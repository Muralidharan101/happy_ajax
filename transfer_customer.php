<?php
    include("../db/conn.php");
    $res = [];

    $lead_id = mysqli_real_escape_string($conn, $_POST["lead_id"]);
    $transfer_to_id = mysqli_real_escape_string($conn, $_POST["transfer_to"]);
    $transfer_reason = mysqli_real_escape_string($conn, $_POST["transfer_reason"]);
    $dateTime = date('Y-m-d H:i:s');

    $sql = mysqli_query($conn,"UPDATE enquiry_data SET `handling_by`='$transfer_to_id' WHERE `lead_id`='$lead_id' ");

    $sql2 = mysqli_query($conn,"INSERT INTO transfer_data (`lead_id`, `general_status`, `transfer_reason`, `created_by`, `status`, `dateTime`)
                                    VALUES ('$lead_id', 'transfer', '$transfer_reason', '$created_by', 'Active', '$dateTime') ");

    if($sql && mysqli_affected_rows($conn) > 0){
        $res['status'] = 'Success';
        $res['remarks'] = 'Lead transfered';
    } else {
        $res['status'] = 'Error';
        $res['remarks'] = 'Unable to transfer lead';
    }

    echo json_encode($res);
?>