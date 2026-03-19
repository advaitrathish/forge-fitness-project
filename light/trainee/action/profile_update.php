<?php
    include("../auth.php");
    include('../../../connect/db.php');
    
    // Primary key from the hidden input field
    $Log_Id = $_POST['Log_Id'];
    
    // Trainee Information
    $tname = $_POST["tname"];
    $blood_group = $_POST["blood_group"];
    $addr = $_POST["addr"];
    $stat = $_POST["stat"];
    $dist = $_POST["dist"];
    $trainer_name = $_POST["trainer_name"];
    $cntno1 = $_POST["cntno1"];
    $cntno2 = $_POST["cntno2"];
    $email = $_POST["email"];
    $jdate = $_POST["jdate"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $about = $_POST["about"];
    
     $sex = $_POST["sex"];
    $age = $_POST["age"];

    // File upload handling
    $photo = $_FILES["photo"]["name"];
    
    if($photo == "")
    {
        // Update without changing the photo
        $sql = "UPDATE trainees SET 
                tname=:tname, blood_group=:blood_group, addr=:addr, stat=:stat, 
                dist=:dist, trainer_name=:trainer_name, cntno1=:cntno1, cntno2=:cntno2, 
                email=:email, jdate=:jdate, username=:username, password=:password, about=:about, sex=:sex, age=:age
                WHERE Log_Id=:Log_Id";
        
        $q1 = $db->prepare($sql);
    }
    else
    {
        // Upload new photo and update database
        move_uploaded_file($_FILES["photo"]["tmp_name"], "../../photo/" . $_FILES["photo"]["name"]);
        
        $sql = "UPDATE trainees SET 
                tname=:tname, blood_group=:blood_group, addr=:addr, stat=:stat, 
                dist=:dist, trainer_name=:trainer_name, cntno1=:cntno1, cntno2=:cntno2, 
                email=:email, photo=:photo, jdate=:jdate, username=:username, 
                password=:password, about=:about, sex=:sex, age=:age
                WHERE Log_Id=:Log_Id";
        
        $q1 = $db->prepare($sql);
        $q1->bindParam(':photo', $photo);
    }

    // Bind parameters to prevent SQL injection
    $q1->bindParam(':tname', $tname);
    $q1->bindParam(':blood_group', $blood_group);
    $q1->bindParam(':addr', $addr);
    $q1->bindParam(':stat', $stat);
    $q1->bindParam(':dist', $dist);
    $q1->bindParam(':trainer_name', $trainer_name);
    $q1->bindParam(':cntno1', $cntno1);
    $q1->bindParam(':cntno2', $cntno2);
    $q1->bindParam(':email', $email);
    $q1->bindParam(':jdate', $jdate);
    $q1->bindParam(':username', $username);
    $q1->bindParam(':password', $password);
    $q1->bindParam(':about', $about);
    $q1->bindParam(':sex', $sex);
    $q1->bindParam(':age', $age);
    $q1->bindParam(':Log_Id', $Log_Id);

    $q1->execute(); 

    // Redirect back to the trainee search/list page
    header("location:../user_profile.php");
?>