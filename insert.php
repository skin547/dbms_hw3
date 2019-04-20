<?php
include 'database.php';
session_start();
    $fields_for_insert = array();
    if(isset($_SESSION["fields_for_insert"])&&isset($_SESSION["table"])){
        $fields_for_insert = $_SESSION["fields_for_insert"];
        $table=$_SESSION["table"];
    }else{
        header("Location: error.html");
    }

    $db = connect();

    $insert_value = "";
    $insert_value_array = array();
    foreach($fields_for_insert as $value){
        $insert_col = $_POST[$value];
        $insert_value.="'".$insert_col."', "; 
        array_push($insert_value_array,$insert_col);
    }
    $insert_value = substr($insert_value,0,-2); //remove the comma(,) at the end
    $sql = "INSERT INTO ".$table." VALUES (".$insert_value." )";
    $result = query($db,$sql);

    if($result){
        $Msg = getMsg($fields_for_insert,array($insert_value_array));
    }else{
        $Msg = getErrorMsg($db);
    }

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Insert</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container">
<form name="form" method = "POST" action="prepare_insert.php">
    <div class="form-group" id="center">
        <br>
        <h1>DBMS Online Book Store</h1>
        <h3>You have insert into <?php echo $table; ?> with:</h3>
        <hr>
        <?php
        foreach($Msg as $value)
            echo $value;
        ?>
        <input class="btn btn-primary" name="search" type="submit" value="Back to Insert"/>
        <a href="index.html" class="btn btn-primary">Back to DBMS</a>
    </div>
</form>
</div>
</body>
</html>
