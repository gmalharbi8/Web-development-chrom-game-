let player;
let playerImage;
let obstacleImage;
let backgroundImage;
let obstacles = [];
let soundClassifier;
let gameStarted;
let score;
let startTime;
let endTime;
let scoreElement;

function preload() {
  const options = {
    probabilityThreshold: 0.95
  };
  soundClassifier = ml5.soundClassifier('SpeechCommands18w', options);
  playerImage = loadImage('./images/crash.png');
  obstacleImage = loadImage('./images/plant.png');
  backgroundImage = loadImage('./images/background.jpg');
}

function mousePressed() {
  obstacles.push(new Obstacle());
}

function setup() {
  let canvas = createCanvas(800, 450);
  canvas.parent("gameCanvas");
  gameStarted = false;
  player = new Player();
  soundClassifier.classify(gotCommand);
  background(backgroundImage);
  player.display();
  score = 0;
  scoreElement = document.getElementById("score");
}


function gotCommand(error, results) {
  if (error) {
    console.log(error);
    return;
  }
  console.log(results[0].label, results[0].confidence);
  if (results[0].label == 'up') {
    player.jump();
  }
}

function keyPressed() {
  if (key == 'ArrowUp') {
    player.jump();
  }
}

function startGame() {
  gameStarted = true;
  startTime = getCurrentMillisecond();
  reset();
  start();
  loop();
}

function restartGame() {
  player = new Player();
  obstacles = [];
  background(backgroundImage);
  player.display();
  score = 0;
}

function draw() {
  if (gameStarted) {
    if (random(1) < 0.005) {
      obstacles.push(new Obstacle());
    }
    background(backgroundImage);
    for (let obstacle of obstacles) {
      obstacle.move();
      obstacle.display();
      if (player.isCollision(obstacle)) {
        noLoop();
        pause();
        endTime = getCurrentMillisecond();
        // console.log("currentUserId", getCookie("currentUserId"));
        // console.log("startTime", startTime);
        // console.log("endTime", endTime);
        // console.log("score", score);
        sendData(getCookie("currentUserId"), startTime, endTime, score);
        Swal.fire({
          title: 'Game Over',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Retry'
        }).then((result) => {
          restartGame();
          // console.log("result: ", result);
          if (result.isConfirmed) {
            loop();
            reset();
            start();
            startTime = getCurrentMillisecond();
            scoreElement.innerHTML = 0;
          } else if (result.dismiss === "cancel") {
            // Simulate an HTTP redirect
            window.location.replace("./highest_scores.php");
          }
        });
      } else if (player.isOvershoot(obstacle)) {
        index = obstacles.indexOf(obstacle);
        if (index > -1) {
          obstacles.splice(index, 1);
        }
        score++;
        scoreElement.innerHTML = score;
        // console.log("score: " + score);
      }
    }
    player.display();
    player.move();
  }
}

function getCookie(cookieName) {
  let name = cookieName + "=";
  let decodedCookie = decodeURIComponent(document.cookie);
  let cookieArray = decodedCookie.split(';');
  for (let i = 0; i < cookieArray.length; i++) {
    let temp = cookieArray[i];
    while (temp.charAt(0) == ' ') {
      temp = temp.substring(1);
    }
    if (temp.indexOf(name) == 0) {
      return temp.substring(name.length, temp.length);
    }
  }
  return "";
}

// send data to save it in DB
function sendData(userId, startTime, endTime, score) {
  $.ajax({
    type: 'POST',
    url: './saveScore.php',
    dataType: "json",
    data: (
      {
        "userId": userId,
        "startTime": startTime,
        "endTime": endTime,
        "score": score
      }),
    success: function (data) {
      // console.log(data);
    },
    error: function (jqXHR, textStatus, errorThrown) {
      // console.log(jqXHR);
      // console.log(textStatus);
      // console.log(errorThrown);
    }
  });
  return false;
}

function getCurrentMillisecond() {
  return new Date().getTime();
}

let hour = 0;
let minute = 0;
let second = 0;
let millisecond = 0;
let timerId;

function start() {
  pause();
  timerId = setInterval(() => { timer(); }, 10);
}

function pause() {
  clearInterval(timerId);
}

function reset() {
  hour = 0;
  minute = 0;
  second = 0;
  millisecond = 0;
  document.getElementById('hour').innerText = '00';
  document.getElementById('minute').innerText = '00';
  document.getElementById('second').innerText = '00';
}

function timer() {
  if ((millisecond += 10) == 1000) {
    millisecond = 0;
    second++;
  }
  if (second == 60) {
    second = 0;
    minute++;
  }
  if (minute == 60) {
    minute = 0;
    hour++;
  }
  document.getElementById('hour').innerText = returnData(hour);
  document.getElementById('minute').innerText = returnData(minute);
  document.getElementById('second').innerText = returnData(second);
}

function returnData(input) {
  return input > 10 ? input : `0${input}`
}