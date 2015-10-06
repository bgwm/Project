<div class="menu">
    <div class="logo"></div>
    <!--搜索-->
    <div class="top_left_tp">
        <img src="images/top-tel.gif">
        <p>留学梦想专线：</p>
        <p class="top-tel">{$site.tel}</p>
    </div>

    <ul id="nav">
        <!-- {foreach  from=$nav_middle_list name=nav_middle_list item=nav} -->
        <!-- {if $smarty.foreach.nav_middle_list.iteration ne 4} -->
        <li><a href="{$nav.url}">{$nav.nav_name}</a>
        <!-- {/if} -->
        <!-- {if $smarty.foreach.nav_middle_list.iteration eq 4} -->
        <li><a href="#">{$nav.nav_name}</a>
        <!-- {/if} -->
        <!-- {if $nav.child} -->
            <ul>
                <!-- {foreach from=$nav.child item=child} -->
                <li><a href="{$child.url}">{$child.nav_name}</a></li>
                <!-- {/foreach} -->
            </ul>
        <!-- {/if} -->
        </li>

        <!-- {/foreach} -->
    </ul>

</div><!--end-menu-->
