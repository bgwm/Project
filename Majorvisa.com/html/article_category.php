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
$cat_id = $firewall->get_legal_id('article_category', $_REQUEST['id'], $_REQUEST['unique_id']);
if ($cat_id == -1)
    $dou->dou_msg($GLOBALS['_LANG']['page_wrong'], ROOT_URL);
$page = $check->is_number($_REQUEST['page']) ? trim($_REQUEST['page']) : 1;
$limit = $dou->pager('article', $_CFG['display_article'], $page, $cat_id);
$sql = "SELECT id, title, content, image, cat_id, add_time, click, description, keywords FROM " . $dou->table('article') . " WHERE cat_id IN (" . $cat_id .
         $dou->dou_child_id($dou->fetch_array_all('article_category'), $cat_id) . ") ORDER BY id DESC" . $limit;
$query = $dou->query($sql);
while ($row = $dou->fetch_array($query)) {
    $url = $dou->rewrite_url('article', $row['id']);
    $add_time = date("Y-m-d", $row['add_time']);
    $add_time_short = date("m-d", $row['add_time']);
    $image = $row['image'] ? ROOT_URL . $row['image'] : '';
    $description = $row['description'] ? $row['description'] : $dou->dou_substr($row['content'], 200);
    $article_list[] = array (
            "id" => $row['id'],
            "cat_id" => $row['cat_id'],
            "title" => $row['title'],
            "image" => $image,
            "add_time" => $add_time,
            "add_time_short" => $add_time_short,
            "click" => $row['click'],
            "description" => $description,
            "url" => $url,
            "keywords" => $row['keywords'],
            "add_time_year" => date("Y", $row['add_time']),
            "add_time_month" => date("m", $row['add_time']),
            "add_time_day" => date("d", $row['add_time'])

    );
}
$sql = "SELECT cat_id, cat_name, parent_id FROM " . $dou->table('article_category') . " WHERE cat_id = '$cat_id'";
$query = $dou->query($sql);
$cate_info = $dou->fetch_array($query);
$smarty->assign('page_title', $dou->page_title('', 'article_category', $cat_id));
$smarty->assign('keywords', $cate_info['keywords']);
$smarty->assign('description', $cate_info['description']);
$smarty->assign('nav_top_list', $dou->get_nav('top'));
$smarty->assign('nav_middle_list', $dou->get_nav('middle', '0', 'article_category', $cat_id, $cate_info['parent_id']));
$smarty->assign('nav_bottom_list', $dou->get_nav('bottom'));
$smarty->assign('ur_here', $dou->ur_here('article_category', $cat_id));
$smarty->assign('cate_info', $cate_info);
$smarty->assign('article_category', $dou->get_category('article_category', 0, $cat_id));
$smarty->assign('article_list', $article_list);
$smarty->assign('recommend_article', $dou->get_article_list('ALL', 6, 'recommend'));
$smarty->display('article_category.dwt');
?>