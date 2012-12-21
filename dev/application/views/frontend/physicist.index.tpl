{extends file="layouts/frontend.tpl"}

{block name="content"}
<div id="text_content">
{if is_null($physicist->getId()) or $physicist->getDisplayed() eq 0}
    <div class="description">
        <p>Bohužiaľ, fyzik, ktorého hľadáte, nebol nájdený v databáze.</p>
        <p>Prosím, vrátte sa <a href="{createUri controller='timeline' action='index' params=[$year|default:'_', $current_period|default:'_']}">na časovú os</a> a nájdite iného fyzika.</p>
    </div>
{else}
    <h1 class="main_heading">{$physicist->getName()|escape:'html'}</h1>
    {if $physicist->getPhotoObject()}
    <div class="photo">
        <img class="photo" src="{imageThumb image=$physicist->getPhotoObject()->getFile() width=150 height=200}" alt="{$physicist->getName()|escape:'html'}" />
        <span class="phototitle">{$physicist->getPhotoObject()->getDescription()|escape:'html'}</span>
    </div>
    {/if}
    <div class="description">
        <p>({$physicist->getBirth_year()}{if $physicist->getDeath_Year() lt 9999} - {$physicist->getDeath_Year()}{/if})</p>
        {$physicist->getDescription()}
    </div>
    <div class="break_float"></div>
    <div class="images">
        {if $physicist->getPhotoObject() or count($physicist->getImages())}
        <div class="images_border">
            {if $physicist->getPhotoObject()}
            <a href="{imageThumb image=$physicist->getPhotoObject()->getFile()}" rel="fancybox" title="{$physicist->getPhotoObject()->getDescription()|escape:'html'}">
                <span class="image" style="background-image: url({imageThumb image=$physicist->getPhotoObject()->getFile() width=90 height=90});"></span>
            </a>
            {/if}
            {foreach $physicist->getImages() as $image}
            <a href="{imageThumb image=$image->getFile()}" rel="fancybox" title="{$image->getDescription()|escape:'html'}">
                <span class="image" style="background-image: url({imageThumb image=$image->getFile() width=90 height=90});"></span>
            </a>
            {/foreach}
        </div>
        {/if}
    </div>
    <div class="misc">
        <table class="misc"><tbody>
            <tr>
                <td class="relations">
                    <div class="widget">
                        <div class="widget_title">Vynálezy a objavy fyzika</div>
                        <div class="widget_content">
                            <div class="narrow_paragraphs">
                            {foreach $physicist->getInventions(TRUE) as $invention}
                            	<p><a href="{createUri controller='inventions' action='index' params=[$invention->getId(), $year, $current_period]}">{$invention->getName()}</a></p>
                             {foreachelse}
                                <p>Nenašli sa žiadne vynálezy a objavy.</p>
                            {/foreach}
                            </div>
                        </div>
                    </div>
                </td>
                <td class="miniapps">
                    <div class="widget">
                        <div class="widget_title">Miniaplikácie</div>
                        <div class="widget_content">
                            <div class="narrow_paragraphs">
                            {foreach $physicist->getMiniapps() as $miniapp}
                                <p><a href="{createUri controller='miniapps' action='index' params=[$miniapp->getId()]}" rel="fancybox_ajax">{$miniapp->getName()|escape:'html'}</a></p>
                            {foreachelse}
                                <p>Neboli pridané žiadne miniaplikácie.</p>
                            {/foreach}
                            </div>
                        </div>
                    </div>
                </td>
                <td class="links">
                    <div class="widget">
                        <div class="widget_title">Externé odkazy</div>
                        <div class="widget_content">
                            <div class="narrow_paragraphs">
                            {foreach $physicist->getLinksLabelsArray() as $link}
                                <p><a href="{$link.url}" target="_blank" class="external-link">{$link.label|default:'Nepomenovaný odkaz'|escape:'html'}</a></p>
                            {foreachelse}
                                <p>Neboli pridané žiadne externé odkazy.</p>
                            {/foreach}
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody></table>
    </div>
    {if $physicist->getHasTest()}
    <div class="test">
        <p>K tomuto fyzikovi boli pridané testovacie otázky.</p>
        <p><a id="doTestLink" href="{createUri controller='questions' action='index' params=[$physicist->getId()]}">Chcem sa otestovať</a></p>
    </div>
    {/if}
{/if}
</div>
{/block}
