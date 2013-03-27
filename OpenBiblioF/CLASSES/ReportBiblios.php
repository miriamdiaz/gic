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
 /* MODIFICACION JUDITH */
class ReportBiblios {
  var $_fecha1 = "";
  var $_fecha2 = "";
  var $_materialCd = "";
  var $_dateSptuError1="";
    
  function ReportBiblios () 
  {
    $this->_loc = new Localize(OBIB_LOCALE,"classes");
  }

  /****************************************************************************
   * @return boolean true if data is valid, otherwise false.
   * @access public
   ****************************************************************************
   */
  function validateData() /*validar fecha*/
  {
    $valid = true;
    list( $year1, $month1, $day1 ) = split( '[/.-]', $this->_fecha1 );
	list( $year2, $month2, $day2 ) = split( '[/.-]', $this->_fecha2 );
	if(!checkdate($month1,$day1,$year1) or !checkdate($month2,$day2,$year2))
	{
		$valid=false;
		$this->_dateSptuError1= $this->_loc->getText("biblioDateError");
	}
	if ($valid)
	{
	
	}
	return $valid;
  }


  /****************************************************************************
   * Getter methods for all fields
   * @return string
   * @access public
   ****************************************************************************
   */
  function getFecha1() {
    return $this->_fecha1;
  }
  function getFecha2() {
    return $this->_fecha2;
  }
  function getMaterialCd() {
    return $this->_materialCd;
  }  
  function getDateSptuError() {
    return $this->_dateSptuError1;
  }
  

  /****************************************************************************
   * Setter methods for all fields
   * @param string $value new value to set
   * @return void
   * @access public
   ****************************************************************************
   */
  function setFecha1($value)
  {  
	$this->_fecha1=trim($value);
  }
  function setFecha2($value)
  {  
	$this->_fecha2=trim($value);
  }
  function setMaterialCd($value)
  {  
	$this->_materialCd=trim($value);
  }  
  function setDateSptuError($value)
  {  
	$this->_dateSptuError1=trim($value);
  }
  
}

?>
