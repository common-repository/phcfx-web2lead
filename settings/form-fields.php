<?php
  // get form options settings
  $settings = get_option(PHCWEB2LEAD_PLUGIN_NAME);
?>

<pre><?php //var_dump($settings) ?></pre>

<h3>PHC FX Web2Lead Form Setup</h3>

<h4><em>Form messages</em></h4>
<p>Define the messages that will show in case of errors and missing input from user.</p>

<table class="form-table">
  <tbody>
    <tr>
      <th scope="row">Required message:</th>
      <td>
        <input class="regular-text" id="reqmsg" type="text" name="<?php echo sprintf('%s[messages][reqmsg]', PHCWEB2LEAD_PLUGIN_NAME) ?>" placeholder="<?php echo $this->options['messages']['reqmsg']; ?>" value="<?php echo $settings['messages']['reqmsg'] ?>">
        <p class="description">Message to show when form is not valid or required fields are empty...</p>
      </td>
    </tr>
    <tr>
      <th scope="row">Thankyou message:</th>
      <td>
        <input class="regular-text" id="thankyou" type="text" name="<?php echo sprintf('%s[messages][thankyou]', PHCWEB2LEAD_PLUGIN_NAME) ?>" placeholder="<?php echo $this->options['messages']['thankyou']; ?>" value="<?php echo $settings['messages']['thankyou'] ?>">
        <p class="description">A message to show when user successfully submits the form...</p>
      </td>
    </tr>
  </tbody>
</table>

<hr>

<h4><em>Form fields</em></h4>
<p>Choose the fields (from the list bellow) that will be available to the user and define which are required.</p>

<table class="form-table">
  <thead>
    <tr>
      <th></th>
      <th>
        Field Label /
        <small>Placeholder</small>
        <p class="description">
          The field label to show in the form.<br>
          <small>Enter text to give hint to the user as the field placeholder.</small>
        </p>
      </th>
      <th>
        Include in form?
        <p class="description">Select if you want this field to be displayed to the user.</p>
      </th>
      <th>
        Is required?
        <p class="description">Is the field a required one.<br />User must fill it out!</p>
      </th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($this->options['form'] as $id => $opts):
    // get label for this field
    $label = $settings['form'][$id]['label'];

    // get hint/placeholder text
    $placeholder = $settings['form'][$id]['placeholder'];

    // some logic stuff for required/included fields
    $readonly = $opts['required'] ? 'readonly' : false;
    $required = $opts['required'] ? true : (bool) $settings['form'][$id]['required'];
    $included = $opts['required'] ? true : (bool) $settings['form'][$id]['included'];
    ?>
    <tr>
      <th><label for="<?php echo $id ?>"><?php echo $opts['label'] ?></label></th>
      <td>
        <input id="<?php echo $id ?>" type="text" name="<?php echo sprintf('%s[form][%s][label]', PHCWEB2LEAD_PLUGIN_NAME, $id) ?>" value="<?php echo $label ?>"><br>
        <input type="text" name="<?php echo sprintf('%s[form][%s][placeholder]', PHCWEB2LEAD_PLUGIN_NAME, $id) ?>" placeholder="Placeholder text..." value="<?php echo $placeholder ?>">
      </td>
      <td>
        <input type="hidden"   name="<?php echo sprintf('%s[form][%s][included]', PHCWEB2LEAD_PLUGIN_NAME, $id) ?>" value="0" checked>
        <input type="checkbox" name="<?php echo sprintf('%s[form][%s][included]', PHCWEB2LEAD_PLUGIN_NAME, $id) ?>" value="1" <?php checked($included) ?> <?php echo $readonly ?> onclick="<?php echo $readonly ? 'return false' : '' ?>">
      </td>
      <td>
        <input type="hidden"   name="<?php echo sprintf('%s[form][%s][required]', PHCWEB2LEAD_PLUGIN_NAME, $id) ?>" value="0" checked>
        <input type="checkbox" name="<?php echo sprintf('%s[form][%s][required]', PHCWEB2LEAD_PLUGIN_NAME, $id) ?>" value="1" <?php checked($required) ?> <?php echo $readonly ?> onclick="<?php echo $readonly ? 'return false' : '' ?>">
      </td>
    </tr>
    <tr class="hidden">
      <td>
        <input type="text" name="<?php echo sprintf('%s[form][%s][type]',    PHCWEB2LEAD_PLUGIN_NAME, $id) ?>" value="<?php echo $opts['type'] ?>">
        <input type="text" name="<?php echo sprintf('%s[form][%s][pattern]', PHCWEB2LEAD_PLUGIN_NAME, $id) ?>" value="<?php echo $opts['pattern'] ?>">
      </td>
    </tr>
    <?php endforeach ?>
  </tbody>
</table>
