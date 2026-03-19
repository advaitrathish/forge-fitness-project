<?php
	include("auth.php");
	include('../../connect/db.php');
	$Log_Id=$_SESSION['SESS_USER_ID'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<?php
		include("include/css.php");
	?>
</head>

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
					
					
					<br><br><br>
					
					<div class="row">
						

						<div class="col-lg-6 col-md-6 col-sm-12 col-12">
							<div class="card card-box">
								<div class="card-head">
									<header>All Complaints</header>
									
								</div>
								<div class="card-body ">
									<div class="row">
										<ul class="docListWindow small-slimscroll-style">
										<?php
											$result = $db->prepare("select * from complaints where Log_Id='$Log_Id'");
											$result->execute();
											for($i=1; $rows = $result->fetch(); $i++)
											{
												?>
											<li>
												<div class="prog-avatar">
													<img src="../photo/<?php echo $rows["photo"];?>" alt="" width="40"
														height="40">
												</div>
												<div class="details">
													<div class="title">
														<a href="#"><?php echo $rows["subjct"];?></a> <?php echo $rows["date"];?> <?php echo $rows["tm"];?> 
													</div>
													<div>
														<span class="clsAvailable"><?php echo $rows["reply"];?> </span>
													</div>
												</div>
											</li>
											<?php }?>	
										</ul>
										<div class="full-width text-center p-t-10">
											<a href="compalint_view_all.php" class="btn purple btn-outline btn-circle margin-0">View All</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<!-- start new student list -->
					
					<!-- end new student list -->
					<!--start calander , to-do & goal process -->
					
					
					
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