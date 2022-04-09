class Obstacle {
    constructor() {
        this.size = 90;
        this.xAxis = width;
        this.yAxis = height - this.size;
    }

    move() {
        this.xAxis -= 10;
    }

    display() {
        image(obstacleImage, this.xAxis, this.yAxis, this.size, this.size);
    }
}