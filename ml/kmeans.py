# =====================================================
# kmeans.py
# Mesin Machine Learning SIP Kafe
# Python 3.11.7
#
# Fungsi utama:
# - Membaca dataset kuisioner kafe (CSV)
# - Melakukan preprocessing & agregasi data
# - Menerapkan algoritma K-Means Clustering
# - Menghasilkan output JSON untuk diproses PHP
# =====================================================

import sys
import json
import pandas as pd
import numpy as np
from sklearn.cluster import KMeans
from sklearn.preprocessing import MinMaxScaler

# =====================================================
# TAHAP 1: LOAD DATASET CSV
# =====================================================
# File CSV dikirim dari PHP sebagai argument pertama
# Contoh pemanggilan:
# python kmeans.py path/to/file.csv
# =====================================================
csv_path = sys.argv[1]

# =====================================================
# PENTING:
# Dataset CSV menggunakan delimiter titik koma (;)
# Oleh karena itu WAJIB mendefinisikan sep=';'
# Jika tidak, pandas akan gagal memisahkan kolom
# =====================================================
df = pd.read_csv(csv_path, sep=';')

# =====================================================
# Validasi awal: jika dataset kosong, hentikan proses
# =====================================================
if df.empty:
    print(json.dumps({
        "error": "Dataset CSV kosong atau gagal dibaca"
    }))
    sys.exit(1)

# =====================================================
# Normalisasi nama kafe
# - Menghilangkan spasi berlebih
# - Menyeragamkan format huruf (Title Case)
# Tujuan: mencegah duplikasi nama kafe
# =====================================================
df['Nama Kafe'] = df['Nama Kafe'].str.strip().str.title()

# =====================================================
# TAHAP 2: SELEKSI FITUR (VARIABEL CLUSTERING)
# =====================================================
# Skor_Rating TIDAK digunakan sebagai fitur clustering
# sesuai desain penelitian (rating hanya untuk evaluasi)
# =====================================================
fitur = [
    'Skor_Rasa',
    'Skor_Pelayanan',
    'Skor_Fasilitas',
    'Skor_Suasana',
    'Skor_Harga'
]

# =====================================================
# Agregasi data:
# - Satu kafe bisa memiliki banyak responden
# - Data digabung dengan rata-rata per kafe
#
# Hasil:
# 1 baris = 1 kafe
# =====================================================
df_group = df.groupby('Nama Kafe')[fitur].mean().reset_index()

# =====================================================
# Validasi hasil agregasi
# =====================================================
if df_group.empty:
    print(json.dumps({
        "error": "Hasil agregasi data kosong, cek isi CSV"
    }))
    sys.exit(1)

# =====================================================
# TAHAP 3: NORMALISASI DATA (MIN-MAX SCALING)
# =====================================================
# Tujuan:
# - Menyamakan skala semua fitur ke rentang 0–1
# - Menghindari fitur tertentu mendominasi jarak
# =====================================================
scaler = MinMaxScaler()
X = scaler.fit_transform(df_group[fitur])

# =====================================================
# TAHAP 4: PROSES K-MEANS CLUSTERING
# =====================================================
# Parameter:
# - n_clusters = 3 (sesuai desain penelitian)
# - random_state = 42 (agar hasil konsisten)
# - n_init = 10 (standar best practice)
# =====================================================
k = 3
kmeans = KMeans(
    n_clusters=k,
    random_state=42,
    n_init=10
)

# Proses clustering
labels = kmeans.fit_predict(X)

# Cluster dimulai dari 1 (bukan 0) agar mudah dibaca
df_group['cluster'] = labels + 1

# =====================================================
# TAHAP 5: HITUNG JARAK KE CENTROID
# =====================================================
# Jarak Euclidean digunakan untuk:
# - Mengukur kedekatan kafe dengan pusat cluster
# - Dasar penentuan peringkat dalam cluster
# =====================================================
centroids = kmeans.cluster_centers_
jarak = []

for i, row in enumerate(X):
    centroid = centroids[labels[i]]
    # Euclidean Distance
    jarak.append(np.linalg.norm(row - centroid))

df_group['jarak_centroid'] = jarak

# =====================================================
# TAHAP 6: PERINGKAT KAFE DALAM SETIAP CLUSTER
# =====================================================
# Logika:
# - Semakin kecil jarak ke centroid → semakin baik
# - Ranking dilakukan PER CLUSTER (bukan global)
#
# method='dense':
# - Tidak ada loncatan ranking (1,2,3...)
# =====================================================
df_group['peringkat_cluster'] = (
    df_group
    .groupby('cluster')['jarak_centroid']
    .rank(method='dense', ascending=True)
    .astype(int)
)

# =====================================================
# TAHAP 7: OUTPUT JSON UNTUK PHP
# =====================================================
# Format output disesuaikan agar mudah diproses
# oleh function_clustering.php
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

# =====================================================
# Cetak JSON ke STDOUT
# PHP akan menangkap output ini via exec()
# =====================================================
print(json.dumps(output))
