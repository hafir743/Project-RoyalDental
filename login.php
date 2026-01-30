<?php
require_once 'includes/config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = sanitizeInput($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $error = 'Please fill in all fields';
    } else {
        $db = new Database();
        $connection = $db->getConnection();
        $user = new User($connection);

        $result = $user->login($email, $password);

        if ($result['success']) {
            if (isset($_POST['remember'])) {
                setcookie('remember_email', $email, time() + 2592000, "/");
            } elseif (isset($_COOKIE['remember_email'])) {
                setcookie('remember_email', '', time() - 3600, "/");
            }
            $page = $_GET['redirect'] ?? ($result['role'] === 'admin' ? 'dashboard' : 'index');
            header('Location: ' . $page . '.php');
            exit;
        } else {
            $error = $result['message'] ?? 'Invalid email or password';
        }
    }
}

if (isLoggedIn()) {
    header('Location: ' . (isAdmin() ? 'dashboard.php' : 'index.php'));
    exit;
}

$page_title = 'Login';
$custom_css = 'login.css';
include 'includes/header.php';
?>
<section class="login-section">
    <div class="container">
        <div class="login-container">
            <div class="login-header">
                <h1>Welcome Back</h1>
                <p>Sign in to your account to continue</p>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($success); ?>
                </div>
            <?php endif; ?>

            <form class="login-form" id="loginForm" method="POST" action="">
                <div class="form-group">
                    <label for="email">Email Address *</label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope"></i>
                        <input type="email" id="email" name="email" placeholder="Enter your email" required
                            value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : (isset($_COOKIE['remember_email']) ? htmlspecialchars($_COOKIE['remember_email']) : ''); ?>">
                    </div>
                    <span class="error-message" id="emailError"></span>
                </div>
                <div class="form-group">
                    <label for="password">Password *</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock"></i>
                        <input type="password" id="password" name="password" placeholder="Enter your password" required>
                        <button type="button" class="toggle-password" id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <span class="error-message" id="passwordError"></span>
                </div>
                <div class="form-options">
                    <label class="remember-me">
                        <input type="checkbox" name="remember" <?php echo isset($_COOKIE['remember_email']) ? 'checked' : ''; ?>>
                        <span>Remember me</span>
                    </label>
                    <a href="#" class="forgot-password" onclick="return false;"
                        style="color: var(--gold); text-decoration: none; font-size: 0.9rem; transition: color 0.3s ease;">Forgot
                        Password?</a>
                </div>
                <button type="submit" class="btn-login">Sign In</button>
            </form>
            <div class="login-footer">
                <p>Don't have an account? <a href="register.php">Sign up here</a></p>
            </div>
        </div>
    </div>
</section>

<script>
    const loginForm = document.getElementById('loginForm');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const emailError = document.getElementById('emailError');
    const passwordError = document.getElementById('passwordError');

    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    emailInput.addEventListener('blur', function () {
        if (!this.value) {
            emailError.textContent = 'Email is required';
        } else if (!validateEmail(this.value)) {
            emailError.textContent = 'Please enter a valid email address';
        } else {
            emailError.textContent = '';
        }
    });

    passwordInput.addEventListener('blur', function () {
        if (!this.value) {
            passwordError.textContent = 'Password is required';
        } else if (this.value.length < 6) {
            passwordError.textContent = 'Password must be at least 6 characters';
        } else {
            passwordError.textContent = '';
        }
    });

    loginForm.addEventListener('submit', function (e) {
        let isValid = true;

        if (!emailInput.value || !validateEmail(emailInput.value)) {
            emailError.textContent = 'Please enter a valid email address';
            isValid = false;
        }

        if (!passwordInput.value || passwordInput.value.length < 6) {
            passwordError.textContent = 'Password must be at least 6 characters';
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
        }
    });

    const toggleBtn = document.getElementById('togglePassword');
    toggleBtn.addEventListener('click', function () {
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
</script>