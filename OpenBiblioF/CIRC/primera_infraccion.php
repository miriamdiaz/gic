<?

  require_once("../classes/Member.php");
  require_once("../classes/MemberQuery.php");
  require_once("../classes/MemberSancionHist.php");
  require_once("../classes/MemberSancionHistQuery.php");
  
  
$mbrid=$_GET["mbrid"];
$barcode_nmbr=$_GET["barcode_nmbr"];

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
  

     $mbr->setTipo_sancion_cd(1);
	 $mbr->setInicio_sancion(date("Y-m-d"));
	 $mbr->setSancion_activa("s");
	 $mbr->setCopy_barcode($barcode_nmbr);
	 
  #**************************************************************************
  #*  Update library member
  #**************************************************************************
  if (!$mbrQ->update($mbr)) {
    $mbrQ->close();
    displayErrorPage($mbrQ);
  }

  $mbrQ->close();  
	 
  #****************************************************************************
  #*  Insert into database for member_sancion_hist
  #****************************************************************************
  $hist = new MemberSancionHist();
  $hist->setMbrid($mbr->getMbrid());
  $hist->setBarcode_nmbr($barcode_nmbr);
  $hist->setFecha_aplico_sancion(date("Y-m-d"));
  $hist->setTipo_sancion_cd(1);
  
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
  $mbrHistQ->close();  

  
header("Location: ../circ/mbr_view.php?mbrid=".$mbr->getMbrid()."&reset=Y");  	 
?>