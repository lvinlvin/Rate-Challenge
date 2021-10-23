<?php
$conn = new mysqli("localhost:3306", "root", "root");
// Check MYSQL connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//Check mysql is work or failed
if (!function_exists('mysqli_init') && !extension_loaded('mysqli')) {
    echo 'We don\'t have mysqli!!!';
} else {
}

//Handle POST Request
if (isset($_POST['submit'])) {
    $timezone = new DateTime("now", new DateTimeZone('Asia/Kuala_Lumpur'));
    $now = $timezone->format('Y-m-d H:i:s');
    $reviewText = $_POST["reviewText"];
    $id = $_COOKIE["id"];
    $rate_star = $_COOKIE["rate_star"];
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
        display: flex;
        padding: 0 20px;
        justify-content: center;
        align-items: center;
    }

    .title {
        font-size: 30px;
        font-weight: bold;
        margin: 20px 0px;
    }

    .rating {
        margin: 20px 0px;
        font-size: 20px;
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
        border: 1px solid grey;
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
        text-align: left;
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


    h1 {
        font-size: 2em;
        margin-bottom: 0.5rem;
    }

    /* Ratings widget */
    .rate {
        display: inline-block;
        border: 0;
    }

    /* Hide radio */
    .rate>input {
        display: none;
    }

    /* Order correctly by floating highest to the right */
    .rate>label {
        float: right;
        color: #ccc;
    }

    /* The star of the show */
    .rate>label:before {
        display: inline-block;
        font-size: 2.8rem;
        padding: 0.3rem 0.5rem;
        margin: 0;
        cursor: pointer;
        font-family: FontAwesome;
        content: "\f005 ";

        /* full star */
    }

    /* Half star trick */
    .rate .half:before {
        content: "\f089 ";
        /* half star no outline */
        position: absolute;
        padding-right: 0;
    }

    /* Click + hover color */
    input:checked~label,
    /* color current and previous stars on checked */
    label:hover,
    label:hover~label {
        color: #ffcc36;
    }

    /* color previous stars on hover */

    /* Hover highlights */
    input:checked+label:hover,
    input:checked~label:hover,
    /* highlight current and previous stars */
    input:checked~label:hover~label,
    /* highlight previous selected stars for new rating */
    label:hover~input:checked~label

    /* highlight previous selected stars */
        {
        color: #ffcc36;
    }

    @media only screen and (max-width: 900px) {
        body {
            margin: 20px;
        }
    }
</style>

<body>


    <form action="" method="POST" id="submit_infor">
        <div class="title">What's your rating</div>
        <div class="rating">Rating</div>

        <div class='rating-stars text-center'>
            <fieldset class="rate" id="star_select">
                <input type="radio" id="rating10" name="rating" value="10" /><label for="rating10" title="5 stars"></label>
                <input type="radio" id="rating9" name="rating" value="9" /><label class="half" for="rating9" title="4 1/2 stars"></label>
                <input type="radio" id="rating8" name="rating" value="8" /><label for="rating8" title="4 stars"></label>
                <input type="radio" id="rating7" name="rating" value="7" /><label class="half" for="rating7" title="3 1/2 stars"></label>
                <input type="radio" id="rating6" name="rating" value="6" /><label for="rating6" title="3 stars"></label>
                <input type="radio" id="rating5" name="rating" value="5" /><label class="half" for="rating5" title="2 1/2 stars"></label>
                <input type="radio" id="rating4" name="rating" value="4" /><label for="rating4" title="2 stars"></label>
                <input type="radio" id="rating3" name="rating" value="3" /><label class="half" for="rating3" title="1 1/2 stars"></label>
                <input type="radio" id="rating2" name="rating" value="2" /><label for="rating2" title="1 star"></label>
                <input type="radio" id="rating1" name="rating" value="1" /><label class="half" for="rating1" title="1/2 star"></label>

            </fieldset>
        </div>

        <div class="rating">Review</div>
        <div>
            <textarea id="reviewText" name="reviewText" rows="4" cols="50" placeholder="Start Typing"></textarea>
        </div>
        <div style="margin:20px 0px;">
            <button type="submit" name="submit" id="submit" class="set_button">Submit Review</button>
        </div>
    </form>

    <script>
        var total_rate = 0;
        var total_hal_rate = 0;
        var checkvalidstar = true;
        var checkvalidtext = true;
        $(document).ready(function() {
            /* Action to perform on click to set rating Star */
            $('#star_select').on('click', function() {
                var ele = document.getElementsByName('rating');
                for (i = 0; i < ele.length; i++) {
                    if (ele[i].checked) total_hal_rate = parseInt(ele[i].value) / 2;
                    // console.log(total_hal_rate);
                }
            });
        });

        //Validation check form
        function submitForm() {
            if (total_hal_rate == 0){ checkvalidstar = false;
                alert("Please Select Star");
            }else checkvalidstar = true;
            if ($("#reviewText").val().trim().length < 1) {
                alert("Please Enter Text...");
                checkvalidtext = false;
                return;
            }else checkvalidtext = true;

        }

        //form Submit click
        $('#submit').on('click', function() {
            submitForm();
            if (checkvalidstar && checkvalidtext) {
                document.cookie = escape("rate_star") + "=" +
                    escape(total_hal_rate);
                $('#submit_infor').submit();
            } else {
                return false;
            }

        });
    </script>

</body>

</html>