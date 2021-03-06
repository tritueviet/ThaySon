
<!-- Main Header -->
<header class="main-header">
    <!-- Logo -->
    <a href="homePage.php" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>A</b>LT</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg "><i class="fa fa-home"></i><b> Home Page</b></span>
    </a>
    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Messages: style can be found in dropdown.less-->
                <li class="dropdown messages-menu">
                    <!-- Menu toggle button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-envelope-o"></i>
                        <span class="label label-success"><?php echo '' . ($numInbox == null ? 0 : $numInbox); ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">You have <?php echo '' . ($numInbox == null ? 0 : $numInbox); ?> messages</li>                                   
                        <li class="footer"><a href="inboxView.php?pageNumInbox=1">See All Messages</a></li>
                    </ul>
                </li><!-- /.messages-menu -->
                <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <!-- The user image in the navbar-->
                        <img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        <span class="hidden-xs"> <?php echo $userNameLogin->getFullName(); ?>&nbsp;&nbsp; </span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- The user image in the menu -->
                        <li class="user-header">
                            <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                            <p>
                                Hi' <?php echo $userNameLogin->getFullName(); ?>&nbsp;&nbsp; 
                                <small>Member since <?php echo $userNameLogin->getCreateTime(); ?>&nbsp;&nbsp; </small>
                            </p>
                        </li>

                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="profile.php" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">               
                                <a href="logout.php?logout" class="btn btn-default btn-flat">Sign out</a>
                            </div>
                        </li>

                    </ul>
                </li>
                <li>
                    <!--<a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>-->
                </li>
            </ul>
        </div>
    </nav>
</header>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar ">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar" >

        <!-- Sidebar user panel (optional) -->
        <!--                <div class="user-panel">
                            <div class="pull-left image">
                                <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                            </div>
                            <div class="pull-left info">
                                <p> <?php // echo $userNameLogin->getFullName();    ?>&nbsp;&nbsp; </p>
                                 Status 
                                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                            </div>
                        </div>-->
        <?php $adminRole = checkRoleAdminUsingUserId($_SESSION['user_id']);
        if ($adminRole) {
            ?>
            <!-- search form (Optional) -->
            <form action="javascript:check()" class="sidebar-form">
                <div class="input-group">
                    <input type="text" name="q" id="key" class="form-control" placeholder="Search by FacebookID..." value="">
                    <span class="input-group-btn">
                        <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
                    </span>
                </div>
            </form>
            <script>
                function check() {
                    // alert( 'Insert FB Id to Search');
                    if (!$('#key').val())
                        alert('Insert FB Id to Search');
                    else {
                        var keey = $('#key').val();
                        window.location.href = 'memberSearch.php?FacebookProfileId='.concat(keey);
                    }
                }
            </script>
            <!-- /.search form -->
        <?php } ?>
        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">MENU</li>
            <!-- Optionally, you can add icons to the links -->
            <!--<li class="active"><a href="#"><i class="fa fa-link"></i> <span>Link</span></a></li>-->
            <?php if ($adminRole) { ?>
                <li><a href="rolesView.php?pageNumRole=1"><i class="fa fa-link"></i> <span>Permission user manager</span></a></li>
            <?php } if (checkRoleQLNhom($_SESSION['user_id']) || checkRoleAdminUsingUserId($_SESSION['user_id'])) { ?>
                <li><a href="subGroup.php"><i class="fa fa-link"></i> <span>Group facebook manager</span></a></li>
            <?php } ?>
            <!--            <li class="treeview">
                            <a href="#"><i class="fa fa-link"></i> <span>Multilevel</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li><a href="#">Link in level 2</a></li>
                                <li><a href="#">Link in level 2</a></li>
                            </ul>
                        </li>-->
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
