<?php
include 'database.php';
session_start();
if(isset($_SESSION["delete_id"]) && isset($_POST["delete"])){
    $id = $_SESSION["delete_id"];
}else{
    header("Location: error.html");
}

$table = $_SESSION["table"];
    
$id_name = getIdName($table);

$db = connect();

$sql = 'DELETE FROM '.$table.' WHERE '.$id_name.' = '.$id;
$result = query($db,$sql);
if($result){
    $Msg = array('<strong><p>ID:'.$id.' Delete Successfully!</P></strong>');
}else{
    $Msg = getErrorMsg($db);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Delete</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container">
<form name="form" method = "POST" action="delete.html">
    <div class="form-group" id="center">
        <h1>DBMS Online Book Store</h1>
        <h3>Delete Result : <?php echo $table; ?> </h3>
        <hr>
        <?php
        foreach($Msg as $value)
            echo $value;
        ?>
        <a href="delete.html" class="btn btn-primary">Back to Delete</a>
        <a href="index.html" class="btn btn-primary">Back to DBMS</a>
    </div>
</form>
</div>
</body>
</html>
