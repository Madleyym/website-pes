<?php
// Include the database connection
require_once 'config/koneksi.php'; // Adjust the path if needed

// Fetch posts from the database (as an example, replace with your actual queries)
$query = "SELECT * FROM posts ORDER BY created_at DESC LIMIT 5";
$result = $conn->query($query);

// Handle errors in query execution
// if ($result === false) {
//     echo "Error fetching posts: " . $conn->error;
// }
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

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background: var(--primary-color);
            color: var(--text-light);
            line-height: 1.6;
        }

        .header {
            background: linear-gradient(to right, #1a1a1a, #2a2a2a);
            padding: 1.5rem;
            text-align: center;
            border-bottom: 3px solid var(--accent-color);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .logo {
            font-size: clamp(1.8rem, 4vw, 2.5rem);
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
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            position: sticky;
            top: 70px;
            z-index: 1000;
        }

        .nav-menu::-webkit-scrollbar {
            height: 3px;
        }

        .nav-menu::-webkit-scrollbar-thumb {
            background: var(--secondary-color);
        }

        .nav-menu a {
            color: var(--text-light);
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            transition: all 0.3s ease;
            white-space: nowrap;
            font-size: clamp(0.875rem, 2vw, 1rem);
        }

        .nav-menu a:hover {
            background: var(--secondary-color);
            transform: translateY(-2px);
        }

        .main-content {
            display: grid;
            grid-template-columns: minmax(0, 2fr) minmax(0, 1fr);
            gap: clamp(1rem, 3vw, 2rem);
            padding: clamp(1rem, 3vw, 2rem);
            max-width: 1400px;
            margin: 0 auto;
        }

        .content-grid {
            display: grid;
            gap: clamp(1rem, 3vw, 2rem);
        }

        .content-card {
            background: var(--card-bg);
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .content-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
        }

        .card-image {
            width: 100%;
            height: clamp(150px, 25vw, 200px);
            object-fit: cover;
        }

        .card-content {
            padding: clamp(1rem, 3vw, 1.5rem);
        }

        .card-content h2 {
            font-size: clamp(1.25rem, 3vw, 1.5rem);
            margin: 0.5rem 0;
        }

        .card-content p {
            font-size: clamp(0.875rem, 2vw, 1rem);
            opacity: 0.9;
        }

        .category-tag {
            background: var(--secondary-color);
            padding: 0.25rem 0.75rem;
            border-radius: 4px;
            font-size: clamp(0.75rem, 2vw, 0.875rem);
            display: inline-block;
        }

        .card-meta {
            margin-top: 1rem;
            font-size: clamp(0.75rem, 2vw, 0.875rem);
            opacity: 0.8;
        }

        .sidebar {
            background: #222;
            border-radius: 12px;
            padding: clamp(1rem, 3vw, 1.5rem);
            height: fit-content;
            position: sticky;
            top: 140px;
        }

        .search-box {
            width: 100%;
            padding: 0.75rem;
            border: none;
            border-radius: 8px;
            margin-bottom: 1rem;
            background: var(--card-bg);
            color: var(--text-light);
            transition: all 0.3s ease;
        }

        .search-box:focus {
            outline: 2px solid var(--secondary-color);
            transform: translateY(-2px);
        }

        .popular-posts {
            display: grid;
            gap: 1rem;
        }

        .popular-post-item {
            display: flex;
            gap: 1rem;
            padding: 0.75rem;
            background: var(--card-bg);
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .popular-post-item:hover {
            transform: translateY(-2px);
            background: #444;
        }

        .popular-post-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
        }

        .popular-post-item h4 {
            font-size: clamp(0.875rem, 2vw, 1rem);
            margin-bottom: 0.25rem;
        }

        .popular-post-item span {
            font-size: clamp(0.75rem, 2vw, 0.875rem);
            opacity: 0.8;
        }

        /* Responsive Breakpoints */
        @media (max-width: 768px) {
            .main-content {
                grid-template-columns: 1fr;
            }

            .nav-menu {
                padding: 0.75rem;
                gap: 0.5rem;
            }

            .nav-menu a {
                padding: 0.4rem 0.8rem;
            }

            .sidebar {
                position: static;
                margin-top: 2rem;
            }

            .header {
                padding: 1rem;
            }
        }

        @media (max-width: 480px) {
            .card-content {
                padding: 1rem;
            }

            .popular-post-item {
                padding: 0.5rem;
            }

            .popular-post-image {
                width: 50px;
                height: 50px;
            }
        }

        /* Dark mode enhancements */
        @media (prefers-color-scheme: dark) {
            .search-box::placeholder {
                color: rgba(255, 255, 255, 0.6);
            }

            .content-card,
            .popular-post-item,
            .sidebar {
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            }
        }
    </style>
</head>

<body>
    <header class="header">
        <div class="logo">Pes-Kisni</div>
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
                <!-- Ganti src dengan path gambar yang benar -->
                <img src="./assets/images/example.png" alt="Sample Face Pack" class="card-image">
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
                    <img src="./assets/images/image.png" alt="Sample Face Pack" class="card-image">
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