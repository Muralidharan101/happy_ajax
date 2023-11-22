<?php
    include("../db/conn.php");
    $res = [];

    $lead_id = mysqli_real_escape_string($conn, $_POST["lead_id"]);
    $modal_traveller_count = mysqli_real_escape_string($conn, $_POST["modal_traveller_count"]);
    $modal_customer_alt_mobile = mysqli_real_escape_string($conn, $_POST["modal_customer_alt_mobile"]);
    $modal_customer_email = mysqli_real_escape_string($conn, $_POST["modal_customer_email"]);
    $modal_customer_address = mysqli_real_escape_string($conn, $_POST["modal_customer_address"]);
    $modal_budget = mysqli_real_escape_string($conn, $_POST["modal_budget"]);
    $modal_enquiry_remarks = mysqli_real_escape_string($conn, $_POST["modal_enquiry_remarks"]);
    
    $sql = mysqli_query($conn,"UPDATE lead_data SET `mobile_2`='$modal_customer_alt_mobile', `email`='$modal_customer_email', `address`='$modal_customer_address' WHERE `id`='$lead_id' ");
    $sql2 = mysqli_query($conn,"UPDATE enquiry_data SET `travellers`='$modal_traveller_count', `budget`='$modal_budget', `enq_remarks`='$modal_enquiry_remarks' WHERE `id`='$lead_id' ");

    if($sql && $sql2) {
        $res['status'] = 'Success';
        $res['remarks'] = 'Updated requirments';
    } else {
        $res['status'] = 'Error';
        $res['remarks'] = 'Error in requirments';
    }

    echo json_encode($res);
?>