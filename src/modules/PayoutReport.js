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
                            td.text(response[i]['total_revenue']);
                            row.append(td);
                            td = $('<td />');
                            td.text(response[i]['total_revenue']);
                            row.append(td);
                            td = $('<td />');
                            td.text(response[i]['stripe_fees']);
                            row.append(td);
                            td = $('<td />');
                            td.text(response[i]['commission']);
                            row.append(td);
                            table.append(row);
                        }
                        this.resultsSection.append(table);
                    },
                    error: (response) => {
                        console.log(response);
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