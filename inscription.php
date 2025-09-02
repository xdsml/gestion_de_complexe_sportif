<?php
session_start();
$errors[]="";
$btn="";
$namePattern = "/^[A-Za-z]+$/";

$emailPattern = "/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/";
$cinPattern = "/^[A-Z]{1,2}\d{1,7}$/";
$dateOfBirthPattern = "/^\d{4}-\d{2}-\d{2}$/";
$passwordPattern = "/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/";
$telPattern="/^0[67][0-9]{8}$/";
$firstname="";$errfirstname="";
$lastname="";$errlast="";
$email="";$erremail="";
$adresse="";$erradress="";
$cin="";$errcin="";
$datedeN="";$errdatedeN="";
$password="";$errpassword="";
$genre="";$errgenre="";
$tel="";$errtel="";
$errgeneral="";

if(isset($_POST["firstname"]) && isset($_POST["lastname"])){
    $firstname=$_POST["firstname"];
    $lastname=$_POST["lastname"];
    $email=$_POST["email"];  
    $cin=$_POST["cin"];  
    $datedeN=$_POST["datedeN"];  
    $password=$_POST["password"]; 
    $adresse=$_POST["adresse"]; 
    $genre=$_POST["genre"];
    $tel=$_POST["tel"];
 $_SESSION['firstname'] =$firstname;
 $_SESSION['lastname'] =$lastname;
 $_SESSION['email'] = $email;
 $_SESSION['cin'] = $cin;
 $_SESSION['datedeN'] = $datedeN;
 $_SESSION['password'] = $password;
 $_SESSION['adresse'] = $adresse;
 $_SESSION['genre'] = $genre;
 $_SESSION['tel'] = $tel;
 $_SESSION['errgeneral'] = $errgeneral;

    if(empty($firstname)) {
        $errfirstname="You must enter your firstname";
    }elseif (!preg_match("/^[A-Za-z]{1,20}$/", $firstname)) {
        $errNamec = "First name must contain only letters and be maximum 20 characters long";
    }
    if(empty($lastname)) {
        $errlast="You must enter your lastname";
    } elseif (!preg_match("/^[A-Za-z]{1,20}$/", $lastname)) {
        $errNamec = "Last name must contain only letters and be maximum 20 characters long";
    }
    if(empty($email)) {
        $erremail="You must enter your email";
    } elseif (!preg_match("/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/", $email)) {
        $errNamec = "Invalid email format";
    }
    if(empty($adresse)) {
        $erradress="You must enter your adresse";
    }
    if(empty($cin)) {
        $errcin="You must enter your cin";
    } elseif (!preg_match("/^[A-Z]{1,2}\d{1,6}$/", $cin)) {
        $errNamec = "Invalid cin format";
    }
    if(empty($datedeN)) {
        $errdatedeN="You must enter your Date of birth";
    } elseif (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $datedeN)) {
        $errNamec = "Name must contain only letters and be maximum 20 characters long";
    }
    if(empty($password)) {
        $errpassword="You must enter your password";
    } elseif (!preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/", $password)) {
        $errNamec = "Invalid password format";
    }
    if(empty($tel)) {
        $errtel="You must enter your Phone number";
    } elseif (!preg_match("/^0[67][0-9]{8}$/", $tel)) {
        $errNamec = "Invalid phone number format";
    }
        if(empty($genre)) {
        $errgenre="You must enter your Gender";
    }
    if(!is_numeric($tel)){
        $errtel="you must enter only numbers";
    } elseif (!preg_match("/^[A-Za-z]{1,20}$/", $lastname)) {
        $errNamec = "Name must contain only letters and be maximum 20 characters long";
    }

        $errgenre="You must enter your Gender";
    if($erradress=="" && $errcin=="" && $errpassword=="" && $errfirstname=="" && $errlast=="" && $erremail=="" && $errdatedeN=="" && $errtel=="" && $errgenre==""){
        $errgeneral="";
       
    }
     
    

    try {
       
        $conn = new PDO("mysql:host=localhost;dbname=complexe2", "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $checkQuery = "SELECT COUNT(*) FROM client WHERE Email = :email OR CIN = :cin";
        $checkStmt = $conn->prepare($checkQuery);
        $checkStmt->bindParam(':email', $email);
        $checkStmt->bindParam(':cin', $cin);
        $checkStmt->execute();
        $count = $checkStmt->fetchColumn();

        if ($count > 0) {
            $msg ="Email or CIN already exists.";
            header('Location: inscriptionlhrba.php?msg='.$msg);
        } else {
    
        // Votre requête SQL d'insertion ici
        $query = "INSERT INTO client (Nom, Prenom, Email, Cin, Datenaiss, Genre, Adresse, Tel, Password) 
                  VALUES (:firstname, :lastname, :email, :cin, :datedeN, :genre, :adresse, :tel, :password)";
        $stmt = $conn->prepare($query);
        // Liaison des valeurs des paramètres
        $stmt->bindValue(':firstname', $firstname);
        $stmt->bindValue(':lastname', $lastname);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':cin', $cin);
        $stmt->bindValue(':datedeN', $datedeN);
        $stmt->bindValue(':genre', $genre);
        $stmt->bindValue(':adresse', $adresse);
        $stmt->bindValue(':tel', $tel);
        $stmt->bindValue(':password', $password);
    
        // Exécution de la requête
        $stmt->execute();
    
        // Autres actions après l'insertion réussie
        echo"Les données ont été insérées avec succès.";
        header("location:aprecnxx.html");
        }
    } catch (PDOException $e) {
        // Capture de l'erreur et affichage du message
        echo "Erreur lors de l'exécution de la requête SQL : " . $e->getMessage();
    }
}
// $servername = "localhost";
// $username = "root"; // à modifier selon votre configuration
// $password = ""; // à modifier selon votre configuration
// $dbname = "complexe"; // à modifier selon votre configuration

// $conn = new mysqli($servername, $username, $password, $dbname);

// if ($conn->connect_error) {
//     echo("Connection failed: " . $conn->connect_error);
// }

// if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['bouton'])) {
//     $usercnx = $_POST['usercnx'];
//     $passwordcnx = $_POST['passwordcnx'];

//     $sql = "SELECT * FROM client WHERE nom='$usercnx' AND password='$passwordcnx'";
//     $result = $conn->query($sql);

//     if ($result->num_rows > 0) {
//         $_SESSION['usercnx'] = $usercnx;
//         $_SESSION['passwordcnx'] = $passwordcnx;
//         header("Location: cour/sitkaaaml/Page 2.php")    ;    
//         exit();
//     } else {
//         echo "Le nom ou le mot de passe est incorrect.";
//     }
//}

if (isset($_POST["boutton"])) {
  
    $usercnx = $_POST['usercnx'];
    $passwordcnx = $_POST['passwordcnx'];

    try {
        $conn = new PDO("mysql:host=localhost;dbname=complexe2", "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Préparer et exécuter la première requête d'insertion pour l'abonnement
        $query1 = "SELECT * FROM client WHERE nom = :usercnx AND password = :passwordcnx";
        $stmt1 = $conn->prepare($query1);
        $stmt1->bindParam(':usercnx', $usercnx);
        $stmt1->bindParam(':passwordcnx', $passwordcnx);
        $stmt1->execute();

        // Vérifiez si l'utilisateur existe
        if ($stmt1->rowCount() > 0) {
            header("Location: aprecnxx.html");
            exit();
        } else {
            echo "Nom d'utilisateur ou mot de passe incorrect.";
        }
    } catch (PDOException $e) {
        // Capture de l'erreur et affichage du message
        echo "Erreur lors de l'exécution de la requête SQL : " . $e->getMessage();
    }
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
    <title>Ludiflex | Login & Registration</title>
    <style>
        /* POPPINS FONT */
  @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

*{  
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}
body{
    background: url("fit.jpg");
    background-size: cover;
    background-repeat: no-repeat;
    background-attachment: fixed;
    overflow: hidden;
}
.wrapper{
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 110vh;
    background: rgba(39, 39, 39, 0.4);
}
.nav{
    position: fixed;
    top: 0;
    display: flex;
    justify-content: space-around;
    width: 100%;
    height: 100px;
    line-height: 100px;
    background: linear-gradient(rgba(39,39,39, 0.6), transparent);
    z-index: 100;
}
.nav-logo img{
    color: white;
    font-size: 25px;
    font-weight: 100px;
    width: 300px;
    margin-right: 400px;
    padding-right: 30px;
    
}
.nav-menu ul{
    display: flex;
}
.nav-menu ul li{
    list-style-type: none;
}
.nav-menu ul li .link{
    text-decoration: none;
    font-weight: 500;
    color: #fff;
    padding-bottom: 15px;
    margin: 0 25px;
}
.link:hover, .active{
    border-bottom: 2px solid gold;
    
}
.nav-button .btn{
    width: 130px;
    height: 40px;
    font-weight: 500;
    background: rgba(255, 255, 255, 0.4);
    border: none;
    border-radius: 30px;
    cursor: pointer;
    transition: .3s ease;
}
.btn:hover{
    background: rgb(255, 217, 0);
    box-shadow: 1px 5px 7px 1px rgb(19, 19, 18);
}
#registerBtn{
    margin-left: 15px;
}
.btn.white-btn{
    background: rgba(255, 217, 1, 0.7);
}
.btn.btn.white-btn:hover{
    background: rgba(255, 255, 255, 0.5);
    box-shadow: 1px 5px 7px 1px rgb(19, 19, 18);
}
.nav-menu-btn{
    display: none;
}
.form-box{
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 512px;
    height: 420px;
    overflow: hidden;
    z-index: 2;
}
.login-container{
    position: absolute;
    left: 4px;
    width: 500px;
    display: flex;
    flex-direction: column;
    transition: .5s ease-in-out;
    color :red;
}
/* Style de la barre de défilement */
::-webkit-scrollbar {
    width: 50px; /* Largeur de la barre de défilement */
}

/* Style de la poignée de la barre de défilement */
::-webkit-scrollbar-thumb {
    background-color: #be0c0c; /* Couleur de la poignée */
    border-radius: 5px; /* Bordure arrondie de la poignée */
}

/* Style de la piste de la barre de défilement */
::-webkit-scrollbar-track {
    background-color: #f1f1f1; /* Couleur de la piste */
    border-radius: 5px; /* Bordure arrondie de la piste */
}

/* Style de la barre de défilement pour Firefox */
/* Notez que la personnalisation est limitée à la couleur */
/* Vous pouvez spécifier seulement une couleur */
/* Le style et la largeur de la barre ne peuvent pas être modifiés */
/* Ils dépendent des préférences utilisateur de Firefox */
/* Pour plus de personnalisation, utilisez les pseudo-éléments WebKit pour Firefox */
* {
    scrollbar-width: thin; /* Largeur de la barre de défilement */
    scrollbar-color: gold rgb(0,0,0,0.5); /* Couleur de la poignée et de la piste */
}


.register-container{
    overflow-y: auto;
    position: absolute;
    right: -520px;
    width: 500px;
    display: flex;
    flex-direction: column;
    transition: .5s ease-in-out;
    height: 1000rem;
    color:red;
    
}

.top span{
    color: #fff;
    font-size: small;
    padding: 10px 0;
    display: flex;
    justify-content: center;
}
.top span a{
    font-weight: 500;
    color: gold;
    margin-left: 5px;
}
header{
    color: #fff;
    font-size: 30px;
    text-align: center;
    padding: 10px 0 30px 0;
}
.two-forms{
    display: flex;
    gap: 10px;
}
.input-field{
    font-size: 15px;
    background: rgba(255, 255, 255, 0.2);
    color: #fff;
    height: 50px;
    width: 100%;
    padding: 0 0px 0 45px;
    border: none;
    border-radius: 30px;
    outline: none;
    transition: .2s ease;
}
.input-field:hover, .input-field:focus{
    background: rgba(255, 255, 255, 0.25);
}
::-webkit-input-placeholder{
    color: #fff;
}
.input-box i{
    position: relative;
    top: -35px;
    left: 17px;
    color: #fff;
}
.submit{
    font-size: 15px;
    font-weight: 500;
    color: black;
    height: 45px;
    width: 100%;
    border: none;
    border-radius: 30px;
    outline: none;
    background: rgba(255, 255, 255, 0.7);
    cursor: pointer;
    transition: .3s ease-in-out;
}
.submit:hover{
    background: rgb(255, 217, 0);
    box-shadow: 1px 5px 7px 1px rgb(19, 19, 18);
}
.two-col{
    display: flex;
    justify-content: space-between;
    color: #fff;
    font-size: small;
    margin-top: 10px;
}
.two-col .one{
    display: flex;
    gap: 5px;
}
.two label a{
    text-decoration: none;
    color: #fff;
}
.two label a:hover{
    text-decoration: underline;
}

.motpass a{
    margin-left:140px;
    color:gold;
    decoration: none;
}
.error-message{
    position: absolute;
    top: 50%;
    left: 10px;
    transform: translateY(-50%);
    color: red;
    font-size: 12x;
    white-space: nowrap;
}


@media only screen and (max-width: 786px){
    .nav-button{
        display: none;
    }
    .nav-menu.responsive{
        top: 100px;
    }
    .nav-menu{
        position: absolute;
        top: -800px;
        display: flex;
        justify-content: center;
        background: rgba(255, 255, 255, 0.2);
        width: 100%;
        height: 90vh;
        backdrop-filter: blur(20px);
        transition: .3s;
    }
    .nav-menu ul{
        flex-direction: column;
        text-align: center;
    }
    .nav-menu-btn{
        display: block;
    }
    .nav-menu-btn i{
        font-size: 25px;
        color: #fff;
        padding: 10px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        cursor: pointer;
        transition: .3s;
    }
    .nav-menu-btn i:hover{
        background: rgba(255, 255, 255, 0.15);
    }
}
@media only screen and (max-width: 540px) {
    .wrapper{
        min-height: 100vh;
    }
    .form-box{
        width: 100%;
        height: 500px;
    }
    .register-container, .login-container{
        width: 100%;
        padding: 0 20px;
        height: 1000em;
       
    }
    .register-container .two-forms{
        flex-direction: column;
        gap: 0;
        height: 1000em;
    }
}
    </style>
</head>
<body>
 <div class="wrapper">
    <nav class="nav">
        <div class="nav-logo">
            <img src="l3abdyalrajaha9i9i.PNG" alt="">
        </div>
        <div class="nav-menu" id="navMenu">
            <ul>
            </ul>
        </div>
        <div class="nav-button">
            <button class="btn white-btn" id="loginBtn" onclick="login()">Se connecter</button>
            <button class="btn" id="registerBtn" onclick="register()">S'inscrire</button>
        </div>
        <div class="nav-menu-btn">
            <i class="bx bx-menu" onclick="myMenuFunction()"></i>
        </div>
    </nav>

<!----------------------------- Form box ----------------------------------->    
    <div class="form-box">
        
















        <!------------------- login form -------------------------->

        
        <div class="login-container" id="login">
        <form action="inscription.php" method="post">
            <?php if(isset($_GET['msg'])){
                $msg=$_GET['msg'];
                echo'<p style=color: red;">'.$msg.'</p>';
            }
            ?>
       
            <div class="top">
                <span>Vous n'avez pas de compte ? <a href="#" onclick="register()">S'inscrire</a></span>
                <header style="color: gold;">Se connecter</header>
            </div>
            <div class="input-box">
                <input type="text" class="input-field" name="usercnx" placeholder="Nom">
                <i class="bx bx-user"></i>
            </div>
            <div class="input-box">
                <input type="password" class="input-field" name="passwordcnx" placeholder="Mot de passe">
                <i class="bx bx-lock-alt"></i>
            </div>
            <div class="input-box">
                <input type="submit" class="submit" name="boutton" value="connecter">
                <i class="bx bx-lock-alt"></i>
            </div>
            <div class="motpass">
            <a href="changemotpass.php">changer votre mot de pass.</a>
            </div>
        
            </form>
        </div>
























        <!------------------- registration form -------------------------->
        <div class="register-container" id="register" style="height: 22rem;">
        <form action="inscription.php" method="post">
            
            <div class="top">
                <span>vous avez deja un compte? <a href="#" onclick="login()">Se connecter
                </a></span>
                <header style="color: gold;">S'inscrire</header>
            </div>
            <div class="two-forms">
                <div class="input-box">
                    <input type="text" class="input-field"  name="firstname" placeholder="Nom" pattern="[A-Za-z]+" method="<?=$firstname?>">
                    <p><?=$errfirstname ?></p>
                    <i class="bx bx-user"></i>
                    <div class="error-message"><?=$errfirstname?></div>
                </div>
                <div class="input-box">
                    <input type="text" class="input-field"  name="lastname"  pattern="[A-Za-z]+" placeholder="Prenom" >
                    <p><?= $errlast ?></p>
                    <i class="bx bx-user"></i>
                    <div class="error-message"><?=$lastname?></div>
                </div>
            </div>
            <div class="input-box">
                <input type="email" class="input-field" name="email"  placeholder="Email"  title="exmaple@ex.ex">
                <p><?= $erremail ?></p>
                <i class="bx bx-envelope"></i>
                <div class="error-message"><?=$erremail?></div>
            </div>
            <div class="input-box">
                <input type="text" class="input-field" name="adresse"  placeholder="Address">
                <p><?= $erradress ?></p>
                <i class="bx bx-envelope"></i>
                <div class="error-message"><?=$erradress?></div>
            </div>
            <div class="input-box">
                <input type="text" class="input-field" name="cin"   placeholder="CIN" title="1 or 2 letters and 7 disits ">
                <p><?= $errcin?></p>
                <i class="bx bx-envelope"></i>
                <div class="error-message"><?=$errcin?></div>
            </div>
            <div class="input-box">
                <input type="date" class="input-field" name="datedeN"   placeholder="Date de naissance">
                <p><?= $errdatedeN ?></p>
                <i class="bx bx-envelope"></i>
                <div class="error-message"><?=$errdatedeN?></div>
            </div>
            <div class="input-box">
                <input type="tel" class="input-field" name="tel"  pattern="0[67][0-9]{8}"  placeholder="Telephone" title="Please enter exactly 10 digits">
                <p><?= $errtel ?></p>
                <i class="bx bx-envelope"></i>
                <div class="error-message"><?=$errtel?></div>
            </div>
            <div class="input-box">
                <select class="input-field" name="genre">
                    <option value="" name="genre" disabled selected >Genre</option>
                    <option value="male"class="two-forms" style="background-color: rgba(255, 255, 255, 0.25);font-size: 15px;
                    background: rgba(255, 255, 255, 0.2);
                    color: #070707;
                    height: 50px;
                    width: 100%;
                    padding: 0 0px 0 45px;
                    border: none;
                    border-radius: 30px;
                    outline: none;
                    transition: .2s ease;"
                    >Male</option>
                    <option value="female" style="font-size: 15px;
                    background: rgba(255, 255, 255, 0.2);
                    color: #070707;
                    height: 50px;
                    width: 100%;
                    padding: 0 0px 0 45px;
                    border: none;
                    border-radius: 30px;
                    outline: none;
                    transition: .2s ease;">Female</option>
                </select>
                <i class="bx bx-user"></i>
                
            </div>
            <div class="input-box">
                <input type="password" class="input-field" name="password" pattern="(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}"  placeholder="Mot de passe" title="Password must be at least 8 characters long and include at least one letter and one number">
                <p><?= $errpassword ?></p>
                <i class="bx bx-lock-alt"></i>
                <div class="error-message"><?=$errpassword?></div>
            </div>
            <div class="input-box">
               
                <input type="submit" class="submit" name="btn"  value="envoyer">
                
            </div>
            

        </div>
</form>

<script>
   
   function myMenuFunction() {
    var i = document.getElementById("navMenu");

    if(i.className === "nav-menu") {
        i.className += " responsive";
    } else {
        i.className = "nav-menu";
    }
   }
 
</script>

<script>

    var a = document.getElementById("loginBtn");
    var b = document.getElementById("registerBtn");
    var x = document.getElementById("login");
    var y = document.getElementById("register");

    function login() {
        x.style.left = "4px";
        y.style.right = "-520px";
        a.className += " white-btn";
        b.className = "btn";
        x.style.opacity = 1;
        y.style.opacity = 0;
    }

    function register() {
        x.style.left = "-510px";
        y.style.right = "5px";
        a.className = "btn";
        b.className += " white-btn";
        x.style.opacity = 0;
        y.style.opacity = 1;
    }

</script>


</body>

</html>