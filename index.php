<?php
header("Access-Control-Allow-Origin: *");
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8" />
   <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

   <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
   <meta name="viewport" content="width=device-width" />

   <title>Rate Challenge</title>

   <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />

   <!--     Fonts     -->
   <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
   <link href='https://fonts.googleapis.com/css?family=Grand+Hotel' rel='stylesheet' type='text/css'>
   <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.3.2/socket.io.min.js" crossorigin="anonymous"></script>
</head>
<style>
   body {
      font-family: "Open Sans", Helvetica, Arial, sans-serif;
      color: #555;
      max-width: 680px;
      margin: 0 auto;
      padding: 0 20px;
   }

   .title {
      font-size: 38px;
      font-weight: bold;
      margin: 20px 0px;
   }

   .setRow {
      width: 600px;
   }

   .total_rate {
      font-size: 28px;
      font-weight: bold;
   }

   .setButton {
      border: 1px solid;
      display: flex;
      justify-content: center;
      align-items: center;
      width: 150px;
      height: 38px;
      border-radius: 6px;
      float: right;
      cursor: pointer;
   }

   .review_row {
      display: flex;
      margin: 6px 0px;
   }

   .review_title {
      font-size: 24px;
      margin: 20px 0px;
      font-weight: bold;
   }

   .review_total {
      display: flex;
      align-items: center;
      font-size: 20px;
   }

   * {
      -webkit-box-sizing: border-box;
      -moz-box-sizing: border-box;
      box-sizing: border-box;
   }

   *:before,
   *:after {
      -webkit-box-sizing: border-box;
      -moz-box-sizing: border-box;
      box-sizing: border-box;
   }

   .clearfix {
      clear: both;
   }

   .text-center {
      text-align: center;
   }

   a {
      color: tomato;
      text-decoration: none;
   }

   a:hover {
      color: #2196f3;
   }

   pre {
      display: block;
      padding: 9.5px;
      margin: 0 0 10px;
      font-size: 13px;
      line-height: 1.42857143;
      color: #333;
      word-break: break-all;
      word-wrap: break-word;
      background-color: #f5f5f5;
      border: 1px solid #ccc;
      border-radius: 4px;
   }

   .header {
      padding: 20px 0;
      position: relative;
      margin-bottom: 10px;
   }

   .header:after {
      content: "";
      display: block;
      height: 1px;
      background: #eee;
      position: absolute;
      left: 30%;
      right: 30%;
   }

   .header h2 {
      font-size: 3em;
      font-weight: 300;
      margin-bottom: 0.2em;
   }

   .header p {
      font-size: 14px;
   }

   #a-footer {
      margin: 20px 0;
   }

   /* Rating Star Widgets Style */
   .rating-stars ul {
      list-style-type: none;
      padding: 0;

      -moz-user-select: none;
      -webkit-user-select: none;
      margin-bottom: 0px;
   }

   .rating-stars ul>li.star {
      display: inline-block;
   }

   /* Idle State of the stars */
   .rating-stars ul>li.star>i.fa {
      font-size: 2.5em;
      /* Change the size of the stars */
      color: #ccc;
      /* Color on idle state */
   }

   /* Hover state of the stars */
   .rating-stars ul>li.star.hover>i.fa {
      color: #ffcc36;
   }

   /* Selected state of the stars */
   .rating-stars ul>li.star.selected>i.fa {
      color: #ff912c;
   }

   /* Selected state of the stars */
   .rating-stars ul>li.star.half>i.fa {
      content: '\2605';
      color: gold;
      position: absolute;
      margin-left: -20px;
      width: 10px;
      overflow: hidden;
   }

   @media only screen and (max-width: 900px) {
      body {
         max-width: 100vw;
         padding: 0px;
      }
   }
</style>

<body>

   <div>
      <div id="title_show"></div>
   </div>


   <script>
      // start socket
      var socket = io('http://localhost:2500', {
         secure: true,
         transports: ['websocket', 'polling']
      });



      $(document).ready(function() {
         // load_data();
      });

      //Call API to get the lastest data with real-time and also generate the front-end webview
      load_data = () => {
         $.get("http://localhost:3100/item/getAllItem", function(data, status) {

            var displayTitle = "";
            var showItemId = [];
            var showItem = [];
            var totalReview = [];
            var totalStar = [];
            var totalReviewValue = [];
            var totalStarValue = [];
            var getData = data["data"]["result"];

            //Put Return API name and item_id to a Array
            for (var i = 0; i < getData.length; i++) {
               showItem.push(getData[i]["name"]);
               showItemId.push(getData[i]["item_id"]);
            }
            //Filter the duplicate name and item_id
            var unique = showItem.filter(function(itm, i, a) {
               return i == showItem.indexOf(itm);
            });
            var uniqueid = showItemId.filter(function(itm, i, a) {
               return i == showItemId.indexOf(itm);
            });

            //Split the Return API data into multiple Array 
            for (var i = 0; i < unique.length; i++) {
               var total_dataStar = 0.0;
               var totalAllReview = 0;
               var ReviewValue = [];
               var StarValue = [];
               for (var j = 0; j < getData.length; j++) {
                  if (unique[i] == getData[j]["name"]) {
                     if (getData[j]["star"] != null) {
                        total_dataStar += parseFloat(getData[j]["star"]);
                        totalAllReview++;
                     }

                     if (getData[j]["review"] != null) ReviewValue.push(getData[j]["review"]);
                     if (getData[j]["star"] != null) StarValue.push(getData[j]["star"]);

                  }
               }

               totalStar.push(total_dataStar);
               totalReview.push(totalAllReview);
               totalReviewValue.push(ReviewValue);
               totalStarValue.push(StarValue);

            }


            //Start to create a webview
            for (var i = 0; i < unique.length; i++) {

               var showingRate = 0;
               var unStar = 0;
               var Stared = 0;
               var halfS = 0;
               var total_Star = totalStar[i];

               var total_Review = totalReview[i];
               //Check the totalReview is that more that one and check halfstar generate for the Total Rating Point and Star
               if (parseInt(total_Review) >= 1) {
                  showingRate = (total_Star / total_Review).toFixed(1);
                  if (showingRate % 1) {
                     unStar = 4 - parseInt(showingRate);
                     Stared = 4 - parseInt(unStar);
                     halfS += 1;
                  } else {
                     unStar = 5 - parseInt(showingRate);
                     Stared = 5 - parseInt(unStar);
                  }

               } else {
                  showingRate = parseInt(total_Star);
                  Stared = parseInt(total_Star);
                  unStar = 5 - parseInt(Stared);
               }

               //store name and item_id
               var name = unique[i];
               var getid = uniqueid[i];
               if (name == "Hyundai") console.log(total_Review);
               //Show the Name of product
               displayTitle += '<div style="margin:40px 0px;border: 1px solid black;padding: 30px; width: 680px;"><div class="title">' + name + '</div>';
               displayTitle += '<div class="setRow"><div style="display:flex; float:left;">';
               //To display with full star or halfstar also if empty
               if (parseInt(total_Review) > 0) {
                  displayTitle += '<div class="total_rate" id="total_rate">' + showingRate + '</div>';
                  displayTitle += '<div style="width:20px;"></div><div class="rating-stars text-center"><ul id="stars">';
                  for (var j = 0; j < Stared; j++) {
                     displayTitle += "<li class='star selected'>  <i class='fa fa-star fa-fw'></i> </li>";
                  }
                  for (var j = 0; j < halfS; j++) {
                     displayTitle += "<li class='star selected'>  <i class='fa fa-star-half-full fa-fw'></i> </li>";
                  }
                  for (var k = 0; k < unStar; k++) {
                     displayTitle += " <li class='star'> <i class='fa fa-star fa-fw'></i></li>";
                  }
               } else {
                  displayTitle += '<div class="total_rate" id="total_rate">0.0</div>';
                  displayTitle += '<div style="width:20px;"></div><div class="rating-stars text-center"><ul id="stars">';
                  for (var k = 0; k < 5; k++) {
                     displayTitle += " <li class='star'> <i class='fa fa-star fa-fw'></i></li>";
                  }
               }

               displayTitle += "  </ul> </div> </div>";
               displayTitle += ' <div class="setButton" onclick="goAddReview(' + getid + ');">Add Review</div>';
               displayTitle += '</div><div style="clear: both;"></div>';
               //Generate Total Review of the item at below 
               if (parseInt(total_Review) > 0) {
                  displayTitle += '<hr> <div class="review_title">Reviews</div>';

                  for (var j = 0; j < totalReviewValue[i].length; j++) {
                     var getR = totalReviewValue[i][j];
                     var getS = totalStarValue[i][j];
                     var countS = getS;
                     var unstar = 0;
                     var halfstar = 0;
                     if (getS % 1) {
                        halfstar++;
                        unstar = 4 - getS;
                        countS--;

                     } else {
                        unstar = 5 - getS;
                     }

                     displayTitle += '<div class="review_row"><div class="rating-stars text-center"><ul id="stars">';
                     for (var k = 0; k < countS; k++) {
                        displayTitle += '<li class="star selected"><i class="fa fa-star fa-fw"></i></li>';
                     }
                     if (halfstar != 0) {
                        displayTitle += '<li class="star selected"><i class="fa fa-star-half-full fa-fw"></i></li>';
                     }
                     for (var l = 0; l < unstar; l++) {
                        displayTitle += '<li class="star"><i class="fa fa-star fa-fw"></i></li>';
                     }
                     displayTitle += '</ul> </div><div style="width:20px;"></div>';

                     displayTitle += '<div class="review_total">' + getS + ', ' + getR + '</div></div>';

                  }

               }

               displayTitle += "</div>";
            }
            $("#title_show").html(displayTitle);
         });

      }

      //go to page AddReview
      function goAddReview(title) {
         //put into cookie
         document.cookie = escape("id") + "=" + escape(title);
         location.href = "review.php";
      }

      //Listening websocket to get real-time data
      socket.emit("listening");

      //If get request update it, real-time
      socket.on("add_review", (data) => {
         load_data();

      })
   </script>

</body>

</html>