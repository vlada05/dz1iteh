<?php
session_start();

if (isset($_SESSION['id'])) {
  header("Location: glavna.php");
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="stylesheet" href="css/index.css">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome</title>
</head>

<body>
  <div class="form-structor">
    <div class="signup">
      <h2 class="form-title" id="signup"><span>or</span>Sign up</h2>
      <div class="form-holder">
        <form method="post">
          <span class="error" id="errorRegister"></span>
          <input type="text" class="input" placeholder="Name" name="regName" id="regName" />
          <span class="error" id="erorRegName"></span>
          <input type="email" class="input" placeholder="Email" name="regEmail" id="regEmail" />
          <span class="error" id="erorRegEmail"></span>
          <input type="password" class="input" placeholder="Password" name="regPw" id="regPw" />
          <span class="error" id="erorRegPw"></span>
      </div>
      <input type="submit" class="submit-btn" name="register" id="register" value="Sign up">
      </form>
    </div>
    <div class="login slide-up">
      <div class="center">
        <h2 class="form-title" id="login"><span>or</span>Log in</h2>
        <div class="form-holder">
          <form method="post">
            <span class="error" id="errorLogin"></span>
            <input type="email" class="input" placeholder="Email" name="logEmail" id="logEmail" />
            <span class="error" id="erorLogEmail"></span>
            <input type="password" class="input" placeholder="Password" name="logPw" id="logPw" />
            <span class="error" id="erorLogPw"></span>
        </div>
        <input type="submit" class="submit-btn" name="logIn" id="logIn" value="Log in">
        <!--onclick="return clickLogin();" -->
        </form>
      </div>
    </div>
  </div>

  <script src="addons/jquery.min.js"></script>
  <script src="js/index.js"></script>
</body>

</html>