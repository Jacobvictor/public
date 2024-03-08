<?php
$current_view = 'sub_passwords';
require "common.php";


// Check security
if (!$admin_super && !$admin_principal && !$admin_dtl && !$admin_special_ed && !$admin_secretary && !$admin_tech && !in_array("nurse", $user_security) && !$admin_resource) {
	$error = "You must be <a href=modules.php?name=Your_Account><big>logged on</big></a> with proper rights to access this page.";
	display_error($error);
	exit;
}


// Retrieve sub passwords
$sql = "SELECT name, value FROM calendar_param WHERE name LIKE 'sub%'";
$result = mysqli_query($mysqli, $sql);
while (list($name, $value) = mysqli_fetch_row($result)) {
	$$name = $value;
}

// Print info sheet for subs
// *************************
if ($op == "print") {
	$var = "sub$sub" . "_password";
	if ($sub == "nurse")
		$var = "sub_nurse_password";
	$password = $$var;

	$school = ($sub <= 6) ? "Elementary" : "Middle";
	$principal_email = ($sub <= 6) ? "lmagruder@district106.net" : "mvervynck@district106.net";
	$secretary_email = ($sub <= 6) ? "amusick@district106.net or clantro@district106.net" : "lfountas@district106.net";

	$sub_txt = ($sub == "nurse") ? "Nurse" : $sub;
	$sub_txt2 = ($sub == "nurse") ? "nurse" : $sub;

	echo "<div style='margin: 25px auto 20px auto; text-align: center; font-size: 1.75em; line-height: 1.25em'>
		<big><b>Substitute $sub_txt</b></big><br>
		<small><small>For ". date("l, M d") . "</small></small>
		</div>
		<div class='clearfix'></div>
		<div style='text-align:left; margin: 0 auto;display: inline-block;'>
		Welcome to Highlands $school School!  Thank you for substitute teaching with us today.  Below you will find information about accessing information and systems you will need to do your job today.
	<br><br>
		Laptop username: <big><b>\"guest\"</b></big><br>
		Laptop password:  There is <big><b>no password</b></big>.<br>
		Please be aware that any documents saved on this device will be erased when you log out.
	<br><br>
		Network account username: <big><b>sub$sub_txt2</b></big><br>
		Google account username:  <big><b>sub$sub_txt2@district106.net</b></big><br>
		Network / Google password: <big><b>$password</b></big> &nbsp; <i>(changes daily)</i>
	<br><br>
	<img align=left src=images/website_login.png style='margin: 10px 15px 10px 0' width=220px><br>
		To access the district website, go to <b><i>www.district106.net</i></b> and click \"Logon\" in the menu. Once the login screen appears, click the Sign In with Google button and use the credentials above to log in.
	<br><br>
		Once logged in to District 106's website, you should be able to access email by going to <b><i>gmail.com</i></b>.  The substitute teacher accounts will receive any emails that are sent to the rest of the staff that day.  Feel free to use this email account to send any work related email to the building principal ($principal_email) or to the office ($secretary_email) as needed.<b>Please make sure any incoming emails are deleted at the end of the day so the account will start fresh the following day.</b>
	<br><br>";
/*
	if ($school == "Elementary" && $sub != "_nurse") {
		echo "Also, once logged onto the district website, you can click the magnifying glass in the menu and search for <b><i>\"pledge\"</i></b>. One of the top results will be a Zoom link to the daily morning announcements and pledge.<br><br>";
	}


	if ($sub == "_nurse") {
		echo "To access PowerSchool, open up Google Chrome or Safari and go to <b><i>https://powerschool.district106.net/admin/</i></b>
			<br><br>";

	} else {
		echo"This account will also be used for you to access any Zoom meetings that you have been asked to participate in while you are filling-in for the regular classroom teacher. To access these meetings, make sure you are logged in to the district website, go to the district homepage, and then click the agenda link at the top of the page that corresponds to the grade level you are subbing in. Navigate to the proper agenda in the folder if necessary, then click the link provided in the agenda.
		<br><br>
		<center><img src=images/website_agendas.png style='margin: 10px 0 20px 0' width=640px></center>
		</div>
		<div class='clearfix'></div>
		<div style='page-break-before: always; text-align:left; margin: 0 auto;display: inline-block;'>
			An example of what this might look like is illustrated below.  Each grade level agenda may be different, but the zoom links should be easily identified.
		<center><img src=images/website_agenda_detail.png style='margin: 10px 0 20px 0' width=640px></center>
			Make sure you are logged-in to your google account as described above.  When you click on the link you should be recognized as a co-host for the meeting and you can then manage the session as necessary.
		<br><br>";
	}
	*/

// START OF NEW EDIT

echo "1. Go to file menu at the top of the screen, click and pull-down to print.<br><br>
2. In the dialog box that appears, make sure airprint_follow_me is the destination, then click the print button.<br><br>
3. If asked for a username and password (The first time you print each day, you will be asked for this), enter the username listed above next to <q>Network account username</q>. This username will NOT have @district106.net in it. In the password field, enter the password labeled <q>Network/Google Password:</q> This changes daily and must be retreived from the office. Click the checkbox <q>Remmember this password in my keychain,</q> so you won't have to enter it anymore that day. When you come back tomorrow, you will have to re-authenticate.<br><br>
4. To retreive your print job, go to any copier and swipe your badge next to the screen. <br><br>
5. Press the <q>Print All</q> button at the top of the screen to release all waiting print jobs OR<br><br>
6. Press the <q>Print Release</q> button to see all jobs waiting to print. Tap the ones you want to release, then press <q>Release Jobs</q>."
exit;
//end of edit
	echo "You can reach the technology help-desk for any technical issues that are preventing you from teaching using the classroom phone and dialing 999.  You can reach the school offices by dialing 11 then the dial button for the elementary office or 22 then dial for the middle school office.
		<br><br>
			We hope you have a rich and rewarding experience working with our students today.  Make sure to fill out the substitute report and turn it in along with your device before you leave the building.
		</div>";
	exit;
}

// End of print sub sheet
// **********************


// Start page
$mobile_wide = 0;
require_once(_BASEDIR . "includes/header.php");

// Title
echo "<div style='text-align: center;'>\n";		// Whole page container
echo "<h2 style='line-height: 1.2em'><a class=black href=" . _BASE_HREF . "technology/backoffice.php><b>Backoffice</b></a><b> &rarr; Sub Passwords for " . date("l") . "</b></h2>\n";


if (!in_array("nurse", $user_security)) {
	// Elementary Subs
	echo "<h2>Elementary School Subs</h2>";
	echo "<div style='text-align: left; margin: 0 auto 0 auto; width: 180px'>\n";
	for($i=1; $i<=6; $i++) {
		$var = "sub$i" . "_password";
		$url = _BASE_HREF . "technology/sub_passwords.php?op=print&sub=$i";
		echo "<a href=$url class=plain><big>sub$i / " . $$var . "</a></big><br><br>";
	}
	echo "</div>\n";


	// Middle School Subs
	echo "<br><h2>Middle School Subs</h2>";
	echo "<div style='text-align: left; margin: 0 auto 0 auto; width: 180px'>\n";
	for($i=7; $i<=12; $i++) {
		$var = "sub$i" . "_password";
		$url = _BASE_HREF . "technology/sub_passwords.php?op=print&sub=$i";
		echo "<a href=$url class=plain><big>sub$i / " . $$var . "</a></big><br><br>";
	}
	echo "</div>\n";
}


// Nurse Sub
if ($admin_super || $admin_special_ed || in_array("nurse", $user_security) || $admin_secretary) {
	echo "<br><h2>Nurse Sub</h2>";
	echo "<div style='text-align: left; margin: 0 auto 0 auto; width: 225px'>\n";
	$var = "sub_nurse_password";
	$url = _BASE_HREF . "technology/sub_passwords.php?op=print&sub=nurse";
	echo "<a href=$url class=plain><big>subnurse / " . $$var . "</a></big><br><br>";
	echo "</div>\n";
}



// Close page
echo "<br></div>\n";
require_once(_BASEDIR . "includes/footer.php");

?>
