import { mimesVideo, mimesDocument, mimesAudio } from './helpers/FileType'; // Assuming you have these mime types in a helper file
import circleImage3 from '../images/3-Leg-Preloader.svg'; // Assuming you use this image somewhere
import Swal from 'sweetalert2';
require('jquery-validation');

// Function to parse Vimeo video ID from a URL
function parseVimeoVideoId(url) {
    const regex = /vimeo\.com\/video\/(\d+)(\?.*)?/;
    const match = url.match(regex);
    if (match) {
        return match[1] + (match[2] || "");
    }
    return null;
}

$(document).ready(function () {
    function addFileInputButton(selector, inputClass, acceptTypes,name) {
        $(document).on('click', selector, function (e) {
            e.preventDefault();
            let timestampId = generateShortTimestampId();
            const inputFile = $('<input />', {
                type: 'file',
                class: `d-none ${inputClass}`,
                accept: acceptTypes.join(','),
                name: name,
                id : timestampId
            });
            $('.media-container').append(inputFile); 
            inputFile.trigger('click');
            inputFile.on('change', function(e) {
                updateViewFile(e,this,acceptTypes,inputClass,timestampId);
            });
        });

       
    }

    addFileInputButton('#btn-add-audio', 'input-file-audio', mimesAudio, 'audios[]');
    addFileInputButton('#btn-add-document', 'input-file-document', mimesDocument, 'documents[]');



    $(this).on('click','#submit-formation',async function(e) {
        if (!validateFormElements('formation')) {
            const invalidField = $(`#formation .is-invalid`).first();
            if (invalidField.length) {
                invalidField[0].reportValidity(); 
                Swal.fire({
                    title: 'Attention!',
                    text: 'Veuillez vous assurer que tous les champs sont valides.',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
            }
            return;
        }
        e.preventDefault(); 
        let form = $('#formation, #formation-fiche').get(0);
        try {
            const urlVideo = ($('#input-url-video').val()??'').trim();
            const videoId = parseVimeoVideoId(urlVideo);
            if(!urlVideo){
                Swal.fire({
                    title: 'Attention!',
                    text: 'La vidéo est obligatoire.',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
                return ;
            }
            if(urlVideo && !videoId){
                Swal.fire({
                    title: 'Attention!',
                    text: 'Le lien de la vidéo est invalide.',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
                return ;
            } 
            $('#video_id').val(videoId);
            form.submit();
        } catch (error) {
            console.error('Validation error:', error);
        }
    });

    $(this).on('click', '.btn-media-delete', function (e) {
        e.preventDefault();
        let mediaId = $(this).attr('data-media-id');
        let newMediaId = $(this).attr('data-new-media-id');

        if(mediaId){
            let mediaDelete = $('<input />', {
                type: 'hidden',
                class: 'hidden_media_deleted',
                name: 'deleted_media[]',
                value: $(this).attr('data-media-id')
            });
            $('#formation-fiche').append(mediaDelete);
            $(this).closest('.media').first().remove();
        }else{
            $(this).closest('.media').first().remove();
            $('#'+newMediaId).remove();
        }
    });


    $(this).on('click','#edit-formation',async function(e) {
        if (!validateFormElements('formation-fiche')) {
            const invalidField = $(`#formation-fiche .is-invalid`).first();
            if (invalidField.length) {
                invalidField[0].reportValidity(); 
                Swal.fire({
                    title: 'Attention!',
                    text: 'Veuillez vous assurer que tous les champs sont valides.',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
            }
            return;
        }
        e.preventDefault(); 
        let form = $('#formation, #formation-fiche').get(0);
        try {
            const urlVideo = ($('#input-url-video').val()??'').trim();
            const videoId = parseVimeoVideoId(urlVideo);
            if(urlVideo && !videoId){
                Swal.fire({
                    title: 'Attention!',
                    text: ' Le lien de la vidéo est invalide.',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
                return ;
            } 
            $('#video_id').val(videoId);
            form.submit();
        } catch (error) {
            console.error('Validation error:', error);
        }
    });

   

});


function validateFormElements(formId) {
    let isValid = true;

    // Select all input, select, and textarea elements inside the specified form, including nested elements
    const formFields = Array.prototype.slice.call(document.querySelectorAll(`#${formId} input, #${formId} select, #${formId} textarea`));
    console.log(formFields);

    formFields.forEach(function (field) { 
        if (!field.checkValidity()) {
            $(field).addClass("is-invalid"); // Add invalid class to show error
            isValid = false;
        } else {
            $(field).removeClass("is-invalid"); // Remove invalid class
        }
    });

    return isValid;
}


function generateShortTimestampId() {
    return Date.now().toString(36); // Convert timestamp to base 36 for shorter ID
  }

function updateViewFile(e, inputElement,acceptTypes,inputClass,id) {
    e.preventDefault();
    let fileLocal = inputElement.files[0]; 
    const fileName = fileLocal.name;  
    const fileType = fileLocal.type;  
    const parentContainer = $(inputElement).closest('.media-container');
    const fileTypeList = {
        'input-file-audio': '#audio-upload-name',   
        'input-file-document': '#document-upload-name' 
    };

    if (acceptTypes.includes(fileType)) {
        let test = `
            <div class="row media" id='${ id }'>
                <div class="col-12 col-md-9 mt-4 font-small-2 ">
                    <span style='color:blue'><i class="fa-solid fa-${fileType === 'audio' ? 'music' : 'book'}  me-2"></i>   ${fileName}</span>
                </div>
                <div class="col-12 col-md-3 mt-4 font-small-1">
                    <a href="#" class="btn btn-outline-danger btn-sm btn-media-delete" data-new-media-id="${ id }"><i class="fa fa-trash"></i></a>
                </div>
            </div>

        `;
        $(fileTypeList[inputClass]).append(test);
    } else {
        Swal.fire({
            title: 'Attention!',
            text: 'Type de fichier invalide.',
            icon: 'warning',
            confirmButtonText: 'OK'
        });
    }
}




// async function submitFormWithFiles(videoId = '') {
//     let formData = new FormData();
//     alert('here');
//     $('#formation-document').find('input[type="file"]').each(function() {
//         $.each(this.files, function(i, file) {
//             formData.append('documents[]', file);
//         });
//     });

//     $('#formation-audio').find('input[type="file"]').each(function() {
//         $.each(this.files, function(i, file) {
//             formData.append('audios[]', file);
//         });
//     });

//     let formDataSubmit = new FormData($('#formation, #formation-fiche')[0]);
//     let formActionUrl = $('#formation, #formation-fiche').attr('action');


//     formData.forEach((value, key) => {
//         formDataSubmit.append(key, value);
//     });

//     if (videoId) {
//         formDataSubmit.append('video_id', videoId);
//     }

//     try {
//         const response = await $.ajax({
//             url: formActionUrl, 
//             type: 'POST',
//             data: formData,
//             processData: false,
//             contentType: false
//         });

//         if (response.status === 'success') {
//             alert('Form submitted successfully!');
//         } else if (response.error) {
//             if (response.errors) {
//                 response.errors.forEach(function(error) {
//                     const fieldName = error.field;
//                     const errorMessage = error.message;

//                     $(`[name="${fieldName}"]`)
//                         .closest('.form-group') 
//                         .find('.error-message') 
//                         .text(errorMessage) 
//                         .show(); 

//                     $(`[name="${fieldName}"]`).addClass('is-invalid');
//                 });
//             }
//         }
//     } catch (error) {
//         console.error('Error during form submission:', error);
//     }
// }

