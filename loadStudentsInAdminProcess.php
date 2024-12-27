<?php
//REQUIRING THE DATABASE CONNECTION
require "connection.php";

//CHECKING IF THE DATA ARE RECEIVED PROPERLY
if(isset($_GET["search"])){
    //IF THE DATA ARE RECEIVED PROPERLY

    //START STORING DATA
    $search = $_GET["search"];
    //END STORING DATA

    //START CUSTOM QUERY CODE
    $query = "SELECT * FROM `student`";

    if(!empty($search)){
        //IF A NAME IS TYPED
        $query.= " WHERE `initials` LIKE '".$search."%' OR `first_name` LIKE '".$search."%' OR `last_name` LIKE '".$search."%'";
    }
    //END OF CUSTOM QUERY CODE
    $results = Database::search($query);

    if($results->num_rows > 0){
        //IF RESULTS ARE AVAILABLE

        //LOOPING THROUGH RESULTS
        for ($x = 0; $x < $results->num_rows; $x++) {
            $results_data = $results->fetch_assoc();
?>

            <div class="ui row file_item">
                <div class="ui two column stackable grid">
                    <div class="ui ten wide column file_item_name">
                        <div class="ui list">
                            <div class="item">
                                <p class="header"><i class="file pdf outline red icon"></i> <?php echo ($results_data["initials"]." ".$results_data["first_name"]." ".$results_data["last_name"]); ?> (ID : <?php echo ($results_data["student_id"]); ?>) (Grade : <?php echo ($results_data["grade"]); ?>)</p>
                                <div class="description">(Joined Date : <?php echo ($results_data["joined_date"]); ?>) <?php if($results_data["mobile"] != null){ ?>(Mobile : <?php echo ($results_data["mobile"]); ?>)<?php } ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="ui centered six wide column grid file_item_action">
                        <div class="ui celled horizontal list">
                            <div class="item">
                                <button class="ui <?php if($results_data["status"] == 1){ ?>positive<?php }else{ ?>negative<?php } ?> button" onclick="blockStudent('<?php echo ($results_data['student_id']); ?>')"> <?php if($results_data["status"] == 1){ ?>Active<?php }else{ ?>Blocked<?php } ?></button>
                            </div>
                            <div class="item">
                                <button class="ui primary button" onclick="gradeModal('<?php echo ($results_data['student_id']); ?>')">Change Grade</button>
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
            <p class="nothingText">No Students Registered!</p>
        </div>
        <!-- empty view -->
    
    <?php
    }

}

?>