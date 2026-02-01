<?php
require_once 'includes/config.php';
requireAdmin();

$db = new Database();
$connection = $db->getConnection();
$service = new Service($connection);

$error = '';
$success = '';
$serviceData = null;
$isEdit = isset($_GET['id']) && is_numeric($_GET['id']);

if ($isEdit) {
    $serviceData = $service->getById($_GET['id']);
    if (!$serviceData) {
        header('Location: dashboard.php?section=services');
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = sanitizeInput($_POST['name'] ?? '');
    $description = sanitizeInput($_POST['description'] ?? '');
    $status = sanitizeInput($_POST['status'] ?? 'active');
    $user_id = $_SESSION['user_id'];

    $image = null;

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $allowedTypes = ALLOWED_IMAGE_TYPES;
        $result = uploadFile($_FILES['image'], UPLOAD_IMAGES, $allowedTypes, MAX_IMAGE_SIZE);

        if ($result['success']) {
            $image = $result['filename'];

            if ($isEdit && $serviceData && $serviceData['image']) {
                $oldImagePath = UPLOAD_IMAGES . $serviceData['image'];
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
        } else {
            $error = $result['message'] ?? 'Failed to upload image';
        }
    } elseif ($isEdit && $serviceData) {
        $image = $serviceData['image'];
    }

    if (empty($error)) {
        if (empty($name) || empty($description)) {
            $error = 'Please fill in all required fields';
        } else {
            if ($isEdit) {
                $result = $service->update($_GET['id'], $name, $description, $image, $status, $user_id);
                if ($result) {
                    $success = 'Service updated successfully';
                    $serviceData = $service->getById($_GET['id']);
                } else {
                    $error = 'Failed to update service';
                }
            } else {
                $result = $service->create($name, $description, $image, $status, $user_id);
                if ($result['success']) {
                    $success = 'Service created successfully';
                    header('Location: dashboard.php?section=services');
                    exit;
                } else {
                    $error = $result['message'] ?? 'Failed to create service';
                }
            }
        }
    }
}

$page_title = $isEdit ? 'Edit Service' : 'Add Service';
include 'includes/header.php';
?>

<div class="dashboard-container">
    <h1><?php echo $isEdit ? 'Edit Service' : 'Add New Service'; ?></h1>
    <a href="dashboard.php?section=services" class="btn btn-secondary">Back to Services</a>

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

    <form method="POST" enctype="multipart/form-data" style="margin-top: 30px; max-width: 800px;">
        <div class="form-group" style="margin-bottom: 20px;">
            <label for="name">Service Name *</label>
            <input type="text" id="name" name="name" required
                value="<?php echo $serviceData ? htmlspecialchars($serviceData['name']) : ''; ?>"
                style="width: 100%; padding: 10px; background: var(--dark-gray); border: 1px solid rgba(201, 162, 78, 0.2); color: white; border-radius: 5px;">
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <label for="description">Description *</label>
            <textarea id="description" name="description" rows="10" required
                style="width: 100%; padding: 10px; background: var(--dark-gray); border: 1px solid rgba(201, 162, 78, 0.2); color: white; border-radius: 5px;"><?php echo $serviceData ? htmlspecialchars($serviceData['description']) : ''; ?></textarea>
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <label for="image">Image</label>
            <?php if ($isEdit && $serviceData && $serviceData['image']): ?>
                <div style="margin-bottom: 10px;">
                    <img src="uploads/images/<?php echo htmlspecialchars($serviceData['image']); ?>" alt="Current image"
                        style="max-width: 200px; max-height: 200px; border-radius: 5px; border: 1px solid rgba(201, 162, 78, 0.2);">
                    <p style="color: var(--text-light); font-size: 0.9rem; margin-top: 5px;">Current image</p>
                </div>
            <?php endif; ?>
            <input type="file" id="image" name="image" accept="image/*"
                style="width: 100%; padding: 10px; background: var(--dark-gray); border: 1px solid rgba(201, 162, 78, 0.2); color: white; border-radius: 5px;">
            <p style="color: var(--text-light); font-size: 0.9rem; margin-top: 5px;">
                <?php echo $isEdit ? 'Leave empty to keep current image' : 'Optional'; ?> (Max 5MB)</p>
        </div>

        <div class="form-group" style="margin-bottom: 20px;">
            <label for="status">Status *</label>
            <select id="status" name="status" required
                style="width: 100%; padding: 10px; background: var(--dark-gray); border: 1px solid rgba(201, 162, 78, 0.2); color: white; border-radius: 5px;">
                <option value="active" <?php echo ($serviceData && $serviceData['status'] == 'active') ? 'selected' : ''; ?>>Active</option>
                <option value="inactive" <?php echo ($serviceData && $serviceData['status'] == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
            </select>
        </div>

        <button type="submit" class="btn"><?php echo $isEdit ? 'Update Service' : 'Create Service'; ?></button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>