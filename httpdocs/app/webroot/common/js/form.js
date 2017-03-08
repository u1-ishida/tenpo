/* agree */
$(function(){
$('input#agree').change(function(){
var prop = $('input#agree').prop('checked');
if(prop){
$('section.btn input#confirm').removeClass('disabled').prop('disabled', false);
$('span.arrowbtn2').append('<style>span.arrowbtn2:after{color:#fff}</style>');
}else{
$('section.btn input#confirm').addClass('disabled').prop('disabled', true);
$('span.arrowbtn2').append('<style>span.arrowbtn2:after{color:#aaa}</style>');
}
});});



/** select other **/
$(function() {
$('select').change(function(){
var selectid = $(this).attr('id');
  if($(this).find('option:selected').hasClass('other')) {
      $('p#'+selectid+'other').show();
  }else{
      $('p#'+selectid+'other').hide();
  }
});
});
