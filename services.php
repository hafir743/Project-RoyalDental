<?php
require_once 'includes/config.php';

$db = new Database();
$connection = $db->getConnection();
$service = new Service($connection);

$services = $service->getActive();

$page_title = 'Services';
$custom_css = 'services.css';
include 'includes/header.php';
include 'includes/admin-edit.php';
?>


<section class="hero services-hero">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1 class="hero-title">Our Premium Services</h1>
        <p>Advanced dental restorations with cutting-edge technology and expert craftsmanship</p>
    </div>
</section>
<section class="services-page">
    <div class="container">
        <div class="services-intro">
            <h2>Comprehensive Dental Solutions</h2>
            <p>At Royal Dental Laboratory, we specialize in creating the finest dental restorations using
                state-of-the-art CAD/CAM technology and premium materials. Each restoration is crafted with precision,
                attention to detail, and a commitment to excellence.</p>
        </div>

        <div class="services-grid-detailed">
            <div class="service-card-detailed" id="dental-implants">
                <div class="service-image">
                    <img src="inplante.jpg" alt="Dental Implants">
                </div>
                <div class="service-content">
                    <h3>Dental Implants</h3>
                    <p>Premium dental implants designed for durability and natural appearance. Our implant restorations
                        provide optimal functionality and aesthetics, ensuring long-lasting results.</p>
                    <ul class="service-features">
                        <li><i class="fas fa-check"></i> High-grade titanium construction</li>
                        <li><i class="fas fa-check"></i> Custom-designed for perfect fit</li>
                        <li><i class="fas fa-check"></i> Lifetime durability</li>
                    </ul>
                </div>
            </div>

            <div class="service-card-detailed" id="emax">
                <div class="service-image">
                    <img src="emax.jpg" alt="Emax">
                </div>
                <div class="service-content">
                    <h3>Emax</h3>
                    <p>IPS e.max all-ceramic restorations known for exceptional strength and esthetics. Perfect for
                        crowns, veneers, and bridges with superior light transmission.</p>
                    <ul class="service-features">
                        <li><i class="fas fa-check"></i> Superior aesthetics</li>
                        <li><i class="fas fa-check"></i> High strength lithium disilicate</li>
                        <li><i class="fas fa-check"></i> Natural tooth appearance</li>
                    </ul>
                </div>
            </div>

            <div class="service-card-detailed" id="zirconia">
                <div class="service-image">
                    <img src="Zricoina.jpg" alt="Zirconia">
                </div>
                <div class="service-content">
                    <h3>Zirconia</h3>
                    <p>High-strength zirconia restorations offering exceptional durability and biocompatibility. Ideal
                        for posterior crowns and bridges where strength is paramount.</p>
                    <ul class="service-features">
                        <li><i class="fas fa-check"></i> Maximum strength and durability</li>
                        <li><i class="fas fa-check"></i> Biocompatible material</li>
                        <li><i class="fas fa-check"></i> Metal-free option</li>
                    </ul>
                </div>
            </div>

            <div class="service-card-detailed" id="aligners">
                <div class="service-image">
                    <img src="aligners.jpg" alt="Aligners">
                </div>
                <div class="service-content">
                    <h3>Aligners</h3>
                    <p>Clear aligner systems for orthodontic treatment. Custom-designed using advanced 3D scanning and
                        printing technology for comfortable, effective teeth alignment.</p>
                    <ul class="service-features">
                        <li><i class="fas fa-check"></i> Nearly invisible design</li>
                        <li><i class="fas fa-check"></i> Custom-fit for each patient</li>
                        <li><i class="fas fa-check"></i> Comfortable to wear</li>
                    </ul>
                </div>
            </div>

            <div class="service-card-detailed" id="veneers">
                <div class="service-image">
                    <img src="venners.jpg" alt="Veneers">
                </div>
                <div class="service-content">
                    <h3>Veneers</h3>
                    <p>Ultra-thin porcelain veneers that transform smiles with minimal tooth preparation. Crafted to
                        match natural tooth color and translucency perfectly.</p>
                    <ul class="service-features">
                        <li><i class="fas fa-check"></i> Minimal tooth preparation</li>
                        <li><i class="fas fa-check"></i> Natural color matching</li>
                        <li><i class="fas fa-check"></i> Stain-resistant surface</li>
                    </ul>
                </div>
            </div>

            <div class="service-card-detailed" id="metal-ceramic">
                <div class="service-image">
                    <img src="metal ceramic.jpg" alt="Metal Ceramic">
                </div>
                <div class="service-content">
                    <h3>Metal Ceramic</h3>
                    <p>Traditional metal-ceramic crowns and bridges combining the strength of metal with the aesthetics
                        of porcelain. Time-tested solution for durable restorations.</p>
                    <ul class="service-features">
                        <li><i class="fas fa-check"></i> Proven durability</li>
                        <li><i class="fas fa-check"></i> Excellent strength</li>
                        <li><i class="fas fa-check"></i> Cost-effective option</li>
                    </ul>
                </div>
            </div>

            <?php if (!empty($services)): ?>
                <?php foreach ($services as $s): ?>
                    <div class="service-card-detailed" id="<?php echo htmlspecialchars($s['slug']); ?>">
                        <div class="service-image">
                            <?php if ($s['image']): ?>
                                <img src="uploads/images/<?php echo htmlspecialchars($s['image']); ?>"
                                    alt="<?php echo htmlspecialchars($s['name']); ?>">
                            <?php else: ?>
                                <div
                                    style="width: 100%; height: 100%; background: var(--dark-gray); display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-tooth" style="font-size: 4rem; color: var(--gold); opacity: 0.5;"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="service-content">
                            <h3><?php echo htmlspecialchars($s['name']); ?></h3>
                            <div class="service-description">
                                <p><?php echo nl2br(htmlspecialchars($s['description'])); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>
<section class="technology-section">
    <div class="container">
        <h2 class="section-title">Advanced Technology</h2>
        <div class="tech-grid">
            <div class="tech-card">
                <i class="fas fa-microchip"></i>
                <h3>CAD/CAM Technology</h3>
                <p>Superior CAD/CAM systems from ImesIcore for precision manufacturing and design.</p>
            </div>
            <div class="tech-card">
                <i class="fas fa-cube"></i>
                <h3>3D Scanning</h3>
                <p>High-resolution digital impressions for accurate restorations.</p>
            </div>
            <div class="tech-card">
                <i class="fas fa-print"></i>
                <h3>3D Printing</h3>
                <p>State-of-the-art 3D printing for models and temporary restorations.</p>
            </div>
            <div class="tech-card">
                <i class="fas fa-palette"></i>
                <h3>Expert Craftsmanship</h3>
                <p>20+ years of experience in creating beautiful, functional restorations.</p>
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