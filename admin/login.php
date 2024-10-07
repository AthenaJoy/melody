<?php
    session_start();
    include 'includes/conn.php';

    if(isset($_POST['login'])){
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows < 1){
            $_SESSION['error'] = 'Cannot find account with the provided username';
        }
        else{
            $row = $result->fetch_assoc();
          
                $_SESSION['admin'] = $row['id']; // Set session for admin
                header('location:home.php'); // Redirect to admin dashboard
                exit();
           
        }
        
    }
    else{
        $_SESSION['error'] = 'Input admin credentials first';
    }

    // Redirect back to login page if there are errors
    header('location: index.php');
    exit();
?>
