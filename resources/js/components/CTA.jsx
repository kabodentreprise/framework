import React from 'react';

function CTA({ user }) {
    return (
        <section className="py-5 bg-primary text-white">
            <div className="container text-center">
                <h2 className="display-5 fw-bold mb-4">Rejoignez notre communauté</h2>
                <p className="lead mb-4">
                    Contribuez à préserver la culture béninoise pour les générations futures
                </p>
                {user ? (
                    <a href="/dashboard" className="btn btn-light btn-lg">
                        <i className="bi bi-speedometer2"></i> Accéder au tableau de bord
                    </a>
                ) : (
                    <>
                        <a href="/register" className="btn btn-light btn-lg me-3">
                            <i className="bi bi-person-plus"></i> S'inscrire maintenant
                        </a>
                        <a href="/login" className="btn btn-outline-light btn-lg">
                            <i className="bi bi-box-arrow-in-right"></i> Se connecter
                        </a>
                    </>
                )}
            </div>
        </section>
    );
}

export default CTA;
