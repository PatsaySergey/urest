addHome = function(){
    this.getRoomsUrl     = '';
    this.getApartmentsUrl = '';
};

addHome.prototype.init = function(options) {
    this.getRoomsUrl     = options.getRoomsUrl;
    this.getApartmentsUrl = options.getApartmentsUrl;
}

addHome.prototype.getRooms = function(id) {
    var result = new Array();
    $.ajax({
        type: 'POST',
        dataType: 'json',
        async: false,
        url: this.getRoomsUrl,
        data: { id: id },
        error: function() {
            console.log('Ошибка при загрузке опций');
        },
        success: function(data) {
            result = data;
        }
    });
    return result;
}



