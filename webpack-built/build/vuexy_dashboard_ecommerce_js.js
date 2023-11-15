(self["webpackChunk"] = self["webpackChunk"] || []).push([["vuexy_dashboard_ecommerce_js"],{

/***/ "./assets/js/vuexy/js/scripts/pages/dashboard-ecommerce.js":
/*!*****************************************************************!*\
  !*** ./assets/js/vuexy/js/scripts/pages/dashboard-ecommerce.js ***!
  \*****************************************************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

/* provided dependency */ var $ = __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");
__webpack_require__(/*! core-js/modules/web.timers.js */ "./node_modules/core-js/modules/web.timers.js");

__webpack_require__(/*! core-js/modules/es.parse-int.js */ "./node_modules/core-js/modules/es.parse-int.js");

/*=========================================================================================
    File Name: dashboard-ecommerce.js
    Description: dashboard ecommerce page content with Apexchart Examples
    ----------------------------------------------------------------------------------------
    Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/
$(window).on('load', function () {
  'use strict';

  var $barColor = '#f3f3f3';
  var $trackBgColor = '#EBEBEB';
  var $textMutedColor = '#b9b9c3';
  var $budgetStrokeColor2 = '#dcdae3';
  var $goalStrokeColor2 = '#51e5a8';
  var $strokeColor = '#ebe9f1';
  var $textHeadingColor = '#5e5873';
  var $earningsStrokeColor2 = '#28c76f66';
  var $earningsStrokeColor3 = '#28c76f33';
  var $statisticsOrderChart = document.querySelector('#statistics-order-chart');
  var $statisticsProfitChart = document.querySelector('#statistics-profit-chart');
  var $earningsChart = document.querySelector('#earnings-chart');
  var $revenueReportChart = document.querySelector('#revenue-report-chart');
  var $budgetChart = document.querySelector('#budget-chart');
  var $browserStateChartPrimary = document.querySelector('#browser-state-chart-primary');
  var $browserStateChartWarning = document.querySelector('#browser-state-chart-warning');
  var $browserStateChartSecondary = document.querySelector('#browser-state-chart-secondary');
  var $browserStateChartInfo = document.querySelector('#browser-state-chart-info');
  var $browserStateChartDanger = document.querySelector('#browser-state-chart-danger');
  var $goalOverviewChart = document.querySelector('#goal-overview-radial-bar-chart');
  var statisticsOrderChartOptions;
  var statisticsProfitChartOptions;
  var earningsChartOptions;
  var revenueReportChartOptions;
  var budgetChartOptions;
  var browserStatePrimaryChartOptions;
  var browserStateWarningChartOptions;
  var browserStateSecondaryChartOptions;
  var browserStateInfoChartOptions;
  var browserStateDangerChartOptions;
  var goalOverviewChartOptions;
  var statisticsOrderChart;
  var statisticsProfitChart;
  var earningsChart;
  var revenueReportChart;
  var budgetChart;
  var browserStatePrimaryChart;
  var browserStateDangerChart;
  var browserStateInfoChart;
  var browserStateSecondaryChart;
  var browserStateWarningChart;
  var goalOverviewChart;
  var isRtl = $('html').attr('data-textdirection') === 'rtl'; // On load Toast

  setTimeout(function () {
    toastr['success']('Vous vous êtes connecté avec succès à Green life ultimate. Vous pouvez maintenant commencer à explorer !', '👋 Bonjour !', {
      closeButton: true,
      tapToDismiss: false,
      rtl: isRtl
    });
  }, 2000); //------------ Statistics Bar Chart ------------
  //----------------------------------------------

  statisticsOrderChartOptions = {
    chart: {
      height: 70,
      type: 'bar',
      stacked: true,
      toolbar: {
        show: false
      }
    },
    grid: {
      show: false,
      padding: {
        left: 0,
        right: 0,
        top: -15,
        bottom: -15
      }
    },
    plotOptions: {
      bar: {
        horizontal: false,
        columnWidth: '20%',
        startingShape: 'rounded',
        colors: {
          backgroundBarColors: [$barColor, $barColor, $barColor, $barColor, $barColor],
          backgroundBarRadius: 5
        }
      }
    },
    legend: {
      show: false
    },
    dataLabels: {
      enabled: false
    },
    colors: [window.colors.solid.warning],
    series: [{
      name: '2020',
      data: [45, 85, 65, 45, 65]
    }],
    xaxis: {
      labels: {
        show: false
      },
      axisBorder: {
        show: false
      },
      axisTicks: {
        show: false
      }
    },
    yaxis: {
      show: false
    },
    tooltip: {
      x: {
        show: false
      }
    }
  };
  statisticsOrderChart = new ApexCharts($statisticsOrderChart, statisticsOrderChartOptions);
  statisticsOrderChart.render(); //------------ Statistics Line Chart ------------
  //-----------------------------------------------

  statisticsProfitChartOptions = {
    chart: {
      height: 70,
      type: 'line',
      toolbar: {
        show: false
      },
      zoom: {
        enabled: false
      }
    },
    grid: {
      borderColor: $trackBgColor,
      strokeDashArray: 5,
      xaxis: {
        lines: {
          show: true
        }
      },
      yaxis: {
        lines: {
          show: false
        }
      },
      padding: {
        top: -30,
        bottom: -10
      }
    },
    stroke: {
      width: 3
    },
    colors: [window.colors.solid.info],
    series: [{
      data: [0, 20, 5, 30, 15, 45]
    }],
    markers: {
      size: 2,
      colors: window.colors.solid.info,
      strokeColors: window.colors.solid.info,
      strokeWidth: 2,
      strokeOpacity: 1,
      strokeDashArray: 0,
      fillOpacity: 1,
      discrete: [{
        seriesIndex: 0,
        dataPointIndex: 5,
        fillColor: '#ffffff',
        strokeColor: window.colors.solid.info,
        size: 5
      }],
      shape: 'circle',
      radius: 2,
      hover: {
        size: 3
      }
    },
    xaxis: {
      labels: {
        show: true,
        style: {
          fontSize: '0px'
        }
      },
      axisBorder: {
        show: false
      },
      axisTicks: {
        show: false
      }
    },
    yaxis: {
      show: false
    },
    tooltip: {
      x: {
        show: false
      }
    }
  };
  statisticsProfitChart = new ApexCharts($statisticsProfitChart, statisticsProfitChartOptions);
  statisticsProfitChart.render(); //--------------- Earnings Chart ---------------
  //----------------------------------------------

  earningsChartOptions = {
    chart: {
      type: 'donut',
      height: 120,
      toolbar: {
        show: false
      }
    },
    dataLabels: {
      enabled: false
    },
    series: [53, 16, 31],
    legend: {
      show: false
    },
    comparedResult: [2, -3, 8],
    labels: ['App', 'Service', 'Product'],
    stroke: {
      width: 0
    },
    colors: [$earningsStrokeColor2, $earningsStrokeColor3, window.colors.solid.success],
    grid: {
      padding: {
        right: -20,
        bottom: -8,
        left: -20
      }
    },
    plotOptions: {
      pie: {
        startAngle: -10,
        donut: {
          labels: {
            show: true,
            name: {
              offsetY: 15
            },
            value: {
              offsetY: -15,
              formatter: function formatter(val) {
                return parseInt(val) + '%';
              }
            },
            total: {
              show: true,
              offsetY: 15,
              label: 'App',
              formatter: function formatter(w) {
                return '53%';
              }
            }
          }
        }
      }
    },
    responsive: [{
      breakpoint: 1325,
      options: {
        chart: {
          height: 100
        }
      }
    }, {
      breakpoint: 1200,
      options: {
        chart: {
          height: 120
        }
      }
    }, {
      breakpoint: 1045,
      options: {
        chart: {
          height: 100
        }
      }
    }, {
      breakpoint: 992,
      options: {
        chart: {
          height: 120
        }
      }
    }]
  };
  earningsChart = new ApexCharts($earningsChart, earningsChartOptions);
  earningsChart.render(); //------------ Revenue Report Chart ------------
  //----------------------------------------------

  revenueReportChartOptions = {
    chart: {
      height: 230,
      stacked: true,
      type: 'bar',
      toolbar: {
        show: false
      }
    },
    plotOptions: {
      bar: {
        columnWidth: '17%',
        endingShape: 'rounded'
      },
      distributed: true
    },
    colors: [window.colors.solid.primary, window.colors.solid.warning],
    series: [{
      name: 'Earning',
      data: [95, 177, 284, 256, 105, 63, 168, 218, 72]
    }, {
      name: 'Expense',
      data: [-145, -80, -60, -180, -100, -60, -85, -75, -100]
    }],
    dataLabels: {
      enabled: false
    },
    legend: {
      show: false
    },
    grid: {
      padding: {
        top: -20,
        bottom: -10
      },
      yaxis: {
        lines: {
          show: false
        }
      }
    },
    xaxis: {
      categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
      labels: {
        style: {
          colors: $textMutedColor,
          fontSize: '0.86rem'
        }
      },
      axisTicks: {
        show: false
      },
      axisBorder: {
        show: false
      }
    },
    yaxis: {
      labels: {
        style: {
          colors: $textMutedColor,
          fontSize: '0.86rem'
        }
      }
    }
  };
  revenueReportChart = new ApexCharts($revenueReportChart, revenueReportChartOptions);
  revenueReportChart.render(); //---------------- Budget Chart ----------------
  //----------------------------------------------

  budgetChartOptions = {
    chart: {
      height: 80,
      toolbar: {
        show: false
      },
      zoom: {
        enabled: false
      },
      type: 'line',
      sparkline: {
        enabled: true
      }
    },
    stroke: {
      curve: 'smooth',
      dashArray: [0, 5],
      width: [2]
    },
    colors: [window.colors.solid.primary, $budgetStrokeColor2],
    series: [{
      data: [61, 48, 69, 52, 60, 40, 79, 60, 59, 43, 62]
    }, {
      data: [20, 10, 30, 15, 23, 0, 25, 15, 20, 5, 27]
    }],
    tooltip: {
      enabled: false
    }
  };
  budgetChart = new ApexCharts($budgetChart, budgetChartOptions);
  budgetChart.render(); //------------ Browser State Charts ------------
  //----------------------------------------------
  // State Primary Chart

  browserStatePrimaryChartOptions = {
    chart: {
      height: 30,
      width: 30,
      type: 'radialBar'
    },
    grid: {
      show: false,
      padding: {
        left: -15,
        right: -15,
        top: -12,
        bottom: -15
      }
    },
    colors: [window.colors.solid.primary],
    series: [54.4],
    plotOptions: {
      radialBar: {
        hollow: {
          size: '22%'
        },
        track: {
          background: $trackBgColor
        },
        dataLabels: {
          showOn: 'always',
          name: {
            show: false
          },
          value: {
            show: false
          }
        }
      }
    },
    stroke: {
      lineCap: 'round'
    }
  };
  browserStatePrimaryChart = new ApexCharts($browserStateChartPrimary, browserStatePrimaryChartOptions);
  browserStatePrimaryChart.render(); // State Warning Chart

  browserStateWarningChartOptions = {
    chart: {
      height: 30,
      width: 30,
      type: 'radialBar'
    },
    grid: {
      show: false,
      padding: {
        left: -15,
        right: -15,
        top: -12,
        bottom: -15
      }
    },
    colors: [window.colors.solid.warning],
    series: [6.1],
    plotOptions: {
      radialBar: {
        hollow: {
          size: '22%'
        },
        track: {
          background: $trackBgColor
        },
        dataLabels: {
          showOn: 'always',
          name: {
            show: false
          },
          value: {
            show: false
          }
        }
      }
    },
    stroke: {
      lineCap: 'round'
    }
  };
  browserStateWarningChart = new ApexCharts($browserStateChartWarning, browserStateWarningChartOptions);
  browserStateWarningChart.render(); // State Secondary Chart 1

  browserStateSecondaryChartOptions = {
    chart: {
      height: 30,
      width: 30,
      type: 'radialBar'
    },
    grid: {
      show: false,
      padding: {
        left: -15,
        right: -15,
        top: -12,
        bottom: -15
      }
    },
    colors: [window.colors.solid.secondary],
    series: [14.6],
    plotOptions: {
      radialBar: {
        hollow: {
          size: '22%'
        },
        track: {
          background: $trackBgColor
        },
        dataLabels: {
          showOn: 'always',
          name: {
            show: false
          },
          value: {
            show: false
          }
        }
      }
    },
    stroke: {
      lineCap: 'round'
    }
  };
  browserStateSecondaryChart = new ApexCharts($browserStateChartSecondary, browserStateSecondaryChartOptions);
  browserStateSecondaryChart.render(); // State Info Chart

  browserStateInfoChartOptions = {
    chart: {
      height: 30,
      width: 30,
      type: 'radialBar'
    },
    grid: {
      show: false,
      padding: {
        left: -15,
        right: -15,
        top: -12,
        bottom: -15
      }
    },
    colors: [window.colors.solid.info],
    series: [4.2],
    plotOptions: {
      radialBar: {
        hollow: {
          size: '22%'
        },
        track: {
          background: $trackBgColor
        },
        dataLabels: {
          showOn: 'always',
          name: {
            show: false
          },
          value: {
            show: false
          }
        }
      }
    },
    stroke: {
      lineCap: 'round'
    }
  };
  browserStateInfoChart = new ApexCharts($browserStateChartInfo, browserStateInfoChartOptions);
  browserStateInfoChart.render(); // State Danger Chart

  browserStateDangerChartOptions = {
    chart: {
      height: 30,
      width: 30,
      type: 'radialBar'
    },
    grid: {
      show: false,
      padding: {
        left: -15,
        right: -15,
        top: -12,
        bottom: -15
      }
    },
    colors: [window.colors.solid.danger],
    series: [8.4],
    plotOptions: {
      radialBar: {
        hollow: {
          size: '22%'
        },
        track: {
          background: $trackBgColor
        },
        dataLabels: {
          showOn: 'always',
          name: {
            show: false
          },
          value: {
            show: false
          }
        }
      }
    },
    stroke: {
      lineCap: 'round'
    }
  };
  browserStateDangerChart = new ApexCharts($browserStateChartDanger, browserStateDangerChartOptions);
  browserStateDangerChart.render(); //------------ Goal Overview Chart ------------
  //---------------------------------------------

  goalOverviewChartOptions = {
    chart: {
      height: 245,
      type: 'radialBar',
      sparkline: {
        enabled: true
      },
      dropShadow: {
        enabled: true,
        blur: 3,
        left: 1,
        top: 1,
        opacity: 0.1
      }
    },
    colors: [$goalStrokeColor2],
    plotOptions: {
      radialBar: {
        offsetY: -10,
        startAngle: -150,
        endAngle: 150,
        hollow: {
          size: '77%'
        },
        track: {
          background: $strokeColor,
          strokeWidth: '50%'
        },
        dataLabels: {
          name: {
            show: false
          },
          value: {
            color: $textHeadingColor,
            fontSize: '2.86rem',
            fontWeight: '600'
          }
        }
      }
    },
    fill: {
      type: 'gradient',
      gradient: {
        shade: 'dark',
        type: 'horizontal',
        shadeIntensity: 0.5,
        gradientToColors: [window.colors.solid.success],
        inverseColors: true,
        opacityFrom: 1,
        opacityTo: 1,
        stops: [0, 100]
      }
    },
    series: [83],
    stroke: {
      lineCap: 'round'
    },
    grid: {
      padding: {
        bottom: 30
      }
    }
  };
  goalOverviewChart = new ApexCharts($goalOverviewChart, goalOverviewChartOptions);
  goalOverviewChart.render();
});

/***/ }),

/***/ "./node_modules/core-js/internals/array-slice.js":
/*!*******************************************************!*\
  !*** ./node_modules/core-js/internals/array-slice.js ***!
  \*******************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

var uncurryThis = __webpack_require__(/*! ../internals/function-uncurry-this */ "./node_modules/core-js/internals/function-uncurry-this.js");

module.exports = uncurryThis([].slice);


/***/ }),

/***/ "./node_modules/core-js/internals/function-apply.js":
/*!**********************************************************!*\
  !*** ./node_modules/core-js/internals/function-apply.js ***!
  \**********************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

var NATIVE_BIND = __webpack_require__(/*! ../internals/function-bind-native */ "./node_modules/core-js/internals/function-bind-native.js");

var FunctionPrototype = Function.prototype;
var apply = FunctionPrototype.apply;
var call = FunctionPrototype.call;

// eslint-disable-next-line es/no-reflect -- safe
module.exports = typeof Reflect == 'object' && Reflect.apply || (NATIVE_BIND ? call.bind(apply) : function () {
  return call.apply(apply, arguments);
});


/***/ }),

/***/ "./node_modules/core-js/internals/number-parse-int.js":
/*!************************************************************!*\
  !*** ./node_modules/core-js/internals/number-parse-int.js ***!
  \************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

var global = __webpack_require__(/*! ../internals/global */ "./node_modules/core-js/internals/global.js");
var fails = __webpack_require__(/*! ../internals/fails */ "./node_modules/core-js/internals/fails.js");
var uncurryThis = __webpack_require__(/*! ../internals/function-uncurry-this */ "./node_modules/core-js/internals/function-uncurry-this.js");
var toString = __webpack_require__(/*! ../internals/to-string */ "./node_modules/core-js/internals/to-string.js");
var trim = (__webpack_require__(/*! ../internals/string-trim */ "./node_modules/core-js/internals/string-trim.js").trim);
var whitespaces = __webpack_require__(/*! ../internals/whitespaces */ "./node_modules/core-js/internals/whitespaces.js");

var $parseInt = global.parseInt;
var Symbol = global.Symbol;
var ITERATOR = Symbol && Symbol.iterator;
var hex = /^[+-]?0x/i;
var exec = uncurryThis(hex.exec);
var FORCED = $parseInt(whitespaces + '08') !== 8 || $parseInt(whitespaces + '0x16') !== 22
  // MS Edge 18- broken with boxed symbols
  || (ITERATOR && !fails(function () { $parseInt(Object(ITERATOR)); }));

// `parseInt` method
// https://tc39.es/ecma262/#sec-parseint-string-radix
module.exports = FORCED ? function parseInt(string, radix) {
  var S = trim(toString(string));
  return $parseInt(S, (radix >>> 0) || (exec(hex, S) ? 16 : 10));
} : $parseInt;


/***/ }),

/***/ "./node_modules/core-js/internals/string-trim.js":
/*!*******************************************************!*\
  !*** ./node_modules/core-js/internals/string-trim.js ***!
  \*******************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

var uncurryThis = __webpack_require__(/*! ../internals/function-uncurry-this */ "./node_modules/core-js/internals/function-uncurry-this.js");
var requireObjectCoercible = __webpack_require__(/*! ../internals/require-object-coercible */ "./node_modules/core-js/internals/require-object-coercible.js");
var toString = __webpack_require__(/*! ../internals/to-string */ "./node_modules/core-js/internals/to-string.js");
var whitespaces = __webpack_require__(/*! ../internals/whitespaces */ "./node_modules/core-js/internals/whitespaces.js");

var replace = uncurryThis(''.replace);
var whitespace = '[' + whitespaces + ']';
var ltrim = RegExp('^' + whitespace + whitespace + '*');
var rtrim = RegExp(whitespace + whitespace + '*$');

// `String.prototype.{ trim, trimStart, trimEnd, trimLeft, trimRight }` methods implementation
var createMethod = function (TYPE) {
  return function ($this) {
    var string = toString(requireObjectCoercible($this));
    if (TYPE & 1) string = replace(string, ltrim, '');
    if (TYPE & 2) string = replace(string, rtrim, '');
    return string;
  };
};

module.exports = {
  // `String.prototype.{ trimLeft, trimStart }` methods
  // https://tc39.es/ecma262/#sec-string.prototype.trimstart
  start: createMethod(1),
  // `String.prototype.{ trimRight, trimEnd }` methods
  // https://tc39.es/ecma262/#sec-string.prototype.trimend
  end: createMethod(2),
  // `String.prototype.trim` method
  // https://tc39.es/ecma262/#sec-string.prototype.trim
  trim: createMethod(3)
};


/***/ }),

/***/ "./node_modules/core-js/internals/to-string.js":
/*!*****************************************************!*\
  !*** ./node_modules/core-js/internals/to-string.js ***!
  \*****************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

var global = __webpack_require__(/*! ../internals/global */ "./node_modules/core-js/internals/global.js");
var classof = __webpack_require__(/*! ../internals/classof */ "./node_modules/core-js/internals/classof.js");

var String = global.String;

module.exports = function (argument) {
  if (classof(argument) === 'Symbol') throw TypeError('Cannot convert a Symbol value to a string');
  return String(argument);
};


/***/ }),

/***/ "./node_modules/core-js/internals/validate-arguments-length.js":
/*!*********************************************************************!*\
  !*** ./node_modules/core-js/internals/validate-arguments-length.js ***!
  \*********************************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

var global = __webpack_require__(/*! ../internals/global */ "./node_modules/core-js/internals/global.js");

var TypeError = global.TypeError;

module.exports = function (passed, required) {
  if (passed < required) throw TypeError('Not enough arguments');
  return passed;
};


/***/ }),

/***/ "./node_modules/core-js/internals/whitespaces.js":
/*!*******************************************************!*\
  !*** ./node_modules/core-js/internals/whitespaces.js ***!
  \*******************************************************/
/***/ ((module) => {

// a string of all valid unicode whitespaces
module.exports = '\u0009\u000A\u000B\u000C\u000D\u0020\u00A0\u1680\u2000\u2001\u2002' +
  '\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200A\u202F\u205F\u3000\u2028\u2029\uFEFF';


/***/ }),

/***/ "./node_modules/core-js/modules/es.parse-int.js":
/*!******************************************************!*\
  !*** ./node_modules/core-js/modules/es.parse-int.js ***!
  \******************************************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

var $ = __webpack_require__(/*! ../internals/export */ "./node_modules/core-js/internals/export.js");
var $parseInt = __webpack_require__(/*! ../internals/number-parse-int */ "./node_modules/core-js/internals/number-parse-int.js");

// `parseInt` method
// https://tc39.es/ecma262/#sec-parseint-string-radix
$({ global: true, forced: parseInt != $parseInt }, {
  parseInt: $parseInt
});


/***/ }),

/***/ "./node_modules/core-js/modules/web.timers.js":
/*!****************************************************!*\
  !*** ./node_modules/core-js/modules/web.timers.js ***!
  \****************************************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

var $ = __webpack_require__(/*! ../internals/export */ "./node_modules/core-js/internals/export.js");
var global = __webpack_require__(/*! ../internals/global */ "./node_modules/core-js/internals/global.js");
var apply = __webpack_require__(/*! ../internals/function-apply */ "./node_modules/core-js/internals/function-apply.js");
var isCallable = __webpack_require__(/*! ../internals/is-callable */ "./node_modules/core-js/internals/is-callable.js");
var userAgent = __webpack_require__(/*! ../internals/engine-user-agent */ "./node_modules/core-js/internals/engine-user-agent.js");
var arraySlice = __webpack_require__(/*! ../internals/array-slice */ "./node_modules/core-js/internals/array-slice.js");
var validateArgumentsLength = __webpack_require__(/*! ../internals/validate-arguments-length */ "./node_modules/core-js/internals/validate-arguments-length.js");

var MSIE = /MSIE .\./.test(userAgent); // <- dirty ie9- check
var Function = global.Function;

var wrap = function (scheduler) {
  return function (handler, timeout /* , ...arguments */) {
    var boundArgs = validateArgumentsLength(arguments.length, 1) > 2;
    var fn = isCallable(handler) ? handler : Function(handler);
    var args = boundArgs ? arraySlice(arguments, 2) : undefined;
    return scheduler(boundArgs ? function () {
      apply(fn, this, args);
    } : fn, timeout);
  };
};

// ie9- setTimeout & setInterval additional parameters fix
// https://html.spec.whatwg.org/multipage/timers-and-user-prompts.html#timers
$({ global: true, bind: true, forced: MSIE }, {
  // `setTimeout` method
  // https://html.spec.whatwg.org/multipage/timers-and-user-prompts.html#dom-settimeout
  setTimeout: wrap(global.setTimeout),
  // `setInterval` method
  // https://html.spec.whatwg.org/multipage/timers-and-user-prompts.html#dom-setinterval
  setInterval: wrap(global.setInterval)
});


/***/ })

},
/******/ __webpack_require__ => { // webpackRuntimeModules
/******/ var __webpack_exec__ = (moduleId) => (__webpack_require__(__webpack_require__.s = moduleId))
/******/ __webpack_require__.O(0, ["vendors-node_modules_jquery_dist_jquery_js","vendors-node_modules_core-js_internals_classof_js-node_modules_core-js_internals_export_js"], () => (__webpack_exec__("./assets/js/vuexy/js/scripts/pages/dashboard-ecommerce.js")));
/******/ var __webpack_exports__ = __webpack_require__.O();
/******/ }
]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,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ZWJwYWNrOi8vLy4vYXNzZXRzL2pzL3Z1ZXh5L2pzL3NjcmlwdHMvcGFnZXMvZGFzaGJvYXJkLWVjb21tZXJjZS5qcyIsIndlYnBhY2s6Ly8vLi9ub2RlX21vZHVsZXMvY29yZS1qcy9pbnRlcm5hbHMvYXJyYXktc2xpY2UuanMiLCJ3ZWJwYWNrOi8vLy4vbm9kZV9tb2R1bGVzL2NvcmUtanMvaW50ZXJuYWxzL2Z1bmN0aW9uLWFwcGx5LmpzIiwid2VicGFjazovLy8uL25vZGVfbW9kdWxlcy9jb3JlLWpzL2ludGVybmFscy9udW1iZXItcGFyc2UtaW50LmpzIiwid2VicGFjazovLy8uL25vZGVfbW9kdWxlcy9jb3JlLWpzL2ludGVybmFscy9zdHJpbmctdHJpbS5qcyIsIndlYnBhY2s6Ly8vLi9ub2RlX21vZHVsZXMvY29yZS1qcy9pbnRlcm5hbHMvdG8tc3RyaW5nLmpzIiwid2VicGFjazovLy8uL25vZGVfbW9kdWxlcy9jb3JlLWpzL2ludGVybmFscy92YWxpZGF0ZS1hcmd1bWVudHMtbGVuZ3RoLmpzIiwid2VicGFjazovLy8uL25vZGVfbW9kdWxlcy9jb3JlLWpzL2ludGVybmFscy93aGl0ZXNwYWNlcy5qcyIsIndlYnBhY2s6Ly8vLi9ub2RlX21vZHVsZXMvY29yZS1qcy9tb2R1bGVzL2VzLnBhcnNlLWludC5qcyIsIndlYnBhY2s6Ly8vLi9ub2RlX21vZHVsZXMvY29yZS1qcy9tb2R1bGVzL3dlYi50aW1lcnMuanMiXSwic291cmNlc0NvbnRlbnQiOlsiLyo9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxyXG4gICAgRmlsZSBOYW1lOiBkYXNoYm9hcmQtZWNvbW1lcmNlLmpzXHJcbiAgICBEZXNjcmlwdGlvbjogZGFzaGJvYXJkIGVjb21tZXJjZSBwYWdlIGNvbnRlbnQgd2l0aCBBcGV4Y2hhcnQgRXhhbXBsZXNcclxuICAgIC0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuICAgIEl0ZW0gTmFtZTogVnVleHkgIC0gVnVlanMsIEhUTUwgJiBMYXJhdmVsIEFkbWluIERhc2hib2FyZCBUZW1wbGF0ZVxyXG4gICAgQXV0aG9yOiBQSVhJTlZFTlRcclxuICAgIEF1dGhvciBVUkw6IGh0dHA6Ly93d3cudGhlbWVmb3Jlc3QubmV0L3VzZXIvcGl4aW52ZW50XHJcbj09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PSovXHJcblxyXG4kKHdpbmRvdykub24oJ2xvYWQnLCBmdW5jdGlvbiAoKSB7XHJcbiAgJ3VzZSBzdHJpY3QnO1xyXG5cclxuICB2YXIgJGJhckNvbG9yID0gJyNmM2YzZjMnO1xyXG4gIHZhciAkdHJhY2tCZ0NvbG9yID0gJyNFQkVCRUInO1xyXG4gIHZhciAkdGV4dE11dGVkQ29sb3IgPSAnI2I5YjljMyc7XHJcbiAgdmFyICRidWRnZXRTdHJva2VDb2xvcjIgPSAnI2RjZGFlMyc7XHJcbiAgdmFyICRnb2FsU3Ryb2tlQ29sb3IyID0gJyM1MWU1YTgnO1xyXG4gIHZhciAkc3Ryb2tlQ29sb3IgPSAnI2ViZTlmMSc7XHJcbiAgdmFyICR0ZXh0SGVhZGluZ0NvbG9yID0gJyM1ZTU4NzMnO1xyXG4gIHZhciAkZWFybmluZ3NTdHJva2VDb2xvcjIgPSAnIzI4Yzc2ZjY2JztcclxuICB2YXIgJGVhcm5pbmdzU3Ryb2tlQ29sb3IzID0gJyMyOGM3NmYzMyc7XHJcblxyXG4gIHZhciAkc3RhdGlzdGljc09yZGVyQ2hhcnQgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCcjc3RhdGlzdGljcy1vcmRlci1jaGFydCcpO1xyXG4gIHZhciAkc3RhdGlzdGljc1Byb2ZpdENoYXJ0ID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvcignI3N0YXRpc3RpY3MtcHJvZml0LWNoYXJ0Jyk7XHJcbiAgdmFyICRlYXJuaW5nc0NoYXJ0ID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvcignI2Vhcm5pbmdzLWNoYXJ0Jyk7XHJcbiAgdmFyICRyZXZlbnVlUmVwb3J0Q2hhcnQgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCcjcmV2ZW51ZS1yZXBvcnQtY2hhcnQnKTtcclxuICB2YXIgJGJ1ZGdldENoYXJ0ID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvcignI2J1ZGdldC1jaGFydCcpO1xyXG4gIHZhciAkYnJvd3NlclN0YXRlQ2hhcnRQcmltYXJ5ID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvcignI2Jyb3dzZXItc3RhdGUtY2hhcnQtcHJpbWFyeScpO1xyXG4gIHZhciAkYnJvd3NlclN0YXRlQ2hhcnRXYXJuaW5nID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvcignI2Jyb3dzZXItc3RhdGUtY2hhcnQtd2FybmluZycpO1xyXG4gIHZhciAkYnJvd3NlclN0YXRlQ2hhcnRTZWNvbmRhcnkgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCcjYnJvd3Nlci1zdGF0ZS1jaGFydC1zZWNvbmRhcnknKTtcclxuICB2YXIgJGJyb3dzZXJTdGF0ZUNoYXJ0SW5mbyA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoJyNicm93c2VyLXN0YXRlLWNoYXJ0LWluZm8nKTtcclxuICB2YXIgJGJyb3dzZXJTdGF0ZUNoYXJ0RGFuZ2VyID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvcignI2Jyb3dzZXItc3RhdGUtY2hhcnQtZGFuZ2VyJyk7XHJcbiAgdmFyICRnb2FsT3ZlcnZpZXdDaGFydCA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoJyNnb2FsLW92ZXJ2aWV3LXJhZGlhbC1iYXItY2hhcnQnKTtcclxuXHJcbiAgdmFyIHN0YXRpc3RpY3NPcmRlckNoYXJ0T3B0aW9ucztcclxuICB2YXIgc3RhdGlzdGljc1Byb2ZpdENoYXJ0T3B0aW9ucztcclxuICB2YXIgZWFybmluZ3NDaGFydE9wdGlvbnM7XHJcbiAgdmFyIHJldmVudWVSZXBvcnRDaGFydE9wdGlvbnM7XHJcbiAgdmFyIGJ1ZGdldENoYXJ0T3B0aW9ucztcclxuICB2YXIgYnJvd3NlclN0YXRlUHJpbWFyeUNoYXJ0T3B0aW9ucztcclxuICB2YXIgYnJvd3NlclN0YXRlV2FybmluZ0NoYXJ0T3B0aW9ucztcclxuICB2YXIgYnJvd3NlclN0YXRlU2Vjb25kYXJ5Q2hhcnRPcHRpb25zO1xyXG4gIHZhciBicm93c2VyU3RhdGVJbmZvQ2hhcnRPcHRpb25zO1xyXG4gIHZhciBicm93c2VyU3RhdGVEYW5nZXJDaGFydE9wdGlvbnM7XHJcbiAgdmFyIGdvYWxPdmVydmlld0NoYXJ0T3B0aW9ucztcclxuXHJcbiAgdmFyIHN0YXRpc3RpY3NPcmRlckNoYXJ0O1xyXG4gIHZhciBzdGF0aXN0aWNzUHJvZml0Q2hhcnQ7XHJcbiAgdmFyIGVhcm5pbmdzQ2hhcnQ7XHJcbiAgdmFyIHJldmVudWVSZXBvcnRDaGFydDtcclxuICB2YXIgYnVkZ2V0Q2hhcnQ7XHJcbiAgdmFyIGJyb3dzZXJTdGF0ZVByaW1hcnlDaGFydDtcclxuICB2YXIgYnJvd3NlclN0YXRlRGFuZ2VyQ2hhcnQ7XHJcbiAgdmFyIGJyb3dzZXJTdGF0ZUluZm9DaGFydDtcclxuICB2YXIgYnJvd3NlclN0YXRlU2Vjb25kYXJ5Q2hhcnQ7XHJcbiAgdmFyIGJyb3dzZXJTdGF0ZVdhcm5pbmdDaGFydDtcclxuICB2YXIgZ29hbE92ZXJ2aWV3Q2hhcnQ7XHJcbiAgdmFyIGlzUnRsID0gJCgnaHRtbCcpLmF0dHIoJ2RhdGEtdGV4dGRpcmVjdGlvbicpID09PSAncnRsJztcclxuXHJcbiAgLy8gT24gbG9hZCBUb2FzdFxyXG4gIHNldFRpbWVvdXQoZnVuY3Rpb24gKCkge1xyXG4gICAgdG9hc3RyWydzdWNjZXNzJ10oXHJcbiAgICAgICdWb3VzIHZvdXMgw6p0ZXMgY29ubmVjdMOpIGF2ZWMgc3VjY8OocyDDoCBQaXhlbEZvcmNlLiBWb3VzIHBvdXZleiBtYWludGVuYW50IGNvbW1lbmNlciDDoCBleHBsb3JlciAhJyxcclxuICAgICAgJ/CfkYsgQm9uam91ciAhJyxcclxuICAgICAge1xyXG4gICAgICAgIGNsb3NlQnV0dG9uOiB0cnVlLFxyXG4gICAgICAgIHRhcFRvRGlzbWlzczogZmFsc2UsXHJcbiAgICAgICAgcnRsOiBpc1J0bFxyXG4gICAgICB9XHJcbiAgICApO1xyXG4gIH0sIDIwMDApO1xyXG5cclxuICAvLy0tLS0tLS0tLS0tLSBTdGF0aXN0aWNzIEJhciBDaGFydCAtLS0tLS0tLS0tLS1cclxuICAvLy0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuICBzdGF0aXN0aWNzT3JkZXJDaGFydE9wdGlvbnMgPSB7XHJcbiAgICBjaGFydDoge1xyXG4gICAgICBoZWlnaHQ6IDcwLFxyXG4gICAgICB0eXBlOiAnYmFyJyxcclxuICAgICAgc3RhY2tlZDogdHJ1ZSxcclxuICAgICAgdG9vbGJhcjoge1xyXG4gICAgICAgIHNob3c6IGZhbHNlXHJcbiAgICAgIH1cclxuICAgIH0sXHJcbiAgICBncmlkOiB7XHJcbiAgICAgIHNob3c6IGZhbHNlLFxyXG4gICAgICBwYWRkaW5nOiB7XHJcbiAgICAgICAgbGVmdDogMCxcclxuICAgICAgICByaWdodDogMCxcclxuICAgICAgICB0b3A6IC0xNSxcclxuICAgICAgICBib3R0b206IC0xNVxyXG4gICAgICB9XHJcbiAgICB9LFxyXG4gICAgcGxvdE9wdGlvbnM6IHtcclxuICAgICAgYmFyOiB7XHJcbiAgICAgICAgaG9yaXpvbnRhbDogZmFsc2UsXHJcbiAgICAgICAgY29sdW1uV2lkdGg6ICcyMCUnLFxyXG4gICAgICAgIHN0YXJ0aW5nU2hhcGU6ICdyb3VuZGVkJyxcclxuICAgICAgICBjb2xvcnM6IHtcclxuICAgICAgICAgIGJhY2tncm91bmRCYXJDb2xvcnM6IFskYmFyQ29sb3IsICRiYXJDb2xvciwgJGJhckNvbG9yLCAkYmFyQ29sb3IsICRiYXJDb2xvcl0sXHJcbiAgICAgICAgICBiYWNrZ3JvdW5kQmFyUmFkaXVzOiA1XHJcbiAgICAgICAgfVxyXG4gICAgICB9XHJcbiAgICB9LFxyXG4gICAgbGVnZW5kOiB7XHJcbiAgICAgIHNob3c6IGZhbHNlXHJcbiAgICB9LFxyXG4gICAgZGF0YUxhYmVsczoge1xyXG4gICAgICBlbmFibGVkOiBmYWxzZVxyXG4gICAgfSxcclxuICAgIGNvbG9yczogW3dpbmRvdy5jb2xvcnMuc29saWQud2FybmluZ10sXHJcbiAgICBzZXJpZXM6IFtcclxuICAgICAge1xyXG4gICAgICAgIG5hbWU6ICcyMDIwJyxcclxuICAgICAgICBkYXRhOiBbNDUsIDg1LCA2NSwgNDUsIDY1XVxyXG4gICAgICB9XHJcbiAgICBdLFxyXG4gICAgeGF4aXM6IHtcclxuICAgICAgbGFiZWxzOiB7XHJcbiAgICAgICAgc2hvdzogZmFsc2VcclxuICAgICAgfSxcclxuICAgICAgYXhpc0JvcmRlcjoge1xyXG4gICAgICAgIHNob3c6IGZhbHNlXHJcbiAgICAgIH0sXHJcbiAgICAgIGF4aXNUaWNrczoge1xyXG4gICAgICAgIHNob3c6IGZhbHNlXHJcbiAgICAgIH1cclxuICAgIH0sXHJcbiAgICB5YXhpczoge1xyXG4gICAgICBzaG93OiBmYWxzZVxyXG4gICAgfSxcclxuICAgIHRvb2x0aXA6IHtcclxuICAgICAgeDoge1xyXG4gICAgICAgIHNob3c6IGZhbHNlXHJcbiAgICAgIH1cclxuICAgIH1cclxuICB9O1xyXG4gIHN0YXRpc3RpY3NPcmRlckNoYXJ0ID0gbmV3IEFwZXhDaGFydHMoJHN0YXRpc3RpY3NPcmRlckNoYXJ0LCBzdGF0aXN0aWNzT3JkZXJDaGFydE9wdGlvbnMpO1xyXG4gIHN0YXRpc3RpY3NPcmRlckNoYXJ0LnJlbmRlcigpO1xyXG5cclxuICAvLy0tLS0tLS0tLS0tLSBTdGF0aXN0aWNzIExpbmUgQ2hhcnQgLS0tLS0tLS0tLS0tXHJcbiAgLy8tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLVxyXG4gIHN0YXRpc3RpY3NQcm9maXRDaGFydE9wdGlvbnMgPSB7XHJcbiAgICBjaGFydDoge1xyXG4gICAgICBoZWlnaHQ6IDcwLFxyXG4gICAgICB0eXBlOiAnbGluZScsXHJcbiAgICAgIHRvb2xiYXI6IHtcclxuICAgICAgICBzaG93OiBmYWxzZVxyXG4gICAgICB9LFxyXG4gICAgICB6b29tOiB7XHJcbiAgICAgICAgZW5hYmxlZDogZmFsc2VcclxuICAgICAgfVxyXG4gICAgfSxcclxuICAgIGdyaWQ6IHtcclxuICAgICAgYm9yZGVyQ29sb3I6ICR0cmFja0JnQ29sb3IsXHJcbiAgICAgIHN0cm9rZURhc2hBcnJheTogNSxcclxuICAgICAgeGF4aXM6IHtcclxuICAgICAgICBsaW5lczoge1xyXG4gICAgICAgICAgc2hvdzogdHJ1ZVxyXG4gICAgICAgIH1cclxuICAgICAgfSxcclxuICAgICAgeWF4aXM6IHtcclxuICAgICAgICBsaW5lczoge1xyXG4gICAgICAgICAgc2hvdzogZmFsc2VcclxuICAgICAgICB9XHJcbiAgICAgIH0sXHJcbiAgICAgIHBhZGRpbmc6IHtcclxuICAgICAgICB0b3A6IC0zMCxcclxuICAgICAgICBib3R0b206IC0xMFxyXG4gICAgICB9XHJcbiAgICB9LFxyXG4gICAgc3Ryb2tlOiB7XHJcbiAgICAgIHdpZHRoOiAzXHJcbiAgICB9LFxyXG4gICAgY29sb3JzOiBbd2luZG93LmNvbG9ycy5zb2xpZC5pbmZvXSxcclxuICAgIHNlcmllczogW1xyXG4gICAgICB7XHJcbiAgICAgICAgZGF0YTogWzAsIDIwLCA1LCAzMCwgMTUsIDQ1XVxyXG4gICAgICB9XHJcbiAgICBdLFxyXG4gICAgbWFya2Vyczoge1xyXG4gICAgICBzaXplOiAyLFxyXG4gICAgICBjb2xvcnM6IHdpbmRvdy5jb2xvcnMuc29saWQuaW5mbyxcclxuICAgICAgc3Ryb2tlQ29sb3JzOiB3aW5kb3cuY29sb3JzLnNvbGlkLmluZm8sXHJcbiAgICAgIHN0cm9rZVdpZHRoOiAyLFxyXG4gICAgICBzdHJva2VPcGFjaXR5OiAxLFxyXG4gICAgICBzdHJva2VEYXNoQXJyYXk6IDAsXHJcbiAgICAgIGZpbGxPcGFjaXR5OiAxLFxyXG4gICAgICBkaXNjcmV0ZTogW1xyXG4gICAgICAgIHtcclxuICAgICAgICAgIHNlcmllc0luZGV4OiAwLFxyXG4gICAgICAgICAgZGF0YVBvaW50SW5kZXg6IDUsXHJcbiAgICAgICAgICBmaWxsQ29sb3I6ICcjZmZmZmZmJyxcclxuICAgICAgICAgIHN0cm9rZUNvbG9yOiB3aW5kb3cuY29sb3JzLnNvbGlkLmluZm8sXHJcbiAgICAgICAgICBzaXplOiA1XHJcbiAgICAgICAgfVxyXG4gICAgICBdLFxyXG4gICAgICBzaGFwZTogJ2NpcmNsZScsXHJcbiAgICAgIHJhZGl1czogMixcclxuICAgICAgaG92ZXI6IHtcclxuICAgICAgICBzaXplOiAzXHJcbiAgICAgIH1cclxuICAgIH0sXHJcbiAgICB4YXhpczoge1xyXG4gICAgICBsYWJlbHM6IHtcclxuICAgICAgICBzaG93OiB0cnVlLFxyXG4gICAgICAgIHN0eWxlOiB7XHJcbiAgICAgICAgICBmb250U2l6ZTogJzBweCdcclxuICAgICAgICB9XHJcbiAgICAgIH0sXHJcbiAgICAgIGF4aXNCb3JkZXI6IHtcclxuICAgICAgICBzaG93OiBmYWxzZVxyXG4gICAgICB9LFxyXG4gICAgICBheGlzVGlja3M6IHtcclxuICAgICAgICBzaG93OiBmYWxzZVxyXG4gICAgICB9XHJcbiAgICB9LFxyXG4gICAgeWF4aXM6IHtcclxuICAgICAgc2hvdzogZmFsc2VcclxuICAgIH0sXHJcbiAgICB0b29sdGlwOiB7XHJcbiAgICAgIHg6IHtcclxuICAgICAgICBzaG93OiBmYWxzZVxyXG4gICAgICB9XHJcbiAgICB9XHJcbiAgfTtcclxuICBzdGF0aXN0aWNzUHJvZml0Q2hhcnQgPSBuZXcgQXBleENoYXJ0cygkc3RhdGlzdGljc1Byb2ZpdENoYXJ0LCBzdGF0aXN0aWNzUHJvZml0Q2hhcnRPcHRpb25zKTtcclxuICBzdGF0aXN0aWNzUHJvZml0Q2hhcnQucmVuZGVyKCk7XHJcblxyXG4gIC8vLS0tLS0tLS0tLS0tLS0tIEVhcm5pbmdzIENoYXJ0IC0tLS0tLS0tLS0tLS0tLVxyXG4gIC8vLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLVxyXG4gIGVhcm5pbmdzQ2hhcnRPcHRpb25zID0ge1xyXG4gICAgY2hhcnQ6IHtcclxuICAgICAgdHlwZTogJ2RvbnV0JyxcclxuICAgICAgaGVpZ2h0OiAxMjAsXHJcbiAgICAgIHRvb2xiYXI6IHtcclxuICAgICAgICBzaG93OiBmYWxzZVxyXG4gICAgICB9XHJcbiAgICB9LFxyXG4gICAgZGF0YUxhYmVsczoge1xyXG4gICAgICBlbmFibGVkOiBmYWxzZVxyXG4gICAgfSxcclxuICAgIHNlcmllczogWzUzLCAxNiwgMzFdLFxyXG4gICAgbGVnZW5kOiB7IHNob3c6IGZhbHNlIH0sXHJcbiAgICBjb21wYXJlZFJlc3VsdDogWzIsIC0zLCA4XSxcclxuICAgIGxhYmVsczogWydBcHAnLCAnU2VydmljZScsICdQcm9kdWN0J10sXHJcbiAgICBzdHJva2U6IHsgd2lkdGg6IDAgfSxcclxuICAgIGNvbG9yczogWyRlYXJuaW5nc1N0cm9rZUNvbG9yMiwgJGVhcm5pbmdzU3Ryb2tlQ29sb3IzLCB3aW5kb3cuY29sb3JzLnNvbGlkLnN1Y2Nlc3NdLFxyXG4gICAgZ3JpZDoge1xyXG4gICAgICBwYWRkaW5nOiB7XHJcbiAgICAgICAgcmlnaHQ6IC0yMCxcclxuICAgICAgICBib3R0b206IC04LFxyXG4gICAgICAgIGxlZnQ6IC0yMFxyXG4gICAgICB9XHJcbiAgICB9LFxyXG4gICAgcGxvdE9wdGlvbnM6IHtcclxuICAgICAgcGllOiB7XHJcbiAgICAgICAgc3RhcnRBbmdsZTogLTEwLFxyXG4gICAgICAgIGRvbnV0OiB7XHJcbiAgICAgICAgICBsYWJlbHM6IHtcclxuICAgICAgICAgICAgc2hvdzogdHJ1ZSxcclxuICAgICAgICAgICAgbmFtZToge1xyXG4gICAgICAgICAgICAgIG9mZnNldFk6IDE1XHJcbiAgICAgICAgICAgIH0sXHJcbiAgICAgICAgICAgIHZhbHVlOiB7XHJcbiAgICAgICAgICAgICAgb2Zmc2V0WTogLTE1LFxyXG4gICAgICAgICAgICAgIGZvcm1hdHRlcjogZnVuY3Rpb24gKHZhbCkge1xyXG4gICAgICAgICAgICAgICAgcmV0dXJuIHBhcnNlSW50KHZhbCkgKyAnJSc7XHJcbiAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICB9LFxyXG4gICAgICAgICAgICB0b3RhbDoge1xyXG4gICAgICAgICAgICAgIHNob3c6IHRydWUsXHJcbiAgICAgICAgICAgICAgb2Zmc2V0WTogMTUsXHJcbiAgICAgICAgICAgICAgbGFiZWw6ICdBcHAnLFxyXG4gICAgICAgICAgICAgIGZvcm1hdHRlcjogZnVuY3Rpb24gKHcpIHtcclxuICAgICAgICAgICAgICAgIHJldHVybiAnNTMlJztcclxuICAgICAgICAgICAgICB9XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICAgIH1cclxuICAgICAgICB9XHJcbiAgICAgIH1cclxuICAgIH0sXHJcbiAgICByZXNwb25zaXZlOiBbXHJcbiAgICAgIHtcclxuICAgICAgICBicmVha3BvaW50OiAxMzI1LFxyXG4gICAgICAgIG9wdGlvbnM6IHtcclxuICAgICAgICAgIGNoYXJ0OiB7XHJcbiAgICAgICAgICAgIGhlaWdodDogMTAwXHJcbiAgICAgICAgICB9XHJcbiAgICAgICAgfVxyXG4gICAgICB9LFxyXG4gICAgICB7XHJcbiAgICAgICAgYnJlYWtwb2ludDogMTIwMCxcclxuICAgICAgICBvcHRpb25zOiB7XHJcbiAgICAgICAgICBjaGFydDoge1xyXG4gICAgICAgICAgICBoZWlnaHQ6IDEyMFxyXG4gICAgICAgICAgfVxyXG4gICAgICAgIH1cclxuICAgICAgfSxcclxuICAgICAge1xyXG4gICAgICAgIGJyZWFrcG9pbnQ6IDEwNDUsXHJcbiAgICAgICAgb3B0aW9uczoge1xyXG4gICAgICAgICAgY2hhcnQ6IHtcclxuICAgICAgICAgICAgaGVpZ2h0OiAxMDBcclxuICAgICAgICAgIH1cclxuICAgICAgICB9XHJcbiAgICAgIH0sXHJcbiAgICAgIHtcclxuICAgICAgICBicmVha3BvaW50OiA5OTIsXHJcbiAgICAgICAgb3B0aW9uczoge1xyXG4gICAgICAgICAgY2hhcnQ6IHtcclxuICAgICAgICAgICAgaGVpZ2h0OiAxMjBcclxuICAgICAgICAgIH1cclxuICAgICAgICB9XHJcbiAgICAgIH1cclxuICAgIF1cclxuICB9O1xyXG4gIGVhcm5pbmdzQ2hhcnQgPSBuZXcgQXBleENoYXJ0cygkZWFybmluZ3NDaGFydCwgZWFybmluZ3NDaGFydE9wdGlvbnMpO1xyXG4gIGVhcm5pbmdzQ2hhcnQucmVuZGVyKCk7XHJcblxyXG4gIC8vLS0tLS0tLS0tLS0tIFJldmVudWUgUmVwb3J0IENoYXJ0IC0tLS0tLS0tLS0tLVxyXG4gIC8vLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLVxyXG4gIHJldmVudWVSZXBvcnRDaGFydE9wdGlvbnMgPSB7XHJcbiAgICBjaGFydDoge1xyXG4gICAgICBoZWlnaHQ6IDIzMCxcclxuICAgICAgc3RhY2tlZDogdHJ1ZSxcclxuICAgICAgdHlwZTogJ2JhcicsXHJcbiAgICAgIHRvb2xiYXI6IHsgc2hvdzogZmFsc2UgfVxyXG4gICAgfSxcclxuICAgIHBsb3RPcHRpb25zOiB7XHJcbiAgICAgIGJhcjoge1xyXG4gICAgICAgIGNvbHVtbldpZHRoOiAnMTclJyxcclxuICAgICAgICBlbmRpbmdTaGFwZTogJ3JvdW5kZWQnXHJcbiAgICAgIH0sXHJcbiAgICAgIGRpc3RyaWJ1dGVkOiB0cnVlXHJcbiAgICB9LFxyXG4gICAgY29sb3JzOiBbd2luZG93LmNvbG9ycy5zb2xpZC5wcmltYXJ5LCB3aW5kb3cuY29sb3JzLnNvbGlkLndhcm5pbmddLFxyXG4gICAgc2VyaWVzOiBbXHJcbiAgICAgIHtcclxuICAgICAgICBuYW1lOiAnRWFybmluZycsXHJcbiAgICAgICAgZGF0YTogWzk1LCAxNzcsIDI4NCwgMjU2LCAxMDUsIDYzLCAxNjgsIDIxOCwgNzJdXHJcbiAgICAgIH0sXHJcbiAgICAgIHtcclxuICAgICAgICBuYW1lOiAnRXhwZW5zZScsXHJcbiAgICAgICAgZGF0YTogWy0xNDUsIC04MCwgLTYwLCAtMTgwLCAtMTAwLCAtNjAsIC04NSwgLTc1LCAtMTAwXVxyXG4gICAgICB9XHJcbiAgICBdLFxyXG4gICAgZGF0YUxhYmVsczoge1xyXG4gICAgICBlbmFibGVkOiBmYWxzZVxyXG4gICAgfSxcclxuICAgIGxlZ2VuZDoge1xyXG4gICAgICBzaG93OiBmYWxzZVxyXG4gICAgfSxcclxuICAgIGdyaWQ6IHtcclxuICAgICAgcGFkZGluZzoge1xyXG4gICAgICAgIHRvcDogLTIwLFxyXG4gICAgICAgIGJvdHRvbTogLTEwXHJcbiAgICAgIH0sXHJcbiAgICAgIHlheGlzOiB7XHJcbiAgICAgICAgbGluZXM6IHsgc2hvdzogZmFsc2UgfVxyXG4gICAgICB9XHJcbiAgICB9LFxyXG4gICAgeGF4aXM6IHtcclxuICAgICAgY2F0ZWdvcmllczogWydKYW4nLCAnRmViJywgJ01hcicsICdBcHInLCAnTWF5JywgJ0p1bicsICdKdWwnLCAnQXVnJywgJ1NlcCddLFxyXG4gICAgICBsYWJlbHM6IHtcclxuICAgICAgICBzdHlsZToge1xyXG4gICAgICAgICAgY29sb3JzOiAkdGV4dE11dGVkQ29sb3IsXHJcbiAgICAgICAgICBmb250U2l6ZTogJzAuODZyZW0nXHJcbiAgICAgICAgfVxyXG4gICAgICB9LFxyXG4gICAgICBheGlzVGlja3M6IHtcclxuICAgICAgICBzaG93OiBmYWxzZVxyXG4gICAgICB9LFxyXG4gICAgICBheGlzQm9yZGVyOiB7XHJcbiAgICAgICAgc2hvdzogZmFsc2VcclxuICAgICAgfVxyXG4gICAgfSxcclxuICAgIHlheGlzOiB7XHJcbiAgICAgIGxhYmVsczoge1xyXG4gICAgICAgIHN0eWxlOiB7XHJcbiAgICAgICAgICBjb2xvcnM6ICR0ZXh0TXV0ZWRDb2xvcixcclxuICAgICAgICAgIGZvbnRTaXplOiAnMC44NnJlbSdcclxuICAgICAgICB9XHJcbiAgICAgIH1cclxuICAgIH1cclxuICB9O1xyXG4gIHJldmVudWVSZXBvcnRDaGFydCA9IG5ldyBBcGV4Q2hhcnRzKCRyZXZlbnVlUmVwb3J0Q2hhcnQsIHJldmVudWVSZXBvcnRDaGFydE9wdGlvbnMpO1xyXG4gIHJldmVudWVSZXBvcnRDaGFydC5yZW5kZXIoKTtcclxuXHJcbiAgLy8tLS0tLS0tLS0tLS0tLS0tIEJ1ZGdldCBDaGFydCAtLS0tLS0tLS0tLS0tLS0tXHJcbiAgLy8tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tXHJcbiAgYnVkZ2V0Q2hhcnRPcHRpb25zID0ge1xyXG4gICAgY2hhcnQ6IHtcclxuICAgICAgaGVpZ2h0OiA4MCxcclxuICAgICAgdG9vbGJhcjogeyBzaG93OiBmYWxzZSB9LFxyXG4gICAgICB6b29tOiB7IGVuYWJsZWQ6IGZhbHNlIH0sXHJcbiAgICAgIHR5cGU6ICdsaW5lJyxcclxuICAgICAgc3BhcmtsaW5lOiB7IGVuYWJsZWQ6IHRydWUgfVxyXG4gICAgfSxcclxuICAgIHN0cm9rZToge1xyXG4gICAgICBjdXJ2ZTogJ3Ntb290aCcsXHJcbiAgICAgIGRhc2hBcnJheTogWzAsIDVdLFxyXG4gICAgICB3aWR0aDogWzJdXHJcbiAgICB9LFxyXG4gICAgY29sb3JzOiBbd2luZG93LmNvbG9ycy5zb2xpZC5wcmltYXJ5LCAkYnVkZ2V0U3Ryb2tlQ29sb3IyXSxcclxuICAgIHNlcmllczogW1xyXG4gICAgICB7XHJcbiAgICAgICAgZGF0YTogWzYxLCA0OCwgNjksIDUyLCA2MCwgNDAsIDc5LCA2MCwgNTksIDQzLCA2Ml1cclxuICAgICAgfSxcclxuICAgICAge1xyXG4gICAgICAgIGRhdGE6IFsyMCwgMTAsIDMwLCAxNSwgMjMsIDAsIDI1LCAxNSwgMjAsIDUsIDI3XVxyXG4gICAgICB9XHJcbiAgICBdLFxyXG4gICAgdG9vbHRpcDoge1xyXG4gICAgICBlbmFibGVkOiBmYWxzZVxyXG4gICAgfVxyXG4gIH07XHJcbiAgYnVkZ2V0Q2hhcnQgPSBuZXcgQXBleENoYXJ0cygkYnVkZ2V0Q2hhcnQsIGJ1ZGdldENoYXJ0T3B0aW9ucyk7XHJcbiAgYnVkZ2V0Q2hhcnQucmVuZGVyKCk7XHJcblxyXG4gIC8vLS0tLS0tLS0tLS0tIEJyb3dzZXIgU3RhdGUgQ2hhcnRzIC0tLS0tLS0tLS0tLVxyXG4gIC8vLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLVxyXG5cclxuICAvLyBTdGF0ZSBQcmltYXJ5IENoYXJ0XHJcbiAgYnJvd3NlclN0YXRlUHJpbWFyeUNoYXJ0T3B0aW9ucyA9IHtcclxuICAgIGNoYXJ0OiB7XHJcbiAgICAgIGhlaWdodDogMzAsXHJcbiAgICAgIHdpZHRoOiAzMCxcclxuICAgICAgdHlwZTogJ3JhZGlhbEJhcidcclxuICAgIH0sXHJcbiAgICBncmlkOiB7XHJcbiAgICAgIHNob3c6IGZhbHNlLFxyXG4gICAgICBwYWRkaW5nOiB7XHJcbiAgICAgICAgbGVmdDogLTE1LFxyXG4gICAgICAgIHJpZ2h0OiAtMTUsXHJcbiAgICAgICAgdG9wOiAtMTIsXHJcbiAgICAgICAgYm90dG9tOiAtMTVcclxuICAgICAgfVxyXG4gICAgfSxcclxuICAgIGNvbG9yczogW3dpbmRvdy5jb2xvcnMuc29saWQucHJpbWFyeV0sXHJcbiAgICBzZXJpZXM6IFs1NC40XSxcclxuICAgIHBsb3RPcHRpb25zOiB7XHJcbiAgICAgIHJhZGlhbEJhcjoge1xyXG4gICAgICAgIGhvbGxvdzoge1xyXG4gICAgICAgICAgc2l6ZTogJzIyJSdcclxuICAgICAgICB9LFxyXG4gICAgICAgIHRyYWNrOiB7XHJcbiAgICAgICAgICBiYWNrZ3JvdW5kOiAkdHJhY2tCZ0NvbG9yXHJcbiAgICAgICAgfSxcclxuICAgICAgICBkYXRhTGFiZWxzOiB7XHJcbiAgICAgICAgICBzaG93T246ICdhbHdheXMnLFxyXG4gICAgICAgICAgbmFtZToge1xyXG4gICAgICAgICAgICBzaG93OiBmYWxzZVxyXG4gICAgICAgICAgfSxcclxuICAgICAgICAgIHZhbHVlOiB7XHJcbiAgICAgICAgICAgIHNob3c6IGZhbHNlXHJcbiAgICAgICAgICB9XHJcbiAgICAgICAgfVxyXG4gICAgICB9XHJcbiAgICB9LFxyXG4gICAgc3Ryb2tlOiB7XHJcbiAgICAgIGxpbmVDYXA6ICdyb3VuZCdcclxuICAgIH1cclxuICB9O1xyXG4gIGJyb3dzZXJTdGF0ZVByaW1hcnlDaGFydCA9IG5ldyBBcGV4Q2hhcnRzKCRicm93c2VyU3RhdGVDaGFydFByaW1hcnksIGJyb3dzZXJTdGF0ZVByaW1hcnlDaGFydE9wdGlvbnMpO1xyXG4gIGJyb3dzZXJTdGF0ZVByaW1hcnlDaGFydC5yZW5kZXIoKTtcclxuXHJcbiAgLy8gU3RhdGUgV2FybmluZyBDaGFydFxyXG4gIGJyb3dzZXJTdGF0ZVdhcm5pbmdDaGFydE9wdGlvbnMgPSB7XHJcbiAgICBjaGFydDoge1xyXG4gICAgICBoZWlnaHQ6IDMwLFxyXG4gICAgICB3aWR0aDogMzAsXHJcbiAgICAgIHR5cGU6ICdyYWRpYWxCYXInXHJcbiAgICB9LFxyXG4gICAgZ3JpZDoge1xyXG4gICAgICBzaG93OiBmYWxzZSxcclxuICAgICAgcGFkZGluZzoge1xyXG4gICAgICAgIGxlZnQ6IC0xNSxcclxuICAgICAgICByaWdodDogLTE1LFxyXG4gICAgICAgIHRvcDogLTEyLFxyXG4gICAgICAgIGJvdHRvbTogLTE1XHJcbiAgICAgIH1cclxuICAgIH0sXHJcbiAgICBjb2xvcnM6IFt3aW5kb3cuY29sb3JzLnNvbGlkLndhcm5pbmddLFxyXG4gICAgc2VyaWVzOiBbNi4xXSxcclxuICAgIHBsb3RPcHRpb25zOiB7XHJcbiAgICAgIHJhZGlhbEJhcjoge1xyXG4gICAgICAgIGhvbGxvdzoge1xyXG4gICAgICAgICAgc2l6ZTogJzIyJSdcclxuICAgICAgICB9LFxyXG4gICAgICAgIHRyYWNrOiB7XHJcbiAgICAgICAgICBiYWNrZ3JvdW5kOiAkdHJhY2tCZ0NvbG9yXHJcbiAgICAgICAgfSxcclxuICAgICAgICBkYXRhTGFiZWxzOiB7XHJcbiAgICAgICAgICBzaG93T246ICdhbHdheXMnLFxyXG4gICAgICAgICAgbmFtZToge1xyXG4gICAgICAgICAgICBzaG93OiBmYWxzZVxyXG4gICAgICAgICAgfSxcclxuICAgICAgICAgIHZhbHVlOiB7XHJcbiAgICAgICAgICAgIHNob3c6IGZhbHNlXHJcbiAgICAgICAgICB9XHJcbiAgICAgICAgfVxyXG4gICAgICB9XHJcbiAgICB9LFxyXG4gICAgc3Ryb2tlOiB7XHJcbiAgICAgIGxpbmVDYXA6ICdyb3VuZCdcclxuICAgIH1cclxuICB9O1xyXG4gIGJyb3dzZXJTdGF0ZVdhcm5pbmdDaGFydCA9IG5ldyBBcGV4Q2hhcnRzKCRicm93c2VyU3RhdGVDaGFydFdhcm5pbmcsIGJyb3dzZXJTdGF0ZVdhcm5pbmdDaGFydE9wdGlvbnMpO1xyXG4gIGJyb3dzZXJTdGF0ZVdhcm5pbmdDaGFydC5yZW5kZXIoKTtcclxuXHJcbiAgLy8gU3RhdGUgU2Vjb25kYXJ5IENoYXJ0IDFcclxuICBicm93c2VyU3RhdGVTZWNvbmRhcnlDaGFydE9wdGlvbnMgPSB7XHJcbiAgICBjaGFydDoge1xyXG4gICAgICBoZWlnaHQ6IDMwLFxyXG4gICAgICB3aWR0aDogMzAsXHJcbiAgICAgIHR5cGU6ICdyYWRpYWxCYXInXHJcbiAgICB9LFxyXG4gICAgZ3JpZDoge1xyXG4gICAgICBzaG93OiBmYWxzZSxcclxuICAgICAgcGFkZGluZzoge1xyXG4gICAgICAgIGxlZnQ6IC0xNSxcclxuICAgICAgICByaWdodDogLTE1LFxyXG4gICAgICAgIHRvcDogLTEyLFxyXG4gICAgICAgIGJvdHRvbTogLTE1XHJcbiAgICAgIH1cclxuICAgIH0sXHJcbiAgICBjb2xvcnM6IFt3aW5kb3cuY29sb3JzLnNvbGlkLnNlY29uZGFyeV0sXHJcbiAgICBzZXJpZXM6IFsxNC42XSxcclxuICAgIHBsb3RPcHRpb25zOiB7XHJcbiAgICAgIHJhZGlhbEJhcjoge1xyXG4gICAgICAgIGhvbGxvdzoge1xyXG4gICAgICAgICAgc2l6ZTogJzIyJSdcclxuICAgICAgICB9LFxyXG4gICAgICAgIHRyYWNrOiB7XHJcbiAgICAgICAgICBiYWNrZ3JvdW5kOiAkdHJhY2tCZ0NvbG9yXHJcbiAgICAgICAgfSxcclxuICAgICAgICBkYXRhTGFiZWxzOiB7XHJcbiAgICAgICAgICBzaG93T246ICdhbHdheXMnLFxyXG4gICAgICAgICAgbmFtZToge1xyXG4gICAgICAgICAgICBzaG93OiBmYWxzZVxyXG4gICAgICAgICAgfSxcclxuICAgICAgICAgIHZhbHVlOiB7XHJcbiAgICAgICAgICAgIHNob3c6IGZhbHNlXHJcbiAgICAgICAgICB9XHJcbiAgICAgICAgfVxyXG4gICAgICB9XHJcbiAgICB9LFxyXG4gICAgc3Ryb2tlOiB7XHJcbiAgICAgIGxpbmVDYXA6ICdyb3VuZCdcclxuICAgIH1cclxuICB9O1xyXG4gIGJyb3dzZXJTdGF0ZVNlY29uZGFyeUNoYXJ0ID0gbmV3IEFwZXhDaGFydHMoJGJyb3dzZXJTdGF0ZUNoYXJ0U2Vjb25kYXJ5LCBicm93c2VyU3RhdGVTZWNvbmRhcnlDaGFydE9wdGlvbnMpO1xyXG4gIGJyb3dzZXJTdGF0ZVNlY29uZGFyeUNoYXJ0LnJlbmRlcigpO1xyXG5cclxuICAvLyBTdGF0ZSBJbmZvIENoYXJ0XHJcbiAgYnJvd3NlclN0YXRlSW5mb0NoYXJ0T3B0aW9ucyA9IHtcclxuICAgIGNoYXJ0OiB7XHJcbiAgICAgIGhlaWdodDogMzAsXHJcbiAgICAgIHdpZHRoOiAzMCxcclxuICAgICAgdHlwZTogJ3JhZGlhbEJhcidcclxuICAgIH0sXHJcbiAgICBncmlkOiB7XHJcbiAgICAgIHNob3c6IGZhbHNlLFxyXG4gICAgICBwYWRkaW5nOiB7XHJcbiAgICAgICAgbGVmdDogLTE1LFxyXG4gICAgICAgIHJpZ2h0OiAtMTUsXHJcbiAgICAgICAgdG9wOiAtMTIsXHJcbiAgICAgICAgYm90dG9tOiAtMTVcclxuICAgICAgfVxyXG4gICAgfSxcclxuICAgIGNvbG9yczogW3dpbmRvdy5jb2xvcnMuc29saWQuaW5mb10sXHJcbiAgICBzZXJpZXM6IFs0LjJdLFxyXG4gICAgcGxvdE9wdGlvbnM6IHtcclxuICAgICAgcmFkaWFsQmFyOiB7XHJcbiAgICAgICAgaG9sbG93OiB7XHJcbiAgICAgICAgICBzaXplOiAnMjIlJ1xyXG4gICAgICAgIH0sXHJcbiAgICAgICAgdHJhY2s6IHtcclxuICAgICAgICAgIGJhY2tncm91bmQ6ICR0cmFja0JnQ29sb3JcclxuICAgICAgICB9LFxyXG4gICAgICAgIGRhdGFMYWJlbHM6IHtcclxuICAgICAgICAgIHNob3dPbjogJ2Fsd2F5cycsXHJcbiAgICAgICAgICBuYW1lOiB7XHJcbiAgICAgICAgICAgIHNob3c6IGZhbHNlXHJcbiAgICAgICAgICB9LFxyXG4gICAgICAgICAgdmFsdWU6IHtcclxuICAgICAgICAgICAgc2hvdzogZmFsc2VcclxuICAgICAgICAgIH1cclxuICAgICAgICB9XHJcbiAgICAgIH1cclxuICAgIH0sXHJcbiAgICBzdHJva2U6IHtcclxuICAgICAgbGluZUNhcDogJ3JvdW5kJ1xyXG4gICAgfVxyXG4gIH07XHJcbiAgYnJvd3NlclN0YXRlSW5mb0NoYXJ0ID0gbmV3IEFwZXhDaGFydHMoJGJyb3dzZXJTdGF0ZUNoYXJ0SW5mbywgYnJvd3NlclN0YXRlSW5mb0NoYXJ0T3B0aW9ucyk7XHJcbiAgYnJvd3NlclN0YXRlSW5mb0NoYXJ0LnJlbmRlcigpO1xyXG5cclxuICAvLyBTdGF0ZSBEYW5nZXIgQ2hhcnRcclxuICBicm93c2VyU3RhdGVEYW5nZXJDaGFydE9wdGlvbnMgPSB7XHJcbiAgICBjaGFydDoge1xyXG4gICAgICBoZWlnaHQ6IDMwLFxyXG4gICAgICB3aWR0aDogMzAsXHJcbiAgICAgIHR5cGU6ICdyYWRpYWxCYXInXHJcbiAgICB9LFxyXG4gICAgZ3JpZDoge1xyXG4gICAgICBzaG93OiBmYWxzZSxcclxuICAgICAgcGFkZGluZzoge1xyXG4gICAgICAgIGxlZnQ6IC0xNSxcclxuICAgICAgICByaWdodDogLTE1LFxyXG4gICAgICAgIHRvcDogLTEyLFxyXG4gICAgICAgIGJvdHRvbTogLTE1XHJcbiAgICAgIH1cclxuICAgIH0sXHJcbiAgICBjb2xvcnM6IFt3aW5kb3cuY29sb3JzLnNvbGlkLmRhbmdlcl0sXHJcbiAgICBzZXJpZXM6IFs4LjRdLFxyXG4gICAgcGxvdE9wdGlvbnM6IHtcclxuICAgICAgcmFkaWFsQmFyOiB7XHJcbiAgICAgICAgaG9sbG93OiB7XHJcbiAgICAgICAgICBzaXplOiAnMjIlJ1xyXG4gICAgICAgIH0sXHJcbiAgICAgICAgdHJhY2s6IHtcclxuICAgICAgICAgIGJhY2tncm91bmQ6ICR0cmFja0JnQ29sb3JcclxuICAgICAgICB9LFxyXG4gICAgICAgIGRhdGFMYWJlbHM6IHtcclxuICAgICAgICAgIHNob3dPbjogJ2Fsd2F5cycsXHJcbiAgICAgICAgICBuYW1lOiB7XHJcbiAgICAgICAgICAgIHNob3c6IGZhbHNlXHJcbiAgICAgICAgICB9LFxyXG4gICAgICAgICAgdmFsdWU6IHtcclxuICAgICAgICAgICAgc2hvdzogZmFsc2VcclxuICAgICAgICAgIH1cclxuICAgICAgICB9XHJcbiAgICAgIH1cclxuICAgIH0sXHJcbiAgICBzdHJva2U6IHtcclxuICAgICAgbGluZUNhcDogJ3JvdW5kJ1xyXG4gICAgfVxyXG4gIH07XHJcbiAgYnJvd3NlclN0YXRlRGFuZ2VyQ2hhcnQgPSBuZXcgQXBleENoYXJ0cygkYnJvd3NlclN0YXRlQ2hhcnREYW5nZXIsIGJyb3dzZXJTdGF0ZURhbmdlckNoYXJ0T3B0aW9ucyk7XHJcbiAgYnJvd3NlclN0YXRlRGFuZ2VyQ2hhcnQucmVuZGVyKCk7XHJcblxyXG4gIC8vLS0tLS0tLS0tLS0tIEdvYWwgT3ZlcnZpZXcgQ2hhcnQgLS0tLS0tLS0tLS0tXHJcbiAgLy8tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS0tLS1cclxuICBnb2FsT3ZlcnZpZXdDaGFydE9wdGlvbnMgPSB7XHJcbiAgICBjaGFydDoge1xyXG4gICAgICBoZWlnaHQ6IDI0NSxcclxuICAgICAgdHlwZTogJ3JhZGlhbEJhcicsXHJcbiAgICAgIHNwYXJrbGluZToge1xyXG4gICAgICAgIGVuYWJsZWQ6IHRydWVcclxuICAgICAgfSxcclxuICAgICAgZHJvcFNoYWRvdzoge1xyXG4gICAgICAgIGVuYWJsZWQ6IHRydWUsXHJcbiAgICAgICAgYmx1cjogMyxcclxuICAgICAgICBsZWZ0OiAxLFxyXG4gICAgICAgIHRvcDogMSxcclxuICAgICAgICBvcGFjaXR5OiAwLjFcclxuICAgICAgfVxyXG4gICAgfSxcclxuICAgIGNvbG9yczogWyRnb2FsU3Ryb2tlQ29sb3IyXSxcclxuICAgIHBsb3RPcHRpb25zOiB7XHJcbiAgICAgIHJhZGlhbEJhcjoge1xyXG4gICAgICAgIG9mZnNldFk6IC0xMCxcclxuICAgICAgICBzdGFydEFuZ2xlOiAtMTUwLFxyXG4gICAgICAgIGVuZEFuZ2xlOiAxNTAsXHJcbiAgICAgICAgaG9sbG93OiB7XHJcbiAgICAgICAgICBzaXplOiAnNzclJ1xyXG4gICAgICAgIH0sXHJcbiAgICAgICAgdHJhY2s6IHtcclxuICAgICAgICAgIGJhY2tncm91bmQ6ICRzdHJva2VDb2xvcixcclxuICAgICAgICAgIHN0cm9rZVdpZHRoOiAnNTAlJ1xyXG4gICAgICAgIH0sXHJcbiAgICAgICAgZGF0YUxhYmVsczoge1xyXG4gICAgICAgICAgbmFtZToge1xyXG4gICAgICAgICAgICBzaG93OiBmYWxzZVxyXG4gICAgICAgICAgfSxcclxuICAgICAgICAgIHZhbHVlOiB7XHJcbiAgICAgICAgICAgIGNvbG9yOiAkdGV4dEhlYWRpbmdDb2xvcixcclxuICAgICAgICAgICAgZm9udFNpemU6ICcyLjg2cmVtJyxcclxuICAgICAgICAgICAgZm9udFdlaWdodDogJzYwMCdcclxuICAgICAgICAgIH1cclxuICAgICAgICB9XHJcbiAgICAgIH1cclxuICAgIH0sXHJcbiAgICBmaWxsOiB7XHJcbiAgICAgIHR5cGU6ICdncmFkaWVudCcsXHJcbiAgICAgIGdyYWRpZW50OiB7XHJcbiAgICAgICAgc2hhZGU6ICdkYXJrJyxcclxuICAgICAgICB0eXBlOiAnaG9yaXpvbnRhbCcsXHJcbiAgICAgICAgc2hhZGVJbnRlbnNpdHk6IDAuNSxcclxuICAgICAgICBncmFkaWVudFRvQ29sb3JzOiBbd2luZG93LmNvbG9ycy5zb2xpZC5zdWNjZXNzXSxcclxuICAgICAgICBpbnZlcnNlQ29sb3JzOiB0cnVlLFxyXG4gICAgICAgIG9wYWNpdHlGcm9tOiAxLFxyXG4gICAgICAgIG9wYWNpdHlUbzogMSxcclxuICAgICAgICBzdG9wczogWzAsIDEwMF1cclxuICAgICAgfVxyXG4gICAgfSxcclxuICAgIHNlcmllczogWzgzXSxcclxuICAgIHN0cm9rZToge1xyXG4gICAgICBsaW5lQ2FwOiAncm91bmQnXHJcbiAgICB9LFxyXG4gICAgZ3JpZDoge1xyXG4gICAgICBwYWRkaW5nOiB7XHJcbiAgICAgICAgYm90dG9tOiAzMFxyXG4gICAgICB9XHJcbiAgICB9XHJcbiAgfTtcclxuICBnb2FsT3ZlcnZpZXdDaGFydCA9IG5ldyBBcGV4Q2hhcnRzKCRnb2FsT3ZlcnZpZXdDaGFydCwgZ29hbE92ZXJ2aWV3Q2hhcnRPcHRpb25zKTtcclxuICBnb2FsT3ZlcnZpZXdDaGFydC5yZW5kZXIoKTtcclxufSk7XHJcbiIsInZhciB1bmN1cnJ5VGhpcyA9IHJlcXVpcmUoJy4uL2ludGVybmFscy9mdW5jdGlvbi11bmN1cnJ5LXRoaXMnKTtcblxubW9kdWxlLmV4cG9ydHMgPSB1bmN1cnJ5VGhpcyhbXS5zbGljZSk7XG4iLCJ2YXIgTkFUSVZFX0JJTkQgPSByZXF1aXJlKCcuLi9pbnRlcm5hbHMvZnVuY3Rpb24tYmluZC1uYXRpdmUnKTtcblxudmFyIEZ1bmN0aW9uUHJvdG90eXBlID0gRnVuY3Rpb24ucHJvdG90eXBlO1xudmFyIGFwcGx5ID0gRnVuY3Rpb25Qcm90b3R5cGUuYXBwbHk7XG52YXIgY2FsbCA9IEZ1bmN0aW9uUHJvdG90eXBlLmNhbGw7XG5cbi8vIGVzbGludC1kaXNhYmxlLW5leHQtbGluZSBlcy9uby1yZWZsZWN0IC0tIHNhZmVcbm1vZHVsZS5leHBvcnRzID0gdHlwZW9mIFJlZmxlY3QgPT0gJ29iamVjdCcgJiYgUmVmbGVjdC5hcHBseSB8fCAoTkFUSVZFX0JJTkQgPyBjYWxsLmJpbmQoYXBwbHkpIDogZnVuY3Rpb24gKCkge1xuICByZXR1cm4gY2FsbC5hcHBseShhcHBseSwgYXJndW1lbnRzKTtcbn0pO1xuIiwidmFyIGdsb2JhbCA9IHJlcXVpcmUoJy4uL2ludGVybmFscy9nbG9iYWwnKTtcbnZhciBmYWlscyA9IHJlcXVpcmUoJy4uL2ludGVybmFscy9mYWlscycpO1xudmFyIHVuY3VycnlUaGlzID0gcmVxdWlyZSgnLi4vaW50ZXJuYWxzL2Z1bmN0aW9uLXVuY3VycnktdGhpcycpO1xudmFyIHRvU3RyaW5nID0gcmVxdWlyZSgnLi4vaW50ZXJuYWxzL3RvLXN0cmluZycpO1xudmFyIHRyaW0gPSByZXF1aXJlKCcuLi9pbnRlcm5hbHMvc3RyaW5nLXRyaW0nKS50cmltO1xudmFyIHdoaXRlc3BhY2VzID0gcmVxdWlyZSgnLi4vaW50ZXJuYWxzL3doaXRlc3BhY2VzJyk7XG5cbnZhciAkcGFyc2VJbnQgPSBnbG9iYWwucGFyc2VJbnQ7XG52YXIgU3ltYm9sID0gZ2xvYmFsLlN5bWJvbDtcbnZhciBJVEVSQVRPUiA9IFN5bWJvbCAmJiBTeW1ib2wuaXRlcmF0b3I7XG52YXIgaGV4ID0gL15bKy1dPzB4L2k7XG52YXIgZXhlYyA9IHVuY3VycnlUaGlzKGhleC5leGVjKTtcbnZhciBGT1JDRUQgPSAkcGFyc2VJbnQod2hpdGVzcGFjZXMgKyAnMDgnKSAhPT0gOCB8fCAkcGFyc2VJbnQod2hpdGVzcGFjZXMgKyAnMHgxNicpICE9PSAyMlxuICAvLyBNUyBFZGdlIDE4LSBicm9rZW4gd2l0aCBib3hlZCBzeW1ib2xzXG4gIHx8IChJVEVSQVRPUiAmJiAhZmFpbHMoZnVuY3Rpb24gKCkgeyAkcGFyc2VJbnQoT2JqZWN0KElURVJBVE9SKSk7IH0pKTtcblxuLy8gYHBhcnNlSW50YCBtZXRob2Rcbi8vIGh0dHBzOi8vdGMzOS5lcy9lY21hMjYyLyNzZWMtcGFyc2VpbnQtc3RyaW5nLXJhZGl4XG5tb2R1bGUuZXhwb3J0cyA9IEZPUkNFRCA/IGZ1bmN0aW9uIHBhcnNlSW50KHN0cmluZywgcmFkaXgpIHtcbiAgdmFyIFMgPSB0cmltKHRvU3RyaW5nKHN0cmluZykpO1xuICByZXR1cm4gJHBhcnNlSW50KFMsIChyYWRpeCA+Pj4gMCkgfHwgKGV4ZWMoaGV4LCBTKSA/IDE2IDogMTApKTtcbn0gOiAkcGFyc2VJbnQ7XG4iLCJ2YXIgdW5jdXJyeVRoaXMgPSByZXF1aXJlKCcuLi9pbnRlcm5hbHMvZnVuY3Rpb24tdW5jdXJyeS10aGlzJyk7XG52YXIgcmVxdWlyZU9iamVjdENvZXJjaWJsZSA9IHJlcXVpcmUoJy4uL2ludGVybmFscy9yZXF1aXJlLW9iamVjdC1jb2VyY2libGUnKTtcbnZhciB0b1N0cmluZyA9IHJlcXVpcmUoJy4uL2ludGVybmFscy90by1zdHJpbmcnKTtcbnZhciB3aGl0ZXNwYWNlcyA9IHJlcXVpcmUoJy4uL2ludGVybmFscy93aGl0ZXNwYWNlcycpO1xuXG52YXIgcmVwbGFjZSA9IHVuY3VycnlUaGlzKCcnLnJlcGxhY2UpO1xudmFyIHdoaXRlc3BhY2UgPSAnWycgKyB3aGl0ZXNwYWNlcyArICddJztcbnZhciBsdHJpbSA9IFJlZ0V4cCgnXicgKyB3aGl0ZXNwYWNlICsgd2hpdGVzcGFjZSArICcqJyk7XG52YXIgcnRyaW0gPSBSZWdFeHAod2hpdGVzcGFjZSArIHdoaXRlc3BhY2UgKyAnKiQnKTtcblxuLy8gYFN0cmluZy5wcm90b3R5cGUueyB0cmltLCB0cmltU3RhcnQsIHRyaW1FbmQsIHRyaW1MZWZ0LCB0cmltUmlnaHQgfWAgbWV0aG9kcyBpbXBsZW1lbnRhdGlvblxudmFyIGNyZWF0ZU1ldGhvZCA9IGZ1bmN0aW9uIChUWVBFKSB7XG4gIHJldHVybiBmdW5jdGlvbiAoJHRoaXMpIHtcbiAgICB2YXIgc3RyaW5nID0gdG9TdHJpbmcocmVxdWlyZU9iamVjdENvZXJjaWJsZSgkdGhpcykpO1xuICAgIGlmIChUWVBFICYgMSkgc3RyaW5nID0gcmVwbGFjZShzdHJpbmcsIGx0cmltLCAnJyk7XG4gICAgaWYgKFRZUEUgJiAyKSBzdHJpbmcgPSByZXBsYWNlKHN0cmluZywgcnRyaW0sICcnKTtcbiAgICByZXR1cm4gc3RyaW5nO1xuICB9O1xufTtcblxubW9kdWxlLmV4cG9ydHMgPSB7XG4gIC8vIGBTdHJpbmcucHJvdG90eXBlLnsgdHJpbUxlZnQsIHRyaW1TdGFydCB9YCBtZXRob2RzXG4gIC8vIGh0dHBzOi8vdGMzOS5lcy9lY21hMjYyLyNzZWMtc3RyaW5nLnByb3RvdHlwZS50cmltc3RhcnRcbiAgc3RhcnQ6IGNyZWF0ZU1ldGhvZCgxKSxcbiAgLy8gYFN0cmluZy5wcm90b3R5cGUueyB0cmltUmlnaHQsIHRyaW1FbmQgfWAgbWV0aG9kc1xuICAvLyBodHRwczovL3RjMzkuZXMvZWNtYTI2Mi8jc2VjLXN0cmluZy5wcm90b3R5cGUudHJpbWVuZFxuICBlbmQ6IGNyZWF0ZU1ldGhvZCgyKSxcbiAgLy8gYFN0cmluZy5wcm90b3R5cGUudHJpbWAgbWV0aG9kXG4gIC8vIGh0dHBzOi8vdGMzOS5lcy9lY21hMjYyLyNzZWMtc3RyaW5nLnByb3RvdHlwZS50cmltXG4gIHRyaW06IGNyZWF0ZU1ldGhvZCgzKVxufTtcbiIsInZhciBnbG9iYWwgPSByZXF1aXJlKCcuLi9pbnRlcm5hbHMvZ2xvYmFsJyk7XG52YXIgY2xhc3NvZiA9IHJlcXVpcmUoJy4uL2ludGVybmFscy9jbGFzc29mJyk7XG5cbnZhciBTdHJpbmcgPSBnbG9iYWwuU3RyaW5nO1xuXG5tb2R1bGUuZXhwb3J0cyA9IGZ1bmN0aW9uIChhcmd1bWVudCkge1xuICBpZiAoY2xhc3NvZihhcmd1bWVudCkgPT09ICdTeW1ib2wnKSB0aHJvdyBUeXBlRXJyb3IoJ0Nhbm5vdCBjb252ZXJ0IGEgU3ltYm9sIHZhbHVlIHRvIGEgc3RyaW5nJyk7XG4gIHJldHVybiBTdHJpbmcoYXJndW1lbnQpO1xufTtcbiIsInZhciBnbG9iYWwgPSByZXF1aXJlKCcuLi9pbnRlcm5hbHMvZ2xvYmFsJyk7XG5cbnZhciBUeXBlRXJyb3IgPSBnbG9iYWwuVHlwZUVycm9yO1xuXG5tb2R1bGUuZXhwb3J0cyA9IGZ1bmN0aW9uIChwYXNzZWQsIHJlcXVpcmVkKSB7XG4gIGlmIChwYXNzZWQgPCByZXF1aXJlZCkgdGhyb3cgVHlwZUVycm9yKCdOb3QgZW5vdWdoIGFyZ3VtZW50cycpO1xuICByZXR1cm4gcGFzc2VkO1xufTtcbiIsIi8vIGEgc3RyaW5nIG9mIGFsbCB2YWxpZCB1bmljb2RlIHdoaXRlc3BhY2VzXG5tb2R1bGUuZXhwb3J0cyA9ICdcXHUwMDA5XFx1MDAwQVxcdTAwMEJcXHUwMDBDXFx1MDAwRFxcdTAwMjBcXHUwMEEwXFx1MTY4MFxcdTIwMDBcXHUyMDAxXFx1MjAwMicgK1xuICAnXFx1MjAwM1xcdTIwMDRcXHUyMDA1XFx1MjAwNlxcdTIwMDdcXHUyMDA4XFx1MjAwOVxcdTIwMEFcXHUyMDJGXFx1MjA1RlxcdTMwMDBcXHUyMDI4XFx1MjAyOVxcdUZFRkYnO1xuIiwidmFyICQgPSByZXF1aXJlKCcuLi9pbnRlcm5hbHMvZXhwb3J0Jyk7XG52YXIgJHBhcnNlSW50ID0gcmVxdWlyZSgnLi4vaW50ZXJuYWxzL251bWJlci1wYXJzZS1pbnQnKTtcblxuLy8gYHBhcnNlSW50YCBtZXRob2Rcbi8vIGh0dHBzOi8vdGMzOS5lcy9lY21hMjYyLyNzZWMtcGFyc2VpbnQtc3RyaW5nLXJhZGl4XG4kKHsgZ2xvYmFsOiB0cnVlLCBmb3JjZWQ6IHBhcnNlSW50ICE9ICRwYXJzZUludCB9LCB7XG4gIHBhcnNlSW50OiAkcGFyc2VJbnRcbn0pO1xuIiwidmFyICQgPSByZXF1aXJlKCcuLi9pbnRlcm5hbHMvZXhwb3J0Jyk7XG52YXIgZ2xvYmFsID0gcmVxdWlyZSgnLi4vaW50ZXJuYWxzL2dsb2JhbCcpO1xudmFyIGFwcGx5ID0gcmVxdWlyZSgnLi4vaW50ZXJuYWxzL2Z1bmN0aW9uLWFwcGx5Jyk7XG52YXIgaXNDYWxsYWJsZSA9IHJlcXVpcmUoJy4uL2ludGVybmFscy9pcy1jYWxsYWJsZScpO1xudmFyIHVzZXJBZ2VudCA9IHJlcXVpcmUoJy4uL2ludGVybmFscy9lbmdpbmUtdXNlci1hZ2VudCcpO1xudmFyIGFycmF5U2xpY2UgPSByZXF1aXJlKCcuLi9pbnRlcm5hbHMvYXJyYXktc2xpY2UnKTtcbnZhciB2YWxpZGF0ZUFyZ3VtZW50c0xlbmd0aCA9IHJlcXVpcmUoJy4uL2ludGVybmFscy92YWxpZGF0ZS1hcmd1bWVudHMtbGVuZ3RoJyk7XG5cbnZhciBNU0lFID0gL01TSUUgLlxcLi8udGVzdCh1c2VyQWdlbnQpOyAvLyA8LSBkaXJ0eSBpZTktIGNoZWNrXG52YXIgRnVuY3Rpb24gPSBnbG9iYWwuRnVuY3Rpb247XG5cbnZhciB3cmFwID0gZnVuY3Rpb24gKHNjaGVkdWxlcikge1xuICByZXR1cm4gZnVuY3Rpb24gKGhhbmRsZXIsIHRpbWVvdXQgLyogLCAuLi5hcmd1bWVudHMgKi8pIHtcbiAgICB2YXIgYm91bmRBcmdzID0gdmFsaWRhdGVBcmd1bWVudHNMZW5ndGgoYXJndW1lbnRzLmxlbmd0aCwgMSkgPiAyO1xuICAgIHZhciBmbiA9IGlzQ2FsbGFibGUoaGFuZGxlcikgPyBoYW5kbGVyIDogRnVuY3Rpb24oaGFuZGxlcik7XG4gICAgdmFyIGFyZ3MgPSBib3VuZEFyZ3MgPyBhcnJheVNsaWNlKGFyZ3VtZW50cywgMikgOiB1bmRlZmluZWQ7XG4gICAgcmV0dXJuIHNjaGVkdWxlcihib3VuZEFyZ3MgPyBmdW5jdGlvbiAoKSB7XG4gICAgICBhcHBseShmbiwgdGhpcywgYXJncyk7XG4gICAgfSA6IGZuLCB0aW1lb3V0KTtcbiAgfTtcbn07XG5cbi8vIGllOS0gc2V0VGltZW91dCAmIHNldEludGVydmFsIGFkZGl0aW9uYWwgcGFyYW1ldGVycyBmaXhcbi8vIGh0dHBzOi8vaHRtbC5zcGVjLndoYXR3Zy5vcmcvbXVsdGlwYWdlL3RpbWVycy1hbmQtdXNlci1wcm9tcHRzLmh0bWwjdGltZXJzXG4kKHsgZ2xvYmFsOiB0cnVlLCBiaW5kOiB0cnVlLCBmb3JjZWQ6IE1TSUUgfSwge1xuICAvLyBgc2V0VGltZW91dGAgbWV0aG9kXG4gIC8vIGh0dHBzOi8vaHRtbC5zcGVjLndoYXR3Zy5vcmcvbXVsdGlwYWdlL3RpbWVycy1hbmQtdXNlci1wcm9tcHRzLmh0bWwjZG9tLXNldHRpbWVvdXRcbiAgc2V0VGltZW91dDogd3JhcChnbG9iYWwuc2V0VGltZW91dCksXG4gIC8vIGBzZXRJbnRlcnZhbGAgbWV0aG9kXG4gIC8vIGh0dHBzOi8vaHRtbC5zcGVjLndoYXR3Zy5vcmcvbXVsdGlwYWdlL3RpbWVycy1hbmQtdXNlci1wcm9tcHRzLmh0bWwjZG9tLXNldGludGVydmFsXG4gIHNldEludGVydmFsOiB3cmFwKGdsb2JhbC5zZXRJbnRlcnZhbClcbn0pO1xuIl0sIm5hbWVzIjpbIiQiLCJ3aW5kb3ciLCJvbiIsIiRiYXJDb2xvciIsIiR0cmFja0JnQ29sb3IiLCIkdGV4dE11dGVkQ29sb3IiLCIkYnVkZ2V0U3Ryb2tlQ29sb3IyIiwiJGdvYWxTdHJva2VDb2xvcjIiLCIkc3Ryb2tlQ29sb3IiLCIkdGV4dEhlYWRpbmdDb2xvciIsIiRlYXJuaW5nc1N0cm9rZUNvbG9yMiIsIiRlYXJuaW5nc1N0cm9rZUNvbG9yMyIsIiRzdGF0aXN0aWNzT3JkZXJDaGFydCIsImRvY3VtZW50IiwicXVlcnlTZWxlY3RvciIsIiRzdGF0aXN0aWNzUHJvZml0Q2hhcnQiLCIkZWFybmluZ3NDaGFydCIsIiRyZXZlbnVlUmVwb3J0Q2hhcnQiLCIkYnVkZ2V0Q2hhcnQiLCIkYnJvd3NlclN0YXRlQ2hhcnRQcmltYXJ5IiwiJGJyb3dzZXJTdGF0ZUNoYXJ0V2FybmluZyIsIiRicm93c2VyU3RhdGVDaGFydFNlY29uZGFyeSIsIiRicm93c2VyU3RhdGVDaGFydEluZm8iLCIkYnJvd3NlclN0YXRlQ2hhcnREYW5nZXIiLCIkZ29hbE92ZXJ2aWV3Q2hhcnQiLCJzdGF0aXN0aWNzT3JkZXJDaGFydE9wdGlvbnMiLCJzdGF0aXN0aWNzUHJvZml0Q2hhcnRPcHRpb25zIiwiZWFybmluZ3NDaGFydE9wdGlvbnMiLCJyZXZlbnVlUmVwb3J0Q2hhcnRPcHRpb25zIiwiYnVkZ2V0Q2hhcnRPcHRpb25zIiwiYnJvd3NlclN0YXRlUHJpbWFyeUNoYXJ0T3B0aW9ucyIsImJyb3dzZXJTdGF0ZVdhcm5pbmdDaGFydE9wdGlvbnMiLCJicm93c2VyU3RhdGVTZWNvbmRhcnlDaGFydE9wdGlvbnMiLCJicm93c2VyU3RhdGVJbmZvQ2hhcnRPcHRpb25zIiwiYnJvd3NlclN0YXRlRGFuZ2VyQ2hhcnRPcHRpb25zIiwiZ29hbE92ZXJ2aWV3Q2hhcnRPcHRpb25zIiwic3RhdGlzdGljc09yZGVyQ2hhcnQiLCJzdGF0aXN0aWNzUHJvZml0Q2hhcnQiLCJlYXJuaW5nc0NoYXJ0IiwicmV2ZW51ZVJlcG9ydENoYXJ0IiwiYnVkZ2V0Q2hhcnQiLCJicm93c2VyU3RhdGVQcmltYXJ5Q2hhcnQiLCJicm93c2VyU3RhdGVEYW5nZXJDaGFydCIsImJyb3dzZXJTdGF0ZUluZm9DaGFydCIsImJyb3dzZXJTdGF0ZVNlY29uZGFyeUNoYXJ0IiwiYnJvd3NlclN0YXRlV2FybmluZ0NoYXJ0IiwiZ29hbE92ZXJ2aWV3Q2hhcnQiLCJpc1J0bCIsImF0dHIiLCJzZXRUaW1lb3V0IiwidG9hc3RyIiwiY2xvc2VCdXR0b24iLCJ0YXBUb0Rpc21pc3MiLCJydGwiLCJjaGFydCIsImhlaWdodCIsInR5cGUiLCJzdGFja2VkIiwidG9vbGJhciIsInNob3ciLCJncmlkIiwicGFkZGluZyIsImxlZnQiLCJyaWdodCIsInRvcCIsImJvdHRvbSIsInBsb3RPcHRpb25zIiwiYmFyIiwiaG9yaXpvbnRhbCIsImNvbHVtbldpZHRoIiwic3RhcnRpbmdTaGFwZSIsImNvbG9ycyIsImJhY2tncm91bmRCYXJDb2xvcnMiLCJiYWNrZ3JvdW5kQmFyUmFkaXVzIiwibGVnZW5kIiwiZGF0YUxhYmVscyIsImVuYWJsZWQiLCJzb2xpZCIsIndhcm5pbmciLCJzZXJpZXMiLCJuYW1lIiwiZGF0YSIsInhheGlzIiwibGFiZWxzIiwiYXhpc0JvcmRlciIsImF4aXNUaWNrcyIsInlheGlzIiwidG9vbHRpcCIsIngiLCJBcGV4Q2hhcnRzIiwicmVuZGVyIiwiem9vbSIsImJvcmRlckNvbG9yIiwic3Ryb2tlRGFzaEFycmF5IiwibGluZXMiLCJzdHJva2UiLCJ3aWR0aCIsImluZm8iLCJtYXJrZXJzIiwic2l6ZSIsInN0cm9rZUNvbG9ycyIsInN0cm9rZVdpZHRoIiwic3Ryb2tlT3BhY2l0eSIsImZpbGxPcGFjaXR5IiwiZGlzY3JldGUiLCJzZXJpZXNJbmRleCIsImRhdGFQb2ludEluZGV4IiwiZmlsbENvbG9yIiwic3Ryb2tlQ29sb3IiLCJzaGFwZSIsInJhZGl1cyIsImhvdmVyIiwic3R5bGUiLCJmb250U2l6ZSIsImNvbXBhcmVkUmVzdWx0Iiwic3VjY2VzcyIsInBpZSIsInN0YXJ0QW5nbGUiLCJkb251dCIsIm9mZnNldFkiLCJ2YWx1ZSIsImZvcm1hdHRlciIsInZhbCIsInBhcnNlSW50IiwidG90YWwiLCJsYWJlbCIsInciLCJyZXNwb25zaXZlIiwiYnJlYWtwb2ludCIsIm9wdGlvbnMiLCJlbmRpbmdTaGFwZSIsImRpc3RyaWJ1dGVkIiwicHJpbWFyeSIsImNhdGVnb3JpZXMiLCJzcGFya2xpbmUiLCJjdXJ2ZSIsImRhc2hBcnJheSIsInJhZGlhbEJhciIsImhvbGxvdyIsInRyYWNrIiwiYmFja2dyb3VuZCIsInNob3dPbiIsImxpbmVDYXAiLCJzZWNvbmRhcnkiLCJkYW5nZXIiLCJkcm9wU2hhZG93IiwiYmx1ciIsIm9wYWNpdHkiLCJlbmRBbmdsZSIsImNvbG9yIiwiZm9udFdlaWdodCIsImZpbGwiLCJncmFkaWVudCIsInNoYWRlIiwic2hhZGVJbnRlbnNpdHkiLCJncmFkaWVudFRvQ29sb3JzIiwiaW52ZXJzZUNvbG9ycyIsIm9wYWNpdHlGcm9tIiwib3BhY2l0eVRvIiwic3RvcHMiXSwic291cmNlUm9vdCI6IiJ9