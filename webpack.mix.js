const mix = require('laravel-mix');
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
mix.js('resources/js/pages/campaigns/index.js', 'public/js/campaign-index.js')
    .sass('resources/sass/campaigns/index.scss', 'public/css/campaign-index.css')
    .js('resources/js/pages/dashboard/dashboard.js', 'public/js/dashboard.js')
    .js('resources/js/pages/campaigns/fb-index.js', 'public/js/fb-campaign-index.js')
    .js('resources/js/pages/campaigns/assign.js', 'public/js/companies-assign.js')
    .js('resources/js/pages/appointments/index.js', 'public/js/appointments-index.js')
    .js('resources/js/pages/customers/index.js', 'public/js/customers-index.js')
    .js('resources/js/pages/events/index.js', 'public/js/events-index.js')
    .sass('resources/sass/dashboard/dashboard.scss', 'public/css/dashboard.css')
    .js('resources/js/pages/company/index.js', 'public/js/company-index.js')
    .sass('resources/sass/company/index.scss', 'public/css/company-index.css')
    .js('resources/js/pages/company/create.js', 'public/js/company-create.js')
    .sass('resources/sass/company/create.scss', 'public/css/company-create.css')
    .js('resources/js/pages/company/details.js', 'public/js/company-details.js')
    .sass('resources/sass/company/details.scss', 'public/css/company-details.css')
    .js('resources/js/pages/user/site-admin-index.js', 'public/js/site-admin-user-index.js')
    .sass('resources/sass/user/site-admin-index.scss', 'public/css/site-admin-user-index.css')
    .js('resources/js/pages/user/company-admin-index.js', 'public/js/company-admin-user-index.js')
    .sass('resources/sass/user/company-admin-index.scss', 'public/css/company-admin-user-index.css')
    .js('resources/js/pages/user/detail.js', 'public/js/user-detail.js')
    .sass('resources/sass/user/detail.scss', 'public/css/user-detail.css')
    .js('resources/js/pages/user/create.js', 'public/js/user-create.js')
    .js('resources/js/pages/customers/create.js', 'public/js/customer-create.js')
    .js('resources/js/pages/customers/edit.js', 'public/js/customer-edit.js')
    .sass('resources/sass/user/create.scss', 'public/css/user-create.css')
    .js('resources/js/pages/auth/login.js', 'public/js/login.js')
    .sass('resources/sass/auth/login.scss', 'public/css/login.css')
    .js('resources/js/pages/auth/registration.js', 'public/js/registration.js')
    .sass('resources/sass/auth/registration.scss', 'public/css/registration.css')
    .js('resources/js/pages/auth/registration-full.js', 'public/js/registration-full.js')
    .sass('resources/sass/auth/registration-full.scss', 'public/css/registration-full.css')
    .sass('resources/sass/media-template/create.scss', 'public/css/media-template-create.css')
    .js('resources/js/pages/media-template/create.js', 'public/js/media-template-create.js')
    .sass('resources/sass/media-template/index.scss', 'public/css/media-template-index.css')
    .js('resources/js/pages/media-template/index.js', 'public/js/media-template-index.js')
    .sass('resources/sass/media-template/details.scss', 'public/css/media-template-details.css')
    .js('resources/js/pages/media-template/details.js', 'public/js/media-template-details.js')
    .js('resources/js/pages/campaigns/console.js', 'public/js/console.js')
    .sass('resources/sass/campaigns/console.scss', 'public/css/console.css')
    // Campaigns
    .js('resources/js/pages/campaigns/create.js', 'public/js/campaigns-create.js')
    .sass('resources/sass/campaigns/create.scss', 'public/css/campaigns-create.css')
    .js('resources/js/pages/campaigns/edit.js', 'public/js/campaigns-edit.js')
    .sass('resources/sass/campaigns/edit.scss', 'public/css/campaigns-edit.css')
    .js('resources/js/pages/campaigns/stats.js', 'public/js/campaigns-stats.js')
    .sass('resources/sass/campaigns/stats.scss', 'public/css/campaigns-stats.css')
    .js('resources/js/pages/campaigns/facebook-campaign.js', 'public/js/campaigns-facebook-campaign.js')
    .sass('resources/sass/campaigns/facebook-campaign.scss', 'public/css/campaigns-facebook-campaign.css')
    .js('resources/js/pages/campaigns/responses.js', 'public/js/campaigns-responses.js')
    .sass('resources/sass/campaigns/responses.scss', 'public/css/campaigns-responses.css')
    // Lead
    .js('resources/js/pages/lead/check-in-form.js', 'public/js/check-in-form.js')
    .sass('resources/sass/lead/check-in-form.scss', 'public/css/check-in-form.css')
    // Recipients
    .js('resources/js/pages/campaigns/recipients/index.js', 'public/js/recipients-index.js')
    .sass('resources/sass/campaigns/recipients/index.scss', 'public/css/recipients-index.css')
    .js('resources/js/pages/campaigns/recipients/detail.js', 'public/js/recipients-detail.js')
    .sass('resources/sass/campaigns/recipients/detail.scss', 'public/css/recipients-detail.css')
    // Drops
    .js('resources/js/pages/campaigns/deployments/index.js', 'public/js/deployments-index.js')
    .sass('resources/sass/campaigns/deployments/index.scss', 'public/css/deployments-index.css')
    .js('resources/js/pages/campaigns/deployments/create.js', 'public/js/deployments-create.js')
    .sass('resources/sass/campaigns/deployments/details.scss', 'public/css/deployments-details.css')
    .js('resources/js/pages/campaigns/deployments/details.js', 'public/js/deployments-details.js')
    .sass('resources/sass/campaigns/deployments/create.scss', 'public/css/deployments-create.css')
    .js('resources/js/pages/campaigns/deployments/edit.js', 'public/js/deployments-edit.js')
    .sass('resources/sass/campaigns/deployments/edit.scss', 'public/css/deployments-edit.css')
    .js('resources/js/pages/campaigns/deployments/mailer-create.js', 'public/js/mailer-create.js')
    .sass('resources/sass/campaigns/deployments/mailer-create.scss', 'public/css/mailer-create.css')
    //Profile
    .js('resources/js/pages/profile/profile.js', 'public/js/profile.js')
    .sass('resources/sass/profile/profile.scss', 'public/css/profile.css')
    // Template builder
    .js('resources/js/pages/template-builder/editor.js', 'public/js/template-builder-editor.js')
    .sass('resources/sass/template-builder/editor.scss', 'public/css/template-builder-editor.css')
    //Selector
    .js('resources/js/pages/selector/select-company.js', 'public/js/select-company.js')
    .sass('resources/sass/selector/select-company.scss', 'public/css/select-company.css')
    //Auth
    .js('resources/js/pages/auth/forget-password.js', 'public/js/forget-password.js')
    .sass('resources/sass/auth/forget-password.scss', 'public/css/forget-password.css')
    .js('resources/js/pages/auth/reset-password.js', 'public/js/reset-password.js')
    .sass('resources/sass/auth/reset-password.scss', 'public/css/reset-password.css')
    //Settings
    .js('resources/js/pages/settings/settings.js', 'public/js/settings.js')
    .sass('resources/sass/settings/settings.scss', 'public/css/settings.css')
    
    //Industry type
    .js('resources/js/pages/industry_type/index.js', 'public/js/industry_type-index.js')
    .js('resources/js/pages/industry_type/create.js', 'public/js/industry_type-create.js')
    .js('resources/js/pages/industry_type/edit.js', 'public/js/industry_type-edit.js')

    // Plugins
    .copyDirectory('resources/js/plugins', 'public/js/plugins')
    .copyDirectory('resources/sass/plugins', 'public/css/plugins')
    // Others
    .copyDirectory('resources/others/favicon.png', 'public/images/')
    // Folders
    .copyDirectory('resources/others/emailTemplates/', 'public/emailTemplates/')
    .copyDirectory('resources/fonts', 'public/fonts/')
    .copyDirectory('resources/img', 'public/img');
    // .options({
    //     processCssUrls: false
    // });
