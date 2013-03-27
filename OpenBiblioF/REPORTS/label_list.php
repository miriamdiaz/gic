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
  $nav = "labellist";

  require_once("../shared/common.php");
  include("../shared/logincheck.php");
  include("../shared/header.php");
  require_once("../functions/fileIOFuncs.php");
  require_once("../classes/ReportDefinition.php");
  require_once("../classes/LabelFormat.php");
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,$tab);
  
  /******************************************
  
  
  define("LABEL_DEFS_DIR","../reports/labeldefs");
  define("REPORT_DEFS_DIR","../reports/reportdefs");

  #****************************************************************************
  #*  Read label layout definition xml
  #****************************************************************************
  $labelids = array();
  $labelTitles = array();
  $sqlStatements = array();
  $labelFiles = array();
  
  if ($handle = opendir(LABEL_DEFS_DIR)) {
    while (false !== ($file = readdir($handle))) { 
      if ($file[0] != "." && !is_dir($file)) {
        $fileName = LABEL_DEFS_DIR."/".$file;
        //$xml = file_get_contents($fileName);
        $xml = fileGetContents($fileName);
        if ($xml === FALSE) {
          echo '<p><font class="error">';
          echo $loc->getText('reportListCannotRead',
            array('fileName' => basename($fileName)));
          echo '</font></p>';
          continue;
        }
        $labelDef = new LabelFormat();
        if ($labelDef->parse($xml)) {
          $labelid = $labelDef->getId();
          $labelids[] = $labelid;
          $labelTitles[$labelid] = $labelDef->getTitle();
          $reportDefFilename = REPORT_DEFS_DIR."/".$labelDef->getReportDefFilename();
          $labelFiles[$labelid] = $fileName;
        } else {
          echo $loc->getText("reportListXmlErr");
          echo "<pre>file name: ".$fileName."\n".$labelDef->getXmlErrorString()."</pre>";
          exit();
        }
        $labelDef->destroy();
        unset($labelDef);
        
        #****************************************************************************
        #*  Read label query sql from report definition xml
        #****************************************************************************
        $xml = fileGetContents($reportDefFilename);
        if ($xml === FALSE) {
          array_pop($labelids);
          unset($labelTitles[$labelid]);
          unset($labelFiles[$labelid]);
          echo '<p><font class="error">';
          echo $loc->getText('Cannot read report file: %fileName%',
            array('fileName' => basename($reportDefFilename)));
          echo '</font></p>';
          continue;
        }
        $rptDef = new ReportDefinition();
        if ($rptDef->parse($xml)) {
          $sqlStatements[$labelid] = $rptDef->getSql();
        } else {
          echo $loc->getText("reportListXmlErr");
          echo "<pre>file name: ".$fileName."\n".$rptDef->getXmlErrorString()."</pre>";
          exit();
        }
        $rptDef->destroy();
        unset($rptDef);
        
        
      } 
    }
    closedir($handle); 
  }

*******************************/
?>

<h1><?php echo $loc->getText("labelListHdr");?></h1>

<?php echo $loc->getText("labelListDesc");?>
<!--**************************** JUDITH
<ol>
<?php
  foreach ($labelids as $lblid) {
    $rptTitle = $loc->getText($labelTitles[$lblid]);
    $title = urlencode($rptTitle);
    $file = urlencode($labelFiles[$lblid]);
    $sql = urlencode($sqlStatements[$lblid]);
    echo "<li><a href=\"../reports/report_criteria.php?reset=Y&rptid=".$lblid."&title=".$title."&sql=".$sql."&label=".$file."\">".$rptTitle."</a></li>";
  }
?>
</ol>
******************************************-->
<?php include("../shared/footer.php"); ?>
