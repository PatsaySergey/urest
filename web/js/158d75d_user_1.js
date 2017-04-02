$('#jsAvatarImg').click(function(){
    var input = $('#avatarImg');
    input.click();
});

$('#avatarImg').change(function(){
    var input = $('#avatarUnlink');
    input.removeAttr('checked');
});

$('#jsAvatarDel').click(function(){
    var input = $('#avatarUnlink');
    $('#jsUserAvatar').replaceWith('<div class="img-circle user-pic user-none img-thumbnail"><i class="fa fa-user"></i></div>');
    input.attr('checked','checked');
});