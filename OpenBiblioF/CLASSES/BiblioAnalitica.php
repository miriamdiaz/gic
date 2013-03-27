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
  require_once("../functions/formatFuncs.php");

/******************************************************************************
 * BiblioCopy represents a library bibliography copy record.  Contains business rules for
 * bibliography data validation.
 *
 * @author David Stevens <dave@stevens.name>;
 * @version 1.0
 * @access public
 ******************************************************************************
 */
class BiblioAnalitica {
  var $_bibid = "";
  var $_anaid = "";
  var $_anaTitulo = "";
  var $_anaTituloError = "";
  var $_anaAutor = "";
  var $_anaAutorError = "";
  var $_anaPaginacion= "";
  var $_anaPaginacionError= "";
  var $_anaMateria = "";
  var $_anaUser = "";
  var $_loc;
  var $_anaSubTitulo = "";
  
  function BiblioAnalitica () 
  {
    $this->_loc = new Localize(OBIB_LOCALE,"classes");
  }

  /****************************************************************************
   * @return boolean true if data is valid, otherwise false.
   * @access public
   ****************************************************************************
   */
  function validateData() 
  {
    $valid = true;
    if ($this->_anaTitulo == "") 
	{
      $valid = false;
      $this->_anaTituloError = $this->_loc->getText("biblioAnaliticaError1");
    } 
	/*
	if($this->_anaAutor == "")
    {
		$valid=false;
		$this->_anaAutorError= $this->_loc->getText("biblioAnaliticaError1");
    }
	*/
    if($this->_anaPaginacion == "")
    {
		$valid=false;
		$this->_anaPaginacionError= $this->_loc->getText("biblioAnaliticaError1");
    }
    return $valid;
  }

  /****************************************************************************
   * Getter methods for all fields
   * @return string
   * @access public
   ****************************************************************************
   */
  function getBibid() {
    return $this->_bibid;
  }
  function getAnaid() {
    return $this->_anaid;
  }
  function getAnaliticaTitulo() {
    return $this->_anaTitulo;
  }
  function getAnaliticaAutor() {
    return $this->_anaAutor;
  }
  function getAnaliticaPaginacion() {
    return $this->_anaPaginacion;
  }
  
   function getAnaliticaMateria() {
    return $this->_anaMateria;
  }
  function getAnaliticaTituloError() {
    return $this->_anaTituloError;
  }
  function getAnaliticaAutorError() {
    return $this->_anaAutorError;
  }
  function getAnaliticaPaginacionError() {
    return $this->_anaPaginacionError;
  }
  function getUserCreador()
  {
  return $this->_anaUser;
  }
  function getAnaliticaSubTitulo() {
    return $this->_anaSubTitulo;
  }

  /* fin franco*/
  /****************************************************************************
   * Setter methods for all fields
   * @param string $value new value to set
   * @return void
   * @access public
   ****************************************************************************
   */
  function setTitulo($value)
  {  
	$this->_anaTitulo=trim($value);
  }
  function setAutor($value)
  {  
	$this->_anaAutor=trim($value);
  }
  function setPaginacion($value)
  {  
	$this->_anaPaginacion=trim($value);
  }
  function setUserCreador($value)
  {  
	$this->_anaUser=trim($value);
  }
  function setMateria($value)
  {  
	$this->_anaMateria=trim($value);
  }
  function setBibid($value) 
  {
    $this->_bibid = trim($value);
  }
  function setAnaid($value) 
  {
    $this->_anaid = trim($value);
  }
  function setSubTitulo($value)
  {  
	$this->_anaSubTitulo=trim($value);
  }
}

?>
