<?php 
    $page_title="Edit Quote";
    $active_page="status";

    include("includes/header.php");

    include("includes/function.php");
    include("language/language.php");

    $mysqli->set_charset('utf8mb4');

    $sql="SELECT * FROM tbl_quotes WHERE `id`='".$_GET['edit_id']."'";
    $res=mysqli_query($mysqli, $sql);
    $row=mysqli_fetch_assoc($res);


    $dirFonts = 'assets/fonts/quotes_fonts';

    $fontsOpt=$errorDir='';

    // Check if the directory exists
    if (file_exists($dirFonts) && is_dir($dirFonts) ) {

      $fontCss = "assets/css/quotes_fonts.css";
      $fh = fopen($fontCss, 'w') or die("can't open file");
      $stringData = "";
      fwrite($fh, $stringData);
      fclose($fh);

      $scan_arr = scandir($dirFonts);
      $files_arr = array_diff($scan_arr, array('.','..') );
      foreach ($files_arr as $file) {

        $file_path = "assets/fonts/quotes_fonts/".$file;
        $file_ext = pathinfo($file_path, PATHINFO_EXTENSION);

        $file_name = pathinfo($file_path, PATHINFO_FILENAME);

        if ($file_ext=="ttf" || $file_ext=="TTF") {

          if(strcmp($row['quote_font'], $file)==0){
            $fontsOpt.='<option value="'.$file.'" selected>'.$file_name.'</option>';  
          }else{
            $fontsOpt.='<option value="'.$file.'">'.$file_name.'</option>';
          }


          $cssData = "/*=======fonts for ".$file_name."========*/
          @font-face {
            font-family: '".$file_name."';
            src: url('../fonts/quotes_fonts/".$file."');
          }\n\n";

          file_put_contents($fontCss, $cssData, FILE_APPEND | LOCK_EX);

        }
      }
    }
    else {
      $errorDir="Fonts directory does not exists. You can't select font in Quote Font";
    }

    $lang_ids=explode(',', $row['lang_ids']);

    if(isset($_POST['submit']))
    {
      $lang_ids=implode(',', $_POST['lang_id']);

      $quote_tags=($_POST['quote_tags']!='') ? addslashes(implode(',', $_POST['quote_tags'])) : '';

      $quote=addslashes(trim($_POST['quote']));

      $bg_color=strtolower(trim($_POST['bg_color']));

      $data = array( 
        'cat_id'  =>  $_POST['cat_id'],
        'sub_cat_id'  =>  addslashes(trim($_POST['sub_cat_id'])),
        'lang_ids'  =>  $lang_ids,
        'quote'  =>  $quote,
        'quote_font'  =>  trim($_POST['quote_font']),
        'quote_tags'  =>  $quote_tags,
        'quote_bg'  =>  $bg_color,
        'quotes_html'  =>  htmlentities(addslashes($_POST['quotes_html']))
      ); 

      $update=Update('tbl_quotes', $data, "WHERE id = '".$_POST['edit_id']."'");

      $_SESSION['class']="success";
      $_SESSION['msg']="11";

      if(isset($_GET['redirect']))
      {
        header("Location:".$_GET['redirect']);
      }
      else{
        header( "Location:edit_quote.php?edit_id=".$_POST['edit_id']);
      }

      exit;	
    }

?>

<!-- For Bootstrap Tags -->
<link rel="stylesheet" type="text/css" href="assets/bootstrap-tag/bootstrap-tagsinput.css">
<!-- End -->

<!-- For Font Family -->
<link rel="stylesheet" type="text/css" href="assets/css/quotes_fonts.css">
<!-- End -->

<script src="vendor/jquery/jquery-3.2.1.min.js"></script>

<link href="vendor/emoji-picker/lib/css/emoji.css" rel="stylesheet">


<style type="text/css">
  .emoji-wysiwyg-editor{
    background-color: #<?=$row['quote_bg']?>;
    color: #FFF;
    font-family: <?=pathinfo($row['quote_font'], PATHINFO_FILENAME)?>;
  }
</style>


<div class="row">
  <div class="col-md-12">
    <?php
      if(isset($_GET['redirect'])){
        echo '<a href="'.$_GET['redirect'].'" class="btn_back"><h4 class="pull-left" style="font-size: 20px;color: #e91e63"><i class="fa fa-arrow-left"></i> Back</h4></a>';
      }
      else{
        echo '<a href="manage_quotes_status.php" class="btn_back"><h4 class="pull-left" style="font-size: 20px;color: #e91e63"><i class="fa fa-arrow-left"></i> Back</h4></a>';
      }
    ?>
    <?php if(!empty($errorDir)){?> 
      <div class="clearfix"></div>
      <div class="alert alert-danger alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
        <?php echo $errorDir; ?></div> 
    <?php } ?>
    <div class="card">
      <div class="page_title_block">
        <div class="col-md-5 col-xs-12">
          <div class="page_title"><?=$page_title?></div>
        </div>
      </div>
      <div class="clearfix"></div>
      <div class="card-body mrg_bottom"> 
        <form action="" method="post" class="form form-horizontal" enctype="multipart/form-data">
          <input  type="hidden" name="edit_id" value="<?php echo $_GET['edit_id'];?>" />
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
                      <option value="<?php echo $cat_row['cid'];?>" <?=($row['cat_id']==$cat_row['cid']) ? 'selected' : '';?>><?php echo $cat_row['category_name'];?></option>
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
                    $sql_data="SELECT * FROM tbl_language WHERE `status`='1' ORDER BY `language_name`";
                    $res_data=mysqli_query($mysqli,$sql_data);
                    while($row_data=mysqli_fetch_assoc($res_data))
                    {
                      ?>                       
                      <option value="<?php echo $row_data['id'];?>" <?=(isset($_GET['edit_id']) && in_array($row_data['id'], $lang_ids)) ? 'selected' : ''; ?>><?php echo $row_data['language_name'];?></option>
                      <?php
                    }
                    ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label" for="quote_font">Quote Font:-</label>
                <div class="col-md-6">
                  <select name="quote_font" id="quote_font" class="select2" required="">
                    <option value="">---Select Font---</option>
                    <?=$fontsOpt?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label">Quote:-</label>
                <div class="col-md-6">
                  <textarea name="quote" class="input-field" data-emojiable="true" data-emoji-input="unicode" type="text"><?php echo stripslashes($row['quote']);?></textarea>

                  <input type="hidden" name="quotes_html" value="<?=$row['quotes_html']?>">
                </div>
              </div>
              <br/>
              <div class="form-group">
                <label class="col-md-3 control-label">Background :-</label>
                <div class="col-md-6">
                  <input value="<?=$row['quote_bg']?>" name="bg_color" onchange="update(this.jscolor)" class="form-control jscolor {position:'bottom',
                  borderColor:'#000', insetColor:'#FFF', backgroundColor:'#FFF'}">
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label">Tags(Optional):-</label>
                <div class="col-md-6">
                  <input type="text" name="quote_tags[]" id="quote_tags" value="<?php echo $row['quote_tags'];?>" data-role="tagsinput" class="form-control">
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

<script src="vendor/emoji-picker/lib/js/config.js"></script>
<script src="vendor/emoji-picker/lib/js/util.js"></script>
<script src="vendor/emoji-picker/lib/js/jquery.emojiarea.js"></script>
<script src="vendor/emoji-picker/lib/js/emoji-picker.js"></script>

<script type="text/javascript">
    $(function () {
        // Initializes and creates emoji set from sprite sheet
        window.emojiPicker = new EmojiPicker({
            emojiable_selector: '[data-emojiable=true]',
            assetsPath: 'vendor/emoji-picker/lib/img/',
            popupButtonClasses: 'icon-smile'
        });

        window.emojiPicker.discover();
    });

</script>
<script type="text/javascript" src="assets/js/jscolor.js"></script>

<script type="text/javascript">

  function update(jscolor) {
    $(".emoji-wysiwyg-editor").css("background-color","#" + jscolor);
    $(".emoji-wysiwyg-editor").css("color","#FFF");
  }

  $(document).ready(function(e){

    $("select[name='quote_font']").change(function(e){

      var font_name = $(this).val();
      font_name = font_name.split("/").slice(-1).join().split(".").shift();
      $(".emoji-wysiwyg-editor").css("font-family",font_name);
    });

    $(".emoji-wysiwyg-editor").blur(function(e){
      $("input[name='quotes_html']").val($(".emoji-wysiwyg-editor").html());
    });

    <?php 
      if(!empty($row['quotes_html'])){
        ?>
        $(".emoji-wysiwyg-editor").html($("input[name='quotes_html']").val());
        <?php
      }
    ?>

  });

</script>

<script type="text/javascript" src="assets/bootstrap-tag/bootstrap-tagsinput.js"></script>

<script type="text/javascript">
  $('#quote_tags').tagsinput();
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
