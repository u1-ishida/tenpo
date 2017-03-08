/* content fade-in */
$(function() {
$('.fade').on('inview', function(event, isInView) {
var opa =  $(this).css('opacity');
if(isInView && opa==0){
$(this).stop().animate({ opacity: 1 },500);
}else{
/*$(this).stop().animate({ opacity: 0 },500);*/
}});});

/* Cookie */
$(function(){
var cv = readCookie('NAGASE_CV');
if(cv) {
  $('div.cookie').addClass('hidden');
  $('p.copyright').css('margin-bottom',+60);
} else {
  $('p.copyright').css('margin-bottom',+160);
}

/* continue */
$('div.cookie button').click(function(){
/*$($('div.cookie').stop().animate({bottom: "-1000"},400));*/
$('div.cookie').addClass('hidden');
$('p.copyright').css('margin-bottom',+60);
createCookie('NAGASE_CV', 1, 30);
cookiesClose();
setTimeout(function(){$('div.cookie').css('display','none');},500);
});

/* account regist complete,contact complete */
$('span.arrowbtn3 input').click(function(){
/*$($('div.cookie').stop().animate({bottom: "-1000"},400));*/
$('div.cookie').addClass('hidden');
$('p.copyright').css('margin-bottom',+60);
createCookie('NAGASE_CV', 1, 30);
cookiesClose();
setTimeout(function(){$('div.cookie').css('display','none');},500);
});
});

function readCookie(name) {
  var nameEQ = escape(name) + "=";
  var ca = document.cookie.split(';');
  for (var i = 0; i < ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') c = c.substring(1, c.length);
    if (c.indexOf(nameEQ) == 0) return unescape(c.substring(nameEQ.length, c.length));
  }
  return null;
}

function createCookie(name, value, days) {
  if (days) {
    var date = new Date();
    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
    var expires = "; expires=" + date.toGMTString();
  } else var expires = "";
  document.cookie = escape(name) + "=" + escape(value) + expires + "; path=/";
}

/* fixed header, coockie, pagetop-button */
$(function(){
var timer = null;
$(window).scroll(function () {
clearTimeout( timer );
timer = setTimeout(function() {
   if($(window).scrollTop() > 0) {
   $('header').addClass('scroll');
   $('footer').addClass('widthtop');
   if($('header').hasClass('menuopen')){
     }else{
     $('#pagetop').addClass('show');
     $('div.cookie p').addClass('widthtop');
   }}else {
   $('header').removeClass('scroll');
   $('footer').removeClass('widthtop');
   $('div.cookie p').removeClass('widthtop');
   $('#pagetop').removeClass('show');
   }
  });
});
});

/*SP menu*/
$(function(){
$('span.menutoggle').click(function(){
$('header').toggleClass('menuopen');
if($('header').hasClass('menuopen')){
    $('article').css('opacity','0.2');
    $('footer').css('opacity','0.2');
    $('span.menutoggle').html('<img src="/common/img/sp_menu_close.png" alt="menu">');
$('#pagetop').removeClass('show').css('opacity','0.2');
$('div.cookie p').removeClass('widthtop').css('opacity','0.2');
}else{
    $('article').css('opacity','1');
    $('footer').css('opacity','1');
    $('span.menutoggle').html('<img src="/common/img/sp_menu_open.png" alt="menu">');
$('#pagetop').css('opacity','1');
$('div.cookie p').css('opacity','1');
    }
});});


/* page top */
$(function(){
    $('a#pagetop').click(function(){
        $('html, body').stop().animate({scrollTop:0}, '500', 'swing');
        return false;
    });
});



$(document).on('opening', '.remodal', function () {
$('#pagetop').css('display','none'); 
});
$(document).on('closing', '.remodal', function (e) {
$('#pagetop').css('display','block'); 
});


/** select font-color **/
$(function() {
  if($('select').find('option:selected').hasClass('placeholder')) {
    $('select').css({'color': '#bbb'});
  }
 
$('select').on('change', function(){
if($(this).find('option:selected').hasClass('placeholder')) {
      $(this).css({'color': '#bbb'});
    } else {
      $(this).css({'color': '#000'});
    }  });
});

$(function(){
$('input#registration').click(function(){
window.location.href = "/account/create/introduction";
});
});
