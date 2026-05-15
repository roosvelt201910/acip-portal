<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - ¡Perdido en el Espacio! | Instituto ACIP</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;600;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --space-dark: #0f172a;
            --space-light: #1e293b;
            --alien-green: #4ade80;
            --glow: #22d3ee;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: radial-gradient(circle at center, #1e293b 0%, #020617 100%);
            height: 100vh;
            width: 100vw;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            position: relative;
        }

        /* Stars Background */
        .stars {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            background-image: 
                radial-gradient(1px 1px at 25px 5px, white, transparent),
                radial-gradient(1px 1px at 50px 25px, white, transparent),
                radial-gradient(1px 1px at 125px 20px, white, transparent),
                radial-gradient(1.5px 1.5px at 50px 75px, white, transparent),
                radial-gradient(2px 2px at 15px 125px, white, transparent),
                radial-gradient(2.5px 2.5px at 110px 80px, white, transparent);
            background-size: 350px 350px;
            animation: starTwinkle 100s linear infinite;
            opacity: 0.6;
        }

        .container {
            text-align: center;
            z-index: 10;
            padding: 2rem;
            max-width: 600px;
        }

        /* Glitch Text Effect */
        .error-code {
            font-size: 8rem;
            font-weight: 900;
            line-height: 1;
            margin-bottom: 0.5rem;
            position: relative;
            color: white;
            text-shadow: 2px 2px 0px var(--alien-green), -2px -2px 0px #ab4bff;
            animation: glitch 3s infinite;
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
            font-weight: 600;
            background: linear-gradient(90deg, #fff, var(--glow));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        p {
            font-size: 1.25rem;
            line-height: 1.6;
            color: #94a3b8;
            margin-bottom: 2.5rem;
        }

        /* Animated SVG Container */
        .illustration-box {
            margin: 2rem auto;
            width: 280px;
            height: 280px;
            position: relative;
            animation: float 6s ease-in-out infinite;
        }

        /* Button */
        .btn-home {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 16px 36px;
            background: rgba(255, 255, 255, 0.1);
            color: var(--alien-green);
            text-decoration: none;
            border: 1px solid var(--alien-green);
            border-radius: 50px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            box-shadow: 0 0 15px rgba(74, 222, 128, 0.2);
        }

        .btn-home:hover {
            background: var(--alien-green);
            color: #020617;
            box-shadow: 0 0 30px rgba(74, 222, 128, 0.6);
            transform: translateY(-3px) scale(1.05);
        }

        /* Animations */
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }

        @keyframes glitch {
            0% { transform: translate(0); }
            2% { transform: translate(-2px, 2px); }
            4% { transform: translate(2px, -2px); }
            6% { transform: translate(0); }
            100% { transform: translate(0); }
        }

        @keyframes starTwinkle {
            from { background-position: 0 0; }
            to { background-position: 0 1000px; }
        }

        @keyframes beamPulsate {
            0%, 100% { opacity: 0.3; height: 0; }
            50% { opacity: 0.6; height: 100px; }
        }

        /* SVG Specific Animations */
        .alien-eye { animation: blink 4s infinite; transform-origin: center; }
        .ufo-lights { animation: disco 2s infinite; }
        
        @keyframes blink {
            0%, 96%, 100% { transform: scaleY(1); }
            98% { transform: scaleY(0.1); }
        }

        @keyframes disco {
            0%, 100% { fill: #ef4444; }
            33% { fill: #3b82f6; }
            66% { fill: #22c55e; }
        }

    </style>
</head>
<body>
    <div class="stars"></div>
    
    <div class="container">
        <div class="illustration-box">
            <!-- Space Alien SVG -->
            <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                <!-- Beam -->
                <path d="M100 130 L70 180 L130 180 Z" fill="url(#beamGradient)" opacity="0.4">
                    <animate attributeName="opacity" values="0.2;0.5;0.2" dur="3s" repeatCount="indefinite" />
                </path>
                <defs>
                    <linearGradient id="beamGradient" x1="0%" y1="0%" x2="0%" y2="100%">
                        <stop offset="0%" stop-color="var(--alien-green)" stop-opacity="0.8" />
                        <stop offset="100%" stop-color="var(--alien-green)" stop-opacity="0" />
                    </linearGradient>
                </defs>

                <!-- UFO Body -->
                <ellipse cx="100" cy="130" rx="60" ry="20" fill="#cbd5e1" />
                <ellipse cx="100" cy="125" rx="35" ry="25" fill="#94a3b8" opacity="0.5" />
                
                <!-- Bubble -->
                <path d="M70 120 A 30 30 0 0 1 130 120" stroke="#bae6fd" stroke-width="2" fill="rgba(186, 230, 253, 0.3)" />
                
                <!-- Alien -->
                <circle cx="100" cy="110" r="12" fill="#4ade80" /> <!-- Head -->
                <ellipse cx="96" cy="108" rx="2" ry="3" fill="black" class="alien-eye" /> <!-- Eye L -->
                <ellipse cx="104" cy="108" rx="2" ry="3" fill="black" class="alien-eye" /> <!-- Eye R -->
                <path d="M98 115 Q100 117 102 115" stroke="black" stroke-width="1" fill="none" /> <!-- Smile -->
                
                <!-- Lights -->
                <circle cx="55" cy="130" r="3" class="ufo-lights" style="animation-delay: 0s" />
                <circle cx="78" cy="138" r="3" class="ufo-lights" style="animation-delay: 0.5s" />
                <circle cx="100" cy="140" r="3" class="ufo-lights" style="animation-delay: 1s" />
                <circle cx="122" cy="138" r="3" class="ufo-lights" style="animation-delay: 1.5s" />
                <circle cx="145" cy="130" r="3" class="ufo-lights" style="animation-delay: 2s" />
            </svg>
        </div>

        <div class="error-code">404</div>
        <h1>¡Houston, tenemos un problema!</h1>
        <p>Parece que el portal que buscas fue abducido o nunca existió en esta dimensión. Nuestro amigo alienígena no sabe cómo llegar ahí.</p>

        <a href="<?= url('/') ?>" class="btn-home">
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            Regresar a la Tierra
        </a>
    </div>
</body>
</html>
