<div class="number_field">{$number = $row->data($gridField->getField())}
{if is_numeric($number)}
    {if intval($number) eq $number}
        {$number|intval}
    {else}
        {$number|number_format:3:'.':' '}
    {/if}
{else}
    {$number|intval}
{/if}
</div>