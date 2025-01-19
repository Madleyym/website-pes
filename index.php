<?php
// Include the database connection
require_once 'config/koneksi.php'; // Adjust the path if needed

// Fetch posts from the database (as an example, replace with your actual queries)
$query = "SELECT * FROM posts ORDER BY created_at DESC LIMIT 5";
$result = $conn->query($query);

// Handle errors in query execution
if ($result === false) {
    echo "Error fetching posts: " . $conn->error;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PesKisni - Your Ultimate PES Resource</title>
    <style>
        :root {
            --primary-color: #2a2a2a;
            --secondary-color: #1e88e5;
            --accent-color: #00ff9d;
            --text-light: #ffffff;
            --card-bg: #333333;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background: var(--primary-color);
            color: var(--text-light);
        }

        .header {
            background: linear-gradient(to right, #1a1a1a, #2a2a2a);
            padding: 1rem;
            text-align: center;
            border-bottom: 3px solid var(--accent-color);
        }

        .logo {
            font-size: 2.5rem;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--text-light);
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .nav-menu {
            background: #222;
            padding: 1rem;
            display: flex;
            justify-content: center;
            gap: 1rem;
        }

        .nav-menu a {
            color: var(--text-light);
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        .nav-menu a:hover {
            background: var(--secondary-color);
        }

        .main-content {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .content-grid {
            display: grid;
            gap: 2rem;
        }

        .content-card {
            background: var(--card-bg);
            border-radius: 8px;
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .content-card:hover {
            transform: translateY(-5px);
        }

        .card-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .card-content {
            padding: 1rem;
        }

        .category-tag {
            background: var(--secondary-color);
            padding: 0.25rem 0.75rem;
            border-radius: 4px;
            font-size: 0.875rem;
            display: inline-block;
        }

        .sidebar {
            background: #222;
            border-radius: 8px;
            padding: 1rem;
        }

        .search-box {
            width: 100%;
            padding: 0.75rem;
            border: none;
            border-radius: 4px;
            margin-bottom: 1rem;
        }

        .popular-posts {
            display: grid;
            gap: 1rem;
        }

        .popular-post-item {
            display: flex;
            gap: 1rem;
            padding: 0.5rem;
            background: var(--card-bg);
            border-radius: 4px;
        }

        .popular-post-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    <header class="header">
        <div class="logo">PesKisni</div>
    </header>

    <nav class="nav-menu">
        <a href="#home">Home</a>
        <a href="#faces">Face Packs</a>
        <a href="#patches">Patches</a>
        <a href="#kits">Kits</a>
        <a href="#stadiums">Stadiums</a>
        <a href="#tutorials">Tutorials</a>
    </nav>

    <main class="main-content">
        <div class="content-grid">
            <!-- Sample Content Card -->
            <article class="content-card">
                <img src="/api/placeholder/400/200" alt="Sample Face Pack" class="card-image">
                <div class="card-content">
                    <span class="category-tag">Premium Face Pack</span>
                    <h2>Sample Player Face PES 2024</h2>
                    <p>Latest face pack update with high-quality textures and realistic features.</p>
                    <div class="card-meta">
                        <span>January 20, 2025</span>
                        <span>• 0 Comments</span>
                    </div>
                </div>
            </article>
        </div>

        <aside class="sidebar">
            <input type="search" placeholder="Search content..." class="search-box">
            <h3>Popular Posts</h3>
            <div class="popular-posts">
                <div class="popular-post-item">
                    <img src="/api/placeholder/60/60" alt="Popular Post" class="popular-post-image">
                    <div>
                        <h4>Popular Face Pack</h4>
                        <span>2.5k views</span>
                    </div>
                </div>
            </div>
        </aside>
    </main>
</body>

</html>
<?php
// Close the database connection
$conn->close();
?>