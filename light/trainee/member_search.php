<?php
    include("auth.php");
    include('../../connect/db.php');
    $Log_Id=$_SESSION['SESS_TRAINEE_ID'];
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
                            <div class=" pull-left">
                                <div class="page-title">Gym Members</div>
                            </div>
                            <ol class="breadcrumb page-breadcrumb pull-right">
                                <li><i class="fa fa-home"></i>&nbsp;<a class="parent-item" href="index.php">Home</a>&nbsp;<i class="fa fa-angle-right"></i></li>
                                <li class="active">Member Search</li>
                            </ol>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="tabbable-line">
                                <ul class="nav customtab nav-tabs" role="tablist">
                                    <li class="nav-item"><a href="#tab1" class="nav-link active" data-bs-toggle="tab">List View</a></li>
                                    <li class="nav-item"><a href="#tab2" class="nav-link" data-bs-toggle="tab">Grid View</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active fontawesome-demo" id="tab1">
                                        <div class="card card-box">
                                            <div class="card-head">
                                                <header>All Registered Members</header>
                                            </div>
                                            <div class="card-body">
                                                
                                                <table class="table table-striped table-bordered table-hover table-checkable order-column valign-middle" id="example4">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th> Name </th>
                                                            <th> Plan </th>
                                                            <th> Blood Group </th>
                                                            <th> Address </th>
                                                            <th> Contact </th>
                                                            <th> Email </th>
                                                            <th>Joined Date</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            $result = $db->prepare("SELECT * FROM members ORDER BY id DESC");
                                                            $result->execute();
                                                            for($i=0; $rows = $result->fetch(); $i++) {
                                                        ?>
                                                        <tr class="odd gradeX">
                                                            <td class="patient-img">
                                                                <img src="../photo/<?php echo $rows['photo'];?>" alt="profile">
                                                            </td>
                                                            <td><?php echo $rows['tname'];?></td>
                                                            <td class="left"><?php echo $rows['membership_plan'];?></td>
                                                            <td class="left"><?php echo $rows['blood_group'];?></td>
                                                            <td class="left"><?php echo $rows['addr'];?></td>
                                                            <td class="left"><?php echo $rows['cntno1'];?></td>
                                                            <td class="left"><?php echo $rows['email'];?></td>
                                                            <td class="left"><?php echo $rows['jdate'];?></td>
                                                          
                                                        </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="tab2">
                                        <div class="row">
                                            <?php
                                                $result = $db->prepare("SELECT * FROM members ORDER BY id DESC");
                                                $result->execute();
                                                for($i=0; $rows = $result->fetch(); $i++) {
                                            ?>
                                            <div class="col-md-4">
                                                <div class="card card-box">
                                                    <div class="card-body no-padding ">
                                                        <div class="doctor-profile">
                                                            <img src="../photo/<?php echo $rows['photo'];?>" class="doctor-pic" alt="">
                                                            <div class="profile-usertitle">
                                                                <div class="doctor-name"><?php echo $rows['tname'];?></div>
                                                                <div class="name-center">Plan: <?php echo $rows['membership_plan'];?></div>
                                                            </div>
                                                            <p><?php echo $rows['addr'];?></p>
                                                            <div>
                                                                <p><i class="fa fa-phone"></i><a href="tel:<?php echo $rows['cntno1'];?>"> <?php echo $rows['cntno1'];?></a></p>
                                                            </div>
                                                          
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php } ?>
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
    <?php include("include/js.php") ?>
</body>
</html>