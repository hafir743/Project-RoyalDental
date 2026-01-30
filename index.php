<?php
require_once 'includes/config.php';

$page_title = 'Home';
include 'includes/header.php';
include 'includes/admin-edit.php';
?>

<section class="hero" id="home">
    <video autoplay muted loop class="hero-video">
        <source src="hyrje.MP4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <img src="royaldental.png" alt="Royal Dental Logo" class="hero-logo">
        <h4>We give You a Royal Smile</h4>
    </div>
    <div class="scroll-indicator">
        <i class="fas fa-chevron-down bounce"></i>
    </div>
</section>

<section class="why-choose-us" id="about">
    <div class="container">

        <div class="admin-edit-section">
            <?php if (isAdmin()): ?>
                <span class="admin-edit-icon" onclick="alert('Use Dashboard to edit page content!')" title="Edit Section">
                    <i class="fas fa-edit"></i>
                </span>
            <?php endif; ?>
            <h2 class="section-title">Why Choose Royal Dental</h2>
        </div>
        <div class="cards-grid">
            <div class="feature-card">
                <div class="card-icon">
                    <i class="fas fa-tooth"></i>
                </div>
                <video class="bg-video" autoplay muted loop>
                    <source src="modelimi.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                <h3>Digital Smile Design</h3>
                <p>Precise 3D modeling for perfect planning</p>
            </div>
            <div class="feature-card">
                <div class="card-icon">
                    <i class="fas fa-cogs"></i>
                </div>
                <video class="bg-video" autoplay muted loop>
                    <source src="cad cam.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                <h3>CAD/CAM Precision</h3>
                <p>Computer-guided milling for exact results</p>
            </div>
            <div class="feature-card">
                <div class="card-icon">
                    <i class="fas fa-spa"></i>
                </div>
                <video class="bg-video" autoplay muted loop>
                    <source src="Emax ceram.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                <h3>Ceramic Aesthetics</h3>
                <p>Natural-looking ceramic restorations</p>
            </div>
            <div class="feature-card">
                <div class="card-icon">
                    <i class="fas fa-award"></i>
                </div>
                <video class="bg-video" autoplay muted loop>
                    <source src="glazura.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                <h3>Final Perfection</h3>
                <p>Flawless finish with premium quality</p>
            </div>
        </div>
    </div>
</section>

<section class="featured-services" id="services">
    <div class="container">
        <h2 class="section-title">Featured Services</h2>
        <div class="services-grid">
            <a href="services.php#dental-implants" class="service-card">
                <div class="service-image">
                    <img src="inplante.jpg" alt="Dental Implants">
                </div>
                <h3>Dental Implants</h3>
            </a>
            <a href="services.php#emax" class="service-card">
                <div class="service-image">
                    <img src="emax.jpg" alt="emax">
                </div>
                <h3>Emax</h3>
            </a>
            <a href="services.php#zirconia" class="service-card">
                <div class="service-image">
                    <img src="Zricoina.jpg" alt="Zricoina">
                </div>
                <h3>Zricoina</h3>
            </a>
            <a href="services.php#aligners" class="service-card">
                <div class="service-image">
                    <img src="aligners.jpg" alt="aligners">
                </div>
                <h3>Aligners</h3>
            </a>
            <a href="services.php#veneers" class="service-card">
                <div class="service-image">
                    <img src="venners.jpg" alt="Veneers">
                </div>
                <h3>Veneers</h3>
            </a>
            <a href="services.php#metal-ceramic" class="service-card">
                <div class="service-image">
                    <img src="metal ceramic.jpg" alt="metal ceramic">
                </div>
                <h3>Metal Ceramic</h3>
            </a>
        </div>
        <div class="services-cta">
            <a href="services.php" class="btn-outline">See All Services</a>
        </div>
    </div>
</section>

<section class="smile-transformations" id="gallery">
    <div class="container">
        <h2 class="section-title">Life-Changing Smiles. Real Results.</h2>
        <div class="slider-container">
            <div class="slider-wrapper">
                <div class="slider-track">
                    <div class="slider-slide">
                        <div class="before-after">
                            <div class="before">
                                <h4>Before</h4>
                                <div class="image-placeholder before-img">
                                    <img src="before11.jpg" alt="Before Smile" class="before-img">
                                </div>
                            </div>
                            <div class="after">
                                <h4>After</h4>
                                <div class="image-placeholder after-img">
                                    <img src="after.jpg" alt="After" class="After">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="slider-slide">
                        <div class="before-after">
                            <div class="before">
                                <h4>Before</h4>
                                <div class="image-placeholder before-img">
                                    <img src="before2jpg.jpg" alt="Before Smile" class="before-img">
                                </div>
                            </div>
                            <div class="after">
                                <h4>After</h4>
                                <div class="image-placeholder after-img">
                                    <img src="after2.jpg" alt="After" class="After">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="slider-slide">
                        <div class="before-after">
                            <div class="before">
                                <h4>Before</h4>
                                <div class="image-placeholder before-img">
                                    <img src="before3.jpg" alt="Before Smile" class="before-img">
                                </div>
                            </div>
                            <div class="after">
                                <h4>After</h4>
                                <div class="image-placeholder after-img">
                                    <img src="after3.jpg" alt="After" class="After">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="slider-slide">
                        <div class="before-after">
                            <div class="before">
                                <h4>Before</h4>
                                <div class="image-placeholder before-img">
                                    <img src="before4.jpg" alt="Before Smile" class="before-img">
                                </div>
                            </div>
                            <div class="after">
                                <h4>After</h4>
                                <div class="image-placeholder after-img">
                                    <img src="after4.jpg" alt="After" class="After">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button class="slider-btn prev" aria-label="Previous"><i class="fas fa-chevron-left"></i></button>
            <button class="slider-btn next" aria-label="Next"><i class="fas fa-chevron-right"></i></button>
        </div>
    </div>
</section>

<section class="testimonials">
    <div class="container">
        <h2 class="section-title">What Our Partners Say</h2>
        <div class="testimonials-carousel">
            <div class="testimonial-card active">
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="testimonial-text">"Royal Dental is our trusted laboratory partner. Their precision,
                    reliability, and attention to detail consistently exceed our expectations."</p>
                <div class="testimonial-author">
                    <div class="author-avatar"></div>
                    <div class="author-info">
                        <h4>Goga Dent</h4>
                        <p>Dental Clinic</p>
                    </div>
                </div>
            </div>
            <div class="testimonial-card">
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="testimonial-text">"The quality of CAD/CAM work and ceramic aesthetics from Royal Dental is
                    outstanding. Every case is delivered with accuracy and care"</p>
                <div class="testimonial-author">
                    <div class="author-avatar"></div>
                    <div class="author-info">
                        <h4>Mici Dent</h4>
                        <p>Dental Clinic</p>
                    </div>
                </div>
            </div>
            <div class="testimonial-card">
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="testimonial-text">"Professional communication, fast turnaround, and premium results. Royal
                    Dental plays a key role in the success of our treatments."</p>
                <div class="testimonial-author">
                    <div class="author-avatar"></div>
                    <div class="author-info">
                        <h4>Pirraku Dent</h4>
                        <p>Dental Clinic</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="carousel-indicators">
            <span class="indicator active" data-slide="0"></span>
            <span class="indicator" data-slide="1"></span>
            <span class="indicator" data-slide="2"></span>
        </div>
    </div>
</section>

<section class="our-doctors" id="team">
    <div class="container">
        <h2 class="section-title">Meet Our Staff</h2>
        <div class="doctors-grid">
            <div class="doctor-card">
                <div class="doctor-image">
                    <div class="doctor-placeholder">
                        <img src="Hafir Kurtishi.jpg" alt="Dt. Hafir Kurtishi">
                    </div>
                    <div class="doctor-social">
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-facebook"></i></a>
                    </div>
                </div>
                <h3>Dt.Arlind Ahmeti</h3>
                <p>Dental technical</p>
            </div>
            <div class="doctor-card">
                <div class="doctor-image">
                    <div class="doctor-placeholder">
                        <img src="Hafir Kurtishi.jpg" alt="Dt. Hafir Kurtishi">
                    </div>
                    <div class="doctor-social">
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-facebook"></i></a>
                    </div>
                </div>
                <h3>Dt.Hafir Kurtishi</h3>
                <p>Dental technical</p>
            </div>
            <div class="doctor-card">
                <div class="doctor-image">
                    <div class="doctor-placeholder">
                        <img src="Hafir Kurtishi.jpg" alt="Dt. Hafir Kurtishi">
                    </div>
                    <div class="doctor-social">
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-facebook"></i></a>
                    </div>
                </div>
                <h3>Dt.Edonis Kurtishi</h3>
                <p>Dental technical</p>
            </div>
        </div>
    </div>
</section>

<section class="book-appointment" id="appointment">
    <div class="cta-overlay"></div>
    <div class="container">
        <h2 class="cta-title">Ready for Your Royal Smile?</h2>
        <a href="contact.php#appointment" class="btn-cta">Send a Case</a>
    </div>
</section>

<?php include 'includes/footer.php'; ?>