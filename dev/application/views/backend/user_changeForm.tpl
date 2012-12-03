{extends file='layouts/backend.tpl'}

{block content}
    <div id="userChangeForm">
    {if isset($param1) && $param1 neq NULL}
        {if ($param1 eq "password" || $param1 eq "email")}
            <form id="changeForm" action="{createUri controller='user' action='proccesForm' params=[$param1]}" method="post">
                <div>
                    {if ($param1 == "password")}
                        <div class="userChangeForm-row">
                            Zmena hesla:
                        </div>
                        <div class="userChangeForm-row">
                            <div class="userChangeForm-row-text">Napíšte nové heslo</div>
                            <div class="userChangeForm-row-input">
                                <input type="password" name="{$param1}1" />
                            </div>
                        </div>
                        <div class="userChangeForm-row">
                            <div class="userChangeForm-row-text">Potvrdte nové heslo</div>
                            <div class="userChangeForm-row-input">
                                <input type="password" name="{$param1}2" />
                            </div>
                        </div>
                    {/if}    
                    {if ($param1 == "email")}
                        <div class="userChangeForm-row">
                            Zmena email-u:
                        </div>
                        <div class="userChangeForm-row">
                            <div class="userChangeForm-row-text">Zadajte nový email:</div>
                            <div class="userChangeForm-row-input">
                                <input type="text" name="{$param1}" />
                            </div>
                        </div>
                    {/if}
                </div>
                <div>
                    <input type="submit" value="Zmeniť" />
                </div>
            </form>
        {elseif ($param1 eq "success")}
            <div class="userChangeForm-row" style='color: green;'>
                {if ($param2 eq "password")}
                    Vaše heslo bolo zmenené.
                {/if}
                {if ($param2 eq "email")}
                    Váš email bol zmenený. Aktivujte si ho prosim. 
                {/if}
            </div>
        {elseif ($param1 eq "failed")}
            <div class="userChangeForm-row" style="color: red;">
                {if ($param2 eq "invalid-email")}
                    Zadali ste email v nesprávnom tvare.
                {elseif ($param2 eq "password-short")}
                    Prikrátke heslo, minimálne 5 znakov.
                {elseif ($param2 eq "password-mismatch")}
                    Zadané heslá sa nezhodujú.
                {else}    
                    Nedefinovaná chyba.
                {/if}
            </div>
        {/if}
    {else}
        <p>Neplatny vstup ....</p>
    {/if}
     </div>
{/block}