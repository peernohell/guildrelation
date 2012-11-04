<?php
function user_session_start () {
	session_start();
	$user_info = false;

	// check if we have userInfo
	if (isset($_GET['user'])) {
		$user_info = unserialize(base64_decode($_GET['user']));
		$_SESSION['user_info'] = $user_info;

	} else if (isset($_SESSION['user_info'])) {
		$user_info = $_SESSION['user_info'];

	} else {
		// we have no information about the user. juste show a message
		echo "Votre session a expirer. veuillez retourner sur la page d'acceuil de ryzom";
	}
	return $user_info;
}

function get_guild_info ($guild_id) {
	global $config;
	$guild_info = $config['path.data'] . "$guild_id";
	if (file_exists($guild_info)) {
		// load file
		$guild_info = unserialize(file_get_contents($guild_info));
	} else {
		$guild_info = array();
	}
	return $guild_info;
}

function set_guild_info ($guild_id, $guild_info) {
	global $config;
	$guild_file = $config['path.data'] . "$guild_id";
	file_put_contents($guild_file, serialize($guild_info));
}
  
?>
