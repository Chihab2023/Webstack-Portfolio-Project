<?php $current_date = date_i18n(get_option('date_format')); 
$author_id  = get_current_user_id();
$first_name = get_the_author_meta( 'first_name', $author_id );
?>

<div id="date-time">

    <p><strong><?php _e('Welcome back', 'wproject'); ?>, <?php echo $first_name; ?>.</strong></p>

    <p class="dt-wrapper">
        <span class="the-date">
            <i data-feather="calendar"></i>
            <em><?php echo $current_date; ?></em>
        </span>
        <span class="the-time">
            <i data-feather="clock"></i>
            <em><?php echo $current_date; ?></em>
        </span>
    </p>

</div>

<script>
    $( document ).ready(function() {
        function updateCurrentTime() {
            var currentTime = moment().format('h:mm:ss');
            $('.the-time em').text(currentTime);
        }
        updateCurrentTime();
        setInterval(updateCurrentTime, 1000);
    });
</script>