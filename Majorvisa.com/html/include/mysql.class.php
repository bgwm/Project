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
class DbMysql {
    private $dbhost; 
    private $dbuser; 
    private $dbpass; 
    private $dbname; 
    private $dou_link; 
    private $prefix; 
    private $charset; 
    private $pconnect;
    private $sql;
    private $result; 
    private $error_msg; 
                        

    function DbMysql($dbhost, $dbuser, $dbpass, $dbname = '', $prefix, $charset = 'utf8', $pconnect = 0) {
        $this->dbhost = $dbhost;
        $this->dbuser = $dbuser;
        $this->dbpass = $dbpass;
        $this->dbname = $dbname;
        $this->prefix = $prefix;
        $this->charset = strtolower(str_replace('-', '', $charset));
        $this->pconnect = $pconnect;
        $this->connect();
    }
    

    function connect() {
        if ($this->pconnect) {
            if (!$this->dou_link = @mysql_pconnect($this->dbhost, $this->dbuser, $this->dbpass)) {
                $this->error('Can not pconnect to mysql server');
                return false;
            }
        } else {
            if (!$this->dou_link = @mysql_connect($this->dbhost, $this->dbuser, $this->dbpass, true)) {
                $this->error('Can not connect to mysql server');
                return false;
            }
        }
        
        if ($this->version() > '4.1') {
            if ($this->charset) {
                $this->query("SET character_set_connection=" . $this->charset . ", character_set_results=" . $this->charset .
                         ", character_set_client=binary");
            }
            
            if ($this->version() > '5.0.1') {
                $this->query("SET sql_mode=''");
            }
        }
        
        if (mysql_select_db($this->dbname, $this->dou_link) === false) {
            $this->error("NO THIS DBNAME:" . $this->dbname);
            return false;
        }
    }
    

    function query($sql) {
        $this->sql = $sql;
        $query = mysql_query($this->sql, $this->dou_link);
        return $query;
    }
    
    
    function affected_rows() {
        return mysql_affected_rows();
    }
    
 
    function result($row = 0) {
        return @ mysql_result($this->result, $row);
    }
    
 
    function num_rows($query) {
        return @ mysql_num_rows($query);
    }
    

    function num_fields($query) {
        return mysql_num_fields($query);
    }
    
    
    function free_result() {
        return mysql_free_result($this->result);
    }
    
    
    function insert_id() {
        return mysql_insert_id();
    }
    
 
    function fetch_row($query) {
        return mysql_fetch_row($query);
    }
    

    function fetch_assoc($query) {
        return mysql_fetch_assoc($query);
    }
    
   
    function fetch_array($query) {
        return mysql_fetch_array($query);
    }
    

    function version() {
        if (empty($this->version)) {
            $this->version = mysql_get_server_info($this->dou_link);
        }
        return $this->version;
    }
    

    function close() {
        return mysql_close($this->dou_link);
    }
    

    function table($str) {
        return '`' . $this->prefix . $str . '`';
    }
    
   
    function select_all($table) {
        return $this->query("SELECT * FROM " . $this->table($table));
    }
    

    function select($table, $columnName = "*", $condition = '', $debug = '') {
        $condition = $condition ? ' Where ' . $condition : NULL;
        if ($debug) {
            echo "SELECT $columnName FROM $table $condition";
        } else {
            $query = $this->query("SELECT $columnName FROM $table $condition");
            return $query;
        }
    }
    
    
    function delete($table, $condition, $url = '', $out='') {
        if ($this->query("DELETE FROM $table WHERE $condition")) {
            if (!empty($url)) {
                $GLOBALS['dou']->dou_msg($GLOBALS['_LANG']['del_succes'], $url,$out);
            }
        }
    }
    

    function fn_insert($table, $column, $value) {
        $this->query("insert into $table ($column) value ($value)");
    }
    
   
    function get_one($sql, $limited = false) {
        if ($limited == true) {
            $sql = trim($sql . ' LIMIT 1');
        }
        
        $res = $this->query($sql);
        if ($res !== false) {
            $row = mysql_fetch_row($res);
            
            if ($row !== false) {
                return $row[0];
            } else {
                return '';
            }
        } else {
            return false;
        }
    }
    

    function escape_string($string) {
        if (PHP_VERSION >= '4.3') {
            return mysql_real_escape_string($string);
        } else {
            return mysql_escape_string($string);
        }
    }
    
    
    function fetch_array_all($table, $order_by = '') {
        $order_by = $order_by ? " ORDER BY " . $order_by : '';
        $query = $this->query("SELECT * FROM " . $this->table($table) . $order_by);
        while ($row = $this->fetch_assoc($query)) {
            $data[] = $row;
        }
        return $data;
    }
    

    function error($msg = '') {
        $msg = $msg ? "ZePHP Error: $msg" : '<b>MySQL server error report</b><br>' . $this->error_msg;
        exit($msg);
    }
}
?>