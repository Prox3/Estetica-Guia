$(document).ready(function(){
 $("#categories_strip ul li, #page_nav ul li").hover(function(){
   $(this).addClass("hover");
   $('> .dir',this).addClass("open");
   $('ul:first',this).css('visibility', 'visible');
 },function(){
   $(this).removeClass("hover");
   $('.open',this).removeClass("open");
   $('ul:first',this).css('visibility', 'hidden');
 });

});