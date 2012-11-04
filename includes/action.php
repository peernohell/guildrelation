<?php
class Action {
	static function save ($guild_name = '', $new_value = null) {
		global $user_info, $guild_info;
		if ($guild_name != '' && isset($guild_info[$_POST['original_name']])) {
			unset($guild_info[$_POST['original_name']]);
		}
		$comment = $_POST['comment'];
		error_log("Comment: $comment");
		// remove ending br
		if (substr_compare($comment, '<br><br><br><br><br><br>', -24) == 0) {
			error_log("compare found");
			$comment = substr($comment, 0, -24);
			error_log("Comment: $comment");
		}

		// create => create a new entry
		$guild_info[$_POST['guild_name']] = array(
			'name' => $_POST['guild_name'],
			'relation' => $_POST['relation'],
			'comment' => $comment 
		);
		set_guild_info($user_info['guild_id'], $guild_info);
	}

	static function remove ($user, &$guilds, $guild_name) {
		unset($guilds[$guild_name]);
		set_guild_info($user['guild_id'], $guilds);
		$redirect = true;
	}
}
?>
