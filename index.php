<?php
	$center=$search="";
	if(!isset($_GET['keyword']) && !isset($_GET['v']))
		$center = "margin-top:200px;";
	if(isset($_GET['keyword']))
		$search = $_GET['keyword'];
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Youtube Downloader</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	<style type="text/css">
		.header{
			background-color: #e40000;
		    color: #fff;
		    font-size: 25px;
		    padding: 6px 30px;
		    margin-bottom: 35px;
		}
		.container{
			padding: 0px;
			min-height: 800px;
		}
		.buttons{
			visibility: hidden;
		}
		.vid{
			cursor: pointer;
		}
	</style>
</head>
<body>
	 <div class="container" style="background-color:#ececec;"> 
		
				<div class="header">
					Youtube Downloader
				</div>
		
	
		
			<div class="row">
				<div class="col-md-8 col-md-offset-2">
					<div class="searchBox" style="<?php echo $center; ?>">
						<div class="searchForm">
						<form role="form" method="GET">  
							<div class="row">
							  <div class="col-xs-12">
								<div class="input-group input-group-lg">
									<input type="text" class="form-control" name="keyword" placeholder="Please Enter Keyword to search videos" value="<?php echo $search; ?>" />
								  <div class="input-group-btn">
									<button type="submit" class="btn">Search</button>
								  </div><!-- /btn-group -->
								</div><!-- /input-group -->
							  </div><!-- /.col-xs-12 -->
							</div><!-- /.row -->
						</form>
					</div> <!-- searchForm-->
					<div class="row" style="margin-top:35px;">
					
					<?php
						if(isset($_GET['keyword']))
						{
							$keyword = $_GET['keyword'];
							
							$keyword=preg_replace("/ /","+",$keyword);
							
							$response = file_get_contents("https://www.googleapis.com/youtube/v3/search?part=snippet&q={$keyword}&type=video&key=AIzaSyBqhtJ3_FLsK74e0qh9FyDlnGyaggVsIk0&maxResults=8");
							
							$searchResponse = json_decode($response,true);
							$i=0;
							foreach ($searchResponse['items'] as $searchResult) {
							$i++;
							$a = $searchResult['id']['videoId'];
							$b = preg_replace('/[^a-zA-Z0-9]/', '_', $searchResult['snippet']['title']);
							 
							
							?>
							<div class="col-md-3" style="margin-bottom:30px;">
								<div id="<?php echo $a; ?>" class="vid"> 
									 <div> 
								 		<img src="<?php echo $searchResult['snippet']['thumbnails']['default']['url']; ?>" alt="Youtube Video" style="width:100%;">
									</div> 
								
									<div> 
										<?php echo $searchResult['snippet']['title']; ?>
									</div>
								
								</div>
							</div>	
								
								<?php
								if($i==4)
									echo '</div><div class="row" style="margin-top:5px;">';
								}
							}
							elseif (isset($_GET['v'])) {
									// code...
								
									$v_id = $_GET['v'];

								echo '<table class="table table-striped table-bordered table-hover watch" style="cursor:pointer;">
										<tr>
											<td>
												<img src="https://i.ytimg.com/vi/'.$v_id.'/default.jpg" style="border-radius:2px;">
											</td>
											<td id="dwnld-title">

											</td>
										</tr>
									  </table>';
								
								echo '<table class="table table-striped table-bordered table-hover">';
								$json=file_get_contents("https://api.wapclub.xyz/api.php?id=$v_id");
								$json=json_decode($json, true);
								foreach($json as $data){
									if(!isset($title)){
										$title = preg_replace("/[^A-Za-z0-9 ]/", '', $data['title']); 
									}
								echo '<tr>';
								echo "<td>$data[quality]</td>";	
								echo "<td>$data[format]</td>";	
								echo '<td><a class="btn btn-default" href="'.$data['url'].'&title='.urlencode($data['title']).'" >
								Download</a></td>';
								echo '</tr>';	
								}
								echo '</table>';							}
					

					?>
					</div>
				</div> <!--searchBox-->
			</div> <!--col md 8-->

			
			

		</div> <!--row-->
		
		<!-- Modal starts -->
<div id="myModal2" class="modal fade" role="dialog" style="background-color: rgba(0, 0, 0, 0.62);">
  <div class="modal-dialog" style="margin-top:12%;width:560px;height:315px;">

    <!-- Modal content-->
    <div class="modal-content" id="watch">
      <!-- <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">DOWNLOAD</h4>
      </div> -->
<!--       <div id="downloadFormatList" class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
 -->
    </div>
</div>
</div>
<!--modal ends-->

		<!-- Modal starts -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog" style="margin-top:15%;" >

    <!-- Modal content-->
    <div class="modal-content" style="padding:50px;">
    <form method="GET">
    	<input type="hidden" name="v" id="v_id">
      	<span class="btn btn-primary btn-lg btn-block watch">WATCH</span>
		<button type="submit" class="btn btn-danger btn-lg btn-block">DOWNLOAD</button>
	</form>
	  <!-- <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">DOWNLOAD</h4>
      </div> -->
<!--       <div id="downloadFormatList" class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
 -->
    </div>
</div>
</div>
<!--modal ends-->
		
		
	</div>	 <!--container-->
	
	
	
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script>
	 
	$(".vid").click(function(){
		$("#v_id").val($(this).attr("id"));
		$('#myModal').modal('show');
	});

	$(".watch").click(function(){
		$("#watch").html('<iframe width="560" height="315" src="https://www.youtube.com/embed/'+$("#v_id").val()+'" frameborder="0" allowfullscreen></iframe>');
		$('#myModal').modal('hide');
		$('#myModal2').modal('show');

	});

</script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<?php 
	if(isset($title))
			echo '<script>$(document).ready(function(){$("#dwnld-title").html("'.$title.'");$("#v_id").val("'.$v_id.'");}); </script>';
									
?>

</body>
</html>