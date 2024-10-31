<h3>PHC FX Backend Configurations</h3>

<table class="form-table">
  <tbody>
  <?php
    // get stored settings
    $settings = get_option(PHCWEB2LEAD_PLUGIN_NAME);

    // check required ones
    $required = array();
    foreach ($this->options['backend'] as $id => $opts)
      if ($opts['required']) $required[] = "<code>{$opts['label']}</code>";

    ?><p>Provide the info bellow so that the plugin can talk to your PHC FX backend installation.<br>
    <?php echo implode(', ', $required) ?> are required to be setup!</p><?php

    // display the options
    foreach ($this->options['backend'] as $id => $opts):
      $name  = sprintf(PHCWEB2LEAD_PLUGIN_NAME.'[backend][%s]', $id);
      $value = isset($settings['backend'][$id]) ? $settings['backend'][$id] : null;
  ?>
    <tr>
      <th scope="row">
        <label for="<?php echo $id ?>"><?php echo $opts['label'] ?></label>
      </th>
      <td>
        <input class="regular-text" id="<?php echo $id ?>" type="<?php echo $opts['type'] ?>" name="<?php echo $name ?>" value="<?php echo $value ?>">
        <p class="description"><?php echo $opts['descr'] ?></p>
      </td>
    </tr>
  <?php endforeach ?>
  </tbody>
</table>
