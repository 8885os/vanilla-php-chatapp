<?php
session_start();
include_once 'config.php';

$email = htmlspecialchars($_POST['email']);
$fname = htmlspecialchars($_POST['fname']);
$lname = htmlspecialchars($_POST['lname']);
$password = htmlspecialchars($_POST['password']);

if (!empty($fname) && !empty($lname) && !empty($email) && !empty($password)) {
    $password = password_hash($password, PASSWORD_DEFAULT);
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) { //if email is valid
        //check if email already exists
        $stmt = $pdo->prepare("SELECT email FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            echo "Email already exists!";
        } else {
            if (isset($_FILES['image'])) {
                $image_name = $_FILES['image']['name'];
                $image_type = $_FILES['image']['type'];
                $temp_name = $_FILES['image']['tmp_name']; //used to move file in our folder

                //Explode image and get .extension
                $image_explode = explode('.', $image_name);
                $image_ext = end($image_explode); //get the extension of the user uploaded img file

                $extensions = ['png', 'jpeg', 'jpg']; //valid image extensions
                if (in_array($image_ext, $extensions) === true) {
                    $uuid = uniqid('', true);
                    $new_image_name = $image_explode[0] . $uuid . '.' . $image_ext;
                    if (move_uploaded_file($temp_name, '../images/users/' . $new_image_name)) { //if user upload to our folder is successful
                        $status = "Active now"; //status will be active on sign up
                        $random_id = $uuid;

                        //insert all user data inside table
                        $stmt2 = $pdo->prepare("INSERT INTO users (unique_id,fname,lname,email,password,image,status) VALUES (?,?,?,?,?,?,?)");
                        $stmt2->bindParam(1, $uuid);
                        $stmt2->bindParam(2, $fname);
                        $stmt2->bindParam(3, $lname);
                        $stmt2->bindParam(4, $email);
                        $stmt2->bindParam(5, $password);
                        $stmt2->bindParam(6, $new_image_name);
                        $stmt2->bindParam(7, $status);
                        $stmt2->execute();
                        $stmt3 = $pdo->prepare("SELECT * FROM users WHERE email = :email");
                        $stmt3->bindParam(':email', $email);
                        $stmt3->execute();
                        if ($stmt3->rowCount() > 0) {
                            $row = $stmt3->fetch(PDO::FETCH_ASSOC);
                            $_SESSION['unique_id'] = $row['unique_id'];
                            echo "success";
                        }
                    }
                } else {
                    echo "Please use a correct image format of: png, jpeg or jpg.";
                }
            } else {
                echo "Please select an image file.";
            }
        }
    } else {
        echo "Your email is not valid";
    }
} else {
    echo "All input fields are required!";
}
