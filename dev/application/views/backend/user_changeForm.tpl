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
                        {if isset($param2) && $param2 eq "password-short"}
                            <div class="userChangeForm-row">
                                <div class="userChangeForm-row-text" style="color: red;">
                                    Heslo je prikratke. Minimalna dlzka su 4 znaky.
                                </div>
                            </div>
                        {/if}
                        {if isset($param2) && $param2 eq "password-mismatch"}
                            <div class="userChangeForm-row">
                                <div class="userChangeForm-row-text" style="color: red;">
                                    Hesla sa nezhoduju.
                                </div>
                            </div>
                        {/if}
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
                        {if isset($param2) && $param2 eq "invalid-email"}
                            <div class="userChangeForm-row">
                                <div class="userChangeForm-row-text" style="color: red;">
                                    Zadali ste nespravny email.
                                </div>
                            </div>
                        {/if}
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
                {elseif ($param2 eq "email")}
                    Na Váš email bola zaslaná overovacia správa.
                {elseif ($param2 eq "email2")}
                    Váš email bo úspešne zmenený.
                {else}
                    <p style='color: red;'>Neplatný vstup</p>
                {/if}
            </div>
        {elseif ($param1 eq "failure")}
            <div class="userChangeForm-row" style='color: red;'>
                {if ($param2 eq "email")}
                    Vyskytla sa chyba, heslo nebolo zmenené.
                {elseif ($param2 eq "email2")}
                    Nesprávne overovacie údaje !!
                {else}
                    <p>Neplatný vstup</p>
                {/if}                
            </div>            
        {/if}
    {else}
        <p>Neplatný vstup</p>
    {/if}
     </div>
{/block}