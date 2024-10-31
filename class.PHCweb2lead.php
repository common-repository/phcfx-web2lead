<?php

class PHCweb2lead {
  private $validSettings = false;

  // holds the options fields for both
  // backend settings and the lead form fields
  private $options = array(
    'backend' => array(
      'apikey' => array('label' => 'API Key',        'type' => 'text', 'required' => true,  'descr' => 'This key allows the backend to accept data sent from this plugin\'s form.<br>If you do not have a key yet, please generate one in your PHC FX installation.', 'notice' => 'This can not be empty! Please enter your API key...'),
      //'appid'  => array('label' => 'Application ID', 'type' => 'text', 'required' => true,  'descr' => 'Here you should enter PHC FX Engine\'s Application ID key.<br>This allows your application to communicate with PHC FX Engine.', 'notice' => 'PHC-FX Engine is disabled! Please enter your Application ID...'),
      'url'    => array('label' => 'Backend URL',    'type' => 'url',  'required' => true,  'descr' => 'The URL of your PHC FX application.<br>Something like, e.g. https://myurl.com/myphc', 'notice' => 'No backend URL! Please define your backend URL...'),
      'dbname' => array('label' => 'Database Name',  'type' => 'text', 'required' => false, 'descr' => 'Enter the name of the PHC FX company where you want your lead information to be stored.<br>You can leave this empty if you only work with one company.', 'notice' => ''),
      'source' => array('label' => 'Lead Source',    'type' => 'text', 'required' => false, 'descr' => 'Optional info to identify the lead origin.<br>This is stored in lead origin field of your PHC FX installation.', 'notice' => '')
      ),

    'form' => array(
      'name'    => array('label' => 'Name',          'type' => 'text',     'required' => true,  'included' => true,  'placeholder' => '' , 'pattern' => ''),
      'company' => array('label' => 'Company Name',  'type' => 'text',     'required' => false, 'included' => false, 'placeholder' => '' , 'pattern' => ''),
      'address' => array('label' => 'Address',       'type' => 'text',     'required' => false, 'included' => false, 'placeholder' => '' , 'pattern' => ''),
      'zipcode' => array('label' => 'Zip Code',      'type' => 'text',     'required' => false, 'included' => false, 'placeholder' => '' , 'pattern' => ''),
      'email'   => array('label' => 'Email',         'type' => 'email',    'required' => false, 'included' => false, 'placeholder' => '' , 'pattern' => ''),
      'website' => array('label' => 'Website',       'type' => 'url',      'required' => false, 'included' => false, 'placeholder' => '' , 'pattern' => ''),
      'mobile'  => array('label' => 'Mobile Number', 'type' => 'text',     'required' => false, 'included' => false, 'placeholder' => '' , 'pattern' => ''),
      'remarks' => array('label' => 'Obs./Remarks',  'type' => 'textarea', 'required' => false, 'included' => false, 'placeholder' => '' , 'pattern' => '')
      ),

    'messages' => array(
      'reqmsg'   => 'There are required fields that are empty! Please fill them...',
      'thankyou' => 'Thank you! We\'ll get back to you before you know it. Speak soon.'
      )
    );

  private static $instance = null;

  public static function self() {
    if (self::$instance) return $instance;

    return new PHCweb2lead();
  }

  private function __construct () {
    // call init
    $this->init();

    // store default form field settings
    add_option(PHCWEB2LEAD_PLUGIN_NAME, array('form' => $this->options['form'], 'messages' => $this->options['messages']));
  }

  /**
   * Initializes WordPress hooks
   */
  private function init() {
    add_action('admin_menu', array($this, 'init_plugin'));
    add_action('admin_init', array($this, 'register_settings'));

    // handlers to load (render) settings and add link to plugin settings
    add_action('admin_menu', array($this, 'load_settings'));
    add_filter('plugin_action_links_'.PHCWEB2LEAD_PLUGIN, array($this, 'load_links'));

    // handler to show notices in admin panel
    add_action('admin_notices', array($this, 'render_notices'));

    // handlers to load scripts required by the plugin
    add_action('wp_enqueue_scripts', array($this, 'register_scripts'));

    // handler to add our shortcode generator
    add_shortcode('phcfxw2l', array($this, 'render_form'));

    // handler for form submission
    add_action('admin_post_w2lsubmit',        array($this, 'submit_form'));
    add_action('admin_post_nopriv_w2lsubmit', array($this, 'submit_form'));
  }

  public function init_plugin() {
    $plugins = get_plugins();

    define('PLUGIN_NAME',    $plugins[PHCWEB2LEAD_PLUGIN]['Name']);
    define('PLUGIN_VERSION', $plugins[PHCWEB2LEAD_PLUGIN]['Version']);
  }

  public function register_settings() {
    // === BACKEND SETTINGS SECTION ===========================================
    add_settings_section('backend-section', null, null, 'backend-options');
    add_settings_field(null, null, null, 'backend-options', 'backend-section');
    register_setting('backend-options', PHCWEB2LEAD_PLUGIN_NAME);

    // === FORM SETTINGS SECTION ==============================================
    add_settings_section('form-section', null, null, 'form-options');
    add_settings_field(null, null, null, 'form-options', 'form-section');
    register_setting('form-options', PHCWEB2LEAD_PLUGIN_NAME);
  }

  public function render_settings() {
    include(PHCWEB2LEAD_PLUGIN_DIR.'phcfx-web2lead-settings.php');
  }

  public function load_settings() {
    add_options_page(sprintf('%s Settings', PLUGIN_NAME), PLUGIN_NAME, 'manage_options', PHCWEB2LEAD_PLUGIN_NAME, array($this, 'render_settings'));
  }

  public function load_links($links) {
    // add our settings page
    array_unshift($links, '<a href="'. get_admin_url(null, 'options-general.php?page='.PHCWEB2LEAD_PLUGIN_NAME) .'">Settings</a>');

    return $links;
  }

  public function register_scripts() {
    // register scripts that will be used later on
    wp_register_script(PHCWEB2LEAD_PLUGIN_NAME, plugins_url('/js/'.PHCWEB2LEAD_PLUGIN_NAME.'.js' , __FILE__ ));
  }

  public function render_form () {
    // read current settings
    $settings = get_option(PHCWEB2LEAD_PLUGIN_NAME);

    ob_start();
    include(PHCWEB2LEAD_PLUGIN_DIR.'phcfx-web2lead-form.php');

    // inject our JS script
    wp_enqueue_script(PHCWEB2LEAD_PLUGIN_NAME);

    // inject data (settings) and default messages to JS
    wp_localize_script(PHCWEB2LEAD_PLUGIN_NAME, 'settings', $settings);
    wp_localize_script(PHCWEB2LEAD_PLUGIN_NAME, 'messages', $this->options['messages']);

    // inject also the server-side script that will handle the form submission
    wp_localize_script(PHCWEB2LEAD_PLUGIN_NAME, 'url', admin_url('admin-post.php'));

    return ob_get_clean();
  }

  public function render_notices() {
    $notices = array();
    $settings = get_option(PHCWEB2LEAD_PLUGIN_NAME);

    // list of notices to be displayed on WP admin panel
    // quit if no notices to display
    if ( $this->checkSettings($notices) ) return;

    // output notices in admin panel
    ?>
    <div class="error">
      <h4><?php echo PLUGIN_NAME ?></h4>
      <p>The required settings are not yet configured!</p>
      <blockquote>
      <?php foreach ($notices as $entry => $message): ?>
        <p><strong><?php echo $entry ?></strong> - <?php echo $message ?></p>
      <?php endforeach; ?>
      </blockquote>

      <p><strong>NOTE:</strong> The plugin will not show up in your pages unless all above settings have been setup correctly.</p>
    </div>
    <?php
  }

  public function submit_form () {
    // list of errors
    $errors = array();

    // create HTTP POST context stream
    $context = stream_context_create(array(
      'http' => array(
        'method'  => 'POST',
        'header'  => 'Content-type: application/x-www-form-urlencoded',
        'content' => http_build_query($_POST)
        )
      )
    );

    // build our web service full URL
    $url = "{$_POST['url']}/REST/UserLoginWS/registFormCLP";

    // try to send post request and get response from server
    if (($response = @file_get_contents($url, false, $context)) === false) {
      $response = json_encode(
        array('messages' => array(array('messageType' => 'Error', 'messageCodeLocale' => "Failed to send data to backend! Please check your settings...")))
        );
    }

    // send response as JSON
    ob_start();
    header('Content-type: application/json');
    // TODO: what header should we send back ?!!!
    //foreach ($http_response_header as $header) header($header);
    echo $response;
    echo ob_get_clean();
    die();
  }

  public function checkSettings (&$notices) {
    $settings = get_option(PHCWEB2LEAD_PLUGIN_NAME);

    // check if required settings are filled up
    foreach ($this->options['backend'] as $id => $opts) {
      if ( $opts['required'] && empty($settings['backend'][$id]) )
        $notices[$opts['label']] = $opts['notice'];
    }

    return count($notices)==0;
  }
}
