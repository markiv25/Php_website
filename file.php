<?php
require_once"./PDO.DB.class.php";
$db = new DB();
$data = $db->getAllEvents();
?>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <link rel="stylesheet" href="./css/file.css">
    <link rel="apple-touch-icon" type="image/png"
        href="https://cpwebassets.codepen.io/assets/favicon/apple-touch-icon-5ae1a0698dcc2402e9712f7d01ed509a57814f994c660df9f7a952f3060705ee.png">
    <meta name="apple-mobile-web-app-title" content="CodePen">

    <link rel="shortcut icon" type="image/x-icon"
        href="https://cpwebassets.codepen.io/assets/favicon/favicon-aec34940fbc1a6e787974dcd360f2c6b63348d4b1f4e06c77743096d55480f33.ico">

    <link rel="mask-icon" type="image/x-icon"
        href="https://cpwebassets.codepen.io/assets/favicon/logo-pin-8f3771b1072e3c38bd662872f6b673a722f4b3ca2421637d5596661b4e2132cc.svg"
        color="#111">
        <link href="https://fonts.googleapis.com/css?family=Poppins:900" rel="stylesheet">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
  

    <title>Events Page:</title>




    
    <script>
        window.console = window.console || function (t) { };
    </script>



    <script>
        if (document.location.search.match(/type=embed/gi)) {
            window.parent.postMessage("resize", "*");
        }
    </script>


</head>
<video playsinline autoplay muted loop poster="polina.jpg" id="bgvid">
  <source src="polina.webm" type="video/webm">
  <source src="polina.mp4" type="video/mp4">
</video>
<body translate="no" data-new-gr-c-s-check-loaded="14.1052.0" data-gr-ext-installed="" style="background-image:url('https://assets.codepen.io/1462889/back-page.svg');background-size: cover;";
 >
    <h1>Events Page:</h1>
  
    <ul>
    <?php  $Stringdata="";

foreach($data as $i){
    $Stringdata= $i->whoAmI();
  $img=$Stringdata["name"].'.jpg';  
  $ses_data=$db->getsess($Stringdata["idevent"]);
  
  
echo"
  
    <li class='booking-card'
            style='background-image: url(./assets/$img)'> 
            <div class='book-container'>
                <div class='content'>
                ";
                    foreach($ses_data as $j){
                        $Sata= $j->sess();
                   echo" <button class='btn'>  $Sata[name]</button>";                   }
            echo"</div>
            </div>
            <div class='informations-container'>
                <h2 class='title'>$Stringdata[name]</h2>
                <p class='sub-title'>Hover here to view more Details</p>
                <p class='price'><svg class='icon' style='width:24px;height:24px' viewBox='0 0 24 24'>
                        <path fill='currentColor'
                            d='M3,6H21V18H3V6M12,9A3,3 0 0,1 15,12A3,3 0 0,1 12,15A3,3 0 0,1 9,12A3,3 0 0,1 12,9M7,8A2,2 0 0,1 5,10V14A2,2 0 0,1 7,16H17A2,2 0 0,1 19,14V10A2,2 0 0,1 17,8H7Z'>
                        </path>
                    </svg>Venue :$Stringdata[venue_name]</p>
                <div class='more-information'>
                    <div class='info-and-date-container'>
                        <div class='box info'>
                            <svg class='icon' style='width:24px;height:24px' viewBox='0 0 24 24'>
                                <path fill='currentColor'
                                    d='M11,9H13V7H11M12,20C7.59,20 4,16.41 4,12C4,7.59 7.59,4 12,4C16.41,4 20,7.59 20,12C20,16.41 16.41,20 12,20M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M11,17H13V11H11V17Z'>
                                </path>
                            </svg>
                            <p>People Allowed :$Stringdata[numberallowed]</p>
                        </div>
                        <div class='box date'>
                            <svg class='icon' style='width:24px;height:24px' viewBox='0 0 24 24'>
                                <path fill='currentColor'
                                    d='M19,19H5V8H19M16,1V3H8V1H6V3H5C3.89,3 3,3.89 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3H18V1M17,12H12V17H17V12Z'>
                                </path>
                            </svg>
                            <p>$Stringdata[datestart]</p>
                        </div>
                    </div>";
                    foreach($ses_data as $j){
                        $Sata= $j->sess();
                   echo" <p class='disclaimer'>$Sata[name] </p>";
                   
                }
                echo"
                </div>
            </div>
        </li>
        ";
    
}
        ?>
    </ul>

</body>

</html>