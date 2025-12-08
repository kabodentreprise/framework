// resources/js/components/Navbar.jsx
import React, { useState, useEffect } from 'react';

export default function Navbar({ user, onLogout }) {
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

    return (
        <nav className={`navbar ${isScrolled ? 'scrolled' : ''}`}>
            <div className="nav-container">
                <div className="nav-brand">
                    <div className="logo">🌍</div>
                    <span>Culture Bénin</span>
                </div>

                <button
                    className="nav-toggle"
                    onClick={() => setIsMenuOpen(!isMenuOpen)}
                    aria-label="Toggle menu"
                >
                    ☰
                </button>

                <div className={`nav-menu ${isMenuOpen ? 'active' : ''}`}>
                    <a href="#features" className="nav-link" onClick={() => setIsMenuOpen(false)}>Découvrir</a>
                    <a href="#heritage" className="nav-link" onClick={() => setIsMenuOpen(false)}>Patrimoine</a>
                    <a href="#statistics" className="nav-link" onClick={() => setIsMenuOpen(false)}>Impact</a>
                    <a href="#testimonials" className="nav-link" onClick={() => setIsMenuOpen(false)}>Témoignages</a>

                    <div className="nav-auth">
                        {user ? (
                            <>
                                <a href="/dashboard" className="btn btn-primary">
                                    Tableau de bord
                                </a>
                                <button onClick={handleLogoutClick} className="btn btn-outline">
                                    Déconnexion
                                </button>
                            </>
                        ) : (
                            <>
                                <a href="/login" className="btn btn-outline">
                                    Connexion
                                </a>
                                <a href="/register" className="btn btn-primary">
                                    S'inscrire
                                </a>
                            </>
                        )}
                    </div>
                </div>
            </div>
        </nav>
    );
}
