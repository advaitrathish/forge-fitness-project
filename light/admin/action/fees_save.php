<?php
    include("../auth.php");
    include('../../../connect/db.php');

    // Capture the data from the POST request
    $member_id = $_POST['member_id'];
    $amount    = $_POST['amount'];
    $paid_date = $_POST['paid_date'];
    $method    = $_POST['method'];
    $remarks   = $_POST['remarks'];

    // SQL query to insert fee record
    $sql = "INSERT INTO fees (member_id, amount, paid_date, method, remarks) 
            VALUES (:mid, :amt, :pdate, :meth, :rem)";
    
    $q = $db->prepare($sql);
    
    // Bind values and execute
    $result = $q->execute(array(
        ':mid'   => $member_id,
        ':amt'   => $amount,
        ':pdate' => $paid_date,
        ':meth'  => $method,
        ':rem'   => $remarks
    ));

    if($result) {
        // Success: Redirect back to the fees view with a success parameter
        header("location:../fees_view.php?status=success");
    } else {
        // Failure: Show error
        echo "Error: Could not save the payment record. Please check your database connection.";
    }
    exit();
?>