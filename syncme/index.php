<?php
//CONFIGURATION
include_once 'config.php';


if (empty($_POST)) {
	if($url != "localhost")
		die("You are a server. cant start a connection");

	if (isset($_GET['check']) || isset($_GET['show']) || isset($_GET['update']) || isset($_GET['update_all'])) {
		send_files(isset($_GET['update_all']), !isset($_GET['check']), isset($_GET['show']));
	}else if(isset($_GET['update_db'])){
		start_db_update();
	}else if(isset($_GET['open_db'])){
		?>
		<iframe src="<?=link;?>?access_code=<?=base64_encode(token);?>" width="100%" height="100%"></iframe>
		<?php
	}
	?>
	<form onsubmit="return false">
		<center>
			<br><br>
			<input type="submit" name="check" onclick="run_update('check')" value="Check Update"/>
			<input type="submit" name="show" value="Show File Changes" onclick="run_update('show')" />
			<input type="submit" name="update" value="Update Now" onclick="run_update('update')"/>
			<input type="submit" name="update_all" onclick="run_update('update_all')" value="Full System Update"/>
			<input type="submit" name="update_db" onclick="run_update('update_db')" value="Update Server DB"/>
			<input type="submit" name="open_db" onclick="run_update('open_db')" value="Open Database"/>
			<input type="submit" name="update_all" onclick="run_update('clear')" value="Stop & Clear"/>
		</center>
	</form>
	<div id="result_show"></div>
	<script>
		var eventSource = undefined;
		function run_update(add) {
			if(add == 'open_db'){
				location = "?open_db"
			}
			if(add == "clear"){
				document.getElementById("result_show").innerHTML = "";
				if(eventSource != undefined)
					eventSource.close();
				return;
			}

			if (typeof(EventSource) !== "undefined") {
				if(eventSource != undefined)
					eventSource.close();

				eventSource = new EventSource("?"+add+"&host=<?=$link;?>");
				eventSource.onmessage = function (event){
					if(event.data == "END_PUSH_MESSAGE") {
						append_result("<b style='color: red;'>FINISHED</b><br>");
						eventSource.close();
					}else {
						append_result(event.data);
					}
				}
			}
		}

		function append_result(text){
			var x = document.getElementById("result_show");
			x.innerHTML = x.innerHTML + text;
		}

	</script>
	<?php

} else {
	post_accept();
}


function send_files($update_all = false, $update_now = false, $show_only = false)
{
	header('Content-Type: text/event-stream');
	header('Cache-Control: no-cache');
	set_time_limit(0);
	push_message("Generating File List (".link.")");


	$full_list = getFileList($update_all);
	$push['file_list'] = base64_encode(json_encode($full_list));
	$push['full_update'] = $update_all ? 1 : 0;

	push_message("Pushing " . count($full_list) . " File List to Server (".link.") for comparison");
	$res = send_data($push, "latest_files");
	$result = json_decode($res, true);


	if (!$update_now && !$show_only) {
		if(getIndex($result, 'status') == 'success'){
			push_message(count(getIndex($result, 'result', array())) . " File differences received");

		}else
			push_message("Error: ".getIndex($result, 'result', 'Unable to Connect to Server'));

		end_push_message();
	}

	if (getIndex($result, "status") != 'success') {
		push_message("Error Occurred: " . getIndex($result, "result", "Unable to connect to server"));
		end_push_message();
	}

	$files = getIndex($result, 'result', array());

	push_message(count($files) . " modified file list received from Server", "blue");

	if (!empty($files))
		push_message("Updating Files");

	$base_url = str_replace(DIRECTORY_SEPARATOR, '/', BASE_URL );

	$deleted = array();

	foreach ($files as $relativePath => $info) {
		//fetch file contents

		if($info == "deleted"){
			$deleted[] = $relativePath;
			if($show_only)
				push_message("$relativePath on delete list", "brown");
			else
				push_message("$relativePath will be deleted!!", "red");


			continue;
		}

		$realpath = $base_url . $relativePath;

		if ($show_only) {
			push_message("$realpath needs updates", "purple");
			continue;
		}

		$post['link'] = $relativePath;
		$post['content'] = base64_encode(file_get_contents($realpath));

		$response = send_data($post);

		push_message($response, "green");


	}

	$post = array();
	if(!empty($deleted) && !$show_only && allow_delete){
		$post['delete'] = base64_encode(json_encode($deleted));
		$response = send_data($post);
		push_message($response, "red");
	}


	end_push_message();

}

function start_db_update(){
	header('Content-Type: text/event-stream');
	header('Cache-Control: no-cache');
	set_time_limit(0);
	push_message("Starting Database Update on server: ".link);

	$push['start_db_update'] = true;

	$result = send_data($push);
	push_message($result);
	end_push_message();

}


function post_accept()
{
	$push = $_POST;


	$full_update = empty(getIndex($push, 'full_update')) ? false : true;

	if (isset($push['file_list'])) {
		authenticate(getIndex($push, 'token'));

		$remoteFiles = getFileList($full_update);
		$localFiles = json_decode(base64_decode(getIndex($push, 'file_list', "")), true);
		$localFiles = empty($localFiles) ? array() : $localFiles;

		//compare local and remote file list to get updated files
		$updatedFiles = array();
		$deleted_files = array();
		foreach ($localFiles as $filePath => $info) {
			if (empty($remoteFiles[$filePath]) || $remoteFiles[$filePath] != $info) {
				//0 for non-deleted files while 1 for deleted files
				$updatedFiles[$filePath] = 1;
			}
		}

		foreach ($remoteFiles as $filePath => $info) {
			if (!isset($updatedFiles[$filePath]) && empty($localFiles[$filePath])) {
				//1 for non-deleted files while 1 for deleted files
				$updatedFiles[$filePath] = "deleted";
			}

		}

		print json_encode(array('result' => $updatedFiles, "status" => "success"));
	} else if (isset($push['link'])) {
		authenticate(getIndex($push, 'token'), false);

		$f = getIndex($push, 'link');
		$base_url = str_replace(DIRECTORY_SEPARATOR, '/', BASE_URL );
		$file = $base_url . $f;

		if (isset($_POST['content'])) {
			$dir = dirname($file);
			if (!file_exists($dir)) {
//				print "exits = $dir";
				mkdir($dir, 0777, true);
			}
//			else
//				print "Not exits = $dir";
			file_put_contents($file, base64_decode($_POST['content']));
			print "$f updated successfully!!!";
		} else {
			print "No file received";

		}
	}else if(isset($push['delete'])){
		authenticate(getIndex($push, 'token'), false);

		$list = json_decode(base64_decode($push['delete']),true);
		$base_url = str_replace(DIRECTORY_SEPARATOR, '/', BASE_URL );

		foreach($list as $file){
			print "$base_url.$file Deleted!!!<br>";
			@unlink($base_url.$file);
		}
		print count($list)." files deleted successfully";
	}else if(isset($push['start_db_update'])){
		authenticate(getIndex($push, 'token'), false);
		process_db_update();
	}
}

function process_db_update(){
	$version = @file_get_contents("db/pos");
	$version = empty($version)?0:$version;
	$folder = "db";
	$array = scandir($folder, SCANDIR_SORT_ASCENDING);
	sort($array, SORT_NUMERIC);
	$str = "";
	$nv = 0;
	foreach($array as $file){
		if($file == '.' || $file == '..' || $file == 'pos' || $file == 'index.php')
			continue;
		$path = "$folder/$file";
		if(file_exists($path) && $file > $version) {
			$str .= "\n" . file_get_contents($path);
			$nv = $file;
		}
	}

	if(empty($str)){
		print "No update changes available ($version)";
		exit;
	}

//	return array("new_version"=>$nv, "changes"=>$str);

	$conn = @mysqli_connect("localhost", db_username, db_password, db_name);

	if(!$conn) {
		die(mysqli_connect_error());
	}



	$sql = explode("\n", $str);
	$query = '';

	$err = "";

	foreach($sql as $line) {
		$tsl = trim($line);
		if (($sql != '') && (substr($tsl, 0, 2) != "--") && (substr($tsl, 0, 1) != '#')) {
			$query .= $line;

			if (preg_match('/;\s*$/', $line)) {

				print "----<br>$query<br>";
				if(!mysqli_query($conn, $query)){
					print "<i style='color: red;'>Error Updating: ".mysqli_error($conn)."</i><br><br>";

				}


				$query = '';
			}
		}
	}

	file_put_contents("db/pos",$nv);


}

function authenticate($token, $isJson = true, $die = true)
{
	if ($token == token) {
		return true;
	} else {
		if ($die) {
			if($isJson){
				print json_encode(array("result"=>"invalid Exchange Token", "status"=>"error"));
			}else
				exit("Invalid Exchange Token $token == ".token);
			die();
		}
	}
	return false;
}

function push_message($msg, $color = 'purple')
{
	print "data: <b>".date("h:i:s A, m/d/Y")."</b>: <span style='color: $color;'>$msg</span><br>";
	echo PHP_EOL;
	echo PHP_EOL;
	ob_flush();
	flush();
}

function end_push_message(){
	print "data: END_PUSH_MESSAGE";
	echo PHP_EOL;
	echo PHP_EOL;
	ob_flush();
	flush();
	exit;
}

function send_data($data, $sublink = "receive")
{
	$data['token'] = token;
	$push = http_build_query($data);

	$ch = curl_init(link);
	curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $push);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
	curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
	$ret =  curl_exec($ch);
 return $ret;
}

function getFileList($full_update = false)
{
	global $include_folders, $exclude_folders, $skip_files, $include_full, $include_root_folder, $include_root_files, $delete_sender;

	if ($full_update) {
		$include_folders = array_merge($include_folders, $include_full);
	}


	foreach ($include_folders as $x => $y) {
		$include_folders[$x] = str_replace('/', DIRECTORY_SEPARATOR, BASE_URL . "$y");
	}
	foreach ($exclude_folders as $x => $y) {
		$exclude_folders[$x] = str_replace('/', DIRECTORY_SEPARATOR, BASE_URL . "$y");
	}

	$filter = $filter = function ($file, $key, $iterator) use ($include_folders, $exclude_folders, $skip_files, $include_root_folder, $include_root_files) {

		if (strpos_arr($key, $exclude_folders) !== false) {
			return false;
		}

		if (in_array($file->getFileName(), $skip_files)) {
			return false;
		}

		if (strpos_arr($key, $include_folders) !== false) {
			return true;
		}

		if (dirname($key) == BASE_URL && $include_root_files)
			return true;

		return $include_root_folder;

	};
	$iterator = new \RecursiveIteratorIterator(new \RecursiveCallbackFilterIterator(new \RecursiveDirectoryIterator(BASE_URL,
		\FilesystemIterator::CURRENT_AS_FILEINFO |
		\FilesystemIterator::SKIP_DOTS
	), $filter));


	$base_url = str_replace(DIRECTORY_SEPARATOR, '/', BASE_URL);

	$files = array();

	foreach ($iterator as $fileInfo) {

		$fullPath = str_replace(DIRECTORY_SEPARATOR, '/', $fileInfo->getPathName());
		$path = str_replace($base_url, "", $fullPath);

		$files[$path] = hash_file("sha256", $fullPath);
	}
	return $files;
}


function getIndex($array, $str_index, $default = "")
{

	if (is_object($array))
		$array = (Array)$array;

	$ex = explode(",", $str_index);

	if (count($ex) > 0) {
		if (count($ex) == 1) {
			return isset($array[$ex[0]]) ? $array[$ex[0]] : $default;
		} else {
			if (isset($array[$ex[0]])) {
				$array2 = $array[$ex[0]];
				array_shift($ex);
				return getIndex($array2, implode(",", $ex), $default);
			} else
				return $default;
		}
	}
	return $default;
}

function strpos_arr($haystack, $needle) {
	if(!is_array($needle)) $needle = array($needle);
	foreach($needle as $what) {
		if(($pos = strpos($haystack, $what))!==false) return $pos;
	}
	return false;
}

