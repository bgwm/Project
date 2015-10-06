<?php /* Smarty version 2.6.26, created on 2015-07-14 12:00:24
         compiled from index.dwt */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="<?php echo $this->_tpl_vars['keywords']; ?>
" />
    <meta name="description" content="<?php echo $this->_tpl_vars['description']; ?>
" />
    <title><?php echo $this->_tpl_vars['page_title']; ?>
</title>
    <link rel="stylesheet" href="http://majorvisa.com/theme/meiqiao/css/global.css" type="text/css" />
    <link rel="stylesheet" href="http://majorvisa.com/theme/meiqiao/css/mb_base.css" type="text/css">
    <link rel="stylesheet" href="http://majorvisa.com/theme/meiqiao/css/mb_index.css" type="text/css">

    <script type="text/javascript" src="http://majorvisa.com/theme/meiqiao/js/jquery-1.7.1.js"></script>
    <script type="text/javascript" src="http://majorvisa.com/theme/meiqiao/js/index.js"></script>
    <script type="text/javascript" src="http://majorvisa.com/theme/meiqiao/js/jquery-1.js"></script>

    <script>
        <?php echo '
        //选项卡
        function setTab(m,n){
            var tli=document.getElementById("menu"+m).getElementsByTagName("li");
            var mli=document.getElementById("main"+m).getElementsByTagName("ul");
            for(i=0;i       <tli.length;i++){
                tli[i].className=i==n?"hover":"";
                mli[i].style.display=i==n?"block":"none";
            }
        }
        '; ?>

    </script>
</head>

<body>

<!------header------>
<div class="head">

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc/header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

    <div class="clears"></div>
</div><!--end-header-->
<div class="clears"></div>

<!-----------banner------------>
<div class="banner">
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc/index_p1.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div><!--end-banner-->


<div class="fgx3"></div><!---大标题--->

<div class="conter" style="height:350px">
<div class="index_x w">

<div class="tabbox w1000 bc mt30">

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc/index_p2.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

</div>
</div>
</div>
</div>
</div><!--end-conter-->


<!--底部-->
<div class="flooter">
    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc/footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>
</body>
</html>