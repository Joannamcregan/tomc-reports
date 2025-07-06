/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./src/modules/PayoutReport.js":
/*!*************************************!*\
  !*** ./src/modules/PayoutReport.js ***!
  \*************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! jquery */ "jquery");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_0__);

class PayoutReport {
  constructor() {
    this.startDate = jquery__WEBPACK_IMPORTED_MODULE_0___default()("#payout-report--start-date");
    this.endDate = jquery__WEBPACK_IMPORTED_MODULE_0___default()("#payout-report--end-date");
    this.generateButton = jquery__WEBPACK_IMPORTED_MODULE_0___default()('#tomc-payout-report--generate-button');
    this.startDateError = jquery__WEBPACK_IMPORTED_MODULE_0___default()('#payout-report--start-date-error');
    this.endDateError = jquery__WEBPACK_IMPORTED_MODULE_0___default()('#payout-report--end-date-error');
    this.dateOrderError = jquery__WEBPACK_IMPORTED_MODULE_0___default()('#payout-report--dates-error');
    this.resultsSection = jquery__WEBPACK_IMPORTED_MODULE_0___default()('#tomc-payout-report--results-section');
    this.events();
  }
  events() {
    this.generateButton.on('click', this.generate.bind(this));
  }
  generate(e) {
    let startDate = this.startDate.val();
    let endDate = this.endDate.val();
    if (startDate != '' && endDate != '') {
      this.startDateError.addClass('hidden');
      this.endDateError.addClass('hidden');
      if (endDate > startDate) {
        this.dateOrderError.addClass('hidden');
        jquery__WEBPACK_IMPORTED_MODULE_0___default()(e.target).addClass('contracting');
        jquery__WEBPACK_IMPORTED_MODULE_0___default().ajax({
          beforeSend: xhr => {
            xhr.setRequestHeader('X-WP-Nonce', marketplaceData.nonce);
          },
          url: tomcBookorgData.root_url + '/wp-json/tomcReports/v1/getPayoutRecords',
          type: 'GET',
          data: {
            'startDate': startDate,
            'endDate': endDate
          },
          success: response => {
            jquery__WEBPACK_IMPORTED_MODULE_0___default()(e.target).removeClass('contracting');
            let table = jquery__WEBPACK_IMPORTED_MODULE_0___default()('<table />');
            let row = jquery__WEBPACK_IMPORTED_MODULE_0___default()('<tr />');
            let heading = jquery__WEBPACK_IMPORTED_MODULE_0___default()('<th />');
            heading.text('Display Name');
            row.append(heading);
            heading = jquery__WEBPACK_IMPORTED_MODULE_0___default()('<th />');
            heading.text('Total Revenue');
            row.append(heading);
            heading = jquery__WEBPACK_IMPORTED_MODULE_0___default()('<th />');
            heading.text('Stripe Fees');
            row.append(heading);
            heading = jquery__WEBPACK_IMPORTED_MODULE_0___default()('<th />');
            heading.text('Commission');
            row.append(heading);
            table.append(row);
            for (let i = 0; i < response.length; i++) {
              row = jquery__WEBPACK_IMPORTED_MODULE_0___default()('<tr />');
              let td = jquery__WEBPACK_IMPORTED_MODULE_0___default()('<td />');
              td.text(Math.round(response[i]['total_revenue'] * 100) / 100);
              row.append(td);
              td = jquery__WEBPACK_IMPORTED_MODULE_0___default()('<td />');
              td.text(Math.round(response[i]['total_revenue'] * 100) / 100);
              row.append(td);
              td = jquery__WEBPACK_IMPORTED_MODULE_0___default()('<td />');
              td.text(Math.round(response[i]['stripe_fees'] * 100) / 100);
              row.append(td);
              td = jquery__WEBPACK_IMPORTED_MODULE_0___default()('<td />');
              td.text(Math.round(response[i]['commission'] * 100) / 100);
              row.append(td);
              table.append(row);
            }
            this.resultsSection.append(table);
          },
          error: response => {
            console.log(response);
          }
        });
      } else {
        this.dateOrderError.removeClass('hidden');
      }
    } else {
      if (startDate == '') {
        this.startDateError.removeClass('hidden');
      } else {
        this.startDateError.addClass('hidden');
      }
      if (endDate == '') {
        this.endDateError.removeClass('hidden');
      } else {
        this.endDateError.addClass('hidden');
      }
    }
  }
}
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (PayoutReport);

/***/ }),

/***/ "jquery":
/*!*************************!*\
  !*** external "jQuery" ***!
  \*************************/
/***/ ((module) => {

module.exports = window["jQuery"];

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry needs to be wrapped in an IIFE because it needs to be isolated against other modules in the chunk.
(() => {
/*!**********************!*\
  !*** ./src/index.js ***!
  \**********************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _modules_PayoutReport__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./modules/PayoutReport */ "./src/modules/PayoutReport.js");

const payoutReport = new _modules_PayoutReport__WEBPACK_IMPORTED_MODULE_0__["default"]();
})();

/******/ })()
;
//# sourceMappingURL=index.js.map