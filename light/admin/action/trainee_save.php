<?php
    include("../../../connect/db.php");
    
    // Collecting Trainee Information
    $Log_Id = $_POST["Log_Id"];
    $tname = $_POST["tname"];      // Changed from sname (Station Name)
    $blood_group = $_POST["blood_group"]; // Changed from locatin
    $addr = $_POST["addr"];
    $stat = $_POST["stat"];
    
    $sex = $_POST["sex"];
    $age = $_POST["age"];

    $dist = $_POST["dist"];
    $trainer_name = $_POST["trainer_name"]; // Changed from scname (SI Name)
    $cntno1 = $_POST["cntno1"];
    $cntno2 = $_POST["cntno2"];
    $email = $_POST["email"];
    $jdate = $_POST["jdate"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $about = $_POST["about"];

    $date = date("Y-m-d");
    $utype = "Trainee"; // Changed from Police
    
    // Photo Upload Logic
    if(isset($_FILES['photo']['tmp_name']) && $_FILES['photo']['tmp_name'] != "") {
        $image_name = addslashes($_FILES['photo']['name']);
        move_uploaded_file($_FILES["photo"]["tmp_name"], "../../photo/" . $_FILES["photo"]["name"]);
        $photo = $_FILES["photo"]["name"];
    } else {
        $photo = ""; 
    }
    
    // SQL Query - Updated table name to 'trainees' and column names to match
    // Ensure your database table 'trainees' has these column names
    $sql = "INSERT INTO trainees (
                Log_Id, tname, blood_group, addr, stat, dist, trainer_name, 
                cntno1, cntno2, email, photo, jdate, username, password, 
                date, about, utype, age, sex
            ) VALUES (
                '$Log_Id', '$tname', '$blood_group', '$addr', '$stat', '$dist', '$trainer_name', 
                '$cntno1', '$cntno2', '$email', '$photo', '$jdate', '$username', '$password', 
                '$date', '$about', '$utype', '$age', '$sex'
            )";

    $q1 = $db->prepare($sql);
    $q1->execute(); 

    // Redirect to trainee search or list page
    header("location:../trainee_search.php");
?>