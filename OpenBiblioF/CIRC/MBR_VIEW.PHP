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

  $tab = "circulation";
  $nav = "view";
  $focus_form_name = "barcodesearch";
  $focus_form_field = "barcodeNmbr";

  require_once("../shared/common.php");
  require_once("../functions/inputFuncs.php");
  require_once("../functions/formatFuncs.php");
  require_once("../shared/logincheck.php");
  require_once("../classes/Member.php");
  require_once("../classes/MemberQuery.php");
  require_once("../classes/BiblioSearch.php");
  require_once("../classes/BiblioSearchQuery.php");
  require_once("../classes/BiblioHold.php");
  require_once("../classes/BiblioHoldQuery.php");
  require_once("../classes/MemberAccountQuery.php");
  require_once("../classes/BiblioStatusHistQuery.php");
  require_once("../classes/DmQuery.php");
  require_once("../shared/get_form_vars.php");
  require_once("../classes/Localize.php");
  //agregado Horacio Alvarez 01-04-06
  require_once("../classes/StaffQuery.php");
  require_once("../classes/MemberSancionHist.php");
  require_once("../classes/MemberSancionHistQuery.php");  
  $loc = new Localize(OBIB_LOCALE,$tab);
  
  ?>
  
  <script language="JavaScript">
  function chekearRetraso(accion)
  {
//  var atrasado=document.barcodesearch.atrasado.value;
  var atrasado=window.document.getElementById("atrasado").value;
  if(accion=="prestamo")
     {
     if(atrasado!=1)
       popSecondary('elegir_tipo_prestamo.php','400','330');
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
  
  function chekearRetrasoParaPrestarReservado(bibid,copyid,holdid,mbrid)
  {
  var atrasado=window.document.getElementById("atrasado").value;
     if(atrasado!=1)
       window.location.replace("../shared/hold_del.php?bibid="+bibid+"&copyid="+copyid+"&holdid="+holdid+"&mbrid="+mbrid+"&prestar=yes");
	 else
	   alert("Este socio esta retrasado, no puede reservar libros");	 
  }
  </script>
  
  <?

  #****************************************************************************
  #*  Checking for get vars.  Go back to form if none found.
  #****************************************************************************
  if (count($_GET) == 0) {
    header("Location: ../circ/index.php");
    exit();
  }

  #****************************************************************************
  #*  Retrieving get var
  #****************************************************************************
  $mbrid = $_GET["mbrid"];
  if (isset($_GET["msg"])) {
    $msg = "<font class=\"error\">".stripslashes($_GET["msg"])."</font><br><br>";
  } else {
    $msg = "";
  }

  #****************************************************************************
  #*  Loading a few domain tables into associative arrays
  #****************************************************************************
  $dmQ = new DmQuery();
  $dmQ->connect();
  if ($dmQ->errorOccurred()) {
    $dmQ->close();
    displayErrorPage($dmQ);
  }
  /***********************************/
  /*Actualiza las reservas vencidas  */
  /***********************************/
  $dmQ->actualizarReservasVencidas();
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

  #****************************************************************************
  #*  Check for outstanding balance due
  #****************************************************************************
  $acctQ = new MemberAccountQuery();
  $acctQ->connect();
  if ($acctQ->errorOccurred()) {
    $acctQ->close();
    displayErrorPage($acctQ);
  }
  $balance = $acctQ->getBalance($mbrid);
  if ($acctQ->errorOccurred()) {
    $acctQ->close();
    displayErrorPage($acctQ);
  }
  $acctQ->close();
  $balMsg = "";
  if ($balance != 0) {
    $balText = moneyFormat($balance,2);
    $balMsg = "<font class=\"error\">".$loc->getText("mbrViewBalMsg",array("bal"=>$balText))."</font><br><br>";
  }

  #****************************************************************************
  #*  Search database for member
  #****************************************************************************
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
  $mbrQ->actualizar_infracciones($mbr);
  
  if (!$mbrQ->execSelect($mbrid)) {
    $mbrQ->close();
    displayErrorPage($mbrQ);
  }
  $mbr = $mbrQ->fetchMember();
  
  $mbrQ->actualizar_contadores($mbr);
  
  if (!$mbrQ->execSelect($mbrid)) {
    $mbrQ->close();
    displayErrorPage($mbrQ);
  }
  $mbr = $mbrQ->fetchMember();  
  

  #**************************************************************************
  #*  Show member information
  #**************************************************************************
  require_once("../shared/header.php");
?>

<?php echo $balMsg ?>
<?php echo $msg ?> 
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
      <?php print $loc->getText("mbrViewAddr"); ?>
    </td>
    <td valign="top" class="primary">
      <?php
        if ($mbr->getAddress1() != "") echo $mbr->getAddress1()."<br>\n";
        if ($mbr->getAddress2() != "") echo $mbr->getAddress2()."<br>\n";
        if ($mbr->getCity() != "") {
          echo $mbr->getCity().", ".$mbr->getState()." ".$mbr->getZip();
          if ($mbr->getZipExt() != 0) {
            echo "-".$mbr->getZipExt()."<br>\n";
          } else {
            echo "<br>\n";
          }
        }
      ?>
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
      <?php print $loc->getText("mbrViewLibraryid"); ?>
    </td>
    <td valign="top" class="primary">
      <?php echo $biblio_cod_library[$mbr->getLibraryid()];?>
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
      <?php print $loc->getText("mbrViewClassify"); ?>
    </td>
    <td valign="top" class="primary">
      <?php echo $mbrClassifyDm[$mbr->getClassification()];?>
    </td>
    <td class="primary" valign="top">
      <?php print $loc->getText("mbrFldsSanciones"); ?>
    </td>
    <td valign="top" class="primary">
      <?php printDomainDescription("tipo_sancion_dm",$mbr->getTipo_sancion_cd());
	        if($mbr->getTipo_sancion_cd()>0) echo " al ".$mbr->getInicio_sancionDDmmYYYY();?>
    </td>	
  </tr>
  <tr>
    <td class="primary" valign="top">
      <?php print $loc->getText("mbrViewPhone"); ?>
    </td>
    <td valign="top" class="primary">
      <?php
        if ($mbr->getHomePhone() != "") {
          echo $loc->getText("mbrViewPhoneHome").$mbr->getHomePhone()." ";
        }
        if ($mbr->getWorkPhone() != "") {
          echo $loc->getText("mbrViewPhoneWork").$mbr->getWorkPhone();
        }
      ?>
    </td>
    <td class="primary" valign="top">
      <?php print $loc->getText("mbrFldsObservaciones"); ?>
    </td>
    <td valign="top" class="primary">
      <b> <font color='red'><?php echo $mbr->getObservaciones();?></font><b>
    </td>	
  </tr>
  <tr>
    <td class="primary" valign="top">
      <?php print $loc->getText("mbrViewEmail"); ?>
    </td>
    <td valign="top" class="primary">
      <?php echo $mbr->getEmail();?>
    </td>
  </tr>
</table>

  </td>
  <!--Name: HORACIO ALVAREZ
      Date: 2006-03-15
	  Description: Se comenta esta porcion de codigo.
	               El codigo escribe una tabla que informa que cantidad de libros, 
				   de cada tipo de material que el socio tiene en su poder.
  <td class="noborder" valign="top">

<?php
  #****************************************************************************
  #*  Show checkout stats
  #****************************************************************************
/*  $dmQ = new DmQuery();
  $dmQ->connect();
  if ($dmQ->errorOccurred()) {
    $dmQ->close();
    displayErrorPage($dmQ);
  }
  $dmQ->execCheckoutStats($mbr->getMbrid());
  if ($dmQ->errorOccurred()) {
    $dmQ->close();
    displayErrorPage($dmQ);
  }*/
?>
<?php // print $loc->getText("mbrViewHead2"); ?>
<table class="primary">
  <tr>
    <th align="left">
      <?php // print $loc->getText("mbrViewStatColHdr1"); ?>
    </th>
    <th align="left">
      <?php // print $loc->getText("mbrViewStatColHdr2"); ?>
    </th>
    <th align="left" nowrap="yes">
      <?php // print $loc->getText("mbrViewStatColHdr3"); ?>
    </th>
  </tr>
<?php
//  while ($dm = $dmQ->fetchRow()) {
?>
  <tr>
    <td nowrap="true" class="primary" valign="top">
      <?php // echo $dm->getDescription(); ?>
    </td>
    <td valign="top" class="primary">
      <?php // echo $dm->getCount(); ?>
    </td>
    <td valign="top" class="primary">
      <?php /* if ($mbr->getClassification() == "a") {
        echo $dm->getAdultCheckoutLimit();
      } else {
        echo $dm->getJuvenileCheckoutLimit();
      } */?>
    </td>
  </tr>
<?php
/*  }
  $dmQ->close();*/
?>
  </table>
</td>  
      FIN COMENTARIOS--></tr></table>

<br>
<!--****************************************************************************
    *  Checkout form
    **************************************************************************** -->
<!--
Autor: Horacio Alvarez
Fecha: 22-06-03
Descripcion: Se agrega esta funcion javascript
para atrapar el submit lanzado por la tecla enter
y anularlo.
-->
<script language="JavaScript">
/*document.onkeydown = function(){ 
      if(window.event && window.event.keyCode == 13){
       window.event.keyCode = 505; 
      }
      if(window.event && window.event.keyCode == 505){ 
       return false;    
      } 
   } */
function prestar_event(e)
{
      if(e.keyCode == 13){
	   window.event.keyCode = 505; 
       chekearRetraso('prestamo');
	   return false
      }
}
</script>	
<form name="barcodesearch" method="POST" action="../circ/checkout.php" onKeyPress="return prestar_event(event)" >
<table class="primary">
  <tr>
    <th valign="top" nowrap="yes" align="left">
      <?php print $loc->getText("mbrViewHead3"); ?>
    </th>
  </tr>
<?
$limiteSuperado="";
$disabledBoton="";
$disabledField="";
if(!$mbr->getPuedePrestar())
   $disabledBoton="disabled";
?>
  <tr>
    <td nowrap="true" class="primary">
    <?
	$error="";
	if(!$mbr->getPuedePrestar()) $error=$loc->getText("mbrViewErrorLimiteSuperado");
	if($mbr->getEstaSancionado()) $error=$loc->getText("mbrViewErrorSancionado").$mbr->getFecha_suspensionDDmmYYYY();
	
	if($error=="")
	  {  
	  print $loc->getText("mbrViewBarcode");
      printInputText("barcodeNmbr",18,18,$postVars,$pageErrors); 
	  
	  ?>
      <input type="hidden" name="mbrid" value="<?php echo $mbrid;?>">
      <input type="hidden" name="classification" value="<?php echo $mbr->getClassification();?>">
      <!--  <input type="submit" value="<?php // print $loc->getText("mbrViewCheckOut"); ?>" class="button">-->
	  
	  <!-- Horacio Alvarez -->
	  <!-- Fecha: 2006-03-10 -->
	  <!-- el campo a continuacion se setea desde el pop-up donde se selecciona el tipo de prestamo -->
	  <input type="hidden" name="dias_para_devolucion"> 
	  <input <? echo $disabledBoton;?> type="button" onClick="chekearRetraso('prestamo');" value="<?php print $loc->getText("mbrViewCheckOut"); ?>" class="button">
	<?
	 }
	else
	  {
	   ?>
	   <font class="error"><?=$error?></font>
   <? }
   ?>
     <input type="hidden" name="limiteSuperado" value="<?=$limiteSuperado?>">
	 <br><input type="checkbox" name="inter">Inter - Bibliotecario
    </td>
  </tr>
</table>
</form>
<!--
Autor: Horacio Alvarez
fecha: 20-04-06
Descripcion: Agrego un nuevo form, y cambio el javascript que llama al pop-up de saldo de prestamos
-->
<form name="imprimirSaldoPrestamos" action="noAction">
<h1><?php print $loc->getText("mbrViewHead4"); ?>
  <font class="primary"> <a href="javascript:popSecondaryForSaldosPrestamos('../circ/mbr_print_checkouts.php?mbrid=<?php echo $mbrid;?>')"><?php print $loc->getText("mbrPrintCheckouts"); ?></a></font>
</h1>
<table class="primary">
  <tr>
    <!--
	Cabecera agregada: "Seleccionar"
	Fecha: 20-04-06
	-->
    <th valign="top" nowrap="yes" align="left">
      <?php print $loc->getText("mbrViewOutHdr9"); ?>
    </th>  
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
  $daysLate=0;
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
	   <? echo printCheckBox("seleccionar",$biblio->getBarcodeNmbr());?>
	</td>
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
      <?php echo toDDmmYYYY($biblio->getDueBackDt());
	   $dueBackDt = toDDmmYYYY($biblio->getDueBackDt());
	  ?>
    </td>
    <td class="primary" valign="top" >
      <?php echo $biblio->getDaysLate();
	  //VALIDACION DE POSIBLE NUEVA INFRACCION
	  if($biblio->getDaysLate() > $daysLate)
	    {
	     $daysLate = $biblio->getDaysLate();
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
	  if(isset($daysLate))
	    {
	    $histQ = new BiblioStatusHistQuery();
        $histQ->connect();
        if ($histQ->errorOccurred()) {
          $histQ->close();
          displayErrorPage($histQ);
        }
        if (!$histQ->queryByMbridAndSanciono($mbr->getMbrid())) {
         $histQ->close();
         displayErrorPage($histQ);
        }
	    $mismoDia = false;
	    if ($hist = $histQ->fetchRow()) {
//		        echo "hist->getStatusBeginDt(): ".substr($hist->getStatusBeginDt(),0,10)."<br>";
//				echo "hoy: ".date("Y-m-d")."<br>";	  
//           $log.="h_begin_dt=".substr($hist->getStatusBeginDt(),0,10)."|";
	       if(substr($hist->getStatusBeginDt(),0,10) == date("Y-m-d"))
		   {
		       $mismoDia = true;
//			   $log.="mismoDia=true|";
		   }
	    }		
	    //if($mbr->getTipo_sancion_cd()==1 && $daysLate<3)
		if($mbr->getTipo_sancion_cd()==1 && $daysLate<3)
		  {
		   if($mbr->getSancion_activa()=='s')
	           $atrasado = false;
		   else
		       if($mismoDia)
			      $atrasado = false;
		  }
		}
	  if($atrasado)
	    {		
	     //sancionar solo si ya posee de 2º infraccion en adelante,no esta cumpliendo otra sancion, y no posee la mas alta infraccion 5
		 if($mbr->getTipo_sancion_cd()<5)
		    {
			
			
		     if($mbr->getTipo_sancion_cd()>=0 && !$mbr->getEstaSancionado() && $mbr->getSancion_activa()!='s')
	           {			    
			    if($mbr->getTipo_sancion_cd()==0)
				   {
		           $timestamp_current = strtotime($inicio_sancion);
                   $timestamp_future  = $timestamp_current + (60*60*24*1);//SUMA UN DIA
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
</form>
<br>
<!--****************************************************************************
    *  Hold form
    **************************************************************************** -->
<form name="holdForm" method="POST" action="../circ/place_hold.php">
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

<h1><?php print $loc->getText("mbrViewHead6"); ?></h1>
<table class="primary">
  <tr>
    <th colspan="2" valign="top" nowrap="yes" align="left">
      <?php print $loc->getText("mbrViewHoldHdr1"); ?>
    </th>
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
	<?
	if(substr($hold->getHoldBeginDt(),0,10)==date("Y-m-d") && !$mbr->getEstaSancionado() && $mbr->getPuedePrestar())
	  {//puede prestar el libro, ya que llegó la fecha de reserva
	   ?>
	   <a href="#" onClick="chekearRetrasoParaPrestarReservado('<?=$hold->getBibid()?>','<?=$hold->getCopyid()?>','<?=$hold->getHoldid()?>','<?=$mbrid?>')"><?php print $loc->getText("mbrViewPrestar"); ?></a>
<!---       <a href="../shared/hold_del.php?bibid=<?php echo $hold->getBibid();?>&copyid=<?php echo $hold->getCopyid();?>&holdid=<?php echo $hold->getHoldid();?>&mbrid=<?php echo $mbrid;?>&prestar=yes"><?php print $loc->getText("mbrViewPrestar"); ?></a>-->
       <?
	  }
	else echo "------";//no puede prestar el libro, ya que todavia no llega la fecha de reserva
	?>	  
    </td>  
    <td class="primary" valign="top" nowrap="yes">
      <a href="../shared/hold_del_confirm.php?bibid=<?php echo $hold->getBibid();?>&copyid=<?php echo $hold->getCopyid();?>&holdid=<?php echo $hold->getHoldid();?>&mbrid=<?php echo $mbrid;?>"><?php print $loc->getText("mbrViewDel"); ?></a>
    </td>
    <td class="primary" valign="top" nowrap="yes">
      <?php echo toDDmmYYYY(substr($hold->getHoldBeginDt(),0,10));?>
    </td>
    <td class="primary" valign="top">
    <img src="../fotos/foto_tipo_material.php?code=<? echo $hold->getMaterialCd();?>" width="20" height="20">
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


<?php require_once("../shared/footer.php"); ?>
