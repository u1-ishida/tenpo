/** tab change **/
function ChangeTab(tabname) {
$('div.tabcontent').hide();
$('div#'+tabname).show();
$('p.tabs a').removeClass('current');
$('p.tabs a#'+tabname).addClass('current');
};


/** tab default **/
$(function() {
var urlHash = location.hash;
if(urlHash){
  if (urlHash == '#filter') {
    $('a#keyword').removeClass('current');
    $('a#selection').addClass('current');
    $('div#keyword').removeClass('current');
    $('div#selection').addClass('current');
  } else {
  }
};});



/** each height **/
/* news */
$(function(){
    var biggestHeight = "0";
    $('section.productlist dl.product').each(function(){
        if ($(this).height() > biggestHeight ) {
            biggestHeight = $(this).height()
        }
    });
    $('section.productlist dl.product').height(biggestHeight);
})
