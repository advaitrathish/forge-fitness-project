
<?php
	include("auth.php");
	include('../../connect/db.php');
	$Log_Id=$_SESSION['SESS_USER_ID'];
	$result = $db->prepare("select * from members where Log_Id='$Log_Id'");
	$result->execute();
	for($i=0; $row = $result->fetch(); $i++)
	{		
		$sname=$row["tname"];
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
								<div class="page-title">New Mail</div>
							</div>
							<ol class="breadcrumb page-breadcrumb pull-right">
								<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item"
										href="index.php">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
								</li>
								<li><a class="parent-item" href="">Email</a>&nbsp;<i class="fa fa-angle-right"></i>
								</li>
								<li class="active">Compose</li>
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
													
													<div class="inbox-body no-pad">
														<div class="mail-list">
															<div class="compose-mail">
																<form method="post" action="action/message_save.php" autocomplete="off" enctype="multipart/form-data">
																	<div class="form-group">
																		<label for="to" class="">To:</label>
																			<input list="tname" required class="form-control" name="tname" placeholder="Search" >
																				<datalist id="tname">
																				<?php
																					$result = $db->prepare("select distinct(tname) from trainees");
																					$result->execute();
																					for($i=0; $rows = $result->fetch(); $i++)
																					{
																					echo '<option>'.$rows['tname'].'</option>';
																					}
																					
																					$result = $db->prepare("select distinct(name) from admin");
																					$result->execute();
																					for($i=0; $rows = $result->fetch(); $i++)
																					{
																					echo '<option>'.$rows['name'].'</option>';
																					}
																				?>	                                    					
																				</datalist>  
																		<input type="hidden" name="sname" value="<?php echo $sname;?>">	
																		<input type="hidden" name="photo" value="<?php echo $photo;?>">	
																	</div>
																	
																	<div class="form-group">
																		<label for="subject" class="">Subject:</label>
																		<input type="text" required 
																			class="form-control" name="subjt">
																	</div>
																	<div class="form-group">
																		<label for="subject" class="">Description:</label>
																		<textarea rows="4" name="desp"
																			class="form-control" required ></textarea>
																	</div>
																	<div class="compose-editor">
																		<div id="summernote"></div>
																		<input type="file" class="default" name="file1" required >
																	</div>
																	<div class="btn-group margin-top-20 ">
																		<button
																			class="btn btn-primary btn-sm margin-right-10"><i
																				class="fa fa-check"></i> Send</button>
																		
																	</div>
																	
																</form>
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