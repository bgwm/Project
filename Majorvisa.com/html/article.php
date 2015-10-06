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
$id = $firewall->get_legal_id('article', $_REQUEST['id'], $_REQUEST['unique_id']);
$cat_id = $dou->get_one("SELECT cat_id FROM " . $dou->table('article') . " WHERE id = '$id'");
$parent_id = $dou->get_one("SELECT parent_id FROM " . $dou->table('article_category') . " WHERE cat_id = '" . $cat_id . "'");
if ($id == -1)
    $dou->dou_msg($GLOBALS['_LANG']['page_wrong'], ROOT_URL);
$query = $dou->select($dou->table('article'), '*', '`id` = \'' . $id . '\'');
$article = $dou->fetch_array($query);
$article['add_time_year'] = date("Y", $article['add_time']);
$article['add_time_month'] = date("m", $article['add_time']);
$article['add_time_day'] = date("d", $article['add_time']);
$article['add_time'] = date("Y-m-d", $article['add_time']);
foreach (explode(',', $article['defined']) as $row) {
    $row = explode('：', str_replace(":", "：", $row));
    
    if ($row['1']) {
        $defined[] = array (
                "arr" => $row['0'],
                "value" => $row['1'] 
        );
    }
}
$click = $article['click'] + 1;
$dou->query("update " . $dou->table('article') . " SET click = '$click' WHERE id = '$id'");
$smarty->assign('page_title', $dou->page_title($article['title'], 'article_category', $cat_id));
$smarty->assign('keywords', $article['keywords']);
$smarty->assign('description', $article['description']);
$smarty->assign('nav_top_list', $dou->get_nav('top'));
$smarty->assign('nav_middle_list', $dou->get_nav('middle', '0', 'article_category', $cat_id, $parent_id));
$smarty->assign('nav_bottom_list', $dou->get_nav('bottom'));
$smarty->assign('ur_here', $dou->ur_here('article_category', $cat_id, $article['title']));
$smarty->assign('article_category', $dou->get_category('article_category', 0, $cat_id));
$smarty->assign('lift', $dou->lift('article', $id, $cat_id));
$smarty->assign('article', $article);
$smarty->assign('defined', $defined);
$smarty->assign('recommend_article', $dou->get_article_list('ALL', 6, 'recommend'));
$smarty->display('article.dwt');
?>