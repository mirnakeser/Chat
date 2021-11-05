<?php require_once __DIR__ . '/_header.php'; ?>

<h3> Logout </h3>


Are you sure you want to leave the Chat?
<p>
<form method="post" action="chat.php?rt=users/index">
<button type="submit" name="logout">Yes, I want to logout.</button>
</form>
<form method="post" action="chat.php?rt=channels/naslovna">
<button type="submit" name="home">No, I want to keep chating.</button>
</form>
</p>


<?php require_once __DIR__ . '/_footer.php'; ?>