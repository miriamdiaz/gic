<?php require_once("../functions/errorFuncs.php");
require_once("../classes/Dm.php");
require_once("../classes/DmQuery.php");
function printSelect($fieldName,$domainTable,&$postVars,$disabled=FALSE)
{
  $value = "";
  if (isset($postVars[$fieldName])) 
  {
      $value = $postVars[$fieldName];
  }
  $dmQ = new DmQuery();
  $dmQ->connect();
  if ($dmQ->errorOccurred()) 
  {
    $dmQ->close();
    displayErrorPage($dmQ);
  }
  $dmQ->execSelect($domainTable);
  if ($dmQ->errorOccurred()) 
  {
    $dmQ->close();
    displayErrorPage($dmQ);
  }
  echo "<select id=\"".$fieldName."\" name=\"".$fieldName."\"";
  if ($disabled) 
  {
    echo " disabled";
  }
  echo ">\n";
  while ($dm = $dmQ->fetchRow()) 
  {
    echo "<option value=\"".$dm->getCode()."\"";
    if (($value == "") && ($dm->getDefaultFlg() == 'Y')) 
    {
      echo " selected";
    } 
    elseif ($value == $dm->getCode()) 
    {
      echo " selected";
    }
    echo ">".$dm->getDescription()."\n";
  }
  echo "</select>\n";
  $dmQ->close();
} ?>
<?php printSelect("copyCodLoc","biblio_cod_library",$postVars)?>