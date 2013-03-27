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
require_once("../classes/DbConnection.php");

/******************************************************************************
 * Query parent data access component class for all data access components
 *
 * @author David Stevens <dave@stevens.name>;
 * @version 1.0
 * @access public
 ******************************************************************************
 */
class Query {
  var $_conn;
  var $_errorOccurred = false;
  var $_error = "";
  var $_dbErrno = "";
  var $_dbError = "";
  var $_SQL = "";

  /****************************************************************************
   * Instantiates private connection var and connects to the database
   *
   * @return void
   * @access public
   ****************************************************************************
   */
  function connect() {
    $this->_conn = new DbConnection();
    $rc = $this->_conn->connect();
    if ($rc == false) {
      $this->_errorOccurred = true;
      $this->_error = $this->_conn->getError();
      $this->_dbErrno = $this->_conn->getDbErrno();
      $this->_dbError = $this->_conn->getDbError();
      return false;
    }
    return true;
  }
  /****************************************************************************
   * Closes database and destroys connection
   *
   * @return boolean returns false, if error occurs
   * @access public
   ****************************************************************************
   */
  function close() {
    $rc = $this->_conn->close();
    if ($rc == false) {
      $this->_errorOccurred = true;
      $this->_error = $this->_conn->getError();
      $this->_dbErrno = $this->_conn->getDbErrno();
      $this->_dbError = $this->_conn->getDbError();
      unset($this->_conn);
      return false;
    }
    unset($this->_conn);
    return true;
  }

  /****************************************************************************
   * Makes SQL by interpolating values into a format string.
   * This function works something like printf() for SQL queries.  Format
   * strings contain %-escapes signifying that a value from the argument
   * list should be inserted into the string at that point.  The routine
   * properly quotes or transforms the value to make sure that it will be
   * handled correctly by the SQL server.  The recognized format strings
   * are as follows:
   *  %% - is replaced by a single '%' character and does not consume a
   *       value form the argument list.
   *  %C - treats the argument as a column reference.  This differs from
   *       %I below only in that it passes the '.' operator for separating
   *       table and column names on to the SQL server unquoted.
   *  %I - treats the argument as an identifier to be quoted.
   *  %N - treats the argument as a number and strips off all of it but
   *       an initial numeric string with optional sign and decimal point.
   *  %Q - treats the argument as a string and quotes it.
   * @param string $fmt format string
   * @param string ... optional argument values
   * @return string the result of interpreting $fmt
   * @access public
   ****************************************************************************
   */
  function mkSQL() {
    $n = func_num_args();
    if ($n < 1)
      return false;
    $i = 1;
    $SQL = "";
    $fmt = func_get_arg(0);
    while (strlen($fmt)) {
      $p = strpos($fmt, "%");
      if ($p === false) {
        $SQL .= $fmt;
        break;
      }
      $SQL .= substr($fmt, 0, $p);
      if (strlen($fmt) < $p+2)
        return false;
      if ($fmt{$p+1} == '%') {
        $SQL .= "%";
      } else {
        if ($i >= $n)
          return false;
        $arg = func_get_arg($i++);
        switch ($fmt{$p+1}) {
        case 'C':
          $a = array();
          foreach (explode('.', $arg) as $ident) {
            array_push($a, $this->_conn->ident($ident));
          }
          $SQL .= implode('.', $a);
          break;
        case 'I':
          $SQL .= $this->_conn->ident($arg);
          break;
        case 'N':
		{
			//echo"<h1>entra a numstr arg: </h1>".$arg."<--";
          $SQL .= $this->_conn->numstr($arg);
		 }
          break;
        case 'Q':
          $SQL .= $this->_conn->quote($arg);
          break;
        default:
          return false;
        }
      }
      $fmt = substr($fmt, $p+2);
    }
    return $SQL;
  }

  /****************************************************************************
   * Executes an SQL query handling the standard bookkeeping.
   * @param string $sql query string
   * @param string $msg error message to be returned if the query fails
   * @return boolean false if there was an error
   * @access private to be used by subclasses only
   ****************************************************************************
   */
  function _query($sql, $msg) {
    $result = $this->_conn->exec($sql);
    if ($result == false) {
      $this->_errorOccurred = true;
      $this->_error = $msg;
      $this->_dbErrno = $this->_conn->getDbErrno();
      $this->_dbError = $this->_conn->getDbError();
      $this->_SQL = $sql;
      return false;
    }
    return $result;
  }

  /****************************************************************************
   * @return boolean true if error occurred
   * @access public
   ****************************************************************************
   */
  function resetResult() {
    return $this->_conn->resetResult();
  }

  /****************************************************************************
   * clears error info
   * @access public
   ****************************************************************************
   */
  function clearErrors() {
    $this->_errorOccurred = false;
    $this->_error = "";
    $this->_dbErrno = "";
    $this->_dbError = "";
  }

  /****************************************************************************
   * @return boolean true if error occurred
   * @access public
   ****************************************************************************
   */
  function errorOccurred() {
    return $this->_errorOccurred;
  }
  /****************************************************************************
   * @return string error message
   * @access public
   ****************************************************************************
   */
  function getError() {
    return $this->_error;
  }
  /****************************************************************************
   * @return string error number returned from database
   * @access public
   ****************************************************************************
   */
  function getDbErrno() {
    return $this->_dbErrno;
  }
  /****************************************************************************
   * @return string error message returned from database
   * @access public
   ****************************************************************************
   */
  function getDbError() {
    return $this->_dbError;
  }
  /****************************************************************************
   * @return string SQL used in query when an error occurs in Query execution
   * @access public
   ****************************************************************************
   */
  function getSQL() {
    return $this->_SQL;
  }
  // 25/7/05 ini franco funcion para introducir registro en la tabla auditoria
  function insertAuditoria($bibid,$copyid,$userid,$op,$tabla,$error)
  {
    $sql = $this->mkSQL("insert into auditoria values(%N,%N,sysdate(),%N,%N,%Q) ", $bibid,$copyid,$userid,$op,$tabla);
	if (!$this->_query($sql,$error))
    {
      	return false;
    }
	else
	{
		return true;		
	}

  }//fin franco
  
  /**
  Autor: Horacio Alvarez
  Modificado: 26-06-03
  Descripcion: Actualiza las reservas vencidas
  */  
  function actualizarReservasVencidas()
  {
    $error="No se puede ejecutar el proceso de actualizacion de reservas vencidas";
	$sql="select holdid, mbrid, bibid, copyid, hold_begin_dt  from biblio_hold where hold_begin_dt < CURRENT_DATE";
	$result=$this->_query($sql,$error);
	while($row=mysql_fetch_array($result))
	    {
		 $bibid = $row["bibid"];
		 $copyid = $row["copyid"];
		 $holdid = $row["holdid"];
		 $mbrid = $row["mbrid"];
		 $hold_begin_dt = $row["hold_begin_dt"];
		 $sql = "select status_cd from biblio_copy where bibid = $bibid and copyid = $copyid";
		 $result2 = $this->_query($sql,$error);
		 if($row2 = mysql_fetch_array($result2))
		      {
			   $status_cd = $row2["status_cd"];
			   if($status_cd == "out")
			      {
				   //sumo 1 dia al dia pactado de reserva.
		           $timestamp_current = strtotime($hold_begin_dt);
                   $timestamp_future  = $timestamp_current + (60*60*24*1);				   
				   $new_hold_begin_dt = date('Y-m-d', $timestamp_future);
				   $sql = "update biblio_hold set hold_begin_dt = '$new_hold_begin_dt' where bibid = $bibid and copyid = $copyid and holdid = $holdid";
				   $this->_query($sql,$error);
				  }
			   else
			      {
                   $sql = "delete from biblio_hold where bibid = $bibid and copyid = $copyid and holdid = $holdid";
	               $this->_query($sql,$error);  				   
		           $sql="update member set cantidad_reservas=cantidad_reservas-1 where mbrid = $mbrid ";
		           $this->_query($sql,$error);				   
                   //$sql = "update biblio_copy set status_cd='in' where status_cd='hld' and due_back_dt<CURRENT_DATE";
				   $sql = "update biblio_copy set status_cd = 'in', mbrid = null where bibid = $bibid and copyid = $copyid";
	               $this->_query($sql,$error);
				  }
			  }

		}
	$sql = "select bibid,copyid from biblio_copy where status_cd = 'hld' and due_back_dt < CURRENT_DATE ";
	$result = $this->_query($sql,$error);
	while($row = mysql_fetch_array($result))
	    {
		 $bibid = $row["bibid"];
		 $copyid = $row["copyid"];
	     $sql = "update biblio_copy set status_cd = 'in', mbrid = null where bibid = $bibid and copyid = $copyid ";
	     $this->_query($sql,$error);	
		}	
  }

}

?>
