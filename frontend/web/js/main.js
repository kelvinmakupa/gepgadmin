$(function () {
    $('#mbutton').click(function(){
        $('#panel').modal('show')
            .find('#modal-content')
            .load($(this).attr('value'));

      //alert('Yes');
    });
    //alert('badhasfdhgsadfh');
});