<?php
require_once __DIR__ . '/../includes/config.php';
requireAdmin();

$db = new Database();
$connection = $db->getConnection();
$service = new Service($connection);

$error = '';
$success = '';

if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    if ($service->delete($_GET['delete'])) {
        $success = 'Service deleted successfully';
    } else {
        $error = 'Failed to delete service';
    }
}

$allServices = $service->getAll();
?>

<h2>Manage Services</h2>
<a href="dashboard-service-edit.php" class="btn">Add New Service</a>

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
            <th>Description</th>
            <th>Image</th>
            <th>Status</th>
            <th>Created By</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($allServices)): ?>
            <tr>
                <td colspan="8" style="text-align: center;">No services found</td>
            </tr>
        <?php else: ?>
            <?php foreach ($allServices as $s): ?>
                <tr>
                    <td><?php echo $s['id']; ?></td>
                    <td><?php echo htmlspecialchars($s['name']); ?></td>
                    <td><?php echo htmlspecialchars(substr($s['description'] ?? '', 0, 100)); ?>...</td>
                    <td>
                        <?php if ($s['image']): ?>
                            <img src="uploads/images/<?php echo htmlspecialchars($s['image']); ?>"
                                alt="<?php echo htmlspecialchars($s['name']); ?>"
                                style="max-width: 50px; max-height: 50px; border-radius: 5px;">
                        <?php else: ?>
                            <span style="color: var(--text-light); opacity: 0.5;">No image</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <span class="badge <?php echo $s['status'] == 'active' ? 'badge-success' : 'badge-danger'; ?>">
                            <?php echo ucfirst($s['status']); ?>
                        </span>
                    </td>
                    <td><?php echo htmlspecialchars($s['created_by_name'] . ' ' . $s['created_by_surname']); ?></td>
                    <td><?php echo date('M d, Y', strtotime($s['created_at'])); ?></td>
                    <td>
                        <div class="actions">
                            <a href="dashboard-service-edit.php?id=<?php echo $s['id']; ?>" class="btn btn-secondary">Edit</a>
                            <a href="?section=services&delete=<?php echo $s['id']; ?>" class="btn btn-danger"
                                onclick="return confirm('Are you sure you want to delete this service?')">Delete</a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>