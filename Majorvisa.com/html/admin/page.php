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

// 图片上传
include_once (ROOT_PATH . 'include/upload.class.php');
$banner_dir = 'images/banner/'; // 文件上传路径 结尾加斜杠
$banner_thumb_dir = 'thumb/'; // 缩略图路径（相对于$banner_dir） 结尾加斜杠，留空则跟$banner_dir相同
$img = new Upload(ROOT_PATH . $banner_dir, $banner_thumb_dir); // 实例化类文件

$smarty->assign('rec', $rec);
$smarty->assign('cur', 'page');

$temp_num = $_REQUEST['temp_num']?$_REQUEST['temp_num']:time();//获取或者生成temp_num
$smarty->assign('temp_num', $temp_num);

/**
 * +----------------------------------------------------------
 * 单页面列表
 * +----------------------------------------------------------
 */
if ($rec == 'default') {
    $smarty->assign('ur_here', $_LANG['page_list']);
    $smarty->assign('action_link', array (
            'text' => $_LANG['page_add'],
            'href' => 'page.php?rec=add' 
    ));
    
    // 赋值给模板
    $smarty->assign('page_list', $dou->get_page_nolevel());
    
    $smarty->display('page.htm');
} 

/**
 * +----------------------------------------------------------
 * 单页面添加
 * +----------------------------------------------------------
 */
elseif ($rec == 'add') {
    $smarty->assign('ur_here', $_LANG['page_add']);
    $smarty->assign('action_link', array (
            'text' => $_LANG['page_list'],
            'href' => 'page.php' 
    ));
    
    // CSRF防御令牌生成
    $smarty->assign('token', $firewall->set_token('page_add'));

    //新建时如果选择的页面类型切换，则要获取并赋值刚才用户可能输入的数据，不包括所选择的图片
    $page = array(
        "page_name"  => $_REQUEST['page_name']?$_REQUEST['page_name']:'',
        "unique_id"  => $_REQUEST['unique_id']?$_REQUEST['unique_id']:'',
        "parent_id"  => $_REQUEST['parent_id']?$_REQUEST['parent_id']:'',
        "content"    => $_REQUEST['content']?$_REQUEST['content']:'',
        "keywords"   => $_REQUEST['keywords']?$_REQUEST['keywords']:'',
        "description"=> $_REQUEST['description']?$_REQUEST['description']:''
    );

    // 赋值给模板
    $smarty->assign('form_action', 'insert');
    $smarty->assign('page_list', $dou->get_page_nolevel());
    $smarty->assign('page', $page);//赋值用户输入的数据

    $smarty->display('page.htm');
} 

elseif ($rec == 'insert') {
    if (empty($_POST['page_name']))
        $dou->dou_msg($_LANG['page_name'] . $_LANG['is_empty']);
    // 上传banner生成
    $name = date('Ymd');
    for($i = 0; $i < 6; $i++) {
        $name .= chr(mt_rand(97, 122));
    }

    if(!empty($_FILES['banner']['name'])){//检查是否上传了banner，如果没有上传则为空
        $upfile = $img->upload_image('banner', $name); // 上传的文件域
        $file = $banner_dir . $upfile;
        $img->to_file = true;
        $img->make_thumb($upfile, 140, 36);
    }else{
        $file = "";
    }

    // CSRF防御令牌验证
    $firewall->check_token($_POST['token'], 'page_add');
    
    $sql = "INSERT INTO " . $dou->table('page') . " (id, unique_id, parent_id, page_name, content ,keywords, description, banner, type)" .
             " VALUES (NULL, '$_POST[unique_id]', '$_POST[parent_id]', '$_POST[page_name]', '$_POST[content]', '$_POST[keywords]', '$_POST[description]', '$file', '$_POST[page_type]')";
    $dou->query($sql);
    $miid = mysql_insert_id();
    $sql = "UPDATE " . $dou->table('page_images') . " SET page_id = '".$miid."' WHERE temp_num = '$_POST[page_temp_num]'";//将新建页面时增加的图片链接上该页面生成的id号
    $dou->query($sql);
    if (!$check->is_unique_id($_POST['unique_id'])) {
        $dou->dou_msg($_LANG['unique_id_wrong'].'<br />注意：不添加别名在URL重写模式下导航链接将出错!', 'page.php?rec=edit&id=' . $miid.'&temp_num='.$temp_num.'&page_id='.$miid, '', '5');
    }
    
    $dou->create_admin_log($_LANG['page_add'] . ': ' . $_POST[page_name]);
    $dou->dou_msg($_LANG['page_add_succes'], 'page.php');
} 

/**
 * +----------------------------------------------------------
 * 单页面编辑
 * +----------------------------------------------------------
 */
elseif ($rec == 'edit') {
    $smarty->assign('ur_here', $_LANG['page_edit']);
    $smarty->assign('action_link', array (
            'text' => $_LANG['page_list'],
            'href' => 'page.php' 
    ));
    
    // 验证并获取合法的ID
    $id = $check->is_number($_REQUEST['id']) ? $_REQUEST['id'] : '';
    
    $query = $dou->select($dou->table('page'), '*', '`id` = \'' . $id . '\'');
    $page = $dou->fetch_array($query);
    $banner = $page['banner']?ROOT_URL.$page['banner']:"";
    $banner_image = explode(".", $page['banner']);
    $banner_thumb = ROOT_URL . $banner_dir . $banner_thumb_dir . basename($page['banner'],'.'.$banner_image['1']) . "_thumb." . $banner_image['1'];
    // CSRF防御令牌生成
    $smarty->assign('token', $firewall->set_token('page_edit'));
    
    // 赋值给模板
    $smarty->assign('form_action', 'update');
    $smarty->assign('page_list', $dou->get_page_nolevel(0, 0, $id));
    $smarty->assign('page', $page);
    $smarty->assign('banner', $banner);
    $smarty->assign('banner_thumb', $banner_thumb);

    $smarty->display('page.htm');
} 

elseif ($rec == 'update') {
    if (empty($_POST['page_name']))
        $dou->dou_msg($_LANG['page_name'] . $_LANG['is_empty']);
    // 上传banner生成
    if ($_FILES['banner']['name'] != "") {
        // 分析图片名称
        $basename = basename($_POST['banner']);
        $file_name = substr($basename, 0, strrpos($basename, '.'));

        $upfile = $img->upload_image('banner', "$file_name"); // 上传的文件域
        $file = $banner_dir . $upfile;
        $img->to_file = true;
        $img->make_thumb($upfile, 140, 36);

        $up_file = ", banner='$file'";
    }
    // CSRF防御令牌验证
    $firewall->check_token($_POST['token'], 'page_edit');
    
    $sql = "UPDATE " . $dou->table('page') .
             " SET unique_id = '$_POST[unique_id]', parent_id = '$_POST[parent_id]'". $up_file .", page_name = '$_POST[page_name]', content = '$_POST[content]', keywords = '$_POST[keywords]', description = '$_POST[description]' WHERE id = '$_POST[id]'";
    $dou->query($sql);
    
    if (!$check->is_unique_id($_POST['unique_id'])) {
        $dou->dou_msg($_LANG['unique_id_wrong'], 'page.php?rec=edit&id=' . $_POST['id'], '', '5');
    }
    
    $dou->create_admin_log($_LANG['page_edit'] . ': ' . $_POST['page_name']);
    $dou->dou_msg($_LANG['page_edit_succes'], 'page.php', '', '3');
} 

/**
 * +----------------------------------------------------------
 * 单页面删除
 * +----------------------------------------------------------
 */
elseif ($rec == 'del') {
    // 验证并获取合法的ID
    $id = $check->is_number($_REQUEST['id']) ? $_REQUEST['id'] : $dou->dou_msg($_LANG['illegal'], 'page.php');
    
    $page_name = $dou->get_one("SELECT page_name FROM " . $dou->table('page') . " WHERE id = '$id'");
    $is_parent = $dou->get_one("SELECT id FROM " . $dou->table('page') . " WHERE parent_id = '$id'");
    
    if ($id == '1') {
        $dou->dou_msg($_LANG['page_del_wrong'], 'page.php', '', '3');
    } elseif ($is_parent) {
        $_LANG['page_del_is_parent'] = preg_replace('/d%/Ums', $page_name, $_LANG['page_del_is_parent']);
        $dou->dou_msg($_LANG['page_del_is_parent'], 'page.php', '', '3');
    } else {
        if (isset($_POST['confirm']) ? $_POST['confirm'] : '') {
            $dou->create_admin_log($_LANG['page_del'] . ': ' . $page_name);

            //删除banner图片
            $banner_url = $dou->get_one("SELECT banner FROM " . $dou->table('page') . "WHERE id = '$id'");
            $file_name = basename($banner_url);
            $banner = explode(".", $file_name);
            $banner_url_thumb = $banner_dir . $banner_thumb_dir . $banner['0'] . "_thumb." . $banner['1'];
            @ unlink(ROOT_PATH . $banner_url);
            @ unlink(ROOT_PATH . $banner_url_thumb);

            //删除相关的图片文件

            $images_dir = 'images/image_page/'; // 文件上传路径 结尾加斜杠
            $thumb_dir = 'thumb/'; // 缩略图路径（相对于$images_dir） 结尾加斜杠，留空则跟$images_dir相同
            $images = $dou->select($dou->table('page_images'), 'image_url', '`page_id` = \'' . $id . '\'');
            while($row = $dou->fetch_array($images)){
                $image_url = $row['image_url'];
                $file_name = basename($image_url);
                $image = explode(".", $file_name);
                $image_url_thumb = $images_dir . $thumb_dir . $image['0'] . "_thumb." . $image['1'];
                @ unlink(ROOT_PATH . $image_url);
                @ unlink(ROOT_PATH . $image_url_thumb);
            }

            $dou->delete($dou->table('page_images'),"page_id = $id");//删除相关的图片数据
            $dou->delete($dou->table('page'), "id = $id", 'page.php');
        } else {
            $_LANG['del_check'] = preg_replace('/d%/Ums', $page_name, $_LANG['del_check']);
            $dou->dou_msg($_LANG['del_check'], 'page.php', '', '30', "page.php?rec=del&id=$id");
        }
    }
}
?>