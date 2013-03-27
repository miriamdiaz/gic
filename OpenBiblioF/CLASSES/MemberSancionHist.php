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

/******************************************************************************
 * BiblioStatusHist represents a history of bilio checkin and checkout status changes
 *
 * @author David Stevens <dave@stevens.name>;
 * @version 1.0
 * @access public
 ******************************************************************************
 */
class MemberSancionHist {
  var $_id = "";
  var $_mbrid = "";
  var $_barcode_nmbr = "";
  var $_fecha_aplico_sancion = "";
  var $_tipo_sancion_cd = "";
  var $_title = "";

  /****************************************************************************
   * Getter methods for all fields
   * @return string
   * @access public
   ****************************************************************************
   */
  function getId() {
    return $this->_id;
  }
  function getMbrid() {
    return $this->_mbrid;
  }
  function getTitulo() {
    
    return $this->_barcode_nmbr;
  }
  function getBarcode_nmbr() {
    return $this->_barcode_nmbr;
  }  
  function getFecha_aplico_sancion() {
    return $this->_fecha_aplico_sancion;
  }
  function getTipo_sancion_cd() {
    return $this->_tipo_sancion_cd;
  }
  function getTitle() {
    return $this->_title;
  }  

  /****************************************************************************
   * Setter methods for all fields
   * @param string $value new value to set
   * @return void
   * @access public
   ****************************************************************************
   */
  function setId($value) {
    $this->_id = trim($value);
  }   
  function setMbrid($value) {
    $this->_mbrid = trim($value);
  }
  function setBarcode_nmbr($value) {
    $this->_barcode_nmbr = trim($value);
  }
  function setFecha_aplico_sancion($value) {
    $this->_fecha_aplico_sancion = trim($value);
  }
  function setTipo_sancion_cd($value) {
    $this->_tipo_sancion_cd = trim($value);
  }
  function setTitle($value) {
    $this->_title = trim($value);
  }  
}

?>
