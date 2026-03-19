<?php
	include("auth.php");
	include('../../connect/db.php');
	$Log_Id=$_SESSION['SESS_ADMIN_ID'];
	$msg_id=$_GET['msg_id'];
	$result = $db->prepare("select * from complaints where msg_id='$msg_id'");
	$result->execute();
	for($i=0; $row = $result->fetch(); $i++)
	{
		$name=$row["name"];
		$sex=$row["sex"];
		$age=$row["age"];
		$cntno=$row["cntno"];
		$photo=$row["photo"];

		$subjct=$row["subjct"];
		$descp=$row["descp"];
		$date=$row["date"];

		$reply=$row["reply"];
		$rdate=$row["rdate"];
		$tm=$row["tm"];

	}
?>

<!DOCTYPE html>
<html lang="en">
<!-- BEGIN HEAD -->

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
								<div class="page-title">Complaints Details</div>
							</div>
							<ol class="breadcrumb page-breadcrumb pull-right">
								<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item"
										href="index.php">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
								</li>
								<li><a class="parent-item" href="">Page</a>&nbsp;<i class="fa fa-angle-right"></i>
								</li>
								<li class="active">Details</li>
							</ol>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<!-- BEGIN PROFILE SIDEBAR -->
							<div class="profile-sidebar">
								<div class="card">
									<div class="card-body no-padding height-9">
										<div class="row">
											<div class="profile-userpic">
												<img src="../photo/<?php echo $photo;?>" class="img-responsive" alt="">
											</div>
										</div>
										<div class="profile-usertitle">
											<div class="profile-usertitle-name"> <?php echo $name;?></div>
										</div>
										<ul class="list-group list-group-unbordered">
											<li class="list-group-item">
												<b>Subject</b> <a class="pull-right"> <?php echo $subjct;?></a>
											</li>
											<li class="list-group-item">
												<b>Date</b> <a class="pull-right"> <?php echo $date;?></a>
											</li>
											<li class="list-group-item">
												<b>Time</b> <a class="pull-right"> <?php echo $tm;?></a>
											</li>
										</ul>
										<!-- END SIDEBAR USER TITLE -->
										
									</div>
								</div>
								
							</div>
							<!-- END BEGIN PROFILE SIDEBAR -->
							<!-- BEGIN PROFILE CONTENT -->
							<div class="profile-content">
								<div class="row">
									<div class="card">
										<div class="card-topline-aqua">
											<header></header>
										</div>
										<div class="white-box">
											<!-- Nav tabs -->
											<div class="p-rl-20">
												<ul class="nav customtab nav-tabs" role="tablist">
													<li class="nav-item"><a href="#tab1" class="nav-link active"
															data-bs-toggle="tab">Complaints</a></li>
													<li class="nav-item"><a href="#tab2" class="nav-link"
															data-bs-toggle="tab">Reply</a></li>
												</ul>
											</div>
											<!-- Tab panes -->
											<div class="tab-content">
												<div class="tab-pane active fontawesome-demo" id="tab1">
													<div id="biography">
														<hr>
														<strong>Complaints</strong>
														<p class="m-t-30">

															<?php 
																echo $descp;
															?>
														</p>
														
														<br>
														
														
													</div>
												</div>
												<div class="tab-pane" id="tab2">
													<div class="container-fluid">
														<div class="row">
															<div class="full-width p-rl-20">
																<div class="panel">
																<?php if ($reply=="Pending"){?>
																<form method="post" action="action/complaint_send.php">
																		<input type="hidden" value="<?php echo $msg_id?>" name="msg_id">
																		<textarea class="form-control p-text-area"
																			rows="4" name="reply"
																			placeholder="Reply"></textarea>
																	
																	<footer class="panel-footer">
																		<input type="submit" value="Send"
																			class="btn btn-post pull-right">
																		
																	</footer>
																	</form>
																	<?php }?>
																</div>
															</div>
															<div class="full-width p-rl-20">
																<ul class="activity-list">
																	
																	<li>
																		
																		<div class="activity-desk">
																			<h5>
																				<span><p class="m-t-30">
																				<?php 
																					echo $reply;
																				?>
																				</p>
																				</span>
																			</h5>
																			<p class="text-muted">
																			<?php 
																					echo $rdate;
																				?>
																			</p>
																		</div>
																	</li>
																	
																
																
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- END PROFILE CONTENT -->
						</div>
					</div>
				</div>
				<!-- end page content -->
				<!-- start chat sidebar -->
				
				<!-- end chat sidebar -->
			</div>
			<!-- end page container -->
			<!-- start footer -->
			<?php
				include("include/footer.php")
			?>
			<!-- end footer -->
		</div>
	</div>
	<!-- start js include path -->
	<?php
		include("include/js.php")
	?>
	<!-- end js include path -->
</body>

</html>