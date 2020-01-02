<div id="multiple-children">
{section name='i' start=1 loop=25}
    {assign var='rowNumber' value=$smarty.section.i.index}
    <div id="add-item-row-{$rowNumber}" class="multiple_children-row hiddenElement {cycle values="odd-row,even-row"}">
        <fieldset><legend>{ts}Child {$rowNumber}{/ts}</legend>
            <div class="crm-section">
                <div class="label">
                    {$form.child_first_name.$rowNumber.label}
                </div>
                <div class="content">
                    {$form.child_first_name.$rowNumber.html}
                </div>
            </div>
            <br/>
            <div class="crm-section">
                <div class="label">
                    {$form.child_last_name.$rowNumber.label}
                </div>
                <div class="content">
                    {$form.child_last_name.$rowNumber.html}
                </div>
            </div>
            <div><a href=# class="remove_item crm-hover-button" style="float:right;"><b>{ts}Remove{/ts}</b></a></div>
        </fieldset>
    </div>
{/section}
<span id="add-another-item" class="crm-hover-button hiddenElement" style="font-weight:bold;padding:10px;"><a href=#>{ts}Add another card{/ts}</a></span>
</div>