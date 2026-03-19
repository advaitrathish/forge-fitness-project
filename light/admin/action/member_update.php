<?php
    include("../auth.php");
    include('../../../connect/db.php');
    
    // Primary key from the hidden input field
    $id = $_POST['id'];
    
    // Member Information
    $tname = $_POST["tname"];
    $blood_group = $_POST["blood_group"];
    $addr = $_POST["addr"];
    $stat = $_POST["stat"];
    $dist = $_POST["dist"];
    $membership_plan = $_POST["membership_plan"]; // Updated from trainer_name
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
        $sql = "UPDATE members SET 
                tname=:tname, blood_group=:blood_group, addr=:addr, stat=:stat, 
                dist=:dist, membership_plan=:membership_plan, cntno1=:cntno1, cntno2=:cntno2, 
                email=:email, jdate=:jdate, username=:username, password=:password, about=:about, sex=:sex, age=:age
                WHERE id=:id";
        
        $q1 = $db->prepare($sql);
    }
    else
    {
        // Upload new photo and update database
        // Ensure the path matches your project structure
        move_uploaded_file($_FILES["photo"]["tmp_name"], "../../photo/" . $photo);
        
        $sql = "UPDATE members SET 
                tname=:tname, blood_group=:blood_group, addr=:addr, stat=:stat, 
                dist=:dist, membership_plan=:membership_plan, cntno1=:cntno1, cntno2=:cntno2, 
                email=:email, photo=:photo, jdate=:jdate, username=:username, 
                password=:password, about=:about , sex=:sex, age=:age
                WHERE id=:id";
        
        $q1 = $db->prepare($sql);
        $q1->bindParam(':photo', $photo);
    }

    // Bind parameters to prevent SQL injection
    $q1->bindParam(':tname', $tname);
    $q1->bindParam(':blood_group', $blood_group);
    $q1->bindParam(':addr', $addr);
    $q1->bindParam(':stat', $stat);
    $q1->bindParam(':dist', $dist);
    $q1->bindParam(':membership_plan', $membership_plan);
    $q1->bindParam(':cntno1', $cntno1);
    $q1->bindParam(':cntno2', $cntno2);
    $q1->bindParam(':email', $email);
    $q1->bindParam(':jdate', $jdate);
    $q1->bindParam(':username', $username);
    $q1->bindParam(':password', $password);
    $q1->bindParam(':about', $about);
    $q1->bindParam(':sex', $sex);
    $q1->bindParam(':age', $age);
    $q1->bindParam(':id', $id);

    $result = $q1->execute(); 

    if($result) {
        // Redirect back to the member search/list page
        header("location:../member_search.php?status=success");
    } else {
        echo "Error updating record.";
    }
?>