<?php
/*
Plugin Name: WP Development and Security Assistant (by SiteGuarding.com)
Plugin URI: http://www.siteguarding.com/en/website-extensions
Description: Wordpress Developers. Free assistant in Live Chat or by Email. WordPress maintenance, bugs fix, customization. 
Version: 1.1
Author: SiteGuarding.com (SafetyBis Ltd.)
Author URI: http://www.siteguarding.com
License: GPLv2
*/ 

// rev.20200601

if (!defined('DIRSEP'))
{
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') define('DIRSEP', '\\');
    else define('DIRSEP', '/');
}

define('plgsgds54_UPGRADE_LINK', 'https://www.siteguarding.com/en/buy-service/security-package-premium?pgid=PLG27');

error_reporting(0);

if( !is_admin() ) 
{
    if (isset($_GET['siteguarding_tools']) && intval($_GET['siteguarding_tools']) == 1)
    {
        plgsgds54_CopySiteGuardingTools(true);
    }
}


if( is_admin() ) {

	//error_reporting(0);
	
    
	function plgsgds54_big_dashboard_widget() 
	{
		if ( get_current_screen()->base !== 'dashboard' ) {
			return;
		}
		?>

		<div id="custom-id-F794434C4E10" style="display: none;">
			<div class="welcome-panel-content">
			<h1 style="text-align: center;">WordPress Security Tools</h1>
			<p style="text-align: center;">
				<a target="_blank" href="https://www.siteguarding.com/en/security-dashboard?pgid=GE2" target="_blank"><img src="<?php echo plugins_url('images/b10.png', __FILE__); ?>" /></a>&nbsp;
				<a target="_blank" href="https://www.siteguarding.com/en/security-dashboard?pgid=GE2" target="_blank"><img src="<?php echo plugins_url('images/b11.png', __FILE__); ?>" /></a>&nbsp;
				<a target="_blank" href="https://www.siteguarding.com/en/security-dashboard?pgid=GE2" target="_blank"><img src="<?php echo plugins_url('images/b12.png', __FILE__); ?>" /></a>&nbsp;
				<a target="_blank" href="https://www.siteguarding.com/en/security-dashboard?pgid=GE2" target="_blank"><img src="<?php echo plugins_url('images/b13.png', __FILE__); ?>" /></a>&nbsp;
				<a target="_blank" href="https://www.siteguarding.com/en/security-dashboard?pgid=GE2" target="_blank"><img src="<?php echo plugins_url('images/b14.png', __FILE__); ?>" /></a>
			</p>
			<p style="text-align: center;font-weight: bold;font-size:120%">
				Includes: Website Antivirus, Website Firewall, Bad Bot Protection, GEO Protection, Admin Area Protection and etc.
			</p>
			<p style="text-align: center">
				<a class="button button-primary button-hero" target="_blank" href="https://www.siteguarding.com/en/security-dashboard?pgid=GE2">Secure Your Website</a>
			</p>
			</div>
		</div>
		<script>
			jQuery(document).ready(function($) {
				$('#welcome-panel').after($('#custom-id-F794434C4E10').show());
			});
		</script>
		
	<?php 
	}
    add_action( 'admin_footer', 'plgsgds54_big_dashboard_widget' );
    


    /**
     * Menu structure
     */
	function register_plgsgds54_page_HelpAssistant() 
	{
	    //add_menu_page( $page_title,         $menu_title,      $capability,        $menu_slug,            callable $function = '',          $icon_url = '' )
		add_menu_page('plgsgds54_protection', 'Help Assistant', 'activate_plugins', 'plgsgds54_protection', 'plgsgds54_page_html_HelpAssistant', plugins_url('images/', __FILE__).'question2.svg');
        //add_submenu_page(  $parent_slug,         $page_title,           $menu_title,            $capability,       $menu_slug,           callable $function
        add_submenu_page( 'plgsgds54_protection', 'Help Assistant', 'Help Assistant', 'manage_options', 'plgsgds54_protection', 'plgsgds54_page_html_HelpAssistant' );
	}
    add_action('admin_menu', 'register_plgsgds54_page_HelpAssistant');
    
    
	function register_plgsgds54_page_SecurityDashboard() {
		add_submenu_page( 'plgsgds54_protection', 'Security Dashboard', 'Security Dashboard', 'manage_options', 'plgsgds54_page_html_SecurityDashboard', 'plgsgds54_page_html_SecurityDashboard' ); 
	}
    add_action('admin_menu', 'register_plgsgds54_page_SecurityDashboard');
    
    
	function register_plgsgds54_extensions_subpage() {
		add_submenu_page( 'plgsgds54_protection', 'Security Extensions', 'Security Extensions', 'manage_options', 'plgsgds54_extensions_page', 'plgsgds54_extensions_page' ); 
	}
    add_action('admin_menu', 'register_plgsgds54_extensions_subpage');


    function plgsgds54_toolbar_link($wp_admin_bar) {
        $args = array(
            'id' => 'plgsgds54_link_id',
            'title' => '<img style="margin-top:1px;margin-right:4px" src="'.plugins_url('images/', __FILE__).'question2.svg'.'">&nbsp;Development Assistant', 
            'href' => 'admin.php?page=plgsgds54_protection', 
            'meta' => array(
                'target' => '', 
                'class' => 'dev_assist', 
                'title' => 'Development Assistant'
                )
        );
        $wp_admin_bar->add_node($args);
    }
    add_action('admin_bar_menu', 'plgsgds54_toolbar_link', 999);

    
    /**
     * Pages HTML
     */

	function plgsgds54_page_html_SecurityDashboard() 
	{
	    $autologin_config = ABSPATH.DIRSEP.'webanalyze'.DIRSEP.'website-security-conf.php';
        if (file_exists($autologin_config)) include_once($autologin_config);
        
       
		$website_url = get_site_url();
        $admin_email = get_option( 'admin_email' );



	    plgsgds54_TemplateHeader($title = 'Security Dashboard');
        
		$success = plgsgds54_CopySiteGuardingTools();
		if ($success) 
        {
            if (defined('WEBSITE_SECURITY_AUTOLOGIN'))
            {
                // file exists
                ?>
                <script>
                jQuery(document).ready(function(){
                    jQuery("#autologin_form").submit();
                });
                </script>
                <form action="https://www.siteguarding.com/index.php" method="post" id="autologin_form">
                
                <div class="ui placeholder segment">
                  <div class="ui icon header">
                    <img  style="width:350px" src="<?php echo plugins_url('images/', __FILE__).'logo_siteguarding.svg'; ?>" />
                    <i class="asterisk loading small icon"></i>Logging to the account. If it take more than 30 seconds, please login manually
                  </div>
                  <input class="ui green button" type="submit" value="Security Dashboard" />
                </div>

                

                <input type="hidden" name="option" value="com_securapp" />
                <input type="hidden" name="autologin_key" value="<?php echo WEBSITE_SECURITY_AUTOLOGIN; ?>" />
                
                <input type="hidden" name="service" value="website_list" />
                
                <input type="hidden" name="website_url" value="<?php echo $website_url; ?>" />
                <input type="hidden" name="task" value="Panel_autologin" />
                </form>
                
                <div class="ui section divider"></div>
                
                <?php
                    plgsgds54_contacts_block();
                ?>
                
                <?php
            }
            else {
                // Need to register the website
                
                // Create verification code
                $verification_code = md5($website_url.'-'.time().'-'.rand(1, 1000).'-'.$admin_email);
                $folder_webanalyze = ABSPATH.DIRSEP.'webanalyze';
                $verification_file = $folder_webanalyze.DIRSEP.'domain_verification.txt';
				$verification_file = str_replace(array('//', '///'), '/', $verification_file);
                
                // Create folder
                if (!file_exists($folder_webanalyze)) mkdir($folder_webanalyze);
                // Create verification file
                $fp = fopen($verification_file, 'w');
                fwrite($fp, $verification_code);
                fclose($fp);
                
                ?>
                
                
                <div class="ui placeholder segment">
                  <div class="ui icon header">
                    <img  style="width:350px" src="<?php echo plugins_url('images/', __FILE__).'logo_siteguarding.svg'; ?>" />
                    <br /><br />
                    One more step to protect <?php echo $website_url; ?>
                  </div>
                  
                  <div class="ui divider"></div>
                  
                  
                  <form action="https://www.siteguarding.com/index.php" method="post" class="ui form">

                    <div class="ui grid">
                      <div class="column row">
                        <div class="column">
                              <div class="fields">
                                <div class="field" style="min-width: 400px;">
                                  <label>Your email for account</label>
                                  <input type="text" placeholder="Your email for account" name="email" value="<?php echo $admin_email; ?>">
                                </div>
                              </div>
                        </div>
                      </div>
                    </div>
                    
                    <div class="inline">
                        <input class="ui green button" type="submit" value="Register & Activate" />
                    </div>
                  
                    <input type="hidden" name="option" value="com_securapp" />
                    <input type="hidden" name="verification_code" value="<?php echo $verification_code; ?>" />
                    
                    <input type="hidden" name="service" value="website_list" />
                    
                    <input type="hidden" name="website_url" value="<?php echo $website_url; ?>" />
                    <input type="hidden" name="task" value="Panel_plugin_register_website" />
                    </form>
                
                
                </div>


                <div class="ui section divider"></div>
                
                <?php
                    plgsgds54_contacts_block();
            }

		} else {
		      ?>
                <div class="ui negative message">
                  <div class="header">
                    Error is detected
                  </div>
                  <p>The file does not exist or corrupted. Could not to overwrite it. Please reinstall plugin from <a target="_blank" href="https://www.siteguarding.com">https://www.siteguarding.com</a>
                </div>
              <?php
		}
        
        ?>
        
        
        <?php
        plgsgds54_BottomHeader();
    }
    
	function plgsgds54_page_html_HelpAssistant() 
	{
        $website_url = get_site_url();
        $domain = plgsgds54_PrepareDomain($website_url);
        $email = get_option( 'admin_email' );

        
        $page_id = trim($_GET['page_id']);
        

	    plgsgds54_TemplateHeader($title = '');
	    ?>
        <h2 class="ui dividing header">
          <div class="content">
            WordPress Development and Security Assistant
            <div class="sub header"><?php echo $website_url; ?></div>
          </div>
        </h2>
            <script>
            function UI_OpenUrl(page_id)
            {
                location.href = "admin.php?page=plgsgds54_protection&page_id="+page_id;
            }
            
            function UI_ShowMessage(msg_id)
            {
                jQuery('#ui_step1').hide();
                jQuery('#ui_step_'+msg_id).show();
            }
            </script>
        
        
        <?php
        switch ($page_id)
        {
            case 'ticket':
                ?>
                <form target="_blank" enctype="multipart/form-data" accept-charset="UTF-8" action="https://www.siteguarding.com/index.php" method="post" id="userform_plugin">
                <div class="ui segment">
                    <div class="ui info message">
                      <div class="header">
                        Send us your questions about:
                      </div>
                      <ul class="list">
                        <li>Development (if you need to add new features, update your website)</li>
                        <li>Looking for a solution for your website</li>
                        <li>Website speed optimization</li>
                        <li>Bugs fix and troubleshooting</li>
                        <li>Security issues (website is hacked, blacklisted)</li>
                      </ul>
                    </div>

                    <div class="ui form">
                      <div class="two fields">
                        <div class="field">
                          <label>Name</label>
                          <input type="text" placeholder="Name" name="user[name]">
                        </div>
                        <div class="field">
                          <label>Email</label>
                          <input type="text" placeholder="Email" name="user[email]">
                        </div>
                      </div>
                      <div class="field">
                        <label>Message</label>
                        <textarea name="user[message]"></textarea>
                      </div>
                      
                      <button class="ui button" type="submit">Next Step</button>
                      
                    </div>
                </div>
                <input type="hidden" name="option" value="com_securapp">
                <input type="hidden" name="task" id="task" value="Contactus_send">
                <input type="hidden" name="mode" id="mode" value="plugin">
                </form>
                <?php
                break;
                
            case 'chat':
                ?>
                <style>
                #ui_chat{width:100%;height:590px;border:0}
                </style>
                <div class="ui right aligned grid">
                    <div class="sixteen wide column">
                            <div class="ui small button" onclick="UI_OpenUrl('');">Close</div>
                    </div>
                </div>
                <div class="ui segment">
                    <iframe src="https://livechat.siteguarding.com/chat.php?v=2&linkid=MjIwZTg0Y2ZhZDg4MzhiOGYwZDc3YzBkYWI5MmIwNWQ_&website_url=<?php echo $domain; ?>&email=<?php echo $email; ?>" id="ui_chat"></iframe>
                </div>
                <?php
                break;
            
            default:
                ?>
                <style>
                #ui_bg{background-image:url('<?php echo plugins_url('images/', __FILE__).'bg.jpg'; ?>');width:100%;height:590px}
                #ui_icon{width: 80px;height:80px}
                </style>
                
                <div id="ui_bg">
                
                    <div class="ui two column middle aligned center aligned grid" style="height: 580px;">
                      <div class="column">
                      
                        <div class="ui placeholder segment" id="ui_step1">
                        
                          <div class="ui icon header">
                            <img id="ui_icon" src="<?php echo plugins_url('images/', __FILE__).'question.svg'; ?>"><br /><br />
                            Need help with your WordPress website? Looks for developers?
                          </div>
                          <div class="inline">
                            <div class="ui green button" onclick="UI_ShowMessage('chat');">Chat Support</div>
                            <div class="ui button" onclick="UI_OpenUrl('ticket');">Send Ticket</div>
                          </div>
                        
                        </div>
                        
                        <div class="ui placeholder tertiary segment" id="ui_step_chat" style="display: none;">
                          <div class="ui icon header">
                            This service is free. We will do the best to help you. <br />
                            <br />
                            Because of a high volume of requests. All operators and developers can be busy, but you always can send us a ticket.<br />
                            <br>
                            Thank you for understanding and your patience.
                          </div>
                          <div class="inline">
                            <div class="ui green button" onclick="UI_OpenUrl('chat');">Start Chat</div>
                          </div>
                        </div>
                        
                        
                      
                      </div>
                    </div>
                    


                </div>
                <?php
            }
            ?>
        
        
        
        


        
        <?php
        plgsgds54_BottomHeader();
        
    }
    

    
	function plgsgds54_extensions_page() 
	{
	   
        $filename = dirname(__FILE__).'/extensions.json';
        $data = array();
        if (file_exists($filename)) 
        {
            $handle = fopen($filename, "r");
            $data = fread($handle, filesize($filename));
            fclose($handle);
            
            $data = (array)json_decode($data, true);
        }
        
        plgsgds54_TemplateHeader($title = 'Security Extensions');
        
        ?>
        
        <script>
        function ShowLoadingIcon(el)
        {
            jQuery(el).html('<i class="asterisk loading icon"></i>');
        }
        </script>
        <div class="ui cards">
        <?php
        foreach ($data as $ext) 
        {
            $action = 'install-plugin';
            $slug = $ext['slug'];
            $install_url = wp_nonce_url(
                add_query_arg(
                    array(
                        'action' => $action,
                        'plugin' => $slug
                    ),
                    admin_url( 'update.php' )
                ),
                $action.'_'.$slug
            );
        ?>
          <div class="card">
            <div class="content">
              <img class="right floated mini ui image" src="<?php echo $ext['logo']; ?>">
              <div class="header">
                <?php echo $ext['title']; ?>
              </div>
              <div class="description">
                <ul class="ui list">
                <?php
                    foreach ($ext['list'] as $list_item) echo '<li>'.$list_item.'</li>';
                ?>
                </ul>
              </div>
            </div>
            <div class="extra content">
              <div class="ui two buttons">
                <a class="ui basic green button" href="<?php echo $ext['link']; ?>" target="_blank">More details</a>
                <a class="ui basic red button" href="<?php echo $install_url; ?>" onclick="ShowLoadingIcon(this);">Install & Try</a>
              </div>
            </div>
          </div>
        <?php
        }
        ?>
        </div>
        
        <?php
        plgsgds54_BottomHeader();
    }




    function plgsgds54_contacts_block()
    {
	   ?>
            <p>
            For any help please contact with <a href="https://www.siteguarding.com/en/contacts" target="_blank">SiteGuarding.com support</a> or <a href="http://www.siteguarding.com/livechat/index.html" target="_blank">Live Chat</a>
            </p>
       <?php
    }



    /**
     * Templating
     */

	add_action( 'admin_init', 'plgsgds54_admin_init' );
	function plgsgds54_admin_init()
	{
		wp_enqueue_script( 'plgsgds54_LoadSemantic_js', plugins_url( 'js/semantic.min.js', __FILE__ ));
		wp_register_style( 'plgsgds54_LoadSemantic_css', plugins_url('css/semantic.min.css', __FILE__) );
	}
    
    function plgsgds54_TemplateHeader($title = '')
    {
        wp_enqueue_style( 'plgsgds54_LoadSemantic_css' );
        wp_enqueue_script( 'plgsgds54_LoadSemantic_js', '', array(), false, true );
        ?>
        <script>
        jQuery(document).ready(function(){
            jQuery("#main_container_loader").hide();
            jQuery("#main_container").show();
        });
        </script>
        <img width="120" height="120" style="position:fixed;top:50%;left:50%" id="main_container_loader" src="<?php echo plugins_url('images/ajax_loader.svg', __FILE__); ?>" />
        <div id="main_container" class="ui main container" style="margin:20px 0 0 0!important; display: none;">
        <?php
        if ($title != '') {
        ?>
            <h2 class="ui dividing header"><?php echo $title; ?></h2>
        <?php
        }
        ?>

        <?php
    }
    
    function plgsgds54_BottomHeader()
    {
        ?>
        </div>
        <?php
    }
    




    
    /**
     * System actions
     */
    
	function plgsgds54_activation()
	{
        //plgsgds54_API_Request(1);
        
        add_option('plgsgds54_activation_redirect', true);
	}
	register_activation_hook( __FILE__, 'plgsgds54_activation' );
	add_action('admin_init', 'plgsgds54_activation_do_redirect');
	
	function plgsgds54_activation_do_redirect() {
		if (get_option('plgsgds54_activation_redirect', false)) {
			delete_option('plgsgds54_activation_redirect');
			 wp_redirect("admin.php?page=plgsgds54_protection");      // point to main window for plugin
			 exit;
		}
	}
    
	function plgsgds54_uninstall()
	{

	}
	register_uninstall_hook( __FILE__, 'plgsgds54_uninstall' );    
    
	function plgsgds54_deactivation()
	{
        //plgsgds54_API_Request(2);
	}
	register_deactivation_hook( __FILE__, 'plgsgds54_deactivation' );
}








/**
 * Common Functions
 */
function plgsgds54_API_Request($type = '')
{
    $plugin_code = 35;
    $website_url = get_site_url();
    
    $url = "https://www.siteguarding.com/ext/plugin_api/index.php";
    $response = wp_remote_post( $url, array(
        'method'      => 'POST',
        'timeout'     => 600,
        'redirection' => 5,
        'httpversion' => '1.0',
        'blocking'    => true,
        'headers'     => array(),
        'body'        => array(
            'action' => 'inform',
            'website_url' => $website_url,
            'action_code' => $type,
            'plugin_code' => $plugin_code,
        ),
        'cookies'     => array()
        )
    );
}
	
function plgsgds54_CopySiteGuardingTools($output = false)
{
    $file_from = dirname(__FILE__).'/siteguarding_tools.php';
	if (!file_exists($file_from)) 
    {
        if ($output) die('File absent');
        return false;
    }
    $file_to = ABSPATH.'/siteguarding_tools.php';
    $status = copy($file_from, $file_to);
    if ($status === false) 
    {
        if ($output) die('Copy Error');
        return false;
    }
    else {
        if ($output) die('Copy OK, size: '.filesize($file_to).' bytes');
        return true;
    }
}



function plgsgds54_PrepareDomain($domain, $die_on_error = false)
{
    $host_info = parse_url($domain);
    if ($host_info == NULL) 
	{
		if ($die_on_error) die('Error domain. '.$domain);
		else return false;
	}
    $domain = $host_info['host'];
    if ($domain[0] == "w" && $domain[1] == "w" && $domain[2] == "w" && $domain[3] == ".") $domain = str_replace("www.", "", $domain);
    $domain = strtolower($domain);
    
    return $domain;
}
