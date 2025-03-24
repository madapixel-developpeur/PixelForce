/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
// You can specify which plugins you need

import './styles/app.scss'; // On commente cette ligne si on veut la même affichage du template (vuexy)
import 'datatables.net-bs5/css/dataTables.bootstrap5.min.css'
import jquery from 'jquery';
global.$ = global.jQuery = $;
import 'datatables.net-bs5';
// start the Stimulus application
import './bootstrap';
import './js/tinymce';
$(document).ready(function() {
    $('.sortable').DataTable({
        paging: false,
        ordering: true,
        info: false,
        searching : false
    });

    $('.sortable-sortDefault-Desc').DataTable({
        paging: false,
        ordering: true,
        order: [[0, 'desc']],
        info: false,
        searching : false
    })
    // dropdown bootstrap fix
    let dropdown = false;
    $(this).on('click', '[data-bs-toggle="dropdown"]', function(e) {
        e.preventDefault();
        e.stopPropagation();
        const idDrop = $(this).attr('id');
        if(idDrop) {
            $(this).closest('.dropdown').find('[aria-labelledby="'+idDrop+'"]').first().toggleClass('show');
        } else {
            $(this).next('.dropdown-menu').first().toggleClass('show')
        }

        dropdown = true;
    }).on('click', 'body', function() {
        $('.dropdown-menu').each(function() {
            $(this).removeClass('show');
        })
    });

    // popover bootstrap fix
    $('[data-bs-toggle="popover"]').each(function() {
        var popover = new bootstrap.Popover(this, {
            container: 'body',
            trigger: 'hover'
        })
    })

    // tooltip bootstrap fix
    $('[data-toggle="tooltip"]').each(function() {
        $(this).tooltip()
    })


});

require('./js/speedLiveVideo');
