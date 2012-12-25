<!DOCTYPE html>
<?php
include_once('config.php');
include_once('includes/user_session.php');

$user_info = user_session_start();

if ($user_info === false) {
	echo "aucune information utilisateur n'a ete trouvée";
	exit();
}
define('RYZOM_IG', $user_info['ig']);
define('RYAPI_URL', 'http://api.ryzom.com/');
include_once('includes/action.php');
include_once('includes/utils.php');
include_once('includes/render.php');

$guilds = get_guild_info($user_info['guild_id']);

// switch action
$do = isset($_POST['do']) ? $_POST['do'] : null;
switch ($do) {
	case 'create':
			Render::guild_show();
		break;
	case 'edit':
		if (isset($_POST['guild_index']) && isset($guilds[$_POST['guild_index']])) {
			Render::guild_show($guilds[$_POST['guild_index']]);
		} else {
			Render::guild_list($guilds, 'edition impossible guilde non trouvee');
		}
		break;
	case 'remove_confirm':
		if (isset($_POST['guild_index']) && isset($guilds[$_POST['guild_index']])) {
			Render::remove_confirm($guilds[$_POST['guild_index']]);
		} else {
			Render::guild_list($guilds, 'supression impossible guilde non trouvee');
		}
		break;
	case 'remove':
		$message = null;
		if (isset($_POST['guild_index']) && isset($guilds[$_POST['guild_index']])) {
			Action::remove($user_info, $guilds, $_POST['guild_index']);
		} else {
			$message = 'supression, impossible guilde non trouvee';
		}
		Render::guild_list($guilds, $message);
		break;
	case 'save':
		Action::save(isset($_POST['guild_index'])? $_POST['guild_index'] : '');
	default:
		Render::guild_list($guilds);
}

?>
