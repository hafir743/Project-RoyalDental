<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' - ' : ''; ?>Royal Dental</title>
    <link rel="stylesheet" href="styles.css?v=<?php echo time(); ?>">
    <?php if (isset($custom_css)): ?>
        <link rel="stylesheet" href="<?php echo $custom_css; ?>?v=<?php echo time(); ?>">
    <?php endif; ?>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <header class="header" id="header">
        <nav class="navbar">
            <div class="nav-container">
                <div class="logo">
                    <a href="index.php"><img src="royaldental.png" alt="Royal Dental Logo"></a>
                </div>
                <ul class="nav-menu">
                    <li><a href="index.php"
                            class="nav-link <?php echo $current_page == 'index.php' ? 'active' : ''; ?>">Home</a></li>
                    <li><a href="about-us.php"
                            class="nav-link <?php echo $current_page == 'about-us.php' ? 'active' : ''; ?>">About Us</a>
                    </li>
                    <li><a href="services.php"
                            class="nav-link <?php echo $current_page == 'services.php' ? 'active' : ''; ?>">Services</a>
                    </li>
                    <li><a href="gallery.php"
                            class="nav-link <?php echo $current_page == 'gallery.php' ? 'active' : ''; ?>">Gallery</a>
                    </li>
                    <li><a href="contact.php"
                            class="nav-link <?php echo $current_page == 'contact.php' ? 'active' : ''; ?>">Contact</a>
                    </li>
                    <li><a href="contact.php#appointment" class="btn-book-nav">Send a Case</a></li>
                    <?php if (isAdmin()): ?>
                        <li><a href="dashboard.php"
                                class="nav-link <?php echo $current_page == 'dashboard.php' ? 'active' : ''; ?>">Dashboard</a>
                        </li>
                    <?php endif; ?>
                </ul>
                <?php if (isLoggedIn()): ?>
                    <div class="user-menu">

                        <a href="logout.php" class="btn-logout" aria-label="Logout">Logout</a>
                    </div>
                <?php else: ?>
                    <a href="login.php" class="user-icon-btn <?php echo $current_page == 'login.php' ? 'active' : ''; ?>"
                        aria-label="Login">
                        <i class="fas fa-user"></i>
                    </a>
                <?php endif; ?>
                <div class="hamburger">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </nav>
    </header>