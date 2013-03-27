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

  require_once("../classes/ReportCriteria.php");
  require_once("../classes/ReportQuery.php");

  #****************************************************************************
  #*  Page functions
  #****************************************************************************
  /*
  Autor: Horacio Alvarez
  Fecha: 27-05-2006
  Descripcion: Modificado para agregar los operadores de busqueda %%
  cuando se busca por LIKE en strings.
  */
  function getCriteria(&$vars,$index) {
    $crit = new ReportCriteria();
    $colData = explode(" ", $vars["fieldId".$index]);
    $fieldId = $colData[0];
    $fieldType = $colData[1];
    $fieldIsNumeric = $colData[2];
    $crit->setFieldid($fieldId);
    $crit->setType($fieldType);
    $crit->setNumeric($fieldIsNumeric);
	$comparador=$vars["comparitor".$index];
    $crit->setComparitor($vars["comparitor".$index]);
    $vars["comparitor".$index] = $crit->getComparitor();
	$value1=$vars["fieldValue".$index."a"];
	if($crit->getComparitor()=="like")
	   $crit->setValue1("%".$value1."%");
	else
       $crit->setValue1($value1);
    $vars["fieldValue".$index."a"] = $crit->getValue1();
	$value2=$vars["fieldValue".$index."b"];
    $crit->setValue2($vars["fieldValue".$index."b"]);
    $vars["fieldValue".$index."b"] = $crit->getValue2();
    return $crit;
  }

  #****************************************************************************
  #*  Read form variables
  #****************************************************************************
  $rptid = $_POST["rptid"];
  $title = $_POST["title"];
  $label = "";
  if(isset($_POST["label"]))
    $label = $_POST["label"];
  $letter = $_POST["letter"];
  $initialSort = $_POST["initialSort"];
  $baseSql = stripslashes($_POST["sql"]);
  $metaSql = urlencode($baseSql);
  
  if($rptid=="siunpaEstadisctico")
     {
	    $anio=$_POST["anio"];
		$baseSql = str_replace("-1",$anio,$baseSql);
	 }
  elseif($rptid=="estadisticoOperaciones")
     {
	    $anio=$_POST["anio"];
		$baseSql = str_replace("-1",$anio,$baseSql);
	 }
  elseif($rptid=="estadisticoUsuarios")
     {
	    $anio=$_POST["anio"];
		$baseSql = str_replace("-1",$anio,$baseSql);
	 }	 	   
  elseif($rptid=="prestamosAnuales")
     {
	    $anio=$_POST["anio"];
		$materialCd=$_POST["materialCd"];
		$fecha_desde=$anio."-01-01";
		$fecha_hasta=$anio."-12-31";
		$baseSql.=" AND H.status_begin_dt between '$fecha_desde' and '$fecha_hasta' ";
		if($materialCd!="")
		   $baseSql.=" AND B.material_cd=$materialCd ";
		$baseSql.=" order by H.status_begin_dt desc ";
	 }
  elseif($rptid=="prestamosMensuales")
      {
	    $anio=$_POST["anio"];
		$mes_desde=$_POST["mes_desde"];
		if($mes_desde<10)
		   $mes_desde="0".$mes_desde;
		$mes_hasta=$_POST["mes_hasta"];
		if($mes_hasta<10)
		   $mes_hasta="0".$mes_hasta;		
		$materialCd=$_POST["materialCd"];
		$fecha_desde=$anio."-".$mes_desde."-01";
		$fecha_hasta=$anio."-".$mes_hasta."-31";
		$baseSql.=" AND H.status_begin_dt between '$fecha_desde' and '$fecha_hasta' ";
		if($materialCd!="")
		   $baseSql.=" AND B.material_cd=$materialCd ";
		$baseSql.=" order by H.status_begin_dt desc ";	  
	  }
  elseif($rptid=="prestamosDiarios")
      {
	    $anio_desde=$_POST["list_year_desde"];
		$mes_desde=$_POST["list_month_desde"];
		$dia_desde=$_POST["list_day_desde"];
	    $anio_hasta=$_POST["list_year_hasta"];
		$mes_hasta=$_POST["list_month_hasta"];
		$dia_hasta=$_POST["list_day_hasta"];				
		$materialCd=$_POST["materialCd"];
		$fecha_desde=$anio_desde."-".$mes_desde."-".$dia_desde;
		$fecha_hasta=$anio_hasta."-".$mes_hasta."-".$dia_hasta;
		$baseSql.=" and DATE_FORMAT(H.status_begin_dt,'%Y-%m-%d') between '$fecha_desde' and  '$fecha_hasta' ";
		if($materialCd!="")
		   $baseSql.=" AND B.material_cd=$materialCd ";
		$baseSql.=" order by H.status_begin_dt desc ";	  
	  }
  elseif($rptid=="devolucionesDiarias")
      {
	    $anio_desde=$_POST["list_year_desde"];
		$mes_desde=$_POST["list_month_desde"];
		$dia_desde=$_POST["list_day_desde"];
	    $anio_hasta=$_POST["list_year_hasta"];
		$mes_hasta=$_POST["list_month_hasta"];
		$dia_hasta=$_POST["list_day_hasta"];				
		$fecha_desde=$anio_desde."-".$mes_desde."-".$dia_desde;
		$fecha_hasta=$anio_hasta."-".$mes_hasta."-".$dia_hasta;
		$baseSql.=" and DATE_FORMAT(H.status_begin_dt,'%Y-%m-%d') between '$fecha_desde' and  '$fecha_hasta' ";
		$baseSql.=" order by H.status_begin_dt desc ";	  
	  }
  elseif($rptid=="prestamosVencer")
      {
	    $anio_desde=$_POST["list_year_desde"];
		$mes_desde=$_POST["list_month_desde"];
		$dia_desde=$_POST["list_day_desde"];
		$fecha_desde=$anio_desde."-".$mes_desde."-".$dia_desde;
		$baseSql.=" and DATE_FORMAT(c.due_back_dt,'%Y-%m-%d') like '$fecha_desde' ";
		$baseSql.=" order by c.due_back_dt desc ";	  
	  }	  	  	  
  elseif($rptid=="listadoSocios")
      {
	    $classification=$_POST["classification"];
		$letra_desde=$_POST["letra_desde"];
		$letra_hasta=$_POST["letra_hasta"];
		$carrera = $_POST["carrera"];
		if($letra_desde>$letra_hasta)
		  {
		   $aux=$letra_desde;
		   $letra_desde=$letra_hasta;
		   $letra_hasta=$aux;
		  }
		if($letra_desde!=$letra_hasta)
		    $baseSql.=" AND M.last_name between '$letra_desde%' and '$letra_hasta%' ";
	    else
		    $baseSql.=" AND M.last_name like '$letra_desde%' ";
	    if($classification!="")
		  $baseSql.=" AND M.classification = $classification ";
	    if($carrera != "")
		  $baseSql.=" AND M.carrera = $carrera ";		  
		$baseSql.=" order by last_name ";  
		
	  }	  	  

  #****************************************************************************
  #*  Validate selection criteria
  #****************************************************************************
  $crit = Array();
  $allCriteriaValid = TRUE;

  for ($i = 1; $i <= 4; $i++) {
   if(isset($_POST["fieldId".$i]))
    if ($_POST["fieldId".$i] != "") {
      $crit[$i] = getCriteria($_POST,$i);
      $critValid = $crit[$i]->validateData();
      $_POST["fieldValue".$i."a"] = $crit[$i]->getValue1();
      $_POST["fieldValue".$i."b"] = $crit[$i]->getValue2();
      if (!$critValid) {
        $allCriteriaValid = FALSE;
        $pageErrors["fieldValue".$i."a"] = $crit[$i]->getValue1Error();
        $pageErrors["fieldValue".$i."b"] = $crit[$i]->getValue2Error();
      }
    }
  }

  #****************************************************************************
  #*  Go back to criteria screen if any errors occurred
  #****************************************************************************
  $_SESSION["postVars"] = $_POST;
  if (!$allCriteriaValid) {
    $_SESSION["pageErrors"] = $pageErrors;
    $urlTitle = urlencode($title);
    $urlSql = urlencode($baseSql);
    header("Location: ../reports/report_criteria.php?rptid=".$rptid."&title=".$urlTitle."&sql=".$urlSql."&label=".$label."&letter=".$letter."&initialSort=".$initialSort);
    exit();
  }

  #****************************************************************************
  #*  add selection criteria to sql
  #****************************************************************************
  // checking for existing where clause.
  
  if(!isset($_POST["fromBusquedaAvanzada"]))
    {
      $hasWhereClause = stristr($baseSql,"where");
      if ($hasWhereClause == FALSE) {
          $clausePrefix = " where ";
      } else {
         $clausePrefix = " and ";
        }

      // add each selection criteria to the sql
      $splitResult = spliti("group by",$baseSql,2);
      if (count($splitResult) > 1) {
         $sql = $splitResult[0];
         $groupBy = $splitResult[1];
      } else {
         $sql = $baseSql;
         $groupBy = "";
      }
	 }
  else
     {
	  $clausePrefix = " and ";
      $sql = $baseSql;
      $groupBy = "";	  
	 }

  foreach($crit as $c) {
    $sql = $sql.$clausePrefix.$c->getFieldid()." ".$c->getSqlComparitor();
    if ($c->isNumeric()) {
      $quote = "";
    } else {
      $quote = "'";
    }
    $sql = $sql." ".$quote.$c->getValue1().$quote;
    if ($c->getComparitor() == "bt") {
      $sql = $sql." and ".$quote.$c->getValue2().$quote;
    }
    $clausePrefix = " and ";
  }

  #****************************************************************************
  #*  add group by back in if it exists
  #****************************************************************************
  if ($groupBy != "") {
    $sql = $sql." group by ".$groupBy;
  }

  #****************************************************************************
  #*  add sort clause to sql
  #****************************************************************************
  $clausePrefix = " order by ";
  for ($i = 1; $i <= 3; $i++) {
    $sortOrderFldNm = "sortOrder".$i;
    $sortDirFldNm = "sortDir".$i;
	$sortCol="";
	if(isset($_POST[$sortOrderFldNm])) $sortCol = $_POST[$sortOrderFldNm];
	$sortDir = "";
	if(isset($_POST[$sortDirFldNm])) $sortDir = $_POST[$sortDirFldNm];
    if ($sortCol != ""){
      $sql = $sql.$clausePrefix.$sortCol;
      if ($sortDir == "desc") {
        $sql = $sql." DESC";
      }
      $clausePrefix = ", ";
    }
  }
  
  #****************************************************************************
  #*  run report
  #****************************************************************************
  $reportQ = new ReportQuery();
  $reportQ->connect();
  if ($reportQ->errorOccurred()) {
    $reportQ->close();
    displayErrorPage($reportQ);
  }
  $result = $reportQ->query($sql);
  if ($reportQ->errorOccurred()) {
    $reportQ->close();
    displayErrorPage($reportQ);
  }
  $fieldIds = array();
  $fieldNames = array();
  $fieldTypes = array();
  $fieldNumericFlgs = array();
  while ($fld = $reportQ->fetchField()) {
    $fldid = $fld->name;
    if ($fld->table != "") {
	   if(substr_count($fld->table,"#")==0)//agregado por Horacio Alvarez
          $fldid = $fld->table.".".$fldid;
    }
    $fieldIds[] = $fldid;
    $fieldTypes[$fldid] = $fld->type;
    $fieldNumericFlgs[$fldid] = $fld->numeric;
  }

  $colCount = count($fieldIds);
  $rowCount = $reportQ->getRowCount();
  $qStrTitle = urlencode($title);
  $qStrSql = urlencode($baseSql);

?>
