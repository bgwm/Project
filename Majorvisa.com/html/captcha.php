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
define('IN_DOUCO', true);
define('EXIT_INIT', true);

require (dirname(__FILE__) . '/include/init.php');
require (ROOT_PATH . 'include/captcha.class.php');

session_start();

$captcha = new Captcha(70, 25);

@ob_end_clean();

$captcha->create_captcha();
echo "ddd";

?>