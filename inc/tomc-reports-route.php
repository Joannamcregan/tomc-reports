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
        // $query = 'select users.display_name, sum(line_total.meta_value) as total_revenue, sum(stripe.meta_value) as stripe_fees, ((sum(line_total.meta_value) - sum(stripe.meta_value)) * (um.meta_value / 100)) as commission
        // $query = 'select users.display_name, line_total.meta_value as total_revenue, stripe.meta_value as stripe_fees, 0 as commission
        $query = 'with CTE AS (
            select child_order.id as cte_order_id, sum(line_total.meta_value) as cte_order_cost
            from %i completed
            join %i child_order on completed.id = child_order.parent_order_id
            and completed.parent_order_id = 0
            and completed.status = "wc-completed"
            join %i items on child_order.id = items.order_id
            and items.order_item_type = "line_item"
            join %i line_total on items.order_item_id = line_total.order_item_id
            and line_total.meta_key = "_line_total"
            where child_order.date_created_gmt >= %s
            and child_order.date_created_gmt <= %s
            group by child_order.id
        ),
        CTE1 AS (
            select items.order_item_id as cte1_item_id, (line_total.meta_value / cte_order_cost) as cte1_percent_order_cost
            from %i completed
            join %i child_order on completed.id = child_order.parent_order_id
            and completed.parent_order_id = 0
            join CTE on child_order.id = CTE.cte_order_id
            join %i items on child_order.id = items.order_id
            and items.order_item_type = "line_item"
            join %i line_total on items.order_item_id = line_total.order_item_id
            and line_total.meta_key = "_line_total"
            where child_order.date_created_gmt >= %s
            and child_order.date_created_gmt <= %s
        ),
        CTE2 AS (
            select cte1_item_id as cte2_item_id, (stripe.meta_value * cte1_percent_order_cost) as stripe_fee
            from %i completed
            join %i child_order on completed.id = child_order.parent_order_id
            and completed.parent_order_id = 0
            and completed.status = "wc-completed"
            join %i items on child_order.id = items.order_id
            and items.order_item_type = "line_item"
            join CTE1 on items.order_item_id = CTE1.cte1_item_id
            join %i line_total on items.order_item_id = line_total.order_item_id
            and line_total.meta_key = "_line_total"
            join %i stripe on completed.id = stripe.order_id
            and stripe.meta_key = "_stripe_fee"
            where child_order.date_created_gmt >= %s
            and child_order.date_created_gmt <= %s
        )
        select users.display_name, sum(line_total.meta_value) as total_revenue, sum(stripe_fee) as stripe_fees, sum(item_commission.meta_value) as commission
        from %i completed
        join %i child_order on completed.id = child_order.parent_order_id
        and completed.parent_order_id = 0
        and completed.status = "wc-completed"
        and child_order.status <> "wc-refunded"
        join %i items on child_order.id = items.order_id
        and items.order_item_type = "line_item"
        join CTE2 on items.order_item_id = CTE2.cte2_item_id
        join %i l on l.order_item_id = items.order_item_id
        join %i posts on l.product_id = posts.id
        join %i users on posts.post_author = users.id
        join %i line_total on items.order_item_id = line_total.order_item_id
        and line_total.meta_key = "_line_total"
        left join %i item_commission on items.order_item_id = item_commission.order_item_id
        and item_commission.meta_key = "_vendor_item_commission"
        where child_order.date_created_gmt >= %s
        and child_order.date_created_gmt <= %s
        group by users.display_name;';
        // $results = $wpdb->get_results($wpdb->prepare($query, $orders_table, $order_items_table, $order_product_lookup_table, $posts_table, $users_table, $item_meta_table, $order_meta_table, $user_meta_table, $startDate, $endDate), ARRAY_A);
        $results = $wpdb->get_results($wpdb->prepare($query, $orders_table, $orders_table, $order_items_table, $item_meta_table, $startDate, $endDate, $orders_table, $orders_table, $order_items_table, $item_meta_table, $startDate, $endDate, $orders_table, $orders_table, $order_items_table, $item_meta_table, $order_meta_table, $startDate, $endDate, $orders_table, $orders_table, $order_items_table, $order_product_lookup_table, $posts_table, $users_table, $item_meta_table, $item_meta_table, $startDate, $endDate), ARRAY_A);
        // return $results;
        return $wpdb->prepare($query, $orders_table, $orders_table, $order_items_table, $item_meta_table, $startDate, $endDate, $orders_table, $orders_table, $order_items_table, $item_meta_table, $startDate, $endDate, $orders_table, $orders_table, $order_items_table, $item_meta_table, $order_meta_table, $startDate, $endDate, $orders_table, $orders_table, $order_items_table, $order_product_lookup_table, $posts_table, $users_table, $item_meta_table, $item_meta_table, $startDate, $endDate);
    } else {
        wp_safe_redirect(site_url('/my-account'));
        return 'fail';
    }
}