/* key visual */
$(document).ready(function(){
  $('.key-visual').slick({
  dots: true,
  infinite: true,
  speed:1000,
  slidesToShow: 1,
  slidesToScroll: 1,
  autoplay: true,
  autoplaySpeed: 5000,
  fade: true,
  cssEase: 'linear',
  responsive: [
    {
      breakpoint: 599,
      settings: {
        arrows: false,
        centerMode: true,
        centerPadding: '0px'
      }
    },{
      breakpoint: 1150,
      settings: {
        arrows: false,
      }
    }

  ]
  });
});



