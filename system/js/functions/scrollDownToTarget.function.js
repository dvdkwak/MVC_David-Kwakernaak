var scrollDownToTarget = function(target){
  $('html, body').animate({
    scrollTop: $("#"+target).offset().top
  });
}
