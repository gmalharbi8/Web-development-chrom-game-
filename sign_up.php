<?php
include "./database.php";
function isEmailExist($email) {
    try {
        Database::connect();
        $result = Database::select("EMAIL", "USER", "WHERE EMAIL='$email'");
        Database::close();
        // 0 >> not exist,  1 >> exist, -1 >>  some errors(not connected to DB)
        return $result->num_rows > 0 ? 1 : 0;
    } catch (\Throwable$th) {
        return -1;
    }
}

// The request is using the POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST["username"]) ? $_POST["username"] : "";
    $email = isset($_POST["email"]) ? $_POST["email"] : "";
    $password = isset($_POST["password"]) ? $_POST["password"] : "";
    $isError = false;
    $errorMessages = [];

    if ($username == "") {
        $errorMessages["username"] = "Username should be filled.";
        $isError = true;
    } // end if

    if ($email == "") {
        $errorMessages["email"] = "Email should be filled.";
        $isError = true;
    } // end if

    if ($password == "") {
        $errorMessages["password"] = "Password should be filled.";
        $isError = true;
    } // end if

    $isEmailExist = isEmailExist($email);
    if ($isEmailExist == 1) {
        $errorMessages["email"] = "You already have an account, please sign in.";
        $isError = true;
    } // end if

    if ($isEmailExist == -1) {
        $isError = true;
    } // end if

    if (!$isError) {
        // insert("table_name", "column1, column2, column3", [["val1", "val2", "val3"], ["val1", "val2", "val3"]])
        // INSERT INTO USER (NAME, EMAIL, PASSWORD) VALUES ('username', 'email', 'password')
        try {
            Database::connect();
            Database::insert("USER", "NAME, EMAIL, PASSWORD", [[$username, $email, $password]]);
            Database::close();
            $isInserted = true;
        } catch (\Throwable$th) {
            $isInserted = false;
            $isError = true;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="style.css" />
    <title>Sign Up</title>
</head>

<body>
    <div id="container">
        <div id="sub_container1" class="text_center">
            <img src="./images/crash.gif" alt="">
            <h1>Crash Game</h1>
        </div>

        <div id="sub_container2" >
            <?php
if (isset($isInserted)) {
    if ($isInserted) {
        echo "Your account created successfully, please <a href='./index.php'>sign in</a> to enjoy.";
    } else {
        echo "There are some issues in the system, and we can't create you account now. Please try again later.";
    }
    die();
}
?>
            <h2>Sign up</h2>
            <?php
if (isset($isEmailExist) && $isEmailExist == -1) {
    echo "There are some issues in the system. Please try again later.";
    die();
} // end if
?>
            <form action="" method="POST">
                <?php
if (isset($isError) && $isError) {
    echo "<p class = 'errorMessage'>Fields with red color need to be filled in properly.</p>";
} // end if
?>
                <table>
                    <tr>
                        <td>
                            <p>Username:</p>
                        </td>
                        <td>
                            <?php
if (isset($isError) && isset($errorMessages["username"])) {
    echo "<input id='username' type='text' class='errorField' name='username' value='" . (isset($username) ? $username : "") . "' placeholder='Username' />";
    echo "<label class='errorMessage'>*</label>";
} else {
    echo "<input id='username' type='text' name='username' value='" . (isset($username) ? $username : "") . "' placeholder='Username'>";
}
?>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <p>E-mail:</p>
                        </td>
                        <td>
                            <?php
if (isset($isError) && isset($errorMessages["email"])) {
    echo "<input id='email' type='email' class='errorField' name='email' value='" . (isset($email) ? $email : "") . "' placeholder='e.g. crash@gmail.com' />";
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
if (isset($isError) && isset($errorMessages["password"])) {
    echo "<input id='password' type='password' class='errorField' name='password' value='" . (isset($password) ? $password : "") . "'/>";
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
                    <input class="button" type="submit" value="Submit" />
                    <input class="button" type="reset" value="Reset" />
                </div>
                <br /><br /><br />
            </form>
            <br />
        </div>
    </div>
    <script type="text/javascript" src="./js/sign_up_script.js"></script>
</body>

</html>