<?php
if (isAdmin()):
    ?>
    <style>
        .admin-edit-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            z-index: 10000;
            display: none;
            align-items: center;
            justify-content: center;
        }

        .admin-edit-modal {
            background: var(--dark-gray);
            padding: 30px;
            border-radius: 10px;
            max-width: 600px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
            border: 2px solid var(--gold);
        }

        .admin-edit-modal h3 {
            color: var(--gold);
            margin-bottom: 20px;
        }

        .admin-edit-btn {
            position: relative;
            display: inline-block;
        }

        .admin-edit-icon {
            position: absolute;
            top: 5px;
            right: 5px;
            background: var(--gold);
            color: var(--black);
            width: 25px;
            height: 25px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            cursor: pointer;
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 100;
        }

        .admin-edit-btn:hover .admin-edit-icon {
            opacity: 1;
        }

        .admin-edit-section {
            position: relative;
            margin-bottom: 20px;
        }

        .admin-edit-section:hover .admin-edit-icon {
            opacity: 1;
        }
    </style>

    <script>
        function openAdminEdit(type, id, currentContent) {
            const overlay = document.getElementById('adminEditOverlay');
            const modal = document.getElementById('adminEditModal');
            const form = document.getElementById('adminEditForm');

            form.querySelector('[name="edit_type"]').value = type;
            form.querySelector('[name="edit_id"]').value = id || '';

            if (type === 'text') {
                form.querySelector('[name="content"]').value = currentContent;
                form.querySelector('.text-edit').style.display = 'block';
                form.querySelector('.html-edit').style.display = 'none';
            } else {
                form.querySelector('[name="html_content"]').value = currentContent;
                form.querySelector('.text-edit').style.display = 'none';
                form.querySelector('.html-edit').style.display = 'block';
            }

            overlay.style.display = 'flex';
        }

        function closeAdminEdit() {
            document.getElementById('adminEditOverlay').style.display = 'none';
        }

        document.addEventListener('click', function (e) {
            const overlay = document.getElementById('adminEditOverlay');
            if (e.target === overlay) {
                closeAdminEdit();
            }
        });
    </script>

    <div id="adminEditOverlay" class="admin-edit-overlay">
        <div id="adminEditModal" class="admin-edit-modal">
            <h3>Edit Content</h3>
            <form id="adminEditForm" method="POST" action="admin-quick-edit.php">
                <input type="hidden" name="edit_type" value="">
                <input type="hidden" name="edit_id" value="">

                <div class="text-edit" style="display: none;">
                    <label>Content:</label>
                    <textarea name="content" rows="5"
                        style="width: 100%; padding: 10px; background: var(--dark-gray); border: 1px solid rgba(201, 162, 78, 0.2); color: white; border-radius: 5px;"></textarea>
                </div>

                <div class="html-edit" style="display: none;">
                    <label>HTML Content:</label>
                    <textarea name="html_content" rows="10"
                        style="width: 100%; padding: 10px; background: var(--dark-gray); border: 1px solid rgba(201, 162, 78, 0.2); color: white; border-radius: 5px; font-family: monospace;"></textarea>
                </div>

                <div style="margin-top: 20px; display: flex; gap: 10px;">
                    <button type="submit" class="btn">Save</button>
                    <button type="button" class="btn btn-secondary" onclick="closeAdminEdit()">Cancel</button>
                </div>
            </form>
        </div>
    </div>
<?php endif; ?>