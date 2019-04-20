<?php
include 'database.php';
session_start();
    $fields_for_update = array();
    if(isset($_SESSION["fields_for_update"])&&isset($_SESSION["table"])){
        $fields_for_update = $_SESSION["fields_for_update"];
        $table=$_SESSION["table"];
        $id_name = $fields_for_update[0];
    }else{
        header("Location: error.html");
    }

    $db = connect();
    $id = $_POST[$id_name];
    $update_value = "";
    $update_value_array = array();
    foreach($fields_for_update as $value){
        $update_col = $_POST[$value];
        $update_value.=" ".$value." = "." '".$update_col."', "; 
        array_push($update_value_array,$update_col);
    }
    $update_value = substr($update_value,0,-2); //remove the comma(,) at the end
    $sql = "UPDATE  ".$table." SET ".$update_value."  WHERE ".$id_name." = ".$id;
    $result = query($db,$sql);
    if($result){
        $Msg = getMsg($fields_for_update,array($update_value_array));
    }else{
        $Msg = getErrorMsg($db);
    }

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Update</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container">
<form name="form" method = "POST" action="update.html">
    <div class="form-group" id="center">
        <br>
        <h1>DBMS Online Book Store</h1>
        <h3><?php echo $table; ?> Update result:</h3>
        <hr>
        <?php
        foreach($Msg as $value)
            echo $value;
        ?>
        <input class="btn btn-primary" name="update" type="submit" value="Back to Update"/>
        <a href="index.html" class="btn btn-primary">Back to DBMS</a>
    </div>
</form>
</div>
</body>
</html>
