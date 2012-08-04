<?php if ($this->fail === true) : ?>
<h1>Oops!</h1><br />
<center><span class="error"> Sorry, the password you entered was incorrect.<br /><br /></span></center>                 
<?php endif; ?>

<center>
    <form name="editor" method="post" action="">
        <label class="passProtected" for="thePass">Password </label>
        <input type="password" name="thePassword" />
        <input type="submit" name="showUs" value="Submit" />
    </form>
</center>