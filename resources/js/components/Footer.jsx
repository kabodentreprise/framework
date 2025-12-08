import React from 'react';

function Footer() {
    const currentYear = new Date().getFullYear();

    return (
        <footer className="bg-dark text-white py-4">
            <div className="container">
                <div className="row">
                    <div className="col-md-6">
                        <h5>Culture Bénin</h5>
                        <p>Plateforme de promotion du patrimoine culturel et linguistique béninois.</p>
                    </div>
                    <div className="col-md-3">
                        <h5>Liens rapides</h5>
                        <ul className="list-unstyled">
                            <li><a href="#features" className="text-white text-decoration-none">Fonctionnalités</a></li>
                            <li><a href="#about" className="text-white text-decoration-none">À propos</a></li>
                            <li><a href="#contact" className="text-white text-decoration-none">Contact</a></li>
                        </ul>
                    </div>
                    <div className="col-md-3">
                        <h5>Contact</h5>
                        <p>
                            <i className="bi bi-envelope"></i> contact@culturebenin.bj<br />
                            <i className="bi bi-phone"></i> +229 XX XX XX XX
                        </p>
                    </div>
                </div>
                <hr />
                <div className="text-center">
                    <p>&copy; {currentYear} Culture Bénin. Tous droits réservés.</p>
                </div>
            </div>
        </footer>
    );
}

export default Footer;
