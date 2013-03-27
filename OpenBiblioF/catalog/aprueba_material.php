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

  session_cache_limiter(null);

  #****************************************************************************
  #*  Checking for post vars.  Go back to form if none found.
  #****************************************************************************
  /*if (count($_POST) == 0) 
  {
    header("Location: ../catalog/index.php");
    exit();
  }*/

  #****************************************************************************
  #*  Checking for tab name to show OPAC look and feel if searching from OPAC
  #****************************************************************************
  $tab = "cataloging";
  $lookup = "N";
  $nav = "apruebaMaterial";

  if (isset($_POST["tab"])) 
  {
    $tab = $_POST["tab"];
  }
  if (isset($_POST["lookup"])) 
  {
    $lookup = $_POST["lookup"];
  }

  require_once("../shared/common.php");
  if ($tab != "opac") 
  {
    require_once("../shared/logincheck.php");
  }
  require_once("../classes/BiblioSearch.php");
  require_once("../classes/BiblioSearchQuery.php");
  require_once("../functions/searchFuncs.php");
  require_once("../classes/DmQuery.php");
  require_once("../classes/BiblioQuery.php");  
  #****************************************************************************
  #*  Function declaration only used on this page.
  #****************************************************************************
  function printResultPages(&$loc, $currPage, $pageCount, $sort) 
  {
    if ($pageCount <= 1)
    {
      return false;
    }
    echo $loc->getText("biblioSearchResultPages").": ";
    $maxPg = OBIB_SEARCH_MAXPAGES + 1;
    if ($currPage > 1) 
	{
      echo "<a href=\"javascript:changePage(".($currPage-1).",'".$sort."')\">&laquo;".$loc->getText("biblioSearchPrev")."</a> ";
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
          echo "<a href=\"javascript:changePage(".$i.",'".$sort."')\">".$i."</a> ";
        }
      } 
	  elseif ($i == $maxPg)
	  {
        echo "... ";
      }
    }
    if ($currPage < $pageCount) 
	{
      echo "<a href=\"javascript:changePage(".($currPage+1).",'".$sort."')\">".$loc->getText("biblioSearchNext")."&raquo;</a> ";
    }
  }

  
  #****************************************************************************
  #*  Loading a few domain tables into associative arrays
  #****************************************************************************
  /*$dmQ = new DmQuery();
  $dmQ->connect();
  if ($dmQ->errorOccurred()) 
  {
    $dmQ->close();
    displayErrorPage($dmQ);
  }
  $dmQ->execSelect("collection_dm");
  $collectionDm = $dmQ->fetchRows();
  $dmQ->execSelect("material_type_dm");
  $materialTypeDm = $dmQ->fetchRows();
  $dmQ->resetResult();
  $materialImageFiles = $dmQ->fetchRows("image_file");
  $dmQ->execSelect("biblio_status_dm");
  $biblioStatusDm = $dmQ->fetchRows();
  $dmQ->close();*/

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
  }/*
  $searchType = $_POST["searchType"];
  $sortBy = $_POST["sortBy"];
  if ($sortBy == "default") {
    if ($searchType == "author") {
      $sortBy = "author";
    } else {
      $sortBy = "title";
    }
  }
  # remove slashes added by form post
  $searchText = stripslashes(trim($_POST["searchText"]));
  # remove redundant whitespace
  $searchText = eregi_replace("[[:space:]]+", " ", $searchText);
  if ($searchType == "barcodeNmbr") {
    $sType = OBIB_SEARCH_BARCODE;
    $words[] = $searchText;
  } else {
    $words = explodeQuoted($searchText);
    if ($searchType == "author") {
      $sType = OBIB_SEARCH_AUTHOR;
    } elseif ($searchType == "subject") {
      $sType = OBIB_SEARCH_SUBJECT;
    } else {
      $sType = OBIB_SEARCH_TITLE;
    }
  }
*/
  #****************************************************************************
  #*  Search database
  #****************************************************************************
  $biblioQ = new BiblioQuery();
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
  
  if (!$biblioQ->pendienteDeApronacion($currentPageNmbr)) 
  {
    $biblioQ->close();
    displayErrorPage($biblioQ);
  }

  #**************************************************************************
  #*  Show search results
  #**************************************************************************
  if ($tab == "opac") {
    require_once("../shared/header_opac.php");
  } else {
    require_once("../shared/header.php");
  }
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,"shared");

  # Display no results message if no results returned from search.
  if ($biblioQ->getRowCount() == 0) {
    $biblioQ->close();
    echo $loc->getText("biblioSearchNoResults");
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
<form name="changePageForm" method="POST" action="../catalog/aprueba_material.php">
  <input type="hidden" name="lookup" value="<?php echo $_POST["lookup"];?>">
  <input type="hidden" name="page" value="1">
  <input type="hidden" name="tab" value="<?php echo $tab;?>">
</form>

<!--**************************************************************************
    *  Printing result stats and page nav
    ************************************************************************** -->
<?php 
  echo $loc->getText("biblioSearchResultTxt",array("items"=>$biblioQ->getRowCount()));
  if ($biblioQ->getRowCount() > 1) {
    echo " .No Ordenado"/*$loc->getText("biblioSearch"."$sortBy")*/;
   /* if ($sortBy == "author") {
      echo "(<a href=\"javascript:changePage(".$currentPageNmbr.",'title')\">".$loc->getText("biblioSearchSortByTitle")."</a>).";
    } else {
      echo "(<a href=\"javascript:changePage(".$currentPageNmbr.",'author')\">".$loc->getText("biblioSearchSortByAuthor")."</a>).";
    }*/
  }
?>
<br>
<?php printResultPages($loc, $currentPageNmbr, $biblioQ->getPageCount(), $sortBy); ?><br>
<br>

<!--**************************************************************************
    *  Printing result table
    ************************************************************************** -->
<table class="primary" align="center">
  <tr>
    <th valign="top" nowrap="yes" align="left" colspan="3">
      <?php echo $loc->getText("biblioSearchResults"); ?>: &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
 &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
 &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp
 &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp 
    </th>
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
        	<td nowrap="true" class="primary" valign="top" align="center" rowspan="2">
		    <?php echo $biblioQ->getCurrentRowNmbr();?>.<br />
    	    
    		</td>
    		<td class="primary" valign="top" colspan="2">
		 <table class="primary" width="100%"> 
        	<tr>

<a href="../catalog/material_view.php?bibid=<?php echo $biblio->getBibid();?>&tab=<?php echo $tab;?>">
			<?php echo $biblio->getTitle(); ?></a> 
        	</tr>
        <!--	<tr>
          
        	</tr>
        	<tr>
          
	        </tr>
        <tr>
        </tr> -->
        <tr>
<?php /*echo $biblioQ->getPageCount()." ".$currentPageNmbr." ".$loc." ".  $sortBy; */?>
        </tr>
      </table>
    </td>
  </tr>
  <?php
    
	 ?>
     <tr>
        
      </tr> 
    <?php 
    
    }
    }
    $biblioQ->close();
  ?>
  </table><br>
<?php printResultPages($loc, $currentPageNmbr, $biblioQ->getPageCount(), $sortBy); ?><br>
<?php require_once("../shared/footer.php"); ?>
