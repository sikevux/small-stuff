<?php
error_reporting(E_ALL);
/*
 * Created by Sikevux
 * Inspired by Zash
 * And Do What Ever The Fuck You Want With It
 */
?>
<?php
function percent($amount, $total) {
$count = $amount / $total;
$countt = $count * 100;
$result = number_format($countt, 0);
echo $result;
}
$disc_count = trim(shell_exec("df -Pk|grep -v none|wc -l"));
$disc_name = trim(shell_exec("diskusage 1"));
for($i=1; $i<$disc_count; $i++) {
$drive_array[] = trim(shell_exec("diskusage 1|sed -n '".$i."p'"));
$drive_max[] =  trim(shell_exec("diskusage 4|sed -n '".$i."p'"));
$drive_use_b[] =  trim(shell_exec("diskusage 3|sed -n '".$i."p'"));
$drive_use[] =  trim(shell_exec("diskusage 5|sed -n '".$i."p'"));
}
$system_max = trim(shell_exec("diskusage 4| tail -n1"));
for($i=1; $i<$disc_count; $i++) {
$drive_percent[] = percent($drive_max[$i], $system_max);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<title><?php system(hostname); ?> status</title>
<meta charset="utf-8">
<meta content="width=400" name="viewport">
<style type="text/css">
body {
	margin: 14% 5% 0;
}

h1,h2 {
	font: 1em sans-serif;
	margin: 2pt 0;
}

h1 {
	font-size: 3em;
	text-align: center;
}

h1+h2 {
	text-align: center;
}

h2 {
	font-size: 1.2em;
	margin-left: 1em;
}

h3 {
	margin-top: 15em;
	font-size: 12px;
	text-align: center;
}

.drive,.partition,.used-space {
	float: left;
}

.drive {
	width: 100%;
	outline: 1px solid black;
	margin: 1ex0;
}

.partition {
	background-color: #80ff80;
}

.used-space {
	white-space: nowrap;
	background-color: #ff8080;
	overflow: visible;
}
<?php
$disc_count--;
for($i=1; $i<$disc_count; $i++) {
print("#".$drive_array[$i].".partition { width: ".$drive_percent[$i]."%;}\n");
print("#".$drive_array[$i].".partition .used-space { width: ".$drive_use[$i].";}\n");
}
?>

</style>
</head>
<body>
	<h1>
	<?php system("hostname"); ?>
	</h1>
	<?php
	$updata = rtrim(shell_exec('uptime'));
	$uptime = explode(' up ', $updata);
	$uptime = explode(',', $uptime[1]);
	$load = explode('average:', $updata);
	$kdata = rtrim(shell_exec('uname -sr'));
	$kernel = explode('-', $kdata);
	?>
	<h2>
	<?php echo $kernel[0]; ?>
		&ndash; up
		<?php echo $uptime[0]; //echo $boot[1]; ?>
	</h2>
	<h2>disk sda</h2>
	<div class="drive" id="sda">
		<div class="partition" id="sda1">
			<div class="used-space">&nbsp;sda1 on /boot</div>
		</div>
		<div class="partition" id="sda5">
			<div class="used-space">&nbsp;sda5 on /</div>
		</div>
	</div>
	<br />
	<h2>disk sdb</h2>
	<div class="drive" id="sdb">
		<div class="partition" id="sdb1">
			<div class="used-space">&nbsp;sdb1 on /pool</div>
		</div>
	</div>
	<h3>:3</h3>
</body>
</html>
