<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Constancia de Reclamo - <?= $complaint['codigo'] ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1a2b4a 0%, #8b1538 100%);
            min-height: 100vh;
            padding: 40px 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .receipt-container {
            max-width: 900px;
            width: 100%;
            background: white;
            border-radius: 0;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
            overflow: hidden;
            border-top: 8px solid #8b1538;
        }
        
        .receipt-header {
            background: linear-gradient(135deg, #1a2b4a 0%, #2d4a7c 100%);
            color: white;
            padding: 50px 40px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .receipt-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #8b1538 0%, #c41e3a 50%, #8b1538 100%);
        }
        
        .receipt-header h1 {
            font-size: 2.2rem;
            margin-bottom: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        
        .receipt-header p {
            font-size: 1.2rem;
            opacity: 0.95;
            font-weight: 300;
        }
        
        .receipt-code {
            background: rgba(139, 21, 56, 0.9);
            padding: 18px 40px;
            border-radius: 0;
            display: inline-block;
            margin-top: 25px;
            font-size: 1.4rem;
            font-weight: 700;
            letter-spacing: 2px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        
        .receipt-body {
            padding: 50px 40px;
        }
        
        .info-section {
            margin-bottom: 40px;
        }
        
        .section-title {
            font-size: 1.4rem;
            color: #1a2b4a;
            font-weight: 700;
            margin-bottom: 25px;
            padding-bottom: 12px;
            border-bottom: 3px solid #8b1538;
            display: flex;
            align-items: center;
            gap: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .section-title i {
            color: #8b1538;
            font-size: 1.3rem;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }
        
        .info-item {
            background: #f8f9fa;
            padding: 20px 25px;
            border-radius: 0;
            border-left: 5px solid #1a2b4a;
            transition: all 0.3s;
        }
        
        .info-item:hover {
            border-left-color: #8b1538;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        
        .info-label {
            font-size: 0.85rem;
            color: #6c757d;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 8px;
        }
        
        .info-value {
            font-size: 1.15rem;
            color: #1a2b4a;
            font-weight: 600;
        }
        
        .detail-box {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 0;
            border-left: 5px solid #1a2b4a;
            line-height: 1.9;
            white-space: pre-wrap;
            font-size: 1.05rem;
            color: #333;
        }
        
        .footer-note {
            background: #fff8e1;
            border-left: 5px solid #8b1538;
            padding: 25px;
            border-radius: 0;
            margin-top: 40px;
            font-size: 0.95rem;
            color: #5d4037;
            line-height: 1.7;
        }
        
        .footer-note strong {
            color: #8b1538;
            display: block;
            margin-bottom: 10px;
            font-size: 1.05rem;
        }
        
        .action-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            padding: 35px;
            background: #f8f9fa;
            border-top: 3px solid #e9ecef;
        }
        
        .btn {
            padding: 16px 45px;
            border: none;
            border-radius: 0;
            font-size: 1.05rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .btn-print {
            background: linear-gradient(135deg, #1a2b4a 0%, #2d4a7c 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(26, 43, 74, 0.3);
        }
        
        .btn-print:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(26, 43, 74, 0.4);
            background: linear-gradient(135deg, #2d4a7c 0%, #1a2b4a 100%);
        }
        
        .btn-back {
            background: white;
            color: #8b1538;
            border: 3px solid #8b1538;
        }
        
        .btn-back:hover {
            background: #8b1538;
            color: white;
        }
        
        @media print {
            body {
                background: white;
                padding: 0;
            }
            
            .receipt-container {
                box-shadow: none;
                border-radius: 0;
            }
            
            .action-buttons {
                display: none;
            }
        }
        
        @media (max-width: 768px) {
            .receipt-header h1 {
                font-size: 1.6rem;
            }
            
            .receipt-code {
                font-size: 1.1rem;
                padding: 12px 25px;
            }
            
            .info-grid {
                grid-template-columns: 1fr;
            }
            
            .receipt-body {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <div class="receipt-header">
            <h1><i class="fas fa-file-alt"></i> CONSTANCIA DE RECLAMO</h1>
            <p>ACIP - Libro de Reclamaciones</p>
            <div class="receipt-code">
                <i class="fas fa-barcode"></i> <?= $complaint['codigo'] ?>
            </div>
        </div>
        
        <div class="receipt-body">
            <!-- Información General -->
            <div class="info-section">
                <div class="section-title">
                    <i class="fas fa-info-circle"></i>
                    Información General
                </div>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Fecha de Registro</div>
                        <div class="info-value"><?= $complaint['fecha'] ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Tipo de Reclamo</div>
                        <div class="info-value"><?= ucfirst($complaint['tipo']) ?></div>
                    </div>
                </div>
            </div>
            
            <!-- Datos del Reclamante -->
            <div class="info-section">
                <div class="section-title">
                    <i class="fas fa-user"></i>
                    Datos del Reclamante
                </div>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Nombre Completo</div>
                        <div class="info-value"><?= e($complaint['nombre']) ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Email</div>
                        <div class="info-value"><?= e($complaint['email']) ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Teléfono</div>
                        <div class="info-value"><?= e($complaint['telefono']) ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Documento</div>
                        <div class="info-value"><?= $complaint['tipo_documento'] ?> <?= e($complaint['documento']) ?></div>
                    </div>
                </div>
            </div>
            
            <!-- Detalle del Reclamo -->
            <div class="info-section">
                <div class="section-title">
                    <i class="fas fa-file-alt"></i>
                    Detalle del Reclamo
                </div>
                <div class="detail-box">
                    <?= e($complaint['detalle']) ?>
                </div>
            </div>
            
            <!-- Nota Legal -->
            <div class="footer-note">
                <strong><i class="fas fa-exclamation-triangle"></i> Información Importante:</strong><br>
                La formulación de reclamo no impide acudir a otras vías de solución de controversias ni es requisito previo para interponer una denuncia ante el INDECOPI. El proveedor deberá dar respuesta al reclamo en un plazo no mayor a treinta (30) días calendario, pudiendo ampliar el plazo hasta por treinta (30) días más, previa comunicación al consumidor.
            </div>
        </div>
        
        <div class="action-buttons">
            <button onclick="window.print()" class="btn btn-print">
                <i class="fas fa-print"></i> Imprimir Constancia
            </button>
            <a href="<?= url('libro-reclamaciones') ?>" class="btn btn-back">
                <i class="fas fa-arrow-left"></i> Volver al Formulario
            </a>
        </div>
    </div>
</body>
</html>
