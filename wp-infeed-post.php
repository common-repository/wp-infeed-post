<?php
/*
Plugin Name: WP Infeed Post
Plugin URI: http://tkmserver.xsrv.jp/uploads/wp-infeed-post
Description: インフィード広告を挿入可能な新着記事表示プラグイン
Author: Takuma Hirotsu
Version: 1.0
Author URI: http://tkmserver.xsrv.jp
LIcense:GPL2
*/

/*  Copyright 2017 Takuma Hirotsu (email : hirotsu2625@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
	published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

register_uninstall_hook(__FILE__, 'WP_Infeed_Post_Uninstall'  ); 

function WP_Infeed_Post_Uninstall() {
          delete_option( 'my_title_size' );
          delete_option( 'my_title_color' );
          delete_option( 'my_cat_color' );
          delete_option( 'my_cat_back_color' );
          delete_option( 'my_date_color' );
          delete_option( 'my_underline_color' );
}

add_action('admin_menu','add_wp_infeed_post');
function add_wp_infeed_post(){
   add_menu_page(
    'WP Infeed Post',//ページタイトル
    'WP Infeed Post',//メニュータイトル
    'administrator',//権限
    'wp-infeed-post',//メニューslug,slugはハイフン区切り
    'display_wp_infeed_post',//実行される関数
    '',//アイコンURL
    81 //設定の後のポジション
  );
}

//独自設定ページ
function display_wp_infeed_post(){
?>
<h2 style="font-size:26px;">WP Infeed Post Settings</h2>
<?php 
     // POSTデータがあれば設定を更新
    if ( !empty($_POST['my_title_size']) && check_admin_referer( 'wp_infeed_post_action', 'wp_infeed_post_field' ) ) {
      // nonceの検証
  			$nonce = $_REQUEST['_wpnonce'];
 			if ( wp_verify_nonce( $nonce, 'wp_infeed_post_nonce' ) ) {

			$error_msg = '<div id="setting-error-settings_updated" class="error settings-error notice is-dismissible"><p><strong>不正な入力値です。</strong></p></div>';
          	$update_msg = '<div class="updated settings-error notice is-dismissible"><p><strong>設定を保存しました。</strong></p></div>';
          
          	if( ctype_digit(strval($_POST['my_title_size'])) == true 
            || sanitize_hex_color( $_POST['my_title_color']) == true
            || sanitize_hex_color( $_POST['my_cat_color']) == true
            || sanitize_hex_color( $_POST['my_cat_back_color']) == true
            || sanitize_hex_color( $_POST['my_date_color']) == true
            || sanitize_hex_color( $_POST['my_underline_color']) == true ){
            echo $update_msg;
          }
          
          if(ctype_digit(strval($_POST['my_title_size'])) == false && empty($_POST['my_title_size']) == false
            || sanitize_hex_color( $_POST['my_title_color']) == false && empty($_POST['my_title_color']) == false
            || sanitize_hex_color( $_POST['my_cat_color']) == false && empty($_POST['my_cat_color']) == false
            || sanitize_hex_color( $_POST['my_cat_back_color']) == false && empty($_POST['my_cat_back_color']) == false
            || sanitize_hex_color( $_POST['my_date_color']) == false && empty($_POST['my_date_color']) == false
            || sanitize_hex_color( $_POST['my_underline_color']) == false && empty($_POST['my_underline_color']) == false){
            echo $error_msg;
          }
   
								//バリデーション
          			if ( ctype_digit(strval($_POST['my_title_size'])) == true || empty($_POST['my_title_size']) == true){
                  update_option('my_title_size',(int)$_POST['my_title_size']);
                } else {
                  $msg = 'セキュリティーチェック エラー';
                  $alert = 'alert-danger';
   							}
                  
                if ( sanitize_hex_color( $_POST['my_title_color']) == true || empty($_POST['my_title_color']) == true){
                  update_option('my_title_color',sanitize_hex_color( $_POST['my_title_color']));
                } else {
                  $msg = 'セキュリティーチェック エラー';
                  $alert = 'alert-danger';
   							}
          
          			if ( sanitize_hex_color( $_POST['my_cat_color']) == true || empty($_POST['my_cat_color']) == true){
                  update_option('my_cat_color',sanitize_hex_color( $_POST['my_cat_color']));
                }else {
                  $msg = 'セキュリティーチェック エラー';
                  $alert = 'alert-danger';
   							}
          			
          			if ( sanitize_hex_color( $_POST['my_cat_back_color']) == true || empty($_POST['my_cat_back_color']) == true){
                  update_option('my_cat_back_color',sanitize_hex_color( $_POST['my_cat_back_color']));
                } else {
                  $msg = 'セキュリティーチェック エラー';
                  $alert = 'alert-danger';
   							} 
          
          			if ( sanitize_hex_color( $_POST['my_date_color']) == true || empty($_POST['my_date_color']) == true){
                 update_option('my_date_color',sanitize_hex_color( $_POST['my_date_color']));
                } else {
                  $msg = 'セキュリティーチェック エラー';
                  $alert = 'alert-danger';
   				}
          
          			if ( sanitize_hex_color( $_POST['my_underline_color']) == true || empty($_POST['my_underline_color']) == true){
                  update_option('my_underline_color',sanitize_hex_color( $_POST['my_underline_color']));
                } else {
                  $msg = 'セキュリティーチェック エラー';
                  $alert = 'alert-danger';
   				} 
   		}
    }
 ?>
<?php include_once('views/wp-infeed-post-options.php'); ?>
<?php
}

class WP_Infeed_Post_Widget extends WP_Widget {
  function WP_Infeed_Post_Widget() {
      parent::WP_Widget(false, $name = 'WP Infeed Post', array( 'description' => '自由なデザインが可能な新着記事一覧。インフィード広告を挿入可能。', ) );  
    }
    function widget($args, $instance) {    
      //ウィジェットタイトル出力
      extract( $args );
   		 if($instance['title'] != ''){
 		       $title = apply_filters('widget_title', $instance['title']);
  	   }
    	 echo $before_widget;
   		 if( $title ){
     		   echo $before_title . $title . $after_title;
  	   }
      ?>
    <style><?php include_once('style/wp-infeed-post.css'); ?></style>
	  <?php include_once('views/wp-infeed-post-widget.php'); ?>	
        <?php
    }
  
    function update($new_instance, $old_instance) {        
  $instance = $old_instance;
  $instance['title'] = strip_tags($new_instance['title']);
  $instance['limit'] = is_numeric($new_instance['limit']) ? $new_instance['limit'] : 5;
  $instance['width'] = is_numeric($new_instance['width']) ? $new_instance['width'] : 50;
  $instance['height'] = is_numeric($new_instance['height']) ? $new_instance['height'] : 50;
  $instance['order1'] = is_numeric($new_instance['order1']) ? $new_instance['order1'] : 1;
  $instance['order2'] = is_numeric($new_instance['order2']) ? $new_instance['order2'] : 2;      
  $instance['ad1'] = $new_instance['ad1'] ; 
  $instance['ad2'] = $new_instance['ad2'] ; 
  $instance['date'] = isset($new_instance['date']);
  $instance['cat'] = isset($new_instance['cat']);
  $instance['new'] = isset($new_instance['new']);
  $instance['title_hidden'] = isset($new_instance['title_hidden']);
  $instance['underline'] = isset($new_instance['underline']);
        return $instance;
    }
    function form($instance) {
        ?>
<p>
        <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
        <input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>">
  					 <br>
             <br>
        <label for="<?php echo $this->get_field_id('title_hidden'); ?>"><?php _e('タイトルを折り返さない:'); ?></label>
        <input id="<?php echo $this->get_field_id('title_hidden'); ?>" name="<?php echo $this->get_field_name('title_hidden'); ?>" type="checkbox" <?php checked(isset($instance['title_hidden']) ? $instance['title_hidden'] : 0); ?> />
             <br>
             <br>
        <label for="<?php echo $this->get_field_id('limit'); ?>"><?php _e('表示する投稿数:'); ?></label>
        <input type="text" id="<?php echo $this->get_field_id('limit'); ?>" name="<?php echo $this->get_field_name('limit'); ?>" value="<?php echo esc_attr( $instance['limit'] ); ?>" size="3">
             <br>
             <br>
         <label for="<?php echo $this->get_field_id('width'); ?>"><?php _e('アイキャッチ画像横幅:'); ?></label>
        <input type="text" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" value="<?php echo esc_attr( $instance['width'] ); ?>" size="3">px
             <br>
             <br>
        <label for="<?php echo $this->get_field_id('height'); ?>"><?php _e('アイキャッチ画像高さ:'); ?></label>
        <input type="text" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" value="<?php echo esc_attr( $instance['height'] ); ?>" size="3">px
             <br>
             <br>
        <label for="<?php echo $this->get_field_id('new'); ?>"><?php _e('NEW!マークの表示:'); ?></label>
        <input id="<?php echo $this->get_field_id('new'); ?>" name="<?php echo $this->get_field_name('new'); ?>" type="checkbox" <?php checked(isset($instance['new']) ? $instance['new'] : 0); ?> />
             <br>
             <br>
        <label for="<?php echo $this->get_field_id('cat'); ?>"><?php _e('カテゴリーの表示:'); ?></label>
        <input id="<?php echo $this->get_field_id('cat'); ?>" name="<?php echo $this->get_field_name('cat'); ?>" type="checkbox" <?php checked(isset($instance['cat']) ? $instance['cat'] : 0); ?> />
             <br>
             <br>
        <label for="<?php echo $this->get_field_id('date'); ?>"><?php _e('日付の表示:'); ?></label>
        <input id="<?php echo $this->get_field_id('date'); ?>" name="<?php echo $this->get_field_name('date'); ?>" type="checkbox" <?php checked(isset($instance['date']) ? $instance['date'] : 0); ?> />
             <br>
             <br>
    	<label for="<?php echo $this->get_field_id('underline'); ?>"><?php _e('下線の表示:'); ?></label>
        <input id="<?php echo $this->get_field_id('underline'); ?>" name="<?php echo $this->get_field_name('underline'); ?>" type="checkbox" <?php checked(isset($instance['underline']) ? $instance['underline'] : 0); ?> />
             <br>
             <br>
        <label for="<?php echo $this->get_field_id('order1'); ?>"><?php _e('アドセンス表示位置①(数字で指定):'); ?></label>
        <input type="text" id="<?php echo $this->get_field_id('order1'); ?>" name="<?php echo $this->get_field_name('order1'); ?>" value="<?php echo esc_attr( $instance['order1'] ); ?>" size="3">
             <br>
             <br>
         <label for="<?php echo $this->get_field_id('ad1'); ?>"><?php _e('アドセンスコード①:'); ?></label>
        <textarea class="widefat" rows="10" cols="20" id="<?php echo $this->get_field_id('ad1'); ?>" name="<?php echo $this->get_field_name('ad1'); ?>"><?php echo esc_textarea($instance['ad1']) ; ?></textarea>
             <br>
             <br>
        <label for="<?php echo $this->get_field_id('order2'); ?>"><?php _e('アドセンス表示位置②(数字で指定):'); ?></label>
        <input type="text" id="<?php echo $this->get_field_id('order2'); ?>" name="<?php echo $this->get_field_name('order2'); ?>" value="<?php echo esc_attr( $instance['order2'] ); ?>" size="3">
             <br>
             <br> 
        <label for="<?php echo $this->get_field_id('ad2'); ?>"><?php _e('アドセンスコード②:'); ?></label>
        <textarea class="widefat" rows="10" cols="20" id="<?php echo $this->get_field_id('ad2'); ?>" name="<?php echo $this->get_field_name('ad2'); ?>"><?php echo esc_textarea($instance['ad2']) ; ?></textarea>
</p>
        <?php 
    }
}
add_action( 'widgets_init', function(){
     register_widget( 'WP_Infeed_Post_Widget' );
});

//カラーピッカーの生成関数
function wp_infeed_post_genelate_color_picker($name, $value, $label){?>
  <p><label for="<?php echo $name; ?>"><?php echo $label; ?></label></p>
  <p><input type="text" name="<?php echo $name; ?>" value="<?php echo $value; ?>" ></p>
  <?php wp_enqueue_script( 'wp-color-picker' );
  $data = '(function( $ ) {
      var options = {
          defaultColor: false,
          change: function(event, ui){},
          clear: function() {},
          hide: true,
          palettes: true
      };
      $("input:text[name='.$name.']").wpColorPicker(options);
  })( jQuery );';
    wp_add_inline_script( 'wp-color-picker', $data, 'after' ) ;
}
add_action('admin_print_styles', 'wp_infeed_post_color_picker');
function wp_infeed_post_color_picker() {
 wp_enqueue_style( 'wp-color-picker' );
}
					
?>