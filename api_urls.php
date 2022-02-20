<?php 
    $page_title="Api Urls";
    include("includes/header.php");
    include("includes/function.php");

    $file_path = getBaseUrl().'api.php';

?>
    
<style type="text/css">
    .updatedApi{
        color: #a9b7c6;
    }
</style>

<div class="row">
      <div class="col-sm-12 col-xs-12">
     	 	<div class="card">
		        <div class="card-header">
		          Example API urls
		        </div>
       			    <div class="card-body no-padding">
         		
         			 <pre><code class="html">
                        <br><b>API URL</b> <?php echo $file_path;?>

                        <span class="updatedApi"><br><b>Home Status</b> (Method: home)(Parameter: user_id, lang_ids, page)</span>
                        <span class="updatedApi"><br><b>Related Status</b> (Method: related_status)(Parameter: post_id, user_id, cat_id, lang_ids, page)</span>
                        <br><b>Home Category List</b> (Method: home_cat_list)
                        <br><b>Category List</b> (Method: cat_list) (Parameters: page)
                        <span class="updatedApi"><br><b>Language List</b>(Method: get_language)(Parameter: lang_ids)</span>
                        <span class="updatedApi"><br><b>Category & Language List</b>(Method: get_cat_lang_list)</span>
                        <span class="updatedApi"><br><b>Status Favourite/Unfavourite</b> (Method: status_favourite) (Parameters: post_id, user_id, type[video, image, gif, quote])</span>
                        <span class="updatedApi"><br><b>Get Favourite List</b> (Method: get_favourite_status) (Parameters: user_id, page)</span>
                        <br><b>Status list by Cat ID</b> (Method: status_by_cat_id)(Parameter: cat_id, user_id, page, lang_ids)
                        <span class="updatedApi"><br><b>Single Status</b> (Method: single_status)(Parameter: status_id, user_id, lang_ids, type[video, image, gif, quote])</span>
                        <span class="updatedApi"><br><b>Single Status View Count</b> (Method: single_status_view_count)(Parameter: post_id, user_id, owner_id, type[video, image, gif, quote])</span>
                        <span class="updatedApi"><br><b>Status Download</b> (Method: single_status_download)(Parameter: post_id, user_id, type[video, image, gif])</span>
                        <span class="updatedApi"><br><b>Search Status</b> (Method: search_status)(Parameter: search_text, user_id, page, lang_ids)</span>
                        <br><b>User Email Verify</b> (Method: user_register_verify_email)(Parameter: email,otp_code)
                        <br><b>User Register</b> (Method: user_register)(Parameter: type (google, normal, facebook), device_id, name, email, password, phone, user_refrence_code, auth_id)
                        <br><b>User Login</b> (Method: user_login)(Parameter: email, password, player_id, user(Only for Check User's Login))
                        <span class="updatedApi"><br><b>Get User Data</b> (Method: get_user_data)(Parameter: user_id)</span>
                        <span class="updatedApi"><br><b>Delete User Account</b> (Method: delete_user_account)(Parameter: user_id, email)</span>
                        <span class="updatedApi"><br><b>Search Users</b> (Method: user_search)(Parameter: user_id, search_keyword, page)</span>
                        <br><b>Change Password</b> (Method: change_password)(Parameters: user_id, old_password, new_password)
                        <br><b>User Profile</b> (Method: user_profile)(Parameter: user_id)
                        <span class="updatedApi"><br><b>User Followers</b> (Method: user_followers)(Parameter: user_id, page)</span>
                        <span class="updatedApi"><br><b>User Following</b> (Method: user_following)(Parameter: user_id, page)</span>
                        <br><b>User Profile Update</b> (Method: user_profile_update)(Parameter: user_id, name, email, password, phone,user_image, user_youtube,user_instagram)
                        <br><b>Other User Profile</b> (Method: other_user_profile)(Parameter: other_user_id, user_id)
                        <br><b>User Status</b> (Method: user_status)(Parameter: user_id)
                        <br><b>Forgot Password</b> (Method: forgot_pass)(Parameter: email)
                        <span class="updatedApi"><br><b>User Rewards Points</b> (Method: user_rewads_point)(Parameter: user_id)</span>
                        <br><b>User Redeem Points History</b> (Method: user_redeem_points_history)(Parameter: user_id, redeem_id)
                        <br><b>User Redeem Request</b> (Method: user_redeem_request)(Parameter: user_id,user_points,payment_mode,bank_details)
                        <br><b>User Redeem History</b> (Method: user_redeem_history)(Parameter: user_id)
                        <span class="updatedApi"><br><b>User Video Upload</b>(Method: user_video_upload)(Parameter: user_id, cat_id, lang_ids(1,2,3), video_tags(a,b,c), video_title, video_layout) (Files: video_local, video_thumbnail)</span>
                        <span class="updatedApi"><br><b>User Status List</b> (Method: user_status_list)(Parameter: user_id, login_user, page)(login_user: true OR false)</span>
                        <span class="updatedApi"><br><b>User Status Delete</b> (Method: user_status_delete)(Parameter: user_id, post_id, type[video, image, gif, quote])</span>
                        <span class="updatedApi"><br><b>User Status Like</b> (Method: user_status_like)(Parameter: user_id, post_id, type[video, image, gif, quote])</span>
                        <span class="updatedApi"><br><b>Add Status Comment</b> (Method: add_status_comment)(Parameter: comment_text, user_id, post_id, type[video, image, gif, quote])</span>
                        <span class="updatedApi"><br><b>Status Comment Delete</b> (Method: delete_comment)(Parameter: comment_id, post_id, type)</span>
                        <span class="updatedApi"><br><b>Get Status Comments</b> (Method: get_all_comments) (Parameter: post_id, user_id, type[video, image, gif, quote], page)</span> 
                        <br><b>User Follow</b> (Method: user_follow)(Parameter: user_id, follower_id)
                        <br><b>User Contact Us</b> (Method: user_contact_us)(Parameter: contact_email, contact_name, contact_msg)
                        <span class="updatedApi"><br><b>Report Status</b> (Method: status_report)(Parameter: user_id, email, post_id, report_type, report_text, type[video, image, gif, quote])</span>
                        <br><b>Points Details</b> (Method: points_details)   
                        <br><b>Get Spinner</b> (Method: get_spinner) (Parameter: user_id)
                        <br><b>Save Spin Points</b> (Method: save_spinner_points) (Parameter: user_id, ponints)
                        <br><b>Get Redeem Transaction</b> (Method: get_transaction) (Parameter: redeem_id)  
                        <br><b>Porfile Verification</b> (Method: profile_verify) (Parameter: user_id,full_name, message)(Parameter: document (File))
                        <br><b>Porfile Status</b> (Method: profile_status) (Parameter: user_id) 
                        <br><b>Verification Details</b> (Method: verfication_details) (Parameter: user_id) 
                        <br><b>Get Contact Subject List</b> (Method: get_contact) (Parameters: user_id) 
                        <span class="updatedApi"><br><b>Upload Image/GIF Status</b> (Method: upload_img_gif_status) (Parameters: cat_id, user_id, lang_ids(1,2,3), image_tags(a,b,c), image_title, image_layout[Landscape OR Portrait], status_type[image OR gif])(File: image_file)</span>
                        <span class="updatedApi"><br><b>Upload Quote Status</b> (Method: upload_quote_status) (Parameters: cat_id, user_id, lang_ids(1,2,3), quote_tags(a,b,c), quote, quote_font, bg_color)</span>
                        <span class="updatedApi"><br><b>Check Daily Upload Limit</b> (Method: daily_upload_limit) (Parameter: user_id, type[video, image, gif, quote])</span>
                        <span class="updatedApi"><br><b>OTP Status</b> (Method: otp_status)</span>
                        <span class="updatedApi"><br><b>Upload Status Options</b> (Method: upload_status_opt)</span>
                        <span class="updatedApi"><br><b>Reward Points</b> (Method: reward_points) (Parameter: user_id)</span>
                        <span class="updatedApi"><br><b>Get Payment Mode</b> (Method: get_payment_mode)</span>
                        <span class="updatedApi"><br><b>App FAQ</b> (Method: app_faq)</span>
                        <span class="updatedApi"><br><b>App Privacy Policy</b> (Method: app_privacy_policy)</span>
                        <span class="updatedApi"><br><b>App Terms &amp; Conditions</b> (Method: app_term_condition)</span>
                        <span class="updatedApi"><br><b>App About</b> (Method: app_about)</span>
                        <span class="updatedApi"><br><b>Apply User Refrence Code</b> (Method: apply_user_refrence_code) (Parameter: user_id, user_refrence_code)</span>
                        <span class="updatedApi"><br><b>App Settings</b> (Method: app_settings)</span>
                 
       				</div>
          	</div>
        </div>
</div>
<br/>
<div class="clearfix"></div>
        
<?php include("includes/footer.php");?>    
