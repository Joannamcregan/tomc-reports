<?php
/* 
    Plugin Name: TOMC Reports
    Version: 1.0
    Author: Joanna
    Description: allow admin to view custom reports
*/

if( ! defined('ABSPATH') ) exit;
require_once plugin_dir_path(__FILE__) . 'inc/tomc-reports-route.php';

class TOMCReportsPlugin {
    function __construct() {
        add_action('activate_tomc-reports/tomc-reports.php', array($this, 'onActivate'));
        add_action('admin_enqueue_scripts', array($this, 'pluginFiles'));
        add_action( 'admin_menu', array($this, 'wpdocs_register_payout_report_tab') );
        add_filter('template_include', array($this, 'loadTemplate'), 99);
    }	

    function registerScripts(){
        wp_register_style('tomc_reports_styles', plugins_url('css/tomc-reports-styles.css', __FILE__), false, '1.0', 'all');
    }

    function pluginFiles(){
        wp_enqueue_style('tomc_reports_styles');
        wp_enqueue_script('tomc-reports-js', plugin_dir_url(__FILE__) . '/build/index.js', array('jquery'), '1.0', true);
        wp_localize_script('tomc-reports-js', 'tomcReportsData', array(
            'root_url' => get_site_url(),        
            'nonce' => wp_create_nonce('wp_rest')
        ));
    }

    function addReportsPage() {
        $reports_page = array(
            'post_title' => 'Payout Report',
            'post_content' => '',
            'post_status' => 'publish',
            'post_author' => 0,
            'post_type' => 'page'
        );
        wp_insert_post($reports_page);
    }

    function onActivate() {
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

        if (post_exists('Payout Report', '', '', 'page', 'publish') == ''){
            $this->addReportsPage();
        }
    }

    function loadTemplate($template){
        if (is_page('payout-report')){
            return plugin_dir_path(__FILE__) . 'inc/template-payout-report.php';
        } else
        return $template;
    }

    function wpdocs_register_payout_report_tab(){
	add_menu_page( 
		__( 'Payout Report', 'textdomain' ),
		'Payout Report',
		'manage_options',
		'payout-report',
		array($this, 'payout_report_tab')
	); 
}

function payout_report_tab(){
	echo '<main>
            <div class="report-section two-thirds-screen">
                <h1 class="centered-text margin-20">Payout Report</h1>
                <label for="payout-report--start-date" class="centered-text margin-20 block">start date: </label>
                <input type="date" id="payout-report--start-date" />
                <label for="payout-report--end-date" class="centered-text margin-20 block">end date: </label>
                <input type="date" id="payout-report--end-date" />
                <p id="payout-report--start-date-error" class="hidden centered-text red-text">Choose a start date.</p>
                <p id="payout-report--end-date-error" class="hidden centered-text red-text">Choose an end date.</p>
                <p id="payout-report--dates-error" class="hidden centered-text red-text">The end date must be later than the start date.</p>
                <button id="tomc-payout-report--generate-button" class="purple-width-fit-button">Generate</button>
                <div id="tomc-payout-report--results-section" class="tomc-report--result-section"></div>
            </div>
        </main>';
    }
}

$tomcReportsPlugin = new TOMCReportsPlugin();