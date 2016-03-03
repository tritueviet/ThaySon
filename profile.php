<!DOCTYPE html>
<?php
session_start();
require_once __DIR__ . '/host.php';
require_once $ROOT . '/dao/daoUsers.php';
require_once $ROOT . '/dao/daoRoles.php';
require_once $ROOT . '/models/users.php';
require_once $ROOT . '/models/inbox.php';
require_once $ROOT . '/dao/daoInbox.php';
require_once $ROOT . '/dao/daoGroups.php';
require_once $ROOT . '/models/groups.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
}
$res = getUserById($_SESSION['user_id']);
$listInbox = getInboxIdUseStatus($_SESSION['user_id']);
//$listGroup = (array) getListGroupsWithIdUser($_SESSION['user_id']);
//echo '---'.$listInbox;
if (isset($_POST['save'])) {
    //$uname = mysql_real_escape_string($_POST['uname']);
    $email = mysql_real_escape_string($_POST['email']);
    //$upass = (mysql_real_escape_string($_POST['pass']));
    $fullname = mysql_real_escape_string($_POST['fullname']);
    $address = mysql_real_escape_string($_POST['address']);
    $phone = (mysql_real_escape_string($_POST['phone']));
    $gender = mysql_real_escape_string($_POST['gender']);  // Storing Selected Value In Variable
    $tdate = mysql_real_escape_string($_POST['date']);
    //$date = str_replace('/', '-', $tdate);
    $user = new Users();

    //$res->setUserName($uname);
    $res->setEmail($email);
    $res->setPhoneNumber($phone);
    $res->setAddress($address);
    $res->setGender($gender);
    $res->setBirthday(date('Y-m-d', strtotime($tdate)));
    // $user->setPassword($upass);
    $res->setFullName($fullname);
    $insert = updateUsers($res);
    if ($insert != null) {
        header("Location: profile.php");
    } else {
        ?>
        <script>alert('error while registering you...');</script>
        <?php
    }
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>User Profile</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <script src="bootstrap/js/bootstrap.js" type="text/javascript"></script>
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
        <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
        <script src="plugins/jQueryUI/jquery-ui.js" type="text/javascript"></script>
        <script src="plugins/jQueryUI/jquery-ui.min.js" type="text/javascript"></script>
        <!-- Bootstrap 3.3.5 -->
        <script src="plugins/datepicker/bootstrap-datepicker.js"></script>
        <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">

        <script>
            $(function () {
                $("#datepicker").datepicker();
            });
        </script>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">

            <header class="main-header">
                <!-- Logo -->
                <a href="homePage.php" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <!--<span class="logo-mini"><b>A</b>LT</span>-->
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><i class="fa fa-home"></i><b> Admin</b></span>
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top" role="navigation">                
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <!-- Messages: style can be found in dropdown.less-->
                            <li class="dropdown messages-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-envelope-o"></i>
                                    <span class="label label-success">4</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header">You have 4 messages</li>
                                    <li class="footer"><a href="inboxView.php?pageNumInbox=1">See All Messages</a></li>
                                </ul>
                            </li>
                            <!-- Notifications: style can be found in dropdown.less -->

                            <!-- User Account: style can be found in dropdown.less -->
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                                    <span class="hidden-xs"><?php echo '' . $res->getFullName(); ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                                        <p>
                                            <?php echo '' . $res->getFullName(); ?>
                                            <small><?php echo '' . $res->getCreateTime(); ?></small>
                                        </p>
                                    </li>
                                    <!-- Menu Body -->
                                    <li class="user-body">                                     
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="profile.php" class="btn btn-default btn-flat">Profile</a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="logout.php" class="btn btn-default btn-flat">Sign out</a>
                                        </div>
                                    </li>
                                </ul>
                            </li> 
                            <li class="dropdown notifications-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">                                
                                    <span class="label label-warning"></span>
                                </a>  
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <!--             sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!--                 Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                        </div>
                        <div class="pull-left info">
                            <p><?php echo '' . $res->getFullName(); ?></p>
                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>

                </section>
                <!--/.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        User Profile
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="homePage.php"><i class="fa fa-home"></i> Home</a></li>
                        <li class="active">User profile</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-3">

                                <!-- Profile Image -->
                                <div class="box box-primary">
                                    <div class="box-body box-profile">
                                        <img class="profile-user-img img-responsive img-circle" src="dist/img/user4-128x128.jpg" alt="User profile picture">
                                        <h3 class="profile-username text-center"> <?php echo '' . $res->getFullName(); ?></h3>
                                        <p class="text-muted text-center"> Member since <?php echo '' . $res->getCreateTime(); ?></p>

                                    </div><!-- /.box-body -->
                                </div><!-- /.box -->
                            </div><!-- /.col -->
                            <div class=" col-sm-6 "> 

                                <div class="box box-primary box-header with-border" >
<!--                                    <h2 class=" center">Update Personal info</h2>-->
                                    <!--/.box-header-->  

                                    <form class="form-horizontal" role="form" method="post">
                                        <div class="box-header center">
                                            <h1 class="box-title center">Personal Information</h1>
                                            <div style="height: 10px;"></div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Full name:</label>
                                            <div class="col-lg-8">
                                                <input class="form-control" value="<?php echo $res->getFullName() ?>" type="text" name="fullname">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Phone Number:</label>
                                            <div class="col-lg-8">
                                                <input name="phone" class="form-control" value="<?php echo $res->getPhoneNumber1() ?>" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">DOB:</label>
                                            <div class="col-lg-8">
                                                <div class='input-group date' id='datepicker' data-provide="datepicker" data-date-format="dd-mm-yyyy">
                                                    <input type='text' class="form-control" name = "date" value="<?php echo $res->getBirthday() ?>"/>
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Address:</label>
                                            <div class="col-lg-8">
                                                <input class="form-control" value="<?php echo $res->getAddress1() ?>" type="text" name="address">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Gender</label>
                                            <div class="col-lg-8">
                                                <div class="ui-select">
                                                    <select id="user_time_zone" class="form-control" name="gender">
                                                        <?php
                                                        if ($res->getGender() == 1) {
                                                            echo '<option value="1" name="gen" selected>Male</option>';
                                                            echo '<option value="2" name="gen">Female</option>';
                                                        } else {
                                                            echo '<option value="1" name="gen" >Male</option>';
                                                            echo '<option value="2" name="gen" selected>Female</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                           if(checkRole($res->getUserId(), 5)){
                                        ?>
                                        <div class="form-group">
                                            <label class="col-md-5 control-label"></label>
                                            <div class="col-md-6">
                                                
                                                <button class="btn btn-primary" type="submit" name="save"><i class="fa fa-save"></i> Save</button>
<!--                                                <input class="btn btn-primary"  value="Save" type="submit" name="save">-->
                                                <span style="padding-right: 10px;"></span>
                                                <input class="btn btn-default"  type="reset" value="Cancel"/>
                                            </div
                                        </div> 
                                           <?php }?>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-3 sidebar" ></div>
                        </div><!-- /.row -->
                    </div>
                </section><!-- /.content -->
            </div><!-- /.content-wrapper -->
            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    <b>Version</b> 2.3.0
                </div>
                <strong>Copyright &copy; 2014-2015 <a href="http://almsaeedstudio.com">Almsaeed Studio</a>.</strong> All rights reserved.
            </footer>
        </div><!-- ./wrapper -->

        <!-- jQuery 2.1.4 -->
        <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
        <!-- Bootstrap 3.3.5 -->
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <!-- FastClick -->
        <script src="plugins/fastclick/fastclick.min.js"></script>
        <!-- AdminLTE App -->
        <script src="dist/js/app.min.js"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="dist/js/demo.js"></script>
    </body>
</html>
