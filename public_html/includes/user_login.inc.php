<?php
/**
 * Created by PhpStorm.
 * User: Martin
 * Date: 7/25/2016
 * Time: 12:22 AM
 */

$page_title = "Login";
include($root . '/includes/header.html');

echo '<h1>Login</h1>';

if (isset($errors) and !empty($errors)) {
    echo '<p class=error><b>Error:</b><br>The following error(s) have occurred: <br>';
    foreach ($errors as $e)
        echo "  - $e<br>";
}

?>
<!-- Form -->

<form action="login.php" method="post">
    <p>Username: <input type="text" name="username" size="20" maxlength="20"  /></p>
    <p>Password: <input type="password" name="password" size="20" maxlength="40"  /></p>
    <p><input type="submit" name="submit" value="Submit"/></p>
</form>

<?php include($root . '/includes/footer.html');