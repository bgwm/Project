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
class Firewall {

    function dou_firewall() {
  
        $this->dou_magic_quotes();
    }
    
 
    function dou_magic_quotes() {
        if (!@ get_magic_quotes_gpc()) {
            $_GET = $_GET ? $this->addslashes_deep($_GET) : '';
            $_POST = $_POST ? $this->addslashes_deep($_POST) : '';
            $_COOKIE = $this->addslashes_deep($_COOKIE);
            $_REQUEST = $this->addslashes_deep($_REQUEST);
        }
    }
    

    function addslashes_deep($value) {
        if (empty($value)) {
            return $value;
        }
        
        if (is_array($value)) {
            foreach ((array) $value as $k => $v) {
                unset($value[$k]);
                $k = addslashes($k);
                if (is_array($v)) {
                    $value[$k] = $this->addslashes_deep($v);
                } else {
                    $value[$k] = addslashes($v);
                }
            }
        } else {
            $value = addslashes($value);
        }
        
        return $value;
    }
    

    function stripslashes_deep($value) {
        if (empty($value)) {
            return $value;
        }
        
        if (is_array($value)) {
            foreach ((array) $value as $k => $v) {
                unset($value[$k]);
                $k = stripslashes($k);
                if (is_array($v)) {
                    $value[$k] = $this->stripslashes_deep($v);
                } else {
                    $value[$k] = stripslashes($v);
                }
            }
        } else {
            $value = stripslashes($value);
        }
        return $value;
    }
    

    function dou_filter($value) {
        if (is_array($value)) {
            foreach ($value as $k => $v) {
                $value[$k] = htmlspecialchars($v, ENT_NOQUOTES);
            }
        } else {
           
            $value = htmlspecialchars($value, ENT_NOQUOTES);
        }
        
        return $value;
    }
    

    function set_token($cur) {
        $token = md5(uniqid(rand(), true));
        $n = rand(1, 24);
								return $_SESSION[DOU_ID]['token'][$cur] = substr($token, $n, 8);
    }
    
 
    function check_token($token, $cur) {
        if (isset($_SESSION[DOU_ID]['token'][$cur]) && $token == $_SESSION[DOU_ID]['token'][$cur]) {
            unset($_SESSION[DOU_ID]['token'][$cur]);
            return true;
        } else {
            unset($_SESSION[DOU_ID]['token'][$cur]);
            header('Content-type: text/html; charset=' . DOU_CHARSET);
            echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">" . $GLOBALS['_LANG']['illegal'];
            exit();
        }
    }
    
  
    function get_legal_id($module, $id = '', $unique_id = '') {
      
        if ((isset($id) && !$GLOBALS['check']->is_number($id)) || (isset($unique_id) && !$GLOBALS['check']->is_unique_id($unique_id)))
            return -1;
        
        if (isset($unique_id)) {
            if ($module == 'page') {
                $get_id = $GLOBALS['dou']->get_one("SELECT id FROM " . $GLOBALS['dou']->table($module) . " WHERE unique_id = '$unique_id'");
            } else {
                if (isset($id)) {
                    $system_unique_id = $GLOBALS['dou']->get_one("SELECT c.unique_id FROM " . $GLOBALS['dou']->table($module . '_category') .
                             " AS c LEFT JOIN " . $GLOBALS['dou']->table($module) . " AS i ON id = '$id' WHERE c.cat_id = i.cat_id");
                    $get_id = $system_unique_id == $unique_id ? $id : '';
                } else {
                    $get_id = $GLOBALS['dou']->get_one("SELECT cat_id FROM " . $GLOBALS['dou']->table($module) . " WHERE unique_id = '$unique_id'");
                }
            }
        } else {
            if (isset($id)) {
                if (strpos($module, 'category')) {
                    $get_id = $GLOBALS['dou']->get_one("SELECT cat_id FROM " . $GLOBALS['dou']->table($module) . " WHERE cat_id = '$id'");
                } else {
                    $get_id = $GLOBALS['dou']->get_one("SELECT id FROM " . $GLOBALS['dou']->table($module) . " WHERE id = '$id'");
                }
            } else {
              
                return strpos($module, 'category') ? 0 : -1;
            }
        }
        
        $legal_id = $get_id ? $get_id : -1;
        
        return $legal_id;
    }
}
?>