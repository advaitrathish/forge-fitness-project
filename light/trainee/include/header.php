
<?php
	$result = $db->prepare("select * from trainees where Log_Id='$Log_Id'");
	$result->execute();
	for($i=0; $row = $result->fetch(); $i++)
	{		
		$smessageu=$row["tname"];
		$photo=$row["photo"];	
	}
?>
<div class="page-header navbar navbar-fixed-top">
    <div class="page-header-inner ">
        <!-- logo start -->
        <div class="page-logo">
            <a href="index.php">
                <span class="logo-icon material-icons fa-rotate-45">school</span>
                <span class="logo-default">FORGE STUDIO</span> </a>
        </div>
        <!-- logo end -->
        <ul class="nav navbar-nav navbar-left in">
            <li><a href="#" class="menu-toggler sidebar-toggler"><i class="icon-menu"></i></a></li>
        </ul>
        <form class="search-form-opened" action="#" method="GET">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search..." name="query">
                <span class="input-group-btn">
                    <a href="javascript:;" class="btn submit">
                        <i class="icon-magnifier"></i>
                    </a>
                </span>
            </div>
        </form>
        <!-- start mobile menu -->
        <a class="menu-toggler responsive-toggler" data-bs-toggle="collapse" data-bs-target=".navbar-collapse">
            <span></span>
        </a>
        <!-- end mobile menu -->
        
        <!-- start header menu -->
        <div class="top-menu">
            <ul class="nav navbar-nav pull-right">
                <li><a class="fullscreen-btn"><i data-feather="maximize"></i></a></li>
                <!-- start notification dropdown -->
                
                <!-- end notification dropdown -->
                <!-- start message dropdown -->
                <li class="dropdown dropdown-extended dropdown-inbox" id="header_inbox_bar">
                    <a class="dropdown-toggle" data-bs-toggle="dropdown" data-hover="dropdown"
                        data-close-others="true">
                        <i data-feather="mail"></i>
                        <span class="badge headerBadgeColor2"> 2 </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="external">
                            <h3><span class="bold">Messages</span></h3>
                            <span class="notification-label cyan-bgcolor">New </span>
                        </li>
                        <li>
                            <ul class="dropdown-menu-list small-slimscroll-style" data-handle-color="#637283">
                            <?php
                                $result = $db->prepare("select * from  message where sname='$smessageu'");
                                $result->execute();
                                for($i=0; $rows = $result->fetch(); $i++)
                                {
                                 
                                    ?>
                                <li>
                                    <a href="mail_inbox.php">
                                        <span class="photo">
                                            <img src="../photo/<?php echo $rows['photo'];?>" class="img-circle" alt="">
                                        </span>
                                        <span class="subject">
                                            <span class="from"> <?php echo $rows['sname'];?></span>
                                            <span class="time"><?php echo $rows['date'];?> <?php echo $rows['tm'];?> </span>
                                        </span>
                                        <span class="message"> <?php echo $rows['subjt'];?> </span>
                                    </a>
                                </li>
                              <?php }?>                                
                            </ul>
                            <div class="dropdown-menu-footer">
                                <a href="mail_inbox.php"> All Messages </a>
                            </div>
                        </li>
                    </ul>
                </li>
                <!-- end message dropdown -->
                <!-- start manage user dropdown -->
                <li class="dropdown dropdown-user">
                    <a class="dropdown-toggle" data-bs-toggle="dropdown" data-hover="dropdown"
                        data-close-others="true">
                        <img alt="" class="img-circle " src="../photo/<?php echo $photo;?>" />
                        <span class="username username-hide-on-mobile"> <?php echo $smessageu;?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-default">
                        <li>
                            <a href="user_profile.php">
                                <i class="icon-user"></i> Profile </a>
                        </li>                       
                        <li>
                            <a href="../../index.php">
                                <i class="icon-logout"></i> Log Out </a>
                        </li>
                    </ul>
                </li>
                <!-- end manage user dropdown -->
                <li class="dropdown dropdown-quick-sidebar-toggler">
                    
                </li>
            </ul>
        </div>
    </div>
</div>