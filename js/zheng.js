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
    "../images/55.jpg",
    "../images/22.jpg",
    "../images/11.jpg"
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
        if(oMyselect1.options[oMyselect1.selectedIndex].text=="—— 省 ——"){
            oAddress1.value="";
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
      if(oMyselect1.options[oMyselect1.selectedIndex].text=="—— 省 ——"){
        oAddress1.value="";
    }
    }   




    var canvas = document.getElementById("canvas");
        var ctx = canvas.getContext('2d');

        function rand(min, max) {
            return parseInt(Math.random() * (max - min + 1) + min);
        }

        function Round() {
            //随机大小
            this.r = rand(5, 20);
            //随机位置
            var x = rand(0,canvas.width - this.r);//仿制超出右边界
            this.x = x<this.r ? this.r:x;
            var y = rand(0,canvas.height - this.r);
            this.y = y<this.r ? this.r:y;
            //随机速度
            var speed = rand(1, 3);
            this.speedX = rand(0, 4) > 2 ? speed : -speed;
            this.speedY = rand(0, 4) > 2 ? speed : -speed;

        }
        Round.prototype.draw = function() {
                    ctx.fillStyle = 'rgba(230,230,230,1)';
                    ctx.beginPath();
                    ctx.arc(this.x, this.y, this.r, 0, 2 * Math.PI, true);
                    ctx.closePath();
                    ctx.fill();
                }
            Round.prototype.links = function(){
                for (var i=0;i<ballobj.length;i++) {
//                  var ball = ballobj[i];
                    var l = Math.sqrt((ballobj[i].x - this.x)*(ballobj[i].x - this.x)+(ballobj[i].y - this.y)*(ballobj[i].y - this.y));
                    var a = 1/l *100;
                    if(l<250){
                    ctx.beginPath();
                    ctx.moveTo(this.x,this.y);
                    ctx.lineTo(ballobj[i].x,ballobj[i].y);
                    ctx.strokeStyle = 'rgba(230,230,230,1)';
                    ctx.stroke();
                    ctx.closePath();
                    }
            }
            }
            Round.prototype.move = function() {
                this.x += this.speedX/10;
                if (this.x > canvas.width  || this.x < 0) {
                    this.speedX *= -1;
                }
                this.y += this.speedY/10;
                if (this.y > canvas.height  || this.y < 0) {
                    this.speedY *= -1;
                }
            }
        var ballobj = [];

        function init() {
            for (var i = 0; i < 50; i++) {
                var obj = new Round();
                obj.draw();
                obj.move();
                ballobj.push(obj);
            }
        }
        init();
        function ballmove(){
            ctx.clearRect(0,0,canvas.width,canvas.height);
            for (var i=0;i<ballobj.length;i++) {
                var ball = ballobj[i];
                ball.draw();
                ball.move();
                ball.links();
            }
            window.requestAnimationFrame(ballmove);
        }
        ballmove();


//个人中心修改开始

//个人中心修改结束
}

var oChange=document.getElementById('change');
// var oPhonenumber3=document.getElementById('phonenumber3');
// var oAddredd3=document.getElementById('address3');
// var oPassword3=document.getElementById('password3');
// var oMessage1=document.getElementById('message1');




function checkPhone1()
    {
        var oPhoneNumber11 =document .getElementById('phonenumber11');
        var oTest11=document.getElementById('test11');
        var pattern = /^1[34578]\d{9}$/; //验证手机号正则表达式 
        if(!pattern.test(oPhoneNumber11.value)&&(oPhoneNumber11.value!='')){ 
            oTest11.innerHTML="手机号码不合规范"
            oTest11.className="red";  
           return false; 
           } 
          else{ 
            oTest11.innerHTML="OK"
            oTest11.className="green";  
            return true; 
        } 
    }

    function checkPassword1()
    {
        var oPassword11 = document.getElementById('password11'); 
         var oTest22 = document.getElementById('test22'); 
         var pattern = /^[a-zA-Z0-9_]{5,14}$/; 
         if(!pattern.test(oPassword11.value)&&(oPassword11.value!='')){ 
            oTest22.innerHTML="密码不合规范";
            oTest22.className="red";  
           return false; 
           } 
          else{ 
            oTest22.innerHTML="OK";
            oTest22.className="green";  
            return true; 
         } 
    }

var phone_num;
var address_data;
var pass_data;
function update_user(){
  if(change.innerHTML == "修改"){
    phone_num = $('#phonenumber3 > h4').text();
    address_data = $('#address3 h4').text();
    pass_data = $('#password3 > h4').text();

    $('#button_data').html('<a href="admin.php?controller=admin&method=logout"><button class="btn btn-lg" style="float:left;">退出登录</button></a><button class="btn btn-primary btn-lg" onclick="send_update_user();" type="submit" id="change">保存</button> <button class="btn btn-danger btn-lg" onclick="cencel();">取消</button>');
    $('#phonenumber3').html('<div class="form-group">'+
    '<input class="form-control" id="phonenumber11" type="number" name="phonenumber" placeholder="不填即为放弃修改" onBlur="checkPhone1()" oninput="checkPhone1()">'+
    '<span id="test11"></span> '+
'</div>');

   $('#chooseadd1').removeClass('hidden1');
   $('#province3').val("");
   $('#city3').val("");
   $('#district3').val("");
   
   $('#address3 h4').html('');
   $('#password3').html('<div class="form-group">'+

   '<h4>请输入原密码:</h4>'+
   '<input class="form-control" id="password12" type="password" name="password" placeholder="不填即为放弃修改">'+

   '<h4>请输入新密码:</h4>'+
   '<input class="form-control" id="password11" type="password" name="password" onBlur="checkPassword1()" oninput="checkPassword1()">'+
   '<span id="test22"></span>'+
'</div>')
  }else{

  }
    
}
// $("#province3 option:first").prop("selected", 'selected'); 

var oWarning1=document.getElementById('warning1');

var oWarning2=document.getElementById('warning2');

var oWarning3=document.getElementById('warning3');

var oWarning4=document.getElementById('warning4');

// $("#delete1").click(function(){
//     oWarning1.innerHTML='';
//     oWarning1.style='';
// })

$("#delete1").click(function(){
    $("#delete1").parent().html('').removeClass('mymessage10');
    
})

$("#delete2").click(function(){
    $("#delete2").parent().html('').removeClass('mymessage10');
    
})

$("#delete3").click(function(){
    $("#delete3").parent().html('').removeClass('mymessage10');
    
})

$("#delete4").click(function(){
    $("#delete4").parent().html('').removeClass('mymessage10');
    
})


$('#message1').click(function(){
    oChange.style.display="none";
})

$('#message2').click(function(){
    oChange.style.display="inline-block";
})

function checkUserName()
    {
         var oUserName = document.getElementById('username'); 
         var oTest1 = document.getElementById('test1'); 
         var pattern = /^[a-zA-Z0-9_]{4,15}$/;  //用户名格式正则表达式
         if(oUserName.value.length == 0){ 
            oTest1.innerHTML="用户名不能为空";
            oTest1.className="red";
            
            return false; 
        } 
        if(!pattern.test(oUserName.value)){ 
            oTest1.innerHTML="用户名不合规范";     
            oTest1.className="red";  
            return false; 
        } 
        else{ 
            oTest1.innerHTML="OK";
            oTest1.className="green";
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
            oTest2.className="red";  
           return false; 
           } 
          else{ 
            oTest2.innerHTML="OK";
            oTest2.className="green";  
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
            oTest3.className="red";  
           return false; 
           } 
          else{ 
            oTest3.innerHTML="OK"
            oTest3.className="green";  
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
            oTest4.className="red";  
           return false; 
           } 
          else{ 
            oTest4.innerHTML="OK"
            oTest4.className="green";  
            return true; 
        } 
    }

    function checkPhone3()
    {
        var oPhoneNumber =document .getElementById('phonenumber4');
        var oTest4=document.getElementById('find2');
        var pattern = /^1[34578]\d{9}$/; //验证手机号正则表达式 
        if(!pattern.test(oPhoneNumber.value)){ 
            oTest4.innerHTML="手机号码不合规范"
            oTest4.className="red";  
           return false; 
           } 
          else{ 
            oTest4.innerHTML="OK"
            oTest4.className="green";  
            return true; 
        } 
    }

    function checkUserName3()
    {
         var oUserName = document.getElementById('username4'); 
         var oTest1 = document.getElementById('find1'); 
         var pattern = /^[a-zA-Z0-9_]{4,15}$/;  //用户名格式正则表达式
         if(oUserName.value.length == 0){ 
            oTest1.innerHTML="用户名不能为空";
            oTest1.className="red";
            
            return false; 
        } 
        if(!pattern.test(oUserName.value)){ 
            oTest1.innerHTML="用户名不合规范";     
            oTest1.className="red";  
            return false; 
        } 
        else{ 
            oTest1.innerHTML="OK";
            oTest1.className="green";
            return true; 
        } 
    }

    function checkPassword3()
    {
        var oPassword = document.getElementById('password4'); 
         var oTest2 = document.getElementById('find3'); 
         var pattern = /^[a-zA-Z0-9_]{5,14}$/; 
         if(!pattern.test(oPassword.value)){ 
            oTest2.innerHTML="密码不合规范";
            oTest2.className="red";  
           return false; 
           } 
          else{ 
            oTest2.innerHTML="OK";
            oTest2.className="green";  
            return true; 
         } 
    }

    function ConfirmPassword3()
    {
         var oConfirmPassword = document.getElementById('confirmpassword4'); 
         var oPassword = document.getElementById('password4'); 
         var oTest3 = document.getElementById('find4'); 
         if((oConfirmPassword.value)!=(oPassword.value) || oConfirmPassword.value.length == 0){ 
            oTest3.innerHTML="上下密码不一致"
            oTest3.className="red";  
           return false; 
           } 
          else{ 
            oTest3.innerHTML="OK"
            oTest3.className="green";  
            return true; 
          }  
    }

    $('#verify').click(function(){
      var user = username4.value;
      var phone = phonenumber4.value;
      var pass = password4.value;
      var passagain = confirmpassword4.value;
      if(user == "" || phone == "" || pass == "" || passagain == ""){alert("请完善信息");return 0;}
      if(pass != passagain){alert("两次密码不一致");return 0};
      $.ajax({
        type:'post',
        url:'index.php?contorller=index&method=findpass',
        async:true,
        data:{
          'user':user,
          'phone':phone,
          'pass':pass
        },
        success:function(data){
          if(data == "true"){
            alert("密码修改成功");
            window.location.href='http://localhost';
          }else if(data == "false"){
            alert("请核实用户名和手机信息");
          }else{
            console.log("BUG");
          }
        }
      });
    })

//登录注册、选择地址结束

$('#tip1').popover();

$('#tip2').popover();

$('#tip3').popover();

$('#tip4').popover();

$('#tip5').popover();