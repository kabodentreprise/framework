import React, { useState, useEffect } from 'react';
import axios from 'axios';
import Header from './Header';
import Hero from './Hero';
import Features from './Features';
import About from './About';
import CTA from './CTA';
import Footer from './Footer';

function App() {
    const [user, setUser] = useState(null);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        // Vérifier si l'utilisateur est connecté
        axios.get('/api/user')
            .then(response => {
                setUser(response.data);
            })
            .catch(() => {
                setUser(null);
            })
            .finally(() => {
                setLoading(false);
            });
    }, []);

    const handleLogout = async () => {
        try {
            await axios.post('/logout');
            setUser(null);
            window.location.href = '/';
        } catch (error) {
            console.error('Erreur de déconnexion:', error);
        }
    };

    if (loading) {
        return (
            <div className="d-flex justify-content-center align-items-center min-vh-100">
                <div className="spinner-border text-primary" role="status">
                    <span className="visually-hidden">Chargement...</span>
                </div>
            </div>
        );
    }

    return (
        <div className="App">
            <Header user={user} onLogout={handleLogout} />
            <Hero user={user} />
            <Features />
            <About />
            <CTA user={user} />
            <Footer />
        </div>
    );
}

export default App;
