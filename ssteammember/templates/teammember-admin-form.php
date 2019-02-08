<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2/8/2019
 * Time: 3:46 PM
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}; ?>

<div class="sscbox" id="frmAddMateri">
    <p class="ss-field">
        <label for="<?php echo $pluginName . "_position"; ?>"><?php echo __( 'Position' ); ?></label>
        <input type="text" class="soal regular-text" name="<?php echo $pluginName . "_position"; ?>"
               id="<?php echo $pluginName . "_position"; ?>"
               value="<?php echo get_post_meta( $post_id, $pluginName . "_position", true ); ?>"
               required>
    </p>
    <p class="ss-field">
        <label for="<?php echo $pluginName . "_email"; ?>"><?php echo __( 'Email' ); ?></label>
        <input type="email" class="<?php echo $pluginName . "_email"; ?> regular-text"
               name="<?php echo $pluginName . "_email"; ?>"
               id="<?php echo $pluginName . "_email"; ?>"
               value="<?php echo get_post_meta( $post_id, $pluginName . "_email", true ); ?>"
               required/>
    </p>
    <p class="ss-field">
        <label for="<?php echo $pluginName . "_website"; ?>"><?php echo __( 'Website' ); ?></label>
        <input type="url" class="<?php echo $pluginName . "_website"; ?> regular-text"
               name="<?php echo $pluginName . "_website"; ?>"
               id="<?php echo $pluginName . "_website"; ?>"
               value="<?php echo get_post_meta( $post_id, $pluginName . "_website", true ); ?>"
               required/>
    </p>
    <p class="ss-field">
        <label for="<?php echo $pluginName . "_image"; ?>"><?php echo __( 'Image' ); ?></label>
    <div class="pimg">
		<?php $ssimageid = get_post_meta( $post_id, $pluginName . "_image_id", true ); ?>
        <div class="imgprev <?php echo ! $ssimageid ? "hidden" : ""; ?>">
            <img src="<?php echo $ssimageid ? wp_get_attachment_image_url( $ssimageid ) : ""; ?>"/>
            <input type="hidden" name="<?php echo $pluginName . "_image_id"; ?>"
                   value="<?php echo $ssimageid; ?>"/>
            <a href="#" class="rimage">X</a>
        </div>
        <button type="button" class="imgselect button"><?php echo __( 'Select Image' ); ?></button>
    </div>
    </p>
</div>