<?php 
    $page_title="Dashboard";
    include("includes/header.php");
    include("includes/function.php");

    $sql="SELECT COUNT(*) as num FROM tbl_language";
    $total_languages= mysqli_fetch_array(mysqli_query($mysqli,$sql));
    $total_languages = $total_languages['num'];

    $qry_cat="SELECT COUNT(*) as num FROM tbl_category";
    $total_category= mysqli_fetch_array(mysqli_query($mysqli,$qry_cat));
    $total_category = $total_category['num'];

    $qry_video="SELECT COUNT(*) as num FROM tbl_video";
    $total_video = mysqli_fetch_array(mysqli_query($mysqli,$qry_video));
    $total_video = $total_video['num'];


    $qry_users="SELECT COUNT(*) as num FROM tbl_users WHERE id <> 0";
    $total_users = mysqli_fetch_array(mysqli_query($mysqli,$qry_users));
    $total_users = $total_users['num'];

    $sql_img="SELECT COUNT(*) as num FROM tbl_img_status WHERE `status_type`='image'";
    $total_img = mysqli_fetch_array(mysqli_query($mysqli,$sql_img));
    $total_img = $total_img['num'];

    $sql_gif="SELECT COUNT(*) as num FROM tbl_img_status WHERE `status_type`='gif'";
    $total_gif = mysqli_fetch_array(mysqli_query($mysqli,$sql_gif));
    $total_gif = $total_gif['num'];

    $sql_quotes="SELECT COUNT(*) as num FROM tbl_quotes";
    $total_quotes = mysqli_fetch_array(mysqli_query($mysqli,$sql_quotes));
    $total_quotes = $total_quotes['num'];

    $sql_verify="SELECT COUNT(*) as num FROM tbl_verify_user varify_u, tbl_users user WHERE varify_u.`user_id`=user.`id` AND varify_u.`status`='0' ORDER BY varify_u.`id` DESC";

    $total_verify = mysqli_fetch_array(mysqli_query($mysqli,$sql_verify));
    $total_verify = $total_verify['num'];


    $qry="SELECT * FROM tbl_settings where id='1'";
    $result=mysqli_query($mysqli,$qry);
    $settings_row=mysqli_fetch_assoc($result);


    $qry_users_paid="SELECT SUM(redeem_price) AS num FROM tbl_users_redeem
                    LEFT JOIN tbl_users ON tbl_users_redeem.`user_id`= tbl_users.`id`
                    WHERE tbl_users_redeem.`status` = 1";
                    $total_paid = mysqli_fetch_array(mysqli_query($mysqli,$qry_users_paid));
                    $total_paid = $total_paid['num'];

    $qry_users_pending="SELECT SUM(redeem_price) AS num FROM tbl_users_redeem
                  LEFT JOIN tbl_users ON tbl_users_redeem.`user_id`=tbl_users.`id`
                  WHERE tbl_users_redeem.`status`= 0";
                  $total_pending = mysqli_fetch_array(mysqli_query($mysqli,$qry_users_pending));
                  $total_pending = $total_pending['num'];


    $countStr='';

    $no_data_status=false;
    $count=$monthCount=0;

    for ($mon=1; $mon<=12; $mon++) {

        if(isset($_GET['filterByYear'])){

          $year=$_GET['filterByYear'];
          $month = date('M', mktime(0,0,0,$mon, 1, $year));
        }
        else{
          $year=date('Y');
          $month = date('M', mktime(0,0,0,$mon, 1, date('Y')));
        }

        $sql_user="SELECT `id` FROM tbl_users WHERE `registration_on` <> 0 AND DATE_FORMAT(FROM_UNIXTIME(`registration_on`), '%c') = '$mon' AND DATE_FORMAT(FROM_UNIXTIME(`registration_on`), '%Y') = '$year'";

        $totalcount=mysqli_num_rows(mysqli_query($mysqli, $sql_user));

        $verified_user="SELECT `id` FROM tbl_verify_user WHERE `verify_at` <> 0 AND `status`='1' AND DATE_FORMAT(FROM_UNIXTIME(`verify_at`), '%c') = '$mon' AND DATE_FORMAT(FROM_UNIXTIME(`verify_at`), '%Y') = '$year'";

        $verifycount=mysqli_num_rows(mysqli_query($mysqli, $verified_user));

        $suspend_user="SELECT `id` FROM tbl_suspend_account WHERE `status`='1' AND DATE_FORMAT(FROM_UNIXTIME(`suspended_on`), '%c') = '$mon' AND DATE_FORMAT(FROM_UNIXTIME(`suspended_on`), '%Y') = '$year'";

        $suspendcount=mysqli_num_rows(mysqli_query($mysqli, $suspend_user));


        $countStr.="['".$month."', ".$totalcount.", ".$verifycount.", ".$suspendcount."], ";

        if($totalcount!=0 || $verifycount!=0 || $suspendcount!=0){
          $monthCount++;
        }
    }

    if($monthCount!=0){
      $no_data_status=false;
    }
    else{
      $no_data_status=true;
    }

    $countStr=rtrim($countStr, ", ");

    function array_msort($array, $cols)
    {
        $colarr = array();
        foreach ($cols as $col => $order) {
            $colarr[$col] = array();
            foreach ($array as $k => $row) { $colarr[$col]['_'.$k] = strtolower($row[$col]); }
        }
        $eval = 'array_multisort(';
        foreach ($cols as $col => $order) {
            $eval .= '$colarr[\''.$col.'\'],'.$order.',';
        }
        $eval = substr($eval,0,-1).');';
        eval($eval);
        $ret = array();
        foreach ($colarr as $col => $arr) {
            foreach ($arr as $k => $v) {
                $k = substr($k,1);
                if (!isset($ret[$k])) $ret[$k] = $array[$k];
                $ret[$k][$col] = $array[$k][$col];
            }
        }
        return $ret;
    }
?>

<style type="text/css">
  .table > tbody, .table > tbody > tr, .table > tbody > tr > td{
    display: block !important;
  }
</style>       

<div class="row">
  <div class="clearfix"></div>
  <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12"> 
    <a href="manage_category.php" class="card card-banner card-green-light">
      <div class="card-body"> <i class="icon fa fa-sitemap fa-4x"></i>
        <div class="content">
          <div class="title">Categories</div>
          <div class="value"><span class="sign"></span><?php echo $total_category;?></div>
        </div>
      </div>
    </a> 
  </div>
  <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12"> 
    <a href="manage_videos.php" class="card card-banner card-skyeblue-light">
      <div class="card-body"> <i class="icon fa fa-film fa-4x"></i>
        <div class="content">
          <div class="title">Video Status</div>
          <div class="value"><span class="sign"></span><?php echo thousandsNumberFormat($total_video);?></div>
        </div>
      </div>
    </a> 
  </div>
  <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12"> <a href="manage_image_status.php" class="card card-banner card-alicerose-light">
    <div class="card-body"> <i class="icon fa fa-image fa-4x"></i>
    <div class="content">
      <div class="title">Image Status</div>
      <div class="value"><span class="sign"></span><?php echo thousandsNumberFormat($total_img);?></div>
    </div>
    </div>
    </a> 
  </div> 
  <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 mr_bot60"> <a href="manage_gif_status.php" class="card card-banner card-pink-light">
    <div class="card-body"> <i class="icon fa fa-spinner"></i>
    <div class="content">
      <div class="title">GIF Status</div>
      <div class="value"><span class="sign"></span><?php echo thousandsNumberFormat($total_gif);?></div>
    </div>
    </div>
    </a> 
  </div>
  <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 mr_bot60"> <a href="manage_quotes_status.php" class="card card-banner card-green-light">
    <div class="card-body"> <i class="icon fa fa-quote-right fa-4x"></i>
    <div class="content">
      <div class="title">Text Quotes Status</div>
      <div class="value"><span class="sign"></span><?php echo thousandsNumberFormat($total_quotes);?></div>
    </div>
    </div>
    </a> 
  </div>
  <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12"> 
    <a href="manage_users.php" class="card card-banner card-blue-light">
      <div class="card-body"> <i class="icon fa fa-users fa-4x"></i>
        <div class="content">
          <div class="title">Users</div>
          <div class="value"><span class="sign"></span><?php echo thousandsNumberFormat($total_users);?></div>
        </div>
      </div>
    </a> 
  </div>
  <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 mr_bot60"> 
    <a href="verification_request.php" class="card card-banner card-aliceblue-light">
      <div class="card-body"> <i class="icon fa fa-check-square-o fa-4x"></i>
        <div class="content">
          <div class="title">Verification Request</div>
          <div class="value"><span class="sign"></span><?php echo thousandsNumberFormat($total_verify);?></div>
        </div>
      </div>
    </a> 
  </div>
  <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12"> 
    <a href="manage_transaction.php" class="card card-banner card-orange-light">
      <div class="card-body"> <i class="icon fa fa-list fa-4x"></i>
        <div class="content">
          <div class="title">Paid</div>
          <div class="value"><span class="sign"></span><?php echo $total_paid ? $total_paid : '0';?> <span class="sign"><?php echo thousandsNumberFormat($settings_row['redeem_currency']);?></span></div>
        </div>
      </div>
    </a> 
  </div>
  <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 mr_bot60"> 
    <a href="manage_transaction.php" class="card card-banner card-yellow-light">
      <div class="card-body"> <i class="icon fa fa-list fa-4x"></i>
        <div class="content">
          <div class="title">Pending</div>
          <div class="value"><span class="sign"></span><?php echo $total_pending ? $total_pending : '0';?> <span class="sign"><?php echo thousandsNumberFormat($settings_row['redeem_currency']);?></span></div>
        </div>
      </div>
    </a> 
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <div class="container-fluid" style="background: #FFF;box-shadow: 0px 5px 10px 0px #CCC;border-radius: 10px;">
      <div class="col-lg-10">
        <h3>Users Analysis</h3>
      </div>
      <div class="col-lg-2" style="padding-top: 20px">
        <form method="get" id="graphFilter">
          <select class="form-control" name="filterByYear" style="box-shadow: none;height: auto;border-radius: 0px;font-size: 16px;">
            <?php 
              $currentYear=date('Y');
              $minYear=2018;

              for ($i=$currentYear; $i >= $minYear ; $i--) { 
                ?>
                <option value="<?=$i?>" <?=(isset($_GET['filterByYear']) && $_GET['filterByYear']==$i) ? 'selected' : ''?>><?=$i?></option>
                <?php
              }
            ?>
          </select>
        </form>
      </div>
      <div class="col-lg-12">
        <?php 
          if($no_data_status){
            ?>
            <h3 class="text-muted text-center" style="padding-bottom: 2em">No data found !</h3>
            <?php
          }
          else{
            ?>
            <div id="registerChart">
              <p style="text-align: center;"><i class="fa fa-spinner fa-spin" style="font-size:3em;color:#aaa;margin-bottom:50px" aria-hidden="true"></i></p>
            </div>
            <?php    
          }
        ?>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-4">
    <div class="container-fluid" style="background: #FFF;box-shadow: 0px 5px 10px 0px #CCC;border-radius: 10px;">
      <h3 style="font-size:20px;">Most viewed statuses</h3>
      <p>Statuses with more views.</p>
      <table class="table table-hover">
        <?php

          $statuses=array();

          $sql_video="SELECT id,video_title, video_thumbnail, totel_viewer FROM tbl_video WHERE `status`='1' AND `totel_viewer` > 5 ORDER BY `totel_viewer` DESC LIMIT 4";
          $res=mysqli_query($mysqli, $sql_video);

          while($row_data=mysqli_fetch_assoc($res)){
              $data['id']=$row_data['id'];
              $data['title']=$row_data['video_title'];
              $data['image']=$row_data['video_thumbnail'];
              $data['total_views']=$row_data['totel_viewer'];
              $data['status_type']='video';

              array_push($statuses, $data);
          }

          mysqli_free_result($res);

          $sql_img="SELECT id, image_title, image_file, total_views, status_type FROM tbl_img_status WHERE `status`='1' AND `total_views` > 5 ORDER BY `total_views` DESC LIMIT 4";

          $res=mysqli_query($mysqli, $sql_img);

          while($row_data=mysqli_fetch_assoc($res)){
              $data['id']=$row_data['id'];
              $data['title']=$row_data['image_title'];
              $data['image']=$row_data['image_file'];
              $data['total_views']=$row_data['total_views'];
              $data['status_type']=$row_data['status_type'];

              array_push($statuses, $data);
          }

          mysqli_free_result($res);

          $sql_img="SELECT id, quote, total_views FROM tbl_quotes WHERE `status`='1' AND `total_views` > 5 ORDER BY `total_views` DESC LIMIT 4";

          $res=mysqli_query($mysqli, $sql_img);

          while($row_data=mysqli_fetch_assoc($res)){
              $data['id']=$row_data['id'];
              $data['title']=$row_data['quote'];
              $data['image']='';
              $data['total_views']=$row_data['total_views'];
              $data['status_type']='Quote';

              array_push($statuses, $data);
          }

          mysqli_free_result($res);

          $statuses = array_msort($statuses, array('total_views'=>SORT_DESC));

          if(!empty($statuses))
          {
          foreach ($statuses as $key => $row) {

        ?>
        <tr>
          <td>
            <div style="float: left;padding-right: 20px">
              <?php if($row['status_type']!='Quote'){ ?>
                <img src="<?='images/'.$row['image']?>" style="width: 40px;height: 40px;border-radius: 50px;object-fit: cover;"/>  
              <?php }else{ ?>
                <img src="<?='images/'.APP_LOGO?>" style="width: 40px;height: 40px;border-radius: 50px;object-fit: cover;"/>  
              <?php } ?>
            </div>
            <div>
              <a href="javascript:void(0)" title="<?=$row['title']?>" style="color: inherit;">

                <p class="cut-text" style="margin-bottom: 2px;">
                  <?=$row['title'];?>
                </p>
                <p style="font-weight: 500;margin-bottom:0"><span class="label label-default" style="font-size: 10px;padding: 2px 8px;"><?=ucfirst($row['status_type'])?></span> | Views: <?=thousandsNumberFormat($row['total_views'])?></p> 
              </a>
            </div>
          </td>
        </tr>
        <?php }
        }
        else{
          ?>
          <tr>
            <td class="text-center">No data available !</td>
          </tr>
          <?php
        }
        ?>
      </table>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="container-fluid" style="background: #FFF;box-shadow: 0px 5px 10px 0px #CCC;border-radius: 10px;">
      <h3 style="font-size:20px;">Most Liked statuses</h3>
      <p>Statuses with more likes.</p>
      <table class="table table-hover">
        <?php

          $statuses=array();

          $sql_video="SELECT id,video_title, video_thumbnail, total_likes FROM tbl_video WHERE `status`='1' AND `total_likes` > 5 ORDER BY `total_likes` DESC LIMIT 4";
          $res=mysqli_query($mysqli, $sql_video);

          while($row_data=mysqli_fetch_assoc($res)){
              $data['id']=$row_data['id'];
              $data['title']=$row_data['video_title'];
              $data['image']=$row_data['video_thumbnail'];
              $data['total_likes']=$row_data['total_likes'];
              $data['status_type']='video';

              array_push($statuses, $data);
          }

          mysqli_free_result($res);

          $sql_img="SELECT id, image_title, image_file, total_likes, status_type FROM tbl_img_status WHERE `status`='1' AND `total_likes` > 5 ORDER BY `total_likes` DESC LIMIT 4";

          $res=mysqli_query($mysqli, $sql_img);

          while($row_data=mysqli_fetch_assoc($res)){
              $data['id']=$row_data['id'];
              $data['title']=$row_data['image_title'];
              $data['image']=$row_data['image_file'];
              $data['total_likes']=$row_data['total_likes'];
              $data['status_type']=$row_data['status_type'];

              array_push($statuses, $data);
          }

          mysqli_free_result($res);

          $sql_img="SELECT id, quote, total_likes FROM tbl_quotes WHERE `status`='1' AND `total_likes` > 5 ORDER BY `total_likes` DESC LIMIT 4";

          $res=mysqli_query($mysqli, $sql_img);

          while($row_data=mysqli_fetch_assoc($res)){
              $data['id']=$row_data['id'];
              $data['title']=$row_data['quote'];
              $data['image']='';
              $data['total_likes']=$row_data['total_likes'];
              $data['status_type']='Quote';

              array_push($statuses, $data);
          }

          mysqli_free_result($res);

          $statuses = array_msort($statuses, array('total_likes'=>SORT_DESC));

          if(!empty($statuses))
          {
          foreach ($statuses as $key => $row) {

        ?>
        <tr>
          <td>
            <div style="float: left;padding-right: 20px">
              <?php if($row['status_type']!='Quote'){ ?>
                <img src="<?='images/'.$row['image']?>" style="width: 40px;height: 40px;border-radius: 50px;object-fit: cover;"/>  
              <?php }else{ ?>
                <img src="<?='images/'.APP_LOGO?>" style="width: 40px;height: 40px;border-radius: 50px;object-fit: cover;"/>  
              <?php } ?>
            </div>
            <div>
              <a href="javascript:void(0)" title="<?=$row['title']?>" style="color: inherit;">
                <p class="cut-text" style="margin-bottom: 2px;">
                  <?=$row['title'];?>
                </p>
                <p style="font-weight: 500;margin-bottom:0"><span class="label label-default" style="font-size: 10px;padding: 2px 8px;"><?=ucfirst($row['status_type'])?></span> | Likes: <?=thousandsNumberFormat($row['total_likes'])?></p> 
              </a>
            </div>
          </td>
        </tr>
        <?php }
        }
        else{
          ?>
          <tr>
            <td class="text-center">No data available !</td>
          </tr>
          <?php
        }
        ?>
      </table>
    </div>
  </div>

  <div class="col-lg-4">
    <div class="container-fluid" style="background: #FFF;box-shadow: 0px 5px 10px 0px #CCC;border-radius: 10px;">
      <h3 style="font-size:20px;">Most download statuses</h3>
      <p>Statuses with more download.</p>
      <table class="table table-hover">
        <?php

          $statuses=array();

          $sql_video="SELECT id,video_title, video_thumbnail, total_download FROM tbl_video WHERE `status`='1' AND `total_download` > 5 ORDER BY `total_download` DESC LIMIT 5";
          $res=mysqli_query($mysqli, $sql_video);

          while($row_data=mysqli_fetch_assoc($res)){
              $data['id']=$row_data['id'];
              $data['title']=$row_data['video_title'];
              $data['image']=$row_data['video_thumbnail'];
              $data['total_download']=$row_data['total_download'];
              $data['status_type']='video';

              array_push($statuses, $data);
          }

          mysqli_free_result($res);

          $sql_img="SELECT id, image_title, image_file, total_download, status_type FROM tbl_img_status WHERE `status`='1' AND `total_download` > 5 ORDER BY `total_download` DESC LIMIT 5";

          $res=mysqli_query($mysqli, $sql_img);

          while($row_data=mysqli_fetch_assoc($res)){
              $data['id']=$row_data['id'];
              $data['title']=$row_data['image_title'];
              $data['image']=$row_data['image_file'];
              $data['total_download']=$row_data['total_download'];
              $data['status_type']=$row_data['status_type'];

              array_push($statuses, $data);
          }

          mysqli_free_result($res);

          $statuses = array_msort($statuses, array('total_download'=>SORT_DESC));

          if(!empty($statuses))
          {
          foreach ($statuses as $key => $row) {

        ?>
        <tr>
          <td>
            <div style="float: left;padding-right: 20px">
              <img src="<?='images/'.$row['image']?>" style="width: 40px;height: 40px;border-radius: 50px;object-fit: cover;"/> 
            </div>
            <div>
              <a href="javascript:void(0)" title="<?=$row['title']?>" style="color: inherit;">
                <p class="cut-text" style="margin-bottom: 2px;">
                  <?=$row['title'];?>
                </p>
                <p style="font-weight: 500;margin-bottom:0"><span class="label label-default" style="font-size: 10px;padding: 2px 8px;"><?=ucfirst($row['status_type'])?></span> | Downloads: <?=thousandsNumberFormat($row['total_download'])?></p> 
              </a>
            </div>
          </td>
        </tr>
        <?php }
        }
        else{
          ?>
          <tr>
            <td class="text-center">No data available !</td>
          </tr>
          <?php
        }
        ?>
      </table>
    </div>
  </div>

</div>
        
<?php include("includes/footer.php");?>

<?php 
  if(!$no_data_status){
    ?>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {packages: ['corechart', 'line']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = new google.visualization.DataTable();
        data.addColumn('string', "<?=$client_lang['months_lbl']?>");
        data.addColumn('number', "<?=$client_lang['total_users_lbl']?>");
        data.addColumn('number', "<?=$client_lang['verified_users_lbl']?>");
        data.addColumn('number', "<?=$client_lang['suspended_users_lbl']?>");

        data.addRows([<?=$countStr?>]);

        var options = {
          curveType: 'function',
          fontSize: 15,
          hAxis: {
            title: "Months of <?=(isset($_GET['filterByYear'])) ? $_GET['filterByYear'] : date('Y')?>",
            titleTextStyle: {
              color: '#000',
              bold:'true',
              italic: false
            },
          },
          vAxis: {
            title: "Nos. of Users",
            titleTextStyle: {
              color: '#000',
              bold:'true',
              italic: false,
            },
            gridlines: { count: -1},
            format: '#',
            viewWindowMode: "explicit", viewWindow: {min: 0, max: 'auto'},
          },
          height: 400,
          chartArea:{
            left:50,top:20,width:'100%',height:'auto'
          },
          legend: {
              position: 'bottom'
          },
          colors: ['#3366CC', 'green','red'],
          lineWidth:4,
          animation: {
            startup: true,
            duration: 1200,
            easing: 'out',
          },
          pointSize: 5,
          pointShape: "circle",

        };
        var chart = new google.visualization.LineChart(document.getElementById('registerChart'));

        chart.draw(data, options);
      }


      $(document).ready(function () {
          $(window).resize(function(){
              drawChart();
          });
      });
    </script>
    <?php
  }
?>
<script type="text/javascript">
    
    // filter of graph
    $("select[name='filterByYear']").on("change",function(e){
      $("#graphFilter").submit();
    });

</script>       
