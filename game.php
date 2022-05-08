<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sign_out = isset($_POST["sign_out"]) ? $_POST["sign_out"] : "";
    if ($sign_out) {
        if (isset($_COOKIE['currentUserId'])) {
            unset($_COOKIE['currentUserId']);
            setcookie('currentUserId', null, -1, '/');
        }
        header('Location: ./index.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Crash Game</title>

    <link rel="stylesheet" type="text/css" href="style.css" />

    <script src="libraries/p5.min.js"></script>
    <script src="libraries/p5.sound.min.js"></script>
    <script src="libraries/p5.collide2d.min.js"></script>
    <script src="libraries/ml5.min.js"></script>
    <script
      type="text/javascript"
      src="libraries/sweetalert2.all.min.js"
    ></script>
    <script src="./js/jquery-3.3.1.min.js"></script>
    <style>
      html,
      body {
        margin: 0;
        padding: 0;
      }
      canvas {
        display: block;
      }
    </style>
  </head>
  <body>

    <div class="disp_flex justify_space_evenly score_timer">
      <div class="disp_flex justify_center">
        <p>
          <span id="hour">00</span>:<span id="minute">00</span>:<span id="second">00</span>
        </p>
      </div>
      <div class="disp_flex justify_center"><p>Score: <span id="score">0</span></p></div>
    </div>

    <div id="gameCanvas"></div>

    <div id="startNewGame">
      <input
      class="button"
      type="button"
      value="Start New Game"
      onclick="startGame()"
      />

      <form action="" method="POST">
        <input class="button red_sign_out_button" type="submit" name="sign_out" value="Sign Out" />
      </form>
    </div>

    <script src="js/player.js"></script>
    <script src="js/obstacle.js"></script>
    <script src="js/sketch.js"></script>
  </body>
</html>