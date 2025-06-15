document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('form');
    const btnKembali = document.getElementById('btnKembali');
    let formChanged = false;

    // Deteksi perubahan input, textarea, dan file
    form.querySelectorAll('input, textarea, select').forEach(input => {
        input.addEventListener('change', () => {
            formChanged = true;
        });
    });

    // Trigger peringatan saat tombol kembali ditekan
    btnKembali.addEventListener('click', function (e) {
        if (formChanged) {
            const konfirmasi = confirm('Perubahan belum disimpan. Yakin ingin kembali?');
            if (!konfirmasi) {
                e.preventDefault();
            }
        }
    });
});