<?php 
include("includes/connection.php");
include("includes/session_check.php");

date_default_timezone_set("Asia/Kolkata");

    //Get file name
$currentFile = $_SERVER["SCRIPT_NAME"];
$parts = Explode('/', $currentFile);
$currentFile = $parts[count($parts) - 1];

$requestUrl = $_SERVER["REQUEST_URI"];
$urlparts = Explode('/', $requestUrl);
$redirectUrl = $urlparts[count($urlparts) - 1];

$mysqli->set_charset("utf8mb4");      

?>

<!DOCTYPE html>
<html>
<head>
  <meta name="author" content="">
  <meta name="description" content="">
  <meta http-equiv="Content-Type"content="text/html;charset=UTF-8"/>
  <meta name="viewport"content="width=device-width, initial-scale=1.0">
  <title> <?php if(isset($page_title)){ echo $page_title.' | '.APP_NAME; }else{ echo APP_NAME; } ?></title>
  <link rel="icon" href="images/<?php echo APP_LOGO;?>" sizes="16x16">
  <link rel="stylesheet" type="text/css" href="assets/css/vendor.css">
  <link rel="stylesheet" type="text/css" href="assets/css/flat-admin.css">

  <!-- Theme -->
  <link rel="stylesheet" type="text/css" href="assets/css/theme/blue-sky.css">
  <link rel="stylesheet" type="text/css" href="assets/css/theme/blue.css">
  <link rel="stylesheet" type="text/css" href="assets/css/theme/red.css">
  <link rel="stylesheet" type="text/css" href="assets/css/theme/yellow.css">

  <link rel="stylesheet" type="text/css" href="assets/sweetalert/sweetalert.css">

  <script src="assets/ckeditor/ckeditor.js"></script>

  <?php 
  if(!empty($css_files)){
    foreach ($css_files as $key => $value) {
      echo '<link rel="stylesheet" type="text/css" href="'.$value.'">';
    }
  }

  if(!empty($js_files)){
    foreach ($js_files as $key => $value) {
      echo '<script type="text/javascript" src="'.$value.'"></script>';
    }

  }
  ?>

  <style type="text/css">
    .btn_edit, .btn_delete, .btn_cust{
      padding: 5px 10px !important;
      font-size: 12px !important; 
    }

    /*--------- for sweet alerts --------*/
    .sweet-alert h2 {
      font-size: 24px;
      line-height: 28px;
      font-weight: 500
    }
    .sweet-alert .lead{
      font-size: 18px; 
      font-weight: 400
    }
    .sweet-alert .btn{
      min-width: 70px !important;
      padding: 8px 12px !important;
      border: 0 !important;
      height: auto !important;
      margin: 0px 3px !important;
      box-shadow: none !important;
      font-size: 15px;
    }
    .sweet-alert .sa-icon {
      margin: 0 auto 15px auto !important;
    }

    .social_img{
      width: 20px !important;
      height: 20px !important;
      position: absolute;
      top: -11px;
      z-index: 1;
      left: 40px;
      margin:5px;
    }

    .control-label-help{
      color: red !important;
    }

    .dropdown-li{
      margin-bottom: 0px !important;
    }
    .cust-dropdown-container{
      background: #E7EDEE;
      display: none;
    }
    .cust-dropdown{
      list-style: none;
      background: #eee;
    }
    .cust-dropdown li a{
      padding: 8px 0px;
      width: 100%;
      display: block;
      color: #444;
      float: left;
      text-decoration: none;
      transition: all linear 0.2s;
      font-weight: 500;
    }
    .cust-dropdown li a:hover{
      color: #e91e63;
    }

    .cust-dropdown li a.active{
      color: #e91e63;
    }

    .cut-text { 
      text-overflow: ellipsis;
      overflow: hidden; 
      width: 160px; 
      white-space: nowrap;
    }

  </style>


</head>

<body>

  <div class="loader"></div>

  <div class="app app-default">
    <aside class="app-sidebar" id="sidebar">
      <div class="sidebar-header"> <a class="sidebar-brand" href="home.php"><img src="images/<?php echo APP_LOGO;?>" alt="app logo" /></a>
        <button type="button" class="sidebar-toggle"> <i class="fa fa-times"></i> </button>
      </div>
      <div class="sidebar-menu">
        <ul class="sidebar-nav">
          <li <?php if($currentFile=="home.php"){?>class="active"<?php }?>> <a href="home.php">
            <div class="icon"> <i class="fa fa-dashboard" aria-hidden="true"></i> </div>
            <div class="title">Dashboard</div>
          </a> 
        </li>
        <li <?php if($currentFile=="manage_category.php" or $currentFile=="add_category.php"){?>class="active"<?php }?>> <a href="manage_category.php">
          <div class="icon"> <i class="fa fa-sitemap" aria-hidden="true"></i> </div>
          <div class="title">Categories</div>
        </a> 
      </li>
		  <!-- start code updated by arjann006@gmail.com 08/01/2022 -->
      <li <?php if($currentFile=="manage_sub_category.php" or $currentFile=="add_sub_category.php"){?>class="active"<?php }?>> <a href="manage_sub_category.php">
          <div class="icon"> <i class="fa fa-sitemap" aria-hidden="true"></i> </div>
          <div class="title">Sub Categories</div>
        </a> 
      </li>
		  <!-- end code updated by arjann006@gmail.com 08/01/2022 -->
      <li <?php if($currentFile=="manage_language.php" or $currentFile=="add_language.php"){?>class="active"<?php }?>> <a href="manage_language.php">
        <div class="icon"> <i class="fa fa-language" aria-hidden="true"></i> </div>
        <div class="title">Languages</div>
      </a> 
    </li>

    <li class="dropdown-li status <?php if(isset($active_page) && $active_page=="status"){ echo 'active'; }?>">
      <a href="javascript:void(0)" class="dropdown-a">
        <div class="icon"> <i class="fa fa-map-o" aria-hidden="true"></i> </div>
        <div class="title">Statuses</div>
        <i class="fa fa-angle-right pull-right" style="padding-top: 7px;color: #fff;"></i>
      </a> 
    </li>

    <li class="cust-dropdown-container">
      <ul class="cust-dropdown">
        <li> 
          <a href="manage_videos.php" <?php if($currentFile=="manage_videos.php" or $currentFile=="manage_users_videos.php" or $currentFile=="add_video.php" or $currentFile=="edit_video.php"){?>class="active"<?php }?>>
            <div class="title"><i class="fa fa-angle-right" aria-hidden="true"></i>&nbsp;Video</div>
          </a> 
        </li>

        <li>
          <a href="manage_image_status.php" <?php if($currentFile=="manage_image_status.php" or $currentFile=="manage_user_image_status.php" or $currentFile=="image_status.php"){?>class="active"<?php }?>>
            <div class="title"><i class="fa fa-angle-right"></i>&nbsp;Image</div>
          </a> 
        </li> 
        <li>
          <a href="manage_gif_status.php" <?php if($currentFile=="manage_gif_status.php" or $currentFile=="manage_user_gif_status.php" or $currentFile=="gif_status.php"){?>class="active"<?php }?>>
            <div class="title"><i class="fa fa-angle-right"></i>&nbsp;GIF</div>
          </a> 
        </li>

        <li>
          <a href="manage_quotes_status.php" <?php if($currentFile=="manage_quotes_status.php" or $currentFile=="manage_user_quotes_status.php" or $currentFile=="add_quote.php" or $currentFile=="edit_quote.php"){?>class="active"<?php }?>>
            <div class="title"><i class="fa fa-angle-right"></i>&nbsp;Text Quotes</div>
          </a> 
        </li>   
      </ul>
    </li>


    <li <?php if($currentFile=="manage_slider.php" or $currentFile=="add_slider.php" or $currentFile=="edit_slider.php"){?>class="active"<?php }?>>
      <a href="manage_slider.php">
        <div class="icon"> <i class="fa fa-sliders" aria-hidden="true"></i> </div>
        <div class="title">Home Slider</div>
      </a> 
    </li>

    <li class="dropdown-li user <?php if(isset($active_page) && $active_page=="user"){ echo 'active'; }?>">
      <a href="javascript:void(0)" class="dropdown-a">
        <div class="icon"> <i class="fa fa-users" aria-hidden="true"></i> </div>
        <div class="title">Users</div>
        <i class="fa fa-angle-right pull-right" style="padding-top: 7px;color: #fff;"></i>
      </a> 
    </li>
    <li class="cust-dropdown-container">
      <ul class="cust-dropdown">
        <li> 
          <a href="manage_users.php" <?php if($currentFile=="manage_users.php" or $currentFile=="add_user.php" or (isset($history_page) && $history_page=="user")){?>class="active"<?php }?>>
            <div class="title"><i class="fa fa-angle-right" aria-hidden="true"></i>&nbsp;Users</div>
          </a> 
        </li>

        <li>
          <a href="deleted_users.php" <?php if($currentFile=="deleted_users.php"){?>class="active"<?php }?>>
            <div class="title"><i class="fa fa-angle-right"></i>&nbsp;Deleted Users</div>
          </a> 
        </li>   
      </ul>
    </li>

    <li <?php if($currentFile=="verification_request.php"){?>class="active"<?php }?>> <a href="verification_request.php">
      <div class="icon"> <i class="fa fa-check-square-o" aria-hidden="true"></i> </div>
      <div class="title">Verification Req.</div>
    </a> 
  </li>
  <li <?php if($currentFile=="manage_transaction.php"){?>class="active"<?php }?>> <a href="manage_transaction.php">
    <div class="icon"> <i class="fa fa-list" aria-hidden="true"></i> </div>
    <div class="title">Transaction</div>
  </a> 
</li>
<li <?php if($currentFile=="manage_contact_list.php" or $currentFile=="contact_subject.php"){?>class="active"<?php }?>> <a href="manage_contact_list.php">
  <div class="icon"> <i class="fa fa-envelope" aria-hidden="true"></i> </div>
  <div class="title">Contact List</div>
</a> 
</li>
<li <?php if($currentFile=="manage_comments.php" OR $currentFile=="manage_reports.php" OR $currentFile=="view_comments.php" OR $currentFile=='view_image_comments.php' OR $currentFile=='view_quotes_comments.php' OR $currentFile=='view_reports.php' OR $currentFile=='view_quotes_reports.php' OR $currentFile=='view_image_reports.php'){?>class="active"<?php }?>>  <a href="manage_comments.php">
  <div class="icon"> <i class="fa fa-users" aria-hidden="true"></i> </div>
  <div class="title">Users Interaction</div>
</a> 
</li>
<li <?php if($currentFile=="send_notification.php"){?>class="active"<?php }?>> <a href="send_notification.php">
  <div class="icon"> <i class="fa fa-send" aria-hidden="true"></i> </div>
  <div class="title">Notification</div>
</a> 
</li>
<li <?php if($currentFile=="spinner.php" or $currentFile=="add_block.php" or $currentFile=="edit_block.php"){?>class="active"<?php }?>> <a href="spinner.php">
  <div class="icon"> <i class="fa fa-spinner" aria-hidden="true"></i> </div>
  <div class="title">Lucky Wheel</div>
</a> 
</li>

<li class="dropdown-li settings <?php if(isset($active_page) && $active_page=="settings"){ echo 'active'; }?>">
  <a href="javascript:void(0)" class="dropdown-a">
    <div class="icon"> <i class="fa fa-cog" aria-hidden="true"></i> </div>
    <div class="title">Settings</div>
    <i class="fa fa-angle-right pull-right" style="padding-top: 7px;color: #fff;"></i>
  </a> 
</li>
<li class="cust-dropdown-container">
  <ul class="cust-dropdown">
    <li> 
      <a href="rewards_points.php" <?php if($currentFile=="rewards_points.php"){?>class="active"<?php }?>>
        <div class="title"><i class="fa fa-angle-right" aria-hidden="true"></i>&nbsp;Rewards Points</div>
      </a> 
    </li>

    <li>
      <a href="smtp_settings.php" <?php if($currentFile=="smtp_settings.php"){?>class="active"<?php }?>>
        <div class="title"><i class="fa fa-angle-right"></i>&nbsp;SMTP Settings</div>
      </a> 
    </li> 
    <li>
      <a href="app_settings.php" <?php if($currentFile=="app_settings.php"){?>class="active"<?php }?>>
        <div class="title"><i class="fa fa-angle-right"></i>&nbsp;App Settings</div>
      </a> 
    </li>
    <li>
      <a href="settings.php" <?php if($currentFile=="settings.php"){?>class="active"<?php }?>>
        <div class="title"><i class="fa fa-angle-right"></i>&nbsp;General Settings</div>
      </a> 
    </li>   
  </ul>
</li>


<?php if(file_exists('verification.php')){ ?>
  <li <?php if($currentFile=="verification.php"){?>class="active"<?php }?>> <a href="verification.php">
    <div class="icon"> <i class="fa fa-check-square-o" aria-hidden="true"></i> </div>
    <div class="title">Verify Purchase</div>
  </a> 
</li>
<?php } ?>

<?php if(file_exists('api.php')){?>
  <li <?php if($currentFile=="api_urls.php"){?>class="active"<?php }?>> <a href="api_urls.php">
    <div class="icon"> <i class="fa fa-exchange" aria-hidden="true"></i> </div>
    <div class="title">API URLS</div>
  </a> 
</li> 
<?php }?>


</ul>
</div>

</aside>   
<div class="app-container">
  <nav class="navbar navbar-default" id="navbar">
    <div class="container-fluid">
      <div class="navbar-collapse collapse in">
        <ul class="nav navbar-nav navbar-mobile">
          <li>
            <button type="button" class="sidebar-toggle"> <i class="fa fa-bars"></i> </button>
          </li>
          <li class="logo"> <a class="navbar-brand" href="#"><?php echo APP_NAME;?></a> </li>
          <li>
            <button type="button" class="navbar-toggle">
              <?php if(PROFILE_IMG){?>               
                <img class="profile-img" src="images/<?php echo PROFILE_IMG;?>">
              <?php }else{?>
                <img class="profile-img" src="assets/images/profile.png">
              <?php }?>

            </button>
          </li>
        </ul>
        <ul class="nav navbar-nav navbar-left">
          <li class="navbar-title"><?php echo APP_NAME;?></li>

        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown notification danger">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <div class="icon"><i class="fa fa-bell" aria-hidden="true"></i></div>
              <div class="title">System Notifications</div>
              <div class="count notify_count"></div>
            </a>
            <div class="dropdown-menu">
              <ul>
                <li class="dropdown-header">Notification</li>
              </ul>
            </div>
          </li>
          <li class="dropdown profile"> <a href="profile.php" class="dropdown-toggle" data-toggle="dropdown"> <?php if(PROFILE_IMG){?>               
            <img class="profile-img" src="images/<?php echo PROFILE_IMG;?>">
          <?php }else{?>
            <img class="profile-img" src="assets/images/profile.png">
          <?php }?>
          <div class="title">Profile</div>
        </a>
        <div class="dropdown-menu">
          <div class="profile-info">
            <h4 class="username">Admin</h4>
          </div>
          <ul class="action">
            <li><a href="profile.php">Profile</a></li>                  
            <li><a href="logout.php">Logout</a></li>
          </ul>
        </div>
      </li>
    </ul>
  </div>
</div>
</nav>