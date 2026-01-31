<?php
require_once 'includes/config.php';

$db = new Database();
$connection = $db->getConnection();
$contact = new Contact($connection);
$appointment = new Appointment($connection);

$contactError = '';
$contactSuccess = '';
$appointmentError = '';
$appointmentSuccess = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['contact_form'])) {
    $name = sanitizeInput($_POST['name'] ?? '');
    $email = sanitizeInput($_POST['email'] ?? '');
    $phone = sanitizeInput($_POST['phone'] ?? '');
    $subject = sanitizeInput($_POST['subject'] ?? '');
    $message = sanitizeInput($_POST['message'] ?? '');

    if (empty($name) || empty($email) || empty($message)) {
        $contactError = 'Please fill in all required fields';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $contactError = 'Please enter a valid email address';
    } else {
        $result = $contact->create($name, $email, $phone, $subject, $message);
        if ($result['success']) {
            $contactSuccess = 'Thank you for your message! We will get back to you soon.';
            $_POST = array();
        } else {
            $contactError = 'Failed to send message. Please try again.';
        }
    }
}

if (isLoggedIn() && $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['appointment_form'])) {
    $name = sanitizeInput($_POST['appt-name'] ?? '');
    $email = sanitizeInput($_POST['appt-email'] ?? '');
    $phone = sanitizeInput($_POST['appt-phone'] ?? '');
    $service = sanitizeInput($_POST['appt-service'] ?? '');
    $color = sanitizeInput($_POST['appt-color'] ?? '');
    $tooth_shape = sanitizeInput($_POST['appt-shape'] ?? '');
    $preferred_date = $_POST['appt-date'] ?? '';
    $preferred_time = $_POST['appt-time'] ?? '';
    $notes = sanitizeInput($_POST['appt-message'] ?? '');

    $uploadedFiles = [];
    $uploadErrors = [];

    if (isset($_FILES['appt-files']) && !empty($_FILES['appt-files']['name'][0])) {
        if (!is_dir(UPLOAD_APPOINTMENTS)) {
            mkdir(UPLOAD_APPOINTMENTS, 0755, true);
        }

        $fileCount = count($_FILES['appt-files']['name']);

        for ($key = 0; $key < $fileCount; $key++) {
            $fileName = $_FILES['appt-files']['name'][$key];
            $fileError = $_FILES['appt-files']['error'][$key];

            if ($fileError === UPLOAD_ERR_OK && !empty($fileName)) {
                $file = [
                    'name' => $fileName,
                    'type' => $_FILES['appt-files']['type'][$key],
                    'tmp_name' => $_FILES['appt-files']['tmp_name'][$key],
                    'error' => $fileError,
                    'size' => $_FILES['appt-files']['size'][$key]
                ];

                $allowedTypes = array_merge(
                    ALLOWED_IMAGE_TYPES,
                    ALLOWED_PDF_TYPES,
                    ALLOWED_3D_TYPES,
                    ALLOWED_DICOM_TYPES,
                    ['application/octet-stream']
                );

                $result = uploadFile($file, UPLOAD_APPOINTMENTS, $allowedTypes, MAX_PDF_SIZE, ALLOWED_FILE_EXTENSIONS);

                if ($result['success']) {
                    $uploadedFiles[] = $result['filename'];
                } else {
                    $uploadErrors[] = $fileName . ': ' . $result['message'];
                }
            } elseif ($fileError !== UPLOAD_ERR_NO_FILE) {
                $uploadErrors[] = $fileName . ': Upload error code ' . $fileError;
            }
        }
    }

    if (!empty($uploadErrors) && empty($uploadedFiles)) {
        $appointmentError = 'File upload error: ' . implode(', ', $uploadErrors);
    } elseif (!empty($uploadErrors)) {
        $appointmentError = 'Some files failed to upload: ' . implode(', ', $uploadErrors);
    }

    $filesString = !empty($uploadedFiles) ? implode(',', $uploadedFiles) : null;

    if (empty($name) || empty($email) || empty($phone) || empty($preferred_date) || empty($preferred_time)) {
        $appointmentError = 'Please fill in all required fields';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $appointmentError = 'Please enter a valid email address';
    } else {
        $selectedDate = new DateTime($preferred_date);
        $minDate = new DateTime();
        $minDate->modify('+3 days');
        $minDate->setTime(0, 0, 0);
        $selectedDate->setTime(0, 0, 0);

        if ($selectedDate < $minDate) {
            $appointmentError = 'Selected date must be at least 3 days from today';
        } else {
            $result = $appointment->create($name, $email, $phone, $service, $color, $tooth_shape, $preferred_date, $preferred_time, $notes, $filesString);
            if ($result['success']) {
                $n = count($uploadedFiles);
                $appointmentSuccess = 'Thank you! Your case has been submitted successfully.' . ($n ? ' ' . $n . ' ' . ($n === 1 ? 'file' : 'files') . ' uploaded successfully.' : '') . ' We will contact you soon for confirmation.';
                $_POST = array();
            } else {
                $appointmentError = 'Failed to submit case. Please try again.';
            }
        }
    }
}

$page_title = 'Contact';
$custom_css = 'contact.css';
include 'includes/header.php';
?>


<body>
    <section class="hero contact-hero">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1 class="hero-title">Contact Us</h1>
            <p>We're here to help you achieve your perfect smile</p>
        </div>
    </section>
    <section class="contact-info-section">
        <div class="container">
            <div class="contact-cards">
                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h3>Location</h3>
                    <p>12 Qershori<br>Ferizaj, Kosovë</p>
                </div>
                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <h3>Phone</h3>
                    <p>+383 48 600 417</p>
                </div>
                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h3>Email</h3>
                    <p>royaldentalfr@gmail.com</p>
                </div>
                <div class="contact-card">
                    <div class="contact-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3>Working Hours</h3>
                    <p>Mon-Fri: 9AM-7PM<br>Sat: 10AM-4PM</p>
                </div>
            </div>
        </div>
    </section>
    <section class="contact-form-section">
        <div class="container">
            <div class="contact-wrapper">
                <div class="contact-form-container">
                    <h2>Send Us a Message</h2>
                    <p>Have a question or want to learn more about our services? Fill out the form below and we'll get
                        back to you as soon as possible.</p>

                    <?php if ($contactError): ?>
                        <div class="alert-message alert-error" id="contactError">
                            <i class="fas fa-exclamation-circle"></i>
                            <span><?php echo htmlspecialchars($contactError); ?></span>
                            <button class="alert-close" onclick="this.parentElement.remove()">&times;</button>
                        </div>
                    <?php endif; ?>

                    <?php if ($contactSuccess): ?>
                        <div class="alert-message alert-success" id="contactSuccess">
                            <i class="fas fa-check-circle"></i>
                            <span><?php echo htmlspecialchars($contactSuccess); ?></span>
                            <button class="alert-close" onclick="this.parentElement.remove()">&times;</button>
                        </div>
                    <?php endif; ?>

                    <form class="contact-form" id="contactForm" method="POST" action="">
                        <input type="hidden" name="contact_form" value="1">
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" id="phone" name="phone" required>
                        </div>
                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <input type="text" id="subject" name="subject" required>
                        </div>
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea id="message" name="message" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn-submit">Send Message</button>
                    </form>
                </div>
                <div class="map-container">
                    <h2>Find Us</h2>
                    <div class="map-placeholder">
                        <iframe src="https://www.google.com/maps?q=9592+7Q4,+12+Qershor,+Ferizaj+70000&output=embed"
                            width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                        <p>12 Qershori, Ferizaj, Kosovë</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="appointment-section" id="appointment">
        <div class="container">
            <h2 class="section-title">Send a Case</h2>

            <?php if (!isLoggedIn()): ?>
                <div class="alert-message alert-info"
                    style="text-align: center; margin-bottom: 30px; background-color: rgba(201, 162, 78, 0.1); border: 1px solid var(--gold); border-radius: 8px; padding: 20px;">
                    <i class="fas fa-info-circle"
                        style="color: var(--gold); font-size: 1.5rem; margin-bottom: 15px; display: block;"></i>
                    <p style="margin-bottom: 15px;">You must be logged in to send a case.</p>
                    <a href="login.php?redirect=contact" class="btn-submit"
                        style="display: inline-block; width: auto; text-decoration: none; padding: 10px 30px;">Login
                        Here</a>
                </div>
            <?php else: ?>
                <p class="section-subtitle">Schedule a consultation with our expert team</p>

                <?php if ($appointmentError): ?>
                    <div class="alert-message alert-error" id="appointmentError">
                        <i class="fas fa-exclamation-circle"></i>
                        <span><?php echo htmlspecialchars($appointmentError); ?></span>
                        <button class="alert-close" onclick="this.parentElement.remove()">&times;</button>
                    </div>
                <?php endif; ?>

                <?php if ($appointmentSuccess): ?>
                    <div class="alert-message alert-success" id="appointmentSuccess">
                        <i class="fas fa-check-circle"></i>
                        <span><?php echo htmlspecialchars($appointmentSuccess); ?></span>
                        <button class="alert-close" onclick="this.parentElement.remove()">&times;</button>
                    </div>
                <?php endif; ?>

                <form class="appointment-form" id="appointmentForm" method="POST" action="#appointment"
                    enctype="multipart/form-data">
                    <input type="hidden" name="appointment_form" value="1">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="appt-name">Full Name *</label>
                            <input type="text" id="appt-name" name="appt-name" required>
                        </div>
                        <div class="form-group">
                            <label for="appt-email">Email Address *</label>
                            <input type="email" id="appt-email" name="appt-email" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="appt-phone">Phone Number *</label>
                            <input type="tel" id="appt-phone" name="appt-phone" required>
                        </div>
                        <div class="form-group">
                            <label for="appt-service">Service Interested In *</label>
                            <select id="appt-service" name="appt-service" required>
                                <option value="">Select a service</option>
                                <option value="dental-implants">Dental Implants</option>
                                <option value="emax">Emax</option>
                                <option value="zirconia">Zirconia</option>
                                <option value="aligners">Aligners</option>
                                <option value="veneers">Veneers</option>
                                <option value="metal-ceramic">Metal Ceramic</option>
                                <option value="Total Prosthesis">Total Prosthesis</option>
                                <option value="Partial Denture">Partial Denture</option>
                                <option value="Gold Teeth">Gold Teeth</option>
                                <option value="consultation">General Consultation</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="appt-color">Color *</label>
                            <select id="appt-color" name="appt-color" required>
                                <option value="">Select a color</option>
                                <option value="A1">A1</option>
                                <option value="A2">A2</option>
                                <option value="A3">A3</option>
                                <option value="B1">B1</option>
                                <option value="B2">B2</option>
                                <option value="BL1">BL1</option>
                                <option value="BL2">BL2</option>
                                <option value="BL3">BL3</option>
                                <option value="C1">C1</option>
                                <option value="C2">C2</option>
                                <option value="D1">D1</option>
                                <option value="D2">D2</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="appt-shape">Tooth Shapes *</label>
                            <select id="appt-shape" name="appt-shape" required>
                                <option value="">Select a Tooth Shapes</option>
                                <option value="Oval">Oval</option>
                                <option value="Square">Square</option>
                                <option value="Tapered">Tapered</option>
                                <option value="Round">Round</option>
                                <option value="Quadrangular">Quadrangular</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="appt-date">Preferred Date *</label>
                            <input type="date" id="appt-date" name="appt-date" required>
                        </div>
                        <div class="form-group">
                            <label for="appt-time">Preferred Time *</label>
                            <select id="appt-time" name="appt-time" required>
                                <option value="">Select a time</option>
                                <option value="09:00">9:00 AM</option>
                                <option value="10:00">10:00 AM</option>
                                <option value="11:00">11:00 AM</option>
                                <option value="12:00">12:00 PM</option>
                                <option value="13:00">1:00 PM</option>
                                <option value="14:00">2:00 PM</option>
                                <option value="15:00">3:00 PM</option>
                                <option value="16:00">4:00 PM</option>
                                <option value="17:00">5:00 PM</option>
                                <option value="18:00">6:00 PM</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="appt-message">Additional Notes</label>
                        <textarea id="appt-message" name="appt-message" rows="4"
                            placeholder="Any specific requests or information you'd like us to know..."></textarea>
                    </div>
                    <div class="form-group file-upload-group">
                        <label for="appt-files">Upload Files (Optional)</label>
                        <p class="file-upload-hint">You can upload 3D scans, photos, X-rays, or other dental files (Max 10MB
                            per file). You can upload multiple files.</p>
                        <div class="file-upload-wrapper">
                            <input type="file" id="appt-files" name="appt-files[]" multiple
                                accept="image/*,.stl,.obj,.ply,.dcm,.pdf" class="file-input">
                            <label for="appt-files" class="file-upload-label">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <span>Choose files or drag and drop</span>
                            </label>
                            <div class="file-list" id="fileList"></div>
                        </div>
                    </div>
                    <button type="submit" class="btn-submit">Send a Case</button>
                </form>
            <?php endif; ?>
        </div>
    </section>
</body>

</html>
<script>
    (function () {
        var d = new Date();
        d.setDate(d.getDate() + 3);
        var minDate = d.getFullYear() + '-' + String(d.getMonth() + 1).padStart(2, '0') + '-' + String(d.getDate()).padStart(2, '0');
        var dateInput = document.getElementById('appt-date');
        if (dateInput) {
            dateInput.setAttribute('min', minDate);
            dateInput.setAttribute('placeholder', 'Select date (earliest: ' + minDate + ')');
        }
        var fileInput = document.getElementById('appt-files');
        var fileList = document.getElementById('fileList');
        if (fileInput && fileList) {
            fileInput.addEventListener('change', function () {
                fileList.innerHTML = '';
                for (var i = 0; i < this.files.length; i++) {
                    var f = this.files[i];
                    var div = document.createElement('div');
                    div.className = 'file-item';
                    div.innerHTML = '<i class="fas fa-file"></i> ' + f.name + ' (' + (f.size / 1024 / 1024).toFixed(2) + ' MB)';
                    fileList.appendChild(div);
                }
            });
        }
        document.addEventListener('DOMContentLoaded', function () {
            var contactSuccess = document.getElementById('contactSuccess');
            var contactError = document.getElementById('contactError');
            var appointmentSuccess = document.getElementById('appointmentSuccess');
            var appointmentError = document.getElementById('appointmentError');
            var msg = contactSuccess || contactError;
            if (msg) setTimeout(function () { msg.scrollIntoView({ behavior: 'smooth', block: 'center' }); }, 100);
            msg = appointmentSuccess || appointmentError;
            if (msg) setTimeout(function () { msg.scrollIntoView({ behavior: 'smooth', block: 'center' }); }, 100);
            if (contactSuccess) {
                document.getElementById('contactForm').reset();
                setTimeout(function () { contactSuccess.style.opacity = '0'; setTimeout(function () { contactSuccess.remove(); }, 300); }, 8000);
            }
            if (appointmentSuccess) {
                document.getElementById('appointmentForm').reset();
                if (fileList) fileList.innerHTML = '';
                setTimeout(function () { appointmentSuccess.style.opacity = '0'; setTimeout(function () { appointmentSuccess.remove(); }, 300); }, 8000);
            }
        });
    })();
</script>

<?php include 'includes/footer.php'; ?>