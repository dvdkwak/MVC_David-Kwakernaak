var setText1 = function(){
  $("#UC_show>p").text("You should go now...");
}

var setText2 = function(){
  $("#UC_show>p").text("Shu! Shu!");
}


$(document).ready(function(){
  centerVertical('centerMe', '0.8');
});

$(window).resize(function(){
  centerVertical('centerMe', '0.8');
});

setTimeout(function(){
  $("#UC_show").animate({"opacity":"1"}, 300);
}, 4000);

setTimeout(function(){
  setInterval(setText1, 2000);
}, 1000);
setInterval(setText2, 2000);
