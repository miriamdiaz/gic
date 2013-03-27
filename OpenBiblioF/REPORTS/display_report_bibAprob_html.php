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
 #****************************************************************************
 #*  Checking for tab name to show OPAC look and feel if searching from OPAC
 #****************************************************************************
  $tab = "reports";
  $nav = "reportlistsiunpa"; 
  $lookup = "N";
  require_once("../shared/common.php");
 // include("../shared/logincheck.php");
  
  require_once("../classes/Localize.php");
  require_once("../functions/errorFuncs.php");
  require_once("../functions/inputFuncs.php");
  //require_once("../classes/BiblioQuery.php");
  //require_once("../classes/ReportBiblios.php");
  require_once("../classes/ReportAprobBibQuery.php");
  //require_once("../classes/ReportQuery.php");
  $loc = new Localize(OBIB_LOCALE,$tab);
  
  if (isset($_POST["tab"])) 
  {
    $tab = $_POST["tab"];
  }
  if (isset($_POST["lookup"])) 
  {
    $lookup = $_POST["lookup"];
  }
  if (isset($_POST["fech1"])) 
  {
    $fech1 = $_POST["fech1"];
  }
   if (isset($_POST["fech2"])) 
  {
    $fech2 = $_POST["fech2"];
	include("../shared/header.php");
  }

  
 
  #****************************************************************************
  #*  Function declaration only used on this page.
  #****************************************************************************
  function printResultPages(&$loc, $currPage, $pageCount) 
  {
    if ($pageCount <= 1)
    {
      return false;
    }
    echo $loc->getText("biblioSearchListResultPages").": ";
    $maxPg = OBIB_SEARCH_MAXPAGES + 1;
    if ($currPage > 1) 
	{
      echo "<a href=\"javascript:changePage(".($currPage-1).")\">&laquo;".$loc->getText("biblioSearchListPrev")."</a> ";
    }
    for ($i = 1; $i <= $pageCount; $i++) 
	{
      if ($i < $maxPg) 
	  {
        if ($i == $currPage) 
		{
          echo "<b>".$i."</b> ";
        }
		else 
		{
          echo "<a href=\"javascript:changePage(".$i.")\">".$i."</a> ";
        }
      } 
	  elseif ($i == $maxPg)
	  {
        echo "... ";
      }
    }
    if ($currPage < $pageCount) 
	{
      echo "<a href=\"javascript:changePage(".($currPage+1).")\">".$loc->getText("biblioSearchListNext")."&raquo;</a> ";
    }
  }
  #****************************************************************************
  #*  Retrieving post vars and scrubbing the data
  #****************************************************************************
  if (isset($_POST["page"])) 
  {
    $currentPageNmbr = $_POST["page"];
  } 
  else 
  {
    $currentPageNmbr = 1;
  }
  
  #****************************************************************************
  #*  Search database
  #****************************************************************************
  $biblioQ = new ReportAprobBibQuery();
  //echo "new";
  $biblioQ->setItemsPerPage(OBIB_ITEMS_PER_PAGE);
  $biblioQ->connect();
  if ($biblioQ->errorOccurred()) {
    $biblioQ->close();
    displayErrorPage($biblioQ);
  }
   # checking to see if we are in the opac search or logged in
  if ($tab == "opac") {
    $opacFlg = true;
  } else {
    $opacFlg = false;
  }
  //$fech1 = $reportBiblios->getFecha1();
  //$fech2 = $reportBiblios->getFecha2();

  //echo " En display: fecha1: $fech1  fecha2: $fech2";
   if (!$biblioQ->viewBibliosAprob($currentPageNmbr,$fech1,$fech2)) 
  {
    $biblioQ->close();
    displayErrorPage($biblioQ);
  }
  #**************************************************************************
  #*  Show search results
  #**************************************************************************
  
  // require_once("../classes/Localize.php");
   //$loc = new Localize(OBIB_LOCALE,"shared");

  # Display no results message if no results returned from search.
  
   if ($biblioQ->getRowCount() == 0) {
    $biblioQ->close();
    echo $loc->getText("biblioSearchListNoResults");
    require_once("../shared/footer.php");
    exit();
  }
?>

<!--**************************************************************************
    *  Javascript to post back to this page
    ************************************************************************** -->
<script language="JavaScript" type="text/javascript">
<!--
function changePage(page)
{
  document.changePageForm.page.value = page;
  
  document.changePageForm.submit();
}
-->
</script>


<!--**************************************************************************
    *  Form used by javascript to post back to this page
    ************************************************************************** -->
<form name="changePageForm" method="POST" action="../reports/display_report_bibAprob_html.php">
  <input type="hidden" name="lookup" value="<?php echo $_POST["lookup"];?>">
  <input type="hidden" name="page" value="1">
  <input type="hidden" name="tab" value="<?php echo $tab;?>">
  <input type="hidden" name="fech1" value="<?php echo $fech1;?>">
  <input type="hidden" name="fech2" value="<?php echo $fech2;?>">
</form>

<!--**************************************************************************
    *  Printing result stats and page nav
    ************************************************************************** -->
<h1><?php print $loc->getText("reportSiunpaHead3");?>&nbsp;<?php print $loc->getText("reportSiunpaHead3-1");?></h1>

<font class="small">
<a href="../reports/list_new_aprobs_form.php"><?php print $loc->getText("runReportListReturnLink1"); ?></a>
| <a href="../reports/report_list_siunpa.php"><?php print $loc->getText("runReportListReturnLink2"); ?></a>
</font>
<br><br>

<?php 
  echo $loc->getText("biblioSearchListResultTxt",array("itemsl"=>$biblioQ->getRowCount()));
  if ($biblioQ->getRowCount() > 1) {
    echo ". <br> Ordenado por fecha de creaci&oacute;n";
   }
?>
<br>
<?php printResultPages($loc, $currentPageNmbr, $biblioQ->getPageCount()); ?><br>
<br>

<!--**************************************************************************
    *  Printing result table
    ************************************************************************** -->
<?php echo $loc->getText("biblioSearchListResults"); ?>:
<br><br>
<table class="primary">
 <tr>
 	<th>Nº</th>
	<th>T&iacute;tulo</th>
	<th>Signatura</th>
	<th>Fech. Creaci&oacute;n</th>
	<th>Carg&oacute;</th>
	<th>Aprobó</th>
	<th>Fech. Aprob</th>
	
 </tr>
  <?php
    $priorBibid = 0;
    while ($biblio = $biblioQ->fetchRowFranco()) 
    {
      if ($biblio->getBibid() == $priorBibid)
      {   
      } 
	  else 
      {
        $priorBibid = $biblio->getBibid();
	    ?>
	    <tr>
        	<td nowrap="true" class="primary" valign="center" align="center">
		    <?php echo $biblioQ->getCurrentRowNmbr();?><br>
    	    </td>
			<td class="primary" valign="center" align="left">
			<?php echo $biblio->getTitle(); ?>
        	</td>
			<td class="primary" valign="center" align="center">
             <?php echo $biblio->getCallNmbr1().$biblio->getCallNmbr2().$biblio->getCallNmbr3(); ?>
        	</td>
			<td class="primary" valign="center" align="center">
             <?php echo $biblio->getCreateDt(); ?>
        	</td>
			<td class="primary" valign="center" align="center">
             <?php getName($biblio->getUserNameCreador());//$biblio->getUserNameCreador(); ?>
        	</td>
			<td class="primary" valign="center" align="center">
             <?php getName($biblio->getUserId()); ?>
        	</td>
			<td class="primary" valign="center" align="center">
             <?php echo $biblio->getFecha(); ?>
        	</td>
		</tr>
    <?php 
    }
    }
    $biblioQ->close();
  ?>
  </table><br>
<?php printResultPages($loc, $currentPageNmbr, $biblioQ->getPageCount()); ?><br>
<?php require_once("../shared/footer.php"); ?> 
