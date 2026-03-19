<?php
    include("../auth.php");
    include('../../../connect/db.php');

    // Get the ID from the URL string
    $id = $_GET["id"];  
    
    // Use a prepared statement with a placeholder to prevent SQL injection
    $sql = "DELETE FROM trainees WHERE id = :id";
    $q1 = $db->prepare($sql);
    
    // Bind the parameter and execute
    $q1->bindParam(':id', $id);
    
    if($q1->execute()) {
        // Redirect back to the search page with a success flag if desired
        header("location:../trainee_search.php?status=deleted");
    } else {
        // Handle potential errors
        header("location:../trainee_search.php?status=error");
    }
?>