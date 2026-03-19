<?php
    include("auth.php");
    include('../../connect/db.php');
    $Log_Id=$_SESSION['SESS_USER_ID'];
    
    // Fetch trainee data
    $result = $db->prepare("SELECT * FROM members WHERE Log_Id = '$Log_Id'");
    $result->execute();
    
    $filter_mem = "";
    while($row = $result->fetch())
    {       
        $filter_mem = $row["tname"];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("include/css.php"); ?>
    <link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css" rel="stylesheet" />
    <style>
        .ai-opinion-box {
            font-size: 11px;
            padding: 4px 8px;
            border-radius: 4px;
            display: inline-block;
            margin-top: 5px;
            border-left: 3px solid;
        }
        .status-pill {
            font-weight: bold;
            padding: 4px 12px;
            border-radius: 50px;
            color: #fff;
            font-size: 11px;
            text-transform: uppercase;
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
                    
                    <div class="page-bar">
                        <div class="page-title-breadcrumb">
                            <div class="pull-left"><div class="page-title">Advanced Workout Analytics</div></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-topline-indigo">
                                <div class="card-head">
                                    <header><i class="fa fa-bolt"></i> Live Performance Feed</header>
                                </div>
                                <div class="card-body">
                                    <div class="table-scrollable">
                                        <table class="table table-hover table-bordered" id="workoutTable">
                                            <thead>
                                                <tr class="active">
                                                    <th>#</th>
                                                    <th>Member</th>
                                                    <th>Exercise Details</th>
                                                    <th>Intensity</th>
                                                    <th>Date & Time</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $total_exercises = 0;
                                                    $sql = "SELECT * FROM gym_logs";
                                                    
                                                    if($filter_mem != '') {
                                                        $sql .= " WHERE mem_name = :mname ORDER BY log_date DESC";
                                                        $stmt = $db->prepare($sql);
                                                        $stmt->bindParam(':mname', $filter_mem);
                                                    } else {
                                                        $sql .= " ORDER BY log_date DESC";
                                                        $stmt = $db->prepare($sql);
                                                    }
                                                    
                                                    $stmt->execute();
                                                    $rows = $stmt->fetchAll();
                                                    foreach($rows as $key => $row) {
                                                        $total_exercises++;
                                                        $count = $row['exercise_count'];
                                                        
                                                        // AI OPINION ENGINE
                                                        if ($count < 6) {
                                                            $opinion = "Strength Focus: You are moving heavy weight! Ensure 3 min rest between sets.";
                                                            $op_color = "#e74c3c"; // Red
                                                            $op_bg = "#fdf2f2";
                                                            $status = "Power";
                                                        } elseif ($count >= 6 && $count < 10) {
                                                            $opinion = "Growth Zone: Good effort, but push for 10-12 reps to maximize muscle hypertrophy.";
                                                            $op_color = "#f39c12"; // Orange
                                                            $op_bg = "#fff9eb";
                                                            $status = "Incomplete";
                                                        } else {
                                                            $opinion = "Optimal Volume: Perfect rep range for muscle definition and endurance.";
                                                            $op_color = "#27ae60"; // Green
                                                            $op_bg = "#f4faf6";
                                                            $status = "Target Met";
                                                        }
                                                ?>
                                                <tr <?php if($count < 10) echo 'style="background-color: '.$op_bg.';"'; ?>>
                                                    <td><?php echo $key + 1; ?></td>
                                                    <td>
                                                        <strong><?php echo $row['mem_name']; ?></strong><br>
                                                        <small class="text-muted">ID: <?php echo $row['Log_Id']; ?></small>
                                                    </td>
                                                    <td>
                                                        <span style="font-size: 15px; font-weight: 600; color: #34495e;"><?php echo $row['exercise_name']; ?></span><br>
                                                        <div class="ai-opinion-box" style="border-color: <?php echo $op_color; ?>; color: <?php echo $op_color; ?>; background: white;">
                                                            <i class="fa fa-android"></i> <strong>AI Opinion:</strong> <?php echo $opinion; ?>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div style="font-size: 18px; font-weight: bold; color: #2c3e50;"><?php echo $count; ?></div>
                                                        <span class="status-pill" style="background-color: <?php echo $op_color; ?>;">
                                                            <?php echo $status; ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <i class="fa fa-calendar"></i> <?php echo date("d-M-Y", strtotime($row['log_date'])); ?><br>
                                                        <i class="fa fa-clock-o"></i> <?php echo date("h:i A", strtotime($row['log_time'])); ?>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                            <tfoot>
                                                <tr style="background: #3f51b5; color: white;">
                                                    <td colspan="3" class="text-right"><strong>TOTAL LOGGED ACTIVITIES:</strong></td>
                                                    <td colspan="2"><strong><?php echo $total_exercises; ?> Exercises</strong></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include("include/js.php") ?>
    
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#workoutTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    { extend: 'excel', className: 'btn btn-success btn-outline' },
                    { extend: 'pdf', className: 'btn btn-danger btn-outline' },
                    { extend: 'print', className: 'btn btn-primary btn-outline' }
                ],
                "order": [[ 4, "desc" ]],
                "pageLength": 15
            });
        });
    </script>
</body>
</html>