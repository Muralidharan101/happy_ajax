<?php
    include("../db/conn.php");
    $res = [];

    $lead_id = mysqli_real_escape_string($conn, $_POST["lead_id"]);

    $sql = mysqli_query($conn, "SELECT ld.lead_name, ld.mobile_1, ld.mobile_2 , ld.email, ld.address, ld.created_by, CONCAT(DATE_FORMAT(ld.dateTime, '%D'), ' ', DATE_FORMAT(ld.dateTime, '%b %Y'))AS created_date,
                                ed.travellers, ed.child, CONCAT(DATE_FORMAT(ed.from_date, '%D'), ' ', DATE_FORMAT(ed.from_date, '%b %Y'))AS from_date, CONCAT(DATE_FORMAT(ed.to_date, '%D'), ' ', DATE_FORMAT(ed.to_date, '%b %Y'))AS to_date, ed.days, ed.budget, ed.enq_remarks, ed.quoted_value, ed.handling_by,
                                DATE_FORMAT(ed.from_date, '%m-%d-%y')AS actual_from_date , DATE_FORMAT(ed.to_date, '%m-%d-%y') actual_to_date,
                                (fd.id)AS follow_id ,fd.follow_up_status, CONCAT(DATE_FORMAT(fd.follow_up_date, '%D'), ' ', DATE_FORMAT(fd.follow_up_date, '%b %Y')) AS follow_up_date, fd.follow_up_reason,
                                (lde.id)AS des_id, lde.destination,
                                dd.city_name,
                                (emd.emp_name) created_by_name,
                                frd.follow_up,
                                (SELECT emp_name FROM employee_data WHERE employee_data.id = ed.handling_by) AS handling_by_name
                                FROM lead_data ld
                                JOIN enquiry_data ed ON ld.id=ed.lead_id
                                JOIN follow_up_data fd ON ld.id=fd.lead_id
                                JOIN follow_reason_data frd ON frd.id=fd.follow_up_status
                                JOIN employee_data emd ON ld.created_by=emd.id
                                JOIN lead_destination lde ON ld.id=lde.lead_id
                                JOIN destination_data dd ON lde.destination=dd.id
                                WHERE ld.status='Active'
                                AND ld.id = '$lead_id' ");

    $sql2 = mysqli_query($conn,"SELECT lds.destination, dd.city_name FROM lead_destination AS lds
                                JOIN destination_data AS dd ON lds.destination=dd.id 
                                WHERE lds.lead_id= '$lead_id' ");

    if ($sql && $sql2) {
        if ($row = mysqli_fetch_assoc($sql)) {
            $res['data'] = $row;
        }

        while ($row2 = mysqli_fetch_assoc($sql2)) {
            $res['data']['destination_id'][] = $row2;
        }

        $res['status'] = 'Success';
        $res['remarks'] = 'Data sent';
    } else {
        $res['status'] = 'Error';
        $res['remarks'] = 'No data available';
    }
    echo json_encode($res);
?>