<x-layouts.app>
    <body class="contact-page">
        <link rel="stylesheet" href="{{ asset('css/contact.css') }}">

        <div class="contact-container">
            <h2>Contact Us</h2>
            <p>Have any questions? We'd love to hear from you.</p>

            <p><i class="fa-solid fa-phone"></i> 09389282080</p>
            <p><i class="fa-solid fa-envelope"></i> cabalanchristianjay612@gmail.com</p>
            <p><i class="fa-solid fa-map-marker-alt"></i> Bilangbilangan Daku, Bien Unido, Bohol</p>

            <form method="POST" action="{{ route('contact.submit') }}">
                @csrf
                <input type="text" name="name" placeholder="Your Name" required>
                <input type="email" name="email" placeholder="Your Email" required>
                <input type="text" name="subject" placeholder="Subject" required>
                <textarea name="message" placeholder="Your Message" required></textarea>
                <button type="submit">Send Message</button>
            </form>

            @if(session('success'))
                <p class="success-message">{{ session('success') }}</p>
            @endif
        </div>
    </body>
</x-layouts.app>
