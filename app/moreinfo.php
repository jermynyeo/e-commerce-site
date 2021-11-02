<!DOCTYPE html>
<html lang="en">
	<head>
	<title>Admin Page</title>
		<style>
		li {
  text-transform: capitalize;
  
  }

    #page-container {
      position: relative;
      min-height: 100vh;
    }

    #content-wrap {
      padding-bottom: 2.5rem;    /* Footer height */
    }

    #footer {
      position: absolute;
      bottom: 0;
      width: 100%;
      height: 2.5rem;            /* Footer height */
    }
		</style>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"
			integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut"
			crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"
			integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
			crossorigin="anonymous"></script>	

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

    

		

  <div id="page-container" >
    
    </div>
		<!-- end cart -->

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

    <script>
    // retrieve particular info 
   
    var url = new URL(window.location.href);
    var bookingID = url.searchParams.get("bookingID");
    console.log(bookingID)
    
    $(async() => {           
			// Change serviceURL to your own
			var serviceURL = "http://13.250.108.137:8000/handleorders/vieworders/" + bookingID ;
            try {
            const response =
             await fetch(serviceURL, { method: 'GET' });
            const data = await response.json();
            // console.log(data)
            //console.log(data.bookingID)

            if (!data || data.length < 1) {
               
            } else {

                var printrow1 = "<div id='content-wrap' ><div id='about' class='w3-card-4' style='margin-top:10%;padding-bottom:5%;'><div class='container'><div class='row' id='solutionProducts' style='font-size:20px;' ></div></div>"
                $("#page-container").append(printrow1)


				var printrow = 
				"<div class='w3-container'><div class='col-md-6 col-sm-6 wow fadeInLeft'><h3 id='name'> More Info</h3><h2><b>Booking ID : " + data.bookingID +"</b></h2><br/>";
                printrow = printrow + "<p><span><b>Start Date :</b><i>" + data.projStartDate +  "</i><br><b>End Date :</b><i>  " + data.projEndDate + "</i><br><p>Project Progress: <b>" + data.productProgress  + "</b>%</p></span><div class='progress'><div class='progress-bar progress-bar-danger' role='progressbar' aria-valuenow=' " + data.productProgress +  "' aria-valuemin='0' aria-valuemax='100' style='width:" + data.productProgress.toString()+"%;'></div></div>";
                printrow =  printrow + "<p><i>Comments:</i></p><textarea rows='4' cols='85'>"+ data.comments +"</textarea></div></div>";
              
                // console.log(printrow)
                $("#solutionProducts").append(printrow);
                        
                

            }
        } catch (error) {
            showError
            ('There is a problem retrieving books data, please try again later.<br />'+error);
                } 
    });


    </script>


	
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
		<script src="js/custom.js"></script>

	</body>
</html>