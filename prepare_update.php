<?php
include 'database.php';

session_start();
    if( empty($_POST["id"]) || ( !ctype_digit($_POST["id"]) ) ){
        header("Location: error.html");
    }else{
        $id = $_POST["id"];
        $table = $_SESSION["table"];
    }
    $id_name = getIdName($table);
    $db = connect();
    //select id
    $sql = "SELECT * FROM ".$table." where ".$id_name." = ".$id;
    $result = query($db,$sql);

    $Msg = array();

    if($result){
        $fields = getFields($result);
        $tuples = getTuples($result);    
        $_SESSION["fields_for_update"] = $fields;
        if($fields == null || $tuples == null){
            array_push($Msg,"<strong>Data does not exist!!</strong></br></br>");
        }else{
            array_push($Msg,"<div class="."form-group".">");
            $id_name = $fields[0];    
            $update_id = $tuples[0][0];
            $row = "<label for=".$id_name.">".$id_name.":</label><input type="."text"." class="."form-control"." id=".$id_name." name=".$id_name." value=".$update_id."  readonly>";    
            //set readonly to restrict input and set the default value, not using disabled because the value won't be posted.
            array_push($Msg,$row);
            for($i = 1;$i<getFieldsNum($result);$i++){
                $field = $fields[$i];
                $value = trim($tuples[0][$i]);
                $row = "<label for=".$field.">".$field.":</label><input type="."text"." class="."form-control"." id=".$field." name=".$field." value= '".$value."' >";
                array_push($Msg,$row);
            }
            array_push($Msg,"</div>");
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
    <title>Update</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container">
<form name="form" method = "POST" action="update.php">
    <div class="form-group" id="center">
        <br>
        <h1>DBMS Online Book Store</h1>
        <h3>Update: <?php echo $table; ?> </h3>
        <hr>
        <?php
        foreach($Msg as $value)
            echo $value;
        ?>
        <input class="btn btn-primary" name="search" type="submit" value="Update"/>
        <input  class="btn" name="reset" type="reset" value="reset"/>
        <a href="index.html" class="btn btn-primary">Back to DBMS</a>
    </div>
</form>
</div>
</body>
</html>
