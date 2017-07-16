$(function($){

  $(".mininavlist").hide();	   
  
  $(".mititle").click(function(){
		$(this).siblings(".mininavlist").toggle(300);
  })
 
  $(".mititle").click(function(){
		$(this).toggleClass("on");
  })  
   
  $(".mininavlist li").click(function(){
		$(this).addClass("on").siblings().removeClass("on");
  })

	// $('#sidebar ul li').click(function(){
	// 	$(this).addClass('active').siblings().removeClass('active');
     //    var index = $(this).index();
	// 	$('.j-content').eq(index).toggle().siblings('.j-content').hide();
	// })
    
	// $(".add").click(function(){
	// var t=$(this).parent().find('input[class*=text_box]');
	// t.val(parseInt(t.val())+1)
	// setTotal();
	// })
	// $(".min").click(function(){
	// var t=$(this).parent().find('input[class*=text_box]');
	// t.val(parseInt(t.val())-1)
	// if(parseInt(t.val())<0){
	// t.val(0);
	// }
	// setTotal();
	// }) ;
	// function setTotal(){
	// var s=0;
	// $("#tab li").each(function(){
	// s+=parseInt($(this).find('input[class*=text_box]').val())*parseFloat($(this).find('span[class*=price]').text());
	// });
	// $("#total").html(s.toFixed(2));
	// }
	// setTotal();
	


})