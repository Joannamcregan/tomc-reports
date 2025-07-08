<?php global $wpdb;         
$userid = get_current_user_id();
$user = wp_get_current_user();

get_header();
if (is_user_logged_in()){
    if (in_array( 'administrator', (array) $user->roles ) ){
        ?><main>
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
        </main>
    <?php } else {
        ?><main>
            <div class="two-thirds-screen">
                <p class="centered-text half-screen">Only admin can access this report. If you're an author looking for your personal this report, please contact us by email.</p>
            </div>
        </main>
    <?php }
} else {
    ?><main>
        <p class="centered-text">Only logged in admin can access this report.</p>
    </main>
<?php }
get_footer();
?>