<?php
$servername = "localhost";
$username = "nriitac_student";
$password = "College@123456";
$dbname = "nriitac_college";

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the latest 10 job details
$sql = "SELECT * FROM jobs ORDER BY id DESC LIMIT 10";

$result = $conn->query($sql);

// Display the job details
if ($result->num_rows > 0) {
    $jobs = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $jobs = [];
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Latest Job Opportunities</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: url('your-image.jpg') center/cover no-repeat; /* Replace 'your-image.jpg' with the path to your background image */
        }

        .job-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: rgba(255, 255, 255, 0.9); /* Add a background color with transparency */
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .job {
            margin-bottom: 40px;
            padding: 30px;
            background-color: #f9f9f9;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 36px;
            margin-bottom: 30px;
            color: #FFA500; /* Change the heading color */
            text-align: center;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
        }

        h3 {
            margin-bottom: 20px;
            color: #4285f4;
            font-size: 24px;
        }

        p {
            margin: 10px 0;
            color: #555;
        }

        .apply-link {
            background-color: #4285f4;
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            margin-top: 10px;
            border-radius: 4px;
            transition: background-color 0.3s ease;
            box-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
        }

        .apply-link:hover {
            background-color: #ff7f50;
        }

        .no-jobs {
            font-style: italic;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="job-container">
        <h1 style="font-family: 'Arial Black', sans-serif; font-weight: bold;">Latest Job Opportunities</h1>
        <?php if (!empty($jobs)): ?>
            <?php foreach ($jobs as $job): ?>
                <div class="job">
                    <h3><?php echo $job['title']; ?></h3>
                    <p><strong>Company:</strong> <?php echo $job['company']; ?></p>
                    <p><strong>Location:</strong> <?php echo $job['location']; ?></p>
                    <p><?php echo $job['description']; ?></p>
                    <?php if (isset($job['apply_link']) && !empty($job['apply_link'])): ?>
                        <a class="apply-link" href="<?php echo $job['apply_link']; ?>">Apply Now</a>
                    <?php else: ?>
                        <p>No application link provided.</p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="no-jobs">No jobs found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
