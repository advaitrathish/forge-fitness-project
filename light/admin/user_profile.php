<?php
	include("auth.php");
	include('../../connect/db.php');
	$Log_Id=$_SESSION['SESS_ADMIN_ID'];
	$result = $db->prepare("select * from admin where Log_Id='$Log_Id'");
	$result->execute();
	for($i=0; $row = $result->fetch(); $i++)
	{
		$name=$row["name"];
		$contactno=$row["contactno"];
		$email=$row["email"];
		$username=$row["username"];
		$password=$row["password"];	
		$date=$row["date"];	
		$design=$row["design"];	
		
		$addrs=$row["addrs"];	
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
								<div class="page-title">Profile</div>
							</div>
							<ol class="breadcrumb page-breadcrumb pull-right">
								<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item"
										href="index.php">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
								</li>
								<li><a class="parent-item" href="">Profile</a>&nbsp;<i class="fa fa-angle-right"></i>
								</li>
								<li class="active">Update</li>
							</ol>
						</div>
					</div>
					<div class="row">
						<div class="col-md-8">
							<!-- BEGIN PROFILE SIDEBAR -->
							
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
											<div class="tab-content">
												
												<div class="tab-pane active" id="tab2">
													<div class="container-fluid">
														<div class="row">
                                                        
															<div class="full-width p-rl-20">
																<div class="panel">
																<form class="edit-profile m-b30" method="post" action="action/profile_update.php" enctype="multipart/form-data" autocomplete="off">
																	<div class="">
																		<div class="form-group row">
																			<div class="col-sm-10  ml-auto">
																				<h3>1. Personal Details</h3>
																			</div>
																		</div>
																		<div class="form-group row">
																			<label class="col-sm-2 col-form-label">Full Name</label>
																			<div class="col-sm-7">
																				<input class="form-control" type="text" value="<?php echo $name;?>" name="name" required pattern="[a-zA-Z]*">
																				<input type="hidden" value="<?php echo $Log_Id;?>" name="Log_Id">
																			</div>
																		</div>
																		<div class="form-group row">
																			<label class="col-sm-2 col-form-label">Designation</label>
																			<div class="col-sm-7">
																				<input class="form-control" type="text" value="<?php echo $design;?>" name="design" required>
																			</div>
																		</div>		
																		<div class="form-group row">
																			<label class="col-sm-2 col-form-label">Email</label>
																			<div class="col-sm-7">
																				<input class="form-control" type="email" value="<?php echo $email;?>" name="email">
																			</div>
																		</div>
																		<div class="form-group row">
																			<label class="col-sm-2 col-form-label">Photo</label>
																			<div class="col-sm-7">
																				<input class="form-control" type="file" name="photo">
																			</div>
																		</div>							
																		<div class="form-group row">
																			<label class="col-sm-2 col-form-label">Phone No.</label>
																			<div class="col-sm-7">
																				<input class="form-control" type="text" value="<?php echo $contactno;?>" name="contactno" required pattern="[0-9]{10,10}" maxlength="10" minlength="10">
																			</div>
																		</div>
																		
																		<div class="seperator"></div>
																		
																		<div class="form-group row">
																			<div class="col-sm-10 ml-auto">
																				<h3>2. Address</h3>
																			</div>
																		</div>
																		<div class="form-group row">
																			<label class="col-sm-2 col-form-label">Address</label>
																			<div class="col-sm-7">
																				<input class="form-control" type="text"  value="<?php echo $addrs;?>" name="addrs" required>
																			</div>
																		</div>
																	</div>
																	<div class="">
																		<div class="">
																			<div class="row">
																				<div class="col-sm-2">
																				</div>
																				<div class="col-sm-7">
																					<button type="submit" class="btn btn-primary pull-right">Save changes</button>
																					<button type="reset" class="btn btn-danger pull-right">Cancel</button>
																				</div>
																			</div>
																		</div>
																	</div>
																</form>
																<form class="edit-profile" method="post" action="action/password_update.php" autocomplete="off">
																	<div class="">
																		<div class="form-group row">
																			<div class="col-sm-10 ml-auto">
																				<h3>3. Password</h3>
																			</div>
																		</div>
																		<div class="form-group row">
																			<label class="col-sm-2 col-form-label">Current Password</label>
																			<div class="col-sm-7">
																				<input class="form-control" type="password" value="<?php echo $password;?>">
																				<input type="hidden" value="<?php echo $Log_Id;?>" name="Log_Id">
																			</div>
																		</div>
																		<div class="form-group row">
																			<label class="col-sm-2 col-form-label">New Password</label>
																			<div class="col-sm-7">
																				<input class="form-control" type="password" name="password" required>
																			</div>
																		</div>									
																	</div>
																	<div class="row">
																		<div class="col-sm-2">
																		</div>
																		<div class="col-sm-7">
																			<button type="submit" class="btn btn-primary pull-right">Save changes</button>
																			<button type="reset" class="btn btn-danger pull-right">Cancel</button>
																		</div>
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
							<!-- END PROFILE CONTENT -->
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
	</div>
	<!-- start js include path -->
	<?php
		include("include/js.php")
	?>
	<!-- end js include path -->
</body>

</html>