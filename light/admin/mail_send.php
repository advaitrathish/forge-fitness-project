
<?php
	include("auth.php");
	include('../../connect/db.php');
	$Log_Id=$_SESSION['SESS_ADMIN_ID'];
	$result = $db->prepare("select * from admin where Log_Id='$Log_Id'");
	$result->execute();
	for($i=0; $row = $result->fetch(); $i++)
	{		
		$sname=$row["name"];
		$photo=$row["photo"];
		
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
								<div class="page-title">Inbox</div>
							</div>
							<ol class="breadcrumb page-breadcrumb pull-right">
								<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item"
										href="index.php">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
								</li>
								<li><a class="parent-item" href="">Email</a>&nbsp;<i class="fa fa-angle-right"></i>
								</li>
								<li class="active">Inbox</li>
							</ol>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-body no-padding height-9">
									<div class="inbox">
										<div class="row">
											<div class="col-md-3">
												<div class="inbox-sidebar">
													<div class="d-grid gap-2">
														<a href="mail_compose.php" class="btn red" type="button"><i
																class="fa fa-edit"></i>Compose</a>
													</div>
													<ul class="inbox-nav inbox-divider">
														<li class="active"><a href="mail_inbox.php"><i
																	class="fa fa-inbox"></i> Inbox <span
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
														<div class="mail-option no-pad-left">
															
															
															<div class="btn-group pull-right btn-prev-next">
																<button class="btn btn-sm btn-primary" type="button">
																	<i class="fa fa-chevron-left"></i>
																</button>
																<button class="btn btn-sm btn-primary" type="button">
																	<i class="fa fa-chevron-right"></i>
																</button>
															</div>
															
														</div>
													</div>
													<div class="inbox-body no-pad table-responsive">
														<table class="table table-inbox table-hover">
															<tbody>
															<?php
																$result = $db->prepare("select * from  message where sname='$sname'");
																$result->execute();
																for($i=0; $rows = $result->fetch(); $i++)
																{
																	$msg_id = $rows['msg_id'];
																	?>
																<tr class="unread">
																	
																	<td>
																		<a href="#" class="avatar">
																			<img src="../photo/<?php echo $rows['photo'];?>"
																				alt="">
																		</a>
																	</td>
																	<td class="view-message  dont-show"><?php echo $rows['sname'];?></td>
																	<td class="view-message "><a
																	href="mail_view.php<?php echo '?msg_id='.$msg_id;?>"><?php echo $rows['subjt'];?></a></td>
																	
																	<td class="view-message "><?php echo $rows['tm'];?></td>
																</tr>
																<?php }?>
															</tbody>
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