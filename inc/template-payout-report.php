<?php global $wpdb;         
$orders_table = $wpdb->prefix . "wc_orders";
$order_items_table = $wpdb->prefix . "woocommerce_order_items";
$order_product_lookup_table = $wpdb->prefix . "wc_order_product_lookup";
$users_table = $wpdb->prefix . "users";
$user_meta_table = $wpdb->prefix . "usermeta";
$posts_table = $wpdb->prefix . "posts";
$item_meta_table = $wpdb->prefix . "woocommerce_order_itemmeta";
$order_meta_table = $wpdb->prefix . "wc_orders_meta";
$userid = get_current_user_id();
$user = wp_get_current_user();

get_header();
if (is_user_logged_in()){
    if (in_array( 'administrator', (array) $user->roles ) ){
        ?><main>
            <div class="report-section">
                <h1 class="centered-text margin-20">Payout Report</h1>
                <label for="payout-report--start-date" class="centered-text margin-20 block">start date: </label>
                <input type="date" id="payout-report--start-date" />
                <label for="payout-report--end-date" class="centered-text margin-20 block">end date: </label>
                <input type="date" id="payout-report--end-date" />
                <button id="tomc-payout-report--generate-button" class="purple-width-fit-button">Generate</button>
            </div>
        </main>
    <?php } else {
        ?><main>
            <p class="centered-text half-screen">Only admin can access this report. If you're an author looking for your personal this report, please contact us by email.</p>
        </main>
    <?php }
} else {
    ?><main>
        <p class="centered-text">Only logged in admin can access this report.</p>
    </main>
<?php }
get_footer();
?>