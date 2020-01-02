<table id="multipleChildren" class="form-layout" style="display:none">
  <tbody>
    <tr class="crm-event-manage-fee-form-block-multiple-children">
      <td class="label">{$form.multiple_children.label}</td><td class="content">
            {$form.multiple_children.html}
      </td>
    </tr>
  </tbody>
</table>

{literal}
<script type="text/javascript">
CRM.$(function($) {
    $( document ).ajaxComplete(function( event, xhr, settings ) {
        $('#multipleChildren').find('tr').insertBefore('tr.crm-event-manage-eventinfo-form-block-is_map');
    });
});
</script>
{/literal}