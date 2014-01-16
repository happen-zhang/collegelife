function url_change(url){
	$(document).ready(function(){
		$("#box").animate({left:"-2000px"},800);
	})

	times=setTimeout("url_change_animation('"+url+"')",800);
}


function url_change_animation(url){
	window.location.href=url;
}

function check_login(){
	var name=document.getElementById("login_name").value;
	var psd=document.getElementById("login_psd").value;
	if(name == '登录昵称'){
		$("#error_box_2").hide();
		$("#error_box_1").fadeIn("slow");
		return false;
	}else if(psd == '密码'){
		$("#error_box_1").hide();
		$("#error_box_2").fadeIn("slow");
		return false;
	}
}

function doHideErrors() {
	for(var i=3;i<=17;i++){
		$("#error_box_"+i).hide();
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
		doHideErrors();
		$("#error_box_3").fadeIn("slow");
		return false;
	} if (name.length > 24 || name.length < 6) {
		doHideErrors();
		$("#error_box_9").fadeIn("slow");
		return false;
	} else if (!regNumLetter.test(name)) {
		doHideErrors();
		$("#error_box_10").fadeIn("slow");		
		return false;
	} else if(psd1 == "" || psd2 == ""){
		doHideErrors();
		$("#error_box_4").fadeIn("slow");
		return false;
	} else if(psd1.length < 6 || psd1.length > 24){
		doHideErrors();
		$("#error_box_11").fadeIn("slow");
		return false;
	} else if (!regNumLetter.test(psd1)) {
		doHideErrors();
		$("#error_box_12").fadeIn("slow");
		return false;
	} else if(psd1 != psd2) {
		doHideErrors();
		$("#error_box_6").fadeIn("slow");
		return false;
	} else if(email == "") {
		doHideErrors();
		$("#error_box_7").fadeIn("slow");
		return false;
	} else if (!regMail.test(email)) {
		doHideErrors();
		$("#error_box_13").fadeIn("slow");
		return false;		
	} else if(real == "") {
		doHideErrors();
		$("#error_box_8").fadeIn("slow");
		return false;
	} else if (!real.match(regSpecialChars)) {
		doHideErrors();
		$("#error_box_14").fadeIn("slow");
		return false;		
	} else if (tel_full != "" && tel_full.length < 6) {
		doHideErrors();
		$("#error_box_15").fadeIn("slow");
		return false;	
	} else if (tel_full != "" && !regNum.test(tel_full)) {
		doHideErrors();
		$("#error_box_15").fadeIn("slow");
		return false;			
	} else if (tel_brief != "" && tel_brief.length < 6) {
	    doHideErrors();	
		$("#error_box_16").fadeIn("slow");
		return false;	
	} else if (tel_brief != "" && !regNum.test(tel_brief)) {
		doHideErrors();
		$("#error_box_16").fadeIn("slow");
		return false;			
	} else if (dormitory_no == "" || !regNum.test(dormitory_no)) {
		doHideErrors();
		$("#error_box_17").fadeIn("slow");
		return false;
	}
}

function check_buy(){
	var integer = /^[1-9]+[0-9]*]*$/;
	var num=document.getElementById("shop_num").value;
	if(num < 1 || !integer.test(num)){
		alert("请填写有效的数字再提交购买");
		return false;
	}else{
		num = num.replace(/\b(0+)/gi, "");
		var i=confirm("您确认要购买该产品且数量为"+num+"吗？");
		if(!i){
			return false;
		}
	}
}

function unvalid(){
	alert("请登录后再购买");
	return false;
}

function check_list(id, url){
	var i=confirm("您确认要取消"+id+"号订单吗？");
	if(i){
		window.location.href=url;
	}else{
		return false;
	}
}