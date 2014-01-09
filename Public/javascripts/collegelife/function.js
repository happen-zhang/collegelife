/* 
Design by hehuaqi
Date:12/25 2013
North studio 21
 */

function animation_top_start(){
	$(document).ready(function(){
		$("#top").slideToggle("slow");
	})
	createCode();
	index_bg(1);
}

function login_box_show(){
   var IsMousedown,IsMousedown1 ,LEFT, TOP, login,login1,LEFT1,TOP1;
   /* for login */
   document.getElementById("Mdown").onmousedown=function(e) {
    login = document.getElementById("loginBox");
    IsMousedown = true;
    e = e||event;
    LEFT = e.clientX - parseInt(login.style.left);
    TOP = e.clientY - parseInt(login.style.top);
    document.onmousemove = function(e) {
     e = e||event;
     if (IsMousedown) {
      login.style.left = e.clientX - LEFT + "px";
      login.style.top = e.clientY - TOP + "px";
     }
    }
    
    document.onmouseup=function(){
     IsMousedown=false;
    }
   }

   /* for reg */
   document.getElementById("Mdown1").onmousedown=function(e) {
    login1 = document.getElementById("loginBox1");
    IsMousedown1 = true;
    e = e||event;
    LEFT1 = e.clientX - parseInt(login1.style.left);
    TOP1 = e.clientY - parseInt(login1.style.top);
    document.onmousemove = function(e) {
     e = e||event;
     if (IsMousedown1) {
      login1.style.left = e.clientX - LEFT1 + "px";
      login1.style.top = e.clientY - TOP1 + "px";
     }
    }
    
    document.onmouseup=function(){
     IsMousedown1=false;
    }
   }


}

function index_show(id){
	$(document).ready(function(){
		switch(id){
			case 1:
				window.location.href="index.php";
				break;
			case 2:
				window.location.href="index.php?value=1";
				break;
			case 3:
				window.location.href="mobile/index.php";
				break;
			case 4:
				$(".hide").fadeIn("slow");
				break;
			case 5:
				window.location.href="deal/logout.php";
				break;
			case 6:
				window.location.href="shop_list.php";
				break;
			case 7:
				window.location.href="info.php";
				break;
		}
	})
}

var code;
function createCode(){ 
	code = new Array();
	var codeLength = 4;
	var checkCode = document.getElementById("checkCode");
	checkCode.value = "";

	var selectChar = new Array(2,3,4,5,6,7,8,9,'A','B','C','D','E','F','G','H','J','K','L','M','N','P','Q','R','S','T','U','V','W','X','Y','Z');

	for(var i=0;i<codeLength;i++) {
	   var charIndex = Math.floor(Math.random()*32);
	   code +=selectChar[charIndex];
	}
	if(code.length != codeLength){
	   createCode();
	}
	checkCode.value = code;
}

function check_login(){
	var inputCode=document.getElementById("input1").value.toUpperCase();
	var name=document.getElementById("login_name").value;
	var password=document.getElementById("login_psd").value;

	if(name == ""){
		alert("请输入您的昵称");
		createCode();
		return false;
	}else if(password == ""){
		alert("请输入您的登录密码");
		createCode();
		return false;
	}else if(inputCode.length <=0) {
	   alert("请输入验证码");
	   return false;
	}else if(inputCode != code ){
	   alert("验证码输入错误");
	   createCode();
	   return false;
	}

}

function check_reg(){
	var name=document.getElementById("reg_name").value;
	var psd1=document.getElementById("reg_psd").value;
	var psd2=document.getElementById("reg_psd2").value;
	var email=document.getElementById("reg_email").value;
	var real=document.getElementById("reg_realname").value;
	if(name == ""){
		alert("请输入您的昵称");
		return false;
	}else if(psd1 == "" || psd2 == ""){
		alert("您的注册密码不能为空");
		return false;
	}else if(psd1.length < 6 || psd1.length > 20){
		alert("您的注册密码长度不符合要求");
		return false;
	}else if(psd1 != psd2){
		alert("您两次输入的密码不一致");
		return false;
	}else if(email == ""){
		alert("请输入您的邮箱");
		return false;
	}else if(real == ""){
		alert("请输入您的真实姓名");
		return false;
	}
}

function index_bg(id){
	$(document).ready(function(){
		for(var i=1;i<=3;i++){
			$(".content_right_img_"+i).hide();
		}
		$(".content_right_img_"+id).fadeIn("slow");
		if(id == 3){
			id=1;
		}else{
			id++;
		}
		t=setTimeout("index_bg("+id+")",10000);
	})
}

function check_info(){
	var name=document.getElementById("info_name").value;
	var email=document.getElementById("info_email").value;
	if(name == ""){
		alert("请输入您的真实姓名");
		return false;
	}else if(email == ""){
		alert("请输入您的邮箱");
		return false;
	}
}

function check_psd(){
	var psd1=document.getElementById("info_psd1").value;
	var psd2=document.getElementById("info_psd2").value;
	var psd3=document.getElementById("info_psd3").value;
	if(psd1 == ""){
		alert("请输入您的原密码");
		return false;
	}else if(psd2 == ""){
		alert("请输入您的新密码");
		return false;
	}else if(psd3 == ""){
		alert("请确认您的新密码");
		return false;
	}else if(psd2.length < 6 || psd2.length > 20){
		alert("您的新密码长度不符合要求");
		return false;
	}else if(psd2 != psd3){
		alert("您两次输入的密码不一致");
		return false;
	}
}

function check_shop(){
	var num=document.getElementById("shop_num").value;
	if(num < 1 || isNaN(num)){
		alert("请填写有效的数字再提交购买");
		return false;
	}else{
		num=num.replace(/\b(0+)/gi,"");
		var i=confirm("您确认要购买该产品且数量为"+num+"吗？");
		if(!i){
			return false;
		}
	}
}

function check_list(str,id){
	var i=confirm("您确认要取消"+str+"号订单吗？");
	if(i){
		window.location.href="deal/shop_list_deal.php?id="+id;
	}else{
		return false;
	}
}

function unvalid(){
	alert("请登录后再购买");
	return false;
}

function check_shop_btn(id){
	if(id == 1){
		var num=document.getElementById("shop_num").value;
		num=parseInt(num);
		if(num <= 1){
			document.getElementById("shop_num").value=1;
		}else{
			document.getElementById("shop_num").value-=1;
		}
	}else{
		var num=document.getElementById("shop_num").value;
		num=parseInt(num);
		num++;
		document.getElementById("shop_num").value=num;
	}
}

function check_commend(){
	var commend=document.getElementById("commend_box").value;
	if(commend == "发表评论"){
		alert("请写下您的评论再发布");
		return false;
	}
}

commend_num=1;
function show_commend(){
	$(document).ready(function(){
		if(commend_num == 1){
			document.getElementById("msg_commend").innerHTML="评论消息▲";
			commend_num=2;
		}else{
			document.getElementById("msg_commend").innerHTML="评论消息▼";
			commend_num=1;
		}
		$("#all_comment_line").slideToggle("slow");
	})
}

function check_contact(){
	var name=document.getElementById("contact_name").value;
	var cell=document.getElementById("contact_num").value;
	var textarea=document.getElementById("contact_area").value;
	if(name == ""){
		alert("请输入您的称呼再提交");
		return false;
	}else if(cell == ""){
		alert("请输入您的联系方式再提交");
		return false;
	}else if(textarea == ""){
		alert("请输入您的建议再提交");
		return false;
	}
}