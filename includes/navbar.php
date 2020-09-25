<nav>
    <div class="w3-blue w3-bar">
        <div class="w3-bar-item">&lambda; Databases Manager</div>
        <div class="w3-bar-item">User: <?php echo $_SESSION['connection']['user'] ?></div>
        <a href="../index.php" class="w3-bar-item w3-button">Home</a>
        <a href="../index.php#work_in_progress" class="w3-bar-item w3-button">Users</a>

        <!--LOGOUT - LAST ITEM-->
        <a href="../login.php?logout=true" class="w3-bar-item w3-button w3-red">Logout</a>
    </div>
</nav>