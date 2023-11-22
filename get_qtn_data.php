<?php
  include("../db/conn.php");

  $result = [];
  $lead_id = mysqli_real_escape_string($conn,$_POST['lead_id']); 

  $count = 0;
  $sql = "SELECT qtn_value, qtn_update_remarks, quotation_status, emp_name, qtn_file_name, 
              FROM quotation_data
              JOIN employee_data
                ON quotation_data.created_by = employee_data.id
              WHERE quotation_data.lead_id = '$lead_id' AND quotation_data.status = 'Active' ";
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
