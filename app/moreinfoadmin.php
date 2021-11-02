<!DOCTYPE html>
<html lang="en">

<head>
	<title>Admin Page - More Info</title>
    <style>
    li {
        text-transform: capitalize;

    }

    #page-container {
        position: relative;
        min-height: 100vh;
    }

    #content-wrap {
        padding-bottom: 2.5rem;
        /* Footer height */
    }

    #footer {
        position: absolute;
        bottom: 0;
        width: 100%;
        height: 2.5rem;
        /* Footer height */
    }
    </style>
    <script>
    var getParams = function(url) {
        var params = {};
        var parser = document.createElement('a');
        parser.href = url;
        var query = parser.search.substring(1);
        var vars = query.split('&');
        for (var i = 0; i < vars.length; i++) {
            var pair = vars[i].split('=');
            params[pair[0]] = decodeURIComponent(pair[1]);
        }
        return params;
    };
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"
        integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"
        integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous">
    </script>

    <meta charset="utf-8">

    <title>B.Y IT solutions</title>

    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="">
    <meta name="description" content="">

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

    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

</head>

<body data-spy="scroll" data-offset="50" data-target=".navbar-collapse">

<script>
   // retrieve particular info 

   var url = new URL(window.location.href);
    var bookingID = url.searchParams.get("bookingID");

    // email   
    var customername = url.searchParams.get("customername");
        console.log(customername)


    // pass email

    $(async () => {
        // Change serviceURL to your own
        var serviceURL = "http://13.250.108.137:8000/handleorders/vieworders/" + bookingID;
        // console.log(serviceURL)

        try {
            const response =
                await fetch(serviceURL, {
                    method: 'GET'
                });
            const data = await response.json();
            if (!data || data.length < 1) {

            } else {

                $("#bookingname").html(data.bookingID);
                // start end date 
                $("#startdate").html(data.projStartDate);
                $("#enddate").html(data.projEndDate);
                // Product Progress
                $("#hiddenid").val(data.bookingID);
                $("#progress").val(data.productProgress);
                // Progress bar 
                $("#greenbar").attr("aria-valuenow", data.productProgress.toString());
                $("#greenbar").css("width", data.productProgress.toString() + "%");
                // text area
                $("#textareaComments").val(data.comments);
                $("#solutionProducts").append(printrow);

                



            }

        } catch (error) {
            showError
                ('There is a problem retrieving books data, please try again later.<br />' + error);
        }


 



    });</script>


    <div id="page-container">
        <div id='content-wrap'>
            <div id='about' class='w3-card-4' style='margin-top:10%;padding-bottom:5%;'>
                <div class='container'>
                    <div class='row' id='solutionProducts' style='font-size:20px;'>
                        <div class='w3-container'>
                                <div class='col-md-6 col-sm-6 wow fadeInLeft'>
                                    <h3 id='name'> More Info</h3>
                                    <h2>Booking ID <b id='bookingname'>Fetching Data...</b></h2><br />

                                    <!--Start date and end Date-->
                                    <p><span><b>Start Date :</b><i id='startdate'>Fetching Data...</i>
                                            <br><b>End Date :</b><i id='enddate'>Fetching Data...</i>


                                            <!--Set the value of the progress-->
                                            <!--Get the value of booking id -->
                                            <input type='hidden' id='hiddenid' value='158'>
                                            
                                            <input type='hidden' id='emailid' value=''>
                                            </i><br>
                                            
                                            <ul id='error'></ul><br>
                                            <p>Project Progress: <b> <input type='number' min='0' max='100' id='progress'
                                                        value='Fetching Data...'>

                                                    <!--Progress bar -->
                                                </b></p>
                                        </span>
                                        <div class='progress'>
                                            <div id='greenbar' class='progress-bar progress-bar-danger'
                                                role='progressbar' aria-valuenow='' aria-valuemin='0'
                                                aria-valuemax='100' style='width:0;'></div>
                                        </div>

                                        <p><i>Comments:</i></p>
                                        <textarea id='textareaComments' rows='4' cols='85'>Fetching Data...</textarea>

                                       

                                       <button  type="button" id='linkBack2' id='socialmediabtn'
                                                class='btn btn-warning' >Update me</button> <p id='updatedone'></p>
 

                            </br>
                        </div>
                    </div>


                </div>
            </div>
        </div>
        <!-- end cart -->


		<script>


       

    $('#linkBack2').click(function() {

        var bookingid = $("#hiddenid").val();
        var progress = $("#progress").val();
        var comments = $("#textareaComments").val();                  
        var customername = url.searchParams.get("customername");

        if(progress > 100 || progress < 0){
            // error 
            var row  = "<li>Max Progress is 100% or 0%</li>"
            $("#error").append(row)
        }else{

            if(progress == 100){
                updateProducts(bookingid);
            }            
            updateProgress(bookingid, progress, comments);
            emailcust("updated");

        }

    });

   async function emailcust(purpose){

    var serviceURL2 = "http://13.250.108.137:8000/customer/user";
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

                if(user.username == customername ){

                 var email = user.email;


                }

            }

      }catch (error) {
                console.log(error);
                return error;

              } 


    var bookingID = url.searchParams.get("bookingID");
    var serviceurl4 = "http://18.138.255.13:5005/sendnoti/" + purpose  +"/" + email + "/" + bookingID ;
      
      try{
                  const response =
                        await fetch(serviceurl4, {
                            method: 'GET',
                            mode: 'cors'
                        });

                    const sendnoti = await response.text();
		    console.log(sendnoti);

        }catch (error) {
                console.log(error);
                return error;

              }

    }



    async function updateProducts(bookingid) {

        var serviceURL6 = "http://13.250.108.137:8000/handleorders/updateproducts/" + bookingid;

        try {
            const response =
                await fetch(serviceURL6, {
                    method: 'GET',
                    mode: 'cors'
                });
            const data = await response.json();
                
            console.log(data);

        } catch (error) {
        
            console.log ("There is a problem retrieving books data, please try again later." + error);
        }

    }

    
    async function updateProgress(bookingid, progress, comments) {

        // change this to update pass the post data 
        // comments

        var serviceURL = "http://13.250.108.137:8000/handleorders/updateorders/" + bookingid + "/" + progress + '/' + comments;

        try {
            const response =
                await fetch(serviceURL, {
                    method: 'GET'
                });
            const data = await response.json();
            console.log(data['msg'])

            if(data['msg'] == "true"){
                $("#updatedone").text("Update Success")
            }else{
                $("#updatedone").text("Update Fail")
            }

        } catch (error) {

            console.log ("There is a problem retrieving books data, please try again later." + error);
            return FALSE;
        }

    }
    </script>





        </br></br></br>
    </div>
    <!-- start footer -->
    <footer id='footer'>
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-sm-8">
                    <p>Copyright &copy; 2020 B.Y Company</p>
                </div>
                <div class="col-md-4 col-sm-2">
                    <ul class="social-icon">
                        <li><a href="#" class="fa fa-facebook"></a></li>
                        <li><a href="#" class="fa fa-twitter"></a></li>
                        <li><a href="#" class="fa fa-instagram"></a></li>
                        <li><a href="#" class="fa fa-pinterest"></a></li>
                        <li><a href="#" class="fa fa-google"></a></li>
                        <li><a href="#" class="fa fa-github"></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    </div>

    <!-- end footer -->


    <!-- jQuery -->
    <script src="js/jquery.js"></script>
    <!-- bootstrap -->
    <script src="js/bootstrap.min.js"></script>
    <!-- isotope -->
    <script src="js/isotope.js"></script>
    <!-- images loaded -->
    <script src="js/imagesloaded.min.js"></script>
    <!-- wow -->
    <script src="js/wow.min.js"></script>
    <!-- smoothScroll -->
    <script src="js/smoothscroll.js"></script>
    <!-- jquery flexslider -->
    <script src="js/jquery.flexslider.js"></script>
    <!-- Magnific Pop up -->
    <script src="js/jquery.magnific-popup.min.js"></script>
    <!-- custom -->
    <script src="js/custom.js">
    </script>
</body>

</html>