<?php
// Activer l'affichage des erreurs
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Inclure la connexion à la base de données
include '/var/www/html/smarttech/db.php';

// Inclure le script d'envoi d'e-mails
require 'send-mail.php';

// Vérifier si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $poste = $_POST['poste'];
    $date_embauche = $_POST['date_embauche'];
    $salaire = $_POST['salaire'];

    // Insérer l'employé dans la base de données
    $sql = "INSERT INTO employes (nom, prenom, email, poste, date_embauche, salaire) 
            VALUES ('$nom', '$prenom', '$email', '$poste', '$date_embauche', '$salaire')";

    if ($conn->query($sql)) {
        // Envoyer un e-mail de notification à l'employé
        $subject = "Bienvenue chez Smarttech";
        $body = "Bonjour $prenom $nom,<br><br>"
              . "Nous sommes ravis de vous accueillir chez Smarttech en tant que $poste.<br>"
              . "Votre date d'embauche est le $date_embauche et votre salaire est de $salaire €.<br><br>"
              . "Cordialement,<br>L'équipe Smarttech";

        $result = sendEmail($email, $subject, $body);

        if ($result === true) {
            echo "Employé ajouté avec succès et e-mail envoyé !";
        } else {
            echo "Employé ajouté, mais l'e-mail n'a pas pu être envoyé : $result";
        }
    } else {
        echo "Erreur lors de l'ajout de l'employé : " . $conn->error;
    }

    // Rediriger vers la page de liste des employés
    header("Location: read.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un employé - Smarttech</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../style.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="../../index.php">Smarttech</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="read.php">Employés</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../clients/read.php">Clients</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../documents/list.php">Documents</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenu principal -->
    <div class="container mt-5">
        <h1 class="text-center mb-4">Ajouter un employé</h1>
        <form action="create.php" method="POST" class="card p-4">
            <div class="mb-3">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" class="form-control" id="nom" name="nom" required>
            </div>
            <div class="mb-3">
                <label for="prenom" class="form-label">Prénom</label>
                <input type="text" class="form-control" id="prenom" name="prenom" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="poste" class="form-label">Poste</label>
                <input type="text" class="form-control" id="poste" name="poste" required>
            </div>
            <div class="mb-3">
                <label for="date_embauche" class="form-label">Date d'embauche</label>
                <input type="date" class="form-control" id="date_embauche" name="date_embauche" required>
            </div>
            <div class="mb-3">
                <label for="salaire" class="form-label">Salaire</label>
                <input type="number" step="0.01" class="form-control" id="salaire" name="salaire" required>
            </div>
            <button type="submit" class="btn btn-primary">Ajouter</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
