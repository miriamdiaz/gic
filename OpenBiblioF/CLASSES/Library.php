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
 * Lb represents a domain table row.
 *
 * @author David Stevens <dave@stevens.name>;
 * @version 1.0
 * @access public
 ******************************************************************************
 */
require_once("../shared/global_constants.php");
require_once("../classes/Query.php");
require_once("../classes/LibraryQuery.php");
class Library
{
  var $_code = "";
  var $_codeError="";
  var $_description = "";
  var $_descriptionError = "";
  var $_defaultFlg = "";
  var $_count = "0";

  /****************************************************************************
   * @return boolean true if data is valid, otherwise false.
   * @access public
   ****************************************************************************
   */
  
   function validateData()
   {
    $valid = true;
    if ($this->_description == "") 
    {
      $valid = false;
      $this->_descriptionError = "La descripción es requerida.";
    }
    if (!is_numeric($this->_code)) 
    {
      $valid = false;
      $this->_codeError = "El codigo debe ser numérico.";
    }
    elseif ($this->_code < 0) 
    {
      $valid = false;
      $this->_codeError = "El codigo no debe ser menor a cero.";
    }
	else
	{
	//echo "<h1>entra</h1>";
		$LQ = new LibraryQuery();
	//		echo "<h1>new</h1>";
		if(!$LQ->dupliCode($this->_code))
		{
		      $valid = false;
		      $this->_codeError = "El codigo debe ser unico.";
		}
			echo "<h1>sale</h1>";
	}
    return $valid;
  }

  /****************************************************************************
   * Getter methods for all fields
   * @return string
   * @access public
   ****************************************************************************
   */
  function getCode() 
  {
    return $this->_code;
  }

  function getCodeError() 
  {
    return $this->_codeError;
  }

  function getDescription() 
  {
    return $this->_description;
  }

  function getDescriptionError()
  {
    return $this->_descriptionError;
  }

  function getDefaultFlg() 
  {
    return $this->_defaultFlg;
  }

  function getCount() 
  {
    return $this->_count;
  }
  
   /****************************************************************************
   * Setter methods for all fields
   * @param string $value new value to set
   * @return void
   * @access public
   ****************************************************************************
*/
	function setCode($value) 
	{
		//setType($value,"Integer");
//		echo"<h1>".getType($value)."</h1>";
		$this->_code = trim($value);
	}

	function setCodeError($value) 
	{
    	$this->_codeError = trim($value);
  	}

	function setDescription($value) 
	{
		$this->_description = trim($value);
	}

	function setDescriptionError($value) 
	{
    	$this->_descriptionError = trim($value);
  	}

	function setDefaultFlg($value) 
	{
    	$this->_defaultFlg = trim($value);
  	}

	function setCount($value) 
	{
  	  if (trim($value) == "") 
	  {
        $this->_count = "0";
      }
	  else
	  {
        $this->_count = trim($value);
      }
    }

}

?>
