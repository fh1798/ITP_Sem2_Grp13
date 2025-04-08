<?php
  // SQL query to join artikel with preisliste, steuersatz, and marke
  $sql = "
    SELECT
      a.artikelID,
      a.name,
      a.artikelBildSrc,
      a.markeFK,
      p.preisNetto,
      s.steuersatz,
      m.name AS markeName
    FROM artikel a
    JOIN preisliste p ON a.artikelID = p.artikelID
    JOIN steuersatz s ON p.steuersatzID = s.steuersatzID
    JOIN marke m ON a.markeFK = m.markeID
  ";
  $stmt = $db_obj->prepare($sql); // Using the already established connection
  $stmt->execute();
  // Fetch the result set as an associative array
  $artikel = [];
  $result = $stmt->get_result(); // Get the result from the prepared statement
  while ($item = $result->fetch_assoc()) {
      $artikel[] = $item; // Store each row in the $artikel array
  }
?>
<div class="container py-5 vh-100">
    <h1 class="text-center mb-5">Unsere Artikel</h1>
    <div class="row">
        <?php foreach($artikel as $item): ?>
            <div class="col-md-3 mb-4">
                <!-- Wrap the entire card in an anchor tag to make it clickable -->
                <a href="index.php?page=<?php echo "artikeldetailansicht" . "&artikelID=" . $item['artikelID'] ;?>" class="card-link">
                    <div class="card">
                        <img src="<?php echo htmlspecialchars($item['artikelBildSrc']); ?>"
                             alt="<?php echo htmlspecialchars($item['markeName'] . ' ' . $item['name']); ?>"
                             class="card-img-top">
                        <div class="card-body">
                            <h5><?php echo htmlspecialchars($item['markeName']); ?></h5>
                            <div><?php echo htmlspecialchars($item['name']); ?></div>
                            <div class="fw-bold mt-2">
                                <?php echo number_format($item['preisNetto'] * (1 + $item['steuersatz']), 2, ',', '.'); ?> € (inkl. MwSt.)
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>