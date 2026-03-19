<?php
    include("auth.php");
    include('../../connect/db.php');
     $Log_Id=$_SESSION['SESS_TRAINEE_ID'];
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
                            <div class="pull-left"><div class="page-title">Gym Performance Analytics</div></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-box">
                                <div class="card-body">
                                    <form method="GET" action="" class="form-inline">
                                        <div class="form-group mx-sm-3 mb-2">
                                            <label class="mr-2">Filter Member: </label>
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
                                        <a href="gym_stats_full.php" class="btn btn-default mb-2">Reset</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                        // DATA PREPARATION
                        $dateActivity = [];
                        $memberShare = [];
                        $exercisePopularity = [];
                        
                        $sql = "SELECT mem_name, exercise_name, log_date FROM gym_logs";
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
                            $ex = $row['exercise_name'];
                            $mem = $row['mem_name'];

                            $dateActivity[$d] = ($dateActivity[$d] ?? 0) + 1;
                            $memberShare[$mem] = ($memberShare[$mem] ?? 0) + 1;
                            $exercisePopularity[$ex] = ($exercisePopularity[$ex] ?? 0) + 1;
                        }
                        ksort($dateActivity);
                    ?>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="card card-box">
                                <div class="card-head"><header>Member Share</header></div>
                                <div class="card-body"><div id="pie_chart" style="height: 300px;"></div></div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card card-box">
                                <div class="card-head"><header>Daily Logs</header></div>
                                <div class="card-body"><div id="bar_chart" style="height: 300px;"></div></div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card card-box">
                                <div class="card-head"><header>Top Exercises</header></div>
                                <div class="card-body"><div id="ex_bar_chart" style="height: 300px;"></div></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-box">
                                <div class="card-head"><header>Workout Consistency Trend</header></div>
                                <div class="card-body"><div id="line_chart" style="height: 300px;"></div></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <?php include("include/js.php") ?>
    
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart', 'bar']});
        google.charts.setOnLoadCallback(drawCharts);

        function drawCharts() {
            // PIE DATA
            var pData = google.visualization.arrayToDataTable([
                ['Member', 'Logs'],
                <?php foreach($memberShare as $m => $v) echo "['$m', $v],"; ?>
            ]);

            // DAILY BAR DATA
            var bData = google.visualization.arrayToDataTable([
                ['Date', 'Sessions', { role: 'style' }],
                <?php 
                $i=0; $colors=['#3f51b5','#009688','#ffc107','#f44336'];
                foreach($dateActivity as $d => $v) {
                    echo "['$d', $v, '".$colors[$i%4]."'],"; $i++;
                }
                ?>
            ]);

            // EXERCISE NAME DATA (Horizontal Bar)
            var exData = google.visualization.arrayToDataTable([
                ['Exercise', 'Frequency'],
                <?php foreach($exercisePopularity as $ex => $v) echo "['$ex', $v],"; ?>
            ]);

            // LINE TREND DATA
            var lData = google.visualization.arrayToDataTable([
                ['Date', 'Exercise Count'],
                <?php foreach($dateActivity as $d => $v) echo "['$d', $v],"; ?>
            ]);

            // DRAWING
            new google.visualization.PieChart(document.getElementById('pie_chart')).draw(pData, {is3D:true, legend:'bottom', chartArea:{width:'90%',height:'70%'}});
            new google.visualization.ColumnChart(document.getElementById('bar_chart')).draw(bData, {legend:'none', chartArea:{width:'80%',height:'70%'}});
            new google.visualization.BarChart(document.getElementById('ex_bar_chart')).draw(exData, {legend:'none', colors:['#673ab7'], chartArea:{width:'70%',height:'80%'}});
            new google.visualization.LineChart(document.getElementById('line_chart')).draw(lData, {curveType:'function', pointSize:10, colors:['#e91e63'], chartArea:{width:'90%',height:'70%'}});
        }
    </script>
</body>
</html>