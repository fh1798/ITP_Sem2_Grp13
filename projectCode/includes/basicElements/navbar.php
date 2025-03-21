<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Fragrance Shop</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link  <?php if($page === "home") echo "active"; ?>" href="index.php?page=home">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link  <?php if($page === "faq") echo "active"; ?>" href="index.php?page=faq">FAQs</a>
        </li>
        <li class="nav-item">
          <a class="nav-link  <?php if($page === "impressum") echo "active"; ?>" href="index.php?page=impressum">Impressum</a>
        </li>
      </ul>

      <!-- Login/Logout for Sprint 2-->
      
    </div>
  </div>
</nav>