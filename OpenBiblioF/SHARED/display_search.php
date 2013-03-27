<?php
/**********************************************************************************
 *   Copyright(C) 2005 David Stevens
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
if ($_POST["tipo"] == "html")
    {
    $tab = "home";
    $nav = "runsearch";

    //  include("../shared/logincheck.php");
	require_once("../shared/common.php");
    $index = "outputType";
 
    include("display_search_html.php");
    }
    else if ($_POST["tipo"] == "csv")  
	     {
		 require_once("../shared/common.php");
		 include("display_search_csv.php");
		 }
		else if ($_POST["tipo"] == "pdf")
		        {
				 require_once("../shared/common.php");
				 include("../shared/display_search_pdf.php");
				}
?>

