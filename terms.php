<?php
session_start();
include('db/config.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>GameZone | Terms & Conditions</title>
<link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@600;700&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">

<style>
  :root {
    --bg:#0d0d0d; 
    --card:#141414; 
    --text:#e6e6e6; 
    --muted:#aaaaaa;
    --accent:#00ffcc;   /* aqua neon */
    --accent-2:#00ccaa; /* darker aqua */
    --glass:rgba(255,255,255,0.05);
  }

  * {box-sizing:border-box;}
  body {
    margin:0; font-family:'Poppins',sans-serif; background:var(--bg); color:var(--text);
  }
  .wrap {max-width:1100px; margin:40px auto; padding:24px;}
  header.hero {text-align:center; margin-bottom:18px; position:relative;} /* position added for absolute button */
  header .title {
    font-family:'Orbitron'; font-size:2.4rem; color:var(--accent); margin:0;
    text-shadow:0 0 12px rgba(0,255,204,0.6);
  }
  header .subtitle {margin-top:6px; color:var(--muted); font-size:0.96rem;}

  /* Back Home button */
  .back-home {
    position: absolute;
    left: 18px;
    top: 18px;
    display: inline-block;
    padding: 8px 14px;
    border-radius: 8px;
    color: var(--accent);
    background: transparent;
    border: 2px solid var(--accent);
    text-decoration: none;
    font-weight: 600;
    transition: all 0.22s ease;
    box-shadow: 0 0 8px rgba(0,255,204,0.12);
  }
  .back-home:hover {
    background: var(--accent);
    color: #0d0d0d;
    transform: translateY(-3px);
    box-shadow: 0 0 18px rgba(0,255,204,0.9);
  }

  .card {
    background:var(--card); border-radius:12px; padding:20px; margin-bottom:18px;
    box-shadow:0 10px 25px rgba(0,0,0,0.5);
  }
  h2 {
    font-family:'Orbitron'; color:var(--accent-2); font-size:1.05rem; margin:0 0 12px;
    text-shadow:0 0 8px rgba(0,255,204,0.5);
  }
  p, ul {font-size:0.98rem; line-height:1.6;}
  ul {padding-left:18px;}
  li {margin:8px 0;}
  footer.note {text-align:center; color:var(--muted); margin-top:14px; font-size:0.88rem;}
</style>
</head>
<body>
<div class="wrap">
  <header class="hero">
   
    <h1 class="title">GameZone — Terms & Conditions</h1>
    <div class="subtitle">Effective: August 13, 2025</div>
  </header>

  <section class="card">
    <h2>1. Acceptance of Terms</h2>
    <p>By using GameZone, you agree to these Terms & Conditions. If you do not agree, please do not use our platform.</p>

    <h2>2. Accounts</h2>
    <p>Users must provide accurate registration information and keep login details secure. GameZone is not responsible for losses due to compromised accounts.</p>

    <h2>3. Purchases & Payments</h2>
    <p>Orders are subject to product availability. All transactions are processed via secure third-party payment providers. No sensitive payment data is stored on GameZone servers.</p>

    <h2>4. User Conduct</h2>
    <ul>
      <li>No cheating, hacking, or exploiting system bugs.</li>
      <li>No harassment, hate speech, or abusive behavior.</li>
      <li>No distribution of illegal or harmful content.</li>
    </ul>

    <h2>5. Content Ownership</h2>
    <p>All GameZone content, branding, and design elements are protected intellectual property. User-uploaded content remains the property of the user but may be displayed on the platform.</p>

    <h2>6. Termination</h2>
    <p>We reserve the right to suspend or terminate accounts that violate these terms without notice.</p>

    <h2>7. Disclaimers & Liability</h2>
    <p>GameZone is provided "as is" without warranties. We are not responsible for any losses or damages resulting from use of the platform.</p>

    <h2>8. Governing Law</h2>
    <p>These terms are governed by applicable laws in your jurisdiction. Disputes shall be resolved in the appropriate courts.</p>

    <h2>9. Contact</h2>
    <p>For questions, contact us at <a href="mailto:support@gamezone.com" style="color:var(--accent);">support@gamezone.com</a>.</p>
  </section>

  <footer class="note">© 2025 GameZone — All rights reserved.</footer>
</div>
 <a href="index.php" class="back-home" aria-label="Back to home">⬅ Back Home</a>
</body>
</html>
