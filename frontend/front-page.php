<?php get_header(); 
$print = isset($_GET['print']) ? esc_html($_GET['print']) : '';
?>

<div class="container">

    <?php 
        get_template_part('inc/left');
        get_template_part('inc/home');
        
        if(empty(esc_html($print))) {
            get_template_part('inc/right');   
        }
        
        if(empty(esc_html($print))) {
            get_template_part('inc/help');
        }
    ?> 

</div>
<?php get_footer(); ?>