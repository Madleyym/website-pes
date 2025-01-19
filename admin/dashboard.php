<?php
require_once '../config/koneksi.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PesKisni Admin Panel</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #1a1a1a;
            --secondary-color: #2196f3;
            --accent-color: #00ff9d;
            --text-light: #ffffff;
            --danger-color: #dc3545;
            --success-color: #28a745;
            --warning-color: #ffc107;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f8f9fa;
        }

        .admin-container {
            display: grid;
            grid-template-columns: 250px 1fr;
        }

        /* Sidebar Styles */
        .sidebar {
            background: var(--primary-color);
            height: 100vh;
            position: fixed;
            width: 250px;
            padding: 1rem;
        }

        .sidebar h2 {
            color: var(--text-light);
            padding: 1rem;
            font-size: 1.5rem;
            margin-bottom: 2rem;
            border-bottom: 2px solid var(--accent-color);
        }

        .nav-menu {
            list-style: none;
        }

        .nav-menu li {
            margin-bottom: 0.5rem;
        }

        .nav-menu a {
            color: var(--text-light);
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .nav-menu a:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .nav-menu i {
            margin-right: 0.75rem;
            width: 20px;
            text-align: center;
        }

        /* Main Content Styles */
        .main-content {
            margin-left: 250px;
            padding: 2rem;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .page-header h1 {
            font-size: 1.75rem;
            color: #333;
        }

        .page-header span {
            color: #666;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            position: relative;
        }

        .stat-card h3 {
            color: #666;
            font-size: 1rem;
            font-weight: 500;
            margin-bottom: 1rem;
        }

        .stat-number {
            font-size: 1.75rem;
            font-weight: bold;
            color: #333;
        }

        .stat-icon {
            position: absolute;
            top: 1.5rem;
            right: 1.5rem;
            font-size: 1.5rem;
            color: #2196f3;
            opacity: 0.8;
        }

        /* Recent Posts Table */
        .recent-posts {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .recent-posts h2 {
            font-size: 1.25rem;
            color: #333;
            margin-bottom: 1.5rem;
        }

        .content-table {
            width: 100%;
            border-collapse: collapse;
        }

        .content-table th {
            background: #f8f9fa;
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: #333;
            border-bottom: 2px solid #eee;
        }

        .content-table td {
            padding: 1rem;
            border-bottom: 1px solid #eee;
            color: #666;
        }

        .status-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 50px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .status-published {
            background: var(--success-color);
            color: white;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }

        .edit-button {
            background: var(--secondary-color);
            color: white;
        }

        .delete-button {
            background: var(--danger-color);
            color: white;
        }

        .btn:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        @media (max-width: 1200px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .admin-container {
                grid-template-columns: 1fr;
            }
            
            .sidebar {
                display: none;
            }
            
            .main-content {
                margin-left: 0;
                padding: 1rem;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <aside class="sidebar">
            <h2>PesKisni</h2>
            <ul class="nav-menu">
                <li><a href="dashboard.php"><i class="fas fa-home"></i>Dashboard</a></li>
                <li><a href="posts.php"><i class="fas fa-newspaper"></i>Manage Posts</a></li>
                <li><a href="categories.php"><i class="fas fa-folder"></i>Categories</a></li>
                <li><a href="comments.php"><i class="fas fa-comments"></i>Comments</a></li>
                <li><a href="media.php"><i class="fas fa-images"></i>Media Library</a></li>
                <li><a href="users.php"><i class="fas fa-users"></i>Users</a></li>
                <li><a href="settings.php"><i class="fas fa-cog"></i>Settings</a></li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a></li>
            </ul>
        </aside>

        <main class="main-content">
            <div class="page-header">
                <h1>Dashboard</h1>
                <span><?php echo date('l, d F Y'); ?></span>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <h3>Total Posts</h3>
                    <p class="stat-number"><?php echo isset($totalPosts) ? number_format($totalPosts) : '245'; ?></p>
                    <i class="fas fa-newspaper stat-icon"></i>
                </div>
                <div class="stat-card">
                    <h3>Total Comments</h3>
                    <p class="stat-number"><?php echo isset($totalComments) ? number_format($totalComments) : '1,234'; ?></p>
                    <i class="fas fa-comments stat-icon"></i>
                </div>
                <div class="stat-card">
                    <h3>Total Downloads</h3>
                    <p class="stat-number"><?php echo isset($totalDownloads) ? number_format($totalDownloads) : '5,678'; ?></p>
                    <i class="fas fa-download stat-icon"></i>
                </div>
                <div class="stat-card">
                    <h3>Active Users</h3>
                    <p class="stat-number">892</p>
                    <i class="fas fa-users stat-icon"></i>
                </div>
            </div>

            <div class="recent-posts">
                <h2>Recent Posts</h2>
                <table class="content-table">
                    <thead>
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
                        <tr>
                            <td>New Face Pack 2024</td>
                            <td><i class="fas fa-folder"></i> Face Packs</td>
                            <td><i class="far fa-calendar"></i> 2024-01-20</td>
                            <td><span class="status-badge status-published">Published</span></td>
                            <td>1,234</td>
                            <td class="action-buttons">
                                <button class="btn edit-button"><i class="fas fa-edit"></i> Edit</button>
                                <button class="btn delete-button"><i class="fas fa-trash"></i> Delete</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Latest Patch Update</td>
                            <td><i class="fas fa-folder"></i> Patches</td>
                            <td><i class="far fa-calendar"></i> 2024-01-19</td>
                            <td><span class="status-badge status-published">Published</span></td>
                            <td>2,156</td>
                            <td class="action-buttons">
                                <button class="btn edit-button"><i class="fas fa-edit"></i> Edit</button>
                                <button class="btn delete-button"><i class="fas fa-trash"></i> Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>