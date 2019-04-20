<?php

    function connect(){
        $db = mysqli_connect(
            'localhost',
            'root',//user
            '',//password
            'bookstore'//db
        )or die("無法開啟MySQL資料庫連接!<br>");
        return $db;
    }

    function disConnect($db){
        mysqli_close($db);
    }

    function free($result){
        mysqli_free_result($result);
    }

    function query($db,$sql){
        mysqli_query($db, 'SET NAMES utf8');
        $result = mysqli_query($db,$sql);
        return $result;
    }
    function getIdName($table){
        switch($table){
            case "member":
                $id_name = "M_Id";
                break;
            case  "book":
                $id_name = "B_Id";
                break;
            case  "orderhistory":
                $id_name = "O_Id";
                break;
            case  "supplier":
                $id_name = "P_Id";
                break;
            default:
                header("Location: error.html");
        }
        return $id_name;
    }

    function getFields($result){
        $fields = array();
        if($result->num_rows == 0){
            return null;
        }else{
            while($meta = mysqli_fetch_field($result)){
                array_push($fields,$meta->name);
            }
        }
        return $fields;
    }
    
    function getCount($result){
        $count = mysqli_num_rows($result);
        // return $count[0];
        return $count;
    }
    
    function getFieldsNum($result){
        $total_fields = mysqli_num_fields($result);
        return $total_fields;
    }

    function getTuples($result){
        $total_fields = getFieldsNum($result);
        $tuples = array();
        if($result->num_rows == 0){
            return null;
        }else{
            while($row = mysqli_fetch_row($result)){
                $tuple = array();
                for($i = 0;$i<=$total_fields-1;$i++){
                    array_push($tuple,$row[$i]);
                }
            array_push($tuples,$tuple);
            }
            return $tuples;
        }
    }

    function getMsg($fields,$tuples){       //get the Message
        $Msg = array();
        array_push($Msg,"<div class="."row".">");

        foreach($fields as $field){
            array_push($Msg,"<div class="."col".">".$field."</div>");
        }
        array_push($Msg," </div> <hr>");

        foreach($tuples as $t){
            array_push($Msg,"<div class=row>");
            foreach($t as $value){
                array_push($Msg,"<div class="."col".">".$value."</div>");
            }
            array_push($Msg,"</div></br>");
        }
        return $Msg;
    }

    function getErrorMsg($db){
        $Msg = array("Error!!:</br>" .mysqli_error($db)."</br>");
        return $Msg;
    }

    function getRelation($db,$table,$id){
        if($table == "book"){
            $relate_table = 'supplier';
            $relate_id = 'P_ID';
            $id = $id;
        }elseif($table == "orderhistory"){
            $relate_table = 'odetail';
            $relate_id = 'O_Id';
            $id = $id;
        }else{
            return null;
        }
        
        $id_name = getIdName($table);
        $sql = 'SELECT * from '.$relate_table.' WHERE '.$relate_table.'.'.$relate_id.' = (SELECT '.$relate_id.' FROM '.$table.' WHERE '.$table.'.'.$id_name." = ".$id.")";
        $result = query($db,$sql);
        if($result){
            return $result;
        }else{
            return getErrorMsg($db);
        }
    }
?>