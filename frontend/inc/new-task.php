<?php if ( ! defined( 'ABSPATH' ) ) { exit; }


$project_id = '';
    if(isset($_GET['project-id'])) {
        $project_id = esc_html($_GET['project-id']);
    }
    $unique_task_name = generate_unique_task_name($project_id);

    $wproject_settings              = wProject();
    $users_can_create_tasks         = $wproject_settings['users_can_create_tasks'];
    $enable_leave_warning           = $wproject_settings['enable_leave_warning'];
    $job_number_prefix              = $wproject_settings['job_number_prefix'];
    $users_can_assign_tasks         = $wproject_settings['users_can_assign_tasks'];
    $enable_subtask_descriptions    = $wproject_settings['enable_subtask_descriptions'];
    
    $cl                             = $wproject_settings['context_labels'];
    $context_labels                 = rtrim($cl, ', ');
    $the_context_labels             = explode(',', $context_labels);
    $the_context_labels             = array_map('trim', $the_context_labels); /* Trim whitespace */
    $context_label_display          = $wproject_settings['context_label_display'];

    if(function_exists('add_client_settings')) {
        $wproject_client_settings   = wProject_client();
        $client_create_own_tasks    = $wproject_client_settings['client_create_own_tasks'];
        $client_can_assign_tasks    = $wproject_client_settings['client_can_assign_tasks'];
    } else {
        $client_create_own_tasks    = '';
        $client_can_assign_tasks    = '';
    }

    $user                       = wp_get_current_user();
    $user_role                  = $user->roles[0];

    $user_info                  = get_userdata(get_current_user_id());
    $default_task_ownership     = $user_info->default_task_ownership;

    $the_total_projects_count   = all_projects_count();

    

    if($the_total_projects_count['count'] > 0) { 

    if($user_role   == 'administrator'  || 	$user_role 	== 'team_member' ){

        /*$users_can_create_tasks == 'on' && $user_role != 'client' ||         Allow users if option is enabled, and if user is not a client 
        $user_role              == 'client' && $client_create_own_tasks ||  /* Allow clients if option to create own tasks is enabled 
        $user_role              == 'project_manager' ||                     /* Allow Project managers */
   ?>                            		
     


    <!--/ Start New Task /-->
<form class="general-form new-task-form" data-target="add_new_task" method="post" id="new-task-form" enctype="multipart/form-data">
    <!--/ Start Task Details /-->
    <fieldset>
    <legend><?php _e('Task', 'wproject'); ?></legend>
    <ul>
        <li>
            <label><?php _e('Project', 'wproject'); ?></label>
            <?php do_action('projects_selection'); ?>
        </li>
        <li>
            <label><?php _e('Assigned to', 'wproject'); ?></label>
            <?php task_assignee(); ?>
        
    </ul>
</fieldset>
    <!--/ End Task Details /-->
		

<!--/ Start New Form Elements /-->
<fieldset>
    <legend><?php _e('Additional Details', 'wproject'); ?></legend>
    <ul>
        <li>
            <label for="localisation_generale"><?php _e('Localisation générale', 'wproject'); ?></label>
            <select id="localisation_generale" name="localisation_generale">
                <option value=""></option>
                <option value="Pont"><?php _e('Pont', 'wproject'); ?></option>
                <option value="Digue_quai"><?php _e('Digue quai', 'wproject'); ?></option>
            </select>
        </li>

        <li>
            <label for="sub_localisation_1"><?php _e('Sub localisation 1', 'wproject'); ?></label>
            <select id="sub_localisation_1" name="sub_localisation_1">
                <option value=""></option>
                <option value="Pieu"><?php _e('Pieu', 'wproject'); ?></option>
                <option value="chevetreBA"><?php _e('chevêtre B.A', 'wproject'); ?></option>
                <option value="chevetreMetallique"><?php _e('chevêtre métallique', 'wproject'); ?></option>
                <option value="appareilAppui"><?php _e('Appareil d\'appui', 'wproject'); ?></option>
                <option value="digueSecondaire"><?php _e('Digue secondaire', 'wproject'); ?></option>
                <option value="diguePrincipale"><?php _e('Digue principale', 'wproject'); ?></option>
            </select>
        </li>

        <li id="sub_localisation_2_container" style="display:none;">
            <label><?php _e('Sub localisation 2', 'wproject'); ?></label>
            <div id="sub_localisation_2">
                <!-- Checkboxes will be dynamically added here -->
            </div>
        </li>

        <li id="sub_localisation_3_container" style="display:none;">
            <label><?php _e('Sub localisation 3', 'wproject'); ?></label>
            <div id="sub_localisation_3">
                <!-- Checkboxes will be dynamically added here -->
            </div>
        </li>
    </ul>
</fieldset>
<!--/ End New Form Elements /-->


	
        <!--/ Start Task Specifics /-->
        <fieldset>
            <legend><?php _e('Specifics', 'wproject'); ?></legend>
            <ul>
                <li>
                    <label><?php _e('Priority', 'wproject'); ?></label>
                    <div class="radio-group radio-group-4">
                        <label>
                            <input type="radio" name="task_priority" value="low" /> <?php /* translators: One of 4 possible task priorities */ _e('Low', 'wproject'); ?>
                        </label>
                        <label>
                            <input type="radio" name="task_priority" value="normal" checked /> <?php /* translators: One of 4 possible task priorities */ _e('Normal', 'wproject'); ?>
                        </label>
                        <label>
                            <input type="radio" name="task_priority" value="high" /> <?php /* translators: One of 4 possible task priorities */ _e('High', 'wproject'); ?>
                        </label>
                        <label>
                            <input type="radio" name="task_priority" value="urgent" /> <?php /* translators: One of 4 possible task priorities */ _e('Urgent', 'wproject'); ?>
                        </label>
                    </div>
					<input type="hidden" name="task_status" id="task_status" value="in-progress" />
                </li>
                <li>
					<label><?php _e('1st Date of inspection', 'wproject'); ?>
						<em class="action clear-dates"><?php _e('Clear dates', 'wproject'); ?></em>
					</label>
					<input type="datetime-local" name="task_start_date" class="pick-start-date merge-start" min="<?php echo date('Y-m-d\TH:i'); ?>" />
				</li>
				<li><label><?php _e(' 2nd date of inspection', 'wproject'); ?>
						<em class="action clear-dates"><?php _e('Clear dates', 'wproject'); ?></em>
					</label>
					<input type="datetime-local" name="task_end_date" class="pick-end-date merge-end" min="<?php echo date('Y-m-d\TH:i'); ?>" />
				</li>

                 <li type="hidden" class="side-by-side">
                    <div >
                        <label ><?php _e('Job #', 'wproject'); ?></label>
                        <input type="text" name="task_job_number" value="<?php if($job_number_prefix) { echo $job_number_prefix; } ?>" />
                    </div>
                    <div>
                        <label><?php _e('% Complete', 'wproject'); ?></label>
                        <input type="number" name="task_pc_complete" min="0" max="100" value="0" class="task-pc-complete" />
                    </div>
                </li> 
                 <li type="hidden">
                    <label><?php _e('Status', 'wproject'); ?></label>
                    <select name="task_status" class="task-status-selector">
                        <option value="complete"><?php _e('Complete', 'wproject'); ?></option>
                        <option value="in-progress"><?php _e('In progress', 'wproject'); ?></option>
                        <option value="not-started" selected><?php _e('Not started', 'wproject'); ?></option>
                        <option value="on-hold"><?php _e('On hold', 'wproject'); ?></option>
                    </select>
                </li> 
                <?php if($user_role =='client') { ?>
                <li type="hidden">
                    <label><?php _e('Web page', 'wproject'); ?></label>
                    <input type="url" name="web_page_url" placeholder="<?php _e('https://', 'wproject'); ?>" />
                </li>
                <li type="hidden">
                    <label>
                        <input type="checkbox" name="task_milestone" /> <span><?php _e('This task is a milestone', 'wproject'); ?></span>
                    </label>
                </li>
                <li type="hidden">
                    <label>
                        <input type="checkbox" name="task_private" /> <span><?php _e('Hide the task details from other users', 'wproject'); ?></span>
                    </label>
                </li>
                <?php } ?>

            </ul>
        </fieldset>
        <!--/ End Task Specifics /-->

        <?php if($user_role =='client') { ?>
        <!--/ Start Task Relationship /-->
        <fieldset class="relationship">
            <legend><?php _e('Relationship', 'wproject'); ?></legend>
            <ul>
                <li>
                    <label><?php _e('This task', 'wproject'); ?></label>
                    <select name="task_relation" class="relation">
                        <option value=""></option>
                        <option value="has_issues_with"><?php _e('Has issues with', 'wproject'); ?></option>
                        <option value="is_blocked_by"><?php _e('Is blocked by', 'wproject'); ?></option>
                        <option value="is_similar_to"><?php _e('Is similar to', 'wproject'); ?></option>
                        <option value="relates_to"><?php _e('Relates to', 'wproject'); ?></option>
                    </select>
                </li>
                <li>
                    <label></label>
                    <select name="task_related" class="related" disabled>
                        <option value=""></option>
                        <?php
                            $project_args = array(
                                'orderby'	 => 'name',
                                'order'		 => 'ASC',
                                'taxonomy' => 'project',
                            );
                            $projects = get_categories($project_args);

                            foreach($projects as $cat) {
                                $args = array(
                                    'orderby' => 'name',
                                    'order'   => 'ASC'
                                );
                                
                                $task_args = array(
                                    'posts_per_page' 	=> -1,
                                    'meta_key'          => 'task_status',
                                    'meta_value'        => array('in-complete', 'in-progress', 'on-hold', 'not-started', ''),
                                    'post_type'			=> 'task',
                                    'post__not_in' 		=> array(get_the_ID()), /* Exclude the current post ID */
                                    'orderby' 		    => 'title', 
                                    'order' 		    => 'ASC',
                                    'tax_query' => array(
                                        array(
                                            'taxonomy' => 'project',
                                            'field'    => 'slug',
                                            'terms'    => array( $cat->name ),
                                            'operator' => 'IN'
                                        ),
                                    ),
                                );
                                $posts = get_posts($task_args);
                                if ($posts) {
                                    echo '<optgroup label="' . $cat->name . '">';
                                    foreach($posts as $post) { 
                                        setup_postdata($post); ?>
                                        <option value="<?php echo $post->ID; ?>"><?php the_title(); ?></option>
                                    <?php
                                    }
                                    echo '</optgroup> ';
                                }
                            }
                        ?>
                    </select>
                </li>
                <li>
                    <label><?php _e('Explanation', 'wproject'); ?></label>
                    <textarea name="task_explanation" class="explanation" disabled></textarea>
                </li>
            </ul>
        </fieldset>
        <!--/ End Task Relationship /-->
        <?php } ?>


        <!--/ Start Files /-->
        <fieldset>
            <legend><?php _e('Files', 'wproject'); ?><span class="files-count"></span></legend>
            <ul>

               <li class="no-margin">
                    <label><?php _e('Attach files', 'wproject'); ?></label>
                    <input type="file" name="task_files[]" id="task_files" multiple="multiple" class="file-input" />
                    <style>
                        .file-input:before {
                            content: '<?php _e('Browse', 'wproject'); ?>';
                        }
                    </style>
                </li>
				<li>
                    <label><?php _e('Description', 'wproject'); ?></label>
                    <textarea name="task_description"></textarea>
                </li>
            </ul>
        </fieldset>
        <!--/ End Files /-->


        <!--/ Start Subtasks /-->
    
       <!-- <legend><?php _e('Subtasks', 'wproject'); ?></legend> -->
<ul class="subtask-items materials <?php if($enable_subtask_descriptions) { echo 'has-descriptions'; } ?>">
			
            
            <li><input type="hidden" name="subtask_name[]" value="<?php echo 'Review ITN'; ?>" /></li>
            <li><input type="hidden" name="subtask_name[]" value="<?php echo 'Review The Results of The 1st inspection '; ?>" /></li>
            <li><input type="hidden" name="subtask_name[]" value="<?php echo 'Review The Results of The 2nd inspection '; ?>" /></li>
            <li><input type="hidden" name="subtask_name[]" value="<?php echo 'Review The Attachements'; ?>" /></li>
            
        </ul>

  
    <!--/ End Subtasks /-->

        <!--/ Start Context Label 
        <fieldset>
       
            <legend><?php _e('Context label', 'wproject'); ?></legend>
            <ul>
                <li class="no-margin">

                    <?php if($context_label_display == 'dropdown' || $context_label_display == '') { ?>
                        
                        <label><?php _e('Add context', 'wproject'); ?></label>
                        <select name="context_label">
                            <option></option>
                            <?php 
                                sort($the_context_labels);
                                foreach($the_context_labels as $value) {
                                    echo '<option value="' . str_replace('-', ' ', trim($value)) . '">' . str_replace('-', ' ', trim($value)) . '</option>';
                                }
                            ?>
                        </select>

                    <?php } else { ?>
                        
                        <div class="radio-group radio-group-2">
                        <?php 
                            sort($the_context_labels);
                            foreach($the_context_labels as $value) {
                                echo '<label class="radio">';
                                echo '<input type="radio" name="context_label" value="' . str_replace('-', ' ', trim($value)) . '" />' . str_replace('-', ' ', trim($value));
                                echo '</label>';
                            }
                        ?>
                        </div>

                    <?php } ?>

                </li>
            </ul>
        </fieldset>

        <!--/ End Context Label /-->
	<?php	function organize_task_uploads($task_id, $task_name, $files) {
    if (empty($files)) {
        return array();
    }

    $upload_dir = wp_upload_dir();
    $task_dir = $upload_dir['basedir'] . '/tasks/' . $task_name;

    // Create the task directory if it doesn't exist
    if (!file_exists($task_dir)) {
        wp_mkdir_p($task_dir);
    }

    $uploaded_files = array();

    foreach ($files['name'] as $key => $value) {
        if ($files['error'][$key] == 0) {
            $tmp_name = $files['tmp_name'][$key];
            $name = sanitize_file_name($files['name'][$key]);
            $target_file = $task_dir . '/' . $name;

            // Move the file to the task directory
            if (move_uploaded_file($tmp_name, $target_file)) {
                $file_type = wp_check_filetype($name, null);
                $attachment = array(
                    'post_mime_type' => $file_type['type'],
                    'post_title' => preg_replace('/\.[^.]+$/', '', $name),
                    'post_content' => '',
                    'post_status' => 'inherit'
                );

                // Insert the file as an attachment
                $attach_id = wp_insert_attachment($attachment, $target_file, $task_id);

                if (!is_wp_error($attach_id)) {
                    // Generate attachment metadata
                    require_once(ABSPATH . 'wp-admin/includes/image.php');
                    $attach_data = wp_generate_attachment_metadata($attach_id, $target_file);
                    wp_update_attachment_metadata($attach_id, $attach_data);

                    $uploaded_files[] = $attach_id;
                }
            }
        }
    }

    return $uploaded_files;
}?>

        <?php do_action( 'new_task_end' ); ?>

        <input type="hidden" name="task_takeover_request" />

        <div class="submit">
            <button><?php _e('Create task', 'wproject'); ?></button>
			<li>
                    <input type="hidden" name="task_name" id="task_name" value="<?php echo $unique_task_name; ?>" />
            </li>
        </div>
		<script>
	document.addEventListener('DOMContentLoaded', function() {
    const localisationGenerale = document.getElementById('localisation_generale');
    const subLocalisation1 = document.getElementById('sub_localisation_1');
    const subLocalisation2Container = document.getElementById('sub_localisation_2_container');
    const subLocalisation2 = document.getElementById('sub_localisation_2');
    const subLocalisation3Container = document.getElementById('sub_localisation_3_container');
    const subLocalisation3 = document.getElementById('sub_localisation_3');

    const subLoc2OptionsMap = {
        'Pieu': ['P1*', 'P2*'],
        'chevetreBA': ['P1', 'P2', 'P3', 'P4', 'P5'],
        'chevetreMetallique': ['P25', 'P26', 'P27', 'P28', 'P29', 'P30'],
        'appareilAppui': ['P26*', 'P27*', 'P28*', 'P29*'],
        'digueSecondaire': ['Fabrication du caisson', 'Travaux Offshore'],
        'diguePrincipale': ['fabrication caisson', 'travaux ofshore']
    };

    const subLoc3OptionsMap = {
        'Pieu': ['A', 'B', 'C', 'D', 'E'],
        'chevetreBA': [
            'Inspection Pré-béton (ferraillage,coffrage et bétonnage) du bouchon de pieux en béton',
            'Inspection de ferraillage, ferraillage,coffrage et bétonnage du chevêtre',
            'Inspection post béton (après décoffrage) des poutres de chevêtre en béton',
            'Vérification finale de la longueur de coupe et de la verticalité des pieux'
        ],
        'chevetreMetallique': [
            'Inspection de réception matériel',
            'Inspection de soudage et de CND pour le chevêtre métallique  (NDT)',
            'Inspection de la préparation surfacique et de la peinture pour le chevêtre',
            'Réception de la longueur et la verticalité des pieux , avant installation de chevêtre',
            'Verifier la préparation des joints/ inspection de l\'emboitement pour l\'installation de chevêtre métalliques'
        ],
        'appareilAppui': [
            'Inspection de réception matériel',
            'Inspection visuelle de soudage et contrôle CND des plaques de bossage',
            'Inspection de la préparation de surface et peinture des plaques de bossage',
            'Inspection ferraillage, coffrage et mortier pour le bossage d\'appareil d\'appui'
        ],
        'digueSecondaire': ['B01', 'B02', 'B03', 'B04', 'B05', 'B06', 'B07', 'BC'],
        'diguePrincipale': ['A1', 'A2', 'A3', 'A4', 'A5']
    };

    function updateSubLocalisation1() {
        const value = localisationGenerale.value;
        Array.from(subLocalisation1.options).forEach(option => {
            if (value === 'Pont') {
                option.style.display = ['', 'Pieu', 'chevetreBA', 'chevetreMetallique', 'appareilAppui'].includes(option.value) ? '' : 'none';
            } else if (value === 'Digue_quai') {
                option.style.display = ['', 'digueSecondaire', 'diguePrincipale'].includes(option.value) ? '' : 'none';
            } else {
                option.style.display = '';
            }
        });
        subLocalisation1.value = '';
        updateSubLocalisation2();
    }

    function updateSubLocalisation2() {
        const value = subLocalisation1.value;
        subLocalisation2Container.style.display = value ? 'block' : 'none';
        const options = subLoc2OptionsMap[value] || [];
        
        // Clear existing checkboxes
        subLocalisation2.innerHTML = '';
        
        // Add new checkboxes
        options.forEach(option => {
            const label = document.createElement('label');
            const checkbox = document.createElement('input');
            checkbox.type = 'checkbox';
            checkbox.name = 'sub_localisation_2[]';
            checkbox.value = option;
            label.appendChild(checkbox);
            label.appendChild(document.createTextNode(option));
            subLocalisation2.appendChild(label);
            checkbox.addEventListener('change', updateSubLocalisation3);
        });
        
        updateSubLocalisation3();
    }

    function updateSubLocalisation3() {
        const value = subLocalisation1.value;
        const selectedOptions = Array.from(subLocalisation2.querySelectorAll('input[type="checkbox"]:checked')).map(cb => cb.value);
        subLocalisation3Container.style.display = selectedOptions.length > 0 ? 'block' : 'none';
        
        let options = [];
        if (value === 'Pieu' && (selectedOptions.includes('P1*') || selectedOptions.includes('P2*'))) {
            options = ['A', 'B', 'C', 'D', 'E'];
        } else {
            options = subLoc3OptionsMap[value] || [];
        }
        
        // Clear existing checkboxes
        subLocalisation3.innerHTML = '';
        
        // Add new checkboxes
        options.forEach(option => {
            const label = document.createElement('label');
            const checkbox = document.createElement('input');
            checkbox.type = 'checkbox';
            checkbox.name = 'sub_localisation_3[]';
            checkbox.value = option;
            label.appendChild(checkbox);
            label.appendChild(document.createTextNode(option));
            subLocalisation3.appendChild(label);
        });
    }

    localisationGenerale.addEventListener('change', updateSubLocalisation1);
    subLocalisation1.addEventListener('change', updateSubLocalisation2);

    // Initial setup
    updateSubLocalisation1();
});
	</script>
    </form>

    <?php do_action( 'new_task_after_form' ); ?>
	
	
    <script>
        $('.relation').change(function() {

            var relationship = $('select[name=relation] option').filter(':selected').val();

            var relationship = $('select[name=relation] option').filter(':selected').val();

            if ($(this).val() === '') {
                $('.relationship .explanation').attr('disabled','disabled');
                $('.relationship .relation, .relationship .related, .relationship textarea').val('');
                $('.relationship .related').attr('disabled', 'disabled');
            } else {
                $('.relationship .related').removeAttr('disabled');
                $('.relationship .related').attr('required', 'required');
                $().text();
            }
            if(relationship == 'is_blocked') {
                $( '.relationship .this-task-text' ).text( '<?php _e('Is blocked by', 'wproject');?>:' );
            } else if(relationship == 'is_similar') {
                $( '.relationship .this-task-text' ).text( '<?php _e('Is similar to', 'wproject');?>:' );
            } else if(relationship == 'has_issues') {
                $( '.relationship .this-task-text' ).text( '<?php _e('Has issues with', 'wproject');?>:' );
            } else if(relationship == 'relates') {
                $( '.relationship .this-task-text' ).text( '<?php _e('Relates to', 'wproject');?>:' );
            } else {
                $( '.relationship .this-task-text' ).text( '' );
            }
        });

        $('.related').change(function() {
            if ($(this).val() != '') {
                $('.relationship .explanation').removeAttr('disabled');
            }
            if ($(this).val() === '') {
                $('.relationship .explanation').attr('disabled','disabled');
                $('.relationship .relation, .relationship .related, .relationship textarea').val('');
                $('.relationship .related').attr('disabled', 'disabled');
                $('.relationship .this-task-text').text( '' );
            }
        });

        /* Subtask handling */
         var delete_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ff9800" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>';

        $(window).load(function() {
            $(function() {
                var subtaskItems = $('.subtask-items');
                var i = $('.subtask-items li').size() + 1;
                
                $('.add-item').click(function() {
                    $('<li class="item"><span><input type="text" name="subtask_name[]" data-lpignore="true" placeholder="<?php _e('Subtask', 'wproject'); ?>" required /><?php if($enable_subtask_descriptions) { ?><textarea name="subtask_description[]" placeholder="<?php _e('Additional information', 'wproject'); ?>"></textarea><?php } ?><input type="hidden" name="subtask_status[]" value="0" /></span><span class="remove" title="<?php _e('Remove (double click)', 'wproject'); ?>">'+delete_icon+'</span></li>').prependTo(subtaskItems);
                    i++;
                });
                
                $('.subtask-items').on('dblclick', '.remove', function() {
                    $('.subtask-items').find(this).parent().remove();
                    updateTotal();
                    return false;
                });
            });
        }); 

        /* 
            Change the task status to complete if task percentage is 100, 
            and swap it back to original status when less than 100.
        */
        var currentTaskStatus = $('.task-status-selector').val();
        jQuery('.task-pc-complete').change(function() {
            if (jQuery(this).val() == '100') {
                jQuery('.task-status-selector').val('complete');
            } else {
                jQuery('.task-status-selector').val(currentTaskStatus);
            }
        });
        jQuery('.task-status-selector').change(function() {
            if (jQuery(this).val() == 'complete') {
                jQuery('.task-pc-complete').val('100');
            } else {
                jQuery('.task-pc-complete').val(currentTaskStatus);
            }
        });

        /* Focus task name input */
        //jQuery('#task_name').focus();

        /* Clear date fields */
        jQuery('.clear-dates').hide();
        jQuery('input[type="date"]').change(function() {
            jQuery('.clear-dates').fadeIn();
        });
        jQuery('.clear-dates').click(function() {
            jQuery('input[type="date"]').val('');
            jQuery('input[type="date"]').trigger('change');
        });

    </script>
	
	  <!--/ <?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_new_task'])) {
    // Create the task post
    $task_title = sanitize_text_field($_POST['task_name']);
    $task_description = sanitize_textarea_field($_POST['task_description']);

    $task_id = wp_insert_post(array(
        'post_title'   => $task_title,
        'post_content' => $task_description,
        'post_type'    => 'task',
        'post_status'  => 'publish'
    ));

    if ($task_id && !is_wp_error($task_id)) {
        // Handle file uploads
        if (!empty($_FILES['task_files']['name'][0])) {
            $uploaded_files = organize_task_uploads($task_id, $unique_task_name, $_FILES['task_files']);
            
            // If you want to save the attachment IDs to the task post meta
            if (!empty($uploaded_files)) {
                update_post_meta($task_id, 'task_attachments', $uploaded_files);
            }
        }

        // Handle other form fields...
        // For example:
        update_post_meta($task_id, 'task_priority', sanitize_text_field($_POST['task_priority']));
        update_post_meta($task_id, 'task_start_date', sanitize_text_field($_POST['task_start_date']));
        update_post_meta($task_id, 'task_end_date', sanitize_text_field($_POST['task_end_date']));
        // ... add other fields as needed

        // Redirect to the task page or a success page
        wp_redirect(get_permalink($task_id));
        exit;
    }
}
?> -->

    <script type='text/javascript' src="<?php echo get_template_directory_uri(); ?>/js/date-picker-logic.js" id="date-picker-logic"></script>

    <?php leave_warning() ?>

    <!--/ End New Project /-->
    <?php } else { ?>
        <p class="info"><i data-feather="alert-triangle"></i><?php _e('The ability to create new tasks has not been enabled. Discuss this with your project manager or an administrator.', 'wproject'); ?></p>
    <?php } ?>

<?php } else { ?>
    <p class="info"><i data-feather="alert-triangle"></i><?php _e('There needs to be at least one project before you can create a task.', 'wproject'); ?></p>
    <?php if(
        $users_can_create_tasks == 'on' || 
        $user_role              == 'project_manager' || 
        $user_role              == 'administrator' || 
		$user_role == 'inspector'
    ) { ?>
    <a href="<?php echo get_the_permalink(104); ?>" class="btn-light"><?php _e('Create a project', 'wproject'); ?></a>
    <?php } ?>

<?php } ?>
<?php /* unique task name */
function generate_unique_task_name($project_id) {
   // $project_id = sanitize_title($project_id);
    $project_id = '';
    if(isset($_GET['project-id'])) {
        $project_id = esc_html($_GET['project-id']);
    }
    // Get the last used number for this project
    $last_number = get_option('last_task_number_' . $project_id, 0);
    
    // Increment the number
    $new_number = $last_number + 1;
    
    // Update the last used number in the database
    update_option('last_task_number_' . $project_id, $new_number);
    
    // Generate the unique task name
    $unique_task_name = 'ITN_' . $project_id . '_' . $new_number;
    
    return $unique_task_name;
				
}?>
<?php /* Help topics */
function new_task_help() { ?>
    <h4><?php _e('Task', 'wproject'); ?></h4>
    <p><?php _e('The bare minimum details of the task. A task name and project must be specified.', 'wproject'); ?></p>

    <h4><?php _e('Specifics', 'wproject'); ?></h4>
    <p><?php _e('Further information about this task. You can also hide this task from other users.', 'wproject'); ?></p>

    <h4><?php _e('Relationship', 'wproject'); ?></h4>
    <p><?php _e('Is this task related to another? If so, specify the relationship here.', 'wproject'); ?></p>

    <h4><?php _e('Subtasks', 'wproject'); ?></h4>
    <p><?php _e('Allow the task to be comprised of smaller, granular tasks.', 'wproject'); ?></p>

    <h4><?php _e('Context label', 'wproject'); ?></h4>
    <p><?php _e('Give this task some context.', 'wproject'); ?></p>
<?php }
add_action('help_start', 'new_task_help');

/* Side nav items */
function new_task_nav() { 
    
    $project_id = '';
    if(isset($_GET['project-id'])) {
        $project_id = esc_html($_GET['project-id']);
    }
    ?>

    <?php if($project_id !='') { ?>
        <li>
            <a href="<?php echo home_url(); ?>/project/<?php echo get_term( $project_id )->slug; ?>"><i data-feather="arrow-left-circle"></i>
                <span class="spawn"><?php _e('Back to ', 'wproject'); ?><?php echo get_term( $project_id )->name; ?></span>
            </a>
        </li>
    <?php } ?>

    <li><a href="<?php echo home_url(); ?>/"><i data-feather="x-circle"></i><?php _e('Discard', 'wproject'); ?></a></li>
<?php }
add_action('side_nav', 'new_task_nav');




