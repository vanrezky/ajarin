<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $title; ?> | Ajarin - Find a Corect Answer</title>

    <!-- Favicon -->
    <link rel="icon" href="/user/dist/media/img/icon.png" type="image/png">

    <!-- Bundle Styles -->
    <link rel="stylesheet" href="/user/vendor/bundle.css">

    <link rel="stylesheet" href="/user/vendor/enjoyhint/enjoyhint.css">

    <!-- App styles -->
    <link rel="stylesheet" href="/user/dist/css/app.min.css">
</head>

<body>

    <!-- page loading -->
    <div class="page-loading"></div>
    <!-- ./ page loading -->
    <!-- layout -->
    <div class="layout">

        <!-- navigation -->
        <nav class="navigation">
            <div class="nav-group">
                <ul>
                    <li class="logo">
                        <a href="#">
                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="612px" height="612px" viewBox="0 0 612 612" style="enable-background:new 0 0 612 612;" xml:space="preserve">
                                <g>
                                    <g id="_x32__26_">
                                        <g>
                                            <path d="M401.625,325.125h-191.25c-10.557,0-19.125,8.568-19.125,19.125s8.568,19.125,19.125,19.125h191.25
                                    c10.557,0,19.125-8.568,19.125-19.125S412.182,325.125,401.625,325.125z M439.875,210.375h-267.75
                                    c-10.557,0-19.125,8.568-19.125,19.125s8.568,19.125,19.125,19.125h267.75c10.557,0,19.125-8.568,19.125-19.125
                                    S450.432,210.375,439.875,210.375z M306,0C137.012,0,0,119.875,0,267.75c0,84.514,44.848,159.751,114.75,208.826V612
                                    l134.047-81.339c18.552,3.061,37.638,4.839,57.203,4.839c169.008,0,306-119.875,306-267.75C612,119.875,475.008,0,306,0z
                                    M306,497.25c-22.338,0-43.911-2.601-64.643-7.019l-90.041,54.123l1.205-88.701C83.5,414.133,38.25,345.513,38.25,267.75
                                    c0-126.741,119.875-229.5,267.75-229.5c147.875,0,267.75,102.759,267.75,229.5S453.875,497.25,306,497.25z" />
                                        </g>
                                    </g>
                                </g>
                                <g></g>
                                <g></g>
                                <g></g>
                                <g></g>
                                <g></g>
                                <g></g>
                                <g></g>
                                <g></g>
                                <g></g>
                                <g></g>
                                <g></g>
                                <g></g>
                                <g></g>
                                <g></g>
                                <g></g>
                            </svg>
                        </a>
                    </li>
                    <li>
                        <a class="active" data-navigation-target="chats" href="#" data-toggle="tooltip" title="Chats" data-placement="right">
                            <span class="badge badge-warning"></span>
                            <i data-feather="message-circle"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="dark-light-switcher" data-toggle="tooltip" title="Dark mode" data-placement="right">
                            <i data-feather="moon"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- ./ navigation -->

        <!-- content -->
        <div class="content">

            <!-- sidebar group -->
            <div class="sidebar-group">

                <!-- Chats sidebar -->
                <div id="chats" class="sidebar active">
                    <header>
                        <span>Discussion</span>
                        <ul class="list-inline">
                            <li class="list-inline-item d-xl-none d-inline">
                                <a href="#" class="btn btn-outline-light text-danger sidebar-close">
                                    <i data-feather="x"></i>
                                </a>
                            </li>
                        </ul>
                    </header>
                    <div class="sidebar-body">
                        <ul class="list-group list-group-flush">
                            <?= $this->renderSection('navigation'); ?>
                        </ul>
                    </div>
                </div>
                <!-- ./ Chats sidebar -->

            </div>
            <!-- ./ sidebar group -->

            <!-- chat -->
            <?= $this->renderSection('content'); ?>
            <!-- ./ chat -->
        </div>
        <!-- ./ content -->

    </div>

    <audio id="myAudio">
        <source src="/assets/sound/pling.mp3" type="audio/mpeg">
    </audio>
    <!-- ./ layout -->

    <!-- Bundle -->
    <script src="/user/vendor/bundle.js"></script>

    <script src="/user/vendor/enjoyhint/enjoyhint.min.js"></script>

    <!-- App scripts -->
    <script src="/user/dist/js/app.min.js?v3"></script>

    <!-- Examples -->
    <!-- <script src="/user/dist/js/examples.js"></script> -->
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> -->
    <script>
        const myAudio = document.getElementById("myAudio");

        function playAudio() {
            myAudio.play();
        }

        function pauseAudio() {
            myAudio.pause();
        }
    </script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js"></script>
    <script>
        let global_level = '<?= session('_ci_user_login.level'); ?>';
        let global_id_author = '<?= session('_ci_user_login.id'); ?>';
        // let global_id_student = '<?= session('_ci_user_login.level') == 'student' ? session('_ci_user_login.id') : 'X'; ?>'
        let global_roomId = 123321;
        let global_first_chat_id = '<?= isset($first_trans_id) ? $first_trans_id : ""; ?>';
        var socket = io("https://socket.upp.ac.id:3000", {
            query: {
                roomId: global_roomId,
            },
        });

        socket.on('discussion', function(msg) {
            let body_chat = $("#body-chat-" + msg.transaction_id);
            if (body_chat.length > 0) {
                if (msg.expired) {
                    $message = expired();
                } else {
                    $message = message(msg)
                }

                body_chat.find('.messages').append($message);
                scrollTo(msg.transaction_id);
                if (global_level != msg.level) {
                    playAudio();
                }
            }
            return false;
        });


        function message(msg) {
            let html = `<div class="message-item ` + (global_level == msg.level ? 'outgoing-message' : '') + `">
                    <div class="message-avatar">
                        <figure class="avatar">
                            <img src="/uploads/images/${msg.image}" class="rounded-circle" alt="image">
                        </figure>
                        <div>
                            <h5>${msg.name}</h5>
                            <div class="time">${msg.time}</div>
                        </div>
                    </div>`;
            if (msg.type == 'text') {

                html += `<div class="message-content">
                            ${msg.chat_text}
                        </div>`;

            } else {
                html += `<figure>
                            <img src="/uploads/images/${msg.chat_image}" class="img-fluid rounded" alt="image"  style="max-width: 200px;">
                        </figure>`;
            }

            html += `</div>`;

            return html;
        }

        function expired() {
            return `<div class="message-item">
                        <div class="message-content bg-danger">
                            This discussion has ended
                        </div>
                    </div>`;
        }

        $(document).ready(function() {

            // remove body-style
            setTimeout(() => {
                $(".chat-body").prop("style", "");
                scrollTo(global_first_chat_id);
            }, 100);

            $(".navigation-chat").click(function(e) {
                e.preventDefault();

                let id = $(this).data('id');
                $(".body-chat").addClass('d-none');
                $(".navigation-chat").removeClass('open-chat');

                $(this).addClass("open-chat");
                let d = $("#body-chat-" + id);
                d.removeClass('d-none');
                scrollTo(id);

            });


            $(".form-submit").submit(function(e) {
                e.preventDefault();
                let formData = $(this).serializeArray();

                $.ajax({
                    type: "post",
                    url: "/" + global_level + "/discuss/chat",
                    data: new FormData(this),
                    contentType: false, // The content type used when sending data to the server.
                    cache: false, // To unable request pages to be cached
                    processData: false, // To send DOMDocument or non processed data file
                    dataType: "json",
                    beforeSend: function() {
                        $("[name='chat_text']").val("");
                        $("[name='image']").val("");
                    },
                    success: function(response) {
                        socket.emit('discussion', {
                            roomId: global_roomId,
                            msg: response
                        });

                    }
                });
            });


            $(".upload").click(function(e) {
                e.preventDefault();
                $(this).closest("form").find('[name="image"]').click();
            });

            $('[name="image"]').change(function() {
                $(this).closest('.form-submit').submit();
                console.log('send image');
            });
        });

        function scrollTo(elemt_id) {
            let elemt = $("#body-chat-" + elemt_id + " .messages");

            if (elemt.length > 0) {
                var scrollBottom = Math.max(elemt.height() - $("#body-chat-" + elemt_id + " .chat-body").height(), 0);
                $("#body-chat-" + elemt_id + " .chat-body").scrollTop(scrollBottom);

            }
        }
    </script>
    <?= $this->renderSection('script'); ?>


</body>

</html>