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
#*  Translation text shared by various php files under the navbars dir
#****************************************************************************
$trans["login"]                    = "\$text = 'Entrar';";
$trans["logout"]                   = "\$text = 'Salir';";
$trans["help"]                     = "\$text = 'Ayuda';";

#****************************************************************************
#*  Translation text for page home.php
#****************************************************************************
$trans["homeHomeLink"]             = "\$text = 'Inicio';";
$trans["homeLicenseLink"]          = "\$text = 'Licencia';";

#****************************************************************************
#*  Translation text for page admin.php
#****************************************************************************
$trans["adminSummary"]             = "\$text = 'Administración';";
$trans["adminStaff"]               = "\$text = 'Admin. bibliotecarios';";
$trans["adminSettings"]            = "\$text = 'Config. biblioteca';";
$trans["adminMaterialTypes"]       = "\$text = 'Tipos de material';";
$trans["adminCollections"]         = "\$text = 'Colecciones';";
$trans["adminThemes"]              = "\$text = 'Temas de diseño';";
$trans["adminTranslation"]         = "\$text = 'Traducción';";

#****************************************************************************
#*  Translation text for page cataloging.php
#****************************************************************************
$trans["catalogSummary"]           = "\$text = 'Catalogación';";
$trans["catalogSearch1"]           = "\$text = 'Búsqueda de material';";
$trans["catalogSearch2"]           = "\$text = 'Búsqueda bibliográfica';";
$trans["catalogResults"]           = "\$text = 'Resultados de la búsqueda';";
$trans["catalogBibInfo"]           = "\$text = 'Información bibliográfica';";
$trans["catalogBibEdit"]           = "\$text = 'Editar básica';";
$trans["catalogBibEditMarc"]       = "\$text = 'Editar-MARC';";
$trans["catalogBibMarcNewFld"]     = "\$text = 'Nuevo campo MARC';";
$trans["catalogBibMarcNewFldShrt"] = "\$text = 'Nuevo MARC';";
$trans["catalogBibMarcEditFld"]    = "\$text = 'Editar campo MARC';";
$trans["catalogCopyNew"]           = "\$text = 'Nueva copia';";
$trans["catalogCopyEdit"]          = "\$text = 'Editar Copia';";
$trans["catalogHolds"]             = "\$text = 'Reservas';";
$trans["catalogDelete"]            = "\$text = 'Borrar';";
$trans["catalogBibNewLike"]        = "\$text = 'Nuevo como';";
$trans["catalogBibNew"]            = "\$text = 'Nuevo material';";
$trans["Upload Marc Data"]         = "\$text = 'Subir datos Marc';";

#****************************************************************************
#*  Translation text for page reports.php
#****************************************************************************
$trans["reportsSummary"]           = "\$text = 'Informes';";
$trans["reportsReportListLink"]    = "\$text = 'Lista de informes';";
$trans["reportsLabelsLink"]        = "\$text = 'Imprimir etiquetas';";
$trans["reportsLettersLink"]        = "\$text = 'Imprimir cartas';";

#****************************************************************************
#*  Translation text for page opac.php
#****************************************************************************
$trans["catalogSearch1"]           = "\$text = 'Buscar';";
$trans["catalogSearch2"]           = "\$text = 'Búscar material';";
$trans["catalogResults"]           = "\$text = 'Resultados de la búsqueda';";
$trans["catalogBibInfo"]           = "\$text = 'Información bibliográfica';";

#Added

$trans["memberInfo"]="\$text = 'Información de socios';";
$trans["memberSearch"]="\$text = 'Búscar socio';";
$trans["editInfo"]="\$text = 'Editar datos';";
$trans["checkoutHistory"]= "\$text = 'Historial de préstamo';";
$trans["account"]="\$text = 'Cuenta';";
$trans["checkIn"]="\$text = 'Devolución';";
$trans["memberSearch"]= "\$text = 'Buscar socio';";
$trans["newMember"]= "\$text = 'Nuevo socio';";
//$trans["account"]        	= "\$text = 'Cuenta';";
?>
