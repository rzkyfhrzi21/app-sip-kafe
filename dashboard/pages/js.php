<!-- =========================
CORE & THEME (TETAP DIPAKAI)
========================= -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="assets/static/js/components/dark.js"></script>
<script src="assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="assets/static/js/pages/horizontal-layout.js"></script>
<script src="assets/compiled/js/app.js"></script>


<!-- =========================
SWEETALERT
========================= -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php require_once '../config/sweetalert.php'; ?>


<!-- =========================
FORM & INPUT
========================= -->
<!-- Choices -->
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
<script src="assets/static/js/pages/form-element-select.js"></script>

<!-- Parsley -->
<script src="https://cdn.jsdelivr.net/npm/parsleyjs@2.9.2/dist/parsley.min.js"></script>
<script src="assets/static/js/pages/parsley.js"></script>

<!-- Flatpickr -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="assets/static/js/pages/date-picker.js"></script>

<!-- =========================
FILE UPLOAD (PROFILE)
========================= -->
<script src="https://unpkg.com/filepond/dist/filepond.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-crop/dist/filepond-plugin-image-crop.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-resize/dist/filepond-plugin-image-resize.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-filter/dist/filepond-plugin-image-filter.js"></script>
<script src="assets/static/js/pages/filepond.js"></script>


<!-- =========================
CHECKBOX DELETE ACCOUNT
========================= -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const checkbox = document.getElementById("iaggree");
        const button = document.getElementById("btn-delete-account");

        if (checkbox && button) {
            checkbox.addEventListener("change", function() {
                button.disabled = !this.checked;
            });
        }
    });
</script>


<!-- =========================
DATATABLES + BUTTONS (CDN)
========================= -->

<!-- Bootstrap 4 JS (wajib kalau pakai theme bootstrap4) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables core -->
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

<!-- DataTables Bootstrap 4 -->
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap4.min.js"></script>

<!-- Responsive -->
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap4.min.js"></script>

<!-- Buttons -->
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap4.min.js"></script>

<!-- Export dependencies -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<!-- HTML5 export + Print + ColVis -->
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>

<script src="https://cdn.datatables.net/select/1.7.0/js/dataTables.select.min.js"></script>
<script src="https://cdn.datatables.net/fixedheader/3.4.0/js/dataTables.fixedHeader.min.js"></script>


<!-- =========================
DATATABLE INIT
========================= -->
<script>
    $(function() {

        const today = new Date().toLocaleDateString('id-ID', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric'
        }).replaceAll('/', '-');

        const namaKafe = document.body.dataset.title || 'Data';
        const titleDoc = `Sistem Informasi Peringkat Kafe Bandar Lampung - ${namaKafe} (${today})`;

        /* =====================================================
           INIT DATATABLE (SATU KALI SAJA)
        ===================================================== */
        const dt = $('#tabel').DataTable({
            paging: true,
            lengthChange: true,
            pageLength: 25,
            lengthMenu: [25, 50, 100, 250],
            searching: true,
            searchDelay: 300,
            ordering: true,
            order: [
                [0, 'desc']
            ],
            info: true,
            autoWidth: false,
            responsive: true,
            stateSave: true,
            fixedHeader: true,

            /* ===== SELECT ===== */
            select: {
                style: 'multi'
            },

            dom: 'Bfltip',
            buttons: [{
                    extend: 'csvHtml5',
                    title: titleDoc,
                    filename: titleDoc,
                    exportOptions: {
                        columns: ':not(.no-export)'
                    }
                },
                {
                    extend: 'excelHtml5',
                    title: titleDoc,
                    filename: titleDoc,
                    exportOptions: {
                        columns: ':not(.no-export)'
                    }
                },
                {
                    extend: 'pdfHtml5',
                    title: titleDoc,
                    filename: titleDoc,
                    pageSize: 'A4',
                    orientation: 'landscape',
                    exportOptions: {
                        columns: ':not(.no-export)'
                    },
                    customize: function(doc) {
                        doc.styles.title = {
                            fontSize: 14,
                            bold: true,
                            alignment: 'center'
                        };
                    }
                },
                {
                    extend: 'print',
                    title: titleDoc,
                    exportOptions: {
                        columns: ':not(.no-export)'
                    }
                },
                {
                    extend: 'colvis',
                    text: 'Kolom'
                }
            ],

            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                infoEmpty: "Tidak ada data",
                zeroRecords: "Data tidak ditemukan",
                paginate: {
                    previous: "Sebelumnya",
                    next: "Berikutnya"
                }
            },

            columnDefs: [{
                    targets: [0],
                    width: "60px"
                },
                {
                    targets: [-1],
                    orderable: false,
                    searchable: false
                }
            ]
        });

        // letakkan tombol export
        dt.buttons().container().appendTo('#tabel_wrapper .col-md-6:eq(0)');

        /* =====================================================
           CANCEL SELECT - CARA 2 (KLIK AREA KOSONG)
        ===================================================== */
        $('#tabel_wrapper').on('click', function(e) {
            // klik di luar table (bukan tr / td)
            if ($(e.target).closest('table').length === 0) {
                dt.rows({
                    selected: true
                }).deselect();
            }
        });

        /* =====================================================
           CANCEL SELECT - CARA 3 (ESC KEY)
        ===================================================== */
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                dt.rows({
                    selected: true
                }).deselect();
            }
        });
    });
</script>