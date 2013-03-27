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

//  $tab = "admin";
//  $nav = "mails";

  require_once("../functions/errorFuncs.php");
//  require_once("../shared/common.php");
//  require_once("../classes/Localize.php");
  require_once("../functions/inputFuncs.php");
  require_once("../funciones.php");
  include_once("../classes/Settings.php");
  include_once("../classes/SettingsQuery.php");  
//  $loc = new Localize(OBIB_LOCALE,$tab);
  
//  require_once("../shared/logincheck.php");

//  require_once("../shared/header.php");

  $setQ = new SettingsQuery();
  $setQ->connect();
  if ($setQ->errorOccurred()) {
      $setQ->close();
      displayErrorPage($setQ);
  }
  $setQ->execSelect();
  if ($setQ->errorOccurred()) {
      $setQ->close();
      displayErrorPage($setQ);
  }
  $set = $setQ->fetchRow();
  
  $mensaje="Nombre: ".$set->getLibraryName()." \n";
  $mensaje.="Domicilio: ".$set->getDomicilio()." \n";
  $mensaje.="Teléfono: ".$set->getLibraryPhone()." \n";
  $mensaje.="Horario: ".$set->getLibraryHours()." \n";
  
$mensaje  = '<html> <head> <title>Untitled Document</title> <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"> </head> ';
$mensaje .= '<body>                                                                                                                          ';
$mensaje .= '<table width="550" border="0">                                                                                                  ';
$mensaje .= '  <tr>                                                                                                                          ';
$mensaje .= '    <td width="16%"><img src="http://www2.unpa.edu.ar/unpa_img/logotipo.jpg"></td>                                              ';
$mensaje .= '    <td width="59%">&nbsp;</td>                                                                                                 ';
$mensaje .= '    <td width="25%">&nbsp;</td>                                                                                                 ';
$mensaje .= '  </tr>                                                                                                                         ';
$mensaje .= '  <tr>                                                                                                                          ';
$mensaje .= '    <td colspan="3" ><div align="right"><font size="2" face="Arial">'.getFechaEspaniolSinHora().'</font></div></td>             ';
$mensaje .= '  </tr>                                                                                                                         ';                            
$mensaje .= '  <tr>                                                                                                                          ';                            
$mensaje .= '    <td colspan="3"><font face="Arial"><font size="2">Estimado/a Usuario/a:</font></font></td>                                  ';                            
$mensaje .= '  </tr>                                                                                                                         ';
$mensaje .= '  <tr>                                                                                                                          ';                            
$mensaje .= '    <td>&nbsp;</td>                                                                                                             ';                            
$mensaje .= '    <td colspan="2"><div align="justify"><font face="Arial"><font size="2">Le                                                   ';                            
$mensaje .= '        recordamos que el d&iacute;a '.toDDmmYYYY(getNextDiasHabiles(2)).' vencen su/s prestamo/s de                                                   ';                            
$mensaje .= '        material</font></font></div></td>                                                                                             ';                            
$mensaje .= '  </tr>                                                                                                                         ';                            
$mensaje .= '  <tr>                                                                                                                          ';                            
$mensaje .= '    <td colspan="3"><font face="Arial"><font size="2">bibliográfico. La demora                                             ';                            
$mensaje .= '      en la devolución del material esta sujeta a sanciones según el</font></font></td>                                                                         ';                            
$mensaje .= '  </tr>                                                                                                                         ';
$mensaje .= '  <tr>                                                                                                                          ';                            
$mensaje .= '    <td colspan="3"><font face="Arial"><font size="2">reglamento de bibliotecas.</font></font></td>                                                                         ';                            
$mensaje .= '  </tr>                                                                                                                         ';
$mensaje .= '  <tr>                                                                                                                          ';                            
$mensaje .= '    <td>&nbsp;</td>                                                                                                             ';                            
$mensaje .= '    <td colspan="2"><div align="justify"><font face="Arial"><font size="2">Por                                                  ';                            
$mensaje .= '        lo tanto solicitamos tenga presente la fecha de devolución.</font></font></div></td>                                 ';                            
$mensaje .= '  </tr>                                                                                                                         ';                                                       
$mensaje .= '  <tr>                                                                                                                          ';                            
$mensaje .= '    <td>&nbsp;</td>                                                                                                             ';                            
$mensaje .= '    <td colspan="2"><font face="Arial"><font size="2">Lo saludamos atentamente.-</font></font></td>                             ';                            
$mensaje .= '  </tr>                                                                                                                         ';                            
$mensaje .= '  <tr>                                                                                                                          ';                            
$mensaje .= '    <td>&nbsp;</td>                                                                                                             ';                            
$mensaje .= '    <td colspan="2">&nbsp;</td>                                                                                                 ';                            
$mensaje .= '  </tr>                                                                                                                         ';                            
$mensaje .= '  <tr>                                                                                                                          ';                            
$mensaje .= '    <td colspan="3"> <p align="right"><font size="2" face="Arial">U N P A - U A R G<br>                                                                                                               ';                            
$mensaje .= '        Sistema de Informaci&oacute;n y Bibliotecas (SIUNPA)<br>                                                                ';                            
$mensaje .= '        '.$set->getLibraryName().'<br>                                                              ';                            
$mensaje .= '        '.$set->getDomicilio().'<br>                                                              ';
$mensaje .= '        TEL: '.$set->getLibraryPhone().'<br>                                                              ';                            
$mensaje .= '        Servicio de Pr&eacute;stamo y Circulaci&oacute;n</font></p></td>                                                        ';                            
$mensaje .= '  </tr>                                                                                                                         ';                            
$mensaje .= '</table>                                                                                                                        ';                            
$mensaje .= '</body>                                                                                                                         ';                            
$mensaje .= '</html>                                                                                                                         ';

if(isset($_GET["mostrar"]))
    echo $mensaje;
?>  
