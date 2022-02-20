<?php 

    $page_title=(isset($_GET['language_id'])) ? 'Edit Language' : 'Add Language';
    include("includes/header.php");

    require("includes/function.php");
    require("language/language.php");

    require_once("thumbnail_images.class.php");

    if(isset($_POST['submit']) and isset($_GET['add']))
    {

      $ext = pathinfo($_FILES['language_image']['name'], PATHINFO_EXTENSION);

      $language_image=rand(0,99999)."_language.".$ext;

      //Main Image
      $tpath1='images/'.$language_image;   

      if($ext!='png')  {
        $pic1=compress_image($_FILES["language_image"]["tmp_name"], $tpath1, 80);
      }
      else{
        $tmp = $_FILES['language_image']['tmp_name'];
        move_uploaded_file($tmp, $tpath1);
      }

      //Thumb Image 
      $thumbpath='images/thumbs/'.$language_image;   
      $thumb_pic1=create_thumb_image($tpath1,$thumbpath,'400','200');  


      $data = array(
        'language_name'=> addslashes(trim($_POST['language_name'])),
        'language_image'  =>  $language_image
      );  

      $qry = Insert('tbl_language',$data); 

      $_SESSION['msg']="10";
      header( "Location:manage_language.php");
      exit; 
    }

    if(isset($_GET['language_id']))
    {

      $qry="SELECT * FROM tbl_language where id='".$_GET['language_id']."'";
      $result=mysqli_query($mysqli,$qry);
      $row=mysqli_fetch_assoc($result);

    }

    if(isset($_POST['submit']) and isset($_POST['language_id']))
    {

        $data = array(
          'language_name'  =>  addslashes(trim($_POST['language_name']))
        );

        if($_FILES['language_image']['name']!="")
        {    
          if($row['language_image']!="")
          {
            unlink('images/thumbs/'.$row['language_image']);
            unlink('images/'.$row['language_image']);
          }

          $ext = pathinfo($_FILES['language_image']['name'], PATHINFO_EXTENSION);

          $language_image=rand(0,99999)."_language.".$ext;

          //Main Image
          $tpath1='images/'.$language_image;   

          if($ext!='png')  {
            $pic1=compress_image($_FILES["language_image"]["tmp_name"], $tpath1, 80);
          }
          else{
            $tmp = $_FILES['language_image']['tmp_name'];
            move_uploaded_file($tmp, $tpath1);
          }

          //Thumb Image 
          $thumbpath='images/thumbs/'.$language_image;   
          $thumb_pic1=create_thumb_image($tpath1,$thumbpath,'400','200');

          $data = array_merge($data, array("language_image"=>$language_image));
        }

        $updated=Update('tbl_language', $data, "WHERE id = '".$_POST['language_id']."'");

        $_SESSION['msg']="11"; 
        if(isset($_GET['redirect'])){
          header("Location:".$_GET['redirect']);
        }
        else{
          header( "Location:add_language.php?language_id=".$_POST['language_id']);
        }
        exit;
    }
?>
<div class="row">
  <div class="col-md-12">
    <?php
      if(isset($_GET['redirect'])){
        echo '<a href="'.$_GET['redirect'].'" class="btn_back"><h4 class="pull-left" style="font-size: 20px;color: #e91e63"><i class="fa fa-arrow-left"></i> Back</h4></a>';
      }
      else{
        echo '<a href="manage_language.php" class="btn_back"><h4 class="pull-left" style="font-size: 20px;color: #e91e63"><i class="fa fa-arrow-left"></i> Back</h4></a>';
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
          <input type="hidden" name="language_id" value="<?php echo $_GET['language_id'];?>" />

          <div class="section">
            <div class="section-body">
              <div class="form-group">
                <label class="col-md-3 control-label">Language Title :-</label>
                <div class="col-md-6">
                  <input type="text" name="language_name" placeholder="Enter language title" id="language_name" value="<?php  echo $row['language_name'];?>" class="form-control" required>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label">Select Image :-
                  <p class="control-label-help">(Recommended resolution: W:400*H:200)</p>
                </label>
                <div class="col-md-6">
                  <div class="fileupload_block">
                    <input type="file" name="language_image" value="fileupload" id="fileupload" accept=".png, .jpg, .jpeg" <?=(!isset($_GET['language_id'])) ? 'required="required"' : ''?> onchange="fileValidation()">
                    <?php if(isset($_GET['language_id'])) {?>
                      <div class="fileupload_img" id="uploadPreview"><img type="image" src="images/<?php echo $row['language_image'];?>" alt="image" style="width: 150px;height: 100px;"/></div>
                    <?php }else{?>
                      <div class="fileupload_img" id="uploadPreview"><img type="image" src="assets/images/landscape.jpg" style="width: 150px;height: 100px;" alt="image" /></div>
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

<script type="text/javascript">
  function fileValidation(){
    var fileInput = document.getElementById('fileupload');
    var filePath = fileInput.value;
    var allowedExtensions = /(\.png|.jpg|.jpeg|.PNG|.JPG|.JPEG)$/i;
    if(!allowedExtensions.exec(filePath)){
      alert('Please upload file having extension .png, .jpg, .jpeg .PNG, .JPG, .JPEG only.');
      fileInput.value = '';
      return false;
    }else{
      //image preview
      if (fileInput.files && fileInput.files[0]) {

        var reader = new FileReader();
        reader.onload = function(e) {
          document.getElementById('uploadPreview').innerHTML = '<img src="'+e.target.result+'" style="width:150px;height:100px;"/>';
        };
        reader.readAsDataURL(fileInput.files[0]);
      }
    }
  }
</script>