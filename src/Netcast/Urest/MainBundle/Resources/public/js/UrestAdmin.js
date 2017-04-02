$(document).ready(function(){
    $('.urest-collection-add').on('click',function(){
        var container = jQuery(this).closest('[data-prototype]');
        var proto = container.attr('data-prototype');
        var protoName = container.attr('data-prototype-name') || '__name__';
        // Set field id
        var idRegexp = new RegExp(container.attr('id')+'_'+protoName,'g');
        proto = proto.replace(idRegexp, container.attr('id')+'_'+(container.children().length - 1));

        // Set field name
        var parts = container.attr('id').split('_');
        var nameRegexp = new RegExp(parts[parts.length-1]+'\\]\\['+protoName,'g');
        proto = proto.replace(nameRegexp, parts[parts.length-1]+']['+(container.children().length - 1));
        jQuery(proto)
            .insertAfter(jQuery(this).parent())
            .trigger('sonata-admin-append-form-element')
        ;
        jQuery(this).trigger('sonata-collection-item-added');

        $('.urest_fileinput').each(function(){
            $(this).find('.btn-file').unbind('click');
            $(this).find('.btn-file').on('click',function(){
                $(this).parent().find('input[type=file]').click();
            })
        });
        $('select.tourServiceSelect').unbind('change');
        $('select.tourServiceSelect').on('change',function(){
            var id = $(this).val();
            TourServices.getOptions(id,$(this));
        });

        $('select.jsAddHotelSelect').on('change',function(){
            var wrapper = $(this).parent().parent().parent();
            var hotelSelect = wrapper.find('select.jsAddRoomSelect');
            var id = $(this).val();
            var rooms = addHome.getRooms(id);
            hotelSelect.empty();
            $.each(rooms,function(index,value){
                hotelSelect.append('<option value="'+value.id+'">'+value.title+'</option>')
            });
        });

        $('.jsAddTypeSelect').on('ifChecked',function(event){
            var type = event.target.value;
            var wrapp = $(this).parent().parent().parent();
            if(type == 'hotel') {
                wrapp.find('.jsAddApartmentSelect').addClass('hide');
                wrapp.find('.jsAddApartmentSelect').removeAttr('urestrequired');
                wrapp.find('.jsAddApartmentSelect').removeAttr('required');
                wrapp.find('.jsAddApartmentLabel').addClass('hide');

                wrapp.find('.jsAddHotelSelect').removeClass('hide');
                wrapp.find('.jsAddHotelLabel').removeClass('hide');
                wrapp.find('.jsAddRoomSelect').removeClass('hide');
                wrapp.find('.jsAddRoomLabel').removeClass('hide');
            } else {
                wrapp.find('.jsAddApartmentSelect').removeClass('hide');
                wrapp.find('.jsAddApartmentLabel').removeClass('hide');

                wrapp.find('.jsAddHotelSelect').addClass('hide');
                wrapp.find('.jsAddHotelSelect').removeAttr('urestrequired');
                wrapp.find('.jsAddHotelSelect').removeAttr('required');
                wrapp.find('.jsAddHotelLabel').addClass('hide');
                wrapp.find('.jsAddRoomSelect').addClass('hide');
                wrapp.find('.jsAddRoomSelect').removeAttr('urestrequired');
                wrapp.find('.jsAddRoomSelect').removeAttr('required');
                wrapp.find('.jsAddRoomLabel').addClass('hide');
            }

        });
    })

    $('span.btn-file').on('click',function(){
        $(this).parent().find('input[type=file]').click();
    })

    $('.urest_del_media').on('click',function(){
        $(this).parent().find('input[name*=unlink]').attr('checked','checked');
    })

    $('.urest_fileinput input[type=file]').on('change',function(){
        if($(this).val() != '')
        $(this).parent().parent().parent().parent().find('input[name*=unlink]').removeAttr('checked');
    })

        $(function ( $ ) {

            $.fn.formCheck = function() {

                this.lockSubmit = false;
                var s = this;
                this.find('[required]').each(function(){
                    $(this).attr('urestRequired', 'required');
                    $(this).removeAttr('required')
                })

                this.bind('submit',function(){
                    var success = true;
                    $(this).find('[urestRequired=required]').each(function(){
                        if($(this).val() == '')
                        {
                            if($(this).hasClass('select2-offscreen'))
                            {
                                $(this).prev('.select2-container').css('border','red 1px solid');
                            }
                            else
                            {
                                $(this).css('border','red 1px solid');
                            }
                            if($(this).next('.errorDiv').size() == 0)
                            {
                                var errorDiv = $("<div>", {style: "position:absolute; color:red", class: "errorDiv"});
                                errorDiv.html('required field');
                                $(this).after(errorDiv);
                            }
                            success = false;
                        }
                        else
                        {
                            if($(this).hasClass('select2-offscreen'))
                            {
                                $(this).prev('.select2-container').css('border','');
                            }
                            else
                            {
                                $(this).css('border','');
                            }
                            $(this).next('.errorDiv').replaceWith('')
                        }

                    })

                    if(success == false)
                    {
                        $('body,html').animate(
                            {scrollTop:0},1000);
                        return false;
                    }
                    if (s.lockSubmit) return false;
                    s.lockSubmit = true;
                })

            };
        }( jQuery ));

    $('form').formCheck();


    $('#listTable tr.replace-inputs th:last').html(' ');
    $('#listTable tr.replace-inputs th:first').removeClass('sorting_asc');


    $(document).on('keypress','input[data-format="price"]',function(key) {
        var denyComma = false;
        var isComma = false;
        var price = $(this).val()+String.fromCharCode(key.charCode);
        var matches = price.match(/[\.,]/g);
        if (matches!=null && matches.length>1) denyComma=true;
        if (key.charCode==44 || key.charCode==46) isComma = true;
        if (!(key.charCode >= 48 && key.charCode <= 57) && (!isComma || denyComma) )
            return false;
    });



    $('select[name*=country]').change(function(){
        var country = $(this).val();
        if(country !== null)
        {
            $('select[name*=region] option').attr('disabled','disabled');
            var val = $('select[name*=region] option[parent='+country+']:first').attr('value');
            $('select[name*=region]').select2("val", val);
            $('select[name*=region] option').each(function(){
                if($(this).attr('parent') == country) $(this).removeAttr('disabled');
            })
        }
        else
        {
            $('select[name*=region] option').removeAttr('disabled');
        }
        $('select[name*=region]').change();
    })

    $('select[name*=region]').change(function(){
        var region = $(this).val();
        if(region !== null)
        {
            $('select[name*=city] option').attr('disabled','disabled');
            var val = $('select[name*=city] option[parent='+region+']:first').attr('value');
            $('select[name*=city]').select2("val", val);
            $('select[name*=city] option').each(function(){
                if($(this).attr('parent') == region) $(this).removeAttr('disabled');
            })
        }
        else
        {
            $('select[name*=city] option').removeAttr('disabled');
        }
    })

    $('select.jsAddHotelSelect').on('change',function(){
        var wrapper = $(this).parent().parent().parent();
        var hotelSelect = wrapper.find('select.jsAddRoomSelect');
        var id = $(this).val();
        var rooms = addHome.getRooms(id);
        hotelSelect.empty();
        $.each(rooms,function(index,value){
            hotelSelect.append('<option value="'+value.id+'">'+value.title+'</option>')
        });
    });
    $('.jsAddTypeSelect').on('ifChecked',function(event){
        var type = event.target.value;
        var wrapp = $(this).parent().parent().parent();
        if(type == 'hotel') {
            wrapp.find('.jsAddApartmentSelect').addClass('hide');
            wrapp.find('.jsAddApartmentSelect').removeAttr('urestrequired');
            wrapp.find('.jsAddApartmentSelect').removeAttr('required');
            wrapp.find('.jsAddApartmentLabel').addClass('hide');

            wrapp.find('.jsAddHotelSelect').removeClass('hide');
            wrapp.find('.jsAddHotelLabel').removeClass('hide');
            wrapp.find('.jsAddRoomSelect').removeClass('hide');
            wrapp.find('.jsAddRoomLabel').removeClass('hide');
        } else {
            wrapp.find('.jsAddApartmentSelect').removeClass('hide');
            wrapp.find('.jsAddApartmentLabel').removeClass('hide');

            wrapp.find('.jsAddHotelSelect').addClass('hide');
            wrapp.find('.jsAddHotelSelect').removeAttr('urestrequired');
            wrapp.find('.jsAddHotelSelect').removeAttr('required');
            wrapp.find('.jsAddHotelLabel').addClass('hide');
            wrapp.find('.jsAddRoomSelect').addClass('hide');
            wrapp.find('.jsAddRoomSelect').removeAttr('urestrequired');
            wrapp.find('.jsAddRoomSelect').removeAttr('required');
            wrapp.find('.jsAddRoomLabel').addClass('hide');
        }
    });

    $('.jsAddTypeSelect input').each(function(){

        if($(this).is(':checked')) {
            var type = $(this).val();
            var wrapp = $(this).parent().parent().parent().parent().parent().parent().parent();
            if(type == 'hotel') {
                wrapp.find('.jsAddApartmentSelect').addClass('hide');
                wrapp.find('.jsAddApartmentSelect').removeAttr('urestrequired');
                wrapp.find('.jsAddApartmentSelect').removeAttr('required');
                wrapp.find('.jsAddApartmentLabel').addClass('hide');

                wrapp.find('.jsAddHotelSelect').removeClass('hide');
                wrapp.find('.jsAddHotelLabel').removeClass('hide');
                wrapp.find('.jsAddRoomSelect').removeClass('hide');
                wrapp.find('.jsAddRoomLabel').removeClass('hide');
            } else {
                wrapp.find('.jsAddApartmentSelect').removeClass('hide');
                wrapp.find('.jsAddApartmentLabel').removeClass('hide');

                wrapp.find('.jsAddHotelSelect').addClass('hide');
                wrapp.find('.jsAddHotelSelect').removeAttr('urestrequired');
                wrapp.find('.jsAddHotelSelect').removeAttr('required');
                wrapp.find('.jsAddHotelLabel').addClass('hide');
                wrapp.find('.jsAddRoomSelect').addClass('hide');
                wrapp.find('.jsAddRoomSelect').removeAttr('urestrequired');
                wrapp.find('.jsAddRoomSelect').removeAttr('required');
                wrapp.find('.jsAddRoomLabel').addClass('hide');
            }
        }
    });

    $('.jsAddHotelSelect').removeAttr('urestrequired');

});
