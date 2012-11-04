<?php

function guild_action ($name) {
	return table(
		tr(
			tag('td', array('width' => "40px"),
				tag('form', array('method' => "POST", 'action' => "index.php"),
					tag('input', array('type' => "hidden" , 'name' => "guild_name", "value" => $name)) 
					. tag('input', array('type' => "hidden" , 'name' => "do", "value" => "edit"))
					. tag('input', array('type' => "submit", "value" => "edit"))
				)
			)
		)
		. tr(
			tag('td', array('width' => "40px"),
				tag('form', array('method' => "POST", 'action' => "index.php"),
					tag('input', array('type' => "hidden" , 'name' => "guild_name", "value" => $name)).
					tag('input', array('type' => "hidden" , 'name' => "do", "value" => "remove_confirm")).
					tag('input', array('type' => "submit", "value" => "supprimer"))
				)
			)
		)
	);
}

function guild ($guild) {
	$relations = array(-1 => 'ennemie', 0 => 'neutre', 1 => 'alli&eacute;');
	if ($guild['relation'] < -1 || $guild['relation'] > 1) {
		$relation = 'non defini';
	} else {
		$relation = $relations[$guild['relation']];
	}
	$color = "#FFFFFF";

	switch ($guild['relation'])
	{
		case -1: $color = "#992222"; break;
		case  1: $color = "#229922"; break;
	}
	return tr(
		td(span($guild['name'], $color))
		. td(span($relation, $color))
		. td(span($guild['comment'], $color))
		. tag('td', array('width' => '60px'), guild_action($guild['name']))
	);
}

function template_list ($user, $guilds, $message = null) {
	$c = "<h1>Relation de la guilde <b>" . $user['guild_name'] . "</b></h1>"
	. "Bienvenue ". $user['char_name'];
	if (!is_null($message)) {
		$c .= "<br>attention: $message";
	}
	$c .= "<h2>Liste des relation</h2>"
	. "<form action='index.php' method='POST'>"
	. "  <input type='hidden' name='do' value='create' />"
	. "  <input type='submit' value='Ajouter une relation' />"
	. "</form>"
	. "<table border=1>"
	. "<tr><td widtd='200px'>Nom"
	. "</td><td width='65px'>relation"
	. "</td><td width='400px'>commentaire"
	. "</td><td width='140px'>action"
	. "</td></tr>";

	foreach($guilds as $name => $value) {
		$c .= guild($value);
	}
	return $c . "</table>";
}
?>
