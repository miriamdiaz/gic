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
#*  Common translation text shared among multiple pages
#****************************************************************************
$trans["catalogSubmit"]            = "\$text = 'Submit';";
$trans["catalogCancel"]            = "\$text = 'Cancel';";
$trans["catalogRefresh"]           = "\$text = 'Refresh';";
$trans["catalogDelete"]            = "\$text = 'Delete';";
$trans["catalogFootnote"]          = "\$text = 'Fields marked with %symbol% are required.';";
$trans["AnswerYes"]                = "\$text = 'Si';";
$trans["AnswerNo"]                 = "\$text = 'No';";

#****************************************************************************
#*  Translation text for page index.php
#****************************************************************************
$trans["indexHdr"]                 = "\$text = 'Catalogaci�n';";
$trans["indexBarcodeHdr"]          = "\$text = 'Buscar bibliograf�a por c�digo de barras';";
$trans["indexBarcodeField"]        = "\$text = 'C�digo de barras';";
$trans["indexSearchHdr"]           = "\$text = 'Buscar bibliograf�a por frase de b�squeda';";
$trans["indexTitle"]               = "\$text = 'T�tulo';";
$trans["indexAuthor"]              = "\$text = 'Autor';";
$trans["indexSubject"]             = "\$text = 'Resumen';";
$trans["indexButton"]              = "\$text = 'Buscar';";

#****************************************************************************
#*  Translation text for page biblio_new_form.php
#****************************************************************************
$trans["biblioNewFormLabel"]       = "\$text = 'A�adir nuevo';";

#****************************************************************************
#*  Translation text for page biblio_fields.php
#****************************************************************************
$trans["biblioFieldsLabel"]        = "\$text = 'Bibliograf�a';";
$trans["biblioFieldsMaterialTyp"]  = "\$text = 'Tipo de material';";
$trans["biblioFieldsCollection"]   = "\$text = 'Colecci�n';";
$trans["biblioFieldsCallNmbr"]     = "\$text = 'N�mero de entrada';";
$trans["biblioFieldsUsmarcFields"] = "\$text = 'Campos USMarc';";
$trans["biblioFieldsOpacFlg"]      = "\$text = 'Mostrar en OPAC';";
$trans["biblioFieldsIndex"]      = "\$text = 'Indice';";

#****************************************************************************
#*  Translation text for page biblio_new.php
#****************************************************************************
$trans["biblioNewSuccess"]         = "\$text = 'Se ha creado la siguiente nueva bibliograf�a.  Para a�adir una copia, seleccione \"Nueva copia\" del navegador de la izquierda o \"a�adir nueva copia\" de la informaci�n de copia de abajo.';";

#****************************************************************************
#*  Translation text for page biblio_edit.php
#****************************************************************************
$trans["biblioEditSuccess"]        = "\$text = 'Datos de libro actualizados correctamente.';";

#****************************************************************************
#*  Translation text for page biblio_copy_new_form.php and biblio_copy_edit_form.php
#****************************************************************************
$trans["biblioCopyNewFormLabel"]   = "\$text = 'A�adir nueva copia';";
$trans["biblioCopyNewBarcode"]     = "\$text = 'C�digo de barras';";
$trans["biblioCopyNewDesc"]        = "\$text = 'Descripci�n';";
$trans["biblioCopyEditFormLabel"]  = "\$text = 'Editar copia';";
$trans["biblioCopyEditFormStatus"] = "\$text = 'Estado';";

#****************************************************************************
#*  Translation text for page biblio_copy_new.php
#****************************************************************************
$trans["biblioCopyNewSuccess"]     = "\$text = 'Copia creada correctamente.';";

#****************************************************************************
#*  Translation text for page biblio_copy_edit.php
#****************************************************************************
$trans["biblioCopyEditSuccess"]    = "\$text = 'Copia actualizada correctamente.';";

#****************************************************************************
#*  Translation text for page biblio_copy_del_confirm.php
#****************************************************************************
$trans["biblioCopyDelConfirmErr1"] = "\$text = 'No se pudo borrar la copia.  Una copia debe estar registrada antes de que pueda ser borrada.';";
$trans["biblioCopyDelConfirmMsg"]  = "\$text = 'Est�s seguro de que quieres borrar la copia con c�digo de barras %barcodeNmbr%?  Esto tambi�n borrar� todos los cambios en el status del historial de esta copia.';";

#****************************************************************************
#*  Translation text for page biblio_copy_del.php
#****************************************************************************
$trans["biblioCopyDelSuccess"]     = "\$text = 'Copia con c�digo de barras %barcode% borrada correctamente.';";

#****************************************************************************
#*  Translation text for page biblio_marc_list.php
#****************************************************************************
$trans["biblioMarcListMarcSelect"] = "\$text = 'A�adir nuevo campo MARC';";
$trans["biblioMarcListHdr"]        = "\$text = 'Informaci�n del campo MARC';";
$trans["biblioMarcListTbleCol1"]   = "\$text = 'Funci�n';";
$trans["biblioMarcListTbleCol2"]   = "\$text = 'Etiqueta';";
$trans["biblioMarcListTbleCol3"]   = "\$text = 'Descripci�n de la etiqueta';";
$trans["biblioMarcListTbleCol4"]   = "\$text = 'Ind 1';";
$trans["biblioMarcListTbleCol5"]   = "\$text = 'Ind 2';";
$trans["biblioMarcListTbleCol6"]   = "\$text = 'Subcampo';";
$trans["biblioMarcListTbleCol7"]   = "\$text = 'Descripci�n del subcampo';";
$trans["biblioMarcListTbleCol8"]   = "\$text = 'Datos del campo';";
$trans["biblioMarcListNoRows"]     = "\$text = 'No se encontraron campos de MARC.';";
$trans["biblioMarcListEdit"]       = "\$text = 'Editar';";
$trans["biblioMarcListDel"]        = "\$text = 'Eliminar';";

#****************************************************************************
#*  Translation text for page usmarc_select.php
#****************************************************************************
$trans["usmarcSelectHdr"]          = "\$text = 'Selector de campo MARC';";
$trans["usmarcSelectInst"]         = "\$text = 'Seleccione un tipo de campo';";
$trans["usmarcSelectNoTags"]       = "\$text = 'No se encontraron etiquetas.';";
$trans["usmarcSelectUse"]          = "\$text = 'uso';";
$trans["usmarcCloseWindow"]        = "\$text = 'Cerrar Ventana';";

#****************************************************************************
#*  Translation text for page biblio_marc_new_form.php
#****************************************************************************
$trans["biblioMarcNewFormHdr"]     = "\$text = 'A�adir nuevo campo MARC';";
$trans["biblioMarcNewFormTag"]     = "\$text = 'Etiqueta';";
$trans["biblioMarcNewFormSubfld"]  = "\$text = 'Subcampo';";
$trans["biblioMarcNewFormData"]    = "\$text = 'Datos del campo';";
$trans["biblioMarcNewFormInd1"]    = "\$text = 'Indicador 1';";
$trans["biblioMarcNewFormInd2"]    = "\$text = 'Indicador 2';";
$trans["biblioMarcNewFormSelect"]  = "\$text = 'Seleccionar';";

#****************************************************************************
#*  Translation text for page biblio_marc_new.php
#****************************************************************************
$trans["biblioMarcNewSuccess"]     = "\$text = 'Campo MARC a�adido correctamente.';";

#****************************************************************************
#*  Translation text for page biblio_marc_edit_form.php
#****************************************************************************
$trans["biblioMarcEditFormHdr"]    = "\$text = 'Editar campo MARC';";

#****************************************************************************
#*  Translation text for page biblio_marc_edit.php
#****************************************************************************
$trans["biblioMarcEditSuccess"]    = "\$text = 'Campo MARC actualizado correctamente.';";

#****************************************************************************
#*  Translation text for page biblio_marc_del_confirm.php
#****************************************************************************
$trans["biblioMarcDelConfirmMsg"]  = "\$text = 'Est�s seguro de que quieres borrar el campo con etiqueta %tag% y el subcampo %subfieldCd%?';";

#****************************************************************************
#*  Translation text for page biblio_marc_del.php
#****************************************************************************
$trans["biblioMarcDelSuccess"]     = "\$text = 'Campo MARC borrado correctamente.';";

#****************************************************************************
#*  Translation text for page biblio_del_confirm.php
#****************************************************************************
$trans["biblioDelConfirmWarn"]     = "\$text = 'Esta bibliograf�a tiene copia(s) %copyCount%  y solicitudes de pr�stamo %holdCount%.  Por favor borre estas copias y/o peticiones de uso antes de borrar esta bibliograf�a.';";
$trans["biblioDelConfirmReturn"]   = "\$text = 'volver a la informaci�n bibliogr�fica';";
$trans["biblioDelConfirmMsg"]      = "\$text = 'Est�s seguro de que quieres borrar la bibliograf�a titulada %title%?';";

#****************************************************************************
#*  Translation text for page biblio_del_confirm.php
#****************************************************************************
$trans["biblioDelMsg"]             = "\$text = 'La bibliograf�a, %title%, ha sido borrada.';";
$trans["biblioDelReturn"]          = "\$text = 'volver a la b�squeda bibliogr�fica';";

#****************************************************************************
#*  Translation text for page biblio_hold_list.php
#****************************************************************************
$trans["biblioHoldListHead"]       = "\$text = 'Splicitudes de pr�stamo de la bibliograf�a:';";
$trans["biblioHoldListNoHolds"]    = "\$text = 'Actualmente no hay copias de la bibliograf�a en uso.';";
$trans["biblioHoldListHdr1"]       = "\$text = 'Funci�n';";
$trans["biblioHoldListHdr2"]       = "\$text = 'Copia';";
$trans["biblioHoldListHdr3"]       = "\$text = 'Prestado';";
$trans["biblioHoldListHdr4"]       = "\$text = 'Socio';";
$trans["biblioHoldListHdr5"]       = "\$text = 'Estado';";
$trans["biblioHoldListHdr6"]       = "\$text = 'Fecha de devoluci�n';";
$trans["biblioHoldListdel"]        = "\$text = 'Eliminar';";

#****************************************************************************
#*  Translation text for page noauth.php
#****************************************************************************
$trans["NotAuth"]                 = "\$text = 'No tienes permiso de catalogaci�n';";

#****************************************************************************
#*  Translation text for page upload_usmarc.php and upload_usmarc_form.php
#****************************************************************************
$trans["MarcUploadTest"]            = "\$text = 'Carga del test';";
$trans["MarcUploadTestTrue"]        = "\$text = 'Verdadero';";
$trans["MarcUploadTestFalse"]       = "\$text = 'Falso';";
$trans["MarcUploadTestFileUpload"]  = "\$text = 'Entrada de archivo USMarc';";
$trans["MarcUploadRecordsUploaded"] = "\$text = 'Documentos transferidos';";
$trans["MarcUploadMarcRecord"]      = "\$text = 'Documento MARC';";
$trans["MarcUploadTag"]             = "\$text = 'Etiqueta';";
$trans["MarcUploadSubfield"]        = "\$text = 'Sub';";
$trans["MarcUploadData"]            = "\$text = 'Datos';";
$trans["MarcUploadRawData"]         = "\$text = 'Datos en bruto:';";
$trans["UploadFile"]                = "\$text = 'Subir archivo';";

#****************************************************************************
#*  Translation text for page usmarc_select.php
#****************************************************************************
$trans["PoweredByOB"]                 = "\$text = 'OpenBiblio';";
$trans["Copyright"]                   = "\$text = 'Copyright &copy; 2002';";
$trans["underthe"]                    = "\$text = 'bajo';";
$trans["GNU"]                 = "\$text = 'GNU General Public License';";

$trans["catalogResults"]                 = "\$text = 'Resultados de b�squeda';";



?>
