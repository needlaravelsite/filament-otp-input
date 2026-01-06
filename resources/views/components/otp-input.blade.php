@php
    $id = $getId();
    $isDisabled = $isDisabled();
    $statePath = $getStatePath();
    $numberInputs = $getNumberInputs();
    $inputType = $getInputType();
    $autoFocus = $hasAutoFocus();
@endphp

<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <div
        x-data="otpInputComponent({
            state: $wire.{{ $applyStateBindingModifiers("\$entangle('{$statePath}')") }},
            numberInputs: {{ $numberInputs }},
            disabled: {{ $isDisabled ? 'true' : 'false' }},
            autoFocus: {{ $autoFocus ? 'true' : 'false' }}
        })"
        x-on:otp-complete.window="$event.detail.id === '{{ $id }}' && $wire.call('$refresh')"
        class="flex gap-2"
    >
        @for ($i = 0; $i < $numberInputs; $i++)
            <input
                x-ref="input{{ $i }}"
                type="{{ $inputType }}"
                inputmode="numeric"
                maxlength="1"
                x-model="inputs[{{ $i }}]"
                x-on:input="handleInput({{ $i }}, $event)"
                x-on:keydown="handleKeydown({{ $i }}, $event)"
                x-on:paste="handlePaste($event)"
                x-bind:disabled="disabled"
                {{ $i === 0 && $autoFocus ? 'autofocus' : '' }}
                class="w-12 h-12 text-center text-lg font-semibold border-2 rounded-lg
                       focus:border-primary-500 focus:ring-2 focus:ring-primary-500/20
                       dark:bg-gray-800 dark:border-gray-600 dark:text-white
                       disabled:opacity-50 disabled:cursor-not-allowed
                       transition-all duration-200"
            />
        @endfor
    </div>
</x-dynamic-component>

@pushOnce('scripts')
    <script>
        function otpInputComponent({ state, numberInputs, disabled, autoFocus }) {
            return {
                inputs: Array(numberInputs).fill(''),
                state: state,
                numberInputs: numberInputs,
                disabled: disabled,

                init() {
                    // Initialize inputs from state
                    if (this.state) {
                        const stateStr = String(this.state);
                        this.inputs = stateStr.split('').slice(0, numberInputs);

                        // Fill remaining with empty strings
                        while (this.inputs.length < numberInputs) {
                            this.inputs.push('');
                        }
                    }

                    // Watch for state changes
                    this.$watch('inputs', () => {
                        this.updateState();
                    });

                    // Auto-focus first input if enabled
                    if (autoFocus && !disabled) {
                        this.$nextTick(() => {
                            this.$refs.input0?.focus();
                        });
                    }
                },

                handleInput(index, event) {
                    const value = event.target.value;

                    // Only allow single digit/character
                    if (value.length > 1) {
                        this.inputs[index] = value.slice(-1);
                        event.target.value = this.inputs[index];
                    } else {
                        this.inputs[index] = value;
                    }

                    // Move to next input if value entered
                    if (value && index < this.numberInputs - 1) {
                        this.$refs[`input${index + 1}`]?.focus();
                    }

                    this.updateState();
                },

                handleKeydown(index, event) {
                    // Handle backspace
                    if (event.key === 'Backspace') {
                        if (!this.inputs[index] && index > 0) {
                            // Move to previous input if current is empty
                            this.$refs[`input${index - 1}`]?.focus();
                        } else {
                            // Clear current input
                            this.inputs[index] = '';
                        }
                        this.updateState();
                    }

                    // Handle arrow keys
                    if (event.key === 'ArrowLeft' && index > 0) {
                        event.preventDefault();
                        this.$refs[`input${index - 1}`]?.focus();
                    }

                    if (event.key === 'ArrowRight' && index < this.numberInputs - 1) {
                        event.preventDefault();
                        this.$refs[`input${index + 1}`]?.focus();
                    }
                },

                handlePaste(event) {
                    event.preventDefault();
                    const pastedData = event.clipboardData.getData('text');
                    const pastedChars = pastedData.replace(/\s/g, '').split('');

                    // Fill inputs with pasted data
                    pastedChars.forEach((char, i) => {
                        if (i < this.numberInputs) {
                            this.inputs[i] = char;
                        }
                    });

                    // Focus last filled input or first empty input
                    const focusIndex = Math.min(pastedChars.length, this.numberInputs - 1);
                    this.$refs[`input${focusIndex}`]?.focus();

                    this.updateState();
                },

                updateState() {
                    const code = this.inputs.join('');
                    this.state = code;

                    // Check if all inputs are filled
                    if (this.inputs.every(input => input !== '')) {
                        // Dispatch event when OTP is complete
                        this.$nextTick(() => {
                            this.$dispatch('otp-complete', {
                                code: code,
                                id: '{{ $id }}'
                            });
                        });
                    }
                }
            }
        }
    </script>
@endPushOnce
