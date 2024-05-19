<?php include('./header.php'); ?>

<aside class="main-sidebar bg-white elevation-4">
    <div class="dropdown mx-3">
        <a href="" class="brand-link text-dark" data-toggle="dropdown" aria-expanded="true">
            <i class="nav-icon fa fa-laugh-wink fa-lg" style="color: #0C359E;"></i>
            <span class=" font-weight-bold flag-icon-tk" style="color: #0C359E;">SIMPATI</span>

        </a>
    </div>

    <div class="sidebar">
        <nav class="mt-4">
            <ul class="nav nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item dropdown">
                    <a href="./" class="nav-link nav-home text-dark">
                        <span class="nav-icon material-symbols-outlined">
                            dashboard
                        </span>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <?php
                    $sql = $conn->query("SELECT * FROM users WHERE id");
                    $row = $sql->fetch_array();
                    ?>
                    <a href="index.php?page=profile&id=<?= $row['id'] ?>" class="nav-link nav-home text-dark">
                        <span class="nav-icon material-symbols-outlined">
                            person
                        </span>
                        <p>
                            My profile
                        </p>
                    </a>
                </li>
                <?php if ($_SESSION['login_type'] == 1) : ?>
                <li class="nav-item">
                    <a href="#" class="nav-link nav-edit_user text-dark">
                        <span class="nav-icon material-symbols-outlined">
                            group
                        </span>
                        <p>
                            Users
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="./index.php?page=new_user" class="text-dark nav-link nav-new_user tree-item">
                                <i class="fas fa-angle-right nav-icon"></i>
                                <p>Add New</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="./index.php?page=user_list" class="text-dark nav-link nav-user_list tree-item">
                                <i class="fas fa-angle-right nav-icon"></i>
                                <p>List</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <?php
                    if (isset($_SESSION['login_type']) && $_SESSION['login_type'] == 1) {
                    ?>
                <li class="nav-item">
                    <a href="#" class="nav-link nav-is-tree nav-edit_survey text-dark nav-view_survey">
                        <span class="nav-icon material-symbols-outlined">
                            quiz
                        </span>
                        <p>
                            Survey
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="./index.php?page=new_survey" class="text-dark nav-link nav-new_survey tree-item">
                                <i class="fas fa-angle-right nav-icon"></i>
                                <p>Add New</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="./index.php?page=survey_list" class="text-dark nav-link nav-survey_list tree-item">
                                <i class="fas fa-angle-right nav-icon"></i>
                                <p>List</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="./index.php?page=survey_report" class="text-dark nav-link nav-survey_report">
                        <span class="nav-icon material-symbols-outlined">
                            monitoring
                        </span>
                        <p>
                            Survey Report
                        </p>
                    </a>
                </li>
                <?php
                    }
                    ?>
                <?php else : ?>
                <li class="nav-item">
                    <a href="./index.php?page=survey_widget"
                        class="text-dark nav-link nav-survey_widget nav-answer_survey">
                        <i class="nav-icon fas fa-poll-h"></i>
                        <p>
                            Survey List
                        </p>
                    </a>
                </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a href="ajax.php?action=logout" class="nav-link nav-home text-dark">
                        <span class="nav-icon material-symbols-outlined">
                            logout
                        </span>
                        <p>
                            Logout
                        </p>
                    </a>
                </li>
            </ul>
        </nav>

    </div>
</aside>
<script>
$(document).ready(function() {
    var page = '<?php echo isset($_GET['page']) ? $_GET['page'] : 'home' ?>';
    if ($('.nav-link.nav-' + page).length > 0) {
        $('.nav-link.nav-' + page).addClass('active')
        console.log($('.nav-link.nav-' + page).hasClass('tree-item'))
        if ($('.nav-link.nav-' + page).hasClass('tree-item') == true) {
            $('.nav-link.nav-' + page).closest('.nav-treeview').siblings('a').addClass('active')
            $('.nav-link.nav-' + page).closest('.nav-treeview').parent().addClass('menu-open')
        }
        if ($('.nav-link.nav-' + page).hasClass('nav-is-tree') == true) {
            $('.nav-link.nav-' + page).parent().addClass('menu-open')
        }

    }
    $('.manage_account').click(function() {
        uni_modal('Manage Account', 'manage_user.php?id=' + $(this).attr('data-id'))
    })
})
</script>

<!-- <script>
    var timeout = 10000;

    function logoutRedirect() {
        window.location.href = "ajax.php?action=logout";
    }
    var timeoutID;

    function startTimer() {
        timeoutID = setTimeout(logoutRedirect, timeout);
    }

    function resetTimer() {
        clearTimeout(timeoutID);
        startTimer();
    }
    document.addEventListener("DOMContentLoaded", function() {
        startTimer();
        document.addEventListener("mousemove", resetTimer);
        document.addEventListener("keydown", resetTimer);
    });
</script> -->