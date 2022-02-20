<?php 

$page_title="Status Rewards Points";
$active_page="settings";

include("includes/header.php");

require("includes/function.php");
require("language/language.php");


$qry="SELECT * FROM tbl_settings WHERE id='1'";
$result=mysqli_query($mysqli,$qry);
$settings_row=mysqli_fetch_assoc($result);


if(isset($_POST['rewards_points_submit']))
{

  $data = array(
    'redeem_points'  =>  addslashes(trim($_POST['redeem_points'])),
    'redeem_money'  =>  addslashes(trim($_POST['redeem_money'])),
    'redeem_currency'  =>  addslashes(trim($_POST['redeem_currency'])),
    'minimum_redeem_points'  =>  addslashes(trim($_POST['minimum_redeem_points'])),
    'registration_reward'  =>  addslashes(trim($_POST['registration_reward'])),
    'app_refer_reward'  =>  addslashes(trim($_POST['app_refer_reward'])),

    'video_views'  =>  addslashes(trim($_POST['video_views'])),
    'video_add'  =>  addslashes(trim($_POST['video_add'])),
    'like_video_points'  =>  addslashes(trim($_POST['like_video_points'])),
    'download_video_points'  =>  addslashes(trim($_POST['download_video_points'])),
    'video_views_status'  =>  $_POST['video_views_status'] ? 'true' : 'false',
    'video_add_status'  =>  $_POST['video_add_status'] ? 'true' : 'false',
    'like_video_points_status'  =>  $_POST['like_video_points_status'] ? 'true' : 'false',
    'download_video_points_status'  =>  $_POST['download_video_points_status'] ? 'true' : 'false',
    'other_user_video_status'  =>  $_POST['other_user_video_status'] ? 'true' : 'false',
    'other_user_video_point'  =>  addslashes(trim($_POST['other_user_video_point'])),

    'image_add'  =>  addslashes(trim($_POST['image_add'])),
    'image_add_status'  =>  $_POST['image_add_status'] ? $_POST['image_add_status'] : 'false',

    'image_views'  =>  addslashes(trim($_POST['image_views'])),

    'other_user_image_point'  =>  addslashes(trim($_POST['other_user_image_point'])),
    'other_user_image_status'  =>  $_POST['other_user_image_status'] ? $_POST['other_user_image_status'] : 'false',

    'like_image_points'  =>  addslashes(trim($_POST['like_image_points'])),
    'like_image_points_status'  =>  $_POST['like_image_points_status'] ? $_POST['like_image_points_status'] : 'false',

    'download_image_points'  =>  addslashes(trim($_POST['download_image_points'])),
    'download_image_points_status'  =>  $_POST['download_image_points_status'] ? $_POST['download_image_points_status'] : 'false',

    'gif_add'  =>  addslashes(trim($_POST['gif_add'])),
    'gif_add_status'  =>  $_POST['gif_add_status'] ? $_POST['gif_add_status'] : 'false',

    'gif_views'  =>  addslashes(trim($_POST['gif_views'])),

    'other_user_gif_point'  =>  addslashes(trim($_POST['other_user_gif_point'])),
    'other_user_gif_status'  =>  $_POST['other_user_gif_status'] ? $_POST['other_user_gif_status'] : 'false',

    'like_gif_points'  =>  addslashes(trim($_POST['like_gif_points'])),
    'like_gif_points_status'  =>  $_POST['like_gif_points_status'] ? $_POST['like_gif_points_status'] : 'false',

    'download_gif_points'  =>  addslashes(trim($_POST['download_gif_points'])),
    'download_gif_points_status'  =>  $_POST['download_gif_points_status'] ? $_POST['download_gif_points_status'] : 'false',

    'quotes_add'  =>  addslashes(trim($_POST['quotes_add'])),
    'quotes_add_status'  =>  $_POST['quotes_add_status'] ? $_POST['quotes_add_status'] : 'false',

    'quotes_views'  =>  addslashes(trim($_POST['quotes_views'])),

    'other_user_quotes_point'  =>  addslashes(trim($_POST['other_user_quotes_point'])),
    'other_user_quotes_status'  =>  $_POST['other_user_quotes_status'] ? $_POST['other_user_quotes_status'] : 'false',

    'like_quotes_points'  =>  addslashes(trim($_POST['like_quotes_points'])),
    'like_quotes_points_status'  =>  $_POST['like_quotes_points_status'] ? $_POST['like_quotes_points_status'] : 'false',
  );

  $settings_edit=Update('tbl_settings', $data, "WHERE id = '1'");



  $_SESSION['msg']="11";
  header( "Location:rewards_points.php");
  exit;

}

?>

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-body">

      </div>
      <div class="clearfix"></div>
        <div class="card-body pt_top">

          <div class="rewards_point_page_title">
            <div class="col-md-12 col-xs-12">
              <div class="page_title" style="font-size: 20px;color: #424242;">
                <h3><?=$page_title?></h3>
              </div>
            </div>              
          </div>      
          <form action="" name="admob_settings" method="post" class="form form-horizontal" enctype="multipart/form-data">
            <div class="col-md-12">
              <div class="form-group reward_point_block">
                <div class="col-md-12">
                  <div class="col-md-6 col-sm-8">
                    <div class="form-group">
                      <div class="col-md-7 col-sm-5 points_block mrg_right">
                        <div class="col-md-5">
                          <label class="control-label">Points</label>
                          <input type="text" name="redeem_points" id="redeem_points" value="<?php echo $settings_row['redeem_points'];?>" class="form-control">
                        </div>
                        <div class="col-md-2">
                          <label class="col-md-2 control-label point_count">=</label>
                        </div>
                        <div class="col-md-5">
                          <label class="control-label">Amount</label>
                          <input type="text" name="redeem_money" id="redeem_money" value="<?php echo $settings_row['redeem_money'];?>" class="form-control">
                        </div>  
                      </div>                      
                      <div class="col-md-4 col-sm-6 points_block points_amount">
                        <label class="control-label">Currency Code</label>
                        <input type="text" name="redeem_currency" id="redeem_currency" value="<?php echo $settings_row['redeem_currency'];?>" class="form-control">
                      </div>                    
                    </div>
                  </div>
                  <div class="col-md-4 col-sm-4 redeem_point_section">                    
                    <div class="col-md-12 points_block minimum_redeem_point">
                      <label class="control-label">Minimum Redeem Points</label>  
                      <input type="number" min="1" name="minimum_redeem_points" id="minimum_redeem_points" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="<?php echo $settings_row['minimum_redeem_points'];?>" class="form-control">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="mrg-top manage_user_btn manage_rewards_point_block">
              <div class="row">
                <div class="col-md-12">
                  <table class="table table-striped table-bordered table-hover">
                    <thead>
                      <tr>
                        <th style="width:300px">Activity Name</th>
                        <th style="width:50px">Points</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>            
                        <td>App Registration Points:-</td>
                        <td><input type="text" name="registration_reward" onkeypress="return event.charCode >= 48 && event.charCode <= 57" id="registration_reward" value="<?php echo $settings_row['registration_reward'];?>" class="form-control limit_0"></td>
                      </tr>
                      <tr>            
                        <td>App Refer Points:-</td>
                        <td><input type="text" name="app_refer_reward" onkeypress="return event.charCode >= 48 && event.charCode <= 57" id="app_refer_reward" value="<?php echo $settings_row['app_refer_reward'];?>" class="form-control limit_0"></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <hr/>
              <div class="row">
                <div class="col-md-12">
                  <h4><i class="fa fa-video-camera"></i> Video Status Reward Points</h4>
                  <table class="table table-striped table-bordered table-hover">
                    <thead>
                      <tr>
                        <th style="width:300px">Activity Name</th>
                        <th style="width:50px">Points</th>
                        <th style="width:50px">Enable/Disable</th>             
                      </tr>
                    </thead>
                    <tbody>
                      <tr>  
                        <td>Video Add Points:-</td>
                        <td><input type="text" name="video_add" id="video_add" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="<?php echo $settings_row['video_add'];?>" class="form-control limit_0"></td>
                        <td>
                          <div class="row toggle_btn">
                            <p style="float: right;">&nbsp;&nbsp;Rewarded Ads Status</p>
                            <input type="checkbox" id="checked05" class="cbx hidden" name="video_add_status" value="true" <?php if($settings_row['video_add_status']=='true'){?>checked <?php }?>/>
                            <label for="checked05" class="lbl" style="float: left"></label>
                          </div>
                        </td>
                      </tr>
                      <tr>            
                        <td>Video View Points :-</td>
                        <td><input type="text" name="video_views" id="video_views" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="<?php echo $settings_row['video_views'];?>" class="form-control limit_0"></td>
                        <td>
                          <div class="row toggle_btn">
                            <p style="float: right;">&nbsp;&nbsp;Rewarded Ads Status</p>
                            <input type="checkbox" id="checked04" class="cbx hidden" name="video_views_status" value="true" <?php if($settings_row['video_views_status']=='true'){?>checked <?php }?>/>
                            <label for="checked04" class="lbl" style="float: left"></label>
                          </div>
                        </td>
                      </tr>
                      <tr>            
                        <td>Video Points Viewed By Others:-</td>
                        <td><input type="text" name="other_user_video_point" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="<?php echo $settings_row['other_user_video_point'];?>" class="form-control limit_0"></td>
                        <td>
                          <div class="row toggle_btn">
                            <p style="float: right;">&nbsp;&nbsp;Enable/Disable</p>
                            <input type="checkbox" id="checked09" class="cbx hidden" name="other_user_video_status" value="true" <?php if($settings_row['other_user_video_status']=='true'){?>checked <?php }?>/>
                            <label for="checked09" class="lbl" style="float: left"></label>
                          </div>
                        </td>
                      </tr>
                      <tr>            
                        <td>Video Like Points:-</td>
                        <td><input type="text" name="like_video_points" onkeypress="return event.charCode >= 48 && event.charCode <= 57" id="like_video_points" value="<?php echo $settings_row['like_video_points'];?>" class="form-control limit_0"></td>
                        <td>
                          <div class="row toggle_btn">
                            <p style="float: right;">&nbsp;&nbsp;Rewarded Ads Status</p>
                            <input type="checkbox" id="checked06" class="cbx hidden" name="like_video_points_status" value="true" <?php if($settings_row['like_video_points_status']=='true'){?>checked <?php }?>/>
                            <label for="checked06" class="lbl" style="float: left"></label>
                          </div>
                        </td>
                      </tr>
                      <tr>            
                        <td>Video Download Points:-</td>
                        <td><input type="text" name="download_video_points" onkeypress="return event.charCode >= 48 && event.charCode <= 57" id="download_video_points" value="<?php echo $settings_row['download_video_points'];?>" class="form-control limit_0"></td>
                        <td>
                          <div class="row toggle_btn">
                            <p style="float: right;">&nbsp;&nbsp;Rewarded Ads Status</p>
                            <input type="checkbox" id="checked07" class="cbx hidden" name="download_video_points_status" value="true" <?php if($settings_row['download_video_points_status']=='true'){?>checked <?php }?>/>
                            <label for="checked07" class="lbl" style="float: left"></label>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>

                  <br/>
                  <b><i class="fa fa-hand-o-right"></i> Note for Video Points Viewed By Others</b>   
                  <p style="color:red;padding-top:7px">
                    <strong>Enable -</strong> Video status owner gets points when other user views video
                    <br/>
                    <strong>Disable -</strong> Video status owner will not get points when other user views video
                  </p>

                </div>

              </div>
            </div>
            <hr/>
            <div class="mrg-top manage_user_btn manage_rewards_point_block">
              <div class="row">
                <div class="col-md-12">
                  <h4><i class="fa fa-image"></i> Image Status Reward Points</h4>
                  <table class="table table-striped table-bordered table-hover">
                    <thead>
                      <tr>
                        <th style="width:300px">Activity Name</th>
                        <th style="width:50px">Points</th>
                        <th style="width:50px">Enable/Disable</th>             
                      </tr>
                    </thead>
                    <tbody>
                      <tr>            
                        <td>Image Add Points:-</td>
                        <td><input type="text" name="image_add" id="image_add" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="<?php echo $settings_row['image_add'];?>" class="form-control limit_0"></td>
                        <td>
                          <div class="row toggle_btn">
                            <p style="float: right;">&nbsp;&nbsp;Rewarded Ads Status</p>
                            <input type="checkbox" id="chk_img_add" class="cbx hidden" name="image_add_status" value="true" <?php if($settings_row['image_add_status']=='true'){?>checked <?php }?>/>
                            <label for="chk_img_add" class="lbl" style="float: left"></label>
                          </div>
                        </td>
                      </tr>

                      <tr>            
                        <td>Image View Points :-</td>
                        <td><input type="text" name="image_views" id="image_views" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="<?php echo $settings_row['image_views'];?>" class="form-control limit_0"></td>
                        <td>
                        </div>
                      </td>
                    </tr>

                    <tr>            
                      <td>Image Points Viewed By Others:-</td>
                      <td><input type="text" name="other_user_image_point" onkeypress="return event.charCode >= 48 && event.charCode <= 57" id="other_user_image_point" value="<?php echo $settings_row['other_user_image_point'];?>" class="form-control limit_0"></td>
                      <td>
                        <div class="row toggle_btn">
                          <p style="float: right;">&nbsp;&nbsp;Enable/Disable</p>
                          <input type="checkbox" id="chk_img_other" class="cbx hidden" name="other_user_image_status" value="true" <?php if($settings_row['other_user_image_status']=='true'){?>checked <?php }?>/>
                          <label for="chk_img_other" class="lbl" style="float: left"></label>
                        </div>
                      </td>
                    </tr>

                    <tr>            
                      <td>Image Like Points:-</td>
                      <td><input type="text" name="like_image_points" onkeypress="return event.charCode >= 48 && event.charCode <= 57" id="like_image_points" value="<?php echo $settings_row['like_image_points'];?>" class="form-control limit_0"></td>
                      <td>
                        <div class="row toggle_btn">
                          <p style="float: right;">&nbsp;&nbsp;Rewarded Ads Status</p>
                          <input type="checkbox" id="chk_img_like" class="cbx hidden" name="like_image_points_status" value="true" <?php if($settings_row['like_image_points_status']=='true'){?>checked <?php }?>/>
                          <label for="chk_img_like" class="lbl" style="float: left"></label>
                        </div>
                      </td>
                    </tr>

                    <tr>            
                      <td>Image Download Points:-</td>
                      <td><input type="text" name="download_image_points" onkeypress="return event.charCode >= 48 && event.charCode <= 57" id="download_image_points" value="<?php echo $settings_row['download_image_points'];?>" class="form-control limit_0"></td>
                      <td>
                        <div class="row toggle_btn">
                          <p style="float: right;">&nbsp;&nbsp;Rewarded Ads Status</p>
                          <input type="checkbox" id="chk_img_download" class="cbx hidden" name="download_image_points_status" value="true" <?php if($settings_row['download_image_points_status']=='true'){?>checked <?php }?>/>
                          <label for="chk_img_download" class="lbl" style="float: left"></label>
                        </div>
                      </td>
                    </tr> 
                  </tbody>
                </table>
                <br/>
                <b><i class="fa fa-hand-o-right"></i> Note for Image Points Viewed By Others</b>   
                <p style="color:red;padding-top:7px">
                  <strong>Enable -</strong> Image status owner gets points when other user views image
                  <br/>
                  <strong>Disable -</strong> Image status owner will not get points when other user views image
                </p>
              </div>
            </div>
          </div>
          <hr/>
          <div class="mrg-top manage_user_btn manage_rewards_point_block">
            <div class="row">
              <div class="col-md-12">
                <h4><i class="fa fa-spinner"></i> GIF Status Reward Points</h4>
                <table class="table table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <th style="width:300px">Activity Name</th>
                      <th style="width:50px">Points</th>
                      <th style="width:50px">Enable/Disable</th>             
                    </tr>
                  </thead>
                  <tbody>
                    <tr>            
                      <td>GIF Add Points:-</td>
                      <td><input type="text" name="gif_add" onkeypress="return event.charCode >= 48 && event.charCode <= 57" id="gif_add" value="<?php echo $settings_row['gif_add'];?>" class="form-control limit_0"></td>
                      <td>
                        <div class="row toggle_btn">
                          <p style="float: right;">&nbsp;&nbsp;Rewarded Ads Status</p>
                          <input type="checkbox" id="chk_gif_add" class="cbx hidden" name="gif_add_status" value="true" <?php if($settings_row['gif_add_status']=='true'){?>checked <?php }?>/>
                          <label for="chk_gif_add" class="lbl" style="float: left"></label>
                        </div>
                      </td>
                    </tr>

                    <tr>            
                      <td>GIF View Points :-</td>
                      <td><input type="text" name="gif_views" onkeypress="return event.charCode >= 48 && event.charCode <= 57" id="gif_views" value="<?php echo $settings_row['gif_views'];?>" class="form-control limit_0"></td>
                      <td>
                      </td>
                    </tr>

                    <tr>            
                      <td>GIF Points Viewed By Others:-</td>
                      <td><input type="text" name="other_user_gif_point" onkeypress="return event.charCode >= 48 && event.charCode <= 57" id="other_user_gif_point" value="<?php echo $settings_row['other_user_gif_point'];?>" class="form-control limit_0"></td>
                      <td>
                        <div class="row toggle_btn">
                          <p style="float: right;">&nbsp;&nbsp;Enable/Disable</p>
                          <input type="checkbox" id="chk_gif_other" class="cbx hidden" name="other_user_gif_status" value="true" <?php if($settings_row['other_user_gif_status']=='true'){?>checked <?php }?>/>
                          <label for="chk_gif_other" class="lbl" style="float: left"></label>
                        </div>
                      </td>
                    </tr>

                    <tr>            
                      <td>GIF Like Points:-</td>
                      <td><input type="text" name="like_gif_points" onkeypress="return event.charCode >= 48 && event.charCode <= 57" id="like_gif_points" value="<?php echo $settings_row['like_gif_points'];?>" class="form-control limit_0"></td>
                      <td>
                        <div class="row toggle_btn">
                          <p style="float: right;">&nbsp;&nbsp;Rewarded Ads Status</p>
                          <input type="checkbox" id="chk_gif_like" class="cbx hidden" name="like_gif_points_status" value="true" <?php if($settings_row['like_gif_points_status']=='true'){?>checked <?php }?>/>
                          <label for="chk_gif_like" class="lbl" style="float: left"></label>
                        </div>
                      </td>
                    </tr>

                    <tr>            
                      <td>GIF Download Points:-</td>
                      <td><input type="text" name="download_gif_points" onkeypress="return event.charCode >= 48 && event.charCode <= 57" id="download_gif_points" value="<?php echo $settings_row['download_gif_points'];?>" class="form-control limit_0"></td>
                      <td>
                        <div class="row toggle_btn">
                          <p style="float: right;">&nbsp;&nbsp;Rewarded Ads Status</p>
                          <input type="checkbox" id="chk_gif_download" class="cbx hidden" name="download_gif_points_status" value="true" <?php if($settings_row['download_gif_points_status']=='true'){?>checked <?php }?>/>
                          <label for="chk_gif_download" class="lbl" style="float: left"></label>
                        </div>
                      </td>
                    </tr> 
                  </tbody>
                </table>
                <br/>
                <b><i class="fa fa-hand-o-right"></i> Note for GIF Points Viewed By Others</b>   
                <p style="color:red;padding-top:7px">
                  <strong>Enable -</strong> GIF status owner gets points when other user views gif
                  <br/>
                  <strong>Disable -</strong> GIF status owner will not get points when other user views gif
                </p>
              </div>
            </div>
          </div>
          <!-- for quote status rewards -->
          <hr/>
          <div class="mrg-top manage_user_btn manage_rewards_point_block">
            <div class="row">
              <div class="col-md-12">
                <h4><i class="fa fa-quote-right"></i> Text Quotes Status Reward Points</h4>
                <table class="table table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <th style="width:300px">Activity Name</th>
                      <th style="width:50px">Points</th>
                      <th style="width:50px">Enable/Disable</th>             
                    </tr>
                  </thead>
                  <tbody>
                    <tr>            
                      <td>Text Quotes Add Points:-</td>
                      <td><input type="text" name="quotes_add" onkeypress="return event.charCode >= 48 && event.charCode <= 57" id="quotes_add" value="<?php echo $settings_row['quotes_add'];?>" class="form-control limit_0"></td>
                      <td>
                        <div class="row toggle_btn">
                          <p style="float: right;">&nbsp;&nbsp;Rewarded Ads Status</p>
                          <input type="checkbox" id="chk_quotes_add" class="cbx hidden" name="quotes_add_status" value="true" <?php if($settings_row['quotes_add_status']=='true'){?>checked <?php }?>/>
                          <label for="chk_quotes_add" class="lbl" style="float: left"></label>
                        </div>
                      </td>
                    </tr>

                    <tr>            
                      <td>Text Quotes View Points :-</td>
                      <td><input type="text" name="quotes_views" onkeypress="return event.charCode >= 48 && event.charCode <= 57" id="quotes_views" value="<?php echo $settings_row['quotes_views'];?>" class="form-control limit_0"></td>
                      <td>
                      </td>
                    </tr>

                    <tr>            
                      <td>Text Quotes Points Viewed By Others:-</td>
                      <td><input type="text" name="other_user_quotes_point" onkeypress="return event.charCode >= 48 && event.charCode <= 57" id="other_user_quotes_point" value="<?php echo $settings_row['other_user_quotes_point'];?>" class="form-control limit_0"></td>
                      <td>
                        <div class="row toggle_btn">
                          <p style="float: right;">&nbsp;&nbsp;Enable/Disable</p>
                          <input type="checkbox" id="chk_quotes_other" class="cbx hidden" name="other_user_quotes_status" value="true" <?php if($settings_row['other_user_quotes_status']=='true'){?>checked <?php }?>/>
                          <label for="chk_quotes_other" class="lbl" style="float: left"></label>
                        </div>
                      </td>
                    </tr>

                    <tr>            
                      <td>Text Quotes Like Points:-</td>
                      <td><input type="text" name="like_quotes_points" onkeypress="return event.charCode >= 48 && event.charCode <= 57" id="like_quotes_points" value="<?php echo $settings_row['like_quotes_points'];?>" class="form-control limit_0"></td>
                      <td>
                        <div class="row toggle_btn">
                          <p style="float: right;">&nbsp;&nbsp;Rewarded Ads Status</p>
                          <input type="checkbox" id="chk_quotes_like" class="cbx hidden" name="like_quotes_points_status" value="true" <?php if($settings_row['like_quotes_points_status']=='true'){?>checked <?php }?>/>
                          <label for="chk_quotes_like" class="lbl" style="float: left"></label>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <br/>
                <b><i class="fa fa-hand-o-right"></i> Note for Text Quotes Points Viewed By Others</b>   
                <p style="color:red;padding-top:7px">
                  <strong>Enable -</strong> Text Quotes status owner gets points when other user views quote
                  <br/>
                  <strong>Disable -</strong> Text Quotes status owner will not get points when other user views quote
                </p>
              </div>
            </div>
          </div>
          <hr/>
          <div align="center" class="form-group">
            <div class="col-md-12">
              <button type="submit" name="rewards_points_submit" class="btn btn-primary ">Save</button>
            </div>
          </div>
          <!-- End -->

        </form>

        <b><i class="fa fa-hand-o-right"></i> Note:</b>   
        <p style="color:red;padding-top:7px">If you want to show rewards status ads on listed activity you have to ENABLE <strong>Rewarded Ads Status</strong>.</p>
        
        

      </div>
      <div class="clearfix"></div>
    </div>
  </div>

</div>


<?php include("includes/footer.php");?>    

<script type="text/javascript">
  $("#other_user_video_point").keyup(function(e){
    if($(this).val()==''){
      $(this).val('0');
    }
  });

  $(".limit_0").blur(function(e){
    if($(this).val() < 0 || $(this).val() == '')
    {
      $(this).val("0");
    }
  });
</script>   
