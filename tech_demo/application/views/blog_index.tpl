{extends file="blog_layout.tpl"}

{block name="content"}
    <h2>Zoznam sprav</h2>
    {foreach $blog_entries as $blog_entry}
        <h3>{$blog_entry->getTitle()|escape:"html"}</h3>
        <div>
            {$blog_entry->getText()|escape:"html"|nl2br}
        </div>
        <div>
            {foreach $blog_entry->getTags() as $tag}
                <span style="border-right: 1px solid black; padding-right: 3px;">{$tag->getName()|escape:"html"}</span>
            {foreachelse}
                <span>Nie su priradene ziadne tagy ...</span>
            {/foreach}
        </div>
        <div>
            Pocet komentarov: {$blog_entry->getCommentsCount()|escape:"html"}
        </div>
        <div style="border-bottom: 1px solid black; padding-bottom: 5px; margin-bottom: 5px;">
            <a href="{$domain}index.php/blog/entry/id/{$blog_entry->getId()}">Zobraz viacej ...</a>
        </div>
    {/foreach}
{/block}