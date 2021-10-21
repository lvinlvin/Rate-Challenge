<?php
$conn = new mysqli("localhost:3306", "root", "root");
// Check connection
if ($conn->connect_error) {
   die("Connection failed: " . $conn->connect_error);
}

if (!function_exists('mysqli_init') && !extension_loaded('mysqli')) {
   echo 'We don\'t have mysqli!!!';
} else {
   // echo "here";
   $mysqlNew = "SELECT * FROM ratechallenge.item";
   //AND mra_password='" . $admin_password . "'
   $resultNewLocation = $conn->query($mysqlNew);
   if ($resultNewLocation->num_rows > 0) {
      //  echo "here";
      $getitem = [];
      while ($row = $resultNewLocation->fetch_assoc()) {
         $itemob = array(
            "id" => $row["id"],
            "name" => $row["name"],
         );
         // echo $row["name"];
         array_push($getitem, $itemob);
      }
   }

   $queryReview = "SELECT * FROM ratechallenge.rate";
   $resultReview = $conn->query($queryReview);
   if ($resultReview->num_rows > 0) {
      $getReview = [];
      while ($row = $resultReview->fetch_assoc()) {
         $itemob = array(
            "star" => $row["star"],
            "review" => $row["review"],
            "item_id" => $row["item_id"],
         );
         // echo $row["name"];
         array_push($getReview, $itemob);
      }
   }
}
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
      text-align: center;
      font-size: 30px;
      font-weight: bold;
      margin: 14px;
   }

   .row {
      display: flex;
      justify-content: space-around;
   }

   .total_rate {
      font-size: 28px;
   }

   .setButton {
      border: 1px solid;
      display: flex;
      justify-content: center;
      align-items: center;
      width: 100px;
      border-radius: 6px;
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

   .new-react-version {
      padding: 20px 20px;
      border: 1px solid #eee;
      border-radius: 20px;
      box-shadow: 0 2px 12px 0 rgba(0, 0, 0, 0.1);

      text-align: center;
      font-size: 14px;
      line-height: 1.7;
   }

   .new-react-version .react-svg-logo {
      text-align: center;
      max-width: 60px;
      margin: 20px auto;
      margin-top: 0;
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
</style>

<body>


   <?php foreach ($getitem as $value) {
   ?>
      <div class="title"><?php echo $value["name"] . "</br>"; ?></div>
      <div class="row">
         <div style="display:flex;">
            <div class="total_rate">0.0</div>
            <div style="width:10px;"></div>
            <div class='rating-stars text-center'>
               <ul id='stars'>
                  <li class='star' title='Poor' data-value='1'>
                     <i class='fa fa-star fa-fw'></i>
                  </li>
                  <li class='star' title='Fair' data-value='2'>
                     <i class='fa fa-star fa-fw'></i>
                  </li>
                  <li class='star' title='Good' data-value='3'>
                     <i class='fa fa-star fa-fw'></i>
                  </li>
                  <li class='star' title='Excellent' data-value='4'>
                     <i class='fa fa-star fa-fw'></i>
                  </li>
                  <li class='star' title='WOW!!!' data-value='5'>
                     <i class='fa fa-star fa-fw'></i>
                  </li>
               </ul>
            </div>
         </div>

         <div class="setButton" onclick="goAddReview('<?php echo $value['id'] ?>');">Add Review</div>
      </div>
      <?php
      if (count($getReview) > 0) {
      } ?>
      <div>
         <div>Review</div>
         <?php
         foreach ($getReview as $val) {
            if ($val["item_id"] == $value["id"]) {
               $unStar = 5 - $val["star"];
               // echo $unStar;
         ?>
               <div class='rating-stars text-center'>
                  <ul id='stars'>
                     <?php
                     for ($i = 0; $i < $val["star"]; $i++) {
                     ?>
                        <li class='star selected'>
                           <i class='fa fa-star fa-fw'></i>
                        </li>
                     <?php
                     }
                     for ($j = 0; $j < $unStar; $j++) {
                     ?>
                        <li class='star'>
                           <i class='fa fa-star fa-fw'></i>
                        </li>
                     <?php
                     }
                     ?>
                       <!-- <li class='star selected'>
                           <i class='fa fa-star-half-full fa-fw'></i>
                        </li> -->
                  </ul>
               </div>
         <?php
            }
         } ?>
      </div>

   <?php
   }
   ?>


   <div>
   </div>
   <script>
      $(document).ready(function() {




      });

      function goAddReview(title) {
         document.cookie = escape("id") + "=" +
            escape(title);
         location.href = "review.php";
      }
   </script>

</body>

</html>