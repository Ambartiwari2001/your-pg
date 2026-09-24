<footer class="bg-slate-900 text-slate-300 mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-10">
            <div class="md:col-span-2">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-white font-bold text-xl mb-4">
                    <span class="w-9 h-9 rounded-xl hero-gradient flex items-center justify-center text-sm">SE</span>
                    StayEase
                </a>
                <p class="text-slate-400 max-w-md leading-relaxed">
                    Find verified, affordable PG accommodation across Ahmedabad and Gujarat. Your perfect stay is just a click away.
                </p>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-4">Quick Links</h4>
                <ul class="space-y-3 text-sm">
                    <li><a href="{{ route('home') }}" class="hover:text-white transition-colors">Home</a></li>
                    <li><a href="{{ route('pgs.index') }}" class="hover:text-white transition-colors">Browse PGs</a></li>
                    @auth
                        <li><a href="{{ route('dashboard') }}" class="hover:text-white transition-colors">Dashboard</a></li>
                    @else
                        <li><a href="{{ route('login') }}" class="hover:text-white transition-colors">Login</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-white transition-colors">Register</a></li>
                    @endauth
                </ul>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-4">Contact</h4>
                <ul class="space-y-3 text-sm">
                    <li>📍 Ahmedabad, Gujarat</li>
                    <li>📞 +91 98765 43210</li>
                    <li>✉️ hello@stayease.in</li>
                </ul>
            </div>
        </div>
        <div class="border-t border-slate-800 mt-10 pt-8 flex flex-col sm:flex-row justify-between items-center gap-4 text-sm text-slate-500">
            <p>&copy; {{ date('Y') }} StayEase. All rights reserved.</p>
            <p>Made with care for students & professionals</p>
        </div>
    </div>
</footer>
