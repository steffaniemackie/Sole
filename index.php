<?php require_once('header.php'); ?>

<section role="main">
    <aside role="dialog">
        <h1>sign in</h1>
        <form method="post" action="process/user.php">
            <label for="username">user</label>
            <input name="username" id="username" type="text"><br>
            <label for="password">password</label>
            <input type="password" name="password" id="password">
            <input type="submit" value="Login" name="action" id="button">
            <a href="signup.html" id="sign">sign up</a>
        </form>
    </aside>
</section>

<div class="clear"></div>
</body>
</div>
</html>