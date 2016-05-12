$(document).ready(function() {
    $('.bt_show').click(function(){

        var bt = $(this);
        var id = $(this).attr('data-key');

        $.ajax({
            type: 'POST',
            url: '/message/show/' + id,
            dataType: 'text',
            success: function(data){
                console.log('success');
                $('#load_modal').html(data);
                $('#load_modal #myModal').modal();
            },
            beforeSend: function(){
                console.log('beforeSend');
            },
        });

    });
});