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
if ($_REQUEST['s']) {
    if ($check->is_text($keyword = trim($_REQUEST['s']))) {
        require (ROOT_PATH . 'include/search.inc.php');
    } else {
        $dou->dou_msg($_LANG['search_keyword_wrong']);
    }
}
$sql = "SELECT * FROM " . $dou->table('page') . " WHERE id = '1'";
$query = $dou->query($sql);
$about = $dou->fetch_array($query);
$index['about_name'] = $about['page_name'];
$index['about_content'] = $dou->dou_substr($about['content'], 300);
$index['about_link'] = $dou->rewrite_url('page', '1');
$index['product_link'] = $dou->rewrite_url('product_category');
$index['article_link'] = $dou->rewrite_url('article_category');
$index['cur'] = true;
$smarty->assign('page_title', $dou->page_title());
$smarty->assign('keywords', $_CFG['site_keywords']);
$smarty->assign('description', $_CFG['site_description']);
$smarty->assign('nav_top_list', $dou->get_nav('top'));
$smarty->assign('nav_middle_list', $dou->get_nav('middle'));
$smarty->assign('nav_bottom_list', $dou->get_nav('bottom'));
$smarty->assign('show_list', $dou->get_show_list());
$smarty->assign('link', get_link_list());
$smarty->assign('index', $index);
$smarty->assign('recommend_product', $dou->get_product_list('ALL', $_CFG['home_display_product'], 'recommend'));
$smarty->assign('recommend_article', $dou->get_article_list('ALL', $_CFG['home_display_article'], 'recommend'));
$smarty->display('index.dwt');
$limit = " limit 0,3";
$sql = "SELECT id, cat_id, product_name, product_image, description FROM " . $dou->table('product') . " WHERE home_sort>0 ORDER BY id DESC" . $limit;
$query = $dou->query($sql);
while ($row = $dou->fetch_array($query)) {
    $url = $dou->rewrite_url('product', $row['id']); 
    $add_time = date("Y-m-d", $row['add_time']);
    $description = $row['description'] ? $row['description'] : $dou->dou_substr($row['content'], 150);
    $image_main = explode(",",$row['product_image']);
    $thumb = ROOT_URL . dirname($image_main[0]) ."/thumb_" . basename($image_main[0]);
    $price = $row['price'] > 0 ? $dou->price_format($row['price']) : $_LANG['price_discuss'];
    $product_list[] = array (
            "id" => $row['id'],
            "name" => $row['product_name'],
            "thumb" => $thumb,
            "description" => $description,
            "url" => $url

    );
}
function get_link_list() {
    $sql = "SELECT * FROM " . $GLOBALS['dou']->table('link') . " ORDER BY sort ASC, id ASC";
    $query = $GLOBALS['dou']->query($sql);
    while ($row = $GLOBALS['dou']->fetch_array($query)) {
        $link_list[] = array (
                "id" => $row['id'],
                "link_name" => $row['link_name'],
                "link_url" => $row['link_url'],
                "sort" => $row['sort'] 
        );
    }
    
    return $link_list;
}

?>