document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('form');
    const btnKembali = document.getElementById('btnKembali');
    let formChanged = false;

    // Deteksi perubahan pada semua input di form
    form.querySelectorAll('input').forEach(input => {
        input.addEventListener('input', () => {
            formChanged = true;
        });
    });

    // Saat tombol kembali diklik
    btnKembali.addEventListener('click', function (e) {
        if (formChanged) {
            const konfirmasi = confirm('Data belum disimpan. Apakah Anda yakin ingin kembali?');
            if (!konfirmasi) {
                e.preventDefault(); // Batalkan navigasi
            }
        }
    });
});