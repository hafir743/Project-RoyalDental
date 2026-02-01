<?php
require_once __DIR__ . '/../includes/config.php';
requireAdmin();

$db = new Database();
$connection = $db->getConnection();
$appointment = new Appointment($connection);

$error = '';
$success = '';

if (isset($_GET['update_status']) && is_numeric($_GET['update_status']) && isset($_GET['status'])) {
    if ($appointment->updateStatus($_GET['update_status'], $_GET['status'])) {
        $success = 'Status updated successfully';
    } else {
        $error = 'Failed to update status';
    }
}

if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    if ($appointment->delete($_GET['delete'])) {
        $success = 'Appointment deleted successfully';
    } else {
        $error = 'Failed to delete appointment';
    }
}

$allAppointments = $appointment->getAll();
?>

<h2>Appointments / Cases</h2>

<?php if ($error): ?>
    <div class="alert alert-error" style="margin-top: 20px;">
        <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?>
    </div>
<?php endif; ?>

<?php if ($success): ?>
    <div class="alert alert-success" style="margin-top: 20px;">
        <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($success); ?>
    </div>
<?php endif; ?>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Service</th>
            <th>Date</th>
            <th>Time</th>
            <th>Files</th>
            <th>Status</th>
            <th>Date Created</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($allAppointments)): ?>
            <tr>
                <td colspan="11" style="text-align: center;">No appointments found</td>
            </tr>
        <?php else: ?>
            <?php foreach ($allAppointments as $apt): ?>
                <tr>
                    <td><?php echo $apt['id']; ?></td>
                    <td><?php echo htmlspecialchars($apt['name']); ?></td>
                    <td><?php echo htmlspecialchars($apt['email']); ?></td>
                    <td><?php echo htmlspecialchars($apt['phone']); ?></td>
                    <td><?php echo htmlspecialchars($apt['service'] ?? 'N/A'); ?></td>
                    <td><?php echo $apt['preferred_date'] ? date('M d, Y', strtotime($apt['preferred_date'])) : 'N/A'; ?></td>
                    <td><?php echo $apt['preferred_time'] ? date('H:i', strtotime($apt['preferred_time'])) : 'N/A'; ?></td>
                    <td>
                        <?php if (!empty($apt['files'])):
                            $fileCount = count(explode(',', $apt['files']));
                            ?>
                            <span style="color: var(--gold); font-weight: 600;">
                                <i class="fas fa-paperclip"></i> <?php echo $fileCount; ?>
                                <?php echo $fileCount == 1 ? 'file' : 'filet'; ?>
                            </span>
                        <?php else: ?>
                            <span style="color: var(--text-light); opacity: 0.5;">
                                <i class="fas fa-minus"></i> N/A
                            </span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <span class="badge <?php
                        echo $apt['status'] == 'pending' ? 'badge-warning' :
                            ($apt['status'] == 'confirmed' ? 'badge-info' : 'badge-success');
                        ?>">
                            <?php echo ucfirst($apt['status']); ?>
                        </span>
                    </td>
                    <td><?php echo date('M d, Y', strtotime($apt['created_at'])); ?></td>
                    <td>
                        <div class="actions">
                            <a href="dashboard-appointment-view.php?id=<?php echo $apt['id']; ?>"
                                class="btn btn-secondary">View</a>
                            <?php if ($apt['status'] == 'pending'): ?>
                                <a href="?section=appointments&update_status=<?php echo $apt['id']; ?>&status=confirmed"
                                    class="btn">Confirm</a>
                            <?php endif; ?>
                            <a href="?section=appointments&delete=<?php echo $apt['id']; ?>" class="btn btn-danger"
                                onclick="return confirm('Are you sure you want to delete this appointment?')">Delete</a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>