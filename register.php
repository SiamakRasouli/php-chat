<?php include 'theme\header.php';
    include 'loader.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
      $data = [
        'first_name' => $_POST['first_name'],
        'last_name' => $_POST['last_name'],
        'password' => md5($_POST['password']),
        'email' => $_POST['email'],
        'status' => 1
      ];

      if($auth->register($data, $_FILES)) { // if user registered succussfully then we can login the user
        if($auth->loginUser($_POST['email'], $_POST['password'])) { // if user login successfully then redirect to index page
          header('Location: /index.php');
        }
      }
    }
 ?>
        <header class="header"><span class="name">Register</span>
        </header>

        <div class="inbox">
          <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
            <div>
              <div class="col-2">
                <label for="first_name">First Name:</label>
                <input type="text" name="first_name" id="first_name" />
              </div>

              <div class="col-2">
                <label for="last_name">Last Name:</label>
                <input type="text" name="last_name" id="last_name" />
              </div>
            </div>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" />

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" />

            <label for="confirm_password">Confirm Password:</label>
            <input
              type="password"
              name="confirm_password"
              id="confirm_password"
            />

            <label for="photo">Photo:</label>
            <input type="file" name="photo" id="photo">

            <input type="submit" name="submit" value="Sign Up" />
          </form>
          <div class="form_footer">Have a account?
            <a href="index.php">Sign in</a>
        </div>
        </div>
        <!-- Inbox -->
      </div>
      <!-- APP -->
    </div>
    <!-- Container -->
  </body>
</html>
