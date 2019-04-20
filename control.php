<?php
session_start();

if(isset($_POST["table"]) && isset($_POST["function"])){
    $table = $_POST["table"];
    $function = $_POST["function"];
}else{
    header("Location: error.html");
}
    
$_SESSION["function"] = $function;
$_SESSION["table"] = $table;

switch($function){
    case "search":
        header("Location: select.html");
        break;
    case "insert":
        header("Location: prepare_insert.php");
        break;
    case "update":
        header("Location: update.html");
        break;
    case "delete":
        header("Location: delete.html");
        break;
    case "connect":
        header("Location: table.php");
        break;
}

?>