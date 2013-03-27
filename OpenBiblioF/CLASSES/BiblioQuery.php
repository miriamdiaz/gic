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
require_once("../classes/Query.php");
require_once("../classes/Biblio.php");
require_once("../classes/BiblioField.php");
require_once("../classes/Localize.php");

/******************************************************************************
 * BiblioQuery data access component for library bibliographies
 *
 * @author David Stevens <dave@stevens.name>;
 * @version 1.0
 * @access public
 ******************************************************************************
 */
class BiblioQuery extends Query {
  var $_itemsPerPage = 1;
  var $_rowNmbr = 0;
  var $_currentRowNmbr = 0;
  var $_currentPageNmbr = 0;
  var $_rowCount = 0;
  var $_pageCount = 0;
  var $_loc;
  var $_fieldsInBiblio;

  function BiblioQuery () {
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

  function setItemsPerPage($value) {
    $this->_itemsPerPage = $value;
  }
  function getCurrentRowNmbr() {
    return $this->_currentRowNmbr;
  }
  function getRowCount() {
    return $this->_rowCount;
  }
  function getPageCount() {
    return $this->_pageCount;
  }

  function getLineNmbr() {
    return $this->_rowNmbr;
  }

  /****************************************************************************
   * Executes a query
   * @param string $bibid bibid of bibliography to select
   * @return Biblio a bibliography object or false if error occurs
   * @access public
   ****************************************************************************
   */
  /*###########################
    # WORKS WITH NEW FORMAT   #
    ###########################*/
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
	$bib->setImage_path($array["image_path"]);
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
	
    if (!$this->_query($sql, $this->_loc->getText("biblioQueryErr1"))) {
      return false;
    }
    $array = $this->_conn->fetchRow(OBIB_NUM);
    if ($array[0] > 0) {
      return true;
    }
    return false;
  }
  /*
  Autor: Horacio Alvarez
  Fecha: 13-06-2006
  Descripcion: Modificado para insertar tambien
  el path de la imagen, campo image_path
  */
  function insert($biblio) {
  	if($biblio->getLiteraturaFlg() != "CHECKED")
  	{
    //24/08/05 ini franco para ver q la signatura no este duplicada
    $dupCallNmbr1 = $this->_dupSigna($biblio->getCallNmbr1(),$biblio->getCallNmbr2(),$biblio->getCallNmbr3(), $biblio->getBibid());
    
    

    if ($this->errorOccurred()) return false;
    if ($dupCallNmbr1) {
      $this->_errorOccurred = true;
      $this->_error = $this->_loc->getText("biblioQueryErr3",array("callNmbr1"=>$biblio->getCallNmbr1()));
      return false;
    	}
	}

	//fin franco
	
	// inserting biblio row
    $biblioFlds = $biblio->getBiblioFields();

    $bibfields = array();	// fields in biblio table
    foreach ($this->_fieldsInBiblio as $key => $name) {
      if (array_key_exists($key, $biblioFlds) and $biblioFlds[$key]->getFieldid() == '') {
        $bibfields[$name] = $biblioFlds[$key]->getFieldData();
        unset($biblioFlds[$key]);
      } else {
        $bibfields[$name] = '';
      }
    }
	/*midicado franco*/
    $sql = $this->mkSQL("insert into biblio values(null, sysdate(), sysdate(), "
                        . "%N, %N, %N, %Q, %Q, %Q, %Q, %Q, %Q, %Q, %Q, "
                        . "%Q, %Q, %Q, %Q, %Q, %N, %Q, %N, %Q, %Q) ",
                        $biblio->getLastChangeUserid(),
                        $biblio->getMaterialCd(), $biblio->getCollectionCd(),
                        $biblio->getCallNmbr1(),
                        $biblio->getCallNmbr2(),
                        $biblio->getCallNmbr3(),
                        $bibfields['title'], $bibfields['title_remainder'],
                        $bibfields['responsibility_stmt'], $bibfields['author'],
                        $bibfields['topic1'], $bibfields['topic2'],
                        $bibfields['topic3'], $bibfields['topic4'],
                        $bibfields['topic5'],
                        $biblio->showInOpac() ? "Y" : "N", $biblio->getUserNameCreador(),$biblio->getFechaCatalog(),0,$biblio->getLiteraturaFlg() ? "Y" : "N",
						$biblio->getImage_path());
    if (!$this->_query($sql, $this->_loc->getText("biblioQueryInsertErr1"))) {
      return false;
    }
    $bibid = $this->_conn->getInsertId();
	# \/ Eduardo ROJEL 20/12/05 \/
/*    include ("../conexiondb.php");				
    $clean_name = "logotipo.jpeg";
    $path = "C:/apachefriends/xampp/htdocs/OpenBiblioF/images/";
    //$bibid = $_POST["bibid"];
    $arch_origen = $path.$clean_name;
    $arch_dest = $path."OUT-".$clean_name;  // ESTE DEBE EXISTIR, Y NOBODY DEBE TENER PERMISOS DE ESCRITURA Y LECTURA
    $arch_gen = "uploads/"."OUT-".$clean_name;
            chmod($arch_origen,0777);
    	    // Guarda en la BD la foto subida.
	    //echo $arch_origen;
	    $aux = split("\.",$arch_origen);
	    //echo "tipo";
	    $tipo = strtolower($aux[1]);
	    
	    ob_start();
	    $image = imagecreatefromjpeg($arch_origen);
	    imagejpeg($image);
  	    $imagen = ob_get_contents();
	    ob_end_clean();
	    $imagen = str_replace('##','\#\#',mysql_escape_string($imagen));
 
	   $orden = " INSERT INTO biblio_fotos(bibid,foto) VALUES ( $bibid, '$imagen') ; ";	
	   $query = mysql_query($orden,$conexion);   
	# /\ /\ /\ /\ /\ /\ /\ /\ /\ /\ /\ /\ /\ /\ /\ /\ /\ /\ /\ /\ /\ /\ /\ /\*/
	
    # inserting biblio_field rows
    if (!($this->_insertFields($biblioFlds, $bibid))) 
	{
      return false;
    }
	

    //insertando el indice ini franco
	$sql = $this->mkSQL("insert into biblio_index values(%N,%Q) ", $bibid, $biblio->getIndice());
	if (!$this->_query($sql, $this->_loc->getText("biblioQueryInsertErr1")))
    {
      return false;
    }
    //fin franco
	else
	{
			// ini 26/07/05 franco insertando en la tabla auditoria
			if (!$this->insertAuditoria($bibid,0,$biblio->getLastChangeUserid(),1,"biblio_index",$this->_loc->getText("biblioQueryInsertErr1")))
			{
			  return false;
			}
			//fin franco
	}
	
	// ini 25/07/05 franco insertando en la tabla auditoria
	if (!$this->insertAuditoria($bibid,0,$biblio->getUserNameCreador(),1,"biblio",$this->_loc->getText("biblioQueryInsertErr1")))
    {
      return false;
    }
    //fin franco
    return $bibid;
  }

  /****************************************************************************
   * Updates a bibliography in the biblio table.
   * @param Biblio $biblio bibliography to update
   * @return boolean returns false, if error occurs
   * @access public
   ****************************************************************************
   */
  /*###########################
    # WORKS WITH NEW FORMAT   #
    ###########################*/
	
  /*
  Autor: Horacio Alvarez
  Fecha: 27-05-06
  Descripcion: Modificado porque se agregó el campo image_path
  en la tabla BIBLIO.
  */
  function update($biblio, $checkout=FALSE) {
    # checking for duplicate barcode number
  if (!$checkout) 
  {
     if($biblio->getLiteraturaFlg() != "CHECKED")
  	{
	  //24/08/05 ini franco para ver q la signatura no este duplicada
    $dupCallNmbr1 = $this->_dupSigna($biblio->getCallNmbr1(),$biblio->getCallNmbr2(),$biblio->getCallNmbr3(), $biblio->getBibid());
    if ($this->errorOccurred()) return false;
    if ($dupCallNmbr1) 
	{
      $this->_errorOccurred = true;
      $this->_error = $this->_loc->getText("biblioQueryErr3",array("callNmbr1"=>$biblio->getCallNmbr1()));
	  //echo "<h1>entro y devuelve false</h1>";
      return false;
    }
	}
  }
    $biblioFlds = $biblio->getBiblioFields();
	
	
    // updating biblio table
    $sql = $this->mkSQL("update biblio set last_change_dt = sysdate(), "
                        . " last_change_userid=%N, material_cd=%N, "
                        . " collection_cd=%N, "
                        . " call_nmbr1=%Q, call_nmbr2=%Q, call_nmbr3=%Q, date_sptu=%Q,",
                        $biblio->getLastChangeUserid(),
                        $biblio->getMaterialCd(), $biblio->getCollectionCd(),
                        $biblio->getCallNmbr1(), $biblio->getCallNmbr2(),
                        $biblio->getCallNmbr3(), $biblio->getFechaCatalog());
						
	$imagePath=$biblio->getImage_path();
	if($imagePath!="")
	 {
      $sql.=$this->mkSQL(" image_path=%Q, ",$biblio->getImage_path());	
	  }
	  
    foreach ($this->_fieldsInBiblio as $key => $name) {

      if (array_key_exists($key, $biblioFlds) and $biblioFlds[$key]->getFieldid() == '') {
        $sql .= $this->mkSQL("%I=%Q, ", $name, $biblioFlds[$key]->getFieldData());
        unset($biblioFlds[$key]);
      } else {
        $sql .= $this->mkSQL("%I='', ", $name);
      }
    }
    $sql .= $this->mkSQL("opac_flg=%Q, literatura_flg=%Q where bibid=%N ",
                        $biblio->showInOpac() ? "Y" : "N",$biblio->getLiteraturaFlg() ? "Y" : "N", $biblio->getBibid());

    if (!$this->_query($sql, $this->_loc->getText("biblioQueryUpdateErr1"))) 
    {
      return false;
    }
   
    // 26/07/05 ini franco 
	else
	{
		if (!$this->insertAuditoria($biblio->getBibid(),0,$_SESSION["userid"],3,"biblio",$this->_loc->getText("biblioQueryInsertErr1")))
		{
		  return false;
		}

	}
	// fin franco

    // inserting (or updating) biblio_field rows from update Biblio object.
    if (!($this->_insertFields($biblioFlds, $biblio->getBibid()))) {
      return false;
    }
   //actualizando el indice ini franco 05/07/05
	$sql = $this->mkSQL("update biblio_index set indice=%Q where bibid=%N", $biblio->getIndice(), $biblio->getBibid());
	if (!$this->_query($sql, $this->_loc->getText("biblioQueryInsertErr1")))
    {
      return false;
    }
    //fin franco
	// 26/07/05 ini franco 
	else
	{
		if (!$this->insertAuditoria($biblio->getBibid(),0,$_SESSION["userid"],3,"biblio_index",$this->_loc->getText("biblioQueryInsertErr1")))
		{
		  return false;
		}

	}
	// fin franco



      return true;
  }


  /****************************************************************************
   * Inserts biblio_field rows
   * @param array reference $biblioFlds an array of BiblioField objects
   * @param int bibid id of bibliography to insert fields into
   * @return boolean returns false if error occurs
   * @access private
   ****************************************************************************
   */
  function _insertFields(&$biblioFlds, $bibid) {
    foreach ($biblioFlds as $key => $value) {
//   echo "<h3>id: ".$value->getFieldid()."</h3> <br>";
	//echo "<h3>data: ".$value->getFieldData()."</h3> <br>";
      if ($value->getFieldData() == "") {
        // value has been set to spaces, we may need to delete it
        if ($value->getFieldid() == "") {
          $sql = NULL;
        } else {
          $sql = $this->mkSQL("delete from biblio_field "
                                . "where bibid=%N and fieldid=%N ",
                                $value->getBibid(), $value->getFieldid());
//				echo "<h1> borra". $sql ."</h1>";

		    // ini 26/07/05 franco insertando en la tabla auditoria
			if (!$this->insertAuditoria($bibid,0,$_SESSION["userid"],2,"biblio_field",$this->_loc->getText("biblioQueryInsertErr1")))
			{
			  return false;
			}
			//fin franco
	
        }          
      } elseif ($value->getFieldid() == "") {
        // new value
        $sql = $this->mkSQL("insert into biblio_field "
                            . "values (%N, null, %Q, 'N','N', %Q, %Q) ",
                            $bibid, $value->getTag(),
                            $value->getSubfieldCd(),
                            $value->getFieldData());
	//echo "<h1> inserta". $sql ."</h1>";
			// ini 26/07/05 franco insertando en la tabla auditoria
			if (!$this->insertAuditoria($bibid,0,$_SESSION["userid"],1,"biblio_field",$this->_loc->getText("biblioQueryInsertErr1")))
			{
			  return false;
			}
			//fin franco

      } else {
        // existing value
        $sql = $this->mkSQL("update biblio_field set field_data = %Q "
                            . "where bibid=%N and fieldid=%N ",
                            $value->getFieldData(), $value->getBibid(),
                            $value->getFieldid());
	//echo "<h1> apadta". $sql ."</h1>";
			// ini 26/07/05 franco insertando en la tabla auditoria
			if (!$this->insertAuditoria($bibid,0,$_SESSION["userid"],3,"biblio_field",$this->_loc->getText("biblioQueryInsertErr1")))
			{
			  return false;
			}
			//fin franco
      }
    
      if ($sql != NULL) {
        if (!$this->_query($sql, $this->_loc->getText("biblioQueryInsertErr2"))) {
          return FALSE;
        }
      }
    }
    return true;
  }

  /****************************************************************************
   * Deletes a bibliography from the biblio table.
   * @param string $bibid bibliography id of bibliography to delete
   * @return boolean returns false, if error occurs
   * @access public
   ****************************************************************************
   */
  function delete($bibid) {
    $sql = $this->mkSQL("delete from biblio_field where bibid = %N ", $bibid);
    if (!$this->_query($sql, $this->_loc->getText("biblioQueryDeleteErr"))) 
    {
      return false;
    }
    // 26/07/05 ini franco 
	else
	{
		if (!$this->insertAuditoria($bibid,0,$_SESSION["userid"],2,"biblio_field",$this->_loc->getText("biblioQueryInsertErr1")))
		{
		  return false;
		}

	}
	// fin franco
    $sql = $this->mkSQL("delete from biblio where bibid = %N ", $bibid);
	//inicio franco 26/07/05
	if (!$this->insertAuditoria($bibid,0,$_SESSION["userid"],2,"biblio",$this->_loc->getText("biblioQueryInsertErr1")))
	{
	  return false;
	}//fin franco
    return $this->_query($sql, $this->_loc->getText("biblioQueryDeleteErr"));
  }

 	/* las tres siguiente son
    funciones utilizadas  unicamente para aprobar material
	creada el 27-28/07/05*/
	function pendienteDeApronacion($page)
	{

		# reset stats
		$this->_rowNmbr = 0;
		$this->_currentRowNmbr = 0;
		$this->_rowCount = 0;
		$this->_currentPageNmbr=$page;
		$this->_pageCount = 0;
	
		# setting count query
    	$sqlcount = "select count(*) as rowcount from biblio where biblio.aprob_flg=0";
		
		# setting query that will return all the data
		$sql = $this->mkSQL("select biblio.bibid , biblio.title from biblio where biblio.aprob_flg=%N",0);
	
		# setting limit so we can page through the results
	    $offset = ($page - 1) * $this->_itemsPerPage;
    	$limit = $this->_itemsPerPage;
	    $sql .= $this->mkSQL(" limit %N, %N", $offset, $limit);

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
	$bib->setTitle($array["title"]);
    
    return $bib;
  }
	function updateFlgAprobacion($bibid)
	{
		//echo"entra a la funcion con bibid".$bibid;
		if(!is_numeric($bibid)){settype($bibid,"integer") ;}
		// updating biblio table
    	$sql = $this->mkSQL("update biblio set last_change_dt = sysdate(), "
		. " last_change_userid=%N, aprob_flg=%N  ", $_SESSION["userid"],1);
		$sql.= $this->mkSQL("where bibid=%N ",$bibid);
//echo"<br>";
		//echo "sentencia ".$sql;
		if (!$this->_query($sql, $this->_loc->getText("biblioQueryUpdateErr1"))) 
    	{  
 		//echo  "no lo hizo";
		return false;
    	}
		// 29/07/05 ini franco 
		else
		{
//echo  "sio aca esta el maltido lo hizo". $bibid;
$bi=$bibid;
			if (!$this->insertAuditoria($bi,0,$_SESSION["userid"],3,"biblio",$this->_loc->getText("biblioQueryInsertErr1")))
			{
//echo  "no lo hizo auditoria";
			  return false;
			}
			if (!$this->insertAuditoria($bi,0,$_SESSION["userid"],4,"biblio",$this->_loc->getText("biblioQueryInsertErr1")))
			{
//echo  "no lo hizo auditoria2";
			  return false;
			}
		
		}
		// fin franco
return true;
	}


}

?>
