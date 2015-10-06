<div class="flooter_c">

    <div class="flooter_left links">
        <ul class="foot-left-tp">
            <!-- {foreach  from=$nav_middle_list name=nav_top_list item=nav} -->
            <li class="link-title"><a href="{$nav.url}">{$nav.nav_name}</a></li>
            <!-- {/foreach} -->
        </ul>

        <div class="foot-left-bt">
            <p>关注我们：</p>
            <img src="images/foot-left-1.png">
            <img src="images/foot-left-2.png">
        </div>
    </div>

    <div class="flooter_right">
        <div class="flooter_con"></div>
        <p>您的专属留学移民机构</p>
        <p>TEL:{$site.tel}（服务热线）</p>
        <p>ADD:{$site.site_address}（中国）</p>
        <p class="copy" style="white-space:nowrap;">{$lang.copyright}</p>
    </div>
    <div class="clears"></div>
    <!-- {if $site.code} -->
    <div style="display:none">{$site.code}</div>
    <!-- {/if} -->
</div>
{include file="inc/float.tpl"}