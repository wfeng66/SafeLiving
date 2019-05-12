<?php # Script 12.9 - showcounty.php #2
// The user is redirected here from login.php or county.php.
session_start(); // Start the session.

$page_title = 'Incidence Confirmation';


require('security/connect_t.php');
require('includes/login_functions.inc.php');
require('includes/header.html');
if (!isset($_SESSION['userid'])) {
	redirect_user('login_t.php');
}

if ($_SESSION['userid']!=38){
    echo "You haven't permission to access this page! ";
    redirect_user('showcounty.php');
}
       
$q_needconf = "SELECT `id`, `FullName`,`County`, `CellPhone`, `Email`, `IncAdd`, `CrimeType`, `CaseNo`, `Description` FROM `Reported` WHERE `Confirmation` = 0 LIMIT 1;";
$r_needconf = mysqli_query($dbc, $q_needconf);
$result_needconf = mysqli_fetch_array($r_needconf, MYSQLI_ASSOC);
$id = $result_needconf['id'];
$county = $result_needconf['County'];

// create gender query
$q_gender = "SELECT `AntiMale`, `AntiFemale`, `AntiTransgender` FROM `Reported` WHERE `id` = $id LIMIT 1;";
$r_gender = mysqli_query($dbc, $q_gender);
$result_gender = mysqli_fetch_array($r_gender, MYSQLI_ASSOC);

// create race query
$q_race = "SELECT `AntiAsian`, `AntiBlack`, `AntiHispanic`, `AntiAmericanIndianAlaskanNative`, `AntiMultiRacialGrp`, `AntiNativeHawaiiPacif`, `AntiWhite`, `AntiOtherRace` FROM `Reported` WHERE `id` = $id LIMIT 1;";
$r_race = mysqli_query($dbc, $q_race);
$result_race = mysqli_fetch_array($r_race, MYSQLI_ASSOC);

// create religion query
$q_religion = "SELECT 'AntiAtheismAgnosticism', 'AntiBuddhist', 'AntiCatholic', 'AntiEasternOrthodox', 'AntiHindu', 'AntiIslamicMuslim', 'AntiJehovahsWitness', 'AntiJewish', 'AntiMormon', 'AntiMultiReligGrp', 'AntiProtestant', 'AntiSikh', 'AntiOtherChristian', 'AntiOtherReligion' FROM `Reported` WHERE `id` = $id LIMIT 1;";
$r_religion = mysqli_query($dbc, $q_religion);
$result_religion = mysqli_fetch_array($r_religion, MYSQLI_ASSOC);

// create sexual orientation query
$q_sexual = "SELECT 'AntiBisexual', 'AntiGayMale', 'AntiHeterosexual', 'AntiGayFemale' FROM `Reported` WHERE `id` = $id LIMIT 1;";
$r_sexual = mysqli_query($dbc, $q_sexual);
$result_sexual = mysqli_fetch_array($r_sexual, MYSQLI_ASSOC);

// create disability query
$q_disa = "SELECT 'AntiPhysDisa', 'AntiMentDisa', 'NonDisa' FROM `Reported` WHERE `id` = $id LIMIT 1;";
$r_disa = mysqli_query($dbc, $q_disa);
$result_disa = mysqli_fetch_array($r_disa, MYSQLI_ASSOC);

// create crimetype query
$q_crimetype = "SELECT 'crimetype' FROM `Reported` WHERE `id` = $id LIMIT 1;";
$r_crimetype = mysqli_query($dbc, $q_crimetype);
$result_crimetype = mysqli_fetch_array($r_crimetype, MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	if($_POST['confirm']=='confirm') {
		$sql_setting1 = "UPDATE `Reported` SET  `County` ='".$_POST['county']."', `".$_POST['gender']."`=1, `".$_POST['race']."`=1, `".$_POST['religion']."`=1, `".$_POST['sexual']."`=1, `".$_POST['disa']."`=1, `CrimeType` = '".$_POST['crimetype']."', `Confirmation` = 1";
	}elseif($_POST['confirm']=='fake'){
		$sql_setting1 = "UPDATE `Reported` SET  `County` ='".$_POST['county']."', `".$_POST['gender']."`=1, `".$_POST['race']."`=1, `".$_POST['religion']."`=1, `".$_POST['sexual']."`=1, `".$_POST['disa']."`=1, `CrimeType` = '".$_POST['crimetype']."', `Confirmation` = -1";
	}

	$sql_setting2 = " WHERE `id`=".$id;

	// combine the whole sql query
	$sql_setting = $sql_setting1.$sql_setting2.';';
	echo $sql_setting;

    if(mysqli_query($dbc,$sql_setting)){
        echo "Setting successful!";
    }else{
        echo "Writting error, please contact administrator!";
    }

	mysqli_close($dbc); // Close the database connection.
} 



// show form depending on reported information
if(isset($result_needconf)){
	// Base information
	echo  "<form method='post' action='police.php'>";
	echo "<div class='confform'>";
	echo "<br><br><h3>Case Information</h3>";
	echo "<div id='left'>";
	foreach($result_needconf as $k=>$v){
		if($k != 'id'){
			echo $k.": ".$v."<br><br>";
		}
	}
	echo "</div>";

	echo "<div id='right'>";
	// gender option
	echo "<p>Gender <select name='gender'>";
	foreach($result_gender as $k=>$v){
		if(is_null($v)){
			echo "<option value='".$k."'>".$k."</option>";
		}else{
			echo "<option value='".$k."'selected>".$k."</option>";
		}
	}
	echo "</select></p>";

	// race option
	echo "<p>Race <select name='race'>";
	foreach($result_race as $k=>$v){
		if(is_null($v)){
			echo "<option value='".$k."'>".$k."</option>";
		}else{
			echo "<option value='".$k."'selected>".$k."</option>";
		}
	}
	echo "</select></p>";

	// religion option
	echo "<p>Religion <select name='religion'>";
	foreach($result_religion as $k=>$v){
		if(is_null($v)){
			echo "<option value='".$k."'>".$k."</option>";
		}else{
			echo "<option value='".$k."'selected>".$k."</option>";
		}
	}
	echo "</select></p>";

	// Sexual Orientation option
	echo "<p>Sexual Orientation <select name='sexual'>";
	foreach($result_sexual as $k=>$v){
		if(is_null($v)){
			echo "<option value='".$k."'>".$k."</option>";
		}else{
			echo "<option value='".$k."'selected>".$k."</option>";
		}
	}
	echo "</select></p>";

	// disability option
	echo "<p>Disability <select name='disa'>";
	foreach($result_disa as $k=>$v){
		if(is_null($v)){
			echo "<option value='".$k."'>".$k."</option>";
		}else{
			echo "<option value='".$k."'selected>".$k."</option>";
		}
	}
	echo "</select></p>";

	// crimetype option
	foreach($result_crimetype as $k=>$v){
		$crimetype = $v;
	}

}else{
	echo "There is no confirmation need!";
}


?>




	<p>County: <select name='county'>
	  <option value='Albany'<?php if ($county == 'Albany' ) echo 'selected' ; ?>>Albany</option>
	  <option value='Allegany'<?php if ($county == 'Allegany' ) echo 'selected' ; ?>>Allegany</option>
	  <option value='Bronx'<?php if ($county == 'Bronx' ) echo 'selected' ; ?>>Bronx</option>
	  <option value='Broome'<?php if ($county == 'Broome' ) echo 'selected' ; ?>>Broome</option>
	  <option value='Cayuga'<?php if ($county == 'Cayuga' ) echo 'selected' ; ?>>Cayuga</option>
	  <option value='Chemung'<?php if ($county == 'Chemung' ) echo 'selected' ; ?>>Chemung</option>
	  <option value='Chenango'<?php if ($county == 'Chenango' ) echo 'selected' ; ?>>Chenango</option>
	  <option value='Clinton'<?php if ($county == 'Clinton' ) echo 'selected' ; ?>>Clinton</option>
	  <option value='Dutchess'<?php if ($county == 'Dutchess' ) echo 'selected' ; ?>>Dutchess</option>
	  <option value='Erie'<?php if ($county == 'Erie' ) echo 'selected' ; ?>>Erie</option>
	  <option value='Essex'<?php if ($county == 'Essex' ) echo 'selected' ; ?>>Essex</option>
	  <option value='Franklin'<?php if ($county == 'Franklin' ) echo 'selected' ; ?>>Franklin</option>
	  <option value='Jefferson'><?php if ($county == 'Jefferson' ) echo 'selected' ; ?>Jefferson</option>
	  <option value='Kings'<?php if ($county == 'Kings' ) echo 'selected' ; ?>>Kings</option>
	  <option value='Livingston'<?php if ($county == 'Livingston' ) echo 'selected' ; ?>>Livingston</option>
	  <option value='Madison'<?php if ($county == 'Madison' ) echo 'selected' ; ?>>Madison</option>
	  <option value='Monroe'<?php if ($county == 'Monroe' ) echo 'selected' ; ?>>Monroe</option>
	  <option value='Montgomery'<?php if ($county == 'Montgomery' ) echo 'selected' ; ?>>Montgomery</option>
	  <option value='Multiple'<?php if ($county == 'Multiple' ) echo 'selected' ; ?>>Multiple</option>
	  <option value='Nassau'<?php if ($county == 'Nassau' ) echo 'selected' ; ?>>Nassau</option>
	  <option value='New York'<?php if ($county == 'New York' ) echo 'selected' ; ?>>New York</option>
	  <option value='Niagara'<?php if ($county == 'Niagara' ) echo 'selected' ; ?>>Niagara</option>
	  <option value='Oneida'<?php if ($county == 'Oneida' ) echo 'selected' ; ?>>Oneida</option>
	  <option value='Orange'<?php if ($county == 'Orange' ) echo 'selected' ; ?>>Orange</option>
	  <option value='Oswego'<?php if ($county == 'Oswego' ) echo 'selected' ; ?>>Oswego</option>
	  <option value='Otsego'<?php if ($county == 'Otsego' ) echo 'selected' ; ?>>Otsego</option>
	  <option value='Queens'<?php if ($county == 'Queens' ) echo 'selected' ; ?>>Queens</option>
	  <option value='Richmond'<?php if ($county == 'Richmond' ) echo 'selected' ; ?>>Richmond</option>
	  <option value='Rockland'<?php if ($county == 'Rockland' ) echo 'selected' ; ?>>Rockland</option>
	  <option value='Saratoga'<?php if ($county == 'Saratoga' ) echo 'selected' ; ?>>Saratoga</option>
	  <option value='Schenectady'<?php if ($county == 'Schenectady' ) echo 'selected' ; ?>>Schenectady</option>
	  <option value='Schoharie'<?php if ($county == 'Schoharie' ) echo 'selected' ; ?>>Schoharie</option>
	  <option value='St. Lawrence'<?php if ($county == 'St. Lawrence' ) echo 'selected' ; ?>>St. Lawrence</option>
	  <option value='Suffolk'<?php if ($county == 'Suffolk' ) echo 'selected' ; ?>>Suffolk</option>
	  <option value='Tompkins'<?php if ($county == 'Tompkins' ) echo 'selected' ; ?>>Tompkins</option>
	  <option value='Ulster'<?php if ($county == 'Ulster' ) echo 'selected' ; ?>>Ulster</option>
	  <option value='Wayne'<?php if ($county == 'Wayne' ) echo 'selected' ; ?>>Wayne</option>
	  <option value='Westchester'<?php if ($county == 'Westchester' ) echo 'selected' ; ?>>Westchester</option>
	</select></p>

	<p>Crime Type <select name='crimetype'>
        <option value='Assault'<?php if ($crimetype == 'Assault' ) echo 'selected' ; ?>>Assault</option>
        <option value='Battery'<?php if ($crimetype == 'Battery' ) echo 'selected' ; ?>>Battery</option>
        <option value='Imprisonment'<?php if ($crimetype == 'Imprisonment' ) echo 'selected' ; ?>>False Imprisonment</option>
        <option value='Kidnapping'<?php if ($crimetype == 'Kidnapping' ) echo 'selected' ; ?>>Kidnapping</option>
        <option value='Murder'<?php if ($crimetype == 'Murder' ) echo 'selected' ; ?>>Murder</option>
        <option value='Sexual'<?php if ($crimetype == 'Sexual' ) echo 'selected' ; ?>>Rape or other offenses of a sexual nature</option>
        <option value='Robbery'<?php if ($crimetype == 'Robbery' ) echo 'selected' ; ?>>Robbery</option>  
        <option value='Larceny'<?php if ($crimetype == 'Larceny' ) echo 'selected' ; ?>>Larceny</option>
        <option value='Burglary'<?php if ($crimetype == 'Burglary' ) echo 'selected' ; ?>>Burglary</option>  
        <option value='Arson'<?php if ($crimetype == 'Arson' ) echo 'selected' ; ?>>Arson</option>
        <option value='Other'<?php if ($crimetype == 'Other' ) echo 'selected' ; ?>>Other</option>            
	</select></p> 
	
	<p>
	<p>Confirm <select name='confirm'>
        <option value='confirm'>Confirm</option>
				<option value='fake'>Fake</option>            
	</select></p> 
	</div>
		
	</p>
</div>
<p>
<input type='submit' name='submit' value='submit'>
 </form>

</body>
</html>