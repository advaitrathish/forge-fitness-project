<?php
    include("auth.php");
    include('../../connect/db.php');
     $Log_Id=$_SESSION['SESS_ADMIN_ID'];
    $filter_mem = isset($_GET['mem_name']) ? $_GET['mem_name'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("include/css.php"); ?>
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
                            <div class="pull-left"><div class="page-title">Gym Activity Analytics</div></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-box">
                                <div class="card-body">
                                    <form method="GET" action="" class="form-inline">
                                        <div class="form-group mx-sm-3 mb-2">
                                            <label class="mr-2">Select Member: </label>
                                            <select name="mem_name" class="form-control" onchange="this.form.submit()">
                                                <option value="">-- All Members --</option>
                                                <?php
                                                    $m_list = $db->prepare("SELECT DISTINCT mem_name FROM gym_logs ORDER BY mem_name ASC");
                                                    $m_list->execute();
                                                    while($m_row = $m_list->fetch()) {
                                                        $selected = ($filter_mem == $m_row['mem_name']) ? 'selected' : '';
                                                        echo "<option value='".$m_row['mem_name']."' $selected>".$m_row['mem_name']."</option>";
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <?php if($filter_mem != '') { ?>
                                            <a href="workout_analytics.php" class="btn btn-default mb-2">Reset View</a>
                                        <?php } ?>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                        // DATA PREPARATION
                        $dateData = [];
                        $memberData = [];
                        
                        $sql = "SELECT mem_name, log_date FROM gym_logs";
                        if($filter_mem != '') {
                            $sql .= " WHERE mem_name = :mname";
                            $res = $db->prepare($sql);
                            $res->bindParam(':mname', $filter_mem);
                        } else {
                            $res = $db->prepare($sql);
                        }
                        $res->execute();
                        while($row = $res->fetch()) {
                            $d = date("d-M", strtotime($row['log_date']));
                            $m = $row['mem_name'];
                            $dateData[$d] = ($dateData[$d] ?? 0) + 1;
                            $memberData[$m] = ($memberData[$m] ?? 0) + 1;
                        }
                        ksort($dateData); // Sort dates chronologically
                    ?>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-box">
                                <div class="card-head"><header>Daily Exercise Count (Bar)</header></div>
                                <div class="card-body">
                                    <div id="bar_chart" style="height: 300px;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card card-box">
                                <div class="card-head"><header>Member Participation (Pie)</header></div>
                                <div class="card-body">
                                    <div id="pie_chart" style="height: 300px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-box">
                                <div class="card-head"><header>Workout Trend Over Time (Line)</header></div>
                                <div class="card-body">
                                    <div id="line_chart" style="height: 350px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <?php include("include/js.php") ?>
    
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawCharts);

        function drawCharts() {
            // 1. BAR CHART DATA
            var bData = google.visualization.arrayToDataTable([
                ['Date', 'Exercises', { role: 'style' }],
                <?php 
                $colors = ['#3f51b5', '#e91e63', '#9c27b0', '#00bcd4', '#4caf50', '#ff9800'];
                $i = 0;
                foreach($dateData as $date => $val) {
                    $color = $colors[$i % count($colors)];
                    echo "['$date', $val, '$color'],";
                    $i++;
                }
                ?>
            ]);

            // 2. PIE CHART DATA
            var pData = google.visualization.arrayToDataTable([
                ['Member', 'Logs'],
                <?php 
                foreach($memberData as $mem => $val) {
                    echo "['$mem', $val],";
                }
                ?>
            ]);

            // 3. LINE CHART DATA (Trend)
            var lData = google.visualization.arrayToDataTable([
                ['Date', 'Activity Level'],
                <?php 
                foreach($dateData as $date => $val) {
                    echo "['$date', $val],";
                }
                ?>
            ]);

            // DRAW BAR
            new google.visualization.ColumnChart(document.getElementById('bar_chart')).draw(bData, {
                legend: 'none', chartArea: {width: '80%', height: '70%'}
            });

            // DRAW PIE
            new google.visualization.PieChart(document.getElementById('pie_chart')).draw(pData, {
                is3D: true, chartArea: {width: '90%', height: '80%'}
            });

            // DRAW LINE
            new google.visualization.LineChart(document.getElementById('line_chart')).draw(lData, {
                curveType: 'function',
                pointSize: 7,
                hAxis: { title: 'Date' },
                vAxis: { title: 'Total Exercises' },
                chartArea: {width: '90%', height: '70%'}
            });
        }
    </script>
</body>
</html>