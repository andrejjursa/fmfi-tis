{if is_string($row->data($gridField->getField()))}
    {$file = $row->data($gridField->getField())}
{elseif is_object($row->data($gridField->getField()))}
    {if !is_null($gridField->getSubField())}
    {$file = $row->data($gridField->getField())}
    {$file = $file->data($gridField->getSubField()->getField())}
    {/if}
{/if}
{if !empty($file)}
    <div class="image_field"><a href="{imageThumb image=$file}" target="_blank" rel="fancybox"><img src="{imageThumb image=$file width=100 height=100}" alt="" /></a></div>
{/if}