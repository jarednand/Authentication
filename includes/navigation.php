<div id="side-navigation">
    <a href="javascript:void(0)" id="side-navigation-close-button">&times;</a>
    <?php
        if (isset($_SESSION["user_id"])){
            echo "<a href='logout'>Logout</a>";
        } else {
            echo "<a href='login'>Login</a>";
            echo "<a href='register'>Sign Up</a>";
        }
    ?>
</div>
<div id="navigation-container">
    <div class="container">
        <div class="float-left">
            <a href="/Authentication">
                Authentication
            </a>
        </div>
        <div class="float-right">
            <div id="navigation-links">
            <?php
                if (isset($_SESSION["user_id"])){
                    echo "<a href='logout'>Logout</a>";
                } else {
                    echo "<a href='login'>Login</a>";
                    echo "<a href='register'>Sign Up</a>";
                }
            ?>
            </div>
            <div id="navigation-hamburger-icon">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
        <div class="float-clear"></div>
    </div>
</div>