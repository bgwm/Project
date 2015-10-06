<?php /* Smarty version 2.6.26, created on 2015-07-14 12:00:25
         compiled from inc/footer.tpl */ ?>
<div class="flooter_c">

    <div class="flooter_left links">
        <ul class="foot-left-tp">
            <?php $_from = $this->_tpl_vars['nav_middle_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['nav_top_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['nav_top_list']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['nav']):
        $this->_foreach['nav_top_list']['iteration']++;
?>
            <li class="link-title"><a href="<?php echo $this->_tpl_vars['nav']['url']; ?>
"><?php echo $this->_tpl_vars['nav']['nav_name']; ?>
</a></li>
            <?php endforeach; endif; unset($_from); ?>
        </ul>

        <div class="foot-left-bt">
            <p>关注我们：</p>
            <img src="http://majorvisa.com/theme/meiqiao/images/foot-left-1.png">
            <img src="http://majorvisa.com/theme/meiqiao/images/foot-left-2.png">
        </div>
    </div>

    <div class="flooter_right">
        <div class="flooter_con"></div>
        <p>您的专属留学移民机构</p>
        <p>TEL:<?php echo $this->_tpl_vars['site']['tel']; ?>
（服务热线）</p>
        <p>ADD:<?php echo $this->_tpl_vars['site']['site_address']; ?>
（中国）</p>
        <p class="copy" style="white-space:nowrap;"><?php echo $this->_tpl_vars['lang']['copyright']; ?>
</p>
    </div>
    <div class="clears"></div>
    <?php if ($this->_tpl_vars['site']['code']): ?>
    <div style="display:none"><?php echo $this->_tpl_vars['site']['code']; ?>
</div>
    <?php endif; ?>
</div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "inc/float.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>