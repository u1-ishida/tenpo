<h2>Login</h2>

<form action="/cakephp/account/login" method="POST">
<input type="hidden" name="next_url" value="<?php echo $next_url; ?>">
Login ID:<input type="text" name="id"><br>
Password:<input type="text" name="password"><br>
<input type="submit" value="Login">
</form>
