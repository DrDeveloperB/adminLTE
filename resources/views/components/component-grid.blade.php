
@props(['type' => ''])

@if($type === 'styles')
    <!-- Bootstrap 4 - dataTables -->
    <link rel="stylesheet" href="{{ mix('css/dataTables.bootstrap4.css') }}">
{{--    <link rel="stylesheet" href="{{ mix('css/dataTables.fixedHeader.css') }}">--}}
{{--    <link rel="stylesheet" href="{{ mix('css/dataTables.fixedColumns.css') }}">--}}
@endif

@if($type === 'scripts')
    <!-- Bootstrap 4 - dataTables -->
    <script src="{{ mix('js/dataTables.js') }}"></script>
    <script src="{{ mix('js/dataTables.bootstrap4.js') }}"></script>
{{--    <script src="{{ mix('js/dataTables.editor.js') }}"></script>--}}
{{--    <script src="{{ mix('js/dataTables.fixedHeader.js') }}"></script>--}}
{{--    <script src="{{ mix('js/dataTables.fixedHeader.bootstrap4.js') }}"></script>--}}
@endif
