<!DOCTYPE html>
<html lang="en">

<head>
	<title>Receipt</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <head>
        <title>Login V6</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!--===============================================================================================-->
        <link rel="icon" type="image/png" href="images/icons/favicon.ico" />
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="css/util.css">
        
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" type="text/css" href="css/main.css">
        <!--===============================================================================================-->
        <style type='text/css'>

                
         #itemsTable{
          
            }
        

        table {
        margin:auto;
        border-collapse: collapse;
        width: 70%;
        padding:10px;
        margin-top:5%;
        margin-bottom:5%;
        }

        th, td {
        text-align: center;
        padding: 8px;
        }

        tr:nth-child(even) {background-color: #f2f2f2;}

        body {
        opacity: 1;
        transition: 0.7s opacity;
        }

        body.fade {
            opacity: 0;
            transition: none;
        }

        </style>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>

        <script src="js/tabsSearch.js"></script>
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Roboto'>
        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    </head>
</head>

<body>



    <script>


    
      var paymentId = "<?php echo $_GET['paymentId']; ?>";
  var username = sessionStorage.getItem("username")
    var purpose = "pass";
        var bookingid = ''
        var email = '';
        var allid =[];
        var bookingid = '';

    $(async () => {
        
        var serviceURL = "http://13.250.108.137:8000/payment/itemsbought/" + paymentId;
        var serviceURL2 = "http://13.250.108.137:8000/customer/user";
        var serviceURL3 = "http://13.250.108.137:8000/handleorders/productprogress/" + username;
		  
          try{
        var allid = [];
      const responseBookingID =
            await fetch(serviceURL3, {
                method: 'GET',
                mode: 'cors'
            });
            const allbookingofuser = await responseBookingID.json();
            for(const bookings in allbookingofuser.UserBookings){
                var booking = allbookingofuser.UserBookings[bookings];
                allid.push(booking.bookingID)
                console.log(allid)
              
          }

      }catch (error) {
                  console.log(error);
                  return error;

                }
                
          var bookingid = allid[allid.length - 1];
           console.log(bookingid)
            //console.log(serviceURL2 + username)
      var email = '';
      
        try{
            const response =
                  await fetch(serviceURL2, {
                      method: 'GET',
                      mode: 'cors'
                  });

              const allusers = await response.json();
                

              for(const eachuser in allusers.users){

                  var user = allusers.users[eachuser];

                  if(user.username == username ){

                   var email = user.email;
                  }

              }
        }catch (error) {
                  console.log(error);
                  return error;

                }

        
        var serviceurl4 = "http://18.138.255.13:5005/sendnoti/" + purpose  +"/" + email + "/" + bookingid ;
      
        try{
                    const response =
                          await fetch(serviceurl4, {
                              method: 'GET',
                              mode: 'cors'
                          });

                      const sendnoti = await response.text();

          }catch (error) {
                  console.log(error);
                  return error;

                }


        //   console.log(bookingid)
        //   console.log(email)

        console.log(serviceURL);
        try {
            const response =
                await fetch(serviceURL, {
                    method: 'GET',
                    mode: 'cors'
                });
            const data = await response.json();

            var initial = " <div class='col-md-12 wow bounce'><h2 id='crowd'><i>Payment Receipt</i></h2></div><div style='text-align:center;width:100%;' class='w3-container'><h4><i>Payment Information</i></h4></div><div style='width:100%;clear:both;display:block;'><table id='itemsTable'><tr><th style='width:50%'>Product Name</th><th style='width:50%'>Price</th></tr></table><a id='linkBack'><button id='socialmediabtn' class='btn btn-warning'>Back to Home</button></a></div>"
            $("#categories").append(initial)

            for (const x in data.item_list) {
                var temp = data.item_list[x];

                var final = temp.split("'").join("\"");
                console.log(final);
                var data_object = JSON.parse(final);
                console.log(data_object["name"]);


                if (!data_object || !data_object) {
                    showError('Sorry error')
                } else {



                    var rows = "";
                    eachRow =
                        "<td>" + data_object["name"] + "</td>" +
                        "<td>" + data_object["price"] + "</td>";
                    rows += "<tr>" + eachRow + "</tr>";
                    $('#itemsTable').append(rows);
                }


            }


            username = sessionStorage.getItem("username");
            console.log(username);
            $("#linkBack").attr("href", "indexlogin.html?user=" + username);
        } catch (error) {
            console.error(error);
        }



    });// aysnc 


        //   console.log(bookingid)


    </script>

    <!-- start pricing -->

    
    <div id="pricing" style='margin-top:10%;' class="text-center" data-wow-delay="5s">
        <div class="container">
            <div id='categories' class="row text-center w3-panel w3-card-4 w3-container w3-center w3-animate-top">
            
            </div>
        </div>
    </div>
    <!-- end pricing -->



</body>


<script>

    
   
</script>

</html>