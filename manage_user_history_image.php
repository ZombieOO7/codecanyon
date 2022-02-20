<?php 
    $page_title="User's Images";
    $active_page="user";
    
    $history_page='user';
    
    include('includes/header.php'); 
    include("includes/connection.php");

    include("includes/function.php");
    include("language/language.php"); 

    $user_id=$_GET['user_id'];

    //Get User Video
    $tableName="tbl_img_status";   
    $targetpage = "manage_user_history_image.php"; 
    $limit = 12; 
    
    $query = "SELECT COUNT(*) as num FROM $tableName 
              LEFT JOIN tbl_category ON tbl_img_status.`cat_id`=tbl_category.`cid` 
              WHERE `status_type`='image' AND user_id='".$user_id."'";
    $total_pages = mysqli_fetch_array(mysqli_query($mysqli,$query));
    $total_pages = $total_pages['num'];
    
    $stages = 3;
    $page=0;
    if(isset($_GET['page'])){
      $page = mysqli_real_escape_string($mysqli,$_GET['page']);
    }
    if($page){
      $start = ($page - 1) * $limit; 
    }else{
      $start = 0; 
    } 
       

    $video_qry="SELECT tbl_category.`category_name`,tbl_img_status.* FROM tbl_img_status
                LEFT JOIN tbl_category ON tbl_img_status.`cat_id`= tbl_category.`cid` 
                WHERE `status_type`='image' AND user_id='".$user_id."'
                ORDER BY tbl_img_status.`id` DESC LIMIT $start, $limit";  

    $result=mysqli_query($mysqli,$video_qry);
?>

<div class="row">
  <?php 
    // for common history header
    require_once 'includes/header_history.php';
  ?>
  <div class="col-xs-12">
    <div class="card">
      <div class="card-header">User's Total Images</div>

        <?php 
          if(mysqli_num_rows($result) > 0)
          {
        ?>
        <br/>
        <div class="col-md-3 col-xs-12">
          <div class="checkbox" style="float: left;z-index: 1">
            <input type="checkbox" id="checkall">
            <label for="checkall">
                Select All
            </label>
          </div>
          <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle btn_delete" type="button" data-toggle="dropdown"  style="margin-top: 5px;margin-left: 10px">Action
            <span class="caret"></span></button>
            <ul class="dropdown-menu" style="right:0;left:auto;">
              <li><a href="" class="actions" data-action="enable">Enable</a></li>
              <li><a href="" class="actions" data-action="disable">Disable</a></li>
              <li><a href="" class="actions" data-action="delete">Delete !</a></li>
            </ul>
          </div>
        </div>
        <div class="clearfix"></div>     
        <div class="col-md-12 mrg-top">
          <div class="row">
            <?php 
              $i=0;
              while($row=mysqli_fetch_array($result))
              {
            ?>
            <div class="col-lg-4 col-sm-6 col-xs-12">
              <div class="block_wallpaper">
                <div class="wall_category_block">
                  <h2><?php echo $row['category_name'];?></h2>  

                    <?php if($row['featured']!="0"){?>
                       <a href="javascript:void(0)" class="toggle_btn_a" data-id="<?php echo $row['id'];?>" data-action="deactive" data-column="featured" data-toggle="tooltip" data-tooltip="Slider"><div style="color:green;"><i class="fa fa-sliders"></i></div></a> 
                    <?php }else{?>
                       <a href="javascript:void(0)" class="toggle_btn_a" data-id="<?php echo $row['id'];?>" data-action="active" data-column="featured" data-tooltip="Add to Slider"><i class="fa fa-sliders"></i></a> 
                    <?php }?>

                    <?php if($row['status']!="0"){?>
                      <a href="javascript:void(0)" class="btn_notify" data-status="<?php echo $row['id'];?>" data-uid="<?php echo $row['user_id'];?>" data-tooltip="Notify Users" style="margin-right: 8px"><i class="fa fa-bell"></i></a> 
                    <?php } ?>

                    <div class="checkbox" style="float: right;margin-top: 12px">
                      <input type="checkbox" name="post_ids[]" id="checkbox<?php echo $i;?>" value="<?php echo $row['id']; ?>" class="post_ids">
                      <label for="checkbox<?php echo $i;?>">
                      </label>
                    </div>

                </div>
                <div class="wall_image_title">
                   <p style="font-size: 16px;"><?php echo $row['image_title'];?></p>
                  <ul>
                    <?php if($row['image_layout']=='Portrait'){?>
                      <li><a href="javascript:void(0)" data-toggle="tooltip" data-tooltip="Portrait"><i class="fa fa-mobile"></i></a></li>
                    <?php }else{?>
                      <li><a href="javascript:void(0)" data-toggle="tooltip" data-tooltip="Landscape"><i class="fa fa-mobile" style="transform:rotate(90deg);"></i></a></li>
                    <?php }?>

                    <li><a href="javascript:void(0)" data-toggle="tooltip" data-tooltip="<?php echo $row['total_views'];?> Views"><i class="fa fa-eye"></i></a></li>        

                    <li><a href="image_status.php?edit_id=<?php echo $row['id'];?>&action=edit" target="_blank" data-toggle="tooltip" data-tooltip="Edit"><i class="fa fa-edit"></i></a></li>

                    <li><a href="" data-toggle="tooltip" data-tooltip="Delete" class="btn_delete_a" data-id="<?php echo $row['id'];?>"><i class="fa fa-trash"></i></a></li>

                    <?php if($row['status']!="0"){?>
                     <li><div class="row toggle_btn"><a href="javascript:void(0)" data-id="<?php echo $row['id'];?>" data-action="deactive" data-column="status" data-toggle="tooltip" data-tooltip="ENABLE"><img src="assets/images/btn_enabled.png" alt="wallpaper_1" /></a></div></li> 

                    <?php }else{?>
                    
                     <li><div class="row toggle_btn"><a href="javascript:void(0)" data-id="<?php echo $row['id'];?>" data-id="<?=$row['id']?>" data-action="active" data-column="status" data-toggle="tooltip" data-tooltip="DISABLE"><img src="assets/images/btn_disabled.png" alt="wallpaper_1" /></a></div></li> 
                
                    <?php }?>  


                  </ul>
                </div>
        
                <span>
                  <?php if($row['image_file']!=""){?>
                  <img src="images/<?php echo $row['image_file'];?>" />
                  <?php }else{?>
                  <img src="images/default_img.jpg" />
                </span>                     
                <?php }?>  
               </div>
            </div>
            <?php
            $i++;
            }
            ?>
          </div>

          <div class="pagination_item_block">
            <nav>
            <?php include("user_history_pagination.php");?>
            </nav>
          </div>
        </div>
        <?php }else{ ?>
        <div class="row mrg-top mr_bot60">
          <div class="col-md-12 text-center">
              <h3 class="text-muted">No data found!</h3>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>    
</div>
        
<?php include("includes/footer.php");?>       

<script type="text/javascript">

  $(".toggle_btn a").on("click",function(e){
    e.preventDefault();
    var _for=$(this).data("action");
    var _id=$(this).data("id");
    var _column=$(this).data("column");
    var _table='tbl_img_status';

    $.ajax({
      type:'post',
      url:'processData.php',
      dataType:'json',
      data:{id:_id,for_action:_for,column:_column,table:_table,'action':'toggle_status','status_type':'image','tbl_id':'id'},
      success:function(res){
          console.log(res);
          $(".loader").show();
          if(res.status=='1'){
            location.reload();
          }
        }
    });

  });

   $(".toggle_btn_a").on("click",function(e){
      e.preventDefault();
      var _for=$(this).data("action");
      var _id=$(this).data("id");
      var _column=$(this).data("column");
      var _table='tbl_img_status';

      $.ajax({
        type:'post',
        url:'processData.php',
        dataType:'json',
        data:{id:_id,for_action:_for,column:_column,table:_table,'action':'toggle_status','tbl_id':'id'},
        success:function(res){
            console.log(res);
            if(res.status=='1'){
              location.reload();
            }
          }
      });

  });

  
  $(".btn_notify").click(function(e){
      e.preventDefault();
      var _id=$(this).data("status");
      var _uid=$(this).data("uid");

      swal({
          title: "Are you sure?",
          text: "Notification will be send to your followers.",
          input: 'text',
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: "btn-danger btn_edit",
          cancelButtonClass: "btn-warning btn_edit",
          confirmButtonText: "Yes",
          cancelButtonText: "No",
          closeOnConfirm: false,
          closeOnCancel: false,
          showLoaderOnConfirm: true
        },

        function(isConfirm) {
          if (isConfirm) {
            $.ajax({
              type:'post',
              url:'processData.php',
              dataType:'json',
              data:{id:_id,uid:_uid,'action':'notify_users','status_type':'image'},
              success:function(res){
                  console.log(res);
                  if(res.status=='1'){
                    swal({
                        title: "Send", 
                        text: "Notification has been sent to your followers..", 
                        type: "success"
                    },function() {
                    });
                  }
                }
            });
          }
          else{
            swal.close();
          }

        });
  });

  $(".actions").click(function(e){
      e.preventDefault();

      var _ids = $.map($('.post_ids:checked'), function(c){return c.value; });
      var _action=$(this).data("action");

      if(_ids!='')
      {
        swal({
          title: "Do you really want to perform?",
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: "btn-danger btn_edit",
          cancelButtonClass: "btn-warning btn_edit",
          confirmButtonText: "Yes",
          cancelButtonText: "No",
          closeOnConfirm: false,
          closeOnCancel: false,
          showLoaderOnConfirm: true
        },
        function(isConfirm) {
          if (isConfirm) {

            var _table='tbl_img_status';

            $.ajax({
              type:'post',
              url:'processData.php',
              dataType:'json',
              data:{id:_ids,for_action:_action,table:_table,'action':'multi_action','status_type':'image'},
              success:function(res){
                  console.log(res);
                  if(res.status=='1'){
                    swal({
                        title: "Successfully", 
                        text: "You have successfully done", 
                        type: "success"
                    },function() {
                        location.reload();
                    });
                  }
                }
            });
          }
          else{
            swal.close();
          }

        });
      }
      else{
        swal("Sorry no image selected !!")
      }
  });


  $(".btn_delete_a").click(function(e){

    e.preventDefault();

    var _id=$(this).data("id");

    swal({
        title: "Are you sure?",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger btn_edit",
        cancelButtonClass: "btn-warning btn_edit",
        confirmButtonText: "Yes",
        cancelButtonText: "No",
        closeOnConfirm: false,
        closeOnCancel: false,
        showLoaderOnConfirm: true
      },
      function(isConfirm) {
        if (isConfirm) {

          $.ajax({
            type:'post',
            url:'processData.php',
            dataType:'json',
            data:{id:_id,'action':'delete_img_status'},
            success:function(res){
                console.log(res);
                if(res.status=='1'){
                  swal({
                      title: "Successfully", 
                      text: "Image status is deleted...", 
                      type: "success"
                  },function() {
                      location.reload();
                  });
                }
              }
          });
        }
        else{
          swal.close();
        }
    });
  });

</script>

<?php if(isset($_SESSION['msg'])){?>
  <div class="row">
    <div class="col-md-12">
      <div class="col-md-12 col-sm-12">
          <script type="text/javascript">
            $('.notifyjs-corner').empty();
            $.notify(
              '<?php echo $client_lang[$_SESSION['msg']] ; ?>',
              { position:"top center",className: 'success'}
            );
          </script>
      </div>
    </div>
  </div>
<?php unset($_SESSION['msg']);}?>