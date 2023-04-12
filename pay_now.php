<?php

    require('admin/inc/db_config.php');
    require('admin/inc/essentials.php');
    
    date_default_timezone_set("Asia/Kolkata");

    session_start();

    if(!(isset($_SESSION['login']) && $_SESSION['login']==true)){
        redirect('rooms.php');
    }

    if(isset($_POST['pay_now']))
    {
        $frm_data = filtration($_POST);

        $query1 = "INSERT INTO `booking_order`(`user_id`, `room_id`, `check_in`, `check_out`) VALUES (?, ?, ?, ?)";

        insert($query1, [$_SESSION['uId'],$_SESSION['room']['id'],$frm_data['checkin'],$frm_data['checkout']],'isss');

        $booking_id = mysqli_insert_id($con);

        $query2 = "INSERT INTO `booking_details`(`booking_id`, `room_name`, `price`, `total_pay`, `user_name`, `phonenum`, `address`) VALUES (?,?,?,?,?,?,?)";

        insert($query2, [$booking_id,$_SESSION['room']['name'],$_SESSION['room']['price'],$_SESSION['room']['payment'],$frm_data['name'],$frm_data['phonenum'],$frm_data['address']],'issssss');

        redirect('pay_status.php');

    }

    


?>