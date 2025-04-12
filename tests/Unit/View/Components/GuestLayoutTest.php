<?php

namespace Tests\Unit\View\Components;

use App\View\Components\GuestLayout;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\View\View;
use Tests\TestCase;

class GuestLayoutTest extends TestCase
{
    /**
     * Test that the component renders the correct view.
     */
    public function test_component_renders_correct_view(): void
    {
        $component = new GuestLayout();
        
        $view = $component->render();
        
        $this->assertInstanceOf(View::class, $view);
        $this->assertEquals('components.layouts.guest', $view->getName());
    }
    
    /**
     * Test that the component can be rendered in a blade view.
     */
    public function test_component_can_be_rendered(): void
    {
        $view = $this->blade(
            '<x-guest-layout>Test Content</x-guest-layout>'
        );
        
        $view->assertSee('Test Content');
    }
    
    /**
     * Test that the component passes the title to the view.
     */
    public function test_component_can_receive_title(): void
    {
        $view = $this->blade(
            '<x-guest-layout>
                <x-slot name="title">Custom Title</x-slot>
                Content
            </x-guest-layout>'
        );
        
        $view->assertSee('Custom Title');
    }
} 