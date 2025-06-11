document.querySelectorAll('.rating i').forEach(star => {
  star.addEventListener('click', function() {
    const rating = this.getAttribute('data-rating');
    document.getElementById('ratingInput').value = rating;

    // Tambahkan efek bintang aktif
    document.querySelectorAll('.rating i').forEach(s => {
      s.classList.remove('ri-star-fill');
      s.classList.add('ri-star-line');
    });
    for (let i = 0; i < rating; i++) {
      document.querySelectorAll('.rating i')[i].classList.remove('ri-star-line');
      document.querySelectorAll('.rating i')[i].classList.add('ri-star-fill');
    }
  });
});

document.getElementById("submitTestimoni").addEventListener("click", function() {
  document.getElementById("testimoniForm").submit();
});