import $ from 'jquery';

class PayoutReport{
    constructor(){
        this.startDate = $("#payout-report--start-date");
        this.endDate = $("#payout-report--end-date");
        this.generateButton = $('#tomc-payout-report--generate-button');
        this.events();
    }
    events(){             
        this.generateButton.on('click', this.generate.bind(this));
    }
    generate(){
        console.log('start date: ' + this.startDate.val());
    }
}

export default PayoutReport;