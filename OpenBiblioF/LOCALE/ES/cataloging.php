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
$trans["catalogSubmit"]            = "\$text = 'Enviar';";
$trans["catalogCancel"]            = "\$text = 'Cancelar';";
$trans["catalogRefresh"]           = "\$text = 'Refresh';";
$trans["catalogDelete"]            = "\$text = 'Borrar';";
$trans["catalogFootnote"]          = "\$text = 'Los campos marcados con %symbol% son requeridos.';";
$trans["AnswerYes"]                = "\$text = 'Si';";
$trans["AnswerNo"]                 = "\$text = 'No';";

#****************************************************************************
#*  Translation text for page index.php
#****************************************************************************
$trans["indexHdr"]                 = "\$text = 'Catalogación';";
$trans["indexBarcodeHdr"]          = "\$text = 'Buscar bibliografía por código de barras';";
$trans["indexBarcodeField"]        = "\$text = 'Código de barras';";
$trans["indexSearchHdr"]           = "\$text = 'Buscar bibliografía por frase de búsqueda';";
$trans["indexTitle"]               = "\$text = 'Título';";
$trans["indexTitleAnalitica"]               = "\$text = 'Título o Analítica';";
$trans["indexAuthor"]              = "\$text = 'Autor';";
$trans["indexSubject"]             = "\$text = 'Materia';";
$trans["indexButton"]              = "\$text = 'Buscar';";
$trans["indexSignatura"]             = "\$text = 'Signatura';";
$trans["indexIsbn"]             = "\$text = 'ISBN';";
$trans["indexColeccion"]             = "\$text = 'Colección';";
$trans["indexNombreEditor"]             = "\$text = 'Nombre del Editor';";
$trans["indexNota"]             = "\$text = 'Nota';";
$trans["indexMaterial"]             = "\$text = 'Tipo material';";
$trans["indexBibid"]             = "\$text = 'Registro Bibid';";
$trans["indexOcurrHdr"]              = "\$text = 'Calcular ocurrencias';";
$trans["opac_autor_corporativo"]       = "\$text='Autor Corporativo';";

#****************************************************************************
#*  Translation text for page biblio_new_form.php
#****************************************************************************
$trans["biblioNewFormLabel"]       = "\$text = 'Añadir nuevo';";

#****************************************************************************
#*  Translation text for page biblio_fields.php
#****************************************************************************
$trans["biblioFieldsLabel"]        = "\$text = 'Bibliografía';";
$trans["biblioFieldsMaterialTyp"]  = "\$text = 'Tipo de material';";
$trans["biblioFieldsCollection"]   = "\$text = 'Colección';";
$trans["biblioFieldsCallNmbr"]     = "\$text = 'Signatura';";
$trans["biblioFieldsUsmarcFields"] = "\$text = 'Campos USMarc';";
$trans["biblioFieldsOpacFlg"]      = "\$text = 'Mostrar en OPAC';";
$trans["biblioFieldsLiteraturaFlg"]      = "\$text = '**Omitir Signatura Duplicada';";
$trans["biblioFieldsNoteLiteraturaFlg"]      = "\$text = '**Esta opción solo debe utilizarce para materiales de Literatura.';";
$trans["biblioFieldsIndex"]      = "\$text = 'Indice';";
$trans["biblioFieldsDateSptu"]      = "\$text = 'Fecha de Catalogación';";
$trans["biblioFieldsDateCreate"]      = "\$text = 'Fecha de Creación';";
$trans["biblioFieldsUser"]      = "\$text = 'Usuario';";
#****************************************************************************
#*  Translation text for page biblio_new.php
#****************************************************************************
$trans["biblioNewSuccess"]         = "\$text = 'Se ha creado la siguiente nueva bibliografía.  Para añadir un ejemplar, <br>
seleccione \"Nuevo ejemplar\" del navegador de la izquierda o <br>\"añadir nuevo ejemplar\" de la información del ejemplar de abajo.';";

#****************************************************************************
#*  Translation text for page biblio_edit.php
#****************************************************************************
$trans["biblioEditSuccess"]        = "\$text = 'Datos de libro actualizados correctamente.';";

#****************************************************************************
#*  Translation text for page biblio_copy_new_form.php and biblio_copy_edit_form.php
#****************************************************************************
$trans["biblioCopyNewFormLabel"]   = "\$text = 'Añadir nuevo ejemplar';";
$trans["biblioCopyNewBarcode"]     = "\$text = 'Código de barras';";
$trans["biblioCopyNewDesc"]        = "\$text = 'Descripción';";
$trans["biblioCopyEditFormLabel"]  = "\$text = 'Editar ejemplar';";
$trans["biblioCopyEditFormStatus"] = "\$text = 'Estado';";
/*ini franco 06/07/05*/
$trans["biblioCopyNewVolumenTomo"] = "\$text = 'Volumen / Tomo';";
$trans["biblioCopyNewTomo"] = "\$text = 'Tomo';";
$trans["biblioCopyUserCreador"] = "\$text = 'Usuario';";
$trans["biblioCopyNewProveedor"] = "\$text = 'Proveedor';";
$trans["biblioCopyNewPrecio"] = "\$text = 'Precio Actual';";
$trans["biblioCopyCodLoc"] = "\$text = 'Codigo Localización';";
$trans["biblioCopyDateSPTU"] = "\$text = 'Fecha de Catalogación';";
/*fin franco*/

#****************************************************************************
#*  Translation text for page biblio_copy_new.php
#****************************************************************************
$trans["biblioCopyNewSuccess"]     = "\$text = 'Ejemplar creado correctamente.';";

#****************************************************************************
#*  Translation text for page biblio_copy_edit.php
#****************************************************************************
$trans["biblioCopyEditSuccess"]    = "\$text = 'Ejemplar actualizado correctamente.';";

#****************************************************************************
#*  Translation text for page biblio_copy_del_confirm.php
#****************************************************************************
$trans["biblioCopyDelConfirmErr1"] = "\$text = 'No se pudo borrar el ejemplar.  Un ejemplar debe estar registrado antes de que pueda ser borrado.';";
$trans["biblioCopyDelConfirmMsg"]  = "\$text = 'Estás seguro de que quieres borrar el ejemplar con código de barras %barcodeNmbr%?  Esto también borrará todos los cambios en el status del historial de este ejemplar.';";

#****************************************************************************
#*  Translation text for page biblio_copy_del.php
#****************************************************************************
$trans["biblioCopyDelSuccess"]     = "\$text = 'Ejemplar con código de barras %barcode% borrado correctamente.';";

#****************************************************************************
#*  Translation text for page biblio_marc_list.php
#****************************************************************************
$trans["biblioMarcListMarcSelect"] = "\$text = 'Añadir nuevo campo MARC';";
$trans["biblioMarcListHdr"]        = "\$text = 'Información del campo MARC';";
$trans["biblioMarcListTbleCol1"]   = "\$text = 'Función';";
$trans["biblioMarcListTbleCol2"]   = "\$text = 'Etiqueta';";
$trans["biblioMarcListTbleCol3"]   = "\$text = 'Descripción de la etiqueta';";
$trans["biblioMarcListTbleCol4"]   = "\$text = 'Ind 1';";
$trans["biblioMarcListTbleCol5"]   = "\$text = 'Ind 2';";
$trans["biblioMarcListTbleCol6"]   = "\$text = 'Subcampo';";
$trans["biblioMarcListTbleCol7"]   = "\$text = 'Descripción del subcampo';";
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
$trans["biblioMarcNewFormHdr"]     = "\$text = 'Añadir nuevo campo MARC';";
$trans["biblioMarcNewFormTag"]     = "\$text = 'Etiqueta';";
$trans["biblioMarcNewFormSubfld"]  = "\$text = 'Subcampo';";
$trans["biblioMarcNewFormData"]    = "\$text = 'Datos del campo';";
$trans["biblioMarcNewFormInd1"]    = "\$text = 'Indicador 1';";
$trans["biblioMarcNewFormInd2"]    = "\$text = 'Indicador 2';";
$trans["biblioMarcNewFormSelect"]  = "\$text = 'Seleccionar';";

#****************************************************************************
#*  Translation text for page biblio_marc_new.php
#****************************************************************************
$trans["biblioMarcNewSuccess"]     = "\$text = 'Campo MARC añadido correctamente.';";

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
$trans["biblioMarcDelConfirmMsg"]  = "\$text = 'Estás seguro de que quieres borrar el campo con etiqueta %tag% y el subcampo %subfieldCd%?';";

#****************************************************************************
#*  Translation text for page biblio_marc_del.php
#****************************************************************************
$trans["biblioMarcDelSuccess"]     = "\$text = 'Campo MARC borrado correctamente.';";

#****************************************************************************
#*  Translation text for page biblio_del_confirm.php
#****************************************************************************
$trans["biblioDelConfirmWarn"]     = "\$text = 'Esta bibliografía tiene ejemplar(es) %copyCount%  y solicitudes de préstamo %holdCount%.  Por favor borre estos ejemplares y/o peticiones de uso antes de borrar esta bibliografía.';";
$trans["biblioDelConfirmReturn"]   = "\$text = 'volver a la información bibliográfica';";
$trans["biblioDelConfirmMsg"]      = "\$text = 'Estás seguro de que quieres borrar la bibliografía titulada %title%?';";

#****************************************************************************
#*  Translation text for page biblio_del_confirm.php
#****************************************************************************
$trans["biblioDelMsg"]             = "\$text = 'La bibliografía, %title%, ha sido borrada.';";
$trans["biblioDelReturn"]          = "\$text = 'volver a la búsqueda bibliográfica';";

#****************************************************************************
#*  Translation text for page biblio_hold_list.php
#****************************************************************************
$trans["biblioHoldListHead"]       = "\$text = 'Solicitudes de préstamo de la bibliografía:';";
$trans["biblioHoldListNoHolds"]    = "\$text = 'Actualmente no hay ejemplares de la bibliografía en uso.';";
$trans["biblioHoldListHdr1"]       = "\$text = 'Función';";
$trans["biblioHoldListHdr2"]       = "\$text = 'Ejemplar';";
$trans["biblioHoldListHdr3"]       = "\$text = 'Prestado';";
$trans["biblioHoldListHdr4"]       = "\$text = 'Socio';";
$trans["biblioHoldListHdr5"]       = "\$text = 'Estado';";
$trans["biblioHoldListHdr6"]       = "\$text = 'Fecha de devolución';";
$trans["biblioHoldListdel"]        = "\$text = 'Eliminar';";

#****************************************************************************
#*  Translation text for page noauth.php
#****************************************************************************
$trans["NotAuth"]                 = "\$text = 'No tienes permiso de catalogación';";

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

$trans["catalogResults"]                 = "\$text = 'Resultados de búsqueda';";

#****************************************************************************
#*  Translation text for page materials_list.php esto estaba en la tradccion de admin
# ini franco 14/07/05
#****************************************************************************
$trans["admin_materials_listAddmaterialtypes"]                 = "\$text = 'Añadir nuevo tipo de material';";
$trans["admin_materials_listMaterialtypes"]                 = "\$text = 'Tipos de material:';";
$trans["admin_materials_listFunction"]                 = "\$text = 'Función';";
$trans["admin_materials_listDescription"]                 = "\$text = 'Descripción';";
$trans["admin_materials_listCheckoutlimit"]                 = "\$text = 'Límite de préstamo';";
$trans["admin_materials_listImageFile"]                 = "\$text = 'Archivo de Imagen';";
$trans["admin_materials_listBibcount"]                 = "\$text = 'Número<br>bibliografía';";
$trans["admin_materials_listAdult"]                 = "\$text = 'Adultos';";
$trans["admin_materials_listJuvenile"]                 = "\$text = 'Juvenil';";
$trans["admin_materials_listEdit"]                 = "\$text = 'editar';";
$trans["admin_materials_listDel"]                 = "\$text = 'borrar';";
$trans["admin_materials_listNote"]                 = "\$text = '*Nota:';";
$trans["admin_materials_listNoteText"]                 = "\$text = 'La función de borrado sólo está disponible en colecciones que tienen una cuenta bibliográfica de cero <br> si deseas borrar una colección con una cuenta bibliográfica mayor de cero primero tendrás que cambiar el tipo de material en esas bibliografías a otro tipo de material.';";
#****************************************************************************
#*  Translation text for page materials_edit_form.php
#ini franco 14/07/05
#****************************************************************************
$trans["admin_materials_delEditmaterialtype"]                 = "\$text = 'Editar tipo de material:';";
$trans["admin_materials_delDescription"]                 = "\$text = 'Descripción:';";
$trans["admin_materials_delAdultLimit"]                 = "\$text = 'Límite de préstamos adulto:';";
$trans["admin_materials_delunlimited"]                 = "\$text = '(0 significa ilimitado)';";
$trans["admin_materials_delJuvenileLimit"]                 = "\$text = 'Límite de préstamo juvenil:';";
$trans["admin_materials_delImagefile"]                 = "\$text = 'Archivo de imagen:';";
$trans["admin_materials_delNote"]                 = "\$text = '*Nota:';";
$trans["admin_materials_delNoteText"]                 = "\$text = 'Los archivos de imagen se localizarán en el directorio openbiblio/images.';";
$trans["admin_materials_editEnd"]                 = "\$text = ' actualizado.';";
$trans["admin_materials_newEnd"]                 = "\$text = ' creado.';";
$trans["admin_materials_delAreyousure"]                 = "\$text = ' Esta seguro que desea borrar el tipo de material ';";

#****************************************************************************
#*  Translation text for page materials_new_form.php ini franco 14/07/05
#****************************************************************************
$trans["admin_materials_new_formNoteText"]                 = "\$text = 'Los archivos de imagen se localizarán en el directorio openbibliof/images.';";

#****************************************************************************
#*  Common translation text shared among multiple pages ini franco 14/07/05
#****************************************************************************
$trans["adminSubmit"]              = "\$text = 'Enviar';";
$trans["adminCancel"]              = "\$text = 'Cancelar';";
$trans["adminDelete"]              = "\$text = 'Borrar';";
$trans["adminUpdate"]              = "\$text = 'Actualizar';";
$trans["adminFootnote"]            = "\$text = 'Los campos marcados con %symbol% son requeridos.';";
#****************************************************************************
#*  Translation text for page materials_del.php
#****************************************************************************
$trans["admin_materials_delMaterialType"]                 = "\$text = 'tipo de material, ';";
$trans["admin_materials_delMaterialdeleted"]                 = "\$text = ', ha sido borrado.';";
$trans["admin_materials_Return"]                 = "\$text = 'volver a la lista de tipo de material';";

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
$trans["adminCollections_edit_formDaysdueback"]                 = "\$text = 'Prestable:';";
$trans["adminCollections_edit_formDailyLateFee"]                 = "\$text = 'Multa diaria por retraso:';";
$trans["adminCollections_edit_formNote"]                 = "\$text = '';";
$trans["adminCollections_edit_formNoteText"]                 = "\$text = '';";

#****************************************************************************
#*  Translation text for page collections_list.php
#****************************************************************************
$trans["adminCollections_listAddNewCollection"]                 = "\$text = 'Añadir nueva colección';";
$trans["adminCollections_listCollections"]                 = "\$text = 'Colecciones:';";
$trans["adminCollections_listFunction"]                 = "\$text = 'Función';";
$trans["adminCollections_listDescription"]                 = "\$text = 'Descripción';";
$trans["adminCollections_listDaysdueback"]                 = "\$text = 'Prestable';";
$trans["adminCollections_listDailylatefee"]                 = "\$text = 'Diariamente<br>Multa por retraso';";
$trans["adminCollections_listBibliographycount"]                 = "\$text = 'Número<br>libros';";
$trans["adminCollections_listEdit"]                 = "\$text = 'editar';";
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
$trans["adminCollections_new_formNote"]                 = "\$text = '';";
$trans["adminCollections_new_formNoteText"]                 = "\$text = '';";

$trans["catalog_listMaterial_auditoria"]                 = "\$text = ' Material Pendiente de Aprobación:';";
#****************************************************************************
#*  Translation text for page aprueba_material.php
#****************************************************************************
$trans["catalog_bibid"]                 = "\$text = ' Id Material';";
$trans["catalog_copyid"]                 = "\$text = ' Id Ejemplar';";
$trans["cataloging_materials_view"]      ="\$text='Ver';";
$trans["catalog_materials_apruebaNoteText"]                 = "\$text = 'La función de ver sólo le permitira aprobar  <br> si deseas editarlo tenes q hacer otra cosa.';";
#****************************************************************************
#*  Translation text for page aprobar.php 28/07/05
#****************************************************************************
$trans["catalog_aprueba_material_Return"]                 = "\$text = ' Volver a la lista de materiales';";
$trans["catalog_materials_ApruebaMaterial"]                 = "\$text = ' El material: ';";
$trans["catalog_materials_MaterialAprobado"]                 = "\$text = ' fue aprobado satisfactoriamente ';";
#****************************************************************************
#*  Translation text for page aprobarEjemplar.php
#****************************************************************************
$trans["catalog_materials_ApruebaEjemplar"]                 = "\$text = ' El ejemplar: ';";
#****************************************************************************
#*  Translation text for page library_list.php 3/08/05
#****************************************************************************
$trans["catalogLibrary_listAddNewLibrary"]                 = "\$text = 'Añadir nueva biblioteca';";
$trans["catalogLibrary_list"]                 = "\$text = 'Bibliotecas:';";
$trans["catalogLibrary_listFunction"]                 = "\$text = 'Función';";
$trans["catalogLibrary_listDescription"]                 = "\$text = 'Descripción';";
$trans["catalogLibrary_ListNoteText"]                 = "\$text = ' PROXIMAMENTE: La función de borrado sólo está disponible en Bibliotecas que tengan una cuenta bibliográfica de cero.<br>Si deseas borrar una Biblioteca con una cuenta bibliográfica mayor de cero primero tendrás que reasignar los materiales y ejemplares de esa biblioteca a otra biblioteca.';";
#****************************************************************************
#*  Translation text for page library_new_form.php4/08/05
#****************************************************************************
$trans["catalogLibrary_new_formAddnewlibrary"]                 = "\$text = 'Añadir nueva Biblioteca:';";
$trans["catalogLibrary_new_formDescription"]                 = "\$text = 'Descripción:';";
$trans["catalogLibrary_new_formCode"]                 = "\$text = 'Código asignado:';";
$trans["catalogLibrary_new_formNote"]                 = "\$text = '*Nota:';";
$trans["catalogLibrary_new_formNoteText"]                 = "\$text = 'Tener en cuenta que el código es numérico y único.';";

#****************************************************************************
#*  Translation text for page biblio_ana_new_form.php and biblio_ana_edit_form.php
#****************************************************************************
$trans["biblioAnaliticaNewFormLabel"]   = "\$text = 'Añadir nueva analítica';";
$trans["biblioAnaliticaNewTitulo"]     = "\$text = 'Título';";
$trans["biblioAnaliticaNewSubTitulo"]     = "\$text = 'Subtítulo';";
$trans["biblioAnaliticaNewAutor"]        = "\$text = 'Autor';";
$trans["biblioAnaliticaNewPaginacion"]  = "\$text = 'Paginación';";
$trans["biblioAnaliticaNewMateria"] = "\$text = 'Materias';";
$trans["biblioAnaliticaUserCreador"] = "\$text = 'Usuario';";
$trans["biblioAnaliticaEditFormLabel"] = "\$text = 'Editar Analítica';";

#****************************************************************************
#*  Translation text for page biblio_analitica_new.php
#****************************************************************************
$trans["biblioAnaliticaNewSuccess"]     = "\$text = 'Analítica creada correctamente.';";

#****************************************************************************
#*  Translation text for page biblio_analitica_edit.php
#****************************************************************************
$trans["biblioAnaliticaEditSuccess"]    = "\$text = 'Analítica actualizada correctamente.';";

#****************************************************************************
#*  Translation text for page biblio_analitica_del_confirm.php
#****************************************************************************
//$trans["biblioCopyDelConfirmErr1"] = "\$text = 'No se pudo borrar el ejemplar.  Un ejemplar debe estar registrado antes de que pueda ser borrado.';";
$trans["biblioAnaDelConfirmMsg"]  = "\$text = 'Estás seguro de que quieres borrar la analítica con Título  %titulo%?  Esto también afectara al material.';";

#****************************************************************************
#*  Translation text for page biblio_analitica_del.php
#****************************************************************************
$trans["biblioAnaDelSuccess"]     = "\$text = 'Analítica con título %titulo% borrada correctamente.';";
?>
