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
require_once("../classes/Biblio.php");
require_once("../classes/BiblioField.php");
require_once("../classes/Localize.php");

require_once("../classes/DbConnection.php");



/******************************************************************************
 * DmQuery data access component for domain tables
 *
 * @author David Stevens <dave@stevens.name>;
 * @version 1.0
 * @access public
 ******************************************************************************
 */
class LibraryQuery extends Query  
{
  var $_tableNm = "biblio_cod_library";

/*  function execSelect($table, $code = "") 
  {
    $this->_tableNm = $table;
	echo"<h1>".getType($table)."</h1>";
    $sql = $this->mkSQL("select * from %I ", $table);
    if ($code != "") 
    {
      $sql .= $this->mkSQL("where code = %N ", $code);
    }
    $sql .= "order by description ";
    return $this->_query($sql, "Error accessing the ".$table." domain table.");
  }

  */
  
 /**
  Autor: Horacio Alvarez
  Fecha: 17-04-06
  Descripcion: funcion que realiza el query para 
  obtener el registro de la biblioteca correspondiente 
  al codigo recibo por parametro.
 */  
  function execSelectWithCode($code) 
  {
    $sql = $this->mkSQL("select * from %I ", $this->_tableNm);
    if ($code != "") 
    {
      $sql .= $this->mkSQL("where code = %N ", $code);
    }
    $sql .= "order by description ";
    return $this->_query($sql, "Error accessing the ".$this->_tableNm." domain table.");
  }  
  
  function execSelectWithStats($table) 
  {
    $this->_tableNm = $table;
    $sql = $this->mkSQL("select * from %I ", $table);

//    $sql = "select biblio_cod_library.* ";
//    $sql .= "from biblio_cod_library";
    return $this->_query($sql, "Error accessing the ".$table." domain table.");
  }


  function fetchRow() 
  {
    $array = $this->_conn->fetchRow();
	
    if ($array == false) 
	{
		return false;
    }

    $lb = new Library();
	$lb->setCode($array["code"]);
	$lb->setDescription($array["description"]);
	$lb->setDefaultFlg($array["default_flg"]);

    if (isset($array["row_count"])) 
	{
      $lb->setCount($array["row_count"]);
    }
	return $lb;
  }

  /*function fetchRows($col="") 
  {
    if ($col == "") $col = "description";
    while ($result = $this->_conn->fetchRow())
    {
      $assoc[$result["code"]] = $result[$col];
    }
    return $assoc;
  }
*/
  function dupliCode($code) 
  {
	echo "<h1>entra dupcode".$code."</h1>";
	echo setType($code,"Integer");
//    $sql = $this->mkSQL("select count(*) from biblio_cod_library where code = %N)",$code);
    $sql = $this->mkSQL("select count(*) from biblio_cod_library where biblio_cod_library.code=%N", $code);
//	$sql.= $this->mkSQL("where code= %N ", $code);
    echo "<h1>".$sql."</h1>";
    if (!$this->_query($sql, /*$this->_loc->getText("biblioCopyQueryErr1")*/"error")) 
    {
echo "<h1>NOla ejecuta</h1>";
      return false;
    }
	echo "<h1>la ejecuta</h1>";
    $array = $this->_conn->fetchRow(OBIB_NUM);
    if ($array[0] > 0) 
    {
      return true;
    }
    return false;
  }
  /*function otra($code) 
  {
	echo "otra".$code."<br>";
	echo settype($code,"Integer");
	echo is_numeric($code);
	echo gettype($code);
	$sql = $this->mkSQL("select count(*) from biblio_cod_library where biblio_cod_library.code = %N ",$code);
	echo"sale otra sql".$sql;
	return true;
  }*/

}

?>