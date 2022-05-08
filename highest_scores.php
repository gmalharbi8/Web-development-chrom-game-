<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="style.css" />
    <title>Highest Scores</title>
  </head>
  <body>
    <div id="container" id="highest_scores_table">
      <div id="sub_container1" class="text_center">
        <img src="./images/crash.gif" alt="">
        <br /><br />
        <form action="" method="POST">
        <div class="disp_flex justify_center">
          <input class="button" type="submit" name="back_to_game" value="Back To Game" />
          <input class="button red_sign_out_button" type="submit" name="sign_out" value="Sign Out" />
        </div>
        </form>
        <br /><br />
        <h1>Highest Scores</h1>
      </div>

      <?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sign_out = isset($_POST["sign_out"]) ? $_POST["sign_out"] : "";
    $back_to_game = isset($_POST["back_to_game"]) ? $_POST["back_to_game"] : "";
    if ($sign_out) {
        if (isset($_COOKIE['currentUserId'])) {
            unset($_COOKIE['currentUserId']);
            setcookie('currentUserId', null, -1, '/');
        }
        header('Location: ./index.php');
    } else if ($back_to_game) {
        header('Location: ./game.php');
    }
}

include './database.php';
try {
    Database::connect();
    // SELECT NAME, MAX(SCORE) as SCORE FROM SCORE_HISTORY, USER WHERE USER_ID = ID GROUP BY USER_ID ORDER BY SCORE DESC;
    $result = Database::select("NAME, MAX(SCORE) as SCORE", "SCORE_HISTORY, USER", "WHERE USER_ID = ID GROUP BY USER_ID ORDER BY SCORE DESC");
    Database::close();
} catch (\Throwable$th) {
}

?>

      <div id="highest_scores_table_div">
        <table id="highest_scores_table">
          <thead>
            <tr>
              <th>Username</th>
              <th>Score</th>
            </tr>
          </thead>
          <tbody>
              <?php
// fetch each record in result set
while ($row = mysqli_fetch_row($result)) {
    // build table to display results
    echo "<tr>";
    echo "<td>$row[0]</td>";
    echo "<td>$row[1]</td>";
    echo "</tr>";
} // end while
?> <!-- end PHP script -->
          </tbody>
        </table>
      </div>
    </div>
  </body>
</html>