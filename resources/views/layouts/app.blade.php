@props(['title' => '', 'bodyClass' => null, 'footerLinks' => ''])

<x-base-layout :$title :$bodyClass>
    <x-layouts.header />

    @session('success')
        <div class="container my-large">
            <div class="success-message">
                {{ session('success') }}
            </div>
        </div>
    @endsession

    @session('warning')
        <div class="container my-large">
            <div class="warning-message">
                {{ session('warning') }}
            </div>
        </div>
    @endsession

    {{ $slot }}
</x-base-layout>
