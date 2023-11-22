<?php
    include("../db/conn.php");
    $res = [];

    $lead_id = mysqli_real_escape_string($conn, $_POST["lead_id"]);
    $mobile = mysqli_real_escape_string($conn, $_POST["mobile"]);
    $alt_mobile = mysqli_real_escape_string($conn, $_POST["alt_mobile"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $address = mysqli_real_escape_string($conn, $_POST["address"]);

    $sql = mysqli_query($conn, "UPDATE lead_data SET `mobile1`='$mobile', `mobile_2`='$alt_mobile', `email`='$email', `address`='$address' WHERE `id`='$lead_id' ");

    if($sql) {
        $res['status'] = 'Success';
        $res['remarks'] = 'Lead Data Updated';
    } else {
        $res['status'] = 'Error';
        $res['remarks'] = 'Unable to update lead';
    }

    echo json_encode($res);
?>