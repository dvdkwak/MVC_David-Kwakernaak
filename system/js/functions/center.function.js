var centerVertical = function(target, amplifier = "1"){
  let wH = $(window).outerHeight();
  let targetH = $("#"+target).outerHeight();
  let neededH = (wH/2)-(targetH/2);
  neededH = neededH*amplifier;
  $("#"+target).css({"margin-top":neededH+"px"});
  return neededH;
}
