<?php
function template_remove ($guild) {
	$name = $guild['name'];
	$c = '<h1>Suppression de de la guilde ' .  $name . '</h1>
Etes vous vraiment sur de vouloir supprmier la guilde <b>' . $name .'</b>
<form method="POST" action="index.php">
	<input type="hidden" name="do" value="remove" />
	<input type="hidden" name="guild_index" value="' . $guild['id'] . '" />
	<input type=submit value="supprimer" />
	<a href="index.php">retour</a>
</form>';
	return $c;
}
?>
