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
/*
Autor: Horacio Alvarez
Fecha: 03-06-06
Descripcion: Función que escribe una tabla por cada linea encontrada en
header.txt y data.txt, contenedores de los resultados de la busqueda avanzada.
*/
function TablePerItem($header,$data)
{
    $this->SetFillColor(0,51,102);
    $this->SetLineWidth(.1);
	$count_columnas=count($data);
	for($i=0;$i<$count_columnas;$i++)
	   {
	    $j=0;
	    foreach($header as $col)
		       {
			    if(!empty($data[$i][$j]))
				  {
                   $this->SetTextColor(255);
				   $this->SetDrawColor(255,255,255);
			       $this->Cell(40    ,5,$col       ,1,0,'L',1);
				   $this->SetTextColor(0);
				   $this->SetDrawColor(0,51,102);
				   $this->Cell(120,5,$data[$i][$j],1);
				   $this->Ln();
			 	  }
				$j++;
			   }
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
    $this->SetLineWidth(.2);
    //$this->SetFont('','B');
    //Cabecera
//    $w=array(14,60,25,15,14,13,18,23,1);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],6,$header[$i],1,0,'C',1);
    $this->Ln();
    //Restauración de colores y fuentes
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    //Datos
    $fill=0;
    foreach($data as $row)
    {
        $this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
        $this->Cell($w[1],6,$row[1],'LR',0,'L',$fill);
        $this->Cell($w[2],6,$row[2],'LR',0,'R',$fill);
        $this->Cell($w[3],6,$row[3],'LR',0,'R',$fill);
		$this->Cell($w[4],6,$row[4],'LR',0,'R',$fill);
		$this->Cell($w[5],6,$row[5],'LR',0,'R',$fill);
		$this->Cell($w[6],6,$row[6],'LR',0,'R',$fill);
		$this->Cell($w[7],6,$row[7],'LR',0,'R',$fill);
		$this->Cell($w[8],6,$row[8],'LR',0,'R',$fill);
		$this->Cell($w[9],6,$row[9],'LR',0,'R',$fill);
		$this->Cell($w[10],6,$row[10],'LR',0,'R',$fill);
		$this->Cell($w[11],6,$row[11],'LR',0,'R',$fill);
        $this->Ln();
        $fill=!$fill;
    }
    $this->Cell(array_sum($w),0,'','T');
}
}
$pdf=new PDF();
$fp=fopen("header.txt","r");
$linea=fread($fp,1024);
$header=explode(";",$linea);
$data=$pdf->LoadData('data.txt');
$pdf->SetFont('Arial','',6);
$pdf->AddPage();
$pdf->Cell(40,10,$_GET["title"]);
$pdf->Ln();
$pdf->TablePerItem($header,$data);
$pdf->Output();
?>