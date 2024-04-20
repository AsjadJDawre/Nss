<?php
session_start();
require_once('config.php'); 
require('fpdf/fpdf.php');


// Redirect if not logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: login.php");
    exit();
}


$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'login';


// Check if the form was submitted and userInput is not empty
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['userInput'])) {
    
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve and sanitize the scrolling text from the form
    $newText = $conn->real_escape_string($_POST["userInput"]);

    // Update the database with new text
    $sql = "UPDATE content_text SET scrolling_text='$newText'";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['success'] = true; // Set a session variable for success message
        $conn->close();
        header("Location: welcome.php");
        exit();
    } else {
        echo "Error updating scrolling text: " . $conn->error;
    }

    $conn->close();
}

if($_SERVER["REQUEST_METHOD"]=="POST"&& !empty($_POST['news_card'])){
    $conn=new mysqli($servername,$username,$password,$dbname);
    
    if($conn->connect_error){
        die("Connection Failed !! ".$conn->connect_error);
    }
    $newsdata=$conn->real_escape_string($_POST['news_card']);
    
    $sql="UPDATE content_text SET news_card='$newsdata'";

    if($conn->query($sql)== TRUE){
        $_SESSION['success']= TRUE;
        $conn->close();
        header('Location: welcome.php');
        exit();
    }
    else{
        echo "Error Updating the news Data ".$conn->error;
    }
}



$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


    $news = "";
    $notification = "";
    
    if(isset($_POST['news_card'])) {
        $newsText = $_POST['news_card'];
        $sql = "UPDATE content_text SET news='$newsText'";
        $conn->query($sql);
    
        $_SESSION['news'] = $newsText; // Store in session
    }
    
    if(isset($_POST['notification'])) {
        $notificationText = $_POST['notification'];
        $sql = "UPDATE content_text SET notification='$notificationText'";
        $conn->query($sql);
    
        $_SESSION['notification'] = $notificationText; // Store in session
    }
    




    if(isset($_SESSION['news'])) {
        $news = $_SESSION['news'];
    } else {
        $sql = "SELECT news FROM content_text";
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $news = isset($row["news"]) ? $row["news"] : "";
        }
    }
    
    if(isset($_SESSION['notification'])) {
        $notification = $_SESSION['notification'];
    } else {
        $sql = "SELECT notification FROM content_text";
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $notification = isset($row["notification"]) ? $row["notification"] : "";
        }
    }
   
 

    
    // Default or initial data when the page loads
    $tableData = [];
    $tableData1=[];
    
    // Handle form submissions
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["category"])) {
            $selectedCategory = $_POST["category"];
            // Query the database for students in the selected category
            $query = "SELECT username, gender, address, department, year, dob, category, contact 
            FROM users 
            WHERE category = '$selectedCategory' 
            ORDER BY 
              CASE 
                WHEN year = 'FE' THEN 1 
                WHEN year = 'SE' THEN 2 
                WHEN year = 'TE' THEN 3 
                WHEN year = 'BE' THEN 4 
                ELSE 5 
              END ASC,
              CASE 
                WHEN department = 'Computer' THEN 1 
                WHEN department = 'Mechanical' THEN 2 
                WHEN department = 'Civil' THEN 3 
                ELSE 4 
              END ASC,
              year ASC";
        
    
    
          $result = mysqli_query($conn, $query);
    
            if ($result && mysqli_num_rows($result) > 0) {
                // Build the table data
                while ($row = mysqli_fetch_assoc($result)) {
                    $tableData[] = $row;
                }
                mysqli_free_result($result); // Free the result set
            }
        }
    
       
    }
    
        if (isset($_POST["year"])) {
            $year = $_POST["year"];
            // Query the database for students in the selected category
            $query = "SELECT username, gender, address, department, year, dob, category, contact 
            FROM users 
            WHERE year = '$year' 
            ORDER BY 
              CASE 
                WHEN year = 'FE' THEN 1 
                WHEN year = 'SE' THEN 2 
                WHEN year = 'TE' THEN 3 
                WHEN year = 'BE' THEN 4 
                ELSE 5 
              END ASC,
              CASE 
                WHEN department = 'Computer' THEN 1 
                WHEN department = 'Mechanical' THEN 2 
                WHEN department = 'Civil' THEN 3 
                ELSE 4 
              END ASC,
              year ASC";
        
    
    
          $result = mysqli_query($conn, $query);
    
            if ($result && mysqli_num_rows($result) > 0) {
                // Build the table data
                while ($row = mysqli_fetch_assoc($result)) {
                    $tableData1[] = $row;
                }
                mysqli_free_result($result); // Free the result set
            }
        }
    
       
        
            
    
        if (isset($_POST["delete_submit"])) {
            $deleteName = mysqli_real_escape_string($conn, $_POST["delete_name"]);
    
            // Query to delete the record based on the provided name
            $deleteSql = "DELETE FROM users WHERE username = '$deleteName'";
            $deleteResult = mysqli_query($conn, $deleteSql);
    
            if ($deleteResult) {
                echo '<div id="successAlert1" class="alert alert-success" role="alert">
                        Record of ' . $deleteName . ' has been deleted successfully.
                      </div>';
                      header("Location:welcome.php".$_SERVER['PHP_SELF']); // Redirect to the same page
    
            
            } else {
                echo "Error deleting record: " . mysqli_error($conn);
            }
        }
        
        $conn->close();


?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
          crossorigin="anonymous">
          <link
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


    <title>Nss login system!</title>
    <style>
                body {
    margin: 0;
    padding-top: 60px;


}
        /* Define the default styles for .navbar and .box1 */
        .navbar {
            width: 100%; /* Adjust this width as needed */
        }

        .box1 {
            margin-top: 15px;
            width: 100%; 
            position: sticky;
            left: 400px;
        }

        /* Media query for smaller screens */
        @media screen and (min-width: 320px) and (max-width: 425px) {
   .box1{
     width:75%;
   }
   .logo{
     margin-top:-24vh;
   }
}

@media screen and (max-width: 765px) {
    .box1 {
        width: 200px; 
        font-size:13px;
    }
    .logo{
      margin-top:-9vh;

    }
}



        @media screen and (max-width: 767px) {
            .navbar, .box1 {
                width: 100%; /* Adjust the width for smaller screens */
            }
        }






        .header {
            display: flex;
            align-items: center;
            flex-wrap: wrap; 
        }

        .logo {
            width: 50px; /* Adjust the size of the logo as needed */
            height: auto;
            margin-right: 10px;
            margin-top:-1vh;
         
        }

        .subtitle {
    display: block; /* Ensure the subtitle is on a new line */
    text-align: center; /* Center the text */
    font-size: smaller; /* Adjust the font size as needed */
    margin-top: 5px; /* Add space between the sentences */
    color: #777; /* Adjust the color as needed */
}

        .box-text {
            margin-top: 5px;
            text-align: center;
        }
        .box2{
            height:100vh;
            width:100%;
            display:flex;
            justify-content:center;
            
        }


.scrolling-text {
    width: 100%;
    height: 50px; /* Set the height of the scrolling area */
    overflow: hidden; /* Hide overflowing content */
    position: relative;
    background-color: #f0f0f0;
    margin-top:50px;
}

.scrolling-text p {
    white-space: nowrap; /* Prevent text from wrapping */
    position: absolute;
    padding:12px 5px 4px;
    animation: scrolling 11s linear infinite; 
    right:0;
    transform: translateX(100%); 
}

@keyframes scrolling {
    0% {
        transform: translateX(100%);
    }
    100% {
        transform: translateX(-350%);
    }
}
.hidden-content {
            display: none;
        }
        .close-button {
            top: 10px;
            right: 10px;
            color: red;
            cursor: pointer;
        }
      .close-button{
        color:red;
      }

      .input-btn:hover{
        color:white;
        font-family: Serif;
        background-color:green;
      }
      .close-button:hover{
          background-color:red;
          color:white;

      }

/* Basic styling for the card */
.card {
    border: 2px solid #003355;
    border-radius: 10px;
    padding: 20px;
    margin: 20px;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    background-color: #f9f9f9;
    width: 400px; /* Fixed width */
    height: 400px; /* Fixed height */
    /* overflow: auto; Allow scrollbars when content overflows */
}

/* Styling for the card header */
.card-header1 {
    background-color: #003355;
    padding: 15px;
    border-radius: 8px 8px 0 0;
    color: #fff;
    text-align: center;
}

/* Styling for the news text */
.card-body p {
    margin: 0;
    font-size: 18px;
    line-height: 1.6;
    color: #333;
    overflow: auto;
    max-height: 100%; /* Allow text to expand within the container */
    word-wrap: break-word; /* Wrap long words */
}

.parent_card {
    display: flex;
    justify-content: space-between; /* Aligns items with space between */
    gap: 150px; /* Sets the gap between items */
}

#news_inp {
    border: 2.5px solid #003355;
    width: 600px;
    padding: 10px; /* Reduce padding */
    border-radius: 18px;
    margin-left: 50px;
}
#news_inp h2 {
    margin-left: 0; /* Reset margin-left */
    margin-top: 0; /* Reset margin-top */
    padding-left: 65px; /* Adjust padding to position text */
}

#notification_inp {
    border: 2.5px solid #003355;
    width: 600px;
    padding: 10px; /* Reduce padding */
    border-radius: 18px;
    margin-left: 50px;
}
.table_data{
    height: auto;
    width: auto;
    margin-left: 100px;
    margin-top: 10vh;
}

table {
            border-collapse: collapse;
            width: 100%;
            border: 2px solid #003355; /* Adding border to the table */
        }

        th, td {
            border: 1px solid #003355; /* Adding borders to table cells */
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #003355; /* Setting background color for table heading */
            color: white;
        }

        input[type="submit"] {
            background-color:#0256bd ; /* Setting button color */
            color: white;
            border: none;
            padding: 8px 12px;
            cursor: pointer;
            margin-left: 15vh;

            border-radius: 12px;

        }
        .Buttons{
            margin:20px 5px 5px;
        }
        .pdf-link {
            display:flex;
            padding: 8px 12px;
    background-color: #003355;
    border-radius: 14px; 
    color: white;
    text-decoration: none;
    margin-top: 10px;
    margin-right: 100px;
    margin-left: 8px;
    width: auto;
    height: auto;
}


        .pdf-link:hover {
            background-color: #005d91;
            color:white;
            text-decoration: none;

        }
        #heading{
            font-family:emoji,serif;
            width:auto;
            height:auto;
            background-color: #003355;
            text-align: center;
         color: white;
         border-radius: 10px;
        }
        label{
            margin-top: 35px;
    padding: 5px 6px;
    background-color: #003355;
    color: white;
    width: auto;
    margin-left: 15px;
    border-radius: 5px;
    height: auto;
        }
select{
    color: white;
    background-color: #054773;
}

      /* Styles for the pop-up card */
      .popup-card {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 40px; /* Increased padding */
            border-radius: 10px; /* Increased border radius */
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
            z-index: 1000; /* Ensure it appears above other content */
            max-width: 400px; /* Set maximum width */
            width: 80%; /* Set width as a percentage */
        }

        /* Styles for the blurred background */
        .blur-background {
            display: none; /* Initially hidden */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent black */
            backdrop-filter: blur(5px); /* Apply blur effect */
            z-index: 999; /* Ensure it's behind the pop-up card */
        }

        /* Styles for input box */
        .popup-card textarea {
            height: 100px; /* Increased height */
            width: 90%; /* Set width to 90% of the pop-up card */
            resize: none; /* Disable resizing */
        }

        /* Styles for buttons */
        .popup-card button {
            margin-top: 10px; /* Add margin between buttons */
        }

        /* Flex container for parent cards */
        .parent_card {
            display: flex;
            justify-content: space-around; /* Adjust as needed */
            margin-bottom: 20px; /* Add some space between parent cards */
        }

        /* Adjust card width */
        .card {
            /* width: 45%; Adjust card width */
        }

/* Styles for the blurred background */
        .blur-background {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(10px); /* Increased blur */
            z-index: 999;
        }
        .popup-card button {
            margin-top: 20px; /* Space between buttons */
            padding: 10px 20px; /* Increased padding */
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        /* Style for close button */
        .popup-card .close-button {
            background-color: #ff5e5e; /* Red color for close button */
            color: white;
        }
        #userInput {
            /* Increased height */
            height: 100px;
            width: 90%;
            resize: none; /* Disable resizing */
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark " style="background-color:#042d41;      position: fixed;
    top: 0;
    z-index: 999;color:white;">
    <a class="navbar-brand" style="margin-left: 65px;" href="#">Nss Login System</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="welcome.php">Home <span class="sr-only">(current)</span></a>
            </li>
          
            <li class="nav-item active">
                <a class="nav-link" href="admin.php"> Access Control </a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="gall_uploads.php"> Upload Photos </a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="Logout.php"> Logout </a>
            </li>
        </ul>
        <div class="navbar-collapse collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#"> <img src="https://img.icons8.com/metro/26/000000/guest-male.png">
                        <?php echo "Welcome " . $_SESSION['username'] ?></a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="box1 col-sm-8">
    <div class="header">
        <img src="gmvit_logo-removebg-preview.png" alt="Logo" class="logo">
        <div>
            <h6>Sant Gajanant Maharaj Vedak Institute of Technology (GMVIT)
                <span class="subtitle">Admissions A.Y. 2023-24 Tala Nss Dashboard</span>
            </h6>
            <div class="box-text">
                Undergraduate Programs in Engineering and Technology (4 Years)
            </div>
        </div>
    </div>
</div>


</form>

<?php
    if (isset($_SESSION['success']) && $_SESSION['success'] === true) {
        echo '<div id="successAlert" class="alert alert-success" role="alert">
            Scrolling text updated successfully.
          </div>';
        unset($_SESSION['success']); // Clear the success flag
    }
    ?>


<form id="textInputForm" method="post" action="">

<div class="scrolling-txt" id="scrollingText" onclick="showPopup()">
        <div class="scrolling-text">
            <?php
            // Establish database connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Retrieve scrolling text from the database
            $sql = "SELECT scrolling_text FROM content_text";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Output data
                while ($row = $result->fetch_assoc()) {
                    echo '<p>' . $row["scrolling_text"] . '</p>';
                }
            } else {
                // If no data found, display default text
                echo '<p>This is an example of scrolling text using CSS.</p>';
            }

            $conn->close();
            ?>
        </div>
    </div>

   <!-- Scrolling Content Popup -->
<div class="popup-card" id="popupCard2">
    <h2>Scrolling Content</h2>
    <form id="textInputForm" method="post" action="welcome.php">
        <label for="userInput">Enter Text</label>
        <textarea id="userInput" name="userInput" required style="margin-left: 22px;"></textarea>
        <div class="button-container">
            <button type="submit" class="input-btn">Add Text</button>
            <button type="button" class="close-button" onclick="hidePopup('scrolling')">Close Window</button>
        </div>
    </form>
</div>

<!-- Background blur for Scrolling Content Popup -->
<div class="blur-background" id="blurBackground2"></div>

<!-- Parent Card Section -->
<div class="parent_card">
    <!-- News Component Card -->
    <div class="card homepage aos-init aos-animate" onclick="showPopup('news')" data-aos="fade-down" data-aos-easing="linear" data-aos-duration="2000">
        <div class="card-header1">
            <span class="news"><img src="news.gif" alt="" style="height:auto; width:45px; filter:invert(100%) brightness(200%); ">  News</span>
        </div>
        <div class="card-body">
            <marquee align="justify" direction="up" onmouseout="this.start()" height="230px" onmouseover="this.stop()" scrollamount="2" scrolldelay="60">
                <p align="justify"><?php echo $news; ?></p>
            </marquee>
        </div>
    </div>

    <!-- Notification Component Card -->
    <div class="card homepage aos-init aos-animate" onclick="showPopup('notification')" data-aos="fade-down" data-aos-easing="linear" data-aos-duration="2000">
        <div class="card-header1">
            <span class="news"><img src="notification-bell.gif" alt="" style="height:auto; width:30px;filter:brightness(100%); ">  Notifications</span>
        </div>
        <div class="card-body">
            <marquee align="justify" direction="up" onmouseout="this.start()" height="230px" onmouseover="this.stop()" scrollamount="2" scrolldelay="60">
                <p align="justify"><?php echo $notification; ?></p>
            </marquee>
        </div>
    </div>
</div>

<!-- Popup card for News -->
<div class="popup-card" id="popupCardNews">
    <h2 style="margin-left: 65px;margin-top: 15px;">News Input</h2>
    <form id="textInputFormNews" method="post" action="welcome.php">
        <label for="userInputNews">Enter Text:</label>
        <textarea id="userInputNews" name="userInputNews" required></textarea>
        <div class="button-container">
            <button type="submit" class="input-btn">Add Text</button>
            <button type="button" class="close-button" onclick="hidePopup('news')">Close Window</button>
        </div>
    </form>
</div>

<!-- Popup card for Notification -->
<div class="popup-card" id="popupCardNotification">
    <h2 style="margin-left: 65px;margin-top: 15px;">Notification Input</h2>
    <form id="textInputFormNotification" method="post" action="welcome.php">
        <label for="userInputNotification">Enter Details:</label>
        <textarea id="userInputNews" name="userInputNews" required></textarea>
        <div class="button-container">
            <button type="submit" class="input-btn">Add Data</button>
            <button type="button" class="close-button" onclick="hidePopup('notification')">Close Window</button>
        </div>
    </form>
</div>

<!-- Background blur for News Popup -->
<div class="blur-background" id="blurBackgroundNews"></div>

<!-- Background blur for Notification Popup -->
<div class="blur-background" id="blurBackgroundNotification"></div>




    



        
<a href="student_repo.php">
  <input type="button" value="Get Report" class="pdf-link" id="action_btn">
</a>



    
 

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>




        <script>
// Function to show/hide scrolling text pop-up
document.addEventListener("DOMContentLoaded", function() {
    var scrollingText = document.getElementById("scrollingText");
    scrollingText.addEventListener("click", showPopupScrolling);
});

function showPopupScrolling() {
    document.getElementById("popupCard2").style.display = "block";
    document.getElementById("blurBackground2").style.display = "block";
}

function hidePopupScrolling() {
    document.getElementById("popupCard2").style.display = "none";
    document.getElementById("blurBackground2").style.display = "none";
}

// Function to show/hide news and notification pop-ups
function showPopup(type) {
    if (type === 'news') {
        document.getElementById("blurBackgroundNews").style.display = "block";
        document.getElementById("popupCardNews").style.display = "block";
    } else if (type === 'notification') {
        document.getElementById("blurBackgroundNotification").style.display = "block";
        document.getElementById("popupCardNotification").style.display = "block";
    }
}

function hidePopup(type) {
    if (type === 'news') {
        document.getElementById("blurBackgroundNews").style.display = "none";
        document.getElementById("popupCardNews").style.display = "none";
    } else if (type === 'notification') {
        document.getElementById("blurBackgroundNotification").style.display = "none";
        document.getElementById("popupCardNotification").style.display = "none";
    } else if (type === 'scrolling') {
        hidePopupScrolling();
    }
}


    // Other functions for your webpage
    function showContent() {
        let content = document.getElementById("hiddenContent");
        content.style.display = "block";
    }

    function addText() {
        let userInput = document.getElementById("userInput").value;
        let scrollingText = document.getElementById("scrollingText").getElementsByTagName("p")[0];
        scrollingText.textContent = userInput;
    }

    function hideContent() {
        let hiddenContent = document.getElementById("hiddenContent");
        hiddenContent.style.display = "none";
        let closeButton = document.getElementById("closeButton");
        closeButton.style.display = "none";
    }

    function card_data() {
        let content = document.getElementById("news_inp");
        content.style.display = "block";
    }

    function hide_card() {
        let card = document.getElementById("news_inp");
        card.style.display = "none";
    }

    function notification_data() {
        let content = document.getElementById("notification_inp");
        content.style.display = "block";
    }

    function hide_card2() {
        let card = document.getElementById("notification_inp");
        card.style.display = "none";
    }

    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            var alert = document.getElementById('successAlert1');
            if (alert) {
                alert.style.display = 'none'; // Hide the alert after 3 seconds
            }
        }, 3000); // 3000 milliseconds = 3 seconds
    });
</script>


</body>
</html>
