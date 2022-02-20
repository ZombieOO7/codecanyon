<?php 
  $page_title="User's Following";
  $active_page="user";

  $history_page='user';

  include('includes/header.php'); 
	include("includes/connection.php");
	
  include("includes/function.php");
	include("language/language.php"); 
 
	$user_id=$_GET['user_id'];

  //Follower list    
  $tableName="tbl_follows";   
  $targetpage = "manage_user_history_followings.php";   
  $limit = 12; 
  
  $query = "SELECT COUNT(*) as num FROM $tableName WHERE tbl_follows.`follower_id`='$user_id'";
  $total_pages = mysqli_fetch_array(mysqli_query($mysqli,$query));
  $total_pages = $total_pages['num'];
  
  $stages = 1;
  $page=0;
  if(isset($_GET['page'])){
  $page = mysqli_real_escape_string($mysqli,$_GET['page']);
  }
  if($page){
    $start = ($page - 1) * $limit; 
  }else{
    $start = 0; 
  }

  $query_follow="SELECT * FROM tbl_follows
  WHERE tbl_follows.`follower_id`='$user_id' ORDER BY tbl_follows.`id` DESC LIMIT $start, $limit";
  $sql_follow = mysqli_query($mysqli,$query_follow)or die(mysqli_error());

  
	 
?>
 

<div class="row">
    <?php 
      // for common history header
      require_once 'includes/header_history.php';
    ?>
    <div class="col-md-12">
      <div class="card">
        <div class="page_title_block">
        <div class="col-md-5 col-xs-12">
          <div class="page_title"><?=$page_title?></div>
        </div>
        </div>
        <div class="clearfix"></div>
        <div class="row mrg-top">
        <div class="col-md-12">
          <div class="col-md-12 col-sm-12"> </div>
        </div>
        </div>
        <div class="card-body">
        <div class="row">
          <?php 
      
            $i=0;
            while($row_follow=mysqli_fetch_array($sql_follow))
            {

          ?>
          <div class="col-md-3">
            <div class="user_followings_block">
              
              <?php if(get_user_info($row_follow['user_id'],'user_image')!="") {?>
                    <img src="images/<?php echo get_user_info($row_follow['user_id'],'user_image');?>" alt="user_photo"/>
              <?php }else{?>  
                    <img src="assets/images/user_photo.png" alt="user_photo" />
              <?php } ?>  
              
              <h3><a href="manage_user_history.php?user_id=<?=$row_follow['user_id']?>&redirect=<?=$_GET['redirect']?>"><?php echo get_user_info($row_follow['user_id'],'name');?></a>
                <?php 
                  if(get_user_info($row_follow['user_id'],'is_verified')==1){
                    echo '<img src="assets/images/verification_150.png" style="border: none;width: 15px;height: 15px">';
                  }
                ?>
              </h3>
              <a href="manage_user_history.php?user_id=<?php echo $row_follow['user_id'];?>&redirect=<?=$_GET['redirect']?>" class="view_more_info">View Info</a>
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
          <div class="clearfix"></div>  
        </div>  
      </div>
    </div>    
  </div> 


<?php include('includes/footer.php');?>                  