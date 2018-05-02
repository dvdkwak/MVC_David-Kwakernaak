var pushDistance;
var distanceToButton;

// On document ready
$(document).ready(function(){
  centerVertical("moveCenter", "0.5");
  pushDistance = centerVertical("pushDown", "1.5");
  distanceToButton = $(window).height()*0.25;
  $('.UC_content').css({"padding-top":distanceToButton+"px"});
});


// On window resize
$(window).resize(function(){
  centerVertical("moveCenter", "0.5");
  pushDistance = centerVertical("pushDown", "1.5");
  distanceToButton = $(window).height()*0.25;
  $('.UC_content').css({"padding-top":distanceToButton+"px"});
});


// On document scroll
$(document).scroll(function(){
  // function to fix menu abr at right height
  if($(document).scrollTop() >= (pushDistance-($(".UC_getReady_btn").height()/2)-6)){
    $(".UC_menu").addClass("changed");
  }else{
    $(".UC_menu").removeClass("changed");
  }

  // function to add a 3d-effect
  let scrollTop = $(document).scrollTop();
  scrollTop = scrollTop/3;
  $('.UC_title').css({'margin-top':scrollTop+'px'});
});
