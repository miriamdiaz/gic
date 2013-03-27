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

  require_once("../classes/Localize.php");
  $navLoc = new Localize(OBIB_LOCALE,"navbars");


 if (isset($_SESSION["userid"])) {
   $sess_userid = $_SESSION["userid"];
 } else {
   $sess_userid = "";
 }
 if ($sess_userid == "") { ?>
  <input type="button" onClick="parent.location='../shared/loginform.php?RET=<?php echo $_SERVER["PHP_SELF"];?>'" value="<?php echo $navLoc->getText("login");?>" class="navbutton">
<?php } else { ?>
  <input type="button" onClick="parent.location='../shared/logout.php'" value="<?php echo $navLoc->getText("logout");?>" class="navbutton">
<?php } ?>
<br/><br/>

<?php if ($nav == "summary") { ?>
 &raquo; <?php echo "Adquisiciones";?><br>
<?php } else { ?>
 <a href="../adquisiciones/index.php" class="alt1"><?php echo "Adquisiciones";?></a><br>
<?php } ?>

<?php if ($nav == "conceptos") { ?>
 &raquo; <?php echo "Conceptos";?><br>
<?php } else { ?>
 <a href="../adquisiciones/conceptos_list.php" class="alt1"><?php echo "Conceptos";?></a><br>
<?php } ?>

<?php if ($nav == "estados") { ?>
 &raquo; <?php echo "Estados";?><br>
<?php } else { ?>
 <a href="../adquisiciones/estados_list.php" class="alt1"><?php echo "Estados";?></a><br>
<?php } ?>

<?php if ($nav == "docentes") { ?>
 &raquo; <?php echo "Docentes";?><br>
<?php } else { ?>
 <a href="../adquisiciones/Mbr_list.php" class="alt1"><?php echo "Docentes";?></a><br>
<?php } ?>

<?php if ($nav == "areas") { ?>
 &raquo; <?php echo "Areas";?><br>
<?php } else { ?>
 <a href="../adquisiciones/areas_list.php" class="alt1"><?php echo "Areas";?></a><br>
<?php } ?>

<?php 

  #****************************************************************************
  #*  Read report definition xml
  #****************************************************************************
  define("REPORT_DEFS_DIR","../reports/reportdefs");
  require_once("../functions/fileIOFuncs.php");
  require_once("../classes/ReportDefinition.php");
  $loc = new Localize(OBIB_LOCALE,$tab);
  
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
	
    if($rptid == "adquisiciones")
	    $_SESSION["sqlAdquisiciones"] = $originalSql;		
  }  

if ($nav == "informe_adquisiciones") { ?>
 &raquo; <?php echo "Informe de Adquisiciones";?><br>
<?php } else { ?>
 <a href="../reports/report_criteria.php?reset=Y&rptid=adquisiciones&title=Adquisiciones"><?php print "Informe de Adquisiciones"; ?></a><br>
<?php } ?>

<a href="javascript:popSecondary('../shared/help.php<?php if (isset($helpPage)) echo "?page=".$helpPage; ?>')"><?php echo $navLoc->getText("help");?></a>
