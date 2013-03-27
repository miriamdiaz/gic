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

  require_once("../functions/formatFuncs.php");
  require_once("../funciones.php");
  include_once("../classes/Dm.php");
  include_once("../classes/DmQuery.php");
  include_once("../functions/errorFuncs.php");  


class Adquisicion {
  var $_adqid = 0;
  var $_conceptoCd = 0;
  var $_conceptoCdError = "";
  var $_title = "";
  var $_titleError = "";
  var $_author = "";
  var $_authorError = "";
  var $_isbn = "";
  var $_isbnError = "";
  var $_edicionDt = "";
  var $_editorial = "";
  var $_ejemplares = 0;
  var $_ejemplaresError = "";
  var $_libraryId = 0;
  var $_libraryIdError = "";
  var $_areaCd = 0;
  var $_areaCdError = "";
  var $_mbrid = 0;
  var $_estadoCd = 0;
  var $_estadoCdError = "";
  var $_observacion = "";
  var $_createdDt = "";

  /****************************************************************************
   * @return boolean true if data is valid, otherwise false.
   * @access public
   ****************************************************************************
   */
  function validateData() {
    $valid = true;
	
	$this->_title = trim($this->_title);
	if($this->_title == "" || empty($this->_title))
	   {
	    $this->_titleError = "Debe ingresar el título del libro";
		$valid = false;
	   }
	if($this->_author == "" || empty($this->_author))
	   {
	    $this->_authorError = "Debe ingresar el autor del libro";
		$valid = false;
	   }
	if($this->_isbn == "" || empty($this->_isbn))
	   {
	    $this->_isbnError = "Debe ingresar el isbn del libro";
		$valid = false;
	   }	   	   	
	if(!is_numeric($this->_ejemplares))
	   {
	    $this->_ejemplaresError = "La cantidad de ejemplares debe ser un número de entero";
		$valid = false;
	   }
	elseif($this->_ejemplares <= 0)
	   {
	    $this->_ejemplaresError = "La cantidad de ejemplares debe ser mayor a 0";
		$valid = false;
	   }	   
	if($this->_libraryId == 0)
	   {
	    $this->_libraryIdError = "Debe seleccionar una biblioteca";
		$valid = false;
	   }
	if($this->_estadoCd == 0)
	   {
	    $this->_estadoCdError = "Debe seleccionar un estado";
		$valid = false;
	   }	
	if($this->_areaCd == 0)
	   {
	    $this->_areaCdError = "Debe seleccionar un área";
		$valid = false;
	   }
	if($this->_conceptoCd == 0)
	   {
	    $this->_conceptoCdError = "Debe seleccionar un concepto";
		$valid = false;
	   }
	else
	   {
		$dmQ = new DmQuery();
		$dmQ->connect();
		if ($dmQ->errorOccurred()) {
		  $dmQ->close();
		  displayErrorPage($dmQ);
		}
		$dmQ->execSelect("concepto_dm",$this->_conceptoCd);
		if ($dmQ->errorOccurred()) {
		  $dmQ->close();
		  displayErrorPage($dmQ);
		}
		$dm = $dmQ->fetchRow();
		$fechaVto = $dm->getFechaVto();
		if(date("Y-m-d") > $fechaVto)
		  {
	       $this->_conceptoCdError = "El concepto ya se encuentra vencido";
		   $valid = false;		
		  }
	   }	   	   	   
	
    return $valid;
  }

  /****************************************************************************
   * Getter methods for all fields
   * @return string
   * @access public
   ****************************************************************************
   */
   
  function getAdqid() {
    return $this->_adquid;
  }
  
  function getConceptoCd() {
    return $this->_conceptoCd;
  }  
  
  function getConceptoCdError() {
    return $this->_conceptoCdError;
  }    
  
  function getTitle() {
    return $this->_title;
  }
  function getTitleError() {
    return $this->_titleError;
  }      
  
  function getAuthor() {
    return $this->_author;
  }
  
  function getAuthorError() {
    return $this->_authorError;
  }      
    
  function getIsbn() {
    return $this->_isbn;
  }    
  
  function getIsbnError() {
    return $this->_isbnError;
  }      
  
  function getEdicionDt() {
    return $this->_edicionDt;
  }      
  
  function getEditorial() {
    return $this->_editorial;
  }      
  
  function getEjemplares() {
    return $this->_ejemplares;
  }
  
  function getEjemplaresError() {
    return $this->_ejemplaresError;
  }        
  
  function getLibraryId() {
    return $this->_libraryId;
  }
  
  function getLibraryIdError() {
    return $this->_libraryIdError;
  }        
  
  function getAreaCd() {
    return $this->_areaCd;
  }      
  
  function getAreaCdError() {
    return $this->_areaCdError;
  }        
  
  function getMbrid() {
    return $this->_mbrid;
  }      
  
  function getEstadoCd() {
    return $this->_estadoCd;
  }      
  
  function getEstadoCdError() {
    return $this->_estadoCdError;
  }        
  
  function getObservacion() {
    return $this->_observacion;
  }      
  
  function getCreatedDt() {
    return $this->_createdDt;
  }      
  /****************************************************************************
   * Setter methods for all fields
   * @param string $value new value to set
   * @return void
   * @access public
   ****************************************************************************
   */
  function setAdqid($value) {
    $this->_adquid = trim($value);
  }      
  
  function setConceptoCd($value) {
    $this->_conceptoCd = trim($value);
  }      
  
  function setTitle($value) {
    $this->_title = trim($value);
  }          
  
  function setAuthor($value) {
    $this->_author = trim($value);
  }            
  
  function setIsbn($value) {
    $this->_isbn = trim($value);
  }            
  
  function setEdicionDt($value) {
    $this->_edicionDt = trim($value);
  }            
  
  function setEditorial($value) {
    $this->_editorial = trim($value);
  }            
  
  function setEjemplares($value) {
    $this->_ejemplares = trim($value);
  }            
  
  function setLibraryId($value) {
    $this->_libraryId = trim($value);
  }            
  
  function setAreaCd($value) {
    $this->_areaCd = trim($value);
  }            
  
  function setMbrid($value) {
    $this->_mbrid = trim($value);
  }            
  
  function setEstadoCd($value) {
    $this->_estadoCd = trim($value);
  }            
  
  function setObservacion($value) {
    $this->_observacion = trim($value);
  }            
  
  function setCreatedDt($value) {
    $this->_createdDt = trim($value);
  }            

}

?>
