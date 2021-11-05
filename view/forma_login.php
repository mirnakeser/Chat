<?php
require_once __DIR__ . '/_header.php';
?>
<p>
<h3>Login to Chat</h3>
<form method='post' action='chat.php?rt=users/login'>
    username:
    <input type="text" name="username">
    <br>
    password:
    <input type="password" name="password">
    <br>
    <button type="submit" name="login">Login!</button>
</form>
</p>

<p>
<h3>Don't have an account yet? Register here.</h3>
<form method='post' action='chat.php?rt=users/register'>
    username: (3-10 letters)
    <br>
    <input type="text" name="newusername">
    <br>
    password:
    <br>
    <input type="password" name="newpassword">
    <br>
    email:
    <br>
    <input type="text" name="newemail">
    <br>
    <button type="submit" name="register">Register!</button>
</form>
</p>



<?php
require_once __DIR__ . '/_footer.php';
?>