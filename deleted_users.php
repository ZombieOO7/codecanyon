<?php 

$page_title="Deleted Users";
$active_page="user";

include('includes/header.php'); 
include("includes/connection.php");

include("includes/function.php");
include("language/language.php"); 

if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != ""){
	$url = $_SERVER['HTTP_REFERER'];
}else{
	$url = "deleted_users.php";
}

$keyword='';
if(isset($_GET['search']))
{

	$keyword=addslashes(trim($_GET['search']));

	$tableName="tbl_deleted_users";		
	$targetpage = "deleted_users.php?search=".$_GET['search']; 	
	$limit = 15; 

	$query = "SELECT COUNT(*) as num FROM $tableName WHERE `id`!='0' AND (tbl_deleted_users.`name` LIKE '%$keyword%' OR tbl_deleted_users.`email` LIKE '%$keyword%' OR tbl_deleted_users.`device_id` LIKE '%$keyword%')";
	$total_pages = mysqli_fetch_array(mysqli_query($mysqli,$query));
	$total_pages = $total_pages['num'];

	$stages = 1;
	$page=0;
	if(isset($_GET['page'])){
		$page = mysqli_real_escape_string($mysqli,$_GET['page']);
	}
	if($page){
		$start = ($page - 1) * $limit; 
	}else{
		$start = 0;	
	}


	$user_qry="SELECT * FROM tbl_deleted_users WHERE tbl_deleted_users.`id`!='0' AND (tbl_deleted_users.`name` LIKE '%$keyword%' OR tbl_deleted_users.`email` LIKE '%$keyword%' OR tbl_deleted_users.`device_id` LIKE '%$keyword%' OR tbl_deleted_users.`auth_id` LIKE '%$keyword%') ORDER BY tbl_deleted_users.`id` DESC LIMIT $start, $limit";

	$users_result=mysqli_query($mysqli,$user_qry);

}
else
{

	$tableName="tbl_deleted_users";		
	$targetpage = "deleted_users.php"; 	
	$limit = 15; 

	$query = "SELECT COUNT(*) as num FROM $tableName";
	$total_pages = mysqli_fetch_array(mysqli_query($mysqli,$query));
	$total_pages = $total_pages['num'];

	$stages = 1;
	$page=0;
	if(isset($_GET['page'])){
		$page = mysqli_real_escape_string($mysqli,$_GET['page']);
	}
	if($page){
		$start = ($page - 1) * $limit; 
	}else{
		$start = 0;	
	}	


	$users_qry="SELECT * FROM tbl_deleted_users ORDER BY tbl_deleted_users.`id` DESC LIMIT $start, $limit";  

	$users_result=mysqli_query($mysqli,$users_qry);

}

function highlightWords($text, $word){
	$text = preg_replace('#'. preg_quote($word) .'#i', '<span style="background-color: #F9F902;">\\0</span>', $text);
	return $text;
}
?>


<div class="row">
	<div class="col-xs-12">
		<div class="card mrg_bottom">
			<div class="page_title_block">
				<div class="col-md-5 col-xs-12">
					<div class="page_title"><?=$page_title?></div>
				</div>
				<div class="col-md-7 col-xs-12">              
					<div class="search_list">
						<div class="search_block">
							<form  method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
								<input class="form-control input-sm" placeholder="Search..." aria-controls="DataTables_Table_0" type="search" value="<?php if(isset($_GET['search'])){ echo $_GET['search']; } ?>" name="search" required>
								<button type="submit" class="btn-search"><i class="fa fa-search"></i></button>
							</form>  
						</div>
					</div> 
				</div>
				<div class="col-md-4 col-xs-12 text-right" style="float: right;">
					<button class="btn btn-danger btn_cust btn_delete_all" style="margin-bottom:20px;"><i class="fa fa-trash"></i> Delete All</button>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="col-md-12 mrg-top manage_user_btn">
				<table class="table table-striped table-bordered table-hover" style="overflow:scroll !important;">
					<thead>
						<tr>
							<th nowrap="">
								<div class="checkbox" style="margin-top: 0px;margin-bottom: 0px;">
									<input type="checkbox" name="checkall" id="checkall" value="">
									<label for="checkall"></label> 
								</div>

							</th>
							<th>Name</th>
							<th>Email/Google/Facebook ID</th>
							<th>Total Point</th>
							<th>Registered On</th>
							<th>Deleted On</th>
							<th class="text-center">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$i=0;

						if(mysqli_num_rows($users_result) > 0)
						{
							while($users_row=mysqli_fetch_array($users_result))
							{

								$device_id = !empty($keyword) ? highlightWords($users_row['device_id'], $keyword) : $users_row['device_id'];
								$name = !empty($keyword) ? highlightWords($users_row['name'], $keyword) : $users_row['name'];

								if($users_row['email']!='' AND $users_row['user_type']=='Normal')
								{
									$email = !empty($keyword)?highlightWords($users_row['email'], $keyword):$users_row['email'];	
								}
								else if($users_row['user_type']=='Google'){
									if($users_row['user_type']=='Google' AND $users_row['email']=='' AND $users_row['auth_id']!=''){
										$email = !empty($keyword)?highlightWords($users_row['auth_id'], $keyword):$users_row['auth_id'];
									}
									else{
										$email = !empty($keyword) ? highlightWords($users_row['email'], $keyword):$users_row['email'];
									}

								}
								else if($users_row['user_type']=='Facebook'){
									if($users_row['user_type']=='Facebook' AND $users_row['email']=='' AND $users_row['auth_id']!=''){
										$email = !empty($keyword)?highlightWords($users_row['auth_id'], $keyword):$users_row['auth_id'];
									}
									else{
										$email = !empty($keyword)?highlightWords($users_row['email'], $keyword):$users_row['email'];
									}

								} 
								?>
								<tr>
									<td> 
										<div>
											<div class="checkbox">
												<input type="checkbox" name="post_ids[]" id="checkbox<?php echo $i;?>" value="<?php echo $users_row['id']; ?>" class="post_ids">
												<label for="checkbox<?php echo $i;?>"></label>
											</div>
										</div>
									</td>
									<td style="word-break: break-all;"><?php echo $name;?></td>
									<td><?php echo $email;?></td>   
									<td><?php echo thousandsNumberFormat($users_row['total_point']);?></td>
									<td nowrap="">
										<?php echo ($users_row['registration_on']!='0') ? date('d-m-Y h:i A',$users_row['registration_on']) : 'not available';?>
									</td>
									<td nowrap=""><?php echo date('d-m-Y',$users_row['deleted_on']);?></td>
									<td nowrap="">
										<a href="" class="btn btn-success btn_details" data-toggle="tooltip" data-tooltip="More Details"><i class="fa fa-eye"></i></a>

										<!-- More Detail Modal -->
										<div class="more_details" style="display: none;">
											<div class="modal-header" style="padding-bottom: 10px;">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
												<h4 class="modal-title" style="margin-bottom: 10px"><?php echo ucwords($users_row['name']);?></h4>
												<p style="font-size: 14px;margin-bottom: 0px;padding-bottom: 0px"><strong>Email/Google/Facebook ID:</strong> <?php echo $email;?></p>
												<p style="font-size: 14px;margin-bottom: 0px;padding-bottom: 0px"><strong>Registered On:</strong> <?php echo date('d-m-Y',$users_row['registration_on']);?></p>
											</div>
											<div class="modal-body">
												<div class="row">
													<div class="col-md-6">
														<span class="badge badge-primary badge-icon" style="font-size: 16px"><i class="fa fa-video-camera" aria-hidden="true"></i><span>Total Videos: <?=thousandsNumberFormat($users_row['total_video'])?> </span></span>
														<br/><br/>
														<span class="badge badge-success badge-icon" style="font-size: 16px"><i class="fa fa-quote-right" aria-hidden="true"></i><span>Total Quote: <?=thousandsNumberFormat($users_row['total_quote'])?> </span></span>
														<br/><br/>
														<span class="badge badge-warning badge-icon" style="font-size: 16px"><i class="fa fa-image" aria-hidden="true"></i><span>Total Images: <?=thousandsNumberFormat($users_row['total_image'])?> </span></span>
														<br/><br/>
														<span class="badge badge-danger badge-icon" style="font-size: 16px"><i class="fa fa-spinner" aria-hidden="true"></i><span>Total GIF: <?=thousandsNumberFormat($users_row['total_gif'])?> </span></span>
													</div>
													<div class="col-md-6">
														<span class="badge badge-primary badge-icon" style="font-size: 16px"><i class="fa fa-money" aria-hidden="true"></i><span>Earn Points: <?=thousandsNumberFormat($users_row['total_point'])?> </span></span>
														<br/><br/>
														<span class="badge badge-success badge-icon" style="font-size: 16px"><i class="fa fa-money" aria-hidden="true"></i><span>Pending Points: <?=thousandsNumberFormat($users_row['pending_points'])?> </span></span>
														<br/><br/>
														<span class="badge badge-warning badge-icon" style="font-size: 16px"><i class="fa fa-users" aria-hidden="true"></i><span>Total Followers: <?=thousandsNumberFormat($users_row['total_followers'])?> </span></span>
														<br/><br/>
														<span class="badge badge-danger badge-icon" style="font-size: 16px"><i class="fa fa-users" aria-hidden="true"></i><span>Total Following: <?=thousandsNumberFormat($users_row['total_following'])?> </span></span>
													</div>

												</div>
												<br/>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
											</div>
										</div>
										<!-- End -->

										<a href="javascript:void(0)" data-id="<?php echo $users_row['id'];?>" class="btn btn-danger btn_delete_a" data-toggle="tooltip" data-tooltip="Delete"><i class="fa fa-trash"></i></a>
									</td>
								</tr>
								<?php	
								$i++;
							}
						}
						else{
							?>
							<tr>
								<td colspan="7" align="center">
									<h5 class="no_data">Sorry! no data</h5>
								</td>
							</tr>
							<?php
						}

						?>
					</tbody>
				</table>
				<!-- Pagination -->

				<div class="col-md-12 col-xs-12">
					<div class="pagination_item_block">
						<nav>
							<?php include("pagination.php");?>
						</nav>
					</div>
				</div>

			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</div> 

<div class="modal fade" id="moreDetailsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog">
		<div class="modal-content">
		</div>
	</div>
</div> 

<?php include('includes/footer.php');?> 


<script type="text/javascript">

	$(".btn_details").on("click", function(e){
		e.preventDefault();
		var html=$(this).next("div.more_details").html();
		$("#moreDetailsModal .modal-content").html('');
		$("#moreDetailsModal .modal-content").html(html);
		$("#moreDetailsModal").modal("show");
	});

	$(".btn_delete_a").on("click", function(e) {

		e.preventDefault();

		var _id = $(this).data("id");
		var _table = 'tbl_deleted_users';

		swal({
			title: "<?=$client_lang['are_you_sure_msg']?>",
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: "btn-danger",
			cancelButtonClass: "btn-warning",
			confirmButtonText: "Yes!",
			cancelButtonText: "No",
			closeOnConfirm: false,
			closeOnCancel: false,
			showLoaderOnConfirm: true
		},
		function(isConfirm) {
			if (isConfirm) {

				$.ajax({
					type: 'post',
					url: 'processData.php',
					dataType: 'json',
					data: {id: _id, for_action: 'delete', table: _table, 'action': 'multi_action'},
					success: function(res)
					{
						$('.notifyjs-corner').empty();

						if(res.status==1){
							location.reload();
						}
						else{
							swal({
								title: 'Error!', 
								text: "<?=$client_lang['something_went_worng_err']?>", 
								type: 'error'
							},function() {
								location.reload();
							});
						}
					}
				});
			} else {
				swal.close();
			}

		});
	});

	// for multiple deletes
	$(".btn_delete_all").on("click", function(e){

		var _table = 'tbl_deleted_users';

		var _ids = $.map($('.post_ids:checked'), function(c){return c.value; });
		var type=$(this).data('type');
		if(_ids!='')
		{
			swal({
				title: "<?=$client_lang['are_you_sure_msg']?>",
				type: "warning",
				showCancelButton: true,
				confirmButtonClass: "btn-danger btn_edit",
				cancelButtonClass: "btn-warning btn_edit",
				confirmButtonText: "Yes",
				cancelButtonText: "No",
				closeOnConfirm: false,
				closeOnCancel: false,
				showLoaderOnConfirm: true
			},

			function(isConfirm) {
				if (isConfirm) {
					$.ajax({
						type:'post',
						url:'processData.php',
						dataType:'json',
						data: {id: _ids, for_action: 'delete', table: _table, 'action': 'multi_action'},
						success:function(res)
						{
							$('.notifyjs-corner').empty();

							if(res.status==1){
								location.reload();
							}
							else{
								swal({
									title: 'Error!', 
									text: "<?=$client_lang['something_went_worng_err']?>", 
									type: 'error'
								},function() {
									location.reload();
								});
							}
						}
					});
				}
				else{
					swal.close();
				}

			});
		}
		else{
			swal({title: 'Sorry no records selected!', type: 'info'});
		}
	});

	var totalItems=0;

	$("#checkall").click(function () {

		totalItems=0;

		$('input:checkbox').not(this).prop('checked', this.checked);
		$.each($("input[name='post_ids[]']:checked"), function(){
			totalItems=totalItems+1;
		});

		if($('input:checkbox').prop("checked") == true){
			$('.notifyjs-corner').empty();
			$.notify(
				'Total '+totalItems+' item checked',
				{ position:"top center",className: 'success'}
				);
		}
		else if($('input:checkbox'). prop("checked") == false){
			totalItems=0;
			$('.notifyjs-corner').empty();
		}
	});

	var noteOption = {
		clickToHide : false,
		autoHide : false,
	}

	$.notify.defaults(noteOption);

	$(".post_ids").click(function(e){

		if($(this).prop("checked") == true){
			totalItems=totalItems+1;
		}
		else if($(this). prop("checked") == false){
			totalItems = totalItems-1;
		}

		if(totalItems==0){
			$('.notifyjs-corner').empty();
			exit();
		}

		$('.notifyjs-corner').empty();

		$.notify(
			'Total '+totalItems+' item checked',
			{ position:"top center",className: 'success'}
			);
	});

</script>