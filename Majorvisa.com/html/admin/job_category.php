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

// rec操作项的初始化
$rec = $check->is_rec($_REQUEST['rec']) ? $_REQUEST['rec'] : 'default';

// 赋值给模板
$smarty->assign('rec', $rec);
$smarty->assign('cur', 'job_category');

/**
 * +----------------------------------------------------------
 * 分类列表
 * +----------------------------------------------------------
 */
if ($rec == 'default') {
    $smarty->assign('ur_here', $_LANG['job_category']);
    $smarty->assign('action_link', array (
            'text' => $_LANG['job_category_add'],
            'href' => 'job_category.php?rec=add'
    ));
    
    // 赋值给模板
    $smarty->assign('job_category', $dou->get_category_nolevel('job_category'));
    
    $smarty->display('job_category.htm');
} 

/**
 * +----------------------------------------------------------
 * 分类添加
 * +----------------------------------------------------------
 */
elseif ($rec == 'add') {
    $smarty->assign('ur_here', $_LANG['job_category_add']);
    $smarty->assign('action_link', array (
            'text' => $_LANG['job_category'],
            'href' => 'job_category.php'
    ));
    
    // CSRF防御令牌生成
    $smarty->assign('token', $firewall->set_token('job_category_add'));
    
    // 赋值给模板
    $smarty->assign('form_action', 'insert');
    $smarty->assign('job_category', $dou->get_category_nolevel('job_category'));
    
    $smarty->display('job_category.htm');
} 

elseif ($rec == 'insert') {
    if (empty($_POST['cat_name']))
        $dou->dou_msg($_LANG['job_category_name'] . $_LANG['is_empty']);
    if (!$check->is_unique_id($_POST['unique_id']))
        $dou->dou_msg($_LANG['unique_id_wrong']);
        
    // CSRF防御令牌验证
    $firewall->check_token($_POST['token'], 'job_category_add');
    
    $sql = "INSERT INTO " . $dou->table('job_category') . " (cat_id, unique_id, parent_id, cat_name, keywords, description, template, sort)" .
             " VALUES (NULL, '$_POST[unique_id]', '$_POST[parent_id]', '$_POST[cat_name]', '$_POST[keywords]', '$_POST[description]', '$_POST[template]', '$_POST[sort]')";
    $dou->query($sql);
    
    $dou->create_admin_log($_LANG['job_category_add'] . ': ' . $_POST['cat_name']);
    $dou->dou_msg($_LANG['job_category_add_succes'], 'job_category.php');
} 

/**
 * +----------------------------------------------------------
 * 分类编辑
 * +----------------------------------------------------------
 */
elseif ($rec == 'edit') {
    $smarty->assign('ur_here', $_LANG['job_category_edit']);
    $smarty->assign('action_link', array (
            'text' => $_LANG['job_category'],
            'href' => 'job_category.php'
    ));
    
    // 获取分类信息
    $cat_id = $check->is_number($_REQUEST['cat_id']) ? $_REQUEST['cat_id'] : '';
    $query = $dou->select($dou->table('job_category'), '*', '`cat_id` = \'' . $cat_id . '\'');
    $cat_info = $dou->fetch_array($query);
    
    // CSRF防御令牌生成
    $smarty->assign('token', $firewall->set_token('job_category_edit'));
    
    // 赋值给模板
    $smarty->assign('form_action', 'update');
    $smarty->assign('job_category', $dou->get_category_nolevel('job_category', '0', '0', $cat_id));
    $smarty->assign('cat_info', $cat_info);
    
    $smarty->display('job_category.htm');
} 

elseif ($rec == 'update') {
    if (empty($_POST['cat_name']))
        $dou->dou_msg($_LANG['job_category_name'] . $_LANG['is_empty']);
    if (!$check->is_unique_id($_POST['unique_id']))
        $dou->dou_msg($_LANG['unique_id_wrong']);
        
    // CSRF防御令牌验证
    $firewall->check_token($_POST['token'], 'job_category_edit');
    
    $sql = "update " . $dou->table('job_category') .
             " SET cat_name = '$_POST[cat_name]', unique_id = '$_POST[unique_id]', parent_id = '$_POST[parent_id]', keywords = '$_POST[keywords]' ,description = '$_POST[description]', template = '$_POST[template]', sort = '$_POST[sort]' WHERE cat_id = '$_POST[cat_id]'";
    $dou->query($sql);
    
    $dou->create_admin_log($_LANG['job_category_edit'] . ': ' . $_POST['cat_name']);
    $dou->dou_msg($_LANG['job_category_edit_succes'], 'job_category.php');
} 

/**
 * +----------------------------------------------------------
 * 分类删除
 * +----------------------------------------------------------
 */
elseif ($rec == 'del') {
    $cat_id = $check->is_number($_REQUEST['cat_id']) ? $_REQUEST['cat_id'] : $dou->dou_msg($_LANG['illegal'], 'job_category.php');
    $cat_name = $dou->get_one("SELECT cat_name FROM " . $dou->table('job_category') . " WHERE cat_id = '$cat_id'");
    $is_parent = $dou->get_one("SELECT id FROM " . $dou->table('job') . " WHERE cat_id = '$cat_id'") .
             $dou->get_one("SELECT cat_id FROM " . $dou->table('job_category') . " WHERE parent_id = '$cat_id'");
    
    if ($is_parent) {
        $_LANG['job_category_del_is_parent'] = preg_replace('/d%/Ums', $cat_name, $_LANG['job_category_del_is_parent']);
        $dou->dou_msg($_LANG['job_category_del_is_parent'], 'job_category.php', '', '3');
    } else {
        if (isset($_POST['confirm']) ? $_POST['confirm'] : '') {
            $dou->create_admin_log($_LANG['job_category_del'] . ': ' . $cat_name);
            $dou->delete($dou->table('job_category'), "cat_id = $cat_id", 'job_category.php');
        } else {
            $_LANG['del_check'] = preg_replace('/d%/Ums', $cat_name, $_LANG['del_check']);
            $dou->dou_msg($_LANG['del_check'], 'job_category.php', '', '30', "job_category.php?rec=del&cat_id=$cat_id");
        }
    }
}
?>