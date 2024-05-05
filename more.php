<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Social Awareness Web Application</title>
  <style>
    /* Add your CSS styles here */
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f7f7f7;
    }
    .container {
      max-width: 800px;
      margin: 20px auto;
      padding: 20px;
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    h2 {
      color: #333;
    }
    p {
      color: #666;
    }
    .section {
      margin-bottom: 20px;
    }
    footer {
      background-color: #333;
      color: #fff;
      text-align: center;
      padding: 10px 0;
      position: fixed;
      bottom: 0;
      width: 100%;
      display: none; /* Hide the footer by default */
    }
    .footer-btn {
      background-color: #666;
      color: #fff;
      padding: 8px 16px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      margin: 0 10px;
    }
    .footer-btn:hover {
      background-color: #444;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="section" id="faqs-section">
      <h2>FAQs</h2>
      <p>Access the comprehensive FAQ section to find answers to commonly asked questions and troubleshoot common issues encountered while using the application.</p>
    </div>
    <div class="section" id="contact-support-section">
      <h2>Contact Support</h2>
      <p>If you require further assistance or encounter technical difficulties while using the application, don't hesitate to reach out to our dedicated support team.</p>
      <p>Utilize the contact form provided within the application or send an email to our support address for prompt assistance.</p>
    </div>
    <div class="section" id="user-guides-section">
      <h2>User Guides</h2>
      <p>Explore the extensive collection of user guides, tutorials, and instructional materials available within the application to enhance your understanding of its features and functionalities.</p>
      <p>Follow step-by-step instructions and practical tips to master various aspects of the application and optimize your user experience.</p>
    </div>
    <div class="section" id="feedback-section">
      <h2>Feedback</h2>
      <p>We value your feedback and actively seek input from our users to continuously improve and refine the application.</p>
      <p>Share your suggestions, ideas, or concerns with us through the dedicated feedback form or by sending an email to our feedback address.</p>
      <p>Your feedback helps us identify areas for enhancement and shape the future direction of the application to better meet the needs of our diverse user base.</p>
    </div>
  </div>
  <footer id="footer">
    <button class="footer-btn" id="faqs-btn" onclick="scrollToSection('faqs-section')">FAQs</button>
    <button class="footer-btn" id="contact-support-btn" onclick="scrollToSection('contact-support-section')">Contact Support</button>
    <button class="footer-btn" id="user-guides-btn" onclick="scrollToSection('user-guides-section')">User Guides</button>
    <button class="footer-btn" id="feedback-btn" onclick="scrollToSection('feedback-section')">Feedback</button>
  </footer>

  <script>
    // Function to toggle the visibility of the footer when a section is clicked
    function scrollToSection(sectionId) {
      var section = document.getElementById(sectionId);
      if (section) {
        section.scrollIntoView({ behavior: 'smooth' });
      }
    }

    // Show the footer when the page is scrolled
    window.addEventListener('scroll', function() {
      var footer = document.getElementById('footer');
      if (window.scrollY > 100) {
        footer.style.display = 'block';
      } else {
        footer.style.display = 'none';
      }
    });
  </script>
</body>
</html>
