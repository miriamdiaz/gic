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

  $tab = "home";
  $nav = "info_usuarios";

  require_once("../shared/common.php");
  require_once("../shared/header.php");
  require_once("../classes/Localize.php");
  require_once("../classes/MemberQuery.php");
  require_once("../classes/DmQuery.php");
  require_once("../functions/inputFuncs.php");
  require_once("../functions/formatFuncs.php");  
  require_once("../classes/BiblioSearchQuery.php");
  require_once("../classes/BiblioHoldQuery.php");
  require_once("../classes/BiblioSearch.php");
  require_once("../classes/BiblioStatusHistQuery.php");
  require_once("../funciones.php");
  $loc = new Localize(OBIB_LOCALE,"circulation");
  
    if(isset($_SESSION["postVars"])) $postVars = $_SESSION["postVars"] ;
    if(isset($_SESSION["pageErrors"])) $pageErrors = $_SESSION["pageErrors"];  
  
?>

  <script language="JavaScript">
  function chekearRetraso(accion)
  {
//  var atrasado=document.barcodesearch.atrasado.value;
  var atrasado=window.document.getElementById("atrasado").value;
  if(accion=="prestamo")
     {
     if(atrasado!=1)
       popSecondary('elegir_tipo_prestamo.php','400','250');
	 else
	   alert("Este socio esta retrasado, no puede extraer libros");
	 }
  if(accion=="reserva")
    {
     if(atrasado!=1)
       window.document.holdForm.submit();
	 else
	   alert("Este socio esta retrasado, no puede reservar libros");	 
	}
  }
  </script>

<!-- \/ MODIFICACIÓN JUDITH \/ width="90" height="130" -->
<h1><?php echo $loc->getText("indexHeadingMemberOnline");?></h1>
<br>
<?php echo $loc->getText("member_WelcomeMsg");?>
<?

include ("../conexiondb.php");
$sql="SELECT id,titulo,descripcion,fecha_alta,fecha_vencimiento FROM novedades WHERE (fecha_vencimiento > CURRENT_DATE) or (fecha_vencimiento is NULL) ORDER BY fecha_alta DESC" ;
$resultado_set = mysql_query($sql,$conexion);
$filas = mysql_num_rows($resultado_set);
$muestraFormulario = true;
$msg = "";
if(isset($_GET["dni"]))
  $_POST["dni"]=$_GET["dni"];
if(isset($_POST["dni"]))
{
$muestraFormulario=false;
$dni = $_POST["dni"];
$sql = "SELECT * FROM MEMBER WHERE barcode_nmbr like '$dni'";
$result = mysql_query($sql);
if($row = mysql_fetch_array($result))
  {
   $mbrid = $row["mbrid"];
   $mbrQ = new MemberQuery();
   $mbrQ->connect();
   if ($mbrQ->errorOccurred()) {
     $mbrQ->close();
     displayErrorPage($mbrQ);
   }
   if (!$mbrQ->execSelect($mbrid)) {
     $mbrQ->close();
     displayErrorPage($mbrQ);
   }
   $mbr = $mbrQ->fetchMember();   
   
  $dmQ = new DmQuery();
  $dmQ->connect();
  if ($dmQ->errorOccurred()) {
    $dmQ->close();
    displayErrorPage($dmQ);
  }
  /***********************************/
  /*Fin Actualiza las reservas vencidas  */
  /***********************************/
  $dmQ->execSelect("mbr_classify_dm");
  $mbrClassifyDm = $dmQ->fetchRows();
  $dmQ->execSelect("biblio_status_dm");
  //DOS LINEAS AGREGADAS: Horacio Alvarez FECHA: 25-03-06
  $biblioStatusDm = $dmQ->fetchRows();
  $dmQ->execSelect("biblio_cod_library");
  $biblio_cod_library = $dmQ->fetchRows();    
  $dmQ->execSelect("material_type_dm");
  $materialTypeDm = $dmQ->fetchRows();
  // reseting row to top of same result set to get image_file.  This avoids having to do another select.
  $dmQ->resetResult();
  $materialImageFiles = $dmQ->fetchRows("image_file");
  $dmQ->close();   
?>
<div align="center">
<table class="primary">
  <tr><td class="noborder" valign="top">
  <br>
<table class="primary">
  <tr>
    <th align="left" colspan="4" nowrap="yes">
      <?php print $loc->getText("mbrViewHead1"); ?>
    </th>
  </tr>
  <tr>
    <td class="primary" valign="top">
      <b><?php print $loc->getText("mbrViewCardNmbr"); ?></b>
    </td>
    <td valign="top" class="primary">
      <b><?php echo $mbr->getBarcodeNmbr();?></b>
    </td>
    
    <td class="primary" valign="top">
      <?php print $loc->getText("mbrViewLimitePrestamos"); ?>
    </td>
    <td valign="top" class="primary">
      <?php echo $mbr->getLimitePrestamos();?>
    </td>	
  </tr>
  <tr>
    <td nowrap="true" class="primary" valign="top">
      <b><?php print $loc->getText("mbrViewName"); ?></b>
    </td>
    <td valign="top" class="primary">
      <b><?php echo $mbr->getLastName();?>, <?php echo $mbr->getFirstName();?></b>
    </td>
    
    <td class="primary" valign="top">
      <?php print $loc->getText("mbrViewCantidadPrestamos"); ?>
    </td>
    <td valign="top" class="primary">
      <?php echo $mbr->getCantidadPrestamos();?>
    </td>	
  </tr>
  <tr>
    <td class="primary" valign="top">
      <?php print $loc->getText("mbrViewLibraryid"); ?>
    </td>
    <td valign="top" class="primary">
      <?php echo $biblio_cod_library[$mbr->getLibraryid()];?>
    </td>    

    <td class="primary" valign="top">
      <?php print $loc->getText("mbrViewLimiteReservas"); ?>
    </td>
    <td valign="top" class="primary">
      <?php echo $mbr->getLimiteReservas();?>
    </td>	
  </tr>
  <!--
  Fila agregada: Horacio Alvarez
  Fecha: 25-03-06
  Descripcion: Muestra el nombre de la biblioteca asignada
  -->
  <tr>
    <td class="primary" valign="top">
      <?php print $loc->getText("mbrViewClassify"); ?>
    </td>
    <td valign="top" class="primary">
      <?php echo $mbrClassifyDm[$mbr->getClassification()];?>
    </td>
    <td class="primary" valign="top">
      <?php print $loc->getText("mbrViewCantidadReservas"); ?>
    </td>
    <td valign="top" class="primary">
      <?php echo $mbr->getCantidadReservas();?>
    </td>	
  </tr>
  <tr>

    <td class="primary" valign="top">
      <?php print $loc->getText("mbrFldsSanciones"); ?>
    </td>
    <td valign="top" class="primary">
      <?php printDomainDescription("tipo_sancion_dm",$mbr->getTipo_sancion_cd());
	        if($mbr->getTipo_sancion_cd()>0) echo " al ".$mbr->getInicio_sancionDDmmYYYY();?>
    </td>	
  </tr>
</table>
</td></tr></table>
<br>
<table class="primary">
  <tr>
    <!--
	Cabecera agregada: "Seleccionar"
	Fecha: 20-04-06
	-->  
    <th valign="top" nowrap="yes" align="left">
      <?php print $loc->getText("mbrViewOutHdr1"); ?>
    </th>
    <th valign="top" nowrap="yes" align="left">
      <?php print $loc->getText("mbrViewOutHdr2"); ?>
    </th>
    <th valign="top" nowrap="yes" align="left">
      <?php print $loc->getText("mbrViewOutHdr3"); ?>
    </th>
    <th valign="top" nowrap="yes" align="left">
      <?php print $loc->getText("mbrViewOutHdr4"); ?>
    </th>
    <th valign="top" nowrap="yes" align="left">
      <?php print $loc->getText("mbrViewOutHdr5"); ?>
    </th>
    <th valign="top" nowrap="yes" align="left">
      <?php print $loc->getText("mbrViewOutHdr6"); ?>
    </th>
    <th valign="top" align="left">
      <?php print $loc->getText("mbrViewOutHdr7"); ?>
    </th>
	<!--
	Cabecera agregada: Horacio Alvarez 
	Fecha: 01-04-06
	-->
    <th valign="top" align="left">
      <?php print $loc->getText("mbrViewOutHdr8"); ?>
    </th>
    <th valign="top" align="left">
      <?php print $loc->getText("mbrViewOutHdr11"); ?>
    </th>		
  </tr>
<?php
  #****************************************************************************
  #*  Search database for BiblioStatus data
  #****************************************************************************
  $biblioQ = new BiblioSearchQuery();
  $biblioQ->connect();
  if ($biblioQ->errorOccurred()) {
    $biblioQ->close();
    displayErrorPage($biblioQ);
  }
  if (!$biblioQ->query(OBIB_STATUS_OUT,$mbrid)) {
    $biblioQ->close();
    displayErrorPage($biblioQ);
  }
  $atrasado=false;
  if ($biblioQ->getRowCount() == 0) {
?>
  <tr>
    <td class="primary" align="center" colspan="10">
      <?php print $loc->getText("mbrViewNoCheckouts"); ?>
    </td>
  </tr>
<?php
  } else {
    echo "<div style='visibility:hidden'><input type='checkbox' name='seleccionar' value='ninguno'></div>";
    while ($biblio = $biblioQ->fetchRow()) {
?>
  <tr>
    <td class="primary" valign="top" nowrap="yes">
	<!-- AUTOR: Horacio Alvarez
	     DESCRIPCION: Saco la hora de la fecha
		 -->
      <?php echo toDDmmYYYY(substr($biblio->getStatusBeginDt(),0,10));?>
    </td>
    <td class="primary" valign="top">
      <img src="../fotos/foto_tipo_material.php?code=<? echo $biblio->getMaterialCd();?>" width="20" height="20">
      <?php echo $materialTypeDm[$biblio->getMaterialCd()];?>
    </td>
    <td class="primary" valign="top" >
      <?php echo $biblio->getBarcodeNmbr();?>
    </td>
    <td class="primary" valign="top" >
      <a href="../shared/biblio_view.php?bibid=<?php echo $biblio->getBibid();?>&tab=<?php echo $tab;?>"><?php echo $biblio->getTitle();?></a>
    </td>
    <td class="primary" valign="top" >
      <?php echo $biblio->getAuthor();?>
    </td>
    <td class="primary" valign="top" nowrap="yes">
      <?php echo toDDmmYYYY($biblio->getDueBackDt());?>
    </td>
    <td class="primary" valign="top" >
      <?php echo $biblio->getDaysLate();
	  //VALIDACION DE POSIBLE NUEVA INFRACCION
	  if($biblio->getDaysLate()>0)
	    {
	     $atrasado=true;
		 $inicio_sancion=$biblio->getDueBackDt();
		 $copy_barcode=$biblio->getBarcodeNmbr();
		}
	  ?>
    </td>
	<?
	/**
	Autor: Horacio Alvarez
	Fecha: 01-04-06
	Descripcion: Agregado para obtener los datos del usuario que realizo el prestamo
	*/
    $staffQ = new StaffQuery();
    $staffQ->connect();
    if ($staffQ->errorOccurred()) {
      $staffQ->close();
      displayErrorPage($staffQ);
    }
    $staffQ->execSelect($biblio->getUserId());
    if ($staffQ->errorOccurred()) {
      $staffQ->close();
      displayErrorPage($staffQ); 	

	  }
    $staff = $staffQ->fetchStaff(); 	
	?>	
    <td class="primary" valign="top" >
      <?php echo $staff->getLastName();?>
    </td>	
	<?
	$holdQ=new BiblioHoldQuery();
	$holdQ->connect();
	$hold=$holdQ->getFirstHold($biblio->getBibid(),$biblio->getCopyid());
	
	?>	
    <td class="primary" valign="top" >
      <? 
	  if ($hold!=FALSE)
	     {
         $mbrQR = new MemberQuery();
         $mbrQR->connect();
         if ($mbrQR->errorOccurred()) {
            $mbrQR->close();
            displayErrorPage($mbrQR);
            }
         if (!$mbrQR->execSelect($hold->getMbrid())) {
            $mbrQR->close();
            displayErrorPage($mbrQR);
            }
         $mbrR = $mbrQR->fetchMember();
	     echo $mbrR->getFirstName()." ".$mbrR->getLastName()." - DNI: ".$mbrR->getBarcodeNmbr();
		 }
	  else echo "-----";
	  ?>
    </td>	
  </tr>
<?php
    }
  }
  $biblioQ->close();
  
  echo "<input type='hidden' name='atrasado' value='$atrasado'>";
  
  	  //VALIDACION DE POSIBLE NUEVA INFRACCION
	  if($atrasado)
	    {
	     //sancionar solo si ya posee de 2º infraccion en adelante,no esta cumpliendo otra sancion, y no posee la mas alta infraccion 5
		 if($mbr->getTipo_sancion_cd()<5 && $mbr->getTipo_sancion_cd()!=1)
		    {
		     if($mbr->getTipo_sancion_cd()>=0 && !$mbr->getEstaSancionado() && $mbr->getSancion_activa()!='s')
	           {			    
			    if($mbr->getTipo_sancion_cd()==0)
				   {
		           $timestamp_current = strtotime($inicio_sancion);
                   $timestamp_future  = $timestamp_current + (60*60*24*1);
 				   $mbr->setInicio_sancion(date('Y-m-d', $timestamp_future));
				   }
				else
  				   $mbr->setInicio_sancion(date("Y-m-d"));
			    $mbr->setTipo_sancion_cd($mbr->getTipo_sancion_cd()+1);
			    $mbr->setSancion_activa("s");

				$mbr->setCopy_barcode($copy_barcode);
                if (!$mbrQ->update($mbr)) {
                   $mbrQ->close();
                   displayErrorPage($mbrQ);
                   }  
				else//vuelve a refrescar la ventana para poder actualizar los datos de la sancion (mediante javascript). 
				    {
					  $mbrid=$mbr->getMbrid();
					  $mbrQ->close();
					  echo "<input type='hidden' name='refresca' value='$mbrid'>";
					 }
		    #****************************************************************************
            #*  Insert into database for member_sancion_hist
            #****************************************************************************
            $hist = new MemberSancionHist();
            $hist->setMbrid($mbr->getMbrid());
            $hist->setBarcode_nmbr($copy_barcode);
            $hist->setFecha_aplico_sancion(date("Y-m-d"));
            $hist->setTipo_sancion_cd($mbr->getTipo_sancion_cd());
  
            $mbrHistQ = new MemberSancionHistQuery();
            $mbrHistQ->connect();
            if ($mbrHistQ->errorOccurred()) {
              $mbrHistQ->close();
              displayErrorPage($mbrHistQ);
            }
            $mbrHistQ->insert($hist);
            if ($mbrHistQ->errorOccurred()) {
              $mbrHistQ->close();
              displayErrorPage($mbrHistQ);
            }
            //$mbrHistQ->close();  					 
			    }	 
			 }       			 
		}
?>

</table>
<br>
<form name="holdForm" method="POST" action="../home/place_hold.php">
<table class="primary">
  <tr>
    <th valign="top" nowrap="yes" align="left">
      <?php print $loc->getText("mbrViewHead5"); ?>
    </th>
  </tr>
  <tr>
    <td nowrap="true" class="primary">
  <?
//  if($error=="")
//  {
  if($mbr->getPuedeReservar() && !$mbr->getEstaSancionado())
   {
  ?>	
      <?php print $loc->getText("mbrViewBarcode"); ?>
      <?php printInputText("holdBarcodeNmbr",18,18,$postVars,$pageErrors); ?>
        <a href="javascript:popSecondaryLarge('../opac/index.php?lookup=Y')"><?php print $loc->getText("indexSearch"); ?></a>
      <input type="hidden" name="mbrid" value="<?php echo $mbrid;?>">
      <input type="hidden" name="classification" value="<?php echo $mbr->getClassification();?>">
      <input type="button" onClick="chekearRetraso('reserva')" value="<?php print $loc->getText("mbrViewPlaceHold"); ?>" class="button">
  <?
   }
   else
   {
     if($mbr->getEstaSancionado())
	   echo "<br><font class=\"error\">".$loc->getText("mbrViewErrorSancionado").$mbr->getFecha_suspensionDDmmYYYY()."</font>";
	 else
        echo "<br><font class=\"error\">".$loc->getText('checkoutErr7')."</font>";
   }
/*  }
  else{
	   ?>
	   <font class="error"><?=$error?></font>
   <? }  */
  ?>
    </td>
  </tr>
</table>
</form>
<br>
<table class="primary">
  <tr>
    <th valign="top" nowrap="yes" align="left">
      <?php print $loc->getText("mbrViewHoldHdr2"); ?>
    </th>
    <th valign="top" nowrap="yes" align="left">
      <?php print $loc->getText("mbrViewHoldHdr3"); ?>
    </th>
    <th valign="top" nowrap="yes" align="left">
      <?php print $loc->getText("mbrViewHoldHdr4"); ?>
    </th>
    <th valign="top" nowrap="yes" align="left">
      <?php print $loc->getText("mbrViewHoldHdr5"); ?>
    </th>
    <th valign="top" nowrap="yes" align="left">
      <?php print $loc->getText("mbrViewHoldHdr6"); ?>
    </th>
    <th valign="top" align="left">
      <?php print $loc->getText("mbrViewHoldHdr7"); ?>
    </th>
	<!--
	Autor: Horacio Alvarez
	Fecha: 17-04-06
	Descripcion: modificado para mostrar la cabecera de usuario que realizo la reserva
	-->
    <th valign="top" align="left">
      <?php print $loc->getText("mbrViewHoldHdr9"); ?>
    </th>
  </tr>
<?php
  #****************************************************************************
  #*  Search database for BiblioHold data
  #****************************************************************************
  $holdQ = new BiblioHoldQuery();
  $holdQ->connect();
  if ($holdQ->errorOccurred()) {
    $holdQ->close();
    displayErrorPage($holdQ);
  }
  if (!$holdQ->queryByMbrid($mbrid)) {
    $holdQ->close();
    displayErrorPage($holdQ);
  }
  if ($holdQ->getRowCount() == 0) {
?>
  <tr>
    <td class="primary" align="center" colspan="9">
      <?php print $loc->getText("mbrViewNoHolds"); ?>
    </td>
  </tr>
<?php
  } else {
    while ($hold = $holdQ->fetchRow()) {
?>
  <tr>
  <!--
  Autor: Horacio Alvarez
  Fecha: 17-04-06
  Descripcion: Se agrega la siguiente celda con el link para prestar la reserva.
  -->
    <td class="primary" valign="top" nowrap="yes">
      <?php echo toDDmmYYYY(substr($hold->getHoldBeginDt(),0,10));?>
    </td>
    <td class="primary" valign="top">
      <img src="../images/<?php echo $materialImageFiles[$hold->getMaterialCd()];?>" width="20" height="20" border="0" align="middle" alt="<?php echo $materialTypeDm[$hold->getMaterialCd()];?>">
      <?php echo $materialTypeDm[$hold->getMaterialCd()];?>
    </td>
    <td class="primary" valign="top" >
      <?php echo $hold->getBarcodeNmbr();?>
    </td>
    <td class="primary" valign="top" >
      <a href="../shared/biblio_view.php?bibid=<?php echo $hold->getBibid();?>&tab=<?php echo $tab;?>"><?php echo $hold->getTitle();?></a>
    </td>
    <td class="primary" valign="top" >
      <?php echo $hold->getAuthor();?>
    </td>
    <td class="primary" valign="top" >
      <?php echo $biblioStatusDm[$hold->getStatusCd()];?>
    </td>
	<!--
	Autor: Horacio Alvarez
	Fecha: 17-04-06
	Descripcion: modificado para mostrar el usuario que realizo la reserva
	-->	
	<?
	/**
	Autor: Horacio Alvarez
	Fecha: 01-04-06
	Descripcion: Agregado para obtener los datos del usuario que realizo el prestamo
	*/
    $staffQ = new StaffQuery();
    $staffQ->connect();
    if ($staffQ->errorOccurred()) {
      $staffQ->close();
      displayErrorPage($staffQ);
    }
    $staffQ->execSelect($hold->getUserid());
    if ($staffQ->errorOccurred()) {
      $staffQ->close();
      displayErrorPage($staffQ); 	
	  }
    $staff = $staffQ->fetchStaff(); 	
	?>	
    <td class="primary" valign="top" >
      <?php echo $staff->getLastName();?>
    </td>
  </tr>
<?php
    }
  }
  $holdQ->close();
?>
</table>
<br>
<? 
  include ("../conexiondb.php");  
  $query = "SELECT h.bibid,h.copyid,b.title, b.author,c.barcode_nmbr ";
  $query.= "from biblio_status_hist h ";
  $query.= "LEFT JOIN biblio b ON h.bibid = b.bibid ";
  $query.= "LEFT JOIN biblio_copy c ON c.bibid = b.bibid AND c.copyid = h.copyid ";
  $query.= "where h.mbrid = $mbrid ";
  $query.= "group by h.bibid,h.copyid ";

  $result = mysql_query($query,$conexion);
    
?>
<h1>Historial de Prestamos</h1>
<table class="primary">
  <tr>
    <th valign="top" nowrap="yes" align="left">
      <?php print $loc->getText("mbrHistoryHdr1"); ?>
    </th>
    <th valign="top" nowrap="yes" align="left">
      <?php print $loc->getText("mbrHistoryHdr2"); ?>
    </th>
    <th valign="top" nowrap="yes" align="left">
      <?php print $loc->getText("mbrHistoryHdr3"); ?>
    </th>
    <th valign="top" nowrap="yes" align="left">
      <?php print $loc->getText("mbrHistoryHdr4"); ?>
    </th>
  </tr>

<?php
if(mysql_num_rows($result)==0)  {
?>
  <tr>
    <td class="primary" align="center" colspan="7">
      <?php print $loc->getText("mbrHistoryNoHist"); ?>
    </td>
  </tr>
<?php
  } else {

while ($row = mysql_fetch_array($result)) {

$bibid = $row["bibid"];
$copyid = $row["copyid"];

$query2 = "SELECT h.*, ";
$query2.= "DATE_FORMAT(h.status_begin_dt,'%d-%m-%Y') AS begin_dt, ";
$query2.= "s.last_name AS presto ";
$query2.= "FROM biblio_status_hist h ";
$query2.= "LEFT JOIN staff s ON h.userid = s.userid ";
$query2.= "WHERE h.mbrid = $mbrid AND h.bibid = $bibid AND h.copyid = $copyid ";
$query2.= "ORDER BY h.status_begin_dt Desc";

$result2 = mysql_query($query2,$conexion)

?>
  <tr>
    <td class="primary" valign="top" >
      <?php 
	  echo $row["barcode_nmbr"];
	  ?>
    </td>
    <td class="primary" valign="top" >
      <a href="../shared/biblio_view.php?bibid=<?php echo $row["bibid"];?>&tab=<?php echo $tab?>"><?php echo $row["title"];?></a>
    </td>
    <td class="primary" valign="top" >
      <?php echo $row["author"];?>
    </td>
    <td class="primary" valign="top" >
      <?php 
	  
	  while($row2 = mysql_fetch_array($result2))
	       {
		    $presto = $row2["presto"];
			$due_back_dt = $row2["due_back_dt"];
			$begin_dt = $row2["begin_dt"];
			$status_cd = $row2["status_cd"];
			if($status_cd == "out")
			   $accion = "prestó";
			if($status_cd == "crt")
			   $accion = "devolvió";
			if($status_cd == "hld")
			   $accion = "reservó";
			
			echo $presto." ".$accion." ".$begin_dt." / ";
		   }
	  
	  ?>
    </td>
  </tr>
<?php
    }
  }
//  $histQ->close();

?>
</table>
<?
  #****************************************************************************
  #*  Search database for member sancion history
  #****************************************************************************
  $histQ = new MemberSancionHistQuery();
  $histQ->connect();
  if ($histQ->errorOccurred()) {
    $histQ->close();
    displayErrorPage($histQ);
  }
  if (!$histQ->queryByMbrid($mbrid)) {
    $histQ->close();
    displayErrorPage($histQ);
  }
?>

<h1><?php print $loc->getText("mbrHistorySancionHead1"); ?></h1>
<table class="primary">
  <tr>
    <th valign="top" nowrap="yes" align="left">
      <?php print $loc->getText("mbrHistoryHdr1"); ?>
    </th>
    <th valign="top" nowrap="yes" align="left">
      <?php print $loc->getText("mbrHistoryHdr2"); ?>
    </th>	
    <th valign="top" nowrap="yes" align="left">
      <?php print $loc->getText("mbrHistorySancionHdr2"); ?>
    </th>
    <th valign="top" nowrap="yes" align="left">
      <?php print $loc->getText("mbrHistorySancionHdr3"); ?>
    </th>
  </tr>

<?php
  if ($histQ->getRowCount() == 0) {
?>
  <tr>
    <td class="primary" align="center" colspan="7">
      <?php print $loc->getText("mbrHistoryNoHist"); ?>
    </td>
  </tr>
<?php
  } else {
    while ($hist = $histQ->fetchRow()) {
?>
  <tr>
    <td class="primary" valign="top" >
      <?php echo $hist->getBarcode_nmbr();?>
    </td>
    <td class="primary" valign="top" >
      <?php echo $hist->getTitle();?>
    </td>	
    <td class="primary" valign="top" >
      <?php echo $hist->getFecha_aplico_sancion();?>
    </td>
    <td class="primary" valign="top" >
      <?php printDomainDescription("tipo_sancion_dm",$hist->getTipo_sancion_cd());?>
    </td>
  </tr>
<?php
    }
  }
  $histQ->close();

?>
</table>
</div>      
<?
  }
else
  {
   $muestraFormulario = true;
   $msg = "El DNI no corresponde a un usuario activo.";
  }
}

if($muestraFormulario)
{
?>
<form action="info_usuarios.php" name="info" method="post">
<div align="center">
<table>
<tr>
<td><?php print $loc->getText("mbrViewCardNmbr"); ?></td>
<td><input type="text" name="dni"><? echo $msg;?></td>
</tr>
<tr>
<td colspan="2"><div align="center"><input type="submit" name="Buscar" value="Ingresar" class="button"></div></td>
</tr>
</table>
</div>
</form>
<? 
}
include("../shared/footer.php"); 
?>