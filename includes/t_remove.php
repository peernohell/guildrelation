<?php
function template_remove ($name) {
?>
<h1>Suppression de de la guilde <?php echo $name ?></h1>
Etes vous vraiment sur de vouloir supprmier la guilde <b><?php echo $name ?></b>
<form method="POST" action="index.php">
	<input type="hidden" name="do" value="remove" />
	<input type="hidden" name="guild_name" value="<?php echo $name ?>" />
	<input type=submit value="supprimer" />
	<a href="index.php">retour</a>
</form>
<?php
}
?>
