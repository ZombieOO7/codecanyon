<?php 

$page_title="Verification Requests";

include('includes/header.php'); 
include("includes/connection.php");

include("includes/function.php");
include("language/language.php"); 

$sql_verify="SELECT varify_u.*, user.`name`, user.`email` FROM tbl_verify_user varify_u, tbl_users user WHERE varify_u.`user_id`=user.`id` AND varify_u.`status`='0' ORDER BY varify_u.`id` DESC";

$res_verify=mysqli_query($mysqli, $sql_verify) or die(mysqli_error($mysqli));

?>

<style type="text/css">
  .top{
    position: relative !important;
    padding: 0px 0px 20px 0px !important;
  }
  .dataTables_wrapper .top .dataTables_filter .form-control{
    border-radius: 3px !important;
    border-color: #ccc !important;
    box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075) !important;
  }
</style>

<div class="row">
  <div class="col-xs-12">
    <div class="card mrg_bottom">
      <div class="page_title_block">
        <div class="col-md-5 col-xs-12">
          <div class="page_title"><?=$page_title?></div>
        </div>
      </div>
      <div class="clearfix"></div>
      <div class="col-md-12 mrg-top manage_user_btn">
      	<table class="datatable table table-striped table-bordered table-hover">
          <thead>
            <tr>	
              <th>Name</th>						 
              <th>Email</th>			
              <th>Full Name</th>			
              <th nowrap="">Requested On</th>	 
              <th class="text-center">Action</th>
            </tr>
          </thead>
          <tbody>
           <?php
           $i=0;
           while($row=mysqli_fetch_array($res_verify))
           {		 
            ?>
            <tr>
             <td><?php echo $row['name'];?></td>
             <td><?php echo $row['email'];?></td> 
             <td><?php echo $row['full_name'];?></td>   
             <td><?php echo date('d M, Y',$row['created_at']);?></td> 
             <td class="text-center" nowrap="">
               <a href="javascript:void(0)" class="btn btn-success btn_edit btn_verify" data-id="<?=$row['id']?>" data-toggle="tooltip" data-tooltip="User verification"><i class="fa fa-check"></i> Verify</a>
               <a href="javascript:void(0)" data-id="<?php echo $row['id'];?>" class="btn btn-danger btn_delete_a" data-toggle="tooltip" data-tooltip="Delete"><i class="fa fa-trash"></i></a>
             </td>
           </tr>
           <?php	
           $i++;
         }
         ?>
       </tbody>
     </table>
   </div>
   <div class="clearfix"></div>
 </div>
</div>
</div> 

<?php include('includes/footer.php');?>                  

<script type="text/javascript">

	$("li.dropdown-header").nextAll("li").remove();
	$.ajax({
    type:'post',
    url:'processData.php',
    dataType:'json',
    data:{'action':'openAllNotify'},
    success:function(data){
      console.log(data.content[0]);
      $(".notify_count").html(data.count);
      $.each(data.content, function(index, item) {
        $(".dropdown-header").after(item);
      });
    }
  });


  $(".btn_delete_a").on("click", function(e) {

    e.preventDefault();

    var _id = $(this).data("id");
    var _table = 'tbl_verify_user';

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

</script>