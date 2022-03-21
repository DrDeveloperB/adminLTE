
@props(['type' => ''])

{{--@if($type === 'styles')--}}
{{--@endif--}}

@if($type === 'scripts')
    <!-- jQuery Validation -->
    <script src="{{ mix('js/jquery.validate.js') }}"></script>
    <script src="{{ mix('js/additional-methods.js') }}"></script>
    <script src="{{ mix('js/messages_ko.js') }}"></script>
@endif
