<div class="widget">
  <?php
        query_posts("showposts=".$instance['limit']);
  ?>
  	<?php if (have_posts()) : while (have_posts()) : the_post(); $loop_count++;?>
     <div ontouchstart="" class="wp-infeed-post-loopbox">
    	<a href="<?php the_permalink(); ?>">
        <div style="overflow:hidden;">
          <!--サムネイル-->
          <?php if( has_post_thumbnail() ): ?>
          	<div class="wp-infeed-post-img" style="width:<?php echo esc_attr( $instance['width'] ); ?>px; height:<?php echo esc_attr( $instance['height'] ); ?>px;" >
              <?php the_post_thumbnail(array( 'class' => 'wp-infeed-post-img' )); ?>
          	</div>
          <?php endif; ?>        
               
          <!--記事タイトル--><div class="wp-infeed-post-title <?PHP if ( $instance['title_hidden'] == 1 ){ echo 'wp-infeed-post-title_hidden'; } ?>" style="color:<?php echo get_site_option('my_title_color'); ?>; font-size:<?php echo get_site_option('my_title_size'); ?>px;" ><?php the_title(); ?></div>
          
           <!--new!マーク表示-->
          <?PHP if ( $instance['new'] == 1 ) : ?>
          	<?php
            	$days = 7; //Newを表示させたい期間の日数
            	$today = date_i18n('U');
            	$entry = get_the_time('U');
            	$kiji = date('U',($today - $entry)) / 86400 ;
            	if( $days > $kiji ){
            		echo '<div class="wp-infeed-post-new">New!</div>';
            	}
          	?>
          <?php endif; ?>
          
          <!--カテゴリー-->
          <?PHP if ( $instance['cat'] == 1 ) : ?>
          	<?php
            	$cat = get_the_category();
           	  $catname = $cat[0]->cat_name; //カテゴリー名を取得
          	  $catslug = $cat[0]->slug; //スラッグ名を取得
            ?>
          <div class="wp-infeed-post-<?php echo $catslug; ?> wp-infeed-post-cat-all" style="color:<?php echo get_site_option('my_cat_color'); ?>; background:<?php echo get_site_option('my_cat_back_color'); ?>;" ><?php echo $catname; ?></div>
          <?php endif; ?>   
          
          <!--日付-->
          <?PHP if ( $instance['date'] == 1 ) : ?>
                 <div class="wp-infeed-post-date" style="color:<?php echo get_site_option('my_date_color'); ?>; "><?php echo get_the_date(); ?></div>
          <?php endif; ?>   

          </div><!--overflow-hidden-->
          
          <!--下線-->
          <?PHP if ( $instance['underline'] == 1 ): ?>
          		<hr style="background-color:<?php echo get_site_option('my_underline_color'); ?>;" class="wp-infeed-post-underline" >
          <?php elseif ( $instance['underline'] == 0 ): ?>
        			<hr class="wp-infeed-post-transparent" style="display:none;">
          <?php endif; ?> 
     </a>
  </div><!--loopbox-->
          
          <!--グーグルアドセンス①-->
          <?php if ( $loop_count == $instance['order1'] ) : ?>
             		<?php echo $instance['ad1'];  ?>
                <?php if (!empty($instance['ad1'])) { ?>
									<hr style="margin-top:-5px; margin-bottom:5px;">
								<?php } ?>
          <?php endif; ?>
           <!--グーグルアドセンス②-->
          <?php if ( $loop_count == $instance['order2']  ) : ?>
            	 	<?php echo $instance['ad2'];  ?>
                <?php if (!empty($instance['ad2'])) { ?>
									<hr style="margin-top:-5px; margin-bottom:5px;">
								<?php } ?>
         	<?php endif; ?>

      <?php endwhile; else: ?>
      	<p>記事がありません</p>
      <?php endif; ?>
  
	</div><!--class-widget-->
<?php wp_reset_query(); ?><!--リセット処理-->