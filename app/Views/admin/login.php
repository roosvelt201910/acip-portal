<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión | ACIP Panel Administrativo</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=AC+Inter:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #0f172a; /* Slate 900 */
            --primary-light: #1e293b; /* Slate 800 */
            --accent-color: #2563eb; /* Blue 600 */
            --accent-hover: #1d4ed8; /* Blue 700 */
            --text-color: #334155; /* Slate 700 */
            --text-light: #64748b; /* Slate 500 */
            --bg-color: #f8fafc; /* Slate 50 */
            --error-color: #ef4444; /* Red 500 */
            --error-bg: #fef2f2; /* Red 50 */
            --white: #ffffff;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background-color: var(--bg-color);
            min-height: 100vh;
            display: flex;
            color: var(--text-color);
        }
        
        .login-split {
            display: flex;
            width: 100%;
            height: 100vh;
            overflow: hidden;
        }

        /* Left Side - Image */
        .split-image {
            flex: 1.2;
            background-image: linear-gradient(rgba(15, 23, 42, 0.6), rgba(15, 23, 42, 0.4)), url('<?= url("assets/images/login-side.jpg") ?>');
            background-size: cover;
            background-position: center;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 60px;
            color: white;
        }

        .image-content {
            position: relative;
            z-index: 1;
            max-width: 600px;
        }

        .image-content h2 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 16px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }

        .image-content p {
            font-size: 16px;
            opacity: 0.9;
            line-height: 1.6;
            text-shadow: 0 1px 2px rgba(0,0,0,0.3);
        }

        /* Right Side - Form */
        .split-form {
            flex: 0.8;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            position: relative;
            min-width: 450px;
            box-shadow: -10px 0 25px rgba(0,0,0,0.05);
        }

        .form-container {
            width: 100%;
            max-width: 400px;
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .brand-logo {
            width: 80px;
            height: 80px;
            background-color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 24px;
            box-shadow: var(--shadow-md);
            border: 1px solid #e2e8f0;
            overflow: hidden;
        }
        
        .brand-logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .login-header {
            margin-bottom: 32px;
        }

        .login-header h1 {
            color: var(--primary-color);
            font-size: 28px;
            font-weight: 700;
            letter-spacing: -0.025em;
            margin-bottom: 8px;
        }
        
        .login-header p {
            color: var(--text-light);
            font-size: 15px;
        }
        
        .alert {
            padding: 14px;
            border-radius: 10px;
            margin-bottom: 25px;
            font-size: 14px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from { transform: translateY(-10px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        
        .alert-error {
            background-color: var(--error-bg);
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .alert-error i {
            color: var(--error-color);
            margin-top: 2px;
        }
        
        .form-group {
            margin-bottom: 24px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: var(--primary-color);
            font-weight: 600;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            color: var(--text-light);
            transition: color 0.3s;
            pointer-events: none;
            z-index: 10;
        }
        
        .form-control {
            width: 100%;
            padding: 14px 16px 14px 45px;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            font-size: 15px;
            color: var(--primary-color);
            transition: all 0.2s ease;
            background-color: #f8fafc;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--accent-color);
            background-color: var(--white);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        }

        .form-control:focus + .input-icon {
            color: var(--accent-color);
        }
        
        .btn {
            width: 100%;
            padding: 16px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: var(--shadow-lg);
        }
        
        .btn:hover {
            background-color: var(--primary-light);
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .login-footer {
            text-align: center;
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1px solid #f1f5f9;
        }
        
        .login-footer a {
            color: var(--text-light);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: color 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        
        .login-footer a:hover {
            color: var(--primary-color);
        }

        /* Mobile Responsive */
        @media (max-width: 900px) {
            .split-image {
                display: none;
            }
            .split-form {
                flex: 1;
                min-width: auto;
            }
        }
    </style>
</head>
<body>
    <div class="login-split">
        <!-- Left Side: Image -->
        <div class="split-image">
            <div class="image-content">
                <h2>Excelencia Académica</h2>
                <p>Instituto de Educación Superior Tecnológico Privado ACIP. Formando profesionales para el futuro.</p>
            </div>
        </div>

        <!-- Right Side: Form -->
        <div class="split-form">
            <div class="form-container">
                <div class="brand-logo">
                    <img src="<?= url('assets/images/logo-acip.png') ?>" alt="Logo ACIP">
                </div>
                
                <div class="login-header">
                    <h1>Panel Administrativo</h1>
                    <p>Bienvenido de nuevo. Ingrese sus credenciales.</p>
                </div>
                
                <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span>
                        <?= e($_SESSION['error']) ?>
                        <?php unset($_SESSION['error']); ?>
                    </span>
                </div>
                <?php endif; ?>
                
                <form method="POST" action="<?= url('admin/login') ?>">
                    <div class="form-group">
                        <label for="email">Correo Electrónico</label>
                        <div class="input-wrapper">
                            <i class="fas fa-envelope input-icon"></i>
                            <input type="email" id="email" name="email" class="form-control" 
                                   placeholder="nombre@acip.edu.pe" required autofocus autocomplete="email">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <div class="input-wrapper">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" id="password" name="password" class="form-control" 
                                   placeholder="••••••••" required autocomplete="current-password">
                        </div>
                    </div>
                    
                    <button type="submit" class="btn">
                        <span>Iniciar Sesión</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>
                    
                    <div class="login-footer">
                        <a href="<?= url('/') ?>">
                            <i class="fas fa-arrow-left"></i>
                            Volver al sitio principal
                        </a>
                    </div>
                </form>
                
                <div style="text-align: center; margin-top: 24px; color: #94a3b8; font-size: 12px;">
                    &copy; <?= date('Y') ?> Instituto ACIP. Todos los derechos reservados. Desarrollado por <a href="www.linkedin.com/in/roosvelt-enriquez-gamez-a28010123" target="_blank">Ing. Roosvelt Enriquez Gamez</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
