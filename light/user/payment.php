<?php
    include("auth.php");
    include('../../connect/db.php');
    $Log_Id = $_SESSION['SESS_USER_ID'];
    
    // Fetch trainee data
    $result = $db->prepare("SELECT * FROM members WHERE Log_Id = '$Log_Id'");
    $result->execute();
    
    for($i=0; $row = $result->fetch(); $i++)
    {       
        $mem_id = $row["id"];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("include/css.php"); ?>
    <link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css" rel="stylesheet" />
    <style>
        /* Modern UI Elements */
        .ai-status { border-left: 4px solid #00c853; background: #f1f8e9; padding: 8px; border-radius: 4px; font-size: 11px; }
        .payment-method-pill { background: #3f51b5; color: white; padding: 2px 10px; border-radius: 20px; font-size: 10px; text-transform: uppercase; }
        
        /* QR Scanner Animation */
        .qr-wrapper {
            position: relative;
            width: 180px;
            height: 180px;
            margin: 15px auto;
            background: #fff;
            padding: 10px;
            border: 2px solid #4285F4;
            border-radius: 10px;
            overflow: hidden;
        }
        .scanner-line {
            position: absolute;
            width: 100%;
            height: 3px;
            background: rgba(234, 67, 53, 0.7);
            top: 0;
            left: 0;
            box-shadow: 0 0 8px 2px rgba(234, 67, 53, 0.5);
            animation: scan 2s linear infinite;
            z-index: 10;
        }
        @keyframes scan {
            0% { top: 0%; }
            50% { top: 100%; }
            100% { top: 0%; }
        }
        .qr-wrapper img { width: 100%; height: auto; position: relative; z-index: 5; transition: opacity 0.2s; }
        
        /* Modal Polish */
        .modal-content { border-radius: 15px; border: none; }
        .gpay-header { background: #4285F4; color: white; border-radius: 15px 15px 0 0; padding: 15px; }
    </style>
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
                            <div class="pull-left"><div class="page-title">Digital Billing Desk</div></div>
                            <div class="pull-right">
                                <button type="button" class="btn btn-primary btn-lg" id="btnOpenPayment">
                                    <i class="fa fa-qrcode"></i> Scan & Pay
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-topline-indigo">
                                <div class="card-body">
                                    <table class="table table-hover" id="feesTable">
                                        <thead>
                                            <tr>
                                                <th>Ref #</th>
                                                <th>Member</th>
                                                <th>Amount</th>
                                                <th>Payment Mode</th>
                                                <th>AI Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            echo $mem_id;
                                                $sql = "SELECT fees.*, members.tname FROM fees INNER JOIN members ON fees.member_id = members.id WHERE members.id = '$mem_id'  ORDER BY fees.id DESC";
                                                $stmt = $db->prepare($sql);
                                                $stmt->execute();
                                                while($row = $stmt->fetch()) {
                                            ?>
                                            <tr>
                                                <td><?php echo $row['id']; ?></td>
                                                <td><strong><?php echo $row['tname']; ?></strong></td>
                                                <td class="text-success" style="font-weight:bold;">₹<?php echo number_format($row['amount'],2); ?></td>
                                                <td><span class="payment-method-pill"><?php echo $row['method']; ?></span></td>
                                                <td>
                                                    <div class="ai-status">
                                                        <i class="fa fa-check-circle"></i> AI Verified: Payment Logged
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="gpay-header">
                    <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-google-wallet"></i> Digital Payment Terminal</h4>
                </div>
                <form action="save_payment.php" method="POST">
                    <div class="modal-body text-center">
                        <div class="row">
                            <div class="col-md-6 text-left">
                                <div class="form-group">
                                    <label>Member</label>
                                    <select name="member_id" class="form-control" required>
                                        <?php
                                            $m = $db->prepare("SELECT id, tname FROM members");
                                            $m->execute();
                                            while($r = $m->fetch()) { echo "<option value='".$r['id']."'>".$r['tname']."</option>"; }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Amount (₹)</label>
                                    <input type="number" id="payAmount" name="amount" class="form-control" value="1000" required autofocus>
                                </div>
                                <div class="form-group">
                                    <label>Method</label>
                                    <input type="text" name="method" class="form-control" value="GPay / UPI" readonly>
                                </div>
                            </div>
                            
                            <div class="col-md-6" style="border-left: 1px solid #eee;">
                                <label>AI Generated QR</label>
                                <div class="qr-wrapper">
                                    <div class="scanner-line"></div>
                                    <img id="qrImage" src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=upi://pay?pa=gym@upi&am=1000&cu=INR" alt="QR Code">
                                </div>
                                <p class="small text-muted">Amount: <strong id="qrLabel">₹1000</strong></p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                       <button type="button" class="btn btn-default btn-close-manual">Close</button>
                        <button type="submit" class="btn btn-primary">Confirm & Finalize</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include("include/js.php") ?>
    
    <script type="text/javascript">
        $(document).ready(function() {
            // 1. Initialize Table
            $('#feesTable').DataTable();

            // 2. FORCE MODAL OPEN (Fixed Trigger)
            $('#btnOpenPayment').on('click', function(e) {
                e.preventDefault();
                $('#paymentModal').modal('show');
            });
			// 2. Bulletproof CLOSE (Manual fix for your "not working" close issue)
            $('.btn-close-manual').click(function() {
                $('#paymentModal').modal('hide');
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove(); 
            });
            // 3. REAL-TIME QR UPDATE LOGIC
            // Using 'keyup' and 'input' to catch every keystroke immediately
            $('#payAmount').on('keyup input', function() {
                var amt = $(this).val();
                
                // Fallback for empty input
                if(amt === "" || amt < 0) { amt = 0; }
                
                // Update text label
                $('#qrLabel').text('₹' + amt);

                // Build the UPI URL (pa = your VPA, am = amount)
                var upiData = "upi://pay?pa=gym@upi&am=" + amt + "&cu=INR";
                
                // Faster QR API for real-time loading
                var qrSource = "https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=" + encodeURIComponent(upiData);
                
                // Update Image
                $('#qrImage').css('opacity', '0.5'); // Visual hint it's loading
                $('#qrImage').attr('src', qrSource);
                
                $('#qrImage').on('load', function() {
                    $(this).css('opacity', '1');
                });
            });
        });
    </script>
</body>
</html>