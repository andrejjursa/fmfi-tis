{extends file="layouts/frontend.tpl"}

{block name="content"}
<div id="text_content">
{if is_null($invention->getId()) or $invention->getDisplayed() eq 0}
    <div class="description">
        <p>Bohužiaľ, objav, ktorý hľadáte, nebol nájdený v databáze.</p>
        <p>Prosím, vrátte sa <a href="{createUri controller='timeline' action='index' params=[$year|default:'_', $current_period|default:'_']}">na časovú os</a> a nájdite iný objav.</p>
    </div>
{else}
    <h1 class="main_heading">{$invention->getName()|escape:'html'}</h1>
    {if $invention->getPhotoObject()}
    <div class="photo">
        <img class="photo" src="{imageThumb image=$invention->getPhotoObject()->getFile() width=150 height=200}" alt="{$invention->getName()|escape:'html'}" />
        <span class="phototitle">{$invention->getPhotoObject()->getDescription()|escape:'html'}</span>
    </div>
    <div class="description">
        <p>({$invention->getYear()})</p>
        {$invention->getDescription()}
    </div>
    <div class="break_float"></div>
    <div class="images">
        {if $invention->getPhotoObject() or count($invention->getImages())}
        <div class="images_border">
            {if $invention->getPhotoObject()}
            <a href="{imageThumb image=$invention->getPhotoObject()->getFile()}" rel="fancybox" title="{$invention->getPhotoObject()->getDescription()|escape:'html'}">
                <span class="image" style="background-image: url({imageThumb image=$invention->getPhotoObject()->getFile() width=90 height=90});"></span>
            </a>
            {/if}
            {foreach $invention->getImages() as $image}
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
                        <div class="widget_title">Fyzici podieľajúci sa na objave</div>
                        <div class="widget_content">
                            <div class="narrow_paragraphs">
                            {foreach $invention->getPhysicists(TRUE) as $physicist}
                            	<p><a href="{createUri controller='physicist' action='index' params=[$physicist->getId(), $year, $current_period]}">{$physicist->getName()}</a></p>
                             {foreachelse}
                                <p>Nenašli sa žiadny fyzici.</p>
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
                            {foreach $invention->getMiniapps() as $miniapp}
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
                            {foreach $invention->getLinksLabelsArray() as $link}
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
    {/if}
{/if}
</div>
{/block}