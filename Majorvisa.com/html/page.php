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
$id = $firewall->get_legal_id('page', $_REQUEST['id'], $_REQUEST['unique_id']);
if ($id == -1)
    $dou->dou_msg($GLOBALS['_LANG']['page_wrong'], ROOT_URL);
$page = get_page_info($id);
$top_id = $page['parent_id'] == 0 ? $id : $page['parent_id'];
$smarty->assign('page_title', $dou->page_title($page['page_name']));
$smarty->assign('keywords', $page['keywords']);
$smarty->assign('description', $page['description']);
$smarty->assign('nav_top_list', $dou->get_nav('top'));
$smarty->assign('nav_middle_list', $dou->get_nav('middle', '0', 'page', $id));
$smarty->assign('nav_bottom_list', $dou->get_nav('bottom'));
$smarty->assign('ur_here', $dou->ur_here('onepage', '', $page['page_name']));
$smarty->assign('page_list', $dou->get_page_list($top_id, $id));
$smarty->assign('top', get_page_info($top_id));
$smarty->assign('page', $page);
if ('page_image' == $page['type']){
    $image_list = get_page_images_info($id);
    $smarty->assign('image_list', $image_list);
}
if ($top_id == $id) {
    $smarty->assign("top_cur", 'top_cur');
}
$smarty->display($page['type'].'.dwt');
function get_page_info($id = 0) {
    $query = $GLOBALS['dou']->select($GLOBALS['dou']->table('page'), '*', '`id` = \'' . $id . '\'');
    $page = $GLOBALS['dou']->fetch_array($query);
    
    if ($page) {
        $page['url'] = $GLOBALS['dou']->rewrite_url('page', $page['id']);
    }
    
    return $page;
}
function get_page_images_info($id = 0) {
    $query = $GLOBALS['dou']->select($GLOBALS['dou']->table('page_images'), '*', '`page_id` = \'' . $id . '\'');
    while ($row = $GLOBALS['dou']->fetch_array($query)) {
        $url = $row['image_url'];
        $image_pathinfo = pathinfo($url);
        $image_ext = "." . $image_pathinfo['extension'];
        $image_name = basename($url, $image_ext);
        $image_path = $image_pathinfo['dirname'];
        $thumb = ROOT_URL . $image_path . "/thumb/" . $image_name . "_thumb" . $image_ext;
        $image_list[] = array (
            "id" => $row['id'],
            "sort" => $row['sort'],
            "name" => $row['name'],
            "url" => $row['image_url'],
            "thumb" => $thumb,
            "description" => $row['description'],
            "link" => $row['page_link']
        );
    }
    return $image_list;
}
?>