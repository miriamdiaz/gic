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

/******************************************************************************
 * DmQuery data access component for domain tables
 *
 * @author David Stevens <dave@stevens.name>;
 * @version 1.0
 * @access public
 ******************************************************************************
 */
class DmQuery extends Query {
  var $_tableNm = "";

  /****************************************************************************
   * Executes a query
   * @param string $table table name of domain table to query
   * @param int $code (optional) code of row to fetch
   * @return boolean returns false, if error occurs
   * @access public
   ****************************************************************************
   */
  function execSelect($table, $code = "") {
    $this->_tableNm = $table;
    $sql = $this->mkSQL("select * from %I ", $table);
    if ($code != "") {
      $sql .= $this->mkSQL("where code = %N ", $code);
    }
    $sql .= "order by description ";
    return $this->_query($sql, "Error accessing the ".$table." domain table.");
  }
  
  function execSelectConceptoActivos($table, $code = "") {
    $this->_tableNm = $table;
    $sql = $this->mkSQL("select * from %I ", $table);
	$sql .= "where fecha_vto >= sysdate() ";
    if ($code != "") {
      $sql .= $this->mkSQL(" and code = %N ", $code);
    }
    $sql .= "order by description ";
    return $this->_query($sql, "Error accessing the ".$table." domain table.");
  }

  /****************************************************************************
   * Executes a query
   * @param string $table table name of domain table to query
   * @return boolean returns false, if error occurs
   * @access public
   ****************************************************************************
   */
  function execSelectWithStats($table) {
    $this->_tableNm = $table;
    if ($table == "collection_dm") {
      $sql = "select collection_dm.*, count(biblio.bibid) row_count ";
      $sql .= "from collection_dm left join biblio on collection_dm.code = biblio.collection_cd ";
      $sql .= "group by 1, 2, 3, 4, 5 ";
    } 
	elseif ($table == "material_type_dm") {
            $sql = "select material_type_dm.*, count(biblio.bibid) row_count ";
            $sql .= "from material_type_dm left join biblio on material_type_dm.code = biblio.material_cd ";
            $sql .= "group by 1, 2, 3, 4, 5, 6 ";
            }
	     elseif ($table == "tipo_prestamo_dm") {
                 $sql = "select tipo_prestamo_dm.* ";
                 $sql .= "from tipo_prestamo_dm ";
		         }
	     elseif ($table == "tipo_sancion_dm") {
                 $sql = "select tipo_sancion_dm.* ";
                 $sql .= "from tipo_sancion_dm ";
		         }
	     elseif ($table == "mbr_classify_dm") {
                 $sql = "select mbr_classify_dm.* ";
                 $sql .= "from mbr_classify_dm ";
		         }
	     elseif ($table == "concepto_dm") {
                 $sql = "select concepto_dm.* ";
                 $sql .= "from concepto_dm ";
		         }
	     elseif ($table == "estado_dm") {
                 $sql = "select estado_dm.* ";
                 $sql .= "from estado_dm ";
		         }
	     elseif ($table == "area_dm") {
                 $sql = "select area_dm.* ";
                 $sql .= "from area_dm ";
		         }				 				 				 				 				 
	/*ini franco 15/07/05*/
	elseif ($table == "material_auditoria")
	{
	  $sql = "select * from material_auditoria where estado='N'";
	}
	else 
	{
      $this->_errorOccurred = true;
      $this->_error = "Can only retrieve stats on collections and material types.";
      return false;
    }
	if($table != "material_auditoria")
	{    $sql .= "order by description "; }
    return $this->_query($sql, "Error accessing the ".$table." domain table.");
  }

  /****************************************************************************
   * Retrieves checkout stats for a particular member.
   * @param string $mbrid Member id of library member to select
   * @return boolean returns false, if error occurs
   * @access public
   ****************************************************************************
   */
  function execCheckoutStats($mbrid) {
    $sql = $this->mkSQL("select mat.*, count(copy.mbrid) row_count "
                        . "from material_type_dm mat "
                        . " left outer join biblio bib on mat.code = bib.material_cd "
                        . " left outer join biblio_copy copy on bib.bibid = copy.bibid "
                        . "where copy.mbrid = %N or copy.mbrid is null "
                        . "group by mat.code, mat.description, mat.default_flg, "
                        . " mat.adult_checkout_limit, mat.juvenile_checkout_limit "
                        . "order by mat.description ", $mbrid);
    if (!$this->_query($sql, "Error accessing library member information.")) {
      return false;
    }
    $this->_tableNm = "material_type_dm";
    return true;
  }

  /****************************************************************************
   * Fetches a row from the query result and populates the Dm object.
   * @return Dm returns domain object or false if no more domain rows to fetch
   * @access public
   ****************************************************************************
   */
  /**
   Funcion Modificada: Horacio Alvarez
   Fecha: 22-03-06
  */ 
  function fetchRow() {
    $array = $this->_conn->fetchRow();
    if ($array == false) 
	{
      return false;
    }
    $dm = new Dm();
	if($this->_tableNm == "mbr_classify_dm")
	  {
		$dm->setCode($array["code"]);
		$dm->setDescription($array["description"]);
	  }	
	elseif($this->_tableNm == "tipo_sancion_dm")
	  {
		$dm->setCode($array["code"]);
		$dm->setDescription($array["description"]);
		$dm->setDias_sancion($array["dias_sancion"]);
		$dm->setAplica_nueva_en($array["aplica_nueva_en"]);
	  }	
	elseif($this->_tableNm == "tipo_prestamo_dm")
	  {
		$dm->setCode($array["code"]);
		$dm->setDescription($array["description"]);
		$dm->setValue($array["dias_devolucion"]);	   
	  }
	elseif($this->_tableNm == "area_dm")
	  {
		$dm->setCode($array["code"]);
		$dm->setDescription($array["description"]);
		$dm->setValue($array["value"]);	   
	  }	  
	elseif($this->_tableNm == "material_auditoria")
	{
		$dm->setBibid($array["bibid"]);
		$dm->setCopyId($array["copyid"]);
		$dm->setEstado($array["estado"]);
		$dm->setFecha($array["fecha"]);
		$dm->setUser($array["user"]);
	}
	else
	{
		$dm->setCode($array["code"]);
		$dm->setDescription($array["description"]);
		$dm->setDefaultFlg($array["default_flg"]);
		if ($this->_tableNm == "collection_dm") 
		{
		  $dm->setDaysDueBack($array["days_due_back"]);
		  $dm->setDailyLateFee($array["daily_late_fee"]);
		}
		elseif ($this->_tableNm == "material_type_dm") 
		{
		  $dm->setAdultCheckoutLimit($array["adult_checkout_limit"]);
		  $dm->setJuvenileCheckoutLimit($array["juvenile_checkout_limit"]);
		  $dm->setImageFile($array["image_file"]);
		}
		elseif ($this->_tableNm == "biblio_cod_library") 
		{
		  $dm->setPrestamos_flg($array["prestamos_flg"]);
		}
		elseif ($this->_tableNm == "concepto_dm") 
		{
		  $dm->setFechaVto($array["fecha_vto"]);
		}				
	}
    if (isset($array["row_count"])) 
	{
      $dm->setCount($array["row_count"]);
    }
    return $dm;
  }

  /****************************************************************************
   * Fetches all rows from the query result.
   * @return assocArray returns associative array containing domain codes and values.
   * @access public
   ****************************************************************************
   */
  function fetchRows($col="") {
    if ($col == "") $col = "description";
    while ($result = $this->_conn->fetchRow()) {
      $assoc[$result["code"]] = $result[$col];
    }
    return $assoc;
  }

  /****************************************************************************
   * Inserts a new domain table row.
   * @param string $table table name of domain table to query
   * @param Dm $dm domain object
   * @return boolean returns false, if error occurs
   * @access public
   ****************************************************************************
   */
  /**
  Funcion Modificada: Horacio Alvarez
  Fecha: 22-03-06
  */
  function insert($table, $dm) {
    # constructing sql
    $sql = $this->mkSQL("insert into %I values (null, %Q, 'N', ",
                         $table, $dm->getDescription());
    if ($table == "collection_dm") {
        $sql .= $this->mkSQL("%N, %N)", $dm->getDaysDueBack(), $dm->getDailyLateFee());
        } elseif ($table == "material_type_dm") {
                  $sql .= $this->mkSQL("%N, %N, %Q)", $dm->getAdultCheckoutLimit(),
                  $dm->getJuvenileCheckoutLimit(), $dm->getImageFile());
                  } 
	              elseif($table == "tipo_prestamo_dm"){
				         $sql = $this->mkSQL("insert into %I values (null, %Q, %N)",
                         $table, $dm->getDescription(),$dm->getValue());
			            }
	              elseif($table == "tipo_sancion_dm"){
				         $sql = $this->mkSQL("insert into %I values (null, %Q, %N, %N)",
                         $table, $dm->getDescription(),$dm->getDias_sancion(),$dm->getAplica_nueva_en());
			            }
	              elseif($table == "mbr_classify_dm"){
				         $sql = $this->mkSQL("insert into %I values (null, %Q, 'N')",
                         $table, $dm->getDescription());
			            }	
	              elseif($table == "concepto_dm"){
				         $sql = $this->mkSQL("insert into %I values (null, %Q, %Q, 'N')",
                         $table, $dm->getDescription(), $dm->getFechaVto());
			            }
	              elseif($table == "estado_dm"){
				         $sql = $this->mkSQL("insert into %I values (null, %Q, 'N')",
                         $table, $dm->getDescription());
			            }
	              elseif($table == "area_dm"){
				         $sql = $this->mkSQL("insert into %I values (null, %Q, %Q, 'N')",
                         $table, $dm->getValue(), $dm->getDescription());
			            }																														
	                    else {
                             $this->_errorOccurred = true;
                             $this->_error = "Can only insert rows on collections and material types.";
                             return false;
                             }

    # running sql
    return $this->_query($sql, "Error inserting into ".$table);
  }

  /****************************************************************************
   * Update a row in a domain table.
   * @param string $table table name of domain table to query
   * @param Staff $staff staff member to update
   * @return boolean returns false, if error occurs
   * @access public
   ****************************************************************************
   */
  /**
  Funcion Modificada: Horacio Alvarez
  Fecha: 22-03-06
  */
  function update($table, $dm) 
  {
  if($table == "mbr_classify_dm")
	   {
	    $sql = $this->mkSQL("update %I set description=%Q ", $table, $dm->getDescription());
		$sql .= $this->mkSQL("where code=%N ", $dm->getCode());
 	   }
  elseif($table == "estado_dm")
	   {
	    $sql = $this->mkSQL("update %I set description=%Q ", $table, $dm->getDescription());
		$sql .= $this->mkSQL("where code=%N ", $dm->getCode());
 	   }
  elseif($table == "area_dm")
	   {
	    $sql = $this->mkSQL("update %I set value = %Q, description = %Q ", $table, $dm->getValue(), $dm->getDescription());
		$sql .= $this->mkSQL("where code=%N ", $dm->getCode());
 	   }	   
  elseif($table == "tipo_sancion_dm")
	   {
	    $sql = $this->mkSQL("update %I set description=%Q, dias_sancion=%N, aplica_nueva_en=%N ", $table, $dm->getDescription(),$dm->getDias_sancion(), $dm->getAplica_nueva_en());
		$sql .= $this->mkSQL("where code=%N ", $dm->getCode());
 	   }
  elseif($table == "tipo_prestamo_dm")
	   {
	    $sql = $this->mkSQL("update %I set description=%Q, dias_devolucion=%N ", $table, $dm->getDescription(),$dm->getValue());
		$sql .= $this->mkSQL("where code=%N ", $dm->getCode());
 	   }
  else
	   {	   
	   // ini franco 19/07/05
  	   if ($table == "material_auditoria")
	       { 
	        $sql = $this->mkSQL("update %I set estado=%Q, fecha=%Q, userid=%N ", $table, $dm->getEstado(), $dm->getFecha(), $dm->getUser());
            $sql .= $this->mkSQL("where bibid=%N ", $dm->getBibid());
          //return $this->_query($sql, "Error updating ".$table);
	       }
	   //fin franco
	   else
	       {
           $sql = $this->mkSQL("update %I set description=%Q, default_flg='N', ", $table, $dm->getDescription());
           if ($table == "collection_dm") 
 	           {
               $sql .= $this->mkSQL("days_due_back=%N, daily_late_fee=%N ", $dm->getDaysDueBack(), $dm->getDailyLateFee());
               }
	       else
		       {
		       if ($table == "material_type_dm") 
	              {
                  $sql .= $this->mkSQL("adult_checkout_limit=%N, "
                          . "juvenile_checkout_limit=%N, "
                          . "image_file=%Q ",
                          $dm->getAdultCheckoutLimit(),
                          $dm->getJuvenileCheckoutLimit(),
                          $dm->getImageFile());
                  }
		       if ($table == "concepto_dm") 
	              {
                  $sql .= $this->mkSQL("fecha_vto = %Q ",
                          $dm->getFechaVto());
                  }				  
	           else
	              {
                  $this->_errorOccurred = true;
                  $this->_error = "Can only update rows on collections and material types.";
                  return false;
                  }
		       }
		   $sql .= $this->mkSQL("where code=%N ", $dm->getCode());     
		   }
       }  
  return $this->_query($sql, "Error updating ".$table);
	   
  }
  
  function isConceptoInAdquisicion($code)
  {
    $sql = $this->mkSQL("select * from adquisicion where concepto_cd = %N ", $code);
	$result = $this->_query($sql, "Error al buscar el concepto en alguna adquisición");
	return (mysql_num_rows($result) > 0);
  }
  
  function isEstadoInAdquisicion($code)
  {
    $sql = $this->mkSQL("select * from adquisicion where estado_cd = %N ", $code);
	$result = $this->_query($sql, "Error al buscar el estado en alguna adquisición");
	return (mysql_num_rows($result) > 0);
  }
  
  function isAreaInAdquisicion($code)
  {
    $sql = $this->mkSQL("select * from adquisicion where area_cd = %N ", $code);
	$result = $this->_query($sql, "Error al buscar el área en alguna adquisición");
	return (mysql_num_rows($result) > 0);
  }    

  /****************************************************************************
   * Deletes a row from a domain table.
   * @param string $mbrid Member id of library member to delete
   * @return boolean returns false, if error occurs
   * @access public
   ****************************************************************************
   */
  function delete($table, $code) {
    $sql = $this->mkSQL("delete from %I where code = %N", $table, $code);
    return $this->_query($sql, "Error deleting from ".$table);
  }
  
  /**
  Autor: Horacio Alvarez
  Agregado: 23-03-06
  Descripcion: funcion que valida la dupliacion de datos.
  Recibe como parametros el valor y el nombre del campo en cuestion.
  */
  function _dupValue($value,$nombreCampo) {
    $sql = $this->mkSQL("select count(*) from %I where $nombreCampo = %N", $this->_tableNm, $value);
    if (!$this->_query($sql, "Error checking for $nombreCampo.")) {
      return false;
    }
    $array = $this->_conn->fetchRow(OBIB_NUM);
    if ($array[0] > 0) {
      return true;
    }
    return false;
  }  

}

?>
