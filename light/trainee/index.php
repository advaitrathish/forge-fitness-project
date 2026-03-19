<?php
	include("auth.php");
	include('../../connect/db.php');
	$Log_Id=$_SESSION['SESS_TRAINEE_ID'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php
		include("include/css.php");
	?>
</head>
<!-- END HEAD -->

<body
	class="page-header-fixed sidemenu-closed-hidelogo page-content-white page-md header-white white-sidebar-color logo-indigo">
	<div class="page-wrapper">
    
		<!-- start header -->
		<?php
		include("include/header.php");
		?>
		<!-- end header -->
        
		
        
		<!-- start page container -->
		<div class="page-container">
        
			<!-- start sidebar menu -->
            <?php
			include("include/leftmenu.php");
			?>
			<!-- end sidebar menu -->
            
			<!-- start page content -->
			<div class="page-content-wrapper">
				<div class="page-content">
					<div class="page-bar">
						<div class="page-title-breadcrumb">
							<div class=" pull-left">
								<div class="page-title">Dashboard</div>
							</div>
							<ol class="breadcrumb page-breadcrumb pull-right">
								<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item"
										href="index.html">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
								</li>
								<li class="active">Dashboard</li>
							</ol>
						</div>
					</div>
					<!-- start widget -->
					<div class="row">
						<div class="col-xl-12">
							<div class="w-100">
								<div class="row">
									<div class="col-sm-6">
										<div class="card">
											<div class="card-body">
												<div class="row">
													<div class="col mt-0">
														<h4 class="info-box-title">Trainies</h4>
													</div>
													<div class="col-auto">
														<div class="col-danger info-icon">
															<i class="fa fa-user pull-left card-icon font-30"></i>
														</div>
													</div>
												</div>
												<h1 class="mt-1 mb-3 info-box-title">
												<?php
														$result = $db->prepare("select count(*) from trainees");
														$result->execute();
														for($i=0; $row = $result->fetch(); $i++)
														{
															echo"".$row['count(*)']."";
														}
													?>
												</h1>
											</div>
										</div>
										<div class="card">
											<div class="card-body">
												<div class="row">
													<div class="col mt-0">
														<h4 class="info-box-title">Members</h4>
													</div>
													<div class="col-auto">
														<div class="col-indigo info-icon">
															<i class="fa fa-user pull-left card-icon font-30"></i>
														</div>
													</div>
												</div>
												<h1 class="mt-1 mb-3 info-box-title">
												<?php
													$result = $db->prepare("select count(*) from members");
													$result->execute();
													for($i=0; $row = $result->fetch(); $i++)
													{
														echo"".$row['count(*)']."";
													}
												?>
												</h1>												
											</div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="card">
											<div class="card-body">
												<div class="row">
													<div class="col mt-0">
														<h4 class="info-box-title">Live</h4>
													</div>
													<div class="col-auto">
														<div class="col-teal info-icon">
															<i class="fa fa-user pull-left card-icon font-30"></i>
														</div>
													</div>
												</div>
												<h1 class="mt-1 mb-3 info-box-title">
												<?php
													$result = $db->prepare("select count(*) from gym_logs");
													$result->execute();
													for($i=0; $row = $result->fetch(); $i++)
													{
														echo"".$row['count(*)']."";
													}
												?>
												</h1>												
											</div>
										</div>
										<div class="card">
											<div class="card-body">
												<div class="row">
													<div class="col mt-0">
														<h4 class="info-box-title">Payment</h4>
													</div>
													<div class="col-auto">
														<div class="col-pink info-icon">
															<i class="fa fa-dollar pull-left card-icon font-30"></i>
														</div>
													</div>
												</div>
												<h1 class="mt-1 mb-3 info-box-title">
												<?php
													$result = $db->prepare("select count(*) from fees");
													$result->execute();
													for($i=0; $row = $result->fetch(); $i++)
													{
														echo"".$row['count(*)']."";
													}
												?>
												</h1>												
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						
					</div>

					<!-- end widget -->
					<div class="row">
						<div class="col-lg-8 col-md-12 col-sm-12 col-12">
							<div class="card card-box">
								<div class="card-head">
									<header>Complaint List</header>
									<div class="tools">
										<a class="fa fa-repeat btn-color box-refresh" href="javascript:;"></a>
										<a class="t-collapse btn-color fa fa-chevron-down" href="javascript:;"></a>
										<a class="t-close btn-color fa fa-times" href="javascript:;"></a>
									</div>
								</div>
								<div class="card-body no-padding height-9">
									
									<div class="table-responsive">
										<table
											class="table table-striped table-bordered table-hover table-checkable order-column"
											id="example4">
											<thead>
												<tr>													
													<th class="right">Name</th>
													<th class="right">Gender</th>
													<th class="right">Subject</th>
													<th class="right">Date</th>
												</tr>
											</thead>
											<tbody>
											<?php
												$result = $db->prepare("select * from  complaints limit 3");
												$result->execute();
												for($i=0; $rows = $result->fetch(); $i++)
												{
											
													?>			

												<tr class="odd gradeX">
													
													<td class="right"> <?php echo $rows['name'];?> </td>
													<td class="right">
													<?php echo $rows['sex'];?>
													</td>
													<td class="right"> <?php echo $rows['subjct'];?> </td>
													<td class="right"> <?php echo $rows['date'];?> </td>
													
												</tr>
												<?php }?>										
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-4 col-md-12 col-sm-12 col-12">
							<div class="card card-box">
								<div class="card-head">
									<header>Live Tracking List</header>
								</div>
								<div class="card-body ">
									<div class="row">
										<ul class="docListWindow small-slimscroll-style">
										<?php
											$result = $db->prepare("select * from  gym_logs order by ex_id  desc limit 2 ");
											$result->execute();
											for($i=0; $rows = $result->fetch(); $i++)
											{
										
												?>	
                                            <li>												
												<div class="details">
													<div class="title">
														<a href="#"><?php echo $rows['mem_name'];?></a> | <?php echo $rows['exercise_name'];?> 
														| TIME : <?php echo $rows['log_time'];?>
													</div>
													
													<div>
														<span class="clsAvailable">Tracking</span>
													</div>
												</div>
											</li>
                                            
										<?php }?>	
											                                            
										</ul>
										
									</div>
								</div>
							</div>
						</div>
					</div>
                    
					
                    
					
				</div>
			</div>
			<!-- end page content -->
            
		</div>
		<!-- end page container -->
		<!-- start footer -->
		<?php
			include("include/footer.php")
		?>
		<!-- end footer -->
	</div>
	<?php
		include("include/js.php")
	?>
</body>

</html>