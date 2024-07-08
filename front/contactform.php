<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&family=Noto+Sans+Display:ital,wght@0,100..900;1,100..900&family=Noto+Sans+Lepcha&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Rubik:ital,wght@0,300..900;1,300..900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../Style/landing.css">
    <title>Contact Us</title>
    <style>
        body {
    font-family: 'Open Sans', sans-serif;
    background-color: #f2f2f2;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 600px;
    margin: 50px auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.container h1 {
    text-align: center;
    color: #333;
}

form {
    margin-top: 20px;
}

label {
    display: block;
    margin-bottom: 5px;
    color: #666;
}

input[type="text"],
input[type="email"],
textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
}

textarea {
    height: 100px;
}

input[type="submit"] {
    background-color: #007bff; /* Blue color */
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

input[type="submit"]:hover {
    background-color: #0056b3; /* Darker shade of blue on hover */
}

#confirmation_message {
    margin-top: 15px;
    text-align: center;
    color: #333;
}

    </style>
</head>
<body>
    <div class="container">
        <h1>Contact us</h1>
        <form method="POST" action="submit_contact_form.php">
            <label for="fullname">Full Name:</label>
            <input type="text" id="fullname" name="fullname" required><br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>
            <label for="subject">Subject:</label>
            <input type="text" id="subject" name="subject" required><br>
            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="4" required></textarea><br>
            <input type="submit" value="Send">
        </form>
        <div id="confirmation_message"></div>
    </div>
</body>
</html>
