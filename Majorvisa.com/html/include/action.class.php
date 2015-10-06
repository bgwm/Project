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
if (!defined('IN_DOUCO')) {
    die('Hacking attempt');
}
class Action extends Common {
    function get_config() {
        $query = $this->select_all('config');
        while ($row = $this->fetch_array($query)) {
            $config[$row['name']] = $row['value'];
        }
        return $config;
    }

    function get_nav($type = 'middle', $parent_id = 0, $current_module = '', $current_id = '', $current_parent_id = '') {
        $nav = array ();
        $data = $this->fetch_array_all('nav', 'sort ASC');
        foreach ((array) $data as $value) {
            if ($value['parent_id'] == $parent_id && $value['type'] == $type) {
                if ($value['module'] == 'nav') {
                    $value['url'] = $value['guide'];
      
                    $value['target'] = (strpos($value['guide'], 'http://') === 0 || strpos($value['guide'], 'https://') === 0) ? true : false;
                    $value['cur'] = strpos($_SERVER['PHP_SELF'], $value['guide']);
                } else {
                    $value['url'] = $this->rewrite_url($value['module'], $value['guide']);
                    $value['cur'] = $this->dou_current($value['module'], $value['guide'], $current_module, $current_id, $current_parent_id);
                }
                
                foreach ($data as $child) {
                    if ($child['parent_id'] == $value['id']) {
                        $value['child'] = $this->get_nav($type, $value['id']);
                        break;
                    }
                }
                $nav[] = $value;
            }
        }
        
        return $nav;
    }
    function dou_current($module, $id, $current_module, $current_id = '', $current_parent_id = '') {
        if (($id == $current_id || $id == $current_parent_id) && $module == $current_module) {
            return true;
        } elseif (!$id && $module == $current_module) {
            return true;
        }
    }
    function get_category($table, $parent_id = 0, $current_id = '') {
        $category = array ();
        $data = $this->fetch_array_all($table, 'sort ASC');
        foreach ((array) $data as $value) {

            if ($value['parent_id'] == $parent_id) {
                $value['url'] = $this->rewrite_url($table, $value['cat_id']);
                $value['cur'] = $value['cat_id'] == $current_id ? true : false;
                
                foreach ($data as $child) {
                   
                    if ($child['parent_id'] == $value['cat_id']) {
                       
                        $value['child'] = $this->get_category($table, $value['cat_id'], $current_id);
                        break;
                    }
                }
                $category[] = $value;
            }
        }
        
        return $category;
    }
    

    function get_article_list($cat_id = '', $num = '', $filter = '') {
        $where = $cat_id == 'ALL' ? '' : " WHERE cat_id IN (" . $cat_id .
                 $this->dou_child_id($this->fetch_array_all('article_category'), $cat_id) . ") ";
        $home_sort = ($filter == 'recommend') ? 'home_sort DESC,' : '';
        $limit = $num ? ' LIMIT ' . $num : '';
        
        $sql = "SELECT id, title, content, image, cat_id, add_time, click, description FROM " . $this->table('article') . $where . "ORDER BY " .
                 $home_sort . " id DESC" . $limit;
        $query = $this->query($sql);
        while ($row = $this->fetch_array($query)) {
            $url = $this->rewrite_url('article', $row['id']);
            $add_time = date("Y-m-d", $row['add_time']);
            $add_time_short = date("m-d", $row['add_time']);
            $image = $row['image'] ? ROOT_URL . $row['image'] : '';
            

            $description = $row['description'] ? $row['description'] : $this->dou_substr($row['content'], 200);
            
            $article_list[] = array (
                    "id" => $row['id'],
                    "cat_id" => $row['cat_id'],
                    "title" => $row['title'],
                    "image" => $image,
                    "add_time" => $add_time,
                    "add_time_short" => $add_time_short,
                    "click" => $row['click'],
                    "description" => $description,
                    "url" => $url 
            );
        }
        
        return $article_list;
    }

  
    function get_job_list($cat_id = '', $num = '', $filter = '') {
        $where = $cat_id == 'ALL' ? '' : " WHERE cat_id IN (" . $cat_id .
            $this->dou_child_id($this->fetch_array_all('job_category'), $cat_id) . ") ";
        $home_sort = ($filter == 'recommend') ? 'home_sort DESC,' : '';
        $limit = $num ? ' LIMIT ' . $num : '';

        $sql = "SELECT id, title, content, image, cat_id, add_time, click, description FROM " . $this->table('job') . $where . "ORDER BY " .
            $home_sort . " id DESC" . $limit;
        $query = $this->query($sql);
        while ($row = $this->fetch_array($query)) {
            $url = $this->rewrite_url('job', $row['id']);
            $add_time = date("Y-m-d", $row['add_time']);
            $add_time_short = date("m-d", $row['add_time']);
            $image = $row['image'] ? ROOT_URL . $row['image'] : '';

            
            $description = $row['description'] ? $row['description'] : $this->dou_substr($row['content'], 200);

            $job_list[] = array (
                "id" => $row['id'],
                "cat_id" => $row['cat_id'],
                "title" => $row['title'],
                "image" => $image,
                "add_time" => $add_time,
                "add_time_short" => $add_time_short,
                "click" => $row['click'],
                "description" => $description,
                "url" => $url
            );
        }

        return $job_list;
    }

   
    function get_product_list($cat_id = '', $num = '', $filter = '') {
        $where = $cat_id == 'ALL' ? '' : " WHERE cat_id IN (" . $cat_id .
                 $this->dou_child_id($this->fetch_array_all('product_category'), $cat_id) . ") ";
        $home_sort = ($filter == 'recommend') ? 'home_sort DESC,' : '';
        $limit = $num ? ' LIMIT ' . $num : '';
        
        $sql = "SELECT id, product_name, price, product_image FROM " . $this->table('product') . $where . "ORDER BY " . $home_sort . " id DESC" .
                 $limit;
        $query = $this->query($sql);
        while ($row = $this->fetch_array($query)) {
            $url = $this->rewrite_url('product', $row['id']);
            $image = explode(".", $row['product_image']);
            $thumb = ROOT_URL . $image[0] . "_thumb." . $image[1];
            $price = $row['price'] > 0 ? $this->price_format($row['price']) : $GLOBALS['_LANG']['price_discuss'];
            
            $product_list[] = array (
                    "id" => $row['id'],
                    "name" => $row['product_name'],
                    "price" => $price,
                    "thumb" => $thumb,
                    "url" => $url 
            );
        }
        
        return $product_list;
    }
    
   
    function get_page_list($parent_id = 0, $current_id = '') {
        $page_list = array ();
        $data = $this->fetch_array_all('page', 'id ASC');
        foreach ((array) $data as $value) {
            
            if ($value['parent_id'] == $parent_id) {
                $value['url'] = $this->rewrite_url('page', $value['id']);
                $value['cur'] = $value['id'] == $current_id ? true : false;
                
                foreach ($data as $child) {
                    
                    if ($child['parent_id'] == $value['id']) {
                       
                        $value['child'] = $this->get_page_list($value['id'], $current_id);
                        break;
                    }
                }
                $page_list[] = $value;
            }
        }
        
        return $page_list;
    }
    

    function ur_here($module, $cat_id = '', $title = '') {
       
        if ($module == 'onepage') {
            return "<li><a>".$title."</a></li>";
            exit();
        }
        

        $main = "<li><a href=" . $this->rewrite_url($module) . ">" . $GLOBALS['_LANG'][$module] . "</a></li>";
        
        
        if ($cat_id) {
            $cat_name = $this->get_one("SELECT cat_name FROM " . $this->table($module) . " WHERE cat_id = '" . $cat_id . "'");
            $main = "<li><a href=" . $this->rewrite_url($module) . ">" . $GLOBALS['_LANG'][$module] . "</a>&raquo;</li>";
            
            if ($title) {
                $category = "</li><li><a href=" . $this->rewrite_url($module, $cat_id) . ">" . $cat_name . "</a>&raquo;";
            } else {
                $category = "</li><li><a>".$cat_name."</a></li>";
            }
        }
        
        
        if ($title) {
            $title = "</li><li><a>". $title."</a></li>";
        }
        
        $ur_here = $main . $category . $title;
        
        return $ur_here;
    }

 
    function page_title($title, $module = '', $cat_id = '') {
        
        if ($module) {
            $main = $GLOBALS['_LANG'][$module] . ' | ';
            
           
            if ($cat_id) {
                $cat_name = $this->get_one("SELECT cat_name FROM " . $this->table($module) . " WHERE cat_id = '" . $cat_id . "'");
                $category = $cat_name . ' | ';
            }
        }
        
        if ($title)
            $title = $title . ' | ';
        
        $titles = $title . $category . $main;
        $page_title = ($titles ? $titles . $GLOBALS['_CFG']['site_name'] : $GLOBALS['_CFG']['site_title']) . '';
        
        return $page_title;
    }
    
  
    function dou_qq($im) {
        $im_explode = explode(',', $im);
        foreach ($im_explode as $value) {
            if (strpos($value, '/') !== false) {
                $arr = explode('/', $value);
                $list['number'] = $arr['0'];
                $list['nickname'] = $arr['1'];
                $im_list[] = $list;
            } else {
                $im_list[] = $value;
            }
        }
        
        return $im_list;
    }
    
 
    function is_mobile() {
        static $is_mobile;
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        
        if (isset($is_mobile))
            return $is_mobile;
        
        if (empty($user_agent)) {
            $is_mobile = false;
        } else {
            
            $mobile_agents = array (
                    'Mobile',
                    'Android',
                    'Silk/',
                    'Kindle',
                    'BlackBerry',
                    'Opera Mini',
                    'Opera Mobi' 
            );
            $is_mobile = false;
            
            foreach ($mobile_agents as $device) {
                if (strpos($user_agent, $device) !== false) {
                    $is_mobile = true;
                    break;
                }
            }
        }
        
        return $is_mobile;
    }
    
   
    function dou_substr($str, $length, $charset = DOU_CHARSET) {
        $str = trim($str); 
        $str = strip_tags($str, "");
        $str = preg_replace("/\t/", "", $str); 
        $str = preg_replace("/\r\n/", "", $str);
        $str = preg_replace("/\r/", "", $str);
        $str = preg_replace("/\n/", "", $str);
        $str = preg_replace("/ /", "", $str);
        $str = preg_replace("/&nbsp; /", "", $str); 
        $str = trim($str); 
        
        if (function_exists("mb_substr")) {
            $substr = mb_substr($str, 0, $length, $charset);
        } else {
            $c['utf-8'] = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
            $c['gbk'] = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
            preg_match_all($c[$charset], $str, $match);
            $substr = join("", array_slice($match[0], 0, $length));
        }
        
        return $substr;
    }
    
   
    function dou_msg($text, $url = '', $time = 3) {
        if (!$text) {
            $text = $GLOBALS['_LANG']['dou_msg_success'];
        }
        
       
        $GLOBALS['smarty']->assign('page_title', $GLOBALS['_CFG']['site_title']);
        $GLOBALS['smarty']->assign('keywords', $GLOBALS['_CFG']['site_keywords']);
        $GLOBALS['smarty']->assign('description', $GLOBALS['_CFG']['site_description']);
        
     
        $data = $this->fetch_array_all('nav', 'sort ASC');
        $GLOBALS['smarty']->assign('nav_top_list', $this->get_nav('top'));
        $GLOBALS['smarty']->assign('nav_middle_list', $this->get_nav('middle'));
        $GLOBALS['smarty']->assign('nav_bottom_list', $this->get_nav('bottom'));
        
      
        $GLOBALS['smarty']->assign('ur_here', $GLOBALS['_LANG']['dou_msg']);
        $GLOBALS['smarty']->assign('text', $text);
        $GLOBALS['smarty']->assign('url', $url);
        $GLOBALS['smarty']->assign('time', $time);
        
        
        $cue = preg_replace('/d%/Ums', $time, $GLOBALS['_LANG']['dou_msg_cue']);
        $GLOBALS['smarty']->assign('cue', $cue);
        
        $GLOBALS['smarty']->display('dou_msg.dwt');
        
        exit();
    }
}
?>