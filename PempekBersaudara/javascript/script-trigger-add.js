document.addEventListener("DOMContentLoaded", function () {
    const btnSubmit = document.querySelector('.btn-submit');
    const modal = document.getElementById('confirmModal');
    const btnYakin = document.getElementById('yakin');
    const btnTidak = document.getElementById('tidak');
    const modalText = document.querySelector('.modal-text');

    if (btnSubmit && modal && btnYakin && btnTidak) {
        btnSubmit.addEventListener('click', function (e) {
            e.preventDefault();

            // Ambil semua nilai input
            const nama = document.getElementById('nama').value.trim();
            const harga = document.getElementById('harga').value.trim();
            const qty = document.getElementById('qty').value.trim();
            const gambar = document.getElementById('gambar').files.length;
            const deskripsi = document.getElementById('deskripsi').value.trim();

            // Validasi: semua field wajib diisi
            if (!nama || !harga || !qty || !gambar || !deskripsi) {
                alert("Semua kolom wajib diisi!");
                return;
            }

            // Jika valid, tampilkan modal
            modalText.innerText = `Apakah Anda yakin ingin menambahkan Menu "${nama}"?`;
            modal.style.display = 'flex';    
        });
        
        btnYakin.addEventListener('click', function () {
            document.querySelector('form').submit();
        });

        btnTidak.addEventListener('click', function () {
            modal.style.display = 'none';
        });
    }
});