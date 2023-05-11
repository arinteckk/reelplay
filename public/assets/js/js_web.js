// home slider
var swiper = new Swiper(".rented-slider", {
  slidesPerView: 1.2,
  centeredSlides: true,
  spaceBetween: 20,
  loop: true,
  autoplay: {
    delay: 3000,
    disableOnInteraction: false,
  },
});

// feather icon
feather.replace()

$(window).scroll(function () {
  var scroll = $(window).scrollTop();
  //>=, not <=
  if (scroll >= 100) {
    //clearHeader, not clearheader - caps H
    $(".header").addClass("darkHeader");
  }
});

// home slider
var swiper = new Swiper(".home-thumb-slider", {
  spaceBetween: 10,
  slidesPerView: 2,
  freeMode: true,
  watchSlidesProgress: true,
  loop: true,
});
var swiper2 = new Swiper(".home-main-slider", {
  spaceBetween: 0,
  autoplay: {
    delay: 2500,
    disableOnInteraction: false,
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  thumbs: {
    swiper: swiper,
  },
});

// categories slider
var swiper = new Swiper(".categories-slider", {
  spaceBetween: 15,
  slidesPerView: 'auto',
  watchSlidesProgress: true,
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  // breakpoints: {
  //   568: {
  //     slidesPerView: 3,
  //     spaceBetween: 15,
  //   },
  //   768: {
  //     slidesPerView: 4,
  //     spaceBetween: 15,
  //   },
  //   992: {
  //     slidesPerView: 5,
  //     spaceBetween: 15,
  //   },
  //   1200: {
  //     slidesPerView: 7,
  //     spaceBetween: 15,
  //   },
  //   1400: {
  //     slidesPerView: 8,
  //     spaceBetween: 15,
  //   },
  // },
});

// fix header
var header = $(".scrollspy");
$(".scrollspy").scroll(function () {
  var scroll = $(this).scrollTop();
  if (scroll >= 10) {
    $(this).addClass("scrollspy-visible");
  } else {
    $(this).removeClass("scrollspy-visible");
  }
});

const toggleForm = () => {
  const container = document.querySelector('.container');
  container.classList.toggle('active');
};

