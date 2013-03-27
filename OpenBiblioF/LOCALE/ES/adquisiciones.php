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
$trans["indexDesc"]                = "\$text = 'Utilice el informe o lista de etiquetas situado en la zona de navegaci�n izquierda para crear informes o etiquetas.';";

#****************************************************************************
#*  Translation text for page report_list.php
#****************************************************************************
$trans["reportListHdr"]            = "\$text = 'Lista de informes';";
$trans["reportListDesc"]           = "\$text = 'Elija uno de los siguientes enlaces para realizar un informe.';";
$trans["reportListXmlErr"]         = "\$text = 'Ocurri� un error al analizar un informe xml.';";
$trans["reportListCannotRead"]     = "\$text = 'No se pudo leer la etiqueta del archivo: %fileName%';";

//  \/ MODIFICACI�N JUDITH 25/10/05 \/ 
#****************************************************************************
#*  Translation text for page report_list_siunpa.php
#****************************************************************************
$trans["reportListHdrSIUNPA"]            = "\$text = 'Informes de SIUNPA';";
$trans["reportListDescSIUNPA"]           = "\$text = 'Elija uno de los siguientes enlaces para realizar un informe.';";
//  /\ MODIFICACI�N JUDITH 25/10/05 /\     

#****************************************************************************
#*  Translation text for page label_list.php
#****************************************************************************
$trans["labelListHdr"]             = "\$text = 'Lista de etiquetas';";
$trans["labelListDesc"]            = "\$text = 'Elija uno de los siguientes enlaces para crear etiquetas en formato pdf.';";
$trans["displayLabelsXmlErr"]      = "\$text = 'Ocurri� un error al analizar un informe xml.  Error = ';";

#****************************************************************************
#*  Translation text for page letter_list.php
#****************************************************************************
$trans["letterListHdr"]            = "\$text = 'Lista de cartas';";
$trans["letterListDesc"]           = "\$text = 'Elija uno de los siguientes enlaces para crear cartas en formato pdf.';";
$trans["displayLettersXmlErr"]      = "\$text = 'Ocurri� un error al analizar un informe xml.  Error = ';";

#****************************************************************************
#*  Translation text for page report_criteria.php
#****************************************************************************
$trans["reportCriteriaHead1"]      = "\$text = 'Criterios de b�squeda de informes (opcional)';";
$trans["reportCriteriaHead2"]      = "\$text = 'Clasificaci�n de informes (opcional)';";
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
$trans["reportCriteriaOutputPDF"] = "\$text = 'PDF';";
$trans["reportCriteriaOutputCSV"]  = "\$text = 'CSV';";



#****************************************************************************
#*  Translation text for page run_report.php
#****************************************************************************
$trans["runReportReturnLink1"]     = "\$text = 'criterios de selecci�n de informes';";
$trans["runReportReturnLink2"]     = "\$text = 'lista de informes';";
$trans["runReportTotal"]           = "\$text = 'Total de filas:';";

#****************************************************************************
#*  Translation text for page display_labels.php
#****************************************************************************
$trans["displayLabelsStartOnLblErr"] = "\$text = 'El campo debe ser num�rico.';";
$trans["displayLabelsXmlErr"]      = "\$text = 'Ocurri� un error al analizar el informe xml.  Error = ';";

#****************************************************************************
#*  Translation text for page noauth.php
#****************************************************************************
$trans["noauthMsg"]                = "\$text = 'Usted no est� autorizado para la solapa de Adquisiciones.';";

#****************************************************************************
#*  Report Titles
#****************************************************************************
$trans["reportHolds"]              = "\$text = 'Reservas ';";
$trans["reportSancionados"]              = "\$text = 'Usuarios que actualmente est�n cumpliendo una sanci�n';";
$trans["reportCheckouts"]          = "\$text = 'Listado de bibliograf�a prestada';";
$trans["overdueLetters"]           = "\$text = 'Over Due Letters';";
$trans["reportLabels"]             = "\$text = 'Informaci�n sobre impresi�n de etiquetas';";
$trans["popularBiblios"]           = "\$text = 'Bibliograf�as m�s populares';";
$trans["overdueList"]              = "\$text = 'Lista de usuarios con pr�stamos retrasados';";
$trans["balanceDueList"]           = "\$text = 'Lista de art�culos pendientes de devoluci�n por los usuarios';";
$trans["prestamosAnuales"]           = "\$text = 'Listado de pr�stamos realizados anualmente';";
$trans["prestamosMensuales"]           = "\$text = 'Listado de pr�stamos realizados por per�odos mensuales';";
$trans["prestamosDiarios"]           = "\$text = 'Listado de pr�stamos diarios';";
$trans["listadoSocios"]           = "\$text = 'Listado de usuarios';";
$trans["listadoSociosPopulares"]           = "\$text = 'Listado de usuarios que registran m�s movimientos';";
$trans["M.MATERIAL"]           = "\$text = 'Material';";
$trans["M.MES"]           = "\$text = 'Mes';";
$trans["M.TIPO"]           = "\$text = 'Tipo';";


#****************************************************************************
#*  Label Titles
#****************************************************************************
$trans["labelsMulti"]              = "\$text = 'Ejemplo de etiqueta m�ltiple';";
$trans["labelsSimple"]             = "\$text = 'Ejemplo de etiqueta simple';";

#****************************************************************************
#*  Column Text
#****************************************************************************
$trans["biblio.bibid"]             = "\$text = 'ID del registro';";
$trans["biblio.create_dt"]         = "\$text = 'Registro';";
$trans["biblio.last_change_dt"]    = "\$text = 'Modificado';";
$trans["biblio.material_cd"]       = "\$text = 'Material en Cd';";
$trans["biblio.collection_cd"]     = "\$text = 'Colecci�n';";
$trans["biblio.call_nmbr1"]        = "\$text = 'Entrada 1';";
$trans["biblio.call_nmbr2"]        = "\$text = 'Entrada 2';";
$trans["biblio.call_nmbr3"]        = "\$text = 'Entrada 3';";
$trans["biblio.title_remainder"]   = "\$text = 'Resto de t�tulos';";
$trans["biblio.responsibility_stmt"] = "\$text = 'Stmt of Resp';";
$trans["biblio.opac_flg"]          = "\$text = 'OPAC';";

$trans["biblio_copy.barcode_nmbr"] = "\$text = 'Cod. barras';";
$trans["biblio.title"]             = "\$text = 'T�tulo';";
$trans["biblio.author"]            = "\$text = 'Autor';";
$trans["biblio.topic1"]            = "\$text = 'Materia';";
$trans["material_type_dm.description"]            = "\$text = 'Tipo de Material';";
$trans["collection_dm.description"]            = "\$text = 'Tipo de Colecci�n';";
$trans["biblio_copy.status_begin_dt"]   = "\$text = 'Prestado';";
$trans["status_begin_dt"]   = "\$text = 'Prestado';";
//linea agreagada: Horacio Alvarez 01-04-06
$trans["staff.last_name"]   = "\$text = 'Operador';";
//linea agreagada: Horacio Alvarez 01-04-06
$trans["staff.usuario"]   = "\$text = 'Operador';";
$trans["biblio_copy.due_back_dt"]       = "\$text = 'Devoluci�n';";
$trans["member.mbrid"]             = "\$text = 'ID';";
$trans["member.barcode_nmbr"]      = "\$text = 'DNI';";
$trans["member.last_name"]         = "\$text = 'Apellido';";
$trans["member.first_name"]        = "\$text = 'Nombre';";
$trans["member.fecha_suspension"]        = "\$text = 'Vence';";
$trans["member.tipo_sancion_cd"]        = "\$text = 'Nro. de Infracci�n';";
$trans["member.address1"]          = "\$text = 'Direcci�n 1';";
$trans["member.address2"]          = "\$text = 'Direcci�n 2';";
$trans["member.city"]              = "\$text = 'Ciudad';";
$trans["member.state"]             = "\$text = 'Estado';";
$trans["member.zip"]               = "\$text = 'C�digo postal';";
$trans["member.zip_ext"]           = "\$text = 'Ext';";
$trans["biblio_hold.hold_begin_dt"] = "\$text = 'Fecha de pr�stamo';";
$trans["hold_begin_dt"] = "\$text = 'Fecha de pr�stamo';";
$trans["member.home_phone"]        = "\$text = 'Tel�fono';";
$trans["member.work_phone"]        = "\$text = 'Tel�fono del trabajo';";
$trans["member.email"]             = "\$text = 'Email';";
$trans["member.school_grade"]      = "\$text = 'Grado';";
$trans["biblio_status_dm.description"] = "\$text = 'Estado';";
$trans["settings.library_name"]    = "\$text = 'Biblioteca';";
$trans["settings.library_hours"]   = "\$text = 'Horario de la biblioteca ';";
$trans["settings.library_phone"]   = "\$text = 'Tel�fono';";
$trans["days_late"]                = "\$text = 'Retraso';";
$trans["title"]                    = "\$text = 'T�tulo';";
$trans["author"]                   = "\$text = 'Autor';";
$trans["due_back_dt"]              = "\$text = 'Fecha de devoluci�n';";
$trans["checkoutCount"]            = "\$text = 'Cuenta de pr�stamos';";
$trans["prestado"]            = "\$text = 'Prestado';";
$trans["C.barcode_nmbr"]            = "\$text = 'Cod. Barra';";
$trans["m.barcode_nmbr"]            = "\$text = 'Dni';";
$trans["s.last_name"]            = "\$text = 'Operador';";
$trans["h.status_begin_dt"]            = "\$text = 'Devuelto';";
$trans["(greatest(0,to_days(sysdate())-to_days(biblio_copy.due_back_dt)))"]   = "\$text = 'D�as Retraso';";
$trans["B.title"]            = "\$text = 'T�tulo';";
$trans["B.author"]            = "\$text = 'Autor';";
$trans["B.topic1"]            = "\$text = 'Materia';";
$trans["T.description"]            = "\$text = 'Material';";
$trans["CD.description"]            = "\$text = 'Colecci�n';";
$trans["M.first_name"]            = "\$text = 'Nombre';";
$trans["M.last_name"]            = "\$text = 'Apellido';";
$trans["M.barcode_nmbr"]            = "\$text = 'D.N.I';";
$trans["S.last_name"]            = "\$text = 'Operador';";
$trans["M.address1"]            = "\$text = 'Direcci�n';";
$trans["M.city"]            = "\$text = 'Ciudad';";
$trans["M.home_phone"]            = "\$text = 'Telefono';";
$trans["M.email"]            = "\$text = 'Email';";
$trans["C.description"]            = "\$text = 'Clasificaci�n';";
$trans["L.description"]            = "\$text = 'Biblioteca';";
$trans["L.code"]            = "\$text = 'Biblioteca';";

//  \/ MODIFICACI�N JUDITH 25/10/05 \/ 
#****************************************************************************
#*  Translation text for page list_biblios_run.php
#****************************************************************************
$trans["reportbibliosSiunpaHead1"]            = "\$text = 'Informes de materiales ordenados por fecha de creaci&oacute;n';";
$trans["reportListDescSIUNPA"]           = "\$text = 'Elija uno de los siguientes enlaces para realizar un informe.';";

#****************************************************************************
#* report_list_siunpa
#****************************************************************************
$trans["reportSiunpaHead1"]             = "\$text = 'Listado de materiales';";
$trans["reportSiunpaHead2"]             = "\$text = 'Listado de ejemplares';";
$trans["reportSiunpaHead3"]             = "\$text = 'Listado de aprobaciones';";
$trans["reportSiunpaHead4"]             = "\$text = 'Prestamos Anuales de Material bibliogr�fico';";
$trans["reportSiunpaHead5"]             = "\$text = 'Prestamos Cuatrimestrales de Material bibliogr�fico';";
$trans["reportSiunpaHead6"]             = "\$text = 'Prestamos Mensuales de Material bibliogr�fico';";
$trans["reportSiunpaHead7"]             = "\$text = 'Listados de Usuarios';";
$trans["reportSiunpaHead3-1"]           = "\$text = 'de Materiales';";
$trans["reportSiunpaHead3-2"]           = "\$text = 'de Ejemplares';";

#****************************************************************************
#*  Translation text for page run_report.php
#****************************************************************************
$trans["runReportListReturnLink1"]     = "\$text = 'Selecci�n de fecha';";
$trans["runReportListReturnLink2"]	   = "\$text = 'lista de informes';";
$trans["runReportTotal"]      	       = "\$text = 'Total de filas:';";

#****************************************************************************
#* report_list_siunpa . display_report_ .....
#****************************************************************************
$trans["reportSiunpaHead1"]             = "\$text = 'Listado de materiales';";
$trans["reportSiunpaHead2"]             = "\$text = 'Listado de ejemplares';";
$trans["reportSiunpaHead3"]             = "\$text = 'Listado de aprobaciones';";
$trans["reportSiunpaHead3-1"]           = "\$text = 'de Materiales';";
$trans["reportSiunpaHead3-2"]           = "\$text = 'de Ejemplares';";
$trans["biblioSearchListResults"]     	= "\$text = 'Resultados de la b�squeda';";
$trans["biblioSearchListNoResults"]     = "\$text = 'No se han encontrado registros.';";
$trans["biblioSearchListResultPages"]  = "\$text = 'P�ginas de resultados';";
$trans["biblioSearchListPrev"]         = "\$text = 'anterior';";
$trans["biblioSearchListNext"]         = "\$text = 'siguiente';";
$trans["biblioSearchListResultTxt"]    	= "if (%itemsl% == 1) {
                                        \$text = '%itemsl% resultado encontrado.';
	                                      } else {
    	                                    \$text = '%itemsl% resultados encontrados';
        	                              }";

#****************************************************************************
#* Titles: list_new_biblios . list_new_copy . list_new_aprobs
#****************************************************************************
$trans["reportSiunpaListDesc"]    	= "\$text = 'Seleccione una fecha';";
$trans["reportTitleHead1"]      	= "\$text = 'Fechas de b�squeda de informes';";
$trans["reportTitleBegin"]      	= "\$text = 'Desde';";
$trans["reportTitleEnd"]    	  	= "\$text = 'Hasta';";
$trans["c.barcode_nmbr"]    	  	= "\$text = 'Cod. Barras';";
$trans["b.title"]    	  	= "\$text = 'T�tulo';";
$trans["m.last_name"]    	  	= "\$text = 'Apellido';";
$trans["m.first_name"]    	  	= "\$text = 'Nombre';";
$trans["m.dni"]    	  	= "\$text = 'DNI';";
$trans["s.operador"]    	  	= "\$text = 'Operador';";
$trans["devuelto"]    	  	= "\$text = 'Devuelto';";
$trans["b.author"]    	  	= "\$text = 'Autor';";

#****************************************************************************
#*  Translation text for page mbr_new_form.php, mbr_edit_form.php and mbr_fields.php
#****************************************************************************
$trans["mbrNewForm"]              = "\$text='A�adir nuevo';";
$trans["mbrEditForm"]             = "\$text='Editar';";
$trans["mbrFldsHeader"]           = "\$text='Docente:';";
$trans["mbrFldsCardNmbr"]         = "\$text='DNI:';";
$trans["mbrFldsLastName"]         = "\$text='Apellido:';";
$trans["mbrFldsFirstName"]        = "\$text='Nombre:';";
//DOS LINEAS MODIFICADAS: Horacio Alvarez FECHA: 24-03-06
$trans["mbrFldsAddr1"]            = "\$text='Direcci�n Particular:';";
$trans["mbrFldsAddr2"]            = "\$text='Direcci�n Laboral:';";
$trans["mbrFldsCity"]             = "\$text='Ciudad:';";
$trans["mbrFldsStateZip"]         = "\$text='Provincia, C�digo postal:';";
//LINEA AGREGADA: Horacio Alvarez FECHA: 24-03-06
$trans["mbrFldsLibraryid"]         = "\$text='Biblioteca:';";
//LINEA AGREGADA: Horacio Alvarez FECHA: 26-03-06
$trans["mbrFldsLimitePrestamos"]         = "\$text='L�mite de Pr�stamos:';";
//LINEA AGREGADA: Horacio Alvarez FECHA: 08-04-06
$trans["mbrFldsLimiteReservas"]         = "\$text='L�mite de Reservas:';";
$trans["mbrFldsHomePhone"]        = "\$text='Tel�fono:';";
$trans["mbrFldsWorkPhone"]        = "\$text='Tel�fono trabajo:';";
$trans["mbrFldsEmail"]            = "\$text='Email:';";
$trans["mbrFldsClassify"]         = "\$text='Clasificaci�n:';";
$trans["mbrFldsCarrera"]         = "\$text='Carrera:';";
$trans["mbrFldsTipoSancion"]         = "\$text='Tipo de Sanci�n:';";
$trans["mbrFldsGrade"]            = "\$text='Curso:';";
$trans["mbrFldsTeacher"]          = "\$text='Tutor:';";
$trans["mbrFldsObservaciones"]          = "\$text='Observaciones:';";
$trans["mbrFldsLimpiar"]          = "\$text='Limpiar Ultima Sanci�n:';";
$trans["mbrFldsSanciones"]          = "\$text='Usted registra:';";
$trans["mbrFldsSubmit"]           = "\$text='Enviar';";
$trans["mbrFldsCancel"]           = "\$text='Cancelar';";
$trans["mbrsearchResult"]         = "\$text='P�ginas de resultados: ';";
$trans["mbrsearchprev"]           = "\$text='ant';";
$trans["mbrsearchnext"]           = "\$text='sig';";
$trans["mbrsearchNoResults"]      = "\$text='No se encontr� registros.';";
$trans["mbrsearchFoundResults"]   = "\$text=' registros encontrados.';";
$trans["mbrsearchSearchResults"]  = "\$text='Resultados de la b�squeda:';";
$trans["mbrsearchCardNumber"]     = "\$text='DNI:';";
$trans["mbrsearchClassification"] = "\$text='Clasificaci�n:';";
$trans["mbrFechaVto"] = "\$text='Fecha Vencimiento:';";
$trans["mbrFechaSuspension"] = "\$text='Fecha Suspensi�n:';";

#****************************************************************************
#*  Common translation text shared among multiple pages
#****************************************************************************
$trans["circCancel"]              = "\$text = 'Cancelar';";
$trans["circDelete"]              = "\$text = 'Borrar';";
$trans["circLogout"]              = "\$text = 'Salir';";
$trans["circAdd"]                 = "\$text = 'A�adir';";
$trans["mbrDupBarcode"]           = "\$text = 'C�digo de barras, %barcode%, ya est� utilizado.';";

#****************************************************************************
#*  Translation text for page mbr_del_confirm.php
#****************************************************************************
$trans["mbrDelConfirmWarn"]       = "\$text = 'El usuario, %name%, tiene %checkoutCount% pr�stamos y %holdCount% reservas.  Todos los materiales prestados beben ser devueltos y todas las reservas borradas antes de borrar a este usuario.';";
$trans["mbrDelConfirmReturn"]     = "\$text = 'Volver a la informaci�n del usuario';";
$trans["mbrDelConfirmMsg"]        = "\$text = 'Est�s seguro de que quieres borrar al docente, %name%?  Esto tambi�n borrar� las adquisiciones del mismo.';";

#****************************************************************************
#*  Translation text for page mbr_del.php
#****************************************************************************
$trans["mbrDelSuccess"]           = "\$text='Docente, %name%, borrado.';";
$trans["mbrDelReturn"]            = "\$text='Volver al listado de Docentes';";

$trans["adquisicion.adqid"]            = "\$text = 'Nro.';";
$trans["adquisicion.title"]            = "\$text = 'T�tulo';";
$trans["adquisicion.author"]            = "\$text = 'Autor';";
$trans["isbn"]            = "\$text = 'I.S.B.N';";
$trans["edicion_dt"]            = "\$text = 'Editado';";
$trans["editorial"]            = "\$text = 'Editorial';";
$trans["ejemplares"]            = "\$text = 'Cant.';";
$trans["observacion"]            = "\$text = 'Observaci�n';";
$trans["created_dt"]            = "\$text = 'Creado';";
$trans["concepto_dm.description"]            = "\$text = 'Concepto';";
$trans["area_dm.description"]            = "\$text = 'Area';";
$trans["biblio_cod_library.description"]            = "\$text = 'Biblioteca';";
$trans["estado_dm.description"]            = "\$text = 'Estado';";

?>
