
TourBuilder = function(){
    this.options = {};
    this.toCity = null;
    this.currService = null;
    this.optionInput = null;
    this.apartments = {};
    this.allServices = new Array();
    this.serviceOption = {};
};

TourBuilder.prototype.init = function(options) {
    this.options = options;
    this.addEvents();
}

TourBuilder.prototype.addEvents = function() {
    var builder = this;
    $('#jsHotelStars .star').click(function(){
        $('#jsHotelStars .star').removeClass('active');
        $(this).addClass('active');
        var stars = $(this).data('stars');
        builder.getHotels(builder.toCity,stars);
    });

    $('#jsToCountrySelect').change(function(){
        var countryId = $(this).val();
        builder.getCity(countryId);
    });

    $('#jsToCitySelector').change(function(){
        var city = $(this).val();
        builder.toCity = city;
        builder.getHotels(city,5);
        builder.getServices(city);
    });

    $(".center-block").find(".btn-next, .btn-prev, .btn-go").unbind( "click" );

    $('#jsApartmentType li').click(function(){
        $('#jsApartmentType li').removeClass('active');
        $(this).addClass('active');
        var id = $(this).attr('id');
        builder.getApartments(id,builder.toCity);
    });


    $('.btn-go').click(function(){
        var form = $('#customTourForm');
        var url = form.attr('action');
        var data = form.serialize();
        $.post(
            url,
            data,
            function(data){
                if(data.success == 1) {
                    window.location.href = data.link;
                }
            }
            ,'json'
        );
    });


    $(".center-block").find(".btn-next, .btn-prev").click(function(e){
        e.preventDefault();
        var isPrevButton = $(this).hasClass("btn-prev");
        var curElm = $(".center-block .slide:visible");
        var curIndex = curElm.data("index");
        var nextIndex = curIndex + (isPrevButton ? -1 : 1);
        if(builder.validateStep(curIndex)) {
            builder.showStep(nextIndex);
        }
    });

    $(".center-block .steps li").click(function(e){
        e.preventDefault();
        var nextIndex = $(this).find('a').data("index");
        var curIndex = $(".center-block .slide:visible").data("index");
        if((nextIndex-curIndex) > 1) {
            nextIndex = curIndex+1;
        }
        if(builder.validateStep(curIndex)) {
            builder.showStep(nextIndex);
        }

    });

    $('#jsRoomType').change(function(){
        var isApartment = $(this).is( ":checked" );
        if(isApartment) {
            $('#jsHotelSelect').removeClass('required');
            $('#jsRoomSelect').removeClass('required');
            $('#roomCount').addClass('required');
            $('#apartment').addClass('required');
        } else {
            $('#jsHotelSelect').addClass('required');
            $('#jsRoomSelect').addClass('required');
            $('#roomCount').removeClass('required');
            $('#apartment').removeClass('required');
        }
    });
}

TourBuilder.prototype.validateStep = function(step) {
    var curElm = $(".center-block .slide:visible");
    if(step == 4) {
        return this.validateServices(curElm);
    }
    if(step > 1) {
        var valid = true;
        curElm.find('.errorBlock').text(" ");
        curElm.find('input.required, select.required').each(function(){
            if($(this).val() == '' || $(this).val() == 'undefined') {
                valid = false;
                $(this).addClass('error');
                $(this).parent().parent().find('.errorBlock').text('Заполните поле');
            }
        });
    } else {
        return true;
    }
    return valid;
}

TourBuilder.prototype.validateServices = function(curElm) {

    var wrapper = curElm.find('#jsServiceListWr');
    var valid = true;
    $('.serviceError').empty();
    $('.serviceOptionError').empty();
    wrapper.find('.table-row').each(function(){
        var service = $(this).find('input.jsServiceId');
        var type = $(this).data('type');
        switch(type) {
            case 'day':
                if(service.is( ":checked" )) {
                    var dateInput = $(this).find('.reservationdate');
                    if(dateInput.val() == '') {
                        $(this).find('.serviceError').text('Укажите даты');
                        valid = false;
                    }
                }
                break;
            case 'option':
                if(service.is( ":checked" )) {
                    var optionInput = $(this).find('input.jsOptionId');
                    if(optionInput != 'undefined') {
                        console.log(optionInput.val());
                        if(optionInput.val() == '') {
                            $(this).find('.serviceError').text('Выберите опцию услуги');
                            valid = false;
                        }
                    } else {
                        $(this).find('.serviceError').text('Выберите опцию услуги');
                        valid = false;
                    }
                }
                break;
            case 'day_option':
                if(service.is( ":checked" )) {
                    if(service.is( ":checked" )) {
                        var dateInput = $(this).find('.reservationdate');
                        if(dateInput.val() == '') {
                            $(this).find('.serviceError').text('Укажите даты');
                            valid = false;
                        }
                    }
                    var optionInput = $(this).find('.jsOptionId');
                    if(optionInput != 'undefined') {
                        if(optionInput.val() == '') {
                            $(this).find('.serviceError').text('Выберите опцию услуги');
                            valid = false;
                        }
                    } else {
                        $(this).find('.serviceError').text('Выберите опцию услуги');
                        valid = false;
                    }
                }
                break;
        }
    });
    return valid;
}

TourBuilder.prototype.showStep = function(nextIndex) {
    var nextElm = $(".center-block .slide[data-index='" + nextIndex + "']");
    var curElm = $(".center-block .slide:visible");
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
            this.showTourInfo();
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
}

TourBuilder.prototype.tourPrice = function() {
    var builder = this;
    builder.allServices = new Array();
    $('#jsServiceListWr').find('.table-row').each(function(){
        var service = $(this).find('input.jsServiceId');
        var type = $(this).data('type');
        var services = {};
        switch(type) {
            case 'line':
                if(service.is( ":checked" )) {
                    services['id'] = service.val();
                    services['type'] = type;
                }
                break;
            case 'day':
                if(service.is( ":checked" )) {
                    services['id'] = service.val();
                    services['type'] = type;
                    var dateInput = $(this).find('.reservationdate');
                    services['date'] = dateInput.val();
                }
                break;
            case 'option':
                if(service.is( ":checked" )) {
                    services['id'] = service.val();
                    services['type'] = type;
                    var optionInput = $(this).find('input.jsOptionId');
                    services['option'] = optionInput.val();
                }
                break;
            case 'day_option':
                if(service.is( ":checked" )) {
                    services['id'] = service.val();
                    services['type'] = type;
                    var dateInput = $(this).find('.reservationdate');
                    services['date'] = dateInput.val();
                    var optionInput = $(this).find('input.jsOptionId');
                    services['option'] = optionInput.val();
                }
                break;
        }
        builder.allServices.push(services);

    });
    var homeType = ($('#jsRoomType').is( ":checked" )) ? 'apartment' : 'hotel';
    var homeId = ($('#jsRoomType').is( ":checked" )) ? $('#apartment').val() : $('#jsRoomSelect').val();
    var tourDateStart = $('#tourDateStart').val();
    var tourDateEnd = $('#tourDateEnd').val();
    var url = this.options.getPriceUrl;
    var price = 0;
    $.post(
        url,
        {services : builder.allServices, homeType : homeType, homeId : homeId, tourDateStart : tourDateStart, tourDateEnd : tourDateEnd},
        function(data){
            price = data.price;
            $('#jsTourTotalPrice').text(' ');
            $('#jsTourTotalPrice').append(price);
        }
        ,'json');
}

TourBuilder.prototype.showTourInfo = function() {
    var builder = this;
    this.tourPrice();
    var toCountry = $('select[name=toCountry] option:selected').text();
    var toCity = $('select[name=toCity] option:selected').text();
    var dateStart = $('input[name=dateStart]').val();
    var dateEnd = $('input[name=dateEnd]').val();
    $('#tourInfoTo').text(toCountry+', '+toCity);
    $('#tourInfoDate').text('с '+dateStart+' по '+dateEnd);
    var isApartment = $('#jsRoomType').is( ":checked" );
    if(isApartment) {
        var roomTitle = 'Апартаменты';
        var apType = $('#jsApartmentType li.active a').text();
        var apName = $('#apartment').data('name');
        var tourRoom = roomTitle+' «'+apType+'», '+apName;

    } else {
        var roomTitle = 'Отель';
        var hotelName = $('#jsHotelSelect option:selected').text();
        var roomName = $('#jsRoomSelect').data('name');
        var tourRoom = roomTitle+' «'+hotelName+'», '+roomName;
    }
    $('#tourInfoRoom').text(tourRoom);
    $('#tourInfoServices').empty();
    $('#servicesWrapper .table-row').each(function(){
        var checkBox = $(this).find('input.btn-checkbox');
        if(checkBox.is( ":checked" )) {
            var serviceTitle = $(this).find('.jsServiceTitle').text();
            var serviceReservation = $(this).find('.reservationdate')
            var serviceReservationDate = '';
            if(serviceReservation.length > 0) {
                serviceReservationDate = ' ('+serviceReservation.val()+')';
            }
            var optionEl = $(this).find('.jsOptionsInput .jsOptionId');
            var optionTitle = '';
            if(optionEl.length > 0) {
                optionTitle = ', '+builder.serviceOption[optionEl.val()];
            }
            $('#tourInfoServices').append('<li><i class="fa fa-tags"></i> '+serviceTitle+optionTitle+serviceReservationDate+'</li>');
        }
    });

}

TourBuilder.prototype.showRoomInfo = function(roomId) {
    var url = this.options.getRoomInfoUrl;
    var src = this.options.loaderImg;
    $('#jsServiceOptionWraper').html('<img src="'+src+'" style="width:100%"> ');
    var builder = this;
    if(roomId <= 0) {
        return false;
    }
    $.post(
        url,
        {id : roomId},
        function(data){
            $('#jsServiceOptionWraper').html(data);
            builder.tScroller();
        }
        ,'html'
    );
}

TourBuilder.prototype.showApartmentInfo = function(id) {
    var url = this.options.getApartmentInfoUrl;
    var src = this.options.loaderImg;
    $('#jsServiceOptionWraper').html('<img src="'+src+'" style="width:100%"> ');
    var builder = this;
    if(id <= 0) {
        return false;
    }
    $.post(
        url,
        {id : id},
        function(data){
            $('#jsServiceOptionWraper').html(data);
            builder.tScroller();
        }
        ,'html'
    );
}

TourBuilder.prototype.getServiceOption = function(element,title) {
    var serviceId = element.attr('id');
    this.currService = serviceId;
    this.optionInput = element.parent().find('.jsOptionsInput');
    this.optionInput.find('.jsOptionId').val('');
    var url = this.options.getServiceOptionsUrl;
    $('#jsServiceTitle').text(title);
    $.post(
        url,
        {id : serviceId},
        function(data){
            $('#jsServiceOptionSelect').html(data);
            $('#serviceInfoBlock').show()
        }
        ,'html');
}


TourBuilder.prototype.selectOption = function(element) {
    var optionId = element.attr('id');
    this.optionInput.find('.jsOptionId').val(optionId);
    var wrapper = this.optionInput.parent().parent().parent().find('.price.pull-right .price');
    wrapper.text(' ');
    wrapper.append(element.data('icon')+' '+element.data('price'));
    var optionName = element.parent().find('.jsOptionName').val();
    this.serviceOption[optionId] = optionName;

    $('#serviceInfoBlock').hide();
}

TourBuilder.prototype.tScroller = function() {
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
}

TourBuilder.prototype.showServiceInfo = function(element) {
    var serviceId = element.attr('id');
    var src = this.options.loaderImg;
    $('#jsServiceOptionWraper').html('<img src="'+src+'" style="width:100%"> ');
    var url = this.options.getServiceUrl;
    var builder = this;
    $.post(
        url,
        {id : serviceId},
        function(data){
            $('#jsServiceOptionWraper').html(data);
            builder.tScroller();
        }
        ,'html');
}

TourBuilder.prototype.showOptionInfo = function(element) {
    var optionId = element.attr('id');
    var src = this.options.loaderImg;
    $('#jsServiceOptionWraper').html('<img src="'+src+'" style="width:100%"> ');
    var builder = this;
    var url = this.options.getOptionUrl;
    $.post(
        url,
        {id : optionId},
        function(data){
            $('#jsServiceOptionWraper').html(data);
            builder.tScroller();
        }
        ,'html');
}

TourBuilder.prototype.getHotels = function(city,stars) {
    var url = this.options.getHotelsUrl;
    $.post(
        url,
        {stars : stars, city : city},
        function(data){
            $('#jsHotelSelect').empty();
            $('#jsHotelSelect').append('<option value="">Выберите отель</option>')
            $.each(data,function(index,value){
                $('#jsHotelSelect').append('<option value="'+value.id+'">'+value.name+'</option>')
            });
            $('#jsHotelSelect').trigger('refresh');
        }
    ,'json');
}

TourBuilder.prototype.getServices = function(city) {
    var url = this.options.getServicesUrl;
    $.post(
        url,
        {city : city},
        function(data){
            $('#servicesWrapper').html(data);
            $('#servicesWrapper input[type=checkbox]').styler();
            $('.reservationdate').daterangepicker({ timePicker: false, format: 'DD.MM.YYYY' });
        }
        ,'html');
}

TourBuilder.prototype.getCity = function(countryId) {
    var url = this.options.getCityUrl;
    var citySelect = $('#jsToCitySelector');
    citySelect.empty();
    if(countryId == '') {
        citySelect.append('<option value="">Сначала выберите страну</option>');
        citySelect.trigger('refresh');
    }
    $.post(
        url,
        {id : countryId},
        function(data){
            citySelect.append('<option value=""></option>')
            $.each(data,function(index,value){
                citySelect.append('<option value="'+index+'">'+value+'</option>')
            });
            citySelect.trigger('refresh');
        }
        ,'json'
    );

}

TourBuilder.prototype.getHotelRooms = function() {
    var url = this.options.getHotelRoomsUrl;
    var id = $('#jsHotelSelect').val();
    $.post(url,{id : id},
        function(data){
            $('#jsInfoBlockSelect').html(data);
            $('#infoBlock').show();
        }
        ,'html');
}

TourBuilder.prototype.selectRoom = function(element) {
    var roomId = element.attr('id');
    var name = element.data('name');
    $('#jsRoomSelect').val(roomId);
    $('#jsRoomSelect').data('name',name);
    $('#infoBlock').hide();
}

TourBuilder.prototype.selectApartment = function(element) {
    var roomId = element.attr('id');
    var name = element.data('name');
    $('#apartment').val(roomId);
    $('#apartment').data('name',name);
    $('#infoBlock').hide();
}

TourBuilder.prototype.getApartmentsList = function() {
    var url = this.options.getApartmentsListUrl;
    var roomCount = $('#roomCount').val();
    var city = this.toCity;
    var type = $('#jsApartmentType li.active').attr('id');;
    $.post(
        url,
        {roomCount : roomCount, city : city, type: type},
        function(data){
            $('#jsInfoBlockSelect').html(data);
            $('#infoBlock').show();
        }
        ,'html');
}

TourBuilder.prototype.getApartments = function(id,city) {
    var url = this.options.getApartmentsUrl;
    $.post(
        url,
        {id : id, city : city},
        function(data){
            $('#roomCount').empty();
            console.log(Object.keys(data).length);
            if(Object.keys(data).length > 0) {
                $('#roomCount').append('<option value="0">Необходимо выбрать</option>');
                $.each(data,function(index,value){
                    $('#roomCount').append('<option value="'+index+'">'+index+'</option>');
                });
                $('#roomCount').trigger('refresh');
            }
        }
        ,'json');
}