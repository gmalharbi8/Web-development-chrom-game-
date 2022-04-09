let player;
let playerImage;
let obstacleImage;
let backgroundImage;
let obstacles = [];
let soundClassifier;

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
  createCanvas(800, 450);
  player = new Player();
  soundClassifier.classify(gotCommand);
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

function draw() {
  if (random(1) < 0.005) {
    obstacles.push(new Obstacle());
  }
  background(backgroundImage);
  for (let obstacle of obstacles) {
    obstacle.move();
    obstacle.display();
    if (player.isCollision(obstacle)) {
      console.log('game over');
      noLoop();
    }
  }
  player.display();
  player.move();
}