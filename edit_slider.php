<?php 
  
  $page_title='Edit Slider';
  include("includes/header.php");

  require("includes/function.php");
  require("language/language.php");

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
        $query="SELECT * FROM tbl_category WHERE `cid`='$post_id'";
        break;
    }

    $sql = mysqli_query($mysqli,$query)or die(mysqli_error());
    $row=mysqli_fetch_assoc($sql);

    return stripslashes($row[$param]);
  }

  $currentVideoUrl='';

  if(isset($_GET['edit_id']))
  {   
    $qry="SELECT * FROM tbl_slider WHERE id='".$_GET['edit_id']."'";
    $result=mysqli_query($mysqli,$qry);
    $row_data=mysqli_fetch_assoc($result);

    if($row_data['slider_type']){
      $currentVideoUrl=get_single_info($row_data['post_id'], 'video_url');

      if(get_single_info($row_data['post_id'], 'video_url')=='local'){
        $currentVideoUrl=$file_path.'uploads/'.basename($row_data['video_url']);
      }
    }
  }

  if(isset($_POST['submit']) and isset($_POST['edit_id']))
  {

    $slider_type=trim($_POST['slider_type']);

    $slider_title=$slider_file=$external_url='';

    if($slider_type=='external'){

        if($_FILES['language_image']['name']!="")
        {

          unlink('images/'.$row_data['external_image']);

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
        }
        else
        {
          $slider_file=$row_data['external_image'];
        }

        $post_id=0;
        $slider_title=addslashes(trim($_POST['slider_title']));
        $external_url=addslashes(trim($_POST['external_url']));
    }
    else{

        switch ($slider_type) {
          case 'video':
              $post_id=$_POST['video_id'];
            break;

          case 'image':
              $post_id=$_POST['image_id'];
            break;

          case 'gif':
              $post_id=$_POST['gif_id'];
            break;

          case 'quote':
              $post_id=$_POST['quote_id'];
            break;
          
          default:
            break;
        }

    }

    if($post_id!=0){
      $sql="SELECT * FROM tbl_slider WHERE `post_id`='$post_id' AND `slider_type`='$slider_type' AND `status`='1' AND `id` <> '".$_GET['edit_id']."'";
      $res=mysqli_query($mysqli, $sql);
      if($res->num_rows > 0){
        $_SESSION['class']='error';
        $_SESSION['msg']=str_replace('###', ucwords($slider_type), $client_lang['slider_exist_err']);
        if(isset($_GET['redirect'])){
          header("Location:".$_GET['redirect']);
        }
        else{
          header("Location:edit_slider.php?edit_id=".$_POST['edit_id']);
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

    $edit=Update('tbl_slider', $data, "WHERE id = '".$_POST['edit_id']."'");

    $_SESSION['class']='success';
    $_SESSION['msg']="11"; 

    if(isset($_GET['redirect'])){
      header("Location:".$_GET['redirect']);
    }
    else{
      header("Location:edit_slider.php?edit_id=".$_POST['edit_id']);
    }
    
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
        <form action="" name="addeditlanguage" method="post" class="form form-horizontal" enctype="multipart/form-data">
          <input type="hidden" name="edit_id" value="<?php echo $_GET['edit_id'];?>" />

          <input type="hidden" class="is_image" value="<?php if($row_data['slider_type']=='external' AND file_exists('images/'.$row_data['external_image'])){ echo 'true'; }else{ echo 'false'; } ?>" />

          <div class="section">
            <div class="section-body">
              <div class="form-group">
                <label class="col-md-3 control-label">Type :-</label>
                <div class="col-md-6">
                  <select class="select2" required="" name="slider_type">
                    <option value="video" <?=($row_data['slider_type']=='video') ? 'selected' : ''?>>Video Status</option>
                    <option value="image" <?=($row_data['slider_type']=='image') ? 'selected' : ''?>>Image Status</option>
                    <option value="gif" <?=($row_data['slider_type']=='gif') ? 'selected' : ''?>>GIF Status</option>
                    <option value="quote" <?=($row_data['slider_type']=='quote') ? 'selected' : ''?>>Quote Status</option>
                    <option value="external" <?=($row_data['slider_type']=='external') ? 'selected' : ''?>>External Banner</option>
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
                      <option data-url="<?=$video_file?>" value="<?php echo $row['id'];?>" <?=($row_data['post_id']==$row['id'] AND $row_data['slider_type']=='video') ? 'selected' : ''?>><?php echo $row['video_title'];?></option>                       
                      <?php
                    }
                    mysqli_free_result($res);
                    ?>
                  </select>
                  <div class="embed-responsive embed-responsive-16by9 hoverable preview" style="display: none;margin-bottom: 15px">
                    <video src="" width="100%" height="500" controls class="embed-responsive-item">
                    </video>
                  </div>
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
                        <option data-url="images/<?php echo $row['image_file'];?>" value="<?php echo $row['id'];?>" <?=($row_data['post_id']==$row['id'] AND $row_data['slider_type']=='image') ? 'selected' : ''?>><?php echo $row['image_title'];?></option>                           
                        <?php
                      }
                      mysqli_free_result($res);
                    ?>
                  </select>
                  <img class="preview" src="" style="display: none;margin-bottom: 10px;width:300px;height:170px;object-fit: cover;display: inline-block;box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);border-radius: 6px;" />
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
                        <option data-url="images/<?php echo $row['image_file'];?>" value="<?php echo $row['id'];?>" <?=($row_data['post_id']==$row['id'] AND $row_data['slider_type']=='gif') ? 'selected' : ''?>><?php echo $row['image_title'];?></option>                           
                        <?php
                      }
                      mysqli_free_result($res);
                    ?>
                  </select>
                  <img class="preview" src="" style="display: none;margin-bottom: 10px;width:300px;height:170px;object-fit: cover;display: inline-block;box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);border-radius: 6px;" />
                </div>
              </div>
              <div class="form-group quote_status" style="display: none;">
                <label class="col-md-3 control-label" for="quote_id">Quote Status :-</label>
                <div class="col-md-6">
                  <select name="quote_id" id="quote_id" class="select2">
                    <option value="0">--Select Quote--</option>
                    <?php
                    $sql="SELECT * FROM tbl_quotes ORDER BY `id` DESC";
                    $res=mysqli_query($mysqli, $sql);
                    while($row=mysqli_fetch_array($res))
                    {
                      ?>                       
                      <option data-bg="<?php echo '#'.$row['quote_bg'];?>" data-html="<?php echo $row['quotes_html'];?>" data-font="<?=pathinfo($row['quote_font'], PATHINFO_FILENAME)?>" value="<?php echo $row['id'];?>" <?=($row_data['post_id']==$row['id'] AND $row_data['slider_type']=='quote') ? 'selected' : ''?>><?php echo stripslashes($row['quote']);?></option>                           
                      <?php
                    }
                    mysqli_free_result($res);
                    ?>
                  </select>
                  <div class="preview" style="display: none;height: 100%;margin-bottom: 10px;text-align: center;font-size: 16px;padding: 2em;border-radius:6px;box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);">

                  </div>
                </div>
              </div>
              <div class="external_banner" style="display: none;">
                <div class="form-group">
                  <label class="col-md-3 control-label">Title :-</label>
                  <div class="col-md-6">
                    <input type="text" name="slider_title" placeholder="Enter title" id="slider_title" value="<?php echo $row_data['slider_title'];?>" class="form-control">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-3 control-label" for="external_url">External URL :-</label>
                  <div class="col-md-6">
                    <input type="text" name="external_url" placeholder="Enter external url" id="external_url" value="<?php echo $row_data['external_url'];?>" class="form-control">
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
                        <div class="fileupload_img"><img type="image" src="<?=($row_data['slider_type']!='external') ? 'assets/images/landscape.jpg' : 'images/'.$row_data['external_image'];?>" style="width: 150px;height: 90px;" alt="image alt" /></div>
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

  var type=$("select[name='slider_type']").val();

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
        if($(".is_image").val()=='false')
          $(".external_banner").find("input").attr("required",true);
        $(".video_status").hide();
        $(".image_status").hide();
        $(".gif_status").hide();
        $(".quote_status").hide();

      }
      break;
  }

  $("select[name='slider_type']").on("change",function(e){
    var type=$(this).val();

    $(".video_status").find("select").attr("required",false);
    $(".image_status").find("select").attr("required",false);
    $(".gif_status").find("select").attr("required",false);
    $(".quote_status").find("select").attr("required",false);
    $(".external_banner").find("input").attr("required",false);

    $(".preview").hide();

    switch (type) {
      case 'video':
        {
          var url=$("select[name='video_id']").children("option:selected").data("url");
          if(url!=undefined)
          {
            $("select[name='video_id']").parent("div").find(".preview video").attr('src',url);
            $("select[name='video_id']").parent("div").find(".preview").show();
          }

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

          var url=$("select[name='image_id']").children("option:selected").data("url");
          if(url!=undefined)
          {
            $("select[name='image_id']").parent("div").find(".preview").attr('src',url);
            $("select[name='image_id']").parent("div").find(".preview").show();
          }

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
          var url=$("select[name='gif_id']").children("option:selected").data("url");
          if(url!=undefined)
          {
            $("select[name='gif_id']").parent("div").find(".preview").attr('src',url);
            $("select[name='gif_id']").parent("div").find(".preview").show();
          }

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

          console.log($("select[name='quote_id']").children("option:selected").data("html"));

          var quote=$("select[name='quote_id']").children("option:selected").text();
          var bg=$("select[name='quote_id']").children("option:selected").data("bg");
          var font=$("select[name='quote_id']").children("option:selected").data("font");


          if(quote!=undefined)
          {
            $("select[name='quote_id']").parent("div").find(".preview").css({"color":"#FFF","font-family":font,"background-color":bg});

            if($("select[name='quote_id']").children("option:selected").data("html")!='')
            {
              $("select[name='quote_id']").parent("div").find(".preview").html($("select[name='quote_id']").children("option:selected").data("html"));  
            }
            else{
              $("select[name='quote_id']").parent("div").find(".preview").text(quote);
            }
            
            $("select[name='quote_id']").parent("div").find(".preview").show();
          }

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
          if($(".is_image").val()=='false')
            $(".external_banner").find("input").attr("required",true);
          $(".video_status").hide();
          $(".image_status").hide();
          $(".gif_status").hide();
          $(".quote_status").hide();

        }
        break;
    }
  });

  var url=$("select[name='video_id']").children("option:selected").data("url");
  $("select[name='video_id']").parent("div").find(".preview video").attr('src',url);
  $("select[name='video_id']").parent("div").find(".preview").show();

  $("select[name='video_id']").on("change",function(e){
    var url=$(this).children("option:selected").data("url");
    $(this).parent("div").find(".preview video").attr('src',url);
    $(this).parent("div").find(".preview").show();
  });


  var url=$("select[name='image_id']").children("option:selected").data("url");
  $("select[name='image_id']").parent("div").find(".preview").attr('src',url);
  $("select[name='image_id']").parent("div").find(".preview").show();

  $("select[name='image_id']").on("change",function(e){
    var url=$(this).children("option:selected").data("url");
    $(this).parent("div").find(".preview").attr('src',url);
    $(this).parent("div").find(".preview").show();
  });

  var url=$("select[name='gif_id']").children("option:selected").data("url");
  $("select[name='gif_id']").parent("div").find(".preview").attr('src',url);
  $("select[name='gif_id']").parent("div").find(".preview").show();

  $("select[name='gif_id']").on("change",function(e){
    var url=$(this).children("option:selected").data("url");
    $(this).parent("div").find(".preview").attr('src',url);
    $(this).parent("div").find(".preview").show();
  });

  // for quotes

  var quote=$("select[name='quote_id']").children("option:selected").text();
  var bg=$("select[name='quote_id']").children("option:selected").data("bg");
  var font=$("select[name='quote_id']").children("option:selected").data("font");

  $("select[name='quote_id']").parent("div").find(".preview").css({"color":"#FFF","font-family":font,"background-color":bg});

  if($("select[name='quote_id']").children("option:selected").data("html")!='')
  {
    $("select[name='quote_id']").parent("div").find(".preview").html($("select[name='quote_id']").children("option:selected").data("html"));  
  }
  else{
    $("select[name='quote_id']").parent("div").find(".preview").text(quote);
  }
  
  $("select[name='quote_id']").parent("div").find(".preview").show();


  $("select[name='quote_id']").on("change",function(e){

    var quote=$(this).children("option:selected").text();
    var bg=$(this).children("option:selected").data("bg");
    var font=$(this).children("option:selected").data("font");

    $(this).parent("div").find(".preview").css({"color":"#FFF","font-family":font,"background-color":bg});
    
    if($("select[name='quote_id']").children("option:selected").data("html")!='')
    {
      $("select[name='quote_id']").parent("div").find(".preview").html($("select[name='quote_id']").children("option:selected").data("html"));  
    }
    else{
      $("select[name='quote_id']").parent("div").find(".preview").text(quote);
    }

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