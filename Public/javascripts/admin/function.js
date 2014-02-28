String.prototype.trim=function(){
　 return this.replace(/(^\s*)|(\s*$)/g, "");
}
String.prototype.ltrim=function(){
　 return this.replace(/(^\s*)/g,"");
}
String.prototype.rtrim=function(){
　 return this.replace(/(\s*$)/g,"");
}

function check_login(){
	var inputCode=document.getElementById("input1").value.toUpperCase();
	var name=document.getElementById("adminName").value;
	var psd=document.getElementById("adminPsd").value;
	if(name == ""){
		alert("请输入管理员姓名");
		return false;
	}else if(psd == ""){
		alert("请输入管理员密码");
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

/* 用户删除确定 */
function del(){
	var i=confirm("您确实要删除该用户吗？");
	if(i){
		window.location.href="delete.php";
	}
}

/* 通知删除确定 */
function del_msg(){
	var i=confirm("您确实要删除该通知吗？");
	if(i){
		window.location.href="delete_msg.php";
	}
}

/* 建议删除确定 */
function del_jianyi(){
	var i=confirm("您确实要删除该建议吗？");
	if(i){
		window.location.href="delete_msg.php";
	}
}

/* 建议删除确定 */
function del_comment(){
	var i=confirm("您确实要删除该评论吗？");
	if(i){
		window.location.href="delete_comment.php";
	}
}

/* 管理员删除确定 */
function del_manager(){
	var i=confirm("您确实要删除该管理员吗？");
	if(i){
		window.location.href="delete_manager.php";
	}
}

function check_msg() {
	var msg = document.getElementById("msg").value.trim();

    if (msg == "") {
    	alert("内容不能为空！");
    	return false;
    }

    return true;
}

function createFile() {
    var num = document.getElementById("select_num").value.trim();
    $(".display_img").remove();
    
    var field = "<p><input type='file' name='imgs[]' class='display_img' style='margin-left: 4.3em;' /><p>";
    for (var i = 0; i < num; i++) {
    	$("#select_num").after(field);
    }
}

function toggle_buildings(value) {
    if (value != 1) {
        $(".buildings").hide();
    } else {
    	$(".buildings").show();
    }
}

function check_apply() {
    var apply_cnt = document.getElementById("apply_cnt");
    var reg = /^[0-9]+$/;

    if (!reg.test(apply_cnt.value)) {
    	alert('请输入有效的数字！');
    	return false;
    }

    return true;
}

function check_password() {
	var origin_password = document.getElementById("origin_password").value.trim();
    var new_password = document.getElementById("new_password").value.trim();
    var confirm_password = document.getElementById("confirm_password").value.trim();

    if (origin_password == "") {
        alert("原密码不能为空");
        return false;    	
    }

    if (new_password == "") {
        alert("新密码不能为空");
        return false;    	
    }

    if (new_password != confirm_password) {
        alert("您两次填写的密码不一致！");
        return false;
    }

    return true;
}

function confirmOperation(url) {
    if (url != "#" && url != "") {
        if (confirm('是否确认进行该操作？')) {
            window.location.href = url;
        }        
    }

    return false;
}
