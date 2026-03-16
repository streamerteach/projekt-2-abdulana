
   
   
<section class="signup-form">
    <h3>Login</h3>
     <!-- Visa felmeddelande om det finns -->
    <?php
    if (isset($_SESSION['error_message'])) {
        print '<p style="color: red;">' . $_SESSION['error_message'] . '</p>';
        // Rensa sessionmeddelandet efter visning
        unset($_SESSION['error_message']);
    }
    ?>
    <form action="model/model_login.php" method="post">
        <input type="text" name="username" placeholder="Username">
        <input type="password" name="pwd" placeholder="Password">
        <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="/echo/signup.php">Signup</a> here.</p>