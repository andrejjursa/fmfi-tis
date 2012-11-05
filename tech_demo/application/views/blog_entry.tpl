{extends file="blog_layout.tpl"}

{block name="content"}
    {if is_null($blog_entry) || is_null($blog_entry->getId())}
        <h2>Chyba!</h2>
        <div>
            Pozadovana sprava sa nenasla ...
        </div>
    {else}
        <h2>{$blog_entry->getTitle()|escape:"html"}</h2>
        <div style="border-bottom: 1px solid black; padding-bottom: 5px; margin-bottom: 5px;">{$blog_entry->getText()|escape:"html"|nl2br}</div>
        <h3>Komentare</h3>
        {foreach $blog_entry->getComments() as $blog_comment}
            <div>Autor: {$blog_comment->getAuthor()|escape:"html"} | {$blog_comment->getCrdate()|date_format:"%A - %e. %B %Y %H:%M:%S"}</div>
            <div style="border-bottom: 1px solid black; padding-bottom: 5px; margin-bottom: 5px;">{$blog_comment->getText()|escape:"html"|nl2br}</div>
        {/foreach}
        {form_errors}
        <form action="{$domain}index.php/blog/add_comment" method="post">
            <label>Meno autora:</label><br />
            <input type="text" name="comment[author]" value="{$smarty.post.comment.author|escape:"html"}" /><br />
            <label>Text:</label><br />
            <textarea name="comment[text]">{$smarty.post.comment.text|escape:"html"}</textarea><br />
            <input type="submit" value="Pridat komentar" />
            <input type="hidden" name="comment[blog_entry_id]" value="{$blog_entry->getId()|escape:"html"}" />
        </form>
    {/if}

{/block}