<?php
// Database connection setup
$host = 'localhost'; 
$user = 'your_username'; 
$password = 'your_password'; 
$database = 'login'; 

$connection = mysqli_connect($host, $user, $password, $database);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get ID from URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    die("Invalid ID provided.");
}

// Fetch data from database
$query = "SELECT * FROM registration WHERE id = ?";
$stmt = mysqli_prepare($connection, $query);

if (!$stmt) {
    die("Statement preparation failed: " . mysqli_error($connection));
}

mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result) {
    die("Query execution failed: " . mysqli_error($connection));
}

$data = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);
mysqli_close($connection);

if (!$data) {
    die("No data found for ID $id");
}

// Convert the comma-separated list to an array if necessary
$education = !empty($data['educational_attainment']) ? explode(',', $data['educational_attainment']) : [];

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Record</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .print-container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
        }
        h1 {
            text-align: center;
            color: #007bff;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }
        .data-table th, .data-table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .data-table th {
            background-color: #f4f4f4;
        }
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
    <style>
           /* General styles */
           body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
        }

        .page {
            max-width: 800px; /* Adjust maximum width to fit content */
            padding: 10px; /* Reduced padding for better spacing */
            margin: 0 auto; /* Center the div horizontally */
        }

        h2, h3, h4 {
            text-align: center;
            margin-bottom: 5px;
            font-size: 16px; /* Reduced font size */
        }

        p {
            text-align: center;
            margin-top: 0;
            font-size: 14px; /* Reduced font size */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            
        }

        th, td {
            padding: 2px; /* Reduced padding */
            border: 1px solid #000000;
            text-align: left;
            font-size: 12px; /* Reduced font size */
        }

        .box {
            width: 100px;
            height: 80px;
            border: 1px solid black;
            text-align: center;
            font-size: 10px;
            padding: 2px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto; /* sets left and right margins to auto */
        }

        .picture-box {
            text-align: left;
        }

        th {
            background-color: rgb(42, 170, 255);
            text-align: center;
            color: black;
            border-bottom: none;
        }

        tr:nth-child(even) {
            background-color: white;
        }

        input[type="text"] {
            width: calc(100% - px); /* Adjusted width to account for padding and border */
            padding: 2px; /* Reduced padding */
            width: 165px;
            font-size: 12px; /* Reduced font size */
            border: 1px solid black;
        }

        .center {
            text-align: center;
            margin-top: 10px; /* Add margin to separate from the table */
        }

        .center button {
            padding: 5px 10px; /* Reduced padding */
            font-size: 14px; /* Reduced font size */
            background-color: rgb(255, 255, 255);
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease; /* Smooth transition for background color */
        }

        .center button:hover {
            background-color: rgb(14, 147, 236); /* Change background color on hover */
        }
        .text1 {  
         font-weight: bold; /* or use 700 */
        }
        .one{
        border: 1px solid black; /* Adds a solid border with a light gray color */
        color: blue;
        padding: 10px; /* Adds padding inside the container */
        width: 100%; /* Sets the width to 100% of the containing element */
        font-weight: bold; /* or use 700 */
       
    }
    .image {
    max-width: 140px; /* Ensures the image doesn't exceed the width of its container */
    height: 60px; /* Maintains the aspect ratio */
    text-align: center;
  }

    .image img {
        max-width: 100%; /* Ensure the image fits within the container */
        max-height: 100%; /* Ensure the image fits within the container */
        height: auto; /* Maintain aspect ratio */
        width: auto; /* Maintain aspect ratio */
    }
    .italic-text {
    font-style: italic;
    font-weight: bold;
    color: black;
    }
    .tesda{
        text-align: center;
    }
    .r th {
  font-size: 40px; /* Font size */
  padding: 0; /* Remove padding */
  margin: 0; /* Remove margins */
  width: 100%; /* Full width */
  text-align: center; /* Center text */
  text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5); /* Text shadow */
}
.picture-box {
    text-align: center;
    justify-content: center;
    align-items: center;
    height: 100px;
    width: 790px;
    max-height: 150px;

}

.picture-box img {
    width: 150px;
    height: auto;
    max-height: 150px;
}
    </style>
</head>
<body>
    <div class="page">
    <table class="one">
            <tr>
                <td class="image"><img src="TESDA-Logo.png" alt="Logo" class="logo"></td>
                <td class="tesda">Technical Education and Skills Development Authority<br>Pangasiwaan sa Edukasyong Teknikal at Pagpapaunlad ng Kasanayan</td>
                <td><p class="italic-text">MIS 03 - 01<br>(ver.2018)</p></td>
            </tr>
        </table>
        <table class="r">
            <tr>
                <th>Registration Form</th>
            </tr>
        </table>
        <table>
            <tr>
            <td colspan="2" class="picture-box">
                    <?php if (!empty($data['profile_image'])): ?>
                        <img src="<?php echo htmlspecialchars($data['profile_image']); ?>" alt="ID Picture">
                    <?php elseif (!empty($data['profile_image'])): ?>
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($data['profile_image']); ?>" alt="ID Picture">
                    <?php else: ?>
                    <?php endif; ?>
                </td>
                </tr>
                    </table>

                  
                    <table>       
           
            <tr>
                <th colspan="2">1. T2MIS Auto Generated</th>
            </tr>
            <tr>
                <td class="text1">1.1. Unique Learner Identifier (ULI) Number:</td>
                <td><input type="text" value="<?php echo htmlspecialchars($data['uli_number']); ?>" size="20"></td>
            </tr>
            <tr>
                <td class="text1">1.2. Entry Date:</td>
                <td><input type="text" value="<?php echo htmlspecialchars($data['entry_date']); ?>" size="10" placeholder="mm/dd/yy"></td>
            </tr>
            <tr>
                <th colspan="2">2. Learner/Manpower Profile</th>
            </tr>
            <tr>
                <td class="text1">2.1. Name:</td>
                <td>
                    <input type="text" value="<?php echo htmlspecialchars($data['last_name']); ?>" size="15" placeholder="Last Name, Extension Name (Jr., Sr.)">
                    <input type="text" value="<?php echo htmlspecialchars($data['first_name']); ?>" size="15" placeholder="First Name">
                    <input type="text" value="<?php echo htmlspecialchars($data['middle_name']); ?>" size="15" placeholder="Middle Name">
                </td>
            </tr>
            <tr>
                <td class="text1">2.2. Complete Permanent Mailing Address:</td>
                <td>
                    <input type="text" value="<?php echo htmlspecialchars($data['address_number_street']); ?>" size="20" placeholder="Number, Street">
                    <input type="text" value="<?php echo htmlspecialchars($data['address_barangay']); ?>" size="20" placeholder="Barangay">
                    <input type="text" value="<?php echo htmlspecialchars($data['address_district']); ?>" size="20" placeholder="District">
                    <input type="text" value="<?php echo htmlspecialchars($data['address_city_municipality']); ?>" size="20" placeholder="City/Municipality">
                    <input type="text" value="<?php echo htmlspecialchars($data['address_province']); ?>" size="20" placeholder="Province">
                    <input type="text" value="<?php echo htmlspecialchars($data['address_region']); ?>" size="20" placeholder="Region">
                    <input type="text" value="<?php echo htmlspecialchars($data['email_facebook']); ?>" size="20">
                    <input type="text" value="<?php echo htmlspecialchars($data['contact_no']); ?>" size="20">
                    <input type="text" value="<?php echo htmlspecialchars($data['nationality']); ?>" size="20">
                </td>
            </tr>
         <table>  
            <tr>
                <th colspan="3">3. Personal Information</th>
            </tr>
            <tr>
                <td class="text1">3.1. Sex</td>
                <td class="text1">3.2. Civil Status</td>
                <td class="text1">3.3. Employment Status (before the training)</td>
            </tr>
            <tr>
                <td><label><input type="checkbox" name="sex" value="male" <?php echo $data['sex'] === 'male' ? 'checked' : ''; ?>> Male</label></td>
                <td><label><input type="checkbox" name="civil_status" value="single" <?php echo $data['civil_status'] === 'single' ? 'checked' : ''; ?>> Single</label></td>
                <td> <label><input type="checkbox" name="employment_status" value="employed" <?php echo $data['employment_status'] === 'employed' ? 'checked' : ''; ?>> Employed</label></td>
            </tr>
            <tr>
                <td><label><input type="checkbox" name="sex" value="female" <?php echo $data['sex'] === 'female' ? 'checked' : ''; ?>> Female</label></td>
                <td><label><input type="checkbox" name="civil_status" value="married" <?php echo $data['civil_status'] === 'married' ? 'checked' : ''; ?>> Married</label></td>
                <td><label><input type="checkbox" name="employment_status" value="unemployed" <?php echo $data['employment_status'] === 'unemployed' ? 'checked' : ''; ?>> Unemployed</label></td>
            </tr>
            <tr>
                <td></td>
                <td> <label><input type="checkbox" name="civil_status" value="widow" <?php echo $data['civil_status'] === 'widow' ? 'checked' : ''; ?>> Widow/Widower</label></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td><label><input type="checkbox" name="civil_status" value="separated" <?php echo $data['civil_status'] === 'separated' ? 'checked' : ''; ?>> Separated</label></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td><label><input type="checkbox" name="civil_status" value="solo_parent" <?php echo $data['civil_status'] === 'solo_parent' ? 'checked' : ''; ?>> Solo Parent</label></td>
                <td></td>
            </tr>
            
                
                   
            
        </table> 
        <table>
            
           
            <tr>
                <td class="text1">3.4. Birthdate</td>
                <td><input type="text" size="10" placeholder="Month of Birth" value="<?php echo $data['month_of_birth']; ?>"> 
                <input type="text" size="10" placeholder="Day of Birth" value="<?php echo $data['day_of_birth']; ?>"> 
                <input type="text" size="10" placeholder="Year of Birth" value="<?php echo $data['year_of_birth']; ?>">
                <input type="text" size="10" placeholder="Age" value="<?php echo $data['age']; ?>">
                </td>
            </tr>
            <tr>
                <td class="text1">3.5. Birthplace</td>
                <td>
                <input type="text" size="20" placeholder="City/Municipality" 
                    value="<?php echo isset($data['birthplace_city_municipality']) ? htmlspecialchars($data['birthplace_city_municipality']) : ''; ?>"> 
                <input type="text" size="20" placeholder="Province" 
                    value="<?php echo isset($data['birthplace_province']) ? htmlspecialchars($data['birthplace_province']) : ''; ?>"> 
                <input type="text" size="20" placeholder="Region" 
                    value="<?php echo isset($data['birthplace_region']) ? htmlspecialchars($data['birthplace_region']) : ''; ?>">
                </td>
            </tr>
        </table>
        <table>
        <tr>
    <th colspan="4">3.6. Educational Attainment Before the Training (Trainee)</th>
</tr>
<tr>
    <td><label><input type="checkbox" name="educational_attainment[]" value="no_grade_completed" <?php echo $data['educational_attainment'] === 'no_grade_completed' ? 'checked' : ''; ?>> No Grade Completed</label></td>
    <td><label><input type="checkbox" name="educational_attainment[]" value="pre_school" <?php echo $data['educational_attainment'] === 'pre_school' ? 'checked' : ''; ?>> Pre-School (Nursery/Kinder/Prep)</label></td>
    <td><label><input type="checkbox" name="educational_attainment[]" value="high_school_undergraduate" <?php echo $data['educational_attainment'] === 'high_school_undergraduate' ? 'checked' : ''; ?>> High School Undergraduate</label></td>
    <td><label><input type="checkbox" name="educational_attainment[]" value="high_school_graduate" <?php echo $data['educational_attainment'] === 'high_school_graduate' ? 'checked' : ''; ?>> High School Graduate</label></td>
</tr>
<tr>
    <td><label><input type="checkbox" name="educational_attainment[]" value="elementary_undergraduate" <?php echo $data['educational_attainment'] === 'elementary_undergraduate' ? 'checked' : ''; ?>> Elementary Undergraduate</label></td>
    <td><label><input type="checkbox" name="educational_attainment[]" value="post_secondary_undergraduate" <?php echo $data['educational_attainment'] === 'post_secondary_undergraduate' ? 'checked' : ''; ?>> Post Secondary Undergraduate</label></td>
    <td><label><input type="checkbox" name="educational_attainment[]" value="college_undergraduate" <?php echo $data['educational_attainment'] === 'college_undergraduate' ? 'checked' : ''; ?>> College Undergraduate</label></td>
    <td><label><input type="checkbox" name="educational_attainment[]" value="college_graduate_or_higher" <?php echo $data['educational_attainment'] === 'college_graduate_or_higher' ? 'checked' : ''; ?>> College Graduate or Higher</label></td>
</tr>
<tr>
    <td><label><input type="checkbox" name="educational_attainment[]" value="elementary_graduate" <?php echo $data['educational_attainment'] === 'elementary_graduate' ? 'checked' : ''; ?>> Elementary Graduate</label></td>
    <td><label><input type="checkbox" name="educational_attainment[]" value="post_secondary_graduate" <?php echo $data['educational_attainment'] === 'post_secondary_graduate' ? 'checked' : ''; ?>> Post Secondary Graduate</label></td>
    <td><label><input type="checkbox" name="educational_attainment[]" value="junior_high_graduate" <?php echo $data['educational_attainment'] === 'junior_high_graduate' ? 'checked' : ''; ?>> Junior High Graduate</label></td>
    <td><label><input type="checkbox" name="educational_attainment[]" value="senior_high_graduate" <?php echo $data['educational_attainment'] === 'senior_high_graduate' ? 'checked' : ''; ?>> Senior High Graduate</label></td>
</tr>




        </table>

        
        <table>
            <tr>
                <td class="text1">3.7. Father or Mother's Full Name:</td>
                <td><input type="text" value="<?php echo htmlspecialchars($data['parent_guardian_name']); ?>" size="20"></td>
            </tr>
            <tr>
                <td class="text1">Complete Permanent Mailing Address:</td>
                <td><input type="text" value="<?php echo htmlspecialchars($data['parent_guardian_address']); ?>" size="20"></td>
            </tr>
        </table>
        </table>
       
    </div>
    <div class="center">
    <a href="print2.php?id=<?php echo htmlspecialchars($id); ?>">
        <button>Proceed to Page 2</button>
    </a>
</div>
</body>
</html>
