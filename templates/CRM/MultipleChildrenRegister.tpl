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
            <div><a href=# class="remove_item crm-hover-button" style="float:right;"><b>{ts}Remove{/ts}</b></a></div>
        </fieldset>
    </div>
{/section}
</fieldset>
</div>

{literal}
<script type="text/javascript">
CRM.$(function($) {
  $("#multiple-children").appendTo("div#priceset");

  var selectedchildren = $('select#multiple_child').select2('data');
  hideShowChildren(selectedchildren.text);

  $('select#multiple_child').select2().on("change", function(e) {
    var count = parseInt(e.added.text);
    hideShowChildren(count);
  });

  function hideShowChildren(count) {
      var remainingcount = count + 1;
      for (i = 1; i <= count; i++) {
          $('#add-item-row-' + i).removeClass('hiddenElement');
          $('#add-another-item').removeClass('hiddenElement');
      }
      for (i = remainingcount; i <= 25; i++) {
          $('#add-item-row-' + i).addClass('hiddenElement');
          var row = $('#add-item-row-' + i);
          $('input[name^="child_first_name"]', row).val('');
          $('input[id^="child_last_name"]', row).val('');
          $('input[name^="child_dob"]', row).val('');
          $('input[id^="child_gender"]', row).val('');
      }
  }

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

