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

/******************************************************************************
 * Settings represents the library settings.
 *
 * @author David Stevens <dave@stevens.name>;
 * @version 1.0
 * @access public
 ******************************************************************************
 */
class Settings {
  var $_libraryName = "";
  var $_libraryCd = 0;
  var $_libraryCdError = "";
  var $_libraryImageUrl = "";
  var $_isUseImageSet = false;
  var $_libraryHours = "";
  var $_libraryPhone = "";
  var $_libraryUrl = "";
  var $_opacUrl = "";
  var $_sessionTimeout = 0;
  var $_sessionTimeoutError = "";
  var $_itemsPerPage = 0;
  var $_itemsPerPageError = "";
  var $_version = "";
  var $_themeid = 0;
  var $_purgeHistoryAfterMonths = 0;
  var $_purgeHistoryAfterMonthsError = "";
  var $_isBlockCheckoutsWhenFinesDue = TRUE;
  var $_locale = "";
  var $_charset = "";
  var $_htmlLangAttr = "";
  //cuatro lineas agregadas: Horacio Alvarez FEcha: 2006-04-17
  var $_unidad_academica = "";
  var $_domicilio = "";
  var $_unidad_academicaError= "";
  var $_domicilioError = "";
  var $_smtpError = "";
  var $_smtp = "";
  var $_imapError = "";
  var $_imap = "";
  var $_usuariosOnlineFlg = FALSE;
  var $_docentesOnlineFlg = FALSE;

  /****************************************************************************
  * @return array with code and description of installed locales
  * @access public
  ****************************************************************************
  */
  function getLocales () {
    $dir_handle = opendir(OBIB_LOCALE_ROOT);
    $arr_locale = array();
    
    while (false!==($file=readdir($dir_handle))) {
      if ($file != '.' && $file != '..') {
        if (is_dir (OBIB_LOCALE_ROOT."/".$file)) {
          if (file_exists(OBIB_LOCALE_ROOT.'/'.$file.'/metadata.php')) {
            include(OBIB_LOCALE_ROOT.'/'.$file.'/metadata.php');
	    $arr_temp = array($file => $lang_metadata['locale_description']);
	    $arr_locale = array_merge($arr_locale, $arr_temp);
          }
        }
      }
    }
    closedir($dir_handle);
    return $arr_locale;
  }

  /****************************************************************************
   * @return boolean true if data is valid, otherwise false.
   * @access public
   ****************************************************************************
   */
  function validateData() {
    $valid = true;
    if (!is_numeric($this->_sessionTimeout)) {
      $valid = false;
      $this->_sessionTimeoutError = "Session timeout must be numeric.";
    } elseif ($this->_sessionTimeout <= 0) {
      $valid = false;
      $this->_sessionTimeoutError = "Session timeout must be greater than 0.";
    }
    if (!is_numeric($this->_itemsPerPage)) {
      $valid = false;
      $this->_itemsPerPageError = "Items per page must be numeric.";
    } elseif ($this->_itemsPerPage <= 0) {
      $valid = false;
      $this->_itemsPerPageError = "Items per page must be greater than 0.";
    }
    if (!is_numeric($this->_purgeHistoryAfterMonths)) {
      $valid = FALSE;
      $this->_purgeHistoryAfterMonthsError = "Months must be numeric.";
    }
    if (!is_numeric($this->_libraryCd)) {
      $valid = FALSE;
      $this->_libraryCdError = "El código de biblioteca debe ser numerico.";
    }	
  /**
  Autor: Horacio Alvarez
  Fecha: 17-04-06
  Descripcion: se agregan los campos unidad academica y domicilio.
  */	
    if ($this->_unidad_academica=="") {
      $valid = FALSE;
      $this->_unidad_academicaError = "Debe ingresar el nombre de la Unidad Academica";
    }
    if ($this->_domicilio=="") {
      $valid = FALSE;
      $this->_domicilioError = "Debe ingresar el domicilio de la Unidad Academica";
    }		
    return $valid;
  }

  /****************************************************************************
   * getter methods for all fields
   * @return string
   * @access public
   ****************************************************************************
   */
  function getLibraryName() {
    return $this->_libraryName;
  }
  function getLibraryImageUrl() {
    return $this->_libraryImageUrl;
  }
  function isUseImageSet() {
    return $this->_isUseImageSet;
  }
  function getLibraryHours() {
    return $this->_libraryHours;
  }
  function getLibraryPhone() {
    return $this->_libraryPhone;
  }
  function getLibraryUrl() {
    return $this->_libraryUrl;
  }
  function getOpacUrl() {
    return $this->_opacUrl;
  }
  function getSessionTimeout() {
    return $this->_sessionTimeout;
  }
  function getSessionTimeoutError() {
    return $this->_sessionTimeoutError;
  }
  function getItemsPerPage() {
    return $this->_itemsPerPage;
  }
  function getItemsPerPageError() {
    return $this->_itemsPerPageError;
  }
  function getVersion() {
    return $this->_version;
  }
  function getThemeid() {
    return $this->_themeid;
  }
  function getPurgeHistoryAfterMonths() {
    return $this->_purgeHistoryAfterMonths;
  }
  function getPurgeHistoryAfterMonthsError() {
    return $this->_purgeHistoryAfterMonthsError;
  }
  function isBlockCheckoutsWhenFinesDue() {
    return $this->_isBlockCheckoutsWhenFinesDue;
  }
  function getLocale() {
    return $this->_locale;
  }
  function getCharset() {
    return $this->_charset;
  }
  function getHtmlLangAttr() {
    return $this->_htmlLangAttr;
  }
  /**
  Autor: Horacio Alvarez
  Fecha: 17-04-06
  Descripcion: se agregan los campos unidad academica y domicilio.
  */  
  function getUnidad_academica() {
    return $this->_unidad_academica;
  }
  function getUnidad_academicaError() {
    return $this->_unidad_academicaError;
  }  
  function getDomicilio() {
    return $this->_domicilio;
  }
  function getDomicilioError() {
    return $this->_domicilioError;
  }
  function getLibraryCd() {
    return $this->_libraryCd;
  }
  function getLibraryCdError() {
    return $this->_libraryCdError;
  } 
  function getSmtp() {
    return $this->_smtp;
  }
  function getImap() {
    return $this->_imap;
  } 
  function getSmtpError() {
    return $this->_smtpError;
  }
  function getImapError() {
    return $this->_imapError;
  }
  function getUsuariosOnlineFlg() {
    return $this->_usuariosOnlineFlg;
  }
  function getDocentesOnlineFlg() {
    return $this->_docentesOnlineFlg;
  }                  

  /****************************************************************************
   * Setter methods for all fields
   * @param string $value new value to set
   * @return void
   * @access public
   ****************************************************************************
   */
  function setLibraryName($value) {
    $this->_libraryName = trim($value);
  }
  function setLibraryImageUrl($value) {
    $this->_libraryImageUrl = trim($value);
  }
  function setUseImageFlg($value) {
    if ($value) {
      $this->_isUseImageSet = true;
    } else {
      $this->_isUseImageSet = false;
    }
  }
  function setLibraryHours($value) {
    $this->_libraryHours = trim($value);
  }
  function setLibraryPhone($value) {
    $this->_libraryPhone = trim($value);
  }
  function setLibraryUrl($value) {
    $this->_libraryUrl = trim($value);
  }
  function setOpacUrl($value) {
    $this->_opacUrl = trim($value);
  }
  function setSessionTimeout($value) {
    $temp = trim($value);
    if ($temp == "") {
      $this->_sessionTimeout = 0;
    } else {
      $this->_sessionTimeout = $temp;
    }
  }
  function setSessionTimeoutError($value) {
    $this->_sessionTimeoutError = trim($value);
  }
  function setItemsPerPage($value) {
    $temp = trim($value);
    if ($temp == "") {
      $this->_itemsPerPage = 0;
    } else {
      $this->_itemsPerPage = $temp;
    }
  }
  function setItemsPerPageError($value) {
    $this->_itemsPerPageError = trim($value);
  }
  function setVersion($value) {
    $this->_version = trim($value);
  }
  function setThemeid($value) {
    $temp = trim($value);
    if ($temp == "") {
      $this->_themeid = 0;
    } else {
      $this->_themeid = $temp;
    }
  }
  function setPurgeHistoryAfterMonths($value) {
    $this->_purgeHistoryAfterMonths = trim($value);
  }
  function setBlockCheckoutsWhenFinesDue($value) {
    if ($value) {
      $this->_isBlockCheckoutsWhenFinesDue = TRUE;
    } else {
      $this->_isBlockCheckoutsWhenFinesDue = FALSE;
    }
  }
  function setLocale($value) {
    $this->_locale = trim($value);
  }
  function setCharset($value) {
    $this->_charset = trim($value);
  }
  function setHtmlLangAttr($value) {
    $this->_htmlLangAttr = trim($value);
  }
  /**
  Autor: Horacio Alvarez
  Fecha: 17-04-06
  Descripcion: se agregan los campos unidad academica y domicilio.
  */
  function setUnidad_academica($value) {
    $this->_unidad_academica = trim($value);
  }
  function setDomicilio($value) {
    $this->_domicilio = trim($value);
  }
  function setLibraryCd($value) {
    $this->_libraryCd = trim($value);
  }
  function setSmtp($value) {
    $this->_smtp = trim($value);
  }
  function setImap($value) {
    $this->_imap = trim($value);
  }
  function setUsuariosOnlineFlg($value) {
    if ($value) {
      $this->_usuariosOnlineFlg = TRUE;
    } else {
      $this->_usuariosOnlineFlg = FALSE;
    }
  }    
  function setDocentesOnlineFlg($value) {
    if ($value) {
      $this->_docentesOnlineFlg = TRUE;
    } else {
      $this->_docentesOnlineFlg = FALSE;
    }
  }      

}

?>
