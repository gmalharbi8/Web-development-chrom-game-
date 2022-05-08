class Player {
    constructor() {
        this.size = 130;
        this.xAxis = 50;
        this.yAxis = height - this.size;
        this.velocityYAxis = 0;
        this.gravity = 3;
    }

    jump() {
        if (this.yAxis == height - this.size) {
            this.velocityYAxis = -40;
        }
    }

    isCollision(obstacle) {
        let playerXAxis = this.xAxis + this.size * 0.5;
        let playerYAxis = this.yAxis + this.size * 0.5;
        let obstacleXAxis = obstacle.xAxis + obstacle.size * 0.5;
        let obstacleYAxis = obstacle.yAxis + obstacle.size * 0.5;
        return collideCircleCircle(playerXAxis, playerYAxis, this.size, obstacleXAxis, obstacleYAxis, obstacle.size);
    }

    isOvershoot(obstacle) {
        return (obstacle.xAxis + obstacle.size) < this.xAxis;
    }

    move() {
        this.yAxis += this.velocityYAxis;
        this.velocityYAxis += this.gravity;
        this.yAxis = constrain(this.yAxis, 0, height - this.size);
    }

    display() {
        image(playerImage, this.xAxis, this.yAxis, this.size, this.size);

        // fill(255, 50);
        // rect(this.xAxis, this.yAxis, this.size, this.size);
    }
}