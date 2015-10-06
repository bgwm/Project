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

error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));


@ set_magic_quotes_runtime(0);

if (PHP_VERSION >= '5.1') {
    date_default_timezone_set('PRC');
}


$root_url = dirname('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']) . "/";
define('ROOT_PATH', str_replace('include/init.php', '', str_replace('\\', '/', __FILE__)));
define('ROOT_URL', !defined('ROUTE') ? $root_url : str_replace('include/', '', $root_url));



require (ROOT_PATH . 'data/config.php');
require (ROOT_PATH . 'include/smarty/Smarty.class.php');
require (ROOT_PATH . 'include/mysql.class.php');
require (ROOT_PATH . 'include/common.class.php');
require (ROOT_PATH . 'include/action.class.php');
require (ROOT_PATH . 'include/check.class.php');
require (ROOT_PATH . 'include/firewall.class.php');

$dou = new Action($dbhost, $dbuser, $dbpass, $dbname, $prefix, DOU_CHARSET);
$check = new Check();
$firewall = new Firewall();

define('DOU_SHELL', $dou->get_one("SELECT value FROM " . $dou->table('config') . " WHERE name = 'hash_code'"));
define('DOU_ID', 'dou_' . substr(md5(DOU_SHELL . 'dou'), 0, 5));

$_CFG = $dou->get_config();

if (!defined('EXIT_INIT')) {

    header('Cache-control: private');
    header('Content-type: text/html; charset=' . DOU_CHARSET);


    require (ROOT_PATH . 'languages/' . $_CFG['language'] . '/common.lang.php');
    $_LANG['copyright'] = preg_replace('/d%/Ums', $_CFG['site_name'], $_LANG['copyright']);


    if ($_CFG['site_closed']) {
 
        header('Content-type: text/html; charset=' . DOU_CHARSET);

        echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"><div style=\"margin: 200px; text-align: center; font-size: 14px\"><p>" .
            $_LANG['site_closed'] . "</p><p></p></div>";
        exit();
    }


    $firewall->dou_firewall();

    $theme = $_CFG['site_theme'];
    if ($_CFG['qq']) {
        $_CFG['qq'] = $dou->dou_qq($_CFG['qq']);
    }
    $_CFG['guestbook_link'] = $dou->rewrite_url('guestbook');
    $_CFG['root_url'] = ROOT_URL;

    $smarty = new smarty();
    $smarty->config_dir = ROOT_PATH . 'include/smarty/Config_File.class.php'; 
    $smarty->template_dir = ROOT_PATH . 'theme/' . $theme; 
    $smarty->compile_dir = ROOT_PATH . 'cache'; 
    $smarty->left_delimiter = '{'; 
    $smarty->right_delimiter = '}'; 
    $smarty->force_compile = true;

    if (!file_exists($smarty->compile_dir))
        mkdir($smarty->compile_dir, 0777);

    $smarty->assign("lang", $_LANG);
    $smarty->assign("site", $_CFG);

    function remove_html_comments($source, & $smarty) {
        global $theme;
        $theme_path = ROOT_URL . 'theme';
        $source = preg_replace('/images\//Ums', "theme/$theme/images/", $source);
        $source = preg_replace('/\.*\/theme\//Ums', 'theme/', $source);
        $source = preg_replace('/link href\=\"style\.css/Ums', "link href=\"theme/$theme/style.css", $source);
        $source = preg_replace('/text\/javascript\" src\=\"/Ums',"text/javascript\" src=\"theme/$theme/",$source);
        $source = preg_replace('/text\/javascript\' src\=\'/Ums',"text/javascript' src='theme/$theme/",$source);
        $source = preg_replace('/stylesheet\" href\=\"/Ums',"stylesheet\" href=\"theme/$theme/",$source);
        $source = preg_replace('/layerslider-css-css\'  href\=\'/Ums',"layerslider-css-css'  href='theme/$theme/",$source);
        $source = preg_replace('/main-style-css\'  href\=\'/Ums',"main-style-css'  href='theme/$theme/",$source);
        $source = preg_replace('/theme\//Ums', "$theme_path/", $source);
        $source = preg_replace('/^<meta\shttp-equiv=["|\']Content-Type["|\']\scontent=["|\']text\/html;\scharset=(?:.*?)["|\'][^>]*?>\r?\n?/i', '', $source);

        return $source = preg_replace('/<!--.*{(.*)}.*-->/U', '{$1}', $source);
    }
    $smarty->register_prefilter('remove_html_comments');
}

// 开启缓冲区
ob_start();
?>