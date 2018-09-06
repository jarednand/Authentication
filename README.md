# Authentication

Author: Jared Nand

Description: Fully functional authentication system which includes the following features: login, registration, password reset, remember me, and authentication with Google and Facebook using the Google and Facebook APIs
    
Technologies Used: HTML5, CSS3, Bootstrap 4, jQuery 3.3.1, PHP 7, PHP PDO for interacting with the database, PHPMailer for sending emails via SMTP, and MySQL
    
To get the project working, make the following changes:
  1. Clone the project
  2. In phpMyAdmin, create a database called Authentication
  3. In phpMyAdmin, import the SQL code found within /Authentication/sql/build-database.php to create the tables you need
  4. Set up developer accounts on Google and Facebook, create a new Authentication project, and generate a Google client id and Facebook App Id
  5. Replace "YOUR_..." within Authentication/includes/constants.php with your own custom values
  6. In Authentication/javascript/social-media-login.js, change the value of google_client_id and facebook_app_id to your own custom values
