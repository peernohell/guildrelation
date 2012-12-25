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

function append_index (&$guilds) {
	for ($i=0; $i < sizeof($guilds); $i++) {
		$guilds[$i]['id'] = $i;
	}
}

function remove_index ($guilds) {
	for ($i=0; $i < sizeof($guilds); $i++) { 
		unset($guilds[$i]['id']);
	}
}


function get_guild_info ($guild_id) {
	global $config;
	$guilds = $config['path.data'] . "$guild_id";
	if (file_exists($guilds)) {
		// load file
		$guilds = unserialize(file_get_contents($guilds));
	} else {
		$guilds = array();
	}
	append_index($guilds);
	return $guilds;
}

function set_guild_info ($guild_id, $guilds) {
	global $config;
	$guild_file = $config['path.data'] . "$guild_id";
	remove_index($guilds);
	file_put_contents($guild_file, serialize($guilds));
}
  
?>
