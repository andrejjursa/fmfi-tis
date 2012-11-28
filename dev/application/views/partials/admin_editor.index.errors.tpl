{if $error eq 'no_table'}
    <div class="ui-widget">
    	<div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
    		<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
    		<strong>Chyba:</strong> Nebola vybraná žiadna tabuľka na zobrazenie/úpravu.</p>
    	</div>
    </div>
{elseif $error eq 'no_field'}
    <div class="ui-widget">
    	<div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
    		<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
    		<strong>Chyba:</strong> Požadovaná položka sa nedá nájsť.</p>
    	</div>
    </div>
{elseif $error eq 'disabled'}
    <div class="ui-widget">
    	<div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
    		<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
    		<strong>Chyba:</strong> Táto tabuľka sa nedá zobraziť v tomto režime.</p>
    	</div>
    </div>
{elseif $error eq 'no_new_record'}
    <div class="ui-widget">
    	<div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
    		<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
    		<strong>Chyba:</strong> Táto tabuľka nemá povolené vytvárať nové záznamy.</p>
    	</div>
    </div>
{elseif $error eq 'no_edit_record'}
    <div class="ui-widget">
    	<div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
    		<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
    		<strong>Chyba:</strong> Táto tabuľka nemá povolené upravovať existujúce záznamy.</p>
    	</div>
    </div>
{elseif $error eq 'cannot_save_data'}
    <div class="ui-widget">
    	<div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
    		<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
    		<strong>Chyba:</strong> Nepodarilo sa uložiť dáta.</p>
    	</div>
    </div>
{elseif $error eq 'unknown_record'}
    <div class="ui-widget">
    	<div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
    		<p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
    		<strong>Chyba:</strong> Nepodarilo sa nájsť záznam.</p>
    	</div>
    </div>
{/if}
