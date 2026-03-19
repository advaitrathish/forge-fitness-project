<?php
include("auth.php");
include('../../connect/db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 1. Get data from the Modal
    $member_id = $_POST['member_id'];
    $amount    = $_POST['amount'];
    $method    = $_POST['method']; // e.g., "GPay / UPI"
    $paid_date = date('Y-m-d');    // Today's date

    try {
        // 2. Insert into the fees table
        $sql = "INSERT INTO fees (member_id, amount, method, paid_date) 
                VALUES (:mid, :amt, :meth, :pdate)";
        
        $query = $db->prepare($sql);
        $result = $query->execute(array(
            ':mid'   => $member_id,
            ':amt'   => $amount,
            ':meth'  => $method,
            ':pdate' => $paid_date
        ));

        if ($result) {
            // 3. Optional: If you want to update the member's status to 'Active'
            $update_sql = "UPDATE members SET status = 'Active' WHERE id = :mid";
            $update_query = $db->prepare($update_sql);
            $update_query->execute(array(':mid' => $member_id));

            // 4. Redirect back to the payment desk with success
            header("location: payment.php?success=1");
            exit();
        } else {
            header("location: payment.php?error=fail");
            exit();
        }

    } catch (PDOException $e) {
        // Handle database errors
        die("Error: " . $e->getMessage());
    }
} else {
    // If someone tries to access this page directly
    header("location: payment.php");
    exit();
}
?>