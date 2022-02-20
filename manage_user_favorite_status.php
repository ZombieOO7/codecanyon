<?php 
	$page_title="User's Favorite Statuses";
	$active_page="user";

	$history_page='user';

	include('includes/header.php'); 
	include("includes/connection.php");
	include("includes/function.php");
	include("language/language.php"); 

	$user_id=trim($_GET['user_id']);

	$sql="SELECT * FROM tbl_favourite WHERE `user_id`='$user_id'";
	$result=mysqli_query($mysqli, $sql);

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

      $sql = mysqli_query($mysqli,$query)or die(mysqli_error($mysqli));

      if(mysqli_num_rows($sql) > 0){
        $row=mysqli_fetch_assoc($sql);
        return stripslashes($row[$param]);  
      }
      else{
        return '-';
      } 
    }
?>

<style type="text/css">
  .morecontent span {
      display: none;
  }
  .morelink {
      display: block;
  }
</style>

<div class="row">
    <?php 
      // for common history header
      require_once 'includes/header_history.php';
    ?>
    <div class="col-xs-12">
      <div class="card">
        <div class="card-header">
          <?=$page_title?>
        </div>
        <div class="card-body no-padding">
          <table class="datatable table table-striped primary" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <tr>
                      <th>Status</th>             
                      <th>Type</th>
                      <th>Date</th>  
                   </tr>
                </tr>
            </thead>
            <tbody>
                <?php
                $i=0;
                while($row=mysqli_fetch_array($result))
                {
                  $type='';
                  $title='';

                  $video = "video";
                  $image = "image";
                  $gif = "gif";
                  $quote = "quote";
                  $activity = strtolower($row['type']);

                  if(strpos($activity, $video) !== false)
                  {
                      $type='video';
                      $title='video_title';
                  } 
                  else if(strpos($activity, $image) !== false)
                  {
                      $type='image';
                      $title='image_title';
                  } 
                  else if(strpos($activity, $gif) !== false)
                  {
                      $type='gif';
                      $title='image_title';
                  } 
                  else if(strpos($activity, $quote) !== false)
                  {
                      $type='quote';
                      $title='quote';
                  }
                  else{
                      $type='';
                  }
            ?>
            <tr>
              <td width="500">
                <span class="more">
                  <?php
                    if($type!=''){
                      echo get_single_info($row['post_id'],$title,$type);
                    }
                    else{
                      echo '#';
                    }
                  ?>
                </span>
              </td>
              <td><?php echo ucfirst($row['type']);?></td>
              <td><?=calculate_time_span($row['created_at'])?></td>
            </tr>
           <?php
            
            $i++;
            }
          ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>    
</div> 



<?php include('includes/footer.php');?>        


<script type="text/javascript">
  $(document).ready(function() {
      // Configure/customize these variables.
      var showChar = 50;  // How many characters are shown by default
      var ellipsestext = "...";
      var moretext = "Show more >";
      var lesstext = "Show less";
      

      $('.more').each(function() {
          var content = $.trim($(this).text());
          
          if(content.length > showChar) {
    
              var c = content.substr(0, showChar);
              var h = content.substr(showChar, content.length - showChar);
    
              var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent"><span>' + h + '</span><a href="" class="morelink">' + moretext + '</a></span>';
   
              $(this).html(html);
          }
   
      });
   
      $(".morelink").click(function(){
          if($(this).hasClass("less")) {
              $(this).removeClass("less");
              $(this).html(moretext);
          } else {
              $(this).addClass("less");
              $(this).html(lesstext);
          }
          $(this).parent().prev().toggle();
          $(this).prev().toggle();
          return false;
      });
  });
</script>