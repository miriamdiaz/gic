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
#*  Translation text for page index.php
#****************************************************************************
$trans["opac_Header"]        = "\$text='Catálogo de acceso público online (OPAC)';";
$trans["opac_WelcomeMsg"]    = "\$text=
  'Bienvenido a nuestro acceso público online de nuestra biblioteca. Busca en nuestro catálogo.';";
$trans["opac_SearchTitle"]   = "\$text='Buscar bibliografía por frase de búsqueda:';";
$trans["opac_Title"]         = "\$text='Título';";
$trans["opac_Author"]        = "\$text='Autor';";
$trans["opac_AuthorAnalitica"]        = "\$text='Autor o Autor de Analítica';";
$trans["opac_Subject"]       = "\$text='Materia';";
$trans["opac_Search"]        = "\$text='Buscar';";
// AGREGÓ JUDITH 21-03-06
$trans["opac_Signatura"]       = "\$text='Signatura';";
$trans["opac_Material"]       = "\$text='Tipo de material';";
$trans["opac_Isbn"]       = "\$text='ISBN';";
$trans["opac_autor_corporativo"]       = "\$text='Autor Corporativo';";
$trans["opac_BarcodeHdr"]       = "\$text='Buscar bibliografía por código de barras';";
$trans["opac_BarcodeField"]       = "\$text='Código de barras';";
$trans["admin_materials_code"]       = "\$text='Código';";
$trans["admin_materials_listDescription"]       = "\$text='Descripción';";
$trans["admin_tipo_de_material"]       = "\$text='Tipo de material';";

?>
