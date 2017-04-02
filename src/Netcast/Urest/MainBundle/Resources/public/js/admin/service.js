TourServices = function(){
    this.formName         = '';
    this.getOptionUrl     = '';
    this.getOptionInfoUrl = '';
};

TourServices.prototype.init = function(options) {
    this.formName         = options.formName;
    this.getOptionUrl     = options.getOptionUrl;
    this.getOptionInfoUrl = options.getOptionInfoUrl;
    this.addEvents();
}

TourServices.prototype.addEvents = function() {
    var TourServices = this;
    $('select.tourServiceSelect').on('change',function(){
        var id = $(this).val();
        TourServices.getOptions(id,$(this));
    });
    $('select.tourOptionSelect').each(function(){
        var id = $(this).val();
        $(this).empty();
        if(id != '') {
            TourServices.updateOptions(id,$(this));
        }
    });
}

TourServices.prototype.updateOptions = function(id,select) {
    var TourServices = this;
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: TourServices.getOptionInfoUrl,
        data: { id: id },
        error: function() {
            console.log('Ошибка при загрузке опций');
        },
        success: function(data) {
            console.log(data);
            TourServices.renderOptionsSelect(id,data,select);
        }
    });
}

TourServices.prototype.renderOptionsSelect = function(id,data,select) {
    $.each(data,function(index,value){
        var selected = (id == value.id) ? 'selected="selected"' : '';
        select.append('<option '+selected+' value="'+value.id+'">'+value.title+'</option>');
    });
    select.select2('val', id);
}

TourServices.prototype.getOptions = function(id,select) {
    var TourServices = this;
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: TourServices.getOptionUrl,
        data: { id: id },
        error: function() {
            console.log('Ошибка при загрузке опций');
        },
        success: function(data) {
            TourServices.renderOptions(data,select);
        }
    });
}

TourServices.prototype.renderOptions = function(data,select) {
    var optionSelect = select.parent().parent().parent().parent().find('select.tourOptionSelect');
    optionSelect.removeAttr('required');
    optionSelect.empty();
    if(data.type == 'option' && data.type == 'day_option') {
        optionSelect.attr('required','required');
    }

    $.each(data.options,function(index,value){
        optionSelect.append('<option value="'+value.id+'">'+value.title+'</option>');
    });
}

