<?php
include_once('t_list.php');
include_once('t_edit.php');
include_once('t_remove.php');

function tag ($tag, $param1=null, $param2=null) {
	if (is_array($param1)) {
		$attributes = $param1;
		$content = $param2;
	} else {
		$content = $param1;
		$attributes = is_null($param2) ? array() : $param2;
	}

	$c = "<$tag";
	foreach ($attributes as $name => $value) {
		$c = $c . " $name=\"$value\"";
	}
	return $c . ($content == null ? ' />' : " >$content</$tag>");
}

function span ($text, $color)
{
	return tag('font', array('color' => $color), $text);
}


function tr ($content) { return tag('tr', $content);}
function td ($content) { return tag('td', $content);}
function table ($content) { return tag('table', $content);}

class Render {
	private static function start_layout () {
		return "<html>
	<head><title>Ryzom - outil de relation de guilde </title><head>
	<meta http-equiv='Content-Type' content='text/html;charset=UTF-8'>
	<style type='text/css'>body {background-color: #AAA;}</style>
<body bgcolor='#00000000'>";
	}
	private static function end_layout () {
		return "</body></html>";
	}
	private static function layout ($content) {
		return Render::start_layout()
			. $content
			. Render::end_layout();
	}
	public static function remove_confirm ($name) {
		echo Render::layout(template_remove($name));
	}
	public static function guild_list ($guilds, $message = null) {
		global $user_info;
		echo Render::layout(template_list($user_info, $guilds, $message));
	}
	public static function guild_show ($guild = null) {
		global $user_info;
		echo template_edit($user_info, $guild);
	}
}
?>
