<?php

const DS = DIRECTORY_SEPARATOR;

# --------------------- common functions ---------------------------

function downloadDB(){

	#dump the database to /sql/ with timestamp, return the filename

	$db = "f9219847_db";
	$u = "f9219847";
	$p = "nweg901hF2";
	$host = "f9219847.gblearn.com";

	$file = ".".DS."sql".DS."backup".time().".sql";

	exec("mysqldump --user={$u} --password={$p} --host={$host} {$db} --result-file=$file 2>&1", $o);

	return $file;
}

function uploadDB(){

	#upload, save, and execute the database backup
	$file = DS."sql". DS . "up" . basename($_FILES["file"]["name"]);

	$filetype = strtolower(pathinfo($file, PATHINFO_EXTENSION));


	if($filetype != "sql"){
		return "Incorrect file type. Must be .sql";
	}

	$command = "mysql -uf9219847_admin --password=nweg901hF2 f9219847_db < " .$_FILES["file"]["tmp_name"]."";

	exec($command);

	if(move_uploaded_file($_FILES["file"]["tmp_name"], getcwd().$file)) {
		echo "File $file uploaded.<br>";
	}

}


function getDB()
{
	#return the db object for use elsewhere
	$server = "f9219847.gblearn.com";
	$dbname = "f9219847_db";
	$user = "f9219847";
	$p = "nweg901hF2";

	try {
		$db = mysqli_connect($server, $user, $p, $dbname);

		if (!$db) {
			die("Connection failed: " . mysqli_connect_error());
		}
		return $db;
	} catch (Exception $e) {
		return "error connecting.";
	}

}
function userlog($user, $action, $s=null)
{
	# every action is saved to the logfile
	try {
		if($s){
			$s = ".".DS."controllers".DS;
		} else {
			$s="";
		}
		$ip = isset($_SERVER['REMOTE_ADDR']) ?  $_SERVER['REMOTE_ADDR']: 'n/a';
		$file = fopen($s.'log.txt', 'a');
		date_default_timezone_set("EST");
		$data = "User: " . $user . ", Action: " . $action . ", Time: " . date("F j, Y, g:i:s A") . ", IP: ". $ip . "\n";
		fwrite($file, $data);
	} catch (Exception $ex) {
		fclose($file);
		return false;
	} finally {
		fclose($file);
	}
}

function authUser($u, $p){

	$db = getDB();
	$p =  sha1($p);
	$query = "SELECT * FROM users WHERE username='$u' and password='$p'";
	$c = mysqli_query($db, $query);
	#echo $c;
	if(mysqli_num_rows($c) === 1) {
		userlog($u, "logged in");
		return true;
	} else {
		return false;
		return "nope" . mysqli_error($db);
	}


}
#----------------------client functions-----------------
function addClient($user, $db, $info)
{

	$company = $info["company"];
	$bnum = $info["bnum"];
	$contactfirst = $info["contactfirst"];
	$contactlast = $info["contactlast"];
	$phone = $info["phone"];
	$cell = $info["cell"];
	$website = $info["website"];
	$active = $info["active"];

	$str = "\"" . $company . "\", \"" . $bnum . "\", \"" . $contactfirst . "\", \"" . $contactlast . "\", \"" . $phone . "\", \"" . $cell . "\", \"" . $website . "\", \"" . $active . "\", false";
	#echo $str;

	$query = "INSERT INTO clients (company, bnum, contactfirst, contactlast, phone, cell, website, active, deleted) VALUES($str)";


	if (mysqli_query($db, $query)) {
		userlog($user, "added client " . $company);
		return true;
	} else {
		return "nope" . mysqli_error($db);
	}


}

function updateClient($user, $db, $info)
{
	$company = $info["company"];
	$bnum = $info["bnum"];
	$contactfirst = $info["contactfirst"];
	$contactlast = $info["contactlast"];
	$phone = $info["phone"];
	$cell = $info["cell"];
	$website = $info["website"];
	$active = $info["active"];
	$id = $info["id"];
	echo "<pre>";
	print_r($info);
	#if (addClient($user, $db, $info)) {

		$query = "UPDATE clients SET company = '$company', bnum = '$bnum', contactfirst = '$contactfirst', contactlast = '$contactlast', phone = '$phone', cell = '$cell', website = '$website', active = '$active', deleted=0 WHERE id = $id";
		if (mysqli_query($db, $query)) {
			userlog($user, "updated client " . $info['company']);
			updateClientEvents($user, $db, $id, $active);
			return true;
		} else {
			echo "nope " . mysqli_error($db);
			die();
		}
	#}
}


function updateClientEvents($user, $db, $id, $newstatus)
{
	echo 'here';
	$query = "UPDATE events SET status = $newstatus WHERE id = $id";
	if (mysqli_query($db, $query)) {
		userlog($user, "updated events from client id " . $id);
	} else {
		echo "nope " . mysqli_error($db);
	}
}

function deleteClient($user, $db, $info)
{
	#cybersecurity? never heard of it
	$id = $info["id"];
	$query = "UPDATE clients SET deleted = 1 WHERE id=$id";
	if (mysqli_query($db, $query)) {
		userlog($user, "deleted client id " . $id);
		return true;
	} else {
		echo "nope " . mysqli_error($db);
	}
}

#--------------------notification functions------------------------

function addNotification($user, $db, $info)
{
	$name = $info['named'];
	$type = $info['types'];
	$status = $info['status'];

	$query = "INSERT INTO notifys (named, types, status, deleted) values ('$name','$type','$status', 0)";

	if (mysqli_query($db, $query)) {
		echo userlog($user, "added notification " .$info['named']);
		return true;
	} else {
		echo "nope <br>" . mysqli_error($db);
		die();
	}

}

function updateNotification($user, $db, $info){
	$id = $info['id'];
	$named = $info['named'];
	$types = $info['types'];
	$status = $info['status'];

	$query = "UPDATE notifys SET named='$named', types='$types', status='$status' WHERE id='$id'";

	if (mysqli_query($db, $query)) {
		userlog($user, "updated notification id" . $id);
		return true;
	} else {
		echo "nope <br>" . mysqli_error($db);
		die();
	}

}

function deleteNotification($user, $db, $info){
	$id = $info["id"];
	$query = "UPDATE notifys SET deleted = 1 WHERE id=$id";
	if (mysqli_query($db, $query)) {
		userlog($user, "deleted notify id " . $id);
		return true;
	} else {
		echo "nope " . mysqli_error($db);
	}
}
#-------------------event functions--------------

function addEvent($user, $db, $info){
	$clientid = $info['clientid'];
	$notifid = $info['notifid'];
	$start = $info['start'];
	$freq = $info['freq'];
	$active = $info['active'];

	$query = "INSERT INTO events (clientid, notifid, start, freq, status, deleted) VALUES('$clientid', '$notifid', '$start', '$freq', '$active', 0) ";

	if (mysqli_query($db, $query)) {
		userlog($user, "added event " . $start);
		return true;
	} else {
		echo "nope <br>" . mysqli_error($db);
	}
}

function updateEvent($user, $db, $info){
	$clientid = $info['clientid'];
	$notifid = $info['notifid'];
	$start = $info['start'];
	$freq = $info['freq'];
	$status = $info['status'];
	$id = $info['id'];

	$query = "UPDATE events SET clientid = '$clientid', notifid = '$notifid', start='$start', 
freq='$freq', status='$status' WHERE id='$id'";

	if (mysqli_query($db, $query)) {
		userlog($user, "updated event id ".$id);
		eventStatusUpdate($user, $db, $id, $status);
		return true;
	} else {
		echo "nope " . mysqli_error($db);
		die();
	}
}

function eventStatusUpdate($user, $db, $id, $status){
	$query = "UPDATE events SET status = $status WHERE id = $id";
	if (mysqli_query($db, $query)) {
		userlog($user, "updated notifications from id " . $id);
	} else {
		echo "nope " . mysqli_error($db);
	}
}

function deleteEvent($user, $db, $info)
{
	$id = $info["id"];
	$query = "UPDATE events SET deleted = 1 WHERE id=$id";
	if (mysqli_query($db, $query)) {
		userlog($user, "deleted event id " . $id);
		return true;
	} else {
		echo "nope " . mysqli_error($db);
	}
}

#------------users-------------

function addUser($user, $db, $info){
	$first = $info['first'];
	$last = $info['last'];
	$email = $info['email'];
	$cell = $info['cell'];
	$pos = $info['pos'];
	$uname = $info['uname'];
	$pw = $info['pw'];
	$status = $info['status'];
	$filename = $info['filename'];


	$query = "INSERT INTO users (first, last, email, cell, position, username, password,
status, filename, deleted) VALUES ('$first', '$last', '$email', 
'$cell', '$pos', '$uname', '$pw', '$status', '$filename', 0)";

	if (mysqli_query($db, $query)) {
		userlog($user, "added user " . $uname);
		return "User added.";
	} else {
		echo "nope <br>" . mysqli_error($db);
	}

}


function updateUser($user, $db, $info){
	$first = $info['first'];
	$last = $info['last'];
	$email = $info['email'];
	$cell = $info['cell'];
	$pos = $info['pos'];
	$uname = $info['uname'];
	$pw = $info['pw'];
	$status = $info['status'];
	$id = $_POST['id'];
	$filename = $_POST['filename'];
	$deleted = $_POST['deleted'];

	$query = "UPDATE users SET first='$first', last='$last', email='$email', cell= '$cell',
 position = '$pos', username='$uname', password='$pw', status='$status',
  filename='$filename', deleted='$deleted' WHERE id='$id'";
	if (mysqli_query($db, $query)) {
		userlog($user, "updated user id ".$id);
		return true;
	} else {
		echo "nope " . mysqli_error($db);
		die();
	}
}

function deleteUser($user, $db, $info)
{
	$id = $info["id"];
	$query = "UPDATE users SET deleted = 1 WHERE id=$id";
	if (mysqli_query($db, $query)) {
		userlog($user, "deleted user id " . $id);
		return true;
	} else {
		echo "nope " . mysqli_error($db);
	}
}
