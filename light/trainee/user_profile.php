<?php
    include("auth.php");
    include('../../connect/db.php');
    $Log_Id = $_SESSION['SESS_TRAINEE_ID'];
    
    
    // Fetch trainee data
    $result = $db->prepare("SELECT * FROM trainees WHERE Log_Id = '$Log_Id'");
    $result->execute();
    
    for($i=0; $row = $result->fetch(); $i++)
    {       
        $sLog_Id = $row["Log_Id"];
        $tname = $row["tname"];
        
        $age = $row["age"];
        $sex = $row["sex"];

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
        $photo = $row["photo"]; // Added to ensure profile pic works
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        include("include/css.php");
    ?>
</head>
<body
    class="page-header-fixed sidemenu-closed-hidelogo page-content-white page-md header-white white-sidebar-color logo-indigo">
    <div class="page-wrapper">
        <?php
        include("include/header.php");
        ?>
        <div class="page-container">
            <?php
            include("include/leftmenu.php");
            ?>
            <div class="page-content-wrapper">
                <div class="page-content">
                    <div class="page-bar">
                        <div class="page-title-breadcrumb">
                            <div class=" pull-left">
                                <div class="page-title">Trainee Profile</div>
                            </div>
                            <ol class="breadcrumb page-breadcrumb pull-right">
                                <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item"
                                        href="index.php">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
                                </li>
                                <li><a class="parent-item" href="">Profile</a>&nbsp;<i class="fa fa-angle-right"></i>
                                </li>
                                <li class="active">Update</li>
                            </ol>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="profile-sidebar">
                                <div class="card">
                                    <div class="card-body no-padding height-9">
                                        <div class="row">
                                            <div class="profile-userpic">
                                                <img src="../photo/<?php echo $photo;?>" class="img-responsive" alt="">
                                            </div>
                                        </div>
                                        <div class="profile-usertitle">
                                            <div class="profile-usertitle-name"> <?php echo $tname;?></div>
                                            <div class="profile-usertitle-job"> Blood Group <?php echo $blood_group;?> </div>
                                        </div>
                                         <div class="profile-usertitle">
                                            <div class="profile-usertitle-name"> Age <?php echo $age;?></div>
                                            <div class="profile-usertitle-job"> Gender <?php echo $sex;?> </div>
                                        </div>
                                        <ul class="list-group list-group-unbordered">
                                            <li class="list-group-item">
                                                <b>State</b> <a class="pull-right"> <?php echo $stat;?></a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>District</b> <a class="pull-right"> <?php echo $dist;?></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-head">
                                        <header>About Me</header>
                                    </div>
                                    <div class="card-body no-padding height-9">
                                        <div class="profile-desc">
                                        <?php echo $about;?>
                                        </div>
                                        <ul class="list-group list-group-unbordered">
                                            <li class="list-group-item">
                                                <b>Trainer </b>
                                                <div class="profile-desc-item pull-right"><?php echo $trainer_name;?></div>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Contact </b>
                                                <div class="profile-desc-item pull-right"><?php echo $cntno1;?></div>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Contact </b>
                                                <div class="profile-desc-item pull-right"><?php echo $cntno2;?></div>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Email</b>
                                                <div class="profile-desc-item pull-right"><?php echo $email;?></div>
                                            </li>
                                        </ul>                                      
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-head">
                                        <header>Address</header>
                                    </div>
                                    <div class="card-body no-padding height-9">
                                        <div class="row text-center m-t-10">
                                            <div class="col-md-12">
                                            <?php echo $addr;?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="profile-content">
                                <div class="row">
                                    <div class="card">
                                        <div class="card-topline-aqua">
                                            <header></header>
                                        </div>
                                        <div class="white-box">
                                            <div class="tab-content">
                                                
                                                <div class="tab-pane active" id="tab2">
                                                    <div class="container-fluid">
                                                        <div class="row">
                                                            
                                                            <div class="full-width p-rl-20">
                                                                <div class="panel">
                                                                <form class="edit-profile m-b30" method="post" action="action/profile_update.php" enctype="multipart/form-data">
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <div class="ml-auto">
                                                                                <h3>1. Trainee Details</h3>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                                                                <label>Trainee ID</label>
                                                                            <input type="text" class="form-control" name="Log_Id" value="<?php echo $Log_Id;?>" readonly>
                                                                            </div>                                                                               
                                                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                                                            <label>Full Name</label>
                                                                            <input type="text"  name="tname"   class="form-control" required value="<?php echo $tname;?>">
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
                                                                            <input type="text"  name="blood_group"   class="form-control" value="<?php echo $blood_group;?>">
                                                                            </div>                                                   
                                                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                                            <label>Address</label>
                                                                                <textarea name="addr" class="form-control" rows="2"><?php echo $addr;?></textarea>  
                                                                            </div>
                                                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                                                            <label>State</label>
                                                                            <select name="stat" class="form-control" required>
                                                                                    <option><?php echo $stat;?></option>
                                                                                    <option>Kerala</option>
                                                                                    <option>Tamilnadu</option>
                                                                                </select>
                                                                            </div>                                                                                                                                                   
                                                                            <div class="col-md-6 col-sm-12 col-xs-12">
                                                                                <label>District</label>
                                                                                <select name="dist" class="form-control" required>
                                                                                    <option><?php echo $dist;?></option>
                                                                                    <option>Palakkad</option>
                                                                                    <option>Thrissur</option>
                                                                                </select>
                                                                            </div>
                                                                        
                                                                        <div class="seperator"></div>
                                                                        
                                                                        <div class="col-12 m-t20">
                                                                            <div class="ml-auto m-b5">
                                                                                <h3>2. Personal Information</h3>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6 col-sm-12 col-xs-12">
                                                                            <label>Trainer Name</label>
                                                                                <input type="text"  name="trainer_name" class="form-control" required value="<?php echo $trainer_name;?>">
                                                                            </div>                                                 
                                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                                            <label style="float:left">Contact No 1</label>
                                                                            <input type="text"  name="cntno1"  class="form-control" required value="<?php echo $cntno1;?>">
                                                                        </div>    
                                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                                            <label style="float:left">Contact No 2</label>
                                                                            <input type="text"  name="cntno2"  class="form-control" required value="<?php echo $cntno2;?>">
                                                                        </div>                                                                                    
                                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                                            <label>Email</label>
                                                                            <input type="email"  name="email"  class="form-control" required value="<?php echo $email;?>">
                                                                        </div>                                    
                                                                        <div class="col-md-6 col-sm-12 col-xs-12">
                                                                        <label>Photo</label>
                                                                        <input type="file"  name="photo"  class="form-control">
                                                                        </div>
                                                                        <div class="col-md-6 col-sm-12 col-xs-12">
                                                                        <label>Join Date</label>
                                                                        <input type="date"  name="jdate"  class="form-control" required value="<?php echo $jdate;?>">
                                                                        </div>  
                                                                        <div class="col-12 m-t20">
                                                                            <div class="ml-auto">
                                                                        <h3 class="m-form__section">4. Authentication Information</h3>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group col-6">
                                                                            <label class="col-form-label">Username</label>
                                                                            <div>
                                                                                <input class="form-control" type="text" name="username"  value="<?php echo $username;?>" readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group col-6">
                                                                            <label class="col-form-label">Password</label>
                                                                            <div>
                                                                    <input class="form-control" type="password" name="password"  value="<?php echo $password;?>" readonly>
                                                                            </div>
                                                                        </div>                                     
                                                                        <div class="col-12 m-t20">
                                                                            <div class="ml-auto">
                                                                        <h3 class="m-form__section">5. About</h3>
                                                                            </div>
                                                                        </div>                                  
                                                                        <div class="form-group col-12">
                                                                            <label class="col-form-label">Describe</label>
                                                                            <div>
                                                                    <textarea class="form-control" name="about"><?php echo $about;?></textarea>
                                                                            </div>
                                                                        </div>                                  
                                                                        <div class="col-12">
                                                                            <button type="submit" class="btn pull-right btn-primary ">Update</button>
                                                                            <button type="reset" class="btn pull-right btn-danger">Cancel</button>
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
                                </div>
                            </div>
                            </div>
                    </div>
                </div>
                </div>
            <?php
                include("include/footer.php")
            ?>
            </div>
    </div>
    <?php
        include("include/js.php")
    ?>
    </body>
</html>