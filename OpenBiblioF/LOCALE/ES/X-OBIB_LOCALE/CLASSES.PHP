<?php
/**********************************************************************************
 *   Copyright(C) 2002, 2003, 2004 David Stevens
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
#*  Translation text for class Biblio
#****************************************************************************
$trans["biblioError1"]            = "\$text = 'Número de llamada requerido.';";
$trans["biblioDateError"]            = "\$text = 'Fecha Incorrecta.';";

#****************************************************************************
#*  Translation text for class BiblioField
#****************************************************************************
$trans["biblioFieldError1"]       = "\$text = 'Campo requerido.';";
$trans["biblioFieldError2"]       = "\$text = 'La etiqueta debe ser numérica.';";

#****************************************************************************
#*  Translation text for class BiblioQuery
#****************************************************************************
$trans["biblioQueryQueryErr1"]    = "\$text = 'Error al acceder a la información bibliográfica.';";
$trans["biblioQueryQueryErr2"]    = "\$text = 'Error al acceder al campo de información bibliográfica.';";
$trans["biblioQueryInsertErr1"]   = "\$text = 'Error al insertar nueva información bibliográfica.';";
$trans["biblioQueryInsertErr2"]   = "\$text = 'Error al insertar nuevo campo de información bibliográfica.';";
$trans["biblioQueryUpdateErr1"]   = "\$text = 'Error al actualizar la información bibliográfica.';";
$trans["biblioQueryUpdateErr2"]   = "\$text = 'Error al limpiar el campo de información bibliográfica para actualizarlo.';";
$trans["biblioQueryDeleteErr"]    = "\$text = 'Error al borrar la información bibliográfica.';";
$trans["biblioQueryErr3"]     = "\$text = 'La signatura %callNmbr1% ya está en uso.';";

#****************************************************************************
#*  Translation text for class BiblioSearchQuery
#****************************************************************************
$trans["biblioSearchQueryErr1"]   = "\$text = 'Error al contar los resultados de búsqueda bibliográfica.';";
$trans["biblioSearchQueryErr2"]   = "\$text = 'Error al buscar información bibliográfica.';";
$trans["biblioSearchQueryErr3"]   = "\$text = 'Error al leer la información bibliográfica.';";

#****************************************************************************
#*  Translation text for class BiblioCopy
#****************************************************************************
$trans["biblioCopyError1"]        = "\$text = 'Número de código de barras requerido.';";
$trans["biblioCopyError2"]        = "\$text = 'El código de barras debe ser totalmente alfabético y/o numérico.';";
$trans["biblioCopyError3"]        = "\$text = 'El Precio Actual debe ser totalmente numérico.';";

#****************************************************************************
#*  Translation text for class BiblioCopyQuery
#****************************************************************************
$trans["biblioCopyQueryErr1"]     = "\$text = 'Error al comprobar el código de barras.';";
$trans["biblioCopyQueryErr2"]     = "\$text = 'El código de barras %barcodeNmbr% ya está en uso.';";
$trans["biblioCopyQueryErr3"]     = "\$text = 'Error al insertar nueva copia de la información bibliográfica.';";
$trans["biblioCopyQueryErr4"]     = "\$text = 'Error al acceder a la copia de la información bibliográfica.';";
$trans["biblioCopyQueryErr5"]     = "\$text = 'Error al actualizar la copia de información bibliográfica.';";
$trans["biblioCopyQueryErr6"]     = "\$text = 'Error al borrar la información bibliográfica.';";
$trans["biblioCopyQueryErr7"]     = "\$text = 'Error al acceder a la información bibliográfica para obtener el código de la colección.';";
$trans["biblioCopyQueryErr8"]     = "\$text = 'Error al acceder a la información de la colección para comprobar la fecha de devolución.';";
$trans["biblioCopyQueryErr9"]     = "\$text = 'Ocurrió un error al registrar las copias';";
$trans["biblioCopyQueryErr10"]    = "\$text = 'Ocurrió un error al comprobar los límites de préstamo';";

#****************************************************************************
#*  Translation text for class BiblioFieldQuery
#****************************************************************************
$trans["biblioFieldQueryErr1"]    = "\$text = 'Error al hacer la lectura de un campo bibliográfico.';";
$trans["biblioFieldQueryErr2"]    = "\$text = 'Error al leer los campos bibliográficos.';";
$trans["biblioFieldQueryInsertErr"] = "\$text = 'Error al insertar un nuevo campo bibliográfico.';";
$trans["biblioFieldQueryUpdateErr"] = "\$text = 'Error al actualizar un campo bibliográfico.';";
$trans["biblioFieldQueryDeleteErr"] = "\$text = 'Error al borrar un campo bibliográfico.';";

#****************************************************************************
#*  Translation text for class UsmarcBlockDmQuery
#****************************************************************************
$trans["usmarcBlockDmQueryErr1"]  = "\$text = 'Error al acceder a los datos del bloque marc.';";

#****************************************************************************
#*  Translation text for class UsmarcTagDmQuery
#****************************************************************************
$trans["usmarcTagDmQueryErr1"]    = "\$text = 'Error al acceder a la etiqueta de datos marc.';";

#****************************************************************************
#*  Translation text for class UsmarcSubfieldDmQuery
#****************************************************************************
$trans["usmarcSubfldDmQueryErr1"] = "\$text = 'Error al acceder al subcampo de datos marc.';";

#****************************************************************************
#*  Translation text for class BiblioHoldQuery
#****************************************************************************
$trans["biblioHoldQueryErr1"]     = "\$text = 'Error al acceder a los datos de préstamo por parte de la identificación bibliográfica.';";
$trans["biblioHoldQueryErr2"]     = "\$text = 'Error al acceder a los datos de préstamo por parte de un socio.';";
$trans["biblioHoldQueryErr3"]     = "\$text = 'Error al obtener identificación bibliográfica e identificación de copia para realizar una solicitud de préstamo.';";
$trans["biblioHoldQueryErr4"]     = "\$text = 'Error al insertar los datos de préstamo.';";
$trans["biblioHoldQueryErr5"]     = "\$text = 'Error al borrar los datos de préstamo.';";
$trans["biblioHoldQueryErr6"]     = "\$text = 'Error al obtener el socio que ha realizado la reserva para hacer una copia.';";

#****************************************************************************
#*  Translation text for class ReportQuery
#****************************************************************************
$trans["reportQueryErr1"]         = "\$text = 'Error al llevar a cabo el informe.';";

#****************************************************************************
#*  Translation text for class ReportCriteria
#****************************************************************************
$trans["reportCriteriaErr1"]      = "\$text = 'Un valor no numérico no es válido en una columna numérica.';";
$trans["reportCriteriaDateTimeErr"] = "\$text = 'Formato de fecha y hora no válido.';";
$trans["reportCriteriaDateErr"]   = "\$text = 'Formato de fecha no válido.';";

#****************************************************************************
#*  Translation text for class LabelFormat and LetterFormat
#****************************************************************************
$trans["labelFormatFontErr"]      = "\$text = 'Tipo de fuente no válido  xml.  Los tipos de fuente válidos son Courier, Helvetica, y Times-Roman.';";
$trans["labelFormatFontSizeErr"]  = "\$text = 'Tamaño de fuente no válido  xml.  El tamaño de la fuente debe ser numérico.';";
$trans["labelFormatFontSizeErr2"] = "\$text = 'Tamaño de fuente no válido  xml.  El tamaño de la fuente debe ser mayor de cero.';";
$trans["labelFormatLMarginErr"]   = "\$text = 'Margen izquierdo no válido  xml.  El margen izquierdo debe ser numériico.';";
$trans["labelFormatLMarginErr2"]  = "\$text = 'Margen izquierdo no válido  xml.  El margen izquierdo debe ser mayor de cero.';";
$trans["labelFormatRMarginErr"]   = "\$text = 'Margen derecho no válido  xml.  El margen derecho debe ser numérico.';";
$trans["labelFormatRMarginErr2"]  = "\$text = 'Margen derecho no válido  xml.  El margen derecho debe ser mayor de cero.';";
$trans["labelFormatTMarginErr"]   = "\$text = 'Margen superior no válido  xml.  El margen superior debe ser numérico.';";
$trans["labelFormatTMarginErr2"]  = "\$text = 'Margen superior no válido  xml.  El margen superior debe ser mayor de cero.';";
$trans["labelFormatBMarginErr"]   = "\$text = 'Margen inferior no válido  xml.  El margen inferior debe ser numérico.';";
$trans["labelFormatBMarginErr2"]  = "\$text = 'Margen inferior no válido  xml.  El margen inferior debe ser mayor de cero.';";
$trans["labelFormatColErr"]       = "\$text = 'Columnas no válidas xml.  Las columnas deben ser numéricas.';";
$trans["labelFormatColErr2"]      = "\$text = 'Columnas no válidas xml.  Las columnas deben ser mayores de cero.';";
$trans["labelFormatWidthErr"]     = "\$text = 'Ancho de página no válido xml.  El ancho de página debe ser numérico.';";
$trans["labelFormatWidthErr2"]    = "\$text = 'Ancho de página no válido xml.  El ancho de página debe ser mayor de cero.';";
$trans["labelFormatHeightErr"]    = "\$text = 'Altura de página no válida xml.  La altura de página debe ser numérica.';";
$trans["labelFormatHeightErr2"]   = "\$text = 'Altura de página no válida xml.  La altura de página debe ser mayor de cero.';";
$trans["labelFormatNoLabelsErr"]  = "\$text = 'Líneas no válidas xml.';";

#****************************************************************************
#*  Translation text for class BiblioStatusHistQuery
#****************************************************************************
$trans["biblioStatusHistQueryErr1"] = "\$text = 'Error al obtener el estado del historial bibliográfico.';";
$trans["biblioStatusHistQueryErr2"] = "\$text = 'Error al obtener elestado del historial bibliográfico por parte del socio';";
$trans["biblioStatusHistQueryErr3"] = "\$text = 'Error al insertar el estado del historial bibliográfico';";
$trans["biblioStatusHistQueryErr4"] = "\$text = 'Error al borrar el estado del historial';";
$trans["biblioStatusHistQueryErr5"] = "\$text = 'Error al borrar el estado del historial bibliográfico por parte de un socio';";

#****************************************************************************
#*  Translation text for class MemberAccountTransaction
#****************************************************************************
$trans["memberAccountTransError1"]  = "\$text = 'Cantidad requerida.';";
$trans["memberAccountTransError2"]  = "\$text = 'La cantidad debe ser numérica.';";
$trans["memberAccountTransError3"]  = "\$text = 'Descripción requerida.';";

#****************************************************************************
#*  Translation text for class MemberAccountQuery
#****************************************************************************
$trans["memberAccountQueryErr1"]    = "\$text = 'Error al acceder a la información de la cuenta del socio.';";
$trans["memberAccountQueryErr2"]    = "\$text = 'Error al insertar la información de la cuenta del socio.';";
$trans["memberAccountQueryErr3"]    = "\$text = 'Error al borrar la información de la cuenta del socio.';";

#****************************************************************************
#*  Translation text for class BiblioAnalitica
#****************************************************************************
$trans["biblioAnaliticaError1"]        = "\$text = 'Campo requerido.';";


?>