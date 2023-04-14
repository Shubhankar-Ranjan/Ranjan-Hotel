<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require('include/links.php') ?>
    <title><?php echo $settings_r['site_title'] ?> - BOOKINGS</title>
</head>
<body class="bg-light">
    
    <?php 
        require('include/header.php'); 
        if(!(isset($_SESSION['login']) && $_SESSION['login']==true)){
            redirect('index.php');
        }
    ?>
 
        

   <div class="container">
    <div class="row">

        <div class="col-12 my-5 px-4">
            <h2 class="fw-bold">BOOKINGS</h2>
            <div style="font-size: 14px;">
                <a href="index.php" class="text-secondary text-decoration-none">HOME</a>
                <span class="text-secondary"> / </span>
                <a href="#" class="text-secondary text-decoration-none">BOOKINGS</a>
            </div>
        </div>

        <?php 
            $query = "SELECT bo.*, bd.* FROM `booking_order` bo INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id WHERE (bo.user_id = ?) ORDER BY bo.booking_id DESC";

            $result = select($query,[$_SESSION['uId']],'i');

            while($data = mysqli_fetch_assoc($result))
            {
                $date = date("d-m-Y",strtotime($data['datentime']));
                $checkin = date("d-m-Y",strtotime($data['check_in']));
                $checkout= date("d-m-Y",strtotime($data['check_out']));
                
                if($data['arrival']==1)
                {
                    $btn = "<a href='generate_pdf.php?gen_pdf&id=$data[booking_id]' class='btn btn-dark btn-sm shadow-none mt-2'>
                             Download PDF
                            </a>
                            <button type='button' class='btn btn-dark btn-sm shadow-none mt-2'>
                                Rate & Review
                            </button>
                    ";
                }
                else{
                    $btn = "<button type='button' onclick='cancel_booking($data[booking_id])' class='btn btn-danger btn-sm shadow-none mt-2'>
                                Cancel
                            </button>
                    ";
                }

                echo <<<bookings
                    <div class="col-md-4 px-4 mb-4">
                        <div class="bg-white p-3 rounded shadow-sm">
                            <h5 class="fw-bold">$data[room_name]</h5>
                            <p>₹$data[price] per night</p>
                            <p>
                                <b>Check in:</b> $checkin
                                <br>
                                <b>Check out:</b> $checkout
                            </p>
                            <p>
                                <b>Amount:</b> ₹$data[total_pay]
                                <br>
                                <b>Date:</b> $date
                            </p>
                            $btn
                        </div>
                    </div>
                bookings;
            }


        ?>


        

    </div>
   </div>

   <?php
        if(isset($_GET['cancel_status'])){
            alert('success','Booking Cancelled!');
        }
   ?>


    <?php require("include/footer.php"); ?>
    <script>
        function cancel_booking(id)
        {
            if(confirm('Are you sure you want to cancel this booking?'))
            {
                let xhr = new XMLHttpRequest();
                xhr.open("POST","ajax/cancel_bookings_crud.php",true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                xhr.onload = function(){
                    if(this.responseText==1){
                        window.location.href = "bookings.php?cancel_status=true";
                    }
                    else{
                        alert('error','Cancellation Failed!')
                    }
                }
                xhr.send('cancel_booking&id='+id);
            }
        }
    </script>
    

</body>
</html>  