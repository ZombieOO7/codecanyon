<?php 

    $page_title="Edit Video";
    $active_page="status";

    include("includes/header.php");
    include("includes/connection.php");

    require("includes/function.php");
    require("language/language.php");

    $qry="SELECT * FROM tbl_video WHERE id='".$_GET['video_id']."'";
    $result=mysqli_query($mysqli,$qry);
    $row=mysqli_fetch_assoc($result);

    $lang_ids=explode(',', $row['lang_ids']);

    $video_file=$row['video_url'];

    if($row['video_type']=='local'){
      $video_file=$file_path.'uploads/'.basename($row['video_url']);
    }

    if(isset($_POST['submit']))
    {
      $lang_ids=implode(',', $_POST['lang_id']);

      $video_id='-';

      $video_tags=($_POST['video_tags']!='') ? addslashes(implode(',', $_POST['video_tags'])) : '';

      if($_POST['video_type']=='server_url')
      {
        $video_url=addslashes(trim($_POST['video_url']));  

        if($row['video_type']=='local'){
          unlink('uploads/'.basename($row['video_url']));
        }
      } 
      else if ($_POST['video_type']=='local')
      {
        if (!empty($_FILES['video_local']['name'])) {

          $path = "uploads/"; //set your folder path

          $file_size=round($_FILES['video_local']['size'] / 1024 / 1024, 2);

          if($file_size > $settings_details['video_file_size']) {

            $video_msg=str_replace('###', $settings_details['video_file_size'], $client_lang['video_msg']);
            $video_msg=str_replace('$$$', $settings_details['video_file_duration'], $video_msg);

            $_SESSION['class']='error';
            $_SESSION['msg']=$video_msg;
            if(isset($_GET['redirect']))
            {
              header( "Location:edit_video.php?video_id=".$_POST['video_id'].'&redirect='.$_GET['redirect']);
            }
            else{
              header( "Location:edit_video.php?video_id=".$_POST['video_id']);
            }
            exit;
          }

          unlink('uploads/'.basename($row['video_url']));

          $video_local=rand(0,99999)."_".str_replace(" ", "-", $_FILES['video_local']['name']);

          $tmp = $_FILES['video_local']['tmp_name'];

          if (move_uploaded_file($tmp, $path.$video_local)) 
          {
            $video_url=$video_local;
          } else 
          {
            $_SESSION['class']='error';
            $_SESSION['msg']='Error in uploading video file!';
            header( "Location:add_video.php");

            if(isset($_GET['redirect']))
            {
              header( "Location:edit_video.php?video_id=".$_POST['video_id'].'&redirect='.$_GET['redirect']);
            }
            else{
              header( "Location:edit_video.php?video_id=".$_POST['video_id']);
            }
            exit;
          }
        }
        else{
          $video_url=$row['video_url'];
        }
    } 

    if (!empty($_FILES['video_thumbnail']['name']))
    {
      $ext = pathinfo($_FILES['video_thumbnail']['name'], PATHINFO_EXTENSION);

      $video_thumbnail=rand(0,99999)."_video_thumb.".$ext;

      //Main Image
      $tpath1='images/'.$video_thumbnail;   

      if($ext!='png')  {
        $pic1=compress_image($_FILES["video_thumbnail"]["tmp_name"], $tpath1, 80);
      }
      else{
        $tmp = $_FILES['video_thumbnail']['tmp_name'];
        move_uploaded_file($tmp, $tpath1);
      }

      if($row['video_thumbnail']!="")
      {
        unlink('images/'.$row['video_thumbnail']);
      }
    }
    else{
      $video_thumbnail=$row['video_thumbnail'];
    }

    $data = array( 
      'cat_id'  =>  $_POST['cat_id'],
      'sub_cat_id'  =>  $_POST['sub_cat_id'],
      'lang_ids'  =>  $lang_ids,
      'video_tags'  =>  $video_tags,
      'video_type'  =>  $_POST['video_type'],
      'video_title'  =>  addslashes($_POST['video_title']),
      'video_url'  =>  $video_url,
      'video_id'  =>  $video_id,
      'video_layout'  =>  $_POST['video_layout'],
      'video_thumbnail'  =>  $video_thumbnail
    );

    $qry=Update('tbl_video', $data, "WHERE id = '".$_POST['video_id']."'");

    $_SESSION['class']='success';
    $_SESSION['msg']="11"; 

    if(isset($_GET['redirect']))
    {
      header("Location:".$_GET['redirect']);
    }
    else{
      header( "Location:edit_video.php?video_id=".$_POST['video_id']);
    }
    exit;	
    }

?>
<!-- For Bootstrap Tags -->
<link rel="stylesheet" type="text/css" href="assets/bootstrap-tag/bootstrap-tagsinput.css">
<!-- End -->

<div class="row">
  <div class="col-md-12">
    <?php
      if(isset($_GET['redirect'])){
        echo '<a href="'.$_GET['redirect'].'" class="btn_back"><h4 class="pull-left" style="font-size: 20px;color: #e91e63"><i class="fa fa-arrow-left"></i> Back</h4></a>';
      }
      else{
        echo '<a href="manage_videos.php" class="btn_back"><h4 class="pull-left" style="font-size: 20px;color: #e91e63"><i class="fa fa-arrow-left"></i> Back</h4></a>';
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
        <form action="" name="edit_form" method="post" class="form form-horizontal" enctype="multipart/form-data">
          <input  type="hidden" name="video_id" value="<?php echo $_GET['video_id'];?>" />
          <div class="section">
            <div class="section-body">
			      <div class="form-group">
                <label class="col-md-3 control-label">Video Title :-</label>
                <div class="col-md-6">
                  <input type="text" name="video_title" id="video_title" value="<?php echo stripslashes($row['video_title']);?>" class="form-control" required>
                </div>
            </div>  
              <div class="form-group">
                <label class="col-md-3 control-label">Category :-</label>
                <div class="col-md-6">
                  <select name="cat_id" id="cat_id" class="select2">
                    <option value="">--Select Category--</option>
                    <?php
                    //Get Category
                    $cat_qry="SELECT * FROM tbl_category ORDER BY category_name";
                    $cat_result=mysqli_query($mysqli,$cat_qry);
                    while($cat_row=mysqli_fetch_array($cat_result))
                    {
                      ?>          						 
                      <option value="<?php echo $cat_row['cid'];?>" <?php if($cat_row['cid']==$row['cat_id']){?>selected<?php }?>><?php echo $cat_row['category_name'];?></option>	          							 
                      <?php
                    }
                    ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label">Sub Category :-</label>
                <div class="col-md-6">
                  <select name="sub_cat_id" id="sub_cat_id" class="select2" required>
                    <option value="">--Select Sub Category--</option>
                    <?php
                    $category_id = $row['cat_id'];
                    $sub_cat_qry="SELECT * FROM tbl_sub_category WHERE `status`='1' AND `category_id`=$category_id ORDER BY `sub_category_name`";
                    $sub_cat_result=mysqli_query($mysqli,$sub_cat_qry);
                    while($sub_cat_row=mysqli_fetch_array($sub_cat_result))
                    {
                      ?>
                      <option value="<?php echo $sub_cat_row['id'];?>" <?= ($row['sub_cat_id']==$sub_cat_row['id'])?'selected':'' ?>><?php echo $sub_cat_row['sub_category_name'];?></option>	          							 
                      <?php
                    }
                    ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label" for="lang_id">Languages:-</label>
                <div class="col-md-6">

                  <select name="lang_id[]" id="lang_id" class="select2" multiple="" required>
                    <?php
                    $sql="SELECT * FROM tbl_language WHERE `status`='1' ORDER BY `language_name`";
                    $res=mysqli_query($mysqli,$sql);
                    while($row_data=mysqli_fetch_assoc($res))
                    {
                      ?>                       
                      <option value="<?php echo $row_data['id'];?>" <?=(in_array($row_data['id'], $lang_ids)) ? 'selected' : ''; ?>><?php echo $row_data['language_name'];?></option>
                      <?php
                    }
                    ?>
                  </select>
                </div>
              </div>                
              <div class="form-group">
                <label class="col-md-3 control-label">Tags(Optional):-</label>
                <div class="col-md-6">
                  <input type="text" name="video_tags[]" id="video_tags" value="<?php echo $row['video_tags'];?>" data-role="tagsinput" class="form-control">
                </div>
              </div>                 
              <div class="form-group">
                <label class="col-md-3 control-label">Video Upload Option :-</label>
                <div class="col-md-6">                       
                  <select name="video_type" id="video_type" style="width:280px; height:25px;" class="select2" required>
                    <option value="server_url" <?php if($row['video_type']=='server_url'){?>selected<?php }?>>Server URL</option>
                    <option value="local" <?php if($row['video_type']=='local'){?>selected<?php }?>>Browse From Computer</option>
                  </select>
                </div>
              </div>
              <div id="video_url_display" class="form-group" <?php if($row['video_type']=='local'){?>style="display:none;"<?php }else{?>style="display:block;"<?php }?>>
                <label class="col-md-3 control-label">Video URL :-</label>
                <div class="col-md-6">
                  <input type="text" name="video_url" id="video_url" value="<?php echo $row['video_url']?>" class="form-control" <?=($row['video_type']=='server_url' AND $row['video_url']=='') ? 'required="required"' : ''?>>
                </div>
              </div>
              <div id="video_local_display" class="form-group" <?php if($row['video_type']=='local'){?>style="display:block;"<?php }else{?>style="display:none;"<?php }?>>
                <label class="col-md-3 control-label">Video Upload :-
                  <p class="control-label-help">(Recommended : Maximum <strong><?=$settings_details['video_file_size']?>MB</strong> file size)</p>
                </label>
                <div class="col-md-6">
                  <input type="file" name="video_local" id="video_local" value="" <?=($row['video_type']=='local' AND $row['video_url']=='') ? 'required="required"' : ''?> class="form-control">
                  <div id="uploadPreview" style="background: #eee;text-align: center;">
                    <video height="400" width="100%" class="video-preview" src="<?php echo $video_file?>" controls="controls"/>
                    </div>
                  </div>
                </div><br>
                <div class="form-group">
                  <label class="col-md-3 control-label">Video Layout :-</label>
                  <div class="col-md-6">                       
                    <select name="video_layout" id="video_layout" style="width:280px; height:25px;" class="select2" required>
                      <option value="Landscape" <?=($row['video_layout']=='Landscape') ? 'selected' : ''?>>Landscape</option>
                      <option value="Portrait" <?=($row['video_layout']=='Portrait') ? 'selected' : ''?>>Portrait</option>
                    </select>
                  </div>
                </div>
                <div id="thumbnail" class="form-group">
                  <label class="col-md-3 control-label">Thumbnail Image:-
                    <p class="control-label-help">(Recommended resolution: <strong>Landscape:</strong> 800x500,650x450<br/><strong>Portrait:</strong> 720X1280, 640X1136, 350x800)</p>
                  </label>
                  <div class="col-md-6">
                    <div class="fileupload_block">
                      <input type="file" name="video_thumbnail" <?=($row['video_thumbnail']=='') ? 'required="required"' : ''?> value="" id="fileupload">
                      <?php if($row['video_thumbnail']!=""){?>
                        <input type="hidden" name="video_thumbnail_name" id="video_thumbnail_name" value="<?php echo $row['video_thumbnail'];?>" class="form-control">

                        <div id="uploadPreviewImg">
                          <div class="fileupload_img">
                            <img type="image" src="images/<?php echo $row['video_thumbnail'];?>" <?=(strcmp($row['video_layout'], 'Landscape')==0) ? 'style="width: 150px;height: 100px;"' : 'style="width: 120px;height: 200px;"' ?>  alt="image alt" />
                          </div>
                        </div>
                      <?php }else{ ?>
                        <div id="uploadPreviewImg">
                          <div class="fileupload_img">
                            <img type="image" alt="image" <?=(strcmp($row['video_layout'], 'Landscape')==0) ? 'src="assets/images/landscape.jpg" style="width: 150px;height: 100px;"' : 'style="src="assets/images/portrait.jpg" width: 120px;height: 200px;"' ?>/>
                          </div>
                        </div>
                      <?php } ?>
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

  <script type="text/javascript" src="assets/bootstrap-tag/bootstrap-tagsinput.js"></script>

  <script type="text/javascript">
    $('#video_tags').tagsinput();

    $(document).ready(function(e){

      var video_layout=$("#video_layout").val();

      $("#video_layout").on("change",function(event){

        video_layout=$(this).val();

        $("#fileupload").val('');

        if($(this).val()=='Landscape')
        {
          $("#uploadPreviewImg").find("img").css({width:"150px", height: "100px"})
        }
        else
        {
          $("#uploadPreviewImg").find("img").css({width:"120px", height: "200px"}) 
        }

      });

      var _URL = window.URL || window.webkitURL;

      $("#fileupload").change(function(e) {
        var file, img;
        var thisFile=$(this);

        var countCheck=0;

        if ((file = this.files[0])) {
          img = new Image();
          img.onerror = function() {
            swal('Not a valid file: ' + file.type);
          };

          img.src = _URL.createObjectURL(file);

          if(video_layout=='Landscape')
          {
            $("#uploadPreviewImg").find("img").css({width:"150px", height: "100px"})
            $("#uploadPreviewImg").find("img").attr("src",img.src);
          }
          else
          {
            $("#uploadPreviewImg").find("img").css({width:"120px", height: "200px"})
            $("#uploadPreviewImg").find("img").attr("src",img.src);  
          }

        }

      });

      $("#video_type").change(function(){

        var type=$("#video_type").val();

        if(type=="server_url")
        {
          $("#video_url_display").show();
          $("#video_url_display").find("input").attr("required",true);
          $("#video_local_display").find("input").attr("required",false);
          $("#thumbnail").show();
          $("#video_local_display").hide();
        }
        else
        { 
          $("#video_local_display").find("input").attr("required",true);
          $("#video_url_display").find("input").attr("required",false);

          $("#video_url_display").hide();               
          $("#video_local_display").show();
          $("#thumbnail").show();
        }    

      });

      $('#video_local').change(function(e){

        var file_size=parseFloat(((this.files[0].size) / (1024 * 1024)).toFixed(2));
        var required_file_size=parseFloat('<?=$settings_details['video_file_size']?>');

        if(file_size <= required_file_size)
        {
          if(isVideo($(this).val())){
            $('.video-preview').attr('src', URL.createObjectURL(this.files[0]));
            $('#uploadPreview').show();
          }
          else
          {
            $('#video_local').val('');
            $('#uploadPreview').hide();
            swal({title: 'Error!',text: "<?=$client_lang['video_allow_err']?>", type: 'error'});
          }
        }
        else{
          $('#video_local').val('');
          $('#uploadPreview').hide();

          <?php 
          $video_msg=str_replace('###', $settings_details['video_file_size'], $client_lang['video_msg']);
          $video_msg=str_replace('$$$', $settings_details['video_file_duration'], $video_msg);
          ?>

          var msg="<?=$video_msg?>";
          swal({title: 'Warning!',text: msg, type: 'warning'});
        }
      });

    });

    function isVideo(filename) {
      var ext = getExtension(filename);
      switch (ext.toLowerCase()) {
        case 'm4v':
        case 'avi':
        case 'mp4':
        case 'mov':
        case 'mpg':
        case 'mpeg':
        // etc
        return true;
        }
      return false;
    }

    function getExtension(filename) {
      var parts = filename.split('.');
      return parts[parts.length - 1];
    }

$("#cat_id").on("change",function(){
  var cat_id = $(this).val();
  $.ajax({
    type:'post',
	  url:'processData.php',
	  dataType:'json',
    data:{
      cat_id:cat_id,
      for_action:'multi_action',
      table:'tbl_sub_category',
      action: 'get_sub_cat'
    },
    success:function(res){
      $('#sub_cat_id').empty();
      $.each(res,function(key,value){
        var data = {
            id: value.id,
            text: value.sub_category_name
        };
        var newOption = new Option(data.text,data.id, false, false);
        $('#sub_cat_id').append(newOption);
      })
      $('#sub_cat_id').trigger('change');
    },
  });
});
</script>     
