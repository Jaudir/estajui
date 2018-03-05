$(document).on('focusout','#justificativa_text', function(){
    $x = $('textarea#justificativa_text').val();
    $('#justificativa_post').val($x);
});