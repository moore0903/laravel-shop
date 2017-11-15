$(document).ready(function(){
	
	 $(".banner ul a").width($(window).width());
	 $('.banner').scrollable({size:1,items:'.banner ul',loop:true,clickable:false}).autoscroll({autoplay: true,autopause:false,interval:5000,steps:1}).navigator({navi:"ul.pan",naviItem:"li",activeClass:"hover"});
	 var c1=$(window).width();
	 var c2=($(".pan").width())+20;
	 var c3=(c1-c2)/2;
	 $(".pan").css({"left":c3});
		 
	 $(".menu li").hover(function(){
	   $(this).addClass("on");
	 },function(){
	   $(this).removeClass("on");	 
	 })
	 
	 $(".nbanner ul a").width($(window).width());
	 $('.nbanner').scrollable({size:1,items:'.banner ul',loop:true,clickable:false}).autoscroll({autoplay: true,autopause:false,interval:5000,steps:1}).navigator({navi:"ul.pan",naviItem:"li",activeClass:"hover"});

     $('.honortop').scrollable({size:1,items:'.honortop ul',loop:true,clickable:false}).autoscroll({autoplay: true,autopause:false,interval:6000,steps:1}).navigator({navi:".hontu ul",naviItem:"li",activeClass:"hover"});

	$('.hontu').scrollable({size:3,items:'.hontu ul',loop:true,clickable:false}).autoscroll({autoplay: true,autopause:false,interval:6000,steps:1});

    $('.protcont').scrollable({size:1,items:'.protcont ul',loop:true,clickable:false}).autoscroll({autoplay: true,autopause:false,interval:6000,steps:1}).navigator({navi:".probcont ul",naviItem:"li",activeClass:"hover"});

	$('.probcont').scrollable({size:3,items:'.probcont ul',loop:true,clickable:false}).autoscroll({autoplay: true,autopause:false,interval:6000,steps:1});
     
	$(".xx").click(function(){
	  $(this).parent().parent().remove();
	})
	
	$(".g1").click(function(){
	  $(this).parents().find(".gwblist").remove();
	})
	 
});