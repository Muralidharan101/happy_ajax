<?php
    include("../db/conn.php");
    $res = [];

    $lead_id = mysqli_real_escape_string($conn, $_POST["lead_id"]);
    $customer_name = mysqli_real_escape_string($conn, $_POST["customer_name"]);
    $mobile = mysqli_real_escape_string($conn, $_POST["mobile"]);
    $address = mysqli_real_escape_string($conn, $_POST["customer_address"]);
    $destination = mysqli_real_escape_string($conn, $_POST["destination"]);
    $traveller_count = mysqli_real_escape_string($conn, $_POST["traveller_count"]);

    $from_date = mysqli_real_escape_string($conn, $_POST["travel_start_date"]);
    $to_date = mysqli_real_escape_string($conn, $_POST["travel_end_date"]);

    $travelling_days = mysqli_real_escape_string($conn, $_POST["travelling_days"]);
    $checklist = mysqli_real_escape_string($conn, $_POST["checklist"]);
    $budget = mysqli_real_escape_string($conn, $_POST["budget"]);
    $remarks = mysqli_real_escape_string($conn, $_POST["remarks"]);
    $follow_up_date = mysqli_real_escape_string($conn, $_POST["follow_up_date"]);
    $follow_up_status = mysqli_real_escape_string($conn, $_POST["follow_up_status"]);
    $follow_remarks = mysqli_real_escape_string($conn, $_POST["follow_remarks"]);
    $dateTime = date('Y-m-d H:i:s');

    $alt_mobile = mysqli_real_escape_string($conn, $_POST["alt_mobile"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $children_age = mysqli_real_escape_string($conn, $_POST["children_age"]);
    $created_by = 1;

    if($lead_id == 0) {
        
        $sql = mysqli_query($conn,"INSERT INTO lead_data (`lead_name`, `mobile_1`, `mobile_2`, `address`, `email`, `created_by`, `status`, `dateTime`) 
                VALUES ('$customer_name', '$mobile', '$alt_mobile', '$address', '$email', '$created_by', 'Active', '$dateTime' ) ");
        
        if($sql){

            $inserted_lead_id = mysqli_insert_id($conn);
            $sql2 = mysqli_query($conn,"INSERT INTO enquiry_data (`lead_id`, `travellers`, `child`, `from_date`, `to_date`, `days`,`created_by`, `status`, `dateTime`) 
                                    VALUES ('$inserted_lead_id', '$traveller_count', '$children_age', '$from_date', '$to_date', '$travelling_days', '$created_by','Active', '$dateTime')");

            $sql3 = mysqli_query($conn,"INSERT INTO lead_destination (`lead_id`, `destination`, `created_by`, `status`, `dateTime`) VALUES ('$inserted_lead_id', '$destination', '$created_by', 'Active', '$dateTime')");

            $sql4 = mysqli_query($conn,"INSERT INTO follow_up_data (`lead_id`, `follow_up_status`, `follow_up_date`, `follow_up_reason`,`created_by`, `status`, `dateTime`) 
                                        VALUES ('$inserted_lead_id', '$follow_up_status', '$follow_up_date', '$follow_remarks', '$created_by', 'Active', '$dateTime' ) ");   
            
            if($sql2 && $sql3 && $sql4) {
                $res['status'] = 'Success';
                $res['remarks'] = 'Lead Created';
            } else {
                $res['status'] = 'Error3';
                $res['remarks'] = 'Unable to create lead';
            }
        } else {
            $res['status'] = 'Error2';
            $res['remarks'] = 'Error in query sql1';
        }
    } else if ($lead_id !== 0) {

        $update_query = mysqli_query($conn, "UPDATE lead_data SET `mobile_1`='$mobile', `mobile_2`='$alt_mobile', `email`='$email', `address`='$address' WHERE `id`='$lead_id' ");

        if(mysqli_affected_rows($conn) > 0) {

            $select_lead_id = mysqli_query($conn,"SELECT id FROM lead_data WHERE id='$lead_id'");
            $select_result = mysqli_fetch_assoc($select_lead_id);
            $selected_id = $select_result["id"];
            
            $update_query2 = mysqli_query($conn,"UPDATE enquiry_data SET `travellers`='$traveller_count', `child`='$children_age', `from_date`='$from_date', `to_date`='$to_date', `days`='$travelling_days' WHERE lead_id='$lead_id' ");
            
            $update_query3 = mysqli_query($conn,"UPDATE lead_destination SET `destination`='$destination' WHERE `lead_id`='$lead_id' ");

            $update_query4 = mysqli_query($conn,"UPDATE follow_up_data SET `follow_up_status`='$follow_up_status' , `follow_up_date`='$follow_up_date', `follow_up_reason`='$follow_remarks' WHERE `lead_id`='$lead_id'");
            
            if($update_query2 && $update_query3 && $update_query4) {
                $res['status'] = 'Success';
                $res['remarks'] = 'Lead Updated';
            } else {
                $res['status'] = 'Error5';
                $res['remarks'] = 'Error in update_query2 or update_query3 or update_query4';
            }
        } else{
            $res['status'] = 'Error4';
            $res['remarks'] = 'Error in update_query';
        }

    } else {
        $res['status'] = 'Error1';
        $res['remarks'] = 'Lead Id no received';
    }


    echo json_encode($res);
?>