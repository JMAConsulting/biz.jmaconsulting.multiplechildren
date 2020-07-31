<div id="multiple-children">
<fieldset>
<legend>Child Details</legend>
<div class="crm-section">
  <div class="label">
    {$form.multiple_child.label}
  </div>
  <div class="content">
    {$form.multiple_child.html}
  </div>
</div>
<div class="clear"></div>
    <div id="first-child">
        <fieldset><legend>{ts}Child 1{/ts}</legend>
            <div class="crm-section">
                <div class="label">
                    {$form.child_first_name.1.label}
                </div>
                <div class="content">
                    {$form.child_first_name.1.html}
                </div>
            </div>
            <br/>
            <div class="crm-section">
                <div class="label">
                    {$form.child_last_name.1.label}
                </div>
                <div class="content">
                    {$form.child_last_name.1.html}
                </div>
            </div>
            <div class="crm-section">
                <div class="label">
                    {$form.child_dob.1.label}
                </div>
                <div class="content">
                    {$form.child_dob.1.html}
                </div>
            </div>
            <div class="crm-section">
                <div class="label">
                    {$form.child_gender.1.label}
                </div>
                <div class="content">
                    {$form.child_gender.1.html}
                </div>
            </div>
            <div><span class="add_another_item crm-hover-button" style="float:right;font-weight:bold;padding:10px;"><a href=#>{ts}Add another child{/ts}</a></span></div>
        </fieldset>
    </div>
    <div id="children-with-asd">
{section name='i' start=2 loop=25}
    {assign var='rowNumber' value=$smarty.section.i.index}
    <div id="add-item-row-{$rowNumber}" class="multiple_children-row hiddenElement {cycle values="odd-row,even-row"}">
        <fieldset><legend>{ts}Child {$rowNumber} with ASD{/ts}</legend>
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
            <div class="crm-section">
                <div class="label">
                    {$form.child_dob.$rowNumber.label}
                </div>
                <div class="content">
                    {$form.child_dob.$rowNumber.html}
                </div>
            </div>
            <div class="crm-section">
                <div class="label">
                    {$form.child_gender.$rowNumber.label}
                </div>
                <div class="content">
                    {$form.child_gender.$rowNumber.html}
                </div>
            </div>
            <div><span class="add_another_item crm-hover-button" style="float:right;font-weight:bold;padding:10px;"><a href=#>{ts}Add another child{/ts}</a></span></div>
            {if $rowNumber neq 1}
            <div><a href=# class="remove_item crm-hover-button" style="float:right;padding:10px;"><b>{ts}Remove{/ts}</b></a></div>
            {/if}
        </fieldset>
    </div>
{/section}
    </div>
</fieldset>
</div>

{literal}
<script type="text/javascript">
CRM.$(function($) {
  $("#multiple-children").appendTo("div.custom_pre-section");

  var submittedRows = $.parseJSON('{/literal}{$childSubmitted}{literal}');

  // after form rule validation when page reloads then show only those items which were chosen and hide others
  $.each(submittedRows, function(e, num) {
      $('#add-item-row-' + num).removeClass('hiddenElement');
  });

  $('.add_another_item').on('click', function(e) {
      e.preventDefault();
      var hasHidden = $('div.multiple_children-row').hasClass("hiddenElement");
      if (hasHidden) {
          var row = $('#children-with-asd div.hiddenElement:first');
          $('div.hiddenElement:first, #children-with-asd').fadeIn("slow").removeClass('hiddenElement');
          hasHidden = $('div.multiple_children-row').hasClass("hiddenElement");
      }
      $('.add_another_item').toggle(hasHidden);
  });

  $('.remove_item').on('click', function(e) {
    e.preventDefault();
    var row = $(this).closest('div.multiple_children-row');
    $('#add-another-item').show();
    $('input[name^="child_first_name"]', row).val('');
    $('input[id^="child_last_name"]', row).val('');
    $('input[name^="child_dob"]', row).val('');
    $('input[id^="child_gender"]', row).val('');
    row.addClass('hiddenElement').fadeOut("slow");
  });
});
</script>
{/literal}

