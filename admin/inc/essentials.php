<?php

    // function to redirect to a new page
    function redirect($url){
        echo"
            <script>
                window.location.href='$url';
            </script>
        ";
        exit;
    }

    // function to check whether user is logged in or not
    // and if he is not logged in then he will comeback to index.php, he cannot access to dashboard
    function adminLogin(){
        session_start();
        if(!(isset($_SESSION['adminLogin']) && $_SESSION['adminLogin']==true)){
            redirect('index.php');
            exit;
        }
    
        // session_regenerate_id(true); // it will secure the data of the last session but it also generates the new id to avoid hijacked(security reasons)

    }

    // function for alert message
    function alert($type, $msg){
        $bs_class = ($type == "success") ? "alert-success" : "alert-danger";
        echo <<<alert
            <div class="alert $bs_class alert-dismissible fade show custom-alert" role="alert">
                <strong class="me-3">$msg</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        alert;
    }

?>