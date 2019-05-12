<?php # Script 12.9 - showcounty.php #2
// The user is redirected here from login.php or county.php.
header("Refresh: 600");
session_start(); // Start the session.

// Set the page title and include the HTML header:
$page_title = 'Show County';
include('includes/header.html');
require('security/connect_t.php');

if (!isset($_SESSION['userid'])) {
	// Need the functions:
    require('includes/login_functions.inc.php');
	redirect_user('login_t.php');
}

$q_setting = "SELECT * FROM `UserSetting` WHERE `userid` = ";
$q_setting = $q_setting.$_SESSION['userid'].";";
$r_setting = mysqli_query($dbc, $q_setting);

$row = mysqli_fetch_array($r_setting, MYSQLI_ASSOC);

// construct sql querry statement basing on user profile
$q_inc1 = "SELECT Year, ";
$q_inc2 = " FROM HateCrimeNY WHERE County = ";
foreach($row as $key=>$value){
    if ($key == 'County'){
        $curr_county = $value;
        $q_inc2 = $q_inc2."'".$value."'";
    } elseif($key!='userid'&&$value!=NULL){
        $q_inc1 = $q_inc1.$key.", ";
    }
}
// retrieve data from database
$q_inc = substr($q_inc1,0,-2).$q_inc2; 
$q_person = $q_inc." and CrimeType = 'Crimes Against Persons';";
$q_property = $q_inc." and CrimeType = 'Property Crimes';";
$r_personcrime = mysqli_query($dbc, $q_person);
$r_propertycrime = mysqli_query($dbc, $q_property);
$crime = array();

// fill the 3D array $crime 
while($row = mysqli_fetch_array($r_personcrime)){
    foreach($row as $key=>$value){
        if($key == 'Year'){
            $year = $value;
        }elseif(is_int($key)){}
        else{
            $crime[$key]['person'][$year]=$value;
        }
    }
}
while($row = mysqli_fetch_array($r_propertycrime)){
    foreach($row as $key=>$value){
        if($key == 'Year'){
            $year = $value;
        }elseif(is_int($key)){}
        else{
            $crime[$key]['property'][$year]=$value;
        }
    }
}

$crime_hist = array();
$head = array();
$idx = 1;
$head[0] = 'Year';
foreach($crime as $k1=>$v1){
    $head[$idx] = $k1;
    $idx++;
    for($i = 0; $i < 7; $i++) $crime_hist[$i][$idx] = 0;
    foreach($v1 as $k2=>$v2){
        foreach($v2 as $k3=>$v3){
            $crime_hist[$k3%10][$idx] = $crime_hist[$k3%10][$idx] + (int)$v3;
            $crime_hist[$k3%10][0] = $k3;

        }
    }
  }

  $report = [[]];
  $i=0;
  $j=0;
  $id=-1;
  $q_report = "SELECT * FROM `Reported` WHERE `County` = '".$curr_county."' Limit 10;";
  $r_report = mysqli_query($dbc, $q_report);

  while ($row = mysqli_fetch_array($r_report, MYSQLI_ASSOC)){
    foreach($row as $k=>$v){
        if(!empty($v)){
            if($k == 'id'){
                if($v != $id){
                    $id = $v;
                    if($i != 0) $i++;
                }
            }
            if($v == 1){
                    $report[$i][$j] = $k;
                    $j++;
            }elseif($k == 'id' | $k == 'County' | $k == 'FullName' | $k == 'CellPhone' | $k == 'Email'){}
            else{
                        $report[$i][$j] = $v;
                        $j++;
                }
        }  
      }
  }


?>


    <title>Organization Charts</title>
    <link rel="stylesheet" type="text/css" media="screen" href="org.css" />
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
    
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
            <?php 
                $idx = sizeof($head);
                echo "['";
                for ($i=0; $i < $idx; $i++) echo $head[$i]."', '";
                echo $head[$idx]."'],";     
                
                for($r = 0; $r < 7; $r++){
                    echo "['".$crime_hist[$r][0]."', ";
                    for($c=1; $c<$idx; $c++) echo (int)$crime_hist[$r][$c].", ";
                    echo $crime_hist[$r][$idx]."],";                 
                }
                echo "])";
            ?>


        var options = {
            <?php echo "title: '".$curr_county." county historical bias crime',";     ?>
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
      }
    </script>
  </head>

  <h3 align="center">Current real time reported incidents</h3>
    <div class="output">
    <table align="center" style="width: 80%;">
      <tr>
        <th>Bias Against</th>
        <th>Address</th>
        <th>Crime Type</th>
        <th>Case NO.</th>
        <th>Description</th>
        <th>Happen Time</th>
      </tr>
        <?php foreach($report as $r){
            for($k=0; $k<100; $k++){
                if(isset($r[$k*10])){
                    echo "<tr>";
                    echo "<td>".$r[$k*10];
                    for($i = 1; $i<5; $i++) echo", ".$r[$k*10+$i];
                    echo "'</td>";
                    for($j = 5; $j<10; $j++)echo "<td>".$r[$k*10+$j]."</td>";
                    echo "</tr>";
                }
            }
        }
      ?>
    </table>
    </div>
    <div id="curve_chart" style="width: 900px; height: 500px"></div>
    
  </body>
</html>



