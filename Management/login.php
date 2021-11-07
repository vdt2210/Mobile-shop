<?php
include('../Share/Services/session.php');
include('../Share/stafffunctions.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   // username and password sent from form 

   $myusername = mysqli_real_escape_string($db, $_POST['username']);
   $mypassword = mysqli_real_escape_string($db, $_POST['password']);

   $sql = "SELECT id FROM admin WHERE username = '$myusername' and accpassword = '$mypassword'";
   $result = mysqli_query($db, $sql);
   $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

   $count = mysqli_num_rows($result);

   // If result matched $myusername and $mypassword, table row must be 1 row

   if ($count == 1) {
      //  session_register("myusername");
      $_SESSION['login_user'] = $myusername;
      header("location:welcome.php");
   } else {
      echo '<script type="text/javascript">';
      echo 'alert("Your Login Name or Password is invalid")';
      echo '</script>';
   }
}
?>
<?= template_header() ?>

<body>
   <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
         <div class="container-fluid">
            <a class="brand" href="#">Admin Panel</a>
            <!--/.nav-collapse -->
         </div>
      </div>
   </div>
   <div align="center">
      <div>
         <form action="" method="post">
            <h1 style="font-size:30px">Login</h1>
            <input type="text" name="username" class="box" placeholder="Username" required /><br /><br />
            <input type="password" name="password" class="box" placeholder="Password" required /><br /><br />
            <input type="submit" value="Login" /><br />
         </form>
      </div>
   </div>
   <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js'></script>
   <script src="script.js"></script>
</body>

</html>