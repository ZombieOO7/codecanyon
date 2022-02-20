<?php 
  $page_title='Add Slider';
  include("includes/header.php");
  require("includes/function.php");
  require("language/language.php");

  if(isset($_POST['submit']) and isset($_GET['add']))
  {
      $slider_type=trim($_POST['slider_type']);

      $slider_title=$slider_file=$external_url='';

      if($slider_type=='external'){

          $ext = pathinfo($_FILES['slider_file']['name'], PATHINFO_EXTENSION);

          $slider_file=rand(0,99999)."_slider.".$ext;

          //Main Image
          $tpath1='images/'.$slider_file;   

          if($ext!='png')  {
            $pic1=compress_image($_FILES["slider_file"]["tmp_name"], $tpath1, 80);
          }
          else{
            $tmp = $_FILES['slider_file']['tmp_name'];
            move_uploaded_file($tmp, $tpath1);
          }

          $post_id=0;
          $slider_title=addslashes(trim($_POST['slider_title']));
          $external_url=addslashes(trim($_POST['external_url']));
      }
      else{

          $data_status = array('featured'  =>  '1');

          switch ($slider_type) {
            case 'video':
                $post_id=$_POST['video_id'];
                $edit_status=Update('tbl_video', $data_status, "WHERE id = ".$post_id);
              break;

            case 'image':
                $post_id=$_POST['image_id'];
                $edit_status=Update('tbl_img_status', $data_status, "WHERE id = ".$post_id);
              break;

            case 'gif':
                $post_id=$_POST['gif_id'];
                $edit_status=Update('tbl_img_status', $data_status, "WHERE id = ".$post_id);
              break;

            case 'quote':
                $post_id=$_POST['quote_id'];
                $edit_status=Update('tbl_quotes', $data_status, "WHERE id = ".$post_id);
              break;
            
            default:
              break;
          }
      }

      if($post_id!=0){
        $sql="SELECT * FROM tbl_slider WHERE `post_id`='$post_id' AND `slider_type`='$slider_type' AND `status`='1'";
        $res=mysqli_query($mysqli, $sql);
        if($res->num_rows > 0){
          $_SESSION['class']='error';
          $_SESSION['msg']=str_replace('###', ucwords($slider_type), $client_lang['slider_exist_err']);

          if(isset($_GET['redirect'])){
            header("Location:".$_GET['redirect']);
          }
          else{
            header( "Location:add_slider.php?add");
          }
          
          exit;
        }
      }


	    $data = array(
	       'post_id' =>  $post_id,
         'slider_type' =>  $slider_type,
         'slider_title' =>  $slider_title,
         'external_url' =>  $external_url,
         'external_image' =>  $slider_file
	    );  

	    $qry = Insert('tbl_slider',$data);

      if($slider_type!='external'){

          $data_status = array('featured'  =>  '1');

          switch ($slider_type) {
            case 'video':
                $post_id=$_POST['video_id'];
                $edit_status=Update('tbl_video', $data_status, "WHERE id = ".$post_id);
              break;

            case 'image':
                $post_id=$_POST['image_id'];
                $edit_status=Update('tbl_img_status', $data_status, "WHERE id = ".$post_id);
              break;

            case 'gif':
                $post_id=$_POST['gif_id'];
                $edit_status=Update('tbl_img_status', $data_status, "WHERE id = ".$post_id);
              break;

            case 'quote':
                $post_id=$_POST['quote_id'];
                $edit_status=Update('tbl_quotes', $data_status, "WHERE id = ".$post_id);
              break;
            
            default:
              break;
          }
      } 

	    $_SESSION['msg']="10";
	    header( "Location:manage_slider.php");
	    exit; 
  }
?>

<style type="text/css">
  iframe{
    background: #f0f0f0 !important;
  }
</style>

<!-- For Font Family -->
<link rel="stylesheet" type="text/css" href="assets/css/quotes_fonts.css">
<!-- End -->

<div class="row">
  <div class="col-md-12">
    <?php
      if(isset($_GET['redirect'])){
        echo '<a href="'.$_GET['redirect'].'" class="btn_back"><h4 class="pull-left" style="font-size: 20px;color: #e91e63"><i class="fa fa-arrow-left"></i> Back</h4></a>';
      }
      else{
        echo '<a href="manage_slider.php" class="btn_back"><h4 class="pull-left" style="font-size: 20px;color: #e91e63"><i class="fa fa-arrow-left"></i> Back</h4></a>';
      }
    ?>
    <div class="card">
      <div class="page_title_block">
        <div class="col-md-5 col-xs-12">
          <div class="page_title"><?=$page_title?></div>
        </div>
      </div>
      <div class="clearfix"></div>
      <div class="card-body mrg_bottom"> 
        <form action="" method="post" class="form form-horizontal" enctype="multipart/form-data">

          <div class="section">
            <div class="section-body">
              <div class="form-group">
                <label class="col-md-3 control-label">Type :-</label>
                <div class="col-md-6">
                  <select class="select2" required="" name="slider_type">
                    <option value="video">Video Status</option>
                    <option value="image">Image Status</option>
                    <option value="gif">GIF Status</option>
                    <option value="quote">Quote Status</option>
                    <option value="external">External Banner</option>
                  </select>
                </div>
              </div>
              <div class="form-group video_status">
                <label class="col-md-3 control-label" for="id">Video Status :-</label>
                <div class="col-md-6">
                  <select name="video_id" id="video_id" class="select2" required="">
                    <option value="">--Select Video--</option>
                    <?php
                    $sql="SELECT * FROM tbl_video WHERE `status`='1' ORDER BY `id` DESC";
                    $res=mysqli_query($mysqli, $sql);
                    while($row=mysqli_fetch_assoc($res))
                    {
                      $video_file=$row['video_url'];

                      if($row['video_type']=='local'){
                        $video_file=$file_path.'uploads/'.basename($row['video_url']);
                      }
                      ?>
                      <option data-url="<?=$video_file?>" value="<?php echo $row['id'];?>"><?php echo $row['video_title'];?></option>                       
                      <?php
                    }
                    mysqli_free_result($res);
                    ?>
                  </select>
                  <iframe class="preview" width="100%" height="500" style="border:0;display: none;margin-bottom: 10px" src=""></iframe>
                </div>
              </div>

              <div class="form-group image_status" style="display: none;">
                <label class="col-md-3 control-label" for="image_id">Image Status :-</label>
                <div class="col-md-6">
                  <select name="image_id" id="image_id" class="select2">
                    <option value="">--Select Image--</option>
                    <?php
                    $sql="SELECT * FROM tbl_img_status WHERE `status`='1' AND `status_type`='image' ORDER BY `id` DESC";
                    $res=mysqli_query($mysqli, $sql);
                    while($row=mysqli_fetch_array($res))
                    {
                      ?>                       
                      <option data-url="images/<?php echo $row['image_file'];?>" value="<?php echo $row['id'];?>"><?php echo $row['image_title'];?></option>                           
                      <?php
                    }
                    mysqli_free_result($res);
                    ?>
                  </select>
                  <img class="preview" src="" style="display: none;margin-bottom: 10px;width:300px;height:170px;object-fit: cover;box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);border-radius: 6px;" />
                </div>
              </div>
              <div class="form-group gif_status" style="display: none;">
                <label class="col-md-3 control-label" for="gif_id">GIF Status :-</label>
                <div class="col-md-6">
                  <select name="gif_id" id="gif_id" class="select2">
                    <option value="">--Select GIF--</option>
                    <?php
                    $sql="SELECT * FROM tbl_img_status WHERE `status`='1' AND `status_type`='gif' ORDER BY `id` DESC";
                    $res=mysqli_query($mysqli, $sql);
                    while($row=mysqli_fetch_array($res))
                    {
                      ?>                       
                      <option data-url="images/<?php echo $row['image_file'];?>" value="<?php echo $row['id'];?>"><?php echo $row['image_title'];?></option>                           
                      <?php
                    }
                    mysqli_free_result($res);
                    ?>
                  </select>
                  <img class="preview" src="" style="display: none;margin-bottom: 10px;width:300px;height:170px;object-fit: cover;box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);border-radius: 6px;" />
                </div>
              </div>
              <div class="form-group quote_status" style="display: none;">
                <label class="col-md-3 control-label" for="quote_id">Quote Status :-</label>
                <div class="col-md-6">
                  <select name="quote_id" id="quote_id" class="select2">
                    <option value="0">--Select Quote--</option>
                    <?php
                    $sql="SELECT * FROM tbl_quotes WHERE `status`='1' ORDER BY `id` DESC";
                    $res=mysqli_query($mysqli, $sql);
                    while($row=mysqli_fetch_array($res))
                    {
                      ?>                       
                      <option data-bg="<?php echo '#'.$row['quote_bg'];?>" data-font="<?=pathinfo($row['quote_font'], PATHINFO_FILENAME)?>" value="<?php echo $row['id'];?>"><?php echo stripslashes($row['quote']);?></option>
                      <?php
                    }
                    mysqli_free_result($res);
                    ?>
                  </select>
                  <div class="preview" style="display: none;height: 100%;margin-bottom: 10px;text-align: center;font-size: 16px;padding: 2em;border-radius:6px;box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);">
                    <span></span>
                  </div>
                </div>
              </div>
              <div class="external_banner" style="display: none;">
                <div class="form-group">
                  <label class="col-md-3 control-label">Title :-</label>
                  <div class="col-md-6">
                    <input type="text" name="slider_title" placeholder="Enter title" id="slider_title" value="<?php echo $row['slider_title'];?>" class="form-control">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-3 control-label" for="external_url">External URL :-</label>
                  <div class="col-md-6">
                    <input type="text" name="external_url" placeholder="Enter external url" id="external_url" value="<?php echo $row['external_url'];?>" class="form-control">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-3 control-label">Select Image :-
                    <p class="control-label-help">(Recommended resolution: Landscape: 800x500,650x450</p>
                  </label>
                  <div class="col-md-6">
                    <div class="fileupload_block">
                      <input type="file" name="slider_file" value="fileupload" id="fileupload" accept=".png, .jpg, .jpeg">
                      <div id="uploadPreview">
                        <div class="fileupload_img">
                          <img type="image" src="assets/images/landscape.jpg" style="width: 150px;height: 90px;" alt="image alt" />
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-9 col-md-offset-3">
                  <button type="submit" name="submit" class="btn btn-primary">Save</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
        
<?php include("includes/footer.php");?>

<script type="text/javascript">
  $("select[name='slider_type']").on("change",function(e)
  {
    var type=$(this).val();

    $(".video_status").find("select").attr("required",false);
    $(".image_status").find("select").attr("required",false);
    $(".gif_status").find("select").attr("required",false);
    $(".quote_status").find("select").attr("required",false);
    $(".external_banner").find("input").attr("required",false);

    switch (type) {
      case 'video':
        {
          $(".video_status").show();
          $(".video_status").find("select").attr("required",true);
          $(".image_status").hide();
          $(".gif_status").hide();
          $(".quote_status").hide();
          $(".external_banner").hide();
        }
        break;

      case 'image':
        {

          $(".image_status").show();
          $(".image_status").find("select").attr("required",true);
          $(".video_status").hide();
          $(".gif_status").hide();
          $(".quote_status").hide();
          $(".external_banner").hide();

        }
        break;

      case 'gif':
        {
          $(".gif_status").show();
          $(".gif_status").find("select").attr("required",true);
          $(".video_status").hide();
          $(".image_status").hide();
          $(".quote_status").hide();
          $(".external_banner").hide();
        }
        break;

      case 'quote':
        {
          $(".quote_status").show();
          $(".quote_status").find("select").attr("required",true);
          $(".video_status").hide();
          $(".image_status").hide();
          $(".gif_status").hide();
          $(".external_banner").hide();
        }
        break;

      case 'external':
        {
          $(".external_banner").show();
          $(".external_banner").find("input").attr("required",true);
          $(".video_status").hide();
          $(".image_status").hide();
          $(".gif_status").hide();
          $(".quote_status").hide();

        }
        break;
    }


  });

  $("select[name='video_id']").on("change",function(e){
    var url=$(this).children("option:selected").data("url");
    $(this).parent("div").find(".preview").attr('src',url);
    $(this).parent("div").find(".preview").show();
  });

  $("select[name='image_id']").on("change",function(e){
    var url=$(this).children("option:selected").data("url");
    $(this).parent("div").find(".preview").attr('src',url);
    $(this).parent("div").find(".preview").show();
  });

  $("select[name='gif_id']").on("change",function(e){
    var url=$(this).children("option:selected").data("url");
    $(this).parent("div").find(".preview").attr('src',url);
    $(this).parent("div").find(".preview").show();
  });


  $("select[name='quote_id']").on("change",function(e){
    var quote=$(this).children("option:selected").text();
    var bg=$(this).children("option:selected").data("bg");
    var font=$(this).children("option:selected").data("font");

    $(this).parent("div").find(".preview").css({"color":"#FFF","font-family":font,"background-color":bg});
    $(this).parent("div").find(".preview span").text(quote);
    $(this).parent("div").find(".preview").show();
  });


  var _URL = window.URL || window.webkitURL;

  $("#fileupload").change(function(e) {
      var file, img;
      var thisFile=$(this);

      var countCheck=0;
      
      if ((file = this.files[0])) {
          img = new Image();
          img.onload = function() {
              if(this.width < this.height)
              {
                swal({title: 'Warning!',text: '<?=$client_lang["slider_img_greater_err"]?>', type: 'warning'});
                thisFile.val('');
                $('#uploadPreview').find("img").attr('src', 'assets/images/landscape.jpg');
                return false;
              }
              else if(this.width == this.height){
                swal({title: 'Warning!',text: '<?=$client_lang["slider_img_square_err"]?>', type: 'warning'});
                thisFile.val('');
                $('#uploadPreview').find("img").attr('src', 'assets/images/landscape.jpg');
                return false;
              }
              
          };
          img.onerror = function() {
            swal({title: 'Error!',text: 'Not a valid file: '+ file.type, type: 'error'});
            thisFile.val('');
            $('#uploadPreview').find("img").attr('src', 'assets/images/landscape.jpg');
            return false;
          };

          img.src = _URL.createObjectURL(file);
          
          $('#uploadPreview').find("img").attr('src', img.src);

      }

  });

</script>