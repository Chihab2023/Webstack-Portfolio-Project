<?php get_header();
// Debug: Print the current user's role
//$current_user = wp_get_current_user();
/* global $current_user;
wp_get_current_user();
echo "Current user role: " . implode(', ', $current_user->roles); */

// Move form processing to the top of the file
if (isset($_POST['save_changes']) && check_admin_referer('change_task_owner_control')) {
    $task_id = intval($_POST['task_id']);
    $new_task_owner = intval($_POST['task_owner']);
    $new_task_control = sanitize_text_field($_POST['task_control']);

    // Debug: Print the received values
    echo "<pre>";
    echo "Received task_id: $task_id\n";
    echo "Received new_task_owner: $new_task_owner\n";
    echo "Received new_task_control: $new_task_control\n";
    echo "</pre>";

    // Check if the current user has permission to edit this task
    if (current_user_can('edit_post', $task_id)) {
        // Update task owner
        $update_result = wp_update_post(array(
            'ID' => $task_id,
            'post_author' => $new_task_owner
        ));

        // Update task control
        $meta_result = update_post_meta($task_id, 'task_control', $new_task_control);

        // Debug: Print update results
        echo "<pre>";
        echo "wp_update_post result: " . ($update_result ? "Success" : "Failed") . "\n";
        echo "update_post_meta result: " . ($meta_result ? "Success" : "Failed") . "\n";
        echo "</pre>";

        if ($update_result && $meta_result !== false) {
            echo '<div class="updated"><p>' . __('Task updated successfully.', 'wproject') . '</p></div>';
        } else {
            echo '<div class="error"><p>' . __('Error updating task.', 'wproject') . '</p></div>';
        }
    } else {
        echo '<div class="error"><p>' . __('You do not have permission to edit this task.', 'wproject') . '</p></div>';
    }
}
    $current_user_id            = get_current_user_id();
    $task_id                    = get_the_ID();
    $author_id                  = get_post_field ('post_author', $task_id);
    $user_ID                    = get_the_author_meta( 'ID', $author_id );
    $task_private               = get_post_meta($task_id, 'task_private', TRUE);
    
    $user                       = wp_get_current_user();
    $user_role                  = $user->roles[0];

    if(function_exists('add_client_settings')) {
        $wproject_client_settings   = wProject_client();
        $client_view_others_tasks   = $wproject_client_settings['client_view_others_tasks'];
    } else {
        $wproject_client_settings   = '';
        $client_view_others_tasks   = '';
    }

    /* Don't allow clients access to the task if setting forbids it, but let them if the current user ID matches the task owner ID */
    if($client_view_others_tasks != 'on' && $user_role == 'client' && $current_user_id != $author_id) { ?>
        <body>
            <p>
                <span>
                    <?php _e('Oops! You are not permitted to access tasks that are not yours. Sending you back...', 'wproject'); ?>
                </span>
                <br />
                <img src="<?php echo get_template_directory_uri();?>/images/robot.svg" />
            </p>
            <style>
                body {
                    display: flex;
                    flex-wrap: wrap;
                    justify-content: center;
                    align-items: center;
                    height: 100%;
                    background: #f1f1f1;
                }
                html {
                    height: 100%;
                }
                p {
                    font-family: Arial;
                }
                span {
                    display: block;
                    padding: 20px;
                    background: #fff;
                    border-radius: 100em;
                    position: relative;
                    box-shadow: 7px 7px 20px #ccc;
                }

                span:before {
                    content: '';
                    display: block;
                    width: 0;
                    height: 0;
                    border-style: solid;
                    border-width: 20px 10px 0 10px;
                    border-color: #fff transparent transparent transparent;
                    position: absolute;
                    left: 50px;
                    bottom: -20px;
                }
                img {
                    display: block;
                    width: 100px;
                    height: auto;
                    transform: rotate(-15deg);
                }
				

            </style>
            <script>
                $('header').remove();
                window.setTimeout(function() {
                    window.history.back();;
                }, 5000);
            </script>
        </body>
        
    <?php die; 
    }

    function the_task() {

        $user                           = wp_get_current_user();
        $user_role                      = $user->roles[0];

        $wproject_settings              = wProject(); 
        $show_task_id                   = $wproject_settings['show_task_id'];
        $users_can_task_takeover        = $wproject_settings['users_can_task_takeover'];
        $users_can_claim_task_ownership = $wproject_settings['users_can_claim_task_ownership'];
        $enable_time                    = $wproject_settings['enable_time'];
        $overtime                       = $wproject_settings['overtime'];

        $task_id                        = get_the_ID();
        $date_format                    = get_option('date_format'); 
        $author_id                      = get_post_field ('post_author', $task_id);
        $current_user_id                = get_current_user_id();
        $user_ID                        = get_the_author_meta( 'ID', $author_id );
        $first_name                     = get_the_author_meta( 'first_name', $author_id );
        $last_name                      = get_the_author_meta( 'last_name', $author_id );
        $user_photo                     = get_the_author_meta( 'user_photo', $author_id );

         $categories = get_the_terms( $task_id, 'project' );
		 
        foreach( $categories as $category ) { 
        }
        $project_id = $category->term_id;
            
        if($author_id != '0') {
            if(preg_match("/[a-e]/i", $first_name[0])) {
                $colour = 'a-e';
            } else if(preg_match("/[f-j]/i", $first_name[0])) {
                $colour = 'f-j';
            } else if(preg_match("/[k-o]/i", $first_name[0])) {
                $colour = 'k-o';
            } else if(preg_match("/[p-t]/i", $first_name[0])) {
                $colour = 'p-t';
            } else if(preg_match("/[u-z]/i", $first_name[0])) {
                $colour = 'u-z';
            } else {
                $colour = '';
            }
        }

        if($author_id != '0') {
            if($user_photo) {
                $avatar         = $user_photo;
                $avatar_id      = attachment_url_to_postid($avatar);
                $small_avatar   = wp_get_attachment_image_src($avatar_id, 'thumbnail');
                $avatar         = $small_avatar[0];
                $the_avatar     = '<img src="' . $small_avatar[0] . '" class="avatar" />';
            } else {
                $the_avatar     = '<div class="letter-avatar avatar ' . $colour . '">' . $first_name[0] . $last_name[0] . '</div>';
            }
        } else {
            $the_avatar = '<img src="' . get_template_directory_uri() . '/images/unknown-user.svg' . '" class="avatar" />';
        } 
		
		$localisation_generale  = get_post_meta($task_id, 'localisation_generale', TRUE);
		$sub_localisation_1  = get_post_meta($task_id, 'sub_localisation_1', TRUE);
		$sub_localisation_2  = get_post_meta($task_id, 'sub_localisation_2', TRUE);
		$sub_localisation_3  = get_post_meta($task_id, 'sub_localisation_3', TRUE);
		$sub_localisation_4  = get_post_meta($task_id, 'sub_localisation_4', TRUE);
        $task_job_number        = get_post_meta($task_id, 'task_job_number', TRUE);
        $task_start_date        = get_post_meta($task_id, 'task_start_date', TRUE);
        $task_end_date          = get_post_meta($task_id, 'task_end_date', TRUE);
        $task_time              = get_post_meta($task_id, 'task_time', TRUE);
        $task_timer             = get_post_meta($task_id, 'task_timer', TRUE);
        $task_files             = get_post_meta($task_id, 'task_files', TRUE);
        $task_start_time        = get_post_meta($task_id, 'task_start_time', TRUE);
        $task_description       = get_post_meta($task_id, 'task_description', TRUE);
        $task_milestone         = get_post_meta($task_id, 'task_milestone', TRUE);
        $task_private           = get_post_meta($task_id, 'task_private', TRUE);
        $task_pc_complete       = get_post_meta($task_id, 'task_pc_complete', TRUE);
        $task_relation          = get_post_meta($task_id, 'task_relation', TRUE);
        $task_related           = get_post_meta($task_id, 'task_related', TRUE);
        $task_explanation       = get_post_meta($task_id, 'task_explanation', TRUE);
        $task_status            = get_post_meta($task_id, 'task_status', TRUE );
        $subtask_list           = get_post_meta($task_id, 'subtask_list', TRUE);
        $task_stop_time	        = get_post_meta($task_id, 'task_stop_time', TRUE);
        $task_takeover_request  = get_post_meta($task_id, 'task_takeover_request', TRUE);
        $task_timer             = get_post_meta($task_id, 'task_timer', TRUE);
        $context_label          = get_post_meta($task_id, 'context_label', TRUE);
        $initiator_id           = get_post_meta($task_id, 'initiator_id', TRUE);
        $web_page_url           = get_post_meta( $task_id, 'web_page_url', true );

        if (isset($web_page_url)) {
            $web_page_url = $web_page_url;
            $web_page_url_clean = str_replace(['http://', 'https://'], '', $web_page_url);
        } else {
            $web_page_url = '';
            $web_page_url_clean = '';
        }

        if($task_start_date || $task_end_date) {
            $new_task_start_date     = new DateTime($task_start_date);
            $the_task_start_date     = $new_task_start_date->format($date_format);

            $new_task_end_date       = new DateTime($task_end_date);
            $the_task_end_date       = $new_task_end_date->format($date_format);
        } else {
            $the_task_start_date = '';
            $the_task_end_date   = '';
        }

        $now            = strtotime('today');
        $due_date		= strtotime($task_end_date);

        if($task_start_time) {
            $start_time_date    = new DateTime("@$task_start_time");

            $dt = new DateTime();
            $dt->setTimezone(new DateTimeZone(wp_timezone_string()));
            $dt->setTimestamp($task_start_time);

            $the_start_time     = $dt->format('g:i a');;
        } else {
            $the_start_time     = '';
        }

        $task_priority  = task_priority();

        if($task_private == 'yes') {
            $task_private = __('Private', 'wproject');
            $icon = 'eye-off';
        } else {
            $task_private = __('Everyone', 'wproject');
            $icon = 'eye';
        }
        $categories = get_the_terms( $task_id, 'project' );
    ?>
		<h2 style="text-align: center;">
		<span><?php _e("NRI - Notification et rapport d'inspection", "wproject"); ?></span>
		</h2>
        <!-- <h1><?php echo get_the_title(); ?></h1> !-->

        <?php if($context_label) { ?>
        <span class="context-label"><?php echo trim($context_label); ?></span>
        <?php } ?>

        <?php if($task_takeover_request && $author_id == $current_user_id ) {
            $requester_first_name           = get_the_author_meta( 'first_name', $task_takeover_request );
            $requester_last_name            = get_the_author_meta( 'last_name', $task_takeover_request );
        ?>
            <div class="waiting-notification waiting">
                <form class="transfer-task-ownership" method="post" name="transfer-task-ownership" id="transfer-task-ownership" data-target="transfer_task_ownership" enctype="multipart/form-data">
                    <p>
                        <i data-feather="mail"></i>
                        <?php printf( __('%1$s has requested ownership of this task.', 'wproject'), $requester_first_name . ' ' . $requester_last_name ); ?> 
                        
                        <?php if($task_timer != 'on') { ?>
                        <label class="approve">
                            <input type="radio" name="task_takeover_choice" value="approve" /> <?php _e('Approve', 'wproject'); ?>
                        </label>
                        <?php } else { ?>
                            <span class="message"><?php _e("Can't transfer ownership while recording time", "wproject"); ?></span>
                        <?php } ?>
                        <label class="decline">
                            <input type="radio" name="task_takeover_choice" value="decline" /> <?php _e('Decline', 'wproject'); ?>
                        </label>

                    </p>
                    <input type="hidden" name="requester_id" value="<?php echo $task_takeover_request; ?>" />
                    <input type="hidden" name="task_id" value="<?php echo $task_id; ?>" />
                    <input type="hidden" name="project_name" id="project_name" value="<?php echo $project_name; ?>" />
                    <input type="hidden" name="project_url" id="project_url" value="<?php echo home_url() . '/project/' . $project_url; ?>" />
                </form>
                <script>
                    $('#transfer-task-ownership input').click(function() {
                        setTimeout(function() { 
                            $('#transfer-task-ownership').submit();
                            $('.middle .waiting-notification input').attr('disabled','disabled');
                        }, 250);
                    });
                </script>
            </div>
        <?php } ?>

        <?php // If task is overdue, do something
        if($due_date && $now > $due_date && $task_status !='complete' && $task_status != 'archived') { ?>  
        <?php } ?>

        <?php if($task_relation) { 
            $task_relationship_owner_id     = get_post_field('post_author', $task_related);
            $task_relationship_owner_name   = '<a href="' . home_url() . '/user-profile/?id=' . $task_relationship_owner_id . '">' . get_the_author_meta( 'first_name' , $task_relationship_owner_id ) . ' ' . get_the_author_meta( 'last_name' , $task_relationship_owner_id ) . '</a>'; 
        ?>
            <div class="relation <?php if($task_description) { echo 'mover'; } ?>">
                <p>
                    <i data-feather="alert-triangle"></i>
                    <strong><?php printf( __('This task %1$s', 'wproject'), str_replace('_', ' ', $task_relation)); ?> <a href="<?php echo get_the_permalink($task_related); ?>"><?php echo get_the_title($task_related); ?></a> (<?php echo $task_relationship_owner_name; ?>)</strong>
                </p> 
                <?php if($task_explanation) { ?>
                    <p><?php echo nl2br($task_explanation); ?></p>
                <?php } ?>
            </div>
        <?php } ?>

        <!--/ Start Tabby /-->
        <div class="tabby spacer">

            
        <ul class="tab-nav">
    <li class="expand-all active"><i data-feather="grid"></i></li>
    <li class="task-specs"><?php _e('Details', 'wproject'); ?><i data-feather="list"></i></li>
    <?php if($task_description) { ?>
    <li class="task-description"><?php _e('Description', 'wproject'); ?><i data-feather="align-left"></i></li>
    <?php } ?>
    <?php if($enable_time) { ?>
    <li class="task-time"><?php _e('Time', 'wproject'); ?><i data-feather="clock"></i></li>
    <?php } ?>
    <?php if($user_role == 'administrator' || $user_role == 'inspector') { ?>
    <li class="subtasks"><?php _e("Subtasks", "wproject"); ?><span></span></li>
    <?php } ?>
    <?php 
    $task_control_id = get_post_meta(get_the_ID(), 'task_control', true);
    $current_user = wp_get_current_user();
    $user_role = $current_user->roles[0];
    if ($task_control_id && ($user_role == 'administrator' || $user_role == 'inspector' || $current_user->ID == $task_control_id)) { 
    ?>
    <li class="control-files"><?php _e("Control Files", "wproject"); ?><span></span></li>
    <?php } ?>
    <li class="files"><?php _e("Files", "wproject"); ?><span></span></li>
    <li class="tab-comments"><?php _e("Comments", "wproject"); ?><span></span></li>
	<li class="task-sum"><?php _e('summary', 'wproject'); ?><i data-feather="book"></i></li>
</ul>
            

            <!--/ Start Task Specs Tab Content /-->
            <div class="tab-content tab-content-task-specs active">
			<?php
				function get_task_control_info($task_id) {
					$task_control_id = get_post_meta($task_id, 'task_control', true);
					if ($task_control_id) {
						$user = get_userdata($task_control_id);
						if ($user) {
							return $user->first_name . ' ' . $user->last_name;
						}
					}
					return __('No task control assigned', 'wproject');
				}?>
				<?php
				function get_task_owner_info($task_id) {
					$task_owner_id = get_post_meta($task_id, 'task_owner', true);
					if ($task_owner_id) {
						$user = get_userdata($task_owner_id);
						if ($user) {
							return $user->first_name . ' ' . $user->last_name;
						}
					}
					return __('No task owner assigned', 'wproject');
				}?>
                <!--/ Start Task Specs /-->
                <div class="task-specs">
				
                    
						<li>
							<span><?php _e('Project', 'wproject'); ?>:</span><i data-feather="folder"></i> 
							<?php if($categories !='') {
								foreach( $categories as $category ) { 
									echo '<a href="' . home_url() . '/project/' . $category->slug . '">' . $category->name . '</a>';
								}
							} else {
								_e('No project', 'wproject');
							}
							?>
						</li>
						<li><span><?php _e('ITP No. Réf:', 'wproject'); ?> </span> <i data-feather="alert-circle"></i> <?php echo get_the_title(); ?></li>
						
					

				<!--  <?php if($initiator_id) { ?>
					<li class="initiator-item"><span><?php _e('Initiator', 'wproject'); ?>:</span> 
					
					<?php if($initiator_id == get_current_user_id()) { ?>
						<?php _e("Me", "wproject"); ?>
					<?php } else { ?>
						<a href="<?php echo home_url();?>/user-profile/?id=<?php echo $initiator_id; ?>"><?php echo get_the_author_meta( 'first_name', $initiator_id ); ?> <?php echo get_the_author_meta( 'last_name', $initiator_id ); ?></a>
					<?php } ?>
				<?php } ?>       -->  
					
					<!-- Other task details -->
                        
                           <!-- <?php if($author_id != '0') { ?>

                                <?php if($author_id == get_current_user_id()) { ?>
                                    <?php _e("Me", "wproject"); ?>
                                <?php } else { ?>
                                    <a href="<?php echo get_the_permalink(109); ?>?id=<?php echo $user_ID; ?>"><?php echo $first_name; ?> <?php echo $last_name; ?></a>
                                <?php } ?>


                            <?php } else { ?>

                                <?php if($users_can_claim_task_ownership) { ?>

                                    <?php if($user_role != 'observer') { ?>
                                    <form class="claim-task-form" id="claim-task-form" method="post" data-target="claim_task" enctype="multipart/form-data">
                                        <em class="no-owner" data-task-id="<?php echo $task_id; ?>" data-task-author="<?php echo $current_user_id; ?>" data-task-name="<?php echo get_the_title(); ?>"><?php _e('Adopt', 'wproject'); ?></em>
                                        <input type="hidden" id="no_owner_task_id" name="no_owner_task_id" value="<?php echo $task_id; ?>" />
                                        <input type="hidden" id="no_owner_task_name" name="no_owner_task_name" value="<?php echo get_the_title(); ?>" />
                                    </form>
                                    <?php } else {
                                        _e('Nobody', 'wproject');
                                    } ?>

                                <?php } else { ?>
                                    <?php _e('Unowned task', 'wproject'); ?>
                                <?php } ?>

                            <?php } ?>!-->
                        </li>
						

                        <?php if($task_timer == 'on') { ?>
                            <li><span><?php _e('Time', 'wproject'); ?>:</span> <?php printf( __('%1$s is recording time (since %2$s).', 'wproject'), $first_name, $the_start_time ); ?></li>
                        <?php } ?>

                        
                        
                        <li><span><?php _e('Date created', 'wproject'); ?>:</span><i data-feather="calendar"></i>  <?php echo get_the_date(); ?></li>
                        <li><span><?php _e('Priority', 'wproject'); ?>:</span>  <?php echo $task_priority['name']; ?></li>
                        <li><span><?php _e('localisation General', 'wproject'); ?>:</span> <?php echo $localisation_generale; ?></li>
						<li><span><?php _e('Sub localisation 1', 'wproject'); ?>:</span>  <?php echo $sub_localisation_1; ?></li>
						
						<li><span><?php _e('Sub localisation 2', 'wproject'); ?>:</span>  <?php foreach ($sub_localisation_2 as $key => $value) {echo "- $value <br>";} ?></li>
						<li><span><?php _e('Sub localisation 3', 'wproject'); ?>:</span>  <?php foreach ($sub_localisation_3 as $key => $value) {echo "- $value <br>";} ?></li>
						<li><span><?php _e('Sub localisation 4', 'wproject'); ?>:</span>  <?php foreach ($sub_localisation_4 as $key => $value) {echo "- $value <br>";} ?></li>
                        <?php if($task_start_date && $task_end_date) { ?>
                        <li class="dates">
                            <span><?php _e('Date prévu d\'inspection', 'wproject'); ?>:</span><?php echo $the_task_start_date; ?>
                        </li>
                        <?php } ?>
                        
                        <?php if($task_job_number) { ?>
                        <li><span><?php _e('Job #', 'wproject'); ?>:</span>  <?php echo $task_job_number; ?></li>
                        <?php } ?>
                        <li><span><?php _e('Visibility', 'wproject'); ?>:</span>  <?php echo $task_private; ?></li>

                        <?php if($task_milestone  == 'yes') { ?>
                        <li><span><?php _e('Milestone', 'wproject'); ?>:</span>  <?php _e('Yes', 'wproject'); ?></li>
                        <?php } ?>

                        <?php if($task_pc_complete) { ?>
                        <li><span><?php _e('% Complete', 'wproject'); ?>:</span>  <?php echo $task_pc_complete; ?><?php _e('%', 'wproject'); ?></li>
                        <?php } ?>
                        <?php if($context_label) { ?>
                        <li><span><?php _e('Context', 'wproject'); ?>:</span>  <?php echo trim($context_label); ?></li>
                        <?php } ?>

                        <?php if($show_task_id) { ?>
                        <li>
                            <span><?php _e('ID', 'wproject'); ?>:</span>  

                            <?php if($user_role == 'administrator'  || $user_role == 'inspector') { ?>
                                <a href="<?php echo admin_url(); ?>post.php?post=<?php echo $task_id; ?>&action=edit"><?php echo $task_id; ?></a>
                            <?php } else { ?>
                                <?php echo $task_id; ?>
                            <?php } ?>
                            
                        </li>
                        <?php } ?>

                        <?php if($user_role !='client') {
                            if($web_page_url) { ?>
                        <li>
                            <span><?php _e('Web page', 'wproject'); ?>:</span>  

                            <a href="<?php echo $web_page_url; ?>">
                                <?php echo rtrim($web_page_url_clean, '/'); ?>
                            </a>  
                        </li>
                        <?php }
                        } ?>

                   
                </div>
                <!--/ End Task Specs /-->
				
            </div>
            <!--/ End Task Specs Tab Content /-->

            <?php if($task_description) { ?>
            <!--/ Start Task Description /-->
            <div class="tab-content tab-content-task-description active">
                <p class="task-description"><?php echo make_clickable(nl2br($task_description)); ?></p>
            </div>
            <!--/ End Task Description /-->
            <?php } ?>

            <?php if($enable_time) { ?>
            <!--/ Start Time Tab Content /-->
            <div class="tab-content tab-content-task-time active">

                <!--/ Start Time /-->
                <div class="task-specs">

                    <form class="edit-time-form" method="post" data-target="delete_time" id="edit-time-form" enctype="multipart/form-data">
                        <ul>
                            
                                <li class="time-header">
                                    <span><?php _e('Contributor', 'wproject'); ?></span>
                                    <span><?php _e('Time', 'wproject'); ?></span>
                                    <span><?php _e('Date', 'wproject'); ?></span>
                                    <span class="span-2"><?php _e('Action', 'wproject'); ?></span>
                                </li>
                                <?php 
                                    global $wpdb;
                                    $tablename = $wpdb->prefix.'time';
                                    $query = "
                                        SELECT * 
                                        FROM $tablename 
                                        ORDER BY `date` DESC
                                    ";
                                    $result = $wpdb->get_results($query);
                                    foreach ($result as $data) {

                                        $time_user      = get_userdata( $data->user_id );

                                        /* User */
                                        $first_name     = $time_user->first_name;
                                        $last_name      = $time_user->last_name;
                                        $user_photo     = $time_user->user_photo;
                                        $user_role      = $time_user->roles[0];

                                        if(preg_match("/[a-e]/i", $first_name[0])) {
                                            $colour = 'a-e';
                                        } else if(preg_match("/[f-j]/i", $first_name[0])) {
                                            $colour = 'f-j';
                                        } else if(preg_match("/[k-o]/i", $first_name[0])) {
                                            $colour = 'k-o';
                                        } else if(preg_match("/[p-t]/i", $first_name[0])) {
                                            $colour = 'p-t';
                                        } else if(preg_match("/[u-z]/i", $first_name[0])) {
                                            $colour = 'u-z';
                                        } else {
                                            $colour = '';
                                        }

                                        if($user_photo) {
                                            $avatar         = $user_photo;
                                            $avatar_id      = attachment_url_to_postid($avatar);
                                            $small_avatar   = wp_get_attachment_image_src($avatar_id, 'thumbnail');
                                            $avatar         = $small_avatar[0];
                                            $the_avatar     = '<img src="' . $small_avatar[0] . '" class="avatar" />';
                                        } else {
                                            $the_avatar     = '<div class="letter-avatar avatar ' . $colour . '">' . $first_name[0] . $last_name[0] . '</div>';
                                        }

                                        $id             = $data->id;
                                        

                                        /* Date */
                                        $date           = $data->date;
                                        $date_format    = get_option('date_format'); 
                                        $timestamp      = strtotime($date);
                                        $date_logged	= date($date_format, $timestamp);

                                        /* Time */
                                        $time           = $data->time_log;
                                        $hours          = floor($time / 3600);
                                        $minutes        = floor(($time / 60) % 60);
                                        $seconds        = $time % 60;

                                        /* If the actual task ID matches the task ID in the 'time' table */
                                        if($data->task_id == $task_id ) { ?>
                                        <li data-log-id="<?php echo $id; ?>">
                                        <span class="col-avatar">
                                            <?php echo $the_avatar; ?>
                                            <a href="<?php echo home_url();?>user-profile/?id=<?php echo $data->user_id; ?>">
                                                <?php echo $first_name; ?> <?php echo $last_name; ?>
                                            </a>
                                        </span>
                                        <span class="time" data-hrs="<?php echo $hours; ?>" data-mins="<?php echo $minutes; ?>" data-secs="<?php echo $seconds; ?>" data-time-log="<?php echo $data->time_log; ?>" data-time-id="<?php echo $id; ?>">
                                            <?php printf("%02d:%02d:%02d", $hours, $minutes, $seconds); ?>
                                            <?php if($overtime) {
                                            if(ceil($time / 3600) > $overtime) { ?>
                                                <i class="overtime">
                                                    <i data-feather="alert-triangle"></i>
                                                    <span class="pop"><?php _e('Did you forgot to stop time?', 'wproject'); ?></span>
                                                </i>
                                            <?php }
                                         }?>
                                        </span>
                                        <span class="col-date">
                                            <?php echo $date_logged; ?>
                                        </span>

                                        <?php if($current_user_id == $author_id) { ?>
                                            <span class="edit-time" data-project-id="<?php echo $project_id; ?>" data-task-time="<?php echo $time; ?>" data-time-id="<?php echo $id; ?>" data-time-id="<?php echo $id; ?>" title="<?php _e('Edit time', 'wproject'); ?>">
                                                <i data-feather="edit-3"></i>
                                            </span>
                                            <span class="delete-time" data-id="<?php echo $data->id; ?>" data-project-id="<?php echo $project_id; ?>" data-task-time="<?php echo $time; ?>" data-time-id="<?php echo $id; ?>" data-time-in-seconds="<?php echo $time; ?>" title="<?php _e('Delete time', 'wproject'); ?>">
                                                <i data-feather="x"></i>
                                            </span>
                                        <?php } else { ?>
                                            <span class="edit-time not-allowed"><i data-feather="edit-3"></i></span>
                                            <span class="delete-time not-allowed"><i data-feather="x"></i></span>
                                        <?php } ?>
                                    </li>
                                <?php } 
                                } ?>
                                <li class="time-footer">
                                    <span><?php _e('Total', 'wproject'); ?>: </span>
                                    <span>
                                        <i class="the-time" data-project-time="<?php echo get_term_meta($category->term_id, 'project_total_time', TRUE); ?>">
                                            <?php project_time(); ?>
                                        </i>
                                    </span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </li>

                            
                        </ul>
                        <?php if($current_user_id == $author_id) { ?>
                        <input type="hidden" class="time-id" name="time-id" id="time-id" value="" />
                        <input type="hidden" class="project-id" name="project-id" id="project-id" value="" />
                        <input type="hidden" class="edit-time" name="edit-time" id="edit-time" value="" />
                        <input type="hidden" class="time-in-seconds" name="time-in-seconds" id="time-in-seconds" value="" />
                        <input type="hidden" class="task-id" name="task-id" id="task-id" value="<?php echo $task_id; ?>" />
                        <?php } ?>
                    </form>
                </div>
                
                <script>
                    <?php if($current_user_id == $author_id) { ?>
                    <?php if($task_timer == 'on' && $current_user_id == $author_id ) { ?>
                    $( document ).ready(function() {
                        /* Switch focus to timer tab */
                        // $('.tab-nav li').removeClass('active');
                        // $('.tab-nav .task-time').addClass('active');

                        // $('.tab-content').removeClass('active');
                        // $('.tab-content-task-time').addClass('active');

                        /* Insert row */
                        var the_time = $('body .timer-ui .task-time em').text();
                        var time_user_name = $('.current-user-data').data('name');
                        var time_avatar = $('.current-user-data').data('avatar');
                        var time_date = $('.current-user-data').data('date');
                        var avatar_style = $('.current-user-data').data('avatar-style');
                        $('<li class="inserted"><span class="col-avatar"><img src="'+time_avatar+'" class="avatar ' + avatar_style + '" />'+time_user_name+'</span><span class="time"><?php _e("Recording", "wproject"); ?></span><span class="col-date">'+time_date+'</span><span class="delete-time"></span></li>').insertAfter('.time-header');
                    });
                    <?php } ?>
                    $('body').on('click', '.delete-time', function() {
                        if (confirm('<?php _e('Delete this time entry?', 'wproject'); ?>')) {

                            /* Change this hidden field to 'no' so the form doesn't get processed as a time edit */
                            $('input.edit-time').val('');

                            var time_id                 = $(this).data('time-id');
                            var project_id              = $(this).data('project-id');
                            var time_to_delete          = $(this).data('task-time');
                            var task_time_in_seconds    = $(this).data('time-in-seconds');
                            var project_time            = $('.the-time').data('project-time');
                            var reduced_time            = project_time - task_time_in_seconds;
                            //console.log(project_time);

                            var totalNumberOfSeconds = reduced_time;
                            var hours = parseInt( totalNumberOfSeconds / 3600 );
                            var minutes = parseInt( (totalNumberOfSeconds - (hours * 3600)) / 60 );
                            var seconds = Math.floor((totalNumberOfSeconds - ((hours * 3600) + (minutes * 60))));
                            /* Formatting with leading zeros */
                            var result = (hours < 10 ? "0" + hours : hours) + ":" + (minutes < 10 ? "0" + minutes : minutes) + ":" + (seconds  < 10 ? "0" + seconds : seconds);

                            //var limited_projects_list_count = $('.task-specs li').length;

                            $('input#time-id').val(time_id);
                            $('input#project-id').val(project_id);
                            $('input#time-in-seconds').val(time_to_delete);

                            /* Add class to emphasise that we are deleting a time entry */
                            $('.edit-time-form li .delete-time').addClass('deleting-in-progress');

                            $(this).closest('li').css('text-decoration', 'line-through').fadeOut();
                            
                            setTimeout(function() { 

                                $('.the-time').data('project-time', reduced_time); 

                                /* Update the-time element with the new reduced time */
                                //$('.the-time').text(result); 

                                $('#edit-time-form').submit();
                            }, 500);
                        }
                    });
                    
                    $('.edit-time').click(function() {

                        /* Initilly hide all edit-time-fields */
                        $('.edit-time-fields').hide();

                        /* Initilly show all logged time */
                        $('.edit-time-form li .time').show();

                        /* Initially remove this class to prevent highlighting row */
                        $('.edit-time-form li').removeClass('editing');

                        /* ...and hide the closest .time element to the edit icon that was selected */
                        $(this).closest('li').find('.time').hide();

                        /* Add value to hidden field so we know how to process the form */
                        $('input.edit-time').val('yes');

                        /* Initially remmove all time edit fields */
                        $('.edit-time-form li input').remove();

                        /* Insert the project ID into the hidden field */
                        $('input#project-id').val('<?php echo sanitize_text_field($project_id); ?>');

                        var hrs         = $(this).closest('li').find('.time').data('hrs');
                        var mins        = $(this).closest('li').find('.time').data('mins');
                        var secs        = $(this).closest('li').find('.time').data('secs');
                        var time_id     = $(this).closest('li').find('.time').data('time-id');
                        var save        = '<em class="save"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check feather-icon" color="#ff9800"><polyline points="20 6 9 17 4 12"></polyline></svg></em>';
                        
                        $('input#time-id').val(time_id);

                        /* Add class to emphasise that we are editing a time entry */
                        $(this).closest('li').addClass('editing');

                        /* Spawn time editing fields with data */
                        $(this).closest('li').find('.time').after('<span class="edit-time-fields"><input type="number" name="edit-time-hours" value="'+hrs+'" placeholder="<?php _e('Hrs', 'wproject'); ?>" min="0" max="<?php if($overtime) { echo $overtime; } else { echo '24'; } ?>" /><input type="number" name="edit-time-mins" value="'+mins+'" placeholder="<?php _e('Mins', 'wproject'); ?>" min="0" max="60" />'+save+'</span>');
                    });

                    /* Save time */
                    $('body').on('click', '.save', function() {
                        setTimeout(function() { 
                            $('#edit-time-form').submit();
                        }, 250);
                    });

                    /* Close the edit task row when clicking outside of it */
                    $(document).mouseup(function(e)  {
                        var container = $('.edit-time-form ul .editing');

                        // if the target of the click isn't the container nor a descendant of the container
                        if (!container.is(e.target) && container.has(e.target).length === 0)  {
                            container.removeClass('editing');
                            $('.edit-time-fields').hide();
                            $('input.edit-time').val('');
                            $('.time').show();
                        }
                    });
                    <?php } ?>
                </script>
                
                <!--/ End Time /-->

            </div>
            <!--/ End Time Tab Content /-->
            <?php } ?>

            <!--/ Start Subtasks Tab Content /-->
			 <?php if($user_role == 'administrator'|| $user_role == 'inspector') 
				{ ?>
            <div class="tab-content tab-content-subtasks active">
				<style>
        .validate-btn, .non-validate-btn {
            padding: 5px 10px;
            margin-right: 5px;
            border: 1px solid #ccc;
            background-color: #f8f8f8;
            cursor: pointer;
        }

        .validate-btn.active {
            background-color: #4CAF50;
            color: white;
        }

        .non-validate-btn.active {
            background-color: #f44336;
            color: white;
        }

        .subtask-item {
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .subtask-buttons {
            margin-top: 10px;
        }
		.subtask-comment {
            margin-top: 10px;
        }
        .subtask-comment textarea {
            width: 100%;
            padding: 5px;
            margin-top: 5px;
        }
    </style>
                <!--/ Start Subtasks /-->
                <div class="subtasks">
                    <?php if($subtask_list) { 
                        $subtask_rows = get_post_meta( (int)$task_id, 'subtask_list', true);
                    ?>
					
                    <form class="update-subtask-list" method="post" id="update-subtask-list" data-target="update_subtask_list" enctype="multipart/form-data">
                        <ul>
                <li class="subtask-progress">
                    <b><i></i></b>
                </li>
                <?php 
                    if($subtask_rows) {
                        if (count($subtask_rows) > 0) {
                            sort($subtask_rows); /* Sort alphabetically */
                            foreach ($subtask_rows as $index => $subtask) {
                                $subtask_name           = isset($subtask['subtask_name']) ? $subtask['subtask_name'] : '';
                                $subtask_description    = isset($subtask['subtask_description']) ? $subtask['subtask_description'] : '';
                                $subtask_status         = isset($subtask['subtask_status']) ? $subtask['subtask_status'] : '';
                                $subtask_comment        = isset($subtask['subtask_comment']) ? $subtask['subtask_comment'] : '';
                            ?>
                                <li class="subtask-item" data-index="<?php echo $index; ?>">
                                    <label class="<?php if($subtask_status == '1') { echo 'line-through'; } ?>">
                                        <?php if($subtask_name) { ?>
                                        <input type="hidden" name="subtask_name[]" value="<?php echo $subtask_name;?>" />
                                        <?php } ?>
                                        <?php if($subtask_description) { ?>
                                        <input type="hidden" name="subtask_description[]" value="<?php echo $subtask_description;?>" />
                                        <?php } ?>
                                        <input type="number" name="subtask_status[]" <?php if($subtask_status == '1') { echo 'value="1"'; } else { echo 'value="0"'; } ?> />
                                        
                                        <span>
                                            <strong><?php echo $subtask_name; ?></strong>
                                            <?php if($subtask_description) { echo nl2br($subtask_description); } ?>
                                        </span>
                                    </label>
                                    <div class="subtask-buttons">
                                        <button type="button" class="validate-btn">Validate</button>
                                        <button type="button" class="non-validate-btn">Non Validate</button>
                                    </div>
                                    <div class="subtask-comment">
                                        <textarea name="subtask_comment[]" id="subtask_comment_<?php echo $index; ?>"><?php echo $subtask_comment; ?></textarea>
                                        <button type="button" class="send-comment-btn">Send</button>
                                    </div>
                                </li>                                    
                            <?php 
                            }
                        }
                    }
                ?>
            </ul>
                        <?php /* Get the PM email address for use in notification */
                            $category = get_the_terms( get_the_id(), 'project' );     
                            foreach ( $category as $cat) {
                                $term_id = $cat->term_id;
                            }
                            $term_meta  = get_term_meta($term_id); 
                            $pm_id      = $term_meta['project_manager'][0];
                            $pm_data    = get_userdata( $pm_id );
                        ?>
                        <input type="hidden" name="task_id" value="<?php echo $task_id; ?>" />
                        <input type="hidden" name="task_pc_complete" value="<?php if($task_pc_complete) { echo $task_pc_complete; }?>" />
                        <input type="hidden" id="pm_user_id" name="pm_user_id" value="<?php echo $pm_id; ?>"" />
                        <input type="hidden" id="task_status" name="task_status" value="" />
						
						<?php function list_task_files($task_id) {
    $task_name = get_the_title($task_id);
    $task_dir = wp_upload_dir()['basedir'] . '/task_files/' . sanitize_file_name($task_name);
    
    if (file_exists($task_dir)) {
        $files = scandir($task_dir);
        foreach ($files as $file) {
            if ($file != '.' && $file != '..') {
                $file_url = wp_upload_dir()['baseurl'] . '/task_files/' . sanitize_file_name($task_name) . '/' . $file;
                echo '<a href="' . esc_url($file_url) . '" download>' . esc_html($file) . '</a><br>';
            }
        }
    }
}?>
                    </form>

                        
                        <script>

    <?php /* Allow updating subtasks by task owner, or when there is no task owner */
    if($author_id == get_current_user_id() || $author_id == '0') { ?>
        /* Subtask list dynamic presentation */
        $('.subtasks .subtask-item').each(function() {
            var $item = $(this);
            var $input = $item.find('input[name="subtask_status[]"]');
            var $label = $item.find('label');
            var $validateBtn = $item.find('.validate-btn');
            var $nonValidateBtn = $item.find('.non-validate-btn');
            var $commentTextarea = $item.find('textarea[name="subtask_comment[]"]');
            var $sendCommentBtn = $item.find('.send-comment-btn');
            
            // Set initial state
            if ($label.hasClass('line-through')) {
                $validateBtn.addClass('active');
                $nonValidateBtn.removeClass('active');
                $input.val('1');
            } else {
                $validateBtn.removeClass('active');
                $nonValidateBtn.addClass('active');
                $input.val('0');
            }
            
            // Button click handlers
            $validateBtn.click(function() {
                updateSubtask($item, true);
            });
            
            $nonValidateBtn.click(function() {
                updateSubtask($item, false);
            });

            // Send comment button click handler
            $sendCommentBtn.click(function() {
                updateSubtaskComment($item);
            });
        });

        function updateSubtask($item, isValidated) {
            var $input = $item.find('input[name="subtask_status[]"]');
            var $label = $item.find('label');
            var $validateBtn = $item.find('.validate-btn');
            var $nonValidateBtn = $item.find('.non-validate-btn');
            
            if (isValidated) {
                $validateBtn.addClass('active');
                $nonValidateBtn.removeClass('active');
                $label.addClass('line-through');
                $input.val('1');
            } else {
                $validateBtn.removeClass('active');
                $nonValidateBtn.addClass('active');
                $label.removeClass('line-through');
                $input.val('0');
            }

            updateProgress();
            submitForm();
        }

        function updateSubtaskComment($item) {
            var subtaskIndex = $item.data('index');
            var comment = $item.find('textarea[name="subtask_comment[]"]').val();
            
            // AJAX call to save the comment
            $.ajax({
                url: ajaxurl, // projectpilot AJAX URL, make sure it's defined
                type: 'POST',
                data: {
                    action: 'update_subtask_comment',
                    task_id: <?php echo $task_id; ?>,
                    subtask_index: subtaskIndex,
                    comment: comment
                },
                success: function(response) {
                    if (response.success) {
                        alert('Comment saved successfully!');
                    } else {
                        alert('Error saving comment. Please try again.');
                    }
                },
                error: function() {
                    alert('Error saving comment. Please try again.');
                }
            });
        }

        function updateProgress() {
            var completed = $('.subtasks .subtask-item label.line-through').length;
            var total = <?php echo count($subtask_rows); ?>;
            var progressUpdate = (completed / total) * 100;
            $('.subtask-progress b').attr('style', 'width:'+progressUpdate+'%');

            $('.update-subtask-list input[name="task_pc_complete"]').val(progressUpdate.toFixed(0));
            
            if (progressUpdate == 100) {
                $('.subtask-progress b').addClass('complete');
                $('.tab-nav .subtasks span').text(completed+'/'+total);
                $('.tab-nav .subtasks span').hide();
                $('.side-form-box input[value="complete"]').prop('checked', true);
                $('.side-form-box label').removeClass('selected');
                $('.side-form-box .complete').addClass('selected');
                $('#task_status').val('complete');
            } else {
                $('.subtask-progress b').removeClass('complete');
                $('.tab-nav .subtasks span').show();
                $('.tab-nav .subtasks span').text(completed+'/'+total);
                $('.side-form-box label').removeClass('selected');
                $('.side-form-box .incomplete').addClass('selected');
                $('.side-form-box .incomplete').prop('checked', true);
                $('#task_status').val('incomplete');
            }
        }

        function submitForm() {
            setTimeout(function() { 
                $('#update-subtask-list').submit();
            }, 250);
        }
    <?php } ?>
    
    // Initially set the subtask progress bar and tab count
    updateProgress();
</script>                        
                    <?php } else { ?>
                        <script>
                            $('.tab-nav .subtasks, .tab-content-subtasks').remove();
                        </script>
                    <?php } ?>
                </div>
                <!--/ End Subtasks /-->
            </div>
			 <?php } ?>
            <!--/ End Subtasks Tab Content /-->
			<!--/ Start control Files Tab Content /-->
			<style>
			/* Style for both download and upload buttons */
.download-button,
#control-file-upload-form input[type="submit"] {
    display: inline-block;
    padding: 5px 10px;
    background-color: #4CAF50;
    color: white;
    text-decoration: none;
    border-radius: 3px;
    margin-left: 10px;
    font-size: 0.8em;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.download-button:hover,
#control-file-upload-form input[type="submit"]:hover {
    background-color: #45a049;
}

/* Style for the file input */
#control-file-upload-form input[type="file"] {
    display: inline-block;
    padding: 5px;
    border: 1px solid #45a049;
    border-radius: 3px;
    font-size: 0.9em;
}

/* Style for the form container */
#control-file-upload-form {
    margin-top: 10px;
    margin-bottom: 10px;
}

/* Style for the progress bar */
#upload-progress {
    margin-top: 10px;
}

#upload-progress progress {
    width: 100%;
    height: 20px;
}

#upload-progress span {
    display: inline-block;
    margin-top: 5px;
    font-size: 0.9em;
}

/* Style for the upload message */
#upload-message {
    margin-top: 10px;
    font-weight: bold;
	
}
	.download-button {
    display: inline-block;
    padding: 10px 10px;
    background-color: #4CAF50;
    color: white;
    text-decoration: none;
    border-radius: 3px;
    margin-left: 10px;
    font-size: 0.8em;
}

.download-button:hover {
    background-color: #45a049;
	}
</style>
<?php 
$task_control_id = get_post_meta(get_the_ID(), 'task_control', true);
$current_user = wp_get_current_user();
$user_role = $current_user->roles[0];
if ($task_control_id && ($user_role == 'administrator' || $user_role == 'inspector' || $current_user->ID == $task_control_id)) { 
?>
<div class="tab-content tab-content-control-files">
 <br><span>
    <div id="control-files-list">
        <?php
        $control_files = get_post_meta(get_the_ID(), 'control_files', true);
        if ($control_files && is_array($control_files)) {
            echo '<ul class="control-files-list">';
            foreach ($control_files as $file) {
				echo '<h2><li>';
				echo '<a  target="_blank">' . esc_html($file['name']) . '</a>';
				echo ' <a href="' . esc_url($file['url']) . '" download class="download-button">Download</a>';
				echo '</h2></li>';
}
            echo '</ul>';
        } else {
            echo '<p>' . __("No control files uploaded yet.", "wproject") . '</p>';
        }
        ?></span>
    </div></br>
    <?php if ($current_user->ID == $task_control_id) { ?>
       <form id="control-file-upload-form" enctype="multipart/form-data">
            <input type="file" name="control_file" required>
            <input type="hidden" name="post_id" value="<?php echo get_the_ID(); ?>">
            <input type="hidden" name="action" value="handle_control_file_upload">
            <input type="hidden" name="security" value="<?php echo wp_create_nonce('control_file_upload'); ?>">
           <h2> <input type="submit" value="<?php _e('Upload ', 'wproject'); ?>"></h2>
        </form>
        <div id="upload-progress" style="display: none;">
            <progress value="0" max="100"></progress>
            <span>0%</span>
        </div>
        <div id="upload-message"></div>
    <?php } ?>
	
</div>
<?php } ?>

<script>
jQuery(document).ready(function($) {
    $('#control-file-upload-form').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        percentComplete = parseInt(percentComplete * 100);
                        $('#upload-progress progress').val(percentComplete);
                        $('#upload-progress span').text(percentComplete + '%');
                        $('#upload-progress').show();
                    }
                }, false);
                return xhr;
            },
            success: function(response) {
                if(response.success) {
                    $('#upload-message').html('<p style="color: green;">' + response.data + '</p>');
                    // Refresh the file list
                    location.reload();
                } else {
                    $('#upload-message').html('<p style="color: red;">' + response.data + '</p>');
                }
            },
            error: function() {
                $('#upload-message').html('<p style="color: red;">An error occurred. Please try again.</p>');
            },
            complete: function() {
                $('#upload-progress').hide();
            }
        });
    });
});
</script>
        

			<!--/ End control Files Tab Content /-->
            <!--/ Start Files Tab Content /-->
            <div class="tab-content tab-content-files active">
                <form class="delete-file" method="post" data-target="delete_file" id="delete-file" enctype="multipart/form-data">
                    <!--/ Start Files /-->
                    <div class="files" id="file-set-<?php echo $task_id; ?>">
                        <ul>
                            <?php 
                            $file_count = '0';
                            $attachments = get_posts( array(
                                'post_parent'    => $task_id,
                                'post_type'      => 'attachment',
                                'posts_per_page' => -1,
                                'orderby'        => 'menu_order',
                                'order'          => 'ASC',
                            ) );
                            $i = 1;
                            foreach ( $attachments as $attachment ) { 
                                $class          = "post-attachment mime-" . sanitize_title( $attachment->post_mime_type );
                                $is_image       = wp_attachment_is_image($attachment->ID);
                                $file_type      = wp_check_filetype(wp_get_attachment_url($attachment->ID));
                                $file_size      = filesize( get_attached_file( $attachment->ID ) );
                                $file_extension = $file_type['ext'];

                                if($file_extension == 'pdf') {
                                    $file_extension_image = 'file-pdf.svg';
                                } else if($file_extension == 'zip') {
                                    $file_extension_image = 'file-zip.svg';
                                } else if($file_extension == 'csv') {
                                    $file_extension_image = 'file-csv.svg';
                                } else if($file_extension == 'xls' || $file_extension == 'xlsx') {
                                    $file_extension_image = 'file-csv.svg';
                                } else if($file_extension == 'doc' || $file_extension == 'docx') {
                                    $file_extension_image = 'file-doc.svg';
                                } else if($file_extension == 'ppt' || $file_extension == 'pptx' || $file_extension == 'pps' || $file_extension == 'ppsx') {
                                    $file_extension_image = 'file-ppt.svg';
                                } else if($file_extension == 'txt') {
                                    $file_extension_image = 'file-txt.svg';
                                } else if($file_extension == 'psd') {
                                    $file_extension_image = 'file-psd.svg';
                                } else {
                                    $file_extension_image = 'file.svg';
                                }
                                ?>
                                <li class="<?php echo $class; ?> <?php echo $file_extension; ?>" id="file-<?php echo $attachment->ID; ?>" title="<?php echo get_the_title($attachment->ID); ?>">
                                    <?php if($is_image == 1) { ?>
                                        <a data="<?php echo wp_get_attachment_url($attachment->ID); ?>" class="downloadable file-image">
                                            <img src="<?php echo wp_get_attachment_thumb_url($attachment->ID); ?>" />
                                        </a>
                                    <?php } else { ?>
                                        <em class="file-type-icon">
                                            <a data="<?php echo wp_get_attachment_url($attachment->ID); ?>" href="<?php echo wp_get_attachment_url($attachment->ID); ?>" class="downloadable file-other" download>
                                                <img src="<?php echo get_template_directory_uri();?>/images/<?php echo $file_extension_image; ?>" class="file-icon <?php echo $file_extension; ?>" />
                                                <em><?php echo $file_extension; ?></em>
                                            </a>
                                        </em>
                                    <?php } ?>
                                    <strong>
                                        <?php echo get_the_title($attachment->ID); ?>
                                    </strong>
                                    <span class="actions">
                                        <a href="<?php echo wp_get_attachment_url($attachment->ID); ?>" download title="Download"><i data-feather="download"></i></a>
                                        <a><?php echo size_format( $file_size, $decimals = 0 ); ?></a>
                                        <a class="delete-this-file" data="<?php echo $attachment->ID; ?>" title="Delete"><i data-feather="trash"></i></a>
                                    </span>
                                </li>
                                
                            <?php 
                            $file_count = $i++;
                            }
                            wp_reset_postdata(); ?>
                            
                            <script>
                                /* Basic lightbox */
                                $( document ).ready(function() {

                                    <?php /* Hide Files tab and box of there are no files */
                                        if($file_count == 0) { ?>
                                        $('.tab-nav .files, .tab-content .files').remove();
                                    <?php } ?>
                                      
                                    $('.tab-nav .files span').text('<?php echo $file_count; ?>');
                                    
                                    $('.file-image').click(function() {
                                        $('.mask').addClass('show');
                                        var url = $(this).attr('data');
                                        $('.mask, .image-container').addClass('show');
                                        $('.image-container').append('<img src="'+url+'" />');
                                    });
                                    
                                    $('.mask, .image-container').click(function() {
                                        $('.mask, .image-container').removeClass('show');
                                        $('.image-container img').remove();
                                    });

                                    var files_count = $('.files .post-attachment').length;
                                    if(files_count <= 1) {
                                        $('.switch-files-view').remove();
                                        $('.download-all-files').remove();
                                        $('.delete-all-files').remove();
                                    }

                                });
                            </script>
                        </ul>
                    </div>
                    <!--/ End Files /-->
                    <input type="hidden" name="task_id" value="<?php echo $task_id; ?>" />
                    <input type="hidden" name="file_id" id="file_id" value="" />
                </form>
            </div>
            <!--/ End Files Tab Content /-->

            
            <script>
                $('.tab-nav li').click(function() {
                    var theClass = $(this).attr('class');
                    $('.tab-nav li').removeClass('active').css('pointer-events', 'all');
                    $(this).addClass('active').css('pointer-events', 'none');
                    $('.tab-content').removeClass('active');
                    $('.tab-content-' + theClass).addClass('active');
                });

                $('.expand-all').click(function() {
                    $('.tab-content').addClass('active');
                });
            </script>

            <script>
                /* Claim ownership of a task */
                $( document ).ready(function() {
                    $('.no-owner').click(function() {
                        
                        var avatar_path  = $('.left .user .avatar').attr('src');

                        if(avatar_path == '') {
                            $('.owner .avatar').attr('src', '<?php echo get_template_directory_uri();?>/images/default-user.png');
                        } else {
                            $('.owner .avatar').attr('src', avatar_path);
                        }

                        var task_owner_name = '<?php echo get_the_author_meta('first_name', get_current_user_id()); ?> <?php echo get_the_author_meta('last_name', get_current_user_id()); ?>';
                        $(this).text(task_owner_name);
                        $('.right .owner div strong').text(task_owner_name);
                        $(this).css('pointer-events', 'none');

                        $('#claim-task-form').submit();
                    });
                });    
            </script>
            
            <?php if(empty($print)) { ?>
            
                <?php /* Comments logic */

                    $user 					    = wp_get_current_user();
                    $user_role 				    = $user->roles[0];

                    $current_user_id            = get_current_user_id();
                    $author_id                  = get_post_field ('post_author', $task_id);

                    $options                    = get_option( 'wproject_settings' );
                    $task_comments_enabled      = isset($options['task_comments_enabled']) ? $options['task_comments_enabled'] : '';

                    if(function_exists('add_client_settings')) {
                        $wproject_client_settings   = wProject_client();
                        $client_comment_tasks       = $wproject_client_settings['client_comment_tasks'];
                    } else {
                        $client_comment_tasks       = '';
                    }

                    if($task_comments_enabled == 'on' && comments_open()) { ?>
                    
                        <!--/ Start Comments /-->
                        <div class="tab-content tab-content-tab-comments active">

                            <?php if($user_role == 'observer' || $user_role == 'inspector' || $user_role == 'administrator' || $user_role == 'project_manager' || $user_role == 'team_member' || $user_role == 'client' && $client_comment_tasks) {

                                if($task_private == 'yes') {
                                    if($author_id == $current_user_id || $user_role == 'administrator' || $user_role == 'project_manager'|| $user_role == 'inspector') {
                                        comments_template('/inc/comments.php', true);
                                    }
                                } else {
                                    comments_template('/inc/comments.php', true);
                                } ?>
                                <?php } ?>
                            </div>
							<?php 	}?>
							<?php }?>
                            <!--/ End Comments /-->
							<!--/ Start summary /-->
                        <div class="tab-content tab-content-task-sum active">

                            <?php if($user_role == 'observer' || $user_role == 'inspector' || $user_role == 'administrator' || $user_role == 'project_manager' || $user_role == 'team_member' || $user_role == 'client' && $client_comment_tasks) {

                                if($task_status =='complete') {?>
									<ul class="project-info-list">
										<li class="project-item">
											<span><?php _e('Project', 'wproject'); ?>:</span> 
											<?php if($categories !='') {
												foreach( $categories as $category ) { 
													echo '<a href="' . home_url() . '/project/' . $category->slug . '">' . $category->name . '</a>';
												}
											} else {
												_e('No project', 'wproject');
											}?>
											
										</li>
										<li class="itp-item"><span><?php _e('ITP No. Réf:', 'wproject'); ?> </span> <?php echo get_the_title(); ?></li>
										
									</ul>
									<ul class="project-info-list">
										<li><span><?php _e('Partie 1 (a)  par Dépt. Qualité Contractant', 'wproject');?></span></li>
										<li><span><?php _e('Nom Prénom :', 'wproject'); ?></span> 
											<?php echo get_the_author_meta( 'first_name', $initiator_id ); ?> 
											<?php echo get_the_author_meta( 'last_name', $initiator_id ); ?></li>
											
											</ul>
										<ul class="project-info-list">
											<li class="project-item"><span><?php _e('Partie 1 (b) par Dépt.Qualité JESA', 'wproject'); ?></span>
											
											<li><span><?php _e('Nom Prénom :', 'wproject'); ?></span> <?php echo get_task_owner_info($task_id); ?></li>		
											
										</ul>
									<?php if($task_start_date && $task_end_date) { ?>
										<li class="dates">
											<span><?php _e('Date prévu d\'inspection', 'wproject'); ?>:</span><?php echo $the_task_start_date; ?>
										</li>
										<?php } ?>	
					
									
									
									
									
                                 <?php }?>   
                                
                                
                            </div>
                            <!--/ End summary /-->
                        
                    

            
						<?php 	} ?>

            <script>
                <?php if(isset($_GET['tab']) && $_GET['tab'] == 'time') { ?>
                    $('.tab-nav li, .tab-content').removeClass('active');
                    $('.tab-nav .task-time').addClass('active');
                    $('.tab-content.tab-content-task-time').addClass('active');
                <?php } else if(isset($_GET['tab']) && $_GET['tab'] == 'files') { ?>
                    $('.tab-nav li, .tab-content').removeClass('active');
                    $('.tab-nav .files').addClass('active');
                    $('.tab-content.tab-content-files').addClass('active');
                <?php } else if(isset($_GET['tab']) && $_GET['tab'] == 'subtasks') { ?>
                    $('.tab-nav li, .tab-content').removeClass('active');
                    $('.tab-nav .subtasks').addClass('active');
                    $('.tab-content.tab-content-subtasks').addClass('active');
                <?php } else if(isset($_GET['tab']) && $_GET['tab'] == 'comments') { ?>
                    $('.tab-nav li, .tab-content').removeClass('active');
                    $('.tab-nav .tab-comments').addClass('active');
                    $('.tab-content.tab-content-tab-comments').addClass('active');
                <?php }?>
            </script>


        </div>
        <!--/ End Tabby /-->
<?php	}


?>
<div class="container">

    <?php get_template_part('inc/left'); ?>

    <!--/ Start Section /-->
    <section class="middle task-<?php echo $post->post_name; ?> task-project">               

        <?php if($task_private == 'yes') { ?>

                <?php if($author_id == $current_user_id || $user_role == 'administrator' || $user_role == 'project_manager' || $user_role == 'inspector') { ?>
                    <?php the_task() ?>
                <?php } else { ?>
                    <p><?php _e('This is a private task.', 'wproject'); ?></p>
                <?php } ?>

        <?php } else { ?>
            <?php the_task() ?>
        <?php } ?>

        <!--/ Start Task Widget /-->
        <?php if ( is_active_sidebar( 'wproject-task-widget' ) ) { 
            dynamic_sidebar( 'wproject-task-widget' );
        } ?>
        <!--/ End Task Widget /-->

    </section>
    <!--/ End Section /-->

    <?php /* Help topics */
    function view_task_help() { 

        $print = isset($_GET['print']) ? esc_html($_GET['print']) : '';

        if(empty($print)) { ?>
        <h4><?php _e('Project', 'wproject'); ?></h4>
        <p><?php _e('The project that this task will belong to.', 'wproject'); ?></p>

        <h4><?php _e('Assigned to', 'wproject'); ?></h4>
        <p><?php _e('The Eternal Control that this task will be assigned to. If is not selected, the task will be assigned to you.', 'wproject'); ?></p>

        <h4><?php _e('Priority', 'wproject'); ?></h4>
        <p><?php _e('How important is this task? If not selected, the default priority will be normal.', 'wproject'); ?></p>

        <h4><?php _e('Status', 'wproject'); ?></h4>
        <p><?php _e('If this is a task you have already started work on but forgot to create before the fact, label it appropriately.', 'wproject'); ?></p>

        <h4><?php _e('Milestone', 'wproject'); ?></h4>
        <p><?php _e('Is this task considered to be a milestone?', 'wproject'); ?></p>

        <h4><?php _e('Privacy', 'wproject'); ?></h4>
        <p><?php _e('While this task will still appear in the project, the details will be obfuscated to other team members.', 'wproject'); ?></p>

        <h4><?php _e('Subtasks', 'wproject'); ?></h4>
        <p><?php _e('Smaller tasks that make up the main task.', 'wproject'); ?></p>

        <h4><?php _e('Files', 'wproject'); ?></h4>
        <p><?php _e('Files that are associated with this task.', 'wproject'); ?></p>
    <?php }
    }
    add_action('help_start', 'view_task_help');

    /* Side nav items */
    function view_task_nav() {
        global $post;
        $wproject_settings          = wProject(); 
        $users_can_task_takeover    = $wproject_settings['users_can_task_takeover'];

        if(function_exists('add_client_settings')) {
            $wproject_client_settings   = wProject_client();
            $client_create_own_tasks    = $wproject_client_settings['client_create_own_tasks'];
        }
        $task_id                   		= get_the_ID();
		$user_id                        = get_current_user_id();
		$task_owner_id                  = get_post_field( 'post_author', $task_id );
		
        $current_user_id            = get_current_user_id();
        $task_status                = get_post_meta( get_the_ID(), 'task_status', true );
        
        $author_id                  = get_post_field ('post_author', $task_id);
        $user_ID                    = get_the_author_meta( 'ID', $author_id );
        $first_name                 = get_the_author_meta( 'first_name', $author_id );
        $last_name                  = get_the_author_meta( 'last_name', $author_id );
        $task_wip                   = get_the_author_meta( 'task_wip', $author_id );
        $task_takeover_request      = get_post_meta($task_id, 'task_takeover_request', TRUE);     
        $task_timer                 = get_post_meta($task_id, 'task_timer', TRUE);   

        $user                       = get_userdata(get_current_user_id());
		$user_role                  = $user->roles[0];
       /* $role                       = $user->roles[0];

         $categories = get_the_terms( $task_id, 'project' );
        foreach( $categories as $category ) { 
        }
        $project_id = $category->term_id;
        $project_name = $category->name;
        $project_url = $category->slug; */
    ?>

        <?php if($author_id == get_current_user_id() && $user_role != 'client' || $user_role == 'project_manager' || $user_role == 'administrator' || $user_role == 'client' && $client_create_own_tasks && $user_ID == $current_user_id) { ?>
        <li><a href="<?php echo get_the_permalink(102); ?>?task-id=<?php echo get_the_ID(); ?>"><i data-feather="edit-3"></i><?php _e('Edit', 'wproject'); ?></a></li>
        <?php } ?>

        <li class="download-all-files" id="download-button" data-files=""><a><i data-feather="download-file"></i> <span><?php _e('Download all files', 'wproject'); ?></span></a></li>
  
        <script type="module">
            /* Download all files */
            import { multiDownload } from '<?php echo get_template_directory_uri();?>/js/multi-download/multi-download.js';

            $('#download-button').on('click', function() {
                $(this).addClass('downloading');
                //$('.downloading a span').text('<?php _e('Downloading', 'wproject'); ?>');
                const files = $(this).data('files').split(' ');
                multiDownload(files).then(() => {
                    $(this).removeClass('downloading');
                    $('.download-all-files a span').text('<?php _e('Download again', 'wproject'); ?>');
                });
            });
        </script>

        <script>
            /* Get a list of the all the file paths, add to data attribute for 'Download all files' button  */
            function files_paths() {
                var file_paths = $('.files li a.downloadable').map(function() {
                    return $(this).attr('data');
                }).get().join(' ');
                $('.download-all-files').attr('data-files', file_paths);
            }
            files_paths();

            $('body').on('click', '.delete-this-file', function(event) {
                event.stopPropagation();
                var deleteConfirm = $(this).attr('class');
                if(deleteConfirm == 'delete-this-file') {
                    if (confirm('<?php _e('Delete this file?', 'wproject'); ?>')) {
                        var file_id = $(this).attr('data');
                        $('#file_id').attr('value', file_id);

                        /* Remove the list element for the file that was deleted */
                        $(this).closest('li').find('a.downloadable').remove();

                        setTimeout(function() { 
                            $('#delete-file').submit();

                            /* Update the file paths for the 'Download all files' button */
                            files_paths();

                            /* If there is only one file remaining, remove the 'Download all files' button */
                            var files_remaining = $('.files li a.downloadable').length;
                            if(files_remaining == 1) {
                                $('.download-all-files').fadeOut();
                            }
                            //console.log('files remaining: ' + files_remaining);                            
                        }, 250);
                    }
                }
            });
        </script>

        <form method="post" id="manage-files" data-target="manage_files" enctype="multipart/form-data">
            <li class="delete-all-files"><a><i data-feather="delete-files"></i> <?php _e('Delete all files', 'wproject'); ?></a></li>
            <input type="hidden" name="file_option" id="file_option" value="" />
            <input type="hidden" name="file_task_id" id="file_task_id" value="<?php echo $task_id; ?>" />
        </form>
        <script>
            $(document).on('click', '.delete-all-files', function() {
                if (confirm('<?php _e('Really delete all the files in this task?', 'wproject'); ?>')) {

                    if (confirm('<?php _e('Last chance: Are you sure you want to delete all the files in this task?', 'wproject'); ?>')) {

                        $('#file_option').val('delete-all-files');

                        $('.download-all-files').remove();

                        setTimeout(function() { 
                            $('#manage-files').submit();
                        }, 500);
                    }  else {
                        $('#file_option').val('');
                    }
                }
            });
        </script>

        <?php add_to_calendar(); ?>
        <?php copy_link(); ?>
        <?php if($user_role != 'client') { ?>
        <form method="post" id="comment-status-form" data-target="comment_status" enctype="multipart/form-data">
            <?php if (comments_open($task_id)) { ?>
                <li><a><i data-feather="message-circle-slash"></i> <?php _e('Disable comments', 'wproject'); ?></a></li>
                <input type="hidden" name="comment_status" value="closed" />
            <?php } else { ?>
                <li><a><i data-feather="message-circle"></i> <?php _e('Enable comments', 'wproject'); ?></a></li>
                <input type="hidden" name="comment_status" value="open" />
            <?php } ?>
            <input type="hidden" name="post_id" value="<?php echo $task_id; ?>" />

            <script>
                $('#comment-status-form li').click(function() {
                    setTimeout(function() { 
                        $('#comment-status-form').submit();
                    }, 500);
                });
            </script>
        </form>
        <?php } ?>

        <?php } ?>
    <?php add_action('side_nav', 'view_task_nav'); 


    /* Add project name and link into right nav */
    function side_nav_project_name() { 
        $task_id    = get_the_ID();
        $categories = get_the_terms( $task_id, 'project' );
        ?>
        <li class="project-name" title="<?php _e("Go to project", 'wproject'); ?>">
            <?php if($categories !='') {
                foreach( $categories as $category ) {  ?>
                    <a href="<?php echo home_url(); ?>/project/<?php echo $category->slug;?>">
                        <i data-feather="arrow-left"></i>
                        <strong><?php echo $category->name?></strong>
                    </a> 
                <?php }
            } else {
                _e('No project', 'wproject');
            }
            ?>
        </li>
        <script>
            /* Populate a couple of hidden fields to get project data for the email notification */
            jQuery( document ).ready(function() {
                var project_name = jQuery('.project-name strong').text();
                var project_url = jQuery('.project-name a').attr('href');
                jQuery('#project_name').val(project_name);
                jQuery('#project_url').val(project_url);
            });
        </script>
    <?php }
    add_action('side_nav', 'side_nav_project_name', 1);
    
    get_template_part('inc/right'); 
    get_template_part('inc/help');
    
    ?> 

</div>
<?php get_footer(); ?>