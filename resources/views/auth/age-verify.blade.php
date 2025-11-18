<x-guest-layout>
    <div class="max-w-md mx-auto bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg text-center">
        <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-200">Are you sure you are 18 plus?</h2>
        <p class="text-gray-600 dark:text-gray-400 mb-6">
            You must confirm you are at least 18 years old to continue.
        </p>

        <form method="POST" action="{{ route('age.verify.submit') }}">
            @csrf
            <x-primary-button class="w-full mb-3">
                 Yes, I am 18+
            </x-primary-button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" 
                class="w-full bg-red-600 text-white py-2 px-4 rounded hover:bg-red-700">
                 No
            </button>
        </form>
    </div>
</x-guest-layout>
