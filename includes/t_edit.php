<?php 
function template_edit ($user, $guild = null) {

	$c ='
	<table><tr><td height="30px">
	<a href="index.php">retour</a>
	</td></tr><tr><td height="20px">
	<h1>';

	if (is_null($guild)) {
		$c .= "Ajouter une relation";
		$guild = array(
			'name' => '',
			'relation' => 0,
			'nation' => '',
			'faction' => '',
			'comment' => '',
		);
	} else {
		$c .= "Relation avec la guilde " . $guild['name'];

		if (!isset($guild['nation']))
				$guild['nation'] = '';
		if (!isset($guild['faction']))
				$guild['faction'] = '';
	}
	$c .= '
	</h1>
	</td></tr></table>
	<form method="POST" action="index.php">
	  <input type="hidden" name="do" value="save" />
	  <input type="hidden" name="guild_index" value="' . $guild['id'] .'" />
	<table>
		<tr><td>
	  <label for="guild_name">Nom de la guilde : </label>
		</td><td>
	  <input type="text" name="guild_name" value="' . $guild['name'] . '" />
		</td></tr>
		<tr><td>
	  <label for="relation">relation : </label>
		</td><td>
	  <select name="relation">
	    <option ' . ($guild['relation'] == 1  ? 'selected="selected"' : '') . ' value="1">alli&eacute;</option>
	    <option ' . ($guild['relation'] == 0  ? 'selected="selected"' : '') . ' value="0">neutre</option>
	    <option ' . ($guild['relation'] == -1 ? 'selected="selected"' : '') . ' value="-1">ennemie</option>
	  </select>
		</td></tr>
		<tr><td>
	  <label for="nation">nation : </label>
		</td><td>
		<select name="nation">
	  
		<option ' . ($guild['nation'] == ''        ? 'selected="selected"' : '') . ' value=""      >aucune</option>
		<option ' . ($guild['nation'] == 'fyros'   ? 'selected="selected"' : '') . ' value="fyros" >Fyros</option>
		<option ' . ($guild['nation'] == 'matis'   ? 'selected="selected"' : '') . ' value="matis" >Matis</option>
		<option ' . ($guild['nation'] == 'tryker'  ? 'selected="selected"' : '') . ' value="tryker">Tryker</option>
		<option ' . ($guild['nation'] == 'zorai'   ? 'selected="selected"' : '') . ' value="zorai" >Zoraï</option>
		</select>
		</td></tr>
		<tr><td>
	  <label for="faction">Faction : </label>
		</td><td>
		<select name="faction">
		<option value=""        ' . ($guild['faction'] == ''        ? 'selected="selected"' : '') . ' >neutre</option>
		<option value="kami"    ' . ($guild['faction'] == 'kami'    ? 'selected="selected"' : '') . ' >Kami</option>
		<option value="karavan" ' . ($guild['faction'] == 'karavan' ? 'selected="selected"' : '') . ' >Karavan</option>
		</select>
		</td></tr>
	</table>
	<table>
		<tr><td>
	  <label for="comment">commentaire: </label>
		</td></tr>
		<tr><td>
	  <textarea name="comment" cols="50" rows="5">' . $guild['comment'] . ($user['ig'] ? "<br><br><br><br><br><br>" : '') . '</textarea>
		</td></tr>
		<tr><td>
	  <input type=submit value="save" />
		</td></tr>
		</table>
	</form>';

	return $c;
}
?>
