<?php
/**
 * @file
 * Bootstrap 12 template for Display Suite.
 */ 
 $background_image = !empty($field_image[0]['uri']) ? file_create_url($field_image[0]['uri']) : '';
 //$background_image = !empty($field_image[0]['uri']) ? image_style_url('large', $field_image[0]['uri']) : '';
?>

<<?php print $layout_wrapper; print $layout_attributes; ?> class="<?php print $classes; ?>">
  <?php if (isset($title_suffix['contextual_links'])): ?>
    <?php print render($title_suffix['contextual_links']); ?>
  <?php endif; ?>
  <div class="container">
    <div class="row clearfix">
      <<?php print $central_wrapper; ?> class="col-sm-12 <?php print $central_classes; ?>">
        <div class="container-fluid"><?php print $central; ?></div>
      </<?php print $central_wrapper; ?>>
    </div>
  </div>
  <?php if(!empty($background_image)): ?>
    <div class="blurred-background"><div id="blur-target-<?php print $field_image[0]['fid']; ?>" class="blurred-background-inner"><div id="blur-source-<?php print $field_image[0]['fid']; ?>" class="blur" style="background-image: url('<?php print $background_image; ?>');"></div></div></div>
  <?php endif; ?>
</<?php print $layout_wrapper ?>>


<!-- Needed to activate display suite support on forms -->
<?php if (!empty($drupal_render_children)): ?>
  <?php print $drupal_render_children ?>
<?php endif; ?>
