i want you to modify my code so the inspector can change or select a task owner if it's not already Assigned and select an Exterior Control in side-form

<?php
function view_task_nav() {
        global $post;
        $wproject_settings   = wProject(); 
        $users_can_task_takeover    = $wproject_settings['users_can_task_takeover'];
        if(function_exists('add_client_settings')) {
            $wproject_client_settings   = wProject_client();
            $client_create_own_tasks    = $wproject_client_settings['client_create_own_tasks']; }      $current_user_id            = get_current_user_id();
        $task_status                = get_post_meta( get_the_ID(), 'task_status', true );
        $task_id                    = get_the_ID();
        $author_id                  = get_post_field ('post_author', $task_id);
        $user_ID                    = get_the_author_meta( 'ID', $author_id );
        $first_name                 = get_the_author_meta( 'first_name', $author_id );
        $last_name                  = get_the_author_meta( 'last_name', $author_id );
        $task_wip                   = get_the_author_meta( 'task_wip', $author_id );
        $task_takeover_request      = get_post_meta($task_id, 'task_takeover_request', TRUE);     
        $task_timer                 = get_post_meta($task_id, 'task_timer', TRUE);   
        $user                       = get_userdata(get_current_user_id());
        $role                       = $user->roles[0];
        $categories = get_the_terms( $task_id, 'project' );
        foreach( $categories as $category ) {         }
        $project_id = $category->term_id;
        $project_name = $category->name;
        $project_url = $category->slug;
    ?>
<?php	$current_user = wp_get_current_user();
$user_role = $current_user->roles[0];
$task_id = get_the_ID();
$task_owner_id = get_post_field('post_author', $task_id);
$task_control_id = get_post_meta($task_id, 'task_control', true);
?>
<form class="side-form change-task-owner" method="post" id="change-task-owner">
    <?php wp_nonce_field('change_task_owner_control'); ?>
    <?php if ($user_role == 'inspector') { ?>
        <ul>
            <li>
                <label><?php _e('Assigned to', 'wproject'); ?></label>
                <select name="task_owner" required>
                    <option value="0"><?php _e('Nobody (unowned)', 'wproject'); ?></option>
                    <?php
                    $args = array(
                        'role__in' => array('team_member', 'project_manager'),
                        'orderby' => 'first_name',
                        'order' => 'ASC'  );
                    $users = get_users($args);
                    foreach ($users as $user) {
                        $selected = ($user->ID == $task_owner_id) ? 'selected' : '';
                        echo "<option value='" . esc_attr($user->ID) . "' $selected>" . esc_html($user->first_name . ' ' . $user->last_name . ' - ' . $user->title) . "</option>"; }  ?> </select>
            </li>
            <li>
                <label><?php _e('Select an Exterior Control', 'wproject'); ?></label>
                <select name="task_control">
                    <option value=""><?php _e('Nobody (Selected)', 'wproject'); ?></option>
                    <?php
                    $args = array(
                        'role__in' => array('lab', 'plongeur', 'topo'),
                        'orderby' => 'first_name',
                        'order' => 'ASC' );
                    $users = get_users($args);
                    foreach ($users as $user) {
                        $selected = ($user->ID == $task_control_id) ? 'selected' : '';
                        echo "<option value='" . esc_attr($user->ID) . "' $selected>" . esc_html($user->first_name . ' ' . $user->last_name . ' - ' . $user->title) . "</option>";   }   ?>  </select> </li>
            <li> <input type="hidden" name="task_id" value="<?php echo esc_attr($task_id); ?>">                <input type="submit" name="save_changes" value="<?php _e('Save Changes', 'wproject'); ?>" class="button button-primary">
            </li>
        </ul>
    <?php } else { ?>
        <p><?php _e('You do not have permission to edit this task.', 'wproject'); ?></p>
    <?php } ?>
</form>
<?php }?>