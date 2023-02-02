<x-layout>
    <x-slot name="header">
        {{ __('Home') }}
    </x-slot>

    <x-panel>
        <x-splade-defer url="http://api.quotable.io/random">
            <p v-text="response.content" />
            <p v-if="processing">Processing...</p>
            <button @click="reload">Reload</button>
        </x-splade-defer>
    </x-panel>
</x-layout>
