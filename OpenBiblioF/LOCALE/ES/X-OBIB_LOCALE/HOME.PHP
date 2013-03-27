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
$trans["indexHeading"]       = "\$text='Bienvenido a OpenBiblio-UNPA';";
$trans["indexIntro"]         = "\$text=
  'Utiliza las pestañas superiores para acceder a las diferentes páginas de administración de la biblioteca.';";
$trans["indexTab"]           = "\$text='Página';";
$trans["indexDesc"]          = "\$text='Descripción';";
$trans["indexCirc"]          = "\$text='Circulación';";
$trans["indexCircDesc1"]     = "\$text='Utiliza esta página para administrar los datos de los socios.';";
$trans["indexCircDesc2"]     = "\$text='Administración de socios (añadir nuevos, buscar, editar, borrar)';";
$trans["indexCircDesc3"]     = "\$text='Préstamos, reservas, cuentas e historial de los socios de la biblioteca';";
$trans["indexCircDesc4"]     = "\$text='Registros de bibliografía y del carrito de reposición en estantería';";
//$trans["indexCircDesc5"]     = "\$text='Pago de una multa por retraso en la devolución';";
$trans["indexCat"]           = "\$text='Catalogacíón';";
$trans["indexCatDesc1"]      = "\$text='Administración de datos bibliográficos.';";
$trans["indexCatDesc2"]      = "\$text='Administración bibliográfica (nuevo, buscar, editar, borrar)';";
//$trans["indexCatDesc3"]      = "\$text='Bibliografía importante de los archivos de USMarc';";
$trans["indexAdmin"]         = "\$text='Administración';";
$trans["indexAdminDesc1"]    = "\$text='Administración de bibliotecarios y de datos administrativos.';";
$trans["indexAdminDesc2"]    = "\$text='Administración de bibliotecarios (añadir nuevos, editar, cambiar contraseñas, borrar)';";
$trans["indexAdminDesc3"]    = "\$text='Configuración general de la biblioteca';";
$trans["indexAdminDesc5"]    = "\$text='Lista de tipos de material';";
$trans["indexAdminDesc4"]    = "\$text='Lista de colecciones';";
$trans["indexAdminDesc6"]    = "\$text='Editor de temas de diseño';";
$trans["indexReports"]       = "\$text='Informes';";
$trans["indexReportsDesc1"]  = "\$text='En esta página puedes ejecutar informes a partir de los datos de la biblioteca.';";
$trans["indexReportsDesc2"]  = "\$text='Informes.';";
$trans["indexReportsDesc3"]  = "\$text='Etiquetas.';";
#****************************************************************************
#*  Translation text for page advancedsearch	
#****************************************************************************
$trans["reportCriteriaHead1"]      = "\$text = 'Criterios de búsqueda';";
$trans["homeAdvancedSearch"]          = "\$text = 'Busqueda Avanzada';";
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
$trans["reportCriteriaRunReport"]  = "\$text = 'realizar búsqueda';";
$trans["reportsCancel"]            = "\$text = 'Cancelar';";
#****************************************************************************
#*  Column Text
#****************************************************************************
$trans["biblio.bibid"]             = "\$text = 'ID del registro';";
$trans["biblio.title"]             = "\$text = 'Título';";
$trans["biblio.author"]            = "\$text = 'Autor';";
$trans["biblio.call_nmbr1"]        = "\$text = 'Signatura';";
$trans["biblio.topic1"]        = "\$text = 'Materia';";
$trans["biblio.material_cd"]        = "\$text = 'Tipo de Material';";
$trans["biblio.collection_cd"]        = "\$text = 'Colección';";
$trans["biblio_field.field_data"]        = "\$text = 'ISBN/ISSN/Autor Coporativo/Nombre del Editor/Fecha de Publicación';";


?>
