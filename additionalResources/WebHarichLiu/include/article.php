<!-- Diese Seite stellt die einzelnen Blogartikel im Ganzen dar.
 Sie wird von site_blog.php aus für je einen bestimmten Artikel aufgerufen. -->

<?php 
# das übliche einbinden
include 'fct_session.php';
require_once '../config/dbaccess.php';
include 'header.php';

# abrufen des Artikels aus der Datenbank und Fehlermeldungen, falls dabei etwas schief läuft
if(!isset($_GET['id'])){
    die('<div class="alert alert-danger">Artikelnummer ist ungültig</div>');
}
$article_id=intval($_GET['id']);

$sql= "SELECT * FROM news WHERE id= ?";
$stmt= $db_obj->prepare($sql);

if(!$stmt){
    die('<div class="alert alert-danger">Fehler beim Abrufen der Artikel: ' . htmlspecialchars($db_obj->error) . '</div>');
}
$stmt->bind_param('i', $article_id);
$stmt->execute();
$result=$stmt->get_result();


if($result->num_rows>0){
    $news_items=$result->fetch_assoc();
} else{
   die('<div class="alert alert-danger">Artikel nicht gefunden</div>');
}
$stmt->close();
?>


<!-- Optische Darstellung im main -->
<main role="main" class="container mt-5 pt-5">
    <div class="row">
      <div class="col-md-10 blog-main">
   
            <div class="blog-post">
                <h2 class="blog-post-title"><?= htmlspecialchars($news_items['title']) ?></h2>
                <p class="blog-post-meta"><?= htmlspecialchars($news_items['created_at']) ?> by <a href="#">Admin</a></p>
                <?php if(!empty($news_items['image_path'])): ?>
                    <img src="/hotelprojekt-original/mergedProject/<?= htmlspecialchars($news_items['image_path']) ?>" class="img-image mb-3" style="width: 100%; max-width: 600px; height: auto;" alt="Blog image">
                <?php endif;?>
                <p><?= nl2br(htmlspecialchars($news_items['content'])) ?></p>
                
                <hr>
            </div>
      </div>      
    </div>
    
</main>

<?php include 'footer.php'; ?><!-- footer halt -->