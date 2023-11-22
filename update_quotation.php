<?php
    include("../db/conn.php");
    $res = [];

    $lead_id = mysqli_real_escape_string($conn, $_POST["lead_id"]);
    $qtn_value = mysqli_real_escape_string($conn, $_POST["qtn_value"]);
    $qtn_update_remarks = mysqli_real_escape_string($conn, $_POST["qtn_update_remarks"]);
    $dateTime = date("Y-m-d H:i:s");

    $file_name = $_FILES['qtn_file']['name'];
    $file_basename = basename($file_name);
    $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);

    $sql = mysqli_query($conn,"INSERT INTO quotation_data (`lead_id`, `qtn_value`, `qtn_update_remarks`, `quotation_status`,`created_by`, `status`, `dateTime`) values ('$lead_id', '$qtn_value', '$qtn_update_remarks', 'Approved','$created_by', 'Active', '$dateTime') ");

    if($sql) {
        $inserted_id = mysqli_insert_id($conn);
        $path = '../../quotations/'.$inserted_id.'/';
        
        if(!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $new_filename = $path.$file_basename;

        if(move_uploaded_file($_FILES['qtn_file']['tmp_name'], $new_filename)) {
            $sql2 = "UPDATE `quotation_data` SET `qtn_file_name`='$file_basename' WHERE id='$inserted_id' ";

            if(mysqli_query($conn, $sql2)) {

                $sql3 = "UPDATE `enquiry_data` SET `quoted_value`='$qtn_value' WHERE `lead_id`='$lead_id' AND id='$inserted_id' ";

                if(mysqli_query($conn, $sql3)) {
                    $res['status'] = 'Success';
                    $res['remarks'] = 'Quotation Created';
                } else {
                    $res['status'] = 'Error4';
                    $res['remarks'] = 'Unable to update enquiry_Data';
                }
            } else {
                $res['status'] = 'Error3';
                $res['remarks'] = 'Unable to create quotation';
            }
        } else {
            $res['status'] = 'Error2';
            $res['remarks'] = 'Unable to move uploaded file';
        }
    } else {
        $res['status'] = 'Error1';
        $res['remarks'] = 'Error in sql query';
    }

    echo json_encode($res);
?>