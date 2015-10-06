function AutoScroll2(){
  var re = $('#box ._ul')
  re.animate({marginLeft:"-189px"},1000,function(){
    re.css({marginLeft:0}).find("li:first").appendTo(re);
  })
}
$(function(){
  var _scrolling= setInterval("AutoScroll2()",3000);
  $("#box ._ul").hover(function(){
    clearInterval(_scrolling);
  },function(){
    _scrolling=setInterval("AutoScroll2()",3000);
  });
});


function AutoScroll(obj){ 
$(obj).find("ul:first").animate({ 
marginTop:"-115px" 
},500,function(){ 
$(this).css({marginTop:"0px"}).find("li:first").appendTo(this); 
}); 
} 
$(document).ready(function(){ 
setInterval('AutoScroll("#scrollDiv")',10000) 
}); 


$(document).ready(function() {
  $(window).scroll(function() {
      //$(document).scrollTop() 获取垂直滚动的距离
      //$(document).scrollLeft() 这是获取水平滚动条的距离
      if ($(document).scrollTop() <= 0) {
          $(".nav_a").animate({"height":"70px","line-height":"70px"});
          $(".logo_a").animate({"height":"70px"});
      }

      if ($(document).scrollTop() > 0) {
          $(".nav_a").animate({"height":"50px","line-height":"50px"});
          $(".logo_a").animate({"height":"50px"});
      }
  });
});


/**
 * jQuery jslides 1.1.0
 *
 * http://www.cactussoft.cn
 *
 * Copyright (c) 2009 - 2013 Jerry
 *
 * Dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 */
$(function(){
  var numpic = $('#slides li').size()-1;
  var nownow = 0;
  var inout = 0;
  var TT = 0;
  var SPEED = 5000;


  $('#slides li').eq(0).siblings('li').css({'display':'none'});


  var ulstart = '<ul id="pagination">',
    ulcontent = '',
    ulend = '</ul>';
  ADDLI();
  var pagination = $('#pagination li');
  var paginationwidth = $('#pagination').width();
  $('#pagination').css('margin-left',(470-paginationwidth))
  
  pagination.eq(0).addClass('current')
    
  function ADDLI(){
    //var lilicount = numpic + 1;
    for(var i = 0; i <= numpic; i++){
      ulcontent += '<li>' + '<a href="#">' + (i+1) + '</a>' + '</li>';
    }
    
    $('#slides').after(ulstart + ulcontent + ulend);  
  }

  pagination.on('click',DOTCHANGE)
  
  function DOTCHANGE(){
    
    var changenow = $(this).index();
    
    $('#slides li').eq(nownow).css('z-index','900');
    $('#slides li').eq(changenow).css({'z-index':'800'}).show();
    pagination.eq(changenow).addClass('current').siblings('li').removeClass('current');
    $('#slides li').eq(nownow).fadeOut(400,function(){$('#slides li').eq(changenow).fadeIn(500);});
    nownow = changenow;
  }
  
  pagination.mouseenter(function(){
    inout = 1;
  })
  
  pagination.mouseleave(function(){
    inout = 0;
  })
  
  function GOGO(){
    
    var NN = nownow+1;
    
    if( inout == 1 ){
      } else {
      if(nownow < numpic){
      $('#slides li').eq(nownow).css('z-index','900');
      $('#slides li').eq(NN).css({'z-index':'800'}).show();
      pagination.eq(NN).addClass('current').siblings('li').removeClass('current');
      $('#slides li').eq(nownow).fadeOut(400,function(){$('#slides li').eq(NN).fadeIn(500);});
      nownow += 1;

    }else{
      NN = 0;
      $('#slides li').eq(nownow).css('z-index','900');
      $('#slides li').eq(NN).stop(true,true).css({'z-index':'800'}).show();
      $('#slides li').eq(nownow).fadeOut(400,function(){$('#slides li').eq(0).fadeIn(500);});
      pagination.eq(NN).addClass('current').siblings('li').removeClass('current');

      nownow=0;

      }
    }
    TT = setTimeout(GOGO, SPEED);
  }
  
  TT = setTimeout(GOGO, SPEED); 

})



//滑动门
function tabChange(obj,id)
{
 var arrayli = obj.parentNode.getElementsByTagName("li"); //获取li数组
 var arrayul = document.getElementById(id).getElementsByTagName("ul"); //获取ul数组
 for(i=0;i<arrayul.length;i++)
 {
  if(obj==arrayli[i])
  {
   arrayli[i].className = "cli";
   arrayul[i].className = "";
  }
  else
  {
   arrayli[i].className = "";
   arrayul[i].className = "hidden";
  }
 }
}



//滚动插件 
(function($){ 
$.fn.extend({ 
Scroll:function(opt,callback){ 
//参数初始化 
if(!opt) var opt={}; 
var _this=this.eq(0).find("ul:first"); 
var lineH=_this.find("li:first").height(), //获取行高 
line=opt.line?parseInt(opt.line,10):parseInt(this.height()/lineH,10), //每次滚动的行数，默认为一屏，即父容器高度 
speed=opt.speed?parseInt(opt.speed,10):500, //卷动速度，数值越大，速度越慢（毫秒） 
timer=opt.timer?parseInt(opt.timer,10):3000; //滚动的时间间隔（毫秒） 
if(line==0) line=1; 
var upHeight=0-line*lineH; 
//滚动函数 
scrollUp=function(){ 
_this.animate({ 
marginTop:upHeight 
},speed,function(){ 
for(i=1;i<=line;i++){ 
_this.find("li:first").appendTo(_this); 
} 
_this.css({marginTop:0}); 
}); 
} 
//鼠标事件绑定 
_this.hover(function(){ 
clearInterval(timerID); 
},function(){ 
timerID=setInterval("scrollUp()",timer); 
}).mouseout(); 
} 
}) 
})(jQuery); 
$(document).ready(function(){ 
$("#scrollDiv").Scroll({line:1,speed:500,timer:3000}); 

}); 




