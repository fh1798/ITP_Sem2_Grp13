<!-- Diese Datei ist der Startpunkt unseres Projektes, hier ist die Startseite ausprogrammiert,
  wobei session, header und footer als wiederkehrende Funktionen/Teile eingebungen werden. -->

<!-- session und header einbinden, so wie überall -->
<?php include 'include/fct_session.php';?>
<?php include 'include/header.php';?>

<!-- großes Headerfoto mit Knöpfen, die zum Blog und zur Zimmerreservierung führen -->
<div class="container-fluid hero">
  
  <div class="hero-content text-center text-white py-5 w-100">
    <div class="container">
        <h1 class="display-5 fw-bold">Blick and Glück</h1>
        <div class="col-lg-6 mx-auto">
          <p class="lead mb-4 display-7 fw-bold">Resort und SPA Hotel</p>
        </div> 
        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center"> <!-- Link-Buttons -->
            <button type="button" class="btn btn-primary btn-lg fw-bolder px-4">
              <a href="<?php echo str_replace($_SERVER['DOCUMENT_ROOT'], '', $_SERVER['DOCUMENT_ROOT'] . '/hotelprojekt-original/mergedProject/include/site_blog.php'); ?>" class="text-center text-white text-decoration-none">Mehr erfahren</a>
            </button>
            <button type="button" class="btn btn-primary btn-lg fw-bolder px-4"><a href="include/site_rooms.php" class="text-center text-white text-decoration-none">Zimmer buchen</a></button>
            
        </div>  
    </div>
  </div>
</div> 

<!-- netter Bereich mit einigen Hotelfotos -->
<div class="container-fluid bg-primary py-5">

    <div class="container text-center d-flex justify-content-center align-items-center">
        <div class="container d-block mt-3 p-3">
        <i class="fas fa-award fa-4x text-grey"></i>
        <h2 class="text-center display-6 fw-bold p-4">Unsere Leistungen</h2>
        </div>
    </div>
      
      <div class="container text-center  p-2 rounded">
        <div class="row align-items-center mb-4">
    
          <div class="col-12 col-md-4">
            <div class="img-container rounded-3">
              <img src="res/assets/img/1.jpg" alt="img-suit" class="img-fluid">
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="img-container rounded-3">
              <img src="res/assets/img/2.jpg" alt="img-double-room" class="img-fluid">
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="img-container rounded-3">
              <img src="res/assets/img/3.jpg" alt="img-sauna" class="img-fluid">
            </div>
          </div>
        </div>
        <div class="row g-3 align-items-center ">
          <div class="col-12 col-md-4">
            <div class="img-container rounded-3">
              <img src="res/assets/img/4.jpg" alt="img-restraurant" class="img-fluid">
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="img-container rounded-3">
              <img src="res/assets/img/5.jpg" alt="img-reception" class="img-fluid">
            </div>
          </div>
          <div class="col-12 col-md-4">
            <div class="img-container rounded-3">
              <img src="res/assets/img/6.jpg" alt="img-breakfast" class="img-fluid">
            </div>
          </div>
      </div>
    </div>
</div>

<!-- Einbindung einer Google-Maps Karte für den Hotel-Standort -->
<div class="container text-center my-2">
   
    <h2 class="text-center display-6 fw-bold mt-5">Location</h2>
      <div class="row justify-content-center">
        <div class="col-12 col-md-8 mt-5 pt-5">
          <div class="ration ratio-16x9">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2659.073292073073!2d13.37731231568263!3d52.51627407981147!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47b0e0f6b0e1e4e1%3A0x4e1f3b3f7f4d1b1d!2sAlexanderplatz%2C%2010178%20Berlin!5e0!3m2!1sen!2sde!4v1636823660003!5m2!1sen!2sde" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            <div>
                <h4 class="text-center py-3 ps-3">Sie finden uns hier</h4>
            </div>  
          </div>
        </div>
      </div>
</div>

<!-- Footer einbinden -->
<?php include 'include/footer.php';?>