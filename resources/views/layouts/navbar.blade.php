<header>
    <!-- navbar -->
    <div class="border-b">

        <div class="pt-5">
            <div class="container">
                <div class="flex flex-wrap w-full items-center justify-between">
                    <div class="lg:w-1/6 md:w-1/2 w-2/5">

                    </div>
                    <div class="lg:w-2/5 hidden lg:block">

                    </div>
                    <div class="lg:w-1/5 hidden lg:block">

                    </div>
                    <div class="lg:w-1/5 text-end md:w-1/2 w-3/5">
                        <div class="flex gap-7 items-center justify-end">
                            <div class="lg:hidden leading-none">
                                <!-- Button -->
                                <button class="collapsed" type="button" data-bs-toggle="offcanvas"
                                    data-bs-target="#navbar-default" aria-controls="navbar-default"
                                    aria-label="Toggle navigation">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="icon icon-tabler icon-tabler-menu-2 text-gray-800" width="24"
                                        height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M4 6l16 0" />
                                        <path d="M4 12l16 0" />
                                        <path d="M4 18l16 0" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <nav class="navbar relative navbar-expand-lg lg:flex lg:flex-wrap items-center content-between text-black navbar-default"
            aria-label="Offcanvas navbar large">
            <div class="container max-w-7xl mx-auto w-full xl:px-4 lg:px-0">
                <div class="offcanvas offcanvas-left lg:visible" tabindex="-1" id="navbar-default">
                    <div class="offcanvas-body lg:flex lg:items-center">
                        <div>
                            <ul class="navbar-nav lg:flex gap-3 lg:items-center">
                                <li class="nav-item dropdown w-full lg:w-auto">
                                    <a href="{{ route('index') }}"><img
                                            src="{{ asset('frontend/src') }}/assets/images/logo/shine.png" width="70px"/></a>
                                </li>

                                <li class="nav-item dropdown w-full lg:w-auto">
                                    <a class="nav-link" href="{{ route('index') }}" role="button">Home</a>
                                </li>
                                <li class="nav-item dropdown w-full lg:w-auto">
                                    <a class="nav-link dropdown-toggle" href="#" role="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">Treatment</a>
                                    <ul class="dropdown-menu">
                                        @foreach ($kategoritreatment as $item)
                                            <li>
                                                <a class="dropdown-item" href="{{ route('index.treatment', ['slug'=>$item->slug]) }}">{{Str::ucfirst($item->name)}}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>

                                <li class="nav-item dropdown w-full lg:w-auto dropdown-fullwidth">
                                    <a class="nav-link" href="{{ route('index.product') }}">Produk Kecantikan </a>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</header>
