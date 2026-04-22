<div class="header-footer-container">
    <header>
        <div>
            <h1 class="logo">
                <a href="index.php">The Hub</a>
            </h1>
        </div>
        <nav class="navigation">
            <ul>
                <li class="navigation-link">
                    <a href="talks.php">TALKS</a>
                </li>
                <li class="navigation-link">
                    <a href="wireframes.php">WIREFRAMES</a>
                </li>
                <li class="navigation-link">
                    <a href="credits.php">CREDITS</a>
                </li>

                <?php

                    // header link types according to session state
                    $loginFlag = checkLogin();
                    $navMenuLoggedOut = <<<NAVMENUOUT
                            
                        <li class="login">
                            <a href="login.php"><strong>LOG IN</strong></a>
                        </li>
                        <li class="register">
                            <a href="register.php"><strong>REGISTER</strong></a>
                        </li>
    
    NAVMENUOUT;

                $navMenuLoggedIn = <<<NAVMENUIN
        
                    <li class="navigation-link">
                        <a href="myAccount.php"><strong>MY ACCOUNT</strong></a>
                    </li>
                    <li class="navigation-link">
                        <a href="logout.php">LOG OUT</a>
                    </li>
            
    NAVMENUIN;

                    // set header links display appropriately
                    if (!$loginFlag) {
                        echo $navMenuLoggedOut;
                    }
                    else {
                        echo $navMenuLoggedIn;
                    }

                ?>

            </ul>
        </nav>
    </header>
</div>
