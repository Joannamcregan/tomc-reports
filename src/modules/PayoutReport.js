import $ from 'jquery';

class PayoutReport{
    constructor(){
        this.startDate = $("#payout-report--start-date");
        this.endDate = $("#payout-report--end-date");
        this.generateButton = $('#tomc-payout-report--generate-button');
        this.startDateError = $('#payout-report--start-date-error');
        this.endDateError = $('#payout-report--end-date-error');
        this.dateOrderError = $('#payout-report--dates-error');
        this.resultsSection = $('#tomc-payout-report--results-section');
        this.events();
    }
    events(){             
        this.generateButton.on('click', this.generate.bind(this));
    }
    generate(e){
        let startDate = this.startDate.val();
        let endDate = this.endDate.val();
        if (startDate != '' && endDate != ''){
            this.startDateError.addClass('hidden');
            this.endDateError.addClass('hidden');
            if (endDate > startDate){
                this.dateOrderError.addClass('hidden');
                $(e.target).addClass('contracting');
                $.ajax({
                    beforeSend: (xhr) => {
                        xhr.setRequestHeader('X-WP-Nonce', marketplaceData.nonce);
                    },
                    url: tomcBookorgData.root_url + '/wp-json/tomcReports/v1/getPayoutRecords',
                    type: 'GET',
                    data: {
                        'startDate' : startDate,
                        'endDate' : endDate
                    },
                    success: (response) => {
                        console.log(response);
                        this.resultsSection.html('');
                        $(e.target).removeClass('contracting');
                        let table = $('<table />');
                        let row = $('<tr />');
                        let heading = $('<th />');
                        heading.text('Display Name');
                        row.append(heading);
                        heading = $('<th />');
                        heading.text('Total Revenue');
                        row.append(heading);
                        heading = $('<th />');
                        heading.text('Stripe Fees');
                        row.append(heading);
                        heading = $('<th />');
                        heading.text('Commission');
                        row.append(heading);
                        table.append(row);
                        for (let i = 0; i < response.length; i++){
                            row = $('<tr />');
                            let td = $('<td />');
                            td.text(response[i]['display_name']);
                            row.append(td);
                            td = $('<td />');
                            td.text(Math.round(response[i]['total_revenue'] * 100) / 100);
                            row.append(td);
                            td = $('<td />');
                            td.text(Math.round(response[i]['stripe_fees'] * 100) / 100);
                            row.append(td);
                            td = $('<td />');
                            td.text(Math.round(response[i]['commission'] * 100) / 100);
                            row.append(td);
                            table.append(row);
                        }
                        this.resultsSection.append(table);
                    },
                    error: (response) => {
                        this.resultsSection.html('');
                        let p = $('<p />');
                        p.text('Unfortunately an error occurred. Please try again later.');
                        p.addClass('centered-text');
                        this.resultsSection.append(p);
                    }
                })
            } else {
                this.dateOrderError.removeClass('hidden');
            }
        } else {
            if (startDate == ''){
                this.startDateError.removeClass('hidden');
            } else {
                this.startDateError.addClass('hidden');
            }
            if (endDate == ''){
                this.endDateError.removeClass('hidden');
            } else {
                this.endDateError.addClass('hidden');
            }
        }
    }
}

export default PayoutReport;