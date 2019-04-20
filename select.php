<?php
include 'database.php';

    session_start();
    if(empty($_POST["id"])||(!ctype_digit($_POST["id"]))){
        header("Location: error.html");
    }else{
        $id = $_POST["id"];
    }
    $table = $_SESSION["table"];
    
    $id_name = getIdName($table);

    $db = connect();

    $sql = "SELECT * FROM ".$table." where ".$id_name." = ".$id;
    $result = query($db,$sql);
    if($result){
        $fields = getFields($result);
        $tuples = getTuples($result);
        if($fields == null || $tuples == null){
            $Msg = array();
            $relate = null;
            array_push($Msg,"<strong>Data does not exist!!</strong></br></br>");
        }else{
            $Msg = getMsg($fields,$tuples);
            $relate = getRelation($db,$table,$id);
            if($relate){                        //Check if this table have relation
                $relate_fields = getFields($relate);
                $relate_tuples = getTuples($relate);
                $relate_Msg = getMsg($relate_fields,$relate_tuples);
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
    <title>Query</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container">
<form name="form" method = "POST" action="select.html">
    <div class="form-group" id="center">
        <br>
        <h1>DBMS Online Book Store</h1>
        <h3><?php echo $table; ?> Query Result:</h3>
        <hr>
        <?php
        foreach($Msg as $value)
            echo $value;
        ?>
        <?php 
            if($relate){
                echo "<strong>Relation:</strong><hr>";
                foreach($relate_Msg as $value){
                    echo $value;
                }
            }
        ?>
        <input class="btn btn-primary" name="search" type="submit" value="Back to Query"/>
        <a href="index.html" class="btn btn-primary">Back to DBMS</a>
    </div>
</form>
</div>
</body>
</html>
