<?php 
  $page_title="Add Quote";
  $active_page="status";

  include("includes/header.php");
  include("includes/function.php");
  include("language/language.php"); 
  include("language/app_language.php"); 

  $mysqli->set_charset('utf8mb4');

  $dirFonts = 'assets/fonts/quotes_fonts';

  $fontsOpt=$errorDir='';

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

        $fontsOpt.='<option value="'.$file.'">'.$file_name.'</option>';

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

  if(isset($_POST['submit']))
  {

    $lang_ids=implode(',', $_POST['lang_id']);

    $quote_tags=($_POST['quote_tags']!='') ? addslashes(implode(',', $_POST['quote_tags'])) : '';

    $quote=addslashes(trim($_POST['quote']));

    $bg_color=trim($_POST['bg_color']);

    $data = array( 
      'cat_id'  =>  addslashes(trim($_POST['cat_id'])),
      'sub_cat_id'  =>  addslashes(trim($_POST['sub_cat_id'])),
      'lang_ids'  =>  $lang_ids,
      'quote'  =>  $quote,
      'quote_font'  =>  trim($_POST['quote_font']),
      'quote_tags'  =>  $quote_tags,
      'quote_bg'  =>  $bg_color,
      'quotes_html'  =>  htmlentities(addslashes($_POST['quotes_html'])),
      'created_at'  =>  strtotime(date('d-m-Y h:i:s A')),
    ); 

    $insert = Insert('tbl_quotes',$data);

    $last_id = mysqli_insert_id($mysqli);

    if(isset($_POST['notify_user']))
    {
        $headings = array("en" => str_replace('###', $_SESSION['admin_name'], $client_lang['add_quotes_notify_msg']));

        $content = array(
          "en" => $quote
        );

        $fields = array(
          'app_id' => ONESIGNAL_APP_ID,
          "headings" => $headings,
          'included_segments' => array('All'),
          'data' => array("foo" => "bar","type" => "single_status","status_type" => 'quote',"id" => $last_id,"external_link"=>false),
          'headings'=> array("en" => APP_NAME),
          'contents' => $content
        );

        $fields = json_encode($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
        'Authorization: Basic '.ONESIGNAL_REST_KEY));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $notify_res = curl_exec($ch);
        curl_close($ch);
    }

    if($settings_details['quotes_add_status']=='true')
    {

      $user_id=0;

      $sql_activity = "SELECT * FROM tbl_users_rewards_activity WHERE `post_id` = '$last_id' AND `user_id` = '$user_id' AND `activity_type`='".$app_lang['add_quote']."'";
      $res_activity = mysqli_query($mysqli,$sql_activity);

      $add_point=$settings_details['quotes_add']; 

      if($res_activity->num_rows == 0)
      {
        $qry2 = "SELECT * FROM tbl_users WHERE id = '$user_id'";
        $result2 = mysqli_query($mysqli,$qry2);
        $row2=mysqli_fetch_assoc($result2); 

        $user_total_point=$row2['total_point']+$add_point;

        $user_qry=mysqli_query($mysqli,"UPDATE tbl_users SET total_point='$user_total_point' WHERE id = '$user_id'");

        user_reward_activity($last_id,$user_id,$app_lang['add_quote'],$add_point);

      }
    }

    $_SESSION['class']='success';
    $_SESSION['msg']="10";
    
    if(isset($_GET['redirect']))
    {
      header("Location:".$_GET['redirect']);
    }
    else{
      header( "Location:add_quote.php");
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
    background-color: #E91E63;
    color: #FFF;
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
        <form action="" name="add_form" method="post" class="form form-horizontal" enctype="multipart/form-data">
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
                      <option value="<?php echo $cat_row['cid'];?>"><?php echo $cat_row['category_name'];?></option>                           
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
                    while($row=mysqli_fetch_assoc($res))
                    {
                      ?>                       
                      <option value="<?php echo $row['id'];?>"><?php echo $row['language_name'];?></option>
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
                <label class="col-md-3 control-label">Background :-</label>
                <div class="col-md-6">
                  <input value="e91e63" name="bg_color" onchange="update(this.jscolor)" class="form-control jscolor {position:'bottom',
                  borderColor:'#000', insetColor:'#FFF', backgroundColor:'#FFF'}">
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label">Quote:-</label>
                <div class="col-md-6">
                  <textarea name="quote" class="input-field" data-emojiable="true" data-emoji-input="unicode" type="text">Lorem ipsam !</textarea>
                  <input type="hidden" name="quotes_html" value="">
                </div>
              </div>
              <br/>

              <div class="form-group">
                <label class="col-md-3 control-label">Tags(Optional):-</label>
                <div class="col-md-6">
                  <input type="text" name="quote_tags[]" id="quote_tags" value="<?php  echo $row['quote_tags'];?>" data-role="tagsinput" class="form-control">
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label">Send notification:-</label>
                <div class="col-md-6" style="padding-top: 10px">
                  <input type="checkbox" id="ckbox_notify" class="cbx hidden" name="notify_user" value="true"/>
                  <label for="ckbox_notify" class="lbl"></label>
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
