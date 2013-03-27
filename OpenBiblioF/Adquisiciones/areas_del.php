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
  $nav = "areas";
  $restrictInDemo = true;
  require_once("../shared/common.php");
  require_once("../shared/logincheck.php");
  require_once("../classes/DmQuery.php");
  require_once("../functions/errorFuncs.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);

  #****************************************************************************
  #*  Checking for query string.  Go back to collection list if none found.
  #****************************************************************************
  if (!isset($_GET["code"])){
    header("Location: ../adquisiciones/areas_list.php");
    exit();
  }
  $code = $_GET["code"];
  $description = $_GET["description"];

  #**************************************************************************
  #*  Delete row
  #**************************************************************************
  $dmQ = new DmQuery();
  $dmQ->connect();
  if ($dmQ->errorOccurred()) {
    $dmQ->close();
    displayErrorPage($dmQ);
  }

  if($dmQ->isAreaInAdquisicion($code))
  {
    require_once("../shared/header.php");
    echo "No se puede eliminar el �rea, ya que se encuentra asociada a un pedido de adquisici�n<br><br>";
	echo "<a href=\"../adquisiciones/areas_list.php\">Volver al listado de �reas</a>";
    exit();
  }

  if (!$dmQ->delete("area_dm",$code)) {
    $dmQ->close();
    displayErrorPage($dmQ);
  }
  $dmQ->close();

  #**************************************************************************
  #*  Show success page
  #**************************************************************************
  require_once("../shared/header.php");
?>
<? echo "�rea: "; ?>
<?php echo $description;?>
<? echo " , eliminada satisfactoriamente"; ?><br><br>
<a href="../adquisiciones/areas_list.php"><? echo "Volver a �reas"; ?></a>

<?php require_once("../shared/footer.php"); ?>
