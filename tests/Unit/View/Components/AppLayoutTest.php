<?php

namespace Tests\Unit\View\Components;

use App\View\Components\AppLayout;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\View\View;
use Tests\TestCase;

class AppLayoutTest extends TestCase
{
    /**
     * Test that the component renders the correct view.
     */
    public function test_component_renders_correct_view(): void
    {
        $component = new AppLayout();
        
        $view = $component->render();
        
        $this->assertInstanceOf(View::class, $view);
        $this->assertEquals('components.layouts.app', $view->getName());
    }
    
    /**
     * Test that the component can be rendered in a blade view.
     */
    public function test_component_can_be_rendered(): void
    {
        $view = $this->blade(
            '<x-app-layout>Test Content</x-app-layout>'
        );
        
        $view->assertSee('Test Content');
    }
    
    /**
     * Test that the component passes the title to the view.
     */
    public function test_component_can_receive_title(): void
    {
        $view = $this->blade(
            '<x-app-layout>
                <x-slot name="title">Custom Title</x-slot>
                Content
            </x-app-layout>'
        );
        
        $view->assertSee('Custom Title');
    }
    
    /**
     * Test that the component renders the header slot.
     */
    public function test_component_renders_header_slot(): void
    {
        $view = $this->blade(
            '<x-app-layout>
                <x-slot name="header">Header Content</x-slot>
                Page Content
            </x-app-layout>'
        );
        
        $view->assertSee('Header Content');
        $view->assertSee('Page Content');
    }
} 