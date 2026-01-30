<?php
require_once 'includes/config.php';

$page_title = 'Register';
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Database();
    $conn = $db->getConnection();
    $user = new User($conn);

    $doctorName = sanitizeInput($_POST['doctor-name']);
    $licenseNumber = sanitizeInput($_POST['license-number']);
    $email = sanitizeInput($_POST['email']);
    $phone = sanitizeInput($_POST['phone']);
    $clinicName = sanitizeInput($_POST['clinic-name']);
    $specialization = sanitizeInput($_POST['specialization']);
    $address = sanitizeInput($_POST['address']);
    $city = sanitizeInput($_POST['city']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm-password'];

    if ($password !== $confirmPassword) {
        $error = "Passwords do not match.";
    } else {
        $parts = explode(' ', trim($doctorName));
        $surname = array_pop($parts);
        $name = implode(' ', $parts);
        if (empty($name)) {
            $name = $surname;
            $surname = '';
        }

        $result = $user->register($name, $surname, $email, $password, $licenseNumber, $phone, $clinicName, $specialization, $address, $city);

        if ($result['success']) {
            $success = "Registration successful! You can now <a href='login.php'>login</a>.";
        } else {
            $error = $result['message'];
        }
    }
}

$custom_css = 'register.css';
include 'includes/header.php';
?>
<style>
    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 4px;
    }

    .alert-danger {
        color: #a94442;
        background-color: #f2dede;
        border-color: #ebccd1;
    }

    .alert-success {
        color: #3c763d;
        background-color: #dff0d8;
        border-color: #d6e9c6;
    }

    .alert a {
        font-weight: bold;
        color: inherit;
        text-decoration: underline;
    }
</style>

<body>
    <section class="register-section">
        <div class="container">
            <div class="register-container">
                <div class="register-header">
                    <h1>Register as Doctor</h1>
                    <p>Create your account to access our platform</p>
                </div>

                <?php if ($error): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>
                <?php if ($success): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>

                <form class="register-form" id="registerForm" method="POST" action="">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="doctor-name">Doctor's Full Name *</label>
                            <div class="input-wrapper">
                                <i class="fas fa-user-md"></i>
                                <input type="text" id="doctor-name" name="doctor-name"
                                    placeholder="Enter doctor's full name" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="license-number">License Number *</label>
                            <div class="input-wrapper">
                                <i class="fas fa-id-card"></i>
                                <input type="text" id="license-number" name="license-number"
                                    placeholder="Enter license number" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">Email Address *</label>
                            <div class="input-wrapper">
                                <i class="fas fa-envelope"></i>
                                <input type="email" id="email" name="email" placeholder="Enter your email" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number *</label>
                            <div class="input-wrapper">
                                <i class="fas fa-phone"></i>
                                <input type="tel" id="phone" name="phone" placeholder="Enter phone number" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="clinic-name">Clinic Name *</label>
                            <div class="input-wrapper">
                                <i class="fas fa-building"></i>
                                <input type="text" id="clinic-name" name="clinic-name" placeholder="Enter clinic name"
                                    required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="specialization">Specialization *</label>
                            <div class="input-wrapper">
                                <i class="fas fa-stethoscope"></i>
                                <select id="specialization" name="specialization" required>
                                    <option value="">Select specialization</option>
                                    <option value="general">General Dentistry</option>
                                    <option value="orthodontics">Orthodontics</option>
                                    <option value="prosthodontics">Prosthodontics</option>
                                    <option value="oral-surgery">Oral Surgery</option>
                                    <option value="periodontics">Periodontics</option>
                                    <option value="endodontics">Endodontics</option>
                                    <option value="cosmetic">Cosmetic Dentistry</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="address">Clinic Address *</label>
                            <div class="input-wrapper">
                                <i class="fas fa-map-marker-alt"></i>
                                <input type="text" id="address" name="address" placeholder="Enter clinic address"
                                    required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="city">City *</label>
                            <div class="input-wrapper">
                                <i class="fas fa-city"></i>
                                <input type="text" id="city" name="city" placeholder="Enter city" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="password">Password *</label>
                            <div class="input-wrapper">
                                <i class="fas fa-lock"></i>
                                <input type="password" id="password" name="password" placeholder="Create a password"
                                    required>
                                <button type="button" class="toggle-password" id="togglePassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="confirm-password">Confirm Password *</label>
                            <div class="input-wrapper">
                                <i class="fas fa-lock"></i>
                                <input type="password" id="confirm-password" name="confirm-password"
                                    placeholder="Confirm password" required>
                                <button type="button" class="toggle-password" id="toggleConfirmPassword">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="agree-terms">
                            <input type="checkbox" name="agree-terms" required>
                            <span>I agree to the <a href="#">Terms and Conditions</a> and <a href="#">Privacy Policy</a>
                                *</span>
                        </label>
                    </div>
                    <button type="submit" class="btn-register">Create Account</button>
                </form>
                <div class="register-footer">
                    <p>Already have an account? <a href="login.php">Sign in here</a></p>
                </div>
            </div>
        </div>
    </section>
    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });

        document.getElementById('toggleConfirmPassword').addEventListener('click', function () {
            const confirmPasswordInput = document.getElementById('confirm-password');
            const icon = this.querySelector('i');
            if (confirmPasswordInput.type === 'password') {
                confirmPasswordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                confirmPasswordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    </script>
</body>

</html>