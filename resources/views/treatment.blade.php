@extends('layouts.frontend')

@section('content')
    @include('layouts.navbar')
    <main>
        <!-- Popular Products Start-->
        <section class="lg:my-14 my-8">
            <div class="container">
                <ol class="flex items-center whitespace-nowrap p-2 border-y border-gray-200 dark:border-neutral-700">
                    <li class="inline-flex items-center">
                        <a class="flex items-center text-sm text-gray-500 hover:text-blue-600 focus:outline-hidden focus:text-blue-600 dark:text-neutral-500 dark:hover:text-blue-500 dark:focus:text-blue-500"
                            href="{{ route('index') }}">
                            <svg class="shrink-0 me-3 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                            Home
                        </a>
                        <svg class="shrink-0 mx-2 size-4 text-gray-400 dark:text-neutral-600"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="m9 18 6-6-6-6"></path>
                        </svg>
                    </li>
                    <li class="inline-flex items-center">
                        <a class="flex items-center text-sm text-gray-500 hover:text-blue-600 focus:outline-hidden focus:text-blue-600 dark:text-neutral-500 dark:hover:text-blue-500 dark:focus:text-blue-500"
                            href="#">
                            <svg class="shrink-0 me-3 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <rect width="7" height="7" x="14" y="3" rx="1"></rect>
                                <path
                                    d="M10 21V8a1 1 0 0 0-1-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-5a1 1 0 0 0-1-1H3">
                                </path>
                            </svg>
                            Treatment </a>
                    </li>                   
                </ol>

                <br>

                <div class="grid gap-4 grid-cols-1 md:grid-cols-2 lg:gap-4 xl:grid-cols-5">

                    @foreach ($treatment as $item)
                        <div class="relative rounded-lg break-words border bg-white border-gray-300 card-product">
                            <div class="flex-auto p-4">
                                <div class="text-center relative flex justify-center">
                                    <div class="absolute top-0 left-0">
                                        <span
                                            class="inline-block p-1 text-center font-semibold text-sm align-baseline leading-none rounded bg-green-600 text-white">{{ $item->kategoritreatment->name }}</span>
                                    </div>
                                    <a href="#!"><img src="{{ asset('storage/' . $item->gambar) }}"
                                            style="width: 250px ; height:250px" /></a>

                                    <div class="absolute w-full bottom-[15%] opacity-0 invisible card-product-action">
                                        <a href="#!"
                                            class="h-[34px] w-[34px] leading-[34px] bg-white shadow inline-flex items-center justify-center rounded-lg hover:bg-green-600 hover:text-white"
                                            data-bs-toggle="tooltip" data-bs-html="true" title="Quick View">
                                            <span data-bs-toggle="modal" data-bs-target="#treatment{{ $item->id }}">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-eye" width="16" height="16"
                                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                    <path
                                                        d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                                </svg>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-3">
                                    <a href="#!"
                                        class="text-decoration-none text-gray-500"><small>{{ $item->kategoritreatment->name }}</small></a>
                                    <div class="flex flex-col gap-2">
                                        <h3 class="text-base truncate">
                                            <a href="#!">{{ Str::ucfirst($item->nama) }}</a>
                                        </h3>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <span class="text-gray-900 font-semibold">Rp
                                                {{ number_format($item->harga, 0, ',', '.') }}</span>
                                        </div>
                                        <div>
                                            <a href="https://wa.me/6282117516161?text=Halo%20Admin%2C%20saya%20ingin%20konsultasi%20treatment" target="_blank"
                                                class="btn inline-flex items-center gap-x-1 bg-green-600 text-white border-green-600 disabled:opacity-50 disabled:pointer-events-none hover:text-white hover:bg-green-700 hover:border-green-700 active:bg-green-700 active:border-green-700 focus:outline-none focus:ring-4 focus:ring-green-300 btn-sm">
                                                <span>Hubungi Kami</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @include('layouts.modaltreatment')
                    @endforeach
                </div>
            </div>
        </section>
    </main>
@endsection
