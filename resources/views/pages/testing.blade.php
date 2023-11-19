<?php

use function Livewire\Volt\{state};

state(['count' => 0]);

$increment = fn() => $this->count++;
$descrement = fn() => $this->count--;

?>
@volt
    <div>
        <h1>{{ $count }}</h1>
        <button wire:click="increment">+</button>
        <button wire:click="descrement">-</button>
    </div>
@endvolt
