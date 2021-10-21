<?php
$conn = new mysqli("localhost:3306", "root", "root");
// Check connection
if ($conn->connect_error) {
   die("Connection failed: " . $conn->connect_error);
}

if (!function_exists('mysqli_init') && !extension_loaded('mysqli')) {
   echo 'We don\'t have mysqli!!!';
} else {

}

if (isset($_POST['submit'])) {
    $timezone = new DateTime("now", new DateTimeZone('Asia/Kuala_Lumpur'));
    $now = $timezone->format('Y-m-d H:i:s');
    $reviewText = $_POST["reviewText"];
    $id = $_COOKIE["id"];
    $rate_star = $_COOKIE["rate_star"];
    // echo $p1 . " " . $getName . " " . $form_data;
    // $p2 = $_POST["p2"];
    // $pile = $_POST["pile"];
    // $form_data = $_COOKIE["rate_star"];
    $sql = "INSERT INTO ratechallenge.rate(star,review,item_id,created_at) VALUE('$rate_star', '$reviewText', '$id','$now')";

    if (!$conn->query($sql)) {
        echo "fail";
        // printError('Fail to create quotation');
    } else {
        $check = $conn->insert_id;
        $conn->close();
          header('Location: index.php');
        exit;
        header("Refresh: 0"); // here 0 is in seconds
    }
}
?>

<html>

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

    .rating {
        text-align: center;
        margin: 20px;
        font-size: 16px;
    }

    .setButton {
        border: 1px solid;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 200px;
        height: 40px;
        border-radius: 3px;
    }

    .set_button {
        width: 160px;
        background-color: white;
        border-radius: 4px;
        height: 40px;
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
</style>

<body>


    <form action="" method="POST" id="submit_infor">
        <div class="title">What's your rating</div>
        <div class="rating">Rating</div>

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

        <div>Review</div>
        <div>
            <textarea id="reviewText" name="reviewText" rows="4" cols="50"></textarea>
        </div>
        <div>
            <button type="submit" name="submit" id="submit" class="set_button">Submit Review</button>
        </div>

        <!-- <div class="setButton" onclick="submitReview()">Submit Review</div> -->

    </form>




    <div>
    </div>
    <script>
        var total_rate = 0;
        $(document).ready(function() {

            /* 1. Visualizing things on Hover - See next part for action on click */
            $('#stars li').on('mouseover', function() {
                var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on

                // Now highlight all the stars that's not after the current hovered star
                $(this).parent().children('li.star').each(function(e) {
                    if (e < onStar) {
                        $(this).addClass('hover');
                    } else {
                        $(this).removeClass('hover');
                    }
                });

            }).on('mouseout', function() {
                $(this).parent().children('li.star').each(function(e) {
                    $(this).removeClass('hover');
                });
            });


            /* 2. Action to perform on click */
            $('#stars li').on('click', function() {
                var onStar = parseInt($(this).data('value'), 10); // The star currently selected
                total_rate = onStar;
                var stars = $(this).parent().children('li.star');

                for (i = 0; i < stars.length; i++) {
                    $(stars[i]).removeClass('selected');
                }

                for (i = 0; i < onStar; i++) {
                    $(stars[i]).addClass('selected');
                }

                // JUST RESPONSE (Not needed)
                // var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);
                var msg = "";
                // responseMessage(msg);

            });


        });

        $('#submit').on('click', function() {
            document.cookie = escape("rate_star") + "=" +
                escape(total_rate);
            $('#submit_infor').submit();
        });

        function submitReview() {

            // var x = document.getElementById("reviewText").value;

            // console.log(x + total_rate);
            // const queryString = window.location.search;

            // const urlParams = new URLSearchParams(queryString);

            // const page_type = urlParams.get('title')

            // console.log(page_type);

        }
    </script>

</body>

</html>