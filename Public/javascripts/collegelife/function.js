/* 
Design by hehuaqi
Date:12/25 2013
North studio 21
 */

String.prototype.trim=function(){
　 return this.replace(/(^\s*)|(\s*$)/g, "");
}
String.prototype.ltrim=function(){
　 return this.replace(/(^\s*)/g,"");
}
String.prototype.rtrim=function(){
　 return this.replace(/(\s*$)/g,"");
}

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
	var name=document.getElementById("login_name").value.trim();
	var password=document.getElementById("login_psd").value.trim();
	var regTest = /^[a-zA-Z0-9]+$/;

	if(name == ""){
		alert("请输入您的昵称");
		createCode();
		return false;
	} else if (name.length < 6 || name.length > 24) {
		alert("昵称长度必须在6~24个字符之间");
		createCode();
		return false;		
	} else if (false == regTest.test(name)) {
		alert("昵称只能包含字母和数字");
		createCode();
		return false;	
	} else if(password == "") {
		alert("请输入您的登录密码");
		createCode();
		return false;
	} else if (password.length < 6 || name.length > 24) {
		alert("密码长度必须在6~24个字符之间");
		createCode();
		return false;
	} else if (false == regTest.test(password)) {
		alert("密码昵称只能包含字母和数字");
		createCode();
		return false;
	} else if(inputCode.length <=0) {
	   alert("请输入验证码");
	   return false;
	}else if(inputCode != code ){
	   alert("验证码输入错误");
	   createCode();
	   return false;
	}
}

function check_reg(){
	var name=document.getElementById("reg_name").value.trim();
	var psd1=document.getElementById("reg_psd").value.trim();
	var psd2=document.getElementById("reg_psd2").value.trim();
	var email=document.getElementById("reg_email").value.trim();
	var real=document.getElementById("reg_realname").value.trim();
	var tel_full = document.getElementById("tel_full").value.trim();
	var tel_brief = document.getElementById("tel_brief").value.trim();
	var dormitory_no = document.getElementById("dormitory_no").value.trim();

	var regNumLetter = /^[a-zA-Z0-9]+$/;
	var regNum = /^[0-9]+$/;
	var regMail = /^\w+((-\w+)|(\.\w+))*\@{1}\w+\.{1}\w{2,4}(\.{0,1}\w{2}){0,1}/ig;
	var regSpecialChars = new RegExp(/^(([^\^\.<>%&',;=?$"':#@!~\]\[{}\\/`\|])*)$/);

	if(name == ""){
		alert("请输入您的昵称");
		return false;
	} if (name.length > 24 || name.length < 6) {
		alert("昵称长度必须在6~24个字符之间");
		return false;
	} else if (!regNumLetter.test(name)) {
		alert("昵称只能包含字母和数字");
		return false;
	} else if(psd1 == "" || psd2 == ""){
		alert("您的注册密码不能为空");
		return false;
	} else if(psd1.length < 6 || psd1.length > 24){
		alert("密码长度必须在6~24个字符之间");
		return false;
	} else if (!regNumLetter.test(psd1)) {
		alert("密码只能包含字母和数字");
		return false;
	} else if(psd1 != psd2) {
		alert("您两次输入的密码不一致");
		return false;
	} else if(email == "") {
		alert("请输入您的邮箱");
		return false;
	} else if (!regMail.test(email)) {
		alert("邮箱格式不正确");
		return false;		
	} else if(real == "") {
		alert("请输入您的真实姓名");
		return false;
	} else if (!real.match(regSpecialChars)) {
		alert("真实姓名不能包含特殊字符");
		return false;		
	} else if (tel_full != "" && tel_full.length < 6) {
		alert("请填写正确的长号");
		return false;	
	} else if (tel_full != "" && !regNum.test(tel_full)) {
		alert("请填写正确的长号");
		return false;			
	} else if (tel_brief != "" && tel_brief.length < 6) {	
		alert("请填写正确的短号");
		return false;	
	} else if (tel_brief != "" && !regNum.test(tel_brief)) {
		alert("请填写正确的短号");
		return false;			
	} else if (dormitory_no == "" || !regNum.test(dormitory_no)) {
		alert("请填写正确的宿舍号");
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
	var email=document.getElementById("email").value.trim();
	var real=document.getElementById("real_name").value.trim();
	var tel_full = document.getElementById("tel_full").value.trim();
	var tel_brief = document.getElementById("tel_brief").value.trim();
	var dormitory_no = document.getElementById("dormitory_no").value.trim();

	var regNumLetter = /^[a-zA-Z0-9]+$/;
	var regNum = /^[0-9]+$/;
	var regMail = /^\w+((-\w+)|(\.\w+))*\@{1}\w+\.{1}\w{2,4}(\.{0,1}\w{2}){0,1}/ig;
	var regSpecialChars = new RegExp(/^(([^\^\.<>%&',;=?$"':#@!~\]\[{}\\/`\|])*)$/);

    if(email == "") {
		alert("请输入您的邮箱");
		return false;
	} else if (!regMail.test(email)) {
		alert("邮箱格式不正确");
		return false;		
	} else if(real == "") {
		alert("请输入您的真实姓名");
		return false;
	} else if (!real.match(regSpecialChars)) {
		alert("真实姓名不能包含特殊字符");
		return false;		
	} else if (tel_full != "" && tel_full.length < 6) {
		alert("请填写正确的长号");
		return false;	
	} else if (tel_full != "" && !regNum.test(tel_full)) {
		alert("请填写正确的长号");
		return false;			
	} else if (tel_brief != "" && tel_brief.length < 6) {	
		alert("请填写正确的短号");
		return false;	
	} else if (tel_brief != "" && !regNum.test(tel_brief)) {
		alert("请填写正确的短号");
		return false;			
	} else if (dormitory_no == "" || !regNum.test(dormitory_no)) {
		alert("请填写正确的宿舍号");
		return false;
	}	
}

function check_psd(){
	var origin_psd=document.getElementById("origin_password").value.trim();
	var psd1=document.getElementById("password").value.trim();
	var psd2=document.getElementById("confirmation_password").value.trim();

	var regNumLetter = /^[a-zA-Z0-9]+$/;

    if(origin_psd == "") {
    	alert("原密码不能为空");
    	return false;
    } else if (origin_psd.length < 6 || origin_psd.length > 24) {
    	alert("原密码长度必须在6~24个字符之间");
    	return false;
    } else if (!regNumLetter.test(origin_psd)) {
		alert("原密码只能包含字母和数字");
    	return false;    	
    } else if(psd1 == "" || psd2 == ""){
		alert("密码不能为空");
		return false;
	} else if(psd1.length < 6 || psd1.length > 24){
		alert("密码长度必须在6~24个字符之间");
		return false;
	} else if (!regNumLetter.test(psd1)) {
		alert("密码只能包含字母和数字");
		return false;
	} else if(psd1 != psd2) {
		alert("您两次输入的密码不一致");
		return false;
	}
}

function check_shop(){
	var num=document.getElementById("shop_num").value;
	var goods_count = document.getElementById("goods_count");
	if(num < 1 || isNaN(num)){
		alert("请填写有效的数字再提交购买");
		return false;
	}else{
		num=num.replace(/\b(0+)/gi,"");
		var i=confirm("您确认要购买该产品且数量为"+num+"吗？");
        goods_count.value = num;
		if(!i){
			return false;
		}
	}
}

function check_list(id, url){
	var i=confirm("您确认要取消"+id+"号订单吗？");
	if(i){
		window.location.href=url;
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