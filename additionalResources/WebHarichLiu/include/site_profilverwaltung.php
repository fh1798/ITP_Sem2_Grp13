<!-- Diese Datei liefert das Formular, um die eigenen Nutzerdaten zu ändern -->

<?php
include('header.php');
include('../config/dbaccess.php');

if(!isset($_SESSION['username'])){
    die("Bitte loggen Sie sich ein.");
}
    
/*Kundendaten aufrufen */

$username = $_SESSION['username'];

//db
$sql ="SELECT * FROM users WHERE username = ?"; 

$stmt=$db_obj->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

//wenn es genau einen Datensatz gibt
if($result->num_rows==1){

    $kundendaten=$result->fetch_assoc();
} else{
    die("Kundendaten könnten nicht abgerufen werden.");
}

$success = '';
$errors = [];// von fehlermeldungen

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    //Kundendaten speichern, vergleichen, wenn nicht gleich sind dann aktualisieren
   

    $nachname = $_POST['nachname'] ?? $kundendaten['nachname'];
    $useremail = $_POST['email'] ?? $kundendaten['useremail']; 

    $passwort = $_POST['passwort'] ?? null;//altes passwort
    $reset_passwort = $_POST['reset_passwort']?? null;//neues Passwort
    $reset_passwort_wiederholt = $_POST['reset_passwort_wiederholt'] ?? null;

    $hashed_password = $kundendaten['password'];//altes passwort bleibt
    
    if(!filter_var($useremail, FILTER_VALIDATE_EMAIL)){
        $errors['useremail']= "Ungültige E-Mail-Adresse!";
    }

    //Passwort überprüfen, wenn reset werden soll!!
    //wenn alle felder ausgefüllt sind
   

    if(!empty($reset_passwort) && !empty($reset_passwort_wiederholt)){
    
        
        if(password_verify($passwort, $kundendaten['password'])){

            if($reset_passwort== $reset_passwort_wiederholt){

                $hashed_password= password_hash($reset_passwort, PASSWORD_DEFAULT);
            } else{

            $errors['reset_passwort'] = "Passwörter stimmen nicht überein!";
        }
    }else {
        
        $errors['passwort']= "Das alte Passwort ist falsch, bitte geben Sie das richtige Passwort ein!";
    }
}

//if error ist empty kundendaten wurden erfolgreich geändert/aktualisert, meldung für erfolgreiche änderung.

if(empty($errors)){

    $sql= "UPDATE users SET nachname = ?, useremail = ?, password = ?
    WHERE username = ?";
    $stmt=$db_obj->prepare($sql);
    $stmt->bind_param("ssss",  $nachname, $useremail, $hashed_password, $username);
    if($stmt->execute()){
       
        $success = "Ihre Daten wurden gespeichert.";
    } else{
        $errors['db']="Ein Fehler ist beim Speichern aufgetreten!";
        }

    }  
}      

?>

<!-- Formular -->
<div class="container">
    <h1 class="text-center my-5">Kundendaten</h1>
    <?php if($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>
</div>
<div class="container py-4 my-3" style="max-width: 640px;" >

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" novalidate>
        <div class="form-group">
            <div class="form-group col-auto">
                <label for="username">Username: <span class="text-muted">kann nicht geändert werden</span></label>
                <input type="text" class="form-control" style="background-color:rgba(152, 152, 152, 0.1);" value="<?php echo htmlspecialchars($kundendaten['username']) ;?>"readonly>
            </div>
        </div>    

        <div class="form-group col-auto">
            <label for="vorname">Vorname: <span class="text-muted">kann nicht geändert werden</span></label>
            <input type="text"  id="vorname" style="background-color:rgba(152, 152, 152, 0.1);"name="vorname" value="<?php echo htmlspecialchars($kundendaten['vorname']) ;?>" readonly>
            <?php if (isset($errors['vorname'])): ?>
                <small class="text-muted"><?php echo $errors['vorname']; ?></small>
            <?php endif; ?>
        </div>

        <div class="form-group col-auto">
            <label for="nachname">Nachname:</label>
            <input type="text"  id="nachname" name="nachname" value="<?php echo htmlspecialchars($kundendaten['nachname']) ;?>" required >
            <?php if (isset($errors['nachname'])): ?>
                <small class="text-muted"><?php echo $errors['nachname']; ?></small>
            <?php endif; ?>
        </div>

        
        <div class="form-group col-auto">
            <label for="E-mail">E-Mail:</label>
            <input type="email"  id="useremail" name="useremail" class="form-control"  value="<?php echo htmlspecialchars($kundendaten['useremail']) ;?>" required>
            <?php if (isset($errors['useremail'])): ?>
                <small class="text-muted"><?php echo $errors['useremail']; ?></small>
            <?php endif; ?>
        </div>

        <div class="form-group col-auto">
            <label for="passwort"> altes Passwort eingeben:</label>
            <input type="password"  id="passwort" name="passwort" placeholder="Passwort" class="form-control">
            <?php if (isset($errors['passwort'])): ?>
                <small class="text-muted"><?php echo $errors['passwort']; ?></small>
            <?php endif; ?>
        </div>
        <div class="form-group col-auto">
            <label for="reset_passwort">neues Passwort eingeben</label>
            <input type="password"  id="reset_passwort" name="reset_passwort" placeholder="Passwort wiederholen" class="form-control" value="<?php echo($_SERVER['REQUEST_METHOD'] =="POST")? htmlspecialchars($reset_passwort): '';?>">
        </div>


        <div class="form-group col-auto">
            <label for="reset_passwort_wiederholt">neues Passwort eingeben</label>
            <input type="password"  id="reset_passwort_wiederholt" name="reset_passwort_wiederholt" placeholder="Passwort wiederholen_wiederholt" class="form-control" value="<?php echo($_SERVER['REQUEST_METHOD'] =="POST")? htmlspecialchars($reset_passwort_wiederholt): '';?>">
            <?php if (isset($errors['reset_passwort'])): ?>
                <small class="text-muted"><?php echo $errors['reset_passwort']; ?></small>
            <?php endif; ?>
        </div>
        <div class="d-flex">
            <a href="site_profil.php" class="btn btn-primary mt-5 me-3">zurück</a>
            <button type= "submit" class="btn btn-primary mt-5">speichern</button>
        </div>
        
    </form>

</div>   



<?php include('footer.php')?>