@extends('layouts.master')

@section('title', 'Rólunk')

@section('header', 'Rólunk')

@section('content')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Rólunk') }}
        </h2>   
    </x-slot>

    <div class="about_us">
        <h1 class="text-2xl font-semibold text-black">Ecotrips</h1>
        <br>
        <p class="text-lg text-gray-700 mb-6">
            Üdvözlünk az <strong>Ecotrips</strong>-nél! Célunk, hogy segítsünk neked 
            felfedezni a természet szépségeit, megismerni lenyűgöző látványosságokat, 
            és egyedi túrákat létrehozni, amelyek örök emlékek maradnak.
        </p>

        <h2 class="text-2xl font-semibold text-black">Küldetésünk</h2>
        <p class="text-gray-700 mb-6">
            Hiszünk abban, hogy a természetjárás és a túrázás nemcsak kikapcsolódás, hanem egy életforma is. 
            Az <strong>Ecotrips</strong> segítségével saját túrákat tervezhetsz, felfedezheted a környezeted 
            rejtett kincseit, és megoszthatod élményeidet más természetkedvelőkkel.
        </p>

        <h2 class="text-2xl font-semibold text-black mb-3">Mit kínálunk?</h2>
        <ul class="list-disc list-inside text-gray-700 mb-6">
            <li>Könnyen használható túratervező eszköz</li>
            <li>Részletes információk látványosságokról</li>
            <li>Közösségi funkciók, hogy megoszthasd tapasztalataidat</li>
            <li>Környezettudatos utazási tippek</li>
        </ul>

        <h2 class="text-2xl font-semibold text-black mb-3">Csatlakozz hozzánk!</h2>
        <p class="text-gray-700">
            Fedezd fel a világot velünk, és hozd létre saját felejthetetlen túráidat!
            Legyél részese egy természetkedvelő közösségnek, és oszd meg kalandjaidat másokkal.
        </p>
        <img src="https://gt.stud.vts.su.ac.rs/Turist/img/rolunk.jpg">
        <h2 class="text-2xl font-semibold text-black mb-3">Partnereink</h2>
        <ul class="list-disc list-inside text-gray-700 mb-6">
            <li>GreenTech Solutions</li>
            <li>Skyline Ventures</li>
            <li>BlueWave Innovations</li>
            <li>QuantumSoft</li>
            <li>Future Foods</li>
            <li>SmartEnergy Systems</li>
            <li>TechLink Industries</li>
        </ul>
    </div>
	
</x-app-layout>
@endsection
