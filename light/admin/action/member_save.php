<?php
    include("../../../connect/db.php");
    
    // Collecting Member Information
    $Log_Id = $_POST["Log_Id"];
    $tname = $_POST["tname"];      
    $blood_group = $_POST["blood_group"]; 
    $addr = $_POST["addr"];
    $stat = $_POST["stat"];
    $dist = $_POST["dist"];
    
    // Using membership_plan as per our updated form
    $membership_plan = $_POST["membership_plan"]; 
    
    
    $sex = $_POST["sex"];
    $age = $_POST["age"];

    $cntno1 = $_POST["cntno1"];
    $cntno2 = $_POST["cntno2"];
    $email = $_POST["email"];
    $jdate = $_POST["jdate"];
    $username = $_POST["username"];
    $password = $_POST["password"]; // Consider using password_hash($password, PASSWORD_DEFAULT) for security
    $about = $_POST["about"];

    $date = date("Y-m-d");
    $utype = "Member"; 
    
    // Photo Upload Logic
    if(isset($_FILES['photo']['tmp_name']) && $_FILES['photo']['tmp_name'] != "") {
        $photo = $_FILES["photo"]["name"];
        $target_dir = "../../photo/";
        
        // Ensure directory exists
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        move_uploaded_file($_FILES["photo"]["tmp_name"], $target_dir . $photo);
    } else {
        $photo = ""; 
    }
    
    // SQL Query - Updated to 'members' table
    $sql = "INSERT INTO members (
                Log_Id, tname, blood_group, addr, stat, dist, membership_plan, 
                cntno1, cntno2, email, photo, jdate, username, password, 
                date, about, utype, age, sex
            ) VALUES (
                ?, ?, ?, ?, ?, ?, ?, 
                ?, ?, ?, ?, ?, ?, ?, 
                ?, ?, ?, ?, ?
            )";

    // Using Prepared Statements for better security against SQL Injection
    $q1 = $db->prepare($sql);
    $q1->execute([
        $Log_Id, $tname, $blood_group, $addr, $stat, $dist, $membership_plan,
        $cntno1, $cntno2, $email, $photo, $jdate, $username, $password,
        $date, $about, $utype, $age, $sex
    ]); 

    // Redirect to member search or list page
    header("location:../member_search.php");
?>