<?php if ($this->authenticated) : ?>
<form action="" method="POST" >
    <span>logged in as: <?= $this->user->getUsername(); ?></span>
    <input type="submit" name="logout" value="logout"/> 
</form>
<?php else: ?>
<form action="" method="POST" >
    <label for="username">Username: </label>
    <input type="text" maxlength="40" name="username" /> 
    <label for="Password">Password: </label>
    <input type="password" maxlength="40" name="password" />
    <input type="submit" name="auth" />
</form>
<?php endif;?>