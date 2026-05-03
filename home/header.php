

<header class="admin-header">
    <div class="nav container">

        <!-- LOGO -->
        <a href="../home/home.php" class="logo">
            HD <span>Tech</span>
        </a>

        <!-- NAV RIGHT -->
        <div class="nav-right">

            <?php if (isset($_SESSION['usuario_nome'])): ?>
                <div class="user-box">
                    <i class='bx bx-user'></i>
                    <span>
                        <?php echo htmlspecialchars($_SESSION['usuario_nome']); ?>
                    </span>
                </div>

               

            <?php else: ?>
                <a href="../login/login.php">
                    <i class='bx bx-user'></i>
                </a>
            <?php endif; ?>
       
            <i class='bx bx-menu' id="menu-icone"></i>

        </div>

        <a href="../login/logout.php" class="logout-btn">Sair</a>
    </div>
</header>