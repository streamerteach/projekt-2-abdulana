<section class="signup-form">
    <h3>Login</h3>

    <?php
      // Kollar om det finns ett error message (t.ex. fel lösenord)
    if (isset($_SESSION['error_message'])) {

        // Visar felmeddelandet i rött
        print '<p style="color: red;">' . $_SESSION['error_message'] . '</p>';
        // Tar bort meddelandet efter att det visats
        unset($_SESSION['error_message']);
    }
    ?>
    <!-- Login form -->
    <form action="model/model_login.php" method="post">
        <input type="text" name="username" placeholder="Username">
        <input type="password" name="pwd" placeholder="Password">
        <button type="submit">Login</button>
    </form>
    <p>Don't have an account? <a href="signup.php">Signup</a> here.</p>
</section>