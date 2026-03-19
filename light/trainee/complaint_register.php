<?php
	include("auth.php");
	include('../../connect/db.php');
	$Log_Id=$_SESSION['SESS_TRAINEE_ID'];
	$result = $db->prepare("select * from trainees where Log_Id='$Log_Id'");
	$result->execute();
	for($i=0; $row = $result->fetch(); $i++)
	{
		$mname=$row["tname"];
		$age=$row["age"];
		$sex=$row["sex"];
		$cntno=$row["cntno"];
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
								<div class="page-title">Complaint Register</div>
							</div>
							<ol class="breadcrumb page-breadcrumb pull-right">
								<li><i class="fa fa-home"></i>&nbsp;<a class="parent-item"
										href="index.php">Home</a>&nbsp;<i class="fa fa-angle-right"></i>
								</li>
								<li><a class="parent-item" href="">Page</a>&nbsp;<i class="fa fa-angle-right"></i>
								</li>
								<li class="active">Register</li>
							</ol>
						</div>
					</div>
					<div class="row">
						<div class="col-md-8">
							<!-- BEGIN PROFILE CONTENT -->
							<div class="profile-content">
								<div class="row">
									<div class="card">
										<div class="card-topline-aqua">
											<header></header>
										</div>
										<div class="white-box">
											<!--Form Start -->
											<form class="mail-compose" method="post" action="action/complaint_save.php" autcomplete="off">
													<div class="row">
														<div class="form-group col-6">
															<label class="col-form-label">Name</label>
															<div>
															<input class="form-control" type="name" value="<?php echo $mname;?>" name="name" required>
															<input type="hidden" value="<?php echo $Log_Id;?>" name="Log_Id">
															<input type="hidden" value="<?php echo $photo;?>" name="photo">
															</div>
														</div>	
														<div class="form-group col-6">
															<label class="col-form-label">Age</label>
															<div>
															<input class="form-control" type="text" value="<?php echo $age;?>"  name="age" required>
															</div>
														</div>
													</div>
													<div class="row"> 
														<div class="form-group col-6">
															<label class="col-form-label">Gender</label>
															<div>
															<input class="form-control" type="text" value="<?php echo $sex;?>"  name="sex" required>
															</div>
														</div>
														<div class="form-group col-6">
															<label class="col-form-label">Contact</label>
															<div>
															<input class="form-control" type="text" value="<?php echo $cntno;?>"  name="cntno" required>
															</div>
														</div>
													</div>	
													<div class="row">  							
														<div class="form-group col-6">
															<label class="col-form-label">Subject</label>
															<div>
															<input class="form-control" type="text"  name="subjct" required>
															</div>
														</div>
														<div class="form-group col-6">
															<label class="col-form-label">Date</label>
															<div>
															<input class="form-control" type="date" value="<?php echo date("Y-m-d");?>"  name="date" required max="<?php echo date("Y-m-d");?>">
															</div>
														</div>     
													</div>	
													<div class="row">  		
														<div class="form-group col-12">
															<label class="col-form-label">Description</label>
															<div>
																<textarea name="descp" rows="4" class="form-control" required></textarea>
															</div>							
														</div>                                     
													</div>
														<div class="form-group col-12">
															<button type="submit" class="btn btn-lg btn-primary pull-right">Send</button>
														</div>
													</form>
											<!--Form End -->
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