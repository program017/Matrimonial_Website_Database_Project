<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page - BodhiVivah.com</title>
    <style type="text/css">
        /* Global Styles */
        body {
            margin: 0;
            font-family: sans-serif;
            background-color: lightgrey;
        }
        .pga {
            width: 100%;
        }
        .pg {
            display: table;
            width: 50%;
            background-color: #edf9f3;
            margin: auto;
            padding: 20px;
            box-sizing: border-box;
        }
        h4 {
            color: #34495e;
            text-decoration: none;
            font-family: sans-serif;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            padding: 10px 0;
        }
        input[type="text"],
        input[type="password"],
        input[type="date"],
        select {
            width: calc(100% - 10px);
            padding: 5px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-top: 10px;
            cursor: pointer;
            border: none;
            border-radius: 4px;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        label {
            display: inline-block;
            width: 150px;
            font-weight: bold;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="form.css">
</head>
<body>
<div class="pga">
    <?php
    include 'init.php';
    if(logged_in()) {
        header('Location: index.php');
        exit();
    }
    include 'template/header.php';

    if(isset($_POST['email'], $_POST['name'], $_POST['password'], $_POST['city'], $_POST['mob_no'], $_POST['subscribe'])) {
        $email       = $_POST['email'];
        $name        = $_POST['name'];
        $password    = $_POST['password'];
        $city        = $_POST['city'];
        $mob_no      = $_POST['mob_no'];
        $profile     = $_POST['relation'];
        $gender      = $_POST['sex'];
        $religion    = $_POST['religion'];
        $dob         = $_POST['dob'];
        $state       = $_POST['state'];
        
        $errors = array();
        
        // Validation checks
        if(empty($email) || empty($name) || empty($password) || empty($city) || empty($mob_no) || empty($profile) || 
           empty($gender) || empty($religion) || empty($dob) || empty($state)) {
            $errors[] = 'All fields are required';
        } else {
            if(filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                $errors[] = 'Email address is not valid';
            }
            if(strlen($email) > 255 || strlen($name) > 35 || strlen($city) > 35) {
                $errors[] = 'One or more fields contain too many characters';
            }
            if(user_exists($email)) {
                $errors[] = 'That email has already been registered';
            }
            if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
                $errors[] = "Only letters and white space allowed in name";
            }
            if (!preg_match("/^[a-zA-Z ]*$/", $city)) {
                $errors[] = "Only letters and white space allowed in city name";
            }
            if (!preg_match("/^[0-9 ]*$/", $mob_no)) {
                $errors[] = "Only numbers allowed in mobile number";
            }
        }

        // Display errors if any
        if(!empty($errors)) {
            echo '<ul>';
            foreach($errors as $error) {
                echo '<li>'.$error.'</li>';
            }
            echo '</ul>';
        } else {
            // Registration successful
            $register = user_register($profile, $name, $gender, $dob, $religion, $city, $state, $mob_no, $email, $password);
            if($register !== 0) {
                $_SESSION['user_id'] = $register;
                header('Location: index.php');
                exit();
            }
        }
    }
    ?>

    <!-- Registration Form -->
    <div class="pg">
        <form action="" method="post">
            <ul>
                <h4>Take the 1st step to your happy marriage! Register FREE!</h4>
                <li><label>Profile For:</label>
                    <select name="relation" required>
                        <option value="" selected>Select</option>
                        <option value="Myself">Myself</option>
                        <option value="Son">Son</option>
                        <option value="Daughter">Daughter</option>
                        <option value="Brother">Brother</option>
                        <option value="Sister">Sister</option>
                        <option value="Relative">Relative</option>
                        <option value="Friend">Friend</option>
                    </select>
                </li>
                <li><label for="Name">Name:</label>
                    <input type="text" name="name" id="Name" required>
                </li>
                <li><label>Gender:</label>
                    <input type="radio" name="sex" value="Male" required>Male
                    <input type="radio" name="sex" value="Female">Female
                </li>
                <li><label for="dob">DOB:</label>
                    <input type="date" name="dob" id="dob" required>
                </li>
                <li><label>Religion:</label>
                    <select name="religion" required>
                        <option value="" selected>Select</option>
                        <option value="Hindu">Hindu</option>
                        <option value="Muslim-Shia">Muslim-Shia</option>
                        <option value="Muslim-Sunni">Muslim-Sunni</option>
                        <option value="Muslim-Others">Muslim-Others</option>
                        <option value="Christian">Christian</option>
                        <option value="Sikh">Sikh</option>
                        <option value="Jain">Jain</option>
                        <option value="Parsi">Parsi</option>
                        <option value="Buddhist">Buddhist</option>
                        <option value="Inter-Religion">Inter-Religion</option>
                    </select>
                </li>
                <li><label for="city">City:</label>
                    <input type="text" name="city" id="city" required>
                </li>
                <li><label for="states">State:</label>
                    <select name="state" id="stateofresidence">
                        <option value="" selected>Select</option>
                        <!-- Add more options as needed -->
                    </select>
                </li>
                <li><label for="mob_no">Mobile Number:</label>
                    <input type="text" name="mob_no" id="mob_no" required>
                </li>
                <li><label><input type="checkbox" name="subscribe" checked>
                    I have agreed to the <a href="#">Terms & Conditions</a> & have read & understood the <a href="#">Privacy Policy</a>
                </label></li>
                <li><input type="submit" value="Join Now"></li>
            </ul>
        </form>
    </div>

    <?php
    include 'template/footer.php';
    ?>
</div>
</body>
</html>
