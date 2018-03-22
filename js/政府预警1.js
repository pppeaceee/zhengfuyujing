// 滚动事件开始
$(window).scroll(function(){
    headerInit();
});

function headerInit(){
    if($(this).scrollTop()>0){
       $('body').addClass('fixed-header-on');
    }else{
       $('body').removeClass('fixed-header-on');
    }
}

headerInit();
// 滚动事件结束

// 首页事件开始
$('.index').backstretch([
    "images/pot-holder.jpg",
    "images/coffee.jpg",
    "images/dome.jpg"
    ], {
      fade: 750,
      duration: 3000,
      preload: 1, //Use the lazy-loading functionality
      start: 2 //Optional - now starts with "dome.jpg"
  });
// 首页事件结束


// 认识预警开始
$('.filter li a').click(function(){
    var filterValue = $(this).attr('data-filter');
    $(".isotope-container").isotope({filter:filterValue});
    $(this).parent().addClass('active').siblings().removeClass('active');
    return false;
})

// 认识预警结束