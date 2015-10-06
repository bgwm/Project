<!-- {foreach from=$article_list name=article_list item=article} -->
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table_list">
    <tr>
        <td valign="top" width="725"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="table_list">
            <tr>
                <td width="135"><img src="{$article.image}" width="117" height="117"></td>

                <td valign="top" width="725"><div class="title_car"><a href="{$article.url}" class="name">{$article.title|truncate:30:"..."}</a>
                    <div class="news-time">{$article.add_time}</div>
                </div>
                    <div class="conpname"><h4>{$article.description}</h4></a>
                    </div>
                <td align="right"><a href="{$article.url}" class="green_a">查看详情>></a></td>
            </tr>
        </table>
    </tr>
</table>
<!-- {/foreach} -->