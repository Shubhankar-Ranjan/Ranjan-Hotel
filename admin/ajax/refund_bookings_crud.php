<?php
    require('../inc/db_config.php');
    require('../inc/essentials.php');
    adminLogin();

    if(isset($_POST['get_bookings']))
    { 
        $frm_data = filtration($_POST);

        $query = "SELECT bo.*, bd.* FROM `booking_order` bo INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id WHERE (bd.phonenum LIKE ? OR bd.user_name LIKE ?) AND bo.refund=0 ORDER BY bo.booking_id ASC";

        $res = select($query,["%$frm_data[search]%","%$frm_data[search]%"],'ss');

        $i=1;
        $table_data = "";

        if(mysqli_num_rows($res)==0){
            echo"<b>No Data Found!</b>";
            exit;
        }

        while($data = mysqli_fetch_assoc($res))
        {
            $date = date("d-m-Y",strtotime($data['datentime']));
            $checkin = date("d-m-Y",strtotime($data['check_in']));
            $checkout= date("d-m-Y",strtotime($data['check_out']));

            $table_data .="
                <tr>
                    <td>$i</td>
                    <td>
                        <b>Name:</b> $data[user_name]
                        <br>
                        <b>Phone:</b> $data[phonenum]
                    </td>
                    <td>
                        <b>Room:</b> $data[room_name]
                        <br>
                        <b>Check in:</b> $checkin
                        <br>
                        <b>Check out:</b> $checkout
                        <br>
                        <b>Date:</b> $date
                    </td>
                    <td>
                        <b>₹$data[total_pay]</b>
                    </td>
                    <td>
                        <button type='button' onclick='refund_booking($data[booking_id])' class='btn btn-success btn-sm fw-bold shadow-none mt-3'>
                            <i class='bi bi-cash-stack me-1'></i>Refund
                        </button>
                    </td>
                </tr>
            ";
            
            $i++;
        }
        echo $table_data;
    }

    if(isset($_POST['assign_room']))
    {
        $frm_data = filtration($_POST);

        $query = "UPDATE`booking_order` bo INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id SET bo.arrival = ?, bd.room_no = ? WHERE bo.booking_id = ?";

        $values = [1,$frm_data['room_no'],$frm_data['booking_id']];

        $res = update($query,$values,'isi');  // it will update 2 rows so it will return 2

        echo ($res==2) ? 1 : 0;
    }


    if(isset($_POST['refund_booking']))
    {
        $frm_data = filtration($_POST);

        $query = "UPDATE `booking_order` SET `refund`=? WHERE `booking_id`=?";
        $values = [1,$frm_data['booking_id']];
        $res = update($query,$values,'ii');

        echo $res;
    }

?>