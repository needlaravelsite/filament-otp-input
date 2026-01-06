<?php
namespace NeedLaravelSite\FilamentOtpInput\Components;

use Filament\Forms\Components\Field;

class OtpInput extends Field
{
    protected string $view = 'filament-otp-input::components.otp-input';

    protected int $numberInputs = 4;

    protected string $inputType = 'number';

    protected bool $autoFocus = true;

    /**
     * Set the number of OTP input fields
     */
    public function numberInput(int $count): static
    {
        $this->numberInputs = $count;

        return $this;
    }

    /**
     * Get the number of inputs
     */
    public function getNumberInputs(): int
    {
        return $this->numberInputs;
    }

    /**
     * Set input type to password
     */
    public function password(): static
    {
        $this->inputType = 'password';

        return $this;
    }

    /**
     * Set input type to text
     */
    public function text(): static
    {
        $this->inputType = 'text';

        return $this;
    }

    /**
     * Get the input type
     */
    public function getInputType(): string
    {
        return $this->inputType;
    }

    /**
     * Disable auto focus on first input
     */
    public function disableAutoFocus(): static
    {
        $this->autoFocus = false;

        return $this;
    }

    /**
     * Check if auto focus is enabled
     */
    public function hasAutoFocus(): bool
    {
        return $this->autoFocus;
    }

    /**
     * Set up the component
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->dehydrateStateUsing(function ($state): ?string {
            if (is_array($state)) {
                return implode('', $state);
            }

            return $state;
        });
    }
}
