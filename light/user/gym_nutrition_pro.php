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

    // --- AI NUTRITION & MOTIVATION LOGIC ---
    $diet_title = "Select Member";
    $macros = ['P' => 33, 'C' => 33, 'F' => 34]; // Default
    $food_list = [];
    $video_url = "https://www.youtube.com/embed/n98B_9_L9M0"; 
    $rec_color = "secondary";

    if($filter_mem != '') {
        $stmt = $db->prepare("SELECT AVG(CAST(exercise_count AS UNSIGNED)) as avg_v FROM gym_logs WHERE mem_name = :mname");
        $stmt->execute([':mname' => $filter_mem]);
        $avg_vol = $stmt->fetchColumn();

        if ($avg_vol < 15) {
            // LOW VOLUME: Focus on Fat Loss & Metabolism
            $diet_title = "Metabolic Reset Plan";
            $macros = ['P' => 50, 'C' => 20, 'F' => 30]; 
            $food_list = ["Egg Whites", "Grilled Chicken", "Spinach", "Green Tea", "Almonds"];
            $video_url = "https://www.youtube.com/embed/ZXsQAXx_ao0"; 
            $rec_color = "danger";
        } elseif ($avg_vol > 30) {
            // HIGH VOLUME: Focus on Muscle Recovery & Carbs
            $diet_title = "Anabolic Recovery Plan";
            $macros = ['P' => 30, 'C' => 50, 'F' => 20];
            $food_list = ["Oats", "Sweet Potato", "Whey Protein", "Bananas", "Peanut Butter"];
            $video_url = "https://www.youtube.com/embed/1_fHeNfS3_I";
            $rec_color = "info";
        } else {
            // STABLE: Balanced Maintenance
            $diet_title = "Lean Muscle Maintenance";
            $macros = ['P' => 40, 'C' => 40, 'F' => 20];
            $food_list = ["Brown Rice", "Salmon", "Avocado", "Quinoa", "Greek Yogurt"];
            $video_url = "https://www.youtube.com/embed/mK9m8f_O748";
            $rec_color = "success";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("include/css.php"); ?>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <style>
        .video-container { position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: 8px; }
        .video-container iframe { position: absolute; top: 0; left: 0; width: 100%; height: 100%; }
        .food-item { border-left: 3px solid #4CAF50; padding: 5px 10px; margin-bottom: 5px; background: #f4f4f4; border-radius: 0 5px 5px 0; }
        .macro-badge { font-size: 1.1em; padding: 8px; border-radius: 5px; color: white; display: inline-block; width: 30%; text-align: center; }
    </style>
</head>

<body class="page-header-fixed sidemenu-closed-hidelogo page-content-white page-md header-white white-sidebar-color logo-indigo">
    <div class="page-wrapper">
        <?php include("include/header.php"); ?>
        <div class="page-container">
            <?php include("include/leftmenu.php"); ?>
            <div class="page-content-wrapper">
                <div class="page-content">
                    <br><br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-box">
                                <div class="card-body">
                                    <h3 class="mr-3">Intelligence Center:</h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if($filter_mem != ''): ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-box border-<?php echo $rec_color; ?>">
                                <div class="card-head"><header>Recommended Training</header></div>
                                <div class="card-body">
                                    <div class="video-container">
                                        <iframe src="<?php echo $video_url; ?>" frameborder="0" allowfullscreen></iframe>
                                    </div>
                                    <h4 class="mt-3"><?php echo $filter_mem; ?>'s Coaching:</h4>
                                    <a href="https://wa.me/?text=Hi! Your new plan is ready: <?php echo $video_url; ?>" class="btn btn-success btn-block mt-2">
                                        <i class="fa fa-whatsapp"></i> WhatsApp Coaching Video
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card card-box border-<?php echo $rec_color; ?>">
                                <div class="card-head"><header>Diet & Macro Intelligence</header></div>
                                <div class="card-body">
                                    <h3 class="text-center text-primary"><?php echo $diet_title; ?></h3>
                                    
                                    <div class="text-center mb-4 mt-3">
                                        <div class="macro-badge bg-primary">Prot: <?php echo $macros['P']; ?>%</div>
                                        <div class="macro-badge bg-danger">Carb: <?php echo $macros['C']; ?>%</div>
                                        <div class="macro-badge bg-warning">Fat: <?php echo $macros['F']; ?>%</div>
                                    </div>

                                    

                                    <h5>Recommended Superfoods:</h5>
                                    <div class="row">
                                        <?php foreach($food_list as $food): ?>
                                            <div class="col-md-6"><div class="food-item"><?php echo $food; ?></div></div>
                                        <?php endforeach; ?>
                                    </div>
                                    
                                    <hr>
                                    <a href="https://amazon.com/s?k=whey+protein+isolate" target="_blank" class="btn btn-block btn-outline-info">
                                        <i class="fa fa-shopping-cart"></i> Buy Recommended Supplements
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="card card-box">
                                <div class="card-body"><div id="line_chart" style="height: 300px;"></div></div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card card-box">
                                <div class="card-body">
                                    <div id="pie_chart" style="height: 300px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>

    <?php include("include/js.php") ?>
    
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawCharts);

        function drawCharts() {
            <?php
                $labels = []; $vals = []; $exs = [];
                if($filter_mem != '') {
                    $res = $db->prepare("SELECT * FROM gym_logs WHERE mem_name = :mname ORDER BY log_date ASC");
                    $res->execute([':mname' => $filter_mem]);
                    while($r = $res->fetch()){
                        $labels[] = date("d-M", strtotime($r['log_date']));
                        $vals[] = (int)$r['exercise_count'];
                        $exs[$r['exercise_name']] = ($exs[$r['exercise_name']] ?? 0) + 1;
                    }
                }
            ?>

            var lData = google.visualization.arrayToDataTable([
                ['Date', 'Volume'],
                <?php for($i=0; $i<count($labels); $i++) echo "['".$labels[$i]."', ".$vals[$i]."],"; ?>
            ]);
            new google.visualization.LineChart(document.getElementById('line_chart')).draw(lData, {curveType:'function', pointSize:8});

            var pData = google.visualization.arrayToDataTable([
                ['Ex', 'Freq'],
                <?php foreach($exs as $k=>$v) echo "['$k', $v],"; ?>
            ]);
            new google.visualization.PieChart(document.getElementById('pie_chart')).draw(pData, {is3D:true, legend:'bottom'});
        }
    </script>
</body>
</html>