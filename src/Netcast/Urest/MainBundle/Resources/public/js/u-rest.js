$( function() {



  ///// custom scroll штше применять для блока где нужен кастомный скролл
/*  let $jsCustomScroll = $('.js-custom-scroll');
  if ($jsCustomScroll.length) {
    $jsCustomScroll.mCustomScrollbar({
      mouseWheel: {enable: true},
      // theme: "dark-3",
      scrollEasing: "linear",
      // autoDraggerLength: false
    });
  }*/
///////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////

  ///// for open u-card
    var $fullCard = $('.js-full-card');
    var $fullCardAddBody = $fullCard.find('.js-full-card-add-body');
    var $firstStepFilters = $('.js-u-first-set');
    var $secondStepFilters = $('.js-u-second-set');
    var $document = $(document);

    var cardSmallSlider = null;


// click on more btn in u-full-card
  $document.on('click', '.js-more-info-btn', function () {
    $fullCardAddBody.slideDown(300, function(){
      if(!cardSmallSlider){
        cardSmallSlider = uCardSmallSwiper('js-small-card-slider');
      } else {
        cardSmallSlider.update(true);
      }
    });
  });
  // background backlight for card-option-item on click for tablet and mobile, because they haven't hover event
  $document.on('click', '.js-card-option', function () {
    $(this).addClass('active').siblings().removeClass('active');
    uCardSmallSwiper();
  });


  //u-full-card small slider
  function uCardSmallSwiper (sliderClass){
    return new Swiper ('.'+sliderClass, {
      // Navigation arrows
      nextButton: '.js-smsbn',
      prevButton: '.js-smsbp',

      slidesPerView: 2,
      spaceBetween: 10
    });
  }
  ///////////////////////////////////////////////////////////////////////////////////////////
  ///////////////////////////////////////////////////////////////////////////////////////////




  ///////////////////////////////////////////////////////////////////////////////////////////
  ///////////////////////////////////////////////////////////////////////////////////////////







  // TODO: remove, not for project
  $('.js-show-set-1').click(function () {
    $firstStepFilters.slideDown();
    $secondStepFilters.slideUp();
  });
  $('.js-show-set-2').click(function () {
    $firstStepFilters.slideUp();
    $secondStepFilters.slideDown();  });


} );