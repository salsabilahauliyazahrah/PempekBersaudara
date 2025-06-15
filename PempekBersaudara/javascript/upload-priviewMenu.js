document.addEventListener('DOMContentLoaded', function () {
    const uploadBox = document.querySelector('.upload-box');
    const fileInput = document.getElementById('gambar');
    const preview = document.getElementById('previewImage');
    const previewContainer = document.getElementById('previewContainer');
    const defaultText = document.querySelector('.defaultText');
    const gantiGambar = document.getElementById('gantiGambar');

    uploadBox.addEventListener('click', () => {
        fileInput.click();
    });

    fileInput.addEventListener('change', function (event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                previewContainer.style.display = 'block';
                defaultText.style.display = 'none';
            }
            reader.readAsDataURL(file);
        }
    });

    // Reset tombol
    const resetButton = document.querySelector('.btn-reset');
    resetButton.addEventListener('click', function () {
        fileInput.value = ''; 
        preview.src = ''; 
        previewContainer.style.display = 'none'; 
        defaultText.style.display = 'block'; 
    });    

    gantiGambar.addEventListener('click', (e) => {
        e.stopPropagation(); // supaya tidak trigger uploadBox lagi
        fileInput.click();
    });
});
