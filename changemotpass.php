
<?php
session_start();

if (isset($_POST["button"])) {
    $cin = $_SESSION['cin'];
    $passwordActuel = $_POST["passwordActuel"];
    $passwordNouveau = $_POST["passwordNouveau"];

    try {
        $conn = new PDO("mysql:host=localhost;dbname=complexe2", "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Preparer et executer la requete pour obtenir le mot de passe actuel
        $query1 = "SELECT password FROM client WHERE Cin = :cin";
        $stmt1 = $conn->prepare($query1);
        $stmt1->bindParam(':cin', $cin);
        $stmt1->execute();

        // Recuperer le resultat de la requete
        $result = $stmt1->fetch(PDO::FETCH_ASSOC);

        // Verifier si le mot de passe actuel est correct
        if ($result && $result['password'] === $passwordActuel) {
            // Hashage du nouveau mot de passe (si nécessaire)
            // Vous pouvez ajouter ici un hashage comme password_hash si vous utilisez un hashage pour stocker les mots de passe
            $hashedPassword = $passwordNouveau;

            // Preparer et executer la requete de mise a jour
            $query = "UPDATE client SET password = :password WHERE Cin = :cin";
            $stmt2 = $conn->prepare($query);
            $stmt2->bindParam(':password', $hashedPassword);
            $stmt2->bindParam(':cin', $cin);
            $stmt2->execute();

            echo "Mot de passe mis à jour avec succès.";
            header("location:aprecnxx.html");
        } else {
            echo "Mot de passe actuel incorrect.";
        }

    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>








<style>
    /* POPPINS FONT */
  @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');
*{
    font-family: 'Poppins', sans serif;
}
body{
    background-image: url("fit.jpg");
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
    background-attachment: fixed;
}
.box{
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 90vh;
}
.container{
    width: 350px;
    display: flex;
    flex-direction: column;
    padding: 0 15px 0 15px;
}
span{
    color: gold;
    font-size: small;
    display: flex;
    justify-content: center;
    padding: 10px 0 10px 0;
}
header{
    color: #fff;
    font-size: 30px;
    display: flex;
    justify-content: center;
    padding: 10px 0 10px 0;
}
.input-field{
    display: flex;
    flex-direction: column;
}
.input-field .input{
    height: 45px;
    width: 100%;
    border: none;
    outline: none;
    border-radius: 30px;
    color: #fff;
    padding: 0 0 0 42px;
    background: rgba(255, 255, 255, 0.2);
}
i{
    position: relative;
    top: -31px;
    left: 17px;
    color: #fff;
}
::-webkit-input-placeholder{
    color: #fff;
}
.submit{
    border: none;
    border-radius: 30px;
    font-size: 15px;
    height: 45px;
    outline: none;
    width: 100%;
    background: rgba(255,255,255,0.7);
    cursor: pointer;
    transition: .3s;
}
.submit:hover{
    box-shadow: 1px 5px 7px 1px rgba(0, 0, 0, 0.2);
    background-color: gold;
}
.bottom{
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    font-size: small;
    color: #fff;
    margin-top: 10px;
}
.left{
    display: flex;
}
label a{
    color: #fff;
    text-decoration: none;
}
header{
    color: gold;
}
</style>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Changer le mot de passe</title>
</head>
<body>
    <form action="" method="POST">
        <div class="box">
            <div class="container">
                <div class="top-header">
                    <span>Changer votre mot de passe</span>
                </div>
                <div class="input-field">
                    <input type="password" class="input" name="passwordActuel" placeholder="Mot de passe actuel" required>
                    <i class="bx bx-lock-alt"></i>
                </div>
                <div class="input-field">
                    <input type="password" class="input" name="passwordNouveau" placeholder="Nouveau mot de passe" required>
                    <i class="bx bx-lock-alt"></i>
                </div>
                <div class="input-field">
                    <input type="submit" class="submit" value="Envoyer" name="button">
                </div>
            </div>
        </div>
    </form>
</body>
</html>
