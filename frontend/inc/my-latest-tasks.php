<?php if ( ! defined( 'ABSPATH' ) ) { exit; }
$task_id            = get_the_ID();
$current_author             = get_current_user_id();
$task_order                 = get_user_meta( $current_author, 'default_task_order' , true );
$minimise_complete_tasks    = get_user_meta( $current_author, 'minimise_complete_tasks' , true );
$user_info                  = get_userdata(get_current_user_id());
$recent_tasks               = $user_info->recent_tasks;
$date_format                = get_option('date_format'); 
$now                        = strtotime('today');
$current_user_id	= get_current_user_id();
$wproject_settings          = wProject(); 
$task_spacing               = $wproject_settings['task_spacing'];
//$task_control_id = get_post_meta($task_id, 'task_control', true);
if($recent_tasks == '1 day ago') {
    $recent = __('1 day', 'wproject');
} else if($recent_tasks == '2 days ago') {
    $recent = __('2 days', 'wproject');
} else if($recent_tasks == '3 days ago') {
    $recent = __('3 days', 'wproject');
} else if($recent_tasks == '4 days ago') {
    $recent = __('4 days', 'wproject');
} else if($recent_tasks == '5 days ago') {
    $recent = __('5 days', 'wproject');
} else if($recent_tasks == '10 days ago') {
    $recent = __('10 days', 'wproject');
} else if($recent_tasks == '20 days ago') {
    $recent = __('20 days', 'wproject');
} else if($recent_tasks == '30 days ago') {
    $recent = __('30 days', 'wproject');
} else if($recent_tasks == '60 days ago') {
    $recent = __('60 days', 'wproject');
} else if($recent_tasks == '90 days ago') {
    $recent = __('90 days', 'wproject');
} else if($recent_tasks == '120 days ago') {
    $recent = __('120 days', 'wproject');
} else if($recent_tasks == '150 days ago') {
    $recent = __('150 days', 'wproject');
} else if($recent_tasks == '180 days ago') {
    $recent = __('180 days', 'wproject');
} else if($recent_tasks == '210 days ago') {
    $recent = __('210 days', 'wproject');
}
?>
<!--/ Start Latest Tasks /-->
<div class="tab-content tab-content-my-latest-tasks active">
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
    <form class="update-task-status-form" data-target="update_task_status" id="update-task-status-form" method="post" enctype="multipart/form-data">
    
    <div class="rows">

        <?php if(!wp_is_mobile()) { ?>
        
        <?php if($recent_tasks) { ?>
        <p class="info-line"><?php _e('My tasks from the past', 'wproject'); ?> <?php echo $recent; ?> (<a href="<?php echo home_url();?>/account"><?php _e('change', 'wproject'); ?></a>).</p>
        <?php } ?>

        <ul class="header-row">
			<li><?php _e('Task', 'wproject'); ?></li>
			<li id="sort-author"><?php _e('Task Owner', 'wproject'); ?></li>
			<li><?php _e('Task Control', 'wproject'); ?></li>
			<li><?php _e('Start', 'wproject'); ?></li>
			<li class="my-due-date-toggle toggle"><?php _e('Due', 'wproject'); ?></li>
			<li><?php _e('Status', 'wproject'); ?></li>
			<li class="filters"><i data-feather="filter"></i></li>
		</ul>

        <p class="filter-row">
            <i data-feather="filter"></i>
            <strong><?php _e('Filter', 'wproject'); ?>: <span class="filter-type"></span></strong> 
            <i data-feather="x"></i>
        </p>
        <?php } ?>
        
        <div class="tab-content-my-tasks">
        <ul class="body-rows sort-my-tasks">
            <?php 
            $args = array( 
    'post_type'         => 'task',
    'orderby'           => isset($_GET['sort_by']) && $_GET['sort_by'] == 'author' ? 'author' : 'date',
    'order'             => 'desc',
    'meta_query'        => array(
        'relation'      => 'OR',
        array(
            'key'       => 'task_owner',
            'value'     => $current_user_id,
            'compare'   => '='
        ),
        array(  
            'key'       => 'task_control',
            'value'     => $current_user_id,
            'compare'   => '='
        )
    ),
    'date_query' => array(
        array(
            'after' => $recent_tasks 
        ) 
    )
);
            $query              = new WP_Query($args);
            $i                  = 1;
            
            while ($query->have_posts()) : $query->the_post();
			
    $task_id            = get_the_ID();
    $task_owner_id      = get_post_meta($task_id, 'task_owner', true);
    $task_owner_name    = $task_owner_id ? get_the_author_meta('display_name', $task_owner_id) : __('Not assigned', 'wproject');
    $task_control_id    = get_post_meta($task_id, 'task_control', true);
    $task_control_name  = $task_control_id ? get_the_author_meta('display_name', $task_control_id) : __('Not assigned', 'wproject');
                $task_start_date    = get_post_meta($task_id, 'task_start_date', TRUE);
                $task_end_date      = get_post_meta($task_id, 'task_end_date', TRUE);
                $task_priority      = get_post_meta($task_id, 'task_priority', TRUE);
                $task_time          = get_post_meta($task_id, 'task_time', TRUE);
                $task_stop_time     = get_post_meta($task_id, 'task_stop_time', TRUE);
                $task_timer         = get_post_meta($task_id, 'task_timer', TRUE);
                $recent_tasks       = get_post_meta($task_id, 'recent_tasks', TRUE);
                $task_status        = get_post_meta($task_id, 'task_status', TRUE);
                $task_pc_complete   = get_post_meta($task_id, 'task_pc_complete', TRUE);
                $task_timer         = get_post_meta($task_id, 'task_timer', TRUE);
                $context_label      = get_post_meta($task_id, 'context_label', TRUE);
				$category = get_the_terms( $task_id, 'project' );     
				
			    if($task_status == 'complete') {
                    $the_task_status = '<i data-feather="check-circle-2"></i>' . __('Complete', 'wproject');
                } else if($task_status == 'incomplete') {
                    $the_task_status = __('Incomplete', 'wproject');
                } else if($task_status == 'on-hold') {
                    $the_task_status = __('On hold', 'wproject');
                } else if($task_status == 'in-progress') {
                    $the_task_status = __('In progress', 'wproject');
                } else {
                    $the_task_status = __('Not started', 'wproject');
                }

                if($task_start_date || $task_end_date) {
                    $new_task_start_date    = new DateTime($task_start_date);
                    $the_task_start_date    = $new_task_start_date->format($date_format);
            
                    $new_task_end_date      = new DateTime($task_end_date);
                    $the_task_end_date      = $new_task_end_date->format($date_format);
                } else {
                    $the_task_start_date    = '';
                    $the_task_end_date      = '';
                }

                $due_date = strtotime($task_end_date);
                $overdue_class = '';
                if($due_date && $now > $due_date && $task_status !='complete') {
                    $overdue_class = 'overdue';
                }

                if($i++ > 0) { /* Show latest tasks if there is more than 0... */
            ?>
            <li class="priority <?php if($task_timer == 'on') { echo 'time'; }?> <?php if($task_status == 'complete' && $minimise_complete_tasks == 'yes') { echo 'minimise'; } ?> <?php echo str_replace(' ', '-', strtolower($context_label)); ?> <?php echo $overdue_class; ?> <?php echo $task_priority; ?> <?php echo $task_status; ?> <?php if($task_spacing) { echo 'spacing'; } ?>" id="task-id-<?php echo $task_id; ?>" data-date="<?php echo strtotime($task_end_date); ?>">
                <span class="task-name">
                    <strong><a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?><?php if($task_pc_complete) { echo ' - ' . $task_pc_complete; ?><?php _e('%', 'wproject'); } ?></a></strong>
                    <em>
                        <?php 
                        $terms = get_the_terms( $task_id , 'project' );
                        if($terms !='') {
                        foreach ( $terms as $term ) { ?>
                            <a href="<?php echo home_url()  . '/project/' . $term->slug; ?>"><?php echo $term->name; ?></a>
                        <?php } 
                        }  else {
                            _e('No project', 'wproject');
                        } ?>
                    </em>

                    <?php if($context_label) { ?>
                        <em class="context-label">
                            <?php echo $context_label; ?>
                        </em>
                    <?php } ?>

                </span>

                <!-- Display Task Owner's Name -->
                 <span class="task-owner">
        <em><?php echo esc_html($task_owner_name); ?></em>
    </span>

    <!-- Display Task Control User's Name -->
    <span class="task-control">
        <em><?php echo get_task_control_info($task_id); ?></em>
    </span>

                <?php if($task_start_date) { ?>
                    <span class="date due-date <?php echo $overdue_class; ?>"><?php echo $the_task_start_date; ?></span>
                <?php } else { ?>
                    <?php if(!wp_is_mobile()) { ?>
                    <span></span>
                    <?php } ?>
                <?php } ?>
                
                <?php if($task_end_date) { ?>
                    <span class="date due-date <?php echo $overdue_class; ?>"><?php echo $the_task_end_date; ?></span>
                <?php } else { ?>
                    <?php if(!wp_is_mobile()) { ?>
                    <span></span>
                    <?php } ?>
                <?php } ?>

                <span><em class="status status-<?php echo $task_id; ?> <?php echo $task_status; ?>"><?php echo $the_task_status; ?></em></span>
                
                <span class="task-status-container" data="<?php echo $term->term_id; ?>">
                        <b class="task-status">

                        <?php if($task_timer != 'on') { ?>

                        <i data-feather="circle-ellipsis"></i>
                        <em>
                            <?php if(wp_is_mobile()) { ?>
                                <small class="task-title task-title-<?php echo $task_priority; ?>"><?php echo get_the_title(); ?></small>
                            <?php } ?>
                            <small value="complete" data="<?php echo $task_id; ?>" data-status="<?php _e('Complete', 'wproject'); ?>" <?php if($task_status == 'complete') { echo 'class="disabled"'; } ?>><i data-feather="check-circle-2"></i><?php _e('Complete', 'wproject'); ?></small>
                            <small class="delete" value="delete" data="<?php echo $task_id; ?>" data-status="<?php _e('Delete', 'wproject'); ?>"><i data-feather="x-circle"></i><?php _e('Delete', 'wproject'); ?></small>
                            <small value="incomplete" data="<?php echo $task_id; ?>" data-status="<?php _e('Incomplete', 'wproject'); ?>" <?php if($task_status == 'incomplete') { echo 'class="disabled"'; } ?>><i data-feather="minus-circle"></i><?php _e('Incomplete', 'wproject'); ?></small>
                            <small value="in-progress" data="<?php echo $task_id; ?>" data-status="<?php _e('In progress', 'wproject'); ?>" <?php if($task_status == 'in-progress') { echo 'class="disabled"'; } ?>><i data-feather="arrow-right-circle"></i><?php _e('In progress', 'wproject'); ?></small>
                            <small value="not-started" data="<?php echo $task_id; ?>" data-status="<?php _e('Not started', 'wproject'); ?>" <?php if($task_status == 'not-started') { echo 'class="disabled"'; } ?>><i data-feather="stop-circle"></i><?php _e('Not started', 'wproject'); ?></small>
                            <small value="on-hold" data="<?php echo $task_id; ?>" data-status="<?php _e('On hold', 'wproject'); ?>" <?php if($task_status == 'on-hold') { echo 'class="disabled"'; } ?>><i data-feather="pause-circle"></i><?php _e('On hold', 'wproject'); ?></small>
                        </em>

                        <?php } else { ?>

                            <a href="<?php echo get_the_permalink(); ?>">
                                <!-- <i data-feather="clock"></i> -->
                                <img src="<?php echo get_template_directory_uri();?>/images/clock.svg" class="timing" />
                            </a>
                        <?php } ?>

                        
                    </b>
                </span>

            </li>
            <?php } else {  /* ...otherwise show this message */ ?>
                <li class="no-tasks">
                    <p><i data-feather="thumbs-up"></i><strong><?php _e( 'You have no recent tasks.', 'wproject' ); ?></strong></p>
                </li>
            <?php }
            endwhile;
            wp_reset_postdata(); ?>
        </ul>
        </div>

        <script>
            jQuery( document ).ready(function() {
                $('.task-status em small').click(function() {
                    var changed_status = $(this).attr('value');
                    var changed_status_id = $(this).attr('data');

                    if(changed_status == 'delete') {
                        $('#task-id-'+changed_status_id).remove();
                    }
                });

                // Add click event for Task Owner tab
                $('#sort-author').click(function() {
                    const urlParams = new URLSearchParams(window.location.search);
                    urlParams.set('sort_by', 'author');
                    window.location.search = urlParams.toString();
                });
            });
        </script>
       
        <?php due_date_sorting(); ?>
        
    </div>

    <input type="hidden" id="task_id" name="task_id" />
    <input type="hidden" id="task_status" name="task_status" />

    </form>

    <?php task_filter() ?>

    <script>
        /* Set cookie for the selected view */
        $('.filter-selection li').click(function() {
            let my_tasks_view = $(this).attr('data');
            Cookies.set('my_tasks_view', my_tasks_view);
        });
        $( document ).ready(function() {
            var my_tasks_view_cookie = Cookies.get('my_tasks_view');
            if(Cookies.get('my_tasks_view')) {
                //console.log(my_tasks_view_cookie);
                $('.tab-content-my-tasks li').hide();
                $('.tab-content-my-tasks li.'+my_tasks_view_cookie).show();
            } if(Cookies.get('my_tasks_view') == 'all') {
                $('.tab-content-my-tasks li').show();
            }

            <?php if(is_front_page()) { ?>
                if(Cookies.get('my_tasks_view') == 'all') {
                    $('.tab-content-my-tasks li').show();
                } else if(Cookies.get('my_tasks_view') == 'incomplete') {
                    $('.tab-content-my-tasks li').hide();
                    $('.tab-content-my-tasks .incomplete, .tab-content-my-tasks .not-started, .tab-content-my-tasks .in-progress').show();
                } else if (Cookies.get('my_tasks_view') == undefined) {
                    $('.tab-content-my-tasks li').show();
                } else {
                    $('.tab-content-my-tasks li').hide();
                    $('.tab-content-my-tasks li.'+my_tasks_view_cookie).show();
                }
                
            <?php } ?>
        });
    </script>


</div>
<!--/ End Latest Tasks /-->

<?php /* Help topics */
function my_latest_tasks_help() {

    $user       = wp_get_current_user();
    $user_role  = $user->roles[0];

    if($user_role == 'administrator' || $user_role == 'project_manager' || $user_role == 'team_member'|| $user_role == 'inspector') {

?>
    <h4><?php _e('My latest tasks', 'wproject'); ?></h4>
    <p><?php _e('Tasks that you have recently created or have been recently assigned to you.', 'wproject'); ?></p>
<?php }
}
add_action('help_end', 'my_latest_tasks_help');
