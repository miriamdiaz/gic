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
$trans["adminSubmit"]              = "\$text = 'Enviar';";
$trans["adminCancel"]              = "\$text = 'Cancelar';";
$trans["adminDelete"]              = "\$text = 'Borrar';";
$trans["adminUpdate"]              = "\$text = 'Actualizar';";
$trans["adminFootnote"]            = "\$text = 'Los campos marcados con %symbol% son requeridos.';";

#****************************************************************************
#*  Translation text for page index.php
#****************************************************************************
$trans["indexHdr"]                 = "\$text = 'Administración';";
$trans["indexDesc"]                = "\$text = 'Utiliza las funciones de la zona de la izquierda para administrar los bibliotecarios y los datos administrativos.';";

#****************************************************************************
#*  Translation text for page collections*.php
#****************************************************************************
$trans["adminCollections_delReturn"]                 = "\$text = 'Volver a la lista de colecciones';";
$trans["adminCollections_delStart"]                 = "\$text = 'Colecciones, ';";

#****************************************************************************
#*  Translation text for page collections_del.php
#****************************************************************************
$trans["adminCollections_delEnd"]                 = "\$text = ', ha sido borrado.';";

#****************************************************************************
#*  Translation text for page collections_del_confirm.php
#****************************************************************************
$trans["adminCollections_del_confirmText"]                 = "\$text = '¿Estás seguro de que quieres borrar esta colección?, ';";

#****************************************************************************
#*  Translation text for page collections_edit.php
#****************************************************************************
$trans["adminCollections_editEnd"]                 = "\$text = ', ha sido actualizada.';";

#****************************************************************************
#*  Translation text for page collections_edit_form.php
#****************************************************************************
$trans["adminCollections_edit_formEditcollection"]                 = "\$text = 'Editar colección:';";
$trans["adminCollections_edit_formDescription"]                 = "\$text = 'Descripción:';";
$trans["adminCollections_edit_formDaysdueback"]                 = "\$text = 'Días para la devolución:';";
$trans["adminCollections_edit_formDailyLateFee"]                 = "\$text = 'Multa diaria por retraso:';";
$trans["adminCollections_edit_formNote"]                 = "\$text = '*Notas:';";
$trans["adminCollections_edit_formNoteText"]                 = "\$text = 'Si pones los días de devolución a 0, ningún libro de esta colección se podrá prestar.';";

#****************************************************************************
#*  Translation text for page collections_list.php
#****************************************************************************
$trans["adminCollections_listAddNewCollection"]                 = "\$text = 'Añadir nueva colección';";
$trans["adminCollections_listCollections"]                 = "\$text = 'Colecciones:';";
$trans["adminCollections_listFunction"]                 = "\$text = 'Función';";
$trans["adminCollections_listDescription"]                 = "\$text = 'Descripción';";
$trans["adminCollections_listDaysdueback"]                 = "\$text = 'Días<br>préstamo';";
$trans["adminCollections_listDailylatefee"]                 = "\$text = 'Diariamente<br>Multa por retraso';";
$trans["adminCollections_listBibliographycount"]                 = "\$text = 'Número<br>libros';";
$trans["adminCollections_listEdit"]                 = "\$text = 'Editar';";
$trans["adminCollections_listDel"]                 = "\$text = 'borrar';";
$trans["adminCollections_ListNote"]                 = "\$text = '*Nota:';";
$trans["adminCollections_ListNoteText"]                 = "\$text = 'La función de borrado sólo está disponible en colecciones que tengan una cuenta bibliográfica de cero.<br>Si deseas borrar una colección con una cuenta bibliográfica mayor de cero primero tendrás que cambiar el tipo de material de esas bibliografías a otro tipo de material.';";

#****************************************************************************
#*  Translation text for page collections_new.php
#****************************************************************************
$trans["adminCollections_newAdded"]                 = "\$text = ', ha sido añadida.';";

#****************************************************************************
#*  Translation text for page collections_new_form.php
#****************************************************************************
$trans["adminCollections_new_formAddnewcollection"]                 = "\$text = 'Añadir nueva colección:';";
$trans["adminCollections_new_formDescription"]                 = "\$text = 'Descripción:';";
$trans["adminCollections_new_formDaysdueback"]                 = "\$text = 'Días en que debe ser devuelto:';";
$trans["adminCollections_new_formDailylatefee"]                 = "\$text = 'multa diaria por retraso:';";
$trans["adminCollections_new_formNote"]                 = "\$text = '*Nota:';";
$trans["adminCollections_new_formNoteText"]                 = "\$text = ' Si se pone a cero la fecha de devolución la colección entera queda indisponible para préstamo.';";

#****************************************************************************
#*  Translation text for page materials_del.php
#****************************************************************************
$trans["admin_materials_delMaterialType"]                 = "\$text = 'tipo de material, ';";
$trans["admin_materials_delMaterialdeleted"]                 = "\$text = ', ha sido borrado.';";
$trans["admin_materials_Return"]                 = "\$text = 'volver a la lista de tipo de material';";

#****************************************************************************
#*  Translation text for page materials_del_form.php
#****************************************************************************
$trans["admin_materials_delAreyousure"]                 = "\$text = '¿Estás seguro de que quieres borrar este tipo de material?, ';";

#****************************************************************************
#*  Translation text for page materials_edit_form.php
#****************************************************************************
$trans["admin_materials_delEditmaterialtype"]                 = "\$text = 'Editar tipo de material:';";
$trans["admin_materials_delDescription"]                 = "\$text = 'Descripción:';";
$trans["admin_materials_delAdultLimit"]                 = "\$text = 'Límite de préstamos adulto:';";
$trans["admin_materials_delunlimited"]                 = "\$text = '(0 significa ilimitado)';";
$trans["admin_materials_delJuvenileLimit"]                 = "\$text = 'Límite de préstamo juvenil:';";
$trans["admin_materials_delImagefile"]                 = "\$text = 'Archivo de imagen:';";
$trans["admin_materials_delNote"]                 = "\$text = '*Nota:';";
$trans["admin_materials_delNoteText"]                 = "\$text = 'Los archivos de imagen deben estar en el directorio openbiblio/images.';";

#****************************************************************************
#*  Translation text for page materials_edit.php
#****************************************************************************
$trans["admin_materials_editEnd"]                 = "\$text = ', ha sido actualizado.';";

#****************************************************************************
#*  Translation text for page materials_list.php
#****************************************************************************
$trans["admin_materials_listAddmaterialtypes"]                 = "\$text = 'Añadir nuevo tipo de material';";
$trans["admin_materials_listMaterialtypes"]                 = "\$text = 'Tipos de material:';";
$trans["admin_materials_listFunction"]                 = "\$text = 'Función';";
$trans["admin_materials_listDescription"]                 = "\$text = 'Descripción';";
$trans["admin_materials_listCheckoutlimit"]                 = "\$text = 'Límite de préstamo';";
$trans["admin_materials_listImageFile"]                 = "\$text = 'Imagen<br>File';";
$trans["admin_materials_listBibcount"]                 = "\$text = 'Número<br>libros';";
$trans["admin_materials_listAdult"]                 = "\$text = 'Adultos';";
$trans["admin_materials_listJuvenile"]                 = "\$text = 'Juvenil';";
$trans["admin_materials_listEdit"]                 = "\$text = 'editar';";
$trans["admin_materials_listDel"]                 = "\$text = 'borrar';";
$trans["admin_materials_listNote"]                 = "\$text = '*Nota:';";
$trans["admin_materials_listNoteText"]                 = "\$text = 'La función de borrado sólo está disponible en colecciones que tienen una cuenta bibliográfica de cero <br> si deseas borrar una colección con una cuenta bibliográfica mayor de cero primero tendrás que cambiar el tipo de material en esas bibliografías a otro tipo de material.';";

#****************************************************************************
#*  Translation text for page materials_new.php
#****************************************************************************
$trans["admin_materials_listNewadded"]                 = "\$text = ', ha sido añadido.';";

#****************************************************************************
#*  Translation text for page materials_new_form.php
#****************************************************************************
$trans["admin_materials_new_formNoteText"]                 = "\$text = 'los archivos de imagen deben localizarse en el directorio openbiblio/images.';";

#****************************************************************************
#*  Translation text for page noauth.php
#****************************************************************************
$trans["admin_noauth"]                 = "\$text = 'Usted no está autorizado la solapa de Administración.';";

#****************************************************************************
#*  Translation text for page settings_edit.php
#****************************************************************************

#****************************************************************************
#*  Translation text for page settings_edit_form.php
#****************************************************************************
$trans["admin_settingsUpdated"]                 = "\$text = 'los datos han sido actualizados.';";
$trans["admin_settingsEditsettings"]                 = "\$text = 'Editar los entornos de la biblioteca:';";
$trans["admin_settingsLibName"]                 = "\$text = 'nombre de la biblioteca:';";
$trans["admin_settingsLibimageurl"]                 = "\$text = 'imagen URL de la biblioteca:';";
$trans["admin_settingsOnlyshowimginheader"]                 = "\$text = 'Sólo mostrar la imagen en el encabezamiento:';";
$trans["admin_settingsLibhours"]                 = "\$text = 'horarios de la biblioteca:';";
$trans["admin_settingsLibphone"]                 = "\$text = 'teléfono de la biblioteca:';";
$trans["admin_settingsLibURL"]                 = "\$text = 'URL de la biblioteca:';";
$trans["admin_settingsOPACURL"]                 = "\$text = 'OPAC URL:';";
$trans["admin_settingsSessionTimeout"]                 = "\$text = 'Duración de la sesión:';";
$trans["admin_settingsMinutes"]                 = "\$text = 'minutos';";
$trans["admin_settingsSearchResults"]                 = "\$text = 'resultados de la búsqueda:';";
$trans["admin_settingsItemsperpage"]                 = "\$text = 'artículos por página';";
$trans["admin_settingsPurgebibhistory"]                 = "\$text = 'Depurar el historial de la bibliografía:';";
$trans["admin_settingsmonths"]                 = "\$text = 'meses';";
$trans["admin_settingsBlockCheckouts"]                 = "\$text = 'Bloquear los préstamos cuando haya pendiente una multa:';";
$trans["admin_settingsLocale"]                 = "\$text = 'Localización:';";
$trans["admin_settingsHTMLChar"]                 = "\$text = 'HTML Charset:';";
$trans["admin_settingsHTMLTagLangAttr"]                 = "\$text = 'Atributos de etiquetas de lenguaje HTML:';";

#****************************************************************************
#*  Translation text for all staff pages
#****************************************************************************
$trans["adminStaff_Staffmember"]                 = "\$text = 'Bibliotecarios,';";
$trans["adminStaff_Return"]                 = "\$text = 'volver a la lista de bibliotecarios';";
$trans["adminStaff_Yes"]                 = "\$text = 'Sí';";
$trans["adminStaff_No"]                 = "\$text = 'No';";


#****************************************************************************
#*  Translation text for page staff_del.php
#****************************************************************************
$trans["adminStaff_delDeleted"]                 = "\$text = ', ha sido borrado.';";

#****************************************************************************
#*  Translation text for page staff_delete_confirm.php
#****************************************************************************
$trans["adminStaff_del_confirmConfirmText"]                 = "\$text = 'estás seguro de querer borrar a un miembro del personal, ';";

#****************************************************************************
#*  Translation text for page staff_edit.php
#****************************************************************************
$trans["adminStaff_editUpdated"]                 = "\$text = ', ha sido actualizado';";

#****************************************************************************
#*  Translation text for page staff_edit_form.php
#****************************************************************************
$trans["adminStaff_edit_formHeader"]                 = "\$text = 'Editar información de los miembros del personal:';";
$trans["adminStaff_edit_formLastname"]                 = "\$text = 'Apellido:';";
$trans["adminStaff_edit_formFirstname"]                 = "\$text = 'Nombre:';";
$trans["adminStaff_edit_formLogin"]                 = "\$text = 'Nombre de usuario:';";
$trans["adminStaff_edit_formAuth"]                 = "\$text = 'Autorización:';";
$trans["adminStaff_edit_formCirc"]                 = "\$text = 'Circ';";
$trans["adminStaff_edit_formUpdatemember"]                 = "\$text = 'actualizar miembro';";
$trans["adminStaff_edit_formCatalog"]                 = "\$text = 'Catalogar';";
$trans["adminStaff_edit_formAdmin"]                 = "\$text = 'Admin';";
$trans["adminStaff_edit_formReports"]                 = "\$text = 'Informes';";
$trans["adminStaff_edit_formSuspended"]                 = "\$text = 'Suspendido:';";

#****************************************************************************
#*  Translation text for page staff_list.php
#****************************************************************************
$trans["adminStaff_list_formHeader"]                 = "\$text = 'Añadir nuevo miembro del personal';";
$trans["adminStaff_list_Columnheader"]                 = "\$text = ' miembros del personal:';";
$trans["adminStaff_list_Function"]                 = "\$text = 'Función';";
$trans["adminStaff_list_Edit"]                 = "\$text = 'editar';";
$trans["adminStaff_list_Pwd"]                 = "\$text = 'pwd';";
$trans["adminStaff_list_Del"]                 = "\$text = 'borrar';";

#****************************************************************************
#*  Translation text for page staff_new.php
#****************************************************************************
$trans["adminStaff_new_Added"]                 = "\$text = ', ha sido añadido.';";

#****************************************************************************
#*  Translation text for page staff_new_form.php
#****************************************************************************
$trans["adminStaff_new_form_Header"]          	= "\$text = 'Añadir nuevo miembro del personal:';";
$trans["adminStaff_new_form_Password"]          = "\$text = 'Contraseña:';";
$trans["adminStaff_new_form_Reenterpassword"]   = "\$text = 'Introduzca de nuevo la contraseña:';";

#****************************************************************************
#*  Translation text for page staff_pwd_reset.php
#****************************************************************************
$trans["adminStaff_pwd_reset_Passwordreset"]   = "\$text = 'La contraseña ha sido restaurada.';";

#****************************************************************************
#*  Translation text for page staff_pwd_reset_form.php
#****************************************************************************
$trans["adminStaff_pwd_reset_form_Resetheader"]   = "\$text = 'Borrar contraseña de bibliotecario:';";

#****************************************************************************
#*  Translation text for theme pages
#****************************************************************************
$trans["adminTheme_Return"]                 = "\$text = 'volver a la lista de temas';";
$trans["adminTheme_Theme"]                 = "\$text = 'Tema, ';";

#****************************************************************************
#*  Translation text for page theme_del.php
#****************************************************************************
$trans["adminTheme_Deleted"]                 = "\$text = ', ha sido borrado.';";
#****************************************************************************
#*  Translation text for page theme_del_confirm.php
#****************************************************************************
$trans["adminTheme_Deleteconfirm"]                 = "\$text = '¿Estás seguro de que quieres borrar este tema?, ';";
#****************************************************************************
#*  Translation text for page theme_edit.php
#****************************************************************************
$trans["adminTheme_Updated"]                 = "\$text = ', ha sido actualizado.';";

#****************************************************************************
#*  Translation text for page theme_edit_form.php
#****************************************************************************
$trans["adminTheme_Preview"]                 = "\$text = 'Previsualizar los cambios de tema';";

#****************************************************************************
#*  Translation text for page theme_list.php
#****************************************************************************
$trans["adminTheme_Changetheme"]                 = "\$text = 'Cambiar el tema actual:';";
$trans["adminTheme_Choosetheme"]                 = "\$text = 'Elegir un nuevo tema:';";
$trans["adminTheme_Addnew"]                 = "\$text = 'Añadir nuevo tema';";
$trans["adminTheme_themes"]                 = "\$text = 'Temas:';";
$trans["adminTheme_function"]                 = "\$text = 'Función';";
$trans["adminTheme_Themename"]                 = "\$text = 'Nombre de tema';";
$trans["adminTheme_Usage"]                 = "\$text = 'Uso';";
$trans["adminTheme_Edit"]                 = "\$text = 'editar';";
$trans["adminTheme_Copy"]                 = "\$text = 'copiar';";
$trans["adminTheme_Del"]                 = "\$text = 'borrar';";
$trans["adminTheme_Inuse"]                 = "\$text = 'en uso';";
$trans["adminTheme_Note"]                 = "\$text = '*Nota:';";
$trans["adminTheme_Notetext"]                 = "\$text = 'la función de borrado no está disponible en el tema que está en uso actualmente.';";

#****************************************************************************
#*  Translation text for page theme_list.php
#****************************************************************************
$trans["adminTheme_Theme2"]                 = "\$text = 'Tema:';";
$trans["adminTheme_Tablebordercolor"]                 = "\$text = 'Color del borde de tabla:';";
$trans["adminTheme_Errorcolor"]                 = "\$text = 'Color de error:';";
$trans["adminTheme_Tableborderwidth"]                 = "\$text = 'Anchura del borde de tabla:';";
$trans["adminTheme_Tablecellpadding"]                 = "\$text = 'Anchura de la celda:';";
$trans["adminTheme_Title"]                 = "\$text = 'Título';";
$trans["adminTheme_Mainbody"]                 = "\$text = 'Cuerpo principal';";
$trans["adminTheme_Navigation"]                 = "\$text = 'Navegación';";
$trans["adminTheme_Tabs"]                 = "\$text = 'Tabs';";
$trans["adminTheme_Backgroundcolor"]                 = "\$text = 'Color de fondo:';";
$trans["adminTheme_Fontface"]                 = "\$text = 'Fuente:';";
$trans["adminTheme_Fontsize"]                 = "\$text = 'Tamaño de fuente:';";
$trans["adminTheme_Bold"]                 = "\$text = 'negrita';";
$trans["adminTheme_Fontcolor"]                 = "\$text = 'Color de fuente:';";
$trans["adminTheme_Linkcolor"]                 = "\$text = 'Color de enlace:';";
$trans["adminTheme_Align"]                 = "\$text = 'Alineación:';";
$trans["adminTheme_Right"]                 = "\$text = 'Derecha';";
$trans["adminTheme_Left"]                 = "\$text = 'Izquierda';";
$trans["adminTheme_Center"]                 = "\$text = 'Centro';";

$trans["adminTheme_HeaderWording"]                 = "\$text = 'Editar';";


#****************************************************************************
#*  Translation text for page theme_new.php
#****************************************************************************
$trans["adminTheme_new_Added"]                 = "\$text = ', ha sido actualizada.';";

#****************************************************************************
#*  Translation text for page theme_new_form.php
#****************************************************************************

#****************************************************************************
#*  Translation text for page theme_preview.php
#****************************************************************************
$trans["adminTheme_preview_Themepreview"]                 = "\$text = 'vista previa del tema';";
$trans["adminTheme_preview_Librarytitle"]                 = "\$text = 'título de la biblioteca';";
$trans["adminTheme_preview_CloseWindow"]                 = "\$text = 'Cerrar ventana';";
$trans["adminTheme_preview_Home"]                 = "\$text = 'página principal';";
$trans["adminTheme_preview_Circulation"]   = "\$text = 'Circulación';";
$trans["adminTheme_preview_Cataloging"]    = "\$text = 'Catalogación';";
$trans["adminTheme_preview_Admin"]         = "\$text = 'Administración';";
$trans["adminTheme_preview_Samplelink"]    = "\$text = 'Enlace de muestra';";
$trans["adminTheme_preview_Thisstart"]     = "\$text = 'Esta es una vista previa de ';";
$trans["adminTheme_preview_Thisend"]       = "\$text = 'tema.';";
$trans["adminTheme_preview_Samplelist"]    = "\$text = 'lista de muestra:';";
$trans["adminTheme_preview_Tableheading"]  = "\$text = 'encabezamiento de la tabla';";
$trans["adminTheme_preview_Sampledatarow1"]= "\$text = 'datos de muestra de la fila 1';";
$trans["adminTheme_preview_Sampledatarow2"]= "\$text = 'datos de muestra de la fila 2';";
$trans["adminTheme_preview_Sampledatarow3"]= "\$text = 'datos de muestra de la fila 3';";
$trans["adminTheme_preview_Samplelink"]    = "\$text = 'enlace de muestra';";
$trans["adminTheme_preview_Sampleerror"]   = "\$text = 'error de muestra';";
$trans["adminTheme_preview_Sampleinput"]   = "\$text = 'entrada de muestra';";
$trans["adminTheme_preview_Samplebutton"]  = "\$text = 'botón de muestra';";
$trans["adminTheme_preview_Poweredby"]     = "\$text = 'Puesto en funcionamiento por OpenBiblio';";
$trans["adminTheme_preview_Copyright"]     = "\$text = 'Copyright &copy; 2002 Dave Stevens';";
$trans["adminTheme_preview_underthe"]      = "\$text = 'bajo la';";
$trans["adminTheme_preview_GNU"]           = "\$text = 'licencia pública general de la GNU';";

#****************************************************************************
#*  Translation text for page theme_use.php
#****************************************************************************

?>
