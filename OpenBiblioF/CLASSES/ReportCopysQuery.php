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

require_once("../shared/global_constants.php");
require_once("../classes/Query.php");
require_once("../classes/BiblioCopy.php");

/******************************************************************************
 * BiblioCopyQuery data access component for library bibliography copies
 *
 * @author David Stevens <dave@stevens.name>;
 * @version 1.0
 * @access public
 ******************************************************************************
 */
class ReportCopysQuery extends Query {
  var $_rowCount = 0;
  var $_loc;

  /* ini franco 1/08/5
agregado para poder realizar la paginacion de aprobar material
  */
  var $_itemsPerPage = 1;
  var $_rowNmbr = 0;
  var $_currentRowNmbr = 0;
  var $_currentPageNmbr = 0;
  var $_pageCount = 0;

  //fin franco


  function ReportCopysQuery() 
  {
     $this->_loc = new Localize(OBIB_LOCALE,"classes");
  }

  //ini 1/08/05 para paginacion
  //pendiente de aprobacion
  
  function setItemsPerPage($value) 
  {
    $this->_itemsPerPage = $value;
  }
  function getCurrentRowNmbr() 
  {
    return $this->_currentRowNmbr;
  }
  function getPageCount() 
  {
    return $this->_pageCount;
  }

  function getLineNmbr() 
  {
    return $this->_rowNmbr;
  }
//fin franco


  function getRowCount() {
    return $this->_rowCount;
  }


  /****************************************************************************
   * Executes a query to select ONLY ONE COPY
   * @param string $bibid bibid of bibliography copy to select
   * @param string $copyid copyid of bibliography copy to select
   * @return Copy returns copy or false, if error occurs
   * @access public
   ****************************************************************************
   */
  function query($bibid,$copyid) {
    # setting query that will return all the data
    $sql = $this->mkSQL("select biblio_copy.*, "
                        . " greatest(0,to_days(sysdate()) - to_days(biblio_copy.due_back_dt)) days_late "
                        . "from biblio_copy "
                        . "where biblio_copy.bibid = %N"
                        . " and biblio_copy.copyid = %N",
                        $bibid, $copyid);

    if (!$this->_query($sql, $this->_loc->getText("biblioCopyQueryErr4"))) {
      return false;
    }
    $this->_rowCount = $this->_conn->numRows();
    return $this->fetchCopy();
  }

  /****************************************************************************
   * Executes a query to select ONLY ONE COPY by barcode
   * @param string $barcode barcode of bibliography copy to select
   * @return Copy returns copy or true if barcode doesn't exist,
   *              false on error
   * @access public
   ****************************************************************************
   */
  function queryByBarcode($barcode) {
    # setting query that will return all the data
    $sql = $this->mkSQL("select biblio_copy.*, "
                        . "greatest(0,to_days(sysdate()) - to_days(biblio_copy.due_back_dt)) days_late "
                        . "from biblio_copy where biblio_copy.barcode_nmbr = %Q",
                        $barcode);

    if (!$this->_query($sql, $this->_loc->getText("biblioCopyQueryErr4"))) {
      return false;
    }
    $this->_rowCount = $this->_conn->numRows();
    if ($this->_rowCount == 0) {
      return true;
    }
    return $this->fetchCopy();
  }


  /****************************************************************************
   * Executes a query to select ALL COPIES belonging to a particular bibid
   * @param string $bibid bibid of bibliography copies to select
   * @return boolean returns false, if error occurs
   * @access public
   ****************************************************************************
   */
  function execSelect($bibid) {
    # setting query that will return all the data
    $sql = $this->mkSQL("select biblio_copy.* "
                        . ",greatest(0,to_days(sysdate()) - to_days(biblio_copy.due_back_dt)) days_late "
                        . "from biblio_copy where biblio_copy.bibid = %N",
                        $bibid);

    if (!$this->_query($sql, $this->_loc->getText("biblioCopyQueryErr4"))) {
      return false;
    }
    $this->_rowCount = $this->_conn->numRows();
    return true;
  }

  /****************************************************************************
   * Fetches a row from the query result and populates the BiblioCopy object.
   * @return BiblioCopy returns bibliography copy or false if no more
   *                    bibliography copies to fetch
   * @access public
   ****************************************************************************
   */
  function fetchCopy() {
    $array = $this->_conn->fetchRow();
    if ($array == false) {
      return false;
    }

    $copy = new BiblioCopy();
    $copy->setBibid($array["bibid"]);
    $copy->setCopyid($array["copyid"]);
    $copy->setCopyDesc($array["copy_desc"]);
    $copy->setBarcodeNmbr($array["barcode_nmbr"]);
    $copy->setStatusCd($array["status_cd"]);
    $copy->setStatusBeginDt($array["status_begin_dt"]);
    $copy->setDueBackDt($array["due_back_dt"]);
    $copy->setDaysLate($array["days_late"]);
    $copy->setMbrid($array["mbrid"]);
    /* ini franco 08/07/05*/
    $copy->setVolumen($array["copy_volumen"]);
    $copy->setTomo($array["copy_tomo"]);
    $copy->setProveedor($array["copy_proveedor"]);
    $copy->setPrecio($array["copy_precio"]);
    $copy->setCodLoc($array["copy_cod_loc"]);
	$copy->setUserCreador($array["copy_user_creador"]);
	$copy->setDateSptu($array["copy_date_sptu"]);
    /* fin franco*/
    return $copy;
  }

  /****************************************************************************
   * Returns true if barcode number already exists
   * @param string $barcode Bibliography barcode number
   * @param string $bibid Bibliography id
   * @return boolean returns true if barcode already exists
   * @access private
   ****************************************************************************
   */
  function _dupBarcode($barcode, $bibid=0, $copyid=0) {
    $sql = $this->mkSQL("select count(*) from biblio_copy "
                        . "where barcode_nmbr = %Q "
                        . " and not (bibid = %N and copyid = %N) ",
                        $barcode, $bibid, $copyid);
    if (!$this->_query($sql, $this->_loc->getText("biblioCopyQueryErr1"))) {
      return false;
    }
    $array = $this->_conn->fetchRow(OBIB_NUM);
    if ($array[0] > 0) {
      return true;
    }
    return false;
  }

  /****************************************************************************
   * Inserts a new bibliography copy into the biblio_copy table.
   * @param BiblioCopy $copy bibliography copy to insert
   * @return boolean returns false, if error occurs
   * @access public
   ****************************************************************************
   */
  function insert($copy) {
    # checking for duplicate barcode number
    $dupBarcode = $this->_dupBarcode($copy->getBarcodeNmbr());
    if ($this->errorOccurred()) return false;
    if ($dupBarcode) {
      $this->_errorOccurred = true;
      $this->_error = $this->_loc->getText("biblioCopyQueryErr2",array("barcodeNmbr"=>$copy->getBarcodeNmbr()));
      return false;
    }
    $sql = $this->mkSQL("insert into biblio_copy values (%N"
                        . ",null, %Q, %Q, %Q, sysdate(), ",
                        $copy->getBibid(), $copy->getCopyDesc(),
                        $copy->getBarcodeNmbr(), $copy->getStatusCd());
    if ($copy->getDueBackDt() == "") {
      $sql .= "null, ";
    } else {
      $sql .= $this->mkSQL("%Q, ", $copy->getDueBackDt());
    }
    if ($copy->getMbrid() == "") {
      $sql .= "null,";
    } else {
      $sql .= $this->mkSQL("%Q,", $copy->getMbrid());
    }
    $sql.= $this->mkSQL("%Q,%Q,%N,%Q,%N,%N,%Q,%N)",$copy->getVolumen(),$copy->getTomo(),$copy->getUserCreador(),$copy->getProveedor(),$copy->getPrecio(),$copy->getCodLoc(),$copy->getDateSptu(),0);
	// ini franco 26/07/05
    if(!$this->_query($sql, $this->_loc->getText("biblioCopyQueryErr3")))
		return false;
	else
	{
	    $copyid = $this->_conn->getInsertId();
		if (!$this->insertAuditoria($copy->getBibid(),$copyid,$_SESSION["userid"],1,"biblio_copy",$this->_loc->getText("biblioCopyQueryErr3")))
		{
			  return false;
		}
		return true;
	}
	// fin franco
  }

  /****************************************************************************
   * Updates a bibliography in the biblio table.
   * @param Biblio $biblio bibliography to update
   * @param boolean $checkout is this a checkout operation? default FALSE
   * @return boolean returns false, if error occurs
   * @access public
   ****************************************************************************
   */
  function update($copy, $checkout=FALSE) {
    # checking for duplicate barcode number
    if (!$checkout) {
      $dupBarcode = $this->_dupBarcode($copy->getBarcodeNmbr(), $copy->getBibid(), $copy->getCopyid());
      if ($this->errorOccurred()) return false;
      if ($dupBarcode) {
        $this->_errorOccurred = true;
        $this->_error = $this->_loc->getText("biblioCopyQueryErr2",array("barcodeNmbr"=>$copy->getBarcodeNmbr()));
        return false;
      }
    }
    $sql = $this->mkSQL("update biblio_copy set "
                        . "status_cd=%Q, "
                        . "status_begin_dt=sysdate(), ",
                        $copy->getStatusCd());

    if ($copy->getStatusCd() == OBIB_STATUS_OUT){
      if ($copy->getDueBackDt() != "") {
        $sql .= $this->mkSQL("due_back_dt=date_add(sysdate(),interval %N day), ",
                             $copy->getDueBackDt());
      } else {
        $sql .= "due_back_dt=null, ";
      }
      if ($copy->getMbrid() != "") {
        $sql .= $this->mkSQL("mbrid=%N, ", $copy->getMbrid());
      } else {
        $sql .= "mbrid=null, ";
      }
    }
    $sql .= $this->mkSQL("copy_desc=%Q, barcode_nmbr=%Q, copy_volumen=%Q, copy_tomo=%Q, copy_user_creador=%N, copy_proveedor=%Q, copy_precio=%N, copy_cod_loc=%N, copy_date_sptu=%Q  "
                         . "where bibid=%N and copyid=%N",
                         $copy->getCopyDesc(), $copy->getBarcodeNmbr(),
                         $copy->getVolumen(), $copy->getTomo(), $copy->getUserCreador(), $copy->getProveedor(), $copy->getPrecio(), $copy->getCodLoc(), $copy->getDateSptu(),$copy->getBibid(), $copy->getCopyid());
// ini franco 26/07/05
//insertando en aduitoria los accesosa ala bd
    if(!$this->_query($sql, $this->_loc->getText("biblioCopyQueryErr5")))
		return false;
	else
	{
  		
		if (!$this->insertAuditoria($copy->getBibid(),$copy->getCopyid(),$_SESSION["userid"],3,"biblio_copy",$this->_loc->getText("biblioCopyQueryErr5")))
		{
			  return false;
		}
		return true;
	}
//fin franco
  }

  /****************************************************************************
   * Deletes a copy from the biblio_copy table.
   * @param string $bibid bibliography id of copy to delete
   * @param string $copyid optional copy id of copy to delete.  If none
   *               supplied then all copies under a given bibid will be deleted.
   * @return boolean returns false, if error occurs
   * @access public
   ****************************************************************************
   */
  function delete($bibid,$copyid=0) {
    $sql = $this->mkSQL("delete from biblio_copy where bibid = %N", $bibid);
    if ($copyid > 0) {
      $sql .= $this->mkSQL(" and copyid = %N", $copyid);
    }
    if(!$this->_query($sql, $this->_loc->getText("biblioCopyQueryErr6")))
		return false;
	else
	{
		if (!$this->insertAuditoria($bibid,$copyid,$_SESSION["userid"],2,"biblio_copy",$this->_loc->getText("biblioCopyQueryErr6")))
		{
			  return false;
		}
		return true;
	}
  }

  /****************************************************************************
   * Retrieves collection info
   * @param int $bibid
   * @access private
   ****************************************************************************
   */
  function _getCollectionInfo($bibid) {
    // first get collection code
    $sql = $this->mkSQL("select collection_cd from biblio where bibid = %N",
                        $bibid);
    if (!$this->_query($sql, $this->_loc->getText("biblioCopyQueryErr7"))) {
      return false;
    }
    $array = $this->_conn->fetchRow();
    $collectionCd = $array["collection_cd"];

    // now read collection domain for days due back
    $sql = $this->mkSQL("select * from collection_dm where code = %N",
                        $collectionCd);
    if (!$this->_query($sql, $this->_loc->getText("biblioCopyQueryErr8"))) {
      return false;
    }
    return $this->_conn->fetchRow();
  }

  /****************************************************************************
   * Retrieves days due back for a given copy's collection code
   * @param BilioCopy $copy bibliography copy object to get days due back
   * @return integer days due back or false, if error occurs
   * @access public
   ****************************************************************************
   */
  function getDaysDueBack($copy) {
    $array = $this->_getCollectionInfo($copy->getBibid());
    return $array["days_due_back"];
  }

  /****************************************************************************
   * Retrieves daily late fee for a given copy's collection code
   * @param BiblioCopy $copy bibliography copy object to get days due back
   * @return decimal daily late fee or false, if error occurs
   * @access public
   ****************************************************************************
   */
  function getDailyLateFee($copy) {
    $array = $this->_getCollectionInfo($copy->getBibid());
    return $array["daily_late_fee"];
  }

  /****************************************************************************
   * Update biblio copies to set the status to checked in
   * @param boolean $massCheckin checkin all shelving cart copies
   * @param array $bibids array of bibids to checkin
   * @param array $copyids array of copyids to checkin
   * @return boolean false, if error occurs
   * @access public
   ****************************************************************************
   */
  function checkin($massCheckin,$bibids,$copyids) {
    $sql = $this->mkSQL("update biblio_copy set "
                        . " status_cd=%Q, status_begin_dt=sysdate(), "
                        . " due_back_dt=null, mbrid=null "
                        . "where status_cd=%Q ",
                        OBIB_STATUS_IN, OBIB_STATUS_SHELVING_CART);
    if (!$massCheckin) {
      $prefix = "and (";
      for ($i = 0; $i < count($bibids); $i++) {
        $sql .= $prefix;
	$sql .= $this->mkSQL("(bibid=%N and copyid=%N)",
                             $bibids[$i], $copyids[$i]);
        $prefix = " or ";
      }
      $sql .= ")";
    }
    return $this->_query($sql, $this->_loc->getText("biblioCopyQueryErr9"));
  }

  /****************************************************************************
   * determines if checkout limit for given member and material type has been reached
   * @param int $mbrid member id
   * @param String $classification member classification code
   * @param int $bibid bibliography id of bibliography material type to check for
   * @return boolean true if member has reached limit, otherwise false
   * @access public
   ****************************************************************************
   */
  function hasReachedCheckoutLimit($mbrid,$classification,$bibid) {
    // get material code for given bibid
    $sql = $this->mkSQL("select material_cd from biblio where bibid = %N",
                        $bibid);
    if (!$this->_query($sql, $this->_loc->getText("biblioCopyQueryErr10"))) {
      return false;
    }
    $array = $this->_conn->fetchRow();
    $materialCd = $array["material_cd"];

    // get checkout limits from material_type_dm
    $sql = $this->mkSQL("select * from material_type_dm where code = %N",
                        $materialCd);
    if (!$this->_query($sql, $this->_loc->getText("biblioCopyQueryErr10"))) {
      return false;
    }
    $array = $this->_conn->fetchRow();
    if ($classification == OBIB_MBR_CLASSIFICATION_JUVENILE) {
      $checkoutLimit = $array["juvenile_checkout_limit"];
    } else {
      $checkoutLimit = $array["adult_checkout_limit"];
    }

    // get member's current checkout count for given material type
    $sql = $this->mkSQL("select count(*) row_count from biblio_copy, biblio"
                        . " where biblio_copy.bibid = biblio.bibid"
                        . " and biblio_copy.mbrid = %N"
                        . " and biblio.material_cd = %N",
                        $mbrid, $materialCd);
    if (!$this->_query($sql, $this->_loc->getText("biblioCopyQueryErr10"))) {
      return false;
    }
    $array = $this->_conn->fetchRow();
    $rowCount = $array["row_count"];
    if ($rowCount >= $checkoutLimit) {
      return TRUE;
    }
    return FALSE;
  }



	//funcion utilizada unicamente para aprobar ejemplar
	//creada el 1-8-05

	function viewCopys($page,$fecha1,$fecha2)
	{

		# reset stats
		$this->_rowNmbr = 0;
		$this->_currentRowNmbr = 0;
		$this->_rowCount = 0;
		$this->_currentPageNmbr=$page;
		$this->_pageCount = 0;
			
		# setting count query
    	$sqlcount = "SELECT count(*) AS rowcount "
					."FROM biblio_copy, biblio "
					."WHERE biblio_copy.bibid = biblio.bibid "
					."AND biblio_copy.status_begin_dt >= '$fecha1' AND biblio_copy.status_begin_dt <= '$fecha2' ";
		//echo "<br>Sqlcount: $sqlcount";
		
		# setting query that will return all the data
		$sql = $this->mkSQL("SELECT biblio_copy.bibid, biblio_copy.copyid, "
							."biblio_copy.barcode_nmbr, biblio.title, "
							."biblio_copy.copy_precio, biblio_copy.status_begin_dt,  "
							."biblio_copy.copy_cod_loc, biblio_copy.copy_user_creador "
							."FROM biblio, biblio_copy "
							."WHERE biblio_copy.bibid = biblio.bibid "
							."AND biblio_copy.status_begin_dt >= %Q AND biblio_copy.status_begin_dt <= %Q ", $fecha1,$fecha2);
	
		# setting limit so we can page through the results
	    $offset = ($page - 1) * $this->_itemsPerPage;
    	$limit = $this->_itemsPerPage;
	    $sql .= $this->mkSQL(" limit %N, %N", $offset, $limit);
		//echo "<br>final: $sql";
		# Running row count sql statement
		if (!$this->_query($sqlcount, $this->_loc->getText("biblioSearchQueryErr1"))) 
		{
		 return false;
		}
		# Calculate stats based on row count
		$array = $this->_conn->fetchRow();
		$this->_rowCount = $array["rowcount"];
		$this->_pageCount = ceil($this->_rowCount / $this->_itemsPerPage);
		return $this->_query($sql, $this->_loc->getText("error en paginacion"));
    }
 	//funcion utilizada unicamente para aprobar material
	//creada el 27-28/07/05 modificada 29/07/05//

	  function fetchRowFranco()
	  {
    	$array = $this->_conn->fetchRow();
	    if ($array == false) 
	    {
    	  return false;
    	}

	    # increment rowNmbr
    	$this->_rowNmbr = $this->_rowNmbr + 1;
	    $this->_currentRowNmbr = $this->_rowNmbr + (($this->_currentPageNmbr - 1) * $this->_itemsPerPage);
	
	    $bib = new BiblioCopy();
    	$bib->setBibid($array["bibid"]);
		$bib->setTitle($array["title"]);
		$bib->setCopyid($array["copyid"]);
		$bib->setBarcodeNmbr($array["barcode_nmbr"]);
	    $bib->setStatusBeginDt($array["status_begin_dt"]);
		$bib->setPrecio($array["copy_precio"]);
		$bib->setCodLoc($array["copy_cod_loc"]);
		$bib->setUserCreador($array["copy_user_creador"]);
		return $bib;
  	  }
	
    function updateFlgAprobacion($bibid,$copyid)
	{
 		//echo  "no lo hizo";
		if(!is_numeric($bibid))
		{
		 settype($bibid,"integer");
		 settype($copyid,"integer");
		}
		// updating biblio_copy table
    	$sql = $this->mkSQL("update biblio_copy set aprob_flg=%N ",1);
		$sql.= $this->mkSQL("where bibid=%N and copyid=%N ",$bibid,$copyid);
		if (!$this->_query($sql, $this->_loc->getText("biblioQueryUpdateErr1"))) 
    	{  
 		//echo  "no lo hizo";
		return false;
    	}
		// 29/07/05 ini franco 
		else
		{
		//echo  "sio aca esta el maltido lo hizo". $bibid;
		$bi=$bibid;
			if (!$this->insertAuditoria($bi,$copyid,$_SESSION["userid"],3,"biblio_copy",$this->_loc->getText("biblioQueryInsertErr1")))
			{
				//echo  "no lo hizo auditoria";
			  	return false;
			}
			if (!$this->insertAuditoria($bi,$copyid,$_SESSION["userid"],4,"biblio_copy",$this->_loc->getText("biblioQueryInsertErr1")))
			{
			  //echo  "no lo hizo auditoria2";
			  return false;
			}
		
		}
		// fin franco
		return true;
	}


}

?>
