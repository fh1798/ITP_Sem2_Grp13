<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Parfumeria Duftwelten</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link <?php if($page === "home") echo "active"; ?>" href="index.php?page=home">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if($page === "faq") echo "active"; ?>" href="index.php?page=faq">FAQs</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if($page === "impressum") echo "active"; ?>" href="index.php?page=impressum">Impressum</a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php if($page === "chatroom") echo "active"; ?>" href="index.php?page=chatroom">Chatroom</a>
        </li>
          <li class="nav-item">
            <a class="nav-link <?php if($page === "warenkorb") echo "active"; ?>" href="index.php?page=warenkorb">Warenkorb</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if($page === "artikelübersicht") echo "active"; ?>" href="index.php?page=artikelübersicht">Artikel</a>
        </li>
        <?php if(!isset($_SESSION['benutzerID'])): ?>
          <li class="nav-item">
            <a class="nav-link <?php if($page === "register") echo "active"; ?>" href="index.php?page=register">Register</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php if($page === "login") echo "active"; ?>" href="index.php?page=login">Login</a>
          </li>

        <?php endif; ?>
      </ul>
      <!-- Login/Logout Status -->
      <div class="d-flex">
        <?php if(isset($_SESSION['benutzerID'])): ?>
          <span class="navbar-text me-3">
            Willkommen, <?php echo htmlspecialchars($_SESSION['vorname']); ?>!
          </span>
          <a href="index.php?page=logout" class="btn btn-outline-danger">Logout</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>