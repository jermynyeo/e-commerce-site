<!DOCTYPE html>
<html lang="en">
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    		<!-- animate -->
		<link rel="stylesheet" href="css/animate.min.css">
		<!-- bootstrap -->
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<!-- magnific pop up -->
		<link rel="stylesheet" href="css/magnific-popup.css">
		<!-- font-awesome -->
		<link rel="stylesheet" href="css/font-awesome.min.css">
		<!-- google font -->
		<link href='http://fonts.googleapis.com/css?family=Raleway:400,300,700,800' rel='stylesheet' type='text/css'>
		<!-- custom -->
		<link rel="stylesheet" href="css/style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"
            integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous">
        </script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"
            integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous">
        </script>
        <?php
    $timeStamp = date('Y-m-d');
    #2018-09-15 format produced for projstartdate

if (isset($_GET["productSelected"])){
    $order_list = $_GET["productSelected"];
    $amount = 0;
    $item_temp = array();
    $booking_products = array();
    foreach($order_list as $order){
         #order = 'pro2,8,66.99,SGD,1'
        $order = explode(",",$order);
        $booking_products[] = $order[1];
        $order[0] = str_replace("%20"," ",$order[0]); 
        $item = array("name"=>$order[0], "sku"=>$order[1], "price"=> round($order[2],2), "currency"=>$order[3], "quantity"=>1);
        $item_temp[] = $item;
    }

    $item_list = array();
    $item_list["items"] = $item_temp;
    $item_list = json_encode($item_list);
    //var_dump($item_list);
    $new_order = array();
    #parameters required to create new booking: data["username"], data["comments"], data["productProgress"], data["projStartDate"], data["projEndDate"]) and productisID
    foreach($order_list as $order){
        $new_booking = array("username"=> "temp_value", "comments"=>"Thank you for purchasing", "productProgress" => 0.00,
        "projStartDate" => $timeStamp, "projEndDate"=>$timeStamp);
    }
    // var_dump($new_booking);
    // var_dump($booking_products);
    $booking_details = array("products"=>$booking_products,"username"=>$new_booking["username"],"comments"=>$new_booking["comments"],"productProgress"=>$new_booking["productProgress"],
    "projStartDate"=>$new_booking["projStartDate"],"projEndDate"=>$new_booking["projEndDate"]);
    // var_dump($booking_details);
    $booking_details = json_encode($booking_details);
}
else{
	echo "<script>window.history.go(-1);</script>";
}

?>
    <style>

        .loader {
        border: 16px solid #f3f3f3;
        border-radius: 50%;
        border-top: 16px solid #3498db;
        width: 120px;
        height: 120px;
        -webkit-animation: spin 2s linear infinite; /* Safari */
        animation: spin 2s linear infinite;
        position: absolute;
        left: 46.5%;
        top: 100%;
        transform: translate(-50%, -50%);
        }
        @-webkit-keyframes spin {
        0% { -webkit-transform: rotate(0deg); }
        100% { -webkit-transform: rotate(360deg); }
        }
        @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
        }

        .header {
        padding: 60px;
        text-align: center;
        background: #1abc9c;
        color: white;
        font-size: 30px;
        }


    </style>
</head>
<body>

        <div id="about" style="padding-bottom:0px;">
			<div class="container">

					<div style='text-align:center;display:block;' class="fadeInLeft">
						<h3 id="name">Redirecting To PayPal...</h3>
						<h4>Please wait a moment.. Do not press back!</h4>
                            <div class="loader"></div>
                            
					</div>
			</div>
		</div>

        <script>

            $(async () => {
            

                var newBookingInfo = <?php echo json_encode($booking_details); ?>;
		console.log (typeof newBookingInfo);
                var serviceURL = "http://18.138.255.13:5005/orderRoute";
                var username = sessionStorage.getItem("username");
                newBookingInfo = JSON.parse(newBookingInfo);
                // console.log(username);
                // console.log(newBookingInfo["username"]);
                newBookingInfo["username"] = username;
                // console.log(newBookingInfo["username"]);
                // console.log(newBookingInfo);
                newBookingInfo = JSON.stringify(newBookingInfo);
                console.log(newBookingInfo);
                console.log(typeof newBookingInfo);
                console.log(serviceURL);

                        var requestParam = {
                            headers: { "Content-Type": "application/json"},
                            method: 'POST',
                            mode: "cors",
                            body: newBookingInfo
                        };
                        try {
                            console.log("awaiting response");
                            const response = await fetch(serviceURL, requestParam);
                            json = await response.json();
                            console.log("done");
                            console.log(json);
                            if(json==true){
                                var itemsList = <?php echo json_encode($item_list); ?>;
                                // console.log(itemsList);
                                itemsList = JSON.parse(itemsList);
                                console.log(typeof itemsList) ;
                                console.log(itemsList);
                                itemsList = JSON.stringify(itemsList);
                                window.location.replace("http://13.250.108.137:8000/payment/payment/" + itemsList);
                            }
                        }
                        catch(error){
                            console.log(error);
                        };

            });

        </script>

</body>
</html>
