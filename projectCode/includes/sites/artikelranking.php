<?php
    // Lade Produkte
    $sql = "SELECT a.artikelId, a.name, a.artikelBildSrc, p.preisNetto, s.steuersatz, m.name AS markeName
            FROM artikel a
            LEFT JOIN preisliste p ON a.artikelID = p.artikelID
            LEFT JOIN steuersatz s ON p.steuersatzID = s.steuersatzID
            LEFT JOIN marke m ON a.markeFK = m.markeID";
    $result = $db_obj->query($sql);

    // Lade Likes
    $likes = [];
    $likesResult = $db_obj->query("SELECT artikelID, COUNT(*) AS anzahl FROM likes GROUP BY artikelID");
    while ($row = $likesResult->fetch_assoc()) {
        $likes[$row['artikelID']] = $row['anzahl'];
    }

    // Produkt-Details
    $products = [];
    while ($row = $result->fetch_assoc()) {
        $artikelID = $row['artikelId'];
        $products[] = [
            'artikelId' => $artikelID,
            'name' => $row['name'],
            'bild' => $row['artikelBildSrc'],
            'marke' => $row['markeName'],
            'preis' => number_format($row['preisNetto'] * (1 + $row['steuersatz']), 2, ',', '.'),
            'likes' => $likes[$artikelID] ?? 0
        ];
    }

    // Sortiert Produkte basierend auf likes
    usort($products, function($a, $b) {
        return $b['likes'] <=> $a['likes'];
    });

    // Limitiert auf 5
    $topProducts = array_slice($products, 0, 5);
?>

<section class="bg-light py-5 article-bg-image position-relative">
    <h1 class="mb-5 text-center fw-bold text-white">Top 5 Perfumes auf Parfumeria Duftwelten</h1>

    <div class="container-fluid min-vh-100 d-flex flex-column align-items-center justify-content-start gap-4">

        <?php if (isset($topProducts[0])): ?>
            <!-- Perfume 1 - Special Design -->
            <div class="card w-75 d-flex flex-row align-items-center shadow-lg p-3" style="backdrop-filter: blur(10px); border: 2px solid gold; background: rgba(255, 255, 255, 0.5);">
                <a href="index.php?page=artikeldetailansicht&artikelID=<?php echo $topProducts[0]['artikelId']; ?>" class="flex-shrink-0 me-4" style="width: 150px;">
                    <img src="<?php echo htmlspecialchars($topProducts[0]['bild']); ?>" class="img-fluid rounded" alt="<?php echo htmlspecialchars($topProducts[0]['name']); ?>">
                </a>
                <div class="card-body text-center">
                    <h2 class="fw-bold text-primary">#1 <?php echo htmlspecialchars($topProducts[0]['name']); ?></h2>
                    <p class="text-muted fst-italic">Meist geliked Parfume (<?php echo $topProducts[0]['likes']; ?> Likes)</p>
                    <p class="text-secondary"><?php echo htmlspecialchars($topProducts[0]['marke']); ?></p>
                </div>
            </div>
        <?php endif; ?>

        <?php for ($i = 1; $i < count($topProducts); $i++): ?>
            <!-- Perfume 2 bis 5 -->
            <div class="card w-75 d-flex flex-row align-items-center shadow-sm border-0 p-3" style="backdrop-filter: blur(8px); background: rgba(255, 255, 255, 0.4);">
                <a href="index.php?page=artikeldetailansicht&artikelID=<?php echo $topProducts[$i]['artikelId']; ?>" class="flex-shrink-0 me-4" style="width: 150px;">
                    <img src="<?php echo htmlspecialchars($topProducts[$i]['bild']); ?>" class="img-fluid rounded" alt="<?php echo htmlspecialchars($topProducts[$i]['name']); ?>">
                </a>
                <div class="card-body text-center">
                    <h3 class="fw-semibold">#<?php echo $i + 1; ?> <?php echo htmlspecialchars($topProducts[$i]['name']); ?></h3>
                    <p class="text-secondary"><?php echo htmlspecialchars($topProducts[$i]['marke']); ?></p>
                    <p class="text-muted">Likes: <?php echo $topProducts[$i]['likes']; ?></p>
                </div>
            </div>
        <?php endfor; ?>

    </div>
</section>
