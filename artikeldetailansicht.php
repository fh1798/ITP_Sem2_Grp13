<?php
session_start();
require_once '../../dbaccess.php';

$artikelID = isset($_GET['artikelID']) ? (int)$_GET['artikelID'] : null;

if (!$artikelID) {
    echo "Produkt nicht gefunden.";
    exit;
}

// Kommentar speichern
if (isset($_POST['kommentarAbsenden'], $_SESSION['benutzerID'])) {
    $kommentar = trim($_POST['kommentar']);
    if (!empty($kommentar)) {
        $stmt = $db_obj->prepare("INSERT INTO kommentare (benutzerID, artikelID, kommentar) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $_SESSION['benutzerID'], $artikelID, $kommentar);
        $stmt->execute();
    }
}

// Like speichern
if (isset($_POST['likeAbsenden'], $_SESSION['benutzerID'])) {
    $stmt = $db_obj->prepare("INSERT IGNORE INTO likes (benutzerID, artikelID) VALUES (?, ?)");
    $stmt->bind_param("ii", $_SESSION['benutzerID'], $artikelID);
    $stmt->execute();
}

// Produktdaten
$sql = "SELECT a.artikelId, a.name, a.artikelBildSrc, a.ml, a.markeFK, a.beschreibung, 
               p.preisNetto, s.steuersatz, m.name AS markeName
        FROM artikel a
        LEFT JOIN preisliste p ON a.artikelID = p.artikelID
        LEFT JOIN steuersatz s ON p.steuersatzID = s.steuersatzID
        LEFT JOIN marke m ON a.markeFK = m.markeID
        WHERE a.artikelId = ?";
$stmt = $db_obj->prepare($sql);
$stmt->bind_param("i", $artikelID);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();

if (!$product) {
    header('Location: index.php?page=default');
    exit;
}

// Duftnoten
$sqlNotes = "SELECT dn.name AS duftnoteName, dn.typ AS duftnoteTyp
             FROM artikelduftnoten ad
             JOIN duftnote dn ON ad.duftnoteId = dn.duftnoteId
             WHERE ad.artikelId = ?";
$stmtNotes = $db_obj->prepare($sqlNotes);
$stmtNotes->bind_param("i", $artikelID);
$stmtNotes->execute();
$resultNotes = $stmtNotes->get_result();
$kopfnote = $herznote = $basisnote = [];
while ($note = $resultNotes->fetch_assoc()) {
    if ($note['duftnoteTyp'] == 'Kopfnote') $kopfnote[] = $note['duftnoteName'];
    elseif ($note['duftnoteTyp'] == 'Herznote') $herznote[] = $note['duftnoteName'];
    elseif ($note['duftnoteTyp'] == 'Basisnote') $basisnote[] = $note['duftnoteName'];
}

// Inhaltsstoffe
$sqlIngredients = "SELECT i.inhaltsstoff
                   FROM artikelinhaltsstoffe ai
                   JOIN inhaltsstoffe i ON ai.inhaltID = i.inhaltID
                   WHERE ai.artikelId = ?";
$stmtIngredients = $db_obj->prepare($sqlIngredients);
$stmtIngredients->bind_param("i", $artikelID);
$stmtIngredients->execute();
$resultIngredients = $stmtIngredients->get_result();
$ingredients = [];
while ($ingredient = $resultIngredients->fetch_assoc()) {
    $ingredients[] = $ingredient['inhaltsstoff'];
}

// Likes zählen
$stmt = $db_obj->prepare("SELECT COUNT(*) AS anzahl FROM likes WHERE artikelID = ?");
$stmt->bind_param("i", $artikelID);
$stmt->execute();
$anzahlLikes = $stmt->get_result()->fetch_assoc()['anzahl'];
?>

<div class="container py-5 vh-100">
    <div class="row">
        <div class="col-md-6 d-flex justify-content-center align-items-center">
            <div class="product-placeholder">
                <img src="<?php echo htmlspecialchars($product['artikelBildSrc']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="img-fluid" />
            </div>
        </div>

        <div class="col-md-6">
            <h2><?php echo htmlspecialchars($product['markeName']) . " - " . htmlspecialchars($product['name']); ?></h2>
            <p class="text-muted"><?php echo htmlspecialchars($product['beschreibung']); ?></p>
            <h4 class="text-success mb-3" id="price"><?php echo number_format($product['preisNetto'] * (1 + $product['steuersatz']), 2, ',', '.'); ?> € (inkl. MwSt.)</h4>
            <p><strong>Likes:</strong> <?php echo $anzahlLikes; ?></p>

            <?php if (isset($_SESSION['benutzerID'])): ?>
                <form method="POST" class="mb-3">
                    <button type="submit" name="likeAbsenden" class="btn btn-outline-danger">❤️ Artikel liken</button>
                </form>
            <?php endif; ?>

            <ul class="nav nav-tabs" id="productTab" role="tablist">
                <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#produktdetails">Produktdetails</button></li>
                <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#inhaltsstoffe">Inhaltsstoffe</button></li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane fade show active" id="produktdetails">
                    <ul>
                        <li><strong>Art-Nr.:</strong> <?php echo htmlspecialchars($product['artikelId']); ?></li>
                        <?php if (!empty($product['ml'])): ?>
                            <li><strong>Inhalt:</strong> <?php echo htmlspecialchars($product['ml']); ?> ml</li>
                        <?php endif; ?>
                        <?php if (!empty($kopfnote)): ?><li><strong>Kopfnote:</strong> <?php echo implode(', ', $kopfnote); ?></li><?php endif; ?>
                        <?php if (!empty($herznote)): ?><li><strong>Herznote:</strong> <?php echo implode(', ', $herznote); ?></li><?php endif; ?>
                        <?php if (!empty($basisnote)): ?><li><strong>Basisnote:</strong> <?php echo implode(', ', $basisnote); ?></li><?php endif; ?>
                    </ul>
                </div>
                <div class="tab-pane fade" id="inhaltsstoffe">
                    <ul>
                        <?php foreach ($ingredients as $ingredient): ?>
                            <li><?php echo htmlspecialchars($ingredient); ?></li>
                        <?php endforeach; ?>
                        <?php if (empty($ingredients)): ?>
                            <li>Keine Inhaltsstoffe verfügbar</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>

            <button class="btn btn-primary mt-4">In den Warenkorb</button>

            <!-- Kommentarformular -->
            <div class="mt-5">
                <h4>Kommentar schreiben</h4>
                <?php if (isset($_SESSION['benutzerID'])): ?>
                    <form method="POST">
                        <div class="mb-3">
                            <textarea name="kommentar" class="form-control" placeholder="Dein Kommentar..." required></textarea>
                        </div>
                        <button type="submit" name="kommentarAbsenden" class="btn btn-secondary">Absenden</button>
                    </form>
                <?php else: ?>
                    <p><a href="login.php">Jetzt einloggen</a>, um einen Kommentar zu schreiben.</p>
                <?php endif; ?>
            </div>

            <!-- Kommentaranzeige -->
            <div class="mt-4">
                <h4>Kommentare</h4>
                <?php
                $stmt = $db_obj->prepare("SELECT k.kommentar, k.erstellt_am, b.vorname, b.nachname
                                  FROM kommentare k 
                                  JOIN benutzer b ON k.benutzerID = b.benutzerID 
                                  WHERE k.artikelID = ? ORDER BY k.erstellt_am DESC");
                $stmt->bind_param("i", $artikelID);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0):
                    while ($row = $result->fetch_assoc()):
                        ?>
                        <div class="border p-2 mb-2">
                            <strong><?php echo htmlspecialchars($row['vorname'] . ' ' . $row['nachname']); ?></strong>
                            <small class="text-muted"><?php echo date("d.m.Y H:i", strtotime($row['erstellt_am'])); ?></small>
                            <p><?php echo nl2br(htmlspecialchars($row['kommentar'])); ?></p>
                        </div>
                    <?php endwhile; else: ?>
                    <p>Noch keine Kommentare vorhanden.</p>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div>
