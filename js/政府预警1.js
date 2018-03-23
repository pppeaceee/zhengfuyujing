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

// 导航条事件开始
$('#nav').onePageNav({
    currentClass: 'current',
    changeHash: false,
    scrollSpeed: 750,
    scrollThreshold: 0.5,
    filter: '',
    easing: 'swing',
    begin: function() {
        //I get fired when the animation is starting
    },
    end: function() {
        //I get fired when the animation is ending
    },
    scrollChange: function($currentListItem) {
        //I get fired when you enter a section and I pass the list item of the section
    }
});
// 导航条事件结束

// 首页事件开始
$('.index').backstretch([
    "../images/pot-holder.jpg",
    "../images/coffee.jpg",
    "../images/dome.jpg"
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

new WOW().init();