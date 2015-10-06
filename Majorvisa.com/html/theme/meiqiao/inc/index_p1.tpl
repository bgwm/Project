<!-- {foreach from=$show_list name=show item=show} -->
<!-- {if $smarty.foreach.show.iteration eq 1} -->
<div id="demo01" class="flexslider" style="background: url({$show.show_img})">
<!-- {/if} -->
<!-- {/foreach} -->
        <ul class="slides">
        <li><div class="img"></div></li>
    </ul>
    <div class="nav_1"></div>
    <div class="nav_2">
        <div class="part1"><h1>关于美桥</h1><p>ABOUT US</p></div>
        <div class="part2">
            <p>{$description}</p>
        </div>
        <div style="float:right">
            <!-- {foreach  from=$nav_top_list name=nav_top_list item=nav} -->
            <!-- {if $smarty.foreach.nav_top_list.iteration eq 1} -->
            <a href="{$nav.url}" class="part3"><img width="45" height="45" src="images/part2-1.png"><p>{$nav.nav_name}</p></a>
            <!-- {/if} -->
            <!-- {if $smarty.foreach.nav_top_list.iteration eq 2} -->
            <a href="{$nav.url}" class="part3"><img width="45" height="45" src="images/part2-2.png"><p>{$nav.nav_name}</p></a>
            <!-- {/if} -->
            <!-- {if $smarty.foreach.nav_top_list.iteration eq 3} -->
            <a href="{$nav.url}" class="part3"><img width="45" height="45" src="images/part2-3.png"><p>{$nav.nav_name}</p></a>
            <!-- {/if} -->
            <!-- {if $smarty.foreach.nav_top_list.iteration eq 4} -->
            <a href="{$nav.url}" class="part3"><img width="45" height="45" src="images/part2-4.png"><p>{$nav.nav_name}</p></a>
            <!-- {/if} -->
            <!-- {/foreach} -->
        </div>
        </ul>
    </div>
</div><!--flexslider end-->

<script type="text/javascript" src="js/slider.js"></script>
<script type="text/javascript">
    {literal}
    $(function(){

        $('#demo01').flexslider({
            animation: "slide",
            direction:"horizontal",
            easing:"swing"
        });

    });
    {/literal}
</script>