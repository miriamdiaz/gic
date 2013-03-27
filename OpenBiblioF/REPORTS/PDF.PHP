<?php
//session_start();
require('fpdf.php');

class PDF extends FPDF
{
//Cargar los datos
function LoadData($file)
{
    //Leer las líneas del fichero
    $lines=file($file);
    $data=array();
    foreach($lines as $line)
        $data[]=explode(';',chop($line));
    return $data;
}
function WriteTitle($title){
    $this->Cell(40,7,$title,1);
    $this->Ln();
}
//Tabla simple
function BasicTable($header,$data)
{
    //Cabecera
    foreach($header as $col)
        $this->Cell(40,7,$col,1);
    $this->Ln();
    //Datos
    foreach($data as $row)
    {
        foreach($row as $col)
            $this->Cell(40,7,$col,1);
        $this->Ln();
    }
}

//Una tabla más completa
function ImprovedTable($header,$data)
{
    //Anchuras de las columnas
    $w=array(40,35,40,45);
    //Cabeceras
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C');
    $this->Ln();
    //Datos
    foreach($data as $row)
    {
        $this->Cell($w[0],6,$row[0],'LR');
        $this->Cell($w[1],6,$row[1],'LR');
        $this->Cell($w[2],6,number_format($row[2]),'LR',0,'R');
        $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R');
        $this->Ln();
    }
    //Línea de cierre
    $this->Cell(array_sum($w),0,'','T');
}

//Tabla coloreada
function FancyTable($header,$data,$w)
{
    //Colores, ancho de línea y fuente en negrita
    $this->SetFillColor(255,0,0);
    $this->SetTextColor(255);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
    //Cabecera
//    $w=array(14,60,25,15,14,13,18,23,1);
    $total = 0;
    $total_columnas = count($header)-1;
    for($i=0;$i<$total_columnas;$i++)
	   {
	    $total = $total + $w[$i]["width"];
        $this->Cell($w[$i]["width"],7,$header[$i],1,0,'C',1);
	   }
    $this->Ln();
    //Restauración de colores y fuentes
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    //Datos
    $fill=0;
    foreach($data as $row)
    {
	 foreach($w as $key=>$value)
//	      if($key<$total_columnas)
           { 
		     $width=$value["width"];
			 $text_length=$value["text_length"];
	         $this->Cell($width,5,substr($row[$key],0,$text_length),'LR',0,'L',$fill);
		   }
        $this->Ln();
        $fill=!$fill;
    }
    $this->Cell($total,0,'','T');
}
}
$fp=fopen("header.txt","r");
$linea=fread($fp,1024);
$header=explode(";",$linea);

$rptid=$_GET["rptid"];
if($rptid=="sancionados")
   {
   $pdf=new PDF();
   $data=$pdf->LoadData('data.txt');
   $pdf->SetFont('Arial','',10);
   $pdf->AddPage();
   $pdf->Cell(40,10,$_GET["title"]);
   $pdf->SetFont('Arial','',7);
   $pdf->Ln();
   $w=array(0=>array("width"=>20,"text_length"=>25),
            1=>array("width"=>40,"text_length"=>25),
		    2=>array("width"=>40,"text_length"=>25),
			3=>array("width"=>25,"text_length"=>25),
		    4=>array("width"=>25,"text_length"=>25));
   }
elseif($rptid=="prestamosAnuales" || $rptid=="prestamosDiarios" || $rptid=="prestamosMensuales")
   {
   $pdf=new PDF("L","mm","Legal");
   $data=$pdf->LoadData('data.txt');
   $pdf->SetFont('Arial','',14);
   $pdf->AddPage();
   $pdf->Cell(40,10,$_GET["title"]);
   $pdf->SetFont('Arial','',8);
   $pdf->Ln();
   $w=array(0=>array("width"=>18,"text_length"=>18),
            1=>array("width"=>20,"text_length"=>20),
		    2=>array("width"=>60,"text_length"=>40),
			3=>array("width"=>60,"text_length"=>40),
			4=>array("width"=>40,"text_length"=>25),
			5=>array("width"=>40,"text_length"=>12),
			6=>array("width"=>30,"text_length"=>27),
			7=>array("width"=>30,"text_length"=>30));
  }
elseif($rptid=="prestamosMensuales" || $rptid=="prestamosDiarios" || $rptid=="devolucionesDiarias")
   {
   $pdf=new PDF("L","mm","Legal");
   $data=$pdf->LoadData('data.txt');
   $pdf->SetFont('Arial','',14);
   $pdf->AddPage();
   $pdf->Cell(40,10,$_GET["title"]);
   $pdf->SetFont('Arial','',7);
   $pdf->Ln();
   $w=array(0=>array("width"=>18,"text_length"=>18),
            1=>array("width"=>20,"text_length"=>20),
		    2=>array("width"=>50,"text_length"=>40),
			3=>array("width"=>50,"text_length"=>40),
			4=>array("width"=>40,"text_length"=>25),
			5=>array("width"=>20,"text_length"=>14),
			6=>array("width"=>30,"text_length"=>27),
			7=>array("width"=>30,"text_length"=>30)
			);
   }
elseif($rptid=="popularBiblios")
   {
   $pdf=new PDF("L","mm","Legal");
   $data=$pdf->LoadData('data.txt');
   $pdf->SetFont('Arial','',14);
   $pdf->AddPage();
   $pdf->Cell(40,10,$_GET["title"]);
   $pdf->SetFont('Arial','',8);
   $pdf->Ln();
   $w=array(0=>array("width"=>18,"text_length"=>18),
            1=>array("width"=>20,"text_length"=>20),
		    2=>array("width"=>60,"text_length"=>40),
			3=>array("width"=>60,"text_length"=>40),
			4=>array("width"=>60,"text_length"=>25),
			5=>array("width"=>30,"text_length"=>12),
		    6=>array("width"=>40,"text_length"=>35));
   }      
elseif($rptid=="listadoSocios")
   {
   $pdf=new PDF("L");
   $data=$pdf->LoadData('data.txt');
   $pdf->SetFont('Arial','',14);
   $pdf->AddPage();
   $pdf->Cell(40,10,$_GET["title"]);
   $pdf->SetFont('Arial','',7);
   $pdf->Ln();
   $w=array(0=>array("width"=>15,"text_length"=>15),
            1=>array("width"=>35,"text_length"=>20),
		    2=>array("width"=>30,"text_length"=>20),
			3=>array("width"=>40,"text_length"=>25),
			4=>array("width"=>25,"text_length"=>25),
			5=>array("width"=>20,"text_length"=>12),
			6=>array("width"=>45,"text_length"=>50),
			7=>array("width"=>22,"text_length"=>30),
		    8=>array("width"=>18,"text_length"=>70),
			9=>array("width"=>18,"text_length"=>70));
   }
elseif($rptid=="listadoSociosPopulares")
   {
   $pdf=new PDF("L");
   $data=$pdf->LoadData('data.txt');
   $pdf->SetFont('Arial','',14);
   $pdf->AddPage();
   $pdf->Cell(40,10,$_GET["title"]);
   $pdf->SetFont('Arial','',7);
   $pdf->Ln();
   $w=array(0=>array("width"=>17,"text_length"=>17),
            1=>array("width"=>15,"text_length"=>15),
		    2=>array("width"=>40,"text_length"=>20),
			3=>array("width"=>40,"text_length"=>20),
			4=>array("width"=>40,"text_length"=>25),
			5=>array("width"=>40,"text_length"=>25),
			6=>array("width"=>18,"text_length"=>12));
   }
elseif($rptid=="balanceDueList" || $rptid=="checkouts" || $rptid=="prestamosVencer")
   {
   $pdf=new PDF("L");
   $data=$pdf->LoadData('data.txt');
   $pdf->SetFont('Arial','',14);
   $pdf->AddPage();
   $pdf->Cell(40,10,$_GET["title"]);
   $pdf->SetFont('Arial','',8);
   $pdf->Ln();
   $w=array(0=>array("width"=>25,"text_length"=>25),
            1=>array("width"=>80,"text_length"=>65),
		    2=>array("width"=>30,"text_length"=>30),
			3=>array("width"=>30,"text_length"=>30),
			4=>array("width"=>40,"text_length"=>25),
			5=>array("width"=>40,"text_length"=>20),
			6=>array("width"=>20,"text_length"=>10));
   }
elseif($rptid=="overdueList")
   {
   $pdf=new PDF("L");
   $data=$pdf->LoadData('data.txt');
   $pdf->SetFont('Arial','',10);
   $pdf->AddPage();
   $pdf->Cell(40,10,$_GET["title"]);
   $pdf->SetFont('Arial','',7);
   $pdf->Ln();
   $w=array(0=>array("width"=>35,"text_length"=>20),
            1=>array("width"=>35,"text_length"=>25),
		    2=>array("width"=>18,"text_length"=>25),
			3=>array("width"=>30,"text_length"=>20),
			4=>array("width"=>40,"text_length"=>30),
			5=>array("width"=>18,"text_length"=>20),
			6=>array("width"=>40,"text_length"=>25),
			7=>array("width"=>30,"text_length"=>25),
			8=>array("width"=>20,"text_length"=>20),
			9=>array("width"=>18,"text_length"=>20));
   }
elseif($rptid=="holds")
   {
   $pdf=new PDF("L");
   $data=$pdf->LoadData('data.txt');
   $pdf->SetFont('Arial','',14);
   $pdf->AddPage();
   $pdf->Cell(40,10,$_GET["title"]);
   $pdf->SetFont('Arial','',10);
   $pdf->Ln();
   $w=array(0=>array("width"=>23,"text_length"=>25),
            1=>array("width"=>55,"text_length"=>30),
		    2=>array("width"=>35,"text_length"=>45),
			3=>array("width"=>20,"text_length"=>40),
			4=>array("width"=>40,"text_length"=>25),
			5=>array("width"=>40,"text_length"=>30),
			6=>array("width"=>40,"text_length"=>35));
   }
elseif($rptid == "siunpaEstadisctico" || $rptid == "estadisticoUsuarios")
   {
   $pdf=new PDF("L");
   $data=$pdf->LoadData('data.txt');
   $pdf->SetFont('Arial','',14);
   $pdf->AddPage();
   $pdf->Cell(40,10,$_GET["title"]);
   $pdf->SetFont('Arial','',10);
   $pdf->Ln();
   $w=array(0=>array("width"=>50,"text_length"=>25),
            1=>array("width"=>15,"text_length"=>30),
		    2=>array("width"=>20,"text_length"=>45),
			3=>array("width"=>15,"text_length"=>40),
			4=>array("width"=>15,"text_length"=>25),
			5=>array("width"=>15,"text_length"=>30),
			6=>array("width"=>15,"text_length"=>35),
			7=>array("width"=>15,"text_length"=>20),
			8=>array("width"=>18,"text_length"=>20),
			9=>array("width"=>25,"text_length"=>20),
			10=>array("width"=>20,"text_length"=>20),
			11=>array("width"=>25,"text_length"=>20),
			12=>array("width"=>25,"text_length"=>20));
   }
elseif($rptid == "estadisticoOperaciones")
   {
   $pdf=new PDF("P");
   $data=$pdf->LoadData('data.txt');
   $pdf->SetFont('Arial','',14);
   $pdf->AddPage();
   $pdf->Cell(40,10,$_GET["title"]);
   $pdf->SetFont('Arial','',10);
   $pdf->Ln();
   $w=array(0=>array("width"=>50,"text_length"=>25),
            1=>array("width"=>30,"text_length"=>30),
		    2=>array("width"=>30,"text_length"=>45),
			3=>array("width"=>30,"text_length"=>40));
   }
elseif($rptid=="labels")
   {
   $pdf=new PDF("L");
   $data=$pdf->LoadData('data.txt');
   $pdf->SetFont('Arial','',10);
   $pdf->AddPage();
   $pdf->Cell(40,10,$_GET["title"]);
   $pdf->SetFont('Arial','',7);
   $pdf->Ln();
   $w=array(0=>array("width"=>17,"text_length"=>17),
            1=>array("width"=>17,"text_length"=>17),
		    2=>array("width"=>20,"text_length"=>20),
			3=>array("width"=>30,"text_length"=>30),
			4=>array("width"=>26,"text_length"=>24),
			5=>array("width"=>40,"text_length"=>32),
			6=>array("width"=>35,"text_length"=>30),
			7=>array("width"=>35,"text_length"=>30),
			8=>array("width"=>35,"text_length"=>27),
			9=>array("width"=>12,"text_length"=>12),
		   10=>array("width"=>17,"text_length"=>17));
   }
elseif($rptid=="adquisiciones")
   {
   $pdf=new PDF("L");
   $data=$pdf->LoadData('data.txt');
   $pdf->SetFont('Arial','',10);
   $pdf->AddPage();
   $pdf->Cell(40,10,$_GET["title"]);
   $pdf->SetFont('Arial','',7);
   $pdf->Ln();
   $w=array(0=>array("width"=>10,"text_length"=>10),
            1=>array("width"=>25,"text_length"=>25),
		    2=>array("width"=>25,"text_length"=>25),
			3=>array("width"=>20,"text_length"=>20),
			4=>array("width"=>16,"text_length"=>16),
			5=>array("width"=>20,"text_length"=>20),
			6=>array("width"=>8,"text_length"=>8),
			7=>array("width"=>15,"text_length"=>15),
			8=>array("width"=>16,"text_length"=>16),
			9=>array("width"=>18,"text_length"=>18),
		   10=>array("width"=>15,"text_length"=>15),
		   11=>array("width"=>16,"text_length"=>16),
		   12=>array("width"=>20,"text_length"=>20),
		   13=>array("width"=>16,"text_length"=>16),
		   14=>array("width"=>13,"text_length"=>13),
		   15=>array("width"=>25,"text_length"=>25));
   }                     
$pdf->FancyTable($header,$data,$w);
$pdf->Output();
?>