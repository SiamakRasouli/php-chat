<?php
if($_SERVER['REQUEST_METHOD'] == "POST") {
  if($auth->loginUser($_POST['email'], $_POST['password'])) {

    # Set User status to Online after login
    $query = "UPDATE users SET status=2 WHERE email='{$_SESSION["user"]}'"; // Status=2 means User is Online
    $db->query($query);

    header('Location: /index.php');
  }
}
?>

<header class="header">
  <span class="show name">Login</span>
</header>

<div class="inbox">
  <form action="index.php" method="POST">

    <label for="email">Email:</label>
    <input type="email" name="email" id="email" />

    <label for="password">Password:</label>
    <input type="password" name="password" id="password" />

    <input type="submit" name="submit" value="Sign in" />
  </form>

  <div class="form_footer">Don`t have account?
    <a href="register.php">Register</a>
  </div>

</div>
<!-- Inbox -->