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
  if (count($_POST) == 0) {
    header("Location: ../catalog/index.php");
    exit();
  }

  #****************************************************************************
  #*  Checking for tab name to show OPAC look and feel if searching from OPAC
  #****************************************************************************
  $tab = "cataloging";
  $lookup = "N";
  if (isset($_POST["tab"])) {
    $tab = $_POST["tab"];
  }
  if (isset($_POST["lookup"])) {
    $lookup = $_POST["lookup"];
  }

  $nav = "search";
  require_once("../shared/common.php");
  if ($tab != "opac") {
    require_once("../shared/logincheck.php");
  }
  require_once("../classes/BiblioSearch.php");
  require_once("../classes/BiblioSearchQuery.php");
  require_once("../functions/searchFuncs.php");
  require_once("../classes/DmQuery.php");
  require_once("../classes/BiblioHoldQuery.php");
  
  Header("Content-type: application/vnd.ms-excel; charset=".OBIB_CHARSET.";");
  Header("Content-disposition: attachment; filename=busqueda_opac.csv");  

  #****************************************************************************
  #*  Function declaration only used on this page.
  #****************************************************************************
  function printResultPages(&$loc, $currPage, $pageCount, $sort) {
    if ($pageCount <= 1) {
      return false;
    }
    echo $loc->getText("biblioSearchResultPages").": ";
    $maxPg = OBIB_SEARCH_MAXPAGES + 1;
    if ($currPage > 1) {
      echo "<a href=\"javascript:changePage(".($currPage-1).",'".$sort."')\">&laquo;".$loc->getText("biblioSearchPrev")."</a> ";
    }
    for ($i = 1; $i <= $pageCount; $i++) {
      if ($i < $maxPg) {
        if ($i == $currPage) {
          echo "<b>".$i."</b> ";
        } else {
          echo "<a href=\"javascript:changePage(".$i.",'".$sort."')\">".$i."</a> ";
        }
      } elseif ($i == $maxPg) {
        echo "... ";
      }
    }
    if ($currPage < $pageCount) {
      echo "<a href=\"javascript:changePage(".($currPage+1).",'".$sort."')\">".$loc->getText("biblioSearchNext")."&raquo;</a> ";
    }
  }

  function printCopySection($copyBarcodes,$copyStatus) {
    echo "<tr><td class=\"primary\" valign=\"top\"><font class=\"small\">";
    echo "<b>Barcode</b></font></td>";
    echo "<td class=\"primary\" nowrap=\"true\" valign=\"top\"><font class=\"small\">";
    echo "<b>Status</b></font></td></tr>";
    echo "<tr><td class=\"primary\" valign=\"top\" height=\"50\"><font class=\"small\">";
    echo $copyBarcodes;
    echo "</font></td>";
    echo "<td class=\"primary\" nowrap=\"true\" valign=\"top\"><font class=\"small\">";
    echo $copyStatus;
    echo "</font></td></tr>";
  }


  #****************************************************************************
  #*  Loading a few domain tables into associative arrays
  #****************************************************************************
  $dmQ = new DmQuery();
  $dmQ->connect();
  if ($dmQ->errorOccurred()) {
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
  $dmQ->close();

  #****************************************************************************
  #*  Retrieving post vars and scrubbing the data
  #****************************************************************************
  if (isset($_POST["page"])) {
    $currentPageNmbr = $_POST["page"];
  } else {
    $currentPageNmbr = 1;
  }
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
    } elseif ($searchType == "subject")
	 {
    	  $sType = OBIB_SEARCH_SUBJECT;
      }
	  else
	  {
	  	if($searchType == "signatura")
	    	  $sType = OBIB_SEARCH_SIGNATURA;
		else
		{	if($searchType == "material")
	    	  $sType = OBIB_SEARCH_MATERIAL;
			 elseif($searchType == "autor_corporativo")
			 {
			  $sType = OBIB_SEARCH_AUTOR_CORPORATIVO;
			 }
			 elseif($searchType == "author_analitica")
			 {
			  $sType = OBIB_SEARCH_AUTOR_ANALITICA;
			 }			  
			 else
			 {
			 	//si en isbn no hay nada 
				//hace q la busqueda sea por title
				//osea la de defecto
			 	if($searchType == "isbn" && !empty($words[0]))
				{
				//  echo"<h1>no esta vacio</h1>";
				  $sType = OBIB_SEARCH_ISBN;
				}
				elseif($searchType == "bibid")/*BIBID: Judith 20/10/2006*/
				    $sType = OBIB_SEARCH_BIBID;
			 	elseif($searchType == "coleccion")
				    $sType = OBIB_SEARCH_COLECCION;
			 	elseif($searchType == "nombre_editor")
				    $sType = OBIB_SEARCH_NOMBRE_EDITOR;
			 	elseif($searchType == "nota")
				    $sType = OBIB_SEARCH_NOTA;
			 	elseif($searchType == "title_analitica")
				    $sType = OBIB_SEARCH_ANALITICA;															
				else
		       		$sType = OBIB_SEARCH_TITLE;				
			}
		}
      }
  }

  #****************************************************************************
  #*  Search database
  #****************************************************************************
  $biblioQ = new BiblioSearchQuery();
  $biblioQ->setItemsPerPage(9999999);
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
  if (!$biblioQ->search($sType,$words,$currentPageNmbr,$sortBy,$opacFlg)) {
    $biblioQ->close();
    displayErrorPage($biblioQ);
  }

  #**************************************************************************
  #*  Show search results
  #**************************************************************************
  require_once("../classes/Localize.php");
  $loc = new Localize(OBIB_LOCALE,"shared");

  # Display no results message if no results returned from search.
  if ($biblioQ->getRowCount() == 0) {
    $biblioQ->close();
    echo $loc->getText("biblioSearchNoResults");
    require_once("../shared/footer.php");
    exit();
  }


    echo $loc->getText("biblioSearchResults")." \n\n"; 
	
    $priorBibid = 0;
    while ($biblio = $biblioQ->fetchRow()) 
	      {
          if ($biblio->getBibid() == $priorBibid) 
		      {
             if ($biblio->getBarcodeNmbr() != "") 
                   {
                   #************************************
                   #* print copy line only
                   #************************************
                   echo $loc->getText("biblioSearchCopyBCode").","; 
		               echo $biblio->getBarcodeNmbr().",";
                   echo $loc->getText("biblioSearchCopyStatus").",";	
					         $holdQ=new BiblioHoldQuery();
	                 $holdQ->connect();
	                 $hold=$holdQ->getFirstHold($biblio->getBibid(),$biblio->getCopyid());
		               if($hold!=FALSE)
		                   echo "Reservado,";
		               else
		                   echo $biblioStatusDm[$biblio->getStatusCd()].",";
                   }
             echo " \n";
        }
        else 
             {
             echo " \n";
             $priorBibid = $biblio->getBibid();
             $biblioQ->getCurrentRowNmbr();
             echo $loc->getText("biblioSearchTitle").",";
	           echo $biblio->getTitle()." \n";
             echo $loc->getText("biblioSearchAuthor").",";
			 $author = str_replace("|","-",$biblio->getAuthor());
			 $author = str_replace(","," ",$author);
             if ($author != "") 
	               echo $author;
	           echo " \n";
             echo $loc->getText("biblioSearchResponsibility_Stmt").",";
			 $responsibilityStmt = str_replace("|","-",$biblio->getResponsibilityStmt());
			 $responsibilityStmt = str_replace(","," ",$responsibilityStmt);			 
             if ($responsibilityStmt != "") 
	               echo $responsibilityStmt.",";
	           echo " \n";    
             echo "Tipo de Material,";
             echo $materialTypeDm[$biblio->getMaterialCd()]." \n";
             echo $loc->getText("biblioSearchCollection").",";
             echo $collectionDm[$biblio->getCollectionCd()]." \n";
             echo $loc->getText("biblioSearchCall").",";
             echo $biblio->getCallNmbr1()." ".$biblio->getCallNmbr2()." ".$biblio->getCallNmbr3()." \n";
             if ($biblio->getBarcodeNmbr() != "") 
                 {
                 echo $loc->getText("biblioSearchCopyBCode").",";
	               echo $biblio->getBarcodeNmbr().",";
                 echo $loc->getText("biblioSearchCopyStatus").",";
		             $holdQ=new BiblioHoldQuery();
	               $holdQ->connect();
	               $hold=$holdQ->getFirstHold($biblio->getBibid(),$biblio->getCopyid());
		             if($hold!=FALSE)
		                {
		                 echo "Reservado,";
		                 echo " / A Devolver: ".toDDmmYYYY($biblio->getDueBackDt()).",";
		                }
		             else
		                {
		                echo $biblioStatusDm[$biblio->getStatusCd()].",";
			              if($biblio->getStatusCd() == 'out')
			                 echo " / A Devolver: ".toDDmmYYYY($biblio->getDueBackDt()).",";
		                }
		             echo " \n";
		             } 
		         else 
		              { 
                  echo $loc->getText("biblioSearchNoCopies").",";
                  }
             }
        }
    $biblioQ->close();
  ?>
