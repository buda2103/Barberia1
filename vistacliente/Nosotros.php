<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barbería Mito</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;500;600;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #d4af37;
            --secondary: #1a1a1a;
            --accent: #8b4513;
            --light: #f5f5f5;
            --dark: #333;
            --white: #fff;
            --gradient: linear-gradient(135deg, var(--secondary) 0%, #333 100%);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Oswald', sans-serif;
            color: var(--dark);
            background-color: var(--light);
            line-height: 1.6;
        }
        
        h1, h2, h3, h4 {
            font-family: 'Oswald', sans-serif;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        /* Header & Navigation */
        header {
            background: var(--gradient);
            color: var(--white);
            padding: 0;
            position: relative;
        }
        
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .contact-info {
            display: flex;
            gap: 20px;
        }
        
        .contact-info span {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 0.9em;
        }
        
        .social-icons {
            display: flex;
            gap: 15px;
        }
        
        .social-icons a {
            color: var(--primary);
            font-size: 1.2em;
            transition: all 0.3s ease;
        }
        
        .social-icons a:hover {
            color: var(--white);
            transform: translateY(-3px);
        }
        
        nav {
            padding: 20px 0;
        }
        
        nav ul {
            display: flex;
            justify-content: center;
            gap: 30px;
            list-style: none;
        }
        
        nav a {
            color: var(--white);
            text-decoration: none;
            font-weight: 500;
            text-transform: uppercase;
            font-size: 1em;
            transition: color 0.3s ease;
            position: relative;
            padding: 5px 0;
        }
        
        nav a:hover {
            color: var(--primary);
        }
        
        nav a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background-color: var(--primary);
            transition: width 0.3s ease;
        }
        
        nav a:hover::after {
            width: 100%;
        }
        
        .hero {
            text-align: center;
            padding: 100px 0;
            background: url('barbershop-background.jpg') center/cover no-repeat;
            position: relative;
            z-index: 1;
        }
        
        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.7);
            z-index: -1;
        }
        
        .hero h1 {
            font-size: 3.5em;
            margin-bottom: 20px;
            color: var(--primary);
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }
        
        .hero p {
            font-size: 1.2em;
            max-width: 700px;
            margin: 0 auto 40px;
            color: var(--white);
        }
        
        .btn {
            display: inline-block;
            padding: 12px 30px;
            background-color: var(--primary);
            color: var(--secondary);
            text-decoration: none;
            font-weight: 600;
            border-radius: 4px;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            border: 2px solid var(--primary);
        }
        
        .btn:hover {
            background-color: transparent;
            color: var(--primary);
        }
        
        .btn-outline {
            background-color: transparent;
            color: var(--primary);
        }
        
        .btn-outline:hover {
            background-color: var(--primary);
            color: var(--secondary);
        }
        
        /* Sections */
        .section {
            padding: 80px 0;
        }
        
        .section-dark {
            background-color: var(--secondary);
            color: var(--white);
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 60px;
            position: relative;
            font-size: 2.5em;
            color: var(--secondary);
        }
        
        .section-dark .section-title {
            color: var(--white);
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background-color: var(--primary);
        }
        
        .section-subtitle {
            text-align: center;
            max-width: 800px;
            margin: -40px auto 60px;
            font-size: 1.1em;
            color: #666;
        }
        
        .section-dark .section-subtitle {
            color: #ccc;
        }
        
        /* About Section */
        .about-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 40px;
            align-items: center;
        }
        
        .about-image {
            position: relative;
            height: 100%;
        }
        
        .about-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        
        .about-image::before {
            content: '';
            position: absolute;
            top: -20px;
            left: -20px;
            width: 100%;
            height: 100%;
            border: 4px solid var(--primary);
            border-radius: 8px;
            z-index: -1;
        }
        
        .about-content h3 {
            font-size: 1.8em;
            margin-bottom: 20px;
            color: var(--secondary);
            position: relative;
            display: inline-block;
        }
        
        .about-content h3::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 60px;
            height: 3px;
            background-color: var(--primary);
        }
        
        .about-content p {
            margin-bottom: 20px;
            font-size: 1.05em;
        }
        
        /* Services Section */
        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(270px, 1fr));
            gap: 30px;
        }
        
        .service-card {
            background-color: var(--white);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.2);
        }
        
        .service-image {
            height: 200px;
            overflow: hidden;
        }
        
        .service-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .service-card:hover .service-image img {
            transform: scale(1.1);
        }
        
        .service-content {
            padding: 25px;
        }
        
        .service-content h3 {
            font-size: 1.5em;
            margin-bottom: 15px;
            color: var(--secondary);
        }
        
        .service-content p {
            margin-bottom: 20px;
            color: #666;
        }
        
        .service-price {
            font-weight: 700;
            color: var(--primary);
            font-size: 1.3em;
            margin-bottom: 15px;
            display: block;
        }
        
        /* Stats Section */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 30px;
            margin: 60px 0;
        }
        
        .stat-box {
            text-align: center;
            padding: 30px 20px;
            background-color: var(--white);
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        
        .section-dark .stat-box {
            background-color: rgba(255,255,255,0.05);
            box-shadow: none;
        }
        
        .stat-box:hover {
            transform: translateY(-10px);
        }
        
        .stat-icon {
            font-size: 2.5em;
            color: var(--primary);
            margin-bottom: 20px;
        }
        
        .stat-number {
            font-size: 2.5em;
            font-weight: 700;
            color: var(--secondary);
            margin-bottom: 10px;
        }
        
        .section-dark .stat-number {
            color: var(--primary);
        }
        
        .stat-description {
            font-size: 1em;
            color: #666;
        }
        
        .section-dark .stat-description {
            color: #ccc;
        }
        
        /* Team Section */
        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
        }
        
        .team-member {
            background-color: var(--white);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        
        .team-member:hover {
            transform: translateY(-10px);
        }
        
        .member-image {
            height: 300px;
            overflow: hidden;
            position: relative;
        }
        
        .member-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .team-member:hover .member-image img {
            transform: scale(1.1);
        }
        
        .member-social {
            position: absolute;
            bottom: -50px;
            left: 0;
            width: 100%;
            display: flex;
            justify-content: center;
            gap: 15px;
            padding: 15px 0;
            background-color: rgba(26,26,26,0.8);
            transition: bottom 0.3s ease;
        }
        
        .team-member:hover .member-social {
            bottom: 0;
        }
        
        .member-social a {
            color: var(--white);
            font-size: 1.2em;
            transition: color 0.3s ease;
        }
        
        .member-social a:hover {
            color: var(--primary);
        }
        
        .member-info {
            padding: 25px;
            text-align: center;
        }
        
        .member-info h3 {
            font-size: 1.5em;
            margin-bottom: 5px;
            color: var(--secondary);
        }
        
        .member-position {
            color: var(--primary);
            font-weight: 500;
            margin-bottom: 15px;
            display: block;
        }
        
        /* Testimonials */
        .testimonials-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .testimonial {
            background-color: var(--white);
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            position: relative;
        }
        
        .testimonial::before {
            content: '"';
            position: absolute;
            top: 20px;
            left: 20px;
            font-size: 4em;
            color: var(--primary);
            opacity: 0.3;
            font-family: 'Playfair Display', serif;
            line-height: 0.6;
        }
        
        .testimonial-content {
            font-style: italic;
            margin-bottom: 20px;
            padding-left: 40px;
        }
        
        .testimonial-author {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .author-image {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            overflow: hidden;
        }
        
        .author-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .author-info h4 {
            font-size: 1.1em;
            margin-bottom: 5px;
            color: var(--secondary);
        }
        
        .author-info span {
            font-size: 0.9em;
            color: #666;
        }
        
        /* CTA Section */
        .cta-section {
            background: var(--gradient);
            text-align: center;
            padding: 80px 0;
            position: relative;
            overflow: hidden;
        }
        
        .cta-content {
            position: relative;
            z-index: 1;
        }
        
        .cta-section h2 {
            font-size: 2.5em;
            color: var(--white);
            margin-bottom: 20px;
        }
        
        .cta-section p {
            color: #ddd;
            margin-bottom: 30px;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .cta-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
        }
        
        /* Footer */
        footer {
            background-color: var(--secondary);
            color: var(--white);
            padding: 60px 0 20px;
        }
        
        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
        }
        
        .footer-logo {
            margin-bottom: 20px;
        }
        
        .footer-logo img {
            max-width: 180px;
        }
        
        .footer-about p {
            margin-bottom: 20px;
            color: #bbb;
        }
        
        .footer-title {
            font-size: 1.3em;
            margin-bottom: 20px;
            color: var(--white);
            position: relative;
            display: inline-block;
        }
        
        .footer-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 50px;
            height: 2px;
            background-color: var(--primary);
        }
        
        .footer-links {
            list-style: none;
        }
        
        .footer-links li {
            margin-bottom: 12px;
        }
        
        .footer-links a {
            color: #bbb;
            text-decoration: none;
            transition: color 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .footer-links a:hover {
            color: var(--primary);
        }
        
        .footer-links i {
            color: var(--primary);
            font-size: 0.9em;
        }
        
        .footer-contact p {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
            color: #bbb;
        }
        
        .footer-contact i {
            color: var(--primary);
            font-size: 1.2em;
            width: 20px;
        }
        
        .footer-bottom {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid rgba(255,255,255,0.1);
        }
        
        .footer-bottom p {
            font-size: 0.9em;
            color: #888;
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .hero h1 {
                font-size: 3em;
            }
            
            .about-grid {
                grid-template-columns: 1fr;
            }
            
            .about-image {
                order: -1;
                margin-bottom: 30px;
            }
            
            .about-image img {
                height: 400px;
            }
        }
        
        @media (max-width: 768px) {
            .top-bar {
                flex-direction: column;
                gap: 15px;
            }
            
            nav ul {
                flex-direction: column;
                align-items: center;
                gap: 15px;
            }
            
            .hero {
                padding: 80px 0;
            }
            
            .hero h1 {
                font-size: 2.5em;
            }
            
            .section {
                padding: 60px 0;
            }
            
            .section-title {
                font-size: 2em;
            }
            
            .cta-buttons {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <div class="top-bar">
                <div class="contact-info">
                    <span><i class="fas fa-map-marker-alt"></i> Calle Principal 123</span>
                    <span><i class="fas fa-phone"></i> +34 123 456 789</span>
                </div>
                <div class="social-icons">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
            <nav>
                <ul>
                <li><a href="../Index.php">Inicio</a></li>
                <li><a href="#nosotros">Nosotros</a></li>
                    <li><a href="#equipo">Equipo</a></li>
                    <li><a href="#contacto">Contacto</a></li>
                </ul>
            </nav>
        </div>
        <div class="hero" id="inicio">
            <div class="container">
                <h1>BARBERÍA MITO</h1>
                <p>Tu experiencia de barbería exclusiva. Donde la tradición se encuentra con el estilo moderno para crear un lugar único dedicado al cuidado del hombre contemporáneo.</p>
                <div class="cta-buttons">
                    <a href="#servicios" class="btn">Nuestros Servicios</a>
                    <a href="../vistacliente/Citas.php" class="btn btn-outline">Reserva Ahora</a>
                </div>
            </div>
        </div>
    </header>

    <section class="section" id="nosotros">
        <div class="container">
            <h2 class="section-title">Nuestra Historia</h2>
            <p class="section-subtitle">En Barbería Mito creamos experiencias únicas en cada corte, donde cuidamos cada detalle para que nuestros clientes se sientan especiales.</p>
            
            <div class="about-grid">
                <div class="about-content">
                    <h3>La experiencia completa</h3>
                    <p>Barbería Mito es más que un simple lugar para cortarse el pelo. Es un espacio donde la camaradería, el respeto y el buen gusto se unen para crear una atmósfera única. Fomentamos una comunidad donde todos son bienvenidos y donde el cuidado personal se convierte en una experiencia gratificante.</p>
                    <p>Nuestro servicio combina técnicas tradicionales con tendencias modernas, trabajando con dedicación para lograr el mejor resultado en cada cliente.</p>
                    <a href="#" class="btn">Conoce más</a>
                </div>
                <div class="about-image">
                    <img src="/api/placeholder/500/400" alt="Barbería Mito Interior">
                </div>
            </div>
        </div>
    </section>

    <section class="section section-dark">
        <div class="container">
            <h2 class="section-title">Lo Que Nos Hace Diferentes</h2>
            <div class="stats-container">
                <div class="stat-box">
                    <div class="stat-icon"><i class="fas fa-graduation-cap"></i></div>
                    <div class="stat-number">+5</div>
                    <div class="stat-description">Años de Experiencia</div>
                </div>
                <div class="stat-box">
                    <div class="stat-icon"><i class="fas fa-users"></i></div>
                    <div class="stat-number">+3.500</div>
                    <div class="stat-description">Clientes Satisfechos</div>
                </div>
                <div class="stat-box">
                    <div class="stat-icon"><i class="fas fa-cut"></i></div>
                    <div class="stat-number">+8</div>
                    <div class="stat-description">Profesionales</div>
                </div>
                <div class="stat-box">
                    <div class="stat-icon"><i class="fas fa-star"></i></div>
                    <div class="stat-number">95%</div>
                    <div class="stat-description">Satisfacción</div>
                </div>
            </div>
        </div>
    </section>

    
    </section>

    <section class="section section-dark" id="equipo">
        <div class="container">
            <h2 class="section-title">Nuestro Equipo</h2>
            <p class="section-subtitle">El verdadero valor de Barbería Mito está en nuestro equipo de profesionales apasionados por su trabajo.</p>
            
            <div class="team-grid">
                <div class="team-member">
                    <div class="member-image">
                        <img src="/api/placeholder/400/500" alt="Barbero Miguel">
                        <div class="member-social">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                        </div>
                    </div>
                    <div class="member-info">
                        <h3>Miguel Sánchez</h3>
                        <span class="member-position">Maestro Barbero</span>
                        <p>Con más de 10 años de experiencia, Miguel es especialista en cortes clásicos y diseño de barba.</p>
                    </div>
                </div>
                
                <div class="team-member">
                    <div class="member-image">
                        <img src="/api/placeholder/400/500" alt="Barbero Carlos">
                        <div class="member-social">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                        </div>
                    </div>
                    <div class="member-info">
                        <h3>Carlos Martínez</h3>
                        <span class="member-position">Estilista Senior</span>
                        <p>Especialista en tendencias modernas y técnicas de coloración, Carlos aporta un toque contemporáneo a nuestro equipo.</p>
                    </div>
                </div>
                
                <div class="team-member">
                    <div class="member-image">
                        <img src="/api/placeholder/400/500" alt="Barbera Ana">
                        <div class="member-social">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                        </div>
                    </div>
                    <div class="member-info">
                        <h3>Ana López</h3>
                        <span class="member-position">Experta en Tratamientos</span>
                        <p>Ana lidera nuestros servicios de tratamientos capilares, con formación especializada en soluciones para todo tipo de cabello.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <h2 class="section-title">El Valor