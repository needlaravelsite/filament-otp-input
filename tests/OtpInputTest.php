<?php

namespace NeedLaravelSite\FilamentOtpInput\Tests;

use NeedLaravelSite\ContactForm\Tests\TestCase;
use NeedLaravelSite\FilamentOtpInput\Components\OtpInput;

class OtpInputTest extends TestCase
{
    /** @test */
    public function it_can_render()
    {
        $component = OtpInput::make('otp');

        $this->assertInstanceOf(OtpInput::class, $component);
    }

    /** @test */
    public function it_has_default_4_inputs()
    {
        $component = OtpInput::make('otp');

        $this->assertEquals(4, $component->getNumberInputs());
    }

    /** @test */
    public function it_can_set_custom_number_of_inputs()
    {
        $component = OtpInput::make('otp')->numberInput(6);

        $this->assertEquals(6, $component->getNumberInputs());
    }

    /** @test */
    public function it_can_be_set_to_password_type()
    {
        $component = OtpInput::make('otp')->password();

        $this->assertEquals('password', $component->getInputType());
    }
}
