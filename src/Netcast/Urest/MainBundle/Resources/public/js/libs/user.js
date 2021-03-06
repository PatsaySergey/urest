$(document).ready(function() {
    $('#regBtn').click(function() {
        $('#regForm').submit();
    });
    $('#enterBtn').click(function() {
        $('#enterForm').submit();
    });
    $('#enterBtnMob').click(function() {
        $('#enterFormMob').submit();
    });
    $('#regBtnMob').click(function() {
        $('#regFormMob').submit();
    });
    $('#regForm, #regFormMob').submit(function() {
        var $self = $(this);
        $.ajax({
            url:     $self.prop('action'),
            type:    'post',
            data:    $self.serialize(),
            success: function(response) {
                if (response.success) {
                    $self.parent().fadeOut();
                    $self.parent().next('div').fadeOut();
                    $self.parent().after('Регистрация прошла успешно, для завершения, подтвердите email адрес');
                } else {
                    $self.find('.errorReg').remove();
                    for (var id in response.errors) {
                        for (var i in response.errors[id]) {
                            $('#' + id).after('<div class="errorReg" style="color: red">' + response.errors[id][i] + '</div>');
                        }
                    }
                }
            }
        });
        return false;
    });

    $('#enterForm, #enterFormMob').submit(function() {
        var $self = $(this);
        $.ajax({
            url:     $self.prop('action'),
            type:    'post',
            data:    $self.serialize(),
            success: function(response) {
                $self.find('.errorReg').remove();
                if (response.success) {
                    $('#signup-modal').modal('toggle');
                    $('li.user-bar.hidden-sm.hidden-xs > span').remove();
                    $('li.user-bar.hidden-sm.hidden-xs').append(
                        '<span><a href="' + response.profile + '">' + response.name + ', здравствуйте</a></span>' +
                        ' <span>|</span> ' +
                        '<span><a href="' + response.logout + '">Выйти</a></span>'
                    );
                } else {
                    var error = '';
                    switch (response.error) {
                        case 'Bad credentials':
                            error = 'Неправильный логин/пароль';
                            break;
                        case 'User account is disabled.':
                            error = 'Неподтвержденный аккунт';
                            break;
                    }
                    $self.prepend('<div class="errorReg" style="color: red">' + error + '</div>');
                }
            }
        });
        return false;
    });
});