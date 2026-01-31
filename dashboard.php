<?php
require_once 'includes/config.php';
requireAdmin();

$db = new Database();
$connection = $db->getConnection();
$contact = new Contact($connection);
$appointment = new Appointment($connection);

$service = new Service($connection);

$allMessages = $contact->getAll();
$allAppointments = $appointment->getAll();
$unreadCount = $contact->getUnreadCount();

$allServices = $service->getAll();

$page_title = 'Admin Dashboard';
include 'includes/header.php';
?>
<style>
    .dashboard-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 100px 20px 40px;
    }

    .dashboard-header {
        margin-bottom: 40px;
    }

    .dashboard-header h1 {
        color: var(--gold);
        margin-bottom: 10px;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 40px;
    }

    .stat-card {
        background: var(--dark-gray);
        padding: 30px;
        border-radius: 10px;
        border: 1px solid rgba(201, 162, 78, 0.2);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(201, 162, 78, 0.2);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: var(--gold);
    }

    .stat-card h3 {
        color: var(--gold);
        font-size: 2.5rem;
        margin-bottom: 10px;
        font-weight: 700;
    }

    .stat-card p {
        color: var(--text-light);
        font-size: 1rem;
        margin: 0;
    }

    .stat-card .icon {
        font-size: 2rem;
        color: var(--gold);
        margin-bottom: 15px;
        opacity: 0.8;
    }

    .dashboard-nav {
        display: flex;
        gap: 10px;
        margin-bottom: 30px;
        flex-wrap: wrap;
    }

    .dashboard-nav a {
        padding: 12px 24px;
        background: var(--dark-gray);
        color: var(--gold);
        text-decoration: none;
        border-radius: 5px;
        border: 1px solid rgba(201, 162, 78, 0.2);
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .dashboard-nav a:hover,
    .dashboard-nav a.active {
        background: var(--gold);
        color: var(--black);
    }

    .dashboard-content {
        background: var(--dark-gray);
        padding: 30px;
        border-radius: 10px;
        border: 1px solid rgba(201, 162, 78, 0.2);
    }

    .btn {
        display: inline-block;
        padding: 10px 20px;
        background: var(--gold);
        color: var(--black);
        text-decoration: none;
        border-radius: 5px;
        font-weight: 600;
        transition: background 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .btn:hover {
        background: var(--gold-alt);
    }

    .btn-danger {
        background: #c33;
        color: white;
    }

    .btn-danger:hover {
        background: #a22;
    }

    .btn-secondary {
        background: transparent;
        color: var(--gold);
        border: 1px solid var(--gold);
    }

    .btn-secondary:hover {
        background: var(--gold);
        color: var(--black);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th,
    td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid rgba(201, 162, 78, 0.1);
    }

    th {
        color: var(--gold);
        font-weight: 600;
    }

    td {
        color: var(--text-light);
    }

    .actions {
        display: flex;
        gap: 10px;
    }

    .badge {
        padding: 4px 8px;
        border-radius: 3px;
        font-size: 0.875rem;
    }

    .badge-success {
        background: #3c3;
        color: white;
    }

    .badge-warning {
        background: #cc3;
        color: black;
    }

    .badge-danger {
        background: #c33;
        color: white;
    }

    .badge-info {
        background: #33c;
        color: white;
    }

    @media (max-width: 768px) {
        .dashboard-container {
            padding: 80px 10px 20px;
        }

        .dashboard-nav {
            flex-direction: column;
        }

        .dashboard-nav a {
            width: 100%;
            justify-content: center;
        }

        .dashboard-content {
            padding: 15px;
            overflow-x: auto;
        }

        table {
            min-width: 600px;
        }
    }
</style>

<div class="dashboard-container">
    <div class="dashboard-header">
        <h1>Admin Dashboard</h1>
        <p>Welcome back, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</p>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="icon"><i class="fas fa-envelope"></i></div>
            <h3><?php echo count($allMessages); ?></h3>
            <p>Total Messages</p>
        </div>
        <div class="stat-card">
            <div class="icon"><i class="fas fa-envelope-open"></i></div>
            <h3><?php echo $unreadCount; ?></h3>
            <p>Unread Messages</p>
        </div>
        <div class="stat-card">
            <div class="icon"><i class="fas fa-calendar-check"></i></div>
            <h3><?php echo count($allAppointments); ?></h3>
            <p>Total Appointments</p>
        </div>

        <div class="stat-card">
            <div class="icon"><i class="fas fa-briefcase-medical"></i></div>
            <h3><?php echo count($allServices); ?></h3>
            <p>Total Services</p>
        </div>
    </div>

    <div class="dashboard-nav">
        <a href="dashboard.php?section=messages"
            class="<?php echo (!isset($_GET['section']) || $_GET['section'] == 'messages') ? 'active' : ''; ?>">
            <i class="fas fa-envelope"></i> Messages
        </a>
        <a href="dashboard.php?section=appointments"
            class="<?php echo (isset($_GET['section']) && $_GET['section'] == 'appointments') ? 'active' : ''; ?>">
            <i class="fas fa-calendar-check"></i> Appointments
        </a>
        <a href="dashboard.php?section=services"
            class="<?php echo (isset($_GET['section']) && $_GET['section'] == 'services') ? 'active' : ''; ?>">
            <i class="fas fa-briefcase-medical"></i> Services
        </a>

        <a href="dashboard.php?section=products"
            class="<?php echo (isset($_GET['section']) && $_GET['section'] == 'products') ? 'active' : ''; ?>">
            <i class="fas fa-images"></i> Gallery/Products
        </a>
    </div>

    <div class="dashboard-content">
        <?php
        $section = $_GET['section'] ?? 'messages';
        $files = ['messages' => 'messages.php', 'appointments' => 'appointments.php', 'services' => 'services.php', 'products' => 'gallery_work.php'];
        include 'dashboard/' . ($files[$section] ?? 'messages.php');
        ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>