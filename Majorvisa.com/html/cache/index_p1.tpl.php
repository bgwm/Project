<?php /* Smarty version 2.6.26, created on 2015-07-14 12:00:25
         compiled from inc/index_p1.tpl */ ?>
<?php $_from = $this->_tpl_vars['show_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['show'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['show']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['show']):
        $this->_foreach['show']['iteration']++;
?>
<?php if ($this->_foreach['show']['iteration'] == 1): ?>
<div id="demo01" class="flexslider" style="background: url(<?php echo $this->_tpl_vars['show']['show_img']; ?>
)">
<?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
        <ul class="slides">
        <li><div class="img"></div></li>
    </ul>
    <div class="nav_1"></div>
    <div class="nav_2">
        <div class="part1"><h1>关于美桥</h1><p>ABOUT US</p></div>
        <div class="part2">
            <p><?php echo $this->_tpl_vars['description']; ?>
</p>
        </div>
        <div style="float:right">
            <?php $_from = $this->_tpl_vars['nav_top_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['nav_top_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['nav_top_list']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['nav']):
        $this->_foreach['nav_top_list']['iteration']++;
?>
            <?php if ($this->_foreach['nav_top_list']['iteration'] == 1): ?>
            <a href="<?php echo $this->_tpl_vars['nav']['url']; ?>
" class="part3"><img width="45" height="45" src="http://majorvisa.com/theme/meiqiao/images/part2-1.png"><p><?php echo $this->_tpl_vars['nav']['nav_name']; ?>
</p></a>
            <?php endif; ?>
            <?php if ($this->_foreach['nav_top_list']['iteration'] == 2): ?>
            <a href="<?php echo $this->_tpl_vars['nav']['url']; ?>
" class="part3"><img width="45" height="45" src="http://majorvisa.com/theme/meiqiao/images/part2-2.png"><p><?php echo $this->_tpl_vars['nav']['nav_name']; ?>
</p></a>
            <?php endif; ?>
            <?php if ($this->_foreach['nav_top_list']['iteration'] == 3): ?>
            <a href="<?php echo $this->_tpl_vars['nav']['url']; ?>
" class="part3"><img width="45" height="45" src="http://majorvisa.com/theme/meiqiao/images/part2-3.png"><p><?php echo $this->_tpl_vars['nav']['nav_name']; ?>
</p></a>
            <?php endif; ?>
            <?php if ($this->_foreach['nav_top_list']['iteration'] == 4): ?>
            <a href="<?php echo $this->_tpl_vars['nav']['url']; ?>
" class="part3"><img width="45" height="45" src="http://majorvisa.com/theme/meiqiao/images/part2-4.png"><p><?php echo $this->_tpl_vars['nav']['nav_name']; ?>
</p></a>
            <?php endif; ?>
            <?php endforeach; endif; unset($_from); ?>
        </div>
        </ul>
    </div>
</div><!--flexslider end-->

<script type="text/javascript" src="http://majorvisa.com/theme/meiqiao/js/slider.js"></script>
<script type="text/javascript">
    <?php echo '
    $(function(){

        $(\'#demo01\').flexslider({
            animation: "slide",
            direction:"horizontal",
            easing:"swing"
        });

    });
    '; ?>

</script>