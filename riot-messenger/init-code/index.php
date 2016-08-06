<!DOCTYPE html>
<?php 
  $hostname='localhost';
  $username='riotthfc_admin';
  $password='7=?G+%MV@_#;';

$sent = null;
$submit = false;
//error_reporting(E_ALL);  
$error = false;
$inject = "/(content-type|bcc:|cc:|to:)/i";
if (isset($_POST['submit'])) 
{
$submit = true;
  if((!isset($_POST['name']) || !isset($_POST['subject']) || !isset($_POST['message'])) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
     $error = true;

    //try-catch inserting stuff into DB
    try 
    {
      //creating connection for mysql
      $conn = new PDO("mysql:host=$hostname;dbname=riotthfc_init-code",$username,$password);

      //set the PDO error mode to exeption 
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
      
    $stmt = $conn->prepare(" INSERT INTO icmsg (name, subject, message, email) 
                             VALUES (:name, :subject, :message, :email)");

    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':subject', $subject, PDO::PARAM_STR);
    $stmt->bindParam(':message', $message, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);

    $name = $_POST["name"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];
    $email = $_POST["email"];
    $stmt->execute();


      $conn = null;
      //echo "Connected successfully";
    }
    catch(PDOException $e)
    {
      //echo "Connection failed: " . $e->getMessage();
    }


   foreach ($_POST as $key => $value) 
   {
    // header injection
    if ( preg_match($inject, $value)) 
    {
           $error = true;
           exit; 
    } 
   }
    $header = 'From '.$_POST["name"]. '<' . $_POST["email"] . '>' . "\r\n" .
    'Reply-To: ' .$_POST["email"]. "\r\n" .
    'X-Mailer: PHP/' . phpversion();  
    if(!$error)
    $sent = mail("info@riot-messenger.com", $_POST["subject"], "Message:  ".$_POST['message'], $header);
     
}
 ?>

<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Init() Code</title>

    <link rel="shortcut icon" href="favicon.ico">

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/agency.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,900' rel='stylesheet' type='text/css'>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body id="page-top" class="index">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand page-scroll" href="#page-top">Init() Code</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#about">About Init() Code</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#history">History</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#team">Our Team</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#contact">Contact Us</a>
                    </li>
                    <li>
                        <a href="/index.php">Riot Messenger</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <!-- Header -->
    <header>
        <div class="container">
            <div class="intro-text">
                <!--<div class="intro-lead-in">Welcome to Init() Code!</div>-->
                <!--<div class="intro-heading">It's Nice To Meet You</div>-->
                <!--<a href="#about" class="page-scroll btn btn-xl">Tell Me More</a>-->
            </div>
        </div>
    </header>

    <!-- About Section -->
    <section id="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">About Init() Code</h2><!--
                    <h3 class="section-subheading text-muted">Init() Code</h3>-->
                </div>
            </div>
            <p>Founded in June of this year, Init() Code is dedicated to bringing information security and online privacy to the masses by creating fun and intuitive applications like Riot Messenger, a mobile application featuring retro-style location based chat rooms and direct messaging. Riot Messenger utilizes technologies such as mesh networking and near field communications to allow users to chat securely and anonymously.</p>
            <hr>
            <p>Init() Code's founding team comprises past and present students, tutors, and supplemental instructors of Moreno Valley College. Having progressed beyond the computer science curriculum at the college, they created the Software Engineering Club to accelerate their learning, attract other talented students, and to practice real-world skills. After a very successful year of team building, they expanded their horizons and Init() Code was born.</p>
        </div>
    </section>

    <!-- History Section -->
    <section id="history">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">History</h2>
                    <!--<h3 class="section-subheading text-muted">Init() Code's History</h3>-->
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <ul class="timeline">
                        <li>
                            <div class="timeline-image">
                                <img class="img-circle img-responsive" src="img/about/sec.jpg" alt="">
                            </div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h4>September 2014</h4>
                                    <h4 class="subheading">Our Humble Beginnings</h4>
                                </div>
                                <div class="timeline-body">
                                    <p class="text-muted">Computer Science tutors seeking a greater challenge form the Software Engineering Club to hone their technical, team building, and leadership skills.</p>
                                </div>
                            </div>
                        </li>
                        <li class="timeline-inverted">
                            <div class="timeline-image">
                                <img class="img-circle img-responsive" src="img/about/office.png" alt="">
                            </div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h4>June 2015</h4>
                                    <h4 class="subheading">Init() Code is Born</h4>
                                </div>
                                <div class="timeline-body">
                                    <p class="text-muted">After success with the Software Engineering Club, club founders form Init() Code to create an  innovative messaging application for mobile devices.   </p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="timeline-image">
                                <img class="img-circle img-responsive" src="img/about/riot.png" alt="">
                            </div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <h4>January 2016</h4>
                                    <h4 class="subheading">Riot Messenger Launch</h4>
                                </div>
                                <div class="timeline-body">
                                    <p class="text-muted">Riot Messenger is set to launch New Years Day 2016</p>
                                </div>
                            </div>
                        </li>
                       <li class="timeline-inverted">
                            <div class="timeline-image">
                                <a href="#join"><h4>Be Part
                                    <br>Of Our
                                    <br>Story!</h4></a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section id="team" class="bg-light-gray">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Meet the Team</h2>
                    <h3 class="section-subheading text-muted">Meet the people behind Init() Code and Riot Messenger</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="team-member">
                        <img src="img/team/aaron.jpg" class="img-responsive img-circle" alt="">
                        <h4>Aaron Clark</h4>
                        <p class="text-muted">Chief Executive Officer</p>
                        <ul class="list-inline social-buttons">
                            <li><a href="https://www.linkedin.com/in/aaronbclark" target="_blank"><i class="fa fa-linkedin"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="team-member">
                        <img src="img/team/james.jpg" class="img-responsive img-circle" alt="">
                        <h4>James Luevano</h4>
                        <p class="text-muted">Chief Technology Officer</p>
                        <ul class="list-inline social-buttons">
                            <li><a href="https://twitter.com/jamesluevano"><i class="fa fa-twitter"></i></a>
                            </li>
                            <li><a href="https://www.linkedin.com/in/jamesluevano" target="_blank"><i class="fa fa-linkedin"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="team-member">
                        <img src="img/team/eric.jpg" class="img-responsive img-circle" alt="">
                        <h4>Eric Magallan</h4>
                        <p class="text-muted">Chief Creative Officer</p>
                        <ul class="list-inline social-buttons">
                            <!--<li><a href="#"><i class="fa fa-twitter"></i></a>
                            </li>-->
                            <li><a href="https://www.linkedin.com/in/ericmagallan" target="_blank"><i class="fa fa-linkedin"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="team-member">
                        <img src="img/team/angelo.jpg" class="img-responsive img-circle" alt="">
                        <h4>Angelo Aquino</h4>
                        <p class="text-muted">Senior Android Developer</p>
                        <ul class="list-inline social-buttons">
                            <!--<li><a href="#"><i class="fa fa-twitter"></i></a>
                            </li>
                            <li><a href="#"><i class="fa fa-linkedin"></i></a>
                            </li>-->
                        </ul>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="team-member">
                        <img src="img/team/stephanie.jpg" class="img-responsive img-circle" alt="">
                        <h4>Stephanie Gallo</h4>
                        <p class="text-muted">Web Developer & Content Strategist</p>
                        <ul class="list-inline social-buttons">
                            <li><a href="https://www.linkedin.com/pub/stephanie-gallo/b7/b00/87" target="_blank"><i class="fa fa-linkedin"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="team-member">
                        <img src="img/team/alvin.jpg" class="img-responsive img-circle" alt="">
                        <h4>Alvin Chieng</h4>
                        <p class="text-muted">Operations Specialist</p>
                        <!--<ul class="list-inline social-buttons">
                            <li><a href="#"><i class="fa fa-twitter"></i></a>
                            </li>
                            <li><a href="#"><i class="fa fa-linkedin"></i></a>
                            </li>
                        </ul>-->
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--We're Hiring!-->
    <section id="join">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Join Our Team</h2>
                    <h3 class="section-subheading text-muted">We're looking for awesome inviduals to join the Init() Code Team!</h3>
                </div>
            </div>
      
            <p></p>

            <div class="row text-center">
                <div class="col-xs-6 col-sm-3">
                    <span class="fa-stack fa-4x">
                        <i class="fa fa-circle fa-stack-2x text-primary"></i>
                        <i class="fa fa-apple fa-stack-1x fa-inverse"></i>
                    </span>
                    <h4 class="service-heading">iOS</h4>
                    <p class="text-muted">Open Positions for:<br>
                                                                <em>&ndash;Senior IOS Developer<br>
                                                                &ndash;iOS UIX Developer<br>
                                                                &ndash;iOS Networking Developer<br></p></em>
                </div>
                <div class="col-xs-6 col-sm-3">
                    <span class="fa-stack fa-4x">
                        <i class="fa fa-circle fa-stack-2x text-primary"></i>
                        <i class="fa fa-android fa-stack-1x fa-inverse"></i>
                    </span>
                    <h4 class="service-heading">Android</h4>
                    <p class="text-muted">Open Positions for:<br>
                                                                <em>&ndash;Android UIX Developer<br>
                                                                &ndash;Android Networking Developer<br></p></em>
                                                               
                </div>
                <div class="col-xs-6 col-sm-3">
                    <span class="fa-stack fa-4x">
                        <i class="fa fa-circle fa-stack-2x text-primary"></i>
                        <i class="fa fa-server fa-stack-1x fa-inverse"></i>
                    </span>
                    <h4 class="service-heading">Server</h4>
                    <p class="text-muted">Open Positions for:<br>
                                                                <em>&ndash;Backend Engineer<br>
                                                                &ndash;Security Architect<br>
                                                                &ndash;System Administrator<br></p></em>
                </div>
                <div class="col-xs-6 col-sm-3">
                    <span class="fa-stack fa-4x">
                        <i class="fa fa-circle fa-stack-2x text-primary"></i>
                        <i class="fa fa-clipboard fa-stack-1x fa-inverse"></i>
                    </span>
                    <h4 class="service-heading">Administration</h4>
                    <p class="text-muted">Open Positions for:<br>
                                                                <em>&ndash;Growth Specialist<br>
                                                                &ndash;Senior Mobile Marketing Manager<br></p></em>
                </div>
            </div>
        </div>
    </section>

    <section id="contact" class="section bg-primary">
        <div class="container">
            <div class="col-lg-12 text-center">
                <?php   if($sent) echo "<h2 class=\"section-heading\">Message Sent!</h2>";
                        else if($submit)
                        {
                        echo "<div class=\"alert alert-danger\" role=\"alert\"><h3 class=\"section-heading\">Error, try again.</h3> </div>";
                        }
                 ?>
                  <?php if(!$sent) 
                  echo "<h2 class=\"section-heading\">Contact Us</h2>
                        <h3 class=\"section-subheading text-muted\">Have a question or comment? Send us a message.</h3>";

                  ?>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <form name="sentMessage" class="row contacts" action="index.php#contact" method="post">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                        <input type="text" name="subject" placeholder="Subject" class="form-control">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="name" placeholder="Name*" class="form-control" id="name"  required="required">
                                </div>
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control" placeholder="Email*" id="email" required="required">
                                    <p class="help-block text-danger"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <textarea class="form-control" name="message" placeholder="Your Message*" id="message" required="required"></textarea>
                                    <p class="help-block text-danger"></p>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-lg-12 text-center">
                                <button name="submit" type="submit" class="btn btn-xl">Send message</button>
                            </div>
                        </div>
                    </form>            
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <span class="copyright">Copyright &copy; Init() Code 2015</span>
                </div>
                <div class="col-md-4">
                    <ul class="list-inline social-buttons">
                        <!--<li><a href="#"><i class="fa fa-twitter"></i></a>
                        </li>
                        <li><a href="#"><i class="fa fa-facebook"></i></a>
                        </li>-->
                        <li><a href="https://www.linkedin.com/company/init-code-inc" target="_blank"><i class="fa fa-linkedin"></i></a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <!--<ul class="list-inline quicklinks">
                        <li><a href="#">Privacy Policy</a>
                        </li>
                        <li><a href="#">Terms of Use</a>
                        </li>
                    </ul>-->
                </div>
            </div>
        </div>
    </footer>


    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script> 
    <script src="js/classie.js"></script> 
    <script src="js/cbpAnimatedHeader.js"></script> 

    <!-- Contact Form JavaScript -->
    <script src="js/jqBootstrapValidation.js"></script>
    <!--<script src="js/contact_me.js"></script>-->

    <!-- Custom Theme JavaScript -->
    <script src="js/agency.js"></script>

</body>
</html>
