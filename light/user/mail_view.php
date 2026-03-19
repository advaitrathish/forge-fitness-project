
<?php
	include("auth.php");
	include('../../connect/db.php');
	$Log_Id=$_SESSION['SESS_USER_ID'];
	$msg_id=$_GET["msg_id"];
	$result = $db->prepare("select * from message where msg_id='$msg_id'");
	$result->execute();
	for($i=0; $row = $result->fetch(); $i++)
	{		
		$tname=$row["tname"];
		$sname=$row["sname"];
		$subjt=$row["subjt"];
		$desp=$row["desp"];
		$photo=$row["photo"];
		$file1=$row["file1"];
		$date=$row["date"];
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
	<link href="../../assets/css/pages/inbox.min.css" rel="stylesheet" type="text/css" />
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
								<div class="page-title">View Mail</div>
							</div>
							<ol class="breadcrumb page-breadcrumb pull-right">
								<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item"
										href="index.php">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
								</li>
								<li><a class="parent-item" href="">Email</a>&nbsp;<i class="fa fa-angle-right"></i>
								</li>
								<li class="active">View</li>
							</ol>
						</div>
					</div>
					<div class="inbox">
						<div class="row">
							<div class="col-md-12">
								<div class="card">
									<div class="card-body no-padding height-9">
										<div class="row">
											<div class="col-md-3">
												<div class="inbox-sidebar">
													<div class="d-grid gap-2">
														<a href="mail_compose.php" class="btn red" type="button"><i
																class="fa fa-edit"></i>Compose</a>
													</div>
													<ul class="inbox-nav inbox-divider">
														<li class="active"><a href="mail_inbox.php"><i class="fa fa-inbox"></i> Inbox
																<span
																	class="label mail-counter-style label-danger pull-right">2</span></a>
														</li>
														<li><a href="mail_send.php"><i class="fa fa-envelope"></i> Sent Mail</a>
														</li>
														
													</ul>
													
												</div>
											</div>
											<div class="col-md-9">
												<div class="inbox-body">
													<div class="inbox-header">
														<!-- <h1 class="pull-left">Inbox</h1> -->
														<div class="mail-option">
															<div class="btn-group">
																<a class="btn" href="mail_compose.php"> Reply </a>
																
															</div>
															
														</div>
													</div>
													<div class="inbox-body no-pad">
														<section class="mail-list">
															<div class="mail-sender">
																<div class="mail-heading">
																	<h4 class="vew-mail-header"><b><?php echo $subjt;?></b></h4>
																</div>
																<hr>
																<div class="media">
																	
																	<div class="media-body">
																		<span class="date pull-right"><?php echo $date;?> <?php echo $tm;?></span>
																		
																	</div>
																</div>
															</div>
															<div class="view-mail">
															<?php echo $desp;?>
															</div>
															<div class="attachment-mail">
																
																<ul>
																	
																	<li>
																		<a class="atch-thumb" href="#"> <img
																				src="../photo/<?php echo $file1;?>"
																				alt="image upload" class="doctor-pic">
																		</a> 
																		</a>
																		<div class="links">
																			<a href="../photo/<?php echo $photo;?>" target="_blank">View</a> - <a
																				href="../photo/<?php echo $file1;?>" download>Download</a>
																		</div>
																	</li>
																</ul>
															</div>
															<div class="compose-btn pull-left">
																<a href="mail_compose.php"
																	class="btn btn-sm btn-primary"><i
																		class="fa fa-reply"></i> Reply</a>
																
															</div>
														</section>
													</div>
												</div>
											</div>
										</div>
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
			include("include/footer.php");
		?>
		<!-- end footer -->
	</div>
	<!-- start js include path -->
	<?php
		include("include/js.php");
	?>
</body>

</html>