<?php if ( $this->checkSettings($notices) ): ?>
<form id="phcfxw2l-form" method="post" action="<?php echo admin_url('admin-post.php') ?>">
  <?php
   // get stored settings
  $settings = get_option(PHCWEB2LEAD_PLUGIN_NAME);

  // render our form fields
  foreach ($settings['form'] as $id => $opts): ?>
  <div class="form-field" style="display: <?php echo $opts['included'] ? '' : 'none' ?>">
    <label for="<?php echo $id ?>">
      <?php echo empty($opts['label']) ? $this->options['form'][$id]['label'] : $opts['label'] ?>
      <sup class="text-error"><?php echo $opts['required'] ? '*' : ''?></sup>
    </label>
    <br>
    <?php switch ($opts['type']) {
      case 'text':
      case 'email':
      case 'url':
        ?><input id="<?php echo $id ?>" type="<?php echo $opts['type'] ?>" name="<?php echo $id ?>" <?php echo empty($opts['pattern']) ? '' : "pattern=\"{$opts['pattern']}\"" ?> <?php echo empty($opts['placeholder']) ? '' : "placeholder=\"{$opts['placeholder']}\"" ?> <?php echo ($opts['included'] && $opts['required']) ? 'required' : '' ?>><?php
        break;
      case 'textarea':
        ?><textarea rows="6" name="<?php echo $id ?>" <?php echo ($opts['included'] && $opts['required']) ? 'required' : '' ?>></textarea><?php
        break;
      }
    ?>
  </div>
  <?php endforeach ?>

  <?php wp_nonce_field('phcfxw2l'); ?>
  <input name="action" value="w2lsubmit" type="hidden">

  <input class="buttons" type="submit" value="Send">
  <span id="spinner" style="display: none;"></span>
</form>
<?php endif ?>

<!-- display feedback to the user in this section -->
<div id="phcfxw2l-feedback"></div>

<style type="text/css">

  /* spinner */
  #spinner {
    background: url('<?php echo plugins_url('images/refresh.png', __FILE__) ?>') no-repeat center;
    padding-left: 24px;
    padding-top: 12px;
  }

  /* style our form */
  #phcfxw2l-form label {
    font-weight: bold;
  }

  #phcfxw2l-form div.form-field {
    margin-bottom: 1em;
  }

  /* form fields */
  #phcfxw2l-form input.submitted:required,
  #phcfxw2l-form input.submitted:invalid,

  #phcfxw2l-form textarea.submitted:required,
  #phcfxw2l-form textarea.submitted:invalid {
    box-shadow: 0 0 5px #D45252;
    border-color: #B03535;
  }

  #phcfxw2l-form input.submitted:valid,
  #phcfxw2l-form input.submitted:focus:valid,

  #phcfxw2l-form textarea.submitted:valid {
    box-shadow: 0 0 5px #52D47B;
    border-color: #5DB035;
  }

  #phcfxw2l-feedback { margin: 2em; }

  /* notices */
  .alert {
    border: 0 solid rgba(0, 0, 0, 0);
    margin-bottom: 20px;
    padding: 10px;
  }

  .alert-success {
    color: #3C763D;
    background-color: #DFF0D8;
    border-color: #D6E9C6;
    border-left-color: #3C763D;
    border-left-width: 5px;
  }

  .alert-error {
    color: #A94442;
    background-color: #F2DEDE;
    border-color: #EBCCD1;
    border-left-color: #A94442;
    border-left-width: 5px;
  }

  .alert p {
    margin-bottom: 5px;
  }

  .text-success {
    color: #3C763D;
  }

  .text-error {
    color: #A94442;
  }

  .spin {
    -animation: spin .7s infinite linear;
    -webkit-animation: spin2 .7s infinite linear;
  }

  @-webkit-keyframes spin2 {
    from { -webkit-transform: rotate(0deg);}
    to { -webkit-transform: rotate(360deg);}
  }

  @keyframes spin {
    from { transform: scale(1) rotate(0deg);}
    to { transform: scale(1) rotate(360deg);}
  }

</style>