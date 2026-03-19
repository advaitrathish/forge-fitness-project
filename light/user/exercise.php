<?php
    include("auth.php");
    include('../../connect/db.php');
    $Log_Id=$_SESSION['SESS_USER_ID'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("include/css.php"); ?>
    <style>
        /* Custom style to ensure the iframe is truly full width and responsive */
        .iframe-container {
            width: 100%;
            overflow: hidden;
            /* Adjust padding-top to change aspect ratio if needed, or use fixed height */
            background: #f1f1f1;
            border-radius: 8px;
            border: 1px solid #e1e1e1;
        }
        #external-frame {
            width: 100%;
            height: 800px; /* You can adjust this height as needed */
            border: none;
        }
    </style>
</head>

<body class="page-header-fixed sidemenu-closed-hidelogo page-content-white page-md header-white white-sidebar-color logo-indigo">
    <div class="page-wrapper">
        <?php include("include/header.php"); ?>
        
        <div class="page-container">
            <?php include("include/leftmenu.php"); ?>
            
            <div class="page-content-wrapper">
                <div class="page-content">
                   

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-box">
                                <div class="card-head">
                                    <header>External Monitoring System</header>
                                </div>
                                <div class="card-body">
                                    <div class="iframe-container">
                                        <iframe 
                                            src="http://127.0.0.1:5000" 
                                            id="external-frame"
                                            title="Gym Monitoring System"
                                            allowfullscreen>
                                        </iframe>
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