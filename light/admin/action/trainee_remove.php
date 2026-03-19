<?php
    include("../auth.php");
    include('../../../connect/db.php');

    // Get the ID from the URL string
    $id = $_GET["id"];  
    
    // Updated to target the 'members' table
    $sql = "DELETE FROM members WHERE id = :id";
    $q1 = $db->prepare($sql);
    
    // Bind the parameter and execute
    $q1->bindParam(':id', $id);
    
    if($q1->execute()) {
        // Redirect back to the member search page with a success flag
        header("location:../member_search.php?status=deleted");
    } else {
        // Redirect back with an error flag if the deletion fails
        header("location:../member_search.php?status=error");
    }
    exit();
?>