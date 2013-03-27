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

require_once("../classes/Adquisicion.php");
require_once("../shared/global_constants.php");
require_once("../classes/Query.php");
require_once("../classes/Dm.php");
require_once("../classes/DmQuery.php");

/******************************************************************************
 * MemberQuery data access component for library members
 *
 * @author David Stevens <dave@stevens.name>;
 * @version 1.0
 * @access public
 ******************************************************************************
 */
class AdquisicionQuery extends Query {
  var $_itemsPerPage = 1;
  var $_rowNmbr = 0;
  var $_currentRowNmbr = 0;
  var $_currentPageNmbr = 0;
  var $_rowCount = 0;
  var $_pageCount = 0;

  function setItemsPerPage($value) {
    $this->_itemsPerPage = $value;
  }
  function getCurrentRowNmbr() {
    return $this->_currentRowNmbr;
  }
  function getRowCount() {
    return $this->_rowCount;
  }
  function getPageCount() {
    return $this->_pageCount;
  }  
 
  /****************************************************************************
   * Executes a query
   * @param string $mbrid Member id of library member to select
   * @return boolean returns false, if error occurs
   * @access public
   ****************************************************************************
   */
  function execSelect($mbrid) {
    $sql = $this->mkSQL("select * from adquisicion where mbrid = %N ", $mbrid);
    if (!$this->_query($sql, "Error al buscar pedidos de adquisición.")) {
      return false;
    }
    $this->_rowCount = $this->_conn->numRows();
    return true;
  }
  
  function execSelectActuales($mbrid) {
    $sql = $this->mkSQL("select a.* "
	                   ."from adquisicion a "
					   ."left join concepto_dm c on a.concepto_cd = c.code "
					   ."where a.mbrid = %N and c.fecha_vto >= sysdate() ", $mbrid);
    if (!$this->_query($sql, "Error al buscar pedidos de adquisición.")) {
      return false;
    }
    $this->_rowCount = $this->_conn->numRows();
    return true;
  }  
  
  function execSelectVencidos($mbrid) {
    $sql = $this->mkSQL("select a.* "
	                   ."from adquisicion a "
					   ."left join concepto_dm c on a.concepto_cd = c.code "
					   ."where a.mbrid = %N and c.fecha_vto < sysdate() ", $mbrid);
    if (!$this->_query($sql, "Error al buscar pedidos de adquisición.")) {
      return false;
    }
    $this->_rowCount = $this->_conn->numRows();
    return true;
  }  
  
  function execSelectAdqid($adqid) {
    $sql = $this->mkSQL("select * from adquisicion where adqid = %N ", $adqid);
    if (!$this->_query($sql, "Error al buscar pedidos de adquisición.")) {
      return false;
    }
    $this->_rowCount = $this->_conn->numRows();
    return true;
  }
  
  function execSelectWhere($where) {
    $sql = "select * from adquisicion where ".$where;
    if (!$this->_query($sql, "Error al buscar pedidos de adquisición.")) {
      return false;
    }
    $this->_rowCount = $this->_conn->numRows();
    return true;
  }    

  /****************************************************************************
   * Fetches a row from the query result and populates the Member object.
   * @return Member returns library member or false if no more members to fetch
   * @access public
   ****************************************************************************
   */
  function fetchAdquisicion() {
    $array = $this->_conn->fetchRow();	
    if ($array == false) {
      return false;
    }

    $adq = new Adquisicion();
    $adq->setAdqid($array["adqid"]);
    $adq->setConceptoCd($array["concepto_cd"]);
    $adq->setTitle($array["title"]);
    $adq->setAuthor($array["author"]);
    $adq->setIsbn($array["isbn"]);
    $adq->setEdicionDt($array["edicion_dt"]);
	$adq->setEditorial($array["editorial"]);
	$adq->setEjemplares($array["ejemplares"]);
	$adq->setLibraryId($array["libraryid"]);
	$adq->setAreaCd($array["area_cd"]);
	$adq->setMbrid($array["mbrid"]);	
    $adq->setEstadoCd($array["estado_cd"]);
    $adq->setObservacion($array["observacion"]);
	$adq->setCreatedDt($array["created_dt"]);

    return $adq;
  }

  function insert($adq) {
    $sql = $this->mkSQL("insert into adquisicion "
                        . "values (null, %N, %Q, %Q, %Q, %Q, %Q, %N, %N, %N, %N, %N, %Q, sysdate()) ",
                        $adq->getConceptoCd(), 
						$adq->getTitle(),
						$adq->getAuthor(),
						$adq->getIsbn(),
						$adq->getEdicionDt(),
						$adq->getEditorial(),
						$adq->getEjemplares(),
						$adq->getLibraryId(),
						$adq->getAreaCd(),
						$adq->getMbrid(),
						$adq->getEstadoCd(),
						$adq->getObservacion());
    if (!$this->_query($sql, "Error al intentar insertar un nuevo pedido de adquisición.")) {
      return false;
    }
    $adqid = $this->_conn->getInsertId();
    return $adqid;
  }

  function update($adq) {
    $sql = $this->mkSQL("update adquisicion set "
                        . " concepto_cd = %N, "
						. " title = %Q, "
						. " author = %Q, "
						. " isbn = %Q, "
						. " edicion_dt = %Q, "
						. " editorial = %Q, "
						. " ejemplares = %Q, "
						. " libraryid = %N, "
						. " area_cd = %N,  "
						. " mbrid = %N,  "
						. " estado_cd = %N,  "
						. " observacion = %Q  "
                        . "where adqid = %N",
						$adq->getConceptoCd(),
						$adq->getTitle(),
						$adq->getAuthor(),
						$adq->getIsbn(),
						$adq->getEdicionDt(),
						$adq->getEditorial(),
						$adq->getEjemplares(),
						$adq->getLibraryId(),
                        $adq->getAreaCd(),
						$adq->getMbrid(),
						$adq->getEstadoCd(),
						$adq->getObservacion(),
						$adq->getAdqid());
    return $this->_query($sql, "Error actualizando el registro de pedido de adquisición.");
  }
  
  function actualizarHistorial($adq,$userid)
  {
    $sql = $this->mkSQL("insert into adquisiciones_status_hist "
                        . "values (%N, sysdate(), %N, %N) ",
                        $adq->getAdqid(), 
						$adq->getEstadoCd(),
						$userid);
   $this->_query($sql, "Error al insertar en el historial de estados.");						
  }
  
  function delete($adqid) {
    $sql = $this->mkSQL("delete from adquisicion where adqid = %N ", $adqid);
    return $this->_query($sql, "Error al borrar el pedido de adquisición.");
  }

}

?>
