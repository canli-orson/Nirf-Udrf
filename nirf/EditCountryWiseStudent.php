<?php
include 'config.php';
require "header.php";
// error_reporting(E_ALL);
error_reporting(0);


$dept = $_SESSION['dept_id'];

if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['ID'])) {
	$id = filter_var($_GET['ID'], FILTER_SANITIZE_NUMBER_INT);

	// Fetch existing data for the record being edited
	$query = "SELECT * FROM country_wise_student WHERE ID = ? AND DEPT_ID = ?";
	$stmt = mysqli_prepare($conn, $query);
	mysqli_stmt_bind_param($stmt, "ii", $id, $dept);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);

	if ($result && mysqli_num_rows($result) > 0) {
		$row = mysqli_fetch_assoc($result);
		$program_name = htmlspecialchars($row['PROGRAM_NAME'], ENT_QUOTES, 'UTF-8');
		$country_code = htmlspecialchars($row['COUNTRY_CODE'], ENT_QUOTES, 'UTF-8');
		$num_students = htmlspecialchars($row['NO_OF_STUDENT_COUNTRY'], ENT_QUOTES, 'UTF-8');
	} else {
		echo "<script>alert('Invalid Record ID.');</script>";
		echo '<script>window.location.href = "countryWiseStudent.php";</script>';
		exit;
	}
}

if (isset($_POST['update'])) {
	$id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
	$p_name = trim($_POST['p_name']);

	// Fetch PROGRAM_CODE from program_master based on PROGRAM_NAME
	$select_query = "SELECT `PROGRAM_CODE` FROM `program_master` WHERE `PROGRAM_NAME` = ?";
	$stmt = mysqli_prepare($conn, $select_query);
	mysqli_stmt_bind_param($stmt, "s", $p_name);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);

	if ($result) {
		$row = mysqli_fetch_assoc($result);

		if ($row) {
			$p_code = htmlspecialchars($row['PROGRAM_CODE'], ENT_QUOTES, 'UTF-8');
			$countryCode = trim($_POST['countryCode']);
			$Country_wise_student = trim($_POST['Country_wise_student']);

			// Update query
			$update_query = "UPDATE `country_wise_student` SET
                `PROGRAM_CODE` = ?,
                `PROGRAM_NAME` = ?,
                `COUNTRY_CODE` = ?,
                `NO_OF_STUDENT_COUNTRY` = ?
                WHERE `ID` = ? AND `DEPT_ID` = ?";

			$stmt = mysqli_prepare($conn, $update_query);
			mysqli_stmt_bind_param($stmt, "sssiii", $p_code, $p_name, $countryCode, $Country_wise_student, $id, $dept);

			if (mysqli_stmt_execute($stmt)) {
				echo "<script>alert('Data Updated Successfully.')</script>";
				echo '<script>window.location.href = "countryWiseStudent.php";</script>';
			} else {
				echo "<script>alert('Error updating record. Please try again later.')</script>";
			}
		} else {
			echo "<script>alert('Invalid Program Name.')</script>";
		}
	} else {
		echo "<script>alert('Error fetching Program Code.')</script>";
	}
}
?>


<div class="div">
	<form class="fw-bold" method="POST" enctype="multipart/form-data" autocomplete="off">
		<input type="hidden" name="id" value="<?php echo $id; ?>">

		<div class="mb-3">
			<p class="text-center fs-4 "><b>Edit Country Wise Student</b></p>
		</div>

		<div class="mb-3">
			<label class="form-label" style="margin-bottom: 6px;"><b>Academic Year</b></label>
			<input type="text" name="year" value="<?php echo $A_YEAR; ?>" class="form-control" style="margin-top: 0;" disabled>
		</div>

		<div class="mb-3">
			<label class="form-label" style="margin-bottom: 6px;"><b>Department ID</b></label>
			<input type="text" name="dpt_id" value="<?php echo $dept; ?>" class="form-control" style="margin-top: 0;" disabled>
		</div>

		<div class="mb-3">
			<label class="form-label" style="margin-bottom: 6px;"><b>Program Name</b></label>
			<select name="p_name" class="form-control" style="margin-top: 0;">
				<?php
				$sql = "SELECT * FROM `program_master`";
				$result = mysqli_query($conn, $sql);
				while ($row = mysqli_fetch_assoc($result)) {
					if ($row['PROGRAM_NAME'] == $program_name) {
						echo '<option selected value="' . htmlspecialchars($row['PROGRAM_NAME']) . '">' . htmlspecialchars($row['PROGRAM_NAME']) . '</option>';
					} else {
						echo '<option value="' . htmlspecialchars($row['PROGRAM_NAME']) . '">' . htmlspecialchars($row['PROGRAM_NAME']) . '</option>';
					}
				}
				?>
			</select>
		</div>

		<div class="mb-3">
			<label class="form-label" style="margin-bottom: 6px;"><b>Country Code</b></label>
			<select name="countryCode" class="form-control">
				<option data-countryCode="IN" value="91" <?php echo ($country_code == '91') ? 'selected' : ''; ?>>India (+91)</option>
				<option data-countryCode="NO" value="47" <?php echo ($country_code == '47') ? 'selected' : ''; ?>>Norway (+47)</option>
				<option data-countryCode="GB" value="44" <?php echo ($country_code == '44') ? 'selected' : ''; ?>>United Kingdom (+44)</option>
				<optgroup label="Other countries">
					<option data-countryCode="AD" value="376" <?php echo ($country_code == '376') ? 'selected' : ''; ?>>Andorra (+376)</option>
					<option data-countryCode="DZ" value="213" <?php echo ($country_code == '213') ? 'selected' : ''; ?>>Algeria (+213)</option>
					<option data-countryCode="AI" value="1264" <?php echo ($country_code == '1264') ? 'selected' : ''; ?>>Anguilla (+1264)</option>
					<option data-countryCode="AO" value="244" <?php echo ($country_code == '244') ? 'selected' : ''; ?>>Angola (+244)</option>
					<option data-countryCode="AG" value="1268" <?php echo ($country_code == '1268') ? 'selected' : ''; ?>>Antigua &amp; Barbuda (+1268)</option>
					<option data-countryCode="AR" value="54" <?php echo ($country_code == '54') ? 'selected' : ''; ?>>Argentina (+54)</option>
					<option data-countryCode="AM" value="374" <?php echo ($country_code == '374') ? 'selected' : ''; ?>>Armenia (+374)</option>
					<option data-countryCode="AW" value="297" <?php echo ($country_code == '297') ? 'selected' : ''; ?>>Aruba (+297)</option>
					<option data-countryCode="AU" value="61" <?php echo ($country_code == '61') ? 'selected' : ''; ?>>Australia (+61)</option>
					<option data-countryCode="AT" value="43" <?php echo ($country_code == '43') ? 'selected' : ''; ?>>Austria (+43)</option>
					<option data-countryCode="AZ" value="994" <?php echo ($country_code == '994') ? 'selected' : ''; ?>>Azerbaijan (+994)</option>

					<option data-countryCode="BS" value="1242" <?php echo ($country_code == '1242') ? 'selected' : ''; ?>>Bahamas (+1242)</option>
					<option data-countryCode="BH" value="973" <?php echo ($country_code == '973') ? 'selected' : ''; ?>>Bahrain (+973)</option>
					<option data-countryCode="BD" value="880" <?php echo ($country_code == '880') ? 'selected' : ''; ?>>Bangladesh (+880)</option>
					<option data-countryCode="BB" value="1246" <?php echo ($country_code == '1246') ? 'selected' : ''; ?>>Barbados (+1246)</option>
					<option data-countryCode="BY" value="375" <?php echo ($country_code == '375') ? 'selected' : ''; ?>>Belarus (+375)</option>
					<option data-countryCode="BE" value="32" <?php echo ($country_code == '32') ? 'selected' : ''; ?>>Belgium (+32)</option>
					<option data-countryCode="BZ" value="501" <?php echo ($country_code == '501') ? 'selected' : ''; ?>>Belize (+501)</option>
					<option data-countryCode="BJ" value="229" <?php echo ($country_code == '229') ? 'selected' : ''; ?>>Benin (+229)</option>
					<option data-countryCode="BM" value="1441" <?php echo ($country_code == '1441') ? 'selected' : ''; ?>>Bermuda (+1441)</option>
					<option data-countryCode="BT" value="975" <?php echo ($country_code == '975') ? 'selected' : ''; ?>>Bhutan (+975)</option>
					<option data-countryCode="BO" value="591" <?php echo ($country_code == '591') ? 'selected' : ''; ?>>Bolivia (+591)</option>
					<option data-countryCode="BA" value="387" <?php echo ($country_code == '387') ? 'selected' : ''; ?>>Bosnia Herzegovina (+387)</option>
					<option data-countryCode="BW" value="267" <?php echo ($country_code == '267') ? 'selected' : ''; ?>>Botswana (+267)</option>
					<option data-countryCode="BR" value="55" <?php echo ($country_code == '55') ? 'selected' : ''; ?>>Brazil (+55)</option>
					<option data-countryCode="BN" value="673" <?php echo ($country_code == '673') ? 'selected' : ''; ?>>Brunei (+673)</option>
					<option data-countryCode="BG" value="359" <?php echo ($country_code == '359') ? 'selected' : ''; ?>>Bulgaria (+359)</option>
					<option data-countryCode="BF" value="226" <?php echo ($country_code == '226') ? 'selected' : ''; ?>>Burkina Faso (+226)</option>
					<option data-countryCode="BI" value="257" <?php echo ($country_code == '257') ? 'selected' : ''; ?>>Burundi (+257)</option>

					<option data-countryCode="KH" value="855" <?php echo ($country_code == '855') ? 'selected' : ''; ?>>Cambodia (+855)</option>
					<option data-countryCode="CM" value="237" <?php echo ($country_code == '237') ? 'selected' : ''; ?>>Cameroon (+237)</option>
					<option data-countryCode="CA" value="1" <?php echo ($country_code == '1') ? 'selected' : ''; ?>>Canada (+1)</option>
					<option data-countryCode="CV" value="238" <?php echo ($country_code == '238') ? 'selected' : ''; ?>>Cape Verde Islands (+238)</option>
					<option data-countryCode="KY" value="1345" <?php echo ($country_code == '1345') ? 'selected' : ''; ?>>Cayman Islands (+1345)</option>
					<option data-countryCode="CF" value="236" <?php echo ($country_code == '236') ? 'selected' : ''; ?>>Central African Republic (+236)</option>
					<option data-countryCode="CL" value="56" <?php echo ($country_code == '56') ? 'selected' : ''; ?>>Chile (+56)</option>
					<option data-countryCode="CN" value="86" <?php echo ($country_code == '86') ? 'selected' : ''; ?>>China (+86)</option>
					<option data-countryCode="CO" value="57" <?php echo ($country_code == '57') ? 'selected' : ''; ?>>Colombia (+57)</option>
					<option data-countryCode="KM" value="269" <?php echo ($country_code == '269') ? 'selected' : ''; ?>>Comoros (+269)</option>
					<option data-countryCode="CG" value="242" <?php echo ($country_code == '242') ? 'selected' : ''; ?>>Congo (+242)</option>
					<option data-countryCode="CK" value="682" <?php echo ($country_code == '682') ? 'selected' : ''; ?>>Cook Islands (+682)</option>
					<option data-countryCode="CR" value="506" <?php echo ($country_code == '506') ? 'selected' : ''; ?>>Costa Rica (+506)</option>
					<option data-countryCode="HR" value="385" <?php echo ($country_code == '385') ? 'selected' : ''; ?>>Croatia (+385)</option>
					<option data-countryCode="CU" value="53" <?php echo ($country_code == '53') ? 'selected' : ''; ?>>Cuba (+53)</option>

					<option data-countryCode="CY" value="90392" <?php echo ($country_code == '90392') ? 'selected' : ''; ?>>Cyprus North (+90392)</option>
					<option data-countryCode="CY" value="357" <?php echo ($country_code == '357') ? 'selected' : ''; ?>>Cyprus South (+357)</option>

					<option data-countryCode="CZ" value="420" <?php echo ($country_code == '420') ? 'selected' : ''; ?>>Czech Republic (+420)</option>
					<option data-countryCode="DK" value="45" <?php echo ($country_code == '45') ? 'selected' : ''; ?>>Denmark (+45)</option>

					<option data-countryCode="DJ" value="253" <?php echo ($country_code == '253') ? 'selected' : ''; ?>>Djibouti (+253)</option>
					<option data-countryCode="DM" value="1809" <?php echo ($country_code == '1809') ? 'selected' : ''; ?>>Dominica (+1809)</option>
					<option data-countryCode="DO" value="1809" <?php echo ($country_code == '1809') ? 'selected' : ''; ?>>Dominican Republic (+1809)</option>
					<option data-countryCode="EC" value="593" <?php echo ($country_code == '593') ? 'selected' : ''; ?>>Ecuador (+593)</option>
					<option data-countryCode="EG" value="20" <?php echo ($country_code == '20') ? 'selected' : ''; ?>>Egypt (+20)</option>
					<option data-countryCode="SV" value="503" <?php echo ($country_code == '503') ? 'selected' : ''; ?>>El Salvador (+503)</option>
					<option data-countryCode="GQ" value="240" <?php echo ($country_code == '240') ? 'selected' : ''; ?>>Equatorial Guinea (+240)</option>
					<option data-countryCode="ER" value="291" <?php echo ($country_code == '291') ? 'selected' : ''; ?>>Eritrea (+291)</option>
					<option data-countryCode="EE" value="372" <?php echo ($country_code == '372') ? 'selected' : ''; ?>>Estonia (+372)</option>
					<option data-countryCode="ET" value="251" <?php echo ($country_code == '251') ? 'selected' : ''; ?>>Ethiopia (+251)</option>
					<option data-countryCode="FK" value="500" <?php echo ($country_code == '500') ? 'selected' : ''; ?>>Falkland Islands (+500)</option>
					<option data-countryCode="FO" value="298" <?php echo ($country_code == '298') ? 'selected' : ''; ?>>Faroe Islands (+298)</option>
					<option data-countryCode="FJ" value="679" <?php echo ($country_code == '679') ? 'selected' : ''; ?>>Fiji (+679)</option>
					<option data-countryCode="FI" value="358" <?php echo ($country_code == '358') ? 'selected' : ''; ?>>Finland (+358)</option>
					<option data-countryCode="FR" value="33" <?php echo ($country_code == '33') ? 'selected' : ''; ?>>France (+33)</option>
					<option data-countryCode="GF" value="594" <?php echo ($country_code == '594') ? 'selected' : ''; ?>>French Guiana (+594)</option>
					<option data-countryCode="PF" value="689" <?php echo ($country_code == '689') ? 'selected' : ''; ?>>French Polynesia (+689)</option>
					<option data-countryCode="GA" value="241" <?php echo ($country_code == '241') ? 'selected' : ''; ?>>Gabon (+241)</option>
					<option data-countryCode="GM" value="220" <?php echo ($country_code == '220') ? 'selected' : ''; ?>>Gambia (+220)</option>
					<option data-countryCode="GE" value="995" <?php echo ($country_code == '995') ? 'selected' : ''; ?>>Georgia (+995)</option>
					<option data-countryCode="DE" value="49" <?php echo ($country_code == '49') ? 'selected' : ''; ?>>Germany (+49)</option>
					<option data-countryCode="GH" value="233" <?php echo ($country_code == '233') ? 'selected' : ''; ?>>Ghana (+233)</option>
					<option data-countryCode="GI" value="350" <?php echo ($country_code == '350') ? 'selected' : ''; ?>>Gibraltar (+350)</option>
					<option data-countryCode="GR" value="30" <?php echo ($country_code == '30') ? 'selected' : ''; ?>>Greece (+30)</option>
					<option data-countryCode="GL" value="299" <?php echo ($country_code == '299') ? 'selected' : ''; ?>>Greenland (+299)</option>
					<option data-countryCode="GD" value="1473" <?php echo ($country_code == '1473') ? 'selected' : ''; ?>>Grenada (+1473)</option>
					<option data-countryCode="GP" value="590" <?php echo ($country_code == '590') ? 'selected' : ''; ?>>Guadeloupe (+590)</option>
					<option data-countryCode="GU" value="671" <?php echo ($country_code == '671') ? 'selected' : ''; ?>>Guam (+671)</option>
					<option data-countryCode="GT" value="502" <?php echo ($country_code == '502') ? 'selected' : ''; ?>>Guatemala (+502)</option>
					<option data-countryCode="GN" value="224" <?php echo ($country_code == '224') ? 'selected' : ''; ?>>Guinea (+224)</option>
					<option data-countryCode="GW" value="245" <?php echo ($country_code == '245') ? 'selected' : ''; ?>>Guinea - Bissau (+245)</option>
					<option data-countryCode="GY" value="592" <?php echo ($country_code == '592') ? 'selected' : ''; ?>>Guyana (+592)</option>

					<option data-countryCode="HT" value="509" <?php echo ($country_code == '509') ? 'selected' : ''; ?>>Haiti (+509)</option>
					<option data-countryCode="HN" value="504" <?php echo ($country_code == '504') ? 'selected' : ''; ?>>Honduras (+504)</option>
					<option data-countryCode="HK" value="852" <?php echo ($country_code == '852') ? 'selected' : ''; ?>>Hong Kong (+852)</option>
					<option data-countryCode="HU" value="36" <?php echo ($country_code == '36') ? 'selected' : ''; ?>>Hungary (+36)</option>
					<option data-countryCode="IS" value="354" <?php echo ($country_code == '354') ? 'selected' : ''; ?>>Iceland (+354)</option>
					<option data-countryCode="ID" value="62" <?php echo ($country_code == '62') ? 'selected' : ''; ?>>Indonesia (+62)</option>
					<option data-countryCode="IR" value="98" <?php echo ($country_code == '98') ? 'selected' : ''; ?>>Iran (+98)</option>
					<option data-countryCode="IQ" value="964" <?php echo ($country_code == '964') ? 'selected' : ''; ?>>Iraq (+964)</option>
					<option data-countryCode="IE" value="353" <?php echo ($country_code == '353') ? 'selected' : ''; ?>>Ireland (+353)</option>
					<option data-countryCode="IL" value="972" <?php echo ($country_code == '972') ? 'selected' : ''; ?>>Israel (+972)</option>
					<option data-countryCode="IT" value="39" <?php echo ($country_code == '39') ? 'selected' : ''; ?>>Italy (+39)</option>
					<option data-countryCode="JM" value="1876" <?php echo ($country_code == '1876') ? 'selected' : ''; ?>>Jamaica (+1876)</option>
					<option data-countryCode="JP" value="81" <?php echo ($country_code == '81') ? 'selected' : ''; ?>>Japan (+81)</option>
					<option data-countryCode="JO" value="962" <?php echo ($country_code == '962') ? 'selected' : ''; ?>>Jordan (+962)</option>
					<option data-countryCode="KZ" value="7" <?php echo ($country_code == '7') ? 'selected' : ''; ?>>Kazakhstan (+7)</option>
					<option data-countryCode="KE" value="254" <?php echo ($country_code == '254') ? 'selected' : ''; ?>>Kenya (+254)</option>
					<option data-countryCode="KI" value="686" <?php echo ($country_code == '686') ? 'selected' : ''; ?>>Kiribati (+686)</option>
					<option data-countryCode="KP" value="850" <?php echo ($country_code == '850') ? 'selected' : ''; ?>>Korea North (+850)</option>
					<option data-countryCode="KR" value="82" <?php echo ($country_code == '82') ? 'selected' : ''; ?>>Korea South (+82)</option>
					<option data-countryCode="KW" value="965" <?php echo ($country_code == '965') ? 'selected' : ''; ?>>Kuwait (+965)</option>
					<option data-countryCode="KG" value="996" <?php echo ($country_code == '996') ? 'selected' : ''; ?>>Kyrgyzstan (+996)</option>
					<option data-countryCode="LA" value="856" <?php echo ($country_code == '856') ? 'selected' : ''; ?>>Laos (+856)</option>
					<option data-countryCode="LV" value="371" <?php echo ($country_code == '371') ? 'selected' : ''; ?>>Latvia (+371)</option>
					<option data-countryCode="LB" value="961" <?php echo ($country_code == '961') ? 'selected' : ''; ?>>Lebanon (+961)</option>
					<option data-countryCode="LS" value="266" <?php echo ($country_code == '266') ? 'selected' : ''; ?>>Lesotho (+266)</option>
					<option data-countryCode="LR" value="231" <?php echo ($country_code == '231') ? 'selected' : ''; ?>>Liberia (+231)</option>
					<option data-countryCode="LY" value="218" <?php echo ($country_code == '218') ? 'selected' : ''; ?>>Libya (+218)</option>
					<option data-countryCode="LI" value="423" <?php echo ($country_code == '423') ? 'selected' : ''; ?>>Liechtenstein (+423)</option>
					<option data-countryCode="LT" value="370" <?php echo ($country_code == '370') ? 'selected' : ''; ?>>Lithuania (+370)</option>
					<option data-countryCode="LU" value="352" <?php echo ($country_code == '352') ? 'selected' : ''; ?>>Luxembourg (+352)</option>


					<option data-countryCode="MO" value="853" <?php echo ($country_code == '853') ? 'selected' : ''; ?>>Macao (+853)</option>
					<option data-countryCode="MK" value="389" <?php echo ($country_code == '389') ? 'selected' : ''; ?>>Macedonia (+389)</option>
					<option data-countryCode="MG" value="261" <?php echo ($country_code == '261') ? 'selected' : ''; ?>>Madagascar (+261)</option>
					<option data-countryCode="MW" value="265" <?php echo ($country_code == '265') ? 'selected' : ''; ?>>Malawi (+265)</option>
					<option data-countryCode="MY" value="60" <?php echo ($country_code == '60') ? 'selected' : ''; ?>>Malaysia (+60)</option>
					<option data-countryCode="MV" value="960" <?php echo ($country_code == '960') ? 'selected' : ''; ?>>Maldives (+960)</option>
					<option data-countryCode="ML" value="223" <?php echo ($country_code == '223') ? 'selected' : ''; ?>>Mali (+223)</option>
					<option data-countryCode="MT" value="356" <?php echo ($country_code == '356') ? 'selected' : ''; ?>>Malta (+356)</option>
					<option data-countryCode="MH" value="692" <?php echo ($country_code == '692') ? 'selected' : ''; ?>>Marshall Islands (+692)</option>
					<option data-countryCode="MQ" value="596" <?php echo ($country_code == '596') ? 'selected' : ''; ?>>Martinique (+596)</option>
					<option data-countryCode="MR" value="222" <?php echo ($country_code == '222') ? 'selected' : ''; ?>>Mauritania (+222)</option>
					<option data-countryCode="YT" value="269" <?php echo ($country_code == '269') ? 'selected' : ''; ?>>Mayotte (+269)</option>
					<option data-countryCode="MX" value="52" <?php echo ($country_code == '52') ? 'selected' : ''; ?>>Mexico (+52)</option>
					<option data-countryCode="FM" value="691" <?php echo ($country_code == '691') ? 'selected' : ''; ?>>Micronesia (+691)</option>
					<option data-countryCode="MD" value="373" <?php echo ($country_code == '373') ? 'selected' : ''; ?>>Moldova (+373)</option>
					<option data-countryCode="MC" value="377" <?php echo ($country_code == '377') ? 'selected' : ''; ?>>Monaco (+377)</option>
					<option data-countryCode="MN" value="976" <?php echo ($country_code == '976') ? 'selected' : ''; ?>>Mongolia (+976)</option>
					<option data-countryCode="MS" value="1664" <?php echo ($country_code == '1664') ? 'selected' : ''; ?>>Montserrat (+1664)</option>
					<option data-countryCode="MA" value="212" <?php echo ($country_code == '212') ? 'selected' : ''; ?>>Morocco (+212)</option>
					<option data-countryCode="MZ" value="258" <?php echo ($country_code == '258') ? 'selected' : ''; ?>>Mozambique (+258)</option>
					<option data-countryCode="MM" value="95" <?php echo ($country_code == '95') ? 'selected' : ''; ?>>Myanmar (+95)</option>
					<option data-countryCode="NA" value="264" <?php echo ($country_code == '264') ? 'selected' : ''; ?>>Namibia (+264)</option>
					<option data-countryCode="NR" value="674" <?php echo ($country_code == '674') ? 'selected' : ''; ?>>Nauru (+674)</option>
					<option data-countryCode="NP" value="977" <?php echo ($country_code == '977') ? 'selected' : ''; ?>>Nepal (+977)</option>
					<option data-countryCode="NL" value="31" <?php echo ($country_code == '31') ? 'selected' : ''; ?>>Netherlands (+31)</option>
					<option data-countryCode="NC" value="687" <?php echo ($country_code == '687') ? 'selected' : ''; ?>>New Caledonia (+687)</option>
					<option data-countryCode="NZ" value="64" <?php echo ($country_code == '64') ? 'selected' : ''; ?>>New Zealand (+64)</option>
					<option data-countryCode="NI" value="505" <?php echo ($country_code == '505') ? 'selected' : ''; ?>>Nicaragua (+505)</option>
					<option data-countryCode="NE" value="227" <?php echo ($country_code == '227') ? 'selected' : ''; ?>>Niger (+227)</option>
					<option data-countryCode="NG" value="234" <?php echo ($country_code == '234') ? 'selected' : ''; ?>>Nigeria (+234)</option>
					<option data-countryCode="NU" value="683" <?php echo ($country_code == '683') ? 'selected' : ''; ?>>Niue (+683)</option>
					<option data-countryCode="NF" value="672" <?php echo ($country_code == '672') ? 'selected' : ''; ?>>Norfolk Islands (+672)</option>
					<option data-countryCode="MP" value="670" <?php echo ($country_code == '670') ? 'selected' : ''; ?>>Northern Marianas (+670)</option>
					<option data-countryCode="OM" value="968" <?php echo ($country_code == '968') ? 'selected' : ''; ?>>Oman (+968)</option>

					<option data-countryCode="PW" value="680" <?php echo ($country_code == '680') ? 'selected' : ''; ?>>Palau (+680)</option>
					<option data-countryCode="PA" value="507" <?php echo ($country_code == '507') ? 'selected' : ''; ?>>Panama (+507)</option>
					<option data-countryCode="PG" value="675" <?php echo ($country_code == '675') ? 'selected' : ''; ?>>Papua New Guinea (+675)</option>
					<option data-countryCode="PY" value="595" <?php echo ($country_code == '595') ? 'selected' : ''; ?>>Paraguay (+595)</option>
					<option data-countryCode="PE" value="51" <?php echo ($country_code == '51') ? 'selected' : ''; ?>>Peru (+51)</option>
					<option data-countryCode="PH" value="63" <?php echo ($country_code == '63') ? 'selected' : ''; ?>>Philippines (+63)</option>
					<option data-countryCode="PL" value="48" <?php echo ($country_code == '48') ? 'selected' : ''; ?>>Poland (+48)</option>
					<option data-countryCode="PT" value="351" <?php echo ($country_code == '351') ? 'selected' : ''; ?>>Portugal (+351)</option>
					<option data-countryCode="PR" value="1787" <?php echo ($country_code == '1787') ? 'selected' : ''; ?>>Puerto Rico (+1787)</option>
					<option data-countryCode="QA" value="974" <?php echo ($country_code == '974') ? 'selected' : ''; ?>>Qatar (+974)</option>
					<option data-countryCode="RE" value="262" <?php echo ($country_code == '262') ? 'selected' : ''; ?>>Reunion (+262)</option>
					<option data-countryCode="RO" value="40" <?php echo ($country_code == '40') ? 'selected' : ''; ?>>Romania (+40)</option>
					<option data-countryCode="RU" value="7" <?php echo ($country_code == '7') ? 'selected' : ''; ?>>Russia (+7)</option>
					<option data-countryCode="RW" value="250" <?php echo ($country_code == '250') ? 'selected' : ''; ?>>Rwanda (+250)</option>
					<option data-countryCode="SM" value="378" <?php echo ($country_code == '378') ? 'selected' : ''; ?>>San Marino (+378)</option>
					<option data-countryCode="ST" value="239" <?php echo ($country_code == '239') ? 'selected' : ''; ?>>Sao Tome &amp; Principe (+239)</option>
					<option data-countryCode="SA" value="966" <?php echo ($country_code == '966') ? 'selected' : ''; ?>>Saudi Arabia (+966)</option>
					<option data-countryCode="SN" value="221" <?php echo ($country_code == '221') ? 'selected' : ''; ?>>Senegal (+221)</option>
					<option data-countryCode="RS" value="381" <?php echo ($country_code == '381') ? 'selected' : ''; ?>>Serbia (+381)</option>
					<option data-countryCode="SC" value="248" <?php echo ($country_code == '248') ? 'selected' : ''; ?>>Seychelles (+248)</option>
					<option data-countryCode="SL" value="232" <?php echo ($country_code == '232') ? 'selected' : ''; ?>>Sierra Leone (+232)</option>
					<option data-countryCode="SG" value="65" <?php echo ($country_code == '65') ? 'selected' : ''; ?>>Singapore (+65)</option>
					<option data-countryCode="SK" value="421" <?php echo ($country_code == '421') ? 'selected' : ''; ?>>Slovak Republic (+421)</option>
					<option data-countryCode="SI" value="386" <?php echo ($country_code == '386') ? 'selected' : ''; ?>>Slovenia (+386)</option>
					<option data-countryCode="SB" value="677" <?php echo ($country_code == '677') ? 'selected' : ''; ?>>Solomon Islands (+677)</option>
					<option data-countryCode="SO" value="252" <?php echo ($country_code == '252') ? 'selected' : ''; ?>>Somalia (+252)</option>
					<option data-countryCode="ZA" value="27" <?php echo ($country_code == '27') ? 'selected' : ''; ?>>South Africa (+27)</option>
					<option data-countryCode="ES" value="34" <?php echo ($country_code == '34') ? 'selected' : ''; ?>>Spain (+34)</option>
					<option data-countryCode="LK" value="94" <?php echo ($country_code == '94') ? 'selected' : ''; ?>>Sri Lanka (+94)</option>
					<option data-countryCode="SH" value="290" <?php echo ($country_code == '290') ? 'selected' : ''; ?>>St. Helena (+290)</option>
					<option data-countryCode="KN" value="1869" <?php echo ($country_code == '1869') ? 'selected' : ''; ?>>St. Kitts (+1869)</option>
					<option data-countryCode="LC" value="1758" <?php echo ($country_code == '1758') ? 'selected' : ''; ?>>St. Lucia (+1758)</option>
					<option data-countryCode="SD" value="249" <?php echo ($country_code == '249') ? 'selected' : ''; ?>>Sudan (+249)</option>
					<option data-countryCode="SR" value="597" <?php echo ($country_code == '597') ? 'selected' : ''; ?>>Suriname (+597)</option>
					<option data-countryCode="SZ" value="268" <?php echo ($country_code == '268') ? 'selected' : ''; ?>>Swaziland (+268)</option>
					<option data-countryCode="SE" value="46" <?php echo ($country_code == '46') ? 'selected' : ''; ?>>Sweden (+46)</option>
					<option data-countryCode="CH" value="41" <?php echo ($country_code == '41') ? 'selected' : ''; ?>>Switzerland (+41)</option>
					<option data-countryCode="SY" value="963" <?php echo ($country_code == '963') ? 'selected' : ''; ?>>Syria (+963)</option>

					<option data-countryCode="TW" value="886" <?php echo ($country_code == '886') ? 'selected' : ''; ?>>Taiwan (+886)</option>
					<option data-countryCode="TJ" value="992" <?php echo ($country_code == '992') ? 'selected' : ''; ?>>Tajikistan (+992)</option>
					<option data-countryCode="TH" value="66" <?php echo ($country_code == '66') ? 'selected' : ''; ?>>Thailand (+66)</option>
					<option data-countryCode="TG" value="228" <?php echo ($country_code == '228') ? 'selected' : ''; ?>>Togo (+228)</option>
					<option data-countryCode="TO" value="676" <?php echo ($country_code == '676') ? 'selected' : ''; ?>>Tonga (+676)</option>
					<option data-countryCode="TT" value="1868" <?php echo ($country_code == '1868') ? 'selected' : ''; ?>>Trinidad &amp; Tobago (+1868)</option>
					<option data-countryCode="TN" value="216" <?php echo ($country_code == '216') ? 'selected' : ''; ?>>Tunisia (+216)</option>
					<option data-countryCode="TR" value="90" <?php echo ($country_code == '90') ? 'selected' : ''; ?>>Turkey (+90)</option>
					<option data-countryCode="TM" value="993" <?php echo ($country_code == '993') ? 'selected' : ''; ?>>Turkmenistan (+993)</option>
					<option data-countryCode="TC" value="1649" <?php echo ($country_code == '1649') ? 'selected' : ''; ?>>Turks &amp; Caicos Islands (+1649)</option>
					<option data-countryCode="TV" value="688" <?php echo ($country_code == '688') ? 'selected' : ''; ?>>Tuvalu (+688)</option>
					<option data-countryCode="UG" value="256" <?php echo ($country_code == '256') ? 'selected' : ''; ?>>Uganda (+256)</option>
					<option data-countryCode="GB" value="44" <?php echo ($country_code == '44') ? 'selected' : ''; ?>>UK (+44)</option>
					<option data-countryCode="UA" value="380" <?php echo ($country_code == '380') ? 'selected' : ''; ?>>Ukraine (+380)</option>
					<option data-countryCode="AE" value="971" <?php echo ($country_code == '971') ? 'selected' : ''; ?>>United Arab Emirates (+971)</option>
					<option data-countryCode="UY" value="598" <?php echo ($country_code == '598') ? 'selected' : ''; ?>>Uruguay (+598)</option>
					<option data-countryCode="US" value="1" <?php echo ($country_code == '1') ? 'selected' : ''; ?>>USA (+1)</option>
					<option data-countryCode="UZ" value="998" <?php echo ($country_code == '998') ? 'selected' : ''; ?>>Uzbekistan (+998)</option>
					<option data-countryCode="VU" value="678" <?php echo ($country_code == '678') ? 'selected' : ''; ?>>Vanuatu (+678)</option>
					<option data-countryCode="VA" value="379" <?php echo ($country_code == '379') ? 'selected' : ''; ?>>Vatican City (+379)</option>
					<option data-countryCode="VE" value="58" <?php echo ($country_code == '58') ? 'selected' : ''; ?>>Venezuela (+58)</option>
					<option data-countryCode="VN" value="84" <?php echo ($country_code == '84') ? 'selected' : ''; ?>>Vietnam (+84)</option>
					<option data-countryCode="VG" value="1284" <?php echo ($country_code == '1284') ? 'selected' : ''; ?>>Virgin Islands - British (+1284)</option>
					<option data-countryCode="VI" value="1340" <?php echo ($country_code == '1340') ? 'selected' : ''; ?>>Virgin Islands - US (+1340)</option>
					<option data-countryCode="WF" value="681" <?php echo ($country_code == '681') ? 'selected' : ''; ?>>Wallis &amp; Futuna (+681)</option>
					<option data-countryCode="YE" value="969" <?php echo ($country_code == '969') ? 'selected' : ''; ?>>Yemen (North) (+969)</option>
					<option data-countryCode="YE" value="967" <?php echo ($country_code == '967') ? 'selected' : ''; ?>>Yemen (South) (+967)</option>
					<option data-countryCode="ZM" value="260" <?php echo ($country_code == '260') ? 'selected' : ''; ?>>Zambia (+260)</option>
					<option data-countryCode="ZW" value="263" <?php echo ($country_code == '263') ? 'selected' : ''; ?>>Zimbabwe (+263)</option>


				</optgroup>
			</select>
		</div>

		<div class="mb-3">
			<label class="form-label" style="margin-bottom: 6px;"><b>Number of Students Country Wise</b></label>
			<input type="number" name="Country_wise_student" class="form-control" placeholder="Enter number of students" value="<?php echo $num_students; ?>" style="margin-top: 0;" required>
		</div>

		<input type="submit" class="submit btn btn-primary" value="Update" name="update">
	</form>
</div>

<?php
require "footer.php";
?>