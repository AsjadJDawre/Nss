<?php
session_start();
require_once('config.php'); 
require('fpdf/fpdf.php');


$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'login';


$conn = new mysqli($servername, $username, $password, $dbname);

if (!isset($_SESSION['username'])) {
    header("location: login.php");
    exit;
}

// Access the username
$student = $_SESSION['username'];
    // print $student ;




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
   
 
    $sql = "SELECT * FROM users WHERE student_email = '$student'"; // Modify this query to suit your needs
    $result = mysqli_query($conn, $sql);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    }
    
  
   
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css"  rel="stylesheet" />
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
    padding: 0;

}
        /* Define the default styles for .navbar and .box1 */
        .navbar {
            width: 100%; /* Adjust this width as needed */
        }

        .box1 {
            margin-top: 15px;
            width: 100%; 
            position: sticky;
            left: 0;
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
    margin-top:80px;
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
            display: inline-block;
            padding: 8px 12px;
            background-color: #003355;
            border-radius: 14px;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
            margin-left:8px;
            width:auto;
            height:auto;
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
      .sub-menue-wrap{
          position: absolute;
          top:100%;
          right:10%;
          width:320px;
      }
      .sub-menue{
          background: #fff;
          padding:20px;
          margin:10px;
      }
      /* CSS Styles for the animated window */
.animated-window {
    display: none;
    position: absolute;
    top: 60px; /* Adjust this value to position the window */
    right: 20px;
    background-color: #fff;
    border: 1px solid #ccc;
    padding: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.animated-window a {
    display: block;
    padding: 6px 9px;
    text-decoration: none;
    color: #333;
    transition: background-color 0.3s ease;
}

.animated-window a:hover  {
    background-color: #003355db;
    color:white;
}

.animated-window a:hover img {
    filter: brightness(30);
}
 /* Google Font Link */
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');
*{
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Poppins" , sans-serif;
}
.sidebar{
  position: fixed;
  left: 0;
  top: 0;
  height: 100%;
  width: 78px;
  background: #11101D;
  padding: 6px 14px;
  z-index: 99;
  transition: all 0.5s ease;
}
.sidebar.open{
  width: 250px;
}
.sidebar .logo-details{
  height: 60px;
  display: flex;
  align-items: center;
  position: relative;
}
.sidebar .logo-details .icon{
  opacity: 0;
  transition: all 0.5s ease;
}
.sidebar .logo-details .logo_name{
  color: #fff;
  font-size: 20px;
  font-weight: 600;
  opacity: 0;
  transition: all 0.5s ease;
}
.sidebar.open .logo-details .icon,
.sidebar.open .logo-details .logo_name{
  opacity: 1;
}
.sidebar .logo-details #btn{
  position: absolute;
  top: 50%;
  right: 0;
  transform: translateY(-50%);
  font-size: 22px;
  transition: all 0.4s ease;
  font-size: 23px;
  text-align: center;
  cursor: pointer;
  transition: all 0.5s ease;
}
.sidebar.open .logo-details #btn{
  text-align: right;
}
.sidebar i{
  color: #fff;
  height: 60px;
  min-width: 50px;
  font-size: 28px;
  text-align: center;
  line-height: 60px;
}
.sidebar .nav-list{
  margin-top: 20px;
  height: 100%;
}
.sidebar li{
  position: relative;
  margin: 8px 0;
  list-style: none;
}
.sidebar li .tooltip{
  position: absolute;
  top: -20px;
  left: calc(100% + 15px);
  z-index: 3;
  background: #fff;
  box-shadow: 0 5px 10px rgba(0, 0, 0, 0.3);
  padding: 6px 12px;
  border-radius: 4px;
  font-size: 15px;
  font-weight: 400;
  opacity: 0;
  white-space: nowrap;
  pointer-events: none;
  transition: 0s;
}
.sidebar li:hover .tooltip{
  opacity: 1;
  pointer-events: auto;
  transition: all 0.4s ease;
  top: 50%;
  transform: translateY(-50%);
}
.sidebar.open li .tooltip{
  display: none;
}
.sidebar input{
  font-size: 15px;
  color: #FFF;
  font-weight: 400;
  outline: none;
  height: 50px;
  width: 100%;
  width: 50px;
  border: none;
  border-radius: 12px;
  transition: all 0.5s ease;
  background: #1d1b31;
}
.sidebar.open input{
  padding: 0 20px 0 50px;
  width: 100%;
}
.sidebar .bx-search{
  position: absolute;
  top: 50%;
  left: 0;
  transform: translateY(-50%);
  font-size: 22px;
  background: #1d1b31;
  color: #FFF;
}
.sidebar.open .bx-search:hover{
  background: #1d1b31;
  color: #FFF;
}
.sidebar .bx-search:hover{
  background: #FFF;
  color: #11101d;
}
.sidebar li a{
  display: flex;
  height: 100%;
  width: 100%;
  border-radius: 12px;
  align-items: center;
  text-decoration: none;
  transition: all 0.4s ease;
  background: #11101D;
}
.sidebar li a:hover{
  background: #FFF;
}
.sidebar li a .links_name{
  color: #fff;
  font-size: 15px;
  font-weight: 400;
  white-space: nowrap;
  opacity: 0;
  pointer-events: none;
  transition: 0.4s;
}
.sidebar.open li a .links_name{
  opacity: 1;
  pointer-events: auto;
}
.sidebar li a:hover .links_name,
.sidebar li a:hover i{
  transition: all 0.5s ease;
  color: #11101D;
}
.sidebar li i{
  height: 50px;
  line-height: 50px;
  font-size: 18px;
  border-radius: 12px;
}
.sidebar li.profile{
  position: fixed;
  height: 60px;
  width: 78px;
  left: 0;
  bottom: -8px;
  padding: 10px 14px;
  background: #1d1b31;
  transition: all 0.5s ease;
  overflow: hidden;
}
.sidebar.open li.profile{
  width: 250px;
}
.sidebar li .profile-details{
  display: flex;
  align-items: center;
  flex-wrap: nowrap;
}
.sidebar li img{
  height: 45px;
  width: 45px;
  object-fit: cover;
  border-radius: 6px;
  margin-right: 10px;
}
.sidebar li.profile .name,
.sidebar li.profile .job{
  font-size: 15px;
  font-weight: 400;
  color: #fff;
  white-space: nowrap;
}
.sidebar li.profile .job{
  font-size: 12px;
}
.sidebar .profile #log_out{
  position: absolute;
  top: 50%;
  right: 0;
  transform: translateY(-50%);
  background: #1d1b31;
  width: 100%;
  height: 60px;
  line-height: 60px;
  border-radius: 0px;
  transition: all 0.5s ease;
}
.sidebar.open .profile #log_out{
  width: 50px;
  background: none;
}
.home-section{
  position: relative;
  background: #003355;
  top: 0;
  left: 78px;
  width: calc(100% - 78px);
  transition: all 0.5s ease;
  z-index: 2;
}
.sidebar.open ~ .home-section{
  left: 250px;
  width: calc(100% - 250px);
}
.home-section .text{
  display: inline-block;
  color: white;
  font-size: 25px;
  font-weight: 500;
  margin: 18px
}
@media (max-width: 420px) {
  .sidebar li .tooltip{
    display: none;
  }
}


    </style>
</head>
<body>
    
<div class="sidebar">
      <div class="logo-details">
        <i class="bx bx-user"></i>
        <div class="logo_name"><?php echo $row['username']; ?></div>
        <i class="bx bx-menu" id="btn"></i>
      </div>
      <ul class="nav-list">
        <li>
          <div class="profile-details">
          <!-- <?php
$studentEmail = $row['student_email'];
$sql = "SELECT photo FROM users WHERE student_email = '$studentEmail'";
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
  $photoRow = mysqli_fetch_assoc($result);
  $photoName = $photoRow['photo'];
  $photoPath = "C:/xampp/htdocs/NSS/images/" . $photoName;

  // Check if the photo path is not empty and the file exists
  if (!empty($photoPath) && file_exists($photoPath)) {
    echo '<img src="' . $photoPath . '" alt="profileImg" />';
  } else {
    // Display a default image if the photo path is empty or the file doesn't exist
    echo '<img src="default_profile.jpg" alt="profileImg" />';
  }
} else {
  // Display a default image if there is an error fetching the photo
  echo '<img src="profile.jpg" alt="profileImg" />';
}
?> -->
<div class="name_job">
            </div>
          </div>
        </li>
        <li>
          <a href="#">
            <i class="bx bx-home"></i>
            <span class="links_name">Home</span>
          </a>
          <span class="tooltip">Home</span>
        </li>
        <li>
          <a href="Logout.php">
            <i class="bx bx-log-out"></i>
            <span class="links_name">Logout</span>
          </a>
          <span class="tooltip">Logout</span>
        </li>
        <li>
          <a href="javascript:void(0);" id="editProfileLink">
            <i class="bx bx-edit"></i>
            <span class="links_name">Edit Profile</span>
          </a>
          <span class="tooltip">Edit Profile</span>
        </li>
        <li>
          <a href="#">
            <i class="bx bx-question-mark"></i>
            <span class="links_name">Help and Support</span>
          </a>
          <span class="tooltip">Help and Support</span>
        </li>
        <li>
          <div class="welcome-message">
          
          </div>
        </li>
      </ul>
    </div>
    <section class="home-section">
      <div class="text">Dashboard</div>
    </section>
  
    <div class="moved_cent" style="    margin-left: 15vh;
">
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
</div>


</form>


<form id="textInputForm" method="post" action="">

<div class="scrolling-txt" id="scrollingText">
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
            echo '<p>Error Loating the Scrolling Text .</p>';
        }

        $conn->close();
        ?>
    </div>
</div>


    </div>
    <div class="parent_card">

    <div class="card homepage aos-init aos-animate"   data-aos="fade-down" data-aos-easing="linear" data-aos-duration="2000" style="
    margin-left: 35vh;
">
        <div class="card-header1">
            <span id="rightContainer_ContentTable2_lblPanel2" class="news"><img src="news.gif" alt="" style="height:auto; width:45px; filter:invert(100%) brightness(200%); ">  News</span>
        </div>
        <div class="card-body">
            <marquee id="rightContainer_ContentTable2_panel2" align="justify" direction="up" onmouseout="this.start()" height="230px" onmouseover="this.stop()" scrollamount="2" scrolldelay="60">
                <p align="justify"><?php echo $news; ?>
                </p>
            </marquee>
        </div>
    </div>



    <div class="card homepage aos-init aos-animate"  data-aos="fade-down" data-aos-easing="linear" data-aos-duration="2000">
        <div class="card-header1">
            <span id="rightContainer_ContentTable2_lblPanel2" class="news"><img src="notification-bell.gif" alt="" style="height:auto; width:30px;filter:brightness(100%); ">  Notifications</span>
        </div>
        <div class="card-body">
            <marquee id="rightContainer_ContentTable2_panel2" align="justify" direction="up" onmouseout="this.start()" height="230px" onmouseover="this.stop()" scrollamount="2" scrolldelay="60">
                <p align="justify"><?php echo $notification; ?>
                </p>
            </marquee>
        </div>
    </div>
</div>



    </div>
    </div>
 
</form>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        let sidebar = document.querySelector(".sidebar");
let closeBtn = document.querySelector("#btn");
let searchBtn = document.querySelector(".bx-search");

closeBtn.addEventListener("click", ()=>{
  sidebar.classList.toggle("open");
  menuBtnChange();//calling the function(optional)
});

searchBtn.addEventListener("click", ()=>{ // Sidebar open when you click on the search iocn
  sidebar.classList.toggle("open");
  menuBtnChange(); //calling the function(optional)
});

// following are the code to change sidebar button(optional)
function menuBtnChange() {
 if(sidebar.classList.contains("open")){
   closeBtn.classList.replace("bx-menu", "bx-menu-alt-right");//replacing the iocns class
 }else {
   closeBtn.classList.replace("bx-menu-alt-right","bx-menu");//replacing the iocns class
 }
}

    </script>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
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

document.addEventListener('DOMContentLoaded', function () {
    const menuIcon = document.getElementById('menuIcon');
    const menuOptions = document.getElementById('menuOptions');

    menuIcon.addEventListener('click', function (e) {
        e.stopPropagation(); // Prevent the click from propagating to document
        menuOptions.style.display = (menuOptions.style.display === 'block') ? 'none' : 'block';
    });

    // Close the menu when clicking outside the menu
    document.addEventListener('click', function (e) {
        if (!menuOptions.contains(e.target) && e.target !== menuIcon) {
            menuOptions.style.display = 'none';
        }
    });
});


    </script>
    <script>
      document.getElementById("editProfileLink").addEventListener("click", function() {
            sendApprovalRequest();
        });

        function sendApprovalRequest() {
            // Assuming $result contains the student information
            var username = "<?php echo $result['username']; ?>";
            var contactNumber = "<?php echo $result['contactNumber']; ?>";
            var studentEmail = "<?php echo $result['studentEmail']; ?>";

            // Create a data object to be sent in the AJAX request
            var data = {
                username: username,
                contactNumber: contactNumber,
                studentEmail: studentEmail
            };

            // Send AJAX request to the server
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "send_approval_request.php", true);
            xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
            xhr.send(JSON.stringify(data));

            // Handle the response from the server
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        // Check if the response is positive (you might need to adjust this based on your actual response)
                        if (xhr.responseText.trim().toLowerCase() === 'approved') {
                            // Redirect to the edit_profile_page.php if the response is positive
                            window.location.href = "edit_profile_page.php";
                        } else {
                            // Handle the case where the response is not positive (optional)
                            window.location.href = "Error.php";
                        }
                    } else {
                        // Handle the case where the AJAX request fails (optional)
                        console.log("Error in AJAX request.");
                        window.location.href = "Error.php";
                    }
                }
            };
        }
    </script>
    </script>
</body>
</html>