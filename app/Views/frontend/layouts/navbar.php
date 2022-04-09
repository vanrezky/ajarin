<nav class="navbar navbar-expand-lg navigation" id="navbar">
    <div class="container">
        <a class="navbar-brand" href="/">
            <img src="/assets/images/logo.png" alt="" class="img-fluid" style="max-width: 500px;">
        </a>

        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarmain" aria-controls="navbarmain" aria-expanded="false" aria-label="Toggle navigation">
            <span class="icofont-navigation-menu"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarmain">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="/">Home</a>
                </li>

                <!-- <li class="nav-item"><a class="nav-link" href="/service">Services</a></li> -->
                <!-- <li class="nav-item"><a class="nav-link" href="/contact">Contact</a></li> -->
                <?php
                $level = session('_ci_user_login.level');
                if ($level == 'student' || $level == 'teacher') {

                    if ($level == 'student') {
                        echo '<li class="nav-item"><a class="nav-link" href="/student">List Teacher</a></li>';
                        echo '<li class="nav-item"><a class="nav-link" href="/student/payment/history">History</a></li>';
                    }
                    echo '<li class="nav-item"><a class="nav-link" href="/' . $level . '/profile">Profile</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="/logout">Logout</a></li>';
                } else {

                    echo '<li class="nav-item"><a class="nav-link" href="/appoinment">Sign In</a></li>';
                }

                ?>
            </ul>
        </div>
    </div>
</nav>