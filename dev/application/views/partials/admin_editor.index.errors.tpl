{if $error eq 'no_table'}
    <div class="ui-widget">
    	<div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
    		<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
    		<strong>Chyba:</strong> Nebola vybraná žiadna tabuľka na zobrazenie/úpravu.</p>
    	</div>
    </div>
{elseif $error eq 'disabled'}
    <div class="ui-widget">
    	<div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
    		<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
    		<strong>Chyba:</strong> Táto tabuľka sa nedá zobraziť v tomto režime.</p>
    	</div>
    </div>
{/if}
