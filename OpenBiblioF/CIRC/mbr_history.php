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

  $tab = "circulation";
  $nav = "hist";
  //require agregado: Horacio Alvarez
  require_once("../classes/StaffQuery.php");
  require_once("../shared/common.php");
  require_once("../functions/inputFuncs.php");
  require_once("../shared/logincheck.php");
  require_once("../classes/BiblioStatusHist.php");
  require_once("../classes/BiblioStatusHistQuery.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);

  #****************************************************************************
  #*  Checking for get vars.  Go back to form if none found.
  #****************************************************************************
  if (count($_GET) == 0) {
    header("Location: ../circ/index.php");
    exit();
  }

  #****************************************************************************
  #*  Retrieving get var
  #****************************************************************************
  $mbrid = $_GET["mbrid"];
  if (isset($_GET["name"])) {
      $mbrName = urlencode($_GET["name"]);
  } else {
      $mbrName = "";
  }
  

  #****************************************************************************
  #*  Search database for member history
  #****************************************************************************  
  include ("../conexiondb.php");  
  $query = "SELECT h.bibid,h.copyid,b.title, b.author,c.barcode_nmbr ";
  $query.= "from biblio_status_hist h ";
  $query.= "LEFT JOIN biblio b ON h.bibid = b.bibid ";
  $query.= "LEFT JOIN biblio_copy c ON c.bibid = b.bibid AND c.copyid = h.copyid ";
  $query.= "where h.mbrid = $mbrid ";
  $query.= "group by h.bibid,h.copyid ";

  $result = mysql_query($query,$conexion);
 
  #**************************************************************************
  #*  Show biblio checkout history
  #**************************************************************************
  require_once("../shared/header.php");
?>

<h1><?php print $loc->getText("mbrHistoryHead1"); ?></h1>
<table class="primary">
  <tr>
    <th valign="top" nowrap="yes" align="left">
      <?php print $loc->getText("mbrHistoryHdr1"); ?>
    </th>
    <th valign="top" nowrap="yes" align="left">
      <?php print $loc->getText("mbrHistoryHdr2"); ?>
    </th>
    <th valign="top" nowrap="yes" align="left">
      <?php print $loc->getText("mbrHistoryHdr3"); ?>
    </th>
    <th valign="top" nowrap="yes" align="left">
      <?php print $loc->getText("mbrHistoryHdr4"); ?>
    </th>
  </tr>

<?php
if(mysql_num_rows($result)==0)  {
?>
  <tr>
    <td class="primary" align="center" colspan="7">
      <?php print $loc->getText("mbrHistoryNoHist"); ?>
    </td>
  </tr>
<?php
  } else {

while ($row = mysql_fetch_array($result)) {

$bibid = $row["bibid"];
$copyid = $row["copyid"];

$query2 = "SELECT h.*, ";
$query2.= "DATE_FORMAT(h.status_begin_dt,'%d-%m-%Y') AS begin_dt, ";
$query2.= "s.last_name AS presto ";
$query2.= "FROM biblio_status_hist h ";
$query2.= "LEFT JOIN staff s ON h.userid = s.userid ";
$query2.= "WHERE h.mbrid = $mbrid AND h.bibid = $bibid AND h.copyid = $copyid ";
$query2.= "ORDER BY h.status_begin_dt Desc";

$result2 = mysql_query($query2,$conexion)

?>
  <tr>
    <td class="primary" valign="top" >
      <?php 
	  echo $row["barcode_nmbr"];
	  ?>
    </td>
    <td class="primary" valign="top" >
      <a href="../shared/biblio_view.php?bibid=<?php echo $row["bibid"];?>&tab=<?php echo $tab?>"><?php echo $row["title"];?></a>
    </td>
    <td class="primary" valign="top" >
      <?php echo $row["author"];?>
    </td>
    <td class="primary" valign="top" >
      <?php 
	  
	  while($row2 = mysql_fetch_array($result2))
	       {
		    $presto = $row2["presto"];
			$due_back_dt = $row2["due_back_dt"];
			$begin_dt = $row2["begin_dt"];
			$status_cd = $row2["status_cd"];
			if($status_cd == "out")
			   $accion = "prestó";
			if($status_cd == "crt")
			   $accion = "devolvió";
			if($status_cd == "hld")
			   $accion = "reservó";
			
			echo $presto." ".$accion." ".$begin_dt." / ";
		   }
	  
	  ?>
    </td>
  </tr>
<?php
    }
  }
//  $histQ->close();

?>
</table>

<?php require_once("../shared/footer.php"); ?>
