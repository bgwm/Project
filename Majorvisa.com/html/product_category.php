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
$cat_id = $firewall->get_legal_id('product_category', $_REQUEST['id'], $_REQUEST['unique_id']);
if ($cat_id == -1)
    $dou->dou_msg($GLOBALS['_LANG']['page_wrong'], ROOT_URL);
$page = $check->is_number($_REQUEST['page']) ? trim($_REQUEST['page']) : 1;
$limit = $dou->pager('product', $_CFG['display_product'], $page, $cat_id);
$sql = "SELECT id, cat_id, product_name, price, content, product_image, add_time, description FROM " . $dou->table('product') . " WHERE cat_id IN (" .
         $cat_id . $dou->dou_child_id($dou->fetch_array_all('product_category'), $cat_id) . ") ORDER BY id DESC" . $limit;
$query = $dou->query($sql);
while ($row = $dou->fetch_array($query)) {
    $url = $dou->rewrite_url('product', $row['id']);
    $add_time = date("Y-m-d", $row['add_time']);
    $description = $row['description'] ? $row['description'] : $dou->dou_substr($row['content'], 150);
    $image_main = explode(",",$row['product_image']);
    //$image = explode(".", $image_main[0]);
    //$image = explode("/", $image_main[0]);
    //$image_fn = $image[count($image)-1];
    //$image_path = str_replace($image_fn,'',$image_main[0]);
    $thumb = ROOT_URL . dirname($image_main[0]) ."/thumb_" . basename($image_main[0]);
    $thumb_r = ROOT_URL . dirname($image_main[1]) ."/thumb_" . basename($image_main[1]);
    $price = $row['price'] > 0 ? $dou->price_format($row['price']) : $_LANG['price_discuss'];
    $product_list[] = array (
            "id" => $row['id'],
            "cat_id" => $row['cat_id'],
            "name" => $row['product_name'],
            "price" => $price,
            "thumb" => $thumb,
            "thumb_r" => $thumb_r,
            "add_time" => $add_time,
            "description" => $description,
            "url" => $url 
    );
}
$sql = "SELECT * FROM " . $dou->table('product_category') . " WHERE cat_id = '$cat_id'";
$query = $dou->query($sql);
$cate_info = $dou->fetch_assoc($query);
$smarty->assign('page_title', $dou->page_title('', 'product_category', $cat_id));
$smarty->assign('keywords', $cate_info['keywords']);
$smarty->assign('description', $cate_info['description']);
$smarty->assign('nav_top_list', $dou->get_nav('top'));
$smarty->assign('nav_middle_list', $dou->get_nav('middle', '0', 'product_category', $cat_id, $cate_info['parent_id']));
$smarty->assign('nav_bottom_list', $dou->get_nav('bottom'));
$smarty->assign('ur_here', $dou->ur_here('product_category', $cat_id));
$smarty->assign('cate_info', $cate_info);
$smarty->assign('product_category', $dou->get_category('product_category', 0, $cat_id));
$smarty->assign('product_list', $product_list);
$smarty->display('product_category.dwt');
?>