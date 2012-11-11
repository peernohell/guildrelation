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
	  <input type="hidden" name="original_name" value="' . $guild['name'] .'" />
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
		<input type="radio" name="nation" value=""       ' . ($guild['nation'] == ''        ? 'checked' : '') . ' /><span>aucune</span>
		<input type="radio" name="nation" value="fyros"  ' . ($guild['nation'] == 'fyros'   ? 'checked' : '') . '/><span>Fyros</span>
		<input type="radio" name="nation" value="matis"  ' . ($guild['nation'] == 'matis'   ? 'checked' : '') . '/><span>Matis</span>
		<input type="radio" name="nation" value="tryker" ' . ($guild['nation'] == 'tryker'  ? 'checked' : '') . '/><span>Tryker</span>
		<input type="radio" name="nation" value="zorai"  ' . ($guild['nation'] == 'zorai'   ? 'checked' : '') . '/><span>Zoraï</span>
		</td></tr>
		<tr><td>
	  <label for="faction">Faction : </label>
		</td><td>
		<input type="radio" name="faction" value=""       ' . ($guild['faction'] == ''        ? 'checked' : '') . ' /><span>neutre</span>
		<input type="radio" name="faction" value="kami"  ' . ($guild['faction'] == 'kami'   ? 'checked' : '') . '/><span>Kami</span>
		<input type="radio" name="faction" value="karavan"  ' . ($guild['faction'] == 'karavan'   ? 'checked' : '') . '/><span>Karavan</span>
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
