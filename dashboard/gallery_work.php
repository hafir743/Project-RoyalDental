<?php
require_once __DIR__ . '/../includes/config.php';
requireAdmin();

$db = new Database();
$connection = $db->getConnection();
$gallery = new GalleryItem($connection);

$error = '';
$success = '';

if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    if ($gallery->delete($_GET['delete'])) {
        $success = 'Gallery item deleted successfully';
    } else {
        $error = 'Failed to delete gallery item';
    }
}

$galleryItems = $gallery->getAll();
?>

<h2>Manage Gallery Work</h2>
<a href="dashboard-gallery-work-edit.php" class="btn">Add New Work</a>

<?php if ($error): ?>
    <div class="alert alert-error" style="margin-top: 20px;">
        <i class="fas fa-exclamation-circle"></i>
        <?php echo htmlspecialchars($error); ?>
    </div>
<?php endif; ?>

<?php if ($success): ?>
    <div class="alert alert-success" style="margin-top: 20px;">
        <i class="fas fa-check-circle"></i>
        <?php echo htmlspecialchars($success); ?>
    </div>
<?php endif; ?>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Description</th>
            <th>Image</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($galleryItems)): ?>
            <tr>
                <td colspan="6" style="text-align: center;">No gallery items found</td>
            </tr>
        <?php else: ?>
            <?php foreach ($galleryItems as $item): ?>
                <tr>
                    <td>
                        <?php echo $item['id']; ?>
                    </td>
                    <td>
                        <?php echo htmlspecialchars($item['title']); ?>
                    </td>
                    <td>
                        <?php echo htmlspecialchars(substr($item['description'] ?? '', 0, 100)); ?>...
                    </td>
                    <td>
                        <?php if ($item['image']): ?>
                            <img src="uploads/images/<?php echo htmlspecialchars($item['image']); ?>"
                                alt="<?php echo htmlspecialchars($item['title']); ?>"
                                style="max-width: 50px; max-height: 50px; border-radius: 5px;">
                        <?php else: ?>
                            <span style="color: var(--text-light); opacity: 0.5;">No image</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php echo date('M d, Y', strtotime($item['created_at'])); ?>
                    </td>
                    <td>
                        <div class="actions">
                            <a href="dashboard-gallery-work-edit.php?id=<?php echo $item['id']; ?>"
                                class="btn btn-secondary">Edit</a>
                            <a href="?section=products&delete=<?php echo $item['id']; ?>" class="btn btn-danger"
                                onclick="return confirm('Are you sure you want to delete this item?')">Delete</a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>