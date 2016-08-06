<!DOCTYPE html>
<?php 
  $hostname='localhost';
  $username='root';
  $password='7=?G+%MV@_#;';


  $beta = false;
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

    foreach ($_POST as $key => $value) 
    {
      // header injection
       if ( preg_match($inject, $value)) 
       {
             $error = true;
             exit; 
      } 
    }
    if(!$error)
    {
    
      try 
      {
        //creating connection for mysql
        $conn = new PDO("mysql:host=$hostname;dbname=riotthfc_init-code",$username,$password);

        //set the PDO error mode to exeption 
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // <== add this line
        
        $stmt = $conn->prepare(" INSERT INTO riotmsg (name, subject, message, email) 
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
        echo "Connected successfully";
      }
      catch(PDOException $e)
      {
        echo "Connection failed: " . $e->getMessage();
      }

        $header = 'From '.$_POST["name"]. '<' . $_POST["email"] . '>' . "\r\n" .
        'Reply-To: ' .$_POST["email"]. "\r\n" .
        'X-Mailer: PHP/' . phpversion();  
        $sent = mail("info@riot-messenger.com", $_POST["subject"], "Message:  ".$_POST['message'], $header);
   }    
  } 

  else if((isset($_POST['beta'])))
  {
    $error = false;


    if(!empty($_POST['email']))
    {
      if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
      {
        foreach ($_POST as $key => $value) 
        {
          // header injection
           if ( preg_match($inject, $value)) 
           {
                 $error = true;
                 exit; 
          } 
        }
        if(!$error)
        {
          try 
          {
            //creating connection for mysql
            $conn = new PDO("mysql:host=$hostname;dbname=riotthfc_init-code",$username,$password);

            //set the PDO error mode to exeption 
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // <== add this line
            
            $stmt = $conn->prepare(" INSERT INTO beta (email) 
                                   VALUES (:email)");

            $stmt->bindParam(':email', $email, PDO::PARAM_STR);

            $email = $_POST["email"];
            $stmt->execute();


            $conn = null;
            echo "Connected successfully";
          }
          catch(PDOException $e)
          {
            echo "Connection failed: " . $e->getMessage();
          }


          $beta = true;
           $header = 'From BetaUser <' . $_POST["email"] . '>' . "\r\n" .
            'Reply-To: ' .$_POST["email"]. "\r\n" .
             'X-Mailer: PHP/' . phpversion();  
             $message = "New beta user, email: ".$_POST["email"];
          $sent = mail("info@riot-messenger.com", "New beta user!", $message, $header);


            /*$beta = true;
            $header = 'From info@riot-messenger.com \r\n';
            $message = "<p>Welcome to Riot Messenger Beta!<br>
                         We're excited to Riot with you. <br>
                         Beta is set to launch on October 31st, 2015.<br>
                         When we're ready, we'll send you a special code and download link for the Riot App.</p>

                          <p>Thank you,</p>
                          <p>The Riot Messenger Team</p>";
          $sent = mail($_POST["email"], "Are you ready to Riot?", $message, $header);*/
      }
    }
  }
  }
?>

<!--Icons can be change with FontAwesome and IonIcon -->
<html>


  <head>
    <meta charset="UTF-8">
    <title>Riot - Real-time community chat rooms for Android and IOS.</title>
 
    <link rel='shortcut icon' type='image/x-icon' href='/favicon.ico' />
    <meta name="viewport" content="width=device-width, maximum-scale=1, user-scalable=no">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="shortcut icon" href="#" type="image/x-icon">
    
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="css/riot.css" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,300,400,500,700,900" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Roboto:500,600,700,100,800,400,200,300" rel="stylesheet">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/animate.css">
    <script src="js/jquery.min.js"></script>

    <!-- <link rel="stylesheet" type="text/css" href="meshstyle.css">-->

  </head>
  <body class="no-scroll">
    <div class="site-wrapper">
      
      <div class="top-bar">
        <div class="container">
          <nav class="nav">
            <div class="pull-left">
           
             <!-- <h2><a href="#home" class="smooth-scrolling"><span class="text-primary">Riot</span></a></h2> -->
             <img src="images/logo.png" style="padding-top: 8px;" width="60px" height="60px" class="smooth-scrolling"></img>
            </div>
            <ul class="list-inline pull-right">
             <li><a href="#UI" class="smooth-scrolling">What is Riot?</a></li>
              <li><a href="#features" class="smooth-scrolling">Features</a></li>
              <li><a href="#beta" class="smooth-scrolling">Join Beta</a></li>
               <li><a href="#Fund" class="smooth-scrolling">Contribute</a></li>
              <li><a href="#contact" class="smooth-scrolling">Contact</a></li>
              <li><a href="init-code/index.php">Init() Code</a></li>

            </ul>
            <button class="fa fa-bars open-mobile-menu"></button>
          </nav>
        </div>
      </div>

      <header id="home" class="header">
       <!-- Header begin-->
        <div class="header-section">
          <div class="container">
            <div class="row vertical-align">
              <div class="col-sm-8 col-sm-offset-2">

                <h1 class="text-center">Communicate <em>securely</em><br>without using data or internet</h1>
                  <style type="text/css">
                  button.btn-lg
                  {
                    background-color: #00B16A;
                  }
                  header h1.text-center
                  {
                    font-size: 50px;
                    line-height: 125%;
                    padding-bottom: 10px;
                    padding-top: 15px;
                    font-weight: bold;
                  }
                  header h2.text-center
                  {
                    font-size: 18px;
                    line-height: 200%;
                    padding-top: 15px;
                    padding-bottom: 15px;
                    font-weight: 400;
                  }
                  </style>
                <h2 class="text-center"> 
                  <a href="#beta" class="smooth-scrolling"><button type="button" class="btn btn-primary btn-lg">Join Now!</button></a></h2>

                  <h2 class="text-center">Be one of the first users to recieve the beta as soon as its available<br>
                                          and recieve $5 of in app credit when the app goes live.</h2>
              </div>
            </div>
          </div>
        </div>
      </header>
         <section id="UI" class="section">
        <div class="container">
          <div class="slider featured-slider">
    
            <div class="slide row section-table">
              <div class="col-sm-4 text-center"><img height= "550px" width="370px" src="images/riot-lobby.png" class="img-responsive">
              </div>
              <div class="col-sm-8">
                <h2>Bring back the golden age of chat.</h2>
                <h4>Retro-style location based chat rooms and direct messaging. Mesh networking and near field communications for secure and anonymous conversations. </h4>
                     <p>Instantly chat in real-time with everyone around you, from your school, to your workplace, neighborhood, city, and even your entire state. You can also chat offline with other nearby users, creating your very own mesh network that extends even further for every connected user. Create your own private chat for you and your friends, create a public chat to start a conversation with your community, or just join the lobby and talk to everyone in that area all at once.</p>
				<p>
				Password protect your chat rooms, or use our proprietary near-field access control to ensure that only the people you know will ever get in. Then, allow guests of your chat room to share access among their own circles for a truly viral experience.</p>
				<p>
				Protect your identity and be free to speak your mind by chatting in anonymous mode, or stand behind your words with a verified account and have access to user ratings, custom chat rooms, and more.
				</p>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section class="section bg-primary">
        <div class="container">
           <h2 class="text-center download wow bounceInUp"><span>Ready to Riot?</span></h2><h3 class="text-center">Open beta launches in</h3>
                <div style="color:white;" data-countdown="2015/10/31" class="countdown"></div>
                
        </div>
      </section>
           <section id="features" class="section">
        <div class="container">
          <h2 class="section-title">Features</h2>
          <div class="row features">
            <div class="col-sm-4 text-right">
              <div class="featured-item wow bounceInLeft">
                <div class="featured-text">
                  <h4><a href="#">Communicate with those around you.</a></h4>
                  <p>Chat with people in your building, your city, or your region. Build instant communities like never before.  </p>
                </div>
                <div class="featured-icon">
                  <div class="circle-icon"><i class="fa fa-user-secret"></i></div>
                </div>
              </div>
              <div class="featured-item wow bounceInLeft">
                <div class="featured-text">
                  <h4><a href="#">Mesh Networking </a></h4>
                  <p>Don't just connect to the network - be a part of it. Mesh with other devices to create your own internet.</p>
                </div>
                <div class="featured-icon">
                  <div class="circle-icon pull-right"><i class="fa fa-dashcube"></i></div>
                </div>
              </div>
              <div class="featured-item wow bounceInLeft">
                <div class="featured-text">
                  <h4><a href="#">Anonymous</a></h4>
                  <p>Don't want others (including us) to know who you are? Go anonymous and be free to speak your mind.</p>
                </div>
                <div class="featured-icon">
                  <div class="circle-icon pull-right"><i class="fa fa-globe"></i></div>
                </div>
              </div>
            </div>
            <!-- 313x653-->
            <div class="col-sm-4 text-center wow pulse"><img height="653" width="313"src="images/riot-chatroom.png" alt="Screenshot 1" class="img-responsive">
            </div>
            <div class="col-sm-4">
              <div class="featured-item wow bounceInRight">
                <div class="featured-icon">
                  <div class="circle-icon pull-left"><i class="fa fa-globe"></i></div>
                </div>
                <div class="featured-text">
                  <h4><a href="#">Start your own Riots</a></h4>
                  <p>Create a chat group, then open it up to the public or keep it private with multiple levels of security to keep away prying eyes.</p>
                </div>
              </div>
              <div class="featured-item wow bounceInRight">
                <div class="featured-icon">
                  <div class="circle-icon pull-left"><i class="fa fa-dashcube"></i></div>
                </div>
                <div class="featured-text">
                  <h4><a href="#">Stay in touch with friends and family</a></h4>
                  <p>Follow others and get updated when they join your network. Communicate one-on-one with secured private messaging.</p>
                </div>
              </div>
              <div class="featured-item wow bounceInRight">
                <div class="featured-icon">
                  <div class="circle-icon pull-left"><i class="fa fa-sellsy"></i></div>
                </div>
                <div class="featured-text">
                  <h4><a href="#">Go public</a></h4>
                  <p>Anonymity not for you? Use a public profile and enjoy our full suite of premium features.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
       <section  id="beta" class="section bg-primary">
        <div class="container">
         <?php  if(!$beta){ ?>
           <h2 class="text-center download wow bounceInUp"><span>Want Riot Messenger?</span></h2>
           <h4 style="color: white;" class="text-center">Be one the first users to receive the beta as soon as it's available and recieve $5 of in app-credit when the app goes live.</h4>
           </br>
           <div class="col-sm-6 col-sm-offset-3">
          
           <form method="post" action="index.php#beta">
           <input type="email" name="email" placeholder="Email" required="required" class="form-control">
           <button name="beta" type="submit" class="btn col-sm-offset-3">Join beta</button>
           </div>
            
           </form>
              <?php   } else { ?>
                  <h2 class="text-center download wow bounceInUp"><span>Thank you for joining!</span></h2> 

                  <?php   } ?>

                
        </div>
      </section>
      <section id="Fund" class="section">
        <div class="container">
          <h2 class="text-center">Contribute</h2>
          <div class="row text-center">
           <div class="col-xs-12 col-sm-4 wow bounceInUp"><span class="huge-icon fa fa-globe text-primary"></span>
              <h3 class="text-primary">Evangelize</h3>
              <p>Riot won't change the world until the world knows of it. Money can't buy word of mouth.</p>
 
            <ul class="list-inline social-buttons red text-center">
                        <li>
                          <a href="https://www.linkedin.com/company/riot-messenger" target="_blank"><i class="fa fa-linkedin"></i></a>
                        </li>
                        <li>
                          <a href="https://twitter.com/riot_app" target="_blank"><i class="fa fa-twitter"></i></a>
                        </li>
                        <li>
                          <a href="https://instagram.com/riotmessengerapp/" target="_blank"><i class="fa fa-instagram"></i></a>
                        </li>
                        <li>
                          <a href="https://www.facebook.com/riotmessengerapp" target="_blank"><i class="fa fa-facebook"></i></a>
                        </li>
            </ul>
            </div>
            <div data-wow-delay="0.3s" class="col-xs-12 col-sm-4 wow bounceInUp"><span class="huge-icon fa fa-money text-primary"></span>
              <h3 class="text-primary">Donate</h3>
              <p>Are you a philanthropist? If so, please consider donating to our cause. Every dollar helps liberate another line of code.</p>
            </div>
            <div data-wow-delay="0.5s" class="col-xs-12 col-sm-4 wow bounceInUp"><span class="huge-icon fa fa-sellsy text-primary"></span>
              <h3 class="text-primary">Invest</h3>
              <p>Are you an Angel or VC? If so, we would love to talk. Drop us a message below and we'll get back to you.</p>
            </div>
          </div>
          <center>
                  <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="CWRMQVHPR37FU">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img style="padding-top:10px" alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">

</form>
<script src="http://coinwidget.com/widget/coin.js"></script>
<span>
<script src="http://coinwidget.com/widget/coin.js"></script>
<script>
CoinWidgetCom.go({
  wallet_address: "3Ch39zTKwtQmp7M8AURVyVz2jenPj1Y2NY"
  , currency: "bitcoin"
  , counter: "hide"
  , alignment: "bl"
  , qrcode: true
  , auto_show: false
  , lbl_button: "Bitcoin"
  , lbl_address: "Donate to Riot Messenger"
  , lbl_count: "Riots"
  , lbl_amount: "BTC"
});
</script>
</center>
</span>
        </div>
      </section>
      <section id="contact" class="section bg-primary">
        <div class="container">
        <?php   if($sent) echo "<h3 class=\"text-center\">Message Sent!</h3>";
                else if($submit)
                {
                echo "<div class=\"alert alert-danger\" role=\"alert\"><h3 class=\"text-center\">Error, try again.</h3> </div>";
                }
         ?>
          <?php if(!$sent) 
          echo "<h2 class=\"text-center\">Contact Us</h2>";
          ?>
          <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
              <form class="row contacts" action="index.php#contact" method="post">
                <div class="col-sm-6">
                  <input type="text" name="name" placeholder="Name" required="required" class="form-control">
                </div>
                <div class="col-sm-6">
                  <input type="email" name="email" placeholder="Email" required="required" class="form-control">
                </div>
                <div class="col-sm-12">
                  <input type="text" name="subject" placeholder="Subject" class="form-control">
                </div>
                <div class="col-sm-12">
                  <textarea name="message" placeholder="Message" class="form-control"></textarea>
              
                  <div class="text-center">
                    <button name="submit" type="submit" class="btn">Send message</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <hr>
        </div>
      </section>

      <footer class="footer">
        <div class="container">
          <div class="footer-logo">Riot</div>
          <ul class="list-inline text-center">
          <!--
            <li data-wow-delay="0.2s" class="wow bounceInUp"><a href="#" class="social"><i class="fa fa-twitter"></i></a></li>
            <li data-wow-delay="0.4s" class="wow bounceInUp"><a href="#" class="social"><i class="fa fa-linkedin-square"></i></a></li>
            <li data-wow-delay="0.5s" class="wow bounceInUp"><a href="#" class="social"><i class="fa fa-google-plus"></i></a></li>
            -->
          </ul>

          <div class="col-md-4">
            <p class="copyright">Copyright Init() Code Inc. © 2015</p>
          </div>
          <div class="col-md-4">
            <ul class="list-inline social-buttons text-center">
                        <li>
                          <a href="https://www.linkedin.com/company/riot-messenger" target="_blank"><i class="fa fa-linkedin"></i></a>
                        </li>
                        <li>
                          <a href="https://twitter.com/riot_app" target="_blank"><i class="fa fa-twitter"></i></a>
                        </li>
                        <li>
                          <a href="https://instagram.com/riotmessengerapp/" target="_blank"><i class="fa fa-instagram"></i></a>
                        </li>
                        <li>
                          <a href="https://www.facebook.com/riotmessengerapp" target="_blank"><i class="fa fa-facebook"></i></a>
                        </li>
            </ul>
          </div>
          <div class="col-md-4">
            <p></p>
          </div>
        </div>
      </footer>
    </div>
     
    


    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.stellar.min.js"></script>
    <script src="js/scrollReveal.min.js"></script>
    <script src="js/slick.min.js"></script>
    <script src="js/wow.min.js"></script>
   <script src="js/main.js"></script> 

  <!-- <script type="text/javascript" src="mesh.js"></script> -->


  


  <!-- riot messenger code -->

    <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-65874825-1', 'auto');
  ga('send', 'pageview');

</script>
 
<script src="js/jquery.countdown.min.js"></script>



  </body>
</html>