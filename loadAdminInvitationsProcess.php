<?php
//STARTING THE SESSION
session_start();
//REQUIRING THE DATABASE CONNECTION
require "connection.php";

//CHECKING FOR INVITES SENT BY THE PARTICULAR ADMIN
$sent_rs = Database::search("SELECT * FROM `sent` WHERE `inviter_type` = '4' AND `inviter_id` = '" . $_SESSION["admin"]["admin_id"] . "'");
$sent_num = $sent_rs->num_rows;

if ($sent_num > 0) {
    //IF ANY INVITATIONS ARE SENT

    //LOOPING THROUGH ALL THE RESULTS
    for ($z = 0; $z < $sent_num; $z++) {

        $sent_data = $sent_rs->fetch_assoc();
        $acc_type_rs = Database::search("SELECT * FROM `acc_type` WHERE `id` = '" . $sent_data["acc_type_id"] . "'");
        $acc_type_data = $acc_type_rs->fetch_assoc();

?>

        <div class="ui row invitations">
            <div class="ui grid">
                <div class="ui sixteen wide column">
                    <div class="ui list">
                        <div class="item">
                            <span class="header"><?php echo ("(" . ($z + 1) . ") " . $sent_data["first_name"] . " " . $sent_data["last_name"] . " (" . $acc_type_data["account"]) . ")" ?></span>
                            <div class="description">To: <?php echo ($sent_data["email"] . " (" . $sent_data["datetime"] . ")"); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>

    <?php

    }
} else {
    //IF NO INVITATIONS ARE SENT
    ?>

    <!-- empty view -->
    <img src="resources/nothing.jpg" class="ui centered small image">
    <div class="ui centered grid column">
        <p class="nothingText">Nothing yet...!</p>
    </div>
    <!-- empty view -->

<?php

}

?>