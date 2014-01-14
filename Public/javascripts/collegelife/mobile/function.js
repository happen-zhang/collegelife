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

function check_reg(){
	var name=document.getElementById("reg_name").value;
	var psd1=document.getElementById("reg_psd1").value;
	var psd2=document.getElementById("reg_psd2").value;
	var email=document.getElementById("reg_email").value;
	var real=document.getElementById("reg_realname").value;

	if(name == '您的昵称'){
		for(var i=3;i<=8;i++){
			$("#error_box_"+i).hide();
		}
		$("#error_box_3").fadeIn("slow");
		return false;
	}else if(psd1 == '密码长度6-20位'){
		for(var i=3;i<=8;i++){
			$("#error_box_"+i).hide();
		}
		$("#error_box_4").fadeIn("slow");
		return false;
	}else if(psd1.length < 6 || psd1.length > 20){
		for(var i=3;i<=8;i++){
			$("#error_box_"+i).hide();
		}
		$("#error_box_5").fadeIn("slow");
		return false;
	}else if(psd1 != psd2){
		for(var i=3;i<=8;i++){
			$("#error_box_"+i).hide();
		}
		$("#error_box_6").fadeIn("slow");
		return false;
	}else if(email == "邮箱"){
		for(var i=3;i<=8;i++){
			$("#error_box_"+i).hide();
		}
		$("#error_box_7").fadeIn("slow");
		return false;
	}else if(real == "真实姓名"){
		for(var i=3;i<=8;i++){
			$("#error_box_"+i).hide();
		}
		$("#error_box_8").fadeIn("slow");
		return false;
	}
}

function check_buy(){
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

function unvalid(){
	alert("请登录后再购买");
	return false;
}

function check_list(str,id){
	var i=confirm("您确认要取消"+str+"号订单吗？");
	if(i){
		window.location.href="deal/shop_list_deal.php?id="+id;
	}else{
		return false;
	}
}