$(document).ready(function(){

    // Hilangkan btn-cari
    $('#btn-cari').hide();

    $('#keyword').on('keyup', function(){
        let keyword = $(this).val();
        
        $.get('pages/product.php', {keyword: keyword}, function(data){
            $('#product').html(data);
        }).fail(function(){
            console.error('Error in AJAX request');
        });
    });

});