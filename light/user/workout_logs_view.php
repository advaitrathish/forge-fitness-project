<?php
    include("auth.php");
    include('../../connect/db.php');
    $Log_Id=$_SESSION['SESS_USER_ID'];
    
    // Fetch trainee data
    $result = $db->prepare("SELECT * FROM members WHERE Log_Id = '$Log_Id'");
    $result->execute();
    
    for($i=0; $row = $result->fetch(); $i++)
    {       
        $filter_mem = $row["tname"];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("include/css.php"); ?>
    <link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css" rel="stylesheet" />
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
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
                            <div class="pull-left"><div class="page-title">Daily Workout Logs</div></div>
                           
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-box">
                                <div class="card-head"><header>Daily Exercise Volume </header></div>
                                <div class="card-body">
                                    <div id="workout_bar_chart" style="width: 100%; height: 350px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-topline-indigo">
                                <div class="card-body">
                                    <div class="table-scrollable">
                                        <table class="table table-hover table-bordered" id="workoutTable">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Log ID</th>
                                                    <th>Member Name</th>
                                                    <th>Exercise</th>
                                                    <th>Count/Sets</th>
                                                    <th>Date</th>
                                                    <th>Time</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $total_exercises = 0;
                                                    $chartData = [];
                                                    
                                                    $sql = "SELECT * FROM gym_logs";
                                                    
                                                    if($filter_mem != '') {
                                                        $sql .= " WHERE mem_name = :mname ORDER BY log_date ASC";
                                                        $result = $db->prepare($sql);
                                                        $result->bindParam(':mname', $filter_mem);
                                                    } else {
                                                        $sql .= " ORDER BY log_date ASC";
                                                        $result = $db->prepare($sql);
                                                    }
                                                    
                                                    $result->execute();
                                                    $rows = $result->fetchAll();
                                                    foreach($rows as $key => $row) {
                                                        $total_exercises++;
                                                        
                                                        // Group count of exercises by Date for the chart
                                                        $l_date = date("d-M-Y", strtotime($row['log_date']));
                                                        $chartData[$l_date] = ($chartData[$l_date] ?? 0) + 1;
                                                ?>
                                                <tr>
                                                    <td><?php echo $key + 1; ?></td>
                                                    <td><?php echo $row['Log_Id']; ?></td>
                                                    <td><?php echo $row['mem_name']; ?></td>
                                                    <td><strong><?php echo $row['exercise_name']; ?></strong></td>
                                                    <td><?php echo $row['exercise_count']; ?></td>
                                                    <td><?php echo $l_date; ?></td>
                                                    <td><?php echo date("h:i A", strtotime($row['log_time'])); ?></td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                            <tfoot>
                                                <tr style="background: #eee; font-weight: bold;">
                                                    <td colspan="4" class="text-right">TOTAL SESSIONS LOGGED:</td>
                                                    <td colspan="3"><?php echo $total_exercises; ?> Exercises</td>
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
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
                "order": [[ 5, "desc" ]] // Sort by Date column
            });
        });

        google.charts.load("current", {packages:['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ["Date", "Exercises Logged", { role: "style" } ],
                <?php 
                    $colors = ['#5c6bc0', '#66bb6a', '#ffa726', '#ef5350', '#26c6da', '#ab47bc', '#8d6e63', '#78909c'];
                    $index = 0;
                    
                    foreach($chartData as $date => $count) {
                        $color = $colors[$index % count($colors)];
                        echo "['$date', $count, '$color'],";
                        $index++;
                    }
                ?>
            ]);

            var view = new google.visualization.DataView(data);
            view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

            var options = {
                title: 'Daily Exercise Frequency',
                bar: {groupWidth: "70%"},
                legend: { position: "none" },
                hAxis: { title: 'Workout Date' },
                vAxis: { title: 'Number of Exercises' },
                chartArea: {width: '85%', height: '70%'}
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('workout_bar_chart'));
            chart.draw(view, options);
        }
    </script>
</body>
</html>