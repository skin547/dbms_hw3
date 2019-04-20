<?php
include 'database.php';
session_start();

    if(empty($_POST["id"])||(!ctype_digit($_POST["id"]))){
        header("Location: error.html");
    }else{
        $id = $_POST["id"];
        $_SESSION["delete_id"] = $id;
    }

    $table = $_SESSION["table"];
    
    $id_name = getIdName($table);

    $db = connect();

    $sql = 'SELECT * FROM '.$table.' where '.$id_name.' = '.$id;
    $result = query($db,$sql);
    if($result){
        $fields = getFields($result);
        $tuples = getTuples($result);
        if($fields == null || $tuples == null){
            $Msg=array("<strong>Data does not exist!!</strong></br></br>");
        }else{
            if(query($db,$sql)){
                $Msg = getMsg($fields,$tuples);
            }else{
                $Msg = getErrorMsg($db);
            }
        }
    }else{
        $Msg = getErrorMsg($db);
    }

    free($result);
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
<form name="form" method = "POST" action="delete.php">
    <div class="form-group" id="center">
        <h1>DBMS Online Book Store</h1>
        <h3>Delete Confirmation : <?php echo $table; ?> </h3>
        <h5>You are going to delete:</h5>
        <hr>
        <?php
        foreach($Msg as $value)
            echo $value;
        ?>
        <?php if(!($fields == null || $tuples == null)){?>
        <input class="btn btn-primary" name="delete" type="submit" value="Delete">
        <?php } ?>
        <a href="delete.html" class="btn btn-primary">Back to Search</a>
        <a href="index.html" class="btn btn-primary">Back to DBMS</a>
    </div>
</form>
</div>
</body>
</html>
