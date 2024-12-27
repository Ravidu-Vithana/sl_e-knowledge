<?php
//REQUIRING DATABASE CONNECTION
require "connection.php";

//CHECKING IF THE DATA ARE RECEIVED PROPERLY
if(isset($_GET["search"])){
    //IF THE DATA ARE RECEIVED PROPERLY

    //START STORING DATA
    $search = $_GET["search"];
    //END STORING DATA

    //START CUSTOM QUERY
    $query = "SELECT * FROM `teacher`";

    if(!empty($search)){
        //IF A NAME IS INSERTED
        $query.= " WHERE `initials` LIKE '".$search."%' OR `first_name` LIKE '".$search."%' OR `last_name` LIKE '".$search."%'";
    }

    $results = Database::search($query);

    if($results->num_rows > 0){
        //IF RESULTS ARE AVAILABLE
        for ($x = 0; $x < $results->num_rows; $x++) {
            $results_data = $results->fetch_assoc();
?>

            <div class="ui row file_item">
                <div class="ui two column stackable grid">
                    <div class="ui ten wide column file_item_name">
                        <div class="ui list">
                            <div class="item">
                                <p class="header"><i class="file pdf outline red icon"></i> <?php echo ($results_data["initials"]." ".$results_data["first_name"]." ".$results_data["last_name"]); ?> (ID : <?php echo ($results_data["teacher_id"]); ?>)</p>
                                <div class="description">(Joined Date : <?php echo ($results_data["joined_date"]); ?>) <?php if($results_data["mobile"] != null){ ?>(Mobile : <?php echo ($results_data["mobile"]); ?>)<?php } ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="ui centered six wide column grid file_item_action">
                        <div class="ui celled horizontal list">
                            <div class="item">
                                <button class="ui <?php if($results_data["status"] == 1){ ?>positive<?php }else{ ?>negative<?php } ?> button" onclick="blockTeacher('<?php echo ($results_data['teacher_id']); ?>')"> <?php if($results_data["status"] == 1){ ?>Active<?php }else{ ?>Blocked<?php } ?></button>
                            </div>
                            <div class="item">
                                <button class="ui primary button" onclick="assignSubjectModal('<?php echo ($results_data['teacher_id']); ?>')">Assign Subject</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php
        }

    }else{
        //IF NO RESULTS AVAILABLE
        ?>

        <!-- empty view -->
        <img src="resources/nothing.jpg" class="ui centered small image">
        <div class="ui centered grid column">
            <p class="nothingText">No Teachers Registered!</p>
        </div>
        <!-- empty view -->
    
    <?php
    }

}

?>