
<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ota yhteyttä</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Navigaatiopalkki -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="nettisivu2.php">Minun Nettisivuni</a>
        <a href="nettisivu1.php" class="btn btn-secondary ms-auto">Palaa Pääsivulle</a>
    </div>
</nav>

<div class="container mt-5">
    <h1>Ota yhteyttä</h1>
    <hr>
    <h3>Nimi</h3>
    <p>Hugo Korhonen</p>
    <h3>Sähköposti</h3>
    <p>korhonenhugo@gmail.com</p>
    <h3>puhelinnumero</h3>
    <p>+358 04578341340</p>
    <?php
    // Tietokantayhteyden tiedot
    $host = 'localhost';
    $db = 'yhteydenotto';
    $user = 'root';  
    $pass = 'root';      

    // Virheilmoitusmuuttuja
    $error = "";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Lomakkeen kenttien tiedot
        $nimi = htmlspecialchars($_POST['nimi']);
        $email = htmlspecialchars($_POST['email']);
        $viesti = htmlspecialchars($_POST['viesti']);

        // Tarkista, että kaikki kentät on täytetty
        if (!empty($nimi) && !empty($email) && !empty($viesti)) {
            try {
                // Yhdistä tietokantaan
                $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Tallenna tiedot tietokantaan
                $sql = "INSERT INTO viestit (nimi, email, viesti) VALUES (?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$nimi, $email, $viesti]);

                // Näytä onnistumisviesti
                echo '<div class="alert alert-success">Kiitos viestistäsi! Otamme yhteyttä pian.</div>';
            } catch (PDOException $e) {
                $error = "Tietokantavirhe: " . $e->getMessage();
            }
        } else {
            $error = "Kaikki kentät ovat pakollisia!";
        }
    }

    // Näytä virheilmoitus, jos sellainen on
    if (!empty($error)) {
        echo '<div class="alert alert-danger">' . $error . '</div>';
    }
    ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>