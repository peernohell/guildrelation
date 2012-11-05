<!DOCTYPE html>
<?php
include_once('config.php');
include_once('includes/user_session.php');

$user_info = user_session_start();

if ($user_info === false) {
	echo "aucune information utilisateur n'a ete trouvée";
	exit();
}

include_once('includes/action.php');
include_once('includes/render.php');

$guild_info = get_guild_info ($user_info['guild_id']);

// switch action
$do = isset($_POST['do']) ? $_POST['do'] : null;
switch ($do) {
	case 'create':
			Render::guild_show();
		break;
	case 'edit':
		if (isset($_POST['guild_name']) && isset($guild_info[$_POST['guild_name']])) {
			Render::guild_show($guild_info[$_POST['guild_name']]);
		} else {
			Render::guild_list($guild_info, 'edition impossible guilde non trouvee');
		}
		break;
	case 'remove_confirm':
		if (isset($_POST['guild_name'])) {
			Render::remove_confirm($_POST['guild_name']);
		} else {
			Render::guild_list($guild_info);
		}
		break;
	case 'remove':
		$message = null;
		if (isset($_POST['guild_name']) && isset($guild_info[$_POST['guild_name']])) {
			Action::remove($user_info, $guild_info, $_POST['guild_name']);
		} else {
			$message = 'supression, impossible guilde non trouvee';
		}
		Render::guild_list($guild_info, $message);
		break;
	case 'save':
		Action::save();
	default:
		Render::guild_list($guild_info);
}

?>
