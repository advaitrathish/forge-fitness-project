<?php
    include("auth.php");
    include('../../connect/db.php');
    $Log_Id=$_SESSION['SESS_TRAINEE_ID'];
    
    // Filters
    $filter_mem = isset($_GET['mem_name']) ? $_GET['mem_name'] : '';
    $from_date = isset($_GET['from_date']) ? $_GET['from_date'] : '';
    $to_date = isset($_GET['to_date']) ? $_GET['to_date'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("include/css.php"); ?>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <style>
        .volume-warning { background: #ff5722; color: white; padding: 10px; border-radius: 8px; animation: pulse-red 2s infinite; }
        @keyframes pulse-red { 0% { box-shadow: 0 0 0 0 rgba(255, 87, 34, 0.7); } 70% { box-shadow: 0 0 0 10px rgba(255, 87, 34, 0); } 100% { box-shadow: 0 0 0 0 rgba(255, 87, 34, 0); } }
        .stat-card { text-align: center; padding: 20px; border-radius: 10px; margin-bottom: 20px; }
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
                            <div class="pull-left"><div class="page-title">Exercise Volume & Intensity Monitor</div></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="card card-box">
                                <div class="card-body">
                                    <form method="GET" action="" class="form-inline">
                                        <div class="form-group mr-2">
                                            <label class="mr-2">Member:</label>
                                            <select name="mem_name" class="form-control">
                                                <option value="">-- All --</option>
                                                <?php
                                                    $m_list = $db->prepare("SELECT DISTINCT mem_name FROM gym_logs ORDER BY mem_name ASC");
                                                    $m_list->execute();
                                                    while($m_row = $m_list->fetch()) {
                                                        $sel = ($filter_mem == $m_row['mem_name']) ? 'selected' : '';
                                                        echo "<option value='".$m_row['mem_name']."' $sel>".$m_row['mem_name']."</option>";
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        
                                        <div class="form-group mr-2">
                                            <label class="mr-2">From:</label>
                                            <input type="date" name="from_date" class="form-control" value="<?php echo $from_date; ?>">
                                        </div>
                                        
                                        <div class="form-group mr-2">
                                            <label class="mr-2">To:</label>
                                            <input type="date" name="to_date" class="form-control" value="<?php echo $to_date; ?>">
                                        </div>

                                        <button type="submit" class="btn btn-primary">Filter</button>
                                        <a href="gym_analytics_pro.php" class="btn btn-default ml-1">Reset</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <?php
                            // Count Volume Warnings
                            $vol_query = "SELECT COUNT(*) as total FROM gym_logs WHERE CAST(exercise_count AS UNSIGNED) < 15 OR CAST(exercise_count AS UNSIGNED) > 30";
                            $vol_res = $db->query($vol_query)->fetch();
                        ?>
                        <div class="col-md-4">
                            <div class="stat-card <?php echo ($vol_res['total'] > 0) ? 'volume-warning' : 'bg-success'; ?>">
                                <strong>Intensity Alerts: <?php echo $vol_res['total']; ?> Logs Out of Range</strong>
                            </div>
                        </div>
                    </div>

                    <?php
                        // DATA AGGREGATION WITH DATE FILTER
                        $dateActivity = [];
                        $intensityGroups = ['Low (<15)' => 0, 'Target (15-30)' => 0, 'High (>30)' => 0];
                        $exercisePopularity = [];
                        
                        $sql = "SELECT * FROM gym_logs WHERE 1=1";
                        if($filter_mem != '') { $sql .= " AND mem_name = :mname"; }
                        if($from_date != '') { $sql .= " AND log_date >= :from_d"; }
                        if($to_date != '')   { $sql .= " AND log_date <= :to_d"; }
                        
                        $res = $db->prepare($sql);
                        if($filter_mem != '') { $res->bindParam(':mname', $filter_mem); }
                        if($from_date != '') { $res->bindParam(':from_d', $from_date); }
                        if($to_date != '')   { $res->bindParam(':to_d', $to_date); }
                        
                        $res->execute();
                        
                        while($row = $res->fetch()) {
                            $d = date("d-M", strtotime($row['log_date']));
                            $ex = $row['exercise_name'];
                            $count = (int)$row['exercise_count'];

                            $dateActivity[$d] = ($dateActivity[$d] ?? 0) + 1;
                            $exercisePopularity[$ex] = ($exercisePopularity[$ex] ?? 0) + 1;

                            if($count < 15) $intensityGroups['Low (<15)']++;
                            elseif($count > 30) $intensityGroups['High (>30)']++;
                            else $intensityGroups['Target (15-30)']++;
                        }
                        ksort($dateActivity);
                    ?>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="card card-box">
                                <div class="card-head"><header>Intensity Distribution</header></div>
                                <div class="card-body"><div id="intensity_pie" style="height: 300px;"></div></div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card card-box">
                                <div class="card-head"><header>Daily Exercise Frequency</header></div>
                                <div class="card-body"><div id="bar_chart" style="height: 300px;"></div></div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card card-box">
                                <div class="card-head"><header>Most Popular Workouts</header></div>
                                <div class="card-body"><div id="ex_bar" style="height: 300px;"></div></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-box">
                                <div class="card-head"><header>Volume Trend (Daily Exercise Counts)</header></div>
                                <div class="card-body"><div id="line_trend" style="height: 300px;"></div></div>
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
        google.charts.setOnLoadCallback(drawDashboard);

        function drawDashboard() {
            var intensityData = google.visualization.arrayToDataTable([
                ['Category', 'Count'],
                <?php foreach($intensityGroups as $cat => $val) echo "['$cat', $val],"; ?>
            ]);

            var bData = google.visualization.arrayToDataTable([
                ['Date', 'Logs', { role: 'style' }],
                <?php 
                $c = ['#1abc9c', '#2ecc71', '#3498db', '#9b59b6']; $i=0;
                foreach($dateActivity as $d => $v) {
                    echo "['$d', $v, '".$c[$i%4]."'],"; $i++;
                }
                ?>
            ]);

            var exData = google.visualization.arrayToDataTable([
                ['Exercise', 'Frequency'],
                <?php foreach($exercisePopularity as $ex => $v) echo "['$ex', $v],"; ?>
            ]);

            var lData = google.visualization.arrayToDataTable([
                ['Date', 'Total Volume'],
                <?php foreach($dateActivity as $d => $v) echo "['$d', $v],"; ?>
            ]);

            new google.visualization.PieChart(document.getElementById('intensity_pie')).draw(intensityData, {
                is3D:true, colors:['#f1c40f', '#27ae60', '#e74c3c'], legend:'bottom'
            });

            new google.visualization.ColumnChart(document.getElementById('bar_chart')).draw(bData, {legend:'none'});
            new google.visualization.BarChart(document.getElementById('ex_bar')).draw(exData, {legend:'none', colors:['#34495e']});
            new google.visualization.LineChart(document.getElementById('line_trend')).draw(lData, {curveType:'function', pointSize:8});
        }
    </script>
</body>
</html>