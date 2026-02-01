<?php
require_once 'includes/config.php';
requireAdmin();

$db = new Database();
$connection = $db->getConnection();
$gallery = new GalleryItem($connection);

$error = '';
$success = '';
$workData = null;
$isEdit = isset($_GET['id']) && is_numeric($_GET['id']);

if ($isEdit) {
    $workData = $gallery->getById($_GET['id']);
    if (!$workData) {
        header('Location: dashboard.php?section=products');
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = sanitizeInput($_POST['title'] ?? '');
    $description = sanitizeInput($_POST['description'] ?? '');

    $image = null;

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $allowedTypes = ALLOWED_IMAGE_TYPES;
        $result = uploadFile($_FILES['image'], UPLOAD_IMAGES, $allowedTypes, MAX_IMAGE_SIZE);

        if ($result['success']) {
            $image = $result['filename'];

            if ($isEdit && $workData && $workData['image']) {
                $oldImagePath = UPLOAD_IMAGES . $workData['image'];
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
        } else {
            $error = $result['message'] ?? 'Failed to upload image';
        }
    } elseif ($isEdit && $workData) {
        $image = $workData['image'];
    }

    if (empty($error)) {
        if (empty($title)) {
            $error = 'Please fill in the title';
        } else {
            $data = [
                'title' => $title,
                'description' => $description,
                'image' => $image
            ];

            if ($isEdit) {
                $result = $gallery->update($_GET['id'], $data);
                if ($result) {
                    $success = 'Work updated successfully';
                    $workData = $gallery->getById($_GET['id']);
                } else {
                    $error = 'Failed to update work item';
                }
            } else {
                $result = $gallery->create($data);
                if ($result) {
                    $success = 'Work created successfully';
                    header('Location: dashboard.php?section=products');
                    exit;
                } else {
                    $error = 'Failed to create work item';
                }
            }
        }
    }
}

$page_title = $isEdit ? 'Edit Work' : 'Add New Work';
include 'includes/header.php';
?>

<div class="dashboard-container">
    <h1>
        <?php echo $isEdit ? 'Edit Work' : 'Add New Work'; ?>
    </h1>
    <a href="dashboard.php?section=products" class="btn btn-secondary">Back to Gallery</a>

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

    <form method="POST" enctype="multipart/form-data" style="margin-top: 30px; max-width: 800px;">
        <div class="form-group" style="margin-bottom: 20px;">
            <label for="title">Title *</label>
            <input type="text" id="title" name="title" required
                value="<?php echo $workData ? htmlspecialchars($workData['title']) : ''; ?>"
                style="width: 100%; padding: 10px; background: var(--dark-gray); border: 1px solid rgba(201, 162, 78, 0.2); color: white; border-radius: 5px;">
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="5"
                style="width: 100%; padding: 10px; background: var(--dark-gray); border: 1px solid rgba(201, 162, 78, 0.2); color: white; border-radius: 5px;"><?php echo $workData ? htmlspecialchars($workData['description']) : ''; ?></textarea>
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <label for="image">Image</label>
            <?php if ($isEdit && $workData && $workData['image']): ?>
                <div style="margin-bottom: 10px;">
                    <img src="uploads/images/<?php echo htmlspecialchars($workData['image']); ?>" alt="Current image"
                        style="max-width: 200px; max-height: 200px; border-radius: 5px; border: 1px solid rgba(201, 162, 78, 0.2);">
                    <p style="color: var(--text-light); font-size: 0.9rem; margin-top: 5px;">Current image</p>
                </div>
            <?php endif; ?>
            <input type="file" id="image" name="image" accept="image/*"
                style="width: 100%; padding: 10px; background: var(--dark-gray); border: 1px solid rgba(201, 162, 78, 0.2); color: white; border-radius: 5px;">
            <p style="color: var(--text-light); font-size: 0.9rem; margin-top: 5px;">
                <?php echo $isEdit ? 'Leave empty to keep current image' : 'Optional'; ?> (Max 5MB)
            </p>
        </div>

        <button type="submit" class="btn">
            <?php echo $isEdit ? 'Update Work' : 'Add Work'; ?>
        </button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>