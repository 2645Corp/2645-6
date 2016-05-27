<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>登录</title>
<link rel="shortcut icon" href="favicon.ico" />
<link href="jQueryAssets/jquery.ui.core.min.css" rel="stylesheet" type="text/css">
<link href="jQueryAssets/jquery.ui.theme.min.css" rel="stylesheet" type="text/css">
<link href="jQueryAssets/jquery.ui.button.min.css" rel="stylesheet" type="text/css">
<script src="jQueryAssets/jquery-1.11.1.min.js" type="text/javascript"></script>
<script src="jQueryAssets/jquery.ui-1.10.4.button.min.js" type="text/javascript"></script>
</head>

<body>
<form method="post" action="include/check_login.php">
<div align="center">
<table align="center" border="0" cellspacing="10px">
<tr><td></td><td align="center"><div style="font-family:微软雅黑; font-size:28px">用户登录</div></td></tr>
<tr><td><label for="username">用户名</label></td><td><input name="username" id="username" required="true" /></td></tr>
<tr><td><label for="pass">密码</label></td><td><input type="password" name="pass" id="pass" required="true"/></td></tr>
<tr><td></td><td align="center"><input type="button" id="Button2" value="注册" onclick="window.location.href='reg'"/>&emsp;<input type="submit" id="Button1" value="登录" />&emsp;<a href="reg/findmypass.html">找回密码</a></td></tr>
</table>
</div>
</form>
<script type="text/javascript">
$(function() {
	$( "input" ).button(); 
});
</script>
<?php
session_start();
if(isset($_SESSION['username'])&&isset($_SESSION['userflag']))
{
	if($_SESSION['userflag']!="student")
		header("Location: include/admin.php");
	else
		header("Location: include/stumain.php");
}
?>
</body>
</html>
