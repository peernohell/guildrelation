<?php

function relation_and_name_sort ($a, $b) {
	if ($a['relation'] === $b['relation']) {
		return strcmp($a['name'], $b['name']);
	}
	if (abs($a['relation']) === abs($b['relation'])) {
		// a and b equal 1 or -1
		return $b['relation'] - $a['relation'];
	}
	// a and b equal 1 or 0
	return abs($b['relation']) - abs($a['relation']);
}

function guild_action ($name) {
	return table(
		tr(
			tag('td', array('width' => "40px"),
				tag('form', array('method' => "POST", 'action' => "index.php"),
					tag('input', array('type' => "hidden" , 'name' => "guild_name", "value" => $name)) 
					. tag('input', array('type' => "hidden" , 'name' => "do", "value" => "edit"))
					. tag('input', array('type' => "submit", "value" => "edit"))
				)
			) .
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

function filter_guild (&$guilds, $filter) {
	foreach ($guilds as $name => $info) {
		if (stripos($name, $filter) === false && stripos($guilds[$name]['comment'], $filter) === false) {
				unset($guilds[$name]);
		}
	}
}

function guild ($guild, $odd) {
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
	return tag('tr', array('bgcolor' => ($odd ? '#00000000': '#00000033'), 'valign' => 'middle', 'style' => 'background: ' . ($odd ? '#AAA': '#999')), 
		tag('td', array('height' => '30px'), span($guild['name'], $color))
		. td(span($guild['comment'], $color))
		. tag('td', guild_action($guild['name']))
	);
}

function template_list ($user, $guilds, $message = null) {
	global $_POST;
	$c = "<h1>Relation de la guilde <b>" . $user['guild_name'] . "</b></h1>"
	. "Bienvenue ". $user['char_name'];
	if (!is_null($message)) {
		$c .= "<br>attention: $message";
	}
	$c .= "<h2>Liste des relation</h2>"
	. "<form action='index.php' method='POST'>"
	. "  <input type='text' name='search' value='". (isset($_POST['search']) ? $_POST['search'] : '') . "' />&nbsp;"
	. "  <input type='submit' value='Rechercher' />"
	. "</form><br>"
	. "<form action='index.php' method='POST'>"
	. "  <input type='hidden' name='do' value='create' />"
	. "  <input type='submit' value='Ajouter une relation' />"
	. "</form>"
	. "<table border=1>"
	. "<tr><td widtd='200px'>Nom"
	. "</td><td width='400px'>commentaire"
	. "</td><td width='120px'>action"
	. "</td></tr>";

	// filter guilds
	if (isset($_POST['search']) && $_POST['search'] !== '')
		filter_guild($guilds, $_POST['search']);

	// sort guilds.
	usort($guilds, 'relation_and_name_sort');
  $i = 0;
	foreach($guilds as $name => $value) {
		$c .= guild($value, $i % 2);
		$i++;
	}
	return $c . "</table>";
}
?>
