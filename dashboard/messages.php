<?php
require_once __DIR__ . '/../includes/config.php';
requireAdmin();

$db = new Database();
$connection = $db->getConnection();
$contact = new Contact($connection);

$error = '';
$success = '';

if (isset($_GET['update_status']) && is_numeric($_GET['update_status']) && isset($_GET['status'])) {
    if ($contact->updateStatus($_GET['update_status'], $_GET['status'])) {
        $success = 'Status updated successfully';
    } else {
        $error = 'Failed to update status';
    }
}

if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    if ($contact->delete($_GET['delete'])) {
        $success = 'Message deleted successfully';
    } else {
        $error = 'Failed to delete message';
    }
}

$allMessages = $contact->getAll();
?>

<h2>Contact Messages</h2>

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
            <th>Subject</th>
            <th>Message</th>
            <th>Status</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($allMessages)): ?>
            <tr>
                <td colspan="9" style="text-align: center;">No messages found</td>
            </tr>
        <?php else: ?>
            <?php foreach ($allMessages as $msg): ?>
                <tr>
                    <td><?php echo $msg['id']; ?></td>
                    <td><?php echo htmlspecialchars($msg['name']); ?></td>
                    <td><?php echo htmlspecialchars($msg['email']); ?></td>
                    <td><?php echo htmlspecialchars($msg['phone'] ?? 'N/A'); ?></td>
                    <td><?php echo htmlspecialchars($msg['subject'] ?? 'N/A'); ?></td>
                    <td><?php echo htmlspecialchars(substr($msg['message'], 0, 50)); ?>...</td>
                    <td>
                        <?php $badge = $msg['status'] == 'new' ? 'badge-info' : ($msg['status'] == 'read' ? 'badge-warning' : 'badge-success'); ?>
                        <span class="badge <?php echo $badge; ?>"><?php echo ucfirst($msg['status']); ?></span>
                    </td>
                    <td><?php echo date('M d, Y H:i', strtotime($msg['created_at'])); ?></td>
                    <td>
                        <div class="actions">
                            <a href="dashboard-message-view.php?id=<?php echo $msg['id']; ?>" class="btn btn-secondary">View</a>
                            <?php if ($msg['status'] == 'new'): ?>
                                <a href="?section=messages&update_status=<?php echo $msg['id']; ?>&status=read" class="btn">Mark Read</a>
                            <?php endif; ?>
                            <a href="?section=messages&delete=<?php echo $msg['id']; ?>" class="btn btn-danger"
                                onclick="return confirm('Are you sure you want to delete this message?')">Delete</a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>