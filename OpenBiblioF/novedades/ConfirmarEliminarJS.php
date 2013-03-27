<? include("labels.php")?>
<script languaje="javascript">
function ConfirmarEliminar(id)
    {
    var confirmacion = confirm("<?=$msj_delete_alert_js;?>");
    if (confirmacion)
	{
	parent.location = 'delete.php?id='+id+"&";
	}
    }

</script>