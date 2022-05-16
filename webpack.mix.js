const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix
    .postCss('resources/css/app.css', 'public/css', [
        //
    ])
    .sass('node_modules/admin-lte/node_modules/bootstrap/scss/bootstrap.scss', 'public/css/bootstrap.css')
    .sass('resources/sass/common.scss', 'public/css/common.css')
    // styles 로 믹스하면 폰트 복사가 안됨
    .postCss('node_modules/admin-lte/plugins/fontawesome-free/css/all.css', 'public/css/fontawesome.css')
    .postCss('node_modules/admin-lte/plugins/datatables-bs4/css/dataTables.bootstrap4.css', 'public/css/dataTables.bootstrap4.css')
    .postCss('node_modules/admin-lte/plugins/datatables-fixedheader/css/fixedHeader.bootstrap4.css', 'public/css/dataTables.fixedHeader.css')
    .postCss('node_modules/admin-lte/plugins/datatables-fixedcolumns/css/fixedColumns.bootstrap4.css', 'public/css/dataTables.fixedColumns.css')
    .postCss('node_modules/admin-lte/plugins/datatables-rowgroup/css/rowGroup.bootstrap4.css', 'public/css/dataTables.rowGroup.css')
    .postCss('node_modules/admin-lte/plugins/summernote/summernote-bs4.css', 'public/css/summernote.css')
    .js('resources/js/app.js', 'public/js')
    // .js(['resources/js/app.js', 'node_modules/admin-lte/plugins/bootstrap/js/bootstrap.bundle.js'], 'public/js/app.js')
    // .scripts(['node_modules/admin-lte/plugins/bootstrap/js/bootstrap.bundle.js', 'resources/js/common.js'], 'public/js/bootstrap.js')
    .scripts('node_modules/admin-lte/plugins/bootstrap/js/bootstrap.bundle.js', 'public/js/bootstrap.js')
    // .sourceMaps()
    // .scripts('node_modules/admin-lte/plugins/bootstrap-switch/js/bootstrap-switch.js', 'public/js/bootstrap-switch.js')
    .scripts('node_modules/admin-lte/plugins/datatables/jquery.dataTables.js', 'public/js/dataTables.js')
    .scripts('node_modules/admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.js', 'public/js/dataTables.bootstrap4.js')
    .scripts('node_modules/admin-lte/plugins/datatables-fixedheader/js/dataTables.fixedHeader.js', 'public/js/dataTables.fixedHeader.js')
    .scripts('node_modules/admin-lte/plugins/datatables-fixedheader/js/fixedHeader.bootstrap4.js', 'public/js/dataTables.fixedHeader.bootstrap4.js')
    // .scripts('node_modules/admin-lte/plugins/datatables-fixedcolumns/js/dataTables.fixedColumns.js', 'public/js/dataTables.fixedColumns.js')
    // .scripts('node_modules/admin-lte/plugins/datatables-fixedcolumns/js/fixedColumns.bootstrap4.js', 'public/js/dataTables.fixedColumns.bootstrap4.js')
    // .scripts('node_modules/admin-lte/plugins/datatables-rowgroup/js/dataTables.rowGroup.js', 'public/js/dataTables.rowGroup.js')
    // .scripts('node_modules/admin-lte/plugins/datatables-rowgroup/js/rowGroup.bootstrap4.js', 'public/js/dataTables.rowGroup.bootstrap4.js')
    // .scripts('node_modules/datatables.net-editor/js/dataTables.editor.js', 'public/js/dataTables.editor.js')
    .scripts('resources/js/datatable-editor.js', 'public/js/dataTables.editor.js')
    .scripts('node_modules/admin-lte/plugins/bs-custom-file-input/bs-custom-file-input.js', 'public/js/bs-custom-file-input.js')
    // .scripts(['node_modules/admin-lte/plugins/datatables/jquery.dataTables.js',
    //     'node_modules/admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.js'], 'public/js/dataTables.bootstrap4.js')
    .scripts('resources/js/common.js', 'public/js/common.js')
    .scripts('node_modules/admin-lte/plugins/summernote/summernote-bs4.js', 'public/js/summernote.js')
    // .sourceMaps()
    .scripts('node_modules/admin-lte/plugins/summernote/lang/summernote-ko-KR.js', 'public/js/summernote-ko-KR.js')
    .scripts('node_modules/admin-lte/plugins/jquery-validation/jquery.validate.js', 'public/js/jquery.validate.js')
    .scripts('node_modules/admin-lte/plugins/jquery-validation/additional-methods.js', 'public/js/additional-methods.js')
    .scripts('node_modules/admin-lte/plugins/jquery-validation/localization/messages_ko.js', 'public/js/messages_ko.js')
;
