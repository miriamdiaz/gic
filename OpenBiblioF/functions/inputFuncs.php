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

require_once("../functions/errorFuncs.php");
require_once("../classes/Dm.php");
require_once("../classes/DmQuery.php");

/*********************************************************************************
 * Draws input html tag of type text.
 * @param string $fieldName name of input field
 * @param string $size size of text box
 * @param string $max max input length of text box
 * @param array_reference &$postVars reference to array containing all input values
 * @param array_reference &$pageErrors reference to array containing all input errors
 * @return void
 * @access public
 *********************************************************************************
 */

function printSelectCarreras($fieldName,$postVars)
{
$db = new Query();
$db->connect();
$sql="select carrera from member where not isnull(carrera) and length(carrera) > 0 group by carrera order by carrera asc";
$result=$db->_query($sql,"");

echo  "<select id='$fieldName' name='$fieldName' >\n";
echo "<option value=''></option>";

while($row = mysql_fetch_array($result))
    {
	  $value = "";
	  if (isset($postVars[$fieldName])) {
		  $value = $postVars[$fieldName];
	  }
	
	  echo "<option value='".$row["carrera"]."'";
	  if ($value == $row["carrera"]) {
		  echo " selected";
		}
		echo ">".$row["carrera"]."\n";
	
	}
	  echo "</select>\n";	
} 
 
 
 
function printSelectReference($fieldName,$domainTable,&$postVars,&$reference){
  $value = "";
  if (isset($postVars[$fieldName])) {
      $value = $postVars[$fieldName];
  }

  $dmQ = new DmQuery();
  $dmQ->connect();
  if ($dmQ->errorOccurred()) {
    $dmQ->close();
    displayErrorPage($dmQ);
  }
  $dmQ->execSelect($domainTable);
  if ($dmQ->errorOccurred()) {
    $dmQ->close();
    displayErrorPage($dmQ);
  }
  $reference= "<select id='$fieldName' name='$fieldName'";
  $reference.= ">\n";
  $reference.= "<option value=''></option>";
  while ($dm = $dmQ->fetchRow()) {
    $reference.= "<option value='".$dm->getCode()."'";
    if (($value == "") && ($dm->getDefaultFlg() == 'Y')) {
      $reference.= " selected";
    } elseif ($value == $dm->getCode()) {
      $reference.= " selected";
    }
    $reference.= ">".$dm->getDescription()."\n";
  }
//  echo "<option value=\"\" selected> ";
  $reference.= "</select>\n";
  $dmQ->close();
}

function printSelectReferenceSinCodeSoloOptions($domainTable,&$postVars,&$reference){
  $value = "";
/*  if (isset($postVars[$fieldName])) {
      $value = $postVars[$fieldName];
  }*/

  $dmQ = new DmQuery();
  $dmQ->connect();
  if ($dmQ->errorOccurred()) {
    $dmQ->close();
    displayErrorPage($dmQ);
  }
  $dmQ->execSelect($domainTable);
  if ($dmQ->errorOccurred()) {
    $dmQ->close();
    displayErrorPage($dmQ);
  }
  $reference= "<option value=''></option>";
  while ($dm = $dmQ->fetchRow()) {
    $reference.= "<option value='".$dm->getDescription()."'";
    if (($value == "") && ($dm->getDefaultFlg() == 'Y')) {
      $reference.= " selected";
    } elseif ($value == $dm->getCode()) {
      $reference.= " selected";
    }
    $reference.= ">".$dm->getDescription()."\n";
  }
//  echo "<option value=\"\" selected> ";
  $dmQ->close();
}

function printSelectReferenceSinCode($fieldName,$domainTable,&$postVars,&$reference){
  $value = "";
  if (isset($postVars[$fieldName])) {
      $value = $postVars[$fieldName];
  }

  $dmQ = new DmQuery();
  $dmQ->connect();
  if ($dmQ->errorOccurred()) {
    $dmQ->close();
    displayErrorPage($dmQ);
  }
  $dmQ->execSelect($domainTable);
  if ($dmQ->errorOccurred()) {
    $dmQ->close();
    displayErrorPage($dmQ);
  }
  $reference= "<select id='$fieldName' name='$fieldName'";
  $reference.= ">\n";
  $reference.= "<option value=''></option>";
  while ($dm = $dmQ->fetchRow()) {
    $reference.= "<option value='".$dm->getDescription()."'";
    if (($value == "") && ($dm->getDefaultFlg() == 'Y')) {
      $reference.= " selected";
    } elseif ($value == $dm->getCode()) {
      $reference.= " selected";
    }
    $reference.= ">".$dm->getDescription()."\n";
  }
//  echo "<option value=\"\" selected> ";
  $reference.= "</select>\n";
  $dmQ->close();
}
 

/**
Autor: Horacio Alvarez
Fecha: 26-03-06
Descripcion: Modificado para recibir como parametro un valor default.
*/
function printInputText($fieldName,$size,$max,&$postVars,&$pageErrors,$visibility = "visible",$default = "",$type="text")
{
  if (!isset($postVars))
  {
    $value = $default;
  }
  elseif (!isset($postVars[$fieldName])) 
  {
      $value = $default;
  } 
  else
  {
      $value = $postVars[$fieldName];
  }
  if (!isset($pageErrors)) 
  {
    $error = "";
  } 
  elseif (!isset($pageErrors[$fieldName])) 
  {
      $error = "";
  } 
  else 
  {
      $error = $pageErrors[$fieldName];
  }

  echo "<input type=\"".$type."\" id=\"".$fieldName."\" name=\"".$fieldName."\" size=\"".$size."\" maxlength=\"".$max."\"";
  if ($visibility != "visible") 
  {
    echo " style=\"visibility:".$visibility."\"";
  }
  echo " value=\"".$value."\" >";
  if ($error != "") 
  {
    echo "<br><font class=\"error\">";
    echo $error."</font>";
  }
}

function printInputTextAutocompletar($fieldName,$size,$max,&$postVars,&$pageErrors,$visibility = "visible",$tabla,$atributo)
{
  if (!isset($postVars))
  {
    $value = "";
  }
  elseif (!isset($postVars[$fieldName])) 
  {
      $value = "";
  } 
  else
  {
      $value = $postVars[$fieldName];
  }
  if (!isset($pageErrors)) 
  {
    $error = "";
  } 
  elseif (!isset($pageErrors[$fieldName])) 
  {
      $error = "";
  } 
  else 
  {
      $error = $pageErrors[$fieldName];
  }

  echo "<input type=\"text\" id=\"".$fieldName."\" name=\"".$fieldName."\" size=\"".$size."\" maxlength=\"".$max."\"";
  if ($visibility != "visible") 
  {
    echo " style=\"visibility:".$visibility."\"";
  }
  echo " value=\"".$value."\" >";
  if ($error != "") 
  {
    echo "<br><font class=\"error\">";
    echo $error."</font>";
  }
}

/*********************************************************************************
 * Draws input html tag of type text.
 * @param string $fieldName name of input field
 * @param string $domainTable name of domain table to get values from
 * @param array_reference &$postVars reference to array containing all input values
 *********************************************************************************
 */
function printSelect($fieldName,$domainTable,&$postVars,$disabled=FALSE){
  $value = "";
  if (isset($postVars[$fieldName])) {
      $value = $postVars[$fieldName];
  }

  $dmQ = new DmQuery();
  $dmQ->connect();
  if ($dmQ->errorOccurred()) {
    $dmQ->close();
    displayErrorPage($dmQ);
  }
  $dmQ->execSelect($domainTable);
  if ($dmQ->errorOccurred()) {
    $dmQ->close();
    displayErrorPage($dmQ);
  }
  echo "<select id=\"".$fieldName."\" name=\"".$fieldName."\"";
  if ($disabled) {
    echo " disabled";
  }
  echo ">\n";
  echo "<option value=\"\"></option>";
  while ($dm = $dmQ->fetchRow()) {
    echo "<option value=\"".$dm->getCode()."\"";
    if (($value == "") && ($dm->getDefaultFlg() == 'Y')) {
      echo " selected";
    } elseif ($value == $dm->getCode()) {
      echo " selected";
    }
    echo ">".$dm->getDescription()."\n";
  }
//  echo "<option value=\"\" selected> ";
  echo "</select>\n";  
  $dmQ->close();
}

/*********************************************************************************
 * Draws input html tag of type text.
 * @param string $fieldName name of input field
 * @param string $domainTable name of domain table to get values from
 * @param array_reference &$postVars reference to array containing all input values
 *********************************************************************************
 */
/**
Agregado: Horacio Alvarez
Fecha: 25-03-06
Descripcion: printSelect agregado para poder recibir la varible de sesion pageErrors por parametro
*/ 
function printSelectWithPosErrors($fieldName,$domainTable,&$postVars,&$pageErrors,$disabled=FALSE){
  $value = "";
  if (isset($postVars[$fieldName])) {
      $value = $postVars[$fieldName];
  }
  if (!isset($pageErrors)) 
  {
    $error = "";
  } 
  elseif (!isset($pageErrors[$fieldName])) 
  {
      $error = "";
  } 
  else 
  {
      $error = $pageErrors[$fieldName];
  }  

  $dmQ = new DmQuery();
  $dmQ->connect();
  if ($dmQ->errorOccurred()) {
    $dmQ->close();
    displayErrorPage($dmQ);
  }
  $dmQ->execSelect($domainTable);
  if ($dmQ->errorOccurred()) {
    $dmQ->close();
    displayErrorPage($dmQ);
  }
  echo "<select id=\"".$fieldName."\" name=\"".$fieldName."\"";
  if ($disabled) {
    echo " disabled";
  }
  echo ">\n";
  echo "<option value=\"\"></option>";
  while ($dm = $dmQ->fetchRow()) {
    echo "<option value=\"".$dm->getCode()."\"";
    if (($value == "") && ($dm->getDefaultFlg() == 'Y')) {
      echo " selected";
    } elseif ($value == $dm->getCode()) {
      echo " selected";
    }
    echo ">".$dm->getDescription()."\n";
  }
//  echo "<option value=\"\" selected> ";
  echo "</select>";
  if ($error != "") 
  {
    echo "<br><font class=\"error\">";
    echo $error."</font>";
  }  
  $dmQ->close();
}

function printConceptosActivos($fieldName,$domainTable,&$postVars,&$pageErrors,$disabled=FALSE){
  $value = "";
  if (isset($postVars[$fieldName])) {
      $value = $postVars[$fieldName];
  }
  if (!isset($pageErrors)) 
  {
    $error = "";
  } 
  elseif (!isset($pageErrors[$fieldName])) 
  {
      $error = "";
  } 
  else 
  {
      $error = $pageErrors[$fieldName];
  }  

  $dmQ = new DmQuery();
  $dmQ->connect();
  if ($dmQ->errorOccurred()) {
    $dmQ->close();
    displayErrorPage($dmQ);
  }
  $dmQ->execSelectConceptoActivos($domainTable);
  if ($dmQ->errorOccurred()) {
    $dmQ->close();
    displayErrorPage($dmQ);
  }
  echo "<select id=\"".$fieldName."\" name=\"".$fieldName."\"";
  if ($disabled) {
    echo " disabled";
  }
  echo ">\n";
  echo "<option value=\"\"></option>";
  while ($dm = $dmQ->fetchRow()) {
    echo "<option value=\"".$dm->getCode()."\"";
    if (($value == "") && ($dm->getDefaultFlg() == 'Y')) {
      echo " selected";
    } elseif ($value == $dm->getCode()) {
      echo " selected";
    }
    echo ">".$dm->getDescription()."\n";
  }
//  echo "<option value=\"\" selected> ";
  echo "</select>";
  if ($error != "") 
  {
    echo "<br><font class=\"error\">";
    echo $error."</font>";
  }  
  $dmQ->close();
}

function printSelectVacio($fieldName,$domainTable,&$postVars,$disabled=FALSE){
  $value = "";
  if (isset($postVars[$fieldName])) {
      $value = $postVars[$fieldName];
  }

  $dmQ = new DmQuery();
  $dmQ->connect();
  if ($dmQ->errorOccurred()) {
    $dmQ->close();
    displayErrorPage($dmQ);
  }
  $dmQ->execSelect($domainTable);
  if ($dmQ->errorOccurred()) {
    $dmQ->close();
    displayErrorPage($dmQ);
  }
  echo "<select id=\"".$fieldName."\" name=\"".$fieldName."\"";
  if ($disabled) {
    echo " disabled";
  }
  echo ">\n";
  echo "<option value=\"\" selected></option>";
  while ($dm = $dmQ->fetchRow()) {
    echo "<option value=\"".$dm->getCode()."\"";
    echo ">".$dm->getDescription()."\n";
  }
//  echo "<option value=\"\" selected> ";
  echo "</select>\n";
  $dmQ->close();
}

/**
Name: Horacio Alvarez
Date: 2006-03-10
Description: Genera checkboxs dinamicamente por cada registro una tabla,
              para este caso, los valores de cada checkbox es dado
			  por el campo Code de la clase dm;
*/
function printCheckBoxs($domainTable,$fieldName,&$postVars,&$pageErrors)
{
  $value = "";
  if (isset($postVars[$fieldName])) {
      $value = $postVars[$fieldName];
  }
  
  $dmQ = new DmQuery();
  $dmQ->connect();
  if ($dmQ->errorOccurred()) {
    $dmQ->close();
    displayErrorPage($dmQ);
  }
  $dmQ->execSelect($domainTable);
  if ($dmQ->errorOccurred()) {
    $dmQ->close();
    displayErrorPage($dmQ);
  }
  $i=0;
  while ($dm = $dmQ->fetchRow()) {
    $checked="";
    if($domainTable=="biblio_cod_library")
       if($dm->getPrestamos_flg()=='Y')
	      $checked="checked";
    echo "<input type=\"checkbox\" name=\"$fieldName$i\" value=\"".$dm->getCode()."\" $checked>";
	echo $dm->getDescription();
	echo "<br>";
	$i++;
  }
  $i--;       
  echo "<input type='hidden' name='countChecks' value='$i'";
  
}
function printDomainDescription($domainTable,$value)
{
  $dmQ = new DmQuery();
  $dmQ->connect();
  if ($dmQ->errorOccurred()) {
    $dmQ->close();
    displayErrorPage($dmQ);
  }
  $dmQ->execSelect($domainTable);
  if ($dmQ->errorOccurred()) {
    $dmQ->close();
    displayErrorPage($dmQ);
  }
  $i=0;
  while ($dm = $dmQ->fetchRow()) {
	if($dm->getCode()==$value)
	   echo $dm->getDescription();
	$i++;
  }
}

function printInputTextWithSearch($fieldName,$size,$max,&$postVars,&$pageErrors,$input_id="",$visibility="visible")
{
  if (!isset($postVars))
  {
    $value = "";
  }
  elseif (!isset($postVars[$fieldName])) 
  {
      $value = "";
  } 
  else
  {
      $value = $postVars[$fieldName];
  }
  if (!isset($pageErrors)) 
  {
    $error = "";
  } 
  elseif (!isset($pageErrors[$fieldName])) 
  {
      $error = "";
  } 
  else 
  {
      $error = $pageErrors[$fieldName];
  }

  echo "<input type=\"text\" id=\"".$fieldName."\" name=\"".$fieldName."\" size=\"".$size."\" maxlength=\"".$max."\"";
  if ($visibility != "visible") 
  {
    echo " style=\"visibility:".$visibility."\"";
  }
  echo " value=\"".$value."\" >";
  echo "<input type=\"button\" value=\"Agregar\" onClick=\"window.open('search_$input_id.php','secondary','resizable=yes,scrollbars=yes,status=yes,width=535,height=400');\" class=\"button\">";
  if ($error != "") 
  {
    echo "<br><font class=\"error\">";
    echo $error."</font>";
  }
}


/**
Name: Horacio Alvarez
Fecha: 20-04-06
Descripcion: Imprime un checkbox con el nombre y valor recibido por parametro.
*/
function printCheckBox($name,$value)
{
  echo "<input type=\"checkbox\" name=\"$name\" value=\"$value\">";
}

/**
Name: Horacio Alvarez
Date: 2006-03-10
Description: Genera radio buttons dinamicamente por cada registro una tabla,
              para este caso, los valores de cada radio es dado
			  por el campo value de la clase dm.
*/
function printRadioButtonsValue($domainTable,$fieldName,&$postVars,&$pageErrors)
{
  $value = "";
  if (isset($postVars[$fieldName])) {
      $value = $postVars[$fieldName];
  }
  
  $dmQ = new DmQuery();
  $dmQ->connect();
  if ($dmQ->errorOccurred()) {
    $dmQ->close();
    displayErrorPage($dmQ);
  }
  $dmQ->execSelect($domainTable);
  if ($dmQ->errorOccurred()) {
    $dmQ->close();
    displayErrorPage($dmQ);
  }
  $i=0;
  while ($dm = $dmQ->fetchRow()) {
    $checked="";
    if($dm->getValue()==7)
      $checked="checked";
    echo "<input type=\"radio\" name=\"$fieldName\" value=\"".$dm->getValue()."\" $checked>";
	echo $dm->getDescription();
	echo "<br>";
	$i++;
  }
  $i--;       
  echo "<input type='hidden' name='countChecks' value='$i'";
  
}

/*ini franco*/
function day_box($name,$id,$class,$width,$selected)
{
	$content='<select name="'.$name.'"id="'.$id.'"class."'.$class.'"
	style="width:'.$width.'px">'."\r";
	for($i=1;$i<=31;$i++)
	{
		if($i == $selected)
		{
			$isselected='selected';
		}
		else
		{
			$isselected='';
		}
		$iki=$i;
		if($iki<10)
		{
			$iki='0'.$iki;
		}
		$content.="\t<option value=\"$iki\"$isselected>";
		$content.="$iki</option>\r";
	}
	$content.="</select>";
	return $content;
}
function month_box($name, $id,$class,$width,$selected)
{
	$monthtext[1]="Enero";
	$monthtext[2]="Febrero";
	$monthtext[3]="Marzo";
	$monthtext[4]="Abril";
	$monthtext[5]="Mayo";
	$monthtext[6]="Junio";
	$monthtext[7]="Julio";
	$monthtext[8]="Agosto";
	$monthtext[9]="Septiembre";
	$monthtext[10]="Octubre";
	$monthtext[11]="Noviembre";
	$monthtext[12]="Diciembre";
	$content='<select name="'.$name.'"id="'.$id.'"class="'.$class.'"
	style="width:'.$width.'px">'."\r";
	for($i=1;$i<=12;$i++)
	{
		if($i == $selected)
		{
			$isselected='selected';
		}
		else
		{
			$isselected='';
		}
		$iki=$i;
		if($iki<10)
		{
			$iki='0'.$iki;
		}
		$content.="\t<option value=\"$iki\"$isselected>";
		$content.="$iki-$monthtext[$i]</option>\r";
	}
	$content.="</select>";
	return $content;
}

function year_box($name,$id,$class,$width,$selected)
{
	$content='<select name="'.$name.'"id="'.$id.'"class."'.$class.'"
	style="width:'.$width.'px">'."\r";
	for($i=1990;$i<=2090;$i++)
	{
		if($i == $selected)
		{
			$isselected='selected';
		}
		else
		{
			$isselected='';
		}
		$iki=$i;
		$content.="\t<option value=\"$iki\" $isselected>";
		$content.="$iki</option>\r";
	}
	$content.="</select>";
	return $content;
	
}
function printSelectDate($fieldName,&$postVars,&$pageErrors)
{
  if(!isset($postVars[$fieldName]))
  {echo $day_box=day_box('list_day','','','50',date("d"));
  echo " / ";
  echo $month_box=month_box('list_month','','','120',date("m"));
  echo " / ";
  echo $year_box=year_box('list_year','','','60',date("Y"));}
 
  if (!isset($postVars))
  {
    $value = "";
  }
  elseif (!isset($postVars[$fieldName])) 
  {
      $value = "";
  } 
  else
  {
      $value = $postVars[$fieldName];
	  list( $year, $month, $day ) = split( '[/.-]', $value);
	  echo $day_box=day_box('list_day','','','50',$day);
  	  echo " / ";
	  echo $month_box=month_box('list_month','','','120',$month);
	  echo " / ";
	  echo $year_box=year_box('list_year','','','60',$year);
  }

  if (!isset($pageErrors)) 
  {
    $error = "";
  } 
  elseif (!isset($pageErrors[$fieldName])) 
  {
      $error = "";
  } 
  else 
  {
      $error = $pageErrors[$fieldName];
  }
 
  if ($error != "") 
  {
    echo "<br><font class=\"error\">";
    echo $error."</font>";
  }
  /*if ($pageErrors != "") 
  {
	$error="Fecha Incorrecta";
    echo "<br><font class=\"error\">";
    echo $error."</font>";
  }*/
}
/*fin franco*/

function printSelectDateWithInputName($fieldName,&$postVars,&$pageErrors)
{
  if(!isset($postVars[$fieldName]))
  {echo $day_box=day_box('list_day_'.$fieldName,'','','50',date("d"));
  echo " / ";
  echo $month_box=month_box('list_month_'.$fieldName,'','','120',date("m"));
  echo " / ";
  echo $year_box=year_box('list_year_'.$fieldName,'','','60',date("Y"));}
 
  if (!isset($postVars))
  {
    $value = "";
  }
  elseif (!isset($postVars[$fieldName])) 
  {
      $value = "";
  } 
  else
  {
      $value = $postVars[$fieldName];
	  if($value != "")
	     list( $year, $month, $day ) = split( '[/.-]', $value);
	  else
	    {
	     $day = date("d");
		 $month = date("m");
		 $year = date("Y");
		}
	  echo $day_box=day_box('list_day_'.$fieldName,'','','50',$day);
  	  echo " / ";
	  echo $month_box=month_box('list_month_'.$fieldName,'','','120',$month);
	  echo " / ";
	  echo $year_box=year_box('list_year_'.$fieldName,'','','60',$year);
  }

  if (!isset($pageErrors)) 
  {
    $error = "";
  } 
  elseif (!isset($pageErrors[$fieldName])) 
  {
      $error = "";
  } 
  else 
  {
      $error = $pageErrors[$fieldName];
  }
 
  if ($error != "") 
  {
    echo "<br><font class=\"error\">";
    echo $error."</font>";
  }
  /*if ($pageErrors != "") 
  {
	$error="Fecha Incorrecta";
    echo "<br><font class=\"error\">";
    echo $error."</font>";
  }*/
}

function printSelectDateSinPostVars($fieldName)
{
  echo $day_box=day_box("list_day_$fieldName","","","50",date("d"));
  echo " / ";
  echo $month_box=month_box("list_month_$fieldName","","","120",date("m"));
  echo " / ";
  echo $year_box=year_box("list_year_$fieldName","","","60",date("Y"));
}

/*ini franco 12/07/05*/
function printInputTextArea($fieldName,$size,$max,&$postVars,&$pageErrors,$visibility = "visible")
{
  $size = 40;
  $maxLen = 300;
  $cols = 35;
  $rows = 4;

  if (!isset($postVars))
  {
    $value = "";
  }
  elseif (!isset($postVars[$fieldName])) 
  {
      $value = "";
  } 
  else
  {
      $value = $postVars[$fieldName];
  }
  if (!isset($pageErrors))
  {
    $error = "";
  }
  elseif (!isset($pageErrors[$fieldName])) 
  {
      $error = "";
  }
  else
  {  
      $error = $pageErrors[$fieldName];
  }
    echo "<textarea name=\"values[".$fieldName."]\" cols=\"".$cols."\" rows=\"".$rows."\">";
    echo $value."</textarea>";
   
  if ($error != "")
  {
    echo "<br><font class=\"error\">";
    echo $error."</font>";
  }
}
//fin franco

function printInputTextAreaFixed($fieldName,$size,$max,&$postVars,&$pageErrors,$visibility = "visible")
{
  $size = 40;
  $maxLen = 300;
  $cols = 35;
  $rows = 4;

  if (!isset($postVars))
  {
    $value = "";
  }
  elseif (!isset($postVars[$fieldName])) 
  {
      $value = "";
  } 
  else
  {
      $value = $postVars[$fieldName];
  }
  if (!isset($pageErrors))
  {
    $error = "";
  }
  elseif (!isset($pageErrors[$fieldName])) 
  {
      $error = "";
  }
  else
  {  
      $error = $pageErrors[$fieldName];
  }
    echo "<textarea name=\"$fieldName\" cols=\"".$cols."\" rows=\"".$rows."\">";
    echo $value."</textarea>";
   
  if ($error != "")
  {
    echo "<br><font class=\"error\">";
    echo $error."</font>";
  }
}


//ini JUDITH 15/11/05

function printSelectDate1($fieldName,&$postVars,&$pageErrors)
{
  if(!isset($postVars[$fieldName]))
  {echo $day_box=day_box('list_day1','','','50',date("d"));
  echo " / ";
  echo $month_box=month_box('list_month1','','','120',date("m"));
  echo " / ";
  echo $year_box=year_box('list_year1','','','60',date("Y"));}
 
  if (!isset($postVars))
  {
    $value = "";
  }
  elseif (!isset($postVars[$fieldName])) 
  {
      $value = "";
  } 
  else
  {
      $value = $postVars[$fieldName];
	  list( $year1, $month1, $day1 ) = split( '[/.-]', $value);
	  echo $day_box=day_box('list_day1','','','50',$day1);
  	  echo " / ";
	  echo $month_box=month_box('list_month1','','','120',$month1);
	  echo " / ";
	  echo $year_box=year_box('list_year1','','','60',$year1);
  }

  if (!isset($pageErrors)) 
  {
    $error = "";
  } 
  elseif (!isset($pageErrors[$fieldName])) 
  {
      $error = "";
  } 
  else 
  {
      $error = $pageErrors[$fieldName];
  }
 
  if ($error != "") 
  {
    echo "<br><font class=\"error\">";
    echo $error."</font>";
  }
  /*if ($pageErrors != "") 
  {
	$error="Fecha Incorrecta";
    echo "<br><font class=\"error\">";
    echo $error."</font>";
  }*/
}


function printSelectDate2($fieldName,&$postVars,&$pageErrors)
{
  if(!isset($postVars[$fieldName]))
  {echo $day_box=day_box('list_day2','','','50',date("d"));
  echo " / ";
  echo $month_box=month_box('list_month2','','','120',date("m"));
  echo " / ";
  echo $year_box=year_box('list_year2','','','60',date("Y"));}
 
  if (!isset($postVars))
  {
    $value = "";
  }
  elseif (!isset($postVars[$fieldName])) 
  {
      $value = "";
  } 
  else
  {
      $value = $postVars[$fieldName];
	  list( $year2, $month2, $day2 ) = split( '[/.-]', $value);
	  echo $day_box=day_box('list_day2','','','50',$day2);
  	  echo " / ";
	  echo $month_box=month_box('list_month2','','','120',$month2);
	  echo " / ";
	  echo $year_box=year_box('list_year2','','','60',$year2);
  }

  if (!isset($pageErrors)) 
  {
    $error = "";
  } 
  elseif (!isset($pageErrors[$fieldName])) 
  {
      $error = "";
  } 
  else 
  {
      $error = $pageErrors[$fieldName];
  }
 
  if ($error != "") 
  {
    echo "<br><font class=\"error\">";
    echo $error."</font>";
  }
  /*if ($pageErrors != "") 
  {
	$error="Fecha Incorrecta";
    echo "<br><font class=\"error\">";
    echo $error."</font>";
  }*/
}
// FIN JUDITH 15/11/05

function printSelectAnios($select_name)
{
 echo $year_box=year_box($select_name,'','','60',date("Y"));	
}

function printSelectCuatrimestres($select_name)
{
 echo "<select name='$select_name'>
       <option value='1'>Enero - Abril</option>
	   <option value='2'>Mayo - Agosto</option>
	   <option value='3'>Septiembre - Diciembre</option>
       </select>";
}

function printSelectMeses($select_name)
{
 echo "<select name='$select_name'>
       <option value='1'>Enero</option>
	   <option value='2'>Febrero</option>
	   <option value='3'>Marzo</option>
	   <option value='4'>Abril</option>
	   <option value='5'>Mayo</option>
	   <option value='6'>Junio</option>
	   <option value='7'>Julio</option>
	   <option value='8'>Agosto</option>
	   <option value='9'>Septiembre</option>
	   <option value='10'>Octubre</option>
	   <option value='11'>Noviembre</option>
	   <option value='12'>Diciembre</option>
       </select>";
}

function printAlfabeto($select_name,$letra="")
{
echo "<select name='$select_name'>";
for ($i="a" ; $i!="aa" ; $i++) {
    $selected = "";
	if($letra == $i)
	   $selected = "selected";
    echo "<option value='$i' $selected>$i</option>";
	if($i=="c")
	   echo "<option value='ch'>ch</option>";
	elseif($i=="n")
	   echo "<option value='ñ'>ñ</option>";	
	   	
} 
echo "</select>";
}

//AGREGADO 14/02/06 PARA NOMBRES

 function getName($userId){
  
  	include ("../conexiondb.php");  
	$sql = "SELECT staff.last_name "
		 . "FROM staff "
		 . "WHERE staff.userid = $userId"; 
			
	$resultado_set = mysql_query($sql,$conexion);
	$resultado_array = mysql_fetch_array($resultado_set);
	echo $resultado_array[0];
}

function getLocaliz($codLoc,$escribir=true){
  
  	include ("../conexiondb.php");  
	$sql = "SELECT biblio_cod_library.description "
		 . "FROM biblio_cod_library "
		 . "WHERE biblio_cod_library.code = $codLoc"; 
		 		
	$resultado_set = mysql_query($sql,$conexion);
	$resultado_array = mysql_fetch_array($resultado_set);
	if($escribir)
	   echo $resultado_array[0];
	else
	  return $resultado_array[0];
}

	function printInputFile($name,&$pageErrors)
{
echo "<input type=\"file\" name=\"$name\">";

if (!isset($pageErrors)) 
  {
    $error = "";
  } 
elseif (!isset($pageErrors[$fieldName])) 
  {
      $error = "";
  } 
else 
  {
      $error = $pageErrors[$fieldName];
  }
 
if ($error != "") 
  {
    echo "<br><font class=\"error\">";
    echo $error."</font>";
  }
}

?>
