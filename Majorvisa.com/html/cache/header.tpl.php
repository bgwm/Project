<?php /* Smarty version 2.6.26, created on 2015-07-14 12:00:24
         compiled from inc/header.tpl */ ?>
<div class="menu">
    <div class="logo"></div>
    <!--搜索-->
    <div class="top_left_tp">
        <img src="http://majorvisa.com/theme/meiqiao/images/top-tel.gif">
        <p>留学梦想专线：</p>
        <p class="top-tel"><?php echo $this->_tpl_vars['site']['tel']; ?>
</p>
    </div>

    <ul id="nav">
        <?php $_from = $this->_tpl_vars['nav_middle_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['nav_middle_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['nav_middle_list']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['nav']):
        $this->_foreach['nav_middle_list']['iteration']++;
?>
        <?php if ($this->_foreach['nav_middle_list']['iteration'] != 4): ?>
        <li><a href="<?php echo $this->_tpl_vars['nav']['url']; ?>
"><?php echo $this->_tpl_vars['nav']['nav_name']; ?>
</a>
        <?php endif; ?>
        <?php if ($this->_foreach['nav_middle_list']['iteration'] == 4): ?>
        <li><a href="#"><?php echo $this->_tpl_vars['nav']['nav_name']; ?>
</a>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['nav']['child']): ?>
            <ul>
                <?php $_from = $this->_tpl_vars['nav']['child']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['child']):
?>
                <li><a href="<?php echo $this->_tpl_vars['child']['url']; ?>
"><?php echo $this->_tpl_vars['child']['nav_name']; ?>
</a></li>
                <?php endforeach; endif; unset($_from); ?>
            </ul>
        <?php endif; ?>
        </li>

        <?php endforeach; endif; unset($_from); ?>
    </ul>

</div><!--end-menu-->