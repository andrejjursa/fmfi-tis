{extends file='layouts/backend.tpl'}

{block content}
<h1>Nastavenia používateľa</h1>
    <div id="userChangeForm">
    {if isset($param1) && $param1 neq NULL}
        {if ($param1 eq "password" || $param1 eq "email")}
            <form id="changeForm" action="{createUri controller='user' action='proccesForm' params=[$param1]}" method="post">
                <div>
                    {if ($param1 == "password")}
					<fieldset class="logs">
					<legend>Zmena hesla</legend>
					
						<div class="row">
							<div class="label">Nové heslo:</div>
							<div class="content"><input type="password" name="{$param1}1" /></div>
						</div>
						
						<div class="row">
							<div class="label">Potvrďte nové heslo:</div>
							<div class="content"><input type="password" name="{$param1}2" /></div>
						</div>
						

                        {if isset($param2) && $param2 eq "password-short"}
						
						<div class="row">
							<div class="label">Chyba:</div>
							<div class="content"  style="color: red;">Heslo je príliš krátke. Minimálna dĺžka sú 4 znaky.</div>
						</div>						

                        {/if}
                        {if isset($param2) && $param2 eq "password-mismatch"}
												
						<div class="row">
							<div class="label">Chyba:</div>
							<div class="content"  style="color: red;">Heslá sa nezhodujú.</div>
						</div>						

                        {/if}
						<div class="row">
							<div class="content"><input type="submit" value="Zmeniť" /></div>
						</div>	
					{/if}  
			
					
					</fieldset>
                    {if ($param1 == "email")}
					<fieldset class="logs">
                        <legend>Zmena email-u</legend>
						
						<div class="row">
							<div class="label">Nový e-mail:</div>
							<div class="content"><input type="text" name="{$param1}" /></div>
						</div>						

                        {if isset($param2) && $param2 eq "invalid-email"}
						
						<div class="row">
							<div class="label">Chyba:</div>
							<div class="content"  style="color: red;">Zadali ste nesprávny e-mail.</div>
						</div>								

                        {/if}
						<div class="row">
							<div class="content"><input type="submit" value="Zmeniť" /></div>
						</div>	
					{/if}
				
					</fieldset>
                </div>
            </form>
			
        {elseif ($param1 eq "success")}
		<fieldset class="logs">
            <legend>Zmena nastavení</legend>		
			<div class="row">
			{if ($param2 eq "password")}
				<div class="label">OK:</div>
				<div class="content"  style="color: green;">Vaše heslo bolo zmenené.</div>
			{elseif ($param2 eq "email")}
				<div class="label">OK:</div>
				<div class="content"  style="color: green;">Na Váš email bola zaslaná overovacia správa.</div>	
			{elseif ($param2 eq "email2")}
				<div class="label">OK:</div>
				<div class="content"  style="color: green;">Váš email bo úspešne zmenený.</div>	
			{else}
				<div class="label">Chyba:</div>
				<div class="content"  style="color: red;">Neplatný vstup!</div>
			{/if}
			</div>		
		</fieldset>
             
        {elseif ($param1 eq "failure")}
		<fieldset class="logs">
            <legend>Zmena nastavení</legend>			
			<div class="row">
				<div class="label">Chyba:</div>
				<div class="content"  style="color: red;">
                {if ($param2 eq "email")}
                    Vyskytla sa chyba, heslo nebolo zmenené!
                {elseif ($param2 eq "email2")}
                    Nesprávne overovacie údaje!
                {else}		
					Neplatný vstup!
				{/if}	
				</div>
			</div>  
		</fieldset>		
        {/if}
    {else}
	<fieldset class="logs">
        <legend>Chyba!</legend>	
			<div class="row">
				<div class="label">Chyba:</div>
				<div class="content"  style="color: red;">Neplatný vstup1!</div>
			</div>	
	</fieldset>		
    {/if}
     </div>

{/block}