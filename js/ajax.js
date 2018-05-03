    //分页开始
    var pageNavObj = null;//用于储存分页对象
            pageNavObj = new PageNavCreate("PageNavId",{
                 pageCount:1000, 
                 currentPage:1, 
                 perPageNum:8, 
            });
            pageNavObj.afterClick(pageNavCallBack);

            function pageNavCallBack(clickPage){
                pageNavObj = new PageNavCreate("PageNavId",{
                     pageCount:1000, 
                     currentPage:clickPage, 
                     perPageNum:8, 
                });
                $.ajax({
                    type:'post',
                    url:'index.php?controller=index&method=page',
                    data:{
                        'page':clickPage
                    },
                    async:true,
                    success:function(data){
                      var data = JSON.parse(data);
                      $("#accordion").html(data[0]['warn_data']);
                    }
                })
                pageNavObj.afterClick(pageNavCallBack);
            }

    //分页结束
    var search_p;
    var search_c;
    var search_d;
    var search_s;
    var page_num;
    function search(province,city,district,search){
      search_p = province;
      search_c = city;
      search_d = district;
      search_s = search;
      $.ajax({
          type:'post',
          url:'index.php?controller=index&method=search',
          data:{
              'province':province,
              'city':city,
              'district':district,
              'search':search
          },
          async:true,
          success:function(data){
            // console.log(data);
            var data = JSON.parse(data);
            // console.log(data);
            $("#accordion").html(data[0]['warn_data']);
            $('#title_data').html(data[0]['title']);
            page_num = data[0]['page']
            pageNavObj = new PageNavCreate("PageNavId",{
                 pageCount:data[0]['page'], 
                 currentPage:1, 
                 perPageNum:8, 
            });
            pageNavObj.afterClick(resultpage);
          }
      });
    }
    function resultpage(clickPage){
      // console.log(clickPage);
      pageNavObj = new PageNavCreate("PageNavId",{
           pageCount:page_num, 
           currentPage:clickPage, 
           perPageNum:8, 
     });
      $.ajax({
          type:'post',
          url:'index.php?controller=index&method=searchpage',
          data:{
              'province':search_p,
              'city':search_c,
              'district':search_d,
              'search':search_s,
              'page':clickPage
          },
          async:true,
          success:function(data){
            var data = JSON.parse(data);
            // console.log(data);
            $("#accordion").html(data[0]['warn_data']);
          }
        });
      pageNavObj.afterClick(resultpage);
    }

    
     function login(){
            var user = this.user.value;
            var pass = this.pass.value;
            if(user == "" || pass == ""){
                alert("账号或密码不能为空!");
                return false;
            }
            $.ajax({
                url:'index.php?controller=index&method=login',
                data:{
                    'username':user,
                    'password':pass
                },
                async:true,
                type:'post',
                success:function(data){
                    // console.log(data);
                    if(data == "true")window.location.href='http://112.74.35.246';
                    else if(data == "false")alert("密码错误");
                    else alert("用户不存在");
                }
            });
            return false;
        }
        function register(){
            var user = username.value;
            var pass = password.value;
            var pass_again = confirmpassword.value;
            var phone = phonenumber.value;
            var province = province1.value;
            var city = city1.value;
            var county = district1.value;
            if(user == "" || pass == "" || pass_again == "" || province == "" || county == ""){
                alert("请完善注册表！");
                return false;
            }
            if(pass != pass_again){
                alert("密码不一致!");
                return false;
            }
            $.ajax({
                url:'index.php?controller=index&method=register',
                data:{
                    'username':user,
                    'password':pass,
                    'phonenumber':phone,
                    'province':province,
                    'city':city,
                    'county':county
                },
                type:'post',
                async:true,
                success:function(data){
                    // console.log(data);
                    if(data == "true")window.location.href='http://112.74.35.246';
                    else if(data == "false")alert("用户已存在");
                    else console.log(data);
                }
            });
            return false;
        }
        function page(){
            pageNavObj = new PageNavCreate("PageNavId",{
                     pageCount:1000, 
                     currentPage:1, 
                     perPageNum:8, 
                });
            $.ajax({
                type:'post',
                url:'index.php?controller=index&method=page',
                data:{
                    'page':1
                },
                async:true,
                success:function(data){
                  var data = JSON.parse(data);
                  $("#accordion").html(data[0]['warn_data']);
                  $("#title_data").html(data[0]['title']);
                }
            });
            pageNavObj.afterClick(pageNavCallBack);
        }
        function message(){
            if(msg_email.value == "" || msg_content.value == ""){
                alert('数据不能为空!');
                return 0;
            }
            $.ajax({
                type:'post',
                url:'index.php?controller=index&method=message',
                data:{
                    'email':msg_email.value,
                    'content':msg_content.value
                },
                async:true,
                success:function(data){
                    if(data == "true")alert("留言成功！");
                    else alert("留言失败！");
                }
            });
        }
        function del_msg(id){
          $.ajax({
            type:'post',
                url:'index.php?controller=index&method=delmsg',
                data:{
                  'id':id
                },
                async:true,
                success:function(data){
                  if(data == "true"){
                    var num = $("#message_num").text();
                    num = parseInt(num);
                    $("#message_num").text(num-1);
                  }
                }
          });
        }
        function cencel(){
          $('#phonenumber3').html('<h4>'+phone_num+'</h4>');
          $('#address3 h4').text(address_data);
          $('#chooseadd1').addClass('hidden1');
          $('#password3').html('<h4>'+pass_data+'</h4>');
          $('#button_data').html('<a href="admin.php?controller=admin&method=logout"><button class="btn btn-lg" style="float:left;">退出</button></a><button class="btn btn-primary btn-lg" type="submit" id="change" onclick="update_user();">修改</button> <button class="btn btn-danger btn-lg" data-dismiss="modal">取消</button>');
        }
        function send_update_user(){
          var phone = phonenumber11.value;
          var province = province3.value;
          var city = city3.value;
          var district = district3.value;
          var old_pass = password12.value;
          var new_pass = password11.value;
          var user = $("#user_name_data > h4").text();
          $.ajax({
            type:'post',
            url:"index.php?controlle=index&method=updateUser",
            data:{
                'user':user,
                'phone':phone,
                'province':province,
                'city':city,
                'district':district,
                'old_pass':old_pass,
                'new_pass':new_pass
            },
            async:true,
            success:function(data){
              var data = JSON.parse(data);
              console.log(data);
              $('#phonenumber3').html('<h4>'+data['phonenumber']+'</h4>');
              $('#address3 h4').text(data['province']+data['city']+data['county']);
              $('#chooseadd1').addClass('hidden1');
              $('#password3').html('<h4>'+pass_data+'</h4>');
              $('#button_data').html('<a href="admin.php?controller=admin&method=logout"><button class="btn btn-lg" style="float:left;">退出</button></a><button class="btn btn-primary btn-lg" type="submit" id="change" onclick="update_user();">修改</button> <button class="btn btn-danger btn-lg" data-dismiss="modal">取消</button>');
            }
          });
        }