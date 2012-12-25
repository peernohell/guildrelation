<?php
class Action {
	static function save ($id = '', $new_value = null) {
		global $user_info, $guilds, $_POST;
		$comment = $_POST['comment'];
		// remove ending br
		if (strlen($comment) > 24 && substr_compare($comment, '<br><br><br><br><br><br>', -24) == 0) {
			$comment = substr($comment, 0, -24);
		}

		// create => create a new entry
		$guild = array(
			'id' => $_POST['guild_index'],
			'name' => $_POST['guild_name'],
			'relation' => $_POST['relation'],
			'nation' => $_POST['nation'],
			'faction' => $_POST['faction'],
			'comment' => $comment 
		);
		if ($id == '') {
			$guild['id'] = sizeof($guilds);
			array_push($guilds, $guild);
		} else {
			$guilds[$_POST['guild_index']] = $guild;
		}
		set_guild_info($user_info['guild_id'], $guilds);
	}

	static function remove ($user, &$guilds, $id) {
		array_splice($guilds, $id, 1);
		set_guild_info($user['guild_id'], $guilds);
		$redirect = true;
	}
}
?>
