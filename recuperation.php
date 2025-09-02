<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="recuperation.php" method="post">

   Nom <input type="text" name="nom" require pattern="[A-Za-z]{3,30}">
   Prenom <input type="text" name="prenom" require pattern="[A-Za-z]{3,30}">
   date de naissance <input type="date" name="date" id="">
   moyenne <input type="number" name="moyenne" require pattern="{0,20}">
   niveau <select name="niveau" id="">
    <option value="Bac">Bac</option>
    <option value="Bac2">Bac+2</option>
    <option value="Bac3">Bac+3</option>
    <option value="Bac5">Bac+5</option>
   </select>
   Fr<input type="checkbox" name="francai" id="">
   Ar<input type="checkbox" name="francai" id="">
   EN<input type="checkbox" name="francai" id="">

   homme<input type="radio" name="homme" id="">
   femme<input type="radio" name="homme" id="">
   Adresse<input type="textarea" name="Adress" id="">
</body>
</html>