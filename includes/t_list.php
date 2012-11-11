<?php

function icon ($name) {
	switch($name) {
		case "fyros":  $img = "fyros";break;
		case "matis":  $img = "matis";break;
		case "tryker": $img = "tryker";break;
		case "zorai":  $img = "zorai";break;
		case "kami":  $img = "kami";break;
		case "karavan":  $img = "karavan";break;
	default:
		return '';
	}
	//return '<img src="http://www.bubblegumcrisis.de/arcdb/icon_ig.png" >';
	return "<img src='http://". $_SERVER['HTTP_HOST'] ."/guildrelation/img/$img.png'>";
}

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
		if (strlen($filter['text']) > 0 && stripos($name, $filter['text']) === false && stripos($guilds[$name]['comment'], $filter['text']) === false) {
			error_log('filter name: ' . $filter['text']);
			unset($guilds[$name]);
		} elseif (!$filter['any_nation'] && (!isset($guilds[$name]['nation']) || (isset($filter[$guilds[$name]['nation']]) && $filter[$guilds[$name]['nation']] === ''))) {
			unset($guilds[$name]);

		} elseif (!$filter['any_faction'] && (!isset($guilds[$name]['faction']) || (isset($filter[$guilds[$name]['faction']]) && $filter[$guilds[$name]['faction']] === ''))) {
			unset($guilds[$name]);			
		}
	}
}

function all_uncheck ($data, $tokens) {
	foreach ($tokens as $token) {
		if (isset($data[$token]) && $data[$token] != '') {
			return false;
		}
	}
	return true;
}

function get_search ($params) {
	$tokens = array('fyros', 'matis', 'tryker', 'zorai', 'kami', 'karavan');
	$default = !isset($params['do']) || $params['do'] != 'search';
	$search = array();
	$search['text'] = isset($params['search']) ? $params['search'] : '';
	foreach ($tokens as $token) { 
		$search[$token] = isset($params[$token]) ? 'checked=checked' : '';
		if (isset($params[$token])) error_log("get_seach $token: " . $params[$token]);
	}
	$search['any_nation'] = all_uncheck($params, array('fyros', 'matis', 'tryker', 'zorai'));
	$search['any_faction'] = all_uncheck($params, array('kami', 'karavan'));
	error_log('any nation: ' . $search['any_nation']);
	return $search;
}

function search_form ($search) {
	error_log('search_form fyros: ' . $search['fyros']);
	return '<form action="index.php" method="POST">
	<table>
	  <input type="hidden" name="do" value="search" />&nbsp;
		<tr><td>
		<label for="text">search : </label>	
		<tr><td>
	  <input type="text" name="search" value="'. $search['text'] . '" />&nbsp;
		</td></tr>
		<tr><td>
	  <label for="nation">nation : </label>
		</td><td>
		<input type="checkbox" name="fyros"  value="ok" ' . $search['fyros']  . ' /><span>Fyros</span>
		<input type="checkbox" name="matis"  value="ok" ' . $search['matis']  . '/><span>Matis</span>
		<input type="checkbox" name="tryker" value="ok" ' . $search['tryker'] . '/><span>Tryker</span>
		<input type="checkbox" name="zorai"  value="ok" ' . $search['zorai']  . '/><span>Zoraï</span>
		</td></tr>
		<tr><td>
	  <label for="faction">Faction : </label>
		</td><td>
		<input type="checkbox" name="kami"    value="checked"' . $search['kami'] . '/><span>Kami</span>
		<input type="checkbox" name="karavan" value="checked"' . $search['karavan'] . '/><span>Karavan</span>
		</td></tr>
		<tr><td>
	  <input type="submit" value="Rechercher" />
		</td></tr>
		</table>
	</form>';
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

	$style = array('valign' => 'middle');

	if (RYZOM_IG)
		$style['bgcolor'] = $odd ? '#00000000': '#00000033';	

	return 
		tag('tr', $style, 
			tag('td', array('height' => '30px'), span($guild['name'], $color))
		. td(icon(isset($guild['nation']) ? $guild['nation'] : ''))
		. td(icon(isset($guild['faction']) ? $guild['faction'] : ''))
		. td(span($guild['comment'], $color))
		. tag('td', guild_action($guild['name']))
	);
}

function template_list ($user, $guilds, $message = null) {
	global $_POST;
	$search = get_search($_POST);
	$c = "Bienvenue ". $user['char_name'];
	if (!is_null($message)) {
		$c .= "<br>attention: $message";
	}
	$c .= '<h2>Liste des relation</h2>';
	$c .= search_form($search);
	$c .= '<br>
	<form action="index.php" method="POST">
	  <input type="hidden" name="do" value="create" />
	  <input type="submit" value="Ajouter une relation" />
	</form>
	<table>
	<tr><td widtd="200px">Nom
	</td><td width="40px">Na
	</td><td width="40px">Fac
	</td><td width="400px">commentaire
	</td><td width="120px">action
	</td></tr>';

	// filter guilds
	filter_guild($guilds, $search);

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
