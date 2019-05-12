<?php # Script 12.8 


function stats_standard_deviation(array $a, $sample = true) {
	$n = count($a);
	if ($n === 0) {
			trigger_error("The array has zero elements", E_USER_WARNING);
			return false;
	}
	if ($sample && $n === 1) {
			trigger_error("The array has only 1 element", E_USER_WARNING);
			return false;
	}
	$mean = array_sum($a) / $n;
	$carry = 0.0;
	foreach ($a as $val) {
			$d = ((double) $val) - $mean;
			$carry += $d * $d;
	};
	if ($sample) {
		 --$n;
	}
	return sqrt($carry / $n);
}

function mean(array $input_array)
{
$total = 0;
foreach ($input_array as $value)
{
	$total += $value;
}
return ($total / count($input_array));
}

function z($var, array $arr)
{
return ($var -mean($arr)) / stats_standard_deviation($arr);
}


$results_crime = array(
	'Albany'=>0,
	'Allegany'=>0,
	'Bronx'=>0,
	'Broome'=>0,
	'Cayuga'=>0,
	'Chemung'=>0,
	'Chenango'=>0,
	'Clinton'=>0,
	'Dutchess'=>0,
	'Erie'=>0,
	'Essex'=>0,
	'Franklin'=>0,
	'Jefferson'=>0,
	'Kings'=>0,
	'Livingston'=>0,
	'Madison'=>0,
	'Monroe'=>0,
	'Montgomery'=>0,
	'Multiple'=>0,
	'Nassau'=>0,
	'New York'=>0,
	'Niagara'=>0,
	'Oneida'=>0,
	'Orange'=>0,
	'Oswego'=>0,
	'Otsego'=>0,
	'Queens'=>0,
	'Richmond'=>0,
	'Rockland'=>0,
	'Saratoga'=>0,
	'Schenectady'=>0,
	'Schoharie'=>0,
	'St. Lawrence'=>0,
	'Suffolk'=>0,
	'Tompkins'=>0,
	'Ulster'=>0,
	'Wayne'=>0,
	'Westchester'=>0
    );

$pi_z = $results_crime;

// Need two helper files:
require('includes/retrieve.php');
require('security/connect_t.php');
//$dbc=mysqli_connect('localhost','wcf','wcf','proj490');
$i=0;
$sql_crime="SELECT * FROM HateCrimeNY WHERE Year='2016'";
$query_crime = mysqli_query($dbc,$sql_crime);
$num_fields=mysqli_num_fields($query_crime);
$num_rows=mysqli_num_rows($query_crime);

// retrieve bias crimes data basing on user group characteristics
while($row = mysqli_fetch_array($query_crime)){

	$results_crime[$row["County"]]=$results_crime[$row["County"]]+$row[$_POST['gender']]+$row[$_POST['race']]+$row[$_POST['religion']]+$row[$_POST['sexual']]+$row[$_POST['disa']];

}

foreach($results_crime as $key => $value)
{  
    $sql_price = "SELECT i.Income AS income, h.Price AS price, h.Year AS year FROM HousePrice AS h, Income AS i WHERE h.County=i.County AND h.Year=i.Year AND h.Year>= 1996 AND h.County='$key'";
    $query_price = mysqli_query($dbc,$sql_price);
    $pi = array();
    $c = 0;
    while($row = mysqli_fetch_array($query_price)){
        $pi[$c] = $row['price']/$row['income'];
        $c++;
		if ($row['year']==2016){
			$income_2016 = $row['income'];
		}
	}
	$income_2018 = $income_2016*1.02*1.02;
	$sql_price2018 = "SELECT price FROM HousePrice WHERE Year = 2018 AND County ='$key'";
	$query_price = mysqli_query($dbc,$sql_price2018);
    $row = mysqli_fetch_array($query_price);
    $price_2018 = $row['price'];
    $X = $price_2018/$income_2018;
	$pi_z[$key]= (int)round(z($X, $pi)+5.1);
}

	mysqli_close($dbc); // Close the database connection.


?>


<html lang=en>
  <head>
    <meta charset="utf-8">
		<title>Counties risks</title>
		
		<meta name="safelive" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="normalpage.css">

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['County', "Bias Crime","House Price/Income"],
		  
		  <?php
			foreach($results_crime as $key=>$value){
				echo "['".$key."', ".$value.", ".$pi_z[$key]."],";
			}
			echo "])";
		  	  
		  
		  ?>
		  

        var options = {
          chart: {
            title: 'Risk Levels',
            subtitle: 'Comparision of Counties in New York',
          },
          bars: 'horizontal' // Required for Material Bar Charts.
        };

        var chart = new google.charts.Bar(document.getElementById('barchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>
    
  </head>
  <body>
	<div class="jumbotron" style="margin-bottom: 0px;">
            <h1>Safe Live</h1>
      </div>
  <!-- Begin page content -->
    <nav class="navbar navbar-expand-md navbar-dark bg-dark sticky-top">
            
            <button class="navbar-toggler" data-toggle="collapse" data-target="#collapse_target">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="collapse_target">
            <span class="navbar-text">Safe Live</span>
            
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="home.php">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" data-target="dropdown_target" href="#">
                        Individual
                        <span class="caret"></span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdown_target">
                        <a class="dropdown-item" href="individual.php">Find your perfect residence</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="report.php">Report a incident</a>
                    </div>    
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login_t.php">Organization</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="police.php">Police</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact</a>
                </li>
            </ul>
            </div>
    </nav>
    <div id="barchart_material" style="width: 1000px; height: 1900px;"></div>
  </body>
</html>