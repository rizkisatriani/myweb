@extends('layouts.app')
 

@section('content')
<section class="bg-white">
   <div class="isolate bg-white px-6 py-24 sm:py-32 lg:px-8">
  <div aria-hidden="true" class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80">
    <div style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)" class="relative left-1/2 -z-10 aspect-[1155/678] w-[36.125rem] max-w-none -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-40rem)] sm:w-[72.1875rem]"></div>
  </div>
  <script src="//unpkg.com/alpinejs" defer></script>
<!-- @if(session('success')) -->
<div 
    x-data="{ show: true }" 
    x-show="show" 
    x-transition 
    x-init="setTimeout(() => show = false, 3000)" 
    class="fixed bg-green-500 text-white inset-0 flex items-center justify-center z-50 rounded-lg shadow-lg"
>
    <div class="flex items-center space-x-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
        <span>{{ session('success') }}</span>
    </div>
</div>
<!-- @endif -->
  <div class="mx-auto max-w-2xl text-center">
    <h2 class="text-balance text-4xl font-semibold tracking-tight text-gray-900 sm:text-5xl">Contact us</h2>
    <p class="mt-2 text-lg/8 text-gray-600">Reach out to us anytime if you need assistance — our team is here to help.</p>
  </div>
  <form action="{{ route('contact.store') }}" method="POST" class="mx-auto mt-16 max-w-xl sm:mt-20">
    @csrf
    <div class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-2">
      <div>
        <label for="first-name" class="block text-sm/6 font-semibold text-gray-900">First name</label>
        <div class="mt-2.5">
          <input id="first-name" type="text" name="first_name" value="{{ old('first_name') }}" autocomplete="given-name" class="block w-full rounded-md bg-white px-3.5 py-2 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600" />
        </div>
      </div>
      <div>
        <label for="last-name" class="block text-sm/6 font-semibold text-gray-900">Last name</label>
        <div class="mt-2.5">
          <input id="last-name" type="text" name="last_name" value="{{ old('last_name') }}"  autocomplete="family-name" class="block w-full rounded-md bg-white px-3.5 py-2 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600" />
        </div>
      </div> 
      <div class="sm:col-span-2">
        <label for="email" class="block text-sm/6 font-semibold text-gray-900">Email</label>
        <div class="mt-2.5">
          <input id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="email" class="block w-full rounded-md bg-white px-3.5 py-2 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600" />
        </div>
      </div> 
      <div class="sm:col-span-2">
        <label for="message" class="block text-sm/6 font-semibold text-gray-900">Message</label>
        <div class="mt-2.5">
          <textarea id="message" name="message" rows="4" class="block w-full rounded-md bg-white px-3.5 py-2 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600"></textarea>
        </div>
      </div>
      <div class="flex gap-x-4 sm:col-span-2">
        <div class="flex h-6 items-center">
          <div class="group relative inline-flex w-8 shrink-0 rounded-full bg-gray-200 p-px outline-offset-2 outline-indigo-600 ring-1 ring-inset ring-gray-900/5 transition-colors duration-200 ease-in-out has-[:checked]:bg-indigo-600 has-[:focus-visible]:outline has-[:focus-visible]:outline-2">
            <span class="hidden size-4 rounded-full bg-white shadow-sm ring-1 ring-gray-900/5 transition-transform duration-200 ease-in-out group-has-[:checked]:translate-x-3.5"></span>
            <input id="agree-to-policies" type="checkbox" name="agree-to-policies" aria-label="Agree to policies" class="absolute inset-0 appearance-none focus:outline-none" required />
          </div>
        </div>
        <label for="agree-to-policies" class="text-sm/6 text-gray-600">
          By selecting this, you agree to our
          <a href="/privacy" class="whitespace-nowrap font-semibold text-indigo-600">privacy policy</a>.
        </label>
      </div>
    </div>
    <div class="mt-10">
      <button type="submit" class="block w-full rounded-md bg-indigo-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Let's talk</button>
    </div>
  </form>
</div>

</section>
@endsection
