(self["webpackChunk"] = self["webpackChunk"] || []).push([["ImportExportContact"],{

/***/ "./assets/js/ImportExportContact.js":
/*!******************************************!*\
  !*** ./assets/js/ImportExportContact.js ***!
  \******************************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

/* provided dependency */ var $ = __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");
__webpack_require__(/*! core-js/modules/es.array.for-each.js */ "./node_modules/core-js/modules/es.array.for-each.js");

__webpack_require__(/*! core-js/modules/es.object.to-string.js */ "./node_modules/core-js/modules/es.object.to-string.js");

__webpack_require__(/*! core-js/modules/web.dom-collections.for-each.js */ "./node_modules/core-js/modules/web.dom-collections.for-each.js");

__webpack_require__(/*! core-js/modules/es.promise.js */ "./node_modules/core-js/modules/es.promise.js");

__webpack_require__(/*! core-js/modules/es.array.concat.js */ "./node_modules/core-js/modules/es.array.concat.js");

__webpack_require__(/*! regenerator-runtime/runtime.js */ "./node_modules/regenerator-runtime/runtime.js");

function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

/* exported gapiLoaded */

/* exported gisLoaded */

/* exported handleAuthClick */

/* exported handleSignoutClick */
// TODO(developer): Set to client ID and API key from the Developer Console
var CLIENT_ID = $('#google_client_id').text();
var API_KEY = $('#google_api_key').text(); // Discovery doc URL for APIs used by the quickstart

var DISCOVERY_DOC = 'https://www.googleapis.com/discovery/v1/apis/people/v1/rest'; // Authorization scopes required by the API; multiple scopes can be
// included, separated by spaces.

var SCOPES = 'https://www.googleapis.com/auth/contacts.readonly';
var tokenClient;
var gapiInited = false;
var gisInited = false;
var contacts = {};
var agentId = $('#agentId').text();
$('#signout_button').css('visibility', 'hidden');
gapiLoaded();
gisLoaded();
/**
* Callback after api.js is loaded.
*/

function gapiLoaded() {
  gapi.load('client', intializeGapiClient);
}
/**
* Callback after the API client is loaded. Loads the
* discovery doc to initialize the API.
*/


function intializeGapiClient() {
  return _intializeGapiClient.apply(this, arguments);
}
/**
* Callback after Google Identity Services are loaded.
*/


function _intializeGapiClient() {
  _intializeGapiClient = _asyncToGenerator( /*#__PURE__*/regeneratorRuntime.mark(function _callee2() {
    return regeneratorRuntime.wrap(function _callee2$(_context2) {
      while (1) {
        switch (_context2.prev = _context2.next) {
          case 0:
            _context2.next = 2;
            return gapi.client.init({
              apiKey: API_KEY,
              discoveryDocs: [DISCOVERY_DOC]
            });

          case 2:
            gapiInited = true;
            maybeEnableButtons();

          case 4:
          case "end":
            return _context2.stop();
        }
      }
    }, _callee2);
  }));
  return _intializeGapiClient.apply(this, arguments);
}

function gisLoaded() {
  tokenClient = google.accounts.oauth2.initTokenClient({
    client_id: CLIENT_ID,
    scope: SCOPES,
    callback: '' // defined later

  });
  gisInited = true;
  maybeEnableButtons();
}
/**
* Enables user interaction after all libraries are loaded.
*/


function maybeEnableButtons() {
  if (gapiInited && gisInited) {
    $('#authorize_button').removeClass('d-none');
  }
}
/**
*  Sign in the user upon button click.
*/


function handleAuthClick() {
  tokenClient.callback = /*#__PURE__*/function () {
    var _ref = _asyncToGenerator( /*#__PURE__*/regeneratorRuntime.mark(function _callee(resp) {
      return regeneratorRuntime.wrap(function _callee$(_context) {
        while (1) {
          switch (_context.prev = _context.next) {
            case 0:
              if (!(resp.error !== undefined)) {
                _context.next = 2;
                break;
              }

              throw resp;

            case 2:
              $('#signout_button').css('visibility', 'visible');
              $('#authorize_button').text('Rafraichir');
              $('form#contact_form').removeClass('d-none');
              _context.next = 7;
              return listConnectionNames();

            case 7:
            case "end":
              return _context.stop();
          }
        }
      }, _callee);
    }));

    return function (_x) {
      return _ref.apply(this, arguments);
    };
  }();

  if (gapi.client.getToken() === null) {
    // Prompt the user to select a Google Account and ask for consent to share their data
    // when establishing a new session.
    tokenClient.requestAccessToken({
      prompt: 'consent'
    });
  } else {
    // Skip display of account chooser and consent dialog for an existing session.
    tokenClient.requestAccessToken({
      prompt: ''
    });
  }
}
/**
*  Sign out the user upon button click.
*/


function handleSignoutClick() {
  var token = gapi.client.getToken();

  if (token !== null) {
    google.accounts.oauth2.revoke(token.access_token);
    gapi.client.setToken('');
    $('#content').text('');
    $('#authorize_button').text('Authorize');
    $('#signout_button').css('visibility', 'hidden');
  }
}
/**
* Print the display name if available for 10 connections.
*/


function listConnectionNames() {
  return _listConnectionNames.apply(this, arguments);
}
/**
 * Permet d'exporter des tableau en fichier csv 
 */


function _listConnectionNames() {
  _listConnectionNames = _asyncToGenerator( /*#__PURE__*/regeneratorRuntime.mark(function _callee3() {
    var response, connections, index;
    return regeneratorRuntime.wrap(function _callee3$(_context3) {
      while (1) {
        switch (_context3.prev = _context3.next) {
          case 0:
            _context3.prev = 0;
            _context3.next = 3;
            return gapi.client.people.people.connections.list({
              'resourceName': 'people/me',
              'pageSize': 100,
              'personFields': 'names,phoneNumbers,emailAddresses,addresses',
              'sortOrder': 'FIRST_NAME_ASCENDING'
            });

          case 3:
            response = _context3.sent;
            _context3.next = 10;
            break;

          case 6:
            _context3.prev = 6;
            _context3.t0 = _context3["catch"](0);
            $('#content').text(_context3.t0.message);
            return _context3.abrupt("return");

          case 10:
            connections = response.result.connections;

            if (!(!connections || connections.length == 0)) {
              _context3.next = 14;
              break;
            }

            $('#content').text('No connections found.');
            return _context3.abrupt("return");

          case 14:
            for (index = 0; index < connections.length; index++) {
              connections[index].names[0];
              $('#before_list_checkbox').append("\n            <input type=\"checkbox\" id=\"contact_".concat(index, "\" name=\"contact_").concat(index, "\" value=\"").concat(index, "\" class=\"checkClass\">\n            <label for=\"contact_").concat(index, "\"> ").concat(connections[index].names[0].displayName, "</label><br>\n        "));
            }

            $('form#contact_form #btn_submit_form').removeClass('d-none');
            $('form#contact_form #btn_submit_form').addClass('d-block');
            $('#btn_export_mobile_pdf').removeClass('d-none');
            $('#btn_export_mobile_pdf').addClass('d-block');
            $('#btn_export_mobile_excel').removeClass('d-none');
            $('#btn_export_mobile_excel').addClass('d-block');
            $('#check-all').removeClass('d-none');
            $('#check-all').addClass('d-block');
            contacts = connections;

          case 24:
          case "end":
            return _context3.stop();
        }
      }
    }, _callee3, null, [[0, 6]]);
  }));
  return _listConnectionNames.apply(this, arguments);
}

function exportToCsv(rows) {
  var CsvString = "";
  rows.forEach(function (RowItem, RowIndex) {
    RowItem.forEach(function (ColItem, ColIndex) {
      CsvString += ColItem + ';';
    });
    CsvString += "\r\n";
  });
  CsvString = "data:application/csv;charset=utf-8,%EF%BB%BF" + encodeURI(CsvString);
  var x = document.createElement("A");
  x.setAttribute("href", CsvString);
  x.setAttribute("download", "contact.csv");
  document.body.appendChild(x);
  x.click();
}

$('#authorize_button').on('click', function () {
  handleAuthClick();
}); // Exportation contact en fichier excel

$('#btn_export_mobile_excel').on('click', function (e) {
  var that = $(this);
  that.attr('disabled', true);
  var indexConnexions = [];
  var contactsChecked = [];
  $('form#contact_form input[type="checkbox"]:checked').each(function () {
    indexConnexions.push($(this).val());
  });
  indexConnexions.forEach(function (element) {
    contactsChecked.push(contacts[element]);
  });
  var datas = {
    'contacts': contactsChecked
  };
  var urlExportMobile = '/agent/mobile/contacts/exportExcel';
  $.ajax({
    url: urlExportMobile,
    type: "POST",
    data: datas,
    beforeSend: function beforeSend() {
      $('#spinner_loader').html('<div class="spinner-border text-secondary" role="status"><span class="visually-hidden">Loading...</span></div>');
    },
    success: function success(responseAjax) {
      $('#spinner_loader').html('');
      that.attr('disabled', false);

      if (responseAjax.contacts === 'empty') {
        $('#spinner_loader').html('<span class="text-waring"> Veuillez cocher au moin, un contat </span>');
      }

      if (responseAjax.contacts === 'successfully') {
        exportToCsv(responseAjax.datas);
      }
    },
    error: function error() {
      that.html('Erreur');
    }
  });
}); // Exportation contact en fichier PDF

$('#btn_export_mobile_pdf').on('click', function (e) {
  // let that = $(this);
  // that.attr('disabled', true);
  var indexConnexions = [];
  var contactsChecked = [];
  $('form#contact_form input[type="checkbox"]:checked').each(function () {
    indexConnexions.push($(this).val());
  });
  indexConnexions.forEach(function (element) {
    contactsChecked.push(contacts[element]);
  });
  var datas = {
    'contacts': contactsChecked
  };
  var urlExportMobile = '/agent/mobile/contacts/exportPdf';
  $.ajax({
    url: urlExportMobile,
    type: "POST",
    data: datas,
    beforeSend: function beforeSend() {
      $('#spinner_loader').html('<div class="spinner-border text-secondary" role="status"><span class="visually-hidden">Loading...</span></div>');
    },
    success: function success(responseAjax) {
      $('#spinner_loader').html(''); // that.attr('disabled', false)
    },
    error: function error() {
      $('#spinner_loader').html('');
    }
  });
}); // Permet d'importer les contacts vers Greenlife Ultimate

$('#contact_form').on('submit', function (e) {
  e.preventDefault();
  $('#btn_submit_form').attr('disabled', true);
  var indexConnexions = [];
  var contactsChecked = [];
  $('form#contact_form input[type="checkbox"]:checked').each(function () {
    indexConnexions.push($(this).val());
  });
  indexConnexions.forEach(function (element) {
    contactsChecked.push(contacts[element]);
  });
  var datas = {
    'contacts': contactsChecked,
    'agentId': agentId
  };
  var urlPostContact = '/agent/contact/mobile/import';
  $.ajax({
    url: urlPostContact,
    type: "POST",
    data: datas,
    beforeSend: function beforeSend() {
      $('#spinner_loader').html('<div class="spinner-border text-secondary" role="status"><span class="visually-hidden">Loading...</span></div>');
    },
    success: function success(responseAjax) {
      $('#spinner_loader').html('');

      if (responseAjax.contact === 'added') {
        window.location.href = '/agent/contact/liste?contactMobile=added';
      }
    },
    error: function error() {
      $('#spinner_loader').html('Erreur');
    }
  });
}); // TOUT COCHER

$(":radio#cocher").click(function () {
  $(':checkbox.checkClass').prop('checked', true);
  $(":radio#decocher").prop('checked', false);
}); // TOUT DE-COCHER

$(":radio#decocher").click(function () {
  $(':checkbox.checkClass').prop('checked', false);
  $(":radio#cocher").prop('checked', false);
});

/***/ })

},
/******/ __webpack_require__ => { // webpackRuntimeModules
/******/ var __webpack_exec__ = (moduleId) => (__webpack_require__(__webpack_require__.s = moduleId))
/******/ __webpack_require__.O(0, ["vendors-node_modules_jquery_dist_jquery_js","vendors-node_modules_core-js_internals_classof_js-node_modules_core-js_internals_export_js","vendors-node_modules_core-js_modules_es_promise_js","vendors-node_modules_regenerator-runtime_runtime_js","vendors-node_modules_core-js_internals_array-slice_js-node_modules_core-js_internals_function-ddb79d"], () => (__webpack_exec__("./assets/js/ImportExportContact.js")));
/******/ var __webpack_exports__ = __webpack_require__.O();
/******/ }
]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,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QixTQUEvQixFQUEwQyxJQUExQztBQUNBaEcsRUFBQUEsQ0FBQyxDQUFDLGlCQUFELENBQUQsQ0FBcUJnRyxJQUFyQixDQUEwQixTQUExQixFQUFxQyxLQUFyQztBQUNILENBSEQsR0FJQTs7QUFDQWhHLENBQUMsQ0FBQyxpQkFBRCxDQUFELENBQXFCcUUsS0FBckIsQ0FBMkIsWUFBVTtBQUNqQ3JFLEVBQUFBLENBQUMsQ0FBQyxzQkFBRCxDQUFELENBQTBCZ0csSUFBMUIsQ0FBK0IsU0FBL0IsRUFBMEMsS0FBMUM7QUFDQWhHLEVBQUFBLENBQUMsQ0FBQyxlQUFELENBQUQsQ0FBbUJnRyxJQUFuQixDQUF3QixTQUF4QixFQUFtQyxLQUFuQztBQUNILENBSEQiLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvanMvSW1wb3J0RXhwb3J0Q29udGFjdC5qcyJdLCJzb3VyY2VzQ29udGVudCI6WyJcclxuLyogZXhwb3J0ZWQgZ2FwaUxvYWRlZCAqL1xyXG4vKiBleHBvcnRlZCBnaXNMb2FkZWQgKi9cclxuLyogZXhwb3J0ZWQgaGFuZGxlQXV0aENsaWNrICovXHJcbi8qIGV4cG9ydGVkIGhhbmRsZVNpZ25vdXRDbGljayAqL1xyXG5cclxuLy8gVE9ETyhkZXZlbG9wZXIpOiBTZXQgdG8gY2xpZW50IElEIGFuZCBBUEkga2V5IGZyb20gdGhlIERldmVsb3BlciBDb25zb2xlXHJcbmNvbnN0IENMSUVOVF9JRCA9ICQoJyNnb29nbGVfY2xpZW50X2lkJykudGV4dCgpO1xyXG5jb25zdCBBUElfS0VZID0gJCgnI2dvb2dsZV9hcGlfa2V5JykudGV4dCgpO1xyXG5cclxuXHJcblxyXG4vLyBEaXNjb3ZlcnkgZG9jIFVSTCBmb3IgQVBJcyB1c2VkIGJ5IHRoZSBxdWlja3N0YXJ0XHJcbmNvbnN0IERJU0NPVkVSWV9ET0MgPSAnaHR0cHM6Ly93d3cuZ29vZ2xlYXBpcy5jb20vZGlzY292ZXJ5L3YxL2FwaXMvcGVvcGxlL3YxL3Jlc3QnO1xyXG5cclxuLy8gQXV0aG9yaXphdGlvbiBzY29wZXMgcmVxdWlyZWQgYnkgdGhlIEFQSTsgbXVsdGlwbGUgc2NvcGVzIGNhbiBiZVxyXG4vLyBpbmNsdWRlZCwgc2VwYXJhdGVkIGJ5IHNwYWNlcy5cclxuY29uc3QgU0NPUEVTID0gJ2h0dHBzOi8vd3d3Lmdvb2dsZWFwaXMuY29tL2F1dGgvY29udGFjdHMucmVhZG9ubHknO1xyXG5cclxubGV0IHRva2VuQ2xpZW50O1xyXG5sZXQgZ2FwaUluaXRlZCA9IGZhbHNlO1xyXG5sZXQgZ2lzSW5pdGVkID0gZmFsc2U7XHJcbmxldCBjb250YWN0cyA9IHt9O1xyXG5sZXQgYWdlbnRJZCA9ICQoJyNhZ2VudElkJykudGV4dCgpO1xyXG5cclxuJCgnI3NpZ25vdXRfYnV0dG9uJykuY3NzKCd2aXNpYmlsaXR5JywgJ2hpZGRlbicpO1xyXG5cclxuZ2FwaUxvYWRlZCgpO1xyXG5naXNMb2FkZWQoKTtcclxuXHJcbi8qKlxyXG4qIENhbGxiYWNrIGFmdGVyIGFwaS5qcyBpcyBsb2FkZWQuXHJcbiovXHJcbmZ1bmN0aW9uIGdhcGlMb2FkZWQoKSB7XHJcbiAgICBnYXBpLmxvYWQoJ2NsaWVudCcsIGludGlhbGl6ZUdhcGlDbGllbnQpO1xyXG59XHJcblxyXG4vKipcclxuKiBDYWxsYmFjayBhZnRlciB0aGUgQVBJIGNsaWVudCBpcyBsb2FkZWQuIExvYWRzIHRoZVxyXG4qIGRpc2NvdmVyeSBkb2MgdG8gaW5pdGlhbGl6ZSB0aGUgQVBJLlxyXG4qL1xyXG5hc3luYyBmdW5jdGlvbiBpbnRpYWxpemVHYXBpQ2xpZW50KCkge1xyXG4gICAgYXdhaXQgZ2FwaS5jbGllbnQuaW5pdCh7XHJcbiAgICAgICAgYXBpS2V5OiBBUElfS0VZLFxyXG4gICAgICAgIGRpc2NvdmVyeURvY3M6IFtESVNDT1ZFUllfRE9DXSxcclxuICAgIH0pO1xyXG4gICAgZ2FwaUluaXRlZCA9IHRydWU7XHJcbiAgICBtYXliZUVuYWJsZUJ1dHRvbnMoKTtcclxufVxyXG5cclxuLyoqXHJcbiogQ2FsbGJhY2sgYWZ0ZXIgR29vZ2xlIElkZW50aXR5IFNlcnZpY2VzIGFyZSBsb2FkZWQuXHJcbiovXHJcbmZ1bmN0aW9uIGdpc0xvYWRlZCgpIHtcclxuICAgICAgICB0b2tlbkNsaWVudCA9IGdvb2dsZS5hY2NvdW50cy5vYXV0aDIuaW5pdFRva2VuQ2xpZW50KHtcclxuICAgICAgICBjbGllbnRfaWQ6IENMSUVOVF9JRCxcclxuICAgICAgICBzY29wZTogU0NPUEVTLFxyXG4gICAgICAgIGNhbGxiYWNrOiAnJywgLy8gZGVmaW5lZCBsYXRlclxyXG4gICAgfSk7XHJcbiAgICBnaXNJbml0ZWQgPSB0cnVlO1xyXG4gICAgbWF5YmVFbmFibGVCdXR0b25zKCk7XHJcbn1cclxuXHJcbi8qKlxyXG4qIEVuYWJsZXMgdXNlciBpbnRlcmFjdGlvbiBhZnRlciBhbGwgbGlicmFyaWVzIGFyZSBsb2FkZWQuXHJcbiovXHJcbmZ1bmN0aW9uIG1heWJlRW5hYmxlQnV0dG9ucygpIHtcclxuICAgIGlmIChnYXBpSW5pdGVkICYmIGdpc0luaXRlZCkge1xyXG4gICAgICAgICQoJyNhdXRob3JpemVfYnV0dG9uJykucmVtb3ZlQ2xhc3MoJ2Qtbm9uZScpO1xyXG4gICAgfVxyXG59XHJcblxyXG4vKipcclxuKiAgU2lnbiBpbiB0aGUgdXNlciB1cG9uIGJ1dHRvbiBjbGljay5cclxuKi9cclxuZnVuY3Rpb24gaGFuZGxlQXV0aENsaWNrKCkge1xyXG4gICAgdG9rZW5DbGllbnQuY2FsbGJhY2sgPSBhc3luYyAocmVzcCkgPT4ge1xyXG4gICAgaWYgKHJlc3AuZXJyb3IgIT09IHVuZGVmaW5lZCkge1xyXG4gICAgICAgIHRocm93IChyZXNwKTtcclxuICAgIH1cclxuICAgICAgICAkKCcjc2lnbm91dF9idXR0b24nKS5jc3MoJ3Zpc2liaWxpdHknLCAndmlzaWJsZScpO1xyXG4gICAgICAgICQoJyNhdXRob3JpemVfYnV0dG9uJykudGV4dCgnUmFmcmFpY2hpcicpO1xyXG4gICAgICAgICQoJ2Zvcm0jY29udGFjdF9mb3JtJykucmVtb3ZlQ2xhc3MoJ2Qtbm9uZScpO1xyXG4gICAgICAgIFxyXG5cclxuICAgICAgICBhd2FpdCBsaXN0Q29ubmVjdGlvbk5hbWVzKCk7XHJcbiAgICB9O1xyXG5cclxuICAgIGlmIChnYXBpLmNsaWVudC5nZXRUb2tlbigpID09PSBudWxsKSB7XHJcbiAgICAgICAgLy8gUHJvbXB0IHRoZSB1c2VyIHRvIHNlbGVjdCBhIEdvb2dsZSBBY2NvdW50IGFuZCBhc2sgZm9yIGNvbnNlbnQgdG8gc2hhcmUgdGhlaXIgZGF0YVxyXG4gICAgICAgIC8vIHdoZW4gZXN0YWJsaXNoaW5nIGEgbmV3IHNlc3Npb24uXHJcbiAgICAgICAgdG9rZW5DbGllbnQucmVxdWVzdEFjY2Vzc1Rva2VuKHtwcm9tcHQ6ICdjb25zZW50J30pO1xyXG4gICAgfSBlbHNlIHtcclxuICAgICAgICAvLyBTa2lwIGRpc3BsYXkgb2YgYWNjb3VudCBjaG9vc2VyIGFuZCBjb25zZW50IGRpYWxvZyBmb3IgYW4gZXhpc3Rpbmcgc2Vzc2lvbi5cclxuICAgICAgICB0b2tlbkNsaWVudC5yZXF1ZXN0QWNjZXNzVG9rZW4oe3Byb21wdDogJyd9KTtcclxuICAgIH1cclxufVxyXG5cclxuLyoqXHJcbiogIFNpZ24gb3V0IHRoZSB1c2VyIHVwb24gYnV0dG9uIGNsaWNrLlxyXG4qL1xyXG5mdW5jdGlvbiBoYW5kbGVTaWdub3V0Q2xpY2soKSB7XHJcbiAgICBjb25zdCB0b2tlbiA9IGdhcGkuY2xpZW50LmdldFRva2VuKCk7XHJcbiAgICBpZiAodG9rZW4gIT09IG51bGwpIHtcclxuICAgICAgICBnb29nbGUuYWNjb3VudHMub2F1dGgyLnJldm9rZSh0b2tlbi5hY2Nlc3NfdG9rZW4pO1xyXG4gICAgICAgIGdhcGkuY2xpZW50LnNldFRva2VuKCcnKTtcclxuICAgICAgICAkKCcjY29udGVudCcpLnRleHQoJycpO1xyXG4gICAgICAgICQoJyNhdXRob3JpemVfYnV0dG9uJykudGV4dCgnQXV0aG9yaXplJyk7XHJcbiAgICAgICAgJCgnI3NpZ25vdXRfYnV0dG9uJykuY3NzKCd2aXNpYmlsaXR5JywgJ2hpZGRlbicpO1xyXG4gICAgfVxyXG59XHJcblxyXG4vKipcclxuKiBQcmludCB0aGUgZGlzcGxheSBuYW1lIGlmIGF2YWlsYWJsZSBmb3IgMTAgY29ubmVjdGlvbnMuXHJcbiovXHJcbmFzeW5jIGZ1bmN0aW9uIGxpc3RDb25uZWN0aW9uTmFtZXMoKSB7XHJcbiAgICBsZXQgcmVzcG9uc2U7XHJcbiAgICB0cnkge1xyXG4gICAgICAgIC8vIEZldGNoIGZpcnN0IDEwIGZpbGVzXHJcbiAgICAgICAgcmVzcG9uc2UgPSBhd2FpdCBnYXBpLmNsaWVudC5wZW9wbGUucGVvcGxlLmNvbm5lY3Rpb25zLmxpc3Qoe1xyXG4gICAgICAgICAgICAncmVzb3VyY2VOYW1lJzogJ3Blb3BsZS9tZScsXHJcbiAgICAgICAgICAgICdwYWdlU2l6ZSc6IDEwMCxcclxuICAgICAgICAgICAgJ3BlcnNvbkZpZWxkcyc6ICduYW1lcyxwaG9uZU51bWJlcnMsZW1haWxBZGRyZXNzZXMsYWRkcmVzc2VzJyxcclxuICAgICAgICAgICAgJ3NvcnRPcmRlcic6ICdGSVJTVF9OQU1FX0FTQ0VORElORydcclxuICAgICAgICB9KTtcclxuICAgIH0gY2F0Y2ggKGVycikge1xyXG4gICAgICAgICQoJyNjb250ZW50JykudGV4dChlcnIubWVzc2FnZSk7XHJcbiAgICAgICAgcmV0dXJuO1xyXG4gICAgfVxyXG5cclxuICAgIGNvbnN0IGNvbm5lY3Rpb25zID0gcmVzcG9uc2UucmVzdWx0LmNvbm5lY3Rpb25zO1xyXG4gICAgaWYgKCFjb25uZWN0aW9ucyB8fCBjb25uZWN0aW9ucy5sZW5ndGggPT0gMCkge1xyXG4gICAgICAgICQoJyNjb250ZW50JykudGV4dCgnTm8gY29ubmVjdGlvbnMgZm91bmQuJyk7XHJcbiAgICAgICAgXHJcbiAgICAgICAgcmV0dXJuO1xyXG4gICAgfVxyXG5cclxuICAgIGZvciAobGV0IGluZGV4ID0gMDsgaW5kZXggPCBjb25uZWN0aW9ucy5sZW5ndGg7IGluZGV4KyspIHtcclxuICAgICAgICBjb25uZWN0aW9uc1tpbmRleF0ubmFtZXNbMF1cdFxyXG4gICAgICAgICQoJyNiZWZvcmVfbGlzdF9jaGVja2JveCcpLmFwcGVuZChgXHJcbiAgICAgICAgICAgIDxpbnB1dCB0eXBlPVwiY2hlY2tib3hcIiBpZD1cImNvbnRhY3RfJHtpbmRleH1cIiBuYW1lPVwiY29udGFjdF8ke2luZGV4fVwiIHZhbHVlPVwiJHtpbmRleH1cIiBjbGFzcz1cImNoZWNrQ2xhc3NcIj5cclxuICAgICAgICAgICAgPGxhYmVsIGZvcj1cImNvbnRhY3RfJHtpbmRleH1cIj4gJHtjb25uZWN0aW9uc1tpbmRleF0ubmFtZXNbMF0uZGlzcGxheU5hbWV9PC9sYWJlbD48YnI+XHJcbiAgICAgICAgYCk7XHJcbiAgICB9XHJcbiAgICAkKCdmb3JtI2NvbnRhY3RfZm9ybSAjYnRuX3N1Ym1pdF9mb3JtJykucmVtb3ZlQ2xhc3MoJ2Qtbm9uZScpO1xyXG4gICAgJCgnZm9ybSNjb250YWN0X2Zvcm0gI2J0bl9zdWJtaXRfZm9ybScpLmFkZENsYXNzKCdkLWJsb2NrJyk7XHJcbiAgICAkKCcjYnRuX2V4cG9ydF9tb2JpbGVfcGRmJykucmVtb3ZlQ2xhc3MoJ2Qtbm9uZScpO1xyXG4gICAgJCgnI2J0bl9leHBvcnRfbW9iaWxlX3BkZicpLmFkZENsYXNzKCdkLWJsb2NrJyk7XHJcbiAgICAkKCcjYnRuX2V4cG9ydF9tb2JpbGVfZXhjZWwnKS5yZW1vdmVDbGFzcygnZC1ub25lJyk7XHJcbiAgICAkKCcjYnRuX2V4cG9ydF9tb2JpbGVfZXhjZWwnKS5hZGRDbGFzcygnZC1ibG9jaycpO1xyXG4gICAgJCgnI2NoZWNrLWFsbCcpLnJlbW92ZUNsYXNzKCdkLW5vbmUnKTtcclxuICAgICQoJyNjaGVjay1hbGwnKS5hZGRDbGFzcygnZC1ibG9jaycpO1xyXG4gICAgXHJcbiAgICBjb250YWN0cyA9IGNvbm5lY3Rpb25zO1xyXG5cclxufVxyXG5cclxuXHJcbi8qKlxyXG4gKiBQZXJtZXQgZCdleHBvcnRlciBkZXMgdGFibGVhdSBlbiBmaWNoaWVyIGNzdiBcclxuICovXHJcbmZ1bmN0aW9uIGV4cG9ydFRvQ3N2KHJvd3MpIHtcclxuICAgIHZhciBDc3ZTdHJpbmcgPSBcIlwiO1xyXG5cclxuICAgIHJvd3MuZm9yRWFjaChmdW5jdGlvbihSb3dJdGVtLCBSb3dJbmRleCkge1xyXG4gICAgICAgIFJvd0l0ZW0uZm9yRWFjaChmdW5jdGlvbihDb2xJdGVtLCBDb2xJbmRleCkge1xyXG4gICAgICAgICAgICBDc3ZTdHJpbmcgKz0gQ29sSXRlbSArICc7JztcclxuICAgICAgICB9KTtcclxuICAgICAgICBDc3ZTdHJpbmcgKz0gXCJcXHJcXG5cIjtcclxuICAgIH0pO1xyXG5cclxuICAgIENzdlN0cmluZyA9IFwiZGF0YTphcHBsaWNhdGlvbi9jc3Y7Y2hhcnNldD11dGYtOCwlRUYlQkIlQkZcIiArIGVuY29kZVVSSShDc3ZTdHJpbmcpO1xyXG4gICAgdmFyIHggPSBkb2N1bWVudC5jcmVhdGVFbGVtZW50KFwiQVwiKTtcclxuICAgIHguc2V0QXR0cmlidXRlKFwiaHJlZlwiLCBDc3ZTdHJpbmcgKTtcclxuXHJcbiAgICB4LnNldEF0dHJpYnV0ZShcImRvd25sb2FkXCIsYGNvbnRhY3QuY3N2YCk7XHJcbiAgICBkb2N1bWVudC5ib2R5LmFwcGVuZENoaWxkKHgpO1xyXG4gICAgeC5jbGljaygpO1xyXG59XHJcblxyXG5cclxuJCgnI2F1dGhvcml6ZV9idXR0b24nKS5vbignY2xpY2snLCBmdW5jdGlvbigpe1xyXG4gICAgaGFuZGxlQXV0aENsaWNrKClcclxufSlcclxuXHJcbi8vIEV4cG9ydGF0aW9uIGNvbnRhY3QgZW4gZmljaGllciBleGNlbFxyXG4kKCcjYnRuX2V4cG9ydF9tb2JpbGVfZXhjZWwnKS5vbignY2xpY2snLCBmdW5jdGlvbihlKXtcclxuICAgIGxldCB0aGF0ID0gJCh0aGlzKTtcclxuICAgIHRoYXQuYXR0cignZGlzYWJsZWQnLCB0cnVlKTtcclxuXHJcbiAgICB2YXIgaW5kZXhDb25uZXhpb25zID0gW107XHJcbiAgICB2YXIgY29udGFjdHNDaGVja2VkID0gW107XHJcblxyXG4gICAgJCgnZm9ybSNjb250YWN0X2Zvcm0gaW5wdXRbdHlwZT1cImNoZWNrYm94XCJdOmNoZWNrZWQnKS5lYWNoKGZ1bmN0aW9uICgpIHtcclxuICAgICAgICBpbmRleENvbm5leGlvbnMucHVzaCgkKHRoaXMpLnZhbCgpKTtcclxuICAgIH0pO1xyXG5cclxuICAgIGluZGV4Q29ubmV4aW9ucy5mb3JFYWNoKGVsZW1lbnQgPT4ge1xyXG4gICAgICAgIGNvbnRhY3RzQ2hlY2tlZC5wdXNoKGNvbnRhY3RzW2VsZW1lbnRdKTtcclxuICAgIH0pO1xyXG5cclxuICAgIGxldCBkYXRhcyA9IHtcclxuICAgICAgICAnY29udGFjdHMnIDogY29udGFjdHNDaGVja2VkLFxyXG4gICAgfVxyXG5cclxuICAgIGNvbnN0IHVybEV4cG9ydE1vYmlsZSA9ICAnL2FnZW50L21vYmlsZS9jb250YWN0cy9leHBvcnRFeGNlbCc7XHJcbiAgICAkLmFqYXgoe1xyXG4gICAgICAgIHVybDogdXJsRXhwb3J0TW9iaWxlLFxyXG4gICAgICAgIHR5cGU6IFwiUE9TVFwiLFxyXG4gICAgICAgIGRhdGE6IGRhdGFzLFxyXG4gICAgICAgIGJlZm9yZVNlbmQgOiBmdW5jdGlvbigpe1xyXG4gICAgICAgICAgICAkKCcjc3Bpbm5lcl9sb2FkZXInKS5odG1sKCc8ZGl2IGNsYXNzPVwic3Bpbm5lci1ib3JkZXIgdGV4dC1zZWNvbmRhcnlcIiByb2xlPVwic3RhdHVzXCI+PHNwYW4gY2xhc3M9XCJ2aXN1YWxseS1oaWRkZW5cIj5Mb2FkaW5nLi4uPC9zcGFuPjwvZGl2PicpXHJcbiAgICAgICAgfSxcclxuICAgICAgICBzdWNjZXNzOiBmdW5jdGlvbihyZXNwb25zZUFqYXgpe1xyXG4gICAgICAgICAgICAkKCcjc3Bpbm5lcl9sb2FkZXInKS5odG1sKCcnKTtcclxuICAgICAgICAgICAgdGhhdC5hdHRyKCdkaXNhYmxlZCcsIGZhbHNlKVxyXG4gICAgICAgICAgICBpZihyZXNwb25zZUFqYXguY29udGFjdHMgPT09ICdlbXB0eScpe1xyXG4gICAgICAgICAgICAgICAgJCgnI3NwaW5uZXJfbG9hZGVyJykuaHRtbCgnPHNwYW4gY2xhc3M9XCJ0ZXh0LXdhcmluZ1wiPiBWZXVpbGxleiBjb2NoZXIgYXUgbW9pbiwgdW4gY29udGF0IDwvc3Bhbj4nKTtcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICBpZiAocmVzcG9uc2VBamF4LmNvbnRhY3RzID09PSAnc3VjY2Vzc2Z1bGx5JykgeyBcclxuICAgICAgICAgICAgICAgIGV4cG9ydFRvQ3N2KHJlc3BvbnNlQWpheC5kYXRhcyk7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICB9LFxyXG4gICAgICAgIGVycm9yIDogZnVuY3Rpb24oKXtcclxuICAgICAgICAgICAgdGhhdC5odG1sKCdFcnJldXInKTtcclxuICAgICAgICB9XHJcbiAgICB9KVxyXG5cclxufSk7XHJcblxyXG4vLyBFeHBvcnRhdGlvbiBjb250YWN0IGVuIGZpY2hpZXIgUERGXHJcbiQoJyNidG5fZXhwb3J0X21vYmlsZV9wZGYnKS5vbignY2xpY2snLCBmdW5jdGlvbihlKXtcclxuICAgIC8vIGxldCB0aGF0ID0gJCh0aGlzKTtcclxuICAgIC8vIHRoYXQuYXR0cignZGlzYWJsZWQnLCB0cnVlKTtcclxuXHJcbiAgICB2YXIgaW5kZXhDb25uZXhpb25zID0gW107XHJcbiAgICB2YXIgY29udGFjdHNDaGVja2VkID0gW107XHJcblxyXG4gICAgJCgnZm9ybSNjb250YWN0X2Zvcm0gaW5wdXRbdHlwZT1cImNoZWNrYm94XCJdOmNoZWNrZWQnKS5lYWNoKGZ1bmN0aW9uICgpIHtcclxuICAgICAgICBpbmRleENvbm5leGlvbnMucHVzaCgkKHRoaXMpLnZhbCgpKTtcclxuICAgIH0pO1xyXG5cclxuICAgIGluZGV4Q29ubmV4aW9ucy5mb3JFYWNoKGVsZW1lbnQgPT4ge1xyXG4gICAgICAgIGNvbnRhY3RzQ2hlY2tlZC5wdXNoKGNvbnRhY3RzW2VsZW1lbnRdKTtcclxuICAgIH0pO1xyXG5cclxuICAgIGxldCBkYXRhcyA9IHtcclxuICAgICAgICAnY29udGFjdHMnIDogY29udGFjdHNDaGVja2VkLFxyXG4gICAgfVxyXG5cclxuICAgIGNvbnN0IHVybEV4cG9ydE1vYmlsZSA9ICAnL2FnZW50L21vYmlsZS9jb250YWN0cy9leHBvcnRQZGYnO1xyXG4gICAgJC5hamF4KHtcclxuICAgICAgICB1cmw6IHVybEV4cG9ydE1vYmlsZSxcclxuICAgICAgICB0eXBlOiBcIlBPU1RcIixcclxuICAgICAgICBkYXRhOiBkYXRhcyxcclxuICAgICAgICBiZWZvcmVTZW5kIDogZnVuY3Rpb24oKXtcclxuICAgICAgICAgICAgJCgnI3NwaW5uZXJfbG9hZGVyJykuaHRtbCgnPGRpdiBjbGFzcz1cInNwaW5uZXItYm9yZGVyIHRleHQtc2Vjb25kYXJ5XCIgcm9sZT1cInN0YXR1c1wiPjxzcGFuIGNsYXNzPVwidmlzdWFsbHktaGlkZGVuXCI+TG9hZGluZy4uLjwvc3Bhbj48L2Rpdj4nKVxyXG4gICAgICAgIH0sXHJcbiAgICAgICAgc3VjY2VzczogZnVuY3Rpb24ocmVzcG9uc2VBamF4KXtcclxuICAgICAgICAgICAgJCgnI3NwaW5uZXJfbG9hZGVyJykuaHRtbCgnJyk7XHJcbiAgICAgICAgICAgIC8vIHRoYXQuYXR0cignZGlzYWJsZWQnLCBmYWxzZSlcclxuICAgICAgICB9LFxyXG4gICAgICAgIGVycm9yIDogZnVuY3Rpb24oKXtcclxuICAgICAgICAgICAgJCgnI3NwaW5uZXJfbG9hZGVyJykuaHRtbCgnJyk7XHJcbiAgICAgICAgfVxyXG4gICAgfSlcclxuXHJcbn0pO1xyXG5cclxuLy8gUGVybWV0IGQnaW1wb3J0ZXIgbGVzIGNvbnRhY3RzIHZlcnMgUGl4ZWxGb3JjZVxyXG4kKCcjY29udGFjdF9mb3JtJykub24oJ3N1Ym1pdCcsIGZ1bmN0aW9uKGUpe1xyXG4gICAgZS5wcmV2ZW50RGVmYXVsdCgpO1xyXG4gICAgJCgnI2J0bl9zdWJtaXRfZm9ybScpLmF0dHIoJ2Rpc2FibGVkJywgdHJ1ZSlcclxuXHJcbiAgICB2YXIgaW5kZXhDb25uZXhpb25zID0gW107XHJcbiAgICB2YXIgY29udGFjdHNDaGVja2VkID0gW107XHJcblxyXG5cclxuICAgICQoJ2Zvcm0jY29udGFjdF9mb3JtIGlucHV0W3R5cGU9XCJjaGVja2JveFwiXTpjaGVja2VkJykuZWFjaChmdW5jdGlvbiAoKSB7XHJcbiAgICAgICAgaW5kZXhDb25uZXhpb25zLnB1c2goJCh0aGlzKS52YWwoKSk7XHJcbiAgICB9KTtcclxuXHJcbiAgICBpbmRleENvbm5leGlvbnMuZm9yRWFjaChlbGVtZW50ID0+IHtcclxuICAgICAgICBjb250YWN0c0NoZWNrZWQucHVzaChjb250YWN0c1tlbGVtZW50XSk7XHJcbiAgICB9KTtcclxuXHJcbiAgICBsZXQgZGF0YXMgPSB7XHJcbiAgICAgICAgJ2NvbnRhY3RzJyA6IGNvbnRhY3RzQ2hlY2tlZCxcclxuICAgICAgICAnYWdlbnRJZCcgOiBhZ2VudElkXHJcbiAgICB9XHJcblxyXG4gICAgY29uc3QgdXJsUG9zdENvbnRhY3QgPSAnL2FnZW50L2NvbnRhY3QvbW9iaWxlL2ltcG9ydCc7XHJcbiAgICAkLmFqYXgoe1xyXG4gICAgICAgIHVybDogdXJsUG9zdENvbnRhY3QsXHJcbiAgICAgICAgdHlwZTogXCJQT1NUXCIsXHJcbiAgICAgICAgZGF0YTogZGF0YXMsXHJcbiAgICAgICAgYmVmb3JlU2VuZCA6IGZ1bmN0aW9uKCl7XHJcbiAgICAgICAgICAgICQoJyNzcGlubmVyX2xvYWRlcicpLmh0bWwoJzxkaXYgY2xhc3M9XCJzcGlubmVyLWJvcmRlciB0ZXh0LXNlY29uZGFyeVwiIHJvbGU9XCJzdGF0dXNcIj48c3BhbiBjbGFzcz1cInZpc3VhbGx5LWhpZGRlblwiPkxvYWRpbmcuLi48L3NwYW4+PC9kaXY+JylcclxuICAgICAgICB9LFxyXG4gICAgICAgIHN1Y2Nlc3M6IGZ1bmN0aW9uKHJlc3BvbnNlQWpheCl7XHJcbiAgICAgICAgICAgICQoJyNzcGlubmVyX2xvYWRlcicpLmh0bWwoJycpO1xyXG4gICAgICAgICAgICBpZiAocmVzcG9uc2VBamF4LmNvbnRhY3QgPT09ICdhZGRlZCcgKSB7XHJcbiAgICAgICAgICAgICAgICB3aW5kb3cubG9jYXRpb24uaHJlZiA9ICcvYWdlbnQvY29udGFjdC9saXN0ZT9jb250YWN0TW9iaWxlPWFkZGVkJztcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgIH0sXHJcbiAgICAgICAgZXJyb3IgOiBmdW5jdGlvbigpe1xyXG4gICAgICAgICAgICAkKCcjc3Bpbm5lcl9sb2FkZXInKS5odG1sKCdFcnJldXInKTtcclxuICAgICAgICB9XHJcbiAgICB9KVxyXG59KVxyXG5cclxuXHJcbi8vIFRPVVQgQ09DSEVSXHJcbiQoXCI6cmFkaW8jY29jaGVyXCIpLmNsaWNrKGZ1bmN0aW9uKCl7XHJcbiAgICAkKCc6Y2hlY2tib3guY2hlY2tDbGFzcycpLnByb3AoJ2NoZWNrZWQnLCB0cnVlKTtcclxuICAgICQoXCI6cmFkaW8jZGVjb2NoZXJcIikucHJvcCgnY2hlY2tlZCcsIGZhbHNlKTtcclxufSk7XHJcbi8vIFRPVVQgREUtQ09DSEVSXHJcbiQoXCI6cmFkaW8jZGVjb2NoZXJcIikuY2xpY2soZnVuY3Rpb24oKXtcclxuICAgICQoJzpjaGVja2JveC5jaGVja0NsYXNzJykucHJvcCgnY2hlY2tlZCcsIGZhbHNlKTtcclxuICAgICQoXCI6cmFkaW8jY29jaGVyXCIpLnByb3AoJ2NoZWNrZWQnLCBmYWxzZSk7XHJcbn0pO1xyXG4iXSwibmFtZXMiOlsiQ0xJRU5UX0lEIiwiJCIsInRleHQiLCJBUElfS0VZIiwiRElTQ09WRVJZX0RPQyIsIlNDT1BFUyIsInRva2VuQ2xpZW50IiwiZ2FwaUluaXRlZCIsImdpc0luaXRlZCIsImNvbnRhY3RzIiwiYWdlbnRJZCIsImNzcyIsImdhcGlMb2FkZWQiLCJnaXNMb2FkZWQiLCJnYXBpIiwibG9hZCIsImludGlhbGl6ZUdhcGlDbGllbnQiLCJjbGllbnQiLCJpbml0IiwiYXBpS2V5IiwiZGlzY292ZXJ5RG9jcyIsIm1heWJlRW5hYmxlQnV0dG9ucyIsImdvb2dsZSIsImFjY291bnRzIiwib2F1dGgyIiwiaW5pdFRva2VuQ2xpZW50IiwiY2xpZW50X2lkIiwic2NvcGUiLCJjYWxsYmFjayIsInJlbW92ZUNsYXNzIiwiaGFuZGxlQXV0aENsaWNrIiwicmVzcCIsImVycm9yIiwidW5kZWZpbmVkIiwibGlzdENvbm5lY3Rpb25OYW1lcyIsImdldFRva2VuIiwicmVxdWVzdEFjY2Vzc1Rva2VuIiwicHJvbXB0IiwiaGFuZGxlU2lnbm91dENsaWNrIiwidG9rZW4iLCJyZXZva2UiLCJhY2Nlc3NfdG9rZW4iLCJzZXRUb2tlbiIsInBlb3BsZSIsImNvbm5lY3Rpb25zIiwibGlzdCIsInJlc3BvbnNlIiwibWVzc2FnZSIsInJlc3VsdCIsImxlbmd0aCIsImluZGV4IiwibmFtZXMiLCJhcHBlbmQiLCJkaXNwbGF5TmFtZSIsImFkZENsYXNzIiwiZXhwb3J0VG9Dc3YiLCJyb3dzIiwiQ3N2U3RyaW5nIiwiZm9yRWFjaCIsIlJvd0l0ZW0iLCJSb3dJbmRleCIsIkNvbEl0ZW0iLCJDb2xJbmRleCIsImVuY29kZVVSSSIsIngiLCJkb2N1bWVudCIsImNyZWF0ZUVsZW1lbnQiLCJzZXRBdHRyaWJ1dGUiLCJib2R5IiwiYXBwZW5kQ2hpbGQiLCJjbGljayIsIm9uIiwiZSIsInRoYXQiLCJhdHRyIiwiaW5kZXhDb25uZXhpb25zIiwiY29udGFjdHNDaGVja2VkIiwiZWFjaCIsInB1c2giLCJ2YWwiLCJlbGVtZW50IiwiZGF0YXMiLCJ1cmxFeHBvcnRNb2JpbGUiLCJhamF4IiwidXJsIiwidHlwZSIsImRhdGEiLCJiZWZvcmVTZW5kIiwiaHRtbCIsInN1Y2Nlc3MiLCJyZXNwb25zZUFqYXgiLCJwcmV2ZW50RGVmYXVsdCIsInVybFBvc3RDb250YWN0IiwiY29udGFjdCIsIndpbmRvdyIsImxvY2F0aW9uIiwiaHJlZiIsInByb3AiXSwic291cmNlUm9vdCI6IiJ9