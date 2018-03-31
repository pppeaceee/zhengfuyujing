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

//下拉效果插件开始
new WOW().init();
//下拉效果插件结束

//轮播效果开始

//轮播效果结束

//登录注册、选择地址开始   
window.onload=function(){
    var oUserName=document.getElementById('username');
    var oSearch=document.getElementById("search");
    var oAddress1=document.getElementById("address1");
    var oMyselect1=document.getElementById("province"); 
    var oMyselect2=document.getElementById("city"); 
    var oMyselect3=document.getElementById("district"); 
    
  //   var index = oMyselect1.selectedIndex; // selectedIndex代表的是你所选中项的index 
  //   oMyselect1.options[index].value;
  //   oMyselect1.options[index].text; 
    oMyselect1.onclick=function()
    {
        if(oMyselect1.options[oMyselect1.selectedIndex].text=="—— 省 ——"){
            oAddress1.value="";
        }
        else{
            oAddress1.value=oMyselect1.options[oMyselect1.selectedIndex].text+oMyselect2.options[oMyselect2.selectedIndex].text+oMyselect3.options[oMyselect3.selectedIndex].text;
        }
    }
    oMyselect2.onclick=function()
    {
        if(oMyselect2.options[oMyselect2.selectedIndex].text=="—— 市 ——"||oMyselect3.options[oMyselect3.selectedIndex].text=="—— 区 ——")
        {
            oAddress1.value=oMyselect1.options[oMyselect1.selectedIndex].text;
        }
        else{
            oAddress1.value=oMyselect1.options[oMyselect1.selectedIndex].text+oMyselect2.options[oMyselect2.selectedIndex].text+oMyselect3.options[oMyselect3.selectedIndex].text;
        }
    }
    oMyselect3.onclick=function()
    {
      if(oMyselect3.options[oMyselect3.selectedIndex].text=="—— 区 ——"&&oMyselect2.options[oMyselect2.selectedIndex].text=="—— 市 ——")
      {
        oAddress1.value=oMyselect1.options[oMyselect1.selectedIndex].text;
      }
      if(oMyselect2.options[oMyselect2.selectedIndex].text!=="—— 市 ——"){
        oAddress1.value=oMyselect1.options[oMyselect1.selectedIndex].text; 
      }
      if(oMyselect2.options[oMyselect2.selectedIndex].text!=="—— 市 ——"&&oMyselect3.options[oMyselect3.selectedIndex].text=="—— 区 ——")
      {
        oAddress1.value=oMyselect1.options[oMyselect1.selectedIndex].text+oMyselect2.options[oMyselect2.selectedIndex].text;
      }     
      if(oMyselect3.options[oMyselect3.selectedIndex].text!=="—— 区 ——"&&oMyselect2.options[oMyselect2.selectedIndex].text!=="—— 市 ——")
      {
        oAddress1.value=oMyselect1.options[oMyselect1.selectedIndex].text+oMyselect2.options[oMyselect2.selectedIndex].text+oMyselect3.options[oMyselect3.selectedIndex].text;
      }
    }   
}

function checkUserName()
    {
         var oUserName = document.getElementById('username'); 
         var oTest1 = document.getElementById('test1'); 
         var pattern = /^[a-zA-Z0-9_]{4,15}$/;  //用户名格式正则表达式
         if(oUserName.value.length == 0){ 
            oTest1.innerHTML="用户名不能为空";
            return false; 
        } 
        if(!pattern.test(oUserName.value)){ 
            oTest1.innerHTML="用户名不合规范";       
            return false; 
        } 
        else{ 
            oTest1.innerHTML="OK" ;
            return true; 
        } 
    }

    function checkPassword()
    {
        var oPassword = document.getElementById('password'); 
         var oTest2 = document.getElementById('test2'); 
         var pattern = /^[a-zA-Z0-9_]{5,14}$/; 
         if(!pattern.test(oPassword.value)){ 
            oTest2.innerHTML="密码不合规范";
           return false; 
           } 
          else{ 
            oTest2.innerHTML="OK";
            return true; 
         } 
    }

    function ConfirmPassword()
    {
         var oConfirmPassword = document.getElementById('confirmpassword'); 
         var oPassword = document.getElementById('password'); 
         var oTest3 = document.getElementById('test3'); 
         if((oConfirmPassword.value)!=(oPassword.value) || oConfirmPassword.value.length == 0){ 
            oTest3.innerHTML="上下密码不一致"
           return false; 
           } 
          else{ 
            oTest3.innerHTML="OK"
            return true; 
          }  
    }

    function checkPhone()
    {
        var oPhoneNumber =document .getElementById('phonenumber');
        var oTest4=document.getElementById('test4');
        var pattern = /^1[34578]\d{9}$/; //验证手机号正则表达式 
        if(!pattern.test(oPhoneNumber.value)){ 
            oTest4.innerHTML="手机号码不合规范"
           return false; 
           } 
          else{ 
            oTest4.innerHTML="OK"
            return true; 
        } 
    }

    


//登录注册、选择地址结束