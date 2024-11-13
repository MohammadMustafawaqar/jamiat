@props([
    'id' => 'qamari-date',
    'name' => '',
    'col' => 'col-sm-6',
    'err_msg' => __('messages.invalid_date'),
    'classes' => '',
    'format' => 'کال-میاشت-ورځ',
    'label' => '',
    'required' => 0,
    'value' => ''
])
<div class="{{ $col }}">
    <div class="form-group">
        @if ($label != '')
            <label class="mb-0" for="{{ $id == '' ? $name : $id }}">{{ $label }} {!! $required == 1
                ? '<i
                            class="text-danger">*</i>'
                : '' !!}</label>
        @endif
        <input class="form-control {{ $classes }} @error($name) is-invalid @enderror" type="text"
            id={{ $id == '' ? $name : $id }} name="{{ $name }}" value="yyyy-mm-dd"
            key="{{ $name }}"
            value="{{ $value }}"
            >
        <div id="error-message" style="color:red;"></div>
        @error($name)
            <span id="{{ $id == '' ? $name : $id }}-error" class="error invalid-feedback">{{ $message }}</span>
        @enderror
    </div>
</div>

@push('scripts')
    <script>
        console.log('working fine')
        $(document).ready(function() {
            const dateInput = $('#{{ $id }}');
            const errorMessage = $('#error-message');
            const initialValue = "{{ $format }}";
            const maxDateLength = 10;

            // Set the initial value to 'yyyy-mm-dd'
            dateInput.val(initialValue);

            // Handle keydown events for Backspace
            dateInput.on('keydown', function(e) {
                const key = e.key;

                // Allow only Backspace and numeric keys
                if (key === 'Backspace') {
                    e.preventDefault();
                    handleBackspace();
                } else if (key >= '0' && key <= '9') {
                    // Let the input event handle number insertion
                } else {
                    e.preventDefault(); // Prevent non-numeric and non-backspace keys
                }
            });

            // Handle input events (for inserting digits)
            dateInput.on('input', function() {
                let inputVal = $(this).val().replace(/[^0-9]/g, ''); // Get only digits
                let formattedDate = "{{ $format }}".split(''); // Create a template for the date

                // Insert digits into the formatted date, skipping the '-'
                let inputIndex = 0;
                for (let i = 0; i < formattedDate.length; i++) {
                    if (formattedDate[i] === 'y' || formattedDate[i] === 'm' || formattedDate[i] === 'd') {
                        if (inputIndex < inputVal.length) {
                            formattedDate[i] = inputVal[inputIndex]; // Replace placeholder with digit
                            inputIndex++;
                        }
                    }
                }

                // Set the new formatted value
                $(this).val(formattedDate.join(''));

                // Validate the date when all digits are entered
                if (inputVal.length === maxDateLength - 2) { // Exclude the '-'
                    const year = parseInt(inputVal.slice(0, 4), 10);
                    const month = parseInt(inputVal.slice(4, 6), 10);
                    const day = parseInt(inputVal.slice(6, 8), 10);

                    if (!isValidQamariDate(year, month, day)) {
                        errorMessage.text("{{ $err_msg }}");
                        dateInput.addClass('is-invalid')
                        $(this).val(initialValue); // Reset to 'yyyy-mm-dd'
                    } else {
                        errorMessage.text(''); // Clear any previous errors
                        dateInput.removeClass('is-invalid')
                        dateInput.addClass('is-valid')
                    }
                }
            });

            // Custom function to handle Backspace key behavior
            function handleBackspace() {
                let currentValue = dateInput.val();
                let digits = currentValue.replace(/[^0-9]/g, ''); // Remove non-digit characters

                if (digits.length > 0) {
                    digits = digits.slice(0, -1); // Remove the last digit

                    // Rebuild the formatted value by placing digits in the correct spots
                    let formattedDate = "{{ $format }}".split('');
                    let inputIndex = 0;
                    for (let i = 0; i < formattedDate.length; i++) {
                        if (formattedDate[i] === 'y' || formattedDate[i] === 'm' || formattedDate[i] === 'd') {
                            if (inputIndex < digits.length) {
                                formattedDate[i] = digits[inputIndex];
                                inputIndex++;
                            }
                        }
                    }

                    // Update the input field with the new formatted value
                    dateInput.val(formattedDate.join(''));
                }
            }

            // Qamari date validation function
            function isValidQamariDate(year, month, day) {
                // Validate year (1-1500)
                if (year < 1300 || year > 1500) {
                    return false;
                }

                // Validate month (1-12)
                if (month < 1 || month > 12) {
                    return false;
                }

                // Validate day (1-30)
                if (day < 1 || day > 30) {
                    return false;
                }

                return true;
            }
        });
    </script>
@endpush
