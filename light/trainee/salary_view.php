<?php
    include("auth.php");
    include('../../connect/db.php');
    $Log_Id=$_SESSION['SESS_TRAINEE_ID'];
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
                            <div class="pull-left"><div class="page-title">Salary Statement</div></div>
                        </div>
                    </div>

                    

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-box">
                                <div class="card-head"><header>Date Wise Salary Statment</header></div>
                                <div class="card-body">
                                    <div id="multicolor_chart" style="width: 100%; height: 400px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-topline-indigo">
                                <div class="card-body">
                                    <div class="table-scrollable">
                                        <table class="table table-hover table-bordered" id="salaryTable">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Staff ID</th>
                                                    <th>Month</th>
                                                    <th>Amount (₹)</th>
                                                    <th>Date Paid</th>
                                                    <th>Remarks</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $total = 0;
                                                    $chartData = []; 
                                                    
                                                
                                                       $query = "SELECT * FROM salary WHERE staff_id = '$Log_Id' ORDER BY paid_date ASC";
                                                        $result = $db->prepare($query);
                                                 
                                                    $result->execute();
                                                    $rows = $result->fetchAll();
                                                    
                                                    foreach($rows as $key => $row) {
                                                        $total += $row['amount'];
                                                        $p_date = $row['paid_date'];
                                                        $chartData[$p_date] = ($chartData[$p_date] ?? 0) + $row['amount'];
                                                ?>
                                                <tr>
                                                    <td><?php echo $key+1; ?></td>
                                                    <td>S-<?php echo $row['staff_id']; ?></td>
                                                    <td><?php echo $row['salary_month']; ?></td>
                                                    <td><?php echo number_format($row['amount'], 2); ?></td>
                                                    <td><?php echo $row['paid_date']; ?></td>
                                                    <td><?php echo $row['remarks']; ?></td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                            <tfoot>
                                                <tr style="background: #eee; font-weight: bold;">
                                                    <td colspan="3" class="text-right">SUB TOTAL:</td>
                                                    <td colspan="3">₹ <?php echo number_format($total, 2); ?></td>
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
            $('#salaryTable').DataTable({
                dom: 'Bfrtip',
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
                "order": [[ 4, "desc" ]]
            });
        });

        google.charts.load("current", {packages:['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ["Date", "Amount", { role: "style" } ],
                <?php 
                    ksort($chartData);
                    // Array of colors to cycle through
                    $colors = ['#b87333', 'silver', 'gold', '#e5e4e2', '#6673fc', '#4caf50', '#f44336', '#ff9800'];
                    $c_index = 0;

                    foreach($chartData as $date => $amount) {
                        $color = $colors[$c_index % count($colors)];
                        echo "['$date', $amount, '$color'],";
                        $c_index++;
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
                title: "Salary Payments by Date",
                bar: {groupWidth: "70%"},
                legend: { position: "none" },
                hAxis: { title: 'Payment Date' },
                vAxis: { title: 'Amount (₹)' },
                chartArea: {width: '85%', height: '70%'}
            };
            var chart = new google.visualization.ColumnChart(document.getElementById("multicolor_chart"));
            chart.draw(view, options);
        }
    </script>
</body>
</html>