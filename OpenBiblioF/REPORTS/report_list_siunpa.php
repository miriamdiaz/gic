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
// \/ MODIFICACIÓN JUDITH 25/10/05 \/
  $tab = "reports";
  $nav = "reportlistsiunpa";

  require_once("../shared/common.php");
  include("../shared/logincheck.php");
  include("../shared/header.php");
  require_once("../functions/fileIOFuncs.php");
  require_once("../classes/ReportDefinition.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);
   define("REPORT_DEFS_DIR","../reports/reportdefs");
 
  #****************************************************************************
  #*  Read report definition xml
  #****************************************************************************
  $reportids = array();
  $reportTitles = array();
  $reportSql = array();
  
  if ($handle = opendir(REPORT_DEFS_DIR)) {
    while (false !== ($file = readdir($handle))) { 
      if ($file[0] != "." && !is_dir($file)) {
        $fileName = REPORT_DEFS_DIR."/".$file;
        $xml = fileGetContents($fileName);
        if ($xml === FALSE) {
          continue;
        }
        $rptDef = new ReportDefinition();
        if ($rptDef->parse($xml)) {
          $rptid = $rptDef->getId();
          $reportids[] = $rptid;
          $reportTitles[$rptid] = $rptDef->getTitle();
          $reportSql[$rptid] = $rptDef->getSql();
        } else {
           continue;
        }
        $rptDef->destroy();
        unset($rptDef);
      } 
    }
    closedir($handle); 
  } 
  
  foreach ($reportids as $rptid) {
    $rptTitle = $loc->getText($reportTitles[$rptid]);
    $title = urlencode($rptTitle);
	$originalSql = $reportSql[$rptid];
    $sql = urlencode($reportSql[$rptid]);
	
    if($rptid == "siunpaEstadisctico")
	    $_SESSION["sqlSiunpa"] = $originalSql;
    elseif($rptid == "adquisiciones")
	    $_SESSION["sqlAdquisiciones"] = $originalSql;		
  }  

 ?>

<h1><?php echo $loc->getText("reportListHdrSIUNPA");?></h1>

<?php echo $loc->getText("reportListDescSIUNPA");?>
<!-- PRUEBA 25/10/05 -->



<ol>

 <li><a href=list_new_biblios_form.php><?php print $loc->getText("reportSiunpaHead1"); ?></a></li>
 <BR><BR>
 <li><a href=list_new_copy_form.php><?php print $loc->getText("reportSiunpaHead2"); ?></a></li>
 <BR><BR>
 <li><a href=list_new_aprobs_form.php><?php print $loc->getText("reportSiunpaHead3"); ?></a></li>
 <BR><BR>
 <li><a href=list_biblios_copys_form.php><?php print $loc->getText("reportSiunpaHead4"); ?></a></li>
 <BR><BR>
 <li><a href="report_criteria_estadistico_siunpa.php?reset=Y&rptid=siunpaEstadisctico&title=Estadistico+SIUNPA"><?php print "Estadístico SIUNPA"; ?></a></li> 
</ol>


<?php include("../shared/footer.php"); ?>
