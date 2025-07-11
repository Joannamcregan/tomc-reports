<?php
add_action('rest_api_init', 'tomcReportsRegisterRoute');

function tomcReportsRegisterRoute() {
    register_rest_route('tomcReports/v1', 'getPayoutRecords', array(
        'methods' => 'GET',
        'callback' => 'getPayoutRecords'
    ));
}

function getPayoutRecords($data){
    $startDate = sanitize_text_field($data['startDate']);
    $endDate = sanitize_text_field($data['endDate']);
    $user = wp_get_current_user();
    if (is_user_logged_in()){
        global $wpdb;
        $orders_table = $wpdb->prefix . "wc_orders";
        $order_items_table = $wpdb->prefix . "woocommerce_order_items";
        $order_product_lookup_table = $wpdb->prefix . "wc_order_product_lookup";
        $users_table = $wpdb->prefix . "users";
        $user_meta_table = $wpdb->prefix . "usermeta";
        $posts_table = $wpdb->prefix . "posts";
        $item_meta_table = $wpdb->prefix . "woocommerce_order_itemmeta";
        $order_meta_table = $wpdb->prefix . "wc_orders_meta";
        $userId = $user->ID;
        $query = 'select users.display_name, sum(line_total.meta_value) as total_revenue, sum(stripe.meta_value) as stripe_fees, ((sum(line_total.meta_value) - sum(stripe.meta_value)) * (um.meta_value / 100)) as commission
        from %i completed 
        join %i items on completed.id = items.order_id
        and completed.status = "wc-completed"
        and items.order_item_type = "line_item"
        join %i l on l.order_item_id = items.order_item_id
        join %i posts on l.product_id = posts.id
        join %i users on posts.post_author = users.id
        join %i line_total on items.order_item_id = line_total.order_item_id
        and line_total.meta_key = "_line_total"
        join %i stripe on completed.id = stripe.order_id
        and stripe.meta_key = "_stripe_fee"
        join %i um on users.id = um.user_id
        and um.meta_key = "_vendor_commission"
        where completed.date_created_gmt >= %s
        and completed.date_created_gmt <= %s
        group by users.display_name, um.meta_value;';
        $results = $wpdb->get_results($wpdb->prepare($query, $orders_table, $order_items_table, $order_product_lookup_table, $posts_table, $users_table, $item_meta_table, $order_meta_table, $user_meta_table, $startDate, $endDate), ARRAY_A);
        return $results;
        // return $wpdb->prepare($query, $orders_table, $order_items_table, $order_product_lookup_table, $posts_table, $users_table, $item_meta_table, $order_meta_table, $user_meta_table, $startDate, $endDate);
    } else {
        wp_safe_redirect(site_url('/my-account'));
        return 'fail';
    }
}