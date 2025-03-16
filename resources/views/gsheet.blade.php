@extends('layouts.app')

@section('title', 'CBT | Homepage')

@section('content')

<section class="bg-white dark:bg-gray-900">
    <div class="grid max-w-screen-xl px-4 pt-20 pb-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12 lg:pt-28">
        <div class="mr-auto place-self-center lg:col-span-7">
            <h1 class="max-w-2xl mb-4 text-4xl font-extrabold leading-none tracking-tight md:text-5xl xl:text-6xl dark:text-white">
                Kelola Keuangan dengan Mudah,
                <br> Hanya <span class="text-red-500">Rp10.000!</span>
            </h1>
            <p class="max-w-2xl mb-6 text-gray-700 lg:mb-8 md:text-lg dark:text-gray-400 font-bold lg:text-xxl">
                Selalu kehabisan uang sebelum akhir bulan? Bingung ke mana perginya gaji atau uang saku?</p>

            <img src="{{ asset('images/gsheet/reason.png') }}" alt="Spending money">
        </div>
        <div class="lg:mt-0 lg:col-span-5 lg:flex">
            <img src="{{ asset('images/gsheet/hero.png') }}" class="object-contain" alt="hero image">
        </div>

    </div>
</section>



<section class="bg-white dark:bg-gray-900">
    <div class="max-w-screen-xl px-4 py-8 mx-auto lg:py-24 lg:px-6">
        <div class="max-w-screen-md mx-auto mb-8 text-center lg:mb-12">
            <h2 class="mb-4 text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white">Kelola keuangan jadi lebih mudah! 🚀</h2>
            <p class="mb-5 font-light text-gray-500 sm:text-xl dark:text-gray-400">
                Kini, kelola keuangan jadi lebih mudah dengan Template Google Sheets yang praktis dan otomatis!
                Dirancang khusus untuk mahasiswa & karyawan, template ini akan membantu kamu</p>
        </div>
        <div class="space-y-8 lg:grid lg:grid-cols-3 sm:gap-6 xl:gap-10 lg:space-y-0">
            <!-- Pricing Card -->
            <div class="flex flex-col max-w-lg p-6 mx-auto text-center text-gray-900 bg-white border border-gray-100 rounded-lg shadow dark:border-gray-600 xl:p-8 dark:bg-gray-800 dark:text-white">
                <h3 class="mb-4 text-2xl font-semibold">Analisa Keuangan Kamu</h3>
                <p class="font-light text-gray-500 sm:text-lg dark:text-gray-400">Dashboard yang menyediakan rangkuman data keuangan kamu !</p>
                <div class="flex items-baseline justify-center my-8">
                    <img src="{{ asset('images/gsheet/1.PNG') }}" alt="Image Convert">
                </div>
                <!-- List -->
                <div>
                    <ul role="list" class="mb-8 space-y-4 text-left">
                        <li class="flex items-center space-x-3">
                            <!-- Icon -->
                            <svg class="flex-shrink-0 w-5 h-5 text-green-500 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span><a href="/convert-png-to-jpg">Data Saldo Terkini</a></span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <!-- Icon -->
                            <svg class="flex-shrink-0 w-5 h-5 text-green-500 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span><a href="/convert-jpg-to-png">Total pemasukan mu perbulan</a></span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <!-- Icon -->
                            <svg class="flex-shrink-0 w-5 h-5 text-green-500 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span><a href="/convert-jpg-to-pdf">Total pengeluaran mu perbulan</a></span></span>
                        </li>
                    </ul>
                    <!-- <a href="#" class="text-white bg-purple-600 hover:bg-purple-700 focus:ring-4 focus:ring-purple-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:text-white  dark:focus:ring-purple-900">Get started</a> -->
                </div>
            </div>
            <!-- Pricing Card -->
            <div class="flex flex-col max-w-lg p-6 mx-auto text-center text-gray-900 bg-white border border-gray-100 rounded-lg shadow dark:border-gray-600 xl:p-8 dark:bg-gray-800 dark:text-white">
                <h3 class="mb-4 text-2xl font-semibold">Catat Pemasukan Kamu</h3>
                <p class="font-light text-gray-500 sm:text-lg dark:text-gray-400">Gaji , Uang saku atau deviden saham kamu bisa di catat disini</p>
                <div class="flex items-baseline justify-center my-8">
                    <img src="{{ asset('images/gsheet/2.PNG') }}" alt="Document Convert">
                </div>
                <!-- List -->
                <ul role="list" class="mb-8 space-y-4 text-left">
                    <li class="flex items-center space-x-3">
                        <!-- Icon -->
                        <svg class="flex-shrink-0 w-5 h-5 text-green-500 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span><a href="/convert-word-to-pdf">Custom Alokasi</a></span>
                    </li>
                </ul>
                <!-- <a href="#" class="text-white bg-purple-600 hover:bg-purple-700 focus:ring-4 focus:ring-purple-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:text-white  dark:focus:ring-purple-900">Get started</a> -->
            </div>
            <!-- Pricing Card -->
            <div class="flex flex-col max-w-lg p-6 mx-auto text-center text-gray-900 bg-white border border-gray-100 rounded-lg shadow dark:border-gray-600 xl:p-8 dark:bg-gray-800 dark:text-white">
                <h3 class="mb-4 text-2xl font-semibold">Catat Pengeluaran kamu</h3>
                <p class="font-light text-gray-500 sm:text-lg dark:text-gray-400">Bayar cicilan , tagihan listrik atau budget jalan sama si dia bisa catat disini </p>
                <div class="flex items-baseline justify-center my-8">
                    <img src="{{ asset('images/gsheet/3.PNG') }}" alt="Speed Test Internet">
                </div>
                <!-- List -->
                <ul role="list" class="mb-8 space-y-4 text-left">
                    <li class="flex items-center space-x-3">
                        <!-- Icon -->
                        <svg class="flex-shrink-0 w-5 h-5 text-green-500 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span><a href="/speed-test-internet">kelola pengeluaranmu</a></span>
                    </li>
                    <li class="flex items-center space-x-3">
                        <!-- Icon -->
                        <svg class="flex-shrink-0 w-5 h-5 text-green-500 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span><a href="/speed-test-internet">kustom kategori pengeluaranmu</a></span>
                    </li>
                </ul>
                <!-- <a href="#" class="text-white bg-purple-600 hover:bg-purple-700 focus:ring-4 focus:ring-purple-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:text-white  dark:focus:ring-purple-900">Get started</a> -->
            </div>
        </div>
    </div>
</section>


<section class="bg-white dark:bg-gray-900">
    <div class="max-w-screen-xl px-4 py-8 mx-auto lg:py-24 lg:px-6">
        <div class="max-w-screen-md mx-auto mb-8 text-center lg:mb-12">

            <img src="{{ asset('images/gsheet/disire.jpg') }}" alt="Manage money">
            <h2 class="mb-4 text-xl font-extrabold tracking-tight text-gray-900 dark:text-white">
                Bayangkan bisa mengontrol keuangan tanpa ribet dan tanpa perlu aplikasi mahal!
                Cukup pakai Google Sheets dari HP atau laptop, keuanganmu jadi lebih teratur!</h2>
            <p class="mb-5 font-medium text-black-500 text-2xlsm:text-3xl dark:text-gray-400">
                Dapatkan sekarang hanya Rp10.000! 🎉
                Klik link berikut untuk langsung beli dan mulai atur keuanganmu dengan lebih baik! 🔥</p>
            <a class="mt-10 text-white bg-red-500 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-bold
         rounded-lg text-sm px-4 lg:px-5 py-6 lg:py-2.5 sm:mr-2 lg:mr-0 
        dark:bg-purple-600 dark:hover:bg-purple-700 focus:outline-none dark:focus:ring-purple-800" href="http://lynk.id/cerdas-finansial/8gzoGBz/checkout">
                Beli Sekarang juga !!!
            </a>
        </div>


    </div>
</section>
@endsection