<?php
require_once 'includes/config.php';
requireAdmin();

$db = new Database();
$connection = $db->getConnection();
$contact = new Contact($connection);

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: dashboard.php?section=messages');
    exit;
}

$message = $contact->getById($_GET['id']);

if (!$message) {
    header('Location: dashboard.php?section=messages');
    exit;
}

if ($message['status'] == 'new') {
    $contact->updateStatus($_GET['id'], 'read');
    $message['status'] = 'read';
}

$page_title = 'View Message';
include 'includes/header.php';
?>

<div class="dashboard-container">
    <h1>View Message</h1>
    <a href="dashboard.php?section=messages" class="btn btn-secondary">Back to Messages</a>

    <div style="margin-top: 30px; max-width: 800px; background: var(--dark-gray); padding: 30px; border-radius: 10px;">
        <div style="margin-bottom: 20px;">
            <strong style="color: var(--gold);">From:</strong>
            <p style="color: var(--text-light); margin-top: 5px;"><?php echo htmlspecialchars($message['name']); ?></p>
        </div>

        <div style="margin-bottom: 20px;">
            <strong style="color: var(--gold);">Email:</strong>
            <p style="color: var(--text-light); margin-top: 5px;"><?php echo htmlspecialchars($message['email']); ?></p>
        </div>

        <?php if ($message['phone']): ?>
            <div style="margin-bottom: 20px;">
                <strong style="color: var(--gold);">Phone:</strong>
                <p style="color: var(--text-light); margin-top: 5px;"><?php echo htmlspecialchars($message['phone']); ?></p>
            </div>
        <?php endif; ?>

        <?php if ($message['subject']): ?>
            <div style="margin-bottom: 20px;">
                <strong style="color: var(--gold);">Subject:</strong>
                <p style="color: var(--text-light); margin-top: 5px;"><?php echo htmlspecialchars($message['subject']); ?>
                </p>
            </div>
        <?php endif; ?>

        <div style="margin-bottom: 20px;">
            <strong style="color: var(--gold);">Message:</strong>
            <p style="color: var(--text-light); margin-top: 5px; line-height: 1.8;">
                <?php echo nl2br(htmlspecialchars($message['message'])); ?></p>
        </div>

        <div style="margin-bottom: 20px;">
            <strong style="color: var(--gold);">Date:</strong>
            <p style="color: var(--text-light); margin-top: 5px;">
                <?php echo date('M d, Y H:i', strtotime($message['created_at'])); ?></p>
        </div>

        <div style="margin-bottom: 20px;">
            <strong style="color: var(--gold);">Status:</strong>
            <?php $badge = $message['status'] == 'new' ? 'badge-info' : ($message['status'] == 'read' ? 'badge-warning' : 'badge-success'); ?>
            <span class="badge <?php echo $badge; ?>" style="margin-left: 10px;"><?php echo ucfirst($message['status']); ?></span>
        </div>

        <div style="margin-top: 30px;">
            <?php if ($message['status'] != 'replied'): ?>
                <a href="?section=messages&update_status=<?php echo $message['id']; ?>&status=replied" class="btn">Mark as Replied</a>
            <?php endif; ?>
            <a href="dashboard.php?section=messages&delete=<?php echo $message['id']; ?>" class="btn btn-danger"
                onclick="return confirm('Are you sure you want to delete this message?')">Delete</a>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>