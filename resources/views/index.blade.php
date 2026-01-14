@extends('layouts.frontend')

@section('content')
    @include('layouts.navbar')
    <main>
        <section class="mt-2">
            <div class="container">
                <div class="swiper-container swiper" id="swiper-1" data-pagination-type="" data-speed="400"
                    data-space-between="100" data-pagination="true" data-navigation="false" data-autoplay="true"
                    data-autoplay-delay="3000" data-effect="fade"
                    data-breakpoints='{"480": {"slidesPerView": 1}, "768": {"slidesPerView": 1}, "1024": {"slidesPerView": 1}}'>
                    <div class="swiper-wrapper pb-8">
                        <div class="swiper-slide"
                            style="
                  background: url({{ asset('frontend/src') }}/assets/images/banner/banner-main.png) no-repeat;
                  background-size: cover;
                  border-radius: 0.5rem;
                  background-position: center;
                ">
                            <div class="lg:py-32 p-12 lg:pl-12 xl:w-2/5 md:w-3/5">
                                <span
                                    class="inline-block p-2 text-sm align-baseline leading-none rounded-lg bg-yellow-500 text-gray-900 font-semibold">Shine
                                    Beauty Care </span>
                                <div class="my-7 flex flex-col gap-2">
                                    <h1 class="text-gray-900 text-xl lg:text-5xl font-bold leading-tight">
                                        Rawat Dirimu, Pancarkan Cantik Alami
                                    </h1>
                                    <p class="text-md font-light">
                                        Perawatan Profesional untuk Kecantikan Alami Anda.
                                    </p>
                                </div>                                                        
                                <a href="https://wa.me/6282117516161?text=Halo%20Admin%2C%20saya%20ingin%20konsultasi%20treatment" target="_blank"
                                    class="btn inline-flex items-center gap-x-2 bg-gray-800 text-white border-gray-800 disabled:opacity-50 disabled:pointer-events-none hover:text-white hover:bg-gray-900 hover:border-gray-900 active:bg-gray-900 active:border-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300">
                                    Hubungi Kami
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-tabler icon-tabler-arrow-right inline-block" width="14"
                                        height="14" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M5 12l14 0" />
                                        <path d="M13 18l6 -6" />
                                        <path d="M13 6l6 6" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <div class="swiper-slide"
                            style="
                  background: url({{ asset('frontend/src') }}/assets/images/banner/banner-main2.png) no-repeat;
                  background-size: cover;
                  border-radius: 0.5rem;
                  background-position: center;
                ">
                            <div class="lg:py-32 lg:pl-12 lg:pr-6 px-12 py-12 xl:w-2/5 md:w-3/5">
                                <span
                                    class="inline-block p-2 text-sm align-baseline leading-none rounded-lg bg-yellow-500 text-gray-900 font-semibold">Shine
                                    Beauty Care</span>
                                <div class="my-7 flex flex-col gap-2">
                                    <h2 class="text-gray-900 text-xl lg:text-5xl font-bold leading-tight">
                                        Klinik Kecantikan
                                        <br />
                                        Tepercaya untuk Hasil Nyata
                                    </h2>
                                    <p class="text-md font-light">
                                        <i>“Kecantikan Alami Dimulai dari Perawatan yang Tepat.”</i>
                                        Didukung dokter berpengalaman & teknologi modern.

                                    </p>
                                </div>
                                <a href="https://wa.me/6282117516161?text=Halo%20Admin%2C%20saya%20ingin%20konsultasi%20treatment" target="_blank"
                                    class="btn inline-flex items-center gap-x-2 bg-gray-800 text-white border-gray-800 disabled:opacity-50 disabled:pointer-events-none hover:text-white hover:bg-gray-900 hover:border-gray-900 active:bg-gray-900 active:border-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300">
                                    Hubungi Kami
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-tabler icon-tabler-arrow-right inline-block" width="14"
                                        height="14" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M5 12l14 0" />
                                        <path d="M13 18l6 -6" />
                                        <path d="M13 6l6 6" />
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <!-- Add more slides as needed -->
                    </div>
                    <!-- Add Pagination -->
                    <div class="swiper-pagination !bottom-14"></div>
                    <!-- Add Navigation -->
                    <div class="swiper-navigation">
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                </div>
            </div>
        </section>
        <section class="mt-8">
            <div class="container">
                <div class="flex flex-wrap">
                    <div class="w-full">
                        <h2 class="text-lg absolute z-10">Featured Categories</h2>
                    </div>
                </div>
                <div class="swiper-container swiper" id="swiper-1" data-pagination-type="" data-speed="400"
                    data-space-between="20" data-pagination="false" data-navigation="true" data-autoplay="true"
                    data-autoplay-delay="3000" data-effect="slide"
                    data-breakpoints='{"480": {"slidesPerView": 2}, "768": {"slidesPerView": 3}, "1024": {"slidesPerView": 6}}'>
                    <div class="swiper-wrapper py-12">
                        <div class="swiper-slide">
                            <a href="{{ route('index.product') }}">
                                <div
                                    class="relative rounded-lg break-words border bg-white border-gray-300 transition duration-75 hover:transition hover:duration-500 ease-in-out hover:border-green-600 hover:shadow-md">
                                    <div class="py-8 text-center">
                                        <img src="{{ asset('frontend/src') }}/assets/images/icons/produk-skin-care.png"
                                            class="mb-3 m-auto object-contain" style="width:100px;height:110px;" />
                                        <div class="text-base">Skin Care & Body Care</div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        
                        @foreach ($kategoritreatment as $item)
                            <div class="swiper-slide">
                                <a href="{{ route('index.treatment', ['slug'=> $item->slug]) }}">
                                    <div
                                        class="relative rounded-lg break-words border bg-white border-gray-300 transition duration-75 hover:transition hover:duration-500 ease-in-out hover:border-green-600 hover:shadow-md">
                                        <div class="py-8 text-center">
                                            <img src="{{ asset('storage/' . $item->file) }}"
                                                class="mb-3 m-auto object-contain" style="width:100px;height:110px;" />
                                            <div class="text-base">{{ Str::ucfirst($item->name) }}</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                    <!-- Add Pagination -->
                    <div class="swiper-pagination"></div>
                    <!-- Add Navigation -->
                    <div class="swiper-navigation">
                        <div class="swiper-button-next top-[28px]"></div>
                        <div class="swiper-button-prev top-[28px] !right-0 !left-auto mx-10"></div>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <div class="container">
                <div class="flex md:space-x-2 lg:space-x-6 flex-wrap md:flex-nowrap">
                    <div class="w-full md:w-1/2 mb-3 lg:">
                        <div class="py-10 px-8 rounded-lg"
                            style="
                  background: url({{ asset('frontend/src') }}/assets/images/banner/banner-middle.png)
                    no-repeat;
                  background-size: cover;
                  background-position: center;
                ">
                            <div class="flex flex-col gap-5">
                                <div class="flex flex-col gap-1">
                                    <h4 class="font-bold">Luxury Care for <br> Radiant Skin</h4>
                                </div>

                                <div class="flex flex-wrap">
                                    <a href="https://wa.me/6282117516161?text=Halo%20Admin%2C%20saya%20ingin%20konsultasi%20treatment" target="_blank"
                                        class="btn inline-flex items-center gap-x-2 bg-gray-800 text-white border-gray-800 disabled:opacity-50 disabled:pointer-events-none hover:text-white hover:bg-gray-900 hover:border-gray-900 active:bg-gray-900 active:border-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300">
                                        Hubungi Kami
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-full md:w-1/2">
                        <div class="py-10 px-8 rounded-lg"
                            style="
                  background: url({{ asset('frontend/src') }}/assets/images/banner/banner-middle2.png)
                    no-repeat;
                  background-size: cover;
                  background-position: center;
                ">
                            <div class="flex flex-col gap-5">
                                <div class="flex flex-col gap-1">
                                    <h2 class="font-bold text-xl">Exclusive Care for <br> Timeless Beauty.</h2>
                                </div>
                                <div class="flex flex-wrap">
                                    <a href="https://wa.me/6282117516161?text=Halo%20Admin%2C%20saya%20ingin%20konsultasi%20treatment" target="_blank"
                                        class="btn inline-flex items-center gap-x-2 bg-gray-800 text-white border-gray-800 disabled:opacity-50 disabled:pointer-events-none hover:text-white hover:bg-gray-900 hover:border-gray-900 active:bg-gray-900 active:border-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300">
                                        Hubungi Kami
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> <!-- Popular Products Start-->
        <section class="lg:my-14 my-8">
            <div class="container">
                <div class="flex flex-wrap">
                    <div class="w-full mb-6">
                        <h2 class="text-lg">Popular Products</h2>
                    </div>
                </div>

                <div class="grid gap-4 grid-cols-1 md:grid-cols-2 lg:gap-4 xl:grid-cols-5">

                    @foreach ($product as $item)
                        <div class="relative rounded-lg break-words border bg-white border-gray-300 card-product">
                            <div class="flex-auto p-4">
                                <div class="text-center relative flex justify-center">
                                    <div class="absolute top-0 left-0">
                                        <span
                                            class="inline-block p-1 text-center font-semibold text-sm align-baseline leading-none rounded bg-green-600 text-white">{{ $item->kategoriproduk->name }}</span>
                                    </div>
                                    <a href="#!"><img src="{{ asset('storage/' . $item->image) }}"
                                            style="width: 250px ; height:250px" /></a>

                                    <div class="absolute w-full bottom-[15%] opacity-0 invisible card-product-action">
                                        <a href="#!"
                                            class="h-[34px] w-[34px] leading-[34px] bg-white shadow inline-flex items-center justify-center rounded-lg hover:bg-green-600 hover:text-white"
                                            data-bs-toggle="tooltip" data-bs-html="true" title="Quick View">
                                            <span data-bs-toggle="modal" data-bs-target="#test{{ $item->id }}">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-eye" width="16"
                                                    height="16" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
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
                                        class="text-decoration-none text-gray-500"><small>{{ $item->kategoriproduk->name }}</small></a>
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
                        @include('layouts.modal')
                    @endforeach
                </div>
            </div>
        </section>
        <!-- Popular Products End-->

        <section class="lg:my-14 my-8">
            <div class="container">
                <div class="flex flex-wrap">
                    <div class="w-full mb-6">
                        <h2 class="text-lg">Popular Treatments</h2>
                    </div>
                </div>

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
                                            class="w-full h-auto" style="width: 250px ; height:250px"/></a>

                                    <div class="absolute w-full bottom-[15%] opacity-0 invisible card-product-action">
                                        <a href="#!"
                                            class="h-[34px] w-[34px] leading-[34px] bg-white shadow inline-flex items-center justify-center rounded-lg hover:bg-green-600 hover:text-white"
                                            data-bs-toggle="tooltip" data-bs-html="true" title="Quick View">
                                            <span data-bs-toggle="modal" data-bs-target="#treatment{{ $item->id }}">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="icon icon-tabler icon-tabler-eye" width="16"
                                                    height="16" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
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

        <section class="lg:my-14 my-8">
            <div class="container">
                <div class="flex flex-wrap gap-y-6">
                    <div class="md:w-1/2 lg:w-1/4 px-3">
                        <div class="flex flex-col gap-4">
                            <div class="inline-block">
                                <img src="{{ asset('frontend/src') }}/assets/images/icons/clock.svg" alt="" />
                            </div>
                            <div class="flex flex-col gap-2">
                                <h3 class="text-md">Perawatan Cepat & Efisien</h3>
                                <p>
                                    Nikmati layanan perawatan kecantikan dengan proses cepat, nyaman, dan tepat waktu tanpa
                                    harus menunggu lama.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="md:w-1/2 lg:w-1/4 px-3">
                        <div class="flex flex-col gap-4">
                            <div class="inline-block">
                                <img src="{{ asset('frontend/src') }}/assets/images/icons/gift.svg" alt="" />
                            </div>
                            <div class="flex flex-col gap-2">
                                <h3 class="text-md">Harga Terbaik & Promo Menarik</h3>
                                <p>
                                    Dapatkan perawatan berkualitas dengan harga kompetitif, dilengkapi berbagai promo dan
                                    paket hemat setiap bulan.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="md:w-1/2 lg:w-1/4 px-3">
                        <div class="flex flex-col gap-4">
                            <div class="inline-block">
                                <img src="{{ asset('frontend/src') }}/assets/images/icons/package.svg" alt="" />
                            </div>
                            <div class="flex flex-col gap-2">
                                <h3 class="text-md">Perawatan Lengkap & Profesional</h3>
                                <p>
                                    Tersedia beragam treatment wajah, kulit, dan tubuh yang ditangani oleh tenaga
                                    profesional dengan teknologi modern.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="md:w-1/2 lg:w-1/4 px-3">
                        <div class="flex flex-col gap-4">
                            <div class="inline-block">
                                <img src="{{ asset('frontend/src') }}/assets/images/icons/refresh-cw.svg"
                                    alt="" />
                            </div>
                            <div class="flex flex-col gap-2">
                                <h3 class="text-md">Aman & Konsultasi Fleksibel</h3>
                                <p>
                                    Tidak cocok dengan treatment? Konsultasikan kembali dengan dokter kami untuk solusi
                                    terbaik sesuai kondisi kulit Anda.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
