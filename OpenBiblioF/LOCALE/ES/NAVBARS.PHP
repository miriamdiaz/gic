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
$trans["homeAdvancedSearch"]          = "\$text = 'Busqueda Avanzada';";
$trans["homeReglament"]          = "\$text = 'Reglamento Bibliot. SIUNPA 2001';";
$trans["homeMemberOnline"]              ="\$text = 'Usuario Online';";
$trans["homeHoldOnline"]              ="\$text = 'Reservas Online';";
#****************************************************************************
#*  Translation text for page admin.php
#****************************************************************************
$trans["adminSummary"]             = "\$text = 'Administraci�n';";
$trans["adminStaff"]               = "\$text = 'Admin. Operadores';";
$trans["adminSettings"]            = "\$text = 'Config. biblioteca';";
$trans["adminMaterialTypes"]       = "\$text = 'Tipos de material';";
$trans["adminCollections"]         = "\$text = 'Colecciones';";
/**
Agregado todo lo referente a tipo de prestamos: Horacio Alvarez
Fecha: 22-03-06
*/
$trans["adminTipoPrestamos"]       = "\$text = 'Tipo de Prestamos';";
$trans["adminTipoSocios"]       = "\$text = 'Tipo de Usuarios';";
$trans["adminThemes"]              = "\$text = 'Temas de dise�o';";
$trans["adminMails"]              = "\$text = 'Mailing';";
$trans["adminTranslation"]         = "\$text = 'Traducci�n';";
$trans["adminTipoSanciones"]       = "\$text = 'Tipos de Sanciones';";

#****************************************************************************
#*  Translation text for page cataloging.php
#****************************************************************************
$trans["catalogSummary"]           = "\$text = 'Catalogaci�n';";
$trans["catalogSearch1"]           = "\$text = 'B�squeda de material';";
$trans["catalogSearch2"]           = "\$text = 'B�squeda bibliogr�fica';";
$trans["catalogResults"]           = "\$text = 'Resultados de la b�squeda';";
$trans["catalogBibInfo"]           = "\$text = 'Informaci�n bibliogr�fica';";
$trans["catalogBibEdit"]           = "\$text = 'Editar b�sica';";
$trans["catalogBibEditMarc"]       = "\$text = 'Editar-MARC';";
$trans["catalogBibMarcNewFld"]     = "\$text = 'Nuevo campo MARC';";
$trans["catalogBibMarcNewFldShrt"] = "\$text = 'Nuevo MARC';";
$trans["catalogBibMarcEditFld"]    = "\$text = 'Editar campo MARC';";
$trans["catalogCopyNew"]           = "\$text = 'Nuevo ejemplar';";
$trans["catalogCopyEdit"]          = "\$text = 'Editar ejemplar';";
$trans["catalogHolds"]             = "\$text = 'Ver Reservas';";
$trans["catalogDelete"]            = "\$text = 'Borrar';";
$trans["catalogBibNewLike"]        = "\$text = 'Nuevo como';";
$trans["catalogBibNew"]            = "\$text = 'Nuevo material';";
$trans["Upload Marc Data"]         = "\$text = 'Subir datos Marc';";
$trans["catalogAnaliticaNew"]           = "\$text = 'Nueva Analitica';";
$trans["catalogAnaliticaEdit"]          = "\$text = 'Editar Analitica';";

#****************************************************************************
#*  Translation text for page reports.php
#****************************************************************************
$trans["reportsSummary"]           = "\$text = 'Informes';";
// \/ MODIFICACI�N JUDITH 31/10/05 \/
$trans["reportsReportListLinkSIUNPA"]    = "\$text = 'Informes de SIUNPA';";
// /\ MODIFICACI�N JUDITH 31/10/05 /\
$trans["reportsReportListLink"]    = "\$text = 'Informes Biblioteca';";
$trans["reportsLabelsLink"]        = "\$text = 'Imprimir etiquetas';";
$trans["reportsLettersLink"]        = "\$text = 'Imprimir cartas';";

#****************************************************************************
#*  Translation text for page opac.php
#****************************************************************************
$trans["catalogSearch1"]           = "\$text = 'Buscar';";
$trans["catalogSearch2"]           = "\$text = 'B�scar material';";
$trans["catalogResults"]           = "\$text = 'Resultados de la b�squeda';";
$trans["catalogBibInfo"]           = "\$text = 'Informaci�n bibliogr�fica';";

#Added

$trans["memberInfo"]="\$text = 'Informaci�n de usuarios';";
$trans["memberSearch"]="\$text = 'B�scar usuario';";
$trans["editInfo"]="\$text = 'Editar datos';";
$trans["checkoutHistory"]= "\$text = 'Historial de pr�stamo';";
$trans["checkoutSancion"]= "\$text = 'Historial de sanciones';";
$trans["account"]="\$text = 'Cuenta';";
$trans["checkIn"]="\$text = 'Devoluci�n';";
$trans["memberSearch"]= "\$text = 'Buscar usuario';";
$trans["newMember"]= "\$text = 'Nuevo usuario';";
$trans["importarSocios"]= "\$text = 'Importar Usuarios';";
//$trans["account"]        	= "\$text = 'Cuenta';";

#*****************************************************************************
#* ini franco 15/07/05 Translation text for page aprueba_material.php
#*****************************************************************************
$trans["catalogApruebaMaterial"]                 = "\$text = 'Aprobar Material';";
$trans["catalogApruebaEjemplar"]                 = "\$text = 'Aprobar Ejemplar';";
$trans["catalogLibrary"]                 = "\$text = 'Bibliotecas';";

$trans["volverOpac"]                 = "\$text = 'Volver a Inicio';";

?>
