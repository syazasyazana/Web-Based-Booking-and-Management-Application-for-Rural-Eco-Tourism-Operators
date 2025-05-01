<?php
include '../../config/config.php';

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ Management - Common Questions</title>
<style>
   html, body {
    height: 100%;
    margin: 0;
    display: flex;
    flex-direction: column;
    font-family: Arial, sans-serif;
    background-color: #f9f9f9;
    color: #333;
}

    /* Navbar styling*/
        .navbar {
			display: flex;
			justify-content: space-between;
			align-items: center;
			padding: 10px 30px;
			background-color: rgba(0, 0, 0, 0.6);
			position: fixed; /* Ensures the navbar stays fixed at the top */
			width: 100%; /* Full width for consistency */
			top: 0; /* Aligns the navbar to the top */
			z-index: 1000; /* Ensures it stays above other elements */
			height: 60px; /* Fixed height for proper spacing */
			box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); /* Optional: subtle shadow for better visibility */
		}

        .navbar .logo {
            font-size: 24px;
            font-weight: 700;
            text-transform: uppercase;
            color: white;
        }

        .navbar .nav-links {
            display: flex;
            gap: 15px;
            flex: 1;
            justify-content: center;
        }

        .navbar .nav-links a {
            text-decoration: none;
            color: white;
            font-weight: 400;
            transition: color 0.3s ease;
        }

        .navbar .nav-links a:hover {
            color: #00d9ff;
        }

        .navbar .logout {
            font-size: 16px;
            font-weight: 400;
            color: #ff4c4c;
            margin-left: 15px;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .navbar .logout:hover {
            color: #ff1f1f;
        }
	
	

    /* Title Section */
    .title-section {
        background-color: white;
        color: black;
        padding: 2rem;
        text-align: center;
    }

    .title-section h1 {
        font-size: 2.5rem;
        margin-bottom: 0.5rem;
        color: black;
    }

    .title-section p {
        font-size: 1.2rem;
        margin: 0;
    }

    /* FAQ Section */
    .faq-section {
        max-width: 800px;
        margin: 8rem auto;
        padding: 1rem;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
		 flex: 1;
    }

    .faq-section h2 {
        text-align: center;
        font-size: 2rem;
        color: #000000;
        margin-bottom: 1.5rem;
    }

    /* FAQ Item */
    .faq-item {
        margin-bottom: 1rem;
        border: 1px solid #ddd;
        border-radius: 5px;
        overflow: hidden;
    }

    .faq-question {
        width: 100%;
        background-color: #f1f1f1;
        color: #333;
        border: none;
        outline: none;
        text-align: left;
        padding: 1rem;
        cursor: pointer;
        font-size: 1.1rem;
        position: relative;
    }

    .faq-question:hover {
        background-color: #e9e9e9;
    }

    .toggle-icon {
        position: absolute;
        right: 1rem;
        font-weight: bold;
        font-size: 1.2rem;
    }

    .faq-answer {
        display: none;
        padding: 1rem;
        background-color: #fff;
        color: #555;
        border-top: 1px solid #ddd;
    }

    .faq-answer p {
        margin: 0;
    }

footer {
    background-color: rgba(0, 0, 0, 0.6);
    color: #fff;
    padding: 10px 30px;
    text-align: center;
    font-size: 18px;
    border: 2px solid rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(20px);
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    height: 60px;
    position: relative;
}
</style>



    
</head>
<body>
<div class="navbar">
        <div class="logo">Explore</div>
        <div class="nav-links">
            <a href="mainpage.php">Home</a>
            <a href="../services/serviceListing.php">Services</a>
            <a href="faq.php">FAQ</a>
        </div>
        <a href="login.php" class="login-icon">&#128100;</a>
    </div>

    <!-- Header Section -->
    

    <!-- FAQ Section -->
    <section class="faq-section">
        <h2>Common Questions</h2>
        <!-- FAQs will be dynamically loaded here -->
    </section>



    <!-- Inline JavaScript -->
    <script>
        function loadFAQs() {
            fetch('get_faqs.php')
                .then(response => response.json())
                .then(data => {
                    const faqSection = document.querySelector('.faq-section');
                    faqSection.innerHTML = '<h2>Common Questions</h2>';
                    data.forEach(faq => {
                        faqSection.innerHTML += `
                            <div class="faq-item">
                                <button class="faq-question">${faq.question}<span class="toggle-icon">+</span></button>
                                <div class="faq-answer">
                                    <p>${faq.answer}</p>
                                </div>
                            </div>
                        `;
                    });
                    setupToggleButtons();
                })
                .catch(error => console.error('Error fetching FAQs:', error));
        }

        function setupToggleButtons() {
            document.querySelectorAll('.faq-question').forEach(button => {
                button.addEventListener('click', () => {
                    const faqAnswer = button.nextElementSibling;
                    const isVisible = faqAnswer.style.display === "block";
                    faqAnswer.style.display = isVisible ? "none" : "block";
                    button.querySelector('.toggle-icon').textContent = isVisible ? "+" : "-";
                });
            });
        }

        // Load FAQs on page load
        loadFAQs();
    </script>
	
	<footer>
        <p class="footer" align="center"><small>&copy; Polumpung Sabah. All rights reserved</small></p>
    </footer>
</body>
</html>
