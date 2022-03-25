<select {{ $attributes->merge(['id' => 'state_id', 'name' => 'state_id', 'class' => 'form-control select2 ', 'data-placeholder' => 'Choose State']) }}>
    {{ $slot }}
</select>
<input id="{{ $attributes->get('id') }}-hidden" name="{{ $attributes->get('name') ? rtrim($attributes->get('name'), '[]') : 'state' }}_text" type="hidden">

@push('js')
    <script>
        $(function() {
            'use strict';

            var id = '{{ $attributes->get('id') }}';
            var placeholder = '{{ $attributes->get('data-placeholder') ?? 'Choose State' }}';
            var related = '{{ $attributes->get('related') }}';

            var $el = $('#'+ id);

            $el.select2({
                placeholder: placeholder,
                ajax: {
                    url: '{{ route('api.states.index') }}',
                    data: function (params) {
                        if(related) {
                            var name = $(related).attr('name');
                            params[name] = $(related).val();
                        }

                        params.q = params.term;
                        return params;
                    },
                    dataType: 'json',
                    delay: 250,
                    cache: true,
                    processResults: function (response, params) {
                        if(response.data == null){
                            return null;
                        }
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
                let isMulitple = $el.is('[multiple]');

                if (isMulitple) {
                    let values = $.map($el.find('option:selected'), function (selected) {
                        return {id: selected.value, name: selected.text};
                    });

                    $('#'+ id + '-hidden').val(JSON.stringify(values));
                    return;
                }

                $('#'+ id + '-hidden').val($el.find('option:selected').text());
            };

            $el.change(onChange);

            $(document).on('change', related, function () {
                $el.val(null);
                $el .trigger('change');
            });

            onChange();
        });
    </script>
@endpush
