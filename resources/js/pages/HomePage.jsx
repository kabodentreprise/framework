// resources/js/pages/HomePage.jsx
import React, { useState, useEffect } from 'react';

// Import des sous-composants existants
import Navbar from '../components/Navbar';
import Footer from '../components/Footer';

export default function HomePage() {
    const [user, setUser] = useState(null);
    const [isLoading, setIsLoading] = useState(true);

    useEffect(() => {
        const timer = setTimeout(() => {
            setIsLoading(false);
            const userData = localStorage.getItem('user');
            setUser(userData ? JSON.parse(userData) : null);
        }, 1000);
        return () => clearTimeout(timer);
    }, []);

    const handleLogout = () => {
        setUser(null);
        localStorage.removeItem('user');
        window.location.href = '/';
    };

    if (isLoading) {
        return <div className="flex justify-center items-center h-screen bg-gray-100">Chargement...</div>;
    }

    return (
        <div className="app flex flex-col min-h-screen">
            <Navbar user={user} onLogout={handleLogout} />

            <main className="flex-grow">
                {/* Hero Section Placeholder */}
                <div className="bg-indigo-700 text-white py-20 px-4 text-center">
                    <h1 className="text-4xl font-bold mb-4">Bienvenue sur Culture Bénin</h1>
                    <p className="text-xl">Découvrez la richesse culturelle de notre pays.</p>
                </div>

                <div className="container mx-auto py-12 px-4 text-center text-gray-600">
                    <p>Les autres sections sont en construction...</p>
                </div>
            </main>

            <Footer />
        </div>
    );
}
