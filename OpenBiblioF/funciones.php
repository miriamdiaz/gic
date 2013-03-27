<?

/**
Autor: Horacio Alvarez
Fecha: 17-04-06
Descripcion: Obtiene la fecha completa en español.
*/
function getFechaEspaniol()
{
 
 $mes_numero=date("n");
 switch($mes_numero)
       {
        case 1: $mes_nombre="Enero";break;
		case 2: $mes_nombre="Febrero";break;
		case 3: $mes_nombre="Marzo";break;
		case 4: $mes_nombre="Abril";break;
		case 5: $mes_nombre="Mayo";break;
		case 6: $mes_nombre="Junio";break;
		case 7: $mes_nombre="Julio";break;
		case 8: $mes_nombre="Agosto";break;
		case 9: $mes_nombre="Septiembre";break;
		case 10: $mes_nombre="Octubre";break;
		case 11: $mes_nombre="Noviembre";break;
		case 12: $mes_nombre="Diciembre";break;
	   }
 $fecha=date("j")." de ".$mes_nombre." de ".date("Y, g:i a");
 return $fecha;
}

function getFechaEspaniolSinHora()
{
 
 $mes_numero=date("n");
 switch($mes_numero)
       {
        case 1: $mes_nombre="Enero";break;
		case 2: $mes_nombre="Febrero";break;
		case 3: $mes_nombre="Marzo";break;
		case 4: $mes_nombre="Abril";break;
		case 5: $mes_nombre="Mayo";break;
		case 6: $mes_nombre="Junio";break;
		case 7: $mes_nombre="Julio";break;
		case 8: $mes_nombre="Agosto";break;
		case 9: $mes_nombre="Septiembre";break;
		case 10: $mes_nombre="Octubre";break;
		case 11: $mes_nombre="Noviembre";break;
		case 12: $mes_nombre="Diciembre";break;
	   }
 $fecha=date("j")." de ".$mes_nombre." de ".date("Y");
 return $fecha;
}

function toDDmmYYYY($date)
{
 return substr($date,8,2)."-".substr($date,5,2)."-".substr($date,0,4);
}

function isFinde($date)
{
 $dia = substr($date,8,2);
 $mes = substr($date,5,2);
 $anio = substr($date,0,4);
 
 $magic_number = jddayofweek ( cal_to_jd(CAL_GREGORIAN, $mes , $dia , $anio ) , 0 );
 if($magic_number == 0 || $magic_number == 6)
    return true;
 return false;
}
function getNextDiasHabiles($cantidad)
{
$hoy = date('Y-m-d');
$timestamp_current = strtotime($hoy);
$added = 0;
$reached = false;
while(!$reached)
    {
    $timestamp_parcial = $timestamp_current + (60*60*24*1); 
    $parcial = date('Y-m-d', $timestamp_parcial);
    if(!isFinde($parcial))
	   {
	   $timestamp_current = $timestamp_parcial; 
       $added++;
	   if($added == $cantidad)
	      $reached = true;  
	   }
	$timestamp_current = $timestamp_parcial;
    }
return $parcial;
}
function isSabado($date)
{
 $dia = substr($date,8,2);
 $mes = substr($date,5,2);
 $anio = substr($date,0,4);
 
 $magic_number = jddayofweek ( cal_to_jd(CAL_GREGORIAN, $mes , $dia , $anio ) , 0 );
 if($magic_number == 6)
    return true;
 return false;
}
function isDomingo($date)
{
 $dia = substr($date,8,2);
 $mes = substr($date,5,2);
 $anio = substr($date,0,4);
 
 $magic_number = jddayofweek ( cal_to_jd(CAL_GREGORIAN, $mes , $dia , $anio ) , 0 );
 if($magic_number == 0)
    return true;
 return false;
}
function getCantidadDiasSinFindes($fecha_acordada_devolucion,$total_days)
{
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
	  return $total_days;
}
function enviarMail($asunto,$mensaje,$email,$first_name,$last_name)
{
			$enviado = "No Enviado";
//		    if(mail($email,$asunto,$mensaje,"Content-type: text/html\n", "FROM: Bibliteca Malvina Perazo <biblio@unpa.uarg.com>\n"))
            if(mail($email,$asunto,$mensaje,"Content-type: text/html\n", "admin@djdelirio.com"))
               $enviado = "Enviado";
			 ?>
                <tr>
                  <td nowrap="true" class="primary"> <?=$enviado?> </td>  
                  <td nowrap="true" class="primary">  <?=$first_name?> <?=$last_name?> Email: <?=$email?> </td>
                </tr>			    
			  <?
}
?>