
<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	require('security/connect_t.php');

	if (empty($_POST['fullname'])||empty($_POST['cellphone'])||empty($_POST['email'])||empty($_POST['county'])||empty($_POST['gender'])||empty($_POST['race'])||empty($_POST['religion'])||empty($_POST['sexual'])||empty($_POST['disa'])||empty($_POST['crimetype']))
	{
		echo "You forgot one or more items with asterisk, please make sure that you have filled all of them!";
	}else{
		$sql_setting1 = "INSERT INTO `Reported`(`FullName`, `CellPhone`, `Email`, `County`, `".$_POST['gender']."`, `".$_POST['race']."`, `".$_POST['religion']."`, `".$_POST['sexual']."`, `".$_POST['disa']."`, `CrimeType`";
		$sql_setting2 = ') VALUES("'.trim($_POST['fullname']).'", '.trim($_POST['cellphone']).', "'.trim($_POST['email']).'", "'.$_POST['county'].'", 1, 1, 1, 1, 1, "'.$_POST['crimetype'].'"';	
	}


	// append condition on case number for $sql_setting
	if (!empty($_POST['casenum'])){
			$sql_setting1 = $sql_setting1.", `CaseNo`";
			$sql_setting2 = $sql_setting2.', "'.trim($_POST['casenum']).'"';
	}

	// append condition on incident address for $sql_setting
	if (!empty($_POST['address'])){
		$sql_setting1 = $sql_setting1.", `IncAdd`";
		$sql_setting2 = $sql_setting2.', "'.trim($_POST['address']).'"';
	}

	// append condition on description for $sql_setting
	if (!empty($_POST['desc'])){
		$sql_setting1 = $sql_setting1.", `Description`";
		$sql_setting2 = $sql_setting2.', "'.trim($_POST['desc']).'"';
	}


	// combine the whole sql query
	$sql_setting = $sql_setting1.$sql_setting2.');';
	//echo $sql_setting;
	if(mysqli_query($dbc,$sql_setting)){
		echo "Report successful!";
	}else{
		echo "Writting error, please contact administrator!";
	}

	mysqli_close($dbc); // Close the database connection.
} 

$today = date('Y-m-d');
$min = strtotime("-6 Months");

include('includes/header.html');
?>

	<h2>Incident Report</h2>
	<br>
    <form method='post' action='report.php'>
	<div class="reportform">
		<div id="left">
			<P>Full Name: <input type="text" name="fullname"></p>
			<P>Cell Phone: <input type="number" name="cellphone"></p>
			<P>Email: <input type="email" name="email"></p>
			
			<label for="date">Happen time:</label>
			<input type="date" id="date" name="happendate"
			value= <?php echo '"'.$today.'"'  ?>
			min=<?php echo '"'.$min.'"'  ?> max= <?php echo '"'.$today.'"' ?>>

			<br>
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

			<p>Gender <select name='gender'>
				<option value='AntiMale'>Male</option>
				<option value='AntiFemale'>Female</option>
				<option value='AntiTransgender'>Other</option>
			</select></p>

			<p>Race <select name='race'>
				<option value='AntiAsian'>Asian</option>
				<option value='AntiBlack'>Black</option>
				<option value='AntiHispanic'>Hispanic</option>
				<option value='AntiAmericanIndianAlaskanNative'>Indian/Alaskan Native</option>
				<option value='AntiMulti-RacialGrp'>Multiple Racial</option>
				<option value='AntiNativeHawaiiPacif'>Native Hawaiian/Pacific Island</option>
				<option value='AntiWhite'>White</option>
				<option value='AntiOtherRace'>Other</option>
			</select></p>

			<p>Religion <select name='religion'>
				<option value='AntiAtheismAgnosticism'>Atheism/Agnosticism</option>
				<option value='AntiBuddhist'>Buddhist</option>
				<option value='AntiCatholic'>Catholic</option>
				<option value='AntiEasternOrthodox'>Easter Orthodox</option>
				<option value='AntiHindu'>Hindu</option>
				<option value='AntiIslamicMuslim'>Islamic/Muslin</option>
				<option value='AntiJehovahsWitness'>Jehovahs Witness</option>
				<option value='AntiJewish'>Jewish</option>
				<option value='AntiMormon'>Mormon</option>
				<option value='AntiMulti-ReligGrp'>Multi-Religious</option>
				<option value='AntiProtestant'>Protestant</option>
				<option value='AntiSikh'>Sikh</option>
				<option value='AntiOtherChristian'>Other Christian</option>
				<option value='AntiOtherReligion'>Other</option>
			</select></p> 

			<p>Sexual Orientation<select name='sexual'>
				<option value='AntiBisexual'>Bisexual</option>
				<option value='AntiGayMale'>Gay</option>
				<option value='AntiHeterosexual'>Heterosexual</option>
				<option value='AntiGayFemale'>Lesbian</option>
			</select></p> 

			<p>Disability <select name='disa'>
				<option value='AntiPhysDisa'>Physical Disability</option>
				<option value='AntiMentDisa'>Mental Disability</option>
				<option value='NonDisa'>Non-Disability</option>
			</select></p> 

		</div>

		<br>
		<div id="right">
			<P>Case Number: <input type="text" name="casenum"></p>
			
			<p>Crime Type <select name='crimetype'>
				<option value='Assault'>Assault</option>
				<option value='Battery'>Battery</option>
				<option value='Imprisonment'>False Imprisonment</option>
				<option value='Kidnapping'>Kidnapping</option>
				<option value='Murder'>Murder</option>
				<option value='Sexual'>Rape or other offenses of a sexual nature</option>
				<option value='Robbery'>Robbery</option>  
				<option value='Larceny'>Larceny</option>
				<option value='Burglary'>Burglary</option>  
				<option value='Arson'>Arson</option>
				<option value='Other'>Other</option>            
			</select></p> 

			<P>Incidental Address: <input type="text" name="address"></p>

			<p>Description:</p>
			<textarea name="desc" style="width:500px; height:200px;">
				Please input detail information!
			</textarea>
		</div>
	</div>
<div class="submitbutton">
	<p><input type='submit' name='submit' value='submit'></p>
</div> 
</form>
<!-- </div>   -->
</body>


</html>