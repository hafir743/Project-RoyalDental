<footer class="footer" id="contact">
    <div class="container">
        <div class="footer-content">
            <div class="footer-column">
                <div class="footer-logo">
                    <img src="royaldental.png" alt="Royal Dental Logo" style="width: 250px; height: auto;">
                </div>
                <p>We give you a Royal Smile.</p>
            </div>
            <div class="footer-column">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="about-us.php">About Us</a></li>
                    <li><a href="services.php">Services</a></li>
                    <li><a href="products.php">Products</a></li>
                    <li><a href="gallery.php">Gallery</a></li>
                    <li><a href="news.php">News</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>Contact Us</h3>
                <ul class="contact-info">
                    <li><i class="fas fa-phone"></i> +383 48 600 417</li>
                    <li><i class="fas fa-envelope"></i> royaldentalfr@gmail.com</li>
                    <li><i class="fas fa-map-marker-alt"></i> 12 Qershori Ferizaj Kosovë</li>
                    <li><i class="fas fa-clock"></i> Mon-Fri: 9AM-7PM | Sat: 10AM-4PM</li>
                </ul>
            </div>
        </div>
        <div class="footer-social">
            <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
            <a href="#" aria-label="Facebook"><i class="fab fa-facebook"></i></a>
            <a href="#" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2025 Royal Dental. All Rights Reserved.</p>
        </div>
    </div>
</footer>
<script>
    const hamburger = document.querySelector('.hamburger');
    const navMenu = document.querySelector('.nav-menu');
    if (hamburger) {
        hamburger.addEventListener('click', () => {
            hamburger.classList.toggle('active');
            navMenu.classList.toggle('active');
        });
    }
</script>
<script src="js/slider.js"></script>
</body>

</html>