<form method="post" action="<?php echo wp_nonce_url( esc_url( $_SERVER['REQUEST_URI'] ), 'wp_infeed_post_nonce' ); ?>" >
<table class="form-table">
    <tr>
        <th scope="row"><label for="my_title_size">タイトルの大きさ(必須)</label></th>
        <td><input name="my_title_size" type="text" id="my_title_size" value="<?php form_option('my_title_size'); ?>"　size="3" maxlength="2" />px</td>
    </tr>
    <tr>
        <th scope="row">タイトル文字色</th>
        <td>
          <label><?php
  wp_infeed_post_genelate_color_picker(
    'my_title_color', 
    get_option('my_title_color'), 
    '' //説明文
  );
?>
          </label>
        </td>
    </tr>
    <tr>
        <th scope="row">カテゴリー文字色</th>
        <td>
          <label><?php
  wp_infeed_post_genelate_color_picker(
    'my_cat_color', 
    get_option('my_cat_color'), 
    '' //説明文
  );
?>
          </label>
        </td>
    </tr>
    <tr>
        <th scope="row">カテゴリー背景色</th>
        <td>
          <label><?php
  wp_infeed_post_genelate_color_picker(
    'my_cat_back_color', 
    get_option('my_cat_back_color'), 
    '' //説明文
  );
?>
          </label>
        </td>
    </tr>
    <tr>
        <th scope="row">日付文字色</th>
        <td>
          <label><?php
  wp_infeed_post_genelate_color_picker(
    'my_date_color', 
    get_option('my_date_color'), 
    '' //説明文
  );
?>
          </label>
        </td>
    </tr>
    <tr>
        <th scope="row">下線の色</th>
        <td>
          <label><?php
  wp_infeed_post_genelate_color_picker(
    'my_underline_color', 
    get_option('my_underline_color'), 
    '' //説明文
  );
?>
          </label>
        </td>
    </tr>
</table>
<?php submit_button(); ?>
<?php wp_nonce_field( 'wp_infeed_post_action','wp_infeed_post_field' ); ?>
</form>