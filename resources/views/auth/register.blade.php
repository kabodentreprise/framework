<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Culture Bénin</title>
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

        {{-- Register Card --}}
        <div class="relative z-10 w-full max-w-4xl bg-white/95 backdrop-blur-xl rounded-3xl shadow-2xl overflow-hidden flex flex-col md:flex-row fade-in">
            
            {{-- Sidebar Info --}}
            <div class="hidden md:flex flex-col justify-center p-12 w-2/5 bg-gradient-to-br from-orange-400 to-orange-600 text-white relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-full opacity-10" style="background-image: url('https://www.transparenttextures.com/patterns/cubes.png');"></div>
                <div class="relative z-10">
                    <h2 class="text-3xl font-bold mb-4">Bienvenue !</h2>
                    <p class="mb-8 text-orange-50 leading-relaxed">
                        Rejoignez la plus grande communauté culturelle du Bénin. Partagez, découvrez et préservez notre patrimoine.
                    </p>
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center">🏛️</div>
                            <span>Patrimoine historique</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center">🎨</div>
                            <span>Arts & Culture</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center">🤝</div>
                            <span>Communauté active</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Form Area --}}
            <div class="w-full md:w-3/5 p-8 md:p-12">
                <div class="mb-8">
                    <h1 class="text-2xl font-bold text-gray-800">Créer un compte</h1>
                    <p class="text-gray-500 text-sm mt-1">Remplissez le formulaire pour commencer</p>
                </div>

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

                <form method="POST" action="{{ route('register') }}" class="space-y-5" autocomplete="off">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <!-- Nom -->
                        <div class="space-y-1">
                            <label for="nom" class="text-sm font-semibold text-gray-700 ml-1">Nom</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-orange-500 transition">
                                    👤
                                </div>
                                <input id="nom" type="text" name="nom" value="{{ old('nom') }}" required autofocus autocomplete="off"
                                    class="w-full pl-10 pr-4 py-3 bg-gray-50 border @error('nom') border-red-500 bg-red-50 @else border-gray-200 @enderror rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none transition-all duration-200 hover:bg-white"
                                    placeholder="Votre nom">
                            </div>
                        </div>

                        <!-- Prénom -->
                        <div class="space-y-1">
                            <label for="prenom" class="text-sm font-semibold text-gray-700 ml-1">Prénom</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-orange-500 transition">
                                    👤
                                </div>
                                <input id="prenom" type="text" name="prenom" value="{{ old('prenom') }}" required autocomplete="off"
                                    class="w-full pl-10 pr-4 py-3 bg-gray-50 border @error('prenom') border-red-500 bg-red-50 @else border-gray-200 @enderror rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none transition-all duration-200 hover:bg-white"
                                    placeholder="Votre prénom">
                            </div>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="space-y-1">
                        <label for="email" class="text-sm font-semibold text-gray-700 ml-1">Email</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-orange-500 transition">
                                ✉️
                            </div>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="off"
                                class="w-full pl-10 pr-4 py-3 bg-gray-50 border @error('email') border-red-500 bg-red-50 @else border-gray-200 @enderror rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none transition-all duration-200 hover:bg-white"
                                placeholder="votre@email.com">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <!-- Password -->
                        <div class="space-y-1">
                            <label for="password" class="text-sm font-semibold text-gray-700 ml-1">Mot de passe</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-orange-500 transition">
                                    🔒
                                </div>
                                <input id="password" type="password" name="password" required autocomplete="new-password"
                                    class="w-full pl-10 pr-4 py-3 bg-gray-50 border @error('password') border-red-500 bg-red-50 @else border-gray-200 @enderror rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none transition-all duration-200 hover:bg-white"
                                    placeholder="••••••••">
                            </div>
                        </div>

                        <!-- Password Confirmation -->
                        <div class="space-y-1">
                            <label for="password_confirmation" class="text-sm font-semibold text-gray-700 ml-1">Confirmation</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-orange-500 transition">
                                    🔒
                                </div>
                                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                                    class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none transition-all duration-200 hover:bg-white"
                                    placeholder="••••••••">
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <!-- Sexe -->
                        <div class="space-y-1">
                            <label for="sexe" class="text-sm font-semibold text-gray-700 ml-1">Sexe</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                    ⚥
                                </div>
                                <select id="sexe" name="sexe" required
                                    class="w-full pl-10 pr-4 py-3 bg-gray-50 border @error('sexe') border-red-500 bg-red-50 @else border-gray-200 @enderror rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none appearance-none transition hover:bg-white cursor-pointer">
                                    <option value="">Sélectionnez</option>
                                    <option value="M" {{ old('sexe') == 'M' ? 'selected' : '' }}>Homme</option>
                                    <option value="F" {{ old('sexe') == 'F' ? 'selected' : '' }}>Femme</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">▼</div>
                            </div>
                        </div>

                        <!-- Date de Naissance -->
                        <div class="space-y-1">
                            <label for="date_nais" class="text-sm font-semibold text-gray-700 ml-1">Date de naissance</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400 group-focus-within:text-orange-500 transition">
                                    📅
                                </div>
                                <input id="date_nais" type="date" name="date_nais" value="{{ old('date_nais') }}" required
                                    class="w-full pl-10 pr-4 py-3 bg-gray-50 border @error('date_nais') border-red-500 bg-red-50 @else border-gray-200 @enderror rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none transition-all duration-200 hover:bg-white">
                            </div>
                        </div>
                    </div>

                    <!-- Langue -->
                    <div class="space-y-1">
                        <label for="id_langue" class="text-sm font-semibold text-gray-700 ml-1">Langue maternelle</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                🗣️
                            </div>
                            <select id="id_langue" name="id_langue" required
                                class="w-full pl-10 pr-4 py-3 bg-gray-50 border @error('id_langue') border-red-500 bg-red-50 @else border-gray-200 @enderror rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-transparent outline-none appearance-none transition hover:bg-white cursor-pointer">
                                @if(isset($langues))
                                    @foreach($langues as $langue)
                                        <option value="{{ $langue->id }}" {{ old('id_langue') == $langue->id ? 'selected' : '' }}>
                                            {{ $langue->nom_langue }}
                                        </option>
                                    @endforeach
                                @endif
                                <option value="">Choisir une langue...</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">▼</div>
                        </div>
                    </div>

                    <button type="submit" class="w-full py-4 mt-6 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-bold rounded-xl shadow-lg hover:shadow-orange-500/30 transform hover:-translate-y-1 transition-all duration-200 flex items-center justify-center gap-2">
                        Commencer l'aventure 🚀
                    </button>

                    <div class="text-center pt-4 text-sm text-gray-500">
                        Déjà membre ? <a href="{{ route('login') }}" class="text-orange-600 font-semibold hover:underline">Connectez-vous</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
