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
$page_id = $_REQUEST['page_id']?$_REQUEST['page_id']:'';
if(!$_REQUEST['temp_num']){
    //$dou->dou_msg("临时图片编码未找到！",image.php);
    echo "<script>alert(" . "'临时图片编码未找到,请刷新页面'" . ");self.parent.location='page.php';</script>";//此句有BUG，但一般运行不到此句
    exit;
}else{
    $temp_num=$_REQUEST['temp_num'];
}


// 图片上传
include_once (ROOT_PATH . 'include/upload.class.php');
$images_dir = 'images/image_page/'; // 文件上传路径 结尾加斜杠
$thumb_dir = 'thumb/'; // 缩略图路径（相对于$images_dir） 结尾加斜杠，留空则跟$images_dir相同
$img = new Upload(ROOT_PATH . $images_dir, $thumb_dir); // 实例化类文件


// 赋值给模板
$smarty->assign('rec', $rec);
$smarty->assign('cur', 'image');
$smarty->assign('ur_here','图片页添加');// $_LANG['show']);
$smarty->assign('image_list', $dou->get_page_image_list($page_id,$temp_num));//获取当前id的页面下的图片文件（$page_id检索)以及当前页面下的临时文件($temp_num获取)
$smarty->assign('temp_num', $temp_num);//给页面传递接收到的temp_num
$smarty->assign('page_id', $page_id);//给页面传递当前的page_id,如果是新建（即没有page_id,则为0）,新建的情况在page的add时使用temp_id统一链接新生成的编号。

/**
 * +----------------------------------------------------------
 * 图片列表
 * +----------------------------------------------------------
 */
if ($rec == 'default') {
    // CSRF防御令牌生成
    $smarty->assign('token', $firewall->set_token('image_add'));

    $smarty->display('image.htm');
}

/**
 * +----------------------------------------------------------
 * 图片添加处理
 * +----------------------------------------------------------
 */
elseif ($rec == 'insert') {
    if (empty($_POST['image_name']))
        $dou->dou_msg('图片名称' . $_LANG['is_empty'],'image.php?temp_num='.$temp_num.'&page_id='.$page_id,'out');

    // 上传图片生成
    $name = date('Ymd');
    for($i = 0; $i < 6; $i++) {
        $name .= chr(mt_rand(97, 122));
    }

    $upfile = $img->upload_image('image_img', $name); // 上传的文件域
    $file = $images_dir . $upfile;
    $img->to_file = true;
    //统一标准缩放图片
    $img_size = $dou->get_image_size(ROOT_URL.$file, $_CFG['thumb_width'], $_CFG['thumb_height']);
    $img->make_thumb($upfile, $img_size['width'], $img_size['height'],false,100,false);
    //$img->make_thumb($upfile, $_CFG['thumb_width'], $_CFG['thumb_height'] );

    // CSRF防御令牌验证
    $firewall->check_token($_POST['token'], 'image_add');

    $sql = "INSERT INTO " . $dou->table('page_images') . " (id, name, image_link, image_url, temp_num, page_id, sort)" .
        " VALUES (NULL, '$_POST[image_name]', '$_POST[image_link]', '$file', '$temp_num' , '$page_id', '$_POST[sort]')";//如果是已有的页面新增，则新增时间会直接写入page_id值
    $dou->query($sql);

    $dou->create_admin_log('添加图片页图片' . ': ' . $_POST[image_name]);
    $dou->dou_msg('添加图片页图片成功', 'image.php?temp_num='.$temp_num.'&page_id='.$page_id,'out');//添加成功后的跳转要继续传回temp_num,加out则不会显示整个后台的模板
}

/**
 * +----------------------------------------------------------
 * 图片编辑
 * +----------------------------------------------------------
 */
elseif ($rec == 'edit') {
    // 验证并获取合法的ID
    $id = $check->is_number($_REQUEST['id']) ? $_REQUEST['id'] : '';

    $query = $dou->select($dou->table('page_images'), '*', '`id` = \'' . $id . '\'');
    $image = $dou->fetch_array($query);
    //print_r($image);

    // CSRF防御令牌生成
    $smarty->assign('token', $firewall->set_token('image_edit'));

    // 赋值给模板
    $smarty->assign('id', $id);
    $smarty->assign('image', $image);

    $smarty->display('image.htm');
}

elseif ($rec == 'update') {
    if (empty($_POST['image_name']))
        //$dou->dou_msg($_LANG['show_name'] . $_LANG['is_empty']);
        $dou->dou_msg('图片名称' . $_LANG['is_empty'],'image.php?temp_num='.$temp_num.'&page_id='.$page_id,'out');
    // 上传图片生成
    if ($_FILES['image_img']['name'] != "") {
        // 分析图片名称
        $basename = basename($_POST['image_img']);
        $file_name = substr($basename, 0, strrpos($basename, '.'));

        $upfile = $img->upload_image('image_img', "$file_name"); // 上传的文件域
        $file = $images_dir . $upfile;
        $img->to_file = true;
        //统一标准缩放图片
        $img_size = $dou->get_image_size($file, $_CFG['thumb_width'], $_CFG['thumb_height']);
        $img->make_thumb($upfile, $img_size['width'], $img_size['height'],false,100,false);
        //$img->make_thumb($upfile, $img_size['width'], $img_size['height'] );

        $up_file = ", image_url='$file'";
    }

    // CSRF防御令牌验证
    $firewall->check_token($_POST['token'], 'image_edit');

    $sql = "update " . $dou->table('page_images') . " SET name='$_POST[image_name]'" . $up_file .
        " ,image_link = '$_POST[image_link]', sort = '$_POST[sort]' WHERE id = '$_POST[id]'";
    $dou->query($sql);

    $dou->create_admin_log('编辑图片页图片' . ': ' . $_POST[name]);

    $dou->dou_msg('编辑图片页图片成功', 'image.php?temp_num='.$temp_num.'&page_id='.$page_id,'out');//更新成功后的跳转要继续传回temp_num
}

/**
 * +----------------------------------------------------------
 * 图片删除
 * +----------------------------------------------------------
 */
elseif ($rec == 'del') {
    // 验证并获取合法的ID
    $id = $check->is_number($_REQUEST['id']) ? $_REQUEST['id'] : $dou->dou_msg($_LANG['illegal'], 'image.php', 'out');

    $image_name = $dou->get_one("SELECT name FROM " . $dou->table('page_images') . " WHERE id = '$id'");

    if (isset($_POST['confirm']) ? $_POST['confirm'] : '') {
        // 删除相应商品图片
        $image_url = $dou->get_one("SELECT image_url FROM " . $dou->table('page_images') . " WHERE id = '$id'");
        $file_name = basename($image_url);
        $image = explode(".", $file_name);
        $image_url_thumb = $images_dir . $thumb_dir . $image['0'] . "_thumb." . $image['1'];
        @ unlink(ROOT_PATH . $image_url);
        @ unlink(ROOT_PATH . $image_url_thumb);

        $dou->create_admin_log('删除图片' . ': ' . $image_name);
        $dou->delete($dou->table('page_images'), "id = $id", 'image.php?temp_num='.$temp_num.'&page_id='.$page_id,'out');
    } else {
        $_LANG['del_check'] = preg_replace('/d%/Ums', $image_name, $_LANG['del_check']);
        $dou->dou_msg($_LANG['del_check'], 'image.php?temp_num=$temp_num&page_id=$page_id', 'out', '30', "image.php?rec=del&id=$id&temp_num=$temp_num&page_id=$page_id");
    }
}

?>