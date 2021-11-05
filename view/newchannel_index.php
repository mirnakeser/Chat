<?php require_once __DIR__ . '/_header.php'; ?>
<?php require_once __DIR__ . '/izbornik.php'; ?>

Name for your new channel:
<form method="post" action="chat.php?rt=channels/new" > 
<input type="text" name="noviKanal">
<br>
<button type="submit" name="napraviNovi">Create new channel</button>
</form>

<?php require_once __DIR__ . '/_footer.php'; ?>