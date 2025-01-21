<?php
require_once '../config/koneksi.php';

// Mengambil data statistik dari database
$query_posts = mysqli_query($conn, "SELECT COUNT(*) AS total_posts FROM posts");
$total_posts = mysqli_fetch_assoc($query_posts)['total_posts'];

$query_comments = mysqli_query($conn, "SELECT COUNT(*) AS total_comments FROM comments");
$total_comments = mysqli_fetch_assoc($query_comments)['total_comments'];

$query_downloads = mysqli_query($conn, "SELECT COUNT(*) AS total_downloads FROM downloads");
$total_downloads = mysqli_fetch_assoc($query_downloads)['total_downloads'];

$query_users = mysqli_query($conn, "SELECT COUNT(*) AS active_users FROM tbl_user WHERE level = 'user'");
$total_users = mysqli_fetch_assoc($query_users)['active_users'];

// Mengambil data post terbaru
$query_recent_posts = mysqli_query($conn, "SELECT * FROM posts ORDER BY post_date DESC LIMIT 5");

// Cek apakah query recent_posts berhasil dieksekusi
if (!$query_recent_posts) {
    die("Query gagal dieksekusi: " . mysqli_error($conn));
}

// // Menampilkan post terbaru
// while ($post = mysqli_fetch_assoc($query_recent_posts)) {
//     echo "<div>" . htmlspecialchars($post['title']) . "</div>";
// }
// 
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PesKisni Admin Panel</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="../assets/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="d-flex flex-column h-100">
                <div class="p-3 border-bottom border-secondary">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-cogs text-white me-2" style="font-size: 40px;"></i>
                        <h2 class="h5 text-white mb-0">PES-KISNI</h2>
                    </div>
                </div>


                <nav class="nav-menu p-3 flex-grow-1">
                    <div class="nav flex-column">
                        <a href="dashboard.php" class="nav-link active">
                            <i class="fas fa-home"></i> Dashboard
                        </a>
                        <a href="posts.php" class="nav-link">
                            <i class="fas fa-newspaper"></i> Manage Posts
                        </a>
                        <a href="categories.php" class="nav-link">
                            <i class="fas fa-folder"></i> Categories
                        </a>
                        <a href="comments.php" class="nav-link">
                            <i class="fas fa-comments"></i> Comments
                        </a>
                        <a href="media.php" class="nav-link">
                            <i class="fas fa-images"></i> Media Library
                        </a>
                        <a href="users.php" class="nav-link">
                            <i class="fas fa-users"></i> Users
                        </a>
                        <a href="settings.php" class="nav-link">
                            <i class="fas fa-cog"></i> Settings
                        </a>
                        <a href="../index.php" class="nav-link">
                            <i class="fas fa-globe"></i> PES Kisni
                        </a>

                    </div>
                </nav>

                <div class="p-3 border-top border-secondary">
                    <div class="d-flex align-items-center">
                        <!-- <img src="path/to/avatar.png" alt="User" class="rounded-circle me-2" width="32" height="32"> -->
                        <div class="text-white">
                            <small class="d-block">Logged in as</small>
                            <span class="fw-bold">
                                <i class="fas fa-user-shield me-2"></i>Admin
                            </span>
                        </div>

                        <a href="auth/logout.php" class="btn btn-outline-light btn-sm ms-auto">
                            <i class="fas fa-sign-out-alt"></i>
                        </a>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Navigation -->
            <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom sticky-top">
                <div class="container-fluid">
                    <button class="btn btn-link sidebar-toggler">
                        <i class="fas fa-bars"></i>
                    </button>

                    <form class="d-flex ms-auto me-3">
                        <div class="input-group">
                            <input type="search" class="form-control" placeholder="Search...">
                            <button class="btn btn-outline-secondary">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>

                    <div class="dropdown">
                        <button class="btn btn-link text-dark dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="fas fa-bell"></i>
                            <span class="badge bg-danger">3</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <h6 class="dropdown-header">Notifications</h6>
                            <a class="dropdown-item" href="#">
                                <small class="text-muted">Just now</small>
                                <p class="mb-0">New comment on "Latest Patch Update"</p>
                            </a>
                            <a class="dropdown-item" href="#">
                                <small class="text-muted">30 minutes ago</small>
                                <p class="mb-0">New user registration</p>
                            </a>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            <div class="container-fluid p-4">
                <!-- Header -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center">
                            <h1 class="h3 mb-0">Dashboard Overview</h1>
                            <div class="btn-group">
                                <button class="btn btn-outline-secondary">
                                    <i class="fas fa-download me-1"></i> Export
                                </button>
                                <button class="btn btn-primary">
                                    <i class="fas fa-plus me-1"></i> New Post
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="row g-4 mb-4">
                    <!-- Total Posts -->
                    <div class="col-12 col-sm-6 col-xl-3">
                        <div class="card stat-card border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h6 class="text-muted mb-2">Total Posts</h6>
                                        <h4 class="mb-0"><?php echo $total_posts; ?></h4>
                                        <small class="text-success">
                                            <i class="fas fa-arrow-up"></i> 12.5%
                                        </small>
                                    </div>
                                    <div class="flex-shrink-0 ms-3">
                                        <div class="bg-primary bg-opacity-10 p-3 rounded">
                                            <i class="fas fa-newspaper text-primary"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Comments -->
                    <div class="col-12 col-sm-6 col-xl-3">
                        <div class="card stat-card border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h6 class="text-muted mb-2">Total Comments</h6>
                                        <h4 class="mb-0"><?php echo $total_comments; ?></h4>
                                        <small class="text-danger">
                                            <i class="fas fa-arrow-down"></i> 5.2%
                                        </small>
                                    </div>
                                    <div class="flex-shrink-0 ms-3">
                                        <div class="bg-info bg-opacity-10 p-3 rounded">
                                            <i class="fas fa-comments text-info"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Downloads -->
                    <div class="col-12 col-sm-6 col-xl-3">
                        <div class="card stat-card border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h6 class="text-muted mb-2">Downloads</h6>
                                        <h4 class="mb-0"><?php echo $total_downloads; ?></h4>
                                        <small class="text-success">
                                            <i class="fas fa-arrow-up"></i> 8.4%
                                        </small>
                                    </div>
                                    <div class="flex-shrink-0 ms-3">
                                        <div class="bg-warning bg-opacity-10 p-3 rounded">
                                            <i class="fas fa-download text-warning"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Active Users -->
                    <div class="col-12 col-sm-6 col-xl-3">
                        <div class="card stat-card border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h6 class="text-muted mb-2">Active Users</h6>
                                        <h4 class="mb-0"><?php echo $total_users; ?></h4>
                                        <small class="text-success">
                                            <i class="fas fa-arrow-up"></i> 3.2%
                                        </small>
                                    </div>
                                    <div class="flex-shrink-0 ms-3">
                                        <div class="bg-success bg-opacity-10 p-3 rounded">
                                            <i class="fas fa-users text-success"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Posts Table -->
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white">
                                <h5 class="card-title mb-0">Recent Posts</h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Title</th>
                                                <th>Category</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Views</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($post = mysqli_fetch_assoc($query_recent_posts)) { ?>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <!-- Pastikan path gambar thumb sesuai -->
                                                            <img src="path/to/post-thumb.jpg" alt="Post" class="rounded me-2" width="32" height="32">
                                                            <div>
                                                                <strong><?php echo htmlspecialchars($post['title']); ?></strong>
                                                                <!-- Jika tidak ada author, bisa dihapus atau disesuaikan -->
                                                                <small class="d-block text-muted">By Author (optional)</small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-primary"><?php echo htmlspecialchars($post['category']); ?></span>
                                                    </td>
                                                    <td><?php echo date('Y-m-d', strtotime($post['post_date'])); ?></td>
                                                    <td>
                                                        <!-- Menampilkan status -->
                                                        <span class="badge <?php echo $post['status'] == 'Published' ? 'bg-success' : 'bg-warning'; ?>">
                                                            <?php echo htmlspecialchars($post['status']); ?>
                                                        </span>
                                                    </td>
                                                    <td><?php echo htmlspecialchars($post['views']); ?></td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <!-- Tombol Edit dan Delete -->
                                                            <a href="edit_post.php?id=<?php echo $post['id']; ?>" class="btn btn-sm btn-outline-primary">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <a href="delete_post.php?id=<?php echo $post['id']; ?>" class="btn btn-sm btn-outline-danger">
                                                                <i class="fas fa-trash"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Perbaiki script menjadi seperti ini
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.querySelector('.sidebar');
            const sidebarToggler = document.querySelector('.sidebar-toggler');
            const mobileOverlay = document.createElement('div');
            mobileOverlay.className = 'mobile-nav-overlay';
            document.body.appendChild(mobileOverlay);

            // Toggle sidebar
            function toggleSidebar() {
                sidebar.classList.toggle('show');
                mobileOverlay.classList.toggle('show');
                document.body.style.overflow = sidebar.classList.contains('show') ? 'hidden' : '';
            }

            // Event listeners
            sidebarToggler.addEventListener('click', toggleSidebar);
            mobileOverlay.addEventListener('click', toggleSidebar);

            // Close sidebar on window resize if open
            window.addEventListener('resize', function() {
                if (window.innerWidth > 992 && sidebar.classList.contains('show')) {
                    sidebar.classList.remove('show');
                    mobileOverlay.classList.remove('show');
                    document.body.style.overflow = '';
                }
            });

            // Close sidebar when clicking a nav link on mobile
            const navLinks = document.querySelectorAll('.nav-menu .nav-link');
            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth <= 992 && sidebar.classList.contains('show')) {
                        toggleSidebar();
                    }
                });
            });
        });
    </script>
</body>

</html>