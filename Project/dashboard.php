<?php
// PHP code must be at the very top, before any HTML output, to manage sessions correctly.
session_start();

// Enable basic error reporting (RECOMMENDED TO REMOVE ALL error_reporting IN PRODUCTION)
ini_set('display_errors', 0); // Changed to 0
ini_set('display_startup_errors', 0); // Changed to 0
error_reporting(E_ALL); // You can even comment this out entirely in production

// Check if the user is logged in
$loggedIn = isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true;
$userName = $loggedIn ? htmlspecialchars($_SESSION["name"]) : "Guest";

// Optional: Uncomment this block if you want to restrict dashboard access to logged-in users only
// if (!$loggedIn) {
//     header("location: login.html");
//     exit;
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gamer's Portal</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        /* Base Styles - Dark Theme based on the image */
        body, html {
            margin: 0;
            padding: 0;
            font-family: 'Inter', Arial, sans-serif;
            background-color: #2e1a47; /* Dark purple/indigo from the image */
            min-height: 100vh;
            color: #ffffff; /* Default text color to white for contrast */
            display: flex;
            flex-direction: column;
            overflow-x: hidden; /* Prevent horizontal scroll on small screens */
            line-height: 1.5; /* Default line height for readability */
            scroll-behavior: smooth; /* Smooth scrolling for anchor links */
        }

        /* Top Header Layer - Replicated from image for a website feel */
        .top-header-layer {
            width: 100%;
            height: 60px;
            background-color: #1a1a2e; /* Very dark grey/black for header */
            border-bottom: 1px solid #4a3e5e; /* Slightly lighter border */
            display: flex;
            align-items: center;
            justify-content: space-between; /* Space out elements */
            padding: 0 25px;
            box-sizing: border-box; /* Ensures padding doesn't increase total width */
            color: #ccc; /* Lighter grey for header text */
            position: sticky; /* Make header sticky */
            top: 0;
            z-index: 1000; /* Ensure header stays on top */
        }

        .header-left, .header-center, .header-right {
            display: flex;
            align-items: center;
        }

        .header-left {
            flex-grow: 1;
        }

        .site-logo {
            font-size: 24px;
            font-weight: 700;
            color: #ffffff;
            margin-right: 30px;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .site-logo:hover {
            color: #9370db; /* Accent color on hover */
        }

        .header-nav {
            display: flex;
            gap: 25px; /* Space between main nav items */
        }

        .header-nav-item {
            color: #ccc;
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
            padding: 5px 0;
            transition: color 0.2s ease, border-bottom 0.2s ease;
        }

        .header-nav-item:hover {
            color: #fff;
            border-bottom: 2px solid #9370db; /* Subtle highlight on hover */
        }

        .header-right {
            gap: 25px;
        }

        /* Styles for user name and logout button (new) */
        .user-info {
            color: #ffffff;
            font-size: 15px;
            font-weight: 600;
            margin-right: 15px;
        }

        .header-action-button {
            padding: 8px 15px;
            background-color: #451779; /* Accent purple */
            color: #ffffff;
            font-size: 14px;
            font-weight: 600;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none; /* For link buttons */
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .header-action-button:hover {
            background-color: #5d259c;
            transform: translateY(-1px);
        }

        /* Main Content Area */
        .main-content-wrapper {
            flex-grow: 1;
            padding: 40px 25px; /* Consistent padding around the main content */
            max-width: 1200px; /* Max width for content for better readability */
            margin: 0 auto; /* Center the content */
            box-sizing: border-box;
        }

        /* Hero Section - Prominent banner */
        .hero-section {
            background-color: #3d2a58; /* Slightly lighter purple for hero */
            border-radius: 8px;
            padding: 50px;
            margin-bottom: 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            position: relative; /* For the "New!" badge */
            overflow: hidden;
        }

        .hero-content h1 {
            font-size: 48px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 15px;
            line-height: 1.2;
        }

        .hero-content p {
            font-size: 18px;
            color: #e0e0e0;
            margin-bottom: 30px;
            max-width: 600px;
        }

        .hero-buttons {
            display: flex;
            gap: 15px;
        }

        .hero-button {
            padding: 15px 30px;
            background-color: #4CAF50; /* Green accent */
            color: #ffffff;
            font-size: 16px;
            font-weight: 600;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .hero-button:hover {
            background-color: #45a049;
            transform: translateY(-2px);
        }

        .hero-button.secondary {
            background-color: transparent;
            border: 2px solid #9370db; /* Lighter purple outline */
            color: #9370db;
        }
        .hero-button.secondary:hover {
            background-color: #9370db;
            color: #ffffff;
            transform: translateY(-2px);
        }

        .hero-image-placeholder {
            width: 300px;
            height: 200px;
            background-color: #1a1a2e; /* Dark placeholder */
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
            font-size: 18px;
            box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.5);
            flex-shrink: 0;
            overflow: hidden;
        }

        .hero-image-placeholder img,
        .game-card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }


        .new-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: #e74c3c; /* Red for "New" */
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            font-weight: 700;
            font-size: 14px;
            transform: rotate(5deg);
        }

        /* Content Sections - Flexible grid for cards */
        .content-section {
            margin-bottom: 50px;
        }

        .content-section h2 {
            font-size: 32px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 30px;
            text-align: center;
        }

        .card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); /* Responsive grid */
            gap: 25px;
        }

        .game-card {
            background-color: #1a1a2e; /* Dark card background */
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            text-decoration: none;
            color: inherit;
            display: flex;
            flex-direction: column;
            min-height: 350px;
        }

        .game-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.6);
        }

        .game-card-image {
            width: 100%;
            height: 180px; /* Fixed height for image */
            background-color: #33334d; /* Placeholder color */
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: #999;
            object-fit: cover;
            border-bottom: 1px solid #4a3e5e;
            overflow: hidden;
        }

        .game-card-content {
            padding: 20px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            text-align: center;
        }

        .game-card-content h3 {
            font-size: 20px;
            font-weight: 600;
            color: #ffffff;
            margin-bottom: 10px;
        }

        .game-card-content p {
            font-size: 14px;
            color: #ccc;
            line-height: 1.5;
            flex-grow: 1;
            margin-bottom: 15px;
            text-align: center;
        }

        .game-card-button {
            padding: 10px 15px;
            background-color: #451779;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            text-align: center;
            transition: background-color 0.3s ease;
            display: inline-block;
            width: fit-content;
            margin-top: auto;
            align-self: center;
        }

        .game-card-button:hover {
            background-color: #5d259c;
        }

        /* Footer */
        .site-footer {
            background-color: #1a1a2e;
            color: #ccc;
            padding: 30px 25px;
            border-top: 1px solid #4a3e5e;
            text-align: center;
            font-size: 14px;
        }

        .footer-nav {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 15px;
            flex-wrap: wrap;
        }

        .footer-nav-item {
            color: #ccc;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .footer-nav-item:hover {
            color: #fff;
        }

        .footer-copyright {
            color: #888;
        }

        /* Message Box (consistent) */
        .message-box-container {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #f44336;
            color: white;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 2000;
            display: none;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
            min-width: 250px;
            text-align: center;
        }

        .message-box-container.show {
            display: block;
            opacity: 1;
        }

        .message-box-container.success {
            background-color: #4CAF50;
        }

        /* Specific styles for new content sections */
        .info-section {
            background-color: #3d2a58; /* Slightly lighter purple for content blocks */
            border-radius: 8px;
            padding: 40px;
            margin-bottom: 50px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
        }

        .info-section h2 {
            font-size: 32px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 20px; /* Reduced margin for brief descriptions */
            text-align: left; /* Align section titles to left */
        }

        .info-section p, .info-section ul {
            font-size: 16px;
            color: #e0e0e0;
            margin-bottom: 10px; /* Reduced margin for brief descriptions */
            line-height: 1.6;
        }

        .info-section ul {
            list-style-type: disc;
            margin-left: 20px;
            padding-left: 0;
        }

        .info-section ul li {
            margin-bottom: 5px; /* Reduced margin for brief descriptions */
        }

        .info-section strong {
            color: #ffffff;
        }

        .contact-info p {
            margin-bottom: 10px;
        }

        .contact-info a {
            color: #9370db;
            text-decoration: none;
        }

        .contact-info a:hover {
            text-decoration: underline;
        }


        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .top-header-layer {
                padding: 0 15px;
            }
            .header-nav {
                display: none;
            }
            .header-left {
                flex-grow: 0;
            }
            .site-logo {
                margin-right: 15px;
            }
            .header-action-button {
                padding: 6px 10px;
                font-size: 13px;
            }
            .main-content-wrapper {
                padding: 30px 15px;
            }
            .hero-section {
                flex-direction: column;
                padding: 30px;
                text-align: center;
                margin-bottom: 40px;
            }
            .hero-content h1 {
                font-size: 36px;
            }
            .hero-content p {
                font-size: 16px;
            }
            .hero-buttons {
                flex-direction: column;
                width: 100%;
            }
            .hero-button {
                width: 100%;
            }
            .hero-image-placeholder {
                width: 100%;
                height: 150px;
            }
            .content-section h2, .info-section h2 {
                font-size: 28px;
                margin-bottom: 20px; /* Adjusted for smaller screens */
                text-align: center; /* Center align section titles on small screens */
            }
            .card-grid {
                grid-template-columns: 1fr;
            }
            .game-card {
                min-height: auto;
            }
            .site-footer {
                padding: 20px 15px;
            }
            .info-section {
                padding: 30px 20px;
            }
            .info-section p, .info-section ul {
                font-size: 15px; /* Adjusted for smaller screens */
                margin-bottom: 8px;
            }
        }

        @media (max-width: 480px) {
            .site-logo {
                font-size: 20px;
            }
            .header-right {
                gap: 15px;
            }
            .hero-content h1 {
                font-size: 30px;
            }
            .hero-content p {
                font-size: 15px;
            }
            .content-section h2, .info-section h2 {
                font-size: 24px;
            }
            .game-card-content h3 {
                font-size: 18px;
            }
            .game-card-content p {
                font-size: 13px;
            }
            .game-card-button {
                font-size: 13px;
            }
        }
    </style>
</head>
<body>

    <div class="top-header-layer">
        <div class="header-left">
            <a href="#" class="site-logo">GAMER'S PORTAL</a>
            <nav class="header-nav">
                <!-- Removed Games, Community, Store links -->
                <a href="#latest-gaming-news" class="header-nav-item">News</a>
                <!-- Updated Support link in main navigation -->
                <a href="https://paypal.me/awwabplshelp" class="header-nav-item" target="_blank">Support</a>
            </nav>
        </div>
        <div class="header-right">
            <?php if ($loggedIn): ?>
                <span class="user-info">Welcome, <?php echo $userName; ?>!</span>
                <a href="logout.php" class="header-action-button">Logout</a>
            <?php else: ?>
                <a href="register.html" class="header-action-button">Sign Up</a>
                <a href="login.html" class="header-action-button">Login</a>
            <?php endif; ?>
        </div>
    </div>

    <div class="main-content-wrapper">
        <section class="hero-section">
            <div class="hero-content">
                <h1>Unleash Your Gaming Potential</h1>
                <p>Discover new worlds, challenge friends, and dominate the leaderboards. Your ultimate gaming experience starts here.</p>
                <div class="hero-buttons">
                    <a href="https://hsr.hoyoverse.com/en-us/" class="hero-button">Play Online Now</a>
                    <!-- Updated "Explore Popular Games" button to navigate to Featured Games section -->
                    <a href="#featured-games" class="hero-button secondary">Explore Featured Games</a>
                </div>
            </div>
            <div class="hero-image-placeholder">
                <!-- Honkai Star Rail image from kaleoz-media.seagmcdn.com -->
                <img src="https://kaleoz-media.seagmcdn.com/kaleoz-store/202303/oss-d76e98a3640bf42f0e00420f2f6f1be1.jpg!webp"
                     alt="Featured Game Art: Honkai Star Rail"
                     onerror="this.onerror=null;this.src='https://placehold.co/600x400/666/eee?text=Image+Failed+to+Load';">
                <span class="new-badge">New!</span>
            </div>
        </section>

        <section class="content-section" id="featured-games">
            <h2>Featured Games</h2>
            <div class="card-grid">
                <!-- Game Card 1: Honkai: Star Rail -->
                <a href="https://hsr.hoyoverse.com/en-us/" class="game-card">
                    <div class="game-card-image">
                        <!-- Honkai Star Rail image from kaleoz-media.seagmcdn.com -->
                        <img src="https://kaleoz-media.seagmcdn.com/kaleoz-store/202303/oss-d76e98a3640bf42f0e00420f2f6f1be1.jpg!webp"
                             alt="Honkai Star Rail Game Image"
                             onerror="this.onerror=null;this.src='https://placehold.co/300x180/666/eee?text=Image+Failed+to+Load';">
                    </div>
                    <div class="game-card-content">
                        <h3>Honkai: Star Rail</h3>
                        <p>Embark on a trailblazing adventure across the cosmos. Master turn-based combat and unravel universal mysteries.</p>
                        <span class="game-card-button">Play Now</span>
                    </div>
                </a>

                <!-- Game Card 2: Crystal of Atlan -->
                <a href="https://coa.nvsgames.com/" class="game-card">
                    <div class="game-card-image">
                        <img src="https://cdn-www.bluestacks.com/bs-images/coan-bg-en.jpg"
                             alt="Crystal of Atlan Game Image"
                             onerror="this.onerror=null;this.src='https://placehold.co/300x180/666/eee?text=Image+Failed+to+Load';">
                    </div>
                    <div class="game-card-content">
                        <h3>Crystal of Atlan</h3>
                        <p>Immerse yourself in a Magicpunk MMO Action RPG with diverse classes, refreshing aerial combos, challenging team battles, and thrilling fair PvP showdowns.</p>
                        <span class="game-card-button">Discover More</span>
                    </div>
                </a>

                <!-- Game Card 3: Six Cats Under -->
                <a href="https://teambeanloop.itch.io/six-cats-under" class="game-card">
                    <div class="game-card-image">
                        <img src="https://www.geekgirlauthority.com/wp-content/uploads/2024/03/Six-Cats-Under.jpg"
                             alt="Six Cats Under Game Image"
                             onerror="this.onerror=null;this.src='https://placehold.co/300x180/666/eee?text=Image+Failed+to+Load';">
                    </div>
                    <div class="game-card-content">
                        <h3>Six Cats Under</h3>
                        <p>A charming point-and-click puzzle game where you use poltergeist powers to guide adorable cats to safety. A cute, narrative-driven experience with pixel art.</p>
                        <span class="game-card-button">Play Now</span>
                    </div>
                </a>

                <!-- Game Card 4: Dark and Darker -->
                <a href="https://www.darkanddarker.com/home" class="game-card">
                    <div class="game-card-image">
                        <!-- Dark and Darker image from provided URL -->
                        <img src="https://front.darkanddarker.com/og_img_2.jpg"
                             alt="Dark and Darker Game Image"
                             onerror="this.onerror=null;this.src='https://placehold.co/300x180/666/eee?text=Image+Failed+to+Load';">
                    </div>
                    <div class="game-card-content">
                        <h3>Dark and Darker</h3>
                        <p>A hardcore fantasy FPS dungeon crawler. Venture deep, fight monsters, and escape with legendary loot!</p>
                        <span class="game-card-button">Enter Dungeon</span>
                    </div>
                </a>
            </div>
        </section>

        <section class="content-section" id="latest-gaming-news">
            <h2>Latest Gaming News</h2>
            <div class="card-grid">
                <!-- News Card 1: Apex Legends Patch 2.0 -->
                <a href="https://www.ea.com/id/games/apex-legends/apex-legends/news/breakout-patch-notes" class="game-card">
                    <div class="game-card-image">
                        <img src="https://static0.gamerantimages.com/wordpress/wp-content/uploads/2025/02/apex-legends-covert-art.jpg"
                             alt="Apex Legends News Image"
                             onerror="this.onerror=null;this.src='https://placehold.co/300x180/666/eee?text=Image+Failed+to+Load';">
                    </div>
                    <div class="game-card-content">
                        <h3>Patch 2.0 Released for Apex Legends!</h3>
                        <p>New maps, characters, and improved weapon balance. Dive into the latest update now!</p>
                        <span class="game-card-button">Read More</span>
                    </div>
                </a>

                <!-- News Card 2: Esports Championship Finals -->
                <a href="https://esportsworldcup.com/" class="game-card">
                    <div class="game-card-image">
                        <img src="https://budappest.com/wp-content/uploads/2025/04/telekom-esports-championship-season-3-finals-2025-budapest.png"
                             alt="Esports Championship Finals Image"
                             onerror="this.onerror=null;this.src='https://placehold.co/300x180/666/eee?text=Image+Failed+to+Load';">
                    </div>
                    <div class="game-card-content">
                        <h3>Esports Championship Finals Announced</h3>
                        <p>The biggest event of the year is coming soon! Get your tickets and support your favorite teams.</p>
                        <span class="game-card-button">Details Here</span>
                    </div>
                </a>

                <!-- News Card 3: Developer Q&A: The Making of "Starfall" -->
                <a href="https://www.nintendo.com/us/whatsnew/ask-the-developer-vol-18-mario-kart-world-part-1/" class="game-card">
                    <div class="game-card-image">
                        <img src="https://assets.nintendo.com/image/upload/q_auto:best/f_auto/dpr_2.0/ncom/software/switch-2/70010000095431/b664445df3f7a3765a760822d725ea1853bc6f43d2aa96ccee81d6f45cb281ef"
                             alt="Dev Q&A News Image"
                             onerror="this.onerror=null;this.src='https://placehold.co/300x180/666/eee?text=Image+Failed+to+Load';">
                    </div>
                    <div class="game-card-content">
                        <h3>Developer Q&A: The Making of "Mario Kart World"</h3>
                        <p>Go behind the scenes with the creators of the hit indie game "Mario Kart World."</p>
                        <span class="game-card-button">Watch Interview</span>
                    </div>
                </a>
            </div>
        </section>

        <section class="content-section">
            <h2>Recent Activity & Player Updates</h2>
            <div class="update-messages" style="border: none; padding-top: 0; margin-top: 0;">
                <p>Your server 'MyAwesomeServer' has been automatically updated.</p>
                <p>Your coaching session with CoachPro is confirmed for Apr 20, 2025 at 7:00 PM WIB.</p>
                <p>New achievement unlocked: "First Victory" in Honkai: Star Rail!</p>
            </div>
        </section>

        <!-- New Content Sections -->
        <section class="info-section" id="about-us">
            <h2>About Us</h2>
            <p>Gamer's Portal is a passionate community connecting gamers worldwide. We provide the latest news, exciting games, and a platform for players of all skill levels to thrive. Join us!</p>
        </section>

        <section class="info-section" id="careers">
            <h2>Careers</h2>
            <p>Seeking talented individuals passionate about gaming to join our dynamic team. Explore opportunities to grow and make an impact!</p>
            <h3>Current Openings:</h3>
            <ul>
                <li><strong>Content Writer:</strong> Articles, reviews, guides.</li>
                <li><strong>Community Mod:</strong> Maintain a positive community.</li>
                <li><strong>Web Developer:</strong> Contribute to platform functionality.</li>
                <li><strong>Esports Coordinator:</strong> Plan online tournaments.</li>
            </ul>
            <p>Ready to level up your career? Send your resume to <a href="mailto:awwab200@gmail.com" style="color: #9370db;">awwab200@gmail.com</a>.</p>
        </section>

        <section class="info-section" id="privacy-policy">
            <h2>Privacy Policy</h2>
            <p>Your privacy is paramount. We collect limited data (email, name, usage, cookies) to provide and improve our service. We do not sell your personal data. You have rights regarding your data. Contact us for concerns.</p>
        </section>

        <section class="info-section" id="terms-of-service">
            <h2>Terms of Service</h2>
            <p>By using Gamer's Portal, you agree to these terms. You must be 13+. Be responsible for your account. Prohibited conduct includes harassment, illegal content, and unauthorized access. Violations may lead to account suspension.</p>
        </section>

        <section class="info-section" id="contact-us">
            <h2>Contact Us</h2>
            <p>Questions or feedback? Reach out to the Gamer's Portal team!</p>
            <div class="contact-info">
                <p><strong>Email:</strong> <a href="mailto:awwab300@gmail.com">awwab300@gmail.com</a></p>
                <!-- Updated Support link and description -->
                <p><strong>Support & Donations:</strong> Help support our page development and community initiatives via PayPal: <a href="https://paypal.me/awwabplshelp" target="_blank" style="color: #9370db;">paypal.me/awwabplshelp</a></p>
                <p><strong>Business Inquiries:</strong> <a href="mailto:awwab200@gmail.com" style="color: #9370db;">awwab200@gmail.com</a></p>
            </div>
        </section>

    </div>

    <footer class="site-footer">
        <div class="footer-nav">
            <a href="#about-us" class="footer-nav-item">About Us</a>
            <a href="#careers" class="footer-nav-item">Careers</a>
            <a href="#privacy-policy" class="footer-nav-item">Privacy Policy</a>
            <a href="#terms-of-service" class="footer-nav-item">Terms of Service</a>
            <a href="#contact-us" class="footer-nav-item">Contact Us</a>
        </div>
        <div class="footer-copyright">
            &copy; 2025 Gamer's Portal. All Rights Reserved.
        </div>
    </footer>

    <!-- Message Box - Consistent with other pages -->
    <div id="messageBox" class="message-box-container">
        <span id="messageText"></span>
    </div>

    <!-- The dashboard.js can still be used for logout functionality and general site-wide JS -->
    <script>
        // You can embed necessary JavaScript here if needed for client-side messages
        // or other dynamic behavior not handled by PHP.
        // For status messages coming from URL parameters (e.g., from login.php):
        window.onload = function() {
            const urlParams = new URLSearchParams(window.location.search);
            const status = urlParams.get('status');
            const messageBox = document.getElementById('messageBox');
            const messageText = document.getElementById('messageText');

            function showMessage(message, type = 'error') {
                messageText.textContent = message;
                messageBox.classList.remove('success', 'error');
                messageBox.classList.add(type);
                messageBox.classList.add('show');
                setTimeout(() => {
                    messageBox.classList.remove('show');
                }, 3000);
            }

            if (status === 'login_success') {
                showMessage('Welcome back to your dashboard!', 'success');
                history.replaceState(null, '', window.location.pathname); // Clean URL
            } else if (status === 'logged_out') {
                showMessage('You have been successfully logged out.', 'success');
                history.replaceState(null, '', window.location.pathname); // Clean URL
            }
            // Add other status messages as needed
        };
    </script>
</body>
</html>
