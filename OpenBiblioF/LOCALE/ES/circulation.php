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
$trans["circCancel"]              = "\$text = 'Cancelar';";
$trans["circDelete"]              = "\$text = 'Borrar';";
$trans["circLogout"]              = "\$text = 'Salir';";
$trans["circAdd"]                 = "\$text = 'Añadir';";
$trans["mbrDupBarcode"]           = "\$text = 'Código de barras, %barcode%, ya está utilizado.';";

#****************************************************************************
#*  Translation text for page index.php
#****************************************************************************
$trans["indexHeading"]            = "\$text='Circulación';";
$trans["indexCardHdr"]            = "\$text='Buscar usuario por número de carnet:';";
$trans["indexCard"]               = "\$text='Número de DNI:';";
$trans["indexSearch"]             = "\$text='Buscar';";
$trans["indexNameHdr"]            = "\$text='Buscar usuario por apellido:';";
$trans["indexName"]               = "\$text='Apellido comienza por:';";

#****************************************************************************
#*  Translation text for page mbr_new_form.php, mbr_edit_form.php and mbr_fields.php
#****************************************************************************
$trans["mbrNewForm"]              = "\$text='Añadir nuevo';";
$trans["mbrEditForm"]             = "\$text='Editar';";
$trans["mbrFldsHeader"]           = "\$text='usuario:';";
$trans["mbrFldsCardNmbr"]         = "\$text='DNI:';";
$trans["mbrFldsLastName"]         = "\$text='Apellido:';";
$trans["mbrFldsFirstName"]        = "\$text='Nombre:';";
//DOS LINEAS MODIFICADAS: Horacio Alvarez FECHA: 24-03-06
$trans["mbrFldsAddr1"]            = "\$text='Dirección Particular:';";
$trans["mbrFldsAddr2"]            = "\$text='Dirección Laboral:';";
$trans["mbrFldsCity"]             = "\$text='Ciudad:';";
$trans["mbrFldsStateZip"]         = "\$text='Provincia, Código postal:';";
//LINEA AGREGADA: Horacio Alvarez FECHA: 24-03-06
$trans["mbrFldsLibraryid"]         = "\$text='Biblioteca:';";
//LINEA AGREGADA: Horacio Alvarez FECHA: 26-03-06
$trans["mbrFldsLimitePrestamos"]         = "\$text='Límite de Préstamos:';";
//LINEA AGREGADA: Horacio Alvarez FECHA: 08-04-06
$trans["mbrFldsLimiteReservas"]         = "\$text='Límite de Reservas:';";
$trans["mbrFldsHomePhone"]        = "\$text='Teléfono:';";
$trans["mbrFldsWorkPhone"]        = "\$text='Teléfono trabajo:';";
$trans["mbrFldsEmail"]            = "\$text='Email:';";
$trans["mbrFldsClassify"]         = "\$text='Clasificación:';";
$trans["mbrFldsCarrera"]         = "\$text='Carrera:';";
$trans["mbrFldsTipoSancion"]         = "\$text='Tipo de Sanción:';";
$trans["mbrFldsGrade"]            = "\$text='Curso:';";
$trans["mbrFldsTeacher"]          = "\$text='Tutor:';";
$trans["mbrFldsObservaciones"]          = "\$text='Observaciones:';";
$trans["mbrFldsLimpiar"]          = "\$text='Limpiar Ultima Sanción:';";
$trans["mbrFldsSanciones"]          = "\$text='Usted registra:';";
$trans["mbrFldsSubmit"]           = "\$text='Enviar';";
$trans["mbrFldsCancel"]           = "\$text='Cancelar';";
$trans["mbrsearchResult"]         = "\$text='Páginas de resultados: ';";
$trans["mbrsearchprev"]           = "\$text='ant';";
$trans["mbrsearchnext"]           = "\$text='sig';";
$trans["mbrsearchNoResults"]      = "\$text='No se encontró registros.';";
$trans["mbrsearchFoundResults"]   = "\$text=' registros encontrados.';";
$trans["mbrsearchSearchResults"]  = "\$text='Resultados de la búsqueda:';";
$trans["mbrsearchCardNumber"]     = "\$text='DNI:';";
$trans["mbrsearchClassification"] = "\$text='Clasificación:';";
$trans["mbrFechaVto"] = "\$text='Fecha Vencimiento:';";
$trans["mbrFechaSuspension"] = "\$text='Fecha Suspensión:';";

#****************************************************************************
#*  Translation text for page mbr_new.php
#****************************************************************************
$trans["mbrNewSuccess"]           = "\$text='Usuario añadido a la base de datos correctamente.';";

#****************************************************************************
#*  Translation text for page mbr_edit.php
#****************************************************************************
$trans["mbrEditSuccess"]          = "\$text='Datos de usuario actualizados correctamente.';";

#****************************************************************************
#*  Translation text for page mbr_view.php
#****************************************************************************
$trans["mbrViewHead1"]            = "\$text='Información de usuarios:';";
$trans["mbrViewName"]             = "\$text='Nombre:';";
$trans["mbrViewAddr"]             = "\$text='Dirección:';";
$trans["mbrViewCardNmbr"]         = "\$text='DNI:';";
//3 LINEA AGREGADA: Horacio Alvarez FECHA: 25-03-06
$trans["mbrViewLibraryid"]         = "\$text='Biblioteca:';";
$trans["mbrViewLimitePrestamos"]         = "\$text='Límite de Préstamos:';";
$trans["mbrViewCantidadPrestamos"]         = "\$text='Cantidad Actual de Préstamos:';";
$trans["mbrViewLimiteReservas"]         = "\$text='Límite de Reservas:';";
$trans["mbrViewCantidadReservas"]         = "\$text='Cantidad Actual de Reservas:';";
$trans["mbrViewClassify"]         = "\$text='Clasificación:';";
$trans["mbrViewPhone"]            = "\$text='Teléfono:';";
$trans["mbrViewPhoneHome"]        = "\$text='P:';";
$trans["mbrViewPhoneWork"]        = "\$text='T:';";
$trans["mbrViewEmail"]            = "\$text='Email:';";
$trans["mbrViewGrade"]            = "\$text='Curso:';";
$trans["mbrViewTeacher"]          = "\$text='Tutor:';";
$trans["mbrViewHead2"]            = "\$text='Préstamos:';";
$trans["mbrViewStatColHdr1"]      = "\$text='Material';";
$trans["mbrViewStatColHdr2"]      = "\$text='Cantidad';";
$trans["mbrViewStatColHdr3"]      = "\$text='Límite';";
$trans["mbrViewHead3"]            = "\$text='Préstamo:';";
$trans["mbrViewBarcode"]          = "\$text='Código de barras:';";
//LINEA AGREGADA: Horacio Alvarez
$trans["mbrViewErrorLimiteSuperado"]          = "\$text='El usuario ha superado el límite de préstamos';";
$trans["mbrViewErrorSancionado"]          = "\$text='El usuario se encuentra sancionado hasta el ';";
$trans["mbrViewCheckOut"]         = "\$text='Prestar';";
$trans["mbrViewHead4"]            = "\$text='Material actualmente prestado:';";
$trans["mbrViewOutHdr1"]          = "\$text='Prestado';";
$trans["mbrViewOutHdr2"]          = "\$text='Material';";
$trans["mbrViewOutHdr3"]          = "\$text='Cód. Barras';";
$trans["mbrViewOutHdr4"]          = "\$text='Título';";
$trans["mbrViewOutHdr5"]          = "\$text='Autor';";
$trans["mbrViewOutHdr6"]          = "\$text='Devolución';";
$trans["mbrViewOutHdr7"]          = "\$text='Días retraso';";
//LINEA AGREGADA: Horacio Alvarez 01-04-06
$trans["mbrViewOutHdr8"]          = "\$text='Operador';";
//LINEA AGREGADA: Horacio Alvarez 20-04-06
$trans["mbrViewOutHdr9"]          = "\$text='Seleccionar';";
$trans["mbrViewOutHdr10"]          = "\$text='1ª Infraccion';";
$trans["mbrViewOutHdr11"]          = "\$text='Reservado';";
$trans["mbrViewNoCheckouts"]      = "\$text='No tiene material prestado.';";
$trans["mbrViewHead5"]            = "\$text='Consulta:';";
$trans["mbrViewHead6"]            = "\$text='Material actualmente en reserva:';";
$trans["mbrViewPlaceHold"]        = "\$text='Reservar';";
$trans["mbrViewHoldHdr1"]         = "\$text='Función';";
$trans["mbrViewHoldHdr2"]         = "\$text='En reserva';";
$trans["mbrViewHoldHdr3"]         = "\$text='Material';";
$trans["mbrViewHoldHdr4"]         = "\$text='Código de barras';";
$trans["mbrViewHoldHdr5"]         = "\$text='Título';";
$trans["mbrViewHoldHdr6"]         = "\$text='Autor';";
$trans["mbrViewHoldHdr7"]         = "\$text='Estado';";
$trans["mbrViewHoldHdr8"]         = "\$text='Fecha de devolución';";
//LINEA AGREGADA: Horacio Alvarez 17-04-06
$trans["mbrViewHoldHdr9"]         = "\$text='Usuario';";
$trans["mbrViewNoHolds"]          = "\$text='No tiene material en reserva.';";
$trans["mbrViewBalMsg"]           = "\$text='Nota: el usuario tiene un saldo pendiente en su cuenta de %bal%.';";
$trans["mbrPrintCheckouts"]	  = "\$text='Imprimir los saldos pendientes';";
$trans["mbrViewDel"]              = "\$text='Eliminar';";
//LINEA AGREGADA: Horacio Alvarez 17-04-06
$trans["mbrViewPrestar"]              = "\$text='Prestar';";



#****************************************************************************
#*  Translation text for page checkout.php
#****************************************************************************
$trans["checkoutBalErr"]          = "\$text='Los usuarios deben pagar el saldo pendiente en su cuenta antes de sacar un libro.';";
$trans["checkoutErr8"]          = "\$text='Este libro no pertenece a esta biblioteca.';";
$trans["checkoutErr1"]            = "\$text='El número del código de barras debe ser completamente alfanumérico.';";
$trans["checkoutErr2"]            = "\$text='No se encontró bibliografía con ese código de barras.';";
$trans["checkoutErr3"]            = "\$text='La bibliografía con el código de barras %barcode% ya ha sido prestada.';";
$trans["checkoutErr4"]            = "\$text='La bibliografía con código de barras número %barcode% no está disponible para el préstamo.';";
$trans["checkoutErr5"]            = "\$text='La bibliografía con código de barras número %barcode% está actualmente siendo utilizada por otro usuario.';";
$trans["checkoutErr6"]            = "\$text='El usuario ha alcanzado el tiempo límite de préstamo en el tipo de material bibliográfico especificado.';";
$trans["checkoutErr7"]            = "\$text='Este usuario ya alcanzó el limite de Reservas.';";
$trans["checkoutErr9"]          = "\$text='Este usuario ya expiró su fecha de validación en el sistema.';";
/**
Agregado todo lo referente a tipo de prestamos: Horacio Alvarez
Fecha: 22-03-06	
*/

#****************************************************************************
#*  Translation text for page elegir_tipo_prestamo.php
#****************************************************************************
$trans["adminCollections_new_formTipo_prestamo"]          = "\$text='Tipo de Prestamos';";

#****************************************************************************
#*  Translation text for page shelving_cart.php
#****************************************************************************
$trans["shelvingCartErr1"]        = "\$text='El número del código de barras debe ser completamente alfanumérico.';";
$trans["shelvingCartErr2"]        = "\$text='No se encontró ninguna bibliografía con ese número de código de barras.';";
$trans["shelvingCartErr3"]        = "\$text='Este material ya se encuentra en el carrito o en estanteria';";
$trans["shelvingCartTrans"]       = "\$text='Multa por retraso en la devolución (barcode=%barcode%)';";

#****************************************************************************
#*  Translation text for page checkin_form.php
#****************************************************************************
$trans["checkinFormHdr1"]         = "\$text='Devolución:';";
$trans["checkinFormBarcode"]      = "\$text='Código de barras:';";
$trans["checkinFormShelveButton"] = "\$text='Añadir al carrito de reposición';";
$trans["checkinFormRenovarButton"] = "\$text='Renovar Préstamo';";
$trans["checkinFormCheckinLink1"] = "\$text='Devolver el material seleccionado';";
$trans["checkinFormCheckinLink2"] = "\$text='Devolver todo';";
$trans["checkinFormHdr2"]         = "\$text='Lista actual del carrito de reposición:';";
$trans["checkinFormColHdr1"]      = "\$text='Fecha de escaneado';";
$trans["checkinFormColHdr2"]      = "\$text='Código de barras';";
$trans["checkinFormColHdr3"]      = "\$text='Título';";
$trans["checkinFormColHdr4"]      = "\$text='Autor';";
$trans["checkinFormColHdr5"]      = "\$text='Usuario - Dni';";
$trans["checkinFormColHdr6"]      = "\$text='Operador';";
$trans["checkinFormEmptyCart"]    = "\$text='En la actualidad no hay bibliografías en el carrito de reposición.';";

#****************************************************************************
#*  Translation text for page checkin.php
#****************************************************************************
$trans["checkinErr1"]             = "\$text='No se ha seleccionado ningún artículo.';";

#****************************************************************************
#*  Translation text for page hold_message.php
#****************************************************************************
$trans["holdMessageHdr"]          = "\$text='La bibliografía está reservada!';";
$trans["holdMessageMsg1"]         = "\$text='La bibliografía con número de código de barras %barcode% fue reservado por %nombre% %apellido% DNI: %dni% para el dia %fecha%.';";
$trans["holdMessageMsg2"]         = "\$text='Volver a la devolución de bibliografía.';";

#****************************************************************************
#*  Translation text for page place_hold.php
#****************************************************************************
$trans["placeHoldErr1"]           = "\$text='El código de barras debe ser numérico.';";
$trans["placeHoldErr3"]           = "\$text='Este usuario ya posee este libro prestado.';";
$trans["placeHoldErr4"]           = "\$text='Este libro no se puede reservar, no esta prestado.';";
$trans["placeHoldErr5"]           = "\$text='Este libro ya se encuentra reservado por este usuario.';";
$trans["placeHoldErr6"]           = "\$text='Este libro ya se encuentra reservado.';";



#****************************************************************************
#*  Translation text for page mbr_del_confirm.php
#****************************************************************************
$trans["mbrDelConfirmWarn"]       = "\$text = 'El usuario, %name%, tiene %checkoutCount% préstamos y %holdCount% reservas.  Todos los materiales prestados beben ser devueltos y todas las reservas borradas antes de borrar a este usuario.';";
$trans["mbrDelConfirmReturn"]     = "\$text = 'Volver a la información del usuario';";
$trans["mbrDelConfirmMsg"]        = "\$text = 'Estás seguro de que quieres borrar al usuario, %name%?  Esto también borrará todo el historial de préstamos de este usuario.';";

#****************************************************************************
#*  Translation text for page mbr_del.php
#****************************************************************************
$trans["mbrDelSuccess"]           = "\$text='Usuario, %name%, borrado.';";
$trans["mbrDelReturn"]            = "\$text='Volver a Buscar usuario';";

#****************************************************************************
#*  Translation text for page mbr_history.php
#****************************************************************************
$trans["mbrHistoryHead1"]         = "\$text='Historial de préstamo del usuario:';";
$trans["mbrHistorySancionHead1"]         = "\$text='Historial de sanciones del usuario:';";
$trans["mbrHistoryNoHist"]        = "\$text='No se encontró ningún historial.';";
$trans["mbrHistoryHdr1"]          = "\$text='Código de barras';";
$trans["mbrHistoryHdr2"]          = "\$text='Título';";
$trans["mbrHistorySancionHdr2"]          = "\$text='Devolución Real';";
$trans["mbrHistorySancionHdr6"]          = "\$text='Fecha de Aplicación';";
$trans["mbrHistoryHdr3"]          = "\$text='Autor';";
$trans["mbrHistorySancionHdr3"]          = "\$text='Nro. de Infracción';";
$trans["mbrHistorySancionHdr4"]          = "\$text='Suspendido Hasta';";
$trans["mbrHistorySancionHdr5"]          = "\$text='Cantidad de Días';";
$trans["mbrHistorySancionHdr6"]          = "\$text='Devolución Acordada';";
$trans["mbrHistoryHdr4"]          = "\$text='Nuevo estado';";
$trans["mbrHistoryHdr5"]          = "\$text='Fecha de cambio de estado';";
$trans["mbrHistoryHdr6"]          = "\$text='Fecha de devolución';";
$trans["mbrHistoryHdr7"]          = "\$text='Usuario';";

#****************************************************************************
#*  Translation text for page mbr_account.php
#****************************************************************************
$trans["mbrAccountLabel"]         = "\$text='Añadir una transacción:';";
$trans["mbrAccountTransTyp"]      = "\$text='Tipo de transacción:';";
$trans["mbrAccountAmount"]        = "\$text='Cantidad:';";
$trans["mbrAccountDesc"]          = "\$text='Descripción:';";
$trans["mbrAccountHead1"]         = "\$text='Transacciones de cuenta del usuario:';";
$trans["mbrAccountNoTrans"]       = "\$text='No se encontraron transacciones.';";
$trans["mbrAccountOpenBal"]       = "\$text='Balance de apertura';";
$trans["mbrAccountDel"]           = "\$text='borrar';";
$trans["mbrAccountHdr1"]          = "\$text='Función';";
$trans["mbrAccountHdr2"]          = "\$text='Fecha';";
$trans["mbrAccountHdr3"]          = "\$text='Tipo de transacción';";
$trans["mbrAccountHdr4"]          = "\$text='Descripción';";
$trans["mbrAccountHdr5"]          = "\$text='Cantidad';";
$trans["mbrAccountHdr6"]          = "\$text='Balance';";

#****************************************************************************
#*  Translation text for page mbr_transaction.php
#****************************************************************************
$trans["mbrTransactionSuccess"]   = "\$text='Transacción completada correctamente.';";

#****************************************************************************
#*  Translation text for page mbr_transaction_del_confirm.php
#****************************************************************************
$trans["mbrTransDelConfirmMsg"]   = "\$text='Estás seguro de que quieres borrar esta transacción?';";

#****************************************************************************
#*  Translation text for page mbr_transaction_del.php
#****************************************************************************
$trans["mbrTransactionDelSuccess"] = "\$text='Transacción borrada correctamente.';";

#****************************************************************************
#*  Translation text for page mbr_print_checkouts.php
#****************************************************************************
$trans["mbrPrintCheckoutsTitle"]  = "\$text='Préstamos de %mbrName%';";
$trans["mbrPrintCheckoutsHdr1"]   = "\$text='Fecha:';";
$trans["mbrPrintCheckoutsHdr2"]   = "\$text='Usuario:';";
$trans["mbrPrintCheckoutsHdr3"]   = "\$text='Número de DNI:';";
$trans["mbrPrintCheckoutsHdr4"]   = "\$text='Clasificación:';";
$trans["mbrPrintCheckoutsHdr5"]   = "\$text='Usted Registra:';";
$trans["mbrPrintCheckoutsHdr6"]   = "\$text='Señor Usuario:';";
$trans["mbrPrintCheckoutsLeyendaSancion"]   = "\$text='La devolución del material bibliográfico, realizada fuera de la fecha establecida,  
      ocasiona la aplicación automática de sanciones por cada día hábil de retraso.  
      Para su mejor información consulte la reglamentación vigente.';";
$trans["mbrPrintCloseWindow"]     = "\$text='Cerrar Ventana';";
$trans["mbrPrintCheckoutsOriginal"]  = "\$text=' [original]';";
$trans["mbrPrintCheckoutsDuplicado"]  = "\$text=' [duplicado]';";

#****************************************************************************
#*  Translation text for page member_online.php	
#****************************************************************************

$trans["indexHeadingMemberOnline"]      = "\$text = 'Consulta Online de usuario';";
$trans["member_WelcomeMsg"]      = "\$text = 'Desde aquí usted podrá consultar sus préstamos y tendrá la posibilidad de reservar material';";
$trans["shelvingConfirmMsg"]        = "\$text = ' %name%  posee el libro actualmente. Desea continuar ?.';";
$trans["shelvingConfirmMsgAccept"]        = "\$text = 'Aceptar';";

?>
