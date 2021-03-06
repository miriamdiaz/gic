<?php
/**********************************************************************************
 *   Copyright(C) 2002-2004 David Stevens
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
$trans["sharedCancel"]             = "\$text = 'Cancelar';";
$trans["sharedDelete"]             = "\$text = 'Borrar';";

#****************************************************************************
#*  Translation text for page biblio_view.php
#****************************************************************************
$trans["biblioViewTble1Hdr"]       = "\$text = 'Informaci�n bibliogr�fica';";
$trans["biblioViewMaterialType"]   = "\$text = 'Tipo de material';";
$trans["biblioViewCollection"]     = "\$text = 'Colecci�n';";
$trans["biblioViewCallNmbr"]       = "\$text = 'Signatura';";
$trans["biblioViewTble2Hdr"]       = "\$text = 'Informaci�n bibliogr�fica del ejemplar ';";
$trans["biblioViewTble2Col1"]      = "\$text = 'Cod. barras';";
$trans["biblioViewTble2Col2"]      = "\$text = 'Descripci�n';";
$trans["biblioViewTble2Col3"]      = "\$text = 'Estado';";
// MODIFICACION JUDITH 16/12/05
//$trans["biblioViewTble2Col4"]      = "\$text = 'Estado Dt';";
$trans["biblioViewTble2Col4"]      = "\$text = 'Fecha mod';";
// FIN JUDITH
$trans["biblioViewTble2Col5"]      = "\$text = 'Fecha de devoluci�n';";
/*ini franco 08/07/05*/
$trans["biblioViewTble2Col6"]      = "\$text = ' No se usa -->Tomo';";
$trans["biblioViewTble2Col7"]      = "\$text = 'Volumen/Tomo';";
$trans["biblioViewTble2Col8"]      = "\$text = 'Proveedor';";
$trans["biblioViewTble2Col9"]      = "\$text = 'Precio';";
$trans["biblioViewTble2Col10"]      = "\$text = 'Cod. Loc';";
/*fin franco*/
$trans["biblioViewTble2ColFunc"]   = "\$text = 'Funci�n';";
$trans["biblioViewTble2Coledit"]   = "\$text = 'Editar';";
$trans["biblioViewTble2Coldel"]    = "\$text = 'Eliminar';";
$trans["biblioViewTble3Hdr"]       = "\$text = 'Informaci�n bibliogr�fica adicional';";
$trans["biblioViewNoAddInfo"]      = "\$text = 'No existe informaci�n bibliogr�fica adicional disponible.';";
$trans["biblioViewNoCopies"]       = "\$text = 'No se han creado ejemplares.';";
$trans["biblioViewNoAnaliticas"]       = "\$text = 'No se han creado analiticas.';";

$trans["biblioViewOpacFlg"]        = "\$text = 'Mostrar en OPAC';";
$trans["biblioViewYes"]            = "\$text = 'Si';";
$trans["biblioViewNo"]   	   = "\$text = 'No';";
$trans["biblioViewNewCopy"]        = "\$text = 'A�adir nuevo ejemplar';";
$trans["biblioViewNeweCopy"]        = "\$text = 'A�adir nuevo ejemplar electr�nico';";
$trans["biblioViewNewAnalitica"]        = "\$text = 'A�adir nueva anal�tica';";
$trans["biblioViewTble4Hdr"]       = "\$text = 'Informaci�n bibliogr�fica de la anal�tica ';";
$trans["biblioViewTble4Col1"]      = "\$text = 'T�tulo';";
$trans["biblioViewTble4Col2"]      = "\$text = 'Autor';";
$trans["biblioViewTble4Col3"]      = "\$text = 'Paginaci�n';";
$trans["biblioViewTble4Col4"]      = "\$text = 'Materia';";
$trans["biblioViewTble4Col5"]      = "\$text = 'Subt�tulo';";
$trans["biblioImagen"]			   = "\$text = 'Imagen';";
$trans["biblioUploadImage"]        = "\$text = 'Subir imagen';";
$trans["biblioUpload"]      	   = "\$text = 'Subir';";

#****************************************************************************
#*  Translation text for page biblio_search.php
#****************************************************************************
$trans["biblioSearchNoResults"]    = "\$text = 'No se han encontrado registros.';";
$trans["biblioSearchResults"]      = "\$text = 'Resultados de la b�squeda';";
$trans["biblioSearchResultPages"]  = "\$text = 'P�ginas de resultados';";
$trans["biblioSearchPrev"]         = "\$text = 'anterior';";
$trans["biblioSearchNext"]         = "\$text = 'siguiente';";
$trans["biblioSearchResultTxt"]    = "if (%items% == 1) {
                                        \$text = '%items% resultado encontrado.';
                                      } else {
                                        \$text = '%items% resultado encontrado';
                                      }";
$trans["biblioSearchauthor"]       = "\$text = ' ordenados por autor';";
$trans["biblioSearchtitle"]        = "\$text = ' ordenados por t�tulo';";
$trans["biblioSearchSortByAuthor"] = "\$text = 'ordenados por autor';";
$trans["biblioSearchSortByTitle"]  = "\$text = 'ordenados por t�tulo';";
$trans["biblioSearchTitle"]        = "\$text = 'T�tulo';";
$trans["biblioSearchAuthor"]       = "\$text = 'Autor';";
$trans["biblioSearchMaterial"]     = "\$text = 'Material';";
$trans["biblioSearchCollection"]   = "\$text = 'Colecci�n';";
$trans["biblioSearchCall"]         = "\$text = 'Signatura';";
$trans["biblioSearchCopyBCode"]    = "\$text = 'C�digo de ejemplar';";
$trans["biblioSearchCopyStatus"]   = "\$text = 'Estado';";
$trans["biblioSearchNoCopies"]     = "\$text = 'Ningun ejemplar disponible.';";
$trans["biblioSearchResponsibility_Stmt"]       = "\$text = 'Resp. Secundaria';";
$trans["biblioSearchSelect"]       = "\$text='Seleccionar';";
$trans["select"]       = "\$text='Seleccionar';";
#****************************************************************************
#*  Translation text for page loginform.php
#****************************************************************************
$trans["loginFormTbleHdr"]         = "\$text = 'Entrada para operadores';";
$trans["loginFormUsername"]        = "\$text = 'Nombre de operador';";
$trans["loginFormPassword"]        = "\$text = 'Contrase�a';";
$trans["loginFormLogin"]           = "\$text = 'Entrar';";

#****************************************************************************
#*  Translation text for page hold_del_confirm.php
#****************************************************************************
$trans["holdDelConfirmMsg"]        = "\$text = 'Est�s seguro de querer borrar esta solicitud de pr�stamo?';";

#****************************************************************************
#*  Translation text for page hold_del.php
#****************************************************************************
$trans["holdDelSuccess"]           = "\$text='La solicitud de pr�stamo se borr� correctamente.';";

#****************************************************************************
#*  Translation text for page help_header.php
#****************************************************************************

$trans["helpHeaderTitle"]          = "\$text='Ayuda de OpenBiblio';";
$trans["helpHeaderCloseWin"]       = "\$text='Cerrar ventana';";
$trans["helpHeaderContents"]       = "\$text='Contenidos';";
$trans["helpHeaderPrint"]          = "\$text='Imprimir';";

$trans["catalogResults"]           = "\$text='Resultados de b�squeda';";

#****************************************************************************
#*  Translation text for page header.php and header_opac.php
#****************************************************************************
$trans["headerTodaysDate"]         = "\$text='Fecha:';";
$trans["headerLibraryHours"]       = "\$text='Horario:';";
$trans["headerLibraryPhone"]       = "\$text='Tel�fono:';";
$trans["headerHome"]               = "\$text=' Inicio ';";
$trans["headerCirculation"]        = "\$text=' Circulaci�n ';";
$trans["headerCataloging"]         = "\$text=' Catalogaci�n ';";
$trans["headerAdmin"]              = "\$text=' Administraci�n ';";
$trans["headerReports"]            = "\$text=' Informes ';";

#****************************************************************************
#*  Translation text for page footer.php
#****************************************************************************
$trans["footerLibraryHome"]        = "\$text='Inicio';";
$trans["footerOPAC"]               = "\$text='OPAC';";
$trans["footerHelp"]               = "\$text='Ayuda';";
$trans["footerPoweredBy"]          = "\$text='OpenBiblio versi�n';";
$trans["footerDatabaseVersion"]    = "\$text='Versi�n de base de datos';";
$trans["footerCopyright"]          = "\$text='Copyright';";
$trans["footerUnderThe"]           = "\$text='bajo';";
$trans["footerGPL"]                = "\$text='GNU General Public License';";
$trans["hola.author"]                = "\$text='Autor';";

?>
