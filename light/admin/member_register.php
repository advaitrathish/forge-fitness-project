<?php
    include("auth.php");
    include('../../connect/db.php');
    $Log_Id=$_SESSION['SESS_ADMIN_ID'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        include("include/css.php");
    ?>
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
                            <div class=" pull-left">
                                <div class="page-title">Gym Member Registration</div>
                            </div>
                            <ol class="breadcrumb page-breadcrumb pull-right">
                                <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.php">Home</a>&nbsp;<i class="fa fa-angle-right"></i></li>
                                <li><a class="parent-item" href="">Members</a>&nbsp;<i class="fa fa-angle-right"></i></li>
                                <li class="active">Add New Member</li>
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
                                            <form class="edit-profile m-b30" method="post" action="action/member_save.php" enctype="multipart/form-data" autocomplete="off">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="ml-auto">
                                                            <h3>1. Membership Details</h3>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <label>Membership Number</label>
                                                        <input type="text" class="form-control" name="Log_Id" required="" value="<?php echo "MEM".rand(1000,9999).rand(1000,9999); ?>" readonly>
                                                    </div>                                                
                                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                                        <label>Full Name</label>
                                                        <input type="text" name="tname" class="form-control" required pattern="[A-Za-z\s]*">
                                                    </div>
                                                     <div class="col-md-6 col-sm-12 col-xs-12">
                                                        <label>Gender</label>
                                                        <select name="sex" class="form-control" required>
                                                            <option value="">Select</option>
                                                            <option>Male</option>
                                                            <option>Female</option>
                                                            <option>Other</option>
                                                        </select>
                                                    </div>  
                                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                                        <label>Age</label>
                                                        <input type="number" name="age" class="form-control" placeholder="e.g. 20" required>
                                                    </div>  
                                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                                        <label>Blood Group</label>
                                                        <input type="text" name="blood_group" class="form-control" placeholder="e.g. A+ve, O-ve">
                                                    </div>                                                  
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                        <label>Residential Address</label>
                                                        <textarea name="addr" class="form-control" rows="2"></textarea>  
                                                    </div>
                                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                                        <label>State</label>
                                                        <select name="stat" class="form-control" required>
                                                            <option value="">Select State</option>
                                                            <option>Kerala</option>
                                                            <option>Tamilnadu</option>
                                                        </select>
                                                    </div>                                                                                                                                                
                                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                                        <label>District</label>
                                                        <select name="dist" class="form-control" required>
                                                            <option value="">Select District</option>
                                                            <option>Palakkad</option>
                                                            <option>Thrissur</option>
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="seperator"></div>
                                                    
                                                    <div class="col-12 m-t20">
                                                        <div class="ml-auto m-b5">
                                                            <h3>2. Contact & Health Info</h3>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                                        <label>Membership Plan (e.g. Monthly/Yearly)</label>
                                                        <input type="text" name="membership_plan" class="form-control" required>
                                                    </div>                                                 
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <label style="float:left">Primary Phone Number</label>
                                                        <input type="text" name="cntno1" class="form-control" required pattern="[0-9]{10}" maxlength="10" minlength="10" >
                                                    </div>    
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <label style="float:left">Emergency Contact Number</label>
                                                        <input type="text" name="cntno2" class="form-control" required pattern="[0-9]{10}" maxlength="10" minlength="10" >
                                                    </div>                                                                                                                                                                    
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <label>Email Address</label>
                                                        <input type="email" name="email" class="form-control" required>
                                                    </div>                                    
                                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                                        <label>Member Photo</label>
                                                        <input type="file" name="photo" class="form-control" required>
                                                    </div>
                                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                                        <label>Subscription Start Date</label>
                                                        <input type="date" name="jdate" class="form-control" required>
                                                    </div>                          
                                                    
                                                    <div class="col-12 m-t20">
                                                        <div class="ml-auto">
                                                            <h3 class="m-form__section">3. Account Credentials</h3>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-6">
                                                        <label class="col-form-label">Username</label>
                                                        <div>
                                                            <input class="form-control" type="text" name="username" required maxlength="20" minlength="5" >
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-6">
                                                        <label class="col-form-label">Password</label>
                                                        <div>
                                                            <input class="form-control" type="password" name="password" required maxlength="20" minlength="4" >
                                                        </div>
                                                    </div>  
                                                    <div class="col-12 m-t20">
                                                        <div class="ml-auto">
                                                            <h3 class="m-form__section">4. Physical Goals & Health Notes</h3>
                                                        </div>
                                                    </div>                                  
                                                    <div class="form-group col-12">
                                                        <label class="col-form-label">Fitness Objectives / Past Injuries / Medical Conditions</label>
                                                        <div>
                                                            <textarea class="form-control" name="about" required placeholder="Enter weight loss goals, muscle gain targets, or medical restrictions..."></textarea>
                                                        </div>
                                                    </div>                                  
                                                    <div class="col-12">
                                                        <button type="submit" class="btn pull-right btn-primary">Register Member</button>
                                                        <button type="reset" class="btn pull-right btn-danger">Clear Form</button>
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
            <?php include("include/footer.php") ?>
            </div>
    </div>
    <?php include("include/js.php") ?>
    </body>
</html>