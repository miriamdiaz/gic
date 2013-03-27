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
 * Theme represents a library look and feel theme.
 *
 * @author David Stevens <dave@stevens.name>;
 * @version 1.0
 * @access public
 ******************************************************************************
 */
class Theme {
  var $_themeid = 0;
  var $_themeName = "";
  var $_themeNameError = "";
  var $_titleBg = "";
  var $_titleBgError = "";
  var $_titleFontFace = "";
  var $_titleFontFaceError = "";
  var $_titleFontSize = 1;
  var $_titleFontSizeError = "";
  var $_titleFontBold = false;
  var $_titleFontColor = "";
  var $_titleFontColorError = "";
  var $_titleAlign = "";
  var $_primaryBg = "";
  var $_primaryBgError = "";
  var $_primaryFontFace = "";
  var $_primaryFontFaceError = "";
  var $_primaryFontSize = 1;
  var $_primaryFontSizeError = "";
  var $_primaryFontColor = "";
  var $_primaryFontColorError = "";
  var $_primaryLinkColor = "";
  var $_primaryLinkColorError = "";
  var $_primaryErrorColor = "";
  var $_primaryErrorColorError = "";
  var $_alt1Bg = "";
  var $_alt1BgError = "";
  var $_alt1FontFace = "";
  var $_alt1FontFaceError = "";
  var $_alt1FontSize = 1;
  var $_alt1FontSizeError = "";
  var $_alt1FontColor = "";
  var $_alt1FontColorError = "";
  var $_alt1LinkColor = "";
  var $_alt1LinkColorError = "";
  var $_alt2Bg = "";
  var $_alt2BgError = "";
  var $_alt2FontFace = "";
  var $_alt2FontFaceError = "";
  var $_alt2FontSize = 1;
  var $_alt2FontSizeError = "";
  var $_alt2FontColor = "";
  var $_alt2FontColorError = "";
  var $_alt2LinkColor = "";
  var $_alt2LinkColorError = "";
  var $_alt2FontBold = false;
  var $_borderColor = "";
  var $_borderColorError = "";
  var $_borderWidth = 1;
  var $_borderWidthError = "";
  var $_tablePadding = 1;
  var $_tablePaddingError = "";

  /****************************************************************************
   * @return boolean true if data is valid, otherwise false.
   * @access public
   ****************************************************************************
   */
  function validateData() {
    $valid = true;

    # required field edits
    if ($this->_themeName == "") {
      $valid = false;
      $this->_themeNameError = "El nombre del tema es requerido.";
    }
    if ($this->_titleBg == "") {
      $valid = false;
      $this->_titleBgError = "El color de fondo del título es requerido.";
    }
    if ($this->_titleFontFace == "") {
      $valid = false;
      $this->_titleFontFaceError = "Tipo de letra del título es requerido.";
    }
    if ($this->_titleFontColor == "") {
      $valid = false;
      $this->_titleFontColorError = "El color de la letra del título es requerido.";
    }
    if ($this->_primaryBg == "") {
      $valid = false;
      $this->_primaryBgError = "El color de fondo del cuerpo principal es requerido.";
    }
    if ($this->_primaryFontFace == "") {
      $valid = false;
      $this->_primaryFontFaceError = "El tipo de letra del cuerpo principal es requerido.";
    }
    if ($this->_primaryFontColor == "") {
      $valid = false;
      $this->_primaryFontColorError = "El color de la letra del cuerpo principal es requerido.";
    }
    if ($this->_primaryLinkColor == "") {
      $valid = false;
      $this->_primaryLinkColorError = "El color del enlace (link) del cuerpo principal es requerido.";
    }
    if ($this->_primaryErrorColor == "") {
      $valid = false;
      $this->_primaryErrorColorError = "El color del error en el cuerpo principal es requerido.";
    }
    if ($this->_alt1Bg == "") {
      $valid = false;
      $this->_alt1BgError = "El color de fondo de navegación es requerido.";
    }
    if ($this->_alt1FontFace == "") {
      $valid = false;
      $this->_alt1FontFaceError = "El tipo de letra de navegación es requerido.";
    }
    if ($this->_alt1FontColor == "") {
      $valid = false;
      $this->_alt1FontColorError = "El color de la letra de navegación es requerido.";
    }
    if ($this->_alt1LinkColor == "") {
      $valid = false;
      $this->_alt1LinkColorError = "El color de enlace (link) de navegación es requerido.";
    }
    if ($this->_alt2Bg == "") {
      $valid = false;
      $this->_alt2BgError = "El color de fondo de etiqueta es requerido.";
    }
    if ($this->_alt2FontFace == "") {
      $valid = false;
      $this->_alt2FontFaceError = "El tipo de letra de etiqueta es requerido.";
    }
    if ($this->_alt2FontColor == "") {
      $valid = false;
      $this->_alt2FontColorError = "El color de la letra de etiqueta es requerido.";
    }
    if ($this->_alt2LinkColor == "") {
      $valid = false;
      $this->_alt2LinkColorError = "El color del enlace (link) de etiqueta es requerido.";
    }
    if ($this->_borderColor == "") {
      $valid = false;
      $this->_borderColorError = "El color del borde es requerido.";
    }

    # numeric checks
    if (!is_numeric($this->_titleFontSize)) {
      $valid = false;
      $this->_titleFontSizeError = "El tamaño de letra del título debe ser numérico.";
    } elseif (strrpos($this->_titleFontSize,".")) {
      $valid = false;
      $this->_titleFontSizeError = "El tamaño de letra no debe contener un punto decimal.";
    } elseif ($this->_titleFontSize <= 0) {
      $valid = false;
      $this->_titleFontSizeError = "El tamaño de letra del título debe ser mayor a cero.";
    }

    if (!is_numeric($this->_primaryFontSize)) {
      $valid = false;
      $this->_primaryFontSizeError = "El tamaño de letra del cuerpo principal debe ser numérico.";
    } elseif (strrpos($this->_primaryFontSize,".")) {
      $valid = false;
      $this->_primaryFontSizeError = "El tamaño de letra del cuerpo principal no debe contener un punto decimal.";
    } elseif ($this->_primaryFontSize <= 0) {
      $valid = false;
      $this->_primaryFontSizeError = "El tamaño de letra del cuerpo principal debe ser mayor a cero.";
    }

    if (!is_numeric($this->_alt1FontSize)) {
      $valid = false;
      $this->_alt1FontSizeError = "El tamaño de letra de navegación debe ser numérico.";
    } elseif (strrpos($this->_alt1FontSize,".")) {
      $valid = false;
      $this->_alt1FontSizeError = "El tamaño de letra de navegación no debe contener un punto decimal.";
    } elseif ($this->_alt1FontSize <= 0) {
      $valid = false;
      $this->_alt1FontSizeError = "El tamaño de letra de navegación debe ser mayor a cero.";
    }

    if (!is_numeric($this->_alt2FontSize)) {
      $valid = false;
      $this->_alt2FontSizeError = "El tamaño de letra de etiqueta debe ser numérico.";
    } elseif (strrpos($this->_alt2FontSize,".")) {
      $valid = false;
      $this->_alt2FontSizeError = "El tamaño de letra no debe contener un punto decimal.";
    } elseif ($this->_alt2FontSize <= 0) {
      $valid = false;
      $this->_alt2FontSizeError = "El tamaño de letra de etiqueta debe ser mayor a cero.";
    }

    if (!is_numeric($this->_borderWidth)) {
      $valid = false;
      $this->_borderWidthError = "El ancho del borde debe ser numérico.";
    } elseif (strrpos($this->_borderWidth,".")) {
      $valid = false;
      $this->_borderWidthError = "El ancho del borde no debe contener un punto decimal.";
    } elseif ($this->_borderWidth <= 0) {
      $valid = false;
      $this->_borderWidthError = "El ancho del borde debe ser mayor a cero.";
    }

    if (!is_numeric($this->_tablePadding)) {
      $valid = false;
      $this->_tablePaddingError = "El ancho de celda debe ser numérico.";
    } elseif (strrpos($this->_tablePadding,".")) {
      $valid = false;
      $this->_tablePaddingError = "El ancho de celda no debe contener un punto decimal.";
    } elseif ($this->_tablePadding <= 0) {
      $valid = false;
      $this->_tablePaddingError = "El ancho de celda debe ser mayor a cero.";
    }

    return $valid;
  }

  /****************************************************************************
   * getter methods for all fields
   * @return string
   * @access public
   ****************************************************************************
   */
  function getThemeid() {
    return $this->_themeid;
  }
  function getThemeName() {
    return $this->_themeName;
  }
  function getTitleBg() {
    return $this->_titleBg;
  }
  function getTitleFontFace() {
    return $this->_titleFontFace;
  }
  function getTitleFontSize() {
    return $this->_titleFontSize;
  }
  function getTitleFontBold() {
    return $this->_titleFontBold;
  }
  function getTitleFontColor() {
    return $this->_titleFontColor;
  }
  function getTitleAlign() {
    return $this->_titleAlign;
  }
  function getPrimaryBg() {
    return $this->_primaryBg;
  }
  function getPrimaryFontFace() {
    return $this->_primaryFontFace;
  }
  function getPrimaryFontSize() {
    return $this->_primaryFontSize;
  }
  function getPrimaryFontColor() {
    return $this->_primaryFontColor;
  }
  function getPrimaryLinkColor() {
    return $this->_primaryLinkColor;
  }
  function getPrimaryErrorColor() {
    return $this->_primaryErrorColor;
  }
  function getAlt1Bg() {
    return $this->_alt1Bg;
  }
  function getAlt1FontFace() {
    return $this->_alt1FontFace;
  }
  function getAlt1FontSize() {
    return $this->_alt1FontSize;
  }
  function getAlt1FontColor() {
    return $this->_alt1FontColor;
  }
  function getAlt1LinkColor() {
    return $this->_alt1LinkColor;
  }
  function getAlt2Bg() {
    return $this->_alt2Bg;
  }
  function getAlt2FontFace() {
    return $this->_alt2FontFace;
  }
  function getAlt2FontSize() {
    return $this->_alt2FontSize;
  }
  function getAlt2FontColor() {
    return $this->_alt2FontColor;
  }
  function getAlt2LinkColor() {
    return $this->_alt2LinkColor;
  }
  function getAlt2FontBold() {
    return $this->_alt2FontBold;
  }
  function getBorderColor() {
    return $this->_borderColor;
  }
  function getBorderWidth() {
    return $this->_borderWidth;
  }
  function getTablePadding() {
    return $this->_tablePadding;
  }
  function getThemeNameError() {
    return $this->_themeNameError;
  }
  function getTitleBgError() {
    return $this->_titleBgError;
  }
  function getTitleFontFaceError() {
    return $this->_titleFontFaceError;
  }
  function getTitleFontSizeError() {
    return $this->_titleFontSizeError;
  }
  function getTitleFontColorError() {
    return $this->_titleFontColorError;
  }
  function getPrimaryBgError() {
    return $this->_primaryBgError;
  }
  function getPrimaryFontFaceError() {
    return $this->_primaryFontFaceError;
  }
  function getPrimaryFontSizeError() {
    return $this->_primaryFontSizeError;
  }
  function getPrimaryFontColorError() {
    return $this->_primaryFontColorError;
  }
  function getPrimaryLinkColorError() {
    return $this->_primaryLinkColorError;
  }
  function getPrimaryErrorColorError() {
    return $this->_primaryErrorColorError;
  }
  function getAlt1BgError() {
    return $this->_alt1BgError;
  }
  function getAlt1FontFaceError() {
    return $this->_alt1FontFaceError;
  }
  function getAlt1FontSizeError() {
    return $this->_alt1FontSizeError;
  }
  function getAlt1FontColorError() {
    return $this->_alt1FontColorError;
  }
  function getAlt1LinkColorError() {
    return $this->_alt1LinkColorError;
  }
  function getAlt2BgError() {
    return $this->_alt2BgError;
  }
  function getAlt2FontFaceError() {
    return $this->_alt2FontFaceError;
  }
  function getAlt2FontSizeError() {
    return $this->_alt2FontSizeError;
  }
  function getAlt2FontColorError() {
    return $this->_alt2FontColorError;
  }
  function getAlt2LinkColorError() {
    return $this->_alt2LinkColorError;
  }
  function getBorderColorError() {
    return $this->_borderColorError;
  }
  function getBorderWidthError() {
    return $this->_borderWidthError;
  }
  function getTablePaddingError() {
    return $this->_tablePaddingError;
  }

  /****************************************************************************
   * Setter methods for all fields
   * @param string $value new value to set
   * @return void
   * @access public
   ****************************************************************************
   */
  function setThemeid($value) {
    $this->_themeid = trim($value);
  }
  function setThemeName($value) {
    $this->_themeName = trim($value);
  }
  function setTitleBg($value) {
    $this->_titleBg = trim($value);
  }
  function setTitleFontFace($value) {
    $this->_titleFontFace = trim($value);
  }
  function setTitleFontSize($value) {
    $temp = trim($value);
    if ($temp == "") {
      $this->_titleFontSize = 0;
    } else {
      $this->_titleFontSize = $temp;
    }
  }
  function setTitleFontBold($value) {
    if ($value) {
      $this->_titleFontBold = true;
    } else {
      $this->_titleFontBold = false;
    }
  }
  function setTitleFontColor($value) {
    $this->_titleFontColor = trim($value);
  }
  function setTitleAlign($value) {
    $this->_titleAlign = trim($value);
  }
  function setPrimaryBg($value) {
    $this->_primaryBg = trim($value);
  }
  function setPrimaryFontFace($value) {
    $this->_primaryFontFace = trim($value);
  }
  function setPrimaryFontSize($value) {
    $temp = trim($value);
    if ($temp == "") {
      $this->_primaryFontSize = 0;
    } else {
      $this->_primaryFontSize = $temp;
    }
  }
  function setPrimaryFontColor($value) {
    $this->_primaryFontColor = trim($value);
  }
  function setPrimaryLinkColor($value) {
    $this->_primaryLinkColor = trim($value);
  }
  function setPrimaryErrorColor($value) {
    $this->_primaryErrorColor = trim($value);
  }
  function setAlt1Bg($value) {
    $this->_alt1Bg = trim($value);
  }
  function setAlt1FontFace($value) {
    $this->_alt1FontFace = trim($value);
  }
  function setAlt1FontSize($value) {
    $temp = trim($value);
    if ($temp == "") {
      $this->_alt1FontSize = 0;
    } else {
      $this->_alt1FontSize = $temp;
    }
  }
  function setAlt1FontColor($value) {
    $this->_alt1FontColor = trim($value);
  }
  function setAlt1LinkColor($value) {
    $this->_alt1LinkColor = trim($value);
  }
  function setAlt2Bg($value) {
    $this->_alt2Bg = trim($value);
  }
  function setAlt2FontFace($value) {
    $this->_alt2FontFace = trim($value);
  }
  function setAlt2FontSize($value) {
    $temp = trim($value);
    if ($temp == "") {
      $this->_alt2FontSize = 0;
    } else {
      $this->_alt2FontSize = $temp;
    }
  }
  function setAlt2FontColor($value) {
    $this->_alt2FontColor = trim($value);
  }
  function setAlt2LinkColor($value) {
    $this->_alt2LinkColor = trim($value);
  }
  function setAlt2FontBold($value) {
    if ($value) {
      $this->_alt2FontBold = true;
    } else {
      $this->_alt2FontBold = false;
    }
  }
  function setBorderColor($value) {
    $this->_borderColor = trim($value);
  }
  function setBorderWidth($value) {
    $this->_borderWidth = trim($value);
  }
  function setTablePadding($value) {
    $this->_tablePadding = trim($value);
  }

}

?>
