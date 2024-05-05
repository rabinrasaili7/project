<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Feedback - Social Awareness Web Application</title>
  <style>
    /* Add your CSS styles here */
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f7f7f7;
      color: #333;
    }
    .container {
      max-width: 800px;
      margin: 20px auto;
      padding: 20px;
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    h1, h2, h3 {
      color: #333;
    }
    p {
      margin-bottom: 10px;
    }
    label {
      display: block;
      margin-bottom: 8px;
    }
    textarea {
      width: 100%;
      height: 150px;
      padding: 8px;
      margin-bottom: 20px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
    }
    input[type="submit"] {
      background-color: #333;
      color: #fff;
      border: none;
      border-radius: 4px;
      padding: 10px 20px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }
    input[type="submit"]:hover {
      background-color: #555;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Feedback</h1>
    <p>We value your feedback! Please share your suggestions, ideas, or concerns with us:</p>
    <form action="#" method="post">
      <label for="feedback">Feedback:</label>
      <textarea id="feedback" name="feedback" required></textarea>

      <input type="submit" value="Submit">
    </form>
  </div>
</body>
</html>
