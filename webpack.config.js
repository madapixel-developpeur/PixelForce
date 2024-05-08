const Encore = require('@symfony/webpack-encore');
const dotenv = require('dotenv');


// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    // directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/build')
    .copyFiles({
        from: './assets/images',
        // optional target path, relative to the output dir
        // to: 'images/[path][name].[ext]',
        // if versioning is enabled, add the file hash too
        to: 'images/[path][name].[hash:8].[ext]',
        // only copy files matching this pattern
        //pattern: /\.(png|jpg|jpeg)$/
    })
    // only needed for CDN's or sub-directory deploy
    //.setManifestKeyPrefix('build/')

    /*
     * ENTRY CONFIG
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if your JavaScript imports CSS.
     */
    .addEntry('app', './assets/app.js')
    .addEntry('bootstrap_touchspin', './assets/js/vuexy/js/jquery.bootstrap-touchspin.js')
    .addEntry('form_addAgent', './assets/js/form_addAgent.js')
    .addEntry('PlanificationLiveVideo', './assets/js/PlanificationLiveVideo.js')
    .addEntry('ImportVideoVimeo', './assets/js/ImportVideoVimeo.js')
    .addEntry('commentaire', './assets/js/commentaire.js')
    .addEntry('chatJS', './assets/js/chat/chat.js')
    .addEntry('formationForm', './assets/js/formationForm.js')
    .addEntry('ckeditorForm', './assets/js/ckeditorForm.js')
    .addEntry('validationSecteur', './assets/js/validationSecteur.js')
    .addEntry('ImportExportContact', './assets/js/ImportExportContact.js')
    .addEntry('tag', './assets/js/tag.js')
    .addEntry('StripeAgentRegistration', './assets/js/stripe/stripe-agent-registration.js')
    .addEntry('StripeAgentRegistrationSubscription', './assets/js/stripe/stripe-agent-registration-subscription.js')
    .addEntry('datatableJs', './assets/js/plugins/datatable.js')

    
    // Vuexy: Vendor JS
    .addEntry('vuexyJS', './assets/js/vuexy/vuexy.js')
    .addEntry('vuexy_vendors_js', './assets/js/vuexy/vendors/js/vendors.js')
    // Vuexy: Page Vendor JS
    .addEntry('vuexy_apexcharts_js', './assets/js/vuexy/vendors/js/charts/apexcharts.js')
    .addEntry('vuexy_toastr_js', './assets/js/vuexy/vendors/js/extensions/toastr.js')

    // Vuexy: jquery
    .addEntry('vuexy_jquery_validate', './assets/js/vuexy/js/jquery.validate.min.js')
    // Vuexy: Theme JS
    .addEntry('vuexy_app', './assets/js/vuexy/js/core/app.js')
    .addEntry('vuexy_app_menu', './assets/js/vuexy/js/core/app-menu.js')
    // Vuexy: Page JS
    .addEntry('vuexy_dashboard_ecommerce_js', './assets/js/vuexy/js/scripts/pages/dashboard-ecommerce.js')
    .addEntry('vuexy_app_user_view_js', './assets/js/vuexy/js/scripts/pages/app-user-view.js')
    .addEntry('vuexy_page_account_settings_account_js', './assets/js/vuexy/js/scripts/pages/page-account-settings-account.js')


    // .addEntry('vuexy_calendar_fullcalendar', './public/assets/vuexy/vendors/js/calendar/fullcalendar.min.js')
    // .addEntry('vuexy_extensions_moment', './public/assets/vuexy/vendors/js/extensions/moment.min.js')
    // .addEntry('vuexy_forms_select_select2', './public/assets/vuexy/vendors/js/forms/select/select2.full.min.js')
    // .addEntry('vuexy_forms_validation_jquery_validate', './public/assets/vuexy/vendors/js/forms/validation/jquery.validate.min.js')
    // .addEntry('vuexy_pickers_flatpickr', './public/assets/vuexy/vendors/js/pickers/flatpickr/flatpickr.min.js')
    



    .addStyleEntry('base', './assets/styles/base.css')
    .addStyleEntry('chat', './assets/styles/chat/chat.css')    

    // Vuexy: Theme CSS
    .addStyleEntry('vuexy_bootstrap', './assets/styles/vuexy/bootstrap.css')
    .addStyleEntry('vuexy_apexcharts', './assets/styles/vuexy/vendors/css/charts/apexcharts.css')
    .addStyleEntry('vuexy_toastr', './assets/styles/vuexy/vendors/css/extensions/toastr.css')
    .addStyleEntry('vuexy_bootstrap_extended', './assets/styles/vuexy/bootstrap-extended.css')
    .addStyleEntry('vuexy_colors', './assets/styles/vuexy/colors.css')
    .addStyleEntry('vuexy_components', './assets/styles/vuexy/components.css')
    .addStyleEntry('vuexy_dark_layout', './assets/styles/vuexy/themes/dark-layout.css')
    

    // Vuexy: Page CSS
    .addStyleEntry('vuexy_vertical_menu', './assets/styles/vuexy/core/menu/menu-types/vertical-menu.css')
    .addStyleEntry('vuexy_dashboard_ecommerce', './assets/styles/vuexy/pages/dashboard-ecommerce.css')
    .addStyleEntry('vuexy_chart_apex', './assets/styles/vuexy/plugins/charts/chart-apex.css')
    .addStyleEntry('vuexy_ext_component_toastr', './assets/styles/vuexy/plugins/extensions/ext-component-toastr.css')
    // Vuexy: plugins
    .addStyleEntry('vuexy_form_validation', './assets/styles/vuexy/plugins/forms/form_validation.css')

    
    // enables the Symfony UX Stimulus bridge (used in assets/bootstrap.js)

    .enableStimulusBridge('./assets/controllers.json')

    // When enabled, Webpack "splits" your files into smaller pieces for greater optimization.
    .splitEntryChunks()

    // will require an extra script tag for runtime.js
    // but, you probably want this, unless you're building a single-page app
    .enableSingleRuntimeChunk()

    /*
     * FEATURE CONFIG
     *
     * Enable & configure other features below. For a full
     * list of features, see:
     * https://symfony.com/doc/current/frontend.html#adding-more-features
     */
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    .configureBabel((config) => {
        config.plugins.push('@babel/plugin-proposal-class-properties');
    })

    // enables @babel/preset-env polyfills
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = 3;
    })

    // enables Sass/SCSS support
    .enableSassLoader()
    .enablePostCssLoader()

    // uncomment if you use TypeScript
    //.enableTypeScriptLoader()

    // uncomment if you use React
    //.enableReactPreset()

    // uncomment to get integrity="..." attributes on your script & link tags
    // requires WebpackEncoreBundle 1.4 or higher
    //.enableIntegrityHashes(Encore.isProduction())

    // uncomment if you're having problems with a jQuery plugin
    .autoProvidejQuery()
    // define the environment variables
    .configureDefinePlugin(options => {
        const env = dotenv.config({path: './.env'});
        if (env.error) {
            throw env.error;
        }

        //options['process.env'].VIMEO_ACCESS_TOKEN = JSON.stringify(env.parsed.VIMEO_ACCESS_TOKEN);
        //options['process.env'].MERCURE_JWT_SECRET_LONG = JSON.stringify(env.parsed.MERCURE_JWT_SECRET_LONG);

    })
;

module.exports = Encore.getWebpackConfig();
