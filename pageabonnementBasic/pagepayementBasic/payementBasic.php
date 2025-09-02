<?php
session_start();
$firstname = $_SESSION["firstname"];
$lastname = $_SESSION['lastname'];
$email = $_SESSION['email'];
$cin = $_SESSION['cin'];
$datedeN = $_SESSION['datedeN'];
$password = $_SESSION['password']; // Hashage du mot de passe
$adresse = $_SESSION['adresse'];
$genre = $_SESSION['genre'];
$tel = $_SESSION['tel'];
$Dure = $_SESSION['Dure'];
$activite = $_SESSION['activite'];

$basic = "basic";

if (isset($_POST["boutton"])) {
  
  try {
    $conn = new PDO("mysql:host=localhost;dbname=complexe2", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Préparer et exécuter la requête pour obtenir l'Idabonnement
    $query4 = "SELECT Idabonnement FROM abonnement WHERE Duree = :Dure and Typeabonnement = :basic";
    $stmt4 = $conn->prepare($query4);
    $stmt4->bindParam(':Dure', $Dure);
    $stmt4->bindParam(':basic', $basic);
    $stmt4->execute();

    // Récupérer le résultat de la requête
    $result1 = $stmt4->fetch(PDO::FETCH_ASSOC);

    // Vérifiez si un abonnement a été trouvé
    if ($result1) {
        $ab = $result1['Idabonnement'];
        // Vous pouvez maintenant utiliser la variable $ab
        // echo "Idabonnement: " . $ab;
    }// else {
    //     echo "Aucun abonnement trouvé pour les critères spécifiés.";
    // }

    // Préparer et exécuter la requête pour obtenir l'Idactivite
    $query5 = "SELECT Idactivite FROM activite WHERE Nomactivite = :activite";
    $stmt5 = $conn->prepare($query5);
    $stmt5->bindParam(':activite', $activite);
    $stmt5->execute();

    // Récupérer le résultat de la requête
    $result2 = $stmt5->fetch(PDO::FETCH_ASSOC);
    

    // Vérifiez si une activité a été trouvée
    if ($result2) {
        $ac = $result2['Idactivite'];
        // Vous pouvez maintenant utiliser la variable $ac
        // echo "Idactivite: " . $ac;
    }// else {
    //     echo "Aucune activité trouvée pour les critères spécifiés.";
    // }

    // Préparer et exécuter la requête d'insertion pour l'abonné
    $query2 = "INSERT INTO abonne (Nom, Prenom, Email, Adresse, CIN, Datenaiss, Tel, Password, Idabonnement, Idactivite) 
               VALUES (:firstname, :lastname, :email, :adresse, :cin, :datedeN, :tel, :password, :ab, :ac)";
    $stmt2 = $conn->prepare($query2);
    $stmt2->bindValue(':firstname', $firstname);
    $stmt2->bindValue(':lastname', $lastname);
    $stmt2->bindValue(':email', $email);
    $stmt2->bindValue(':cin', $cin);
    $stmt2->bindValue(':datedeN', $datedeN);
    $stmt2->bindValue(':adresse', $adresse);
    $stmt2->bindValue(':tel', $tel);
    $stmt2->bindValue(':password', $password);
    $stmt2->bindValue(':ab', $ab);
    $stmt2->bindValue(':ac', $ac);
    $stmt2->execute();

    // Récupération de l'ID généré pour l'abonné
    $idAbonne = $conn->lastInsertId();

    // Vérifiez si l'ID généré est bien récupéré
     if (!$idAbonne) {
         throw new Exception("Erreur : impossible de récupérer l'ID généré pour l'abonné.");
     } else {
         echo "L'abonné a été ajouté avec succès. ID: " . $idAbonne;
      
    }

  } catch (PDOException $e) {
    // Capture de l'erreur et affichage du message
    echo "Erreur lors de l'exécution de la requête SQL : " . $e->getMessage();
  } catch (Exception $e) {
    // Capture de l'erreur et affichage du message
    echo $e->getMessage();
  }
  
  
  exit;
}

    

// Les variables de validation
$Cvvpatern = "/^\d{3}$/";
$NameC = "";
$Credit = "";
$Expmy = "";
$Cvv = "";
$errNamec = "";
$errCredit = "";
$errExpmy = "";
$errCvv = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $NameC = $_POST["NameC"];
    $Credit = $_POST["Credit"];
    $Expmy = $_POST["Expmy"];
    $Cvv = $_POST["Cvv"];

    if (empty($NameC)) {
        $errNamec = "You must enter your Name On Card";
    } elseif (!preg_match("/^[A-Za-z ]{1,20}$/", $NameC)) {
        $errNamec = "Name must contain only letters and be a maximum of 20 characters long";
    }
    if (empty($Credit)) {
        $errCredit = "You must enter your Credit Card number";
    }
    if (empty($Expmy)) {
        $errExpmy = "You must enter your Card expiration month";
    }
    if (empty($Cvv)) {
        $errCvv = "You must enter your CVV";
    } elseif (!preg_match($Cvvpatern, $Cvv)) {
        $errCvv = "Invalid CVV format";
    }

    if (empty($errCredit) && empty($errExpmy) && empty($errCvv) && empty($errNamec)) {
        echo "All inputs are valid!";
    } else {
        echo "Error in inputs!";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">
    <style type="text/css">@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;500;600&display=swap');

*{
  font-family: 'Poppins', sans-serif;
  margin:0; padding:0;
  box-sizing: border-box;
  outline: none; border:none;
  text-transform: capitalize;
  transition: all .2s linear;
}

.container{
  display: flex;
  justify-content: center;
  align-items: center;
  padding:25px;
  min-height: 100vh;
  background: linear-gradient(90deg, #fac003 60%, #fac003 40.1%);
}

.container form{
  padding:20px;
  width:700px;
  background: #fff;
  box-shadow: 0 5px 10px rgba(0,0,0,.1);
}

.container form .row{
  display: flex;
  flex-wrap: wrap;
  gap:15px;
}

.container form .row .col{
  flex:1 1 250px;
}

.container form .row .col .title{
  font-size: 20px;
  color:#333;
  padding-bottom: 5px;
  text-transform: uppercase;
}

.container form .row .col .inputBox{
  margin:15px 0;
}

.container form .row .col .inputBox span{
  margin-bottom: 10px;
  display: block;
}

.container form .row .col .inputBox input{
  width: 100%;
  border:1px solid #ccc;
  padding:10px 15px;
  font-size: 15px;
  text-transform: none;
}

.container form .row .col .inputBox input:focus{
  border:1px solid #000;
}

.container form .row .col .flex{
  display: flex;
  gap:15px;
}

.container form .row .col .flex .inputBox{
  margin-top: 5px;
}

.container form .row .col .inputBox img{
  height: 34px;
  margin-top: 5px;
  filter: drop-shadow(0 0 1px #000);
}

.container form .submit-btn{
  width: 100%;
  padding:12px;
  font-size: 17px;
  background: #515a55;
  color:#fff;
  margin-top: 5px;
  cursor: pointer;
}

.container form .submit-btn:hover{
  background: #fac003;
  color: black;
}
</style>

</head>
<body>

<div class="container">

    <form action="payementBasic.php" method="POST">

        <div class="row">

            <div class="col">

                <h3 class="title">Payment</h3>

                <div class="inputBox">
                    <span>Cards accepted :</span>
                    <img src="images/card_img.png" alt="" >
                </div>
                <div class="inputBox">
                    <span>Name on card :</span>
                    <input type="text" name="NameC" placeholder="Mr.<?= $firstname?>" required pattern="[A-Za-z]{1,20}">
                    <span class="error"><?php echo $errNamec; ?></span>
                </div>
                <div class="inputBox">
                    <span>Credit card number :</span>
                    <input type="text" name="Credit" placeholder="1111-2222-3333-4444" oninput="formatCardNumber(this)" required>
                    <span class="error"><?php echo $errCredit; ?></span>
                </div>
                <div class="flex">
                    <div class="inputBox">
                        <span>Exp month :</span>
                        <input type="month" name="Expmy" placeholder="Jnanuary" required>
                        <span class="error"><?php echo $errExpmy; ?></span>
                    </div>
                    <div class="inputBox">
                        
                    </div>
                </div>
                <div class="inputBox">
                    <span>CVV :</span>
                    <input type="number" name="Cvv"  placeholder="123" pattern="\d{3}" required>
                    <span class="error"><?php echo $errCvv; ?></span>
                    
                </div>

            </div>
    
        </div>

        <input type="submit" value="Proceed to checkout" name="boutton"  class="submit-btn"></a>

    </form>

</div>    

<script>
function formatCardNumber(input) {
    // Remove non-digit characters
    var formattedValue = input.value.replace(/\D/g, '');
    
    // Insert dash after every 4 characters
    formattedValue = formattedValue.replace(/(\d{4})(?=\d)/g, '$1-');
    
    // Remove extra dashes
    formattedValue = formattedValue.replace(/(\d{4}-\d{4}-\d{4}-\d{4})-.*/g, '$1');
    
    // Update input value
    input.value = formattedValue;
}
</script>
</body>
</html>
