<?php
    include("auth.php");
    include('../../connect/db.php');
    $Log_Id = $_SESSION['SESS_TRAINEE_ID'];
    
    // Filters
    $filter_mem = isset($_GET['mem_name']) ? $_GET['mem_name'] : '';
    $from_date = isset($_GET['from_date']) ? $_GET['from_date'] : '';
    $to_date = isset($_GET['to_date']) ? $_GET['to_date'] : '';

    // Logic for Recommendation System
    $recommendation = "Select a member to see system recommendations.";
    $rec_class = "alert-secondary";
    $trend_icon = "fa-line-chart";

    if($filter_mem != '') {
        $rec_sql = "SELECT exercise_count FROM gym_logs WHERE mem_name = :mname ORDER BY log_date DESC LIMIT 5";
        $rec_res = $db->prepare($rec_sql);
        $rec_res->execute([':mname' => $filter_mem]);
        $recent_vals = $rec_res->fetchAll(PDO::FETCH_COLUMN);
        
        if(count($recent_vals) > 0) {
            $avg = array_sum($recent_vals) / count($recent_vals);
            if($avg < 15) {
                $recommendation = "<strong>USER DOWN:</strong> Low intensity detected (Avg: ".round($avg,1)."). Risk of quitting. Suggest a follow-up call or a new trainer.";
                $rec_class = "alert-danger";
                $trend_icon = "fa-arrow-down";
            } elseif($avg > 30) {
                $recommendation = "<strong>INCREASE DETECTED:</strong> High intensity (Avg: ".round($avg,1)."). Member is peaking. Suggest advanced supplements or Personal Training upsell.";
                $rec_class = "alert-info";
                $trend_icon = "fa-arrow-up";
            } else {
                $recommendation = "<strong>STABLE PROGRESS:</strong> Member is consistent in the target zone (Avg: ".round($avg,1)."). No immediate action needed.";
                $rec_class = "alert-success";
                $trend_icon = "fa-check-circle";
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("include/css.php"); ?>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <style>
        .volume-warning { background: #ff5722; color: white; padding: 10px; border-radius: 8px; animation: pulse-red 2s infinite; }
        @keyframes pulse-red { 0% { box-shadow: 0 0 0 0 rgba(255, 87, 34, 0.7); } 70% { box-shadow: 0 0 0 10px rgba(255, 87, 34, 0); } 100% { box-shadow: 0 0 0 0 rgba(255, 87, 34, 0); } }
        .stat-card { text-align: center; padding: 15px; border-radius: 10px; margin-bottom: 15px; font-weight: bold; }
        .rec-box { border-left: 5px solid; padding: 15px; margin-bottom: 20px; }
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
                            <div class="pull-left"><div class="page-title">Gym Intelligence & Performance Dashboard</div></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-9">
                            <div class="card card-box">
                                <div class="card-body">
                                    <form method="GET" action="" class="form-inline">
                                        <select name="mem_name" class="form-control mr-2">
                                            <option value="">-- Select Member --</option>
                                            <?php
                                                $m_list = $db->query("SELECT DISTINCT mem_name FROM gym_logs ORDER BY mem_name ASC");
                                                while($m_row = $m_list->fetch()) {
                                                    $sel = ($filter_mem == $m_row['mem_name']) ? 'selected' : '';
                                                    echo "<option value='".$m_row['mem_name']."' $sel>".$m_row['mem_name']."</option>";
                                                }
                                            ?>
                                        </select>
                                        <input type="date" name="from_date" class="form-control mr-2" value="<?php echo $from_date; ?>">
                                        <input type="date" name="to_date" class="form-control mr-2" value="<?php echo $to_date; ?>">
                                        <button type="submit" class="btn btn-primary">Analyze</button>
                                        <a href="gym_pro_intelligence.php" class="btn btn-default ml-1">Reset</a>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <?php
                                $vol_count = $db->query("SELECT COUNT(*) FROM gym_logs WHERE CAST(exercise_count AS UNSIGNED) < 15 OR CAST(exercise_count AS UNSIGNED) > 30")->fetchColumn();
                            ?>
                            <div class="stat-card <?php echo ($vol_count > 0) ? 'volume-warning' : 'bg-success text-white'; ?>">
                                <i class="fa fa-bell"></i> Alerts: <?php echo $vol_count; ?> Outside Range
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert <?php echo $rec_class; ?> rec-box">
                                <i class="fa <?php echo $trend_icon; ?> fa-2x pull-left mr-3"></i>
                                <h4 class="mt-0">System Recommendation</h4>
                                <p class="mb-0"><?php echo $recommendation; ?></p>
                            </div>
                        </div>
                    </div>

                    <?php
                        // DATA GATHERING
                        $dateActivity = [];
                        $intensityGroups = ['Low (<15)' => 0, 'Target (15-30)' => 0, 'High (>30)' => 0];
                        $exercisePop = [];
                        
                        $sql = "SELECT * FROM gym_logs WHERE 1=1";
                        if($filter_mem != '') $sql .= " AND mem_name = :mname";
                        if($from_date != '') $sql .= " AND log_date >= :f_d";
                        if($to_date != '')   $sql .= " AND log_date <= :t_d";
                        $sql .= " ORDER BY log_date ASC";
                        
                        $res = $db->prepare($sql);
                        if($filter_mem != '') $res->bindParam(':mname', $filter_mem);
                        if($from_date != '') $res->bindParam(':f_d', $from_date);
                        if($to_date != '')   $res->bindParam(':t_d', $to_date);
                        $res->execute();
                        
                        while($row = $res->fetch()) {
                            $d = date("d-M", strtotime($row['log_date']));
                            $cnt = (int)$row['exercise_count'];
                            $ex = $row['exercise_name'];

                            $dateActivity[$d] = ($dateActivity[$d] ?? 0) + $cnt;
                            $exercisePop[$ex] = ($exercisePop[$ex] ?? 0) + 1;

                            if($cnt < 15) $intensityGroups['Low (<15)']++;
                            elseif($cnt > 30) $intensityGroups['High (>30)']++;
                            else $intensityGroups['Target (15-30)']++;
                        }
                    ?>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="card card-box"><div class="card-head"><header>Intensity Pie</header></div>
                            <div class="card-body"><div id="pie_chart" style="height: 250px;"></div></div></div>
                        </div>
                        <div class="col-md-4">
                            <div class="card card-box"><div class="card-head"><header>Daily Total Volume</header></div>
                            <div class="card-body"><div id="bar_chart" style="height: 250px;"></div></div></div>
                        </div>
                        <div class="col-md-4">
                            <div class="card card-box"><div class="card-head"><header>Top Exercises</header></div>
                            <div class="card-body"><div id="ex_chart" style="height: 250px;"></div></div></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-box"><div class="card-head"><header>Volume Trend & Prediction</header></div>
                            <div class="card-body"><div id="line_chart" style="height: 350px;"></div></div></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <?php include("include/js.php") ?>
    
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawAll);

        function drawAll() {
            // Pie
            var pData = google.visualization.arrayToDataTable([
                ['Type', 'Count'], <?php foreach($intensityGroups as $k=>$v) echo "['$k',$v],"; ?>
            ]);
            new google.visualization.PieChart(document.getElementById('pie_chart')).draw(pData, {is3D:true, colors:['#f1c40f','#27ae60','#e74c3c'], legend:'bottom'});

            // Bar
            var bData = google.visualization.arrayToDataTable([
                ['Date', 'Volume', {role:'style'}],
                <?php $i=0; foreach($dateActivity as $d=>$v){ echo "['$d',$v,'#3498db'],"; } ?>
            ]);
            new google.visualization.ColumnChart(document.getElementById('bar_chart')).draw(bData, {legend:'none'});

            // Horizontal
            var hData = google.visualization.arrayToDataTable([
                ['Ex', 'Freq'], <?php foreach($exercisePop as $k=>$v) echo "['$k',$v],"; ?>
            ]);
            new google.visualization.BarChart(document.getElementById('ex_chart')).draw(hData, {legend:'none', colors:['#9b59b6']});

            // Line with Trendline
            var lData = google.visualization.arrayToDataTable([
                ['Date', 'Volume'], <?php foreach($dateActivity as $d=>$v) echo "['$d',$v],"; ?>
            ]);
            new google.visualization.LineChart(document.getElementById('line_chart')).draw(lData, {
                curveType:'function', pointSize:10,
                trendlines: { 0: { type: 'linear', color: '#333', opacity: 0.2, labelInLegend: 'Trend' } },
                vAxis: { title: 'Exercise Count' },
                hAxis: { title: 'Timeline' }
            });
        }
    </script>
</body>
</html>