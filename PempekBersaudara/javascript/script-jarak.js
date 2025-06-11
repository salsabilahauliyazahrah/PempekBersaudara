document.addEventListener('DOMContentLoaded', function () {
  const minusBtn = document.querySelector('.distance__input .minus');
  const plusBtn = document.querySelector('.distance__input .plus');
  const jarakInput = document.querySelector('input[name="jarak"]');

  const ongkirDisplay = document.querySelector('.summary__item span:nth-child(2)');
  const totalBayarDisplay = document.querySelector('.summary__total span:nth-child(2)');

  // totalHarga sudah didefinisikan di global scope lewat file PHP
  const ongkirPerKm = 5000;

  function updateOngkir() {
    let jarak = parseInt(jarakInput.value);
    if (isNaN(jarak) || jarak < 1) {
      jarak = 1;
      jarakInput.value = jarak;
    }
    const ongkir = jarak * ongkirPerKm;
    ongkirDisplay.textContent = 'Rp' + ongkir.toLocaleString('id-ID');
    totalBayarDisplay.textContent = 'Rp' + (totalHarga + ongkir).toLocaleString('id-ID');
  }

  minusBtn.addEventListener('click', function(e) {
    e.preventDefault();
    let val = parseInt(jarakInput.value);
    if (val > 1) {
      jarakInput.value = val - 1;
      updateOngkir();
    }
  });

  plusBtn.addEventListener('click', function(e) {
    e.preventDefault();
    let val = parseInt(jarakInput.value);
    jarakInput.value = val + 1;
    updateOngkir();
  });

  updateOngkir();
});
