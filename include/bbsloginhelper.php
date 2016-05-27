
<?php
require_once("config.php");
// 此处需要修改为Discuz根目录下config.php中的对应设置
$cookiepre = BBS_COOKIE_PRE; // cookie 前缀
$cookiedomain = ''; // cookie 作用域
$cookiepath = '/'; // cookie 作用路径
$timestamp = time();
function _setcookie($var, $value, $life = 0, $prefix = 1) {
    global $cookiepre, $cookiedomain, $cookiepath, $timestamp, $_SERVER;
    setcookie(($prefix ? $cookiepre : '').$var, $value,
        $life ? $timestamp + $life : 0, $cookiepath,
        $cookiedomain, $_SERVER['SERVER_PORT'] == 443 ? 1 : 0);
}
function _authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
    $ckey_length = 4;
    $key = md5($key ? $key : UC_KEY);
    $keya = md5(substr($key, 0, 16));
    $keyb = md5(substr($key, 16, 16));
    $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';
    $cryptkey = $keya.md5($keya.$keyc);
    $key_length = strlen($cryptkey);
    $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
    $string_length = strlen($string);
    $result = '';
    $box = range(0, 255);
    $rndkey = array();
    for($i = 0; $i <= 255; $i++) {
        $rndkey[$i] = ord($cryptkey[$i % $key_length]);
    }
    for($j = $i = 0; $i < 256; $i++) {
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }
    for($a = $j = $i = 0; $i < $string_length; $i++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
    }
    if($operation == 'DECODE') {
        if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
            return substr($result, 26);
        } else {
            return '';
        }
    } else {
        return $keyc.str_replace('=', '', base64_encode($result));
    }
}
function _synlogin($uid){
    $dz_tablepre=BBS_DB_PREFIX;
//此处需要修改一下文件的相对路径
	//echo dirname(__FILE__).'/../../bbs/forumdata/cache/cache_settings.php';
    require_once '../bbs/forumdata/cache/cache_settings.php';
	//echo dirname(__FILE__).'/../../bbs/forumdata/cache/cache_settings.php';
    $uid = intval($uid);
    $cookietime = 2592000;
    $discuz_auth_key = md5($_DCACHE['settings']['authkey'].$_SERVER['HTTP_USER_AGENT']);
    $con = mysql_connect("localhost", BBS_DB_USER, BBS_DB_PASS);
    $db_selected = mysql_select_db(BBS_DB,$con);
    $sql = "SELECT username, uid, password, secques FROM ".$dz_tablepre."members WHERE uid='$uid'";
    $result = mysql_query($sql,$con);
    $member = mysql_fetch_array($result);
    mysql_close($con);
    _setcookie('sid', '', -86400 * 365);
    _setcookie('cookietime', $cookietime, 31536000);
    _setcookie('auth', _authcode("$member[password]\t$member[secques]\t$member[uid]", 'ENCODE', $discuz_auth_key), $cookietime);
}
function _synlogout() {
    _setcookie('auth', '', -86400 * 365);
    _setcookie('sid', '', -86400 * 365);
    _setcookie('loginuser', '', -86400 * 365);
    _setcookie('activationauth', '', -86400 * 365);
}
