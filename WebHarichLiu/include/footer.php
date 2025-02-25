<!-- Diese Datei besteht aus dem Footer der HTML Datei,
 hier wird der body- und html-Tag geschlossen, sowie die untere Linkzeile implementiert -->

<div class="container-fluid my-5 py-4 bg-primary">
  <!-- Linkzeile -->
  <footer class="py-3 my-4">
    <ul class="nav justify-content-center border-bottom pb-3 mb-3">
      <li class="nav-item">
        <a href="<?php echo str_replace($_SERVER['DOCUMENT_ROOT'], '', $_SERVER['DOCUMENT_ROOT'] . '/hotelprojekt-original/mergedProject/index.php'); ?>"
         class="nav-link px-2 text-body-secondary fw-bolder">Home</a>
        </li>
      <li class="nav-item">
        <a href="<?php echo str_replace($_SERVER['DOCUMENT_ROOT'], '', $_SERVER['DOCUMENT_ROOT'] . '/hotelprojekt-original/mergedProject/include/site_rooms.php'); ?>" class="nav-link px-2 text-body-secondary fw-bolder">Zimmer buchen</a>
      </li>
      <li class="nav-item">
        <a href="<?php echo str_replace($_SERVER['DOCUMENT_ROOT'], '', $_SERVER['DOCUMENT_ROOT'] . '/hotelprojekt-original/mergedProject/include/site_help.php'); ?>" class="nav-link px-2 text-body-secondary fw-bolder">FAQs</a>
      </li>
      <li class="nav-item">
        <a href="<?php echo str_replace($_SERVER['DOCUMENT_ROOT'], '', $_SERVER['DOCUMENT_ROOT'] . '/hotelprojekt-original/mergedProject/include/site_impressum.php'); ?>" class="nav-link px-2 text-body-secondary fw-bolder">Impressum</a>
      </li>
      <li class="nav-item">
        <a href="<?php echo str_replace($_SERVER['DOCUMENT_ROOT'], '', $_SERVER['DOCUMENT_ROOT'] . '/hotelprojekt-original/mergedProject/include/site_blog.php'); ?>" class="nav-link px-2 text-body-secondary fw-bolder">Über uns</a>
      </li>
    </ul>
  </footer>

  <!-- Copyright Zeile -->
  <div class="container-fluid mt-auto py-2 bg-primary">
        <p class="text-center text-body-secondary fw-bolder">&copy; 2024 Blick & Glück</p>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
