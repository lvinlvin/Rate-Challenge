<h1>CREATE a Rate Challenge front-end</h1>

First at all, I'm using Window 10 for this project.</br>
You have to install XAMPP into your Window and start the Apache Server port to continue this project and also install MYSQL to your Window as well.

Create index.php as a default page of html.</br>
-Create a design same as the Rating Challenge, display product rating using jQuery.</br>
-Calculate the total rating of product and divide with the total review to get the Total Rating Score.</br>
-Display Half Star if the Total Rating got Decimal place.</br>
-Add a button "Add Review" to another page "review" to submit written reviews along with a 5-star rating.</br>
-Display the Reviews below the product if the product got review.</br>
-If another page submit the rating, will have real-time update.</br>
-Using WebSocket to listening rating real-time.</br>

Create review.php to submit written reviews along with a 5-star rating</br>
-Create a design same as Rating Challenge.</br>
-Using MYSQL to store the information.</br>
-Can Select Half Star and Full Star to submit form.</br>
-Update the data at here using MySQL.</br>

In this project the most challenging part is displaying rating real-time, the solution that I can think of is using Websocket to keep listening to the port to update the Webview.
This is my first time that to deal with this real-time update data. Previously just got knowledge at the one on one chat at college.
To support half-star selection is also a big challenge to me because need checks the click that we select.

<h3>Architectural decisions </h3>
At first, I plan to use workerman and phpsocket.io plugin as WebSocket that easily I use one PHP to do all conditions but when I try to see the documentation inside the GitHub, it does not have much information that GitHub provides me to use this plugin on Window.
After that, I decide to use NodeJS as WebSocket and also REST API Request. I try to make multiple products to display and show the Review. In this part, I try lots of conditions to handle this.

If asking me what I will do differently next time around, it will be at the handle to display the UI to show total Rate, total Star, Product Review for multiple Products.
I will not be using too much For to filter the return API data and try to use another solution to solve this kind of problem that I didn't have any idea about for now.


Database Detail</br>
Schemas </br>
·ratechallenge

Generate TABLE
CREATE TABLE `ratechallenge`.`item` (
  `id` BIGINT NOT NULL,
  `name` LONGTEXT NULL,
  `active` LONGTEXT NULL,
  PRIMARY KEY (`id`));

CREATE TABLE `ratechallenge`.`rate` (
`id` BIGINT NOT NULL,
`star` LONGTEXT NULL,
`review` LONGTEXT NULL,
`item_id` LONGTEXT NULL,
`created_at` DATETIME NULL,
PRIMARY KEY (`id`));

Table 'item' column 'active' is to display or hide the product at Front-end.




