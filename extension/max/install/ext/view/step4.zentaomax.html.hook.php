<script>
$tr = $('#modenew').closest('tr');
$nextTR = $tr.next();
$tr.remove();
$nextTR.remove();
$('#submit').after("<input type='hidden' name='mode' value='new' />");
</script>