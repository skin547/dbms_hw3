<?php
include 'database.php';
session_start();
    if(isset($_SESSION["table"])){
        $table = $_SESSION["table"];
    }else{
        header("Location: error.html");
    }
    if(isset($_SESSION["function"])){
        $function = $_SESSION["function"];
    }
    $db = connect();
    $sql = "SELECT * FROM ".$table;
    
    $result = query($db,$sql);

    
    if($result){
        $fields = getFields($result);
        $tuples = getTuples($result);
        $Msg = getMsg($fields,$tuples);
    }else{
        $Msg = getErrorMsg($db);
    }
    free($result);

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title><?php echo $table; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" 
    href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
</head>
<body>
<div class="container">
<form name="form" method = "POST" action="index.html">
    <div class="form-group" id="center">
        <br>
        <h1>DBMS Online Book Store</h1>
        <h3><?php echo $table." ".$function; ?> Result:</h3>
        <hr>
        <?php
        foreach($Msg as $value){
            echo $value;
        }
        ?>
        <input class="btn btn-primary" name="search" type="submit" value="Back to DBMS"/>
    </div>
</form>
</div>
</body>
</html>
