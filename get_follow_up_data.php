<?php
  include("../db/conn.php");

  $result = [];
  $lead_id = mysqli_real_escape_string($conn,$_POST['lead_id']); 

  $count = 0;
  $sql = "SELECT DATE_FORMAT(follow_up_date, '%d-%m-%Y') as follow_up_date, 
                  DATE_FORMAT(follow_up_data.dateTime, '%d-%m-%Y') as dateTime, emp_name, follow_up_reason, 
                  DATEDIFF(follow_up_date, follow_up_data.dateTime) as date_diff
              FROM follow_up_data
              JOIN employee_data
                ON follow_up_data.created_by = employee_data.id
              left JOIN follow_reason_data
                ON follow_reason_data.id = follow_up_data.follow_up_status
              WHERE follow_up_data.lead_id = '$lead_id' AND follow_up_data.status = 'Active' ";
  $rec = mysqli_query($conn, $sql);
  while($data = mysqli_fetch_assoc($rec))
  {
    $result['status'] = 'Success';
    $result['remarks'] = 'Lead available';

    $result['data'][] = $data;
    $count++;
  }

  if($count == 0)
  {
    $result['status'] = 'Not-Available';
    $result['remarks'] = 'No Lead Available';
  }

  echo json_encode($result);
?>
