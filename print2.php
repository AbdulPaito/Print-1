<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login";

// Create connection
$connection = mysqli_connect($servername, $username, $password, $dbname);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if 'id' is set and valid
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']); // Ensure the ID is an integer
} else {
    echo "Invalid ID provided.";
    exit;
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

// Check if data was retrieved
if (!$data) {
    die("No data found for ID $id");
}

// Convert comma-separated lists to arrays
$classification = !empty($data['classification']) ? explode(',', $data['classification']) : [];
$disability_type = !empty($data['disability_type']) ? explode(',', $data['disability_type']) : [];
$disability_cause = !empty($data['disability_cause']) ? explode(',', $data['disability_cause']) : [];
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
    <td><label><input type="checkbox" name="classification[]" value="students" <?php echo in_array('students', $data['classification']) ? 'checked' : ''; ?>> Students</label></td>
    <td><label><input type="checkbox" name="classification[]" value="informal_workers" <?php echo in_array('informal_workers', $data['classification']) ? 'checked' : ''; ?>> Informal Workers</label></td>
    <td><label><input type="checkbox" name="classification[]" value="indigenous_people" <?php echo in_array('indigenous_people', $data['classification']) ? 'checked' : ''; ?>> Indigenous People & Cultural Communities</label></td>
</tr>
<tr>
    <td><label><input type="checkbox" name="classification[]" value="out_of_school_youth" <?php echo in_array('out_of_school_youth', $data['classification']) ? 'checked' : ''; ?>> Out-of-School Youth</label></td>
    <td><label><input type="checkbox" name="classification[]" value="industry_workers" <?php echo in_array('industry_workers', $data['classification']) ? 'checked' : ''; ?>> Industry Workers</label></td>
    <td><label><input type="checkbox" name="classification[]" value="disadvantaged_women" <?php echo in_array('disadvantaged_women', $data['classification']) ? 'checked' : ''; ?>> Disadvantaged Women</label></td>
</tr>
<tr>
    <td><label><input type="checkbox" name="classification[]" value="solo_parent" <?php echo in_array('solo_parent', $data['classification']) ? 'checked' : ''; ?>> Solo Parent</label></td>
    <td><label><input type="checkbox" name="classification[]" value="cooperatives" <?php echo in_array('cooperatives', $data['classification']) ? 'checked' : ''; ?>> Cooperatives</label></td>
    <td><label><input type="checkbox" name="classification[]" value="victim_natural_disasters" <?php echo in_array('victim_natural_disasters', $data['classification']) ? 'checked' : ''; ?>> Victim of Natural Disasters and Calamities</label></td>
</tr>
<tr>
    <td><label><input type="checkbox" name="classification[]" value="solo_parent_children" <?php echo in_array('solo_parent_children', $data['classification']) ? 'checked' : ''; ?>> Solo Parent's Children</label></td>
    <td><label><input type="checkbox" name="classification[]" value="family_enterprises" <?php echo in_array('family_enterprises', $data['classification']) ? 'checked' : ''; ?>> Family Enterprises</label></td>
    <td><label><input type="checkbox" name="classification[]" value="victim_trafficking" <?php echo in_array('victim_trafficking', $data['classification']) ? 'checked' : ''; ?>> Victim or Survivor of Human Trafficking</label></td>
</tr>
<tr>
    <td><label><input type="checkbox" name="classification[]" value="senior_citizens" <?php echo in_array('senior_citizens', $data['classification']) ? 'checked' : ''; ?>> Senior Citizens</label></td>
    <td><label><input type="checkbox" name="classification[]" value="micro_entrepreneurs" <?php echo in_array('micro_entrepreneurs', $data['classification']) ? 'checked' : ''; ?>> Micro Entrepreneurs</label></td>
    <td><label><input type="checkbox" name="classification[]" value="drug_dependent_surrenderers" <?php echo in_array('drug_dependent_surrenderers', $data['classification']) ? 'checked' : ''; ?>> Drug Dependent Surrenderers</label></td>
</tr>
<tr>
    <td><label><input type="checkbox" name="classification[]" value="displaced_heis" <?php echo in_array('displaced_heis', $data['classification']) ? 'checked' : ''; ?>> Displaced HEIs Teaching Personnel</label></td>
    <td><label><input type="checkbox" name="classification[]" value="family_members_microentrepreneur" <?php echo in_array('family_members_microentrepreneur', $data['classification']) ? 'checked' : ''; ?>> Family Members of Microentrepreneurs</label></td>
    <td><label><input type="checkbox" name="classification[]" value="rebel_returnees" <?php echo in_array('rebel_returnees', $data['classification']) ? 'checked' : ''; ?>> Rebel Returnees or Decommissioned Combatants</label></td>
</tr>
<tr>
    <td><label><input type="checkbox" name="classification[]" value="displaced_workers" <?php echo in_array('displaced_workers', $data['classification']) ? 'checked' : ''; ?>> Displaced Workers</label></td>
    <td><label><input type="checkbox" name="classification[]" value="farmers_fishermen" <?php echo in_array('farmers_fishermen', $data['classification']) ? 'checked' : ''; ?>> Farmers and Fishermen</label></td>
    <td><label><input type="checkbox" name="classification[]" value="inmates_detainees" <?php echo in_array('inmates_detainees', $data['classification']) ? 'checked' : ''; ?>> Inmates and Detainees</label></td>
</tr>
<tr>
    <td><label><input type="checkbox" name="classification[]" value="tvet_trainers" <?php echo in_array('tvet_trainers', $data['classification']) ? 'checked' : ''; ?>> TVET Trainers</label></td>
    <td><label><input type="checkbox" name="classification[]" value="family_members_farmers_fishermen" <?php echo in_array('family_members_farmers_fishermen', $data['classification']) ? 'checked' : ''; ?>> Family Members of Farmers and Fishermen</label></td>
    <td><label><input type="checkbox" name="classification[]" value="wounded_afp_pnp" <?php echo in_array('wounded_afp_pnp', $data['classification']) ? 'checked' : ''; ?>> Wounded-in-Action AFP & PNP Personnel</label></td>
</tr>
<tr>
    <td><label><input type="checkbox" name="classification[]" value="currently_employed" <?php echo in_array('currently_employed', $data['classification']) ? 'checked' : ''; ?>> Currently Employed Workers</label></td>
    <td><label><input type="checkbox" name="classification[]" value="community_tmg_employment_coordinator" <?php echo in_array('community_tmg_employment_coordinator', $data['classification']) ? 'checked' : ''; ?>> Community TMG & Employment Coordinator</label></td>
    <td><label><input type="checkbox" name="classification[]" value="family_members_afp_pnp_killed_wounded" <?php echo in_array('family_members_afp_pnp_killed_wounded', $data['classification']) ? 'checked' : ''; ?>> Family Members of AFP and PNP Killed-and-Wounded in Action</label></td>
</tr>
<tr>
    <td><label><input type="checkbox" name="classification[]" value="employees_contractual" <?php echo in_array('employees_contractual', $data['classification']) ? 'checked' : ''; ?>> Employees with Contractual/Job-Order Status</label></td>
    <td><label><input type="checkbox" name="classification[]" value="returning_ofw" <?php echo in_array('returning_ofw', $data['classification']) ? 'checked' : ''; ?>> Returning/Repatriated Overseas Filipino Workers</label></td>
    <td><label><input type="checkbox" name="classification[]" value="family_members_inmates_detainees" <?php echo in_array('family_members_inmates_detainees', $data['classification']) ? 'checked' : ''; ?>> Family Members of Inmates and Detainees</label></td>
</tr>
<tr>
    <td><label><input type="checkbox" name="classification[]" value="tesda_alumni" <?php echo in_array('tesda_alumni', $data['classification']) ? 'checked' : ''; ?>> TESDA Alumni</label></td>
    <td><label><input type="checkbox" name="classification[]" value="indigenous_people" <?php echo in_array('indigenous_people', $data['classification']) ? 'checked' : ''; ?>> Indigenous People</label></td>
    <td><label><input type="checkbox" name="classification[]" value="currently_employed" <?php echo in_array('currently_employed', $data['classification']) ? 'checked' : ''; ?>> Currently Employed</label></td>
</tr>



    <tr>
        <th colspan="3">5. Type of Disability (for Persons with Disability Only): To be filled up by the TESDA personnel</th>
    </tr>
    <tr>
        <td><label><input type="checkbox" name="disability_type[]" value="mental_intellectual" <?php echo in_array('mental_intellectual', $data['disability_type']) ? 'checked' : ''; ?>> Mental/Intellectual</label></td>
        <td><label><input type="checkbox" name="disability_type[]" value="visual_disability" <?php echo in_array('visual_disability', $data['disability_type']) ? 'checked' : ''; ?>> Visual Disability</label></td>
        <td><label><input type="checkbox" name="disability_type[]" value="orthopedic" <?php echo in_array('orthopedic', $data['disability_type']) ? 'checked' : ''; ?>> Orthopedic (Musculoskeletal) Disability</label></td>
    </tr>
    <tr>
        <td><label><input type="checkbox" name="disability_type[]" value="hearing_disability" <?php echo in_array('hearing_disability', $data['disability_type']) ? 'checked' : ''; ?>> Hearing Disability</label></td>
        <td><label><input type="checkbox" name="disability_type[]" value="speech_impairment" <?php echo in_array('speech_impairment', $data['disability_type']) ? 'checked' : ''; ?>> Speech Impairment</label></td>
        <td><label><input type="checkbox" name="disability_type[]" value="multiple_disabilities" <?php echo in_array('multiple_disabilities', $data['disability_type']) ? 'checked' : ''; ?>> Multiple Disabilities, specify</label></td>
    </tr>
    <tr>
        <td><label><input type="checkbox" name="disability_type[]" value="psychosocial_disability" <?php echo in_array('psychosocial_disability', $data['disability_type']) ? 'checked' : ''; ?>> Psychosocial Disability</label></td>
        <td><label><input type="checkbox" name="disability_type[]" value="disability_chronic_illness" <?php echo in_array('disability_chronic_illness', $data['disability_type']) ? 'checked' : ''; ?>> Disability Due to Chronic Illness</label></td>
        <td><label><input type="checkbox" name="disability_type[]" value="learning_disability" <?php echo in_array('learning_disability', $data['disability_type']) ? 'checked' : ''; ?>> Learning Disability</label></td>
    </tr>

    <tr>
        <th colspan="3">6. Causes of Disability (for Persons with Disability Only): To be filled up by the TESDA personnel</th>
    </tr>
    <tr>
        <td><label><input type="checkbox" name="disability_cause[]" value="congenital" <?php echo in_array('congenital', $data['disability_cause']) ? 'checked' : ''; ?>> Congenital/Inborn</label></td>
        <td><label><input type="checkbox" name="disability_cause[]" value="illness" <?php echo in_array('illness', $data['disability_cause']) ? 'checked' : ''; ?>> Illness</label></td>
        <td><label><input type="checkbox" name="disability_cause[]" value="injury" <?php echo in_array('injury', $data['disability_cause']) ? 'checked' : ''; ?>> Injury</label></td>
    </tr>

    <tr>
        <th colspan="3">7. Taken NCAE/YP4SC Before?</th>
    </tr>
    <tr>
        <td colspan="3" style="text-align: center;">
            <label><input type="checkbox" name="ncae_taken" value="yes" <?php echo $data['ncae_taken'] === 'yes' ? 'checked' : ''; ?>> Yes</label>
            <label><input type="checkbox" name="ncae_taken" value="no" <?php echo $data['ncae_taken'] === 'no' ? 'checked' : ''; ?>> No</label>
            <input type="text" placeholder="Where:" id="where" name="where" value="<?php echo htmlspecialchars($data['where']); ?>" />
            <input type="text" placeholder="When:" id="when" name="when" value="<?php echo htmlspecialchars($data['when']); ?>" />
        </td>
    </tr>

        <tr>
            <td colspan="3" style="text-align: center;">
                8. Name of Course/Qualification: <input type="text" id="course-qualification" readonly />
            </td>
        </tr>

        <tr>
            <th colspan="3">9. If Scholar, What Type of Scholarship Package (TWSP, PESFA, STEP, others)?</th>
        </tr>
        <tr>
            <td colspan="3">
                9. What Type of Scholarship Package (TWSP, PESFA, STEP, others)?<input type="text" id="scholarship-package" readonly />
            </td>
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
            <td colspan="2" style="text-align: center;">
                <input type="checkbox" /> Agree
            </td>
            <td>
                <input type="checkbox" /> Disagree
            </td>
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
                <input type="text" id="applicant-signature" readonly />
                <label for="date-accomplished">DATE ACCOMPLISHED</label>
                <input type="text" id="date-accomplished" readonly />
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <label for="registrar_signature">REGISTRAR/SCHOOL ADMINISTRATOR:</label>
                <input type="text" id="registrar_signature" name="registrar_signature" />
                <label for="date-received">DATE RECEIVED</label>
                <input type="text" id="date-received" readonly />
            </td>
        </tr>
    </table>

    <table> 
        <tr>
            <td colspan="2" class="picture-box">
                <div class="thumbmark-box">
                    <label for="thumbmark" class="thumbmark-label">Right Thumbmark</label>
                </div>
                <div class="image-box" id="imageBox">
                    <label for="imageUpload" class="file-upload-label">Picture</label>
                </div>
            </td>
        </tr>
    </table>
</body>
</html>
