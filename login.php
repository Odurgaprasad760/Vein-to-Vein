<?php
// Include the database connection file
include('db_connection.php');

// Initialize the blood group search term
$blood_group = '';

// Check if the form is submitted with a search term
if (isset($_POST['search'])) {
    // Get the blood group entered by the user
    $blood_group = $_POST['blood_group'];

    // Query the database to search across all blood group fields (t1 to t8)
    $sql = "SELECT username, contact, t1, u1, t2, u2, t3, u3, t4, u4, t5, u5, t6, u6, t7, u7, t8, u8 
            FROM orgindata 
            WHERE t1 = ? OR t2 = ? OR t3 = ? OR t4 = ? OR t5 = ? OR t6 = ? OR t7 = ? OR t8 = ?";

    // Prepare the statement
    $stmt = $conn->prepare($sql);
    // Bind the blood group parameter for all fields
    $stmt->bind_param("ssssssss", $blood_group, $blood_group, $blood_group, $blood_group, $blood_group, $blood_group, $blood_group, $blood_group);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    // Default query to fetch all donors (optional)
    $result = null;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
    <title>Sonu - Blood Donor Search</title>
    <style>
        /* Global Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f7f7f7;
            color: #333;
        }
        
        /* Topbar Styling */
        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #ff5c8d;
            padding: 15px 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .topbar h3 {
            color: #fff;
            font-size: 24px;
        }

        .topbar img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
        }

        /* Search Form */
        .topbar form {
            display: flex;
            align-items: center;
        }

        .topbar input {
            padding: 8px 15px;
            border-radius: 20px;
            border: none;
            width: 250px;
            margin-right: 10px;
            font-size: 16px;
        }

        .topbar button {
            padding: 8px 20px;
            background-color: #4b4bd8;
            border: none;
            border-radius: 20px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        .topbar button:hover {
            background-color: #3e3db3;
        }

        /* Main Content */
        .main-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .jay {
            display: flex;
            justify-content: flex-start;
            background-color: #333;
            padding: 10px;
            margin-bottom: 30px;
            border-radius: 10px;
        }

        .jay select {
            padding: 8px 15px;
            background-color: #d1b6a1;
            border: none;
            border-radius: 20px;
            font-size: 16px;
            cursor: pointer;
        }

        .data-list {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .data-list h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 28px;
            color: #333;
        }

        /* Table Styling */
        .data-list table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .data-list th, .data-list td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }

        .data-list th {
            background-color: #4b4bd8;
            color: #fff;
        }

        .data-list tr:nth-child(even) {
            background-color: #f4f4f4;
        }

        .data-list tr:hover {
            background-color: #e0e0e0;
        }

        .data-list td {
            font-size: 16px;
        }

        .no-data {
            text-align: center;
            color: #888;
            font-size: 18px;
        }

        /* Profile Image */
        .topbar a img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .topbar {
                flex-direction: column;
                align-items: center;
            }

            .topbar form {
                flex-direction: column;
                align-items: center;
            }

            .topbar input {
                width: 200px;
            }

            .jay {
                flex-direction: column;
                align-items: flex-start;
            }

            .jay select {
                margin-top: 10px;
            }

            .data-list table th, .data-list table td {
                padding: 8px;
                font-size: 14px;
            }
        }

    </style>
</head>
<body>
    <div class="topbar">
        <img src="loginimg.png" alt="Logo">
        <h3>VEIN TO VEIN</h3>
        <!-- Search Form -->
        <form method="POST" action="">
            <input type="text" name="blood_group" placeholder="Enter Blood Group" value="<?php echo htmlspecialchars($blood_group); ?>">
            <button type="submit" name="search">Search</button>
        </form>
        <a href="third.html">
            <img src="profile.jpeg" alt="Profile">
        </a>
    </div>

    <div class="main-container">
        <div class="jay">
            <select>
                <option>LOCATION</option>
                <option>RAJAHMUNDRY</option>
                <option>KAKINADA</option>
                <option>TUNI</option>
            </select>
        </div>

        <?php if (isset($_POST['search']) && !empty($blood_group)): ?>
        <div class="data-list">
            <h2>Available Blood Donors</h2>
            <?php if ($result && $result->num_rows > 0): ?>
                <table>
                    <tr>
                        <th>Org Name</th>
                        <th>Contact</th>
                        <th>Blood Type</th>
                        <th>Units Available</th>
                    </tr>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <?php
                        $blood_types = ['t1', 't2', 't3', 't4', 't5', 't6', 't7', 't8'];
                        $units = ['u1', 'u2', 'u3', 'u4', 'u5', 'u6', 'u7', 'u8'];
                        for ($i = 0; $i < 8; $i++) {
                            if ($row[$blood_types[$i]] == $blood_group) {
                                echo "<tr>
                                        <td>{$row['username']}</td>
                                        <td>{$row['contact']}</td>
                                        <td>{$row[$blood_types[$i]]}</td>
                                        <td>{$row[$units[$i]]}</td>
                                      </tr>";
                            }
                        }
                        ?>
                    <?php endwhile; ?>
                </table>
            <?php else: ?>
                <p class="no-data">No data found for the blood group "<?php echo htmlspecialchars($blood_group); ?>"</p>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
