<?php

    $hname = "127.0.0.1:3308";
    $uname= "root";
    $pass = "Shubhankar@515";
    $db = "hotel_booking_system";

    $con = mysqli_connect($hname,$uname,$pass,$db);


    /* if connection doesn't established */
    if(!$con){
        die("Cannot Connect to Database".mysqli_connect_error());
    }


    function filtration($data){
        foreach($data as $key => $value){
            // trim() /* removes extra spaces */
            // stripslashes() /* remove splashes */
            // htmlspecialchars()  /* special characters like '<' will convert into HTML entities*/
            // strip_tags() /* did not allow html tags to run */

            $data[$key] = trim($value);
            $data[$key] = stripslashes($value);
            $data[$key] = htmlspecialchars($value);
            $data[$key] = strip_tags($value);
        }
        return $data;
    }

    function select($sql,$values,$datatype)
    {
        $con = $GLOBALS['con'];  // $con has been already declared outside of this function so to call this again we have to use $GLOBALS
        if($stmt = mysqli_prepare($con,$sql))
        {
            mysqli_stmt_bind_param($stmt,$datatype,...$values);
            if(mysqli_stmt_execute($stmt)){
               $res = mysqli_stmt_get_result($stmt);
               mysqli_stmt_close($stmt);  // it is necessary to close the prepared statements
               return $res;
            }
            else{
                mysqli_stmt_close($stmt);
                die("Query cannot be executed - Select");
            }
        }
        else{
            die("Query cannot be prepared - Select");
        }
    }

    function update($sql,$values,$datatype)
    {
        $con = $GLOBALS['con'];  // $con has been already declared outside of this function so to call this again we have to use $GLOBALS
        if($stmt = mysqli_prepare($con,$sql))
        {
            mysqli_stmt_bind_param($stmt,$datatype,...$values);
            if(mysqli_stmt_execute($stmt)){
               $res = mysqli_stmt_affected_rows($stmt);
               mysqli_stmt_close($stmt);  // it is necessary to close the prepared statements
               return $res;
            }
            else{
                mysqli_stmt_close($stmt);
                die("Query cannot be executed - Update");
            }
        }
        else{
            die("Query cannot be prepared - Update");
        }
    }


?>