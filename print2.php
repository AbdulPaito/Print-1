<?php
session_start(); // Start the session

// Database connection
$servername = "localhost";
$username = "your_db_username";
$password = "your_db_password";
$dbname = "login"; // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from database based on a specific ID (you might want to adjust the ID or criteria)
$user_id = isset($_GET['id']) ? intval($_GET['id']) : 1; // Default to ID 1 for demonstration
$sql = "SELECT * FROM registration WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

// Close connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
<style>
body {
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 0;
  background-color: #f4f4f4;
}

.container {
  width: 8.5in;
  margin: 0 auto;
  padding: 1in;
  background-color: #fff;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h4 {
  font-size: 16px;
  font-weight: bold;
  margin-bottom: 10px;
}

table {
  width: 100%;
  border-collapse: collapse;
}

th, td {
  padding: 4px; /* Reduced padding */
  border: 1px solid #000000;
  text-align: left;
  font-size: 12px; /* Reduced font size */
}

th {
  background-color: rgb(14, 147, 236);
  text-align: center;
  color: black;
  border-bottom: none;
}

input[type="checkbox"] {
  margin-right: 5px;
}

.signature-section {
  display: flex;
  justify-content: space-between;
  margin-top: 20px;
}

.signature-box {
  width: 45%;
  border: 1px solid #ddd;
  padding: 10px;
}

.signature-box label {
  font-weight: bold;
}

.picture-box {
  padding: 30px;
  display: flex; /* Enables flexbox layout */
  justify-content: space-evenly; /* Distributes space between the boxes */
  align-items: center; /* Centers items vertically */
}

.thumbmark-box {
  padding: 1px;
  border: 1px solid black;
  width: 100px;
  height: 100px;
  text-align: center;
}

.image-box {
  padding: 1px;
  border: 1px solid black;
  width: 100px;
  height: 100px;
  text-align: center;
}

.thumbmark-label, .file-upload-label {
  display: block;
  font-weight: bold;
  color: #007bff;
  position: relative;
  top: 103px;
}
</style>
</head>
<body>
<div class="container">
  <table>
    <tr>
      <th colspan="3">4. Learner/Trainee/Student (Clients) Classification:</th>
    </tr>
    <tr>
      <td><input type="checkbox" <?php echo strpos($data['classification'], 'Students') !== false ? 'checked' : ''; ?>> Students</td>
      <td><input type="checkbox" <?php echo strpos($data['classification'], 'Informal Workers') !== false ? 'checked' : ''; ?>> Informal Workers</td>
      <td><input type="checkbox" <?php echo strpos($data['classification'], 'Indigenous People & Cultural Communities') !== false ? 'checked' : ''; ?>> Indigenous People & Cultural Communities</td>
    </tr>
    <!-- Repeat for other checkboxes -->
    <tr>
      <th colspan="3">5. Type of Disability (for Persons with Disability Only): To be filled up by the TESDA personnel</th>
    </tr>
    <tr>
      <td><input type="checkbox" <?php echo strpos($data['disability'], 'Mental/Intellectual') !== false ? 'checked' : ''; ?>> Mental/Intellectual</td>
      <td><input type="checkbox" <?php echo strpos($data['disability'], 'Visual Disability') !== false ? 'checked' : ''; ?>> Visual Disability</td>
      <td><input type="checkbox" <?php echo strpos($data['disability'], 'Orthopedic (Musculoskeletal) Disability') !== false ? 'checked' : ''; ?>> Orthopedic (Musculoskeletal) Disability</td>
    </tr>
    <!-- Repeat for other checkboxes -->
    <tr>
      <th colspan="3">6. Causes of Disability (for Persons with Disability Only): To be filled up by the TESDA personnel</th>
    </tr>
    <tr>
      <td><input type="checkbox" <?php echo strpos($data['cause_of_disability'], 'Congenital/Inborn') !== false ? 'checked' : ''; ?>> Congenital/Inborn</td>
      <td><input type="checkbox" <?php echo strpos($data['cause_of_disability'], 'Illness') !== false ? 'checked' : ''; ?>> Illness</td>
      <td><input type="checkbox" <?php echo strpos($data['cause_of_disability'], 'Injury') !== false ? 'checked' : ''; ?>> Injury</td>
    </tr>
    <tr>
      <th colspan="3">7. Taken NCAE/YP4SC Before?</th>
    </tr>
    <tr>
      <td colspan="3" style="text-align: center;">
        <input type="checkbox" <?php echo $data['taken_ncae'] == 'Yes' ? 'checked' : ''; ?>> Yes 
        <input type="checkbox" <?php echo $data['taken_ncae'] == 'No' ? 'checked' : ''; ?>> No 
        <input type="text" placeholder="Where:" id="where" name="where" value="<?php echo htmlspecialchars($data['where_ncae']); ?>"> 
        <input type="text" placeholder="When:" id="when" name="when" value="<?php echo htmlspecialchars($data['when_ncae']); ?>">
      </td>
    </tr>
    <tr>
      <td colspan="3" style="text-align: center;">8. Name of Course/Qualification: <input type="text" id="course-qualification" readonly value="<?php echo htmlspecialchars($data['qualification']); ?>"></td>
    </tr>
    <tr>
      <th colspan="3">9. If Scholar, What Type of Scholarship Package (TWSP, PESFA, STEP, others)?</th>
    </tr>
    <tr>
      <td colspan="3">9. What Type of Scholarship Package (TWSP, PESFA, STEP, others)?<input type="text" id="scholarship-package" readonly value="<?php echo htmlspecialchars($data['scholarship']); ?>"></td>
    </tr>
    <tr>
      <th colspan="3">10. Privacy Disclaimer</th>
    </tr>
    <tr>
      <td colspan="3" style="text-align: center;">
        I hereby allow TESDA to use/post my contact details, name, email, cellphone/landline numbers, and other information I provided, which may be used for processing of my scholarship application, employment opportunities, and other purposes.
      </td>
    </tr>
    <tr>
      <td colspan="2" style="text-align: center;"><input type="checkbox" <?php echo $data['privacy_disclaimer'] == 'Agree' ? 'checked' : ''; ?>> Agree</td>
      <td><input type="checkbox" <?php echo $data['privacy_disclaimer'] == 'Disagree' ? 'checked' : ''; ?>> Disagree</td>
    </tr>
    <tr>
      <th colspan="3">11. Applicant's Signature</th>
    </tr>
    <tr>
      <td colspan="3" style="text-align: center;">
        This is to certify that the information stated above is true and correct.
      </td>
    </tr>
    <tr>
      <td colspan="3">
        <label for="applicant-signature">APPLICANT'S SIGNATURE OVER PRINTED NAME</label>
        <input type="text" id="applicant-signature" readonly value="<?php echo htmlspecialchars($data['applicant_signature']); ?>">
        <label for="date-accomplished">DATE ACCOMPLISHED</label>
        <input type="text" id="date-accomplished" readonly value="<?php echo htmlspecialchars($data['date_accomplished']); ?>">
      </td>
    </tr>
    <tr>
      <td colspan="3">
        <label for="registrar_signature">REGISTRAR/SCHOOL ADMINISTRATOR:</label>
        <input type="text" id="registrar_signature" name="registrar_signature" value="<?php echo htmlspecialchars($data['registrar_signature']); ?>">
        <label for="date-received">DATE RECEIVED</label>
        <input type="text" id="date-received" readonly value="<?php echo htmlspecialchars($data['date_received']); ?>">
      </td>
    </tr>
  </table>
  <table> 
    <tr>
      <td colspan="2" class="picture-box">
        <div class="thumbmark-box">
          <label for="thumbmark" class="thumbmark-label">Right Thumbmark</label>
          <!-- Optionally display a thumbmark image -->
        </div>
        <div class="image-box" id="imageBox">
          <label for="imageUpload" class="file-upload-label">Picture</label>
          <img src="<?php echo htmlspecialchars($data['imageUpload']); ?>" alt="Profile Picture" width="100" height="100">
        </div>
      </td>
    </tr>
  </table>
</div>
</body>
</html>
