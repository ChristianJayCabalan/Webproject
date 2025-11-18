// header on scroll background
const header = document.querySelector("#header");
const resMenu = document.querySelector(".nav-links");

// JavaScript to toggle navigation menu on mobile
const navToggler = document.querySelector('.nav-toggler');
const navLinks = document.querySelector('.nav-links');
const toggleIcon = navToggler.querySelector('i');

navToggler.addEventListener('click', () => {
  // Toggle the visibility of the navigation menu
  navLinks.classList.toggle('show');

  // Toggle the icon between hamburger and close icon
  toggleIcon.classList.toggle('bx-menu-alt-right');
  toggleIcon.classList.toggle('bx-x');
});


//news ticker

document.addEventListener('DOMContentLoaded', function () {
  var newsItems = document.querySelectorAll('.news-item');
  var currentIndex = 0;

  function showNextNewsItem() {
      var nextIndex = (currentIndex + 1) % newsItems.length;

      newsItems[currentIndex].style.opacity = 0;

      setTimeout(function () {
          newsItems[currentIndex].style.display = 'none';
          newsItems[nextIndex].style.display = 'block';
          newsItems[nextIndex].style.opacity = 1;
          currentIndex = nextIndex;
      }, 500);

      setTimeout(showNextNewsItem, 5000);
  }

  

  showNextNewsItem();
});
