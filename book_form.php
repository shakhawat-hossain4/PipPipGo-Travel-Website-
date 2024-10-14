<?php

$connection = mysqli_connect('localhost', 'root', '', 'book_db');

if (isset($_POST['send'])) {
    $name = htmlspecialchars($_POST['name']); // Basic sanitization
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL); // Validate email
    $phone = $_POST['phone'];
    $address = htmlspecialchars($_POST['address']);
    $location = $_POST['location'];
    $guests = $_POST['guests'];
    $arrivals = $_POST['arrivals'];
    $leaving = $_POST['leaving'];

    $request = "INSERT INTO book_form (name, email, phone, address, location, guests, arrivals, leaving) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    try {
        $stmt = mysqli_prepare($connection, $request);
        mysqli_stmt_bind_param($stmt, "ssssssss", $name, $email, $phone, $address, $location, $guests, $arrivals, $leaving);
        mysqli_stmt_execute($stmt);

        $_SESSION['success_message'] = "Room booked successfully.";
        header('location:book.html');

        mysqli_stmt_close($stmt);
    } catch (mysqli_sql_exception $e) {
        echo "Error: " . $e->getMessage();
        // Optionally log the error for further investigation
    }
} else {
    echo 'Something went wrong. Please try again!';
}

mysqli_close($connection); // Close connection
?>