<?php
    include("../db/conn.php");
    $res = [];

    $sql = mysqli_query($conn,"INSERT INTO follow_up_data (`lead_id`, `follow_up_status`, `follow_up_date`, `follow_up_reason`,`created_by`, `status`, `dateTime`) 
    VALUES ('$inserted_lead_id', '$follow_up_status', '$follow_up_date', '$follow_remarks', '$created_by', 'Active', '$dateTime' ) ");   

    if($sql){
        $res['status'] = 'Success';
        $res['remarks'] = 'Follow up created';
    }

    echo json_encode($res);
?>