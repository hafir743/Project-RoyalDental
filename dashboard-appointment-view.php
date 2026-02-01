<?php
require_once 'includes/config.php';
requireAdmin();

$db = new Database();
$connection = $db->getConnection();
$appointment = new Appointment($connection);

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: dashboard.php?section=appointments');
    exit;
}

$apt = $appointment->getById($_GET['id']);

if (!$apt) {
    header('Location: dashboard.php?section=appointments');
    exit;
}

$page_title = 'View Appointment';
include 'includes/header.php';
?>

<div class="dashboard-container">
    <h1>View Appointment / Case</h1>
    <a href="dashboard.php?section=appointments" class="btn btn-secondary">Back to Appointments</a>

    <div style="margin-top: 30px; max-width: 800px; background: var(--dark-gray); padding: 30px; border-radius: 10px;">
        <div style="margin-bottom: 20px;">
            <strong style="color: var(--gold);">Name:</strong>
            <p style="color: var(--text-light); margin-top: 5px;"><?php echo htmlspecialchars($apt['name']); ?></p>
        </div>

        <div style="margin-bottom: 20px;">
            <strong style="color: var(--gold);">Email:</strong>
            <p style="color: var(--text-light); margin-top: 5px;"><?php echo htmlspecialchars($apt['email']); ?></p>
        </div>

        <div style="margin-bottom: 20px;">
            <strong style="color: var(--gold);">Phone:</strong>
            <p style="color: var(--text-light); margin-top: 5px;"><?php echo htmlspecialchars($apt['phone']); ?></p>
        </div>

        <?php if ($apt['service']): ?>
            <div style="margin-bottom: 20px;">
                <strong style="color: var(--gold);">Service:</strong>
                <p style="color: var(--text-light); margin-top: 5px;"><?php echo htmlspecialchars($apt['service']); ?></p>
            </div>
        <?php endif; ?>

        <?php if ($apt['color']): ?>
            <div style="margin-bottom: 20px;">
                <strong style="color: var(--gold);">Color:</strong>
                <p style="color: var(--text-light); margin-top: 5px;"><?php echo htmlspecialchars($apt['color']); ?></p>
            </div>
        <?php endif; ?>

        <?php if ($apt['tooth_shape']): ?>
            <div style="margin-bottom: 20px;">
                <strong style="color: var(--gold);">Tooth Shape:</strong>
                <p style="color: var(--text-light); margin-top: 5px;"><?php echo htmlspecialchars($apt['tooth_shape']); ?>
                </p>
            </div>
        <?php endif; ?>

        <?php if ($apt['preferred_date']): ?>
            <div style="margin-bottom: 20px;">
                <strong style="color: var(--gold);">Preferred Date:</strong>
                <p style="color: var(--text-light); margin-top: 5px;">
                    <?php echo date('M d, Y', strtotime($apt['preferred_date'])); ?></p>
            </div>
        <?php endif; ?>

        <?php if ($apt['preferred_time']): ?>
            <div style="margin-bottom: 20px;">
                <strong style="color: var(--gold);">Preferred Time:</strong>
                <p style="color: var(--text-light); margin-top: 5px;">
                    <?php echo date('H:i', strtotime($apt['preferred_time'])); ?></p>
            </div>
        <?php endif; ?>

        <?php if ($apt['notes']): ?>
            <div style="margin-bottom: 20px;">
                <strong style="color: var(--gold);">Additional Notes:</strong>
                <p style="color: var(--text-light); margin-top: 5px; line-height: 1.8;">
                    <?php echo nl2br(htmlspecialchars($apt['notes'])); ?></p>
            </div>
        <?php endif; ?>

        <?php if ($apt['files']): ?>
            <div style="margin-bottom: 20px;">
                <strong style="color: var(--gold); font-size: 1.2rem;">Filet e Ngarkuara:</strong>
                <div
                    style="margin-top: 15px; display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 15px;">
                    <?php
                    $files = explode(',', $apt['files']);
                    foreach ($files as $file):
                        $file = trim($file);
                        $filePath = UPLOAD_APPOINTMENTS . $file;
                        if (file_exists($filePath)):
                            $fileUrl = 'uploads/appointments/' . urlencode($file);
                            $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                            $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                            $fileSize = filesize($filePath);
                            $fileSizeFormatted = $fileSize > 1024 * 1024 ? number_format($fileSize / (1024 * 1024), 2) . ' MB' : number_format($fileSize / 1024, 2) . ' KB';

                            $icon = 'fa-file';
                            if ($isImage) {
                                $icon = 'fa-image';
                            } elseif ($extension == 'pdf') {
                                $icon = 'fa-file-pdf';
                            } elseif (in_array($extension, ['stl', 'obj', 'ply'])) {
                                $icon = 'fa-cube';
                            } elseif ($extension == 'dcm') {
                                $icon = 'fa-x-ray';
                            }
                            ?>
                            <div
                                style="background: rgba(201, 162, 78, 0.1); border: 2px solid rgba(201, 162, 78, 0.3); border-radius: 8px; padding: 15px; transition: all 0.3s ease; hover:border-color: var(--gold);">
                                <?php if ($isImage): ?>
                                    <div
                                        style="margin-bottom: 10px; border-radius: 5px; overflow: hidden; max-height: 150px; background: var(--dark-gray);">
                                        <img src="<?php echo $fileUrl; ?>" alt="<?php echo htmlspecialchars($file); ?>"
                                            style="width: 100%; height: auto; display: block; cursor: pointer; transition: transform 0.3s ease;"
                                            onclick="window.open('<?php echo $fileUrl; ?>', '_blank')"
                                            onmouseover="this.style.transform='scale(1.05)'"
                                            onmouseout="this.style.transform='scale(1)'">
                                    </div>
                                <?php endif; ?>
                                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                                    <i class="fas <?php echo $icon; ?>"
                                        style="color: var(--gold); font-size: 1.5rem; flex-shrink: 0;"></i>
                                    <div style="flex: 1; min-width: 0;">
                                        <a href="<?php echo $fileUrl; ?>" target="_blank"
                                            style="color: var(--gold); text-decoration: none; display: block; font-weight: 500; word-break: break-word; font-size: 0.9rem; transition: color 0.3s ease;"
                                            onmouseover="this.style.color='var(--gold-alt)'"
                                            onmouseout="this.style.color='var(--gold)'">
                                            <?php echo htmlspecialchars($file); ?>
                                        </a>
                                        <span
                                            style="color: var(--text-light); font-size: 0.8rem; opacity: 0.7;"><?php echo $fileSizeFormatted; ?></span>
                                    </div>
                                </div>
                                <div style="display: flex; gap: 8px; margin-top: 10px;">
                                    <a href="<?php echo $fileUrl; ?>" target="_blank" class="btn"
                                        style="flex: 1; text-align: center; padding: 8px 12px; font-size: 0.85rem; display: flex; align-items: center; justify-content: center; gap: 5px;">
                                        <i class="fas fa-eye"></i> <span>Shiko</span>
                                    </a>
                                    <a href="<?php echo $fileUrl; ?>" download class="btn btn-secondary"
                                        style="flex: 1; text-align: center; padding: 8px 12px; font-size: 0.85rem; display: flex; align-items: center; justify-content: center; gap: 5px;">
                                        <i class="fas fa-download"></i> <span>Shkarko</span>
                                    </a>
                                </div>
                            </div>
                        <?php
                        else:
                            ?>
                            <div
                                style="background: rgba(220, 53, 69, 0.1); border: 2px solid rgba(220, 53, 69, 0.3); border-radius: 8px; padding: 15px;">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <i class="fas fa-exclamation-triangle" style="color: #f87171; font-size: 1.5rem;"></i>
                                    <div>
                                        <p style="color: var(--text-light); margin: 0; font-size: 0.9rem;">
                                            <?php echo htmlspecialchars($file); ?></p>
                                        <p style="color: #f87171; margin: 5px 0 0 0; font-size: 0.8rem;">File nuk u gjet</p>
                                    </div>
                                </div>
                            </div>
                            <?php
                        endif;
                    endforeach;
                    ?>
                </div>
            </div>
        <?php else: ?>
            <div style="margin-bottom: 20px;">
                <strong style="color: var(--gold);">Filet e Ngarkuara:</strong>
                <p style="color: var(--text-light); margin-top: 5px; font-style: italic;">Nuk ka file të ngarkuar</p>
            </div>
        <?php endif; ?>

        <div style="margin-bottom: 20px;">
            <strong style="color: var(--gold);">Status:</strong>
            <?php $badge = $apt['status'] == 'pending' ? 'badge-warning' : ($apt['status'] == 'confirmed' ? 'badge-info' : 'badge-success'); ?>
            <span class="badge <?php echo $badge; ?>" style="margin-left: 10px;"><?php echo ucfirst($apt['status']); ?></span>
        </div>

        <div style="margin-bottom: 20px;">
            <strong style="color: var(--gold);">Date Created:</strong>
            <p style="color: var(--text-light); margin-top: 5px;">
                <?php echo date('M d, Y H:i', strtotime($apt['created_at'])); ?></p>
        </div>

        <div style="margin-top: 30px;">
            <?php if ($apt['status'] == 'pending'): ?>
                <a href="dashboard.php?section=appointments&update_status=<?php echo $apt['id']; ?>&status=confirmed"
                    class="btn">Confirm Appointment</a>
            <?php endif; ?>
            <?php if ($apt['status'] == 'confirmed'): ?>
                <a href="dashboard.php?section=appointments&update_status=<?php echo $apt['id']; ?>&status=completed"
                    class="btn">Mark as Completed</a>
            <?php endif; ?>
            <a href="dashboard.php?section=appointments&delete=<?php echo $apt['id']; ?>" class="btn btn-danger"
                onclick="return confirm('Are you sure you want to delete this appointment?')">Delete</a>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>