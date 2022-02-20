<?php 

  $page_title=(isset($_GET['sub_cat_id'])) ? 'Edit Sub Category' : 'Add Sub Category';

  include("includes/header.php");
  require("includes/function.php");
  require("language/language.php");

  require_once("thumbnail_images.class.php");

  if(isset($_POST['submit']) and isset($_GET['add']))
  {
      $ext = pathinfo($_FILES['sub_category_image']['name'], PATHINFO_EXTENSION);

      $sub_category_image=rand(0,99999)."_category.".$ext;

      //Main Image
      $tpath1='images/'.$sub_category_image;   

      if($ext!='png')  {
        $pic1=compress_image($_FILES["sub_category_image"]["tmp_name"], $tpath1, 80);
      }
      else{
        $tmp = $_FILES['sub_category_image']['tmp_name'];
        move_uploaded_file($tmp, $tpath1);
      }

      //Thumb Image 
      $thumbpath='images/thumbs/'.$sub_category_image;
      $thumb_pic1=create_thumb_image($tpath1,$thumbpath,'200','200');

      $data = array( 
        'sub_category_name'  =>  addslashes(trim($_POST['sub_category_name'])),
        'sub_category_image'  =>  $sub_category_image,
        'start_color'  =>  addslashes(trim($_POST['start_color'])),
        'end_color'  =>  addslashes(trim($_POST['end_color'])),
        'category_id'  =>  addslashes(trim($_POST['cat_id'])),
      );    
      $qry = Insert('tbl_sub_category',$data);
      $_SESSION['msg']="10";
      header( "Location:manage_sub_category.php");
      exit; 
  }

  if(isset($_GET['sub_cat_id']))
  {
      $qry="SELECT * FROM tbl_sub_category where id='".$_GET['sub_cat_id']."'";
      $result=mysqli_query($mysqli,$qry);
      $row=mysqli_fetch_assoc($result);
  }
  if(isset($_POST['submit']) and isset($_POST['sub_cat_id']))
  {

    $data = array(
      'sub_category_name'  =>  addslashes(trim($_POST['sub_category_name'])),
      'start_color'  =>  addslashes(trim($_POST['start_color'])),
      'end_color'  =>  addslashes(trim($_POST['end_color'])),
      'category_id'  =>  addslashes(trim($_POST['cat_id'])),
    );

    if($_FILES['sub_category_image']['name']!="")
    {

      if($row['sub_category_image']!="")
      {
        unlink('images/thumbs/'.$row['sub_category_image']);
        unlink('images/'.$row['sub_category_image']);
      }

      $ext = pathinfo($_FILES['sub_category_image']['name'], PATHINFO_EXTENSION);

      $sub_category_image=rand(0,99999)."_sub_category.".$ext;
      //Main Image
      $tpath1='images/'.$sub_category_image;   
      if($ext!='png')  {
        $pic1=compress_image($_FILES["sub_category_image"]["tmp_name"], $tpath1, 80);
      }
      else{
        $tmp = $_FILES['sub_category_image']['tmp_name'];
        move_uploaded_file($tmp, $tpath1);
      }

      //Thumb Image 
      $thumbpath='images/thumbs/'.$sub_category_image;   
      
      $thumb_pic1=create_thumb_image($tpath1,$thumbpath,'200','200');

      $data = array_merge($data, array("sub_category_image"=>$sub_category_image));
    }

    $category_edit=Update('tbl_sub_category', $data, "WHERE id = '".$_POST['sub_cat_id']."'");

    $_SESSION['msg']="11"; 
    if(isset($_GET['redirect'])){
      header("Location:".$_GET['redirect']);
    }
    else{
      header( "Location:add_sub_category.php?sub_cat_id=".$_POST['sub_cat_id']);
    }
    exit;

  }


?>

<style type="text/css">
  .gradientholder{
    background-image: linear-gradient(to right, #<?php if(isset($_GET['sub_cat_id'])){echo $row['start_color'];}else{ echo 'FF2319';}?> , #<?php if(isset($_GET['sub_cat_id'])){echo $row['end_color'];}else{ echo 'FFEC00';}?>);
  }
</style>

<div class="row">
  <div class="col-md-12">
    <?php
      if(isset($_GET['redirect'])){
        echo '<a href="'.$_GET['redirect'].'" class="btn_back"><h4 class="pull-left" style="font-size: 20px;color: #e91e63"><i class="fa fa-arrow-left"></i> Back</h4></a>';
      }
      else{
        echo '<a href="manage_sub_category.php" class="btn_back"><h4 class="pull-left" style="font-size: 20px;color: #e91e63"><i class="fa fa-arrow-left"></i> Back</h4></a>';
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
            <input type="hidden" name="sub_cat_id" value="<?php echo $_GET['sub_cat_id'];?>" />
            <div class="section">
              <div class="section-body">
                <div class="form-group">
                  <label class="col-md-3 control-label">Category :-</label>
                  <div class="col-md-6">
                    <select name="cat_id" id="cat_id" class="select2" required>
                      <option value="">--Select Category--</option>
                      <?php
                      $cat_qry="SELECT * FROM tbl_category WHERE `status`='1' ORDER BY `category_name`";
                      $cat_result=mysqli_query($mysqli,$cat_qry);
                      while($cat_row=mysqli_fetch_array($cat_result))
                      {
                        ?>
                        <option value="<?php echo $cat_row['cid'];?>" <?=($cat_row['cid'] == $row['category_id'])?'selected':'' ?>> <?php echo $cat_row['category_name'];?></option>	          							 
                        <?php
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-3 control-label">Sub Category Name :-

                  </label>
                  <div class="col-md-6">
                    <input type="text" name="sub_category_name" id="sub_category_name" value="<?php if(isset($_GET['sub_cat_id'])){echo $row['sub_category_name'];}?>" class="form-control" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-3 control-label">Select Icon :-
                    <p class="control-label-help">(Recommended resolution: W:200*H:200)</p>
                    <p class="control-label-help">(Note: Best design appearance icon should be in <strong>WHITE</strong> color and <strong>TRANSPARENT</strong> background)</p>
                  </label>

                  <div class="col-md-6">
                    <div class="fileupload_block">
                      <input type="file" name="sub_category_image" value="fileupload" accept=".png, .PNG" onchange="fileValidation()" <?=(!isset($_GET['sub_cat_id'])) ? 'required="required"' : ''?> id="fileupload">
                      <?php if(isset($_GET['sub_cat_id'])) {?>
                        <div class="fileupload_img" id="uploadPreview"><img type="image" src="images/<?php echo $row['sub_category_image'];?>" alt="category image" style="width: 120px;height: 120px;box-shadow: 0px 3px 5px 1px #ccc;background:#b3b3b3"/></div>
                      <?php }else{?>
                        <div class="fileupload_img" id="uploadPreview"><img type="image" src="assets/images/square.jpg" style="width: 120px;height: 120px;" alt="image" /></div>
                      <?php } ?>

                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-3 control-label">Gradient Start Color :-</label>
                  <div class="col-md-6">
                    <input value="<?php if(isset($_GET['sub_cat_id'])){echo $row['start_color'];}else{ echo 'FF2319';}?>" name="start_color" class="form-control jscolor {position:'bottom',
                    borderColor:'#000', insetColor:'#FFF', backgroundColor:'#FFF'}">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-3 control-label">Gradient End Color :-</label>
                  <div class="col-md-6">
                    <input value="<?php if(isset($_GET['sub_cat_id'])){echo $row['end_color'];}else{ echo 'FFEC00';}?>" name="end_color" class="form-control jscolor {position:'bottom',
                    borderColor:'#000', insetColor:'#FFF', backgroundColor:'#FFF'}">
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-md-6 col-md-offset-3">
                    <div class="gradientholder" style="height: 150px;width: 100%;box-shadow: 0px 5px 5px 1px #aaa;"></div>    
                  </div>
                </div>
                <br/>
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

  <script type="text/javascript" src="assets/js/jscolor.js"></script>    

  <script type="text/javascript">
    $("input[name='start_color']").on("change",function(e){
      var start_color=$(this).val();
      var end_color=$("input[name='end_color']").val();

      $(".gradientholder").css("background-image","linear-gradient(to right, #"+start_color+" , #"+end_color+")");
    });

    $("input[name='end_color']").on("change",function(e){
      var end_color=$(this).val();
      var start_color=$("input[name='start_color']").val();

      $(".gradientholder").css("background-image","linear-gradient(to right, #"+start_color+" , #"+end_color+")");
    });


    function fileValidation(){
      var fileInput = document.getElementById('fileupload');
      var filePath = fileInput.value;
      var allowedExtensions = /(\.png|.PNG)$/i;
      if(!allowedExtensions.exec(filePath)){
        alert('Please upload file having extension .png, .PNG only.');
        fileInput.value = '';
        return false;
      }else{
        //image preview
        if (fileInput.files && fileInput.files[0]) {
          var reader = new FileReader();
          reader.onload = function(e) {
            document.getElementById('uploadPreview').innerHTML = '<img src="'+e.target.result+'" style="width:120px;height:120px;background:#b3b3b3"/>';
          };
          reader.readAsDataURL(fileInput.files[0]);
        }
      }
    }

  </script>
