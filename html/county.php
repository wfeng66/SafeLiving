<?php require('includes/header.html');  ?>
<head><title>Safe Living</title></head>


<?php
session_start(); // Start the session.

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	require('security/connect_t.php');
	$sql_setting1 = "INSERT INTO `UserSetting`(`userid`, `County`";
	$sql_setting2 = ') VALUES('.$_SESSION['userid'].', "'.$_POST['county'].'"';

	// append condition on gender for $sql_setting
	if (!empty($_POST['gender'])){
		foreach ($_POST['gender'] as $gen){
			$sql_setting1 = $sql_setting1.", `".$gen."`";
			$sql_setting2 = $sql_setting2.", 1";
		}
	}

	// append condition on age for $sql_setting
	if (!empty($_POST['age'])){
		foreach ($_POST['age'] as $age){
			$sql_setting1 = $sql_setting1.", `".$age."`";
			$sql_setting2 = $sql_setting2.", 1";
		}
	}

	// append condition on race for $sql_setting
	if (!empty($_POST['race'])){
		foreach ($_POST['race'] as $race){
			$sql_setting1 = $sql_setting1.", `".$race."`";
			$sql_setting2 = $sql_setting2.", 1";
		}
	}

	// append condition on religion for $sql_setting
	if (!empty($_POST['religion'])){
		foreach ($_POST['religion'] as $reli){
			$sql_setting1 = $sql_setting1.", `".$reli."`";
			$sql_setting2 = $sql_setting2.", 1";
		}
	}

	// append condition on sexual orientation for $sql_setting
	if (!empty($_POST['sexual'])){
		foreach ($_POST['sexual'] as $s){
			$sql_setting1 = $sql_setting1.", `".$s."`";
			$sql_setting2 = $sql_setting2.", 1";
		}
	}
	// append condition on disability for $sql_setting
	if (!empty($_POST['disa'])){
		foreach ($_POST['disa'] as $disa){
			$sql_setting1 = $sql_setting1.", `".$disa."`";
			$sql_setting2 = $sql_setting2.", 1";
		}
	}

	// combine the whole sql query
	$sql_setting = $sql_setting1.$sql_setting2.")";
	if(mysqli_query($dbc,$sql_setting)){
		echo "Setting successful!";
	}else{
		echo "Writting error, please contact administrator!";
	}



	mysqli_close($dbc); // Close the database connection.
} 

?>

<div class='reportform'>
    <div id='left'>
        
    <h3><p><?php echo "Hi ".$_SESSION['user'] ?>, Congratulation! Registered Successful!</p>
    <p>Please spend minutes to setup your preference, so that system can load your data automatically once your logined.</p></h3><br>
	<form method='post' action='county.php'>

	<p>County: <select name='county'>
	  <option value='Albany'>Albany</option>
	  <option value='Allegany'>Allegany</option>
	  <option value='Bronx'>Bronx</option>
	  <option value='Broome'>Broome</option>
	  <option value='Cayuga'>Cayuga</option>
	  <option value='Chemung'>Chemung</option>
	  <option value='Chenango'>Chenango</option>
	  <option value='Clinton'>Clinton</option>
	  <option value='Dutchess'>Dutchess</option>
	  <option value='Erie'>Erie</option>
	  <option value='Essex'>Essex</option>
	  <option value='Franklin'>Franklin</option>
	  <option value='Jefferson'>Jefferson</option>
	  <option value='Kings'>Kings</option>
	  <option value='Livingston'>Livingston</option>
	  <option value='Madison'>Madison</option>
	  <option value='Monroe'>Monroe</option>
	  <option value='Montgomery'>Montgomery</option>
	  <option value='Multiple'>Multiple</option>
	  <option value='Nassau'>Nassau</option>
	  <option value='New York'>New York</option>
	  <option value='Niagara'>Niagara</option>
	  <option value='Oneida'>Oneida</option>
	  <option value='Orange'>Orange</option>
	  <option value='Oswego'>Oswego</option>
	  <option value='Otsego'>Otsego</option>
	  <option value='Queens'>Queens</option>
	  <option value='Richmond'>Richmond</option>
	  <option value='Rockland'>Rockland</option>
	  <option value='Saratoga'>Saratoga</option>
	  <option value='Schenectady'>Schenectady</option>
	  <option value='Schoharie'>Schoharie</option>
	  <option value='St. Lawrence'>St. Lawrence</option>
	  <option value='Suffolk'>Suffolk</option>
	  <option value='Tompkins'>Tompkins</option>
	  <option value='Ulster'>Ulster</option>
	  <option value='Wayne'>Wayne</option>
	  <option value='Westchester'>Westchester</option>
	</select></p>
	

	<br>
	<p>Gender</p>
	<input type='checkbox' name='gender[]' value='AntiMale'>Male
	<input type='checkbox' name='gender[]' value='AntiFemale'>Female
	<input type='checkbox' name='gender[]' value='AntiTransgender'>Other<br>

	<p>Age</p>
	<input type='checkbox' name='age[]' value='AntiAge'>Anti-Age<br>

	<br>
	<p>Race</p>
	<input type='checkbox' name='race[]' value='AntiAsian'>Asian
	<input type='checkbox' name='race[]' value='AntiBlack'>Black
	<input type='checkbox' name='race[]' value='AntiHispanic'>Hispanic
	<input type='checkbox' name='race[]' value='AntiAmericanIndianAlaskanNative'>Indian/Alaskan Native
	<input type='checkbox' name='race[]' value='AntiMulti-RacialGrp'>Multiple Racial
	<input type='checkbox' name='race[]' value='AntiNativeHawaiiPacif'>Native Hawaiian/Pacific Island
	<input type='checkbox' name='race[]' value='AntiWhite'>White
	<input type='checkbox' name='race[]' value='AntiOtherRace'>Other<br>

	<br>
	<p>Religion</p>
	<input type='checkbox' name='religion[]' value='AntiAtheismAgnosticism'>Atheism/Agnosticism
	<input type='checkbox' name='religion[]' value='AntiBuddhist'>Buddhist
	<input type='checkbox' name='religion[]' value='AntiCatholic'>Catholic
	<input type='checkbox' name='religion[]' value='AntiEasternOrthodox'>Easter Orthodox
	<input type='checkbox' name='religion[]' value='AntiHindu'>Hindu
	<input type='checkbox' name='religion[]' value='AntiIslamicMuslim'>Islamic/Muslin
	<input type='checkbox' name='religion[]' value='AntiJehovahsWitness'>Jehovahs Witness
	<input type='checkbox' name='religion[]' value='AntiJewish'>Jewish
	<input type='checkbox' name='religion[]' value='AntiMormon'>Mormon
	<input type='checkbox' name='religion[]' value='AntiMulti-ReligGrp'>Multi-Religious
	<input type='checkbox' name='religion[]' value='AntiProtestant'>Protestant
	<input type='checkbox' name='religion[]' value='AntiSikh'>Sikh
	<input type='checkbox' name='religion[]' value='AntiOtherChristian'>Other Christian
	<input type='checkbox' name='religion[]' value='AntiOtherReligion'>Other<br>

	<br>
	<p>Sexual Orientation</p>
	<input type='checkbox' name='sexual[]' value='AntiBisexual' >Bisexual
	<input type='checkbox' name='sexual[]' value='AntiGayMale' >Gay
	<input type='checkbox' name='sexual[]' value='AntiHeterosexual' >Heterosexual
	<input type='checkbox' name='sexual[]' value='AntiGayFemale' >Lesbian<br>

	<br>
	<p>Disability:</p>
	<input type='checkbox' name='disa[]' value='AntiPhysDisa'>Physical Disability
    <input type='checkbox' name='disa[]' value='AntiMentDisa'>Mental Disability<br>
<!--
	<p>Crime Methods</p>
	<input type='checkbox' name='crimem[]' value='Crime Against Persons'>Crime Against Persons
	<input type='checkbox' name='crimem[]' value='Property Crime'>Property Crime<br>
-->
	<p><input type='submit' name='submit' value='submit'></p>


 </form>
    </div>
</div>

</html>