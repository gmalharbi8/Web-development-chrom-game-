<?php
include './database.php';
// the sign in form will submit with POST method, so check if the request type is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // read the values from the request
    $email = isset($_POST["email"]) ? $_POST["email"] : "";
    $password = isset($_POST["password"]) ? $_POST["password"] : "";
    $isError = false;
    // ["Key" => "value", "Key" => "value"]
    $errorMessages = [];

    // check if the values not come
    if ($email == "") {
        $errorMessages["email"] = "Email should be filled.";
        $isError = true;
    } // end if

    if ($password == "") {
        $errorMessages["password"] = "Password should be filled.";
        $isError = true;
    } // end if

    //check if there are some errors
    if (!$isError) {
        try {
            $isLogged = false;
            // connect to DB and check if the user is existing with the password
            Database::connect();
            $result = Database::select("ID", "USER", "WHERE EMAIL = '$email' AND PASSWORD = '$password'");
            Database::close();

            if ($result->num_rows === 1) {
                $isLogged = true;
                $row = mysqli_fetch_row($result);
                $currentUserId = $row[0];
                // read the user details from the DB and save it on cookie
                setcookie("currentUserId", $currentUserId, time() + 2 * 24 * 60 * 60);
            }
        } catch (\Throwable$th) {
            $isLogged = false;
            $isError = true;
        }

    } // end if
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="style.css" />
    <title>Sign In</title>
  </head>
  <body>
    <div id="container">
      <div id="sub_container1" class="text_center">
        <img src="./images/crash.gif" alt="">
        <h1>Crash Game</h1>
      </div>

      <div id = "sub_container2">
        <h2>Sign In</h2>
        <?php
if (isset($isError) && $isError) {
    echo "<p class = 'errorMessage'>Fields with red color need to be filled in properly.</p>";
} // end if

if (isset($isLogged)) {
    if ($isLogged && !$isError) {
        // move to game page, user logged successfully without errors
        header("Location: ./game.php");
        die();
    } else if (!$isLogged && $isError) {
        // user not logged successfully, and there are some DB errors
        echo "<p class = 'errorMessage'>There are some issues in the system, Please try again later.</p>";
        die();
    } else if (!$isLogged && !$isError) {
        // user not logged successfully, and there are no errors
        echo "<p class = 'errorMessage'>Email or password is incorrect. Please try again later.</p>";
    }
} //end if
?>
        <form action="" method="POST">
          <table>
            <tr>
              <td>
                <p>E-mail:</p>
              </td>
              <td>
              <?php
// if the error in email then surround it by red color
if (isset($errorMessages["email"])) {
    echo "<input id='email' type='email' class='errorField' name='email' placeholder='e.g. crash@gmail.com' />";
    echo "<label class='errorMessage'>*</label>";
} else {
    echo "<input id='email' type='email' name='email' value='" . (isset($email) ? $email : "") . "' placeholder='e.g. crash@gmail.com' />";
}
?>
              </td>
            </tr>

            <tr>
              <td>
                <p>Password:</p>
              </td>
              <td>
              <?php
// if the error in password then surround it by red color
if (isset($errorMessages["password"])) {
    echo "<input id='password' type='password' class='errorField' name='password'/>";
    echo "<label class='errorMessage'>*</label>";
} else {
    echo "<input id='password' type='password' name='password' value='" . (isset($password) ? $password : "") . "'/>";
}
?>
              </td>
            </tr>
          </table>
          <br /><br />
          <div class="text_center">
            <input class="Submit" type="submit" value="Submit" />
            <input class="Reset" type="reset" value="Reset" />
          </div>

        </form>
        <br /><br /><br />
        <div >
          <p class="text_center">If you do not have an account: <a  href="./sign_up.php" target="_blank" title="Go to sign up">Sign up</a></p>
        </div>
      </div>
    </div>
    <script type="text/javascript" src="./js/sign_in_script.js"></script>
  </body>
</html>
