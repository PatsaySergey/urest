TourBuilder = function(params,items){
    this.params = params;
    this.vBuilder = null;
    this.init(items);
};

TourBuilder.prototype.initEvents = function() {
    var that = this;
    $( "#jsCity" ).autocomplete({
        source: that.params.acPath,
        /*create: function () {
            $(this).data('ui-autocomplete')._renderItem = function (ul, item) {
                console.log(item);
                return $('<li>')
                    .append('<a>' + item.label + '<br>' + item.value + '</a>')
                    .appendTo(ul);
            };
        },*/
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
            $priceRangeSliderInput.val(ui.values[0] + " - " + ui.values[1]);
        }
    });
    $priceRangeSliderInput.val($priceRangeSlider.slider("values", 0) + " - " + $priceRangeSlider.slider("values", 1) );
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
            hasUser: false,
            authBlock: false,
            log_error: '',
            reg_error: '',
            currencyIcon: that.params.currencyIcon,
            tour: {
                accommodation: {},
                services: [],
                comment: null,
                cost: 0,
                from: dateFrom.toISOString().substr(0,10),
                to: dateTo.toISOString().substr(0,10),
            },
            user: {
                login: null,
                password: null
            },
            newUser: {
                username: null,
                email: null
            },
            endOrder: false,
            lastEvent: false,
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
            checkEmail: function(emailAddress) {
                var sQtext = '[^\\x0d\\x22\\x5c\\x80-\\xff]';
                var sDtext = '[^\\x0d\\x5b-\\x5d\\x80-\\xff]';
                var sAtom = '[^\\x00-\\x20\\x22\\x28\\x29\\x2c\\x2e\\x3a-\\x3c\\x3e\\x40\\x5b-\\x5d\\x7f-\\xff]+';
                var sQuotedPair = '\\x5c[\\x00-\\x7f]';
                var sDomainLiteral = '\\x5b(' + sDtext + '|' + sQuotedPair + ')*\\x5d';
                var sQuotedString = '\\x22(' + sQtext + '|' + sQuotedPair + ')*\\x22';
                var sDomain_ref = sAtom;
                var sSubDomain = '(' + sDomain_ref + '|' + sDomainLiteral + ')';
                var sWord = '(' + sAtom + '|' + sQuotedString + ')';
                var sDomain = sSubDomain + '(\\x2e' + sSubDomain + ')*';
                var sLocalPart = sWord + '(\\x2e' + sWord + ')*';
                var sAddrSpec = sLocalPart + '\\x40' + sDomain; // complete RFC822 email address spec
                var sValidEmail = '^' + sAddrSpec + '$'; // as whole string

                var reValidEmail = new RegExp(sValidEmail);

                return reValidEmail.test(emailAddress);
            },
            login: function() {
                var that = this;
                that.log_error = '';
                $.ajax({
                    url: '/login_check',
                    method: 'POST',
                    data: {
                        _username: this.user.login,
                        _password: this.user.password
                    },
                    success: function(response) {
                        if(response.success) return that.addTour();
                        that.log_error = 'Не верное имя пользователя или пароль';
                    },
                    dataType: 'json'
                })
            },
            register: function() {
                var thatV = this;
                thatV.reg_error = '';
                if(!this.checkEmail(this.newUser.email)) return thatV.reg_error = 'Неверный формат e-mail';
                $.ajax({
                    method: 'POST',
                    url: that.params.registerUrl,
                    data: {username: this.newUser.username, email: this.newUser.email},
                    success: function(response) {
                        if(response.status == 'fail') return thatV.reg_error = response.data;
                        return thatV.addTour();
                    },
                    dataType: 'json'
                })
            },
            sendTour: function() {
                if(!this.hasUser) {
                    this.authBlock = true;
                    this.showOrder = false;
                    return;
                    console.log('dsas');
                }
                this.addTour();
            },
            addTour: function() {
                var url = that.params.addPath;
                var data = this.buildDataToSend();
                $.ajax({
                    type: "POST",
                    url: url,
                    data: data,
                    success: function(response) {
                        if(response.success) window.location.href = response.link;
                    },
                    dataType: 'JSON'
                });
                console.log(data);
            },
            buildDataToSend: function() {
                var isApartment = this.tour.accommodation.item.type == 'apartment' ? 1 : 0;

                var data = {
                    fromCountry : ' ',
                    comment : this.tour.comment,
                    toCity : this.filter.city,
                    isApartment : isApartment,
                    dateStart : this.tour.from,
                    dateEnd : this.tour.to,
                };
                if(isApartment) {
                    data.apartment = this.tour.accommodation.item.id;
                } else {
                    data.room = this.tour.accommodation.room.id;
                }
                if(this.tour.services.length) {
                    data.services = [];
                    $.each(this.tour.services, function(i,service) {
                        var serviceId = (service.type == "day_option" || service.type == "option") ? service.parentId : service.id;
                        var oneService = {
                            'id': serviceId
                        };
                        if(service.type == "day_option" || service.type == "day") {
                            oneService.reservation = service.from+'/'+service.to;
                        }
                        if(service.type == "day_option" || service.type == "option") {
                            oneService.option = service.id;
                        }
                        data.services.push(oneService);
                    });

                }
                return data;
            },
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
                $('.js-ukit-toggle-btn').click();
                $( 'body' ).scrollTop( 0 );
                this.stepOne = false;
                this.stepTwo = false;
                this.endOrder = true;
            },
            closeFullCard: function() {
                $('.container.second-set').removeClass('opened');
                var $fullCard = $('.js-full-card');
                var $fullCardAddBody = $fullCard.find('.js-full-card-add-body');
                $fullCard.removeClass('open');
                $fullCardAddBody.slideUp();
                $('body').removeClass('no-scroll');
            },
            openFullCard: function ($fullCard, $clickedCard) {
                if(!this.cardSlider){
                    this.cardSlider = this.uCardSwiper('js-u-card-swiper');
                } else {
                    this.cardSlider.update(true);
                }
                if(window.innerWidth >= 768) {
                    $fullCard.css('left', 0).css('top', $clickedCard.offset().top).addClass('open');
                } else {
                    $('body').addClass('no-scroll');
                    $fullCard.addClass('open');
                }
            },
            selItem: function(item,$event) {
                this.lastEvent = $event;
                this.currItem = item;
                var $fullCard = $('#itemCard');
                var $info = $fullCard.find('.u-card__info');
                var $thisCard = $($event.target).closest('.js-u-card');
                this.showCard($fullCard,$thisCard);
            },
            selRoom: function(room) {
                var $wrapper = $('.filter-hotel-result');
                $wrapper.addClass('selRoom');
                this.currRoom = room;
            },
            changeAccommodation: function() {
                alert();
                if(!this.cityAutoComplete) this.filter.city = null;
                this.stepTwo = false;
                this.showOrder = false;
                this.stepOne = true;
                this.closeFullCard();
                var that = this;
            },
            showService : function(service,$event) {
                this.closeFullCard();
                $('.servicesCB').prop( "checked", false );
                $($event.target).prop( "checked", true );
                this.currService = service;
                if(service.type == 'line' || service.type == 'day') {
                    this.currService.items = [];
                    this.currService.items.push(service);
                    setTimeout(function(){
                        $('.js-service-card:first').click();
                    },500);
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
                $('.container.second-set').addClass('opened');
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
                if(this.displayService.type == 'option' || this.displayService.type == 'day_option') this.displayService.parentId = this.currService.id;
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
                this.filter.city = this.currItem.city;
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
                        if(!result.length) thatVue.showEnd();
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
            $('body').on('click','.js-fc-show-more', function () {
                $(this).slideUp().closest('.u-filter').find('.u-filter__body').slideDown();
            });

            $('body').on('click','.js-ukit-toggle-btn', function () {
                $(this).closest('.u-kit').toggleClass('open').find('.js-ukit-toggle-body').slideToggle();
            });
            $('#builder').css('visibility','visible');
            $('#builder').css('height','auto');
            that.initEvents();
        }
    });
};