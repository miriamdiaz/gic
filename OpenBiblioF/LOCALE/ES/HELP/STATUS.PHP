<h1>Comprendiendo estados de cambios de bibliograf�a:</h1>
La siguiente tabla lista los posibles estados de un ejemplar.<br><br>
<table class="primary">
  <tr><th>Estado</th><th>Descripci�n</th></tr>
  <tr><td class="primary" valign="top">Disponible</td><td class="primary">La bibliograf�a es archivada y disponible para pr�stamos.</td></tr>
  <tr><td class="primary" valign="top">Prestado</td><td class="primary">La bibliograf�a ha sido prestada a un socio de la biblioteca.</td></tr>
  <tr><td class="primary" valign="top">Reservado</td><td class="primary">La bilbiograf�a es reservada para el socio que se encuentra en la lista de espera de un ejemplar. </td></tr>
  <tr><td class="primary" valign="top">Carrito de reposici�n en estanter�a</td><td class="primary">La bilbiograf�a se encuentra en el carrito de reposici�n a la espera de ser archivada en la estanter�a.</td></tr>
  <tr><td class="primary" valign="top">Da�ado/En reparaci�n</td><td class="primary">La bibliograf�a est� siendo reparada debido a que presentaba da�os.</td></tr>
  <tr><td class="primary" valign="top">Zona de visualizaci�n</td><td class="primary">La bibliograf�a no est� disponible para pr�stamos porque se encuentra en zona de visualizaci�n.</td></tr>
  <tr><td class="primary" valign="top">Perdido/Extraviado</td><td class="primary">La bibliograf�a no est� disponible para pr�stamos porque se encuentra extraviada.</td></tr>
  <tr><td class="primary" valign="top">on loan?</td><td class="primary">Bibliography is on loan.?</td></tr>
  <tr><td class="primary" valign="top">En pedido</td><td class="primary">La bibliograf�a est� en pedido y a�n no ha llegado.</td></tr>
</table>
<br>
Los cambios de estados de la bibliograf�a que son permitidos bajo las siguientes reglas.<br><br>
<table class="primary">
  <tr><th>P�gina</th><th>Estado antiguo</th><th>Estado nuevo</th><th>Reglas</th></tr>
  <tr>
    <td class="primary" valign="top" rowspan="3">Informaci�n del socio</td>
    <td class="primary" valign="top">Disponible</td>
    <td class="primary" valign="top">Prestado</td>
    <td class="primary" valign="top"></td>
  </tr>
  <tr>
    <td class="primary" valign="top">Otro<sup>*</sup></td>
    <td class="primary" valign="top">Prestado</td>
    <td class="primary" valign="top"></td>
  </tr>
  <tr>
    <td class="primary" valign="top">Reservado</td>
    <td class="primary" valign="top">Prestado</td>
    <td class="primary" valign="top">Permitido solo si el  socio es el primero en la cola de espera para el ejemplar o si la cola est� vac�a.</td>
  </tr>
  <tr>
    <td class="primary" valign="top" rowspan="5">Disponibilidades</td>
    <td class="primary" valign="top">Prestado</td>
    <td class="primary" valign="top">Carrito de reposici�n en estanter�a</td>
    <td class="primary" valign="top">Puede calcular las �ltimas multas.</td>
  </tr>
  <tr>
    <td class="primary" valign="top">Prestado</td>
    <td class="primary" valign="top">Reservado</td>
    <td class="primary" valign="top">Puede calcular las �ltimas multas y mostrar un mensaje para colocar el libro en el lugar donde se almacena.</td>
  </tr>
  <tr>
    <td class="primary" valign="top">Otro<sup>*</sup></td>
    <td class="primary" valign="top">Carrito de reposici�n en estanter�a</td>
    <td class="primary" valign="top"></td>
  </tr>
  <tr>
    <td class="primary" valign="top">Reservado</td>
    <td class="primary" valign="top">Carrito de reposici�n en estanter�a</td>
    <td class="primary" valign="top">Permitido solo si la cola de espera para un ejemplar est� vac�a.</td>
  </tr>
  <tr>
    <td class="primary" valign="top">Carrito de reposici�n en estanter�a</td>
    <td class="primary" valign="top">Disponible</td>
    <td class="primary" valign="top"></td>
  </tr>
  <tr>
    <td class="primary" valign="top" rowspan="5">Informaci�n de la bibliograf�a</td>
    <td class="primary" valign="top">Otro<sup>*</sup></td>
    <td class="primary" valign="top">Disponible</td>
    <td class="primary" valign="top"></td>
  </tr>
  <tr>
    <td class="primary" valign="top">Otro<sup>*</sup></td>
    <td class="primary" valign="top">Otro<sup>*</sup></td>
    <td class="primary" valign="top"></td>
  </tr>
  <tr>
    <td class="primary" valign="top">Disponible</td>
    <td class="primary" valign="top">Otro<sup>*</sup></td>
    <td class="primary" valign="top"></td>
  </tr>
  <tr>
    <td class="primary" valign="top">Reservado</td>
    <td class="primary" valign="top">Disponible</td>
    <td class="primary" valign="top">Permitido solo si la cola de espera para un ejemplar est� vac�a.</td>
  </tr>
  <tr>
    <td class="primary" valign="top">Reservado</td>
    <td class="primary" valign="top">Otro<sup>*</sup></td>
    <td class="primary" valign="top">Permitido solo si la cola de espera para un ejemplar est� vac�a.</td>
  </tr>
</table>

<font class="small">* - nota: "otro" incluye los estados: da�ado/en reparaci�n, visualizaci�n, extraviado, on loan y  en pedido.</font>
