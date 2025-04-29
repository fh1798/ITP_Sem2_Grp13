<body>
<?php
// Diese Datei ist in Zukunft verantwortlich für den Warenkorb, zeigt momentan jedoch lediglich eine andere Darstellung derselben Inhalte der Artikelübersicht an
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
    <h1 class="text-center mb-5">Warenkorb</h1>
    <div class="list-group">
        <?php
        $gesamtSumme = 0;
        foreach($artikel as $item):
            $preisBrutto = $item['preisNetto'] * (1 + $item['steuersatz']);
            $gesamtSumme += $preisBrutto;
        ?>
            <a href="index.php?page=<?php echo "artikeldetailansicht" . "&artikelID=" . $item['artikelID']; ?>" class="list-group-item list-group-item-action d-flex align-items-center gap-3">
                <img src="<?php echo htmlspecialchars($item['artikelBildSrc']); ?>"
                     alt="<?php echo htmlspecialchars($item['markeName'] . ' ' . $item['name']); ?>"
                     style="width: 60px; height: auto;"
                     class="img-thumbnail">
                <div>
                    <h5 class="mb-1"><?php echo htmlspecialchars($item['markeName']); ?></h5>
                    <div><?php echo htmlspecialchars($item['name']); ?></div>
                    <div class="fw-bold mt-1">
                        <?php echo number_format($preisBrutto, 2, ',', '.'); ?> € (inkl. MwSt.)
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    </div>

    <!-- Summenblock -->
    <div class="mt-4 p-3 bg-light border rounded text-end">
        <h5>Gesamtsumme: 
            <span class="fw-bold">
                <?php echo number_format($gesamtSumme, 2, ',', '.'); ?> €
            </span>
        </h5>
    </div>
</div>
</body>
