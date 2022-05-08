# Web-development-chrom-game-
we are imam university student and this project describes how to create a web game using front end languages: HTML,CSS,PHP,Ajax,JS.
overview of our project:

In this project, we build a dynamic website which is a makeover of the famous Google Chrome Dinosaur Game, but with more distinguishing and advanced properties. It's called 'Crash Game'. Our target audience is anyone who wants to enjoy a dynamic competitive game.

# Look & Feel:

This game is a makeover of the google dinosaur, the concept is inspired by Crash Bandicoot. The main player's character is Crash and instead of the cactuses, man eating plants will be demonstrated. We’ve used some CSS properties from the website below to achieve a satisfying screen appearance and responsiveness: css-tricks: https://css-tricks.com

Dynamic Components:

Due to the use of php language and its embedding in web pages (html), we have included JavaScript files in these php files: 1.game.php (player.js, obstacle.js, sketch.js)

2.index.php (sign_in_script.js)

3.sign_up.php (sign_up_script.js)

Business logic:

Database structure: The database consists of two tables, one called user to store users’ accounts information and the other table is called score_history to store each player’s scores. User table has 4 parameters, ID which is a primary key, EMAIL, NAME, and PASSWORD, while score_history has a composite key of USER_ID as a foreign key from the primary key of the user table, START_TIME, and END_TIME, and another parameter called SCORE. We have added a file containing database methods (database.php) as connect, select, insert and close. The connect method: uses the username, password, host, and name of the database to make a connection to the database. Method select: It takes the selected Items, location (name of the table), and the condition if it exists, then creates a query and fetches the required values from the table. For the insert method: take the name of the table, columns, and values to be added then the method works to arrange the values in specific formats and add them to the required table. The last method close: closes the connection. In order to deal with this file, we used “include” to import these methods into the files that need to connect to the database.   As an example of including a database file, the highest_scores.php file includes a database file and calls a select method that is equivalent to executing this SQL command (SELECT NAME, MAX(SCORE) as SCORE FROM SCORE_HISTORY, USER WHERE USER_ID = ID GROUP BY USER_ID ORDER BY SCORE DESC;) that will be fitch the highest score for each user and display it for the user into the table. Also, the sign_up.php file includes a database file and calls the insert method that is equivalent to executing this SQL command (INSERT INTO USER (NAME, EMAIL, PASSWORD) VALUES ('username', 'email', 'password')) that adds the user information to the database.
# Flow chart:
![image](https://user-images.githubusercontent.com/93717241/167278709-1cd58bf9-cd3c-4ce8-a1be-b72ceea75c53.png).

By using draw.io tool

## References:
tackoverflow:
https://stackoverflow.com

w3schools:
https://www.w3schools.com

css-tricks:
https://css-tricks.com

c-sharpcorner:
https://www.c-sharpcorner.com

code.tutsplus:
https://code.tutsplus.com

gifer:
https://gifer.com/en/YzDG

Crash character:
https://www.pngegg.com/en/png-bxplc

Game background:
https://wallpaperaccess.com/crash-team-racing-nitro-fueled

