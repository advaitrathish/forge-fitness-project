<?php
    include("../auth.php");
    include('../../../connect/db.php');

    $staff_id = $_POST['staff_id'];
    $salary_month = $_POST['salary_month'];
    $amount = $_POST['amount'];
    $paid_date = $_POST['paid_date'];
    $remarks = $_POST['remarks'];

    $sql = "INSERT INTO salary (staff_id, salary_month, amount, paid_date, remarks) 
            VALUES (:staff_id, :salary_month, :amount, :paid_date, :remarks)";
    
    $q = $db->prepare($sql);
    $q->execute(array(
        ':staff_id' => $staff_id,
        ':salary_month' => $salary_month,
        ':amount' => $amount,
        ':paid_date' => $paid_date,
        ':remarks' => $remarks
    ));

    header("location:../salary_view.php?status=success");
?>