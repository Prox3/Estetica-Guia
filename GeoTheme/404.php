<?php get_header(); ?>
	<div id="wrapper" class="clearfix">
		<div id="inner_pages" class="clearfix" >
			<h1 style="display:table;"><?php echo ERROR_404_NAME; ?></h1>   
			<div class="breadcrumb clearfix">
				<?php if ( get_option( 'ptthemes_breadcrumbs' )) {  ?>
					<div class="breadcrumb_in"><?php if(function_exists('bcn_display')){bcn_display();} ?></div>
				<?php } ?>
			</div>
            <div class="clearfix"></div>
			<div id="content">                     
				<img src="<?php bloginfo('template_directory'); ?>/images/404.png" alt=""  />
			</div> 
            <!-- content  #end -->
	<?php get_sidebar(); ?>
<?php get_footer(); ?>
