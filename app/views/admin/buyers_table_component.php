<?php
// Buyers Table Component for Admin Panel
// Usage: include or require this file in your admin view
?>
<div class="buyers-table-container">
    <h2>Buyers List</h2>
    <table class="buyers-table" style="width:100%;border-collapse:collapse;">
        <thead>
            <tr>
                <th>#</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($buyers)): ?>
                <?php foreach ($buyers as $buyer): ?>
                    <tr>
                        <td><?= htmlspecialchars($buyer['buyer_id']) ?></td>
                        <td><?= htmlspecialchars($buyer['full_name']) ?></td>
                        <td><?= htmlspecialchars($buyer['email']) ?></td>
                        <td><?= htmlspecialchars($buyer['phone_number']) ?></td>
                        <td><?= date('M d, Y', strtotime($buyer['created_at'])) ?></td>
                        <td>
                            <a href="<?= site_url('admin/delete_buyer/' . $buyer['buyer_id']) ?>" onclick="return confirm('Delete this buyer?')" style="color:#dc3545;">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="6" style="text-align:center;">No buyers found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<style>
.buyers-table-container { background: #fff; padding: 2rem; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.07); margin-bottom: 2rem; }
.buyers-table th, .buyers-table td { padding: 0.75rem; border: 1px solid #eee; }
.buyers-table th { background: #f8f9fa; font-weight: 600; }
.buyers-table tr:hover { background: #f1f1f1; }
</style>
