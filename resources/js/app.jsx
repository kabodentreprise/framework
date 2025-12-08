// resources/js/app.jsx
import React, { useState, useEffect } from 'react';
import { createRoot } from 'react-dom/client';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';

// Import des pages
import HomePage from './pages/HomePage';
import RegisterPage from './pages/RegisterPage';
import LoginPage from './pages/LoginPage';

// Layout principal
function AppLayout({ children }) {
    return (
        <div className="app">
            {children}
        </div>
    );
}

function App() {
    return (
        <Router>
            <Routes>
                <Route path="/" element={
                    <AppLayout>
                        <HomePage />
                    </AppLayout>
                } />
                <Route path="/register" element={
                    <AppLayout>
                        <RegisterPage />
                    </AppLayout>
                } />
                <Route path="/login" element={
                    <AppLayout>
                        <LoginPage />
                    </AppLayout>
                } />
                <Route path="/dashboard" element={
                    <AppLayout>
                        <div>Dashboard en cours de développement...</div>
                    </AppLayout>
                } />
            </Routes>
        </Router>
    );
}

// Point d'entrée
const container = document.getElementById('app');
if (container) {
    const root = createRoot(container);
    root.render(
        <React.StrictMode>
            <App />
        </React.StrictMode>
    );
}
