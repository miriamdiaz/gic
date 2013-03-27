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

/******************************************************************************
 * Dm represents a domain table row.
 *
 * @author David Stevens <dave@stevens.name>;
 * @version 1.0
 * @access public
 ******************************************************************************
 */
require_once("../classes/Query.php"); 
 
class Dm {
  var $_code = "";
  var $_description = "";
  var $_descriptionError = "";
  var $_defaultFlg = "";
  var $_daysDueBack = "0";
  var $_daysDueBackError = "";
  var $_dailyLateFee = "0";
  var $_dailyLateFeeError = "";
  var $_adultCheckoutLimit = "0";
  var $_adultCheckoutLimitError = "";
  var $_juvenileCheckoutLimit = "0";
  var $_juvenileCheckoutLimitError = "";
  var $_imageFile = "";
  var $_count = "0";
  //ini franco 18/07/05
  var $_bibid= "";
  var $_copyid= "";
  var $_fecha= "";
  var $_user= "";
  var $_estado= "";
  //fin franco
  /**
  Agregado: Horacio Alvarez
  Fecha: 22-03-06
  */
  var $_value = "1"; //variable generica que puede referirse a cualquier campo esencial de una tabla.
  var $_valueError = "";
  var $_dias_sancion = "0";
  var $_dias_sancionError = "";
  var $_aplica_nueva_en = "0";
  var $_aplica_nueva_enError = "";
  
  /****************************************************************************
   * @return boolean true if data is valid, otherwise false.
   * @access public
   ****************************************************************************
   */
  function validateData() {
    $valid = true;
    if ($this->_description == "") {
      $valid = false;
      $this->_descriptionError = "La descripción es requerida.";
    }
    if (!is_numeric($this->_daysDueBack)) {
      $valid = false;
      $this->_daysDueBackError = "Los días de devolución debe ser numérico.";
    } elseif ($this->_daysDueBack < 0) {
      $valid = false;
      $this->_daysDueBackError = "Los días de devolución no debe ser menor a cero.";
    }
    if (!is_numeric($this->_dailyLateFee)) {
      $valid = false;
      $this->_dailyLateFeeError = "El monto de la multa diaria debe ser numérico.";
    } elseif ($this->_dailyLateFee < 0) {
      $valid = false;
      $this->_dailyLateFeeError = "El monto de la multa diaria no debe ser menor a cero.";
    }
    if (!is_numeric($this->_adultCheckoutLimit)) {
      $valid = false;
      $this->_adultCheckoutLimitError = "El límite de préstamos para adultos debe ser numérico.";
    } elseif ($this->_adultCheckoutLimit < 0) {
      $valid = false;
      $this->_adultCheckoutLimitError = "El límite de préstamos para adultos no debe ser menor a cero.";
    }
    if (!is_numeric($this->_juvenileCheckoutLimit)) {
      $valid = false;
      $this->_juvenileCheckoutLimitError = "El límite de préstamos juvenil debe ser numérico.";
    } elseif ($this->_juvenileCheckoutLimit < 0) {
      $valid = false;
      $this->_juvenileCheckoutLimitError = "El límite de préstamos juvenil no debe ser menor a cero.";
    }
	/**
	Agregado: Horacio Alvarez
	Fecha: 22-03-06
	*/
    if (!is_numeric($this->_value)) {
      $valid = false;
      $this->_valueError = "La cantidad de dias debe ser un valor numérico.";
    } elseif ($this->_value <= 0) {
      $valid = false;
      $this->_valueError = "La cantidad de dias debe ser mayor a cero.";
    }
    if (!is_numeric($this->_dias_sancion)) {
      $valid = false;
      $this->_dias_sancionError = "Los dias sancion debe ser un valor numérico.";
    }
    if (!is_numeric($this->_aplica_nueva_en)) {
      $valid = false;
      $this->_aplica_nueva_enError = "Los dias para la nueva infraccion debe ser un valor numérico.";
    }		
    return $valid;
  }
  
  /**
  Autor: Horacio Alvarez
  Agregado: 23-03-06
  Descripcion: nueva funcion de validacion de datos la cual recibe como parametro
  el "objeto" DmQuery el cual posee una nueva funcion para validar duplicacion de datos.
  */
  function validateDataWithDmQquery($dmQ) {
    $valid = true;
    if ($this->_description == "") {
      $valid = false;
      $this->_descriptionError = "La descripción es requerida.";
    }	
    if (!is_numeric($this->_value)) 
	   {
        $valid = false;
        $this->_valueError = "La cantidad de dias debe ser un valor numérico.";
		}   
	else
	   {
	   if ($this->_value <= 0) 
	        {
            $valid = false;
            $this->_valueError = "La cantidad de dias debe ser mayor a cero.";
            }
	   else
	        {
	        $dupValue = $dmQ->_dupValue($this->_value, "dias_devolucion");
	        if($dupValue)
	            {
                $valid=false;				  
	            $this->_valueError = "Esta cantidad de dias ya existe para otro tipo de prestamo.";
	            }			 
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
  function getCode() {
    return $this->_code;
  }
  function getDescription() {
    return $this->_description;
  }
  function getDescriptionError() {
    return $this->_descriptionError;
  }
  function getDefaultFlg() {
    return $this->_defaultFlg;
  }
  function getDaysDueBack() {
    return $this->_daysDueBack;
  }
  function getDaysDueBackError() {
    return $this->_daysDueBackError;
  }
  function getDailyLateFee() {
    return $this->_dailyLateFee;
  }
  function getDailyLateFeeError() {
    return $this->_dailyLateFeeError;
  }
  function getAdultCheckoutLimit() {
    return $this->_adultCheckoutLimit;
  }
  function getAdultCheckoutLimitError() {
    return $this->_adultCheckoutLimitError;
  }
  function getJuvenileCheckoutLimit() {
    return $this->_juvenileCheckoutLimit;
  }
  function getJuvenileCheckoutLimitError() {
    return $this->_juvenileCheckoutLimitError;
  }
  function getImageFile() {
    return $this->_imageFile;
  }
  function getCount() {
    return $this->_count;
  }
  //ini franco 18/07/05
  function getBibid() {
    return $this->_bibid;
  }
  function getCopyId() {
    return $this->_copyid;
  }
  function getFecha() {
    return $this->_fecha;
  }
  function getUser() {
    return $this->_user;
  }
  function getEstado()
  {
  	return $this->_estado;
  }
  /**
  Agregado: Horacio Alvarez
  FEcha: 22-03-06
  */
  function getValue()
  {
  	return $this->_value;
  }  
  function getValueError() {
    return $this->_valueError;
  } 
  function getDias_sancion() {
    return $this->_dias_sancion;
  } 
  function getDias_sancionError() {
    return $this->_dias_sancionError;
  }   
  function getAplica_nueva_en() {
    return $this->_aplica_nueva_en;
  } 
  function getAplica_nueva_enError() {
    return $this->_aplica_nueva_enError;
  }          
  //fin franco

  /****************************************************************************
   * Setter methods for all fields
   * @param string $value new value to set
   * @return void
   * @access public
   ****************************************************************************
   */
   //ini franco 18/07/05
    function setBibid($value) 
	{
       $this->_bibid = trim($value);
    }
    function setCopyId($value) 
	{
       $this->_copyid = trim($value);
    }
	function setFecha($value) 
	{
       $this->_fecha = trim($value);
    }
	function setUser($value) 
	{
       $this->_user = trim($value);
    }
	function setEstado($value) 
	{
       $this->_estado = trim($value);
    }
   // fin franco
  function setCode($value) {
    $this->_code = trim($value);
  }
  function setDescription($value) {
    $this->_description = trim($value);
  }
  function setDescriptionError($value) {
    $this->_descriptionError = trim($value);
  }
  function setDefaultFlg($value) {
    $this->_defaultFlg = trim($value);
  }
  function setDaysDueBack($value) {
    if (trim($value) == "") {
      $this->_daysDueBack = "0";
    } else {
      $this->_daysDueBack = trim($value);
    }
  }
  function setDaysDueBackError($value) {
    $this->_daysDueBackError = trim($value);
  }
  function setDailyLateFee($value) {
    if (trim($value) == "") {
      $this->_dailyLateFee = "0";
    } else {
      $this->_dailyLateFee = trim($value);
    }
  }
  function setDailyLateFeeError($value) {
    $this->_dailyLateFeeError = trim($value);
  }
  function setAdultCheckoutLimit($value) {
    if (trim($value) == "") {
      $this->_adultCheckoutLimit = "0";
    } else {
      $this->_adultCheckoutLimit = trim($value);
    }
  }
  function setAdultCheckoutLimitError($value) {
    $this->_adultCheckoutLimitError = trim($value);
  }
  function setJuvenileCheckoutLimit($value) {
    if (trim($value) == "") {
      $this->_juvenileCheckoutLimit = "0";
    } else {
      $this->_juvenileCheckoutLimit = trim($value);
    }
  }
  function setJuvenileCheckoutLimitError($value) {
    $this->_juvenileCheckoutLimitError = trim($value);
  }
  function setImageFile($value) {
    $this->_imageFile = trim($value);
  }
  function setCount($value) {
    if (trim($value) == "") {
      $this->_count = "0";
    } else {
      $this->_count = trim($value);
    }
  }
  /**
  Agregado: Horacio Alvarez
  Fecha: 22-03-06
  */
  function setValue($value)
  {
  	$this->_value=trim($value);
  }  
  function setValueError($value) {
    $this->_valueError = trim($value);
  } 
  function setDias_sancion($value) {
    $this->_dias_sancion = trim($value);
  }
  function setDias_sancionError($value) {
    $this->_dias_sancionError = trim($value);
  }   
  function setAplica_nueva_en($value) {
    $this->_aplica_nueva_en = trim($value);
  }
  function setAplica_nueva_enError($value) {
    $this->_aplica_nueva_enError = trim($value);
  }       
   


}

?>
