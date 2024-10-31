<?php
  // check what settings tab to display
  $tab = isset($_GET['tab']) ? $_GET['tab'] : 'backend';
?>

<div class="wrap">

  <!-- plugin's header and description -->
  <div style="width: 70%" class="alignleft">
    <h2><?php echo PLUGIN_NAME ?> Settings</h2>
    <br>
    <a href="http://en.phcfx.com/products/phc-crm-fx/" target="_blank" title="PHC FX CRM" class="alignleft" style="margin-right: 20px;">
      <img src="<?php echo plugins_url('images/phcfx-crm.png', __FILE__) ?>">
    </a>

    <h4>Never loose a deal again!</h4>
    <p class="description"><strong><?php echo PLUGIN_NAME ?></strong> helps you to build a contact form that you can use in your business website.
    When a user sends out information through the form, it will be stored directly into your PHC CRM FX as a lead contact. This way you know that
    potencial deals will have the proper attention and your lead won't be lost in your inbox!</p>

    <div class="clear"></div>
    <p>Don't forget to <strong>save your settings</strong> when all done!</p>
  </div>

  <div style="width: 20%" class="postbox alignright">
    <div style="border-bottom: 1px solid lightgray;">
      <h3 style="padding: 0 10px">How to Use ?</h3>
    </div>
    <div style="padding: 0 10px;">
      <blockquote>
        <p class="description">Just copy and paste the <strong>[phcfxw2l]</strong> shortcode into your post(s)/page(s) where you want the form to be displayed.</p>
      </blockquote>
      <p>Thats it! :) Enjoy!!</p>
    </div>
  </div>

  <div class="clear"></div>

  <h2 class="nav-tab-wrapper">
    <a href="?page=<?php echo PHCWEB2LEAD_PLUGIN_NAME ?>&tab=backend" class="nav-tab <?php echo $tab==='backend' ? 'nav-tab-active' : '' ?>">Backend Options</a>
    <a href="?page=<?php echo PHCWEB2LEAD_PLUGIN_NAME ?>&tab=form"    class="nav-tab <?php echo $tab==='form'    ? 'nav-tab-active' : '' ?>">Form Field Options</a>
  </h2>

  <form method="post" action="options.php">
    <div class="<?php echo $tab==='backend' ? '' : 'hidden' ?>">
    <?php
      settings_fields('backend-options');
      include(PHCWEB2LEAD_PLUGIN_DIR.'/settings/backend.php');
    ?>
    </div>

    <div class="<?php echo $tab==='form' ? '' : 'hidden' ?>">
    <?php
      settings_fields('form-options');
      include(PHCWEB2LEAD_PLUGIN_DIR.'/settings/form-fields.php');
    ?>
    </div>

    <?php submit_button(); ?>
  </form>
</div>

<div class="clear"></div>
