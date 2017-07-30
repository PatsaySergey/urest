TourBuilder = function(params,items){
    this.params = params;
    this.vBuilder = null;
    this.init(items);
};

TourBuilder.prototype.initEvents = function() {
    var that = this;
    $( "#jsCity" ).autocomplete({
        source: that.params.acPath,
        select: function( event, ui ) {
            event.preventDefault();
            var id = ui.item.value.city;
            var cityT = ui.item.value.ct;
            $('#jsCity').val(cityT);
            that.vBuilder.filter.city = id;
            that.vBuilder.cityAutoComplete = cityT;
        }
    });
    var $priceRangeSliderInput = $(".js-price-range-input");
    var $priceRangeSlider = $(".js-price-range-slider");
    $priceRangeSlider.slider({
        range: true,
        min: 0,
        max: 20000,
        values: [100, 19000],
        slide: function (event, ui) {
            that.vBuilder.filter.priceMin = ui.values[0];
            that.vBuilder.filter.priceMax = ui.values[1];
            $priceRangeSliderInput.val(ui.values[0] + " "+that.params.currencyIcon+" - " + ui.values[1] + " "+that.params.currencyIcon);
        }
    });
    $priceRangeSliderInput.val($priceRangeSlider.slider("values", 0) + " "+that.params.currencyIcon+" - " + $priceRangeSlider.slider("values", 1) + " "+that.params.currencyIcon);
    var select = $('select');
    select.styler();
    select.on('change.styler', function(e){
        if($(this).hasClass('apType')) that.vBuilder.filter.apType = $(this).val();
        if($(this).hasClass('apRooms')) that.vBuilder.filter.apRooms = $(this).val();
    });

    $(".js-datepicker").datepicker({
        dateFormat: "yy-mm-dd",
        onSelect: function(dateText) {
            if($(this).hasClass('from')) that.vBuilder.tour.from = dateText;
            if($(this).hasClass('to')) that.vBuilder.tour.to = dateText;
            if($(this).hasClass('froms')) {
                that.vBuilder.displayService.from = dateText;
                that.vBuilder.calcService();
            }
            if($(this).hasClass('tos')) {
                that.vBuilder.displayService.to = dateText;
                that.vBuilder.calcService();
            }
        }
    });
};

TourBuilder.prototype.init = function (items) {
    var that = this;
    var dateFrom = new Date();
    var dateTo = new Date();
    dateTo.setDate(dateFrom.getDate()+1);
    this.vBuilder = new Vue({
        el: '#builder',
        data: {
            currencyIcon: that.params.currencyIcon,
            tour: {
                accommodation: {},
                services: [],
                comment: null,
                cost: 0,
                from: dateFrom.toISOString().substr(0,10),
                to: dateTo.toISOString().substr(0,10),
            },
            endOrder: false,
            cardSlider: null,
            services: {},
            currItem: {},
            currService: {},
            displayService: {},
            currRoom: {},
            showOrder: false,
            showServiceList: false,
            stepOne: true,
            stepTwo: false,
            cityAutoComplete: null,
            allItems: items,
            items: items,
            types: that.params.types,
            apTypes: that.params.apTypes,
            apRooms: {0: 'Все', 1: '1', 2 : '2', 3 : '3', 4 : '4', 5: '5', 'house' : 'Дом'},
            showStars: true,
            showApFilter: true,
            showFilters: true,
            showTourInfo: false,
            showItems: true,
            filter: {
                city: null,
                stars: null,
                type: '',
                priceMin: null,
                priceMax: null,
                apType: 0,
                apRooms: 0
            }
        },
        watch: {
            'filter.type' : function(newV) {
                this.showStars = newV === 'hotel' || !newV
                this.showApFilter = newV === 'apartment' || !newV
            },
            filter: {
                handler: function () {this.items = this.allItems.filter(this.Filtered)},
                deep: true
            }
        },
        methods: {
            uCardSwiper : function(sliderClass) {
                return new Swiper('.'+sliderClass, {
                    nextButton: '.js-sbn',
                    prevButton: '.js-sbp'
                });
            },
            showCard : function($fullCard,$thisCard) {
                var thatV = this;
                if ($fullCard.hasClass('open')) {
                    this.closeFullCard();

                    setTimeout(function () {
                        thatV.openFullCard($fullCard,$thisCard);
                    }, 300);
                } else {
                    this.openFullCard($fullCard,$thisCard);
                }
            },
            showEnd: function() {
                this.stepOne = false;
                this.stepTwo = false;
                this.endOrder = true;
            },
            closeFullCard: function() {
                var $fullCard = $('.js-full-card');
                var $fullCardAddBody = $fullCard.find('.js-full-card-add-body');
                $fullCard.removeClass('open');
                $fullCardAddBody.slideUp();
            },
            openFullCard: function ($fullCard, $clickedCard) {
                if(!this.cardSlider){
                    this.cardSlider = this.uCardSwiper('js-u-card-swiper');
                } else {
                    this.cardSlider.update(true);
                }
                $fullCard.css('left', 0).css('top', $clickedCard.offset().top).addClass('open');
            },
            selItem: function(item,$event) {
                this.currItem = item;
                var $fullCard = $('#itemCard');
                var $thisCard = $($event.target).closest('.js-u-card');
                this.showCard($fullCard,$thisCard);
            },
            selRoom: function(room) {
                this.currRoom = room;
            },
            changeAccommodation: function() {
                this.stepTwo = false;
                this.showOrder = false;
                this.stepOne = true;
                this.closeFullCard();
            },
            showService : function(service,$event) {
                this.closeFullCard();
                $('.servicesCB').prop( "checked", false );
                $($event.target).prop( "checked", true );
                this.currService = service;
                if(service.type == 'line' || service.type == 'day') {
                    this.currService.items = [];
                    this.currService.items.push(service);
                }
                this.showServiceList = true;
            },
            calcService : function() {
                var from = new Date(this.displayService.from);
                var to = new Date(this.displayService.to);
                var delta = Math.round((to-from) / 1000 / 60 / 60/ 24);
                this.displayService.cost = Math.round(delta*parseFloat(this.displayService.price));
                this.displayService.title = (this.displayService.title.substr(0,-1) == ' ') ? this.displayService.title.substr(0,this.displayService.title.length-1) : this.displayService.title+' ';
            },
            setServiceItem: function(item,$event) {
                this.displayService = item;
                var $fullCard = $('#serviceCard');
                var $thisCard = $($event.target).closest('.js-u-card');
                this.displayService.from = this.tour.from;
                this.displayService.to = this.tour.to;
                this.displayService.cost = item.price;
                if(this.displayService.type == 'day' || this.displayService.type == 'day_option') this.calcService();
                this.showCard($fullCard,$thisCard);
            },
            addService: function() {
                this.tour.services.push(this.displayService);
                this.calculate();
                this.closeFullCard();
            },
            deleteService: function(key) {
                this.tour.services.splice(key,1);
                this.calculate();
            },
            calculate: function() {
                var from = new Date(this.tour.from);
                var to = new Date(this.tour.to);
                var delta = Math.round((to-from) / 1000 / 60 / 60/ 24);
                var aCost = Math.round(delta*parseFloat(this.tour.accommodation.item.price));
                var sCost = 0;
                $.each(this.tour.services,function(k,v){
                    if(v) sCost += parseFloat(v.cost);
                });
                this.tour.cost = sCost+aCost;
            },
            selectHome : function () {
                this.selectAccommodation();
            },
            selectAccommodation: function(room) {
                this.closeFullCard();
                var thatVue = this;
                this.tour.accommodation = {
                    item: this.currItem,
                    room: room
                };
                if(room) this.tour.accommodation.item.price = room.price;
                if(!room) this.tour.accommodation.room = {};
                this.showOrder = true;
                this.stepTwo = true;
                this.stepOne = false;
                $("html, body").animate({ scrollTop: 0 }, "slow");
                this.calculate();
                $.ajax(that.params.servicesPath.replace('__id__',this.currItem.city),{
                    type: 'GET',
                    success: function(result) {
                        thatVue.services = result;
                    },
                    dataType: 'json'
                })
            },
            Filtered: function(value) {
                var result = true;
                var that = this;
                $.each(this.filter, function(i,v) {
                    switch (i) {
                        case 'city':
                            if(v) result = result && value.city === that.filter.city;
                            break;
                        case 'priceMin':
                            var price = (value.type === 'hotel') ? value.minPrice : value.price;
                            if(v) result = (result && price >= v);
                            break;
                        case 'priceMax':
                            var price = (value.type === 'hotel') ? value.maxPrice : value.price;
                            if(v) result = (result && price <= v);
                            break;
                        case 'type':
                            if(v) result = (result && value.type === v);
                            break;
                        case 'stars':
                            if(that.filter.type === '') {
                                if(v) result = (result && ((value.type === 'hotel' && value.stars == v) || value.type !== 'hotel'));
                                break;
                            }
                            if(that.filter.type === 'hotel') {
                                if(v) result = (result && value.type === 'hotel' && value.stars == v);
                                break;
                            }
                            break;
                        case 'apType':
                            if(that.filter.type == '') {
                                if(v > 0) result = (result && ((value.type == 'apartment' && value.apType == v) || value.type != 'apartment'));
                                break;
                            }
                            if(that.filter.type === 'apartment') {
                                if(v > 0) result = (result && value.type == 'apartment' && value.apType == v);
                                break;
                            }
                            break;
                        case 'apRooms':
                            if(that.filter.type === '') {
                                if(v) result = (result && ((value.type === 'apartment' && value.apRooms === v) || value.type !== 'apartment'));
                                break;
                            }
                            if(that.filter.type === 'apartment') {
                                if(v) result = (result && value.type === 'apartment' && value.apRooms === v);
                                break;
                            }
                            break;
                    }
                });
                return result;
            }
        },

        mounted: function () {
            $('#builder').css('visibility','visible');
            $('#builder').css('height','auto');
            that.initEvents();
        }
    });
};