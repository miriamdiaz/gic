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
$trans["circAdd"]                 = "\$text = 'A�adir';";
$trans["mbrDupBarcode"]           = "\$text = 'C�digo de barras, %barcode%, ya est� utilizado.';";

#****************************************************************************
#*  Translation text for page index.php
#****************************************************************************
$trans["indexHeading"]            = "\$text='Circulaci�n';";
$trans["indexCardHdr"]            = "\$text='Buscar usuario por n�mero de carnet:';";
$trans["indexCard"]               = "\$text='N�mero de DNI:';";
$trans["indexSearch"]             = "\$text='Buscar';";
$trans["indexNameHdr"]            = "\$text='Buscar usuario por apellido:';";
$trans["indexName"]               = "\$text='Apellido comienza por:';";

#****************************************************************************
#*  Translation text for page mbr_new_form.php, mbr_edit_form.php and mbr_fields.php
#****************************************************************************
$trans["mbrNewForm"]              = "\$text='A�adir nuevo';";
$trans["mbrEditForm"]             = "\$text='Editar';";
$trans["mbrFldsHeader"]           = "\$text='usuario:';";
$trans["mbrFldsCardNmbr"]         = "\$text='DNI:';";
$trans["mbrFldsLastName"]         = "\$text='Apellido:';";
$trans["mbrFldsFirstName"]        = "\$text='Nombre:';";
//DOS LINEAS MODIFICADAS: Horacio Alvarez FECHA: 24-03-06
$trans["mbrFldsAddr1"]            = "\$text='Direcci�n Particular:';";
$trans["mbrFldsAddr2"]            = "\$text='Direcci�n Laboral:';";
$trans["mbrFldsCity"]             = "\$text='Ciudad:';";
$trans["mbrFldsStateZip"]         = "\$text='Provincia, C�digo postal:';";
//LINEA AGREGADA: Horacio Alvarez FECHA: 24-03-06
$trans["mbrFldsLibraryid"]         = "\$text='Biblioteca:';";
//LINEA AGREGADA: Horacio Alvarez FECHA: 26-03-06
$trans["mbrFldsLimitePrestamos"]         = "\$text='L�mite de Pr�stamos:';";
//LINEA AGREGADA: Horacio Alvarez FECHA: 08-04-06
$trans["mbrFldsLimiteReservas"]         = "\$text='L�mite de Reservas:';";
$trans["mbrFldsHomePhone"]        = "\$text='Tel�fono:';";
$trans["mbrFldsWorkPhone"]        = "\$text='Tel�fono trabajo:';";
$trans["mbrFldsEmail"]            = "\$text='Email:';";
$trans["mbrFldsClassify"]         = "\$text='Clasificaci�n:';";
$trans["mbrFldsCarrera"]         = "\$text='Carrera:';";
$trans["mbrFldsTipoSancion"]         = "\$text='Tipo de Sanci�n:';";
$trans["mbrFldsGrade"]            = "\$text='Curso:';";
$trans["mbrFldsTeacher"]          = "\$text='Tutor:';";
$trans["mbrFldsObservaciones"]          = "\$text='Observaciones:';";
$trans["mbrFldsLimpiar"]          = "\$text='Limpiar Ultima Sanci�n:';";
$trans["mbrFldsSanciones"]          = "\$text='Usted registra:';";
$trans["mbrFldsSubmit"]           = "\$text='Enviar';";
$trans["mbrFldsCancel"]           = "\$text='Cancelar';";
$trans["mbrsearchResult"]         = "\$text='P�ginas de resultados: ';";
$trans["mbrsearchprev"]           = "\$text='ant';";
$trans["mbrsearchnext"]           = "\$text='sig';";
$trans["mbrsearchNoResults"]      = "\$text='No se encontr� registros.';";
$trans["mbrsearchFoundResults"]   = "\$text=' registros encontrados.';";
$trans["mbrsearchSearchResults"]  = "\$text='Resultados de la b�squeda:';";
$trans["mbrsearchCardNumber"]     = "\$text='DNI:';";
$trans["mbrsearchClassification"] = "\$text='Clasificaci�n:';";
$trans["mbrFechaVto"] = "\$text='Fecha Vencimiento:';";
$trans["mbrFechaSuspension"] = "\$text='Fecha Suspensi�n:';";

#****************************************************************************
#*  Translation text for page mbr_new.php
#****************************************************************************
$trans["mbrNewSuccess"]           = "\$text='Usuario a�adido a la base de datos correctamente.';";

#****************************************************************************
#*  Translation text for page mbr_edit.php
#****************************************************************************
$trans["mbrEditSuccess"]          = "\$text='Datos de usuario actualizados correctamente.';";

#****************************************************************************
#*  Translation text for page mbr_view.php
#****************************************************************************
$trans["mbrViewHead1"]            = "\$text='Informaci�n de usuarios:';";
$trans["mbrViewName"]             = "\$text='Nombre:';";
$trans["mbrViewAddr"]             = "\$text='Direcci�n:';";
$trans["mbrViewCardNmbr"]         = "\$text='DNI:';";
//3 LINEA AGREGADA: Horacio Alvarez FECHA: 25-03-06
$trans["mbrViewLibraryid"]         = "\$text='Biblioteca:';";
$trans["mbrViewLimitePrestamos"]         = "\$text='L�mite de Pr�stamos:';";
$trans["mbrViewCantidadPrestamos"]         = "\$text='Cantidad Actual de Pr�stamos:';";
$trans["mbrViewLimiteReservas"]         = "\$text='L�mite de Reservas:';";
$trans["mbrViewCantidadReservas"]         = "\$text='Cantidad Actual de Reservas:';";
$trans["mbrViewClassify"]         = "\$text='Clasificaci�n:';";
$trans["mbrViewPhone"]            = "\$text='Tel�fono:';";
$trans["mbrViewPhoneHome"]        = "\$text='P:';";
$trans["mbrViewPhoneWork"]        = "\$text='T:';";
$trans["mbrViewEmail"]            = "\$text='Email:';";
$trans["mbrViewGrade"]            = "\$text='Curso:';";
$trans["mbrViewTeacher"]          = "\$text='Tutor:';";
$trans["mbrViewHead2"]            = "\$text='Pr�stamos:';";
$trans["mbrViewStatColHdr1"]      = "\$text='Material';";
$trans["mbrViewStatColHdr2"]      = "\$text='Cantidad';";
$trans["mbrViewStatColHdr3"]      = "\$text='L�mite';";
$trans["mbrViewHead3"]            = "\$text='Pr�stamo:';";
$trans["mbrViewBarcode"]          = "\$text='C�digo de barras:';";
//LINEA AGREGADA: Horacio Alvarez
$trans["mbrViewErrorLimiteSuperado"]          = "\$text='El usuario ha superado el l�mite de pr�stamos';";
$trans["mbrViewErrorSancionado"]          = "\$text='El usuario se encuentra sancionado hasta el ';";
$trans["mbrViewCheckOut"]         = "\$text='Prestar';";
$trans["mbrViewHead4"]            = "\$text='Material actualmente prestado:';";
$trans["mbrViewOutHdr1"]          = "\$text='Prestado';";
$trans["mbrViewOutHdr2"]          = "\$text='Material';";
$trans["mbrViewOutHdr3"]          = "\$text='C�d. Barras';";
$trans["mbrViewOutHdr4"]          = "\$text='T�tulo';";
$trans["mbrViewOutHdr5"]          = "\$text='Autor';";
$trans["mbrViewOutHdr6"]          = "\$text='Devoluci�n';";
$trans["mbrViewOutHdr7"]          = "\$text='D�as retraso';";
//LINEA AGREGADA: Horacio Alvarez 01-04-06
$trans["mbrViewOutHdr8"]          = "\$text='Operador';";
//LINEA AGREGADA: Horacio Alvarez 20-04-06
$trans["mbrViewOutHdr9"]          = "\$text='Seleccionar';";
$trans["mbrViewOutHdr10"]          = "\$text='1� Infraccion';";
$trans["mbrViewOutHdr11"]          = "\$text='Reservado';";
$trans["mbrViewNoCheckouts"]      = "\$text='No tiene material prestado.';";
$trans["mbrViewHead5"]            = "\$text='Consulta:';";
$trans["mbrViewHead6"]            = "\$text='Material actualmente en reserva:';";
$trans["mbrViewPlaceHold"]        = "\$text='Reservar';";
$trans["mbrViewHoldHdr1"]         = "\$text='Funci�n';";
$trans["mbrViewHoldHdr2"]         = "\$text='En reserva';";
$trans["mbrViewHoldHdr3"]         = "\$text='Material';";
$trans["mbrViewHoldHdr4"]         = "\$text='C�digo de barras';";
$trans["mbrViewHoldHdr5"]         = "\$text='T�tulo';";
$trans["mbrViewHoldHdr6"]         = "\$text='Autor';";
$trans["mbrViewHoldHdr7"]         = "\$text='Estado';";
$trans["mbrViewHoldHdr8"]         = "\$text='Fecha de devoluci�n';";
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
$trans["checkoutErr1"]            = "\$text='El n�mero del c�digo de barras debe ser completamente alfanum�rico.';";
$trans["checkoutErr2"]            = "\$text='No se encontr� bibliograf�a con ese c�digo de barras.';";
$trans["checkoutErr3"]            = "\$text='La bibliograf�a con el c�digo de barras %barcode% ya ha sido prestada.';";
$trans["checkoutErr4"]            = "\$text='La bibliograf�a con c�digo de barras n�mero %barcode% no est� disponible para el pr�stamo.';";
$trans["checkoutErr5"]            = "\$text='La bibliograf�a con c�digo de barras n�mero %barcode% est� actualmente siendo utilizada por otro usuario.';";
$trans["checkoutErr6"]            = "\$text='El usuario ha alcanzado el tiempo l�mite de pr�stamo en el tipo de material bibliogr�fico especificado.';";
$trans["checkoutErr7"]            = "\$text='Este usuario ya alcanz� el limite de Reservas.';";
$trans["checkoutErr9"]          = "\$text='Este usuario ya expir� su fecha de validaci�n en el sistema.';";
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
$trans["shelvingCartErr1"]        = "\$text='El n�mero del c�digo de barras debe ser completamente alfanum�rico.';";
$trans["shelvingCartErr2"]        = "\$text='No se encontr� ninguna bibliograf�a con ese n�mero de c�digo de barras.';";
$trans["shelvingCartErr3"]        = "\$text='Este material ya se encuentra en el carrito o en estanteria';";
$trans["shelvingCartTrans"]       = "\$text='Multa por retraso en la devoluci�n (barcode=%barcode%)';";

#****************************************************************************
#*  Translation text for page checkin_form.php
#****************************************************************************
$trans["checkinFormHdr1"]         = "\$text='Devoluci�n:';";
$trans["checkinFormBarcode"]      = "\$text='C�digo de barras:';";
$trans["checkinFormShelveButton"] = "\$text='A�adir al carrito de reposici�n';";
$trans["checkinFormRenovarButton"] = "\$text='Renovar Pr�stamo';";
$trans["checkinFormCheckinLink1"] = "\$text='Devolver el material seleccionado';";
$trans["checkinFormCheckinLink2"] = "\$text='Devolver todo';";
$trans["checkinFormHdr2"]         = "\$text='Lista actual del carrito de reposici�n:';";
$trans["checkinFormColHdr1"]      = "\$text='Fecha de escaneado';";
$trans["checkinFormColHdr2"]      = "\$text='C�digo de barras';";
$trans["checkinFormColHdr3"]      = "\$text='T�tulo';";
$trans["checkinFormColHdr4"]      = "\$text='Autor';";
$trans["checkinFormColHdr5"]      = "\$text='Usuario - Dni';";
$trans["checkinFormColHdr6"]      = "\$text='Operador';";
$trans["checkinFormEmptyCart"]    = "\$text='En la actualidad no hay bibliograf�as en el carrito de reposici�n.';";

#****************************************************************************
#*  Translation text for page checkin.php
#****************************************************************************
$trans["checkinErr1"]             = "\$text='No se ha seleccionado ning�n art�culo.';";

#****************************************************************************
#*  Translation text for page hold_message.php
#****************************************************************************
$trans["holdMessageHdr"]          = "\$text='La bibliograf�a est� reservada!';";
$trans["holdMessageMsg1"]         = "\$text='La bibliograf�a con n�mero de c�digo de barras %barcode% fue reservado por %nombre% %apellido% DNI: %dni% para el dia %fecha%.';";
$trans["holdMessageMsg2"]         = "\$text='Volver a la devoluci�n de bibliograf�a.';";

#****************************************************************************
#*  Translation text for page place_hold.php
#****************************************************************************
$trans["placeHoldErr1"]           = "\$text='El c�digo de barras debe ser num�rico.';";
$trans["placeHoldErr3"]           = "\$text='Este usuario ya posee este libro prestado.';";
$trans["placeHoldErr4"]           = "\$text='Este libro no se puede reservar, no esta prestado.';";
$trans["placeHoldErr5"]           = "\$text='Este libro ya se encuentra reservado por este usuario.';";
$trans["placeHoldErr6"]           = "\$text='Este libro ya se encuentra reservado.';";



#****************************************************************************
#*  Translation text for page mbr_del_confirm.php
#****************************************************************************
$trans["mbrDelConfirmWarn"]       = "\$text = 'El usuario, %name%, tiene %checkoutCount% pr�stamos y %holdCount% reservas.  Todos los materiales prestados beben ser devueltos y todas las reservas borradas antes de borrar a este usuario.';";
$trans["mbrDelConfirmReturn"]     = "\$text = 'Volver a la informaci�n del usuario';";
$trans["mbrDelConfirmMsg"]        = "\$text = 'Est�s seguro de que quieres borrar al usuario, %name%?  Esto tambi�n borrar� todo el historial de pr�stamos de este usuario.';";

#****************************************************************************
#*  Translation text for page mbr_del.php
#****************************************************************************
$trans["mbrDelSuccess"]           = "\$text='Usuario, %name%, borrado.';";
$trans["mbrDelReturn"]            = "\$text='Volver a Buscar usuario';";

#****************************************************************************
#*  Translation text for page mbr_history.php
#****************************************************************************
$trans["mbrHistoryHead1"]         = "\$text='Historial de pr�stamo del usuario:';";
$trans["mbrHistorySancionHead1"]         = "\$text='Historial de sanciones del usuario:';";
$trans["mbrHistoryNoHist"]        = "\$text='No se encontr� ning�n historial.';";
$trans["mbrHistoryHdr1"]          = "\$text='C�digo de barras';";
$trans["mbrHistoryHdr2"]          = "\$text='T�tulo';";
$trans["mbrHistorySancionHdr2"]          = "\$text='Devoluci�n Real';";
$trans["mbrHistorySancionHdr6"]          = "\$text='Fecha de Aplicaci�n';";
$trans["mbrHistoryHdr3"]          = "\$text='Autor';";
$trans["mbrHistorySancionHdr3"]          = "\$text='Nro. de Infracci�n';";
$trans["mbrHistorySancionHdr4"]          = "\$text='Suspendido Hasta';";
$trans["mbrHistorySancionHdr5"]          = "\$text='Cantidad de D�as';";
$trans["mbrHistorySancionHdr6"]          = "\$text='Devoluci�n Acordada';";
$trans["mbrHistoryHdr4"]          = "\$text='Nuevo estado';";
$trans["mbrHistoryHdr5"]          = "\$text='Fecha de cambio de estado';";
$trans["mbrHistoryHdr6"]          = "\$text='Fecha de devoluci�n';";
$trans["mbrHistoryHdr7"]          = "\$text='Usuario';";

#****************************************************************************
#*  Translation text for page mbr_account.php
#****************************************************************************
$trans["mbrAccountLabel"]         = "\$text='A�adir una transacci�n:';";
$trans["mbrAccountTransTyp"]      = "\$text='Tipo de transacci�n:';";
$trans["mbrAccountAmount"]        = "\$text='Cantidad:';";
$trans["mbrAccountDesc"]          = "\$text='Descripci�n:';";
$trans["mbrAccountHead1"]         = "\$text='Transacciones de cuenta del usuario:';";
$trans["mbrAccountNoTrans"]       = "\$text='No se encontraron transacciones.';";
$trans["mbrAccountOpenBal"]       = "\$text='Balance de apertura';";
$trans["mbrAccountDel"]           = "\$text='borrar';";
$trans["mbrAccountHdr1"]          = "\$text='Funci�n';";
$trans["mbrAccountHdr2"]          = "\$text='Fecha';";
$trans["mbrAccountHdr3"]          = "\$text='Tipo de transacci�n';";
$trans["mbrAccountHdr4"]          = "\$text='Descripci�n';";
$trans["mbrAccountHdr5"]          = "\$text='Cantidad';";
$trans["mbrAccountHdr6"]          = "\$text='Balance';";

#****************************************************************************
#*  Translation text for page mbr_transaction.php
#****************************************************************************
$trans["mbrTransactionSuccess"]   = "\$text='Transacci�n completada correctamente.';";

#****************************************************************************
#*  Translation text for page mbr_transaction_del_confirm.php
#****************************************************************************
$trans["mbrTransDelConfirmMsg"]   = "\$text='Est�s seguro de que quieres borrar esta transacci�n?';";

#****************************************************************************
#*  Translation text for page mbr_transaction_del.php
#****************************************************************************
$trans["mbrTransactionDelSuccess"] = "\$text='Transacci�n borrada correctamente.';";

#****************************************************************************
#*  Translation text for page mbr_print_checkouts.php
#****************************************************************************
$trans["mbrPrintCheckoutsTitle"]  = "\$text='Pr�stamos de %mbrName%';";
$trans["mbrPrintCheckoutsHdr1"]   = "\$text='Fecha:';";
$trans["mbrPrintCheckoutsHdr2"]   = "\$text='Usuario:';";
$trans["mbrPrintCheckoutsHdr3"]   = "\$text='N�mero de DNI:';";
$trans["mbrPrintCheckoutsHdr4"]   = "\$text='Clasificaci�n:';";
$trans["mbrPrintCheckoutsHdr5"]   = "\$text='Usted Registra:';";
$trans["mbrPrintCheckoutsHdr6"]   = "\$text='Se�or Usuario:';";
$trans["mbrPrintCheckoutsLeyendaSancion"]   = "\$text='La devoluci�n del material bibliogr�fico, realizada fuera de la fecha establecida,  
      ocasiona la aplicaci�n autom�tica de sanciones por cada d�a h�bil de retraso.  
      Para su mejor informaci�n consulte la reglamentaci�n vigente.';";
$trans["mbrPrintCloseWindow"]     = "\$text='Cerrar Ventana';";
$trans["mbrPrintCheckoutsOriginal"]  = "\$text=' [original]';";
$trans["mbrPrintCheckoutsDuplicado"]  = "\$text=' [duplicado]';";

#****************************************************************************
#*  Translation text for page member_online.php	
#****************************************************************************

$trans["indexHeadingMemberOnline"]      = "\$text = 'Consulta Online de usuario';";
$trans["member_WelcomeMsg"]      = "\$text = 'Desde aqu� usted podr� consultar sus pr�stamos y tendr� la posibilidad de reservar material';";
$trans["shelvingConfirmMsg"]        = "\$text = ' %name%  posee el libro actualmente. Desea continuar ?.';";
$trans["shelvingConfirmMsgAccept"]        = "\$text = 'Aceptar';";

?>
