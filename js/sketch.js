let player;
let playerImage;
let obstacleImage;
let backgroundImage;
let obstacles = [];
let soundClassifier;
let gameStarted;

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
  if (key == ' ') {
    player.jump();
  }
}

function startGame() {
  gameStarted = true;
  loop();
}

function restartGame() {
  player = new Player();
  obstacles = [];
  background(backgroundImage);
  player.display();
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
        Swal.fire({
          title: 'Game Over',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Retry'
        }).then((result) => {
          restartGame();
          if (result.isConfirmed) {
            loop();
          }
        });
        noLoop();
      }
    }
    player.display();
    player.move();
  }
}