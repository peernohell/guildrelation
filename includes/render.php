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
	<link type='text/css' href='".RYAPI_URL. "data/css/ryzom_ui.css' rel='stylesheet' media='all' />
	<style type='text/css'>
		body{background-image:url(".RYAPI_URL."data/img/bg.jpg);background-repeat:no-repeat;color:white;background-color:black;font-family:arial;font-size:12px}
		#main{width:95%;height:300px;margin-left:auto;margin-right:auto;text-align:left}
		a, a:visited{color:orange;font-size:12px}
		td{font-size:12px}
		a:hover{color:orange}
		.error{padding:.5em;background:#ff5555;color:white;font-weight:bold}
		img{border:0px}
		textarea{background-color:black;color:white;font-family:arial;font-size:12px}
		pre{overflow:auto;width:800px}
	</style>
<body bgcolor='#00000000'><div id='main'>";
	}
	private static function end_layout () {
		return "</div></body></html>";
	}
	private static function layout ($content) {
		$c = Render::start_layout();
		if (!RYZOM_IG) {
			$c .= ryzom_render_www(ryzom_render_window($title, $content, $homeLink));
	
		} else {
			$c .= $content;
		}

		return $c . Render::end_layout();
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
		echo Render::layout(template_edit($user_info, $guild));
	}
}

/////////////////// ryzom api function
/* Copyright (C) 2009 Winch Gate Property Limited
 *
 * This file is part of ryzom_api.
 * ryzom_api is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * ryzom_api is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with ryzom_api.  If not, see <http://www.gnu.org/licenses/>.
 */

function ryzom_render_header() {
	if (ON_IPHONE) {
        return '';
	} else {
	}
}

// Render a Ryzom style window
function ryzom_render_window($title, $content, $homeLink=false) {
	return ryzom_render_window_begin($title, $homeLink) . $content . ryzom_render_window_end();
}

function ryzom_render_window_begin($title, $homeLink=false) {
	global $user_info;
	if ($homeLink === false)
		$homeLink = '<span style="float:right;margin-right:12px;"><a href="index.php" class="ryzom-ui-text-button">accueil</a></span>';

	return '
		<div class="ryzom-ui ryzom-ui-header">
			<div class="ryzom-ui-tl"><div class="ryzom-ui-tr">
				<div class="ryzom-ui-t">Relation de la guilde ' . $user_info['guild_name'] . '</div>
			</div>
		</div>
		<div class="ryzom-ui-l"><div class="ryzom-ui-r"><div class="ryzom-ui-m">
			<div class="ryzom-ui-body">
';
}

function ryzom_render_window_end() {
	global $user;
	return '</div>
		<div>'.(isset( $user['groups'])?implode(':', $user['groups']):'').'</div>
		</div></div></div>
		<div class="ryzom-ui-bl"><div class="ryzom-ui-br"><div class="ryzom-ui-b"></div></div></div><p class="ryzom-ui-notice">powered by <a class="ryzom-ui-notice" href="http://dev.ryzom.com/projects/ryzom-api/wiki">ryzom-api</a></p>
		</div>
	';
}

// Render a webpage using www.ryzom.com style
function ryzom_render_www($content) {
	return ryzom_render_www_begin() . $content . ryzom_render_www_end();
}

function ryzom_render_www_begin($url='') {
	$style1 = 'position: relative; padding-top: 20px; padding-right: 30px; margin-bottom: -3px';
	$style2 = 'position: absolute; bottom: 0; right: 0; ';
	
	if (!$url) {
		$url_params = parse_query($_SERVER['REQUEST_URI']);
		unset($url_params['lang']);

		$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.http_build_query($url_params);
	}
	return '
		<br />
		<div id="main">
				<div style="'.$style1.'">
					<a href="'.$url.'&lang=en"><img hspace="5" border="0" src="'.RYAPI_URL.'data/img/lang/en.png" alt="English" /></a>
					<a href="'.$url.'&lang=fr"><img hspace="5" border="0" src="'.RYAPI_URL.'data/img/lang/fr.png" alt="French" /></a>
					<a href="'.$url.'&lang=de"><img hspace="5" border="0" src="'.RYAPI_URL.'data/img/lang/de.png" alt="German" /></a>
					<a href="'.$url.'&lang=ru"><img hspace="5" border="0" src="'.RYAPI_URL.'data/img/lang/ru.png" alt="Russian" /></a>
					<div style="'.$style2.'">
						<a href="http://www.ryzom.com/"><img border="0" src="'.RYAPI_URL.'data/img/logo.gif" alt=""/></a>
					</div>
				</div>
';
}

function ryzom_render_www_end() {
	return '</div>';
}


?>
