<?php 
  $page_title="Users Interaction";
  include("includes/header.php");
  include("includes/connection.php");
  require("includes/function.php");
  require("language/language.php");
?>
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="page_title_block">
        <div class="col-md-5 col-xs-12">
          <div class="page_title"><?=$page_title?></div>
        </div>
      </div>
      <div class="clearfix"></div>
      <?php if(isset($_SESSION['msg'])){?> 
      <div class="row mrg-top">
        <div class="col-md-12">
          <div class="col-md-12 col-sm-12">
             <div class="alert alert-success alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
              <?php echo $client_lang[$_SESSION['msg']] ; ?></div>
          </div>
        </div>
      </div>
      <?php unset($_SESSION['msg']);}?> 
      <div class="card-body mrg_bottom" style="padding: 0px"> 
        <ul class="nav nav-tabs" role="tablist" style="margin-bottom: 10px">
            <li role="presentation" class="active"><a href="manage_comments.php" aria-controls="comments"><i class="fa fa-comments"></i> Comments</a></li>
            <li role="presentation"><a href="" aria-controls="reports"><i class="fa fa-bug"></i> Reports</a></li> 
        </ul>
      </div>
    </div>
  </div>
</div>
        
<?php include("includes/footer.php");?>       

<script type="text/javascript">
  $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
    localStorage.setItem('activeTab', $(e.target).attr('href'));
  });

  var activeTab = localStorage.getItem('activeTab');
  if(activeTab){
    $('.nav-tabs a[href="' + activeTab + '"]').tab('show');
  }
</script>