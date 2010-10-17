
<h1>Posts</h1>
{render_element element="messages"}
<a href="/tags/tag_manager/create">Create</a> new tag
<br><br>
<ul style="margin: 0px; padding: 0px; " >

{foreach from="$tags" item="tag"}
<li style="list-style-type: none; background-color: {cycle values="#eeeeee,#d0d0d0"}">
    <a href="/tags/tag_manager/read/{$tag->oid}">{$tag}</a> - 
    <a href="/tags/tag_manager/update/{$tag->oid}">Update</a> - 
    <a href="/tags/tag_manager/delete/{$tag->oid}">Delete</a>
</li>
{/foreach}
</ul>
<br>
{* display the page links *}
{if $total_num_pages>0}
    {counter assign="i" start=$first_page_link}
    {if $first_page_link!=1 && $num_page_links_visible<$total_num_pages}
    <a href="/tags/tag_manager/listall/1/{$num_per_page}/{$num_page_links_visible}">&lt;&lt;</a>&nbsp;
    <a href="/tags/tag_manager/listall/{$current_page-1}/{$num_per_page}/{$num_page_links_visible}">&lt;</a>&nbsp;
    {/if}
    {foreach from=$page_nums item="page_num"}

    {if $page_num==$current_page}
    {$page_num}{if $i!=$last_page_link}&nbsp;-&nbsp;{/if}
    {else}
    <a title="Page {$page_num}" href="/tags/tag_manager/listall/{$page_num}/{$num_per_page}/{$num_page_links_visible}">{$page_num}</a>{if $i!=$last_page_link}&nbsp;-&nbsp;{/if}
    {/if}
    {counter}
    {/foreach}
    {if $last_page_link!=$total_num_pages}
    &nbsp;<a href="/tags/tag_manager/listall/{$current_page+1}/{$num_per_page}/{$num_page_links_visible}">&gt;</a>&nbsp;
    <a href="/tags/tag_manager/listall/{$total_num_pages}/{$num_per_page}/{$num_page_links_visible}">&gt;&gt;</a>&nbsp;
    {/if}
{/if}
        