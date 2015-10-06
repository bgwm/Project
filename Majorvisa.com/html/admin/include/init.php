<?php
/**
 * ZePHP
 * --------------------------------------------------------------------------------------------------
 * 版权所有 2013-2015 长沙宅神信息科技有限公司，并保留所有权利。
 * 网站地址: http://www.1ze.cn
 * --------------------------------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在遵守授权协议前提下对程序代码进行修改和使用；不允许对程序代码以任何形式任何目的的再发布。
 * 授权协议：http://www.1ze.cn/license.html
 * --------------------------------------------------------------------------------------------------
 * Author: Albert
 * Release Date: 2015-01-05
 */
if (!defined('IN_DOUCO')) {
    die('Hacking attempt');
}
session_start();
error_reporting(E_ALL ^ E_NOTICE);
if (PHP_VERSION >= '5.1') {
    date_default_timezone_set('PRC');
}
include_once ('../data/config.php');
define('ROOT_PATH', str_replace(ADMIN_PATH . '/include/init.php', '', str_replace('\\', '/', __FILE__)));
define('ROOT_URL', preg_replace('/' . ADMIN_PATH . '\//Ums', '', dirname('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']) . "/"));
define('IS_ADMIN', 'admin');
if (!file_exists(ROOT_PATH . "data/install.lock")) {
    header("Location: " . ROOT_URL . "install/index.php\n");
    exit();
}
require (ROOT_PATH . 'include/smarty/Smarty.class.php');
require (ROOT_PATH . 'include/mysql.class.php');
require (ROOT_PATH . 'include/common.class.php');
require (ROOT_PATH . ADMIN_PATH . '/include/action.class.php');
require (ROOT_PATH . ADMIN_PATH . '/include/check.class.php');
require (ROOT_PATH . 'include/firewall.class.php');
$dou = new Action($dbhost, $dbuser, $dbpass, $dbname, $prefix, DOU_CHARSET);
$check = new Check();
$firewall = new Firewall();
define('DOU_SHELL', $dou->get_one("SELECT value FROM " . $dou->table('config') . " WHERE name = 'hash_code'"));
define('DOU_ID', 'admin_' . substr(md5(DOU_SHELL . 'admin'), 0, 5));
$firewall->dou_firewall();
header('content-type: text/html; charset=' . DOU_CHARSET);
header('Expires: Fri, 14 Mar 1980 20:53:00 GMT');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');
ob_start();
$smarty = new smarty();
$smarty->config_dir = ROOT_PATH . 'include/smarty/Config_File.class.php'; 
$smarty->template_dir = ROOT_PATH . ADMIN_PATH . '/templates'; 
$smarty->compile_dir = ROOT_PATH . 'cache/' . ADMIN_PATH; 
$smarty->left_delimiter = '{'; 
$smarty->right_delimiter = '}'; 
if (!file_exists($smarty->compile_dir))
    mkdir($smarty->compile_dir, 0777);
if (!defined('NO_CHECK')) {
    $row = $dou->admin_check($_SESSION[DOU_ID]['user_id'], $_SESSION[DOU_ID]['shell']);
    if (is_array($row)) {
        $_USER = array (
                'user_id' => $row['user_id'],
                'user_name' => $row['user_name'],
                'email' => $row['email'],
                'action_list' => $row['action_list'] 
        );
        
        $smarty->assign("user", $_USER);
    }
}
$_CFG = $dou->get_config();
$smarty->assign("site", $_CFG);
require (ROOT_PATH . 'languages/zh_cn/admin/common.lang.php');
$smarty->assign("lang", $_LANG);
function remove_html_comments($source, & $smarty) {
    return $source = preg_replace('/<!--.*{(.*)}.*-->/U', '{$1}', $source);
}
$smarty->register_prefilter('remove_html_comments');
?>