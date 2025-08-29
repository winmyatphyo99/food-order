<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo SITENAME; ?></title>
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/main.css">
  
  <style>
body {
    margin: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f0f2f5;
    /* Removed overflow: hidden so content can scroll if needed */
}

.register-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    padding: 20px;
}

.register-container {
    display: flex;
    width: 900px; /* Reduced the overall container width */
    max-width: 100%;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    background: #fff;
    transition: transform 0.3s ease;
}

.register-container:hover {
    transform: translateY(-5px);
}

/* Left image section */
.register-image {
    flex: 1; /* Allows the image to take up available space */
    /* background: url('https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=800&q=80') no-repeat center center; */
    background-size: cover;
    min-width: 300px; /* Ensures the image doesn't disappear on smaller sizes */
}

/* Right form section */
.register-form {
    flex: 1;
    padding: 50px 40px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    max-width: 400px; /* Prevents the form from becoming too wide */
    margin: 0 auto; /* Centers the form content if its narrower */
}

.register-form h2 {
    text-align: center;
    margin-bottom: 30px;
    font-size: 28px;
    color: #1a1a1a;
}

.form-group {
    position: relative;
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    font-weight: 600;
    margin-bottom: 6px;
    color: #333;
}

.form-group input[type="text"],
.form-group input[type="email"],
.form-group input[type="password"] {
    width: 100%;
    padding: 14px 45px 14px 14px;
    border-radius: 8px;
    border: 1px solid #ccc;
    font-size: 15px;
    outline: none;
    transition: 0.3s;
}

.form-group input:focus {
    border-color: #007bff;
    box-shadow: 0 0 8px rgba(0,123,255,0.2);
}

.toggle-password {
    position: absolute;
    right: 15px;
    top: 38px;
    cursor: pointer;
    font-size: 18px;
    color: #888;
    transition: color 0.3s;
}

.toggle-password:hover {
    color: #007bff;
}

.form-group input[type="checkbox"] {
    margin-right: 8px;
}

.form-submit {
    width: 100%;
    padding: 14px;
    background: linear-gradient(90deg, #ff7e5f, #feb47b);
    border: none;
    border-radius: 8px;
    font-size: 16px;
    font-weight: bold;
    color: #fff;
    cursor: pointer;
    transition: transform 0.2s, box-shadow 0.2s;
}

.form-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.text-center {
    text-align: center;
    margin-top: 15px;
    font-size: 14px;
}

.text-center a {
    color: #007bff;
    text-decoration: none;
}

.text-center a:hover {
    text-decoration: underline;
}

/* Responsive */
@media (max-width: 900px) {
    .register-container {
        flex-direction: column;
    }
    .register-image {
        height: 200px;
        /* The image takes the full width of the container */
    }
    .register-form {
        padding: 30px 20px;
        max-width: 100%; /* Ensures the form takes up the full width of the container on smaller screens */
    }
}
</style>
</head>
<body>