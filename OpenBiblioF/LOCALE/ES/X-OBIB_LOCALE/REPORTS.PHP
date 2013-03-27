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

/**********************************************************************************
 *   Instructions for translators:
 *
 *   All gettext key/value pairs are specified as follows:
 *     $trans["key"] = "<php translation code to set the $text variable>";
 *   Allowing translators the ability to execute php code withint the transFunc string
 *   provides the maximum amount of flexibility to format the languange syntax.
 *
 *   Formatting rules:
 *   - Resulting translation string must be stored in a variable called $text.
 *   - Input arguments must be surrounded by % characters (i.e. %pageCount%).
 *   - A backslash ('\') needs to be placed before any special php characters 
 *     (such as $, ", etc.) within the php translation code.
 *
 *   Simple Example:
 *     $trans["homeWelcome"]       = "\$text='Welcome to OpenBiblio';";
 *
 *   Example Containing Argument Substitution:
 *     $trans["searchResult"]      = "\$text='page %page% of %pages%';";
 *
 *   Example Containing a PHP If Statment and Argument Substitution:
 *     $trans["searchResult"]      = 
 *       "if (%items% == 1) {
 *         \$text = '%items% result';
 *       } else {
 *         \$text = '%items% results';
 *       }";
 *
 **********************************************************************************
 */

#****************************************************************************
#*  Translation text used on multiple pages
#****************************************************************************
$trans["reportsCancel"]            = "\$text = 'Cancelar';";

#****************************************************************************
#*  Translation text for page index.php
#****************************************************************************
$trans["indexHdr"]                 = "\$text = 'Informes';";
$trans["indexDesc"]                = "\$text = 'Utilice el informe o lista de etiquetas situado en la zona de navegación izquierda para crear informes o etiquetas.';";

#****************************************************************************
#*  Translation text for page report_list.php
#****************************************************************************
$trans["reportListHdr"]            = "\$text = 'Lista de informes';";
$trans["reportListDesc"]           = "\$text = 'Elija uno de los siguientes enlaces para realizar un informe.';";
$trans["reportListXmlErr"]         = "\$text = 'Ocurrió un error al analizar un informe xml.';";
$trans["reportListCannotRead"]     = "\$text = 'No se pudo leer la etiqueta del archivo: %fileName%';";



#****************************************************************************
#*  Translation text for page label_list.php
#****************************************************************************
$trans["labelListHdr"]             = "\$text = 'Lista de etiquetas';";
$trans["labelListDesc"]            = "\$text = 'Elija uno de los siguientes enlaces para crear etiquetas en formato pdf.';";
$trans["displayLabelsXmlErr"]      = "\$text = 'Ocurrió un error al analizar un informe xml.  Error = ';";

#****************************************************************************
#*  Translation text for page letter_list.php
#****************************************************************************
$trans["letterListHdr"]            = "\$text = 'Lista de cartas';";
$trans["letterListDesc"]           = "\$text = 'Elija uno de los siguientes enlaces para crear cartas en formato pdf.';";
$trans["displayLettersXmlErr"]      = "\$text = 'Ocurrió un error al analizar un informe xml.  Error = ';";

#****************************************************************************
#*  Translation text for page report_criteria.php
#****************************************************************************
$trans["reportCriteriaHead1"]      = "\$text = 'Criterios de búsqueda de informes (opcional)';";
$trans["reportCriteriaHead2"]      = "\$text = 'Clasificación de informes (opcional)';";
$trans["reportCriteriaHead3"]      = "\$text = 'Tipo de salida del reporte';";
$trans["reportCriteriaCrit1"]      = "\$text = 'Criterio 1:';";
$trans["reportCriteriaCrit2"]      = "\$text = 'Criterio 2:';";
$trans["reportCriteriaCrit3"]      = "\$text = 'Criterio 3:';";
$trans["reportCriteriaCrit4"]      = "\$text = 'Criterio 4:';";
$trans["reportCriteriaEQ"]         = "\$text = '=';";
$trans["reportCriteriaNE"]         = "\$text = 'no =';";
$trans["reportCriteriaLT"]         = "\$text = '&lt;';";
$trans["reportCriteriaGT"]         = "\$text = '&gt;';";
$trans["reportCriteriaLE"]         = "\$text = '&lt o =';";
$trans["reportCriteriaGE"]         = "\$text = '&gt o =';";
$trans["reportCriteriaBT"]         = "\$text = 'entre';";
$trans["reportCriteriaAnd"]        = "\$text = 'y';";
$trans["reportCriteriaRunReport"]  = "\$text = 'realizar informe';";
$trans["reportCriteriaSortCrit1"]  = "\$text = 'Clase 1:';";
$trans["reportCriteriaSortCrit2"]  = "\$text = 'Clase 2:';";
$trans["reportCriteriaSortCrit3"]  = "\$text = 'Clase 3:';";
$trans["reportCriteriaAscending"]  = "\$text = 'ascendente';";
$trans["reportCriteriaDescending"] = "\$text = 'descendiente';";
$trans["reportCriteriaStartOnLabel"] = "\$text = 'Empezar a imprimir en la etiqueta:';";
$trans["reportCriteriaOutput"]     = "\$text = 'Tipo de Salida:';";
$trans["reportCriteriaOutputHTML"] = "\$text = 'HTML';";
$trans["reportCriteriaOutputCSV"]  = "\$text = 'CSV';";



#****************************************************************************
#*  Translation text for page run_report.php
#****************************************************************************
$trans["runReportReturnLink1"]     = "\$text = 'criterios de selección de informes';";
$trans["runReportReturnLink2"]     = "\$text = 'lista de informes';";
$trans["runReportTotal"]           = "\$text = 'Total de filas:';";

#****************************************************************************
#*  Translation text for page display_labels.php
#****************************************************************************
$trans["displayLabelsStartOnLblErr"] = "\$text = 'El campo debe ser numérico.';";
$trans["displayLabelsXmlErr"]      = "\$text = 'Ocurrió un error al analizar el informe xml.  Error = ';";

#****************************************************************************
#*  Translation text for page noauth.php
#****************************************************************************
$trans["noauthMsg"]                = "\$text = 'Usted no está autorizado para la solapa de Reportes.';";

#****************************************************************************
#*  Report Titles
#****************************************************************************
$trans["reportHolds"]              = "\$text = 'Peticiones de préstamo que contienen información de contacto con el socio';";
$trans["reportCheckouts"]          = "\$text = 'Listado de bibliografía prestada';";
$trans["overdueLetters"]           = "\$text = 'Over Due Letters';";
$trans["reportLabels"]             = "\$text = 'Información sobre impresión de etiquetas';";
$trans["popularBiblios"]           = "\$text = 'Bibliografías más populares';";
$trans["overdueList"]              = "\$text = 'Lista de socios con artículos pendientes de devolución';";
$trans["balanceDueList"]           = "\$text = 'Lista de artículos pendientes de devolución por los socios';";

#****************************************************************************
#*  Label Titles
#****************************************************************************
$trans["labelsMulti"]              = "\$text = 'Ejemplo de etiqueta múltiple';";
$trans["labelsSimple"]             = "\$text = 'Ejemplo de etiqueta simple';";

#****************************************************************************
#*  Column Text
#****************************************************************************
$trans["biblio.bibid"]             = "\$text = 'ID del registro';";
$trans["biblio.create_dt"]         = "\$text = 'Fecha de registro';";
$trans["biblio.last_change_dt"]    = "\$text = 'Modificado por última vez';";
$trans["biblio.material_cd"]       = "\$text = 'Material en Cd';";
$trans["biblio.collection_cd"]     = "\$text = 'Colección';";
$trans["biblio.call_nmbr1"]        = "\$text = 'Entrada 1';";
$trans["biblio.call_nmbr2"]        = "\$text = 'Entrada 2';";
$trans["biblio.call_nmbr3"]        = "\$text = 'Entrada 3';";
$trans["biblio.title_remainder"]   = "\$text = 'Resto de títulos';";
$trans["biblio.responsibility_stmt"] = "\$text = 'Stmt of Resp';";
$trans["biblio.opac_flg"]          = "\$text = 'OPAC Flag';";

$trans["biblio_copy.barcode_nmbr"] = "\$text = 'Código de barras';";
$trans["biblio.title"]             = "\$text = 'Título';";
$trans["biblio.author"]            = "\$text = 'Autor';";
$trans["biblio_copy.status_begin_dt"]   = "\$text = 'Fecha de comienzo de estado';";
$trans["biblio_copy.due_back_dt"]       = "\$text = 'Fecha de devolución';";
$trans["member.mbrid"]             = "\$text = 'Identificación del socio';";
$trans["member.barcode_nmbr"]      = "\$text = 'Código de barras del socio';";
$trans["member.last_name"]         = "\$text = 'Apellido';";
$trans["member.first_name"]        = "\$text = 'Nombre';";
$trans["member.address1"]          = "\$text = 'Dirección 1';";
$trans["member.address2"]          = "\$text = 'Dirección 2';";
$trans["member.city"]              = "\$text = 'Ciudad';";
$trans["member.state"]             = "\$text = 'Estado';";
$trans["member.zip"]               = "\$text = 'Código postal';";
$trans["member.zip_ext"]           = "\$text = 'Ext';";
$trans["biblio_hold.hold_begin_dt"] = "\$text = 'Fecha de préstamo';";
$trans["member.home_phone"]        = "\$text = 'Teléfono de casa';";
$trans["member.work_phone"]        = "\$text = 'Teléfono del trabajo';";
$trans["member.email"]             = "\$text = 'Email';";
$trans["member.school_grade"]      = "\$text = 'Grado';";
$trans["biblio_status_dm.description"] = "\$text = 'Estado';";
$trans["settings.library_name"]    = "\$text = 'Nombre de la biblioteca';";
$trans["settings.library_hours"]   = "\$text = 'Horario de la biblioteca ';";
$trans["settings.library_phone"]   = "\$text = 'Teléfono de la biblioteca';";
$trans["days_late"]                = "\$text = 'Días de retraso';";
$trans["title"]                    = "\$text = 'Título';";
$trans["author"]                   = "\$text = 'Autor';";
$trans["due_back_dt"]              = "\$text = 'Fecha de devolución';";
$trans["checkoutCount"]            = "\$text = 'Cuenta de préstamos';";

?>
