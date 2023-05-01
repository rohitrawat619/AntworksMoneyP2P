Welcome Buisness Team!
<?php 
if($this->session->userdata('Teamloginsession'))
{
    $udata = $this->session->userdata('Teamloginsession');
   // echo 'Welcome'.' '.$udata['fullname'];
}
else
{
    redirect(base_url('welcome/businessTeamlogin'));
}
 ?>

            <form method="post" autocomplete="off" action="<?=base_url('welcome/editdetailsbteam')?>">

                       <div class="text-center">
                       <input type="hidden" id="vendors" name="vendors" value="1">
						  <button type="submit" class="btn btn-primary">All Vendors</button>
					    </div>
                        </form>
                        <br>
                        <form method="post" autocomplete="off" action="<?=base_url('welcome/editdetailsbteam')?>">
                        <input type="hidden" id="schemes" name="schemes" value="1">
                        <div class="text-center">
						  <button type="submit" class="btn btn-primary">All Schemes</button>
						</div>
                        </form>

                        <div class="container">
			<div class="mb-5 mt-5">
				<div id="GoogleLineChart" style="height: 400px; width: 100%"></div>
			</div>
			<div class="mb-5">
				<div id="GoogleBarChart" style="height: 400px; width: 100%"></div>
			</div>
		</div>

		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
		<script>
			google.charts.load('current', {'packages':['corechart', 'bar']});
			google.charts.setOnLoadCallback(drawLineChart);
			google.charts.setOnLoadCallback(drawBarChart);
            // Line Chart
			function drawLineChart() {
				var data = google.visualization.arrayToDataTable([
					['Day', 'Products Count'],
						<?php 
							foreach ($products as $row){
							   echo "['".$row['day']."',".$row['sell']."],";
						} ?>
				]);
				var options = {
					title: 'Line chart product sell wise',
					curveType: 'function',
					legend: {
						position: 'top'
					}
				};
				var chart = new google.visualization.LineChart(document.getElementById('GoogleLineChart'));
				chart.draw(data, options);
			}
			
			
			// Bar Chart
			google.charts.setOnLoadCallback(showBarChart);
			function drawBarChart() {
				var data = google.visualization.arrayToDataTable([
					['Day', 'Products Count'], 
						<?php 
							foreach ($products as $row){
							   echo "['".$row['day']."',".$row['sell']."],";
							}
						?>
				]);
				var options = {
					title: ' Bar chart products sell wise',
					is3D: true,
				};
				var chart = new google.visualization.BarChart(document.getElementById('GoogleBarChart'));
				chart.draw(data, options);
			}
			
		</script>


<!-- 
<form method="post" action="">
    <input type="text" name="form_id"/>

</form>   

<form method="post" action="">
    <input type="text" name="form_id"/>
   

<form method="post" action="">
    <input type="text" name="form_id"/>
    
</form> -->