<?php
require_once(__DIR__ . '/../../config/dbaccess.php');

// Artikel-ID aus URL
$artikelID = isset($_GET['artikelID']) ? $_GET['artikelID'] : null;

// Falls keine ID übergeben wurde
if (!$artikelID) {
    echo "Produkt nicht gefunden.";
    exit;
}

// Artikel-Details auslesen
$sql = "SELECT 
            a.artikelId, 
            a.name, 
            a.artikelBildSrc,
            a.ml,
            a.markeFK,
            a.beschreibung, 
            p.preisNetto, 
            s.steuersatz,
            m.name AS markeName
        FROM artikel a
        LEFT JOIN preisliste p ON a.artikelID = p.artikelID
        LEFT JOIN steuersatz s ON p.steuersatzID = s.steuersatzID
        LEFT JOIN marke m ON a.markeFK = m.markeID
        WHERE a.artikelId = ?";
        
$stmt = $db_obj->prepare($sql);
$stmt->bind_param("i", $artikelID);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    header('Location: index.php?page=default');
    exit;
}

// Duftnoten auslesen
$sqlNotes = "SELECT 
                dn.name AS duftnoteName,
                dn.typ AS duftnoteTyp
            FROM artikelduftnoten ad
            JOIN duftnote dn ON ad.duftnoteId = dn.duftnoteId
            WHERE ad.artikelId = ?";
$stmtNotes = $db_obj->prepare($sqlNotes);
$stmtNotes->bind_param("i", $artikelID);
$stmtNotes->execute();
$resultNotes = $stmtNotes->get_result();

$kopfnote = [];
$herznote = [];
$basisnote = [];

while ($note = $resultNotes->fetch_assoc()) {
    if ($note['duftnoteTyp'] == 'Kopfnote') {
        $kopfnote[] = $note['duftnoteName'];
    } elseif ($note['duftnoteTyp'] == 'Herznote') {
        $herznote[] = $note['duftnoteName'];
    } elseif ($note['duftnoteTyp'] == 'Basisnote') {
        $basisnote[] = $note['duftnoteName'];
    }
}

// Inhaltsstoffe auslesen
$sqlIngredients = "SELECT 
                    i.inhaltsstoff
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
?>

<div class="container py-5 vh-100">
  <div class="row">
    <div class="col-md-6 d-flex justify-content-center align-items-center">
      <div class="product-placeholder">
        <!-- Artikel Bild -->
        <img src="<?php echo htmlspecialchars($product['artikelBildSrc']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="img-fluid" />
      </div>
    </div>

    <div class="col-md-6">
      <!-- Artikelname, Beschreibung -->
      <h2><?php echo htmlspecialchars($product['markeName']) . " - " . htmlspecialchars($product['name']); ?></h2>
      <p class="text-muted"><?php echo htmlspecialchars($product['beschreibung']); ?></p>

      <h4 class="text-success mb-3" id="price"><?php echo number_format($product['preisNetto'] * (1 + $product['steuersatz']), 2, ',', '.'); ?> € (inkl. MwSt.)</h4>

      <!-- Tabs -->
      <ul class="nav nav-tabs" id="productTab" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="produktdetails-tab" data-bs-toggle="tab" data-bs-target="#produktdetails" type="button" role="tab">Produktdetails</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="inhaltsstoffe-tab" data-bs-toggle="tab" data-bs-target="#inhaltsstoffe" type="button" role="tab">Inhaltsstoffe</button>
        </li>
      </ul>

      <div class="tab-content" id="productTabContent">
        <div class="tab-pane fade show active" id="produktdetails" role="tabpanel">
          <ul>
            <li><strong>Art-Nr.:</strong> <?php echo htmlspecialchars($product['artikelId']); ?></li>
            <?php if (!empty($product['ml'])): ?>
              <li><strong>Inhalt:</strong> <?php echo htmlspecialchars($product['ml']); ?> ml</li>
            <?php endif; ?>

            <?php if (!empty($kopfnote)): ?>
              <li><strong>Kopfnote:</strong> <?php echo implode(', ', $kopfnote); ?></li>
            <?php endif; ?>
            <?php if (!empty($herznote)): ?>
              <li><strong>Herznote:</strong> <?php echo implode(', ', $herznote); ?></li>
            <?php endif; ?>
            <?php if (!empty($basisnote)): ?>
              <li><strong>Basisnote:</strong> <?php echo implode(', ', $basisnote); ?></li>
            <?php endif; ?>
          </ul>
        </div>

        <div class="tab-pane fade" id="inhaltsstoffe" role="tabpanel">
          <ul>
            <?php if (!empty($ingredients)): ?>
              <?php foreach ($ingredients as $ingredient): ?>
                <li><?php echo htmlspecialchars($ingredient); ?></li>
              <?php endforeach; ?>
            <?php else: ?>
              <li>Keine Inhaltsstoffe verfügbar</li>
            <?php endif; ?>
          </ul>
        </div>
      </div>

      <!-- In den Warenkorb Button mit Formular -->
      <form action="index.php?page=warenkorb" method="POST">
        <input type="hidden" name="addArtikelID" value="<?php echo htmlspecialchars($product['artikelId']); ?>">
        <input type="hidden" name="menge" value="1">
        <button type="submit" class="btn btn-primary mt-4">
          In den Warenkorb
        </button>
      </form>
    </div>
  </div>
</div>