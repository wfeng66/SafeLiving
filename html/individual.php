<?php

include('includes/header.html');

?>
<div class='confform'>
    <div id='left'>
        <form method='post' action='showselection_t3.php'>
            <br><br>
            <p>Gender:</p>
            <input type='radio' name='gender' value='AntiMale' checked>Male
            <input type='radio' name='gender' value='AntiFemale' checked>Female
            <input type='radio' name='gender' value='AntiTransgender' checked>Other
            <br><br>
            <p>Race: <select name='race'>
                <option value='AntiArab'>Arab</option>
                <option value='AntiAsian'>Asian</option>
                <option value='AntiBlack'>Black</option>
                <option value='AntiHispanic'>Hispanic</option>
                <option value='AntiAmericanIndianAlaskanNative'>Indian/Alaskan Native</option>
                <option value='AntiMulti-RacialGrp'>Multiple Racial</option>
                <option value='AntiNativeHawaiiPacif'>Native Hawaiian/Pacific Island</option>
                <option value='AntiWhite'>White</option>
                <option value='AntiOtherRace'>Other</option>
            </select>
            <br><br>
            <p>Religion: <select name='religion'>
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
            </select>
            <br><br>
            <p>Religion: </p>
            <input type='radio' name='sexual' value='AntiBisexual' checked>Bisexual
            <input type='radio' name='sexual' value='AntiGayMale' checked>Gay
            <input type='radio' name='sexual' value='AntiHeterosexual' checked>Heterosexual
            <input type='radio' name='sexual' value='AntiGayFemale' checked>Lesbian
            <br><br>
            <p>Disability:</p>
            <input type='checkbox' name='disa' value='AntiPhysDisa'>Physical Disability
            <input type='checkbox' name='disa' value='AntiMentDisa'>Mental Disability
            <input type='checkbox' name='disa' value='NonDisa'>Non-Disability
            <br><br>
            <p><input type='submit' name='screen' value='screen'></p>
            <br><br>

            <p>Please select your personal information, system will analysis the risks level basing on your input.</p>

        </form>
    </div>
</div>
</body>
</html>
