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
require_once("../classes/MemberSancionHist.php");
require_once("../classes/SettingsQuery.php");

/******************************************************************************
 * BiblioStatusHistQuery data access component for holds on library bibliography copies
 *
 * @author David Stevens <dave@stevens.name>;
 * @version 1.0
 * @access public
 ******************************************************************************
 */
class MemberSancionHistQuery extends Query {
  var $_rowCount = 0;
  var $_loc;

  function MemberSancionHistQuery () {
    //$this->_loc = new Localize(OBIB_LOCALE,"classes");
  }

  function getRowCount() {
    return $this->_rowCount;
  }

  /****************************************************************************
   * Executes a query to select status history
   * @param string $mbrid mbrid of member
   * @return boolean returns false if error occurs
   * @access public
   ****************************************************************************
   */
  function queryByMbrid($mbrid) {
    # setting query that will return all the data
    $sql = $this->mkSQL("select m.*, b.title "
                        . " from member_sancion_hist m left join biblio_copy c "
                        . " on m.barcode_nmbr like c.barcode_nmbr "
						. " left join biblio b "
						. " on c.bibid=b.bibid "
						. " where m.mbrid=%N "
                        . "order by fecha_aplico_sancion desc ",
                        $mbrid);
    if (!$this->_query($sql, "Erro in query of member_sacion_hist")) {
      return false;
    }
    $this->_rowCount = $this->_conn->numRows();
    return true;
  }

  function limpiarHistorialByMbrid($mbrid) {
    # setting query that will return all the data
    $sql = $this->mkSQL("delete from  member_sancion_hist "
						. " where mbrid=%N ",
                        $mbrid);
    if (!$this->_query($sql, "Error borrando historial de sanciones")) {
      return false;
    }
    return true;
  }
  /****************************************************************************
   * Fetches a row from the query result and populates the BiblioStatusHist object.
   * @return BiblioStatusHist returns bibliography status history object or false if no more holds to fetch
   * @access public
   ****************************************************************************
   */
  function fetchRow() {
    $array = $this->_conn->fetchRow();
    if ($array == false) {
      return false;
    }

    $hist = new MemberSancionHist();
    $hist->setId($array["id"]);
    $hist->setMbrid($array["mbrid"]);
    $hist->setBarcode_nmbr($array["barcode_nmbr"]);
    $hist->setFecha_aplico_sancion($array["fecha_aplico_sancion"]);
    $hist->setTipo_sancion_cd($array["tipo_sancion_cd"]);
	$hist->setTitle($array["title"]);
    return $hist;
  }

  /****************************************************************************
   * Inserts a new bibliography status history into the biblio_status_hist table.
   * @param BiblioStatusHist $hist history to insert
   * @access public
   ****************************************************************************
   */
  function insert($hist) {
    $sql = $this->mkSQL("insert into member_sancion_hist values "
                        . "(null, %N, %Q, %Q, %N) ",
                        $hist->getMbrid(), $hist->getBarcode_nmbr(),
                        $hist->getFecha_aplico_sancion(),$hist->getTipo_sancion_cd());

    if (!$this->_query($sql, "Error inserting into member_sancion_hist information.")) {
      return false;
    }
    return true;
  }

  /****************************************************************************
   * Deletes history from the biblio_status_hist table.
   * @param string $mbrid member id of history to delete
   * @return boolean returns false, if error occurs
   * @access public
   ****************************************************************************
   */
  function deleteByMbrid($mbrid) {
    $sql = $this->mkSQL("delete from member_sancion_hist where mbrid = %N", $mbrid);
    return $this->_query($sql, "Error al tratar de borrar desde member_sancion_hist");
  }

  /****************************************************************************
   * Deletes history from the biblio_status_hist table.
   * @param string $mbrid member id of history to delete
   * @return boolean returns false, if error occurs
   * @access private
   ****************************************************************************
   */
/*  function _purgeHistory($mbrid) {
    $setQ = new SettingsQuery();
    $purgeMo = $setQ->getPurgeHistoryAfterMonths($this->_conn);
    if ($setQ->errorOccurred()) {
      $this->_error = $setQ->getError();
      $this->_dbErrno = $setQ->getDbErrno();
      $this->_dbError = $setQ->getDbError();
      return false;
    }
    if ($purgeMo == 0) {
      return TRUE;
    }
    $sql = $this->mkSQL("delete from biblio_status_hist where mbrid = %N"
                        . " and status_begin_dt <= date_add(sysdate(),interval - %N month)",
                        $mbrid, $purgeMo);
    // need to add where clause for purge rule
    return $this->_query($sql, $this->_loc->getText("biblioStatusHistQueryErr5"));
  }*/

}
?>
