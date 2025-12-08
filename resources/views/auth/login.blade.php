<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Culture Bénin</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#e67e22',
                        'primary-dark': '#d35400',
                    },
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Outfit', sans-serif; background-color: #f7fafc; }
        .fade-in { animation: fadeIn 0.5s ease-in; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    </style>
</head>
<body class="bg-gray-50 text-gray-900">

    <div class="relative min-h-screen w-full overflow-hidden flex items-center justify-center py-10 px-4">
        
        {{-- Background Slider (CSS Only Implementation for Simplicity) --}}
        <div class="fixed inset-0 z-0">
             <div class="absolute inset-0 bg-cover bg-center transition-opacity duration-1000" style="background-image: url('{{ asset('adminlte/img/porte_non_retour.webp') }}');"></div>
             <div class="absolute inset-0 bg-black/40 backdrop-blur-[2px]"></div>
        </div>

        {{-- Navbar --}}
        <nav class="fixed top-0 left-0 w-full z-50 px-6 py-4 flex justify-between items-center text-white">
            <div class="flex items-center gap-2 font-bold text-xl drop-shadow-md">
                <span class="text-2xl">🌍</span>
                <span>Culture Bénin</span>
            </div>
            <a href="/" class="px-5 py-2 rounded-full border border-white/30 bg-white/10 backdrop-blur-md hover:bg-white/20 transition text-sm font-medium">
                Retour à l'accueil
            </a>
        </nav>

        {{-- Login Card --}}
        <div class="relative z-10 w-full max-w-4xl bg-white/95 backdrop-blur-xl rounded-3xl shadow-2xl overflow-hidden flex flex-col md:flex-row fade-in">
            
            {{-- Sidebar Info --}}
            <div class="hidden md:flex flex-col justify-center p-12 w-2/5 bg-gradient-to-br from-orange-400 to-orange-600 text-white relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-full opacity-10" style="background-image: url('https://www.transparenttextures.com/patterns/cubes.png');"></div>
                <div class="relative z-10">
                    <h2 class="text-3xl font-bold mb-4">Bon retour !</h2>
                    <p class="mb-8 text-orange-50 leading-relaxed">
                        Nous sommes ravis de vous revoir. Connectez-vous pour continuer à explorer le patrimoine du Bénin.
                    </p>
                </div>
            </div>

            {{-- Form Area --}}
            <div class="w-full md:w-3/5 p-8 md:p-12">
                <div class="mb-8">
                    <h1 class="text-2xl font-bold text-gray-800">Connexion</h1>
                    <p class="text-gray-500 text-sm mt-1">Accédez à votre compte</p>
                </div>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200 text-green-700 flex items-center gap-3">
                        <span class="text-xl">✅</span>
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Validation Errors -->
                @if ($errors->any())
                    <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 flex items-center gap-3">
                        <span class="text-xl">⚠️</span>
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-6" autocomplete="off">
                    @csrf

                    <!-- Email Address -->
                    <div class="space-y-1">
                        <label for="email" class="text-sm font-semibold text-gray-700 ml-1">Email</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-orange-500 transition">
                                ✉️
                            </div>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="off"
                                class="w-full pl-10 pr-4 py-3 bg-gray-50 border @error('email') border-red-500 bg-red-50 @else border-gray-200 @enderror rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none transition-all duration-200 hover:bg-white"
                                placeholder="votre@email.com">
                        </div>
                        @error('email')
                            <p class="text-red-500 text-xs ml-1 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="space-y-1">
                        <div class="flex justify-between items-center">
                            <label for="password" class="text-sm font-semibold text-gray-700 ml-1">Mot de passe</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-xs text-orange-600 hover:underline">
                                    Mot de passe oublié ?
                                </a>
                            @endif
                        </div>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-orange-500 transition">
                                🔒
                            </div>
                            <input id="password" type="password" name="password" required autocomplete="new-password"
                                class="w-full pl-10 pr-4 py-3 bg-gray-50 border @error('password') border-red-500 bg-red-50 @else border-gray-200 @enderror rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none transition-all duration-200 hover:bg-white"
                                placeholder="••••••••">
                        </div>
                        @error('password')
                            <p class="text-red-500 text-xs ml-1 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input id="remember_me" type="checkbox" name="remember" class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300 rounded">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-700">
                            Se souvenir de moi
                        </label>
                    </div>

                    <button type="submit" class="w-full py-4 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-bold rounded-xl shadow-lg hover:shadow-orange-500/30 transform hover:-translate-y-1 transition-all duration-200 flex items-center justify-center gap-2">
                        Se connecter 🚀
                    </button>

                    <div class="text-center pt-4 text-sm text-gray-500">
                        Pas encore de compte ? <a href="{{ route('register') }}" class="text-orange-600 font-semibold hover:underline">Inscrivez-vous</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
