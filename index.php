<?php
require_once('./db.php');
require_once('./navbar.php');
require_once('./footer.php');

// check session
if (isset($_SESSION['user_id'])) {
  header("location:home.php");
}

// signup function
if (isset($_POST['signup'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];
  // check user exits or not
  $sql = pg_query($db, "SELECT * FROM users WHERE email='$email'");
  if (($row = pg_fetch_array($sql)) == null) {
    // insert user data
    $query = pg_query($db, "INSERT  INTO users(email, password) VALUES ('$email','$password');");
    if ($query) {
      echo '<script>alert("Record Successfully Added!")</script>';
    } else {
      echo '<script>alert("Record Added failed")</script>';
    }
  } else {
    echo '<script>alert("This email is already being used")</script>';
  }
}

// signin function
if (isset($_POST['signin'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];
  // check login credentials
  $sql = pg_query($db, "SELECT * FROM users WHERE email='$email' AND password='$password'");
  if (($row = pg_fetch_array($sql)) == null) {
    echo '<script>alert("Invalid Email Or Password")</script>';
  } else {
    // create session
    $_SESSION["user_id"] = $row['user_id'];
    // redirect to home page
    echo '<script>alert("Login Successful"); window.location = "home.php";</script>';
  }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta http-equiv="x-ua-compatible" content="ie=edge" />
  <title>Login & Register</title>
  <!-- MDB icon -->
  <link rel="icon" href="img/mdb-favicon.ico" type="image/x-icon" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css" />
  <!-- Google Fonts Roboto -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" />
  <!-- MDB -->
  <link rel="stylesheet" href="css/mdb.min.css" />
</head>

<body>

  <?= navbar() ?>
  <!-- Start your project here-->
  <div class="container col-md-4 mt-5 mb-5">
    <!-- Pills navs -->
    <ul class="nav nav-pills nav-justified mb-3" id="ex1" role="tablist">
      <li class="nav-item" role="presentation">
        <a class="nav-link active" id="tab-login" data-mdb-toggle="pill" href="#pills-login" role="tab" aria-controls="pills-login" aria-selected="true">Login</a>
      </li>
      <li class="nav-item" role="presentation">
        <a class="nav-link" id="tab-register" data-mdb-toggle="pill" href="#pills-register" role="tab" aria-controls="pills-register" aria-selected="false">Register</a>
      </li>
    </ul>
    <!-- Pills navs -->

    <!-- Pills content -->
    <div class="tab-content">
      <div class="tab-pane fade show active" id="pills-login" role="tabpanel" aria-labelledby="tab-login">
        <form method="post">
          <div class="text-center mb-3">
            <p>Sign in with:</p>
          </div>

          <!-- Email input -->
          <div class="form-outline mb-4">
            <input type="email" id="loginName" name="email" class="form-control" required />
            <label class="form-label" for="loginName">Email </label>
          </div>

          <!-- Password input -->
          <div class="form-outline mb-4">
            <input type="password" id="loginPassword" name="password" class="form-control" required />
            <label class="form-label" for="loginPassword">Password</label>
          </div>

          <!-- Remember me-->
          <div class="form-check d-flex justify-content-center mb-4">
            <input class="form-check-input" type="checkbox" value="" id="loginCheck" required />
            <label class="form-check-label" for="loginCheck">
              &nbsp; Remember me
            </label>
          </div>

          <!-- Submit button -->
          <button type="submit" name="signin" class="btn btn-primary btn-block mb-4">
            Sign in
          </button>
        </form>
      </div>
      <!-- register -->
      <div class="tab-pane fade" id="pills-register" role="tabpanel" aria-labelledby="tab-register">
        <form method="post">
          <div class="text-center mb-3">
            <p>Sign up with:</p>
          </div>

          <!-- Email input -->
          <div class="form-outline mb-4">
            <input type="email" id="registerEmail" name="email" class="form-control" required />
            <label class="form-label" for="registerEmail">Email</label>
          </div>

          <!-- Password input -->
          <div class="form-outline mb-4">
            <input type="password" id="registerPassword" name="password" class="form-control" required />
            <label class="form-label" for="registerPassword">Password</label>
          </div>

          <!-- Checkbox -->
          <div class="form-check d-flex justify-content-center mb-4">
            <input class="form-check-input me-2" type="checkbox" value="" id="registerCheck" required aria-describedby="registerCheckHelpText" />
            <label class="form-check-label" for="registerCheck">
              I have read and agree to the terms
            </label>
          </div>

          <!-- Submit button -->
          <button type="submit" name="signup" class="btn btn-primary btn-block mb-3">
            Sign up
          </button>
        </form>
      </div>
    </div>
    <!-- Pills content -->
  </div>
  <!-- End your project here-->
  <div class="fixed-bottom">
    <?= footer() ?>
  </div>

</body>

<!-- MDB -->
<script type="text/javascript" src="js/mdb.min.js"></script>
<!-- Custom scripts -->
<script type="text/javascript"></script>

</html>