<?php 
  $page_title="Manage Sub Categories";
  include("includes/header.php");
	include("includes/connection.php");
	
	require("includes/function.php");
	require("language/language.php");

  $tableName="tbl_sub_category";   
  $targetpage = "manage_sub_category.php"; 
  $limit = 12; 

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

  $keyword='';

  if(!isset($_GET['keyword']))
  {
    $query = "SELECT COUNT(*) as num FROM $tableName";

    $sql_query="SELECT * FROM tbl_sub_category ORDER BY tbl_sub_category.`id` DESC LIMIT $start, $limit"; 
    
  }
  else{

    $keyword=addslashes(trim($_GET['keyword']));

    $query = "SELECT COUNT(*) as num FROM $tableName WHERE `sub_category_name` LIKE '%$keyword%'";

    $targetpage = "manage_category.php?keyword=".$_GET['keyword'];

    $sql_query="SELECT * FROM tbl_sub_category WHERE `sub_category_name` LIKE '%$keyword%' ORDER BY tbl_sub_category.`id` DESC LIMIT $start, $limit"; 

  }

  $total_pages = mysqli_fetch_array(mysqli_query($mysqli,$query));
  $total_pages = $total_pages['num'];

  $result=mysqli_query($mysqli,$sql_query) or die(mysqli_error($mysqli));
?>
                
    <div class="row">
      <div class="col-xs-12">
        <div class="card mrg_bottom">
          <div class="page_title_block">
            <div class="col-md-5 col-xs-12">
              <div class="page_title"><?=$page_title?></div>
            </div>
            <div class="col-md-7 col-xs-12">
              <div class="search_list">
                <div class="search_block">
                  <form method="get" id="searchForm" action="">
                    <input class="form-control input-sm" placeholder="Search here..." aria-controls="DataTables_Table_0" type="search" name="keyword" value="<?php if(isset($_GET['keyword'])){ echo $_GET['keyword'];} ?>" required="required">
                    <button type="submit" class="btn-search"><i class="fa fa-search"></i></button>
                  </form>  
                </div>
                <div class="add_btn_primary"> <a href="add_sub_category.php?add=yes&redirect=<?=$redirectUrl?>">Add Sub Category</a> </div>
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
              ?>
              <div class="col-lg-3 col-sm-4 col-xs-12">
                <div class="block_wallpaper add_wall_category" style="background-image: linear-gradient(to right, #<?=$row['start_color']?> , #<?=$row['end_color']?>);">           
                  <div class="wall_image_title" style="word-break: break-all;">
                    <h2><a href="javascript:void(0)"><?php echo $row['sub_category_name'];?></a></h2>
                   
                    <ul> 

                      <?php if($row['show_on_home']!='0'){?>
                        <li>
                          <a href="javascript:void(0)" class="toggle_btn" data-id="<?php echo $row['id'];?>" data-action="deactive" data-column="show_on_home" data-toggle="tooltip" data-tooltip="Show Home">
                              <i class="fa fa-home" style="color: green"></i>
                            </a>
                        </li>
                      <?php }else{?>
                        <li>
                          <a href="javascript:void(0)" class="toggle_btn" data-id="<?php echo $row['id'];?>" data-action="active" data-column="show_on_home" data-toggle="tooltip" data-tooltip="Set On Home"><i class="fa fa-home"></i>
                            </a>
                        </li>
                      <?php }?>

                      <li><a href="add_sub_category.php?sub_cat_id=<?php echo $row['id'];?>&redirect=<?=$redirectUrl?>" data-toggle="tooltip" data-tooltip="Edit"><i class="fa fa-edit"></i></a></li>               
                      <li><a href="javascript:void(0)" class="btn_delete_a" data-id="<?=$row['id']?>" data-toggle="tooltip" data-tooltip="Delete"><i class="fa fa-trash"></i></a></li>
                      
                      <?php if($row['status']!="0"){?>
                      <li><div class="row toggle_btn"><a href="javascript:void(0)" data-id="<?php echo $row['id'];?>" data-action="deactive" data-column="status" data-toggle="tooltip" data-tooltip="ENABLE"><img src="assets/images/btn_enabled.png" alt="wallpaper_1" /></a></div></li>

                      <?php }else{?>
                      
                      <li><div class="row toggle_btn"><a href="javascript:void(0)" data-id="<?=$row['id']?>" data-action="active" data-column="status" data-toggle="tooltip" data-tooltip="DISABLE"><img src="assets/images/btn_disabled.png" alt="wallpaper_1" /></a></div></li>
                  
                      <?php }?>

                    </ul>
                  </div>
                  <span><img src="images/<?php echo $row['sub_category_image'];?>" style="padding-top:20px;padding-bottom:60px" /></span>
                </div>
              </div>
            <?php
              $i++;
            }
          ?>   
      </div>
      </div>
      <div class="col-md-12 col-xs-12">
        <div class="pagination_item_block">
          <nav>
            <?php include("pagination.php"); ?>
          </nav>
        </div>
      </div>
      <div class="clearfix"></div>
    </div>
  </div>
</div>
        
<?php include("includes/footer.php");?>     

<script type="text/javascript">

  $(".toggle_btn a, a.toggle_btn").on("click",function(e){
    e.preventDefault();

    var _for=$(this).data("action");
    
    var _id=$(this).data("id");
    var _column=$(this).data("column");
    var _table='tbl_sub_category';

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
    var _table = 'tbl_sub_category';

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
