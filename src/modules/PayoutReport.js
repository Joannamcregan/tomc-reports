import $ from 'jquery';

class PayoutReport{
    constructor(){
        this.startDate = $("#payout-report--start-date");
        this.endDate = $("#payout-report--end-date");
        this.generateButton = $('#tomc-payout-report--generate-button');
        this.startDateError = $('#payout-report--start-date-error');
        this.endDateError = $('#payout-report--end-date-error');
        this.dateOrderError = $('#payout-report--dates-error');
        this.events();
    }
    events(){             
        this.generateButton.on('click', this.generate.bind(this));
    }
    generate(){
        if (this.startDate.val() != '' && this.endDate.val() != ''){
            this.startDateError.addClass('hidden');
            this.endDateError.addClass('hidden');
            if (this.endDate.val() > this.startDate.val()){
                this.dateOrderError.addClass('hidden');
                console.log('good to go');
            } else {
                this.dateOrderError.removeClass('hidden');
            }
        } else {
            if (this.startDate.val() == ''){
                this.startDateError.removeClass('hidden');
            } else {
                this.startDateError.addClass('hidden');
            }
            if (this.endDate.val() == ''){
                this.endDateError.removeClass('hidden');
            } else {
                this.endDateError.addClass('hidden');
            }
        }
    }
}

export default PayoutReport;