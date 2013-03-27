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
require_once("../classes/BiblioAnalitica.php");

/******************************************************************************
 * BiblioCopyQuery data access component for library bibliography copies
 *
 * @author David Stevens <dave@stevens.name>;
 * @version 1.0
 * @access public
 ******************************************************************************
 */
class BiblioAnaliticaQuery extends Query {
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


  function BiblioAnaliticaQuery() 
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
  function query($bibid,$anaid) {
    # setting query that will return all the data
	//echo "bibid ".$bibid." anaid ".$anaid;
    $sql = $this->mkSQL("select biblio_analitica.* "
                       
                        . "from biblio_analitica "
                        . "where biblio_analitica.bibid = %N"
                        . " and biblio_analitica.anaid = %N",
                        $bibid, $anaid);
//echo "sql ".$sql;
    if (!$this->_query($sql, $this->_loc->getText("biblioAnaliticaQueryErr4"))) {
      return false;
    }
    $this->_rowCount = $this->_conn->numRows();
    return $this->fetchAnalitica();
  }

  /****************************************************************************
   * Executes a query to select ONLY ONE COPY by barcode
   * @param string $barcode barcode of bibliography copy to select
   * @return Copy returns copy or true if barcode doesn't exist,
   *              false on error
   * @access public
   ****************************************************************************
   */
/*  function queryByBarcode($barcode) {
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
  }*/


  /****************************************************************************
   * Executes a query to select ALL COPIES belonging to a particular bibid
   * @param string $bibid bibid of bibliography copies to select
   * @return boolean returns false, if error occurs
   * @access public
   ****************************************************************************
   */
  function execSelect($bibid) {
    # setting query that will return all the data
    $sql = $this->mkSQL("select biblio_analitica.* "
                        
                        . "from biblio_analitica where biblio_analitica.bibid = %N",
                        $bibid);

    if (!$this->_query($sql, $this->_loc->getText("biblioAnaliticaQueryErr4"))) {
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
  function fetchAnalitica() {
    $array = $this->_conn->fetchRow();
    if ($array == false) {
      return false;
    }

    $analitica = new BiblioAnalitica();
    $analitica->setBibid($array["bibid"]);
    $analitica->setAnaid($array["anaid"]);
    $analitica->setTitulo($array["ana_titulo"]);
	$analitica->setSubTitulo($array["ana_subtitulo"]);
    $analitica->setAutor($array["ana_autor"]);
    $analitica->setPaginacion($array["ana_paginacion"]);
    $analitica->setMateria($array["ana_materia"]);
	$analitica->setUserCreador($array["ana_user"]);


    return $analitica;
  }

  /****************************************************************************
   * Returns true if barcode number already exists
   * @param string $barcode Bibliography barcode number
   * @param string $bibid Bibliography id
   * @return boolean returns true if barcode already exists
   * @access private
   ****************************************************************************
   */
/*  function _dupBarcode($barcode, $bibid=0, $copyid=0) {
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
  } */

  /****************************************************************************
   * Inserts a new bibliography copy into the biblio_copy table.
   * @param BiblioCopy $copy bibliography copy to insert
   * @return boolean returns false, if error occurs
   * @access public
   ****************************************************************************
   */
  function insert($analitica) 
  {
    $sql = $this->mkSQL("insert into biblio_analitica values (%N"
                        . ",null, %Q, %Q, %Q, ",
                        $analitica->getBibid(), $analitica->getAnaliticaTitulo(),
                        $analitica->getAnaliticaAutor(), $analitica->getAnaliticaPaginacion());
    $sql.= $this->mkSQL("%Q,%N,%N,sysdate(),%Q)",$analitica->getAnaliticaMateria(),$analitica->getUserCreador(),0, $analitica->getAnaliticaSubTitulo());
	//echo"<h1>".$sql."</h1>";
    if(!$this->_query($sql, $this->_loc->getText("biblioAnaliticaQueryErr3")))
		return false;
	else
	{
	    $anaid = $this->_conn->getInsertId();
		if (!$this->insertAuditoria($analitica->getBibid(),$anaid,$_SESSION["userid"],1,"biblio_analitica",$this->_loc->getText("biblioAnaliticaQueryErr3")))
		{
			  return false;
		}
		return true;
	}

  }

  /****************************************************************************
   * Updates a bibliography in the biblio table.
   * @param Biblio $biblio bibliography to update
   * @param boolean $checkout is this a checkout operation? default FALSE
   * @return boolean returns false, if error occurs
   * @access public
   ****************************************************************************
   */
  function update($analitica) 
  {
    $sql = $this->mkSQL("update biblio_analitica set "
                        . "status_begin_dt=sysdate(), ");
    $sql .= $this->mkSQL("ana_titulo=%Q, ana_autor=%Q, ana_paginacion=%Q, ana_materia=%Q, ana_subtitulo=%Q "
                         . "where bibid=%N and anaid=%N",
                         $analitica->getAnaliticaTitulo(), $analitica->getAnaliticaAutor(),
                         $analitica->getAnaliticaPaginacion(), $analitica->getAnaliticaMateria(), $analitica->getAnaliticaSubTitulo(), 
						 $analitica->getBibid(), $analitica->getAnaid());

	//echo"<h1>".$sql."</h1>";
    if(!$this->_query($sql, $this->_loc->getText("biblioAnaliticaQueryErr5")))
		return false;
	else
	{
  		
		if (!$this->insertAuditoria($analitica->getBibid(),$analitica->getAnaid(),$_SESSION["userid"],3,"biblio_analitica",$this->_loc->getText("biblioAnaliticaQueryErr5")))
		{
			  return false;
		}
		return true;
	}

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
  function delete($bibid,$anaid=0) 
  {
    $sql = $this->mkSQL("delete from biblio_analitica where bibid = %N", $bibid);
    if ($anaid > 0)
	 {
      $sql .= $this->mkSQL(" and anaid = %N", $anaid);
    }
    if(!$this->_query($sql, $this->_loc->getText("biblioAnaliticaQueryErr6")))
		return false;
	else
	{
		if (!$this->insertAuditoria($bibid,$anaid,$_SESSION["userid"],2,"biblio_analitica",$this->_loc->getText("biblioAnaliticaQueryErr6")))
		{
			  return false;
		}
		return true;
	}
  }

}
?>