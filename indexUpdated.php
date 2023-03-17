<?php
//Create a session
  if (!isset($_SESSION)) {
    session_start();
  }

  //Create variables to hold form data and errors
    $nameErr = $emailErr = $contBackErr = "";
    $name = $email = $contBack = $comment = "";
    $formErr = false;

//Validate form when form is submitted

if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["name"])) {
            $nameErr = "Name is required.";
            $formErr = true;
        } else {
            $name = cleanInput($_POST["name"]);

//Use REGEX to accept only letters and white spaces
            if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
                $nameErr = "Only letters and standard spaces allowed.";
                $formErr = true;
            }
        }
        
        if (empty($_POST["email"])) {
            $emailErr = "Email is required.";
            $formErr = true;
        } else {
            $email = cleanInput($_POST["email"]);
// Check if e-mail address is formatted correctly
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Please enter a valid email address.";
                $formErr = true;
            }
        }
        
  if (empty($_POST["contact-back"])) {
            $contBackErr = "Please let us know if we can contact you back.";
            $formErr = true;
        } else {
            $contBack = cleanInput($_POST["contact-back"]);
        }
        
        $comment = cleanInput($_POST["comment"]);
    }
//Clean and sanitize form inputs

  function cleanInput($data) {
    $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

/**If no form errors occur, send the data to the data base */  

if (($_SERVER["REQUEST_METHOD"] == "POST") && (!($formErr))){  
//Create Connection Variables
    $hostname = "php-mysql-exercisedb.slccwebdev.com";
    $username = "phpmysqlexercise";
    $password = "mysqlexercise";
    $databasename = "php_mysql_exercisedb";
    
    try {
//Create new PDO Object with connection parameters
        $conn = new PDO("mysql:host=$hostname;dbname=$databasename",$username, $password);
        
//Set PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
        
        $sql = "INSERT INTO sl_sp23_Contacts (name, email, contactBack, comments)
                VALUES (:name, :email, :contactBack, :comment);";
//Variable containing SQL command
      $stmt = $conn->prepare($sql);

//Bind parameters to variables
  $stmt->bindParam(':name', $name, PDO::PARAM_STR);
  $stmt->bindParam(':email', $email, PDO::PARAM_STR);
  $stmt->bindParam(':contactBack', $contactBack, PDO::PARAM_STR);
  $stmt->bindParam(':comments', $comments, PDO::PARAM_STR);

//Execute SQL statement on server
  $stmt->execute();

//Create thank you message
$_SESSION['message'] = '<p class="font-weight-bold">Thank you for your submission!</p><p class="font-weight-light;>Your request has been sent.</p>';

$SESSION['complete'] = true;

//Redirect
      header('Location: ' . $_SERVER['REQUEST_URI']);
      exit;

    } catch (PDOException $error) {

//Create error message
$SESSION['message'] = '<p>We apologize, the form was not submitted successfully. Please try again later.</p>';

$SESSION['complete'] = true;
    
//Redirect
header('Location: ' . $_SERVER['REQUEST_URI']);
exit;
}
$conn = null; 
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
<!-- Required meta tags -->
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>

<!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        
        <link href="https://fonts.googleapis.com/css2?family=Purple+Purse&display=swap" rel="stylesheet">

<!-- Bootstrap CSS -->
		    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous" />
		
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
		    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>

		    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

		    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
		
        <link rel="stylesheet" href="style.css"/>

        <title>Portfolio</title>
    </head>

    <body>

<!-- Navigation -->
    <nav class="navbar navbar-expand-sm sticky-top">
      <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarScroll">
          <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll text-white">
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="#">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#about">About</a>
            </li>
            
            <li class="nav-item">
              <a class="nav-link" href="#portfolio">Portfolio</a>
            </li>
            
              <li class="nav-item">
              <a class="nav-link" aria-current="page" href="#table">Contact</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="resume.php">Resum&eacute;</a>
            </li>
        </div>
      </div>
    </nav>
  
<!--Page Header -->
        <header class="mainHeader">
            <div class="container-fluid h-100">
              <div class="row align-items-center justify-content-center text-center text-white h-100 pb-3" style="background-color: black;">
                <div class="col-lg-8">
                    <h1 class="display-3">Stacy LeCates
                      </h1>
                      <hr class="my-4 bg-white" />
                      <p class= "font-weight-light display-4">
                        Web Development and Design
                      </p>
                      <br>
                      <a class="btn btn-lg mt-2" role="button" alt="portfolio button" id="portfolioButton" href="#portfolio">Portfolio</a>
                    </div>
                  </div>
                </div>
              </header>
<!-- About Section -->
              <section id="about">
                <div class="container">
                  <div class="row align-items-center justify-content-center text-center py-5">
                    <div class="col-6 col-md-4">
                      <img src=images\stacyAvatar.jpg id= avatar alt="avatar" class="img-fluid"/>
                    </div>
                        <div class="col-md-8 my-3"><section id="about">
                        <h1>
                            About Me
                        </h1>
                        <hr class="my-4" />
                        Creating digital content is a passion that I am eager to share. I am currently enrolled in a Web Development program in Salt Lake City Utah. I also completed a Digital Media and Design program and earned a BA in Elementary Education. I thrive on learning and developing new skills.  Please take a look over my portfolio and contact me with your comments and questions...
                          <br>
                        <a class="btn btn-dark btn-lg mt-2 mx-auto" id="contactButton" role="button" href="#table">Contact Me</a>
                        <hr class="my-4 bg-black"/>
                                                              
                        <p class="mx-5" style="font-weight:bold;">I am skilled in the following programs:</p>
            
                              
                      <?php                  
                          $mySkills = ["Adobe Photoshop", "Adobe Illustrator", "Adobe Premiere Pro", "Adobe After Effects", "HTML", "CSS", "JavaScript", "PHP", "mySQL"];
                          function newList($array)
                          {
                            echo "<ul>";
                            foreach ($array as $value){
                            echo "<li>" . $value . "</li>";
                            }
                            echo  "<ul>";
                          }
                            newList($mySkills);
                            ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </section>

<!--Portfolio Section -->
    <section id="portfolio">
        <div class="container-fluid">
          <div class="row text-white text-center">
            <div class="col py-3">
              <h1 class="text-white">
                Portfolio
              </h1>
              <hr class="bg-white mb-5" />
            </div>
          </div>

          <div class="container">
              <div class="card-group">

  <!-- Portfolio Items Row Starts -->
      <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3">
  
  <!-- Digital Design Item Begins-->
            <div class="col mb-4">
  <!-- Digital Design Card Starts -->
              <div class="card bg-light text-center shadow h-100">
  <!-- Digital Design Card Image -->
                <img
                  src="images\digDes.jpg"
                  alt="tablet image" class="card-img-top" style="object-fit: cover; height: 25vh;" />
  <!-- Digital Design Card Body Starts -->
                <div class="card-body">
                  <h3 class="card-title">
                    Digital Design
                  </h3>
                  <hr class="bg-dark" />
                  <p class="card-text">I design for both print and online use. My specialties include logos, full branding, media posts, cards, newsletters, posters, photo-manipulation and photo composites.
                </p>
<!-- Digital Design Card Footer Starts -->
                  <div class="card-footer">
                    <a class="btn btn-md mt-2" role="button" alt="view samples button" id="viewButton" href="carousel.php">View Samples</a>
                  </div>
                </div>
              </div>
<!-- Digital Design Item Ends -->
            </div>
<!-- Digital Design Card Ends-->
            
<!-- Web Development Item Begins-->
            <div class="col mb-4">
<!-- Web Development Card Starts -->
              <div class="card bg-light text-center shadow h-100">
<!-- Web Development Card Image -->
                <img
                  src="images\deskCode.jpg"
                  alt="pm_pic" class="card-img-top" alt="computer image" style="object-fit: cover; height: 25vh;" />
<!-- Web Development Card Body Starts -->
                <div class="card-body">
                  <h3 class="card-title">
                    Web Development
                  </h3>
                  <hr class="bg-dark" />
                  <p class="card-text">
                   My focus as a web developer is designing websites that meet the specific needs, preferences and styles of my clients. I design for small businesses, personal/family use, education and other professional fields.</p>
<!-- Web Development Card Footer Starts -->
                  <div class="card-footer">
                    
                  </div>
                </div>
<!-- Web Development Card Ends-->
              </div>
<!-- Web Development Item Ends -->
            </div>
  
   
<!-- Video Projects -->
            <div class="col mb-4">
<!-- Video Card Starts -->
              <div class="card bg-light text-center shadow h-100">
<!-- Video Card Image -->
                <img
                  src="images\video.jpg"
                  alt="pm_pic" class="card-img-top" alt="camera image" style="object-fit: cover; height: 25vh";>
<!-- Video Card Body Starts -->
                <div class="card-body">
                  <h3 class="card-title">
                    Videos
                  </h3>
                  <hr class="bg-dark" />
                  <p class="card-text">
                   Using Adobe software I create and edit original, short videos. These videos can be for personal, business, or educational uses.
                  </p>
<!-- Video Card Footer Starts -->
                  <div class="card-footer">
                    <a class="btn btn-md mt-2" role="button" id="viewButton" alt="view samples button" href="videos.php">View Samples</a>
                  </div>
                </div>
<!-- Video Card Ends-->
              </div>
            </div>
<!-- Video Item Ends -->
          </div>
        </div>
        </div>
      </section>       

<!--Contact Form Section-->

<section id="table">
            <div class="container my-5">
                <div class="row">
                    <div class="col">
                        <h2>The data currently in the database is:</h2>

<!-- Table element start -->
            <table class="table table-hover" id="dataTable">
              <thead>
              <tr>
              <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Contact Back</th>
                <th scope="col">Comments</th>
                <th scope="col">Date Sent</th>
              </tr>
              </thead>
            <tbody>
<!-- Loop through data returned from database -->
                <?php                            
                                    foreach ($stmt->fetchAll() as $row) {
                                        echo "<tr>";
                                        echo "<th scope='row'>" . $row['contactID'] . "</th>";
                                        echo "<td>" . $row['name'] . "</td>";
                                        echo "<td>" . $row['email'] . "</td>";
                                        echo "<td>" . $row['contactBack'] . "</td>";
                                        echo "<td>" . $row['comments'] . "</td>";
                                        echo "<td>" . $row['dateSent'] . "</td>";
                                        echo "</tr>";
                  }
               ?>
              </tbody>
            </table>
    
<!-- Thank you Modal -->
  
<div class="modal fade" id="thankYouModal" tabindex="-1" aria-labelledby="thankYouModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="thankYouModalLabel">Thank You</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php echo $_SESSION['message']; ?>
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!--Show modal thank you message-->
      <?php
        if(isset($_SESSION['complete']) && $SESSION['complete']) {
          echo "<script>$('#thankYouModal').modal('show');<script>";
          session_unset();
        };
        ?>

<!-- Page Footer-->

       <footer class="py-4 bg-black">
        <div class="container">
          <p class="m-0 text-center text-white"        >
            Copyright &copy; Stacy LeCates
          </p>
        </div>
      </footer>
  
    </body>
  
  </html>
                  
    