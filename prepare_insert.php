<?php
include 'database.php';

session_start();

    if(isset($_SESSION["table"])){
        $table = $_SESSION["table"];
    }else{
        header("Location: error.html");
    }

    $db = connect();

    $sql = "SELECT * FROM ".$table;

    $result = query($db,$sql);

    $fields = getFields($result);
    $_SESSION["fields_for_insert"] = $fields;

    $Msg =array();

    array_push($Msg,"<div class="."form-group".">");
    $id = $fields[0];

    $insert_id = getCount($result)+1;       //get next insert ID ex: already have 10 record, then insert id:11

    $row = "<label for=".$id.">".$id.":</label><input type="."text"." class="."form-control"." id=".$id." name=".$id." value=".$insert_id."  readonly>";    //set readonly to restrict input and set the default value, not using disabled because the value won't be posted.
    array_push($Msg,$row);

    for($i = 1;$i<getFieldsNum($result);$i++){
        $field = $fields[$i];
        $row = "<label for=".$field.">".$field.":</label><input type="."text"." class="."form-control"." id=".$field." name=".$field.">";
        array_push($Msg,$row);
    }
    array_push($Msg,"</div>");
    free($result);
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
<form name="form" method = "POST" action="insert.php">
    <div class="form-group" id="center">
        <br>
        <h1>DBMS Online Book Store</h1>
        <h3>Insert Into: <?php echo $table; ?> </h3>
        <hr>
        <?php
        foreach($Msg as $value)
            echo $value;
        ?>
        <input class="btn btn-primary" name="search" type="submit" value="Insert"/>
        <input  class="btn" name="reset" type="reset" value="reset"/>
        <a href="index.html" class="btn btn-primary">Back to DBMS</a>
    </div>
</form>
</div>
</body>
</html>
