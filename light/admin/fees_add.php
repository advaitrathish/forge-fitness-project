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
                            <div class="pull-left"><div class="page-title">Collect Member Fees</div></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8 col-sm-12">
                            <div class="card card-box">
                                <div class="card-head">
                                    <header>Payment Entry</header>
                                </div>
                                <div class="card-body" id="bar-parent">
                                    <form action="action/fees_save.php" method="post">
                                        <div class="form-group">
                                            <label>Select Member</label>
                                            <select class="form-control" name="member_id" id="member_select" required>
                                                <option value="">-- Choose Member --</option>
                                                <?php
                                                    $result = $db->prepare("SELECT id, tname, membership_plan FROM members ORDER BY tname ASC");
                                                    $result->execute();
                                                    while($row = $result->fetch()){
                                                        echo '<option value="'.$row['id'].'" data-plan="'.$row['membership_plan'].'">'.$row['tname'].' (ID: '.$row['id'].')</option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Membership Plan (Autofilled)</label>
                                            <input type="text" id="plan_display" class="form-control" readonly placeholder="Select a member to see plan">
                                        </div>

                                        <div class="form-group">
                                            <label>Amount Received</label>
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
                                            <label>Payment Method</label>
                                            <select class="form-control" name="method">
                                                <option value="Cash">Cash</option>
                                                <option value="UPI/Online">UPI / Online</option>
                                                <option value="Card">Credit/Debit Card</option>
                                                <option value="Cheque">Cheque</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Remarks</label>
                                            <textarea name="remarks" class="form-control" rows="2" placeholder="e.g. Paid for October Month"></textarea>
                                        </div>

                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-primary">Save Payment</button>
                                            <button type="button" class="btn btn-default" onclick="window.history.back();">Cancel</button>
                                        </div>
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

    <script>
        // Simple JS to show the member's plan when selected
        document.getElementById('member_select').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            var plan = selectedOption.getAttribute('data-plan');
            document.getElementById('plan_display').value = plan ? plan : "No Plan Assigned";
        });
    </script>
</body>
</html>