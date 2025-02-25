<!-- Diese Seite zeigt eingeloggten Usern das Formular zum erstellen von Zimmerreservierungen, und anonymen Usern eine Fehlermeldung. -->

<?php
include('fct_session.php');
include('header.php');
?>

<!-- Formular für die Zimmerreservierung -->   
    <div class="container mt-4 pt-4 min-vh-100">
        <h1 class="text-center pt-4">Zimmerreservierung</h1>
        <?php if (!isset($_SESSION['username'])): ?>
                <p class="text-danger my-3">Bitte loggen Sie sich ein oder registrieren Sie sich. Nur registriete Kunden können Zimmerreservierung durchführen</p>
        <?php endif; ?>

        
        <form class="mx-auto mt-3 pt-3" style="width:50%;" method="POST" action="site_reservation_process.php">
            
            <div class="form-row d-flex justify-content-between">
                <div class="form-group col-md-6 px-2">
                    <label for="check_in_date" class="form-label">Anreisedatum</label>
                    <input type="date" class="form-control" id="check_in_date" name="check_in_date" value="<?php echo htmlspecialchars($check_in_date); ?>" min="<?php echo date('Y-m-d'); ?>" required>
                    
                </div>

                <div class="form-group col-md-6 px-2">
                    <label for="check_out_date" class="form-label">Abreisedatum</label>
                    <input type="date" class="form-control" id="check_out_date" name="check_out_date" value="<?php echo htmlspecialchars($check_out_date) ; ?>" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" required>
                    
                </div>
            </div>    
    
            <div class="form-group">
                <label for="guests" class="form-label">Anzahl der Gäste</label>
                <input type="number" class="form-control" id="guests" name="guests" value="<?php echo $guests; ?>" min="1" required>
            </div>
            <div class="form-group">
            <label for="breakfast">Frühstück:(10€)/Tag</label>
            <select name="breakfast" id="breakfast" class="form-control" required>
                <option value="">Bitte wählen...</option>
                <option value="mit">Mit Frühstück</option>
                <option value="ohne">Ohne Frühstück</option>
                
            </select>
        </div>
        
        <div class="form-group">
            <label for="pets">Haustier:(15€)/Tag</label>
            <select name="pets" id="pets" class="form-control" required>
                <option value="">Bitte wählen...</option>
                <option value="keine">Keine</option>
                <option value="hund">Hund</option>
                <option value="katze">Katze</option>
                <option value="sonstige">Sonstige</option>
            </select>
        </div>
        <div class="form-group">
            <label for="parking">Parkplatz:(8€)/Tag</label>
            <select name="parking" id="parking" class="form-control"  required>
                <option value="">Bitte wählen...</option>
                <option value="ja">Ja</option>
                <option value="nein">Nein</option>
                
            </select>
        </div>


        <!-- Zusätzliche Wünsche -->
        <div class="form-group">
            <label for="notes">Zusätzliche Wünsche/Bemerkungen:</label>
            <textarea name="notes" id="notes" class="form-control" rows="5" placeholder="Optional"></textarea>
        </div>

        <!-- Absenden -->
            <a href="site_dashboard.php" class="btn btn-primary mt-5 me-4">Zurück</a>
            <button type="submit" class="btn btn-primary mt-5 pt-2">Reservieren</button>
            
        </form>
    
    </div>
    
<?php include('footer.php');?>