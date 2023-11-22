<?php
  include("../db/conn.php");

  $result = [];
  $mobile = mysqli_real_escape_string($conn,$_POST['mobile']); 

  $sql = "SELECT lead_name, mobile_1, mobile_2, email, id as lead_id FROM lead_data WHERE mobile_1 = '$mobile' OR mobile_2 = '$mobile' ";
  $rec = mysqli_query($conn, $sql);
  if($data = mysqli_fetch_assoc($rec))
  {
    $result['status'] = 'Success';
    $result['remarks'] = 'Lead available';

    $result['data'] = $data;
  }
  else
  {
    $result['status'] = 'Not-Available';
    $result['remarks'] = 'No Lead Available';
  }

  echo json_encode($result);
?>
