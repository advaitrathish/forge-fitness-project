<?php
    include("auth.php");
    include('../../connect/db.php');
    $Log_Id=$_SESSION['SESS_ADMIN_ID'];
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
                            <div class="pull-left"><div class="page-title">Staff Salary Entry</div></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="card card-box">
                                <div class="card-head">
                                    <header>Record Payment</header>
                                </div>
                                <div class="card-body" id="bar-parent">
                                    <form action="action/salary_save.php" method="post">
                                        <div class="form-group">
                                            <label>Select Staff/Trainer</label>
                                            <select class="form-control" name="staff_id" required>
                                                <option value="">-- Select Personnel --</option>
                                                <?php
                                                    // Assuming you have a 'trainers' or 'staff' table
                                                    $result = $db->prepare("SELECT * FROM trainees");
                                                    $result->execute();
                                                    while($row = $result->fetch()){
                                                        echo '<option value="'.$row['Log_Id'].'">'.$row['tname'].' ('.$row['trainer_name'].')</option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Salary Month & Year</label>
                                            <input type="month" name="salary_month" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Amount Paid</label>
                                            <div class="input-group">
                                                <span class="input-group-addon">₹</span>
                                                <input type="number" name="amount" class="form-control" placeholder="0.00" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Payment Date</label>
                                            <input type="date" name="paid_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Remarks</label>
                                            <textarea name="remarks" class="form-control" rows="2" placeholder="Bonus, Deductions, etc."></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Submit Salary</button>
                                    </form>
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