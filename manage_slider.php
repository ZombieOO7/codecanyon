<?php 
  
  $page_title="Manage Sliders";

  include("includes/header.php");
  require("includes/function.php");
  require("language/language.php");

  $tableName="tbl_slider";   
  $targetpage = "manage_slider.php"; 
  $limit = 12; 

  $query = "SELECT COUNT(*) as num FROM $tableName";

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

  $sql_query="SELECT * FROM tbl_slider WHERE `slider_title` LIKE '%$keyword%' ORDER BY tbl_slider.`id` DESC LIMIT $start, $limit";

  $result=mysqli_query($mysqli,$sql_query) or die(mysqli_error($mysqli));

  // paramater wise info
  function get_single_info($post_id,$param,$type='video')
  {
    global $mysqli;

    switch ($type) {
      case 'video':
        $query="SELECT * FROM tbl_video WHERE `id`='$post_id'";
        break;

      case 'image':
        $query="SELECT * FROM tbl_img_status WHERE `id`='$post_id'";
        break;

      case 'gif':
        $query="SELECT * FROM tbl_img_status WHERE `id`='$post_id'";
        break;

      case 'quote':
        $query="SELECT * FROM tbl_quotes WHERE `id`='$post_id'";
        break;
      
      default:
        $query="SELECT * FROM tbl_video WHERE `id`='$post_id'";
        break;
    }

    $sql = mysqli_query($mysqli,$query)or die(mysqli_error());
    $row=mysqli_fetch_assoc($sql);

    return stripslashes($row[$param]);
  } 
   
?>

<!-- For Font Family -->
<link rel="stylesheet" type="text/css" href="assets/css/quotes_fonts.css">
<!-- End -->

<style type="text/css">
  .quotes_holder{
      color: #fff;
      padding: 80px 10px;
      text-align: center;
      font-size: 16px;
  }
</style>
                
<div class="row">
  <div class="col-xs-12">
    <div class="card mrg_bottom">
      <div class="page_title_block">
        <div class="col-md-5 col-xs-12">
          <div class="page_title"><?=$page_title?></div>
        </div>
        <div class="col-md-7 col-xs-12">
          <div class="search_list">
            <div class="add_btn_primary"> <a href="add_slider.php?add=yes&redirect=<?=$redirectUrl?>">Add New</a> </div>
          </div>
        </div>
      </div>
      <div class="clearfix"></div>
      <div class="col-md-12 mrg-top">
        <div class="row">
          <?php 
          $i=0;
          while($row=mysqli_fetch_array($result))
          {
            $layout='Landscape';
            switch ($row['slider_type']) {
              case 'video':
              $slider_title=get_single_info($row['post_id'],'video_title','video');
              $image=get_single_info($row['post_id'],'video_thumbnail','video');
              $layout=get_single_info($row['post_id'],'video_layout','video');
              break;

              case 'image':
              $slider_title=get_single_info($row['post_id'],'image_title','image');
              $image=get_single_info($row['post_id'],'image_file','image');
              $layout=get_single_info($row['post_id'],'image_layout','image');
              break;

              case 'gif':
              $slider_title=get_single_info($row['post_id'],'image_title','gif');
              $image=get_single_info($row['post_id'],'image_file','gif');
              $layout=get_single_info($row['post_id'],'image_layout','gif');
              break;

              default:
              $slider_title=$row['slider_title'];
              $image=$row['external_image'];
              break;
            }
            ?>
            <?php 
            if($row['slider_type']!='quote')
            {
              ?>
              <div class="col-lg-4 col-sm-6 col-xs-12">
                <div class="block_wallpaper"> 
                  <div class="wall_category_block" style="text-align: right;">
                    <div class="row" style="padding: 10px;">
                      <span class="label label-success"><?=$row['slider_type']?></span>  
                    </div>
                  </div>          
                  <div class="wall_image_title">
                    <h2><a href="javascript:void(0)"><?php echo $slider_title;?></a></h2>
                    <ul> 

                      <?php 
                      if($row['slider_type']!='external' AND $row['slider_type']!='quote')
                      {
                        if($layout=='Portrait'){
                          ?>
                          <li><a href="javascript:void(0)" data-toggle="tooltip" data-tooltip="Portrait"><i class="fa fa-mobile"></i></a></li>
                          <?php 
                        }
                        else
                        {
                          ?>
                          <li><a href="javascript:void(0)" data-toggle="tooltip" data-tooltip="Landscape"><i class="fa fa-mobile" style="transform:rotate(90deg);"></i></a></li>
                          <?php 
                        }
                      }
                      else if($row['slider_type']=='external'){
                        ?>
                        <li><a href="<?=$row['external_url']?>" target="_blank" data-toggle="tooltip" data-tooltip="URL"><i class="fa fa-link"></i></a></li>
                        <?php
                      }
                      ?>

                      <li><a href="edit_slider.php?edit_id=<?php echo $row['id'];?>&redirect=<?=$redirectUrl?>" data-toggle="tooltip" data-tooltip="Edit"><i class="fa fa-edit"></i></a></li>    

                      <li><a href="javascript:void(0)" class="btn_delete_a" data-id="<?=$row['id'];?>" data-toggle="tooltip" data-tooltip="Delete"><i class="fa fa-trash"></i></a></li>


                      <?php if($row['status']!="0"){?>
                        <li><div class="row toggle_btn"><a href="javascript:void(0)" data-id="<?php echo $row['id'];?>" data-action="deactive" data-column="status" data-toggle="tooltip" data-tooltip="ENABLE"><img src="assets/images/btn_enabled.png" alt="wallpaper_1" /></a></div></li>

                      <?php }else{?>

                        <li><div class="row toggle_btn"><a href="javascript:void(0)" data-id="<?=$row['id']?>" data-action="active" data-column="status" data-toggle="tooltip" data-tooltip="DISABLE"><img src="assets/images/btn_disabled.png" alt="wallpaper_1" /></a></div></li>

                      <?php }?>
                    </ul>
                  </div>
                  <span>
                    <img src="images/<?php echo $image;?>"/>
                  </span>

                </div>
              </div>
              <?php
            }
            else
            {
              ?>
              <div class="col-lg-4 col-sm-6 col-xs-12">
                <div class="block_wallpaper" style="height: 300px;background: #<?=get_single_info($row['post_id'],'quote_bg','quote')?>">
                  <div class="wall_category_block" style="text-align: right;z-index: 2;">
                    <div class="row" style="padding: 10px;">
                      <span class="label label-success"><?=$row['slider_type']?></span>  
                    </div>
                  </div>
                  <div class="wall_image_title">
                    <ul>

                      <li><a href="edit_slider.php?edit_id=<?php echo $row['id'];?>&redirect=<?=$redirectUrl?>" data-toggle="tooltip" data-tooltip="Edit"><i class="fa fa-edit"></i></a></li>    

                      <li><a href="javascript:void(0)" class="btn_delete_a" data-id="<?=$row['id'];?>" data-toggle="tooltip" data-tooltip="Delete"><i class="fa fa-trash"></i></a></li>   
                      

                      <?php if($row['status']!="0"){?>
                        <li><div class="row toggle_btn"><a href="javascript:void(0)" data-id="<?php echo $row['id'];?>" data-action="deactive" data-column="status" data-toggle="tooltip" data-tooltip="ENABLE"><img src="assets/images/btn_enabled.png" alt="wallpaper_1" /></a></div></li>

                      <?php }else{?>

                        <li><div class="row toggle_btn"><a href="javascript:void(0)" data-id="<?=$row['id']?>" data-action="active" data-column="status" data-toggle="tooltip" data-tooltip="DISABLE"><img src="assets/images/btn_disabled.png" alt="wallpaper_1" /></a></div></li>

                      <?php }?>
                    </ul>
                  </div>
                  <span style="overflow: hidden;height: 262px;position: absolute;width: 100%;">
                    <p class="quotes_holder" style="padding: 60px 10px;font-family: <?=pathinfo(get_single_info($row['post_id'],'quote_font','quote'), PATHINFO_FILENAME)?>">
                      <?php
                        echo stripslashes(nl2br(get_single_info($row['post_id'],'quote','quote')));
                      ?>
                    </p>
                  </span>
                </div>
              </div>
              <?php
            }
            $i++;
          }
          ?>     

        </div>
      </div>
      <div class="col-md-12 col-xs-12">
        <div class="pagination_item_block">
          <nav>
            <?php include("pagination.php");?>
          </nav>
        </div>
      </div>
      <div class="clearfix"></div>
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
    var _table='tbl_slider';

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


  $(".btn_delete_a").on("click", function(e) {

    e.preventDefault();

    var _id = $(this).data("id");
    var _table = 'tbl_slider';

    swal({
      title: "<?=$client_lang['are_you_sure_msg']?>",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn-danger",
      cancelButtonClass: "btn-warning",
      confirmButtonText: "Yes!",
      cancelButtonText: "No",
      closeOnConfirm: false,
      closeOnCancel: false,
      showLoaderOnConfirm: true
    },
    function(isConfirm) {
      if (isConfirm) {

        $.ajax({
          type: 'post',
          url: 'processData.php',
          dataType: 'json',
          data: {id: _id, for_action: 'delete', table: _table, 'action': 'multi_action'},
          success: function(res)
          {
            $('.notifyjs-corner').empty();

            if(res.status==1){
              location.reload();
            }
            else{
              swal({
                title: 'Error!', 
                text: "<?=$client_lang['something_went_worng_err']?>", 
                type: 'error'
              },function() {
                location.reload();
              });
            }
          }
        });
      } else {
        swal.close();
      }

    });
  });
</script>   
