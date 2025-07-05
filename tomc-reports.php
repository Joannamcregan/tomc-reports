<?php
/* 
    Plugin Name: TOMC Reports
    Version: 1.0
    Author: Joanna
    Description: allow admin to view custom reports
*/

if( ! defined('ABSPATH') ) exit;
require_once plugin_dir_path(__FILE__) . 'inc/tomc-reporting-route.php';

class TOMCReportsPlugin {
    function __construct() {
        wp_localize_script('tomc-reports-js', 'tomcReportsData', array(
            'root_url' => get_site_url()
        ));

        add_action('activate_tomc-reports/tomc-reports.php', array($this, 'onActivate'));
        add_action('init', array($this, 'registerScripts'));
        add_action('wp_enqueue_scripts', array($this, 'pluginFiles'));
        add_filter('template_include', array($this, 'loadTemplate'), 99);
    }	

    function registerScripts(){
        wp_register_style('tomc_reports_styles', plugins_url('css/tomc-reports-styles.css', __FILE__), false, '1.0', 'all');
    }

    function pluginFiles(){
        wp_enqueue_style('tomc_reports_styles');
        wp_enqueue_script('tomc-reports-js', plugin_dir_url(__FILE__) . '/build/index.js', array('jquery'), '1.0', true);
        wp_localize_script('tomc-reports-js', 'tomcReportsData', array(
            'root_url' => get_site_url()
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
}

$tomcReportsPlugin = new TOMCReportsPlugin();