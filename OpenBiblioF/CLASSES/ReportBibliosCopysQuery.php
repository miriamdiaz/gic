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

require_once("../shared/global_constants.php");
require_once("../classes/Biblio.php");

require_once("../classes/BiblioField.php");
require_once("../classes/Query.php");
require_once("../classes/Localize.php");

/******************************************************************************
 * BiblioCopyQuery data access component for library bibliography copies
 *
 * @author David Stevens <dave@stevens.name>;
 * @version 1.0
 * @access public
 ******************************************************************************
 */
class ReportBibliosCopysQuery extends Query {
  var $_rowCount = 0;
  var $_loc;
  var $_itemsPerPage = 1;
  var $_rowNmbr = 0;
  var $_currentRowNmbr = 0;
  var $_currentPageNmbr = 0;
  var $_pageCount = 0;
  var $_fieldsInBiblio;
  //var $_fecha1 = "";
  //var $_fecha2 = "";
  var $_dateSptuError1="";
  
  function ReportBibliosCopysQuery() 
  {
     $this->_loc = new Localize(OBIB_LOCALE,"classes");
	 $this->_fieldsInBiblio = array(
      '100a' => 'author',
      '245a' => 'title',
      '245b' => 'title_remainder',
      '245c' => 'responsibility_stmt',
      '650a' => 'topic1',
      '650a1' => 'topic2',
      '650a2' => 'topic3',
      '650a3' => 'topic4',
      '650a4' => 'topic5',
    );
  } 
  
  /****************************************************************************
   * Getter methods for all fields
   * @return string
   * @access public
   ****************************************************************************
   */
 function getCurrentRowNmbr() 
  {
    return $this->_currentRowNmbr;
  }
  function getPageCount() 
  {
    return $this->_pageCount;
  }
  function getLineNmbr() 
  {
    return $this->_rowNmbr;
  }
  function getRowCount() {
    return $this->_rowCount;
  }

  /****************************************************************************
   * Setter methods for all fields
   * @param string $value new value to set
   * @return void
   * @access public
   ****************************************************************************
   */
 
  function setItemsPerPage($value) 
  {
    $this->_itemsPerPage = $value;
  }
 
  /****************************************************************************
   * Executes a query to select ONLY ONE COPY
   * @param string $bibid bibid of bibliography analitic to select
   * @param string $anaid anaid of bibliography analitic to select
   * @return analitic returns analitic or false, if error occurs
   * @access public
   ****************************************************************************
   */
 
 function query($bibid) {
    # reset rowNmbr
    $this->_rowNmbr = 0;
    $this->_currentRowNmbr = 1;
    $this->_rowCount = 1;
    $this->_pageCount = 1;

    /***********************************************************
     *  Reading biblio data
     ***********************************************************/
    # setting query that will return all the data in biblio
    $sql = $this->mkSQL("select biblio.*, staff.username "
                        . "from biblio left join staff "
                        . "on biblio.last_change_userid = staff.userid "
                        . "where biblio.bibid = %N ", $bibid);
    if (!$this->_query($sql, $this->_loc->getText("biblioQueryQueryErr1"))) {
      return false;
    }

    $array = $this->_conn->fetchRow();
    $bib = new Biblio();
    $bib->setBibid($array["bibid"]);
    $bib->setCreateDt($array["create_dt"]);
    $bib->setLastChangeDt($array["last_change_dt"]);
    $bib->setLastChangeUserid($array["last_change_userid"]);
    if (isset($array["username"])) {
      $bib->setLastChangeUsername($array["username"]);
    }
    $bib->setMaterialCd($array["material_cd"]);
    $bib->setCollectionCd($array["collection_cd"]);
    $bib->setCallNmbr1($array["call_nmbr1"]);
    $bib->setCallNmbr2($array["call_nmbr2"]);
    $bib->setCallNmbr3($array["call_nmbr3"]);
    if ($array["opac_flg"] == "Y") 
	{
      $bib->setOpacFlg(true);
    } 
	else 
	{
      $bib->setOpacFlg(false);
    }
	if ($array["literatura_flg"] == "Y") 
	{
      $bib->setLiteraturaFlg(true);
    } 
	else 
	{
      $bib->setLiteraturaFlg(false);
    }
	
	$bib->setUserNameCreador($array["user_name_creador"]);//agregado franco
    //aca tienen que pedir el indice a biblio_index con el bibid.
    $bib->setFechaCatalog($array["date_sptu"]);
	
    //ini franco obteniendo el indice de biblio_index y set el objeto bib
	$sql = $this->mkSQL("select biblio_index.* from biblio_index  where biblio_index.bibid=%N ", $bib->getBibid());
	if (!$this->_query($sql, $this->_loc->getText("biblioQueryInsertErr1")))
    {
      return false;
    }
	$arrayIndice = $this->_conn->fetchRow();
    $bib->setIndice($arrayIndice["indice"]);
   //fin franco
     /***********************************************************
     *  Reading biblio_field data
     ***********************************************************/
    # setting query that will return all the data in biblio
    $sql = $this->mkSQL("select biblio_field.* "
                        . "from biblio_field "
                        . "where biblio_field.bibid = %N "
                        . "order by tag, subfield_cd ", $bibid);
    if (!$this->_query($sql, $this->_loc->getText("biblioQueryQueryErr2"))) {
      return false;
    }
   
    /***********************************************************
     *  Adding fields from biblio to Biblio object 
     ***********************************************************/
    foreach ($this->_fieldsInBiblio as $key => $name) {
      $tag = substr($key, 0, 3);
      $subfieldCd = substr($key, 3, 1);
      $subfieldIdx = '';
      if (count($key) > 4) {
        $index = substr($key, 4);
      }
      $this->_addField($tag, $subfieldCd, $array[$name], $bib, $subfieldIdx);
    }

    /***********************************************************
     *  Adding fields from biblio_field to Biblio object 
     ***********************************************************/
    # subfieldIdx will be used to construct index
    $subfieldIdx = 0;
    $saveTag = "";
    $saveSubfield = "";
    while ($array = $this->_conn->fetchRow()) {
      $tag=$array["tag"];
      $subfieldCd=$array["subfield_cd"];

      # checking for tag and subfield break in order to set the subfield Idx correctly.
      if (($tag == $saveTag) and ($subfieldCd == $saveSubfield)) {
        $subfieldIdx = $subfieldIdx + 1;
      } else {
        $subfieldIdx = 0;
        $saveTag = $tag;
        $saveSubfield = $subfieldCd;
      }

      # setting the index.
      # format is ttts[i] where 
      #    t=tag
      #    s=subfield code
      #    i=subfield index if > 0
      # examples: 020a 650a 650a1 650a2
      $index = sprintf("%03d",$tag).$subfieldCd;
      if ($subfieldIdx > 0) {
        $index = $index.$subfieldIdx;
      }

      $bibFld = new BiblioField();
      $bibFld->setBibid($array["bibid"]);
      $bibFld->setFieldid($array["fieldid"]);
      $bibFld->setTag($array["tag"]);
      $bibFld->setInd1Cd($array["ind1_cd"]);
      $bibFld->setInd2Cd($array["ind2_cd"]);
      $bibFld->setSubfieldCd($array["subfield_cd"]);
      $bibFld->setFieldData($array["field_data"]);
      $bib->addBiblioField($index,$bibFld);
    }
    return $bib;
  }


  /****************************************************************************
   * Utility function to add a field to a Biblio object
   * @return void
   * @access private
   ****************************************************************************
   */
  /*###########################
    # WORKS WITH NEW FORMAT   #
    ###########################*/
  function _addField($tag,$subfieldCd,$value,&$bib,$seq="") {
    if ($value == "") {
      return;
    }
    $index = sprintf("%03d",$tag).$subfieldCd;
    if ($seq != "") {
      $index = $index.$seq;
    }
    $bibFld = new BiblioField();
    $bibFld->setTag($tag);
    $bibFld->setSubfieldCd($subfieldCd);
    $bibFld->setFieldData($value);
    $bib->addBiblioField($index,$bibFld);
  }


  /****************************************************************************
   * Returns true if barcode number already exists
   * @param string $barcode Bibliography barcode number
   * @param string $bibid Bibliography id
   * @return boolean returns true if barcode already exists
   * @access private
   ****************************************************************************
   */
  function _dupBarcode($barcode, $bibid=0) {
    $sql = $this->mkSQL("select count(*) from biblio "
                        . "where barcode_nmbr = %Q and bibid <> %N ",
                        $barcode, $bibid);
    if (!$this->_query($sql, "Error checking for dup barcode.")) {
      return 0;
    }
    $array = $this->_conn->fetchRow(OBIB_NUM);
    if ($array[0] > 0) {
      return true;
    }
    return false;
  }

  /****************************************************************************
   * Inserts new bibliography info into the biblio and biblio_field tables.
   * @param Biblio $biblio bibliography to insert
   * @return int returns bibid or false, if error occurs
   * @access public
   ****************************************************************************
   */
  /*###########################
    # WORKS WITH NEW FORMAT   #
    ###########################*/
  function _dupSigna($nmbr1,$nmbr2,$nmbr3, $bibid=0) 
  {
	$this->_conn->getInsertId();

	 
	if($bibid != 0)
	{
		echo"<h1 id >".	gettype($bibid)."</h1>";
    $sql = $this->mkSQL("select count(*) from biblio "
                        . "where call_nmbr1 = %Q and call_nmbr2 = %Q and call_nmbr3 = %Q "
						  . " and not ( bibid = %N )",
                        $nmbr1,$nmbr2,$nmbr3, $bibid );
	}
	else
	{
	$sql = $this->mkSQL("select count(*) from biblio "
                        . "where call_nmbr1 = %Q and call_nmbr2 = %Q and call_nmbr3 = %Q ",
                        $nmbr1,$nmbr2,$nmbr3);
	}
			echo"<h1 >".	$sql."</h1>";
    if (!$this->_query($sql, $this->_loc->getText("biblioQueryErr1"))) {
      return false;
    }
    $array = $this->_conn->fetchRow(OBIB_NUM);
    if ($array[0] > 0) {
      return true;
    }
    return false;
  }
  
  /********************************************************
  *esto viene de BiblioQuery
  *- 
  *- Fechtrowfranco
  ********************************************************/
  
 function viewBibliosCopys($page)
	{

		# reset stats
		$this->_rowNmbr = 0;
		$this->_currentRowNmbr = 0;
		$this->_rowCount = 0;
		$this->_currentPageNmbr=$page;
		$this->_pageCount = 0;
		//$this->_fech1 = $fecha1;
		//$this->_fech2 = $fecha2;
	
		# setting count query						
    	$sqlcount = "select count(*) as rowcount " 
		           . "from biblio " 
				   . "where biblio.bibid NOT IN "
				   . "(select biblio_copy.bibid "
				   . "from biblio_copy )";
		//echo "sql Count: $sqlcount";
		 
		# setting query that will return all the data
		//$sql = $this->mkSQL("select biblio.bibid , biblio.title from biblio where biblio.aprob_flg=%N",0);
	    $sql = $this->mkSQL("select biblio.* "
		                  . "from biblio "
						  . "where biblio.bibid NOT IN "
						  . "(select biblio_copy.bibid "
						  . "from biblio_copy ) ORDER BY biblio.create_dt");
					  
		# setting limit so we can page through the results
	    $offset = ($page - 1) * $this->_itemsPerPage;
    	$limit = $this->_itemsPerPage;
	    $sql .= $this->mkSQL(" limit %N, %N", $offset, $limit);
		//echo "sql final: $sql";

		# Running row count sql statement
		if (!$this->_query($sqlcount, $this->_loc->getText("biblioSearchQueryErr1"))) {
		  return false;
		}
		# Calculate stats based on row count
		$array = $this->_conn->fetchRow();
		$this->_rowCount = $array["rowcount"];
		$this->_pageCount = ceil($this->_rowCount / $this->_itemsPerPage);

		return $this->_query($sql, $this->_loc->getText("error en paginacion"));
    }
 	/*funcion utilizada unicamente para aprobar material
	creada el 27-28/07/05 modificada 29/07/05*/

  function fetchRowFranco()
  {
    $array = $this->_conn->fetchRow();
    if ($array == false) 
    {
      return false;
    }

    # increment rowNmbr
    $this->_rowNmbr = $this->_rowNmbr + 1;
    $this->_currentRowNmbr = $this->_rowNmbr + (($this->_currentPageNmbr - 1) * $this->_itemsPerPage);

    $bib = new Biblio();
    $bib->setBibid($array["bibid"]);
	$bib->setCreateDt($array["create_dt"]);
	$bib->setMaterialCd($array["material_cd"]);
	$bib->setTitle($array["title"]);
	$bib->setCallNmbr1($array["call_nmbr1"]);
	$bib->setCallNmbr2($array["call_nmbr2"]);
	$bib->setCallNmbr3($array["call_nmbr3"]);
	$bib->setUserNameCreador($array["user_name_creador"]);
	
    return $bib;
  }
  /************************************************************
  * /\esto viene de BiblioQuery
  ***************************************************************/ 
 /***************************************************************
 * esto no se usa!!!!
 *
 *****************************************************************/
 
  function fetchCountBiblios() {
    $array = $this->_conn->fetchRow();
    if ($array == false) {
      return false;
    }

    $ReportBiblios = new ReportBiblios();
    $ReportBiblios->setFecha1($array["fecha1"]);
    $ReportBiblios->setFecha2($array["fecha2"]);
    
	/*$analitica->setTitulo($array["ana_titulo"]);
    $analitica->setAutor($array["ana_autor"]);
    $analitica->setPaginacion($array["ana_paginacion"]);
    $analitica->setMateria($array["ana_materia"]);
	$analitica->setUserCreador($array["ana_user"]); */
    return $ReportBiblios;
  }
 
}
?>