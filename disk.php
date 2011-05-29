<?php
/*
 * Created by Sikevux
 * Inspired by Zash
 * And Do What Ever The Fuck You Want With It
 *
 * Contributions by: kd35a
 */

function percent($amount, $total) {
	$count = $amount / $total;
	$countt = $count * 100;
	$result = number_format($countt, 0);
	return $result;
}

$not_wanted_filesystems = "none|tmpfs|udev|AFS|loop|sr";

$disc_count = shell_exec("df -Pk|grep -v -E \"".$not_wanted_filesystems."\"|wc -l");
$disc_name = shell_exec("df -Pk|grep -v -E \"".$not_wanted_filesystems."\"|awk -v col=1 'NR > 1 {sub( \"\", \"\", \$col); print \$col }'");

for($i=1; $i<$disc_count; $i++) {
	$drive_array[] = shell_exec("df -Pk|grep -v -E \"".$not_wanted_filesystems."\"|awk -v col=1 'NR > 1 {sub( \"\", \"\", \$col); print \$col }'|sed -n '".$i."p'");
	$drive_max[] =  shell_exec("df -Pk|grep -v -E \"".$not_wanted_filesystems."\"|awk -v col=4 'NR > 1 {sub( \"\", \"\", \$col); print \$col }'|sed -n '".$i."p'");
	$drive_use_b[] =  shell_exec("df -Pk|grep -v -E \"".$not_wanted_filesystems."\"|awk -v col=3 'NR > 1 {sub( \"\", \"\", \$col); print \$col }'|sed -n '".$i."p'");
	$drive_use[] =  shell_exec("df -Pk|grep -v -E \"".$not_wanted_filesystems."\"|awk -v col=5 'NR > 1 {sub( \"\", \"\", \$col); print \$col }'|sed -n '".$i."p'");
}

$system_max = shell_exec("df -Pk | awk -v col=4 'NR > 1 {sub( \"\", \"\", \$col); tot += \$col;} END { print tot }'");

for($i=0; $i<$disc_count-1; $i++) {
	$drive_percent[$i] = percent($drive_max[$i], $system_max);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
	<head>
		<title><?php echo substr(shell_exec(hostname), 0, -1); ?> status</title>
		<meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
		<meta content="width=400" name="viewport" />
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
		for($i=0; $i<$disc_count-1; $i++) {
			print("#".substr($drive_array[$i], 0, -1).".partition { width: ".$drive_percent[$i]."%;}\n\t\t");
			print("#".substr($drive_array[$i], 0, -1).".partition .used-space { width: ".substr($drive_use[$i], 0, -1).";}\n");
		}
		?>
		</style>
	</head>
	<body>
		<h1>
			<?php system("hostname"); ?>
		</h1>
		<?php
		$updata = shell_exec('uptime');
		preg_match("/(up[ ]{1,}(([\d]{1,3}[ ]{1,}((day)|(days)),[ ]{1,})?([\d]{1,2}:)?[\d]{1,2}( min)?))(,[ \da-z]{0,},[ a-z:]{1,})([\d]{1,}.[\d]{2}, [\d]{1,}.[\d]{2}, [\d]{1,}.[\d]{2})/", $updata, $tmp);
		$uptime = $tmp[2];
		$load = explode('average:', $updata);
		$kdata = shell_exec('uname -sr');
		$kernel = explode('-', $kdata);
		?>
		<h2>
			<?php echo $kernel[0]." &ndash; up ".$uptime; ?>
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
		<p />
		<h2>disk sdb</h2>
		<div class="drive" id="sdb">
			<div class="partition" id="sdb1">
				<div class="used-space">&nbsp;sdb1 on /pool</div>
			</div>
		</div>
		<h3>:3</h3>
	</body>
</html>
