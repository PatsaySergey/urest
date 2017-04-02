
/* ---------------------------------------------- /*
 * Google Map
 /* ---------------------------------------------- */
function applyMap()
{
	var box = document.getElementById("map");
	if (!box)
		return;
	var mapLocation = new google.maps.LatLng(46.604167162931844,32.897186279296875);

	var map = new google.maps.Map(box, {
		streetViewControl : false,
		overviewMapControl: false,
		mapTypeControl: false,
		zoomControl : false,
		panControl : false,
		scrollwheel: false,
		center: mapLocation,
		zoom: 10
	});

	var marker = new google.maps.Marker({
		position: mapLocation,
		icon: "../assets/img/map-marker.png",
		map: map
	});
	var infobox = new InfoBox({
		content: document.getElementById("infobox"),
		disableAutoPan: false,
		maxWidth: 150,
		pixelOffset: new google.maps.Size(-140, 0),
		zIndex: null,
		boxStyle: {
			background: "url('../assets/img/icon-arrow-map.png') 92px top  no-repeat",
			width: "325px",
			left: "70px"
		},
		closeBoxMargin: "12px 4px 2px 2px",
		closeBoxURL: "http://www.google.com/intl/en_us/mapfiles/close.gif",
		infoBoxClearance: new google.maps.Size(1, 1)
	});

	google.maps.event.addListener(marker, 'click', function() {
		infobox.open(map, this);
		map.panTo(mapLocation);
	});
	//google.maps.event.addListener(marker, 'click', function() {   infobox.open(map,marker); });



	//var map = new GMaps({
	//	streetViewControl : false,
	//	overviewMapControl: false,
	//	mapTypeControl: false,
	//	zoomControl : false,
	//	panControl : false,
	//	scrollwheel: false,
	//	center: mapLocation,
	//	el: '#map',
	//	zoom: 10
	//});

	var image = new google.maps.MarkerImage('../assets/img/map-marker.png',
		new google.maps.Size(80, 80),
		new google.maps.Point(0, 0),
		new google.maps.Point(40, 40)
	);
}

$(function(){

	applyMap();

	$("#menu-mobile").mmenu({
		"searchfield": {
			"placeholder": "Поиск",
			"add": true,
			"search": true
		}
	});

	$("#main-carousel").owlCarousel({
		autoPlay: 5000,
		stopOnHover: true,
		navigation: false,
		pagination: true,
		singleItem: true,
		addClassActive: true,
		transitionStyle: "fade",
		navigationText: ["", ""]

	});
	$("#tour-carousel").owlCarousel({
		autoPlay: 5000,
		stopOnHover: true,
		navigation: true,
		pagination: false,
		singleItem: true,
		addClassActive: true,
		transitionStyle: "fade",
		navigationText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"]

	});
	$("#quote-carousel").owlCarousel({
		items : 2,
		autoPlay: 5000,
		stopOnHover: true,
		navigation: true,
		pagination: false,
		singleItem: true,
		addClassActive: true,
		transitionStyle: "fade",
		navigationText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"]

	});

	$(".footer-carousel #carousel").owlCarousel({
		items : 5,
		itemsDesktop : [1000, 3],
		itemsDesktopSmall : [1199, 4],
		itemsTablet: [991, 3],
		navigation : true,
		navigationText : ["",""],

		pagination : false
	});


	//$('.carousel').carousel();

	$('input.btn-checkbox,input.btn-radio, select').styler();

	///language and price Select
	$('.select-box .dropdown-menu a').click(function(ev) {
		if ("#" === $(this).attr('href')) {
			ev.preventDefault();
			var parent = $(this).closest('.select-box');

			var contentBlock = $(this).find('.content');
			if (contentBlock.length == 0)
				contentBlock = $(this);

			parent.find('.btn-label').html(contentBlock.html());
		}
	});


	/* Search Box Effect Handler */

	//Click
	$('header .search-group .search-first').click(function(e){
		e.preventDefault();
		$('header .search-first').hide();
		$('header .search-group .searchbox-inputtext').show().focus();
		$("header .search-group .search-second").show();
	});
	$('body').click(function(e){
		var clickOnSearch = $(e.target).closest('header .search-group').length;
		if (!clickOnSearch) {
			$('header .search-group .searchbox-inputtext').hide();
			$("header .search-group .search-second").hide();
			$('header .search-first').show();
		}
	});

	$('.reservationdate').daterangepicker({ timePicker: false, format: 'MM.DD.YYYY' });

	$('.switch-wrapper input:checkbox').change(function(){
		var box = $(this).closest('.switch-wrapper');
		box[this.checked ? 'addClass' : 'removeClass']('checked');
		box.trigger('switch-change', [this.checked, this]);
	}).change();

	$('.switch-wrapper').on('switch-change', function(e, isChecked){
		if (isChecked) {
			$('.switch-label-on').addClass('active').css("color","#fff");
			$('.switch-label-off').removeClass('active').css("color","#EDEDED");
			$('.switch-tab-on').show();
			$('.switch-tab-off').hide();
			//$('.slide .registration').show();
			//$('.slide .authorization').hide();
			//$('.slide .tab-hotel').show();
			//$('.slide .tab-apartment').hide();
		} else {
			$('.switch-label-on').removeClass('active').css("color","#EDEDED");
			$('.switch-label-off').addClass('active').css("color","#fff");
			$('.switch-tab-on').hide();
			$('.switch-tab-off').show();
			//$('.slide .authorization').show();
			//$('.slide .registration').hide();
			//$('.slide .tab-apartment').show();
			//$('.slide .tab-hotel').hide();
		}
	});

	//$(".switch-toggle").switchButton({
	//	on_label: 'yes',
	//	off_label: 'no',
	//	width: 232,
	//	height: 29,
	//	button_width: 110
	//});
	//$(".register.switch-toggle").switchButton({
	//	on_label: 'Авторизация',
	//	off_label: 'Регистрация',
	//	width: 232,
	//	height: 29,
	//	button_width: 110
	//});
	//$(".register .switch-button-background.checked")

	$('#start-trip').datetimepicker();
	$('#end-trip').datetimepicker();
	$("#start-trip").on("dp.change",function (e) {
		$('#end-trip').data("DateTimePicker").minDate(e.date);
	});
	$("#end-trip").on("dp.change",function (e) {
		$('#start-trip').data("DateTimePicker").maxDate(e.date);
	});

	$(".center-block").find(".btn-next, .btn-prev, .btn-go").click(function(e){
		e.preventDefault();
		var isPrevButton = $(this).hasClass("btn-prev");
		var curElm = $(".center-block .slide:visible");
		var curIndex = curElm.data("index");
		var nextIndex = curIndex + (isPrevButton ? -1 : 1);
		var nextElm = $(".center-block .slide[data-index='" + nextIndex + "']");

		// set step
		$(".center-block .steps .active").removeClass('active');
		$(".center-block .steps [data-index='" + nextIndex + "']").closest('li').addClass('active');

		if (nextElm.length > 0) {
			if (nextIndex == 1) {
				$(".center-block .steps").hide();
				$(".center-block .btn-prev").addClass("hidden");
				$(".center-block .btn-next").show();
				$(".center-block .btn-go").addClass("hidden");
			} else if (nextIndex == 5) {
				$(".center-block .steps").show();
				$(".center-block .btn-prev").addClass("hidden");
				$(".center-block .btn-next").hide();
				$(".center-block .btn-go").removeClass("hidden");
			} else {
				$(".center-block .steps").show();
				$(".center-block .btn-prev").removeClass("hidden");
				$(".center-block .btn-next").show();
				$(".center-block .btn-go").addClass("hidden");
			}

			nextElm.show();
			curElm.hide();
		}
	});

	var panels = $('.box-question .question');
	panels.hide();
	$('.box-question .dropdown').click(function(e) {
		e.preventDefault();
		//get data-for attribute
		var dataFor = $(this).attr('data-for');
		var idFor = $(dataFor);

		//current button
		var currentButton = $(this);
		idFor.slideToggle(400, function() {
			//Completed slidetoggle
			if(idFor.is(':visible'))
			{
				currentButton.html('<i class="fa fa-angle-up"></i>');
			}
			else
			{
				currentButton.html('<i class="fa fa-angle-down"></i>');
			}
		})
	});

	$(".pagination").rPage();

	$("#thumb-scroller").thumbScroller({
		responsive:true,
		orientation:'horizontal',
		numDisplay:5,
		slideWidth:170,
		slideHeight:100,
		slideMargin:10,
		slideBorder:0,
		padding:0,
		autoPlay:true,
		delay:4000,
		speed:1000,
		easing:'swing',
		control:'scrollbar',
		navButtons:'none',
		playButton:false,
		captionEffect:'slide',
		captionAlign:'bottom',
		captionPosition:'inside',
		captionButton:false,
		captionHeight:'auto',
		continuous:true,
		shuffle:false,
		mousewheel:true,
		imagePosition:'fill',
		pauseOnHover:false,
		pauseOnInteraction:true,
		title:''
	});


});
