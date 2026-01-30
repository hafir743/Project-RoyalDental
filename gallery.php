<?php
require_once 'includes/config.php';
$page_title = 'Gallery';
$custom_css = 'gallery.css';
include 'includes/header.php';
?>


<section class="hero gallery-hero">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1 class="hero-title">Smile Transformations</h1>
        <p>Life-Changing Smiles. Real Results.</p>
    </div>
</section>

<section class="gallery-page">
    <div class="container">
        <div class="gallery-intro">
            <h2>Before & After Gallery</h2>
            <p>Witness the transformative power of our premium dental restorations. Each case represents our commitment
                to excellence, precision, and artistry in creating beautiful, functional smiles.</p>
        </div>

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
                                    <img src="after.jpg" alt="After Smile" class="after-img">
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
                                    <img src="after2.jpg" alt="After Smile" class="after-img">
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

        <div class="gallery-grid">
            <h2 class="section-title">Our Work</h2>
            <div class="gallery-items">
                <div class="gallery-item">
                    <img src="emax.jpg" alt="Emax Restoration">
                    <div class="gallery-overlay">
                        <h3>Emax Restoration</h3>
                        <p>Premium all-ceramic restoration</p>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="inplante.jpg" alt="Dental Implant">
                    <div class="gallery-overlay">
                        <h3>Dental Implant</h3>
                        <p>High-grade titanium implant</p>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="Zricoina.jpg" alt="Zirconia Crown">
                    <div class="gallery-overlay">
                        <h3>Zirconia Crown</h3>
                        <p>Maximum strength restoration</p>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="venners.jpg" alt="Porcelain Veneers">
                    <div class="gallery-overlay">
                        <h3>Porcelain Veneers</h3>
                        <p>Ultra-thin smile transformation</p>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="aligners.jpg" alt="Clear Aligners">
                    <div class="gallery-overlay">
                        <h3>Clear Aligners</h3>
                        <p>Nearly invisible orthodontics</p>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="metal ceramic.jpg" alt="Metal Ceramic">
                    <div class="gallery-overlay">
                        <h3>Metal Ceramic</h3>
                        <p>Durable traditional restoration</p>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="GoldDonXhoni.jpg" alt="Golden Teeth">
                    <div class="gallery-overlay">
                        <h3>Premium Gold Teeth</h3>
                        <p>Reliable, long-lasting dental solutions</p>
                    </div>
                </div>
                <div class="gallery-item">
                    <img src="ProtezaTotale.jpg" alt="Total Prothesis">
                    <div class="gallery-overlay">
                        <h3>Total Prothesis</h3>
                        <p>Removable solution tailored to your smile</p>
                    </div>
                </div>
                <?php if (!empty($galleryItems)): ?>
                    <?php foreach ($galleryItems as $item): ?>
                        <div class="gallery-item">
                            <?php if ($item['image']): ?>
                                <img src="uploads/images/<?php echo htmlspecialchars($item['image']); ?>"
                                    alt="<?php echo htmlspecialchars($item['title']); ?>">
                            <?php else: ?>
                                <div
                                    style="width: 100%; height: 300px; background: var(--dark-gray); display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-image" style="font-size: 3rem; color: var(--gold); opacity: 0.5;"></i>
                                </div>
                            <?php endif; ?>
                            <div class="gallery-overlay">
                                <h3><?php echo htmlspecialchars($item['title']); ?></h3>
                                <p><?php echo htmlspecialchars(substr($item['description'], 0, 100)); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

                <div class="gallery-item">
                    <img src="PortezaParciale.jpg" alt="Partial Denture">
                    <div class="gallery-overlay">
                        <h3>Partial Denture</h3>
                        <p>Custom-made for comfort and function</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="book-appointment">
    <div class="cta-overlay"></div>
    <div class="container">
        <h2 class="cta-title">Ready to Transform Your Smile?</h2>
        <a href="contact.php#appointment" class="btn-cta">Send a Case</a>
    </div>
</section>

<?php include 'includes/footer.php'; ?>