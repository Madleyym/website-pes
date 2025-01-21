<?php
// Sertakan koneksi ke database
require_once '../../config/koneksi.php';  // Sesuaikan path sesuai struktur folder

// Ambil data pengguna dari database
$query_users = mysqli_query($conn, "SELECT * FROM tbl_user");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Styling untuk Table */
        .table {
            width: 100%;
            margin-bottom: 1rem;
            background-color: transparent;
        }

        .table-light {
            background-color: #f8f9fa;
        }

        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }

        /* Styling untuk Badge */
        .badge {
            font-size: 0.875rem;
            padding: 0.375rem 0.75rem;
            border-radius: 0.375rem;
        }

        /* Styling untuk Card */
        .card {
            border: 1px solid #e0e0e0;
            border-radius: 0.375rem;
        }

        .card-header {
            background-color: #ffffff;
            padding: 1rem;
            border-bottom: 1px solid #e0e0e0;
        }

        /* Styling untuk Button */
        .btn-outline-warning {
            border-color: #f39c12;
            color: #f39c12;
        }

        .btn-outline-warning:hover {
            background-color: #f39c12;
            color: white;
        }

        .btn-outline-danger {
            border-color: #e74c3c;
            color: #e74c3c;
        }

        .btn-outline-danger:hover {
            background-color: #e74c3c;
            color: white;
        }

        .btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
        }

        /* Styling untuk Modal */
        .modal-content {
            border-radius: 0.375rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .modal-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #e0e0e0;
        }

        .modal-title {
            font-size: 1.25rem;
            font-weight: 600;
        }

        /* Styling untuk Form */
        .form-label {
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .form-select {
            width: 100%;
            padding: 0.375rem 0.75rem;
            border-radius: 0.375rem;
            border: 1px solid #ced4da;
        }

        /* Styling untuk Overall Layout */
        .row {
            margin-bottom: 1.5rem;
        }

        /* Custom Styling for Modal Buttons */
        .btn-close {
            background-color: transparent;
            border: none;
            color: #000;
        }

        /* Responsive Styling */
        @media (max-width: 768px) {
            .card-body {
                padding: 1rem;
            }

            .table th,
            .table td {
                font-size: 0.875rem;
            }
        }
    </style>
</head>

<body>
    <!-- Table for displaying users -->
    <div class="container my-4">
        <div class="row">
            <div class="col-12 col-xl-8 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">User Management</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Username</th>
                                        <th>Level</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($user = mysqli_fetch_assoc($query_users)) { ?>
                                        <tr>
                                            <td><?php echo $user['id_user']; ?></td>
                                            <td><?php echo $user['username']; ?></td>
                                            <td>
                                                <span class="badge <?php echo $user['level'] == 'admin' ? 'bg-danger' : 'bg-success'; ?>">
                                                    <?php echo ucfirst($user['level']); ?>
                                                </span>
                                            </td>
                                            <td><?php echo date('Y-m-d', strtotime($user['created_at'])); ?></td>
                                            <td>
                                                <!-- Edit Button -->
                                                <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editUserModal<?php echo $user['id_user']; ?>">
                                                    <i class="fas fa-edit"></i> Edit Role
                                                </button>
                                                <!-- Delete Button -->
                                                <a href="delete_user.php?id=<?php echo $user['id_user']; ?>" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-trash"></i> Delete
                                                </a>
                                            </td>
                                        </tr>

                                        <!-- Modal for Editing Role -->
                                        <div class="modal fade" id="editUserModal<?php echo $user['id_user']; ?>" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editUserModalLabel">Edit User Role</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="update_user.php" method="POST">
                                                            <input type="hidden" name="id_user" value="<?php echo $user['id_user']; ?>">
                                                            <div class="mb-3">
                                                                <label for="level" class="form-label">Role</label>
                                                                <select class="form-select" name="level" id="level" required>
                                                                    <option value="admin" <?php echo $user['level'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                                                                    <option value="user" <?php echo $user['level'] == 'user' ? 'selected' : ''; ?>>User</option>
                                                                </select>
                                                            </div>
                                                            <button type="submit" class="btn btn-primary">Update Role</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>