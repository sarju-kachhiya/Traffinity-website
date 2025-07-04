<?php
// --- DB Credentials ---
$host = 'localhost';
$dbname = '#';
$username = '#';
$password = '#';

// --- Connect to MySQL ---
$conn = new mysqli($host, $username, $password, $dbname);

// --- Check Connection ---
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// --- Process Form Submission ---
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize POST data
    $first_name   = $conn->real_escape_string($_POST['first_name'] ?? '');
    $last_name    = $conn->real_escape_string($_POST['last_name'] ?? '');
    $company      = $conn->real_escape_string($_POST['company'] ?? '');
    $website      = $conn->real_escape_string($_POST['website'] ?? '');
    $email        = $conn->real_escape_string($_POST['email'] ?? '');
    $phone        = $conn->real_escape_string($_POST['phone'] ?? '');
    $networks     = $conn->real_escape_string($_POST['networks'] ?? '');
    $service      = $conn->real_escape_string($_POST['service'] ?? '');
    $run_marketing = $conn->real_escape_string($_POST['run any online marketing'] ?? '');
    $worked_agency = $conn->real_escape_string($_POST['worked with marketing agency before'] ?? '');

    // Insert query
    $sql = "INSERT INTO marketer_request (
        first_name, last_name, company_name, website, email, phone_number,
        other_networks, service_type, currently_running_marketing, worked_with_agency
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssss",
        $first_name, $last_name, $company, $website, $email, $phone,
        $networks, $service, $run_marketing, $worked_agency
    );

    if ($stmt->execute()) {
        
        ?>
        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/img/Adsala_Favicon.png" rel="icon">
    <title>Request Submitted</title>
    <!-- Tailwind CSS CDN for easy styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom font for a modern look */
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <!-- Main container for the success message, centered on the page -->
    <!-- Card background changed back to white -->
    <div class="bg-white p-8 rounded-xl shadow-lg max-w-md w-full text-center">
        <!-- Logo Container - to make the Adsala logo appear in a circle -->
        <div class="w-32 h-32 rounded-full overflow-hidden flex items-center justify-center mx-auto mb-6 shadow-md" style="background-color: #005751;">
            <!-- Adsala Logo Image -->
            <!-- Updated src to the Adsala logo and adjusted styling to fit within the circle -->
            <img
                src="https://adsala.com/assets/img/AdsalaLogo_White.png"
                alt="Company Logo"
                class="w-full h-full object-contain"
                onerror="this.onerror=null;this.src='https://adsala.com/assets/img/AdsalaLogo_White.png';"
            >
        </div>

        <!-- Success Message -->
        <!-- Text color changed back to dark gray for visibility on white background -->
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Request Submitted! ✅</h1>
        <p class="text-lg text-gray-600 mb-8">
            Your request has been successfully submitted. Our team will contact you within 24-48 hours!
        </p>

        <!-- Home Button -->
        <!-- This button links back to the home page (index.html). Adjust 'index.html' if your home page has a different name. -->
        <a
            href="index.html"
            class="inline-block bg-[#005751] hover:bg-[#004540] text-white font-semibold py-3 px-6 rounded-lg transition duration-300 ease-in-out transform hover:scale-105 shadow-md"
        >
            Go to Home Page
        </a>
    </div>
</body>
</html>

        <?php
        
    } else {
        ?>
        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="assets/img/Adsala_Favicon.png" rel="icon">
    <title>Request Declined</title>
    <!-- Tailwind CSS CDN for easy styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom font for a modern look */
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <!-- Main container for the success message, centered on the page -->
    <!-- Card background changed back to white -->
    <div class="bg-white p-8 rounded-xl shadow-lg max-w-md w-full text-center">
        <!-- Logo Container - to make the Adsala logo appear in a circle -->
        <div class="w-32 h-32 rounded-full overflow-hidden flex items-center justify-center mx-auto mb-6 shadow-md" style="background-color: #005751;">
            <!-- Adsala Logo Image -->
            <!-- Updated src to the Adsala logo and adjusted styling to fit within the circle -->
            <img
                src="https://adsala.com/assets/img/AdsalaLogo_White.png"
                alt="Company Logo"
                class="w-full h-full object-contain"
                onerror="this.onerror=null;this.src='https://adsala.com/assets/img/AdsalaLogo_White.png';"
            >
        </div>

        <!-- Success Message -->
        <!-- Text color changed back to dark gray for visibility on white background -->
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Request Declined! ❌</h1>
        <p class="text-lg text-gray-600 mb-8">
            Your request has been declined. Please try again.
        </p>

        <!-- Home Button -->
        <!-- This button links back to the home page (index.html). Adjust 'index.html' if your home page has a different name. -->
        <a
            href="index.html"
            class="inline-block bg-[#005751] hover:bg-[#004540] text-white font-semibold py-3 px-6 rounded-lg transition duration-300 ease-in-out transform hover:scale-105 shadow-md"
        >
            Go to Home Page
        </a>
    </div>
</body>
</html>


        <?php
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
