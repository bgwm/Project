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

require (dirname(__FILE__) . '/include/init.php');
$id = $firewall->get_legal_id('product', $_REQUEST['id'], $_REQUEST['unique_id']);
$cat_id = $dou->get_one("SELECT cat_id FROM " . $dou->table('product') . " WHERE id = '$id'");
$parent_id = $dou->get_one("SELECT parent_id FROM " . $dou->table('product_category') . " WHERE cat_id = '" . $cat_id . "'");
$cat_name = $dou->get_one("SELECT cat_name FROM " . $dou->table('product_category') . " WHERE cat_id = '" . $cat_id ."'");
if ($id == -1)
    $dou->dou_msg($GLOBALS['_LANG']['page_wrong'], ROOT_URL);
$query = $dou->select($dou->table('product'), '*', '`id` = \'' . $id . '\'');
$product = $dou->fetch_array($query);
$product['price'] = $product['price'] > 0 ? $dou->price_format($product['price']) : $_LANG['price_discuss'];
$product['add_time'] = date("Y-m-d", $product['add_time']);
$image = explode(".", $product[product_image]);
$product['thumb'] = ROOT_URL . $image[0] . "_thumb." . $image[1];
//$product['product_image'] = ROOT_URL . $product['product_image'];
$rpi=array();
$rpiIndex=0;
foreach (explode(',',$product['product_image']) as $pi) {
    $rpi[$rpiIndex++]= ROOT_URL .$pi;
}
foreach (explode(',', $product['defined']) as $row) {
    $row = explode('：', str_replace(":", "：", $row));
    if ($row['1']) {
        $defined[] = array (
                "arr" => $row['0'],
                "value" => $row['1'] 
        );
    }
}
$smarty->assign('page_title', $dou->page_title($product['product_name'], 'product_category', $cat_id));
$smarty->assign('keywords', $product['keywords']);
$smarty->assign('description', strip_tags($product['description']));//description must be strip
$smarty->assign('nav_top_list', $dou->get_nav('top'));
$smarty->assign('nav_middle_list', $dou->get_nav('middle', '0', 'product_category', $cat_id, $parent_id));
$smarty->assign('nav_bottom_list', $dou->get_nav('bottom'));
$smarty->assign('ur_here', $dou->ur_here('product_category', $cat_id, $product['product_name']));
$smarty->assign('product_category', $dou->get_category('product_category', 0, $cat_id));
$smarty->assign('product', $product);
$smarty->assign('defined', $defined);
$smarty->assign('product_images',$rpi);
$smarty->assign('cat_name', $cat_name);
$smarty->display('product.dwt');
?>