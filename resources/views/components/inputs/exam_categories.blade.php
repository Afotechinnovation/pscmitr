<select {{ $attributes->merge(['id' => 'exam_category_id', 'name' => 'exam_category_id', 'class' => 'form-control select2 ', 'data-placeholder' => 'Choose exam category']) }}>
    {{ $slot }}
</select>
<input id="{{ $attributes->get('id') }}-hidden" name="{{ $attributes->get('name') ?: 'exam_category_id' }}_text" type="hidden">

@push('js')
    <script>
        $(function() {
            'use strict';

            var id = '{{ $attributes->get('id') }}';
            var placeholder = '{{ $attributes->get('data-placeholder') ?? 'Choose exam category' }}';

            var $el = $('#'+ id);

            $el.select2({
                placeholder: placeholder,
                ajax: {
                    url: '{{ route('api.exam-categories.index') }}',
                    dataType: 'json',
                    delay: 250,
                    cache: true,
                    processResults: function (response, params) {
                        params.page = params.page || 1;

                        return {
                            results: $.map(response.data.data, function (item) {
                                return {
                                    text: item.name,
                                    id: item.id
                                }
                            }),
                            pagination: {
                                more: (params.page * response.data.per_page) == response.data.to
                            }
                        };
                    }
                }
            });

            var onChange = function () {
                $('#'+ id + '-hidden').val($el.find('option:selected').text());
            };

            $el.change(onChange);

            onChange();
        });
    </script>
@endpush
