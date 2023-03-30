<?php

    // frontend purpose data

    define('SITE_URL','http://127.0.0.1/hotel_booking_system/');
    define('ABOUT_IMG_PATH',SITE_URL.'image/about/');
    define('CAROUSEL_IMG_PATH',SITE_URL.'image/carousel/');
    define('FACILITIES_IMG_PATH',SITE_URL.'image/facilities/');
    define('ROOMS_IMG_PATH',SITE_URL.'image/rooms/');

    // backend uploads process needs this data

    define('UPLOAD_IMAGE_PATH',$_SERVER['DOCUMENT_ROOT'].'/hotel_booking_system/image/'); //$_SERVER['DOCUMENT_ROOT'] will return the absolute path of the server
    define('ABOUT_FOLDER','about/');
    define('CAROUSEL_FOLDER','carousel/');
    define('FACILITIES_FOLDER','facilities/');
    define('ROOMS_FOLDER','rooms/');

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


    function uploadImage($image,$folder)
    {
        $valid_mime = ['image/jpeg','image/jpg','image/png','image/webp'];
        $img_mime = $image['type']; 

        if(!in_array($img_mime,$valid_mime)){
            return 'inv_img'; // invalid image mime or format
        }
        else if(($image['size']/(1024*1024))>2){
            return 'inv_size'; // invalid image size that is size is greater than 2mb
        }
        else{
            $ext = pathinfo($image['name'],PATHINFO_EXTENSION);
            $rname = 'IMG_'.random_int(11111,99999).".$ext";

            $img_path = UPLOAD_IMAGE_PATH.$folder.$rname;
            if(move_uploaded_file($image['tmp_name'],$img_path)){
                return $rname; 
            }
            else{
                return 'upd_failed';
            }
        }

    }

    function deleteImage($image, $folder)
    {
        if(unlink(UPLOAD_IMAGE_PATH.$folder.$image)){
            return true;
        }
        else{
            return false;
        }
    }

    function uploadSVGImage($image,$folder)
    {
        $valid_mime = ['image/svg+xml'];
        $img_mime = $image['type']; 

        if(!in_array($img_mime,$valid_mime)){
            return 'inv_img'; // invalid image mime or format
        }
        else if(($image['size']/(1024*1024))>2){
            return 'inv_size'; // invalid image size that is size is greater than 2mb
        }
        else{
            $ext = pathinfo($image['name'],PATHINFO_EXTENSION);
            $rname = 'IMG_'.random_int(11111,99999).".$ext";

            $img_path = UPLOAD_IMAGE_PATH.$folder.$rname;
            if(move_uploaded_file($image['tmp_name'],$img_path)){
                return $rname; 
            }
            else{
                return 'upd_failed';
            }
        }

    }
?>