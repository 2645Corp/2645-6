<?php
session_start();

require_once("bbsloginhelper.php");
_synlogout();

unset($_SESSION['username']);
unset($_SESSION['passcode']);
unset($_SESSION['userflag']);
echo "<script language=\"JavaScript\">alert(\"注销成功\");window.location.replace('../index.php');</script>";
?>