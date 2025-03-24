<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <title>Home</title>
</head>
<body>

    <!--- Hero-Section -->
    <div class="min-vh-100 d-flex justify-content-center align-items-center flex-column text-white"
        style="background-image: url('images/hero.jpg'); background-repeat: no-repeat; background-position: center; background-size: cover">
        <div class="text-center">
            <h1 class="display-3 fw-bolder mb-3">Wir sind Motino</h1>
            <p class="fs-3 fw-light">Erlebe den Zauber des Duftes</p>
        </div>
    </div>

    <!-- About Section -->
    <div class="min-vh-100 py-5 d-flex align-items-center">
        <div class="container">
            <div class="row gy-4 align-items-center">
                <div class="col-12 col-lg-6">
                    <img class="img-fluid rounded shadow" loading="lazy" src="images/about.jpg" alt="About Motino">
                </div>
                <div class="col-12 col-lg-6">
                    <h2 class="display-5 fw-bold mb-3">Über uns</h2>
                    <p class="lead mb-3">Wir sind bestrebt, exklusive Dufterlebnisse zu schaffen und unseren Kunden außergewöhnliche Parfums zu bieten. Unser Ziel ist es, mit einzigartigen Kreationen Ihre Persönlichkeit zu unterstreichen.</p>  
                    <p class="mb-4">Während wir wachsen, bleiben unsere Kernwerte unverändert: Qualität, Innovation und Ihre Zufriedenheit stehen an erster Stelle. Wir suchen stets nach neuen Duftnoten und besonderen Kompositionen, um Ihre Erwartungen zu übertreffen und Ihnen unvergleichliche olfaktorische Erlebnisse zu ermöglichen.</p>  
                    
                    <div class="row gy-4 mt-2">
                        <div class="col-12 col-md-6">
                            <div class="d-flex">
                                <div class="me-3">
                                    <i class="bi bi-stars fs-3" style="color: #6C63FF;"></i>
                                </div>
                                <div>
                                    <h3 class="fs-4 mb-2">Zeitlose Eleganz</h3>
                                    <p class="text-secondary">Unser Fokus: edle Düfte, die Tradition mit modernen Nuancen verbinden und ein einzigartiges Dufterlebnis schaffen.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-12 col-md-6">
                            <div class="d-flex">
                                <div class="me-3">
                                    <i class="bi bi-droplet-fill fs-3" style="color: #6C63FF;"></i>
                                </div>
                                <div>
                                    <h3 class="fs-4 mb-2">Ein Hauch von Luxus</h3>
                                    <p class="text-secondary">Wir setzen auf erlesene Kompositionen und hochwertige Essenzen, um unvergessliche Duftmomente zu kreieren.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--- Testimonials Carousel Section --->
    <div class="min-vh-100 py-5 bg-light d-flex align-items-center">
        <div class="container">
            <h2 class="display-5 text-center fw-bold mb-4">Was unsere Kunden über uns sagen</h2>

            <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
                <!-- Carousel Indicators -->
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                
                <div class="carousel-inner py-4">
                    <!-- Testimonial 1 -->
                    <div class="carousel-item active">
                        <div class="d-flex justify-content-center">
                            <div class="text-center px-3" style="max-width: 700px;">
                                <img src="images/person1.jpg" class="rounded-circle mb-3 shadow" alt="client 1" height="100" width="100">
                                <h3 class="fs-4 fw-bold mb-2">Thomas Schuhmacher</h3>
                                <p class="mb-3">
                                    <i class="bi bi-star-fill" style="color: #EBF728;"></i>
                                    <i class="bi bi-star-fill" style="color: #EBF728;"></i>
                                    <i class="bi bi-star-fill" style="color: #EBF728;"></i>
                                    <i class="bi bi-star-fill" style="color: #EBF728;"></i>
                                    <i class="bi bi-star-fill" style="color: #EBF728;"></i>
                                </p>
                                <p class="fs-5">"Der Einkauf bei Motino war ein unvergessliches Erlebnis – eine riesige Auswahl und erstklassiger Service."</p>
                            </div>
                        </div>
                    </div>

                    <!-- Testimonial 2 -->
                    <div class="carousel-item">
                        <div class="d-flex justify-content-center">
                            <div class="text-center px-3" style="max-width: 700px;">
                                <img src="images/person2.jpg" class="rounded-circle mb-3 shadow" alt="client 2" height="100" width="100">
                                <h3 class="fs-4 fw-bold mb-2">Stefan Bauer</h3>
                                <p class="mb-3">
                                    <i class="bi bi-star-fill" style="color: #EBF728;"></i>
                                    <i class="bi bi-star-fill" style="color: #EBF728;"></i>
                                    <i class="bi bi-star-fill" style="color: #EBF728;"></i>
                                    <i class="bi bi-star-fill" style="color: #EBF728;"></i>
                                    <i class="bi bi-star-half" style="color: #EBF728;"></i>
                                </p>
                                <p class="fs-5">"Motino hat unsere Erwartungen übertroffen. Die exklusiven Düfte und schnellen Lieferzeiten haben uns begeistert."</p>
                            </div>
                        </div>
                    </div>

                    <!-- Testimonial 3 -->
                    <div class="carousel-item">
                        <div class="d-flex justify-content-center">
                            <div class="text-center px-3" style="max-width: 700px;">
                                <img src="images/person3.jpg" class="rounded-circle mb-3 shadow" alt="client 3" height="100" width="100">
                                <h3 class="fs-4 fw-bold mb-2">Hansi Flick</h3>
                                <p class="mb-3">
                                    <i class="bi bi-star-fill" style="color: #EBF728;"></i>
                                    <i class="bi bi-star-fill" style="color: #EBF728;"></i>
                                    <i class="bi bi-star-fill" style="color: #EBF728;"></i>
                                    <i class="bi bi-star-fill" style="color: #EBF728;"></i>
                                    <i class="bi bi-star-fill" style="color: #EBF728;"></i>
                                </p>
                                <p class="fs-5">"Die perfekte Kombination aus Vielfalt und Qualität. Dank Motino war das Finden des perfekten Parfums so einfach wie nie."</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Carousel Controls -->
                <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>

    <!-- script hinzugefügt damit Carousel funktioniert -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
