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
$images_dir = 'images/job/'; // 文件上传路径，结尾加斜杠
$thumb_dir = ''; // 缩略图路径（相对于$images_dir） 结尾加斜杠，留空则跟$images_dir相同
$img = new Upload(ROOT_PATH . $images_dir, $thumb_dir); // 实例化类文件
if (!file_exists(ROOT_PATH . $images_dir)) {
    mkdir(ROOT_PATH . $images_dir, 0777);
}

// 赋值给模板
$smarty->assign('rec', $rec);
$smarty->assign('cur', 'job');

/**
 * +----------------------------------------------------------
 * 文章列表
 * +----------------------------------------------------------
 */
if ($rec == 'default') {
    $smarty->assign('ur_here', $_LANG['job']);
    $smarty->assign('action_link', array (
            'text' => $_LANG['job_add'],
            'href' => 'job.php?rec=add'
    ));
    
    // 验证并获取合法的分类ID
    $cat_id = $check->is_number($_REQUEST['cat_id']) ? $_REQUEST['cat_id'] : '';
    
    $keyword = isset($_POST['keyword']) ? trim($_POST['keyword']) : '';
    
    if ($cat_id) {
        $child_id = $dou->dou_child_id($dou->fetch_array_all('job_category'), $cat_id);
        $where = " cat_id IN (" . $cat_id . $child_id . ") ";
    }
    if ($cat_id && $keyword)
        $where .= 'AND';
    if ($keyword)
        $where .= " title LIKE '%$keyword%' ";
    
    $where = $where ? ' WHERE' . $where : '';
    
    // 验证并获取合法的分页ID
    $page = $check->is_number($_REQUEST['page']) ? $_REQUEST['page'] : 1;
    $limit = $dou->pager('job', 15, $page, $cat_id, 'title', $keyword);
    
    $sql = "SELECT id, title, cat_id, image, add_time FROM " . $dou->table('job') . $where . "ORDER BY id DESC" . $limit;
    $query = $dou->query($sql);
    while ($row = $dou->fetch_array($query)) {
        $cat_name = $dou->get_one("SELECT cat_name FROM " . $dou->table('job_category') . " WHERE cat_id = '$row[cat_id]'");
        $add_time = date("Y-m-d", $row['add_time']);
        
        $job_list[] = array (
                "id" => $row['id'],
                "cat_id" => $row['cat_id'],
                "cat_name" => $cat_name,
                "title" => $row['title'],
                "image" => $row['image'],
                "add_time" => $add_time 
        );
    }
    
    // 首页显示文章数量限制框
    for($i = 1; $i <= $_CFG['home_display_job']; $i++) {
        $home_sort_bg .= "<li><em></em></li>";
    }
    
    // 赋值给模板
    $smarty->assign('if_home_sort', $_SESSION['if_home_sort']);
    $smarty->assign('home_sort', get_home_sort());
    $smarty->assign('home_sort_bg', $home_sort_bg);
    $smarty->assign('cat_id', $cat_id);
    $smarty->assign('keyword', $keyword);
    $smarty->assign('job_category', $dou->get_category_nolevel('job_category'));
    $smarty->assign('job_list', $job_list);
    
    $smarty->display('job.htm');
} 

/**
 * +----------------------------------------------------------
 * 文章添加
 * +----------------------------------------------------------
 */
elseif ($rec == 'add') {
    $smarty->assign('ur_here', $_LANG['job_add']);
    $smarty->assign('action_link', array (
            'text' => $_LANG['job'],
            'href' => 'job.php'
    ));



    // 格式化自定义参数，并存到数组$job，文章编辑页面中调用文章详情也是用数组$job，
    if ($_CFG['defined_job']) {
        $defined = explode(',', $_CFG['defined_job']);
        foreach ($defined as $row) {
            $defined_job .= $row . "：\n";
        }
        $job['defined'] = trim($defined_job);
        $job['defined_count'] = count(explode("\n", $job['defined'])) * 2;
    }

    // 验证并获取合法的分类ID
    $cat_id = $check->is_number($_REQUEST['cat_id']) ? $_REQUEST['cat_id'] : '';
    if ($cat_id){
        $query = $dou->select($dou->table('job_category'), 'template', '`cat_id` = \'' . $cat_id . '\'');
        $template = $dou->fetch_array($query);
        $job['template'] = $template[0];//载入招聘模板
        $job['cat_id'] = $cat_id;//如果选择了分类则把cat_id传递给模板
        $job['title'] = $_REQUEST['title']?$_REQUEST['title']:'';
        $job['defined'] = $_REQUEST['defined']?$_REQUEST['defined']:'';
        $job['image'] = $_REQUEST['image']?$_REQUEST['image']:'';
        $job['keywords'] = $_REQUEST['keywords']?$_REQUEST['keywords']:'';
        $job['description'] = $_REQUEST['description']?$_REQUEST['description']:'';
    }

    // CSRF防御令牌生成
    $smarty->assign('token', $firewall->set_token('job_add'));
    
    // 赋值给模板
    $smarty->assign('form_action', 'insert');
    $smarty->assign('job_category', $dou->get_category_nolevel('job_category'));
    $smarty->assign('job', $job);
    
    $smarty->display('job.htm');
} 

elseif ($rec == 'insert') {
    if (empty($_POST['title']))
        $dou->dou_msg($_LANG['job_name'] . $_LANG['is_empty']);
    
    // 判断是否有上传图片/上传图片生成
    if ($_FILES['image']['name'] != "") {
        // 生成图片文件名
        $file_name = date('Ymd');
        for($i = 0; $i < 6; $i++) {
            $file_name .= chr(mt_rand(97, 122));
        }
        
        // 其中image指的是上传的文本域名称，$file_name指的是生成的图片文件名
        $upfile = $img->upload_image('image', $file_name);
        $file = $images_dir . $upfile;
        // $img->make_thumb($upfile, 100, 100); // 生成缩略图
    }
    
    $add_time = time();
    
    // 格式化自定义参数
    $_POST['defined'] = str_replace("\r\n", ',', $_POST['defined']);
        
    // CSRF防御令牌验证
    $firewall->check_token($_POST['token'], 'job_add');
    
    $sql = "INSERT INTO " . $dou->table('job') . " (id, cat_id, title, defined, content, image ,keywords, add_time, description)" .
             " VALUES (NULL, '$_POST[cat_id]', '$_POST[title]', '$_POST[defined]', '$_POST[content]', '$file', '$_POST[keywords]', '$add_time', '$_POST[description]')";
    $dou->query($sql);
    
    $dou->create_admin_log($_LANG['job_add'] . ': ' . $_POST[title]);
    $dou->dou_msg($_LANG['job_add_succes'], 'job.php');
} 

/**
 * +----------------------------------------------------------
 * 文章编辑
 * +----------------------------------------------------------
 */
elseif ($rec == 'edit') {
    $smarty->assign('ur_here', $_LANG['job_edit']);
    $smarty->assign('action_link', array (
            'text' => $_LANG['job'],
            'href' => 'job.php'
    ));
    
    // 验证并获取合法的ID
    $id = $check->is_number($_REQUEST['id']) ? $_REQUEST['id'] : '';
    
    $query = $dou->select($dou->table('job'), '*', '`id` = \'' . $id . '\'');
    $job = $dou->fetch_array($query);
    
    // 格式化自定义参数
    if ($_CFG['defined_job'] || $job['defined']) {
        $defined = explode(',', $_CFG['defined_job']);
        foreach ($defined as $row) {
            $defined_job .= $row . "：\n";
        }
        // 如果文章中已经写入自定义参数则调用已有的
        $job['defined'] = $job['defined'] ? str_replace(",", "\n", $job['defined']) : trim($defined_job);
        $job['defined_count'] = count(explode("\n", $job['defined'])) * 2;
    }
    
    // CSRF防御令牌生成
    $smarty->assign('token', $firewall->set_token('job_edit'));
    
    // 赋值给模板
    $smarty->assign('form_action', 'update');
    $smarty->assign('job_category', $dou->get_category_nolevel('job_category'));
    $smarty->assign('job', $job);
    
    $smarty->display('job.htm');
} 

elseif ($rec == 'update') {
    if (empty($_POST['title']))
        $dou->dou_msg($_LANG['job_name'] . $_LANG['is_empty']);
    
    // 上传图片生成
    if ($_FILES['image']['name'] != "") {
        // 获取图片文件名
        $basename = basename($_POST['image']);
        $file_name = substr($basename, 0, strrpos($basename, '.'));
        
        $upfile = $img->upload_image('image', "$file_name"); // 上传的文件域
        $file = $images_dir . $upfile;
        // $img->make_thumb($upfile, 100, 100); // 生成缩略图
        
        $up_file = ", image='$file'";
    }
    
    // 格式化自定义参数
    $_POST['defined'] = str_replace("\r\n", ',', $_POST['defined']);
        
    // CSRF防御令牌验证
    $firewall->check_token($_POST['token'], 'job_edit');
    
    $sql = "UPDATE " . $dou->table('job') .
             " SET cat_id = '$_POST[cat_id]', title = '$_POST[title]', defined = '$_POST[defined]' ,content = '$_POST[content]'" . $up_file .
             ", keywords = '$_POST[keywords]', description = '$_POST[description]' WHERE id = '$_POST[id]'";
    $dou->query($sql);
    
    $dou->create_admin_log($_LANG['job_edit'] . ': ' . $_POST['title']);
    $dou->dou_msg($_LANG['job_edit_succes'], 'job.php');
} 

/**
 * +----------------------------------------------------------
 * 首页商品筛选
 * +----------------------------------------------------------
 */
elseif ($rec == 'home_sort') {
    $_SESSION['if_home_sort'] = $_SESSION['if_home_sort'] ? false : true;
    
    // 跳转到上一页面
    header("Location: " . $_SERVER['HTTP_REFERER']);
} 

/**
 * +----------------------------------------------------------
 * 设为首页显示商品
 * +----------------------------------------------------------
 */
elseif ($rec == 'set_home_sort') {
    // 验证并获取合法的ID
    $id = $check->is_number($_REQUEST['id']) ? $_REQUEST['id'] : $dou->dou_msg($_LANG['illegal'], 'job.php');
    
    $max_home_sort = $dou->get_one("SELECT home_sort FROM " . $dou->table('job') . " ORDER BY home_sort DESC");
    $new_home_sort = $max_home_sort + 1;
    $dou->query("UPDATE " . $dou->table('job') . " SET home_sort = '$new_home_sort' WHERE id = '$id'");
    
    header("Location: " . $_SERVER['HTTP_REFERER']);
} 

/**
 * +----------------------------------------------------------
 * 取消首页显示商品
 * +----------------------------------------------------------
 */
elseif ($rec == 'del_home_sort') {
    // 验证并获取合法的ID
    $id = $check->is_number($_REQUEST['id']) ? $_REQUEST['id'] : $dou->dou_msg($_LANG['illegal'], 'job.php');
    
    $dou->query("UPDATE " . $dou->table('job') . " SET home_sort = '' WHERE id = '$id'");
    
    header("Location: " . $_SERVER['HTTP_REFERER']);
} 

/**
 * +----------------------------------------------------------
 * 文章删除
 * +----------------------------------------------------------
 */
elseif ($rec == 'del') {
    // 验证并获取合法的ID
    $id = $check->is_number($_REQUEST['id']) ? $_REQUEST['id'] : $dou->dou_msg($_LANG['illegal'], 'job.php');
    
    if (isset($_POST['confirm']) ? $_POST['confirm'] : '') {
        // 删除相应商品图片
        $image = $dou->get_one("SELECT image FROM " . $dou->table('job') . " WHERE id = '$id'");
        $dou->del_image($image);
        
        $title = $dou->get_one("SELECT title FROM " . $dou->table('job') . " WHERE id = '$id'");
        $dou->create_admin_log($_LANG['job_del'] . ': ' . $title);
        $dou->delete($dou->table('job'), "id = $id", 'job.php');
    } else {
        $_LANG['del_check'] = preg_replace('/d%/Ums', $title, $_LANG['del_check']);
        $dou->dou_msg($_LANG['del_check'], 'job.php', '', '30', "job.php?rec=del&id=$id");
    }
} 

/**
 * +----------------------------------------------------------
 * 批量操作选择
 * +----------------------------------------------------------
 */
elseif ($rec == 'action') {
    if (is_array($_POST['checkbox'])) {
        if ($_POST['action'] == 'del_all') {
            // 批量文章删除
            $dou->del_all('job', $_POST['checkbox']);
        } elseif ($_POST['action'] == 'category_move') {
            // 批量移动分类
            $dou->category_move('job', $_POST['checkbox'], $_POST['new_cat_id']);
        } else {
            $dou->dou_msg($_LANG['select_empty']);
        }
    } else {
        $dou->dou_msg($_LANG['job_select_empty']);
    }
}

/**
 * +----------------------------------------------------------
 * 获取首页显示文章
 * +----------------------------------------------------------
 */
function get_home_sort() {
    $sql = "SELECT id, title FROM " . $GLOBALS['dou']->table('job') . " WHERE home_sort > 0 ORDER BY home_sort DESC";
    $query = $GLOBALS['dou']->query($sql);
    while ($row = $GLOBALS['dou']->fetch_array($query)) {
        $home_sort[] = array (
                "id" => $row['id'],
                "title" => $row['title'] 
        );
    }
    
    return $home_sort;
}
?>