// Toggle to show and hide navbar menu
const navbarMenu = document.getElementById("menu");
const burgerMenu = document.getElementById("burger");
burgerMenu.addEventListener("click", () => {
    navbarMenu.classList.toggle("is-active");
    burgerMenu.classList.toggle("is-active");
});

// Toggle to show and hide dropdown menu
const dropdown = document.querySelectorAll(".dropdown");
dropdown.forEach((item) => {
    const dropdownToggle = item.querySelector(".dropdown-toggle");
    dropdownToggle.addEventListener("click", () => {
        const dropdownShow = document.querySelector(".dropdown-show");
        toggleDropdownItem(item);
        // Remove 'dropdown-show' class from other dropdown
        if (dropdownShow && dropdownShow != item) {
            toggleDropdownItem(dropdownShow);
        }
    });
});
// Function to display the dropdown menu
const toggleDropdownItem = (item) => {
    const dropdownContent = item.querySelector(".dropdown-content");
    // Remove other dropdown that have 'dropdown-show' class
    if (item.classList.contains("dropdown-show")) {
        dropdownContent.removeAttribute("style");
        item.classList.remove("dropdown-show");
    } else {
        // Added max-height on active 'dropdown-show' class
        dropdownContent.style.height = dropdownContent.scrollHeight + "px";
        item.classList.add("dropdown-show");
    }
};

$(window).scroll(function () {
    if ($(window).scrollTop() >= 40) {
        $(".headerCnt").addClass("fixed-header");
    } else {
        $(".headerCnt").removeClass("fixed-header");
    }
});

$(".anoucement-bar").slick({
    infinite: true,
    slidesToShow: 1,
    slidesToScroll: 1,
    dots: false,
    arrows: false,
    speed: 3500,
    autoplay: true,
});

$(".homeSlider").slick({
    dots: true,
    infinite: true,
    speed: 300,
    autoplay: true,
    adaptiveHeight: true,
    slidesToShow: 1,
});

$(".multiple-alsolike").slick({
    infinite: false,
    slidesToShow: 3,
    slidesToScroll: 1,
    dots: false,
    autoplay: false,
    responsive: [
        {
            breakpoint: 700,
            settings: {
                slidesToShow: 1,
            },
        },
    ],
});

const $slider = $("#youMayLikeProducts").find(".collection-productSlid");
const slideCount = $slider.children().length;

$("#youMayLikeProducts")
    .find(".collection-productSlid")
    .slick({
        centerMode: false,
        // infinite: slideCount > 3,
        dots: false,
        arrows: slideCount > 3,
        autoplay: false,
        centerPadding: "0px",
        speed: 500,
        // variableWidth: true,
        slidesToShow:5,
        initialSlide: Math.floor((slideCount - 1) / 2),
        responsive: [
            {
                breakpoint: 1441,
                settings: {
                    slidesToShow: 4,
                },
            },
            {
                breakpoint: 1025,
                settings: {
                    slidesToShow: 3,
                },
            },
            {
                breakpoint: 769,
                settings: {
                    slidesToShow: 2,
                },
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                },
            },
        ],
    });

const $sliderViewed = $("#recentlyViewedProducts").find(
    ".collection-productSlid"
);
const slideCountViewed = $sliderViewed.children().length;

$("#recentlyViewedProducts")
    .find(".collection-productSlid")
    .slick({
        centerMode: true,
        infinite: slideCountViewed > 4,
        dots: false,
        arrows: slideCountViewed > 4,
        autoplay: false,
        centerPadding: "0px",
        speed: 500,
        variableWidth: true,
        initialSlide: Math.floor((slideCountViewed - 1) / 2),
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                },
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                },
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                },
            },
        ],
    });

// $('.collection-productSlid').slick({
//   centerMode:true,
//   infinite:true,
//   dots:false,
//   arrows:true,
//   autoplay:false,
//   centerPadding:'0px',
//   speed:500,
//   variableWidth:true,
// });

// $('.collection-productSlid').on('beforeChange', function(event, slick, currentSlide, nextSlide){
//   console.log('beforeChange', currentSlide, nextSlide);
// });
// $('.collection-productSlid').on('afterChange', function(event, slick, currentSlide){
//   console.log('afterChange', currentSlide);
// });

$(".stayClewslider").slick({
    centerMode: true,
    infinite: true,
    dots: false,
    arrows: true,
    autoplay: false,
    centerPadding: "0px",
    speed: 500,
    variableWidth: true,
});
$(".stayClewslider").on(
    "beforeChange",
    function (event, slick, currentSlide, nextSlide) {
        console.log("beforeChange", currentSlide, nextSlide);
    }
);
$(".stayClewslider").on("afterChange", function (event, slick, currentSlide) {
    console.log("afterChange", currentSlide);
});

$(".blog-press-slid").slick({
    centerMode: true,
    infinite: true,
    dots: false,
    arrows: true,
    autoplay: false,
    centerPadding: "0px",
    speed: 500,
    variableWidth: true,
});
$(".blog-press-slid").on(
    "beforeChange",
    function (event, slick, currentSlide, nextSlide) {
        console.log("beforeChange", currentSlide, nextSlide);
    }
);
$(".blog-press-slid").on("afterChange", function (event, slick, currentSlide) {
    console.log("afterChange", currentSlide);
});
$(document).ready(function () {
    $(".accordion-list h3").click(function () {
        var $clickedHeader = $(this);
        var $clickedAnswer = $clickedHeader.siblings(".answer");

        // If already open, just close it
        if ($clickedAnswer.is(":visible")) {
            $clickedAnswer.slideUp(400);
            $clickedHeader.removeClass("active");
        } else {
            // Close others
            $(".accordion-list .answer").slideUp(400);
            $(".accordion-list h3").removeClass("active");

            // Open clicked one
            $clickedAnswer.slideDown(400);
            $clickedHeader.addClass("active");
        }
    });
});

// $(document).ready(function () {
//     $(".accordion-list .foot1 h3").click(function () {
//         $(".accordion-list .awer1").toggle(400);
//         $(".accordion-list .awer2").hide(400);
//         $(".accordion-list .awer3").hide(400);
//     });
// });

// $(document).ready(function () {
//     $(".accordion-list .foot2 h3").click(function () {
//         $(".accordion-list .awer2").toggle(400);
//         $(".accordion-list .awer1").hide(400);
//         $(".accordion-list .awer3").hide(400);
//     });
// });

// $(document).ready(function () {
//     $(".accordion-list .foot3 h3").click(function () {
//         $(".accordion-list .awer3").toggle(400);
//         $(".accordion-list .awer1").hide(400);
//         $(".accordion-list .awer2").hide(400);
//     });
// });

/**manufacture-video**/
$(document).ready(function () {
    $("#manuVideo").click(function () {
        $("#manufacture-video").show();
    });
    $("#manuVideo-stop").click(function () {
        $("#manufacture-video").hide();
    });
});

/*
$(document).ready(function(){
  $('.accordion-list > li > .answer').hide();
  $('.accordion-list > li').click(function() {
    if ($(this).hasClass("active")) {
      $(this).removeClass("active").find(".answer").slideUp();
    } else {
      $(".accordion-list > li.active .answer").slideUp();
      $(".accordion-list > li.active").removeClass("active");
      $(this).addClass("active").find(".answer").slideDown();
    }
    return false;
  });
});
*/

/*search box*/
$("#search-b-c").click(function () {
    $("#searchBox-r").show();
});
$("#searchboxHide").click(function () {
    $("#searchBox-r").hide();
    $("#searchKey").val("");
    $("#search-results").html("");
});

/***sort filter */
$("#sortFilter").click(function () {
    $(".sortlistshow").show();
});
$("#sortclosecfilter").click(function () {
    $(".sortlistshow").hide();
});

/*** categoriesFilter */
$("#categoriesFilter").click(function () {
    $(".sfdetailC").show();
});
$("#closecfilter").click(function () {
    $(".sfdetailC").hide();
});

/**toggle*/
$(document).ready(function () {
    $(".payac1").click(function () {
        $(".an1").toggle(400);
        $("h3.payac1").toggleClass("active");
        $("h3.payac2").removeClass("active");
        $("h3.payac3").removeClass("active");
        $(".an2").hide(400);
        $(".an3").hide(400);
    });
});

$(document).ready(function () {
    $(".payac2").click(function () {
        $(".an2").toggle(400);
        $("h3.payac1").removeClass("active");
        $("h3.payac2").toggleClass("active");
        $("h3.payac3").removeClass("active");
        $(".an1").hide(400);
        $(".an3").hide(400);
    });
});

$(document).ready(function () {
    $(".payac3").click(function () {
        $(".an3").toggle(400);
        $("h3.payac1").removeClass("active");
        $("h3.payac2").removeClass("active");
        $("h3.payac3").toggleClass("active");
        $(".an1").hide(400);
        $(".an2").hide(400);
    });
});

$(document).ready(function () {
    $(".userbx").click(function (event) {
        event.stopPropagation();
        $(".userop").toggle();
    });
});

$(document).on("click", function () {
    $(".userop").hide();
});

/*
$(document).ready(function(){
 $(".slick-center.slick-active .val-d").click(function(){
     $(".slick-next").toggle();
   });
});


$(document).ready(function(){
  $(".slick-center.slick-active .all-vall").click(function(){
      $(".slick-next").toggle();
    });
 });
*/

/**about us**/
$(".mission-l").click(function () {
    $(".mission-c").show();
    $(".mission-l").hide();
});

$(".vission-l").click(function () {
    $(".vission-c").show();
    $(".vission-l").hide();
});

$(".qa-l").click(function () {
    $(".qa-c").show();
    $(".qa-l").hide();
});

$(".nev-l").click(function () {
    $(".nev-c").show();
    $(".nev-l").hide();
});

$(".man-l").click(function () {
    $(".man-c").show();
    $(".man-l").hide();
});

/*country*/

$(document).ready(function () {
    $(".europe-s").click(function () {
        $(".europeDrop").toggle();
    });
});
