<style>#osBox {width: 260px;}</style>
<?php
$html  = "<div class='table-col'>";
$html .= "<div class='input-group'>";
$html .= "<span class='input-group-addon'>" . $lang->bug->identify . '</span>';
$html .= html::select('identify', '', '', "class='form-control chosen'");
$html .= '</div>';
$html .= '</div>';
?>
<script>
/**
 * Load identify.
 *
 * @access public
 * @return void
 */
function loadIdentify()
{
    var productID = $('#product').val();
    setTimeout(function()
    {
        var projectID = $('#project').val();
        var link = createLink('bug', 'ajaxGetIdentify', 'productID=' + productID + '&projectID=' + projectID);
        $.post(link, function(data)
        {
            $('#identify').replaceWith(data);
            $('#identify_chosen').remove();
            $('#identify').chosen();
        })
    }, 500);
}

$('#typeBox').closest('td').attr('colspan', '2').find('.table-row').append(<?php echo json_encode($html);?>);

$(document).on('change', '#product', loadIdentify);
$(document).on('change', '#project', loadIdentify);

loadIdentify();
</script>
