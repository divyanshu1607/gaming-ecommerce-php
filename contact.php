<?php
session_start();
include('db/config.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>GameZone | Contact Us</title>
  <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500;700&family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <style>
    * { margin:0; padding:0; box-sizing:border-box; }
    body {
      font-family:'Poppins',sans-serif;
      background: radial-gradient(circle at top, #0f0f0f, #1a1a1a);
      color: #fff;
      padding-bottom: 3rem;
    }

    h1, h2 { font-family: 'Orbitron', sans-serif; }

    .contact-container {
      max-width: 1200px;
      margin: 3rem auto;
      padding: 2rem;
      background: rgba(20,20,20,0.85);
      box-shadow: 0 0 25px #00ffcc33;
      border-radius: 15px;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 2rem;
    }

    /* Left side (Contact Info) */
    .contact-info {
      display: flex;
      flex-direction: column;
      gap: 1.5rem;
    }
    .contact-info h2 {
      font-size: 2rem;
      color: #00ffcc;
      margin-bottom: 0.5rem;
    }
    .contact-info p {
      font-size: 1rem;
      color: #ccc;
    }
    .contact-info i {
      color: #00ffcc;
      margin-right: 10px;
    }

    .social-links {
      margin-top: 1rem;
    }
    .social-links a {
      font-size: 1.5rem;
      margin-right: 15px;
      color: #fff;
      transition: 0.3s;
    }
    .social-links a:hover { color: #00ffcc; }

    /* Contact Form */
    .contact-form {
      display: flex;
      flex-direction: column;
      gap: 1rem;
    }
    .contact-form input, .contact-form textarea {
      width: 100%;
      padding: 12px 15px;
      border-radius: 10px;
      border: none;
      background: #1f1f1f;
      color: #00ffcc;
      font-size: 1rem;
      box-shadow: 0 0 10px #00ffcc33;
      transition: 0.3s;
    }
    .contact-form input:focus, .contact-form textarea:focus {
      outline: none;
      box-shadow: 0 0 15px #00ffcc88;
    }
    .contact-form textarea { resize: none; }

    .contact-form button {
      background: #00ffcc;
      color: #000;
      font-weight: bold;
      padding: 12px;
      border: none;
      border-radius: 25px;
      cursor: pointer;
      transition: 0.3s;
    }
    .contact-form button:hover {
      background: #00cc99;
      transform: translateY(-2px);
      box-shadow: 0 0 15px #00ffcc88;
    }

    /* Map Section */
    .map {
      margin-top: 2rem;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 0 20px #00ffcc33;
    }

    /* Back Home button */
    .back-home {
      display: inline-block;
      margin: 2rem auto;
      padding: 10px 20px;
      background: #00ffcc;
      color: #000;
      font-weight: bold;
      border-radius: 25px;
      text-decoration: none;
      transition: 0.3s;
      box-shadow: 0 0 10px #00ffcc88;
    }
    .back-home:hover {
      background: #00cc99;
      box-shadow: 0 0 20px #00ffcc;
    }

    @media (max-width: 900px) {
      .contact-container {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>
<body>

<!-- Contact Section -->
<div class="contact-container">
  <!-- Left: Contact Info -->
  <div class="contact-info">
    <h2>Contact Us</h2>
    <p><i class="fas fa-map-marker-alt"></i> Surendranagar, Gujarat, India</p>
    <p><i class="fas fa-envelope"></i> support@gamezone.com</p>
    <p><i class="fas fa-phone"></i> +91 12345 67890</p>

    <div class="social-links">
      <a href="#"><i class="fab fa-facebook"></i></a>
      <a href="#"><i class="fab fa-instagram"></i></a>
      <a href="#"><i class="fab fa-twitter"></i></a>
      <a href="#"><i class="fab fa-discord"></i></a>
      <a href="#"><i class="fab fa-youtube"></i></a>
    </div>
  </div>

  <!-- Right: Contact Form -->
  <form action="send_message.php" method="POST" class="contact-form">
    <input type="text" name="name" placeholder="Your Name" required>
    <input type="email" name="email" placeholder="Your Email" required>
    <input type="text" name="subject" placeholder="Subject" required>
    <textarea name="message" rows="5" placeholder="Your Message" required></textarea>
    <button type="submit">Send Message</button>
  </form>
</div>

<!-- Google Map -->
<div class="map" style="max-width:1200px; margin:0 auto;">
  <iframe 
    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3683.381527586264!2d71.6371!3d22.7271!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395940f1b1b1a3d%3A0x9a6a2d68baf5f0b1!2sSurendranagar%2C%20Gujarat%2C%20India!5e0!3m2!1sen!2sin!4v1672647619876!5m2!1sen!2sin"
    width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy">
  </iframe>
</div>

<!-- Back Home Button -->
<div style="text-align:center;">
  <a href="index.php" class="back-home">← Back Home</a>
</div>

</body>
</html>
