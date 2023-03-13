<?php 
    $db_host="localhost";
    $db_user="atomx";
    $db_password="bruh669";
    $db_name="gestion_plaintes";
    $conn=mysqli_connect($db_host, $db_user, $db_password) or die('db connexion error');
    $db=mysqli_select_db($conn, 'gestion_plaintes') or die(mysqli_errno($conn));
    if(
        isset($_POST["username"]) &&
        isset($_POST["password"])
    ){
        $username=$_POST["username"];
        $password=$_POST["password"];
        // hash password
        $hash=password_hash($password, PASSWORD_DEFAULT);
        if(password_verify($password,$hash)){
            // check username
            $sql = "SELECT * FROM Plaignant WHERE UsernamePlaignant='$username' LIMIT 1";
            $result= mysqli_query($conn, $sql);
            if ($result) {
                if (mysqli_num_rows($result) !=1 ) {
                    echo('<script>alert("Identifiants incorrects !")</script>');
                }else{
                    // check password
                    while($row = mysqli_fetch_assoc($result)) {
                        if(!password_verify($password,$row['PasswordPlaignant'])){
                            echo('<script>alert("Identifiants incorrects !")</script>');
                        }else{
                        // set session
                            session_start();
                            $_SESSION['NumPlaignant']=$row['NumPlaignant'];
                            $_SESSION['NomPlaignant']=$row['NomPlaignant'];
                            $_SESSION['AdressePlaignant']=$row['AdressePlaignant'];
                            $_SESSION['EmailPlaignant']=$row['EmailPlaignant'];
                            $_SESSION['TelPlaignant']=$row['TelPlaignant'];
                            $_SESSION['UsernamePlaignant']=$row['UsernamePlaignant'];
                        }
                        header('Location: plaintes/new.php');
                    }
                }
            }else{
                echo('<script>alert("Erreur lors de la vérification.")</script>');
            }
        }
    }
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" required>
    <title>Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
    <style>
        html,body {
            height: 100%
        }
    </style>
</head>
<body>
    <div class="h-100 d-flex align-items-center justify-content-center">
        <div class="col-5 mx-auto">
            <h1 class="text-center mt-2 mb-5">Connexion</h1>
            <form method="POST" action="">
                <div class="form-group row mb-3">
                    <label class="col-sm-3 col-form-label">Nom d&rsquo;utilisateur</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="username" required>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-3 col-form-label">Mot de passe</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" name="password" required>
                    </div>
                </div>
                <div class="d-flex justify-content-center my-4">
                    <input type="submit" value="Envoyer" class="btn btn-primary px-5">                    
                </div>
            </form>
            <p class="text-center mb-5">
                Pas de compte ? <a href="register.php">Inscription &rarr;</a>
            </p>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>