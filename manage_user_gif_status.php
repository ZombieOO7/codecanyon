<?php 
    $page_title="Users GIF Status";
    $active_page="status";

    include("includes/header.php");
    include("includes/connection.php");

    require("includes/function.php");
    require("language/language.php");

    $targetpage = 'manage_user_gif_status.php';
    $limit = 12;

    $stages = 3;
    $page=0;
    if(isset($_GET['page'])){
      $page = mysqli_real_escape_string($mysqli,$_GET['page']);
    }
    if($page){
      $start = ($page - 1) * $limit; 
    }else{
      $start = 0; 
    }

    $keyword='';

    //Get all images
    if(isset($_GET['status']))
    {
      if($_GET['status']=='enable'){
        $status="tbl_img_status.`status`='1'";
      }
      else if($_GET['status']=='disable'){
        $status="tbl_img_status.`status`='0'";
      }
      else if($_GET['status']=='slider'){
        $status="tbl_img_status.`featured`='1'";
      }
      else if($_GET['status']=='no_slider'){
        $status="tbl_img_status.`featured`='0'";
      }
      else if($_GET['status']=='portrait'){
        $status="tbl_img_status.`image_layout`='Portrait'";
      }
      else if($_GET['status']=='landscape'){
        $status="tbl_img_status.`image_layout`='Landscape'";
      }

      $query="SELECT tbl_category.`category_name`,tbl_img_status.* FROM tbl_img_status
              LEFT JOIN tbl_category ON tbl_img_status.`cat_id`= tbl_category.`cid` 
              WHERE tbl_img_status.`user_id` <> '0' AND tbl_img_status.`status_type`='gif' AND $status ORDER BY tbl_img_status.`id` DESC";

      $sql_query="SELECT tbl_category.`category_name`,tbl_img_status.* FROM tbl_img_status
              LEFT JOIN tbl_category ON tbl_img_status.`cat_id`= tbl_category.`cid` 
              WHERE tbl_img_status.`user_id` <> '0' AND tbl_img_status.`status_type`='gif' AND $status ORDER BY tbl_img_status.`id` DESC LIMIT $start, $limit";

      $targetpage = 'manage_user_gif_status.php?status='.$_GET['status'];

      if(isset($_GET['category']))
      {

        $category=trim($_GET['category']);

        $query="SELECT tbl_category.`category_name`,tbl_img_status.* FROM tbl_img_status
                  LEFT JOIN tbl_category ON tbl_img_status.`cat_id`= tbl_category.`cid` 
                  WHERE tbl_img_status.`user_id` <> '0' AND tbl_img_status.`status_type`='gif' AND $status AND tbl_img_status.`cat_id`='$category' ORDER BY tbl_img_status.`id` DESC";

        $sql_query="SELECT tbl_category.`category_name`,tbl_img_status.* FROM tbl_img_status
                  LEFT JOIN tbl_category ON tbl_img_status.`cat_id`= tbl_category.`cid` 
                  WHERE tbl_img_status.`user_id` <> '0' AND tbl_img_status.`status_type`='gif' AND $status AND tbl_img_status.`cat_id`='$category' ORDER BY tbl_img_status.`id` DESC LIMIT $start, $limit";

        $targetpage = 'manage_user_gif_status.php?status='.$_GET['status'].'&category='.$category;

        if(isset($_GET['language']))
        {

          $language=trim($_GET['language']);

          $query="SELECT tbl_category.`category_name`,tbl_img_status.* FROM tbl_img_status
                  LEFT JOIN tbl_category ON tbl_img_status.`cat_id`= tbl_category.`cid` 
                  WHERE tbl_img_status.`user_id` <> '0' AND tbl_img_status.`status_type`='gif' AND $status AND tbl_img_status.`cat_id`='$category' AND FIND_IN_SET('$language', tbl_img_status.`lang_ids`) ORDER BY tbl_img_status.`id` DESC";

          $sql_query="SELECT tbl_category.`category_name`,tbl_img_status.* FROM tbl_img_status
                  LEFT JOIN tbl_category ON tbl_img_status.`cat_id`= tbl_category.`cid` 
                  WHERE tbl_img_status.`user_id` <> '0' AND tbl_img_status.`status_type`='gif' AND $status AND tbl_img_status.`cat_id`='$category' AND FIND_IN_SET('$language', tbl_img_status.`lang_ids`) ORDER BY tbl_img_status.`id` DESC LIMIT $start, $limit";

          $targetpage = 'manage_user_gif_status.php?status='.$_GET['status'].'&category='.$category.'&language='.$language;

          if(isset($_GET['keyword']))
          {
            $keyword=addslashes(trim($_GET['keyword']));

            $query="SELECT tbl_category.`category_name`,tbl_img_status.* FROM tbl_img_status
                  LEFT JOIN tbl_category ON tbl_img_status.`cat_id`= tbl_category.`cid` 
                  WHERE tbl_img_status.`user_id` <> '0' AND tbl_img_status.`status_type`='gif' AND $status AND tbl_img_status.`cat_id`='$category' AND FIND_IN_SET('$language', tbl_img_status.`lang_ids`) AND (tbl_img_status.`image_title` LIKE '%$keyword%' OR tbl_img_status.`image_tags` LIKE '%$keyword%' OR tbl_category.`category_name` LIKE '%$keyword%') ORDER BY tbl_img_status.`id` DESC";

            $sql_query="SELECT tbl_category.`category_name`,tbl_img_status.* FROM tbl_img_status
                  LEFT JOIN tbl_category ON tbl_img_status.`cat_id`= tbl_category.`cid` 
                  WHERE tbl_img_status.`user_id` <> '0' AND tbl_img_status.`status_type`='gif' AND $status AND tbl_img_status.`cat_id`='$category' AND FIND_IN_SET('$language', tbl_img_status.`lang_ids`) AND (tbl_img_status.`image_title` LIKE '%$keyword%' OR tbl_img_status.`image_tags` LIKE '%$keyword%' OR tbl_category.`category_name` LIKE '%$keyword%') ORDER BY tbl_img_status.`id` DESC LIMIT $start, $limit";

            $targetpage = 'manage_user_gif_status.php?status='.$_GET['status'].'&category='.$category.'&language='.$language.'&keyword='.$keyword;
          }
        } 
        else if(isset($_GET['keyword']))
        {
          $keyword=addslashes(trim($_GET['keyword']));

          $query="SELECT tbl_category.`category_name`,tbl_img_status.* FROM tbl_img_status
                  LEFT JOIN tbl_category ON tbl_img_status.`cat_id`= tbl_category.`cid` 
                  WHERE tbl_img_status.`user_id` <> '0' AND tbl_img_status.`status_type`='gif' AND $status AND tbl_img_status.`cat_id`='$category' AND (tbl_img_status.`image_title` LIKE '%$keyword%' OR tbl_img_status.`image_tags` LIKE '%$keyword%' OR tbl_category.`category_name` LIKE '%$keyword%') ORDER BY tbl_img_status.`id` DESC";

          $sql_query="SELECT tbl_category.`category_name`,tbl_img_status.* FROM tbl_img_status
                  LEFT JOIN tbl_category ON tbl_img_status.`cat_id`= tbl_category.`cid` 
                  WHERE tbl_img_status.`user_id` <> '0' AND tbl_img_status.`status_type`='gif' AND $status AND tbl_img_status.`cat_id`='$category' AND (tbl_img_status.`image_title` LIKE '%$keyword%' OR tbl_img_status.`image_tags` LIKE '%$keyword%' OR tbl_category.`category_name` LIKE '%$keyword%') ORDER BY tbl_img_status.`id` DESC LIMIT $start, $limit";

          $targetpage = 'manage_user_gif_status.php?status='.$_GET['status'].'&category='.$category.'&keyword='.$keyword;

        }
      } 
      else if(isset($_GET['language']))
      {
        $language=trim($_GET['language']);

        $query="SELECT tbl_category.`category_name`,tbl_img_status.* FROM tbl_img_status
                LEFT JOIN tbl_category ON tbl_img_status.`cat_id`= tbl_category.`cid` 
                WHERE tbl_img_status.`user_id` <> '0' AND tbl_img_status.`status_type`='gif' AND $status AND FIND_IN_SET('$language', tbl_img_status.`lang_ids`) ORDER BY tbl_img_status.`id` DESC";

        $sql_query="SELECT tbl_category.`category_name`,tbl_img_status.* FROM tbl_img_status
                LEFT JOIN tbl_category ON tbl_img_status.`cat_id`= tbl_category.`cid` 
                WHERE tbl_img_status.`user_id` <> '0' AND tbl_img_status.`status_type`='gif' AND $status AND FIND_IN_SET('$language', tbl_img_status.`lang_ids`) ORDER BY tbl_img_status.`id` DESC LIMIT $start, $limit";

        $targetpage = 'manage_user_gif_status.php?status='.$_GET['status'].'&language='.$language;

        if(isset($_GET['keyword']))
        {
          $keyword=addslashes(trim($_GET['keyword']));

          $query="SELECT tbl_category.`category_name`,tbl_img_status.* FROM tbl_img_status
                  LEFT JOIN tbl_category ON tbl_img_status.`cat_id`= tbl_category.`cid` 
                  WHERE tbl_img_status.`user_id` <> '0' AND tbl_img_status.`status_type`='gif' AND $status AND FIND_IN_SET('$language', tbl_img_status.`lang_ids`) AND (tbl_img_status.`image_title` LIKE '%$keyword%' OR tbl_img_status.`image_tags` LIKE '%$keyword%' OR tbl_category.`category_name` LIKE '%$keyword%') ORDER BY tbl_img_status.`id` DESC";

          $sql_query="SELECT tbl_category.`category_name`,tbl_img_status.* FROM tbl_img_status
                  LEFT JOIN tbl_category ON tbl_img_status.`cat_id`= tbl_category.`cid` 
                  WHERE tbl_img_status.`user_id` <> '0' AND tbl_img_status.`status_type`='gif' AND $status AND FIND_IN_SET('$language', tbl_img_status.`lang_ids`) AND (tbl_img_status.`image_title` LIKE '%$keyword%' OR tbl_img_status.`image_tags` LIKE '%$keyword%' OR tbl_category.`category_name` LIKE '%$keyword%') ORDER BY tbl_img_status.`id` DESC LIMIT $start, $limit";

          $targetpage = 'manage_user_gif_status.php?status='.$_GET['status'].'&language='.$language.'&keyword='.$keyword;
        }
      } 
      else if(isset($_GET['keyword']))
      {
        $keyword=addslashes(trim($_GET['keyword']));

        $query="SELECT tbl_category.`category_name`,tbl_img_status.* FROM tbl_img_status
                LEFT JOIN tbl_category ON tbl_img_status.`cat_id`= tbl_category.`cid` 
                WHERE tbl_img_status.`user_id` <> '0' AND tbl_img_status.`status_type`='gif' AND $status AND (tbl_img_status.`image_title` LIKE '%$keyword%' OR tbl_img_status.`image_tags` LIKE '%$keyword%' OR tbl_category.`category_name` LIKE '%$keyword%') ORDER BY tbl_img_status.`id` DESC";

        $sql_query="SELECT tbl_category.`category_name`,tbl_img_status.* FROM tbl_img_status
                LEFT JOIN tbl_category ON tbl_img_status.`cat_id`= tbl_category.`cid` 
                WHERE tbl_img_status.`user_id` <> '0' AND tbl_img_status.`status_type`='gif' AND $status AND (tbl_img_status.`image_title` LIKE '%$keyword%' OR tbl_img_status.`image_tags` LIKE '%$keyword%' OR tbl_category.`category_name` LIKE '%$keyword%') ORDER BY tbl_img_status.`id` DESC LIMIT $start, $limit";

        $targetpage = 'manage_user_gif_status.php?status='.$_GET['status'].'&keyword='.$keyword;
      }

    }
    else if(isset($_GET['category']))
    {

      $category=trim($_GET['category']);

      $query="SELECT tbl_category.`category_name`,tbl_img_status.* FROM tbl_img_status
            LEFT JOIN tbl_category ON tbl_img_status.`cat_id`= tbl_category.`cid` 
            WHERE tbl_img_status.`user_id` <> '0' AND tbl_img_status.`status_type`='gif' AND tbl_img_status.`cat_id`='$category' ORDER BY tbl_img_status.`id` DESC";

      $sql_query="SELECT tbl_category.`category_name`,tbl_img_status.* FROM tbl_img_status
            LEFT JOIN tbl_category ON tbl_img_status.`cat_id`= tbl_category.`cid` 
            WHERE tbl_img_status.`user_id` <> '0' AND tbl_img_status.`status_type`='gif' AND tbl_img_status.`cat_id`='$category' ORDER BY tbl_img_status.`id` DESC LIMIT $start, $limit";

      $targetpage = 'manage_user_gif_status.php?category='.$category;

      if(isset($_GET['language']))
      {

        $language=trim($_GET['language']);

        $query="SELECT tbl_category.`category_name`,tbl_img_status.* FROM tbl_img_status
                LEFT JOIN tbl_category ON tbl_img_status.`cat_id`= tbl_category.`cid` 
                WHERE tbl_img_status.`user_id` <> '0' AND tbl_img_status.`status_type`='gif' AND tbl_img_status.`cat_id`='$category' AND FIND_IN_SET('$language', tbl_img_status.`lang_ids`) ORDER BY tbl_img_status.`id` DESC";

        $sql_query="SELECT tbl_category.`category_name`,tbl_img_status.* FROM tbl_img_status
                LEFT JOIN tbl_category ON tbl_img_status.`cat_id`= tbl_category.`cid` 
                WHERE tbl_img_status.`user_id` <> '0' AND tbl_img_status.`status_type`='gif' AND tbl_img_status.`cat_id`='$category' AND FIND_IN_SET('$language', tbl_img_status.`lang_ids`) ORDER BY tbl_img_status.`id` DESC LIMIT $start, $limit";

        $targetpage = 'manage_user_gif_status.php?category='.$category.'&language='.$language;

        if(isset($_GET['keyword']))
        {
          $keyword=addslashes(trim($_GET['keyword']));

          $query="SELECT tbl_category.`category_name`,tbl_img_status.* FROM tbl_img_status
                  LEFT JOIN tbl_category ON tbl_img_status.`cat_id`= tbl_category.`cid` 
                  WHERE tbl_img_status.`user_id` <> '0' AND tbl_img_status.`status_type`='gif' AND tbl_img_status.`cat_id`='$category' AND FIND_IN_SET('$language', tbl_img_status.`lang_ids`) AND (tbl_img_status.`image_title` LIKE '%$keyword%' OR tbl_img_status.`image_tags` LIKE '%$keyword%' OR tbl_category.`category_name` LIKE '%$keyword%') ORDER BY tbl_img_status.`id` DESC";

          $sql_query="SELECT tbl_category.`category_name`,tbl_img_status.* FROM tbl_img_status
                  LEFT JOIN tbl_category ON tbl_img_status.`cat_id`= tbl_category.`cid` 
                  WHERE tbl_img_status.`user_id` <> '0' AND tbl_img_status.`status_type`='gif' AND tbl_img_status.`cat_id`='$category' AND FIND_IN_SET('$language', tbl_img_status.`lang_ids`) AND (tbl_img_status.`image_title` LIKE '%$keyword%' OR tbl_img_status.`image_tags` LIKE '%$keyword%' OR tbl_category.`category_name` LIKE '%$keyword%') ORDER BY tbl_img_status.`id` DESC LIMIT $start, $limit";

          $targetpage = 'manage_user_gif_status.php?category='.$category.'&language='.$language.'&keyword='.$keyword;
        }
      } 
      else if(isset($_GET['keyword']))
      {
        $keyword=addslashes(trim($_GET['keyword']));

        $query="SELECT tbl_category.`category_name`,tbl_img_status.* FROM tbl_img_status
                LEFT JOIN tbl_category ON tbl_img_status.`cat_id`= tbl_category.`cid` 
                WHERE tbl_img_status.`user_id` <> '0' AND tbl_img_status.`status_type`='gif' AND tbl_img_status.`cat_id`='$category' AND (tbl_img_status.`image_title` LIKE '%$keyword%' OR tbl_img_status.`image_tags` LIKE '%$keyword%' OR tbl_category.`category_name` LIKE '%$keyword%') ORDER BY tbl_img_status.`id` DESC";

        $sql_query="SELECT tbl_category.`category_name`,tbl_img_status.* FROM tbl_img_status
                LEFT JOIN tbl_category ON tbl_img_status.`cat_id`= tbl_category.`cid` 
                WHERE tbl_img_status.`user_id` <> '0' AND tbl_img_status.`status_type`='gif' AND tbl_img_status.`cat_id`='$category' AND (tbl_img_status.`image_title` LIKE '%$keyword%' OR tbl_img_status.`image_tags` LIKE '%$keyword%' OR tbl_category.`category_name` LIKE '%$keyword%') ORDER BY tbl_img_status.`id` DESC LIMIT $start, $limit";


        $targetpage = 'manage_user_gif_status.php?category='.$category.'&keyword='.$keyword;
      }
    }
    else if(isset($_GET['language']))
    {

      $language=trim($_GET['language']);

      $query="SELECT tbl_category.`category_name`,tbl_img_status.* FROM tbl_img_status
              LEFT JOIN tbl_category ON tbl_img_status.`cat_id`= tbl_category.`cid` 
              WHERE tbl_img_status.`user_id` <> '0' AND tbl_img_status.`status_type`='gif' AND FIND_IN_SET('$language', tbl_img_status.`lang_ids`) ORDER BY tbl_img_status.`id` DESC";

      $sql_query="SELECT tbl_category.`category_name`,tbl_img_status.* FROM tbl_img_status
              LEFT JOIN tbl_category ON tbl_img_status.`cat_id`= tbl_category.`cid` 
              WHERE tbl_img_status.`user_id` <> '0' AND tbl_img_status.`status_type`='gif' AND FIND_IN_SET('$language', tbl_img_status.`lang_ids`) ORDER BY tbl_img_status.`id` DESC LIMIT $start, $limit";

      $targetpage = 'manage_user_gif_status.php?language='.$language;

      if(isset($_GET['keyword']))
      {
        $keyword=addslashes(trim($_GET['keyword']));

        $query="SELECT tbl_category.`category_name`,tbl_img_status.* FROM tbl_img_status
                LEFT JOIN tbl_category ON tbl_img_status.`cat_id`= tbl_category.`cid` 
                WHERE tbl_img_status.`user_id` <> '0' AND tbl_img_status.`status_type`='gif' AND FIND_IN_SET('$language', tbl_img_status.`lang_ids`) AND (tbl_img_status.`image_title` LIKE '%$keyword%' OR tbl_img_status.`image_tags` LIKE '%$keyword%' OR tbl_category.`category_name` LIKE '%$keyword%') ORDER BY tbl_img_status.`id` DESC";

        $sql_query="SELECT tbl_category.`category_name`,tbl_img_status.* FROM tbl_img_status
                LEFT JOIN tbl_category ON tbl_img_status.`cat_id`= tbl_category.`cid` 
                WHERE tbl_img_status.`user_id` <> '0' AND tbl_img_status.`status_type`='gif' AND FIND_IN_SET('$language', tbl_img_status.`lang_ids`) AND (tbl_img_status.`image_title` LIKE '%$keyword%' OR tbl_img_status.`image_tags` LIKE '%$keyword%' OR tbl_category.`category_name` LIKE '%$keyword%') ORDER BY tbl_img_status.`id` DESC LIMIT $start, $limit";

        $targetpage = 'manage_user_gif_status.php?language='.$language.'&keyword='.$keyword;

      }
    }
    else if(isset($_GET['keyword']))
    {
      $keyword=addslashes(trim($_GET['keyword']));

      $query="SELECT tbl_category.`category_name`,tbl_img_status.* FROM tbl_img_status
              LEFT JOIN tbl_category ON tbl_img_status.`cat_id`= tbl_category.`cid` 
              WHERE tbl_img_status.`user_id` <> '0' AND tbl_img_status.`status_type`='gif' AND (tbl_img_status.`image_title` LIKE '%$keyword%' OR tbl_img_status.`image_tags` LIKE '%$keyword%' OR tbl_category.`category_name` LIKE '%$keyword%') ORDER BY tbl_img_status.`id` DESC";

      $sql_query="SELECT tbl_category.`category_name`,tbl_img_status.* FROM tbl_img_status
              LEFT JOIN tbl_category ON tbl_img_status.`cat_id`= tbl_category.`cid` 
              WHERE tbl_img_status.`user_id` <> '0' AND tbl_img_status.`status_type`='gif' AND (tbl_img_status.`image_title` LIKE '%$keyword%' OR tbl_img_status.`image_tags` LIKE '%$keyword%' OR tbl_category.`category_name` LIKE '%$keyword%') ORDER BY tbl_img_status.`id` DESC LIMIT $start, $limit";

      $targetpage = 'manage_user_gif_status.php?keyword='.$keyword;
    }
    else
    {
      $query="SELECT tbl_category.`category_name`,tbl_img_status.* FROM tbl_img_status
              LEFT JOIN tbl_category ON tbl_img_status.`cat_id`= tbl_category.`cid` 
              WHERE tbl_img_status.`user_id` <> '0' AND tbl_img_status.`status_type`='gif' ORDER BY tbl_img_status.`id` DESC";

      $sql_query="SELECT tbl_category.`category_name`,tbl_img_status.* FROM tbl_img_status
              LEFT JOIN tbl_category ON tbl_img_status.`cat_id`= tbl_category.`cid` 
              WHERE tbl_img_status.`user_id` <> '0' AND tbl_img_status.`status_type`='gif' ORDER BY tbl_img_status.`id` DESC LIMIT $start, $limit";
    }

    $total_pages = mysqli_num_rows(mysqli_query($mysqli,$query));

    $result=mysqli_query($mysqli,$sql_query); 

    function get_user_info($user_id,$field_name) 
    {
      global $mysqli;

      $qry_user="SELECT * FROM tbl_users WHERE id='".$user_id."'";
      $query1=mysqli_query($mysqli,$qry_user);
      $row_user = mysqli_fetch_array($query1);

      $num_rows1 = mysqli_num_rows($query1);

      if ($num_rows1 > 0)
      {     
        return $row_user[$field_name];
      }
      else
      {
        return "";
      }
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
              <form method="get" id="searchForm" action="">
                <input class="form-control input-sm" placeholder="Search here..." aria-controls="DataTables_Table_0" type="search" name="keyword" value="<?php if(isset($_GET['keyword'])){ echo $_GET['keyword'];} ?>" required="required">
                <button type="submit" class="btn-search"><i class="fa fa-search"></i></button>
              </form>  
            </div>
          </div>
        </div>
        <div class="col-md-8 col-xs-12">
          <form id="filterForm" accept="" method="GET">
            <?php 
            if(isset($_GET['keyword'])){
              echo '<input type="hidden" name="keyword" value="'.$_GET['keyword'].'">';
            }
            ?>

            <div class="col-md-4" style="padding: 0px">
              <select name="status" class="form-control select2 filter">
                <option value="">All</option>
                <option value="landscape" <?php if(isset($_GET['status']) && $_GET['status']=='landscape'){ echo 'selected';} ?>>Landscape</option>
                <option value="portrait" <?php if(isset($_GET['status']) && $_GET['status']=='portrait'){ echo 'selected';} ?>>Portrait</option>
                <option value="enable" <?php if(isset($_GET['status']) && $_GET['status']=='enable'){ echo 'selected';} ?>>Enable</option>
                <option value="disable" <?php if(isset($_GET['status']) && $_GET['status']=='disable'){ echo 'selected';} ?>>Disable</option>
                <option value="slider" <?php if(isset($_GET['status']) && $_GET['status']=='slider'){ echo 'selected';} ?>>Slider</option>
                <option value="no_slider" <?php if(isset($_GET['status']) && $_GET['status']=='no_slider'){ echo 'selected';} ?>>No Slider</option>
              </select>
            </div>
            <div class="col-md-4">
              <select name="category" class="form-control select2 filter">
                <option value="">All Category</option>
                <?php
                $cat_qry="SELECT * FROM tbl_category ORDER BY category_name";
                $cat_result=mysqli_query($mysqli,$cat_qry);
                while($cat_row=mysqli_fetch_array($cat_result))
                {
                  ?>                       
                  <option value="<?php echo $cat_row['cid'];?>" <?php if(isset($_GET['category']) && $_GET['category']==$cat_row['cid']){echo 'selected';} ?>><?php echo $cat_row['category_name'];?></option>                           
                  <?php
                }
                ?>
              </select>
            </div>
            <div class="col-md-4">
              <select name="language" class="form-control select2 filter">
                <option value="">All Language</option>
                <?php
                $sql_lang="SELECT * FROM tbl_language ORDER BY language_name";
                $res_lang=mysqli_query($mysqli,$sql_lang);
                while($row_lang=mysqli_fetch_array($res_lang))
                {
                  ?>                       
                  <option value="<?php echo $row_lang['id'];?>" <?php if(isset($_GET['language']) && $_GET['language']==$row_lang['id']){echo 'selected';} ?>><?php echo $row_lang['language_name'];?></option>                           
                  <?php
                }
                ?>
              </select>
            </div>

          </form>
        </div>
        <div class="col-md-4 col-xs-12 text-right" style="float: right;">
          <div class="checkbox" style="width: 95px;margin-top: 5px;float: left;right: 90px;position: absolute;">
            <input type="checkbox" id="checkall">
            <label for="checkall">
              Select All
            </label>
          </div>
          <div class="dropdown" style="float:right">
            <button class="btn btn-primary dropdown-toggle btn_delete" type="button" data-toggle="dropdown">Action
              <span class="caret"></span></button>
              <ul class="dropdown-menu" style="right:0;left:auto;">
                <li><a href="javascript:void(0)" class="actions" data-action="enable">Enable</a></li>
                <li><a href="javascript:void(0)" class="actions" data-action="disable">Disable</a></li>
                <li><a href="javascript:void(0)" class="actions" data-action="delete">Delete !</a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="clearfix"></div>
        <div role="tabpanel" class="mrg-top">
          <ul class="nav nav-tabs" role="tablist">
            <li role="presentation"><a href="manage_gif_status.php">Admin GIF Status</a></li>
            <li role="presentation" class="active"><a href="manage_user_gif_status.php">Users GIF Status</a></li>
          </ul>
        </div>
        <div class="col-md-12">
          <div class="row">
            <?php 
            $i=0;
            while($row=mysqli_fetch_array($result))
            {
              ?>
              <div class="col-lg-4 col-sm-6 col-xs-12">
                <div class="block_wallpaper">
                  <div class="wall_category_block">
                    <h2><?php echo $row['category_name'];?></h2>  

                    <?php if($row['featured']!="0"){?>
                     <a href="javascript:void(0)" class="toggle_btn_a" data-id="<?php echo $row['id'];?>" data-action="deactive" data-column="featured" data-toggle="tooltip" data-tooltip="Slider"><div style="color:green;"><i class="fa fa-sliders"></i></div></a> 
                   <?php }else{?>
                     <a href="javascript:void(0)" class="toggle_btn_a" data-id="<?php echo $row['id'];?>" data-action="active" data-column="featured" data-tooltip="Add to Slider"><i class="fa fa-sliders"></i></a> 
                   <?php }?>

                   <?php if($row['status']!="0"){?>
                    <a href="javascript:void(0)" class="btn_notify" data-status="<?php echo $row['id'];?>" data-uid="<?php echo $row['user_id'];?>" data-tooltip="Notify Users" style="margin-right: 8px"><i class="fa fa-bell"></i></a> 
                  <?php } ?>

                  <div class="checkbox" style="float: right;margin-top: 12px">
                    <input type="checkbox" name="post_ids[]" id="checkbox<?php echo $i;?>" value="<?php echo $row['id']; ?>" class="post_ids">
                    <label for="checkbox<?php echo $i;?>">
                    </label>
                  </div>

                </div>
                <div class="wall_image_title">
                 <p style="font-size: 16px;"><?php echo $row['image_title'];?></p>

                 <p>By: <a href="manage_user_history.php?user_id=<?php echo $row['user_id'];?>&redirect=<?=$redirectUrl?>" style="color: #ddd"><?=ucwords(get_user_info($row['user_id'],'name'))?></a> 
                  <?php 
                  if(get_user_info($row['user_id'],'is_verified')==1){
                    echo '<img src="assets/images/verification_150.png" style="border: none;width: 15px !important ;height: 15px !important ;vertical-align: sub">';
                  }
                  ?>
                </p>
                <ul>
                  <?php if($row['image_layout']=='Portrait'){?>
                    <li><a href="javascript:void(0)" data-toggle="tooltip" data-tooltip="Portrait"><i class="fa fa-mobile"></i></a></li>
                  <?php }else{?>
                    <li><a href="javascript:void(0)" data-toggle="tooltip" data-tooltip="Landscape"><i class="fa fa-mobile" style="transform:rotate(90deg);"></i></a></li>
                  <?php }?>

                  <li><a href="javascript:void(0)" data-toggle="tooltip" data-tooltip="<?php echo $row['total_views'];?> Views"><i class="fa fa-eye"></i></a></li>        

                  <li><a href="gif_status.php?edit_id=<?php echo $row['id'];?>&action=edit&redirect=<?=$redirectUrl?>" data-toggle="tooltip" data-tooltip="Edit"><i class="fa fa-edit"></i></a></li>

                  <li><a href="" data-toggle="tooltip" data-tooltip="Delete" class="btn_delete_a" data-id="<?php echo $row['id'];?>"><i class="fa fa-trash"></i></a></li>

                  <?php if($row['status']!="0"){?>
                   <li><div class="row toggle_btn"><a href="javascript:void(0)" data-id="<?php echo $row['id'];?>" data-action="deactive" data-column="status" data-toggle="tooltip" data-tooltip="ENABLE"><img src="assets/images/btn_enabled.png" alt="wallpaper_1" /></a></div></li>
                 <?php }else{?>
                   <li><div class="row toggle_btn"><a href="javascript:void(0)" data-id="<?php echo $row['id'];?>" data-id="<?=$row['id']?>" data-action="active" data-column="status" data-toggle="tooltip" data-tooltip="DISABLE"><img src="assets/images/btn_disabled.png" alt="wallpaper_1" /></a></div></li>
                 <?php }?>
               </ul>
             </div>

             <span>
              <?php if($row['image_file']!=""){?>
                <img src="images/<?php echo $row['image_file'];?>" />
              <?php }else{?>
                <img src="images/default_img.jpg" />
              </span>                     
            <?php }?>  
          </div>
        </div>
        <?php
        $i++;
      }
      ?>
    </div>
  </div>
  <div class="col-md-12 col-xs-12">
    <div class="pagination_item_block">
      <nav>
        <?php include("pagination.php");?>
      </nav>
    </div>
  </div>
  <div class="clearfix"></div>
</div>
</div>
</div>

<?php include("includes/footer.php");?>       

<script type="text/javascript">

  $(".toggle_btn a, .toggle_btn_a").on("click",function(e){
    e.preventDefault();
    var _for=$(this).data("action");
    var _id=$(this).data("id");
    var _column=$(this).data("column");
    var _table='tbl_img_status';

    $.ajax({
      type:'post',
      url:'processData.php',
      dataType:'json',
      data:{id:_id,for_action:_for,column:_column,table:_table,'action':'toggle_status','status_type':'gif','tbl_id':'id'},
      success:function(res){
        console.log(res);
        $(".loader").show();
        if(res.status=='1'){
          location.reload();
        }
      }
    });

  });

  
  $(".btn_notify").click(function(e){
    e.preventDefault();
    var _id=$(this).data("status");
    var _uid=$(this).data("uid");

    swal({
      title: "Are you sure?",
      text: "Notification will be send to your followers.",
      input: 'text',
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
          data:{id:_id,uid:_uid,'action':'notify_users','status_type':'gif'},
          success:function(res){
            console.log(res);
            if(res.status=='1'){
              swal({
                title: "Send", 
                text: "Notification has been sent to your followers..", 
                type: "success"
              },function() {
              });
            }
          }
        });
      }
      else{
        swal.close();
      }

    });
  });

  $(".actions").click(function(e){
    e.preventDefault();

    var _ids = $.map($('.post_ids:checked'), function(c){return c.value; });
    var _action=$(this).data("action");

    if(_ids!='')
    {
      swal({
        title: "Action: "+$(this).text(),
        text: "<?=$client_lang['multi_action_txt']?>",
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

          var _table='tbl_img_status';

          $.ajax({
            type:'post',
            url:'processData.php',
            dataType:'json',
            data:{id:_ids,for_action:_action,table:_table,'action':'multi_action','status_type':'gif'},
            success:function(res){
              console.log(res);
              if(res.status=='1'){
                swal({
                  title: "<?=$client_lang['multi_action_success_lbl']?>", 
                  text: "<?=$client_lang['multi_action_msg']?>", 
                  type: "success"
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
      swal("Sorry no gif selected !!")
    }
  });


  $(".btn_delete_a").click(function(e){

    e.preventDefault();

    var _id=$(this).data("id");

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
          data:{id:_id,for_action:'delete',table:'tbl_img_status','action':'multi_action'},
          success:function(res){
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
  });

  $(".filter").on("change",function(e){
    $("#filterForm *").filter(":input").each(function(){
      if ($(this).val() == '')
        $(this).prop("disabled", true);
    });
    $("#filterForm").submit();
  });

</script>