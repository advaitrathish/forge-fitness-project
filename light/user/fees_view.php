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
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>

<body class="page-header-fixed sidemenu-closed-hidelogo page-content-white page-md header-white white-sidebar-color logo-indigo">
    <div class="page-wrapper">
        <?php include("include/header.php"); ?>
        <div class="page-container">
            <?php include("include/leftmenu.php"); ?>
            <br><br><br>
            <div class="page-content-wrapper">
                <div class="page-content">
                    
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-box">
                                <div class="card-head"><header>Fees Statement</header></div>
                                <div class="card-body">
                                    <div id="fees_bar_chart" style="width: 100%; height: 350px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-topline-indigo">
                                <div class="card-body">
                                    <div class="table-scrollable">
                                        <table class="table table-hover table-bordered" id="feesTable">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Member Name</th>
                                                    <th>Plan</th>
                                                    <th>Amount (₹)</th>
                                                    <th>Payment Date</th>
                                                    <th>Payment Method</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $total_revenue = 0;
                                                    $chartData = [];
                                                    
                                                    // Fetch all fee records with member details
                                                    $sql = "SELECT fees.*, members.tname, members.membership_plan 
                                                            FROM fees 
                                                            INNER JOIN members ON fees.member_id = members.id WHERE members.id = '$mem_id'
                                                            ORDER BY fees.paid_date ASC";
                                                    
                                                    $result = $db->prepare($sql);
                                                    $result->execute();
                                                    $rows = $result->fetchAll();
                                                    
                                                    foreach($rows as $key => $row) {
                                                        $total_revenue += $row['amount'];
                                                        
                                                        // Group data by Date for the chart array
                                                        $p_date = date("d-M-Y", strtotime($row['paid_date']));
                                                        $chartData[$p_date] = ($chartData[$p_date] ?? 0) + $row['amount'];
                                                ?>
                                                <tr>
                                                    <td><?php echo $key + 1; ?></td>
                                                    <td><?php echo htmlspecialchars($row['tname']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['membership_plan']); ?></td>
                                                    <td><?php echo number_format($row['amount'], 2); ?></td>
                                                    <td><?php echo $p_date; ?></td>
                                                    <td><span class="label label-sm label-success"><?php echo htmlspecialchars($row['method']); ?></span></td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                            <tfoot>
                                                <tr style="background: #eee; font-weight: bold;">
                                                    <td colspan="3" class="text-right">TOTAL REVENUE:</td>
                                                    <td colspan="3">₹ <?php echo number_format($total_revenue, 2); ?></td>
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
            // Initialize DataTable with Export Buttons
            $('#feesTable').DataTable({
                dom: 'Bfrtip',
                buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
                "order": [[ 4, "desc" ]] // Default sort by Payment Date
            });
        });

        // Google Charts Integration
        google.charts.load("current", {packages:['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var dataArray = [["Date", "Revenue", { role: "style" } ]];

            <?php if(!empty($chartData)): ?>
                <?php 
                    $colors = ['#3366cc', '#dc3912', '#ff9900', '#109618', '#990099', '#0099c6', '#dd4477'];
                    $index = 0;
                    foreach($chartData as $date => $amt) {
                        $color = $colors[$index % count($colors)];
                        echo "dataArray.push(['$date', $amt, '$color']);";
                        $index++;
                    }
                ?>
            <?php else: ?>
                // Fallback if no data is found
                dataArray.push(['No Data', 0, '#cccccc']);
            <?php endif; ?>

            var data = google.visualization.arrayToDataTable(dataArray);

            var view = new google.visualization.DataView(data);
            view.setColumns([0, 1,
                { calc: "stringify",
                  sourceColumn: 1,
                  type: "string",
                  role: "annotation" },
                2]);

            var options = {
                title: 'Fees Statement',
                bar: {groupWidth: "75%"},
                legend: { position: "none" },
                hAxis: { title: 'Payment Date' },
                vAxis: { title: 'Amount (₹)' },
                chartArea: {width: '85%', height: '70%'}
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('fees_bar_chart'));
            chart.draw(view, options);
            
            // Make chart responsive
            $(window).resize(function(){
                chart.draw(view, options);
            });
        }
    </script>
</body>
</html>