<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Aethra Organizer</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-900 font-sans">

    <header
        class="fixed top-0 left-0 right-0 z-50 bg-gray-800 flex items-center justify-between py-4 px-6 md:px-[9%] shadow-lg">
        <a href="#" class="flex items-center space-x-3 text-white text-2xl font-bold">
            <img src="{{ asset('images/logoaethra.png') }}" alt="Aethra Logo" class="h-11 w-11 object-contain">
            <span><span>A</span>ETHRA <span class="text-primary">ORGANIZER</span></span>
        </a>

        {{-- Navigasi untuk Desktop --}}
        <nav id="navbar" class="hidden lg:flex items-center space-x-6">
            <a href="#home" class="text-lg text-white hover:text-primary transition-colors duration-200">Home</a>
            <a href="#service" class="text-lg text-white hover:text-primary transition-colors duration-200">Service</a>
            <a href="#about" class="text-lg text-white hover:text-primary transition-colors duration-200">About</a>
            <a href="#gallery" class="text-lg text-white hover:text-primary transition-colors duration-200">Gallery</a>
            <a href="#price" class="text-lg text-white hover:text-primary transition-colors duration-200">Price</a>
            <a href="#review" class="text-lg text-white hover:text-primary transition-colors duration-200">Review</a>
            <a href="#contact" class="text-lg text-white hover:text-primary transition-colors duration-200">Contact</a>
            @can('admin')
                {{-- Tautan Admin --}}
                <a href="{{ route('admin.dashboard') }}"
                    class="text-lg text-white hover:text-primary transition-colors duration-200">Dashboard</a>
            @endcan
            {{-- Di dalam <nav>, sebelum dropdown profil --}}
            @auth
                <div class="relative ms-3">
                    {{-- Tombol Lonceng --}}
                    <button id="notification-bell-button" type="button"
                        class="relative inline-flex items-center p-2 text-sm font-medium text-center text-gray-400 hover:text-white focus:outline-none">
                        <i class="fas fa-bell fa-lg"></i>
                        <span class="sr-only">Notifications</span>
                        @if (auth()->user()->unreadNotifications->count())
                            <div id="notification-badge"
                                class="absolute inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 border-2 border-gray-800 rounded-full -top-1 -end-1">
                                {{ auth()->user()->unreadNotifications->count() }}
                            </div>
                        @endif
                    </button>

                    <div id="notification-dropdown"
                        class="hidden absolute right-0 mt-2 w-80 md:w-96 origin-top-right bg-white dark:bg-gray-800 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-50">
                        <div
                            class="p-3 font-bold text-gray-700 dark:text-gray-200 border-b dark:border-gray-700 flex justify-between items-center">
                            <span>Notifikasi</span>
                            <button id="mark-all-read-button"
                                class="text-xs font-medium text-blue-600 dark:text-blue-500 hover:underline">Tandai semua
                                sudah dibaca</button>
                        </div>
                        <div id="notification-list"
                            class="divide-y divide-gray-100 dark:divide-gray-700 max-h-80 overflow-y-auto">
                            @forelse(auth()->user()->unreadNotifications as $notification)
                                <a href="{{ $notification->data['url'] }}?notify_id={{ $notification->id }}"
                                    class="block px-4 py-3 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <p class="font-semibold">{{ $notification->data['message'] }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                        {{ $notification->created_at->diffForHumans() }}</p>
                                </a>
                            @empty
                                <div class="p-4 text-sm text-center text-gray-500 dark:text-gray-400">Tidak ada notifikasi
                                    baru.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            @endauth
            {{-- Spacer untuk mendorong menu profil ke kanan --}}
            <div class="w-px h-6 bg-gray-600 mx-2"></div>

            {{-- Cek Otentikasi Pengguna --}}
            @auth
                {{-- Jika SUDAH login, tampilkan menu profil --}}
                <div class="relative" id="desktop-profile-container">
                    <button id="desktop-profile-button" class="flex items-center focus:outline-none">
                        <img class="h-9 w-9 rounded-full object-cover"
                            src="{{ Auth::user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=random' }}"
                            alt="{{ Auth::user()->name }}">
                    </button>

                    <div id="desktop-profile-dropdown"
                        class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50 py-1">
                        <div class="px-4 py-2 text-sm text-gray-700">
                            <div class="font-medium">{{ Auth::user()->name }}</div>
                            <div class="text-xs text-gray-500">{{ Auth::user()->email }}</div>
                        </div>
                        <hr class="my-1">
                        <a href="{{ route('profile.edit') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            Profile
                        </a>
                        <a href="{{ route('my-transactions') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            Transaksi Saya
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); this.closest('form').submit();"
                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Sign Out
                            </a>
                        </form>
                    </div>
                </div>
            @else
                {{-- Jika BELUM login, tampilkan tombol Sign In --}}
                <a href="{{ route('login') }}"
                    class="text-lg text-white bg-primary py-2 px-4 rounded-md hover:bg-opacity-90 transition-colors duration-200">
                    Sign In
                </a>
            @endguest
        </nav>

        {{-- Ikon Menu untuk Mobile --}}
        <div id="menu-bars" class="text-white text-3xl cursor-pointer lg:hidden">
            <i class="fas fa-bars"></i>
        </div>
    </header>

    {{-- SCRIPT GABUNGAN: Tambahkan ini di bagian bawah halaman Anda (jika belum ada) --}}
    {{-- Script ini sudah menangani menu mobile DAN desktop --}}


    <div id="mobile-menu" class="hidden lg:hidden fixed top-16 left-0 right-0 bg-gray-800 z-40 p-4">
        <a href="#home" class="block text-white text-lg py-2 px-4 hover:bg-primary rounded-md">Home</a>
        <a href="#service" class="block text-white text-lg py-2 px-4 hover:bg-primary rounded-md">Service</a>
        <a href="#about" class="block text-white text-lg py-2 px-4 hover:bg-primary rounded-md">About</a>
        <a href="#gallery" class="block text-white text-lg py-2 px-4 hover:bg-primary rounded-md">Gallery</a>
        <a href="#price" class="block text-white text-lg py-2 px-4 hover:bg-primary rounded-md">Price</a>
        <a href="#review" class="block text-white text-lg py-2 px-4 hover:bg-primary rounded-md">Review</a>
        <a href="#contact" class="block text-white text-lg py-2 px-4 hover:bg-primary rounded-md">Contact</a>

        @can('admin')
            {{-- Tautan Admin --}}
            <a href="{{ route('admin.dashboard') }}"
                class="block text-white text-lg py-2 px-4 hover:bg-primary rounded-md">Dashboard</a>
        @endcan
        {{-- Cek apakah pengguna sudah login --}}
        {{-- Di dalam <nav>, sebelum dropdown profil --}}
        @auth


            <div class="relative ms-3">
                {{-- Tombol Lonceng --}}
                <button id="notification-bell-button" type="button"
                    class="relative inline-flex items-center p-2 text-sm font-medium text-center text-gray-400 hover:text-white focus:outline-none">
                    <i class="fas fa-bell fa-lg"></i>
                    <span class="sr-only">Notifications</span>
                    @if (auth()->user()->unreadNotifications->count())
                        <div id="notification-badge"
                            class="absolute inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 border-2 border-gray-800 rounded-full -top-1 -end-1">
                            {{ auth()->user()->unreadNotifications->count() }}
                        </div>
                    @endif
                </button>

                <div id="notification-dropdown"
                    class="hidden absolute right-0 mt-2 w-80 md:w-96 origin-top-right bg-white dark:bg-gray-800 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-50">
                    <div
                        class="p-3 font-bold text-gray-700 dark:text-gray-200 border-b dark:border-gray-700 flex justify-between items-center">
                        <span>Notifikasi</span>
                        <button id="mark-all-read-button"
                            class="text-xs font-medium text-blue-600 dark:text-blue-500 hover:underline">Tandai semua sudah
                            dibaca</button>
                    </div>
                    <div id="notification-list"
                        class="divide-y divide-gray-100 dark:divide-gray-700 max-h-80 overflow-y-auto">
                        @forelse(auth()->user()->unreadNotifications as $notification)
                            <a href="{{ $notification->data['url'] }}?notify_id={{ $notification->id }}"
                                class="block px-4 py-3 text-sm text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <p class="font-semibold">{{ $notification->data['message'] }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    {{ $notification->created_at->diffForHumans() }}</p>
                            </a>
                        @empty
                            <div class="p-4 text-sm text-center text-gray-500 dark:text-gray-400">Tidak ada notifikasi
                                baru.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        @endauth
        @auth
            {{-- Jika SUDAH login, tampilkan bagian profil --}}
            <div class="relative mt-2" id="profile-menu-container">
                <button id="profile-menu-button" class="flex items-center space-x-3 py-2 px-4 w-full">
                    <img class="h-10 w-10 rounded-full object-cover"
                        src="{{ Auth::user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=random' }}"
                        alt="{{ Auth::user()->name }}">
                    <span class="font-medium text-white">{{ Auth::user()->name }}</span>
                </button>

                <div id="profile-menu-dropdown"
                    class="hidden absolute left-4 mt-2 w-48 bg-white rounded-md shadow-lg z-50 py-1">
                    <a href="{{ route('profile.edit') }}"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        Profile
                    </a>
                    <a href="{{ route('my-transactions') }}"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        Transaksi Saya
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"
                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            Sign Out
                        </a>
                    </form>
                </div>
            </div>
        @else
            {{-- Jika BELUM login, tampilkan tombol Sign In --}}
            <a href="{{ route('login') }}" class="block text-white text-lg py-2 px-4 hover:bg-primary rounded-md">
                Sign In
            </a>
        @endguest

    </div>

    <main class="pt-20">

        <section class="home min-h-screen flex flex-col items-center justify-center text-center pt-24 pb-12"
            id="home">
            <div class="content max-w-4xl mx-auto px-4">
                <h3 class="text-white text-4xl md:text-6xl uppercase font-bold">it's time to celebrate! the best <span
                        class="text-primary"> event organizers </span></h3>
                <a href="#contact"
                    class="mt-6 inline-block py-3 px-8 text-lg font-semibold rounded-md bg-gray-700 text-white hover:bg-primary transition-colors">contact
                    us</a>
            </div>

            <div class="swiper-container home-slider w-full mt-12">
                <div class="swiper-wrapper items-center py-4">

                    <div class="swiper-slide w-10/12 max-w-xs sm:max-w-sm">
                        <div class="aspect-[3/4] rounded-lg overflow-hidden shadow-2xl">
                            <img src="images/slide-1.jpg" alt="Wedding Event" class="w-full h-full object-cover">
                        </div>
                    </div>

                    <div class="swiper-slide w-10/12 max-w-xs sm:max-w-sm">
                        <div class="aspect-[3/4] rounded-lg overflow-hidden shadow-2xl">
                            <img src="images/slide-2.jpg" alt="Birthday Celebration"
                                class="w-full h-full object-cover">
                        </div>
                    </div>

                    <div class="swiper-slide w-10/12 max-w-xs sm:max-w-sm">
                        <div class="aspect-[3/4] rounded-lg overflow-hidden shadow-2xl">
                            <img src="images/slide-3.jpg" alt="Night Concert" class="w-full h-full object-cover">
                        </div>
                    </div>

                    <div class="swiper-slide w-10/12 max-w-xs sm:max-w-sm">
                        <div class="aspect-[3/4] rounded-lg overflow-hidden shadow-2xl">
                            <img src="images/slide-4.jpg" alt="Outdoor Party" class="w-full h-full object-cover">
                        </div>
                    </div>

                    <div class="swiper-slide w-10/12 max-w-xs sm:max-w-sm">
                        <div class="aspect-[3/4] rounded-lg overflow-hidden shadow-2xl">
                            <img src="images/slide-5.jpg" alt="Formal Gathering" class="w-full h-full object-cover">
                        </div>
                    </div>

                    <div class="swiper-slide w-10/12 max-w-xs sm:max-w-sm">
                        <div class="aspect-[3/4] rounded-lg overflow-hidden shadow-2xl">
                            <img src="images/slide-6.jpg" alt="Festive Decoration"
                                class="w-full h-full object-cover">
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <section class="service py-12 px-4 md:px-[9%]" id="service">
            <h1 class="text-center pb-8 text-white uppercase text-4xl font-bold">our <span
                    class="text-primary">services</span></h1>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                @forelse($services as $service)
                    <div class="rounded-lg bg-gray-800 text-center p-8">
                        <i
                            class="{{ $service->icon }} h-20 w-20 leading-[5rem] inline-flex items-center justify-center rounded-full text-3xl bg-primary text-white"></i>
                        <h3 class="text-2xl text-white py-4 font-semibold capitalize">{{ $service->title }}</h3>
                        <p class="text-base text-gray-300 leading-relaxed">{{ $service->description }}</p>
                    </div>
                @empty
                    <div class="col-span-full text-center text-white text-xl">
                        Layanan kami akan segera tersedia.
                    </div>
                @endforelse

            </div>
        </section>

        <section class="about py-12 px-4 md:px-[9%]" id="about">
            <h1 class="text-center pb-8 text-white uppercase text-4xl font-bold"><span>about</span> us</h1>
            <div class="flex items-center flex-wrap gap-8">
                <div class="flex-1 basis-full lg:basis-5/12">
                    @if ($about && $about->image)
                        <img src="{{ Storage::url($about->image) }}" alt="About Aethra Organizer"
                            class="w-full rounded-lg border-[1rem] border-gray-800 object-cover aspect-[4/3]">
                    @endif
                </div>
                <div class="flex-1 basis-full lg:basis-6/12">
                    <h3 class="text-4xl text-white font-bold">{{ $about->headline ?? '' }}</h3>
                    <p class="text-lg text-gray-300 py-4 leading-loose">{{ $about->paragraph_1 ?? '' }}</p>
                    <p class="text-lg text-gray-300 leading-loose">{{ $about->paragraph_2 ?? '' }}</p>
                    <a href="#contact"
                        class="mt-4 inline-block py-3 px-8 text-lg font-semibold rounded-md bg-gray-700 text-white hover:bg-primary transition-colors">contact
                        us</a>
                </div>
            </div>
        </section>

        <section class="gallery py-12 px-4 md:px-[9%]" id="gallery">
            <h1 class="text-center pb-8 text-white uppercase text-4xl font-bold">our <span
                    class="text-primary">gallery</span></h1>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                @forelse($galleries as $gallery)
                    <div
                        class="group relative border-[1rem] border-gray-800 rounded-lg h-64 cursor-pointer overflow-hidden">
                        <img src="{{ $gallery->image_url }}" alt="{{ $gallery->title ?? 'Gallery Image' }}"
                            class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-110">
                        <h3
                            class="absolute -top-full left-0 right-0 bg-gray-800/80 text-white text-center py-2 text-2xl transition-all duration-300 group-hover:top-0">
                            {{ $gallery->title }}
                        </h3>
                        <div
                            class="absolute -bottom-full left-0 right-0 bg-gray-800/80 text-center py-4 transition-all duration-300 group-hover:bottom-0">

                            <button class="like-btn text-2xl mx-2 text-white hover:text-primary focus:outline-none"
                                data-id="{{ $gallery->id }}" title="Sukai">
                                <i class="fas fa-heart"></i>
                                {{-- Span ini untuk menampilkan jumlah like --}}
                                <span class="like-count text-base align-top">{{ $gallery->likes }}</span>
                            </button>

                            <a href="https://api.whatsapp.com/send?text=Lihat foto event keren ini! {{ route('landing') }}#gallery"
                                target="_blank" class="text-2xl mx-2 text-white hover:text-primary" title="Bagikan">
                                <i class="fas fa-share"></i>
                            </a>

                            <button class="view-btn text-2xl mx-2 text-white hover:text-primary focus:outline-none"
                                data-image="{{ $gallery->image_url }}" data-title="{{ $gallery->title }}"
                                data-description="{{ $gallery->description }}" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                @empty
                    <p class="col-span-full text-center text-white">Galeri masih kosong.</p>
                @endforelse
            </div>
        </section>

        <div id="lightbox"
            class="hidden fixed inset-0 bg-black bg-opacity-80 z-[10000] flex justify-center items-center p-4">
            <div class="relative bg-white dark:bg-gray-900 rounded-lg max-w-4xl max-h-[90vh] shadow-lg">
                <button id="close-lightbox"
                    class="absolute -top-4 -right-4 h-10 w-10 bg-white text-black rounded-full text-2xl">&times;</button>
                <img id="lightbox-img" src="" class="max-w-full max-h-[80vh] object-contain">
                <div class="p-4 text-gray-900 dark:text-gray-100">
                    <h3 id="lightbox-title" class="text-2xl font-bold"></h3>
                    <p id="lightbox-description" class="mt-2"></p>
                </div>
            </div>
        </div>

        <section class="price py-12 px-4 md:px-[9%]" id="price">
            <h1 class="text-center pb-8 text-white uppercase text-4xl font-bold">our <span
                    class="text-primary">price</span></h1>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                @forelse($pakets as $paket)
                    <div
                        class="bg-gray-800 rounded-lg text-center overflow-hidden transition-transform duration-200 hover:scale-105 flex flex-col">
                        <h3 class="bg-primary text-white py-4 text-2xl font-semibold">{{ $paket->name }}</h3>
                        <div class="p-6 flex-grow flex flex-col">
                            <h3 class="text-white pt-4 text-5xl font-bold">
                                Rp{{ number_format($paket->price / 1000) }}K</h3>
                            <ul class="list-none py-4 space-y-3 text-left flex-grow">
                                @foreach ($paket->fiturs as $fitur)
                                    <li class="text-lg text-gray-300"><i
                                            class="fas fa-check text-primary pr-2"></i>{{ $fitur->name }}</li>
                                @endforeach
                            </ul>
                            <a href="{{ route('checkout.show', $paket->id) }}"
                                class="mt-4 inline-block py-3 px-8 text-lg font-semibold rounded-md bg-gray-700 text-white hover:bg-primary transition-colors">
                                Pesan Sekarang
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-4 text-center text-white text-xl">
                        <p>Saat ini belum ada paket yang tersedia. Silakan cek kembali nanti.</p>
                    </div>
                @endforelse

            </div>
        </section>

        <section class="review py-12 px-4 md:px-[9%]" id="review">
            <h1 class="text-center pb-8 text-white uppercase text-4xl font-bold">client's <span
                    class="text-primary">review</span></h1>
            <div class="swiper-container review-slider">
                <div class="swiper-wrapper">
                    <div class="swiper-slide p-8 rounded-lg bg-gray-800 relative">
                        <i class="fas fa-quote-right absolute top-6 right-6 text-primary text-6xl opacity-30"></i>
                        <div class="flex items-center gap-4 pb-4">
                            <img src="images/pic-1.png" alt="" class="h-20 w-20 rounded-full object-cover">
                            <div>
                                <h3 class="text-2xl text-white">john deo</h3>
                                <span class="text-lg text-gray-400">happy clients</span>
                            </div>
                        </div>
                        <p class="leading-loose text-gray-300 text-lg">teman teman ayo pilih aethra organizer ini EO baru tapi bagus bisa all x-responsive-nav-link
                            harga terjangkau, pelayanan ramah, dan profesional. sukses selalu aethra organizer
                        </p>
                    </div>
                    <div class="swiper-slide p-8 rounded-lg bg-gray-800 relative">
                        <i class="fas fa-quote-right absolute top-6 right-6 text-primary text-6xl opacity-30"></i>
                        <div class="flex items-center gap-4 pb-4">
                            <img src="images/pic-2.png" alt="" class="h-20 w-20 rounded-full object-cover">
                            <div>
                                <h3 class="text-2xl text-white">john deo</h3>
                                <span class="text-lg text-gray-400">happy clients</span>
                            </div>
                        </div>
                        <p class="leading-loose text-gray-300 text-lg">wawalnya sih bingung saya cari kemana ya untuk acara birthday sodara saya
                            ternyata aetrha organizer juga bisa, terimakasih telah ,engelola acara saya dengan baik dan profesional
                        </p>
                    </div>
                    <div class="swiper-slide p-8 rounded-lg bg-gray-800 relative">
                        <i class="fas fa-quote-right absolute top-6 right-6 text-primary text-6xl opacity-30"></i>
                        <div class="flex items-center gap-4 pb-4">
                            <img src="images/pic-3.png" alt="" class="h-20 w-20 rounded-full object-cover">
                            <div>
                                <h3 class="text-2xl text-white">john deo</h3>
                                <span class="text-lg text-gray-400">happy clients</span>
                            </div>
                        </div>
                        <p class="leading-loose text-gray-300 text-lg">ga nyesel sih dapet rekomendasi dari temen, ternyata bagus dan profesional
                            waktu awal sih harganya murah, admin aethra naikan value kalian karna ini sangat bagus pelayanan nya
                        </p>
                    </div>
                    <div class="swiper-slide p-8 rounded-lg bg-gray-800 relative">
                        <i class="fas fa-quote-right absolute top-6 right-6 text-primary text-6xl opacity-30"></i>
                        <div class="flex items-center gap-4 pb-4">
                            <img src="images/pic-3.png" alt="" class="h-20 w-20 rounded-full object-cover">
                            <div>
                                <h3 class="text-2xl text-white">john deo</h3>
                                <span class="text-lg text-gray-400">happy clients</span>
                            </div>
                        </div>
                        <p class="leading-loose text-gray-300 text-lg">AETHRA ORGANIZER best dalam pelayanan, dan dalam action pun sigap gercep
                            laporan pertanggung jawaban oke sesuai dengan RAB yang sudah disepakati. terimakasih
                        </p>
                    </div>
                    <div class="swiper-slide p-8 rounded-lg bg-gray-800 relative">
                        <i class="fas fa-quote-right absolute top-6 right-6 text-primary text-6xl opacity-30"></i>
                        <div class="flex items-center gap-4 pb-4">
                            <img src="images/pic-3.png" alt="" class="h-20 w-20 rounded-full object-cover">
                            <div>
                                <h3 class="text-2xl text-white">john deo</h3>
                                <span class="text-lg text-gray-400">happy clients</span>
                            </div>
                        </div>
                        <p class="leading-loose text-gray-300 text-lg">Mantap pelayanan sangat oke, profesional dan cekatan</p>
                    </div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </section>

        <section class="contact py-12 px-4 md:px-[9%]" id="contact">
            <h1 class="text-center pb-8 text-white uppercase text-4xl font-bold"><span>contact</span> us</h1>

            @auth
                {{-- TAMPILKAN FORM JIKA PENGGUNA SUDAH LOGIN --}}
                <form action="{{ route('contact.store') }}" method="POST" class="max-w-3xl mx-auto text-center">
                    @csrf

                    @if (session('success'))
                        <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800"
                            role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="flex flex-wrap justify-between gap-4">
                        {{-- Nama dan Email terisi otomatis dan tidak bisa diubah --}}
                        <input type="text" name="name" placeholder="Name" value="{{ auth()->user()->name }}"
                            readonly
                            class="w-full md:w-[48%] bg-gray-700 rounded-lg p-4 my-2 text-lg text-white placeholder-gray-400 outline-none cursor-not-allowed">
                        <input type="email" name="email" placeholder="Email" value="{{ auth()->user()->email }}"
                            readonly
                            class="w-full md:w-[48%] bg-gray-700 rounded-lg p-4 my-2 text-lg text-white placeholder-gray-400 outline-none cursor-not-allowed">
                    </div>

                    <div class="flex flex-wrap justify-between gap-4">
                        <input type="number" name="phone_number" placeholder="Number (Optional)"
                            class="w-full md:w-[48%] bg-gray-800 rounded-lg p-4 my-2 text-lg text-white placeholder-gray-400 focus:bg-gray-700 outline-none">
                        <input type="text" name="subject" placeholder="Subject" required
                            class="w-full md:w-[48%] bg-gray-800 rounded-lg p-4 my-2 text-lg text-white placeholder-gray-400 focus:bg-gray-700 outline-none">
                    </div>

                    <textarea name="message" placeholder="Your Message" required cols="30" rows="10"
                        class="w-full bg-gray-800 rounded-lg p-4 my-2 text-lg text-white placeholder-gray-400 focus:bg-gray-700 outline-none resize-none"></textarea>

                    <button type="submit"
                        class="mt-4 inline-block py-3 px-8 text-lg font-semibold rounded-md bg-gray-700 text-white hover:bg-primary transition-colors cursor-pointer">
                        Send Message
                    </button>
                </form>
            @else
                {{-- TAMPILKAN PESAN INI JIKA PENGGUNA BELUM LOGIN --}}
                <div class="max-w-3xl mx-auto text-center bg-gray-800 p-10 rounded-lg">
                    <p class="text-xl text-white">Anda harus login untuk dapat mengirim pesan kepada kami.</p>
                    <a href="{{ route('login') }}"
                        class="mt-6 inline-block py-3 px-8 text-lg font-semibold rounded-md bg-primary text-white hover:bg-opacity-80 transition-colors">
                        Login Sekarang
                    </a>
                </div>
            @endguest
        </section>

        <footer class="bg-gray-950 py-12 px-4 md:px-[9%]">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-2xl py-2 text-white font-semibold">branches</h3>
                    <a href="#" class="block text-lg py-1 text-gray-300 hover:text-primary"><i
                            class="fas fa-map-marker-alt text-primary pr-2"></i> Indonesia </a>
                </div>
                <div>
                    <h3 class="text-2xl py-2 text-white font-semibold">quick links</h3>
                    <a href="#home" class="block text-lg py-1 text-gray-300 hover:text-primary"><i
                            class="fas fa-arrow-right text-primary pr-2"></i> home </a>
                    <a href="#service" class="block text-lg py-1 text-gray-300 hover:text-primary"><i
                            class="fas fa-arrow-right text-primary pr-2"></i> service </a>
                    <a href="#about" class="block text-lg py-1 text-gray-300 hover:text-primary"><i
                            class="fas fa-arrow-right text-primary pr-2"></i> about </a>
                    <a href="#gallery" class="block text-lg py-1 text-gray-300 hover:text-primary"><i
                            class="fas fa-arrow-right text-primary pr-2"></i> gallery </a>
                </div>
                <div>
                    <h3 class="text-2xl py-2 text-white font-semibold">contact info</h3>
                    <a href="#" class="block text-lg py-1 text-gray-300 hover:text-primary"><i
                            class="fas fa-phone text-primary pr-2"></i> +62 821-2072-2442</a>
                    <a href="#" class="block text-lg py-1 text-gray-300 hover:text-primary"><i
                            class="fas fa-envelope text-primary pr-2"></i> aethraorganizer@gmail.com</a>
                    <a href="#" class="block text-lg py-1 text-gray-300 hover:text-primary"><i
                            class="fas fa-map-marker-alt text-primary pr-2"></i> Indonesia, 45510</a>
                </div>
                <div>
                    <h3 class="text-2xl py-2 text-white font-semibold">follow us</h3>
                    <a href="#" class="block text-lg py-1 text-gray-300 hover:text-primary"><i
                            class="fab fa-facebook-f text-primary pr-2"></i> facebook </a>
                    <a href="#" class="block text-lg py-1 text-gray-300 hover:text-primary"><i
                            class="fab fa-twitter text-primary pr-2"></i> twitter </a>
                             <a href="#" class="block text-lg py-1 text-gray-300 hover:text-primary"><i
                            class="fab fa-tiktok text-primary pr-2"></i> tiktok </a>
                    <a href="https://www.instagram.com/aethra.organizer?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" class="block text-lg py-1 text-gray-300 hover:text-primary"><i
                            class="fab fa-instagram text-primary pr-2"></i> instagram </a>
                </div>
            </div>
            <div class="text-center border-t border-gray-800 text-white p-8 mt-8 text-xl">
                Copyright© <span class="text-primary">AETHRA ORGANIZER</span> | all rights reserved
            </div>
        </footer>

    </main>

    <div id="theme-toggler"
        class="fixed top-40 -right-full bg-gray-800 z-50 w-64 text-center transition-all duration-300 rounded-l-lg">
        <div id="toggle-btn" class="absolute top-0 -left-14 py-3 px-4 bg-gray-800 cursor-pointer rounded-l-lg">
            <i class="fas fa-cog text-white text-3xl animate-spin" style="animation-duration: 4s;"></i>
        </div>
        <h3 class="text-white pt-4 font-semibold text-2xl">choose color</h3>
        <div class="flex justify-center flex-wrap gap-4 p-4">
            <div class="theme-btn h-12 w-12 rounded-full cursor-pointer" style="background: #3867d6;"></div>
            <div class="theme-btn h-12 w-12 rounded-full cursor-pointer" style="background: #f7b731;"></div>
            <div class="theme-btn h-12 w-12 rounded-full cursor-pointer" style="background: #ff0033;"></div>
            <div class="theme-btn h-12 w-12 rounded-full cursor-pointer" style="background: #20bf6b;"></div>
            <div class="theme-btn h-12 w-12 rounded-full cursor-pointer" style="background: #fa8231;"></div>
            <div class="theme-btn h-12 w-12 rounded-full cursor-pointer" style="background: #FC427B;"></div>
        </div>
    </div>

    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile Menu Toggle
            const menuBars = document.getElementById('menu-bars');
            const mobileMenu = document.getElementById('mobile-menu');
            const navLinks = mobileMenu.querySelectorAll('a');

            menuBars.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
                menuBars.querySelector('i').classList.toggle('fa-bars');
                menuBars.querySelector('i').classList.toggle('fa-times');
            });

            navLinks.forEach(link => {
                link.addEventListener('click', () => {
                    mobileMenu.classList.add('hidden');
                    menuBars.querySelector('i').classList.add('fa-bars');
                    menuBars.querySelector('i').classList.remove('fa-times');
                });
            });

            // Theme Toggler
            const themeToggler = document.getElementById('theme-toggler');
            const toggleBtn = document.getElementById('toggle-btn');

            toggleBtn.addEventListener('click', () => {
                themeToggler.classList.toggle('-right-full');
                themeToggler.classList.toggle('right-0');
            });

            document.querySelectorAll('.theme-btn').forEach(button => {
                button.addEventListener('click', () => {
                    const color = button.style.backgroundColor;
                    document.documentElement.style.setProperty('--main-color', color);
                });
            });

            // Home Swiper
            new Swiper(".home-slider", {
                effect: "coverflow",
                grabCursor: true,
                centeredSlides: true,
                slidesPerView: "auto",
                coverflowEffect: {
                    rotate: 0,
                    stretch: 0,
                    depth: 100,
                    modifier: 2,
                    slideShadows: true,
                },
                loop: true,
                autoplay: {
                    delay: 3000,
                    disableOnInteraction: false,
                }
            });

            // Review Swiper
            new Swiper(".review-slider", {
                slidesPerView: "auto",
                grabCursor: true,
                spaceBetween: 20,
                loop: true,
                autoplay: {
                    delay: 4000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
                breakpoints: {
                    640: {
                        slidesPerView: 1,
                    },
                    768: {
                        slidesPerView: 2,
                    },
                    1024: {
                        slidesPerView: 3,
                    },
                },
            });
        });
    </script>
    <script>
        // Pastikan script dijalankan setelah DOM siap
        document.addEventListener('DOMContentLoaded', function() {
            // Cek apakah elemen-elemennya ada sebelum menambahkan event listener
            const profileButton = document.getElementById('profile-menu-button');
            const profileDropdown = document.getElementById('profile-menu-dropdown');
            const profileContainer = document.getElementById('profile-menu-container');

            if (profileButton && profileDropdown && profileContainer) {
                // Event listener untuk tombol profil
                profileButton.addEventListener('click', function(event) {
                    // Menghentikan event dari "menyebar" ke window
                    event.stopPropagation();
                    profileDropdown.classList.toggle('hidden');
                });

                // Event listener untuk menutup dropdown saat mengklik di luar area menu
                window.addEventListener('click', function(event) {
                    if (!profileContainer.contains(event.target)) {
                        profileDropdown.classList.add('hidden');
                    }
                });
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- LOGIKA UNTUK DROPDOWN PROFIL DESKTOP ---
            const desktopButton = document.getElementById('desktop-profile-button');
            const desktopDropdown = document.getElementById('desktop-profile-dropdown');
            const desktopContainer = document.getElementById('desktop-profile-container');

            if (desktopButton && desktopDropdown && desktopContainer) {
                desktopButton.addEventListener('click', function(event) {
                    event.stopPropagation();
                    desktopDropdown.classList.toggle('hidden');
                });
            }

            // --- LOGIKA UNTUK DROPDOWN PROFIL MOBILE ---
            const mobileButton = document.getElementById('profile-menu-button');
            const mobileDropdown = document.getElementById('profile-menu-dropdown');
            const mobileContainer = document.getElementById('profile-menu-container');

            if (mobileButton && mobileDropdown && mobileContainer) {
                mobileButton.addEventListener('click', function(event) {
                    event.stopPropagation();
                    mobileDropdown.classList.toggle('hidden');
                });
            }

            // --- LOGIKA UNTUK MENUTUP SEMUA DROPDOWN SAAT KLIK DI LUAR ---
            window.addEventListener('click', function(event) {
                // Tutup dropdown desktop jika klik di luarnya
                if (desktopContainer && !desktopContainer.contains(event.target)) {
                    desktopDropdown.classList.add('hidden');
                }
                // Tutup dropdown mobile jika klik di luarnya
                if (mobileContainer && !mobileContainer.contains(event.target)) {
                    mobileDropdown.classList.add('hidden');
                }
            });
            const lightbox = document.getElementById('lightbox');
            const lightboxImg = document.getElementById('lightbox-img');
            const lightboxTitle = document.getElementById('lightbox-title');
            const lightboxDesc = document.getElementById('lightbox-description');
            const closeLightboxBtn = document.getElementById('close-lightbox');

            document.querySelectorAll('.view-btn').forEach(button => {
                button.addEventListener('click', () => {
                    lightboxImg.src = button.dataset.image;
                    lightboxTitle.textContent = button.dataset.title;
                    lightboxDesc.textContent = button.dataset.description;
                    lightbox.classList.remove('hidden');
                });
            });

            if (closeLightboxBtn) {
                closeLightboxBtn.addEventListener('click', () => {
                    lightbox.classList.add('hidden');
                });
            }

            if (lightbox) {
                lightbox.addEventListener('click', (e) => {
                    if (e.target === lightbox) {
                        lightbox.classList.add('hidden');
                    }
                });
            }

            // --- LOGIKA UNTUK TOMBOL LIKE (AJAX) ---
            document.querySelectorAll('.like-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const galleryId = this.dataset.id;
                    const likeCountSpan = this.querySelector('.like-count');

                    fetch(`/gallery/${galleryId}/like`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').getAttribute('content')
                            },
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.likes !== undefined) {
                                likeCountSpan.textContent = data.likes;
                            }
                        })
                        .catch(error => console.error('Error:', error));
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const bellButton = document.getElementById('notification-bell-button');
            const dropdown = document.getElementById('notification-dropdown');
            const markAllReadButton = document.getElementById('mark-all-read-button');
            const notificationBadge = document.getElementById('notification-badge');
            const notificationList = document.getElementById('notification-list');

            if (bellButton && dropdown) {
                // Buka/tutup dropdown saat lonceng diklik
                bellButton.addEventListener('click', function(event) {
                    event.stopPropagation();
                    dropdown.classList.toggle('hidden');
                });

                // Tutup dropdown saat klik di luar area
                window.addEventListener('click', function(event) {
                    if (!bellButton.contains(event.target) && !dropdown.contains(event.target)) {
                        dropdown.classList.add('hidden');
                    }
                });
            }

            // Aksi untuk tombol "Tandai semua sudah dibaca"
            if (markAllReadButton) {
                markAllReadButton.addEventListener('click', function(event) {
                    event.preventDefault();
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content');

                    fetch('{{ route('notifications.markAllRead') }}', {
                            method: 'POST',
                            // Add a comma here if there are other properties before headers
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Hilangkan badge angka
                                if (notificationBadge) {
                                    notificationBadge.style.display = 'none';
                                }
                                // Kosongkan list dan tampilkan pesan
                                notificationList.innerHTML =
                                    '<div class="p-4 text-sm text-center text-gray-500">Tidak ada notifikasi baru.</div>';
                            }
                        })
                        .catch(error => console.error('Error:', error));
                });
            }
        });
    </script>
</body>

</html>
