<?php
/**********************************************************************************
 *   Copyright(C) 2002 David Stevens
 *
 *   This file is part of OpenBiblio.
 *
 *   OpenBiblio is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 *   OpenBiblio is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU General Public License for more details.
 *
 *   You should have received a copy of the GNU General Public License
 *   along with OpenBiblio; if not, write to the Free Software
 *   Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 **********************************************************************************
 */

  $tab = "adquisiciones";
  $nav = "summary";
  require_once("../shared/common.php");
  require_once("../shared/logincheck.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);
  
  #****************************************************************************
  #*  Checking for query string.  Go back to collection list if none found.
  #****************************************************************************
  if (!isset($_GET["code"])){
    header("Location: ../adquisiciones/adquisicion.php");
    exit();
  }
  $adqid = $_GET["code"];

  #**************************************************************************
  #*  Show confirm page
  #**************************************************************************
  require_once("../shared/header.php");
?>
<center>
<form name="delstaffform" method="POST" action="../adquisiciones/adquisiciones_del.php?code=<?php echo $adqid;?>">
<? echo "Está seguro que desea eliminar el pedido de adquisición Nro: "; ?><?php echo $adqid;?>?<br><br>
      <input type="submit" value="Aceptar" class="button">
      <input type="button" onClick="parent.location='../adquisiciones/index.php?code=<? echo $adqid;?>&buscar=1'" value="Cancelar" class="button">
</form>
</center>
<?php include("../shared/footer.php"); ?>
