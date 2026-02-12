# =====================================================
# kmeans.py (FINAL FIX VERSION)
# Mesin Machine Learning SIP Kafe
# Python 3.11.7
#
# Fungsi utama:
# - Membaca dataset kuisioner kafe (CSV)
# - Preprocessing & agregasi
# - K-Means Clustering
# - Output JSON ke PHP
# =====================================================

import sys
import json
import pandas as pd
import numpy as np
from sklearn.cluster import KMeans
from sklearn.preprocessing import MinMaxScaler


# =====================================================
# TAHAP 1: VALIDASI ARGUMENT
# =====================================================

if len(sys.argv) < 2:
    print(json.dumps({
        "error": "Path file CSV tidak ditemukan"
    }))
    sys.exit(1)

csv_path = sys.argv[1]


# =====================================================
# TAHAP 2: LOAD CSV (AUTO DELIMITER + BOM SAFE)
# =====================================================

try:
    df = pd.read_csv(
        csv_path,
        sep=None,           # Auto detect delimiter
        engine='python',    # Wajib untuk sep=None
        encoding='utf-8-sig'  # Hilangkan BOM
    )
except Exception as e:
    print(json.dumps({
        "error": "Gagal membaca file CSV",
        "detail": str(e)
    }))
    sys.exit(1)


# =====================================================
# VALIDASI DATA KOSONG
# =====================================================

if df.empty:
    print(json.dumps({
        "error": "Dataset CSV kosong"
    }))
    sys.exit(1)


# =====================================================
# TAHAP 3: VALIDASI KOLOM WAJIB
# =====================================================

required_columns = [
    'Nama Kafe',
    'Skor_Rasa',
    'Skor_Pelayanan',
    'Skor_Fasilitas',
    'Skor_Suasana',
    'Skor_Harga',
    'Skor_Rating'
]

missing_cols = [c for c in required_columns if c not in df.columns]

if missing_cols:
    print(json.dumps({
        "error": "Kolom wajib tidak lengkap",
        "missing": missing_cols
    }))
    sys.exit(1)


# =====================================================
# TAHAP 4: NORMALISASI NAMA KAFE
# =====================================================

df['Nama Kafe'] = (
    df['Nama Kafe']
    .astype(str)
    .str.strip()
    .str.title()
)


# =====================================================
# TAHAP 5: KONVERSI DATA NUMERIK
# =====================================================

fitur = [
    'Skor_Rasa',
    'Skor_Pelayanan',
    'Skor_Fasilitas',
    'Skor_Suasana',
    'Skor_Harga'
]

for col in fitur + ['Skor_Rating']:
    df[col] = pd.to_numeric(df[col], errors='coerce')


# Hapus baris yang invalid
df = df.dropna(subset=fitur)

if df.empty:
    print(json.dumps({
        "error": "Semua data numerik invalid"
    }))
    sys.exit(1)


# =====================================================
# TAHAP 6: AGREGASI PER KAFE
# =====================================================

df_group = (
    df
    .groupby('Nama Kafe')[fitur]
    .mean()
    .reset_index()
)

if df_group.empty:
    print(json.dumps({
        "error": "Hasil agregasi kosong"
    }))
    sys.exit(1)


# =====================================================
# VALIDASI JUMLAH DATA (MINIMAL K)
# =====================================================

k = 3

if len(df_group) < k:
    print(json.dumps({
        "error": "Jumlah kafe kurang dari jumlah cluster",
        "min_required": k,
        "current": len(df_group)
    }))
    sys.exit(1)


# =====================================================
# TAHAP 7: NORMALISASI (MIN-MAX)
# =====================================================

scaler = MinMaxScaler()
X = scaler.fit_transform(df_group[fitur])


# =====================================================
# TAHAP 8: K-MEANS CLUSTERING
# =====================================================

kmeans = KMeans(
    n_clusters=k,
    random_state=42,
    n_init=10
)

labels = kmeans.fit_predict(X)

df_group['cluster'] = labels + 1


# =====================================================
# TAHAP 9: HITUNG JARAK CENTROID
# =====================================================

centroids = kmeans.cluster_centers_

jarak = []

for i, row in enumerate(X):
    centroid = centroids[labels[i]]
    jarak.append(np.linalg.norm(row - centroid))

df_group['jarak_centroid'] = jarak


# =====================================================
# TAHAP 10: RANKING PER CLUSTER
# =====================================================

df_group['peringkat_cluster'] = (
    df_group
    .groupby('cluster')['jarak_centroid']
    .rank(method='dense', ascending=True)
    .astype(int)
)


# =====================================================
# TAHAP 11: OUTPUT JSON
# =====================================================

output = {
    "k": k,
    "rows": []
}

for _, r in df_group.iterrows():

    output['rows'].append({
        "nama_kafe": r['Nama Kafe'],
        "cluster": int(r['cluster']),
        "jarak_centroid": round(float(r['jarak_centroid']), 6),
        "peringkat_cluster": int(r['peringkat_cluster'])
    })


print(json.dumps(output, ensure_ascii=False))
