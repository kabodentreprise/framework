<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Culture Bénin - Plateforme Culturelle</title>
    <meta name="description" content="Découvrez la richesse culturelle du Bénin à travers notre plateforme dédiée au patrimoine, aux traditions et à l'art béninois.">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- CDN React --}}
    <script crossorigin src="https://unpkg.com/react@18/umd/react.development.js"></script>
    <script crossorigin src="https://unpkg.com/react-dom@18/umd/react-dom.development.js"></script>
    <script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>

    {{-- CSS --}}
    @vite(['resources/css/app.css'])

    <style>
        /* Votre style existant */
        .loading-fallback {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }

        .loading-fallback .spinner {
            width: 50px;
            height: 50px;
            border: 4px solid #e0e0e0;
            border-top: 4px solid #e67e22;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-bottom: 20px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .loading-fallback p {
            font-size: 1.2rem;
            color: #333;
            font-weight: 500;
        }

        /* Styles de base pour éviter les erreurs */
        #app {
            min-height: 100vh;
        }
    </style>
</head>
<body>
    <div id="app">
        <div class="loading-fallback">
            <div class="spinner"></div>
            <p>Chargement de Culture Bénin...</p>
        </div>
    </div>

    <script type="text/babel">
        // ==================== COPIE DE VOTRE app.jsx ====================
        // J'ai simplement copié tout votre code React ici

        const { useState, useEffect } = React;

        // Récupérer l'utilisateur authentifié depuis Blade
        const authUser = @json(Auth::user() ? Auth::user()->load('role') : null);

        // Composant principal
        function App() {
            const [user, setUser] = useState(authUser);
            const [isLoading, setIsLoading] = useState(true);
            const [currentSlide, setCurrentSlide] = useState(0);

            useEffect(() => {
                // Simuler un court chargement pour l'effet visuel
                const timer = setTimeout(() => {
                    setIsLoading(false);
                }, 800);

                // Carousel automatique
                const carouselTimer = setInterval(() => {
                    setCurrentSlide((prev) => (prev + 1) % 3);
                }, 5000);

                return () => {
                    clearTimeout(timer);
                    clearInterval(carouselTimer);
                };
            }, []);

            // La connexion est gérée par Laravel, pas besoin de handleLogin ici pour le moment
            // (sauf si on fait une SPA complète avec connexion AJAX plus tard)

            const handleLogout = () => {
                // Créer un formulaire caché pour soumettre la déconnexion via POST (requis par Laravel)
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '/logout';
                
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = csrfToken;
                
                form.appendChild(csrfInput);
                document.body.appendChild(form);
                form.submit();
            };

            if (isLoading) {
                return React.createElement(LoadingScreen);
            }

            return React.createElement('div', { className: 'app' },
                React.createElement(Navbar, { user: user, onLogout: handleLogout }),
                React.createElement(HeroSection, {
                    user: user,
                    currentSlide: currentSlide,
                    setCurrentSlide: setCurrentSlide
                }),
                React.createElement(FeaturesSection),
                React.createElement(CulturalHeritage),
                React.createElement(StatisticsSection),
                React.createElement(TestimonialsSection),
                React.createElement(CTASection, { user: user }),
                React.createElement(Footer)
            );
        }

        // Composant Écran de chargement
        function LoadingScreen() {
            return React.createElement('div', { className: 'loading-screen' },
                React.createElement('div', { className: 'spinner' }),
                React.createElement('p', null, 'Chargement de Culture Bénin...')
            );
        }

        // Composant Navigation
        function Navbar({ user, onLogout }) {
            const [isMenuOpen, setIsMenuOpen] = useState(false);
            const [isScrolled, setIsScrolled] = useState(false);

            useEffect(() => {
                const handleScroll = () => {
                    setIsScrolled(window.scrollY > 50);
                };
                window.addEventListener('scroll', handleScroll);
                return () => window.removeEventListener('scroll', handleScroll);
            }, []);

            const handleLogoutClick = (e) => {
                e.preventDefault();
                onLogout();
            };



            return React.createElement('nav', { className: `navbar ${isScrolled ? 'scrolled' : ''}` },
                React.createElement('div', { className: 'nav-container' },
                    React.createElement('div', { className: 'nav-brand' },
                        React.createElement('div', { className: 'logo' }, '🌍'),
                        React.createElement('span', null, 'Culture Bénin')
                    ),
                    React.createElement('button', {
                        className: 'nav-toggle',
                        onClick: () => setIsMenuOpen(!isMenuOpen),
                        'aria-label': 'Toggle menu'
                    }, '☰'),
                    React.createElement('div', { className: `nav-menu ${isMenuOpen ? 'active' : ''}` },
                        React.createElement('a', {
                            href: '/catalogue',
                            className: 'nav-link',
                            onClick: () => setIsMenuOpen(false)
                        }, 'Découvrir'),
                        React.createElement('a', {
                            href: '#heritage',
                            className: 'nav-link',
                            onClick: () => setIsMenuOpen(false)
                        }, 'Patrimoine'),
                        React.createElement('a', {
                            href: '#statistics',
                            className: 'nav-link',
                            onClick: () => setIsMenuOpen(false)
                        }, 'Impact'),
                        React.createElement('a', {
                            href: '#testimonials',
                            className: 'nav-link',
                            onClick: () => setIsMenuOpen(false)
                        }, 'Témoignages'),
                        React.createElement('div', { className: 'nav-auth' },
                            user ? React.createElement(React.Fragment, null,
                                React.createElement('a', { href: '/dashboard', className: 'btn btn-primary' }, 'Tableau de bord'),
                                React.createElement('button', { onClick: handleLogoutClick, className: 'btn btn-outline' }, 'Déconnexion')
                            ) : React.createElement(React.Fragment, null,
                                React.createElement('a', { href: '/login', className: 'btn btn-outline' }, 'Connexion'),
                                React.createElement('a', { href: '/register', className: 'btn btn-primary' }, 'S\'inscrire')
                            )
                        )
                    )
                )
            );
        }

        // Composant Hero avec Carousel
        function HeroSection({ user, currentSlide, setCurrentSlide }) {
            const slides = [
                {
                    image: "{{ asset('adminlte/img/porte_non_retour.webp') }}",
                    title: "Trésors Culturels du Bénin",
                    subtitle: "Découvrez la richesse de nos traditions ancestrales"
                },
                {
                    image: "{{ asset('adminlte/img/palais-royal.jpg') }}",
                    title: "Art et Architecture",
                    subtitle: "Les palais royaux et l'architecture traditionnelle"
                },
                {
                    image: "{{ asset('adminlte/img/tata_somba.jpg') }}",
                    title: "Patrimoine Vivant",
                    subtitle: "Les traditions qui font la fierté du Bénin"
                }
            ];

            return React.createElement('section', { className: 'hero' },
                React.createElement('div', { className: 'hero-carousel' },
                    slides.map((slide, index) =>
                        React.createElement('div', {
                            key: index,
                            className: `slide ${index === currentSlide ? 'active' : ''}`
                        },
                            React.createElement('img', {
                                src: slide.image,
                                alt: slide.title,
                                style: {
                                    position: 'absolute',
                                    top: 0,
                                    left: 0,
                                    width: '100%',
                                    height: '100%',
                                    objectFit: 'cover',
                                    zIndex: -1
                                },
                                onError: (e) => {
                                    console.error("Erreur chargement image:", slide.image);
                                    e.target.style.display = 'none';
                                    e.target.parentNode.style.backgroundColor = '#333'; // Fallback color
                                }
                            }),
                            React.createElement('div', { className: 'slide-overlay' }),
                            React.createElement('div', { className: 'slide-content' },
                                React.createElement('h1', { className: 'hero-title' }, slide.title),
                                React.createElement('p', { className: 'hero-subtitle' }, slide.subtitle),
                                React.createElement('div', { className: 'hero-actions' },
                                    user ?
                                        React.createElement('a', {
                                            href: '/dashboard',
                                            className: 'btn btn-primary btn-large'
                                        }, '🎯 Accéder au Tableau de Bord')
                                    : React.createElement(React.Fragment, null,
                                        React.createElement('a', {
                                            href: '/register',
                                            className: 'btn btn-primary btn-large'
                                        }, '🚀 Commencer l\'Aventure'),
                                        React.createElement('a', {
                                            href: '/catalogue',
                                            className: 'btn btn-outline-light btn-large'
                                        }, '📚 Découvrir Plus')
                                    )
                                )
                            )
                        )
                    )
                ),
                React.createElement('div', { className: 'carousel-indicators' },
                    slides.map((_, index) =>
                        React.createElement('button', {
                            key: index,
                            className: `indicator ${index === currentSlide ? 'active' : ''}`,
                            onClick: () => setCurrentSlide(index),
                            'aria-label': `Aller au slide ${index + 1}`
                        })
                    )
                )
            );
        }

        // Composant Fonctionnalités
        function FeaturesSection() {
            const features = [
                {
                    icon: '📚',
                    title: 'Contenus Culturels',
                    description: 'Histoires, contes, recettes culinaires et articles sur les traditions béninoises.'
                },
                {
                    icon: '🌍',
                    title: 'Multilinguisme',
                    description: 'Contenus disponibles dans les langues locales : Fon, Yoruba, Goun, et bien d\'autres.'
                },
                {
                    icon: '🗺️',
                    title: 'Par Région',
                    description: 'Explorez la culture par région : Atlantique, Borgou, Zou, Mono, et toutes les autres.'
                },
                {
                    icon: '🎭',
                    title: 'Arts & Spectacles',
                    description: 'Théâtre, danse, musique et performances traditionnelles'
                },
                {
                    icon: '🍲',
                    title: 'Gastronomie',
                    description: 'Recettes authentiques et secrets culinaires familiaux'
                },
                {
                    icon: '🏛️',
                    title: 'Histoire & Traditions',
                    description: 'Récits historiques et traditions ancestrales préservées'
                }
            ];

            return React.createElement('section', { id: 'features', className: 'features' },
                React.createElement('div', { className: 'container' },
                    React.createElement('div', { className: 'section-header' },
                        React.createElement('h2', null, 'Explorez la Culture Béninoise'),
                        React.createElement('p', null, 'Une immersion complète dans le patrimoine culturel du Bénin')
                    ),
                    React.createElement('div', { className: 'features-grid' },
                        features.map((feature, index) =>
                            React.createElement('div', { key: index, className: 'feature-card' },
                                React.createElement('div', { className: 'feature-icon' }, feature.icon),
                                React.createElement('h3', null, feature.title),
                                React.createElement('p', null, feature.description),
                                React.createElement('a', {
                                    href: `/catalogue?type=${feature.title}`,
                                    className: 'feature-link'
                                }, 'Découvrir →')
                            )
                        )
                    )
                )
            );
        }

        // Composant Patrimoine Culturel
        function CulturalHeritage() {
            const heritageItems = [
                {
                    src: "/adminlte/img/palais-royal.jpg",
                    title: "Palais Royaux d'Abomey",
                    description: "Patrimoine Mondial de l'UNESCO - Ancienne capitale du Royaume du Dahomey"
                },
                {
                    src: "/adminlte/img/porte_non_retour.webp",
                    title: "Porte du Non-Retour",
                    description: "Mémorial de Ouidah - Symbole de la traite négrière"
                },
                {
                    src: "/adminlte/img/tata_somba.jpg",
                    title: "Tata Somba",
                    description: "Architecture traditionnelle des montagnes de l'Atacora"
                },
                {
                    src: "/adminlte/img/festival_gelede.jpg",
                    title: "Festival Gelede",
                    description: "Cérémonie culturelle Yoruba classée au patrimoine immatériel de l'UNESCO"
                }
            ];

            return React.createElement('section', { id: 'heritage', className: 'heritage' },
                React.createElement('div', { className: 'container' },
                    React.createElement('div', { className: 'section-header' },
                        React.createElement('h2', null, 'Patrimoine Exceptionnel'),
                        React.createElement('p', null, 'Découvrez les joyaux culturels classés au patrimoine mondial')
                    ),
                    React.createElement('div', { className: 'heritage-gallery' },
                        heritageItems.map((item, index) =>
                            React.createElement('div', { key: index, className: 'heritage-item' },
                                React.createElement('div', { className: 'heritage-media' },
                                    React.createElement('img', {
                                        src: item.src,
                                        alt: item.title,
                                        loading: 'lazy',
                                        onError: (e) => {
                                            e.target.style.display = 'none';
                                            const fallback = e.target.nextElementSibling;
                                            if (fallback) fallback.style.display = 'flex';
                                        }
                                    }),
                                    React.createElement('div', { className: 'image-fallback' },
                                        React.createElement('div', { className: 'fallback-icon' }, '🏛️'),
                                        React.createElement('p', null, item.title)
                                    ),
                                    React.createElement('div', { className: 'heritage-overlay' },
                                        React.createElement('h3', null, item.title),
                                        React.createElement('p', null, item.description)
                                    )
                                )
                            )
                        )
                    )
                )
            );
        }

        // Composant Statistiques
        function StatisticsSection() {
            const [counters, setCounters] = useState([0, 0, 0, 0]);
            const targetValues = [1250, 89, 42, 350];

            useEffect(() => {
                const duration = 2000;
                const steps = 60;
                const stepDuration = duration / steps;

                const intervals = targetValues.map((target, index) => {
                    let current = 0;
                    const increment = target / steps;

                    const timer = setInterval(() => {
                        current += increment;
                        if (current >= target) {
                            current = target;
                            clearInterval(timer);
                        }

                        setCounters(prev => {
                            const newCounters = [...prev];
                            newCounters[index] = Math.floor(current);
                            return newCounters;
                        });
                    }, stepDuration);

                    return timer;
                });

                return () => intervals.forEach(interval => clearInterval(interval));
            }, []);

            return React.createElement('section', { id: 'statistics', className: 'statistics' },
                React.createElement('div', { className: 'container' },
                    React.createElement('div', { className: 'stats-grid' },
                        React.createElement('div', { className: 'stat-item' },
                            React.createElement('div', { className: 'stat-number' }, counters[0] + '+'),
                            React.createElement('div', { className: 'stat-label' }, 'Contenus Culturels')
                        ),
                        React.createElement('div', { className: 'stat-item' },
                            React.createElement('div', { className: 'stat-number' }, counters[1]),
                            React.createElement('div', { className: 'stat-label' }, 'Artistes Partenaires')
                        ),
                        React.createElement('div', { className: 'stat-item' },
                            React.createElement('div', { className: 'stat-number' }, counters[2]),
                            React.createElement('div', { className: 'stat-label' }, 'Communautés Actives')
                        ),
                        React.createElement('div', { className: 'stat-item' },
                            React.createElement('div', { className: 'stat-number' }, counters[3] + '+'),
                            React.createElement('div', { className: 'stat-label' }, 'Visiteurs Mensuels')
                        )
                    )
                )
            );
        }

        // Composant Témoignages
        function TestimonialsSection() {
            const testimonials = [
                {
                    name: "Dr. Koffi Adé",
                    role: "Anthropologue Culturel",
                    content: "Cette plateforme révolutionne la préservation de notre patrimoine. Un outil indispensable pour les générations futures.",
                    rating: 5
                },
                {
                    name: "Marie Dossou",
                    role: "Artisane Traditionnelle",
                    content: "Enfin une vitrine pour notre artisanat ! Mes créations sont maintenant visibles dans le monde entier.",
                    rating: 5
                },
                {
                    name: "Jean Sègbé",
                    role: "Enseignant",
                    content: "Mes élèves adorent découvrir notre culture à travers ces contenus interactifs et éducatifs.",
                    rating: 4
                }
            ];

            return React.createElement('section', { id: 'testimonials', className: 'testimonials' },
                React.createElement('div', { className: 'container' },
                    React.createElement('div', { className: 'section-header' },
                        React.createElement('h2', null, 'Ils Parlent de Nous'),
                        React.createElement('p', null, 'Découvrez les retours de notre communauté')
                    ),
                    React.createElement('div', { className: 'testimonials-grid' },
                        testimonials.map((testimonial, index) =>
                            React.createElement('div', { key: index, className: 'testimonial-card' },
                                React.createElement('div', { className: 'testimonial-header' },
                                    React.createElement('div', { className: 'testimonial-avatar' },
                                        React.createElement('div', { className: 'avatar-fallback' },
                                            testimonial.name.split(' ').map(n => n[0]).join('')
                                        )
                                    ),
                                    React.createElement('div', { className: 'testimonial-info' },
                                        React.createElement('h4', null, testimonial.name),
                                        React.createElement('p', null, testimonial.role)
                                    ),
                                    React.createElement('div', { className: 'testimonial-rating' },
                                        '⭐'.repeat(testimonial.rating)
                                    )
                                ),
                                React.createElement('p', { className: 'testimonial-content' }, `"${testimonial.content}"`)
                            )
                        )
                    )
                )
            );
        }

        // Composant Call to Action
        function CTASection({ user }) {
            return React.createElement('section', { className: 'cta-premium' },
                React.createElement('div', { className: 'cta-background' },
                    React.createElement('div', { className: 'cta-overlay' })
                ),
                React.createElement('div', { className: 'cta-content' },
                    React.createElement('h2', null, 'Prêt à Explorer la Culture Béninoise ?'),
                    React.createElement('p', null, 'Rejoignez notre communauté de passionnés et contribuez à préserver notre héritage culturel'),
                    React.createElement('div', { className: 'cta-actions' },
                        user ?
                            React.createElement('a', {
                                href: '/dashboard',
                                className: 'btn btn-primary btn-large btn-glow'
                            }, '🎯 Accéder au Tableau de Bord')
                        : React.createElement(React.Fragment, null,
                            React.createElement('a', {
                                href: '/register',
                                className: 'btn btn-primary btn-large btn-glow'
                            }, '🎉 Commencer l\'Aventure'),
                            React.createElement('a', {
                                href: '/login',
                                className: 'btn btn-outline-light btn-large'
                            }, '✨ J\'ai Déjà un Compte')
                        )
                    ),
                    React.createElement('div', { className: 'cta-features' },
                        React.createElement('span', null, '✅ Accès Gratuit'),
                        React.createElement('span', null, '✅ Contenu Illimité'),
                        React.createElement('span', null, '✅ Communauté Active')
                    )
                )
            );
        }

        // Composant Footer
        function Footer() {
            return React.createElement('footer', { className: 'footer-premium' },
                React.createElement('div', { className: 'container' },
                    React.createElement('div', { className: 'footer-content' },
                        React.createElement('div', { className: 'footer-brand' },
                            React.createElement('div', { className: 'logo' }, '🌍'),
                            React.createElement('h3', null, 'Culture Bénin'),
                            React.createElement('p', null, 'Votre porte d\'entrée vers le patrimoine culturel béninois')
                        ),
                        React.createElement('div', { className: 'footer-links' },
                            React.createElement('div', { className: 'link-group' },
                                React.createElement('h4', null, 'Explorer'),
                                React.createElement('a', { href: '/catalogue' }, 'Découvrir'),
                                React.createElement('a', { href: '#heritage' }, 'Patrimoine'),
                                React.createElement('a', { href: '#statistics' }, 'Impact')
                            ),
                            React.createElement('div', { className: 'link-group' },
                                React.createElement('h4', null, 'Ressources'),
                                React.createElement('a', { href: '/blog' }, 'Blog Culturel'),
                                React.createElement('a', { href: '/medias' }, 'Médiathèque'),
                                React.createElement('a', { href: '/events' }, 'Événements')
                            ),
                            React.createElement('div', { className: 'link-group' },
                                React.createElement('h4', null, 'Communauté'),
                                React.createElement('a', { href: '/contribute' }, 'Devenir Contributeur'),
                                React.createElement('a', { href: '/partners' }, 'Partenariats'),
                                React.createElement('a', { href: '/contact' }, 'Nous Contacter')
                            )
                        )
                    ),
                    React.createElement('div', { className: 'footer-bottom' },
                        React.createElement('p', null, '© 2024 Culture Bénin. Tous droits réservés.'),
                        React.createElement('div', { className: 'social-links' },
                            React.createElement('a', { href: '#', 'aria-label': 'Facebook' }, '📘'),
                            React.createElement('a', { href: '#', 'aria-label': 'Instagram' }, '📷'),
                            React.createElement('a', { href: '#', 'aria-label': 'YouTube' }, '📺'),
                            React.createElement('a', { href: '#', 'aria-label': 'Twitter' }, '🐦')
                        )
                    )
                )
            );
        }

        // ==================== RENDU REACT ====================
        const container = document.getElementById('app');
        if (container) {
            const root = ReactDOM.createRoot(container);
            root.render(React.createElement(App));
        }
    </script>
</body>
</html>
