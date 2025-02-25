<!-- Diese Seite zeigt die Newsbeiträge für alle sichtbar an. -->

<?php
# include stuff
include 'header.php';
require '../config/dbaccess.php';

//laden news aus der db
$sql = "SELECT * FROM news ORDER BY created_at DESC";
$stmt = $db_obj->prepare($sql);

if(!$stmt){
    die('<div class="alert alert-danger">Fehler beim Abrufen der Artikel: ' . htmlspecialchars($db_obj->error) . '</div>');
}
$stmt->execute();
$result=$stmt->get_result();
$news_items = [];

if($result->num_rows>0){
    $news_items=$result->fetch_all(MYSQLI_ASSOC);
}
$stmt->close();
?>

<!-- Blogbeiträge aus Datenbank in Hauptteil der Seite anzeigen -->
<main role="main" class="container mt-5 pt-5">
    <div class="row">
      <div class="col-md-8 blog-main">
    <?php if($news_items): ?>    
        <?php foreach($news_items as $news):?>
            <div class="blog-post">
                <h2 class="blog-post-title"><?= htmlspecialchars($news['title']) ?></h2>
                <p class="blog-post-meta"><?= htmlspecialchars($news['created_at']) ?> by <a href="#">Admin</a></p></p>
                <?php if(!empty($news['thumbnail_path'])): ?>
                    <img src="/hotelprojekt-original/mergedProject/<?= htmlspecialchars($news['thumbnail_path']) ?>" class="img-thumbnail mb-3" style="width: 100%; max-width: 300px; height: auto;" alt="Blog Thumbnail">
                <?php endif; ?>
                <p><?= nl2br(htmlspecialchars(mb_substr($news['content'], 0, 200))) ?>...</p>
                <a href="article.php?id=<?= $news['id'] ?>" class="btn btn-primary">Weiterlesen</a>
                <hr>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="text-muted">Zurzeit sind keine Artikel verfügbar. Bitte schauen Sie später noch einmal vorbei.</p>
    <?php endif; ?>    
     </div>

     <!-- Sidebar mit Archiv (leer, aber vorhanden) -->
     <aside class="col-md-4 blog-sidebar">
        <div class="p-4 mb-3 bg.light rounded">
            <h4>Über</h4>
            <p class="mb-0">Das Hotel Blick und Glück bietet nicht nur Entspannung, sondern auch spannende Geschichten in unserem Blog.</p>
        </div>
        <div class="p-4">
            <h4>Archives</h4>
            <ol class="list-unstyled mb-0">
                <li><a href="#">März 2024</a></li>
                <li><a href="#">Februar 2024</a></li>
                <li><a href="#">Januar 2024</a></li>
            </ol>
        </div>
     </aside>
    </div> 
</main>
<?php $db_obj->close();

# footer und so
include 'footer.php'; ?>