<ul class="page-list">
    <!-- {foreach from=$article_list name=article_list item=article} -->
    <li>
        <a href="{$article.url}" class="list-a">{$article.title|truncate:30:"..."}</a>
        <p class="list-time">{$article.add_time}</p>
    </li>
    <!-- {/foreach} -->
</ul>