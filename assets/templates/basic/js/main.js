(function ($) {
  "user strict";

  $(document).ready(function() {
    // preloader
    $(".preloader").delay(1000).animate({
      "opacity" : "0"
      }, 1000, function() {
      $(".preloader").css("display","none");
  });
  // nice-select
  $('select').niceSelect();
  background();
});

/*---------------====================
     11.WOW Active
  ================-------------------*/

  if ($('.wow').length) {
    var wow = new WOW({
      boxClass: 'wow',
      // animated element css class (default is wow)
      animateClass: 'animated',
      // animation css class (default is animated)
      offset: 0,
      // distance to the element when triggering the animation (default is 0)
      mobile: false,
      // trigger animations on mobile devices (default is true)
      live: true // act on asynchronously loaded content (default is true)

    });
    wow.init();
  }

//Create Background Image
function background() {
  var img = $('.bg_img');
  img.css('background-image', function () {
    var bg = ('url(' + $(this).data('background') + ')');
    return bg;
  });
}

setInterval(function(){ 
  $(".banner-group-shape").addClass("active")
}, 1000);

  var fixed_top = $(".header-top-section");
  $(window).on("scroll", function(){
      if( $(window).scrollTop() > 100){  
          fixed_top.addClass("animated fadeInDown header-fixed");
      }
      else{
          fixed_top.removeClass("animated fadeInDown header-fixed");
      }
  });

  // navbar-click
  $(".nav-toggle li a").on("click", function () {
    var element = $(this).parent("li");
    if (element.hasClass("show")) {
      element.removeClass("show");
      element.find("li").removeClass("show");
    }
    else {
      element.addClass("show");
      element.siblings("li").removeClass("show");
      element.siblings("li").find("li").removeClass("show");
    }
  });

  //Mobile Menu
  $(".mobile-nav-toggle").on('click', function () {
    $(this).toggleClass('active');
    $(".fixed-area").toggleClass('mobile-menu-active');
  });

  //Mobile Menu
  $(".sidebar-toggle").on('click', function () {
    $(this).toggleClass('active');
    $(".fixed-area").toggleClass('sidebar-active');
  });

//Mobile Menu
$(document).on('click', '.mobile-nav-toggle, .close', function() {
  $('.main-body').toggleClass('active');
});

//Mobile Menu
$(document).on('click', '.mobile-nav-toggle, .close', function() {
  $('.sidebar-inner').toggleClass('active');
});

//Skip
  $(document).on('click', '.modal-content, .skip', function() {
    $('.modal').toggleClass('hide');
});

//Mobile Menu
$(document).on('click', '.mobile-nav-toggle, .close', function() {
  $('.header-right-sidebar').toggleClass('stop');
});

//Mobile Menu
$(document).on('click', '.header-right-sidebar, .close', function() {
  $('.sidebar-inner').toggleClass('stop');
});

//Mobile Menu
$(document).on('click', '.sidebar-toggle, .close', function() {
  $('.main-body').toggleClass('stop');
});

//Mobile Menu
$(document).on('click', '.mobile-header-right-icon, .close', function() {
  $('.mobile-header-right-social').toggleClass('active');
});

  $('.popup-youtube').magnificPopup({
    type: 'video'
  });
  $('.image-popup').magnificPopup({
    type: 'image'
  });

    /*==================== custom dropdown select js ====================*/
    $('.custom--dropdown > .custom--dropdown__selected').on('click', function () {
      $(this).parent().toggleClass('open');
    });
    $('.custom--dropdown > .dropdown-list > .dropdown-list__item').on('click', function () {
      $('.custom--dropdown > .dropdown-list > .dropdown-list__item').removeClass('selected');
      $(this).addClass('selected').parent().parent().removeClass('open').children('.custom--dropdown__selected').html($(this).html());
    });
    $(document).on('keyup', function (evt) {
      if ((evt.keyCode || evt.which) === 27) {
        $('.custom--dropdown').removeClass('open');
      }
    });
    $(document).on('click', function (evt) {
      if ($(evt.target).closest(".custom--dropdown > .custom--dropdown__selected").length === 0) {
        $('.custom--dropdown').removeClass('open');
      }
    });
  
    /*=============== custom dropdown select js end =================*/



  // scroll-to-top
  var ScrollTop = $(".scrollToTop");
  $(window).on('scroll', function () {
    if ($(this).scrollTop() < 500) {
        ScrollTop.removeClass("active");
    } else {
        ScrollTop.addClass("active");
    }
  });

  //Search
  $(document).on('click', '.search-bar, .skip', function() {
    $('.header-form').toggleClass('active');
  });
  $(document).on('click', '.ellipsis-bar', function() {
    $('.header-top-area').toggleClass('active');
    $('.overlay').addClass('active');
  })

  //Register
  $(document).on('click', '.custom-btn, .close', function() {
    $('.header-register-form').toggleClass('active');
  });
  $(document).on('click', '.ellipsis-bar', function() {
    $('.header-top-area').toggleClass('active');
    $('.overlay').addClass('active');
  })

  //Login
  $(document).on('click', '.custom-btn--style, .stop', function() {
    $('.header-login-form').toggleClass('active');
  });
  $(document).on('click', '.ellipsis-bar', function() {
    $('.header-top-area').toggleClass('active');
    $('.overlay').addClass('active');
  })

  //menu bar
  $('.header-bar').on('click', function () {
    $(this).toggleClass('active');
  $('.header-right').toggleClass('active wow');
})

  //Overlay On Click Functions
  $(document).on('click', '.overlay', function () {
    $(this).removeClass('active');
    $('.header-bar').removeClass('active');
    $('.menu').removeClass('active');
    $('.header-top-area').removeClass('active');
  })

  $('.faq-wrapper .faq-title').on('click', function (e) {
    var element = $(this).parent('.faq-item');
    if (element.hasClass('open')) {
      element.removeClass('open');
      element.find('.faq-content').removeClass('open');
      element.find('.faq-content').slideUp(300, "swing");
    } else {
      element.addClass('open');
      element.children('.faq-content').slideDown(300, "swing");
      element.siblings('.faq-item').children('.faq-content').slideUp(300, "swing");
      element.siblings('.faq-item').removeClass('open');
      element.siblings('.faq-item').find('.faq-title').removeClass('open');
      element.siblings('.taq-item').find('.faq-content').slideUp(300, "swing");
    }
  });

  $('.faq-wrapper--style .faq-title').on('click', function (e) {
    var element = $(this).parent('.faq-item--style');
    if (element.hasClass('open')) {
      element.removeClass('open');
      element.find('.faq-content--style').removeClass('open');
      element.find('.faq-content--style').slideUp(300, "swing");
    } else {
      element.addClass('open');
      element.children('.faq-content--style').slideDown(300, "swing");
      element.siblings('.faq-item--style').children('.faq-content--style').slideUp(300, "swing");
      element.siblings('.faq-item--style').removeClass('open');
      element.siblings('.faq-item--style').find('.faq-title').removeClass('open');
      element.siblings('.taq-item--style').find('.faq-content--style').slideUp(300, "swing");
    }
  });

//Banner Slider
var swiper = new Swiper('.banner-slider', {
  slidesPerView: 1,
  spaceBetween: 0,
  loop: true,
  autoplay: {
    speeds: 1000,
    delay: 3000,
  },
  speed: 1500,
  breakpoints: {
    991: {
      slidesPerView: 1,
    },
    767: {
      slidesPerView: 1,
    },
    575: {
      slidesPerView: 1,
    },
  }
});

// slider
var swiper = new Swiper('.client-slider', {
  slidesPerView: 1,
  spaceBetween: 30,
  loop: true,
  autoplay: {
    speeds: 1000,
    delay: 4000,
  },
  breakpoints: {
    991: {
      slidesPerView: 1,
    },
    767: {
      slidesPerView: 1,
    },
    575: {
      slidesPerView: 1,
    },
  }
});

var swiper = new Swiper('.feature-slider', {
  slidesPerView: 6,
  spaceBetween: 20,
  loop: true,
  autoplay: {
    speeds: 1000,
    delay: 2000,
  },
  speed: 1000,
  breakpoints: {
    1199: {
      slidesPerView: 3,
    },
    991: {
      slidesPerView: 2,
    },
    767: {
      slidesPerView: 2,
    },
    575: {
      slidesPerView: 1,
    },
  }
});

var swiper = new Swiper('.deal-slider', {
  slidesPerView: 5,
  spaceBetween: 0,
  loop: true,
  autoplay: {
    speeds: 1000,
    delay: 2000,
  },
  navigation: {
    nextEl: '.ruddra-next',
    prevEl: '.ruddra-prev',
  },
  breakpoints: {
    1199: {
      slidesPerView: 3,
    },
    991: {
      slidesPerView: 2,
    },
    767: {
      slidesPerView: 2,
    },
    575: {
      slidesPerView: 1,
    },
  }
});

var swiper = new Swiper('.product-details-slider', {
  slidesPerView: 5,
  spaceBetween: 0,
  loop: true,
  autoplay: {
    speeds: 1000,
    delay: 2000,
  },
  navigation: {
    nextEl: '.ruddra-next',
    prevEl: '.ruddra-prev',
  },
  breakpoints: {
    1199: {
      slidesPerView: 5,
    },
    991: {
      slidesPerView: 5,
    },
    767: {
      slidesPerView: 4,
    },
    575: {
      slidesPerView: 3,
    },
  }
});
  
// init Isotope
var $grid = $('.grid').isotope({
  // options
  itemSelector: '.grid-item',
  // percentPosition: true,
    masonry: {
      columnWidth: '.grid-item'
    }
});
var $gallery = $(".grid").isotope({
      
});
// filter items on button click
$('.filter-btn-group').on( 'click', 'button', function() {
  var filterValue = $(this).attr('data-filter');
  $grid.isotope({ filter: filterValue });
});
$('.filter-btn-group').on( 'click', 'button', function() {
$(this).addClass('active').siblings().removeClass('active');
});

//category left side menu
$('.category-sidebar li a').on('click', function (e) {
  var element = $(this).parent('li');
  if (element.hasClass('open')) {
    element.removeClass('open');
    element.find('li').removeClass('open');
    element.find('ul').slideUp(300, "swing");
  } else {
    element.addClass('open');
    element.children('ul').slideDown(300, "swing");
    element.siblings('li').children('ul').slideUp(300, "swing");
    element.siblings('li').removeClass('open');
    element.siblings('li').find('li').removeClass('open');
    element.siblings('li').find('ul').slideUp(300, "swing");
  }
})

//The Password Show
$('#show-pass-one').on('click', function() {
  var x = document.getElementById("myInput");
  if (x.type === "password") {
      x.type = "text";
  } else {
      x.type = "password";
  }
});

$('#show-pass-two').on('click', function() {
  var x = document.getElementById("myInputTwo");
  if (x.type === "password") {
      x.type = "text";
  } else {
      x.type = "password";
  }
});

$('#show-pass-three').on('click', function() {
  var x = document.getElementById("myInputThree");
  if (x.type === "password") {
      x.type = "text";
  } else {
      x.type = "password";
  }
});

//Form Slider
$('.account-control-button').on('click', function() {
  $('.account-area').toggleClass('change-form');
})

// progress bar
$(".progressbar").each(function(){
  $(this).find(".bar").animate({
    "width": $(this).attr("data-perc")
  },8000);
  $(this).find(".label").animate({
    "left": $(this).attr("data-perc")
  },8000);
});

// shop cart + - start here
$(function () {
  var CartPlusMinus = $('.cart-plus-minus');
  CartPlusMinus.prepend('<div class="dec qtybutton">-</div>');
  CartPlusMinus.append('<div class="inc qtybutton">+</div>');
  $(".qtybutton").on("click", function () {
    var $button = $(this);
    var oldValue = $button.parent().find("input").val();
    if ($button.text() === "+") {
      var newVal = parseFloat(oldValue) + 1;
    } else {
      // Don't allow decrementing below zero
      if (oldValue > 0) {
        var newVal = parseFloat(oldValue) - 1;
      } else {
        newVal = 1;
      }
    }
    $button.parent().find("input").val(newVal);
  });
});

/* ---------------------------------------------
		    ## Sidebar Script
		--------------------------------------------- */
    var w = $(window).width();
    var MarginTop = (w > 1199) ? 80 : 0;
    if ($('.cart-sidebar').length) {
        $('.cart-sidebar').theiaStickySidebar({
            'containerSelector': '.cart-section',
            'additionalMarginTop': MarginTop,
            'minWidth': 992,
        });
    }

    var w = $(window).width();
    var MarginTop = (w > 1199) ? 80 : 0;
    if ($('.shop-sidebar').length) {
        $('.shop-sidebar').theiaStickySidebar({
            'containerSelector': '.product-details-section',
            'additionalMarginTop': MarginTop,
            'minWidth': 992,
        });
    }

//Odometer
if($(".counter-item").length) {
  $(".counter-item").each(function () {
    $(this).isInViewport(function (status) {
      if (status === "entered") {
        for (var i = 0; i < document.querySelectorAll(".odometer").length; i++) {
          var el = document.querySelectorAll('.odometer')[i];
          el.innerHTML = el.getAttribute("data-odometer-final");
        }
      }
    });
  });
}

/*=====================
     06 navbar mobile nav
     ==========================*/
     $('.sm-nav-btn').on('click', function () {
      $('.nav-slide').css("left","0px");
    });
  $(".nav-sm-back").on('click', function (){
      $('.nav-slide').css("left","-410px");
  });
  $('.sm-toggle-btn').on('click', function () {
    $('.nav-toggle').css("right","0px");
  });
  $(".nav-toggle-back").on('click', function (){
    $('.nav-toggle').css("right","-410px");
});

$('.v-open-btn').on('click', function(){
  $('.version-change-area').toggleClass('active');
});

$(".search-bar a").on('click', function(){
  $('.header-top-search-area').toggleClass('active');
});

$('#wishlist-button').on('click', function (e) {
  e.preventDefault();
  $('.wishlist-sidebar-area').addClass('active');
  $('.body-overlay').addClass('active');
});
$('#body-overlay').on('click', function (e) {
  e.preventDefault();
  $('.wishlist-sidebar-area').removeClass('active');
  $('.body-overlay').removeClass('active');
});
$('.side-sidebar-close-btn').on('click', function (e) {
e.preventDefault();
$('.wishlist-sidebar-area').removeClass('active');
$('.body-overlay').removeClass('active');
});

$('#cart-button').on('click', function (e) {
  e.preventDefault();
  $('.cart-sidebar-area').addClass('active');
  $('.body-overlay-two').addClass('active');
});
$('#body-overlay-two').on('click', function (e) {
  e.preventDefault();
  $('.cart-sidebar-area').removeClass('active');
  $('.body-overlay-two').removeClass('active');
});
$('.side-sidebar-close-btn').on('click', function (e) {
e.preventDefault();
$('.cart-sidebar-area').removeClass('active');
$('.body-overlay-two').removeClass('active');
});

$('#user-button').on('click', function (e) {
  e.preventDefault();
  $('.user-sidebar-area').addClass('active');
  $('.body-overlay-three').addClass('active');
});
$('#body-overlay-three').on('click', function (e) {
  e.preventDefault();
  $('.user-sidebar-area').removeClass('active');
  $('.body-overlay-three').removeClass('active');
});
$('.side-sidebar-close-btn').on('click', function (e) {
e.preventDefault();
$('.user-sidebar-area').removeClass('active');
$('.body-overlay-three').removeClass('active');
});

/* ---------------------------------------------
            ## Count Down
        --------------------------------------------- */
          if ($('.countdown').length) {
              $('.countdown').syotimer({
                  year: 2020,
                  month: 3,
                  day: 9,
                  hour: 20,
                  minute: 30
              }); 
          }
$(window).on('load', function() {
  galleryMasonaryTwo();
})

function galleryMasonaryTwo(){
  // filter functions
  var $grid = $(".grid");
  var filterFns = {};
  $grid.isotope({
      itemSelector: '.grid-item',
      masonry: {
        columnWidth: 0,
      }
  });
  // bind filter button click
  $('ul.filter').on('click', 'li', function () {
    var filterValue = $(this).attr('data-filter');
    // use filterFn if matches value
    filterValue = filterFns[filterValue] || filterValue;
    $grid.isotope({
      filter: filterValue
    });
  });
  // change is-checked class on buttons
  $('ul.filter').each(function (i, buttonGroup) {
    var $buttonGroup = $(buttonGroup);
    $buttonGroup.on('click', 'li', function () {
      $buttonGroup.find('.active').removeClass('active');
      $(this).addClass('active');
    });
  });
  }


  $('.list-group-item > a').on('click', function () {
    if ($(this).parent().find('.sub-menu').length) {
      if ($(this).parent().find('.sub-menu').first().is(':visible')) {
        $(this).find('.side-menu__sub-icon').removeClass('transform rotate-180');
        $(this).removeClass('side-menu--open');
        $(this).parent().find('.sub-menu').first().slideUp({
          done: function done() {
            $(this).removeClass('sidebar-submenu__open');
          }
        });
      } else {
        $(this).find('.side-menu__sub-icon').addClass('transform rotate-180');
        $(this).addClass('side-menu--open');
        $(this).parent().find('.sub-menu').first().slideDown({
          done: function done() {
            $(this).addClass('sidebar-submenu__open');
          }
        });
      }
    }
  });

  // Mobile Menu
  $('.account-bar a').on('click', function () {
    $('.account-btn').slideToggle();
  });

  // Mobile Menu
  $('.header-search a').on('click', function () {
    $('.header-search-form').slideToggle();
  });

})(jQuery);        