<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<div class="pager">{$lang.pager_1} {$pager.record_count} {$lang.pager_2}，{$lang.pager_3} {$pager.page_count} {$lang.pager_4}，{$lang.pager_5} {$pager.page} {$lang.pager_4} |
    <a href="{$pager.first}">{$lang.pager_first}</a>
    <!-- {if $pager.page gt 1} -->
    <a href="{$pager.previous}">{$lang.pager_previous}</a>
    <!-- {else} -->
    {$lang.pager_previous}
    <!-- {/if} -->
    <!-- {if $pager.page lt $pager.page_count} -->
    <a href="{$pager.next}">{$lang.pager_next}</a>
    <!-- {else} -->
    {$lang.pager_next}
    <!-- {/if} -->
    <a href="{$pager.last}">{$lang.pager_last}</a>
</div>