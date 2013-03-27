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

#*********************************************************************************
#*  checklogin.php
#*  Description: Used to verify signon token on every secured page.
#*               Redirects to the login page if token not valid.
#*********************************************************************************

  require_once("../classes/SessionQuery.php");
  require_once("../functions/errorFuncs.php");

  #****************************************************************************
  #*  Temporarily disabling security for demo since sourceforge.net
  #*  seems to be using mirrored servers that do not share session info.
  #****************************************************************************
  if (!OBIB_DEMO_FLG) {

  $returnPage = $_SERVER['PHP_SELF'];
  $_SESSION["returnPage"] = $returnPage;

  #****************************************************************************
  #*  Checking to see if session variables exist
  #****************************************************************************
  if (!isset($_SESSION["userid"]) or ($_SESSION["userid"] == "")) {
    header("Location: ../shared/loginform.php");
    exit();
  }
  if (!isset($_SESSION["token"]) or ($_SESSION["token"] == "")) {
    header("Location: ../shared/loginform.php");
    exit();
  }

  #****************************************************************************
  #*  Checking session table to see if session_id has timed out
  #****************************************************************************
  $sessQ = new SessionQuery();
  $sessQ->connect();
  if ($sessQ->errorOccurred()) {
    displayErrorPage($sessQ);
  }
  if (!$sessQ->validToken($_SESSION["userid"], $_SESSION["token"])) {
    if ($sessQ->errorOccurred()) {
      displayErrorPage($sessQ);
    }
    $sessQ->close();
    header("Location: ../shared/loginform.php?RET=".$returnPage);
    exit();
  }
  $sessQ->close();

  #****************************************************************************
  #*  Checking authorization for this tab
  #*  The session authorization flags were set at login in login.php
  #****************************************************************************
  if ($tab == "circulation"){
    if (!$_SESSION["hasCircAuth"]) {
      header("Location: ../circ/noauth.php");
      exit();
    } elseif (isset($restrictToMbrAuth) and !$_SESSION["hasCircMbrAuth"]) {
      header("Location: ../circ/noauth.php");
      exit();
    }
  } elseif ($tab == "cataloging") {
    if (!$_SESSION["hasCatalogAuth"] || !$_SESSION["hasAprobarAuth"]) 
	{

     if (!$_SESSION["hasAprobarAuth"]) 
        {
        if (($nav == "apruebaEjemplar") || ($nav == "apruebaMaterial")) 
    	    {
	    header("Location: ../catalog/Aprobarnoauth.php");
	    exit();
	    }
	}
      if (!$_SESSION["hasCatalogAuth"]) { 
	header("Location: ../catalog/noauth.php");
      	exit();
	}    
    
    }
  } elseif ($tab == "admin") {
    if (!$_SESSION["hasAdminAuth"]) {
      header("Location: ../admin/noauth.php");
      exit();
    }
  } elseif ($tab == "reports") {
    if (!$_SESSION["hasReportsAuth"]) {
      header("Location: ../reports/noauth.php");
      exit();
    }
  } elseif ($tab == "adquisiciones") {
    if (!$_SESSION["hasAdquisicionesAuth"]) {
      header("Location: ../adquisiciones/noauth.php");
      exit();
    }	
  
  

}
  }

  #****************************************************************************
  #*  Checking to see if we are in demo mode and if we should not execute this
  #*  page.
  #****************************************************************************
  if (isset($restrictInDemo) && $restrictInDemo && OBIB_DEMO_FLG) {
    include("../shared/demo_msg.php");
  }

?>
