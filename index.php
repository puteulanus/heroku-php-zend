<?php
$funs_list = array('close_curl', 'close_fopen', 'close_http', 'file_get_contents', 'openssl_open', 'zend_loader_enabled');

if (!function_exists('close_curl')) {
	function close_curl() {
		if (!extension_loaded('curl')) {
			return " <span style=\"color:blue\">请在php.ini中打开扩展extension=php_curl.dll</span>";
		} else {
			$func_str = '';
			if (!function_exists('curl_init')) {
				$func_str .= "curl_init() ";
			} 
			if (!function_exists('curl_setopt')) {
				$func_str .= "curl_setopt() ";
			} 
			if (!function_exists('curl_exec')) {
				$func_str .= "curl_exec()";
			} 
			if ($func_str)
				return " <span style=\"color:blue\">不支持 $func_str 等函数，请在php.ini里面的disable_functions中删除这些函数的禁用！</span>";
		} 
	} 
} 
if (!function_exists('close_fopen')) {
	function close_fopen() {
		if (!@ini_get('allow_url_fopen')) {
			return " <span style=\"color:blue\">不能使用 fopen() 和 file_get_contents() 函数。请在php.ini中设置allow_url_fopen = On</span>";
		} else {
			if (!function_exists('fopen')) {
				return " <span style=\"color:blue\">不支持 fopen() 函数，请在php.ini里面的disable_functions中删除这些函数的禁用！</span>";
			} 
		} 
	} 
} 

if (!function_exists('close_http')) {
	function close_http() {
		if (close_curl() && close_fopen()) {
			return true;
		} 
	} 
}

function function_support(&$func_items) {
	$func_str = "";
	foreach($func_items as $item) {
		$status = function_exists($item);
		$func_str .= "<tr>\n";
		if ($item == "close_curl") {
			$func_str .= "<td>CURL";
			if ($curl = close_curl()) {
				$status = '';
				$func_str .= $curl;
			} 
			$func_str .= "</td>\n";
		} else if ($item == "close_fopen") {
			$func_str .= "<td>fopen";
			if ($fopen = close_fopen()) {
				$status = '';
				$func_str .= $fopen;
			} 
			$func_str .= "</td>\n";
		} else if ($item == "close_http") {
			$func_str .= "<td>HTTP";
			if (close_http()) {
				$status = '';
			} 
			$func_str .= " <span style=\"color:green\">上面的 CURL 或者 fopen 必须支持一个！</span>";
			$func_str .= "</td>\n";
		} else if (preg_match("/openssl/", $item)) {
			$func_str .= "<td>$item()";
			if (!$status) {
				$func_str .= " <span style=\"color:blue\">请在php.ini中打开扩展extension=php_openssl.dll</span>";
			} 
			$func_str .= "</td>\n";
		} else if ($item == "zend_loader_enabled") {
			$version = function_exists('zend_loader_version') ? zend_loader_version() : '';
			$func_str .= "<td>Zend Optimizer ". $version;
			if (!$status) {
				$func_str .= " <span style=\"color:green\">不支持Zend，意味着不能使用付费插件。 php5.2.x请安装Zend Optimizer , php5.3.x请安装Zend Guard Loader</span>";
			} elseif (version_compare(PHP_VERSION, '5.4', '>=')) {
				$func_str .= '<span style=\"color:red\">很遗憾，暂时不能在php5.4.x上使用付费插件。请降到PHP5.3.x或者PHP5.2.x</span>';
			} else {
				$func_str .= ( version_compare($version, '3.3', '<') ) ? " <span style=\"color:red\">版本太低，php5.2.x请升级到3.3.0或以上版本，否则不能使用 付费插件</span>" : '';
			}
			$func_str .= "</td>\n";
		} else {
			$func_str .= "<td>$item()</td>\n";
		} 
		if ($status) {
			$func_str .= "<td>支持</td>\n";
			$func_str .= "<td><img src=\"http://smyx.googlecode.com/svn/wp-connect/images/0.gif\" class=\"yes\"/></td>\n";
		} else {
			$func_str .= "<td>不支持</td>\n";
			$func_str .= "<td><img src=\"http://smyx.googlecode.com/svn/wp-connect/images/0.gif\" class=\"no\"/></td>\n";
		} 
		$func_str .= "</tr>";
	} 
	return $func_str;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>环境检查</title>
<meta name="robots" content="noindex,nofollow,noarchive">
<style type="text/css">
body{margin-top:0px;font-family:Helvetica,Arial,Verdana,sans-serif; font-size:14px; background:#fff; color:#333; line-height:1.6em}
h3{margin:0px;font-size:1.17em;}
table{margin:10px 0; width:600px; text-align:left; border-collapse:collapse; border:1px solid #ebebeb}
table th{font-weight:bold; text-align:left; padding:10px 8px; background:#ebebeb}
table td{padding:8px}
table .odd{background:#f1f1f8}
img.yes, img.no{background:url(http://smyx.googlecode.com/svn/wp-connect/images/icon.gif) no-repeat; vertical-align:middle}
img.yes{width:15px; height:12px; background-position:0 -10px}
img.no{width:12px; height:12px; background-position:0 -22px}
</style>
</head>
<body>
<h3>环境检查</h3>
<?php
if (version_compare(PHP_VERSION, '5.4', '>=')) {
	$zend_install_tips = '很遗憾，您正在使用PHP 5.4.x以上版本，暂时不能使用 付费插件。请降到PHP5.3.x或者PHP5.2.x';
} else {
	$zend_loader_enabled = function_exists('zend_loader_enabled');
	if ($zend_loader_enabled) {
		$zend_loader_version = function_exists('zend_loader_version') ? zend_loader_version() : '';
		if (version_compare($zend_loader_version, '3.3', '>=')) {
			$php_version = (version_compare(PHP_VERSION, '5.3', '>=')) ? 'php5.3.x' : 'php5.2.x';
			$zend_install_tips = '恭喜你，您的服务器支持安装付费插件，您的php版本是 ' . PHP_VERSION .' ，购买完成后请在“已购买的插件”中点击 ' . $php_version . ' 的链接下载。<a href="http://smyx.net" target="_blank">现在去购买</a>';
		} else {
			$zend_install_tips = '很遗憾，您不能使用 付费插件，zend版本太低，请升级到3.3.0或以上版本，<a href="http://www.zend.com/en/products/guard/downloads" target="_blank">查看</a>';
		} 
	} else {
		if (version_compare(PHP_VERSION, '5.3', '>=')) {
			$zend_install_tips = '很遗憾，您不能使用 付费插件，php 5.3.x版本请安装 <a href="http://www.zend.com/en/products/guard/downloads" target="_blank">Zend Guard Loader</a>';
		} else {
			$zend_install_tips = '很遗憾，您不能使用 付费插件，请安装 <a href="http://www.zend.com/en/products/guard/downloads" target="_blank">Zend Optimizer</a>';
		} 
		$zend_install_tips .= '<br />如果您正在使用Godaddy linux主机，可以自己开启zend，<a href="http://www.smyx.net/godaddy-linux-open-zend-optimizer.html" target="_blank">查看教程</a>';
	} 
}
echo '<p style="color:red"><strong>' . $zend_install_tips . '</strong></p>';
?>
<h3>函数依赖性检查</h3>
<table>
  <thead>
    <tr>
      <th>函数名称</th>
      <th width="40">状态</th>
      <th width="30">结果</th>
    </tr>
  </thead>
  <tbody>
    <?php echo(function_support($funs_list));?>
  </tbody>
</table>
<?php echo ($getinfo) ? '<p>'.$getinfo.'</p>' : '';?>
<script type="text/javascript">
var table = document.getElementsByTagName("table");
for (j = 0; j < table.length; j++) {
    var tr = table[j].getElementsByTagName("tr");
    for (i = 0; i < tr.length; i++) {
        tr[i].className = (i % 2 > 0) ? "" : "odd";
    }
}
</script>
</body>
</html>