/*=============== SHOW MENU ===============*/
const navMenu = document.getElementById("nav-menu"),
  navToogle = document.getElementById("nav-toggle"),
  navClose = document.getElementById("nav-close");

//   menu show if exists
if (navToogle) {
  navToogle.addEventListener("click", () => {
    navMenu.classList.add("show-menu");
  });
}

// menu hidden if exists
if (navClose) {
  navClose.addEventListener("click", () => {
    navMenu.classList.remove("show-menu");
  });
}
/*=============== REMOVE MENU MOBILE ===============*/
const navLink = document.querySelectorAll(".nav__link");

const linkAction = () => {
  const navMenu = document.getElementById("nav-menu");
  navMenu.classList.remove("show-menu");
};
navLink.forEach((n) => n.addEventListener("click", linkAction));
/*=============== CHANGE BACKGROUND HEADER ===============*/
function scrollHeader() {
  const header = document.getElementById("header");
  //when scroll is greater than 50 vh, add scroll header class to header tag
  if (this.scrollY >= 50) {
    header.classList.add("bg-header");
  } else {
    header.classList.remove("bg-header");
  }
}
/*=============== SHOW SCROLL UP ===============*/
const scrollUp = () => {
  const scrollUp = document.getElementById("scroll-up");

  this.scrollY >= 350 ? scrollUp.classList.add("show-scroll") : scrollUp.classList.remove("show-scroll");
};
window.addEventListener("scroll", scrollUp);
/*=============== SCROLL SECTIONS ACTIVE LINK ===============*/
const sections = document.querySelectorAll("section[id]");

const scrollActive = () => {
  const scrollY = window.scrollY;

  sections.forEach((current) => {
    const sectionHeight = current.offsetHeight,
      sectionTop = current.offsetTop - 58,
      sectionId = current.getAttribute("id"),
      sectionClass = document.querySelector(".nav__menu a[href*=" + sectionId + "]");

    if (scrollY > sectionTop && scrollY <= sectionTop + sectionHeight) {
      sectionClass.classList.add("active-link");
    } else {
      sectionClass.classList.remove("active-link");
    }
  });
};
window.addEventListener("scroll", scrollActive);
/*=============== DARK LIGHT THEME ===============*/
const themeButton = document.getElementById("theme-button");
const darkTheme = "dark-theme";
const iconTheme = "ri-sun-line";

//previously selected theme(if user selected)
const selectedTheme = localStorage.getItem("selected-theme");
const selectedIcon = localStorage.getItem("selected-icon");

//obtain current theme that has interface by validating light theme class in html
const getCurrentTheme = () => (document.body.classList.contains(darkTheme) ? "dark" : "light");
const getCurrentIcon = () => (themeButton.classList.contains(iconTheme) ? "ri-moon-line" : "ri-sun-line");

//validate if user change theme light or dark theme
if (selectedTheme) {
  //if fullfilled, change theme mode
  document.body.classList[selectedTheme === "dark" ? "add" : "remove"](darkTheme);
  themeButton.classList[selectedIcon === "ri-moon-line" ? "add" : "remove"](iconTheme);
}

//activate or deactivate manually with theme button
themeButton.addEventListener("click", () => {
  //add or remove icon theme
  document.body.classList.toggle(darkTheme);
  themeButton.classList.toggle(iconTheme);

  //save theme and current icon that user choose
  localStorage.setItem("selected-theme", getCurrentTheme());
  localStorage.setItem("selected-icon", getCurrentIcon());
});
/*=============== SCROLL REVEAL ANIMATION ===============*/
const sr = ScrollReveal({
  origin: "top",
  distance: "60px",
  duration: 3000,
  delay: 400,
  // reset:true,
});
sr.reveal(`.home__img, .newsletter__container, .footer__logo, .footer__description, .footer__content, .footer__info`);
sr.reveal(`.home__data`, { origin: "bottom" });
sr.reveal(`.about__data, .recently__data`, { origin: "left" });
sr.reveal(`.about__img, .recently__img`, { origin: "right" });
sr.reveal(`.popular__card`, { interval: 100 });
/*=============== USER DROPDOWN ===============*/
const userMenu = document.getElementById('userMenu')
const navUser = userMenu.parentElement

userMenu.addEventListener('click', () => {
  navUser.classList.toggle('show-dropdown')
})

// Close dropdown when clicking outside
document.addEventListener('click', (e) => {
  if (!navUser.contains(e.target)) {
    navUser.classList.remove('show-dropdown')
  }
})

document.addEventListener('DOMContentLoaded', function() {
    const ratingStars = document.querySelectorAll('.rating i');
    let selectedRating = 0;

    function updateStars(rating) {
        ratingStars.forEach((star, index) => {
            if (index < rating) {
                star.classList.remove('ri-star-line');
                star.classList.add('ri-star-fill');
            } else {
                star.classList.remove('ri-star-fill');
                star.classList.add('ri-star-line');
            }
        });
    }

    ratingStars.forEach(star => {
        // Click event
        star.addEventListener('click', function() {
            selectedRating = parseInt(this.dataset.rating);
            updateStars(selectedRating);
        });

        // Hover events
        star.addEventListener('mouseenter', function() {
            const rating = parseInt(this.dataset.rating);
            updateStars(rating);
        });
    });

    // Mouse leave event for the rating container
    document.querySelector('.rating').addEventListener('mouseleave', function() {
        updateStars(selectedRating);
    });

    // Form submission handling
    document.getElementById('submitTestimoni').addEventListener('click', function() {
        const nama = document.getElementById('nama').value;
        const email = document.getElementById('email').value;
        const masukan = document.getElementById('masukan').value;

        if (nama && email && masukan && selectedRating > 0) {
            // Here you would typically send this data to your server
            alert('Terima kasih atas masukan Anda!');
            const modal = bootstrap.Modal.getInstance(document.getElementById('testimoniModal'));
            modal.hide();

            // Reset form
            document.getElementById('testimoniForm').reset();
            selectedRating = 0;
            updateStars(0);
        } else {
            alert('Mohon lengkapi semua field dan berikan rating.');
        }
    });
});