import React from 'react';

function About() {
    const stats = [
        { number: '500+', label: 'Contenus culturels', color: 'primary' },
        { number: '12', label: 'Langues locales', color: 'success' },
        { number: '8', label: 'Régions couvertes', color: 'warning' },
        { number: '100+', label: 'Contributeurs actifs', color: 'info' }
    ];

    return (
        <section id="about" className="py-5 bg-light">
            <div className="container">
                <div className="row align-items-center">
                    <div className="col-lg-6">
                        <h2 className="display-5 fw-bold mb-4">Notre Mission</h2>
                        <p className="lead mb-4">
                            Préserver et promouvoir le riche patrimoine culturel et linguistique du Bénin
                            grâce à une plateforme numérique collaborative.
                        </p>
                        <div className="row">
                            {stats.map((stat, index) => (
                                <div key={index} className="col-6 mb-3">
                                    <h4 className={`text-${stat.color}`}>{stat.number}</h4>
                                    <p className="mb-0">{stat.label}</p>
                                </div>
                            ))}
                        </div>
                    </div>
                    <div className="col-lg-6">
                        <div className="row g-3">
                            {['Tradition', 'Art', 'Cuisine', 'Musique'].map((title, index) => (
                                <div key={index} className="col-6">
                                    <div className="card culture-card">
                                        <img
                                            src={`https://via.placeholder.com/300x200?text=${title}`}
                                            className="card-img-top"
                                            alt={title}
                                        />
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    );
}

export default About;
