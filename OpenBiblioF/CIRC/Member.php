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

/******************************************************************************
 * Member represents a library member.  Contains business rules for
 * member data validation.
 *
 * @author David Stevens <dave@stevens.name>;
 * @version 1.0
 * @access public
 ******************************************************************************
 */
class Member {
  var $_mbrid = 0;
  var $_barcodeNmbr = 0;
  var $_barcodeNmbrError = "";
  var $_createDt = "";
  var $_lastChangeDt = "";
  var $_lastChangeUserid = "";
  var $_lastChangeUsername = "";
  var $_lastName = "";
  var $_lastNameError = "";
  var $_firstName = "";
  var $_firstNameError = "";
  var $_address1 = "";
  var $_address1Error = "";
  var $_address2 = "";
  var $_city = "";
  //SEIS LINEAS AGREGADAS: Horacio Alvarez FECHA: 24-03-06
  var $_libraryid = "";
  var $_libraryidError = "";
  var $_limitePrestamos = 0;
  var $_limitePrestamosError = "";
  var $_limiteReservasError = "";
  var $_cantidadPrestamos = 0;
  var $_cantidadReservas = 0;
  var $_state = "";
  var $_zip = "";
  var $_zipError = "";
  var $_zipExt = "";
  var $_zipExtError = "";
  var $_homePhone = "";
  var $_workPhone = "";
  var $_email = "";
  var $_classification = "";
  var $_schoolGrade = "";
  var $_schoolGradeError = "";
  var $_schoolTeacher = "";
  var $_tipo_sancion_cd = 0;
  var $_inicio_sancion = "";
  var $_fecha_suspension = "";
  var $_sancion_activa = "";
  var $_copy_barcode = "";

  /****************************************************************************
   * @return boolean true if data is valid, otherwise false.
   * @access public
   ****************************************************************************
   */
  function validateData() {
    $valid = true;
    if ($this->_barcodeNmbr == "") {
      $valid = false;
      $this->_barcodeNmbrError = "El n�mero del socio es requerido.";
    } else if (!ctypeAlnum($this->_barcodeNmbr)) {
      $valid = FALSE;
      $this->_barcodeNmbrError = "El n�mero del socio debe ser caracteres alfab�ticos y num�ricos.";
    }
    if ($this->_lastName == "") {
      $valid = false;
      $this->_lastNameError = "El apellido es requerido.";
    }
    if ($this->_firstName == "") {
      $valid = false;
      $this->_firstNameError = "El nombre es requerido.";
    }
	//IF AGREGADO: Horacio Alvarez FECHA: 24-03-06
    if ($this->_address1 == "") {
      $valid = false;
      $this->_address1Error = "La direccion particular es requerida.";
    }
	//IF AGREGADO: Horacio Alvarez FECHA: 24-03-06
    if ($this->_libraryid == "") {
      $valid = false;
      $this->_libraryidError = "La biblioteca es requerida.";
    }
	//IF AGREGADO: Horacio Alvarez FECHA: 26-03-06
    if (!is_numeric($this->_limitePrestamos)) {
      $valid = false;
      $this->_limitePrestamosError = "El limite de pr�stamos debe ser num�rico.";
    }
	//IF AGREGADO: Horacio Alvarez FECHA: 08-04-06
    if (!is_numeric($this->_limiteReservas)) {
      $valid = false;
      $this->_limiteReservasError = "El limite de reservas debe ser num�rico.";
    }	
    if (!is_numeric($this->_zip)) {
      $valid = false;
      $this->_zipError = "El c�digo postal debe ser num�rico.";
    }
    if (strrpos($this->_zip,".")) {
      $valid = false;
      $this->_zipError = "El c�digo postal no debe contener un punto decimal.";
    }
    if (!is_numeric($this->_zipExt)) {
      $valid = false;
      $this->_zipExtError = "La extensi�n del c�digo postal debe ser num�rico.";
    }
    if (strrpos($this->_zipExt,".")) {
      $valid = false;
      $this->_zipExtError = "La extensi�n del c�digo postal no debe contener un punto decimal.";
    }
    if (!is_numeric($this->_schoolGrade)) {
      $valid = false;
      $this->_schoolGradeError = "El grado de escuela debe ser num�rico.";
    }
    if (strrpos($this->_schoolGrade,".")) {
      $valid = false;
      $this->_schoolGradeError = "El grado de escuela no debe contener un punto decimal.";
    }

    return $valid;
  }

  /****************************************************************************
   * Getter methods for all fields
   * @return string
   * @access public
   ****************************************************************************
   */
  function getMbrid() {
    return $this->_mbrid;
  }
  function getBarcodeNmbr() {
    return $this->_barcodeNmbr;
  }
  function getBarcodeNmbrError() {
    return $this->_barcodeNmbrError;
  }
  function getCreateDt() {
    return $this->_createDt;
  }
  function getLastChangeDt() {
    return $this->_lastChangeDt;
  }
  function getLastChangeUserid() {
    return $this->_lastChangeUserid;
  }
  function getLastChangeUsername() {
    return $this->_lastChangeUsername;
  }
  function getLastName() {
    return $this->_lastName;
  }
  function getLastNameError() {
    return $this->_lastNameError;
  }
  function getFirstName() {
    return $this->_firstName;
  }
  function getFirstNameError() {
    return $this->_firstNameError;
  }
  /**
  Autor: Horacio Alvarez
  Fecha: 24-03-06
  */
  function getaddress1Error() {
    return $this->_address1Error;
  }
  /**
  Autor: Horacio Alvarez
  Fecha: 24-03-06
  */
  function getLibraryidError() {
    return $this->_libraryidError;
  }
  /**
  Autor: Horacio Alvarez
  Fecha: 24-03-06
  */
  function getLibraryid() {
    return $this->_libraryid;
  }
  /**
  Autor: Horacio Alvarez
  Fecha: 26-03-06
  */
  function getLimitePrestamosError() {
    return $this->_limitePrestamosError;
  }
  /**
  Autor: Horacio Alvarez
  Fecha: 26-03-06
  */
  function getLimitePrestamos() {
    return $this->_limitePrestamos;
  }
  /**
  Autor: Horacio Alvarez
  Fecha: 08-04-06
  */
  function getLimiteReservasError() {
    return $this->_limiteReservasError;
  }
  /**
  Autor: Horacio Alvarez
  Fecha: 08-04-06
  */
  function getLimiteReservas() {
    return $this->_limiteReservas;
  }  
  /**
  Autor: Horacio Alvarez
  Fecha: 26-03-06
  */
  function getCantidadPrestamos() {
    return $this->_cantidadPrestamos;
  }
  /**
  Autor: Horacio Alvarez
  Fecha: 08-04-06
  */
  function getCantidadReservas() {
    return $this->_cantidadReservas;
  }            
  function getFirstLastName() {
    return $this->_firstName." ".$this->_lastName;
  }
  function getLastFirstName() {
    return $this->_lastName.",".$this->_firstName;
  }
  function getAddress1() {
    return $this->_address1;
  }
  function getAddress2() {
    return $this->_address2;
  }
  function getCity() {
    return $this->_city;
  }
  function getState() {
    return $this->_state;
  }
  function getZip() {
    return $this->_zip;
  }
  function getZipError() {
    return $this->_zipError;
  }
  function getZipExt() {
    return $this->_zipExt;
  }
  function getZipExtError() {
    return $this->_zipExtError;
  }
  function getHomePhone() {
    return $this->_homePhone;
  }
  function getWorkPhone() {
    return $this->_workPhone;
  }
  function getEmail() {
    return $this->_email;
  }
  function getClassification() {
    return $this->_classification;
  }
  function getSchoolGrade() {
    return $this->_schoolGrade;
  }
  function getSchoolGradeError() {
    return $this->_schoolGradeError;
  }
  function getSchoolTeacher() {
    return $this->_schoolTeacher;
  }
  function getTipo_sancion_cd() {
    return $this->_tipo_sancion_cd;
  } 
  function getInicio_sancion() {
    return $this->_inicio_sancion;
  }
  function getInicio_sancionDDmmYYYY() {
    return toDDmmYYYY($this->_inicio_sancion);
  }      
  function getFecha_suspension() {
    return $this->_fecha_suspension;
  }
  function getFecha_suspensionDDmmYYYY() {
    return toDDmmYYYY($this->_fecha_suspension);
  }     
  function getSancion_activa() {
    return $this->_sancion_activa;
  }
  function getCopy_barcode() {
    return $this->_copy_barcode;
  }     
  /**
  Autor: Horacio Alvarez
  Fecha: 26-03-06
  Descripcion: Devuelve true si el usuario
  todavia no supera su limite de cantidad de libros prestados.
  */
  function getPuedePrestar() {
    return $this->getCantidadPrestamos()<$this->getLimitePrestamos();
  }
  /**
  Autor: Horacio Alvarez
  Fecha: 29-04-06
  Descripcion: Devuelve true si el usuario
  esta cumpliendo una sancion
  */
  function getEstaSancionado() {
    if($this->getTipo_sancion_cd()>0)
       return date("Y-m-d")<$this->getFecha_suspension();
	else
	   return false;
  }  
  /**
  Autor: Horacio Alvarez
  Fecha: 08-04-06
  Descripcion: Devuelve true si el usuario
  todavia no supera su limite de cantidad de libros reservados.
  */
  function getPuedeReservar() {
    return $this->getCantidadReservas()<$this->getLimiteReservas();
  }  

  /****************************************************************************
   * Setter methods for all fields
   * @param string $value new value to set
   * @return void
   * @access public
   ****************************************************************************
   */
  function setMbrid($value) {
    $this->_mbrid = trim($value);
  }
  function setBarcodeNmbr($value) {
    $this->_barcodeNmbr = trim($value);
  }
  function setCreateDt($value) {
    $this->_createDt = trim($value);
  }
  function setLastChangeDt($value) {
    $this->_lastChangeDt = trim($value);
  }
  function setLastChangeUserid($value) {
    $this->_lastChangeUserid = trim($value);
  }
  function setLastChangeUsername($value) {
    $this->_lastChangeUsername = trim($value);
  }
  function setLastName($value) {
    $this->_lastName = trim($value);
  }
  function setLastNameError($value) {
    $this->_lastNameError = trim($value);
  }
  function setFirstName($value) {
    $this->_firstName = trim($value);
  }
  function setFirstNameError($value) {
    $this->_firstNameError = trim($value);
  }
  function setAddress1($value) {
    $this->_address1 = trim($value);
  }
  /**
  Autor: Horacio Alvarez
  Fecha: 24-03-06
  */
  function setLibraryid($value) {
    $this->_libraryid = trim($value);
  }  
  /**
  Autor: Horacio Alvarez
  Fecha: 26-03-06
  */
  function setLimitePrestamos($value) {
    $this->_limitePrestamos = trim($value);
  }
  /**
  Autor: Horacio Alvarez
  Fecha: 26-03-06
  */
  function setCantidadPrestamos($value) {
    $this->_cantidadPrestamos = trim($value);
  }  
  /**
  Autor: Horacio Alvarez
  Fecha: 08-04-06
  */
  function setLimiteReservas($value) {
    $this->_limiteReservas = trim($value);
  }  
  /**
  Autor: Horacio Alvarez
  Fecha: 08-04-06
  */
  function setCantidadReservas($value) {
    $this->_cantidadReservas = trim($value);
  }      
  function setAddress2($value) {
    $this->_address2 = trim($value);
  }
  function setCity($value) {
    $this->_city = trim($value);
  }
  function setState($value) {
    $this->_state = trim($value);
  }
  function setZip($value) {
    $temp = trim($value);
    if ($temp == "") {
      $this->_zip = 0;
    } else {
      $this->_zip = $temp;
    }
  }
  function setZipError($value) {
    $this->_zipError = trim($value);
  }
  function setZipExt($value) {
    $temp = trim($value);
    if ($temp == "") {
      $this->_zipExt = 0;
    } else {
      $this->_zipExt = $temp;
    }
  }
  function setZipExtError($value) {
    $this->_zipExtError = trim($value);
  }
  function setHomePhone($value) {
    $this->_homePhone = trim($value);
  }
  function setWorkPhone($value) {
    $this->_workPhone = trim($value);
  }
  function setEmail($value) {
    $this->_email = trim($value);
  }
  function setClassification($value) {
    $this->_classification = trim($value);
  }
  function setSchoolGrade($value) {
    $temp = trim($value);
    if ($temp == "") {
      $this->_schoolGrade = 0;
    } else {
      $this->_schoolGrade = $temp;
    }
  }
  function setSchoolGradeError($value) {
    $this->_schoolGradeError = trim($value);
  }
  function setSchoolTeacher($value) {
    $this->_schoolTeacher = trim($value);
  }
  function setTipo_sancion_cd($value) {
    $this->_tipo_sancion_cd = trim($value);
  }
  function setInicio_sancion($value) {
    $this->_inicio_sancion = trim($value);
  }    
  function setFecha_suspension($value) {
    $this->_fecha_suspension = trim($value);
  }  
  function setSancion_activa($value) {
    $this->_sancion_activa = trim($value);
  }
  function setCopy_barcode($value) {
    $this->_copy_barcode = trim($value);
  }    

}

?>
