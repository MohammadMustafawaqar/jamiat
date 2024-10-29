<div class="col-md-12">
    <div class="d-flex justify-content-between">
        <div class="form-check">
            <label class="form-check-label">
                <input class="form-check-input" type="checkbox" id="checkAll">{{ __('lang.check_all') }}
            </label>
        </div>
        <button type="submit" class="btn btn-primary">{{ __('lang.give_permissions') }}</button>

    </div>
    <hr>
</div>

@foreach ($permissions as $item)
    @if (strpos($item->name, '*') == true)
        @if (!$loop->first)
            </div>
            </div>
        @endif
        <div class="col-lg-6 col-xl-4">
            <div class="list-group mb-3 card-equal">
                <li class="list-group-item list-group-item-action" style="background-color: lightblue;">

                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input checkbox subCheckAll" type="checkbox" name="permissions[]"
                                value="{{ $item->name }}"
                                @if ($role->hasPermissionTo($item->name)) checked @endif>{{ $item->name }}
                        </label>
                    </div>
                </li>
    @else
                <li class="list-group-item list-group-item-action">
                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input checkbox" type="checkbox" name="permissions[]"
                                value="{{ $item->name }}"
                                @if ($role->hasPermissionTo($item->name)) checked @endif>{{ $item->name }}
                        </label>
                    </div>
                </li>
    @endif
@endforeach

<script>
    // Check All checkbox change event handler
    $('#checkAll').change(function() {
        $('.checkbox').prop('checked', $(this).prop('checked'));
    });

    // Individual checkbox change event handler
    $('.checkbox').change(function() {
        // If all checkboxes are checked, check the Check All checkbox
        if ($('.checkbox:checked').length === $('.checkbox').length) {
            $('#checkAll').prop('checked', true);
        } else {
            $('#checkAll').prop('checked', false);
        }
    });
    $('.subCheckAll').change(function() {
        var chkVal = $(this).val();
        var valPrefix = chkVal.split('.')[0];
        var isChecked = $(this).prop('checked');
        $('.checkbox').each(function() {
            var checkboxValuePrefix = $(this).val().split('.')[0];

            if (checkboxValuePrefix == valPrefix) {
                $(this).prop('checked', isChecked);
            }
        });
    });
</script>
