<?= $this->extend('frontend/discuss_template'); ?>

<?= $this->section('navigation'); ?>
<?php
foreach ($transaction as $key => $value) { ?>

    <li class="list-group-item <?= $key == 0 ? 'open-chat' : ''; ?> navigation-chat" data-id="<?= $value['transaction_id']; ?>">
        <figure class="avatar avatar-state-success">
            <img src="/uploads/images/<?= $value['teacher_image']; ?>" class="rounded-circle" alt="image">
        </figure>
        <div class="users-list-body">
            <div>
                <h5 class="text-primary"><?= $value['teacher_name']; ?></h5>
                <p><?= teacher_homebase($value['discuss_homebase']); ?></p>
                <!-- <p><?= isset($value['last_chat']['chat_text']) ? $value['last_chat']['chat_text'] : ''; ?></p> -->
            </div>
            <!-- <div class="users-list-action">
                <small class="text-primary"><?= isset($value['last_chat']['chat_date']) ? igDate($value['last_chat']['chat_date']) : ''; ?></small>
            </div> -->
        </div>
    </li>
<?php } ?>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<?php
foreach ($transaction as $key => $value) { ?>
    <div class="chat body-chat <?= $key != 0 ? 'd-none' : ''; ?>" id="body-chat-<?= $value['transaction_id']; ?>">
        <div class="chat-header">
            <div class="chat-header-user">
                <figure class="avatar">
                    <img src="/uploads/images/<?= $value['teacher_image']; ?>" class="rounded-circle" alt="image">
                </figure>
                <div>
                    <h5><?= $value['teacher_name']; ?></h5>
                    <small class="text-success">
                        <i id="online-status">Online</i>
                    </small>
                </div>
            </div>
            <!-- <div class="chat-header-action">
                <ul class="list-inline">
                    <li class="list-inline-item d-xl-none d-inline">
                        <a href="#" class="btn btn-outline-light mobile-navigation-button">
                            <i data-feather="menu"></i>
                        </a>
                    </li>
                </ul>
            </div> -->
        </div>
        <div class="chat-body">
            <div class="messages">
                <?php

                foreach ($value['chat'] as $k => $val) { ?>
                    <div class="message-item <?= !empty($val['student_id']) ? 'outgoing-message' : ''; ?>">
                        <div class="message-avatar">
                            <figure class="avatar">
                                <img src="/uploads/images/<?= !empty($val['student_id']) ? $value['student_image'] : $value['teacher_image']; ?>" class="rounded-circle" alt="image">
                            </figure>
                            <div>
                                <h5><?= !empty($val['student_id']) ? $value['student_name'] : $value['teacher_name']; ?></h5>
                                <div class="time"><?= igDate($val['chat_date']); ?></div>
                            </div>
                        </div>

                        <?php if ($val['chat_type'] == 'text') { ?>
                            <div class="message-content">
                                <?= $val['chat_text']; ?>
                            </div>

                        <?php } else { ?>
                            <figure>
                                <img src="/uploads/images/<?= $val['chat_image']; ?>" class="img-fluid rounded" alt="image" style="max-width: 200px;">
                            </figure>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="chat-footer">
            <form class="form-submit" enctype="multipart/form-data">
                <input type="hidden" name="transaction_id" value="<?= $value['transaction_id']; ?>">
                <input type="text" class="form-control" placeholder="Write a message." name="chat_text">
                <input type="file" name="image" accept="image/*" style="display: none;">
                <div class="form-buttons">
                    <button class="btn btn-light upload" data-toggle="tooltip" title="Add files" type="button">
                        <i data-feather="paperclip"></i>
                    </button>
                    <button class="btn btn-primary" type="submit">
                        <i data-feather="send"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
<?php } ?>
<?= $this->endSection(); ?>