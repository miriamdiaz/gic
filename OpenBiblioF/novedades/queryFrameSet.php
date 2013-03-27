<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">

<html>
<head>
<title>Busqueda</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link type=\"text/css\" rel=\"stylesheet\" href=\"../estilo.css\"/>
<script languaje="javascript">
    function loading()
	{
	document.getElementById("body").style.visibility="visible";
	document.getElementById("loading").style.visibility="hidden";
	}
    function unloading()
	{
	document.getElementById("loading").style.visibility="visible";
	}
</script>
</head>
<frameset rows="300,*" frameborder="NO" border="0" framespacing="0" name="FrameSet">
    <frame src="query.php" name="query" noresize>
    <frame name="queryResult">
</frameset>
<noframes>
<div id="loading" class="clsLoading">
<body onload="loading()" onUnload="unloading()" id="body" style="visibility:hidden">
</body></noframes>
</html>
