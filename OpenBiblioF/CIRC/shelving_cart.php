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
  $nav = "checkin";
  $restrictInDemo = true;
  require_once("../shared/common.php");
  require_once("../shared/logincheck.php");
  //REQUIRE AGREGADO: Horacio Alvarez FECHA: 26-03-06
  require_once("../classes/MemberQuery.php");
  require_once("../classes/BiblioCopy.php");
  require_once("../classes/BiblioCopyQuery.php");
  require_once("../classes/BiblioHold.php");
  require_once("../classes/BiblioHoldQuery.php");
  require_once("../classes/BiblioStatusHist.php");
  require_once("../classes/BiblioStatusHistQuery.php");
  require_once("../classes/MemberAccountTransaction.php");
  require_once("../classes/MemberAccountQuery.php");
  require_once("../functions/errorFuncs.php");
  require_once("../functions/formatFuncs.php");
  require_once("../classes/Localize.php");
  require_once("../classes/DmQuery.php");
  require_once("../classes/Dm.php");  
  require_once("../funciones.php");
  require_once("../classes/MemberSancionHist.php");
  require_once("../classes/MemberSancionHistQuery.php");  
  $loc = new Localize(OBIB_LOCALE,$tab);
  
  $fp = fopen("c:/biblio_files/log".date("Y-m-d").".txt","a");
  $log = "";

  #****************************************************************************
  #*  Checking for post vars.  Go back to form if none found.
  #****************************************************************************

  if (count($_POST) == 0) {
    header("Location: ../circ/checkin_form.php?reset=Y");
    exit();
  }
  
  $barcode = trim($_POST["barcodeNmbr"]);
  $time = date("H:i:s");
  $log = "$time:barcode=$barcode|";

  #****************************************************************************
  #*  Edit input
  #****************************************************************************
  if (!ctypeAlnum($barcode)) {
    $pageErrors["barcodeNmbr"] = $loc->getText("shelvingCartErr1");
    $postVars["barcodeNmbr"] = $barcode;
    $_SESSION["postVars"] = $postVars;
    $_SESSION["pageErrors"] = $pageErrors;
    header("Location: ../circ/checkin_form.php");
    exit();
  }
  
  #****************************************************************************
  #*  Ready copy record
  #****************************************************************************
  $copyQ = new BiblioCopyQuery();
  $copyQ->connect();
  if ($copyQ->errorOccurred()) {
    $copyQ->close();
    displayErrorPage($copyQ);
  }
  if (!$copy = $copyQ->queryByBarcode($barcode)) {
    $copyQ->close();
    displayErrorPage($copyQ);
  }

  #****************************************************************************
  #*  Edit results
  #****************************************************************************
  $foundError = FALSE;
  if ($copyQ->getRowCount() == 0) {
    $foundError = true;
    $pageErrors["barcodeNmbr"] = $loc->getText("shelvingCartErr2");
  }
  
  if($copy->getStatusCd()=="in" || $copy->getStatusCd()=="crt")
    {
    $foundError = true;
    $pageErrors["barcodeNmbr"] = $loc->getText("shelvingCartErr3");	 
	}  
  $log.= "status_cd=".$copy->getStatusCd()."|";

  if ($foundError == true) {
    $postVars["barcodeNmbr"] = $barcode;
    $_SESSION["postVars"] = $postVars;
    $_SESSION["pageErrors"] = $pageErrors;
    header("Location: ../circ/checkin_form.php");
    exit();
  }

  #****************************************************************************
  #*  Get daily late fee
  #****************************************************************************
  $dailyLateFee = $copyQ->getDailyLateFee($copy);
  if ($copyQ->errorOccurred()) {
    $copyQ->close();
    displayErrorPage($copyQ);
  }

  $copyQ->close();
  $saveMbrid = $copy->getMbrid();
  $saveDaysLate = $copy->getDaysLate();

  #**************************************************************************
  #*  Check hold list to see if someone has the copy on hold
  #**************************************************************************
  $holdQ = new BiblioHoldQuery();
  $holdQ->connect();
  if ($holdQ->errorOccurred()) {
    $holdQ->close();
    displayErrorPage($holdQ);
  }
  $hold = $holdQ->getFirstHold($copy->getBibid(),$copy->getCopyid());
  if ($holdQ->errorOccurred()) {
    $holdQ->close();
    displayErrorPage($holdQ);
  }
  $holdQ->close();

  #**************************************************************************
  #*  Update copy status code
  #**************************************************************************
  $copyQ->connect();
  if ($copyQ->errorOccurred()) {
    $copyQ->close();
    displayErrorPage($copyQ);
  }
  
  $renueva = false;
  if(isset($_POST["renovar"]))
    {
	  $renueva = true;
	  $log.= "renueva=true|";
	  $statusBeginDt = $copy->getStatusBeginDt();
	  $dueBackDt = $copy->getDueBackDt();
	  $fecha1 = mktime(0,0,0,substr($statusBeginDt,5,2),substr($statusBeginDt,8,2),substr($statusBeginDt, 0,4));
      $fecha2 = mktime(0,0,0,substr($dueBackDt,5,2),substr($dueBackDt,8,2),substr($dueBackDt, 0,4));
      $dias_para_devolucion = Round((($fecha2-$fecha1)/86400), 0) ;
	}  
  
  if ($holdQ->getRowCount() > 0) {
    $copy->setStatusCd(OBIB_STATUS_ON_HOLD);
  } else {
    $copy->setStatusCd(OBIB_STATUS_SHELVING_CART);
  }
  
  $inicio_sancion=$copy->getDueBackDt();
  $copy_barcode=$copy->getBarcodeNmbr();  
  
  $fecha_acordada_devolucion = $copy->getDueBackDt();
  $log.="fecha_acord_devol=$fecha_acordada_devolucion|";
  $copy->setMbrid("");
  $copy->setDueBackDt("");
  if (!$copyQ->update($copy,true)) {
    $copyQ->close();
    displayErrorPage($copyQ);
  }
  $copyQ->close();
  
  #****************************************************************************
  #*  Autor: Horacio Alvarez
  #*  fecha: 26-03-06
  #*  Descripcion: Decrementa el campo cantidad de pretamos actual del socio.
  #****************************************************************************
  $mbrQ = new MemberQuery();
  $mbrQ->connect();
  if ($mbrQ->errorOccurred()) {
    $mbrQ->close();
    displayErrorPage($mbrQ);
  }
  if (!$mbrQ->execSelect($saveMbrid)) {
    $mbrQ->close();
    displayErrorPage($mbrQ);
  }
  $mbr = $mbrQ->fetchMember();
  $mbrid = $mbr->getMbrid();
  $nuevaCantidad=$mbr->getCantidadPrestamos()-1;
  $mbr->setCantidadPrestamos($nuevaCantidad);
  $sancionado=false;
//  if($mbr->getSancion_activa()=='s')
  $oldFechaSuspension = "1900-01-01";

  if($mbrQ->estaAtrasado($barcode,$mbr->getMbrid()))
     {//seteo el tiempo de suspension
	 $sancionado=true;
	 $log.= "estaAtrasado=true|";
	 $log.= "tipo_sancion_cd=".$mbr->getTipo_sancion_cd()."|";
	 $log.= "sancion_activa=".$mbr->getSancion_activa()."|";
	 
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
           $log.="h_begin_dt=".substr($hist->getStatusBeginDt(),0,10)."|";
	       if(substr($hist->getStatusBeginDt(),0,10) == date("Y-m-d"))
		   {
		       $mismoDia = true;
			   $log.="mismoDia=true|";
		   }
	  }
	 
	 if($mbr->getSancion_activa() == "n" && !$mismoDia) //CORRE PROCESO DE ACTUALIZACION DE SANCION
	    {
		 do
		 {
		 $reprocesa = false;
		 $mbrQ->actualizar_infracciones($mbr);
         if (!$mbrQ->execSelect($mbrid)) {
             $mbrQ->close();
             displayErrorPage($mbrQ);
         }
         $mbr = $mbrQ->fetchMember();		 
		 
		 $log.= "tipo_sancion_cd_after=".$mbr->getTipo_sancion_cd()."|";
		 
		 $daysLate = $mbrQ->getDiasRetraso($barcode,$mbr->getMbrid());
		 
		 $log.= "daysLate=".$daysLate."|";
	
	     $atrasado = true;	 
	     if(isset($daysLate))
	        {
	        //if($mbr->getTipo_sancion_cd()==1 && $daysLate<3)
		    if($mbr->getTipo_sancion_cd()==1 && $daysLate<3 && $mbr->getSancion_activa()!="n" )
		       {
	            $atrasado = false;
		        $log.= "atrasado=false|";
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
                      displayErrorPage($mbrQ);
                   }
				   else
				      $reprocesa = true;
				    
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
	  }
	  while($reprocesa);
	  
	  }
	  

//	  $histQ->close();
	  
	  if($mbr->getEstaSancionado() && !$mismoDia)//si el socio actualmente esta cumpliendo una sancion, suma la nueva suspension al fecha existente.
	    {
		 $log.="estaSancionado=true|";
		 $mbr->setTipo_sancion_cd($mbr->getTipo_sancion_cd()+1);
		}	  
	  
     /***OBTENGO AL REGISTRO DE TIPOS DE SANCION****/
     $dmQ = new DmQuery();
     $dmQ->connect();
     if ($dmQ->errorOccurred()) {
         $dmQ->close();
         displayErrorPage($dmQ);
     }
	    
		
     $dmQ->execSelect("tipo_sancion_dm",$mbr->getTipo_sancion_cd());
     if ($dmQ->errorOccurred()) {
        $dmQ->close();
        displayErrorPage($dmQ);
     }
     $dm = $dmQ->fetchRow();
      /***FIN OBTENGO AL REGISTRO DE TIPOS DE SANCION****/	  
      
	  $inicio=$fecha_acordada_devolucion;
//	  echo "fecha_acordada_devolucion: ".$fecha_acordada_devolucion."<BR>";
	  $date1 = mktime(0,0,0,substr($inicio,5,2),substr($inicio,8,2),substr($inicio, 0,4));
      $date2 = mktime(0,0,0,date('m'),date('d'),date('Y'));
      $total_days = Round((($date2-$date1)/86400), 0) ;
//	  echo "total_days: ".$total_days."<BR>";
	  $dias=$dm->getDias_sancion();
//	  echo "dias: ".$dias."<BR>";
      
	  
	  
	  
	  $timestamp_current = strtotime($fecha_acordada_devolucion);
	  $realValue = 0;
	  for($i=1;$i<=$total_days;$i++)
	     {
		    $timestamp_parcial = $timestamp_current + (60*60*24*$i); 
		    $parcial = date('Y-m-d', $timestamp_parcial);
		    if(!isFinde($parcial))
		      $realValue++;  
		   }
		
		$total_days = trim($realValue);
		
		$total_days=$total_days*$dias;
//		echo "total_days*dias: ".$total_days."<BR>";

	  
	  
	  if($mbr->getEstaSancionado())
	     $oldFechaSuspension = $mbr->getFecha_suspension();

      $nuevo_inicio = date("Y-m-d");
      $mbr->setInicio_sancion($nuevo_inicio);
	  if($mbr->getEstaSancionado() && !$mismoDia)//si el socio actualmente esta cumpliendo una sancion, suma la nueva suspension al fecha existente.
	    {
	     $nuevo_inicio = $mbr->getFecha_suspension();
		}
	  $mbr->setInicio_sancion($nuevo_inicio);
//	   echo "inicio = mbr->getFecha_suspension(): ".$inicio."<BR>";
      $timestamp_current = strtotime($nuevo_inicio);
	  
	  if($dm->getCode() == 5)//SI LLEGO A LA INFRACCION 5 SE SANCIONA POR 365
	  	  $total_days = 365;
	  
      $timestamp_future  = $timestamp_current + (60*60*24*$total_days);
	  $mbr->setFecha_suspension(date('Y-m-d', $timestamp_future));
	  
//	  echo "setFecha_suspension: ".$mbr->getFecha_suspension()."<BR>";
	  $mbr->setSancion_activa("n");
	  $mbr->setCopy_barcode("");
	  
	  
  $actualiza = true;
//	 echo "oldFechaSuspension: ".$oldFechaSuspension."<br>";
//	 echo "mbr->getFecha_suspension(): ".$mbr->getFecha_suspension()."<br>";  
  if($mbr->getEstaSancionado())
    {
	$log.="estaSancionado2=true|";
//	 echo "oldFechaSuspension: ".$oldFechaSuspension."<br>";
//	 echo "mbr->getFecha_suspension(): ".$mbr->getFecha_suspension()."<br>";
     if($oldFechaSuspension >= $mbr->getFecha_suspension())	 
	   {
	    $log.="oldFechaSuspension=$oldFechaSuspension|";
		$log.="mbr_getFecha_suspension=".$mbr->getFecha_suspension()."|";
		$log.="actualiza=false|";
	    $actualiza = false;
		$sancionado = false;
		}
	}
  if($actualiza)		
    if (!$mbrQ->update($mbr)) {
       $mbrQ->close();
       displayErrorPage($mbrQ);
    }  
  $mbrQ->close();      
}

  #**************************************************************************
  #*  Insert into biblio status history
  #**************************************************************************
  if ($saveMbrid != "") {
    $hist = new BiblioStatusHist();
    $hist->setBibid($copy->getBibid());
    $hist->setCopyid($copy->getCopyid());
    $hist->setStatusCd($copy->getStatusCd());
    $hist->setDueBackDt($copy->getDueBackDt());
	
	if($copy->getStatusCd() == "hld")
       $hist->setMbrid($hold->getMbrid());
	else 	
       $hist->setMbrid($saveMbrid);
	//agregado: Horacio Alvarez
	$hist->setUserId($_SESSION["userid"]);
	if($sancionado)
       $hist->setSanciono("s");
	else
	   $hist->setSanciono("n");
    $histQ = new BiblioStatusHistQuery();
    $histQ->connect();
    if ($histQ->errorOccurred()) {
      $histQ->close();
      displayErrorPage($histQ);
    }
    $histQ->insert($hist);
    if ($histQ->errorOccurred()) {
      $histQ->close();
      displayErrorPage($histQ);
    }
	if($copy->getStatusCd() == "hld")
	{
	    $hist->setStatusCd("crt");
	    $hist->setMbrid($saveMbrid);
		$histQ->insert($hist);
		if ($histQ->errorOccurred()) {
		  $histQ->close();
		  displayErrorPage($histQ);
		}	 
	}
    $histQ->close();

    #**************************************************************************
    #*  Calc late fee if any
    #**************************************************************************
    if (($saveDaysLate > 0) and ($dailyLateFee > 0)) {
      $fee = $dailyLateFee * $saveDaysLate;
      $trans = new MemberAccountTransaction();
      $trans->setMbrid($saveMbrid);
      $trans->setCreateUserid($_SESSION["userid"]);
      $trans->setTransactionTypeCd("+c");
      $trans->setAmount($fee);
      $trans->setDescription($loc->getText("shelvingCartTrans",array("barcode" => $barcode)));

      $transQ = new MemberAccountQuery();
      $transQ->connect();
      if ($transQ->errorOccurred()) {
        $transQ->close();
        displayErrorPage($transQ);
      }
      $trans = $transQ->insert($trans);
      if ($transQ->errorOccurred()) {
        $transQ->close();
        displayErrorPage($transQ);
      }
      $transQ->close();
    }
  }
  $log .= "\n";
  fwrite($fp,$log,1024);
  fclose($fp);
  #**************************************************************************
  #*  Destroy form values and errors
  #**************************************************************************
  unset($_SESSION["postVars"]);
  unset($_SESSION["pageErrors"]);

  #**************************************************************************
  #*  Go back to member view
  #**************************************************************************
  
//die();
  if ($holdQ->getRowCount() > 0) {//material reservado
    $mbrid = $hold->getMbrid();
	$holdBeginDt=$hold->getHoldBeginDt();
    $msg = "";
    if($renueva)
	  $msg = "NOTA: No puede renovar ya que el libro se encuentra reservado";	
	if($sancionado)
	   header("Location: ../circ/hold_message.php?barcode=".$barcode."&mbrid=".$mbrid."&holdBeginDt=".$holdBeginDt."&sancionado=true&mbrid_sancion=".$mbr->getMbrid()."&msg=$msg");
	else
       header("Location: ../circ/hold_message.php?barcode=".$barcode."&mbrid=".$mbrid."&holdBeginDt=".$holdBeginDt."&msg=$msg");
  } else {//material no reservado
    if($sancionado)
	   {
	    $msg = "";
	    if($renueva)
		  $msg = "NOTA: No puede renovar ya que se ha sancionado al socio";
	    header("Location: ../circ/checkin_form.php?sancionado=true&barcode=$barcode&mbrid=".$mbr->getMbrid()."&msg=$msg");
	   }	  
	else
	  {
	   $msg = "";
	   if($renueva)
	     {
	      if($mbr->getEstaSancionado())
		    {
		     $msg = "NOTA: No puede renovar, ya que el socio esta actualmente cumpliendo una sanción";
			 header("Location: ../circ/checkin_form.php?msg=$msg");
			 }
		  else
	         header("Location: ../circ/checkout.php?barcodeNmbr=$barcode&mbrid=".$mbr->getMbrid()."&classification=".$mbr->getClassification()."&dias_para_devolucion=$dias_para_devolucion");
		  }
	   else
          header("Location: ../circ/checkin_form.php");
	  }
  }
 
?>
    
