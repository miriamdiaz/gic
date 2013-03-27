<h1>hola</h1>

<?php 
require_once("../classes/Library.php");
$lb=new Library();
$lb->setCode(45);
echo "code= ".$lb->getCode();
?>
