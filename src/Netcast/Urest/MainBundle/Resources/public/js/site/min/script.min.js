$(document).ready(function() {
	$(document).foundation();

  setResponsiveImages();
  initHeadCarousel();
});

function setResponsiveImages(){
  $(".img-wrap").imgLiquid({
      fill: true,
      horizontalAlign: "center",
      verticalAlign: "center"
  });
}

function initHeadCarousel(){
  $(".bHeadSlider").owlCarousel({
  	navigation : true,
    slideSpeed : 300,
    paginationSpeed : 400,
    singleItem:true,
    navigation: false,
    addClassActive: true,
    transitionStyle : "fade",
    autoPlay: true
  });
}

function init() {
  window.addEventListener('scroll', function(e){
      var distanceY = window.pageYOffset || document.documentElement.scrollTop,
          shrinkOn = 300,
          header = document.querySelector("header");
      if (distanceY > shrinkOn) {
          classie.add(header,"jSmaller");
      } else {
          if (classie.has(header,"jSmaller")) {
              classie.remove(header,"jSmaller");
          }
      }
  });
}
window.onload = init();