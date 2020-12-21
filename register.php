<?php 
require_once "config.php";
// define variables and set kit to empty values
$username = $password =
$confirm_password = "";
$username_err = $password_err =
$confirm_password_err ="";
// processing form data when its submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
    // valdate username
    if (empty(trim($_POST["username"]))) {
        $username_err = "please enter a username.";
    } else {
        // prepare a select statememt
$sql = "SELECT id FROM users WHERE username = ?";
if ($stmt = mysqli_prepare($link, $sql)) {
    // bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "s", $param_username);
    // set parameters
    $param_username = trim($_POST["username"]);
    // attempt to execute the prepared statement
    if (mysqli_stmt_execute($stmt)){
        // store result
        mysqli_stmt_store_result($stmt);
        if(mysqli_stmt_num_rows($stmt) == 1){
            $username_err = "This username is already taken.";
        } else {
            $username = trim($_POST["username"]);
        }
    } else {
        echo "Oops, something went wrong. Please try again later.";
    }
    // close statement
    mysqli_stmt_close($stmt);
}
    }
    // validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a passowrd.";
    }
    elseif(strlen(trim($_POST["password"]) < 6)) {
        $password_err = "password must be at least 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }
    
    // validate and confirm password
    if(empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "please confirm password";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "password did not match";
        }
    }
    // check input error before inserting in database
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
        // prepare an insert statement
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        if($stmt = mysqli_prepare($link, $sql)) {
            // bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            // set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT);
        // attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)) {
            // redirect to login page
            header("location:login.php");
        }  else{
            echo "something went wrong. Please try again later.";
        }
    // close statement
    mysqli_stmt_close($stmt);
        }
    }
    // close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up</title>
    <style>
    body{font: 15px sans-serif;}
    .wrapper{width:350px; padding:20px;}
    </style>
</head>
<body>
<div class="wrapper">
        <h3>Sign Up</h3>
        <p>fill out this form to create an account</p>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>">
        <div <?php echo (!empty($username_err)) ? 'has error' : ''; ?>>
        
        <label>Username:</label>
        <input name="username" type = "text" value ="<?php echo $username; ?>">
        <span> <?php echo $username_err;?>
        </span>
        </div>

        <div class =" form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
            <label>Password:</label>
        <input name="password" type = "password" value ="<?php echo $password; ?>">
        <span> <?php echo $password_err;?>
        </span>
                       </div>

                <div class =" form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                    <label name="confirm"> confirm password:</label>
                    <input name="confirm"required placeholder="password ">
                    <span> <?php echo $confirm_password_err;?>
                    </div>  
        <div>
        <input value ="submit" type="submit">
        <input value ="reset" type="reset">
        </div>
        <p> Already have an account? <a href= "login.php"> Login here</a></p>
        </form>
        </div>
        </body>
</html>
