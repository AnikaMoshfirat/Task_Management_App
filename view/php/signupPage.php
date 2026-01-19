<!DOCTYPE html>
<html>
    <head>
        <title>Signup | TM</title>
        <link rel="stylesheet" href="../../asset/css/signupPageStyle.css">
        <link rel="icon" type="image/png" href="../../asset/imgs/icon.png">
    </head>

    <body>
        <form method="post" action="../../controller/signupCheck.php" enctype="multipart/form-data">
            
            <div class="profileBlock">
                <div class="profileHeading">
                    
                    <i><h2 id="upTxt">Sign Up</h2></i>
                    
                    <input type="file" id="uploads" class="dpup" accept="image/*" name="profile_image" required>
                    <img id="imgs" src="../../asset/imgs/defaultImg.png" alt="Profile Img" class="profilePic">
                </div>

                <div class="profileSec">
                    <h3>Personal Information</h3>
                    
                    <div class="profileInfo">
                        
                        <div class="infos">
                            <label for="firstname">First Name</label>
                            <input type="text" id="firstname" name="firstname" 
                                value="<?php echo isset($_POST['firstname']) ? htmlspecialchars($_POST['firstname']) : ''; ?>"
                                placeholder="Enter your first name" required>
                        </div>
                        <div class="infos">
                            <label for="lastname">Last Name</label>
                            <input type="text" id="lastname" name="lastname" 
                                value="<?php echo isset($_POST['lastname']) ? htmlspecialchars($_POST['lastname']) : ''; ?>"
                                placeholder="Enter your last name" required>
                        </div>
                        <div class="infos">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" 
                                value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                                placeholder="Enter your email" required>
                        </div>
                        <div class="infos">
                            <label for="phone">Phone</label>
                            <input type="tel" id="phone" name="phone" 
                                value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>"
                                placeholder="Enter your phone number" required>
                        </div>
                        <div class="infos">
                            <label for="dob">Date of Birth</label>
                            <input type="date" id="dob" name="dob" 
                                value="<?php echo isset($_POST['dob']) ? htmlspecialchars($_POST['dob']) : ''; ?>"
                                required>
                        </div>
                        <div class="infos">
                            <label for="address">Address</label>
                            <input type="text" id="address" name="address" 
                                value="<?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : ''; ?>"
                                placeholder="Enter your address" required>
                        </div>

                        <div class="infos">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" placeholder="Enter your password" required>
                        </div>
                        <div class="infos">
                            <label for="confirm_password">Confirm Password</label>
                            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
                        </div>
                        
                        <div class="infos">
                            <label for="gender">Gender</label>
                            <div class="genderOps">
                                <label class="genders">
                                    <input type="radio" name="gender" value="male" id="male" 
                                        <?php echo (isset($_POST['gender']) && $_POST['gender'] === 'male') ? 'checked' : ''; ?> 
                                        required> Male
                                </label>
                                <label class="genders">
                                    <input type="radio" name="gender" value="female" id="female" 
                                        <?php echo (isset($_POST['gender']) && $_POST['gender'] === 'female') ? 'checked' : ''; ?> 
                                        required> Female
                                </label>
                                <label class="genders">
                                    <input type="radio" name="gender" value="other" id="other" 
                                        <?php echo (isset($_POST['gender']) && $_POST['gender'] === 'other') ? 'checked' : ''; ?> 
                                        required> Other
                                </label>
                            </div>
                        </div>
                        
                    </div>
                    <p id="msg">
                        <?php
                        if (isset($_GET['message'])) {
                            $message = htmlspecialchars($_GET['message']);
                            $message_type = isset($_GET['type']) ? htmlspecialchars($_GET['type']) : 'Error';
                            echo "<span class='" . $message_type . "'>" . $message . "</span>";
                        }
                        ?>
                    </p>
                </div>

                <div class="formButtons">
                    <button type="reset" class="cancel">Cancel</button>
                    <button type="submit" class="submit">Submit</button>
                </div>
            </div>
            
        </form>
        
        <script src="../../asset/js/signup.js"></script>
    </body>
</html>