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

  $tab = "reports";
  $nav = "runreport";
  
  if(isset($_POST["rptid"]))
    if($_POST["rptid"] == "adquisiciones")
	    $tab = "adquisiciones";    

  require_once("../classes/Localize.php");
  require_once("../funciones.php");
  $loc = new Localize(OBIB_LOCALE,$tab);

  include("../reports/run_report.php");
  include("../shared/header_no_nav.php");

?>

<font class="small">
<?
	if($rptid=="prestamosAnuales")
		{ 
		  echo "<a href='../reports/report_criteria_prestamos_anuales.php?rptid=$rptid&title=$qStrTitle&sql=$metaSql'>"; 
		  print $loc->getText("runReportReturnLink1"); 
		  echo "</a>"; 
		}
	elseif($rptid == "prestamosMensuales")
		{ echo "<a href='../reports/report_criteria_prestamos_mensuales.php?rptid=$rptid&title=$qStrTitle&sql=$metaSql'>"; print $loc->getText("runReportReturnLink1"); echo "</a>"; }
	elseif($rptid == "siunpaEstadisctico")
		{ 
		 $_SESSION["sqlSiunpa"] = urldecode($metaSql);
		 echo "<a href='../reports/report_criteria_estadistico_siunpa.php?rptid=$rptid&title=$qStrTitle'>"; print $loc->getText("runReportReturnLink1"); echo "</a>"; 
		}
	elseif($rptid == "estadisticoOperaciones")
		{ 
		 $_SESSION["sqlOperaciones"] = urldecode($metaSql);
		 echo "<a href='../reports/report_criteria_estadistico_operaciones.php?rptid=$rptid&title=$qStrTitle'>"; print $loc->getText("runReportReturnLink1"); echo "</a>"; 
		}
	elseif($rptid == "estadisticoUsuarios")
		{ 
		 $_SESSION["sqlUsuarios"] = urldecode($metaSql);
		 echo "<a href='../reports/report_criteria_estadistico_usuarios.php?rptid=$rptid&title=$qStrTitle'>"; print $loc->getText("runReportReturnLink1"); echo "</a>"; 
		}						
	elseif($rptid=="listadoSocios")
		{ echo "<a href='../reports/report_criteria_socios.php?rptid=$rptid&title=$qStrTitle&sql=$metaSql'>"; print $loc->getText("runReportReturnLink1"); echo "</a>"; }
	elseif($rptid=="prestamosDiarios")
		{ echo "<a href='../reports/report_criteria_prestamos_diarios.php?rptid=$rptid&title=$qStrTitle&sql=$metaSql'>"; print $loc->getText("runReportReturnLink1"); echo "</a>"; }
	elseif($rptid=="devolucionesDiarias")
		{ echo "<a href='../reports/report_criteria_devoluciones_diarias.php?rptid=$rptid&title=$qStrTitle&sql=$metaSql'>"; print $loc->getText("runReportReturnLink1"); echo "</a>"; }
	elseif($rptid=="prestamosVencer")
		{ echo "<a href='../reports/report_criteria_prestamos_vencer.php?rptid=$rptid&title=$qStrTitle&sql=$metaSql'>"; print $loc->getText("runReportReturnLink1"); echo "</a>"; }				
	else
        { echo "<a href='../reports/report_criteria.php?rptid=$rptid&title=$qStrTitle&sql=$qStrSql'>"; print $loc->getText("runReportReturnLink1"); echo "</a>"; }
	
?>
| 
<?
if($rptid == "siunpaEstadisctico")
{ ?>
<a href="../reports/report_list_siunpa.php"><?php print $loc->getText("runReportReturnLink2"); ?></a></font>
<? 
}
elseif($rptid == "adquisiciones")
{ ?>
<a href="../adquisiciones/index.php"><?php print $loc->getText("runReportReturnLink2"); ?></a></font>
<? 
}
else
{ ?>
<a href="../reports/report_list.php"><?php print $loc->getText("runReportReturnLink2"); ?></a></font>
<? }
?>
<h1><?php echo $title;?>:</h1>

<table class="primary">
  <tr>
    <?php
      foreach($fieldIds as $fldid) {
        echo "<th class=\"rpt\">".$loc->getText($fldid)."</th>";
      }
    ?>
  </tr>
  <?php
    $bibidIndex = -1;
    $mbridIndex = -1;

    foreach($fieldIds as $key => $value) {
      if($value == "biblio.bibid") {
        $bibidIndex = $key;
      }
      else if($value == "member.mbrid") {
        $mbridIndex = $key;
      }
    }
    while ($array = $reportQ->fetchRow()) {
      echo "<tr>";
      
      foreach($array as $key => $value) {
	  //echo "FIELDIDS: ".$fieldIds[$key]."<br>";
	  if($fieldIds[$key] == "biblio_copy.due_back_dt")
	    {
	     $due_back_dt = $value;
		 //echo "VALUE: ".$value."<br>";
		 $value = toDDmmYYYY($value);
		 //echo "VALUE: ".$value."<br>";
		 }
	  if($fieldIds[$key] == "days_late")
	     {
		  $value = getCantidadDiasSinFindes($due_back_dt,$value);
		 }
	  if($fieldIds[$key])
        echo "<td class=\"rpt\">";

	if($key == $bibidIndex) {
          //echo "<a href=\"../shared/biblio_view.php?bibid=".$value."&tab=reports\">".$value."</a>";
		  echo $value;
        }
        else if($key == $mbridIndex) {
          echo "<a href=\"../circ/mbr_view.php?mbrid=".$value."\">".$value."</a>";
        }
        else {
          echo $value;
        }

        echo "</td>";
      }
      echo "</tr>";
    }
    $reportQ->close();
  ?>
  <tr><th class="rpt" colspan="<?php echo $colCount;?>"><?php echo $loc->getText("runReportTotal");?> <?php echo $rowCount;?></th></tr>
</table>
<br>
<font class="small">
<a href="../reports/report_criteria.php?rptid=<?php echo $rptid;?>&title=<?php echo $qStrTitle;?>&sql=<?php echo $qStrSql;?>"><?php print $loc->getText("runReportReturnLink1"); ?></a>
| <a href="../reports/report_list.php"><?php print $loc->getText("runReportReturnLink2"); ?></a></font>

<?php include("../shared/footer.php"); ?>
