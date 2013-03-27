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

  $tab = "admin";
  $nav = "mails";

  require_once("../functions/errorFuncs.php");
  require_once("../shared/common.php");
  require_once("../classes/Localize.php");
  require_once("../functions/inputFuncs.php");
  require_once("../funciones.php");
  include_once("../classes/Settings.php");
  include_once("../classes/SettingsQuery.php");  
  $loc = new Localize(OBIB_LOCALE,$tab);
  
  require_once("../shared/logincheck.php");

  require_once("../shared/header.php");

  $asunto = $_POST["asunto"];
  $classification = $_POST["classification"];
  $filtro = $_POST["filtro"];
//  $mensaje = $_POST["mensaje"];


  //EL INCLUDE TRAE EL CUERPO DEL MENSAJE --> $mensaje
  if($filtro == "vencidos")
      include_once("vencidos.php");
  elseif($filtro == "avencer")
      include_once("por_vencer.php");

//  $mensaje.="<br>Mensaje automático generado por Sistema Open-Biblio UNPA el ".date("d-m-Y")." \n";


	  
  
  $db=new Query();
  $db->connect();
  
  $sql="SELECT email,first_name,last_name ";
  if($filtro != "ninguno")
    {
    $sql.=",b.due_back_dt, b.barcode_nmbr, ";
    $sql.="to_days(sysdate()) - to_days(b.due_back_dt) as days_retrased ";
	}
  $sql.="FROM member m ";
  if($filtro != "ninguno")
     $sql.="LEFT JOIN biblio_copy b on m.mbrid = b.mbrid ";
  $sql.="WHERE 1 = 1 ";
  $sql.="AND (m.email is not null and m.email <> '') ";
  if($filtro != "ninguno")
     {
      $sql.= " and to_days(sysdate()) - to_days(b.due_back_dt) >= -4 ";
      $sql.=" AND b.status_cd = 'out' ";
	 }
  if(!empty($classification))
     $sql.= "AND m.classification = ".$classification;     
  $result = $db->_query($sql,"");
  ?>
  
  <table class="primary">
  <tr>
    <th nowrap="yes" align="left" colspan="2">
      Mailing
    </th>
  </tr>  
  
  <?
  while($row = mysql_fetch_array($result))
    {  
	  
	  $first_name = $row["first_name"];
	  $last_name = $row["last_name"];
	  $email = $row["email"];
	  if($filtro != "ninguno")
	    {
	     $fecha_acordada_devolucion = $row["due_back_dt"];
	     $total_days = $row["days_retrased"];
	     $barcode_nmbr = $row["barcode_nmbr"];
		}
	  
	  if($filtro == "vencidos")
	    {
	     $timestamp_current = strtotime($fecha_acordada_devolucion);
	     $realValue = 0;
	     for($i=1;$i<=$total_days;$i++)//SACO LOS FINES DE SEMANA
	        {
		    $timestamp_parcial = $timestamp_current + (60*60*24*$i); 
		    $parcial = date('Y-m-d', $timestamp_parcial);
		    if(!isFinde($parcial))
		      $realValue++;  
		    }	
		if($realValue > 0)//DEFINITIVAMENTE VENCIDO
	       {
		    $personalizado = '<br><p><font size="2" face="Arial">PD: Ud. se encuentra atrasado por el siguiente libro: '.$barcode_nmbr.'.</font></p>';
			enviarMail($asunto,$mensaje.$personalizado,$email,$first_name,$last_name);
		   }
		}
	  if($filtro == "avencer")
	     {
	     $timestamp_current = strtotime(date('Y-m-d'));
	     $realValue = 0;
	     for($i = $total_days; $i < 0 ;$i++)//SACO LOS FINES DE SEMANA
	        {
		    $timestamp_parcial = $timestamp_current + (60*60*24*($i*-1)); 
		    $parcial = date('Y-m-d', $timestamp_parcial);
		    if(!isFinde($parcial))
		      $realValue++;  
		    }	
		if($realValue == 2)// A PUNTO DE VENCER
	       {
		    $personalizado = '<br><p><font size="2" face="Arial">PD: Ud. debe devolver este libro en 2 dias: '.$barcode_nmbr.'.</font></p>';
            enviarMail($asunto,$mensaje.$personalizado,$email,$first_name,$last_name);
		   }		   
		 }
	 if($filtro == "ninguno")
        enviarMail($asunto,$mensaje,$email,$first_name,$last_name);
    } 	
?>
  <tr>  
    <td nowrap="true" class="primary" colspan="2" align="center"> <input type="button" value="Volver" class="button" onClick="history.back()"></td>
  </tr>
</table>
<br>
<table class="primary"><tr><td valign="top" class="noborder"><font class="small"><? echo $loc->getText("adminTheme_Note"); ?></font></td>
<td class="noborder"><font class="small"><? echo $loc->getText("adminMails_Notetext"); ?></font>
</td></tr></table>
<?php include("../shared/footer.php"); ?>
