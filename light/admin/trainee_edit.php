<?php
    include("auth.php");
    include('../../connect/db.php');
    $Log_Id = $_SESSION['SESS_ADMIN_ID'];
    
    // Get the primary key ID from the URL
    $id = $_GET['id'];
    
    // Fetch trainee data
    $result = $db->prepare("SELECT * FROM trainees WHERE id = :id");
    $result->bindParam(':id', $id);
    $result->execute();
    
    for($i=0; $row = $result->fetch(); $i++)
    {       
        $sLog_Id = $row["Log_Id"];
        $tname = $row["tname"];
        $blood_group = $row["blood_group"];
        $addr = $row["addr"];
        $stat = $row["stat"];
        $dist = $row["dist"];
        $trainer_name = $row["trainer_name"];
        $cntno1 = $row["cntno1"];
        $cntno2 = $row["cntno2"];
        $email = $row["email"];
        $jdate = $row["jdate"];
        $username = $row["username"];
        $password = $row["password"];
        $about = $row["about"];

         $sex = $row["sex"];
        $age = $row["age"];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("include/css.php"); ?>
</head>

<body class="page-header-fixed sidemenu-closed-hidelogo page-content-white page-md header-white white-sidebar-color logo-indigo">
    <div class="page-wrapper">
        <?php include("include/header.php"); ?>
        
        <div class="page-container">
            <?php include("include/leftmenu.php"); ?>
            
            <div class="page-content-wrapper">
                <div class="page-content">
                    <div class="page-bar">
                        <div class="page-title-breadcrumb">
                            <div class="pull-left">
                                <div class="page-title">Edit Trainee</div>
                            </div>
                            <ol class="breadcrumb page-breadcrumb pull-right">
                                <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.php">Home</a>&nbsp;<i class="fa fa-angle-right"></i></li>
                                <li class="active">Edit Trainee</li>
                            </ol>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="profile-content">
                                <div class="row">
                                    <div class="card">
                                        <div class="card-topline-aqua">
                                            <header></header>
                                        </div>
                                        <div class="white-box">
                                            <form class="edit-profile m-b30" method="post" action="action/trainee_update.php" enctype="multipart/form-data" autocomplete="off">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="ml-auto">
                                                            <h3>1. Trainee Details</h3>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <label>Log ID (System ID)</label>
                                                        <input type="hidden" name="id" value="<?php echo $id;?>">
                                                        <input type="text" class="form-control" name="Log_Id" value="<?php echo $sLog_Id;?>" readonly>
                                                    </div>                                                
                                                    
                                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                                        <label>Full Name</label>
                                                        <input type="text" name="tname" class="form-control" required value="<?php echo $tname;?>">
                                                    </div>
                                                     <div class="col-md-6 col-sm-12 col-xs-12">
                                                        <label>Gender</label>
                                                        <select name="sex" class="form-control" required>
                                                            <option><?php echo $sex?></option>
                                                            <option>Male</option>
                                                            <option>Female</option>
                                                            <option>Other</option>
                                                        </select>
                                                    </div>  
                                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                                        <label>Age</label>
                                                        <input type="number" name="age" class="form-control" value="<?php echo $age;?>" required>
                                                    </div>  
                                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                                        <label>Blood Group</label>
                                                        <input type="text" name="blood_group" class="form-control" required value="<?php echo $blood_group;?>">
                                                    </div>                                                    
                                                    
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <label>Address</label>
                                                        <textarea name="addr" class="form-control" rows="2"><?php echo $addr;?></textarea>  
                                                    </div>
                                                    
                                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                                        <label>State</label>
                                                        <select name="stat" class="form-control" required>
                                                            <option selected><?php echo $stat;?></option>
                                                            <option>Kerala</option>
                                                            <option>Tamilnadu</option>
                                                        </select>
                                                    </div>                                                                                                                                                                                                
                                                    
                                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                                        <label>District</label>
                                                        <select name="dist" class="form-control" required>
                                                            <option selected><?php echo $dist;?></option>
                                                            <option>Palakkad</option>
                                                            <option>Thrissur</option>
                                                        </select>
                                                    </div>
                                                   
                                                    <div class="seperator"></div>
                                                    
                                                    <div class="col-12 m-t20">
                                                        <div class="ml-auto m-b5">
                                                            <h3>2. Personal & Health Info</h3>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                                        <label>Assigned Trainer Name</label>
                                                        <input type="text" name="trainer_name" value="<?php echo $trainer_name;?>" class="form-control" required>
                                                    </div>                                                 
                                                    
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <label>Primary Contact</label>
                                                        <input type="text" name="cntno1" class="form-control" value="<?php echo $cntno1;?>" required pattern="[0-9]{10}">
                                                    </div>    
                                                    
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <label>Emergency Contact</label>
                                                        <input type="text" name="cntno2" class="form-control" value="<?php echo $cntno2;?>" pattern="[0-9]{10}">
                                                    </div>                                                                                                                                                                                        
                                                    
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <label>Email</label>
                                                        <input type="email" name="email" class="form-control" value="<?php echo $email;?>" required>
                                                    </div>                                    
                                                    
                                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                                        <label>Update Photo</label>
                                                        <input type="file" name="photo" class="form-control">
                                                    </div>
                                                    
                                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                                        <label>Join Date</label>
                                                        <input type="date" name="jdate" class="form-control" value="<?php echo $jdate;?>" required>
                                                    </div>                          
                                                    
                                                    <div class="col-12 m-t20">
                                                        <div class="ml-auto">
                                                            <h3 class="m-form__section">3. Account Credentials</h3>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="form-group col-6">
                                                        <label class="col-form-label">Username</label>
                                                        <input class="form-control" type="text" name="username" value="<?php echo $username;?>" required>
                                                    </div>
                                                    
                                                    <div class="form-group col-6">
                                                        <label class="col-form-label">Password</label>
                                                        <input class="form-control" type="password" name="password" value="<?php echo $password;?>" required>
                                                    </div>  
                                                    
                                                    <div class="col-12 m-t20">
                                                        <div class="ml-auto">
                                                            <h3 class="m-form__section">4. Medical/About</h3>
                                                        </div>
                                                    </div>                                  
                                                    
                                                    <div class="form-group col-12">
                                                        <label class="col-form-label">Notes (Injuries/Goals)</label>
                                                        <textarea class="form-control" name="about" required><?php echo $about;?></textarea>
                                                    </div>                                  
                                                    
                                                    <div class="col-12">
                                                        <button type="submit" class="btn pull-right btn-primary">Update Trainee</button>
                                                    </div>
                                                </div>
                                            </form>     
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <?php include("include/footer.php") ?>
        </div>
    </div>
    <?php include("include/js.php") ?>
</body>
</html>