"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["formationForm"],{

/***/ "./assets/js/formationForm.js":
/*!************************************!*\
  !*** ./assets/js/formationForm.js ***!
  \************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var regenerator_runtime_runtime_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! regenerator-runtime/runtime.js */ "./node_modules/regenerator-runtime/runtime.js");
/* harmony import */ var regenerator_runtime_runtime_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(regenerator_runtime_runtime_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var core_js_modules_web_timers_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! core-js/modules/web.timers.js */ "./node_modules/core-js/modules/web.timers.js");
/* harmony import */ var core_js_modules_web_timers_js__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_web_timers_js__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var core_js_modules_es_array_join_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! core-js/modules/es.array.join.js */ "./node_modules/core-js/modules/es.array.join.js");
/* harmony import */ var core_js_modules_es_array_join_js__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_array_join_js__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var core_js_modules_es_array_includes_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! core-js/modules/es.array.includes.js */ "./node_modules/core-js/modules/es.array.includes.js");
/* harmony import */ var core_js_modules_es_array_includes_js__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_array_includes_js__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var core_js_modules_es_string_includes_js__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! core-js/modules/es.string.includes.js */ "./node_modules/core-js/modules/es.string.includes.js");
/* harmony import */ var core_js_modules_es_string_includes_js__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_string_includes_js__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var core_js_modules_es_function_name_js__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! core-js/modules/es.function.name.js */ "./node_modules/core-js/modules/es.function.name.js");
/* harmony import */ var core_js_modules_es_function_name_js__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_function_name_js__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var core_js_modules_es_date_to_string_js__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! core-js/modules/es.date.to-string.js */ "./node_modules/core-js/modules/es.date.to-string.js");
/* harmony import */ var core_js_modules_es_date_to_string_js__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_date_to_string_js__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var core_js_modules_es_object_to_string_js__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! core-js/modules/es.object.to-string.js */ "./node_modules/core-js/modules/es.object.to-string.js");
/* harmony import */ var core_js_modules_es_object_to_string_js__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_object_to_string_js__WEBPACK_IMPORTED_MODULE_7__);
/* harmony import */ var core_js_modules_es_promise_js__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! core-js/modules/es.promise.js */ "./node_modules/core-js/modules/es.promise.js");
/* harmony import */ var core_js_modules_es_promise_js__WEBPACK_IMPORTED_MODULE_8___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_promise_js__WEBPACK_IMPORTED_MODULE_8__);
/* harmony import */ var core_js_modules_es_array_find_js__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! core-js/modules/es.array.find.js */ "./node_modules/core-js/modules/es.array.find.js");
/* harmony import */ var core_js_modules_es_array_find_js__WEBPACK_IMPORTED_MODULE_9___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_array_find_js__WEBPACK_IMPORTED_MODULE_9__);
/* harmony import */ var core_js_modules_es_array_for_each_js__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! core-js/modules/es.array.for-each.js */ "./node_modules/core-js/modules/es.array.for-each.js");
/* harmony import */ var core_js_modules_es_array_for_each_js__WEBPACK_IMPORTED_MODULE_10___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_array_for_each_js__WEBPACK_IMPORTED_MODULE_10__);
/* harmony import */ var core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! core-js/modules/web.dom-collections.for-each.js */ "./node_modules/core-js/modules/web.dom-collections.for-each.js");
/* harmony import */ var core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_11___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_web_dom_collections_for_each_js__WEBPACK_IMPORTED_MODULE_11__);
/* harmony import */ var core_js_modules_es_array_concat_js__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! core-js/modules/es.array.concat.js */ "./node_modules/core-js/modules/es.array.concat.js");
/* harmony import */ var core_js_modules_es_array_concat_js__WEBPACK_IMPORTED_MODULE_12___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_array_concat_js__WEBPACK_IMPORTED_MODULE_12__);
/* harmony import */ var _helpers_FileType__WEBPACK_IMPORTED_MODULE_13__ = __webpack_require__(/*! ./helpers/FileType */ "./assets/js/helpers/FileType.js");
/* harmony import */ var _ImportVideoVimeo__WEBPACK_IMPORTED_MODULE_14__ = __webpack_require__(/*! ./ImportVideoVimeo */ "./assets/js/ImportVideoVimeo.js");
/* harmony import */ var _images_3_Leg_Preloader_svg__WEBPACK_IMPORTED_MODULE_15__ = __webpack_require__(/*! ../images/3-Leg-Preloader.svg */ "./assets/images/3-Leg-Preloader.svg");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_16__ = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_16___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_16__);
/* provided dependency */ var $ = __webpack_require__(/*! jquery */ "./node_modules/jquery/dist/jquery.js");














function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }






__webpack_require__(/*! jquery-validation */ "./node_modules/jquery-validation/dist/jquery.validate.js");

$(document).ready(function () {
  // enregistrement des données du formulaire
  // etape 1 : upload video vers serveur vimeo
  // etap 2 : submit formulaire (symfony : upload + flush Data)
  $(this).on('click', '#submit-formation', /*#__PURE__*/function () {
    var _ref = _asyncToGenerator( /*#__PURE__*/regeneratorRuntime.mark(function _callee2(e) {
      return regeneratorRuntime.wrap(function _callee2$(_context2) {
        while (1) {
          switch (_context2.prev = _context2.next) {
            case 0:
              e.preventDefault();
              validationFormulaire(function () {
                progressionBar(0);
                (0,_ImportVideoVimeo__WEBPACK_IMPORTED_MODULE_14__.sendVideoToVimeo)({
                  selector: $('#inputVideo'),
                  titre: $('#video-upload-name').text(),
                  description: '',
                  error: function error(data) {
                    alert('erreur lors du téléchargement video ' + data);
                  },
                  progress: function progress(pourcentage) {
                    progressionBar(pourcentage);
                  },
                  complete: function () {
                    var _complete = _asyncToGenerator( /*#__PURE__*/regeneratorRuntime.mark(function _callee(videoId, url, prettyData) {
                      return regeneratorRuntime.wrap(function _callee$(_context) {
                        while (1) {
                          switch (_context.prev = _context.next) {
                            case 0:
                              _context.next = 2;
                              return saveData(videoId);

                            case 2:
                              progressionContainer.remove();
                              progressionLabel.html('<div class="text-center">' + '   <h1 class="text-success"><i class="fa fa-circle-check"></i></h1>     ' + '   <strong>Formation ajouté avec succès</strong> ' + '</div>');
                              setTimeout(function () {
                                progressionLabel.html('<strong>Rafraichissement de la page ...</strong>');
                                setTimeout(function () {
                                  location.href = Routing.generate('coach_formation_list');
                                }, 1000);
                              }, 1000);

                            case 5:
                            case "end":
                              return _context.stop();
                          }
                        }
                      }, _callee);
                    }));

                    function complete(_x2, _x3, _x4) {
                      return _complete.apply(this, arguments);
                    }

                    return complete;
                  }()
                });
              });

            case 2:
            case "end":
              return _context2.stop();
          }
        }
      }, _callee2);
    }));

    return function (_x) {
      return _ref.apply(this, arguments);
    };
  }()); // boutton ajout video (creation input-file + click automatique sur celui-ci)

  var addVideo = false;
  $(this).on('click', '#btn-add-video', function (e) {
    e.preventDefault();
    var inputFile = $('<input />', {
      type: 'file',
      "class": 'd-none',
      accept: _helpers_FileType__WEBPACK_IMPORTED_MODULE_13__.mimesVideo.join(','),
      id: 'inputVideo'
    });
    $(this).closest('#formation-video').append(inputFile);
    inputFile.trigger('click');
    addVideo = true;
  }); // video local preview

  $(this).on('change', '#inputVideo', function (e) {
    e.preventDefault();
    var video_upload_preview = $('#video-upload-preview')[0];
    var video_upload_name = $('#video-upload-name')[0];
    var loading_video_container = $('#loading-video-container')[0];
    var loading_video = $('#loading-video')[0];
    var videoSource = $('<source />');
    var videoLocalFile = this.files[0];
    $(video_upload_name).removeClass('d-none');

    if (_helpers_FileType__WEBPACK_IMPORTED_MODULE_13__.mimesVideo.includes(videoLocalFile.type)) {
      $(video_upload_name).append(videoLocalFile.name);
      $(loading_video_container).removeClass('d-none');
      $('#btn-add-video').addClass('d-none');
      var reader = new FileReader();

      reader.onload = function (e) {
        videoSource.attr('src', e.target.result);
        video_upload_preview.appendChild(videoSource[0]);
        video_upload_preview.load();
        video_upload_preview.play();
      };

      reader.onprogress = function (e) {
        $(loading_video).html(Math.round(e.loaded * 100 / e.total));
      };

      reader.onloadend = function (e) {
        $(loading_video_container).addClass('d-none');
        $(video_upload_preview).removeClass('d-none');
      };

      reader.readAsDataURL(videoLocalFile);
    } else {
      $('#btn-add-video').removeClass('d-none');
      $(video_upload_name).html('Le fichier charger n\'est pas une video');
    }
  }); // boutton ajout document (creation de plusieur input-file au fur et à mesure du click + click automatique sur chaque input file)

  $(this).on('click', '#btn-add-document', function (e) {
    e.preventDefault();
    var inputFile = $('<input />', {
      type: 'file',
      "class": 'd-none input-file-document',
      accept: _helpers_FileType__WEBPACK_IMPORTED_MODULE_13__.mimesDocument.join(',')
    });
    $(this).closest('#formation-document').append(inputFile);
    inputFile.trigger('click');
  }); // affichage du nom de chaque fichier importer

  $(this).on('change', '#formation-document .input-file-document', function (e) {
    e.preventDefault();
    var documentLocalFile = this.files[0];

    if (_helpers_FileType__WEBPACK_IMPORTED_MODULE_13__.mimesDocument.includes(documentLocalFile.type)) {
      $('#document-upload-name').append('<span class="badge bg-light-info text-dark"><i class="fa-solid fa-book me-2"></i> ' + documentLocalFile.name + '</span>').append('<br>');
    }
  }); // boutton ajout audio (creation de plusieur input-file au fur et à mesure du click + click automatique sur chaque input file)

  $(this).on('click', '#btn-add-audio', function (e) {
    e.preventDefault();
    var inputFile = $('<input />', {
      type: 'file',
      "class": 'd-none input-file-audio',
      accept: _helpers_FileType__WEBPACK_IMPORTED_MODULE_13__.mimesAudio.join(',')
    });
    $(this).closest('#formation-audio').append(inputFile);
    inputFile.trigger('click');
  }); // affichage du nom de chaque fichier importer

  $(this).on('change', '#formation-audio .input-file-audio', function (e) {
    e.preventDefault();
    var audioLocalFile = this.files[0];

    if (_helpers_FileType__WEBPACK_IMPORTED_MODULE_13__.mimesAudio.includes(audioLocalFile.type)) {
      $('#audio-upload-name').append('<span class="badge bg-light-info text-dark"><i class="fa-solid fa-music me-2"></i> ' + audioLocalFile.name + '</span>').append('<br>');
    }
  }); /////// DEBUT FICHE FORMATION ///////

  /**
   * Début fiche formation
   */
  // supprimer un média

  $(this).on('click', '.btn-media-delete', function (e) {
    e.preventDefault();
    var mediaDelete = $('<input />', {
      type: 'hidden',
      "class": 'hidden_media_deleted',
      name: 'deleted_media[]',
      value: $(this).attr('data-media-id')
    });
    $('#formation-fiche').append(mediaDelete);
    $(this).closest('.media').first().remove();
  }); // enregistrement des données du formulaire
  // etape 1 : upload video vers serveur vimeo
  // etap 2 : submit formulaire (symfony : upload + flush Data)

  $(this).on('click', '#edit-formation', /*#__PURE__*/function () {
    var _ref2 = _asyncToGenerator( /*#__PURE__*/regeneratorRuntime.mark(function _callee5(e) {
      return regeneratorRuntime.wrap(function _callee5$(_context5) {
        while (1) {
          switch (_context5.prev = _context5.next) {
            case 0:
              e.preventDefault();
              validationFormulaire( /*#__PURE__*/_asyncToGenerator( /*#__PURE__*/regeneratorRuntime.mark(function _callee4() {
                var fileDeleted;
                return regeneratorRuntime.wrap(function _callee4$(_context4) {
                  while (1) {
                    switch (_context4.prev = _context4.next) {
                      case 0:
                        progressionBar(0);
                        fileDeleted = new FormData();
                        $('.hidden_media_deleted').each(function () {
                          fileDeleted.append('deleted_media[]', $(this).val());
                        });
                        _context4.next = 5;
                        return axios__WEBPACK_IMPORTED_MODULE_16___default().post(Routing.generate('coach_formation_delete_media'), fileDeleted);

                      case 5:
                        if (!addVideo) {
                          _context4.next = 10;
                          break;
                        }

                        $('.hiddenVideoData').remove();
                        (0,_ImportVideoVimeo__WEBPACK_IMPORTED_MODULE_14__.sendVideoToVimeo)({
                          selector: $('#inputVideo'),
                          titre: $('#video-upload-name').text(),
                          description: '',
                          error: function error(data) {
                            alert('erreur lors du téléchargement video ' + data);
                          },
                          progress: function progress(pourcentage) {
                            progressionBar(pourcentage);
                          },
                          complete: function () {
                            var _complete2 = _asyncToGenerator( /*#__PURE__*/regeneratorRuntime.mark(function _callee3(videoId, url, prettyData) {
                              return regeneratorRuntime.wrap(function _callee3$(_context3) {
                                while (1) {
                                  switch (_context3.prev = _context3.next) {
                                    case 0:
                                      _context3.next = 2;
                                      return saveData(videoId);

                                    case 2:
                                      progressionContainer.remove();
                                      progressionLabel.html('<div class="text-center">' + '   <h1 class="text-success"><i class="fa fa-circle-check"></i></h1>     ' + '   <strong>Formation modifié avec succès</strong> ' + '</div>');
                                      setTimeout(function () {
                                        progressionLabel.html('<strong>Rafraichissement de la page ...</strong>');
                                        setTimeout(function () {
                                          location.reload();
                                        }, 1000);
                                      }, 1000);

                                    case 5:
                                    case "end":
                                      return _context3.stop();
                                  }
                                }
                              }, _callee3);
                            }));

                            function complete(_x6, _x7, _x8) {
                              return _complete2.apply(this, arguments);
                            }

                            return complete;
                          }()
                        });
                        _context4.next = 15;
                        break;

                      case 10:
                        _context4.next = 12;
                        return saveData();

                      case 12:
                        progressionContainer.remove();
                        progressionLabel.html('<div class="text-center">' + '   <h1 class="text-success"><i class="fa fa-circle-check"></i></h1>     ' + '   <strong>Formation modifié avec succès</strong> ' + '</div>');
                        setTimeout(function () {
                          progressionLabel.html('<strong>Rafraichissement de la page ...</strong>');
                          setTimeout(function () {
                            location.reload();
                          }, 1000);
                        }, 1000);

                      case 15:
                      case "end":
                        return _context4.stop();
                    }
                  }
                }, _callee4);
              })));

            case 2:
            case "end":
              return _context5.stop();
          }
        }
      }, _callee5);
    }));

    return function (_x5) {
      return _ref2.apply(this, arguments);
    };
  }());
});

function saveData() {
  return _saveData.apply(this, arguments);
}

function _saveData() {
  _saveData = _asyncToGenerator( /*#__PURE__*/regeneratorRuntime.mark(function _callee6() {
    var videoId,
        documentsData,
        audiosData,
        fileDocuments,
        fileAudios,
        formData,
        img_loader,
        responseDocuments,
        responseAudios,
        mediasData,
        _args6 = arguments;
    return regeneratorRuntime.wrap(function _callee6$(_context6) {
      while (1) {
        switch (_context6.prev = _context6.next) {
          case 0:
            videoId = _args6.length > 0 && _args6[0] !== undefined ? _args6[0] : '';
            documentsData = [];
            audiosData = []; // préparation du formulaire, fichiers Documents et Audios

            fileDocuments = new FormData();
            fileAudios = new FormData();
            formData = new FormData($('form[name="formation"]')[0]);
            $('#formation-document').find('input[type="file"]').each(function () {
              fileDocuments.append('documents[]', this.files[0]);
              var document = {
                name: this.files[0].name,
                mimeType: this.files[0].type,
                type: 'document'
              };
              documentsData.push(document);
            });
            $('#formation-audio').find('input[type="file"]').each(function () {
              fileAudios.append('audios[]', this.files[0]);
              var audio = {
                name: this.files[0].name,
                mimeType: this.files[0].type,
                type: 'audio'
              };
              audiosData.push(audio);
            });
            img_loader = $('<img src="' + _images_3_Leg_Preloader_svg__WEBPACK_IMPORTED_MODULE_15__ + '" />');
            progressionContainer.replaceWith(img_loader);
            progressionContainer = $(img_loader);
            progressionLabel.html('<strong>Téléchargement des documents en cours ...</strong>'); // envoie des fichiers Documents

            _context6.next = 14;
            return axios__WEBPACK_IMPORTED_MODULE_16___default().post(Routing.generate('coach_formation_uploadDocument'), fileDocuments, {
              headers: {
                'Content-Type': 'multipart/form-data'
              }
            });

          case 14:
            responseDocuments = _context6.sent.data;

            if (!responseDocuments.error) {
              responseDocuments.files.forEach(function (e, i) {
                documentsData[i].slug = e;
              });
            }

            progressionLabel.html('<strong>Téléchargement des audios en cours ...</strong>'); // envoie des fichiers audios

            _context6.next = 19;
            return axios__WEBPACK_IMPORTED_MODULE_16___default().post(Routing.generate('coach_formation_uploadAudio'), fileAudios, {
              headers: {
                'Content-Type': 'multipart/form-data'
              }
            });

          case 19:
            responseAudios = _context6.sent.data;

            if (!responseAudios.error) {
              responseAudios.files.forEach(function (e, i) {
                audiosData[i].slug = e;
              });
            }

            progressionLabel.html('<strong>Finalisation ...</strong>'); // récuperation de tout les médias importé, qu'importe que ce soit un document ou un fichier audio

            mediasData = documentsData.concat(audiosData); // console.log(mediasData);

            formData.append('mediasData', JSON.stringify(mediasData));
            formData.append('video_id', videoId);
            _context6.next = 27;
            return axios__WEBPACK_IMPORTED_MODULE_16___default().post($('#formation, #formation-fiche').attr('action'), formData);

          case 27:
            _context6.sent.data;

          case 28:
          case "end":
            return _context6.stop();
        }
      }
    }, _callee6);
  }));
  return _saveData.apply(this, arguments);
}

var calc,
    progressionContainer,
    calcChild,
    progression,
    progressionLabel = null;

function progressionBar(pourcentage) {
  if (calc == null) {
    calc = $('<div />', {
      "class": 'w-100 h-100 position-absolute top-0 start-0 d-flex',
      style: 'background: rgba(255,255,255,0.7)'
    });
    calcChild = $('<div />', {
      "class": 'm-auto w-100 text-center'
    });
    progressionContainer = $('<div />', {
      "class": 'progress w-50 mx-auto mb-2 shadow-sm'
    });
    progression = $('<div />', {
      "class": 'progress-bar progress-bar-striped bg-primary',
      role: 'progressbar'
    });
    progressionLabel = $('<div />', {
      "class": 'text-center'
    }).html('<strong>Téléchargement de la video en cours ...</strong>');
    progression.html(pourcentage);
    progressionContainer.html(progression);
    calcChild.html(progressionContainer);
    calcChild.append(progressionLabel);
    calc.html(calcChild);
    $('#form-formation').append(calc);
  } else {
    progression.html(pourcentage + '%');
    progression.css({
      width: pourcentage + '%'
    });
    progression.attr('aria-valuenow', pourcentage);
  }
}

function validationFormulaire(callback) {
  $('#formation, #formation-fiche').validate({
    // in 'rules' user have to specify all the constraints for respective fields
    rules: {
      'formation[titre]': "required",
      'formation[description]': "required",
      'formation[categorieFormation]': "required",
      'formation[contenu]': "required"
    },
    // in 'messages' user have to specify message as per rules
    messages: {
      'formation[titre]': "<i class='fa fa-warning'></i> Veuillez entrer une titre",
      'formation[description]': "<i class='fa fa-warning'></i> La description est obligatoire",
      'formation[categorieFormation]': "<i class='fa fa-warning'></i> La catégorie est obligatoire",
      'formation[contenu]': '<i class=\'fa fa-warning\'></i> Veuillez entrer le contenu de la formation'
    },
    submitHandler: function submitHandler() {
      if ($('#inputVideo').length === 0) {
        var _alert = '<div class="alert alert-danger my-2" role="alert">\n' + '  La vidéo est obligatoire\n' + '</div>';

        $('#formation').prepend(_alert);
      } else {
        callback();
      }
    }
  });
  $('#formation, #formation-fiche').submit();
}

(function (i, s, o, g, r, a, m) {
  i['GoogleAnalyticsObject'] = r;
  i[r] = i[r] || function () {
    (i[r].q = i[r].q || []).push(arguments);
  }, i[r].l = 1 * new Date();
  a = s.createElement(o), m = s.getElementsByTagName(o)[0];
  a.async = 1;
  a.src = g;
  m.parentNode.insertBefore(a, m);
})(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

ga('create', 'UA-57984417-1', 'auto');
ga('send', 'pageview');

/***/ }),

/***/ "./assets/js/helpers/FileType.js":
/*!***************************************!*\
  !*** ./assets/js/helpers/FileType.js ***!
  \***************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "mimesAudio": () => (/* binding */ mimesAudio),
/* harmony export */   "mimesDocument": () => (/* binding */ mimesDocument),
/* harmony export */   "mimesVideo": () => (/* binding */ mimesVideo)
/* harmony export */ });
var mimesVideo = ['video/x-flv', 'video/mp4', 'video/avi', 'application/x-mpegURL', 'video/MP2T', 'video/3gpp', 'video/quicktime', 'video/x-msvideo', 'video/x-ms-wmv'];
var mimesDocument = ['application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/pdf', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation'];
var mimesAudio = ['audio/basic', 'audio/basic', 'auido/L24', 'audio/mid', 'audio/mid', 'audio/mpeg', 'audio/mp4', 'audio/x-aiff', 'audio/x-aiff', 'audio/x-aiff', 'audio/x-mpegurl', 'audio/vnd.rn-realaudio', 'audio/vnd.rn-realaudio', 'audio/ogg', 'audio/vorbis', 'audio/vnd.wav'];

/***/ }),

/***/ "./assets/images/3-Leg-Preloader.svg":
/*!*******************************************!*\
  !*** ./assets/images/3-Leg-Preloader.svg ***!
  \*******************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

module.exports = __webpack_require__.p + "images/3-Leg-Preloader.78ef2f3b.svg";

/***/ })

},
/******/ __webpack_require__ => { // webpackRuntimeModules
/******/ var __webpack_exec__ = (moduleId) => (__webpack_require__(__webpack_require__.s = moduleId))
/******/ __webpack_require__.O(0, ["vendors-node_modules_jquery_dist_jquery_js","vendors-node_modules_core-js_internals_classof_js-node_modules_core-js_internals_export_js","vendors-node_modules_core-js_internals_add-to-unscopables_js-node_modules_core-js_internals_a-464164","vendors-node_modules_core-js_internals_advance-string-index_js-node_modules_core-js_internals-7d93ee","vendors-node_modules_core-js_internals_dom-iterables_js-node_modules_core-js_internals_dom-to-831329","vendors-node_modules_core-js_modules_es_string_iterator_js-node_modules_core-js_modules_web_d-930e15","vendors-node_modules_core-js_modules_es_promise_js","vendors-node_modules_core-js_internals_array-method-is-strict_js-node_modules_core-js_interna-fb67f6","vendors-node_modules_regenerator-runtime_runtime_js","vendors-node_modules_axios_index_js-node_modules_core-js_modules_es_array_find_js","vendors-node_modules_core-js_modules_es_array_join_js-node_modules_core-js_modules_es_array_m-08e58c","vendors-node_modules_core-js_modules_es_array_concat_js-node_modules_core-js_modules_es_array-389bcd","assets_js_ImportVideoVimeo_js"], () => (__webpack_exec__("./assets/js/formationForm.js")));
/******/ var __webpack_exports__ = __webpack_require__.O();
/******/ }
]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,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QUFDQUcsRUFBQUEsQ0FBQyxDQUFDUyxVQUFGLENBQWFDLFlBQWIsQ0FBMEJYLENBQTFCLEVBQTZCQyxDQUE3QjtBQUNILENBVkQsRUFVR1csTUFWSCxFQVVXakksUUFWWCxFQVVxQixRQVZyQixFQVUrQix5Q0FWL0IsRUFVMEUsSUFWMUU7O0FBV0FrSSxFQUFFLENBQUMsUUFBRCxFQUFXLGVBQVgsRUFBNEIsTUFBNUIsQ0FBRjtBQUNBQSxFQUFFLENBQUMsTUFBRCxFQUFTLFVBQVQsQ0FBRjs7Ozs7Ozs7Ozs7Ozs7OztBQzdXTyxJQUFNMUksVUFBVSxHQUFHLENBQ3RCLGFBRHNCLEVBRXRCLFdBRnNCLEVBR3RCLFdBSHNCLEVBSXRCLHVCQUpzQixFQUt0QixZQUxzQixFQU10QixZQU5zQixFQU90QixpQkFQc0IsRUFRdEIsaUJBUnNCLEVBU3RCLGdCQVRzQixDQUFuQjtBQVlBLElBQU1DLGFBQWEsR0FBRyxDQUN6QixvQkFEeUIsRUFFekIseUVBRnlCLEVBR3pCLGlCQUh5QixFQUl6QiwrQkFKeUIsRUFLekIsMkVBTHlCLENBQXRCO0FBUUEsSUFBTUMsVUFBVSxHQUFHLENBQ3RCLGFBRHNCLEVBRXRCLGFBRnNCLEVBR3RCLFdBSHNCLEVBSXRCLFdBSnNCLEVBS3RCLFdBTHNCLEVBTXRCLFlBTnNCLEVBT3RCLFdBUHNCLEVBUXRCLGNBUnNCLEVBU3RCLGNBVHNCLEVBVXRCLGNBVnNCLEVBV3RCLGlCQVhzQixFQVl0Qix3QkFac0IsRUFhdEIsd0JBYnNCLEVBY3RCLFdBZHNCLEVBZXRCLGNBZnNCLEVBZ0J0QixlQWhCc0IsQ0FBbkIiLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvanMvZm9ybWF0aW9uRm9ybS5qcyIsIndlYnBhY2s6Ly8vLi9hc3NldHMvanMvaGVscGVycy9GaWxlVHlwZS5qcyJdLCJzb3VyY2VzQ29udGVudCI6WyJpbXBvcnQge21pbWVzVmlkZW8sIG1pbWVzRG9jdW1lbnQsIG1pbWVzQXVkaW99IGZyb20gJy4vaGVscGVycy9GaWxlVHlwZSdcclxuaW1wb3J0IHtzZW5kVmlkZW9Ub1ZpbWVvfSBmcm9tICcuL0ltcG9ydFZpZGVvVmltZW8nXHJcbmltcG9ydCBjaXJjbGVJbWFnZTMgZnJvbSAnLi4vaW1hZ2VzLzMtTGVnLVByZWxvYWRlci5zdmcnXHJcbmltcG9ydCBheGlvcyBmcm9tICdheGlvcyc7XHJcbnJlcXVpcmUoJ2pxdWVyeS12YWxpZGF0aW9uJylcclxuJChkb2N1bWVudCkucmVhZHkoZnVuY3Rpb24gKCkge1xyXG5cclxuICAgIC8vIGVucmVnaXN0cmVtZW50IGRlcyBkb25uw6llcyBkdSBmb3JtdWxhaXJlXHJcbiAgICAvLyBldGFwZSAxIDogdXBsb2FkIHZpZGVvIHZlcnMgc2VydmV1ciB2aW1lb1xyXG4gICAgLy8gZXRhcCAyIDogc3VibWl0IGZvcm11bGFpcmUgKHN5bWZvbnkgOiB1cGxvYWQgKyBmbHVzaCBEYXRhKVxyXG4gICAgJCh0aGlzKS5vbignY2xpY2snLCcjc3VibWl0LWZvcm1hdGlvbicsYXN5bmMgZnVuY3Rpb24oZSkge1xyXG4gICAgICAgIGUucHJldmVudERlZmF1bHQoKTtcclxuICAgICAgICB2YWxpZGF0aW9uRm9ybXVsYWlyZShmdW5jdGlvbigpIHtcclxuICAgICAgICAgICAgcHJvZ3Jlc3Npb25CYXIoMCk7XHJcbiAgICAgICAgICAgIHNlbmRWaWRlb1RvVmltZW8oe1xyXG4gICAgICAgICAgICAgICAgc2VsZWN0b3I6JCgnI2lucHV0VmlkZW8nKSxcclxuICAgICAgICAgICAgICAgIHRpdHJlOiQoJyN2aWRlby11cGxvYWQtbmFtZScpLnRleHQoKSxcclxuICAgICAgICAgICAgICAgIGRlc2NyaXB0aW9uOicnLFxyXG4gICAgICAgICAgICAgICAgZXJyb3I6IGZ1bmN0aW9uKGRhdGEpIHtcclxuICAgICAgICAgICAgICAgICAgICBhbGVydCgnZXJyZXVyIGxvcnMgZHUgdMOpbMOpY2hhcmdlbWVudCB2aWRlbyAnK2RhdGEpXHJcbiAgICAgICAgICAgICAgICB9LFxyXG4gICAgICAgICAgICAgICAgcHJvZ3Jlc3M6IGZ1bmN0aW9uKHBvdXJjZW50YWdlKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgcHJvZ3Jlc3Npb25CYXIocG91cmNlbnRhZ2UpO1xyXG4gICAgICAgICAgICAgICAgfSxcclxuICAgICAgICAgICAgICAgIGNvbXBsZXRlOiBhc3luYyBmdW5jdGlvbih2aWRlb0lkLCB1cmwsIHByZXR0eURhdGEpIHtcclxuICAgICAgICAgICAgICAgICAgICBhd2FpdCBzYXZlRGF0YSh2aWRlb0lkKTtcclxuICAgICAgICAgICAgICAgICAgICBwcm9ncmVzc2lvbkNvbnRhaW5lci5yZW1vdmUoKVxyXG4gICAgICAgICAgICAgICAgICAgIHByb2dyZXNzaW9uTGFiZWwuaHRtbChcclxuICAgICAgICAgICAgICAgICAgICAgICAgJzxkaXYgY2xhc3M9XCJ0ZXh0LWNlbnRlclwiPicgK1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAnICAgPGgxIGNsYXNzPVwidGV4dC1zdWNjZXNzXCI+PGkgY2xhc3M9XCJmYSBmYS1jaXJjbGUtY2hlY2tcIj48L2k+PC9oMT4gICAgICcgK1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAnICAgPHN0cm9uZz5Gb3JtYXRpb24gYWpvdXTDqSBhdmVjIHN1Y2PDqHM8L3N0cm9uZz4gJyArXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICc8L2Rpdj4nKTtcclxuICAgICAgICAgICAgICAgICAgICBzZXRUaW1lb3V0KGZ1bmN0aW9uKCkge1xyXG4gICAgICAgICAgICAgICAgICAgICAgICBwcm9ncmVzc2lvbkxhYmVsLmh0bWwoJzxzdHJvbmc+UmFmcmFpY2hpc3NlbWVudCBkZSBsYSBwYWdlIC4uLjwvc3Ryb25nPicpXHJcbiAgICAgICAgICAgICAgICAgICAgICAgIHNldFRpbWVvdXQoZnVuY3Rpb24oKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICBsb2NhdGlvbi5ocmVmID0gUm91dGluZy5nZW5lcmF0ZSgnY29hY2hfZm9ybWF0aW9uX2xpc3QnKVxyXG4gICAgICAgICAgICAgICAgICAgICAgICB9LDEwMDApXHJcbiAgICAgICAgICAgICAgICAgICAgfSwxMDAwKVxyXG5cclxuICAgICAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgfSlcclxuICAgICAgICB9KTtcclxuICAgIH0pO1xyXG5cclxuICAgIC8vIGJvdXR0b24gYWpvdXQgdmlkZW8gKGNyZWF0aW9uIGlucHV0LWZpbGUgKyBjbGljayBhdXRvbWF0aXF1ZSBzdXIgY2VsdWktY2kpXHJcbiAgICBsZXQgYWRkVmlkZW8gPSBmYWxzZTtcclxuICAgICQodGhpcykub24oJ2NsaWNrJywnI2J0bi1hZGQtdmlkZW8nLCBmdW5jdGlvbihlKSB7XHJcbiAgICAgICAgZS5wcmV2ZW50RGVmYXVsdCgpO1xyXG4gICAgICAgIGNvbnN0IGlucHV0RmlsZSA9ICQoJzxpbnB1dCAvPicsIHtcclxuICAgICAgICAgICAgdHlwZTogJ2ZpbGUnLFxyXG4gICAgICAgICAgICBjbGFzczonZC1ub25lJyxcclxuICAgICAgICAgICAgYWNjZXB0Om1pbWVzVmlkZW8uam9pbignLCcpLFxyXG4gICAgICAgICAgICBpZDogJ2lucHV0VmlkZW8nXHJcbiAgICAgICAgfSk7XHJcbiAgICAgICAgJCh0aGlzKS5jbG9zZXN0KCcjZm9ybWF0aW9uLXZpZGVvJykuYXBwZW5kKGlucHV0RmlsZSk7XHJcbiAgICAgICAgaW5wdXRGaWxlLnRyaWdnZXIoJ2NsaWNrJyk7XHJcbiAgICAgICAgYWRkVmlkZW8gPSB0cnVlO1xyXG4gICAgfSk7XHJcblxyXG4gICAgLy8gdmlkZW8gbG9jYWwgcHJldmlld1xyXG4gICAgJCh0aGlzKS5vbignY2hhbmdlJywgJyNpbnB1dFZpZGVvJywgZnVuY3Rpb24oZSkge1xyXG4gICAgICAgIGUucHJldmVudERlZmF1bHQoKTtcclxuICAgICAgICBsZXQgdmlkZW9fdXBsb2FkX3ByZXZpZXcgPSAkKCcjdmlkZW8tdXBsb2FkLXByZXZpZXcnKVswXTtcclxuICAgICAgICBsZXQgdmlkZW9fdXBsb2FkX25hbWUgPSAkKCcjdmlkZW8tdXBsb2FkLW5hbWUnKVswXTtcclxuICAgICAgICBsZXQgbG9hZGluZ192aWRlb19jb250YWluZXIgPSAkKCcjbG9hZGluZy12aWRlby1jb250YWluZXInKVswXTtcclxuICAgICAgICBsZXQgbG9hZGluZ192aWRlbyA9ICQoJyNsb2FkaW5nLXZpZGVvJylbMF07XHJcbiAgICAgICAgbGV0IHZpZGVvU291cmNlID0gJCgnPHNvdXJjZSAvPicpO1xyXG4gICAgICAgIGxldCB2aWRlb0xvY2FsRmlsZSA9ICh0aGlzLmZpbGVzKVswXTtcclxuICAgICAgICAkKHZpZGVvX3VwbG9hZF9uYW1lKS5yZW1vdmVDbGFzcygnZC1ub25lJyk7XHJcbiAgICAgICAgaWYobWltZXNWaWRlby5pbmNsdWRlcyh2aWRlb0xvY2FsRmlsZS50eXBlKSkge1xyXG4gICAgICAgICAgICAkKHZpZGVvX3VwbG9hZF9uYW1lKS5hcHBlbmQodmlkZW9Mb2NhbEZpbGUubmFtZSlcclxuICAgICAgICAgICAgJChsb2FkaW5nX3ZpZGVvX2NvbnRhaW5lcikucmVtb3ZlQ2xhc3MoJ2Qtbm9uZScpO1xyXG4gICAgICAgICAgICAkKCcjYnRuLWFkZC12aWRlbycpLmFkZENsYXNzKCdkLW5vbmUnKTtcclxuXHJcbiAgICAgICAgICAgIGNvbnN0IHJlYWRlciA9IG5ldyBGaWxlUmVhZGVyKCk7XHJcbiAgICAgICAgICAgIHJlYWRlci5vbmxvYWQgPSBmdW5jdGlvbiAoZSkge1xyXG4gICAgICAgICAgICAgICAgdmlkZW9Tb3VyY2UuYXR0cignc3JjJywgZS50YXJnZXQucmVzdWx0KTtcclxuICAgICAgICAgICAgICAgIHZpZGVvX3VwbG9hZF9wcmV2aWV3LmFwcGVuZENoaWxkKHZpZGVvU291cmNlWzBdKTtcclxuICAgICAgICAgICAgICAgIHZpZGVvX3VwbG9hZF9wcmV2aWV3LmxvYWQoKTtcclxuICAgICAgICAgICAgICAgIHZpZGVvX3VwbG9hZF9wcmV2aWV3LnBsYXkoKTtcclxuICAgICAgICAgICAgfTtcclxuXHJcbiAgICAgICAgICAgIHJlYWRlci5vbnByb2dyZXNzID0gZnVuY3Rpb24gKGUpIHtcclxuICAgICAgICAgICAgICAgICQobG9hZGluZ192aWRlbykuaHRtbChNYXRoLnJvdW5kKChlLmxvYWRlZCAqIDEwMCkgLyBlLnRvdGFsKSk7XHJcbiAgICAgICAgICAgIH07XHJcbiAgICAgICAgICAgIHJlYWRlci5vbmxvYWRlbmQgPSBmdW5jdGlvbihlKSB7XHJcbiAgICAgICAgICAgICAgICAkKGxvYWRpbmdfdmlkZW9fY29udGFpbmVyKS5hZGRDbGFzcygnZC1ub25lJylcclxuICAgICAgICAgICAgICAgICQodmlkZW9fdXBsb2FkX3ByZXZpZXcpLnJlbW92ZUNsYXNzKCdkLW5vbmUnKTtcclxuICAgICAgICAgICAgfTtcclxuXHJcbiAgICAgICAgICAgIHJlYWRlci5yZWFkQXNEYXRhVVJMKHZpZGVvTG9jYWxGaWxlKTtcclxuICAgICAgICB9IGVsc2Uge1xyXG4gICAgICAgICAgICAkKCcjYnRuLWFkZC12aWRlbycpLnJlbW92ZUNsYXNzKCdkLW5vbmUnKTtcclxuICAgICAgICAgICAgJCh2aWRlb191cGxvYWRfbmFtZSkuaHRtbCgnTGUgZmljaGllciBjaGFyZ2VyIG5cXCdlc3QgcGFzIHVuZSB2aWRlbycpXHJcbiAgICAgICAgfVxyXG5cclxuICAgIH0pXHJcblxyXG4gICAgLy8gYm91dHRvbiBham91dCBkb2N1bWVudCAoY3JlYXRpb24gZGUgcGx1c2lldXIgaW5wdXQtZmlsZSBhdSBmdXIgZXQgw6AgbWVzdXJlIGR1IGNsaWNrICsgY2xpY2sgYXV0b21hdGlxdWUgc3VyIGNoYXF1ZSBpbnB1dCBmaWxlKVxyXG4gICAgJCh0aGlzKS5vbignY2xpY2snLCcjYnRuLWFkZC1kb2N1bWVudCcsIGZ1bmN0aW9uKGUpIHtcclxuICAgICAgICBlLnByZXZlbnREZWZhdWx0KCk7XHJcbiAgICAgICAgY29uc3QgaW5wdXRGaWxlID0gJCgnPGlucHV0IC8+Jywge1xyXG4gICAgICAgICAgICB0eXBlOiAnZmlsZScsXHJcbiAgICAgICAgICAgIGNsYXNzOidkLW5vbmUgaW5wdXQtZmlsZS1kb2N1bWVudCcsXHJcbiAgICAgICAgICAgIGFjY2VwdDogbWltZXNEb2N1bWVudC5qb2luKCcsJylcclxuICAgICAgICB9KTtcclxuICAgICAgICAkKHRoaXMpLmNsb3Nlc3QoJyNmb3JtYXRpb24tZG9jdW1lbnQnKS5hcHBlbmQoaW5wdXRGaWxlKTtcclxuICAgICAgICBpbnB1dEZpbGUudHJpZ2dlcignY2xpY2snKTtcclxuICAgIH0pO1xyXG4gICAgLy8gYWZmaWNoYWdlIGR1IG5vbSBkZSBjaGFxdWUgZmljaGllciBpbXBvcnRlclxyXG4gICAgJCh0aGlzKS5vbignY2hhbmdlJywnI2Zvcm1hdGlvbi1kb2N1bWVudCAuaW5wdXQtZmlsZS1kb2N1bWVudCcsIGZ1bmN0aW9uKGUpIHtcclxuICAgICAgICBlLnByZXZlbnREZWZhdWx0KCk7XHJcbiAgICAgICAgbGV0IGRvY3VtZW50TG9jYWxGaWxlID0gKHRoaXMuZmlsZXMpWzBdO1xyXG4gICAgICAgIGlmKG1pbWVzRG9jdW1lbnQuaW5jbHVkZXMoZG9jdW1lbnRMb2NhbEZpbGUudHlwZSkpIHtcclxuICAgICAgICAgICAgJCgnI2RvY3VtZW50LXVwbG9hZC1uYW1lJykuYXBwZW5kKCc8c3BhbiBjbGFzcz1cImJhZGdlIGJnLWxpZ2h0LWluZm8gdGV4dC1kYXJrXCI+PGkgY2xhc3M9XCJmYS1zb2xpZCBmYS1ib29rIG1lLTJcIj48L2k+ICcrZG9jdW1lbnRMb2NhbEZpbGUubmFtZSsnPC9zcGFuPicpLmFwcGVuZCgnPGJyPicpXHJcbiAgICAgICAgfVxyXG4gICAgfSlcclxuXHJcbiAgICAvLyBib3V0dG9uIGFqb3V0IGF1ZGlvIChjcmVhdGlvbiBkZSBwbHVzaWV1ciBpbnB1dC1maWxlIGF1IGZ1ciBldCDDoCBtZXN1cmUgZHUgY2xpY2sgKyBjbGljayBhdXRvbWF0aXF1ZSBzdXIgY2hhcXVlIGlucHV0IGZpbGUpXHJcbiAgICAkKHRoaXMpLm9uKCdjbGljaycsJyNidG4tYWRkLWF1ZGlvJywgZnVuY3Rpb24oZSkge1xyXG4gICAgICAgIGUucHJldmVudERlZmF1bHQoKTtcclxuICAgICAgICBjb25zdCBpbnB1dEZpbGUgPSAkKCc8aW5wdXQgLz4nLCB7XHJcbiAgICAgICAgICAgIHR5cGU6ICdmaWxlJyxcclxuICAgICAgICAgICAgY2xhc3M6J2Qtbm9uZSBpbnB1dC1maWxlLWF1ZGlvJyxcclxuICAgICAgICAgICAgYWNjZXB0OiBtaW1lc0F1ZGlvLmpvaW4oJywnKVxyXG4gICAgICAgIH0pO1xyXG4gICAgICAgICQodGhpcykuY2xvc2VzdCgnI2Zvcm1hdGlvbi1hdWRpbycpLmFwcGVuZChpbnB1dEZpbGUpO1xyXG4gICAgICAgIGlucHV0RmlsZS50cmlnZ2VyKCdjbGljaycpO1xyXG4gICAgfSk7XHJcbiAgICAvLyBhZmZpY2hhZ2UgZHUgbm9tIGRlIGNoYXF1ZSBmaWNoaWVyIGltcG9ydGVyXHJcbiAgICAkKHRoaXMpLm9uKCdjaGFuZ2UnLCcjZm9ybWF0aW9uLWF1ZGlvIC5pbnB1dC1maWxlLWF1ZGlvJywgZnVuY3Rpb24oZSkge1xyXG4gICAgICAgIGUucHJldmVudERlZmF1bHQoKTtcclxuICAgICAgICBsZXQgYXVkaW9Mb2NhbEZpbGUgPSAodGhpcy5maWxlcylbMF07XHJcbiAgICAgICAgaWYobWltZXNBdWRpby5pbmNsdWRlcyhhdWRpb0xvY2FsRmlsZS50eXBlKSkge1xyXG4gICAgICAgICAgICAkKCcjYXVkaW8tdXBsb2FkLW5hbWUnKS5hcHBlbmQoJzxzcGFuIGNsYXNzPVwiYmFkZ2UgYmctbGlnaHQtaW5mbyB0ZXh0LWRhcmtcIj48aSBjbGFzcz1cImZhLXNvbGlkIGZhLW11c2ljIG1lLTJcIj48L2k+ICcrYXVkaW9Mb2NhbEZpbGUubmFtZSsnPC9zcGFuPicpLmFwcGVuZCgnPGJyPicpXHJcbiAgICAgICAgfVxyXG4gICAgfSlcclxuXHJcbiAgICAvLy8vLy8vIERFQlVUIEZJQ0hFIEZPUk1BVElPTiAvLy8vLy8vXHJcbiAgICAvKipcclxuICAgICAqIETDqWJ1dCBmaWNoZSBmb3JtYXRpb25cclxuICAgICAqL1xyXG4gICAgLy8gc3VwcHJpbWVyIHVuIG3DqWRpYVxyXG4gICAgJCh0aGlzKS5vbignY2xpY2snLCAnLmJ0bi1tZWRpYS1kZWxldGUnLCBmdW5jdGlvbihlKSB7XHJcbiAgICAgICAgZS5wcmV2ZW50RGVmYXVsdCgpO1xyXG4gICAgICAgIGxldCBtZWRpYURlbGV0ZSA9ICQoJzxpbnB1dCAvPicsIHtcclxuICAgICAgICAgICAgdHlwZTogJ2hpZGRlbicsXHJcbiAgICAgICAgICAgIGNsYXNzOiAnaGlkZGVuX21lZGlhX2RlbGV0ZWQnLFxyXG4gICAgICAgICAgICBuYW1lOiAnZGVsZXRlZF9tZWRpYVtdJyxcclxuICAgICAgICAgICAgdmFsdWU6ICQodGhpcykuYXR0cignZGF0YS1tZWRpYS1pZCcpXHJcbiAgICAgICAgfSk7XHJcbiAgICAgICAgJCgnI2Zvcm1hdGlvbi1maWNoZScpLmFwcGVuZChtZWRpYURlbGV0ZSk7XHJcbiAgICAgICAgJCh0aGlzKS5jbG9zZXN0KCcubWVkaWEnKS5maXJzdCgpLnJlbW92ZSgpO1xyXG4gICAgfSlcclxuICAgIC8vIGVucmVnaXN0cmVtZW50IGRlcyBkb25uw6llcyBkdSBmb3JtdWxhaXJlXHJcbiAgICAvLyBldGFwZSAxIDogdXBsb2FkIHZpZGVvIHZlcnMgc2VydmV1ciB2aW1lb1xyXG4gICAgLy8gZXRhcCAyIDogc3VibWl0IGZvcm11bGFpcmUgKHN5bWZvbnkgOiB1cGxvYWQgKyBmbHVzaCBEYXRhKVxyXG4gICAgJCh0aGlzKS5vbignY2xpY2snLCcjZWRpdC1mb3JtYXRpb24nLGFzeW5jIGZ1bmN0aW9uKGUpIHtcclxuICAgICAgICBlLnByZXZlbnREZWZhdWx0KCk7XHJcbiAgICAgICAgdmFsaWRhdGlvbkZvcm11bGFpcmUoYXN5bmMgZnVuY3Rpb24oKSB7XHJcbiAgICAgICAgICAgICBwcm9ncmVzc2lvbkJhcigwKTtcclxuICAgICAgICAgICAgbGV0IGZpbGVEZWxldGVkID0gbmV3IEZvcm1EYXRhKCk7XHJcbiAgICAgICAgICAgICQoJy5oaWRkZW5fbWVkaWFfZGVsZXRlZCcpLmVhY2goZnVuY3Rpb24oKSB7XHJcbiAgICAgICAgICAgICAgICBmaWxlRGVsZXRlZC5hcHBlbmQoJ2RlbGV0ZWRfbWVkaWFbXScsICQodGhpcykudmFsKCkpXHJcbiAgICAgICAgICAgIH0pO1xyXG4gICAgICAgICAgICAoYXdhaXQgYXhpb3MucG9zdChSb3V0aW5nLmdlbmVyYXRlKCdjb2FjaF9mb3JtYXRpb25fZGVsZXRlTWVkaWEnKSxmaWxlRGVsZXRlZCkpXHJcbiAgICAgICAgICAgICBpZihhZGRWaWRlbykge1xyXG4gICAgICAgICAgICAgICAgICQoJy5oaWRkZW5WaWRlb0RhdGEnKS5yZW1vdmUoKTtcclxuICAgICAgICAgICAgICAgICBzZW5kVmlkZW9Ub1ZpbWVvKHtcclxuICAgICAgICAgICAgICAgICAgICAgc2VsZWN0b3I6JCgnI2lucHV0VmlkZW8nKSxcclxuICAgICAgICAgICAgICAgICAgICAgdGl0cmU6JCgnI3ZpZGVvLXVwbG9hZC1uYW1lJykudGV4dCgpLFxyXG4gICAgICAgICAgICAgICAgICAgICBkZXNjcmlwdGlvbjonJyxcclxuICAgICAgICAgICAgICAgICAgICAgZXJyb3I6IGZ1bmN0aW9uKGRhdGEpIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgIGFsZXJ0KCdlcnJldXIgbG9ycyBkdSB0w6lsw6ljaGFyZ2VtZW50IHZpZGVvICcrZGF0YSlcclxuICAgICAgICAgICAgICAgICAgICAgfSxcclxuICAgICAgICAgICAgICAgICAgICAgcHJvZ3Jlc3M6IGZ1bmN0aW9uKHBvdXJjZW50YWdlKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICBwcm9ncmVzc2lvbkJhcihwb3VyY2VudGFnZSk7XHJcbiAgICAgICAgICAgICAgICAgICAgIH0sXHJcbiAgICAgICAgICAgICAgICAgICAgIGNvbXBsZXRlOiBhc3luYyBmdW5jdGlvbih2aWRlb0lkLCB1cmwsIHByZXR0eURhdGEpIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgIGF3YWl0IHNhdmVEYXRhKHZpZGVvSWQpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgcHJvZ3Jlc3Npb25Db250YWluZXIucmVtb3ZlKClcclxuICAgICAgICAgICAgICAgICAgICAgICAgIHByb2dyZXNzaW9uTGFiZWwuaHRtbChcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAnPGRpdiBjbGFzcz1cInRleHQtY2VudGVyXCI+JyArXHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgJyAgIDxoMSBjbGFzcz1cInRleHQtc3VjY2Vzc1wiPjxpIGNsYXNzPVwiZmEgZmEtY2lyY2xlLWNoZWNrXCI+PC9pPjwvaDE+ICAgICAnICtcclxuICAgICAgICAgICAgICAgICAgICAgICAgICAgICAnICAgPHN0cm9uZz5Gb3JtYXRpb24gbW9kaWZpw6kgYXZlYyBzdWNjw6hzPC9zdHJvbmc+ICcgK1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICc8L2Rpdj4nKTtcclxuICAgICAgICAgICAgICAgICAgICAgICAgIHNldFRpbWVvdXQoZnVuY3Rpb24oKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgcHJvZ3Jlc3Npb25MYWJlbC5odG1sKCc8c3Ryb25nPlJhZnJhaWNoaXNzZW1lbnQgZGUgbGEgcGFnZSAuLi48L3N0cm9uZz4nKVxyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgIHNldFRpbWVvdXQoZnVuY3Rpb24oKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgIGxvY2F0aW9uLnJlbG9hZCgpO1xyXG4gICAgICAgICAgICAgICAgICAgICAgICAgICAgIH0sMTAwMClcclxuICAgICAgICAgICAgICAgICAgICAgICAgIH0sMTAwMClcclxuICAgICAgICAgICAgICAgICAgICAgfVxyXG4gICAgICAgICAgICAgICAgIH0pXHJcbiAgICAgICAgICAgICB9IGVsc2Uge1xyXG4gICAgICAgICAgICAgICAgIGF3YWl0IHNhdmVEYXRhKCk7XHJcbiAgICAgICAgICAgICAgICAgcHJvZ3Jlc3Npb25Db250YWluZXIucmVtb3ZlKClcclxuICAgICAgICAgICAgICAgICBwcm9ncmVzc2lvbkxhYmVsLmh0bWwoXHJcbiAgICAgICAgICAgICAgICAgICAgICc8ZGl2IGNsYXNzPVwidGV4dC1jZW50ZXJcIj4nICtcclxuICAgICAgICAgICAgICAgICAgICAgJyAgIDxoMSBjbGFzcz1cInRleHQtc3VjY2Vzc1wiPjxpIGNsYXNzPVwiZmEgZmEtY2lyY2xlLWNoZWNrXCI+PC9pPjwvaDE+ICAgICAnICtcclxuICAgICAgICAgICAgICAgICAgICAgJyAgIDxzdHJvbmc+Rm9ybWF0aW9uIG1vZGlmacOpIGF2ZWMgc3VjY8Ooczwvc3Ryb25nPiAnICtcclxuICAgICAgICAgICAgICAgICAgICAgJzwvZGl2PicpO1xyXG4gICAgICAgICAgICAgICAgIHNldFRpbWVvdXQoZnVuY3Rpb24oKSB7XHJcbiAgICAgICAgICAgICAgICAgICAgIHByb2dyZXNzaW9uTGFiZWwuaHRtbCgnPHN0cm9uZz5SYWZyYWljaGlzc2VtZW50IGRlIGxhIHBhZ2UgLi4uPC9zdHJvbmc+JylcclxuICAgICAgICAgICAgICAgICAgICAgc2V0VGltZW91dChmdW5jdGlvbigpIHtcclxuICAgICAgICAgICAgICAgICAgICAgICAgIGxvY2F0aW9uLnJlbG9hZCgpO1xyXG4gICAgICAgICAgICAgICAgICAgICB9LDEwMDApXHJcbiAgICAgICAgICAgICAgICAgfSwxMDAwKVxyXG4gICAgICAgICAgICAgfVxyXG5cclxuXHJcbiAgICAgICAgfSlcclxuICAgIH0pXHJcblxyXG5cclxufSk7XHJcblxyXG5hc3luYyBmdW5jdGlvbiBzYXZlRGF0YSh2aWRlb0lkID0gJycpXHJcbntcclxuICAgIGxldCBkb2N1bWVudHNEYXRhID0gW107XHJcbiAgICBsZXQgYXVkaW9zRGF0YSA9IFtdO1xyXG4gICAgLy8gcHLDqXBhcmF0aW9uIGR1IGZvcm11bGFpcmUsIGZpY2hpZXJzIERvY3VtZW50cyBldCBBdWRpb3NcclxuICAgIGxldCBmaWxlRG9jdW1lbnRzID0gbmV3IEZvcm1EYXRhKCk7XHJcbiAgICBsZXQgZmlsZUF1ZGlvcyA9IG5ldyBGb3JtRGF0YSgpO1xyXG4gICAgbGV0IGZvcm1EYXRhID0gbmV3IEZvcm1EYXRhKCQoJ2Zvcm1bbmFtZT1cImZvcm1hdGlvblwiXScpWzBdKVxyXG4gICAgJCgnI2Zvcm1hdGlvbi1kb2N1bWVudCcpLmZpbmQoJ2lucHV0W3R5cGU9XCJmaWxlXCJdJykuZWFjaChmdW5jdGlvbigpIHtcclxuICAgICAgICBmaWxlRG9jdW1lbnRzLmFwcGVuZCgnZG9jdW1lbnRzW10nLCB0aGlzLmZpbGVzWzBdKTtcclxuICAgICAgICBjb25zdCBkb2N1bWVudCA9IHtcclxuICAgICAgICAgICAgbmFtZSA6IHRoaXMuZmlsZXNbMF0ubmFtZSxcclxuICAgICAgICAgICAgbWltZVR5cGU6IHRoaXMuZmlsZXNbMF0udHlwZSxcclxuICAgICAgICAgICAgdHlwZTogJ2RvY3VtZW50J1xyXG4gICAgICAgIH07XHJcbiAgICAgICAgZG9jdW1lbnRzRGF0YS5wdXNoKGRvY3VtZW50KTtcclxuICAgIH0pO1xyXG4gICAgJCgnI2Zvcm1hdGlvbi1hdWRpbycpLmZpbmQoJ2lucHV0W3R5cGU9XCJmaWxlXCJdJykuZWFjaChmdW5jdGlvbigpIHtcclxuICAgICAgICBmaWxlQXVkaW9zLmFwcGVuZCgnYXVkaW9zW10nLCB0aGlzLmZpbGVzWzBdKTtcclxuICAgICAgICBjb25zdCBhdWRpbyA9IHtcclxuICAgICAgICAgICAgbmFtZSA6IHRoaXMuZmlsZXNbMF0ubmFtZSxcclxuICAgICAgICAgICAgbWltZVR5cGU6IHRoaXMuZmlsZXNbMF0udHlwZSxcclxuICAgICAgICAgICAgdHlwZTonYXVkaW8nXHJcbiAgICAgICAgfTtcclxuICAgICAgICBhdWRpb3NEYXRhLnB1c2goYXVkaW8pO1xyXG4gICAgfSk7XHJcbiAgICBjb25zdCBpbWdfbG9hZGVyID0gJCgnPGltZyBzcmM9XCInK2NpcmNsZUltYWdlMysnXCIgLz4nKTtcclxuICAgIHByb2dyZXNzaW9uQ29udGFpbmVyLnJlcGxhY2VXaXRoKGltZ19sb2FkZXIpO1xyXG4gICAgcHJvZ3Jlc3Npb25Db250YWluZXIgPSAkKGltZ19sb2FkZXIpXHJcbiAgICBwcm9ncmVzc2lvbkxhYmVsLmh0bWwoJzxzdHJvbmc+VMOpbMOpY2hhcmdlbWVudCBkZXMgZG9jdW1lbnRzIGVuIGNvdXJzIC4uLjwvc3Ryb25nPicpO1xyXG4gICAgLy8gZW52b2llIGRlcyBmaWNoaWVycyBEb2N1bWVudHNcclxuICAgIGNvbnN0IHJlc3BvbnNlRG9jdW1lbnRzID0gKGF3YWl0IGF4aW9zLnBvc3QoUm91dGluZy5nZW5lcmF0ZSgnY29hY2hfZm9ybWF0aW9uX3VwbG9hZERvY3VtZW50JyksIGZpbGVEb2N1bWVudHMsIHtcclxuICAgICAgICBoZWFkZXJzOiB7XHJcbiAgICAgICAgICAgICdDb250ZW50LVR5cGUnOiAnbXVsdGlwYXJ0L2Zvcm0tZGF0YSdcclxuICAgICAgICB9XHJcbiAgICB9KSkuZGF0YTtcclxuICAgIGlmKCFyZXNwb25zZURvY3VtZW50cy5lcnJvcikge1xyXG4gICAgICAgIHJlc3BvbnNlRG9jdW1lbnRzLmZpbGVzLmZvckVhY2goZnVuY3Rpb24oZSwgaSkge1xyXG4gICAgICAgICAgICBkb2N1bWVudHNEYXRhW2ldLnNsdWcgPSBlO1xyXG4gICAgICAgIH0pO1xyXG4gICAgfVxyXG4gICAgcHJvZ3Jlc3Npb25MYWJlbC5odG1sKCc8c3Ryb25nPlTDqWzDqWNoYXJnZW1lbnQgZGVzIGF1ZGlvcyBlbiBjb3VycyAuLi48L3N0cm9uZz4nKVxyXG4gICAgLy8gZW52b2llIGRlcyBmaWNoaWVycyBhdWRpb3NcclxuICAgIGNvbnN0IHJlc3BvbnNlQXVkaW9zID0gKGF3YWl0IGF4aW9zLnBvc3QoUm91dGluZy5nZW5lcmF0ZSgnY29hY2hfZm9ybWF0aW9uX3VwbG9hZEF1ZGlvJyksIGZpbGVBdWRpb3MsIHtcclxuICAgICAgICBoZWFkZXJzOiB7XHJcbiAgICAgICAgICAgICdDb250ZW50LVR5cGUnOiAnbXVsdGlwYXJ0L2Zvcm0tZGF0YSdcclxuICAgICAgICB9XHJcbiAgICB9KSkuZGF0YTtcclxuICAgIGlmKCFyZXNwb25zZUF1ZGlvcy5lcnJvcikge1xyXG4gICAgICAgIHJlc3BvbnNlQXVkaW9zLmZpbGVzLmZvckVhY2goZnVuY3Rpb24oZSwgaSkge1xyXG4gICAgICAgICAgICBhdWRpb3NEYXRhW2ldLnNsdWcgPSBlO1xyXG4gICAgICAgIH0pO1xyXG4gICAgfVxyXG4gICAgcHJvZ3Jlc3Npb25MYWJlbC5odG1sKCc8c3Ryb25nPkZpbmFsaXNhdGlvbiAuLi48L3N0cm9uZz4nKTtcclxuICAgIC8vIHLDqWN1cGVyYXRpb24gZGUgdG91dCBsZXMgbcOpZGlhcyBpbXBvcnTDqSwgcXUnaW1wb3J0ZSBxdWUgY2Ugc29pdCB1biBkb2N1bWVudCBvdSB1biBmaWNoaWVyIGF1ZGlvXHJcbiAgICBjb25zdCBtZWRpYXNEYXRhID0gZG9jdW1lbnRzRGF0YS5jb25jYXQoYXVkaW9zRGF0YSk7XHJcbiAgICAvLyBjb25zb2xlLmxvZyhtZWRpYXNEYXRhKTtcclxuICAgIGZvcm1EYXRhLmFwcGVuZCgnbWVkaWFzRGF0YScsIEpTT04uc3RyaW5naWZ5KG1lZGlhc0RhdGEpKTtcclxuICAgIGZvcm1EYXRhLmFwcGVuZCgndmlkZW9faWQnLCB2aWRlb0lkKTtcclxuICAgIChhd2FpdCBheGlvcy5wb3N0KCQoJyNmb3JtYXRpb24sICNmb3JtYXRpb24tZmljaGUnKS5hdHRyKCdhY3Rpb24nKSxmb3JtRGF0YSkpLmRhdGE7XHJcbn1cclxuXHJcbmxldCBjYWxjLHByb2dyZXNzaW9uQ29udGFpbmVyLCBjYWxjQ2hpbGQscHJvZ3Jlc3Npb24scHJvZ3Jlc3Npb25MYWJlbCA9IG51bGw7XHJcbmZ1bmN0aW9uIHByb2dyZXNzaW9uQmFyKHBvdXJjZW50YWdlKVxyXG57XHJcbiAgICBpZihjYWxjID09IG51bGwpIHtcclxuICAgICAgICBjYWxjID0gJCgnPGRpdiAvPicsIHtcclxuICAgICAgICAgICAgY2xhc3M6ICd3LTEwMCBoLTEwMCBwb3NpdGlvbi1hYnNvbHV0ZSB0b3AtMCBzdGFydC0wIGQtZmxleCcsXHJcbiAgICAgICAgICAgIHN0eWxlOiAnYmFja2dyb3VuZDogcmdiYSgyNTUsMjU1LDI1NSwwLjcpJ1xyXG4gICAgICAgIH0pO1xyXG5cclxuICAgICAgICBjYWxjQ2hpbGQgPSAkKCc8ZGl2IC8+Jywge1xyXG4gICAgICAgICAgICBjbGFzczogJ20tYXV0byB3LTEwMCB0ZXh0LWNlbnRlcidcclxuICAgICAgICB9KTtcclxuXHJcbiAgICAgICAgcHJvZ3Jlc3Npb25Db250YWluZXIgPSAkKCc8ZGl2IC8+Jywge1xyXG4gICAgICAgICAgICBjbGFzczoncHJvZ3Jlc3Mgdy01MCBteC1hdXRvIG1iLTIgc2hhZG93LXNtJ1xyXG4gICAgICAgIH0pO1xyXG5cclxuICAgICAgICBwcm9ncmVzc2lvbiA9ICQoJzxkaXYgLz4nLCB7XHJcbiAgICAgICAgICAgIGNsYXNzOidwcm9ncmVzcy1iYXIgcHJvZ3Jlc3MtYmFyLXN0cmlwZWQgYmctcHJpbWFyeScsXHJcbiAgICAgICAgICAgIHJvbGU6J3Byb2dyZXNzYmFyJ1xyXG4gICAgICAgIH0pO1xyXG4gICAgICAgIHByb2dyZXNzaW9uTGFiZWwgPSAkKCc8ZGl2IC8+Jywge1xyXG4gICAgICAgICAgICBjbGFzczondGV4dC1jZW50ZXInXHJcbiAgICAgICAgfSkuaHRtbCgnPHN0cm9uZz5Uw6lsw6ljaGFyZ2VtZW50IGRlIGxhIHZpZGVvIGVuIGNvdXJzIC4uLjwvc3Ryb25nPicpO1xyXG4gICAgICAgIHByb2dyZXNzaW9uLmh0bWwocG91cmNlbnRhZ2UpO1xyXG4gICAgICAgIHByb2dyZXNzaW9uQ29udGFpbmVyLmh0bWwocHJvZ3Jlc3Npb24pO1xyXG4gICAgICAgIGNhbGNDaGlsZC5odG1sKHByb2dyZXNzaW9uQ29udGFpbmVyKTtcclxuICAgICAgICBjYWxjQ2hpbGQuYXBwZW5kKHByb2dyZXNzaW9uTGFiZWwpXHJcbiAgICAgICAgY2FsYy5odG1sKGNhbGNDaGlsZCk7XHJcblxyXG4gICAgICAgICQoJyNmb3JtLWZvcm1hdGlvbicpLmFwcGVuZChjYWxjKVxyXG4gICAgfSBlbHNlIHtcclxuICAgICAgICBwcm9ncmVzc2lvbi5odG1sKHBvdXJjZW50YWdlKyclJyk7XHJcbiAgICAgICAgcHJvZ3Jlc3Npb24uY3NzKHtcclxuICAgICAgICAgICAgd2lkdGg6IHBvdXJjZW50YWdlKyclJ1xyXG4gICAgICAgIH0pO1xyXG5cclxuICAgICAgICBwcm9ncmVzc2lvbi5hdHRyKCdhcmlhLXZhbHVlbm93JywgcG91cmNlbnRhZ2UpXHJcbiAgICB9XHJcbn1cclxuXHJcblxyXG5mdW5jdGlvbiB2YWxpZGF0aW9uRm9ybXVsYWlyZShjYWxsYmFjaylcclxue1xyXG4gICAgJCgnI2Zvcm1hdGlvbiwgI2Zvcm1hdGlvbi1maWNoZScpLnZhbGlkYXRlKHtcclxuICAgICAgICAvLyBpbiAncnVsZXMnIHVzZXIgaGF2ZSB0byBzcGVjaWZ5IGFsbCB0aGUgY29uc3RyYWludHMgZm9yIHJlc3BlY3RpdmUgZmllbGRzXHJcbiAgICAgICAgcnVsZXMgOiB7XHJcbiAgICAgICAgICAgICdmb3JtYXRpb25bdGl0cmVdJyA6IFwicmVxdWlyZWRcIixcclxuICAgICAgICAgICAgJ2Zvcm1hdGlvbltkZXNjcmlwdGlvbl0nIDogXCJyZXF1aXJlZFwiLFxyXG4gICAgICAgICAgICAnZm9ybWF0aW9uW2NhdGVnb3JpZUZvcm1hdGlvbl0nIDogXCJyZXF1aXJlZFwiLFxyXG4gICAgICAgICAgICAnZm9ybWF0aW9uW2NvbnRlbnVdJyA6IFwicmVxdWlyZWRcIixcclxuICAgICAgICB9LFxyXG4gICAgICAgIC8vIGluICdtZXNzYWdlcycgdXNlciBoYXZlIHRvIHNwZWNpZnkgbWVzc2FnZSBhcyBwZXIgcnVsZXNcclxuICAgICAgICBtZXNzYWdlcyA6IHtcclxuICAgICAgICAgICAgJ2Zvcm1hdGlvblt0aXRyZV0nIDogXCI8aSBjbGFzcz0nZmEgZmEtd2FybmluZyc+PC9pPiBWZXVpbGxleiBlbnRyZXIgdW5lIHRpdHJlXCIsXHJcbiAgICAgICAgICAgICdmb3JtYXRpb25bZGVzY3JpcHRpb25dJyA6IFwiPGkgY2xhc3M9J2ZhIGZhLXdhcm5pbmcnPjwvaT4gTGEgZGVzY3JpcHRpb24gZXN0IG9ibGlnYXRvaXJlXCIsXHJcbiAgICAgICAgICAgICdmb3JtYXRpb25bY2F0ZWdvcmllRm9ybWF0aW9uXScgOiBcIjxpIGNsYXNzPSdmYSBmYS13YXJuaW5nJz48L2k+IExhIGNhdMOpZ29yaWUgZXN0IG9ibGlnYXRvaXJlXCIsXHJcbiAgICAgICAgICAgICdmb3JtYXRpb25bY29udGVudV0nIDogJzxpIGNsYXNzPVxcJ2ZhIGZhLXdhcm5pbmdcXCc+PC9pPiBWZXVpbGxleiBlbnRyZXIgbGUgY29udGVudSBkZSBsYSBmb3JtYXRpb24nXHJcbiAgICAgICAgfSxcclxuICAgICAgICBzdWJtaXRIYW5kbGVyOiBmdW5jdGlvbigpIHtcclxuXHJcbiAgICAgICAgICAgIGlmKCQoJyNpbnB1dFZpZGVvJykubGVuZ3RoID09PSAwKSB7XHJcbiAgICAgICAgICAgICAgICBjb25zdCBhbGVydCA9ICc8ZGl2IGNsYXNzPVwiYWxlcnQgYWxlcnQtZGFuZ2VyIG15LTJcIiByb2xlPVwiYWxlcnRcIj5cXG4nICtcclxuICAgICAgICAgICAgICAgICAgICAnICBMYSB2aWTDqW8gZXN0IG9ibGlnYXRvaXJlXFxuJyArXHJcbiAgICAgICAgICAgICAgICAgICAgJzwvZGl2Pic7XHJcbiAgICAgICAgICAgICAgICAkKCcjZm9ybWF0aW9uJykucHJlcGVuZChhbGVydCk7XHJcblxyXG4gICAgICAgICAgICB9IGVsc2Uge1xyXG4gICAgICAgICAgICAgICAgY2FsbGJhY2soKTtcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgIH1cclxuICAgIH0pO1xyXG4gICAgJCgnI2Zvcm1hdGlvbiwgI2Zvcm1hdGlvbi1maWNoZScpLnN1Ym1pdCgpO1xyXG59XHJcbihmdW5jdGlvbihpLCBzLCBvLCBnLCByLCBhLCBtKSB7XHJcbiAgICBpWydHb29nbGVBbmFseXRpY3NPYmplY3QnXSA9IHI7XHJcbiAgICBpW3JdID0gaVtyXSB8fCBmdW5jdGlvbigpIHtcclxuICAgICAgICAoaVtyXS5xID0gaVtyXS5xIHx8IFtdKS5wdXNoKGFyZ3VtZW50cylcclxuICAgIH0sIGlbcl0ubCA9IDEgKiBuZXcgRGF0ZSgpO1xyXG4gICAgYSA9IHMuY3JlYXRlRWxlbWVudChvKSxcclxuICAgICAgICBtID0gcy5nZXRFbGVtZW50c0J5VGFnTmFtZShvKVswXTtcclxuICAgIGEuYXN5bmMgPSAxO1xyXG4gICAgYS5zcmMgPSBnO1xyXG4gICAgbS5wYXJlbnROb2RlLmluc2VydEJlZm9yZShhLCBtKVxyXG59KSh3aW5kb3csIGRvY3VtZW50LCAnc2NyaXB0JywgJy8vd3d3Lmdvb2dsZS1hbmFseXRpY3MuY29tL2FuYWx5dGljcy5qcycsICdnYScpO1xyXG5nYSgnY3JlYXRlJywgJ1VBLTU3OTg0NDE3LTEnLCAnYXV0bycpO1xyXG5nYSgnc2VuZCcsICdwYWdldmlldycpO1xyXG4iLCJleHBvcnQgY29uc3QgbWltZXNWaWRlbyA9IFtcclxuICAgICd2aWRlby94LWZsdicsXHJcbiAgICAndmlkZW8vbXA0JyxcclxuICAgICd2aWRlby9hdmknLFxyXG4gICAgJ2FwcGxpY2F0aW9uL3gtbXBlZ1VSTCcsXHJcbiAgICAndmlkZW8vTVAyVCcsXHJcbiAgICAndmlkZW8vM2dwcCcsXHJcbiAgICAndmlkZW8vcXVpY2t0aW1lJyxcclxuICAgICd2aWRlby94LW1zdmlkZW8nLFxyXG4gICAgJ3ZpZGVvL3gtbXMtd212J1xyXG5dO1xyXG5cclxuZXhwb3J0IGNvbnN0IG1pbWVzRG9jdW1lbnQgPSBbXHJcbiAgICAnYXBwbGljYXRpb24vbXN3b3JkJyxcclxuICAgICdhcHBsaWNhdGlvbi92bmQub3BlbnhtbGZvcm1hdHMtb2ZmaWNlZG9jdW1lbnQud29yZHByb2Nlc3NpbmdtbC5kb2N1bWVudCcsXHJcbiAgICAnYXBwbGljYXRpb24vcGRmJyxcclxuICAgICdhcHBsaWNhdGlvbi92bmQubXMtcG93ZXJwb2ludCcsXHJcbiAgICAnYXBwbGljYXRpb24vdm5kLm9wZW54bWxmb3JtYXRzLW9mZmljZWRvY3VtZW50LnByZXNlbnRhdGlvbm1sLnByZXNlbnRhdGlvbidcclxuXTtcclxuXHJcbmV4cG9ydCBjb25zdCBtaW1lc0F1ZGlvID0gW1xyXG4gICAgJ2F1ZGlvL2Jhc2ljJyxcclxuICAgICdhdWRpby9iYXNpYycsXHJcbiAgICAnYXVpZG8vTDI0JyxcclxuICAgICdhdWRpby9taWQnLFxyXG4gICAgJ2F1ZGlvL21pZCcsXHJcbiAgICAnYXVkaW8vbXBlZycsXHJcbiAgICAnYXVkaW8vbXA0JyxcclxuICAgICdhdWRpby94LWFpZmYnLFxyXG4gICAgJ2F1ZGlvL3gtYWlmZicsXHJcbiAgICAnYXVkaW8veC1haWZmJyxcclxuICAgICdhdWRpby94LW1wZWd1cmwnLFxyXG4gICAgJ2F1ZGlvL3ZuZC5ybi1yZWFsYXVkaW8nLFxyXG4gICAgJ2F1ZGlvL3ZuZC5ybi1yZWFsYXVkaW8nLFxyXG4gICAgJ2F1ZGlvL29nZycsXHJcbiAgICAnYXVkaW8vdm9yYmlzJyxcclxuICAgICdhdWRpby92bmQud2F2J1xyXG5dOyJdLCJuYW1lcyI6WyJtaW1lc1ZpZGVvIiwibWltZXNEb2N1bWVudCIsIm1pbWVzQXVkaW8iLCJzZW5kVmlkZW9Ub1ZpbWVvIiwiY2lyY2xlSW1hZ2UzIiwiYXhpb3MiLCJyZXF1aXJlIiwiJCIsImRvY3VtZW50IiwicmVhZHkiLCJvbiIsImUiLCJwcmV2ZW50RGVmYXVsdCIsInZhbGlkYXRpb25Gb3JtdWxhaXJlIiwicHJvZ3Jlc3Npb25CYXIiLCJzZWxlY3RvciIsInRpdHJlIiwidGV4dCIsImRlc2NyaXB0aW9uIiwiZXJyb3IiLCJkYXRhIiwiYWxlcnQiLCJwcm9ncmVzcyIsInBvdXJjZW50YWdlIiwiY29tcGxldGUiLCJ2aWRlb0lkIiwidXJsIiwicHJldHR5RGF0YSIsInNhdmVEYXRhIiwicHJvZ3Jlc3Npb25Db250YWluZXIiLCJyZW1vdmUiLCJwcm9ncmVzc2lvbkxhYmVsIiwiaHRtbCIsInNldFRpbWVvdXQiLCJsb2NhdGlvbiIsImhyZWYiLCJSb3V0aW5nIiwiZ2VuZXJhdGUiLCJhZGRWaWRlbyIsImlucHV0RmlsZSIsInR5cGUiLCJhY2NlcHQiLCJqb2luIiwiaWQiLCJjbG9zZXN0IiwiYXBwZW5kIiwidHJpZ2dlciIsInZpZGVvX3VwbG9hZF9wcmV2aWV3IiwidmlkZW9fdXBsb2FkX25hbWUiLCJsb2FkaW5nX3ZpZGVvX2NvbnRhaW5lciIsImxvYWRpbmdfdmlkZW8iLCJ2aWRlb1NvdXJjZSIsInZpZGVvTG9jYWxGaWxlIiwiZmlsZXMiLCJyZW1vdmVDbGFzcyIsImluY2x1ZGVzIiwibmFtZSIsImFkZENsYXNzIiwicmVhZGVyIiwiRmlsZVJlYWRlciIsIm9ubG9hZCIsImF0dHIiLCJ0YXJnZXQiLCJyZXN1bHQiLCJhcHBlbmRDaGlsZCIsImxvYWQiLCJwbGF5Iiwib25wcm9ncmVzcyIsIk1hdGgiLCJyb3VuZCIsImxvYWRlZCIsInRvdGFsIiwib25sb2FkZW5kIiwicmVhZEFzRGF0YVVSTCIsImRvY3VtZW50TG9jYWxGaWxlIiwiYXVkaW9Mb2NhbEZpbGUiLCJtZWRpYURlbGV0ZSIsInZhbHVlIiwiZmlyc3QiLCJmaWxlRGVsZXRlZCIsIkZvcm1EYXRhIiwiZWFjaCIsInZhbCIsInBvc3QiLCJyZWxvYWQiLCJkb2N1bWVudHNEYXRhIiwiYXVkaW9zRGF0YSIsImZpbGVEb2N1bWVudHMiLCJmaWxlQXVkaW9zIiwiZm9ybURhdGEiLCJmaW5kIiwibWltZVR5cGUiLCJwdXNoIiwiYXVkaW8iLCJpbWdfbG9hZGVyIiwicmVwbGFjZVdpdGgiLCJoZWFkZXJzIiwicmVzcG9uc2VEb2N1bWVudHMiLCJmb3JFYWNoIiwiaSIsInNsdWciLCJyZXNwb25zZUF1ZGlvcyIsIm1lZGlhc0RhdGEiLCJjb25jYXQiLCJKU09OIiwic3RyaW5naWZ5IiwiY2FsYyIsImNhbGNDaGlsZCIsInByb2dyZXNzaW9uIiwic3R5bGUiLCJyb2xlIiwiY3NzIiwid2lkdGgiLCJjYWxsYmFjayIsInZhbGlkYXRlIiwicnVsZXMiLCJtZXNzYWdlcyIsInN1Ym1pdEhhbmRsZXIiLCJsZW5ndGgiLCJwcmVwZW5kIiwic3VibWl0IiwicyIsIm8iLCJnIiwiciIsImEiLCJtIiwicSIsImFyZ3VtZW50cyIsImwiLCJEYXRlIiwiY3JlYXRlRWxlbWVudCIsImdldEVsZW1lbnRzQnlUYWdOYW1lIiwiYXN5bmMiLCJzcmMiLCJwYXJlbnROb2RlIiwiaW5zZXJ0QmVmb3JlIiwid2luZG93IiwiZ2EiXSwic291cmNlUm9vdCI6IiJ9