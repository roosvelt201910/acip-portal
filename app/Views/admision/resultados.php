<div class="page-header" style="background: #1e3a8a; color: white; padding: 60px 0; text-align: center;">
    <div class="container">
        <h1>Resultados de Admisión</h1>
        <p>Consulta si alcanzaste una vacante</p>
    </div>
</div>

<div class="container section-padding">
    <div class="row justify-content-center">
        <div class="col-md-10"> <!-- Widened for the table -->
            <div class="content-box text-center mb-5" style="display: none;">
                <h3 class="mb-4">Consultar Individualmente</h3>
                <form action="<?= url('admision/resultados') ?>" method="GET" class="search-form">
                    <div class="input-group mb-3">
                        <input type="text" name="dni" class="form-control form-control-lg" placeholder="Número de DNI" value="<?= isset($_GET['dni']) ? e($_GET['dni']) : '' ?>" required maxlength="15">
                        <button class="btn btn-primary btn-lg" type="submit">
                            <i class="fas fa-search"></i> Buscar
                        </button>
                    </div>
                </form>
            </div>

            <!-- Tabbed Results Files Widget -->
            <?php if (!empty($resultadosArchivos)): ?>
                <div class="content-box text-center mb-5 p-0 overflow-hidden">
                    <div class="bg-light p-3 border-bottom">
                         <h4 class="m-0"><i class="fas fa-file-pdf text-danger mr-2"></i> Documentos de Resultados</h4>
                    </div>
                    
                    <?php
                        // Group files
                        $groupedPublic = ['General' => []];
                        foreach ($resultadosArchivos as $file) {
                            $key = !empty($file['programa_nombre']) ? $file['programa_nombre'] : 'General';
                            if (!isset($groupedPublic[$key])) {
                                $groupedPublic[$key] = [];
                            }
                            $groupedPublic[$key][] = $file;
                        }
                    ?>
                    
                    <div class="public-tabs-header justify-content-center">
                        <?php $pIndex = 0; ?>
                        <?php foreach ($groupedPublic as $groupName => $files): ?>
                            <?php if (empty($files) && $groupName !== 'General') continue; ?>
                            <button class="public-tab-btn <?= $pIndex === 0 ? 'active' : '' ?>" onclick="switchPublicTab(this, 'res-content-<?= md5($groupName) ?>')">
                                <?= $groupName ?>
                            </button>
                            <?php $pIndex++; ?>
                        <?php endforeach; ?>
                    </div>

                    <div class="public-tabs-content text-left p-4">
                        <?php $pIndex = 0; ?>
                        <?php foreach ($groupedPublic as $groupName => $files): ?>
                            <?php if (empty($files) && $groupName !== 'General') continue; ?>
                            <div id="res-content-<?= md5($groupName) ?>" class="public-tab-pane <?= $pIndex === 0 ? 'active' : '' ?>">
                                <div class="row justify-content-center">
                                    <?php foreach ($files as $archivo): ?>
                                        <?php 
                                            // Determine file type - Robust check
                                            $parts = explode('.', $archivo['archivo_url']);
                                            $ext = strtolower(end($parts)); // Simple array end
                                            
                                            $iconType = 'default';
                                            if (in_array($ext, ['pdf'])) $iconType = 'pdf';
                                            elseif (in_array($ext, ['xls', 'xlsx', 'csv'])) $iconType = 'excel';
                                            elseif (in_array($ext, ['doc', 'docx'])) $iconType = 'word';
                                            elseif (in_array($ext, ['zip', 'rar'])) $iconType = 'zip';
                                        ?>
                                        <div class="col-6 col-md-3 mb-4">
                                            <div class="macos-file-grid-item" onclick="openPublicPreview('<?= url($archivo['archivo_url']) ?>', '<?= e($archivo['titulo']) ?>')">
                                                <div class="macos-icon-xl mx-auto type-<?= $iconType ?>">
                                                    <!-- Folded Corner -->
                                                    <div class="macos-icon-corner"></div>
                                                    
                                                    <div class="macos-icon-content d-flex justify-content-center align-items-center flex-column">
                                                        <?php if ($iconType === 'pdf'): ?>
                                                            <!-- PDF: Clean text lines layout -->
                                                            <div class="icon-body-text w-100 mt-2">
                                                                <div class="line w-75"></div>
                                                                <div class="line w-100"></div>
                                                                <div class="line w-100"></div>
                                                                <div class="line w-100"></div>
                                                                <div class="line w-60"></div>
                                                            </div>
                                                            <!-- Fail-safe icon if lines are invisible -->
                                                            <i class="fas fa-file-pdf text-danger position-absolute" style="bottom: 5px; right: 5px; font-size: 14px; opacity: 0.8;"></i>
                                                            
                                                        <?php elseif ($iconType === 'excel'): ?>
                                                            <!-- Excel: Spreadsheet Grid -->
                                                            <div class="icon-body-grid mt-2 w-100">
                                                                <div class="grid-table">
                                                                    <div class="g-row"><span class="g-cell"></span><span class="g-cell"></span><span class="g-cell"></span></div>
                                                                    <div class="g-row"><span class="g-cell"></span><span class="g-cell"></span><span class="g-cell"></span></div>
                                                                    <div class="g-row"><span class="g-cell"></span><span class="g-cell"></span><span class="g-cell"></span></div>
                                                                    <div class="g-row"><span class="g-cell"></span><span class="g-cell"></span><span class="g-cell"></span></div>
                                                                </div>
                                                            </div>
                                                            <i class="fas fa-file-excel text-success position-absolute" style="bottom: 5px; right: 5px; font-size: 14px; opacity: 0.8;"></i>

                                                        <?php elseif ($iconType === 'word'): ?>
                                                            <!-- Word: Text layout -->
                                                            <div class="icon-body-text w-100 mt-2">
                                                                <div class="line w-100 mb-2" style="height: 4px; background: #2563eb; opacity: 0.5;"></div>
                                                                <div class="line w-100"></div>
                                                                <div class="line w-100"></div>
                                                                <div class="line w-80"></div>
                                                            </div>
                                                            <i class="fas fa-file-word text-primary position-absolute" style="bottom: 5px; right: 5px; font-size: 14px; opacity: 0.8;"></i>

                                                        <?php elseif ($iconType === 'zip'): ?>
                                                            <!-- Zip: Center Icon -->
                                                            <div class="text-center w-100" style="opacity: 0.4;">
                                                                <i class="fas fa-file-archive fa-2x"></i>
                                                            </div>
                                                            <span class="position-absolute font-weight-bold text-muted" style="bottom: 5px; right: 8px; font-size: 10px;">ZIP</span>
                                                            
                                                        <?php else: ?>
                                                            <!-- Default -->
                                                            <div class="icon-body-text w-100 mt-3">
                                                                <div class="line w-80"></div>
                                                                <div class="line w-60"></div>
                                                                <div class="line w-90"></div>
                                                                <div class="line w-40"></div>
                                                            </div>
                                                            <i class="fas fa-file text-muted position-absolute" style="bottom: 5px; right: 5px; font-size: 14px; opacity: 0.8;"></i>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <div class="mt-2 text-center">
                                                    <h6 class="mb-0 text-dark" style="font-size: 0.85rem; line-height: 1.3; font-weight: 600;"><?= e($archivo['titulo']) ?></h6>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <?php $pIndex++; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Program Selector -->
            <?php if (!empty($programas)): ?>
<!-- ... -->
<style>
/* ... existing ... */

/* XL MacOS "Thumbnail" Icon Style */
.macos-icon-xl {
    width: 65px; 
    height: 85px;
    background: #ffffff; /* Fallback */
    background: linear-gradient(135deg, #ffffff 0%, #f3f4f6 100%); /* Slight grey gradient */
    border: 1px solid #9ca3af; /* Darker grey border for visibility */
    border-radius: 4px; 
    position: relative;
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06); /* Stronger shadow */
    transition: all 0.2s;
    overflow: hidden; 
    margin: 0 auto;
    display: block !important; /* Force display */
}
.macos-icon-corner {
    position: absolute;
    top: 0;
    right: 0;
    border-width: 0 20px 20px 0;
    border-style: solid;
    border-color: #f3f4f6 #fff; /* Match background gradient */
    background: #cbd5e1; /* Darker fold */
    display: block; 
    width: 0;
    border-bottom-left-radius: 4px;
    box-shadow: -2px 2px 3px rgba(0,0,0,0.15); /* Stronger fold shadow */
    z-index: 10;
}

/* Internal Content Styles */
.macos-icon-content {
    padding: 8px;
    height: 100%;
    display: flex;
    flex-direction: column;
    position: relative;
    z-index: 1;
}

/* Text Lines */
.icon-body-text {
    display: flex; flex-direction: column; gap: 4px; 
}
.line { 
    height: 2px; 
    background: #6b7280; /* Darker grey lines */
    border-radius: 1px; 
    opacity: 0.6; /* Higher opacity */
}
.w-100 { width: 100%; }
.w-80 { width: 80%; }
.w-75 { width: 75%; }
.w-60 { width: 60%; }
.w-50 { width: 50%; }

/* Grid (Excel) */
.icon-body-grid {
    border: 1px solid #9ca3af; /* Darker grid border */
    border-radius: 2px;
    overflow: hidden;
    opacity: 0.7;
}
.grid-table { width: 100%; display: flex; flex-direction: column; }
.g-row { display: flex; border-bottom: 1px solid #9ca3af; height: 8px; }
.g-row:last-child { border-bottom: none; }
.g-cell { flex: 1; border-right: 1px solid #9ca3af; }
.g-cell:last-child { border-right: none; }

</style>
            <div class="content-box mb-5">
                <div class="text-center mb-4">
                    <h3 class="mb-2">Resultados por Programa de Estudio</h3>
                    <p class="text-muted">Selecciona una carrera para ver la lista completa de resultados</p>
                </div>
                <div class="d-flex flex-wrap justify-content-center gap-2">
                    <?php foreach ($programas as $prog): ?>
                        <a href="<?= url('admision/resultados?programa=' . urlencode($prog['programa_estudio'])) ?>" 
                           class="btn <?= (isset($_GET['programa']) && $_GET['programa'] == $prog['programa_estudio']) ? 'btn-primary' : 'btn-outline-primary' ?> mb-2 mr-2">
                            <?= e($prog['programa_estudio']) ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Single Result Card (Search by DNI) -->
            <?php if (isset($resultado)): ?>
                <div class="result-card <?= $resultado['condicion'] == 'INGRESÓ' ? 'success' : 'danger' ?> mx-auto" style="max-width: 600px;">
                    <div class="result-header">
                        <h4><?= e($resultado['nombres_apellidos']) ?></h4>
                        <span class="badge"><?= e($resultado['condicion']) ?></span>
                    </div>
                    <div class="result-body">
                        <div class="row">
                            <div class="col-6">
                                <small>Programa de Estudio</small>
                                <p><strong><?= e($resultado['programa_estudio']) ?></strong></p>
                            </div>
                            <div class="col-6">
                                <small>Puntaje</small>
                                <p><strong><?= $resultado['puntaje'] ?></strong></p>
                            </div>
                            <div class="col-6">
                                <small>Orden de Mérito</small>
                                <p><strong>#<?= $resultado['orden_merito'] ?></strong></p>
                            </div>
                            <div class="col-6">
                                <small>Modalidad</small>
                                <p><?= e($resultado['modalidad']) ?></p>
                            </div>
                        </div>
                    </div>
                    <?php if ($resultado['condicion'] == 'INGRESÓ'): ?>
                        <div class="result-footer">
                            <p class="mb-0">¡Felicitaciones! Acércate a la oficina de admisión para completar tu matrícula.</p>
                        </div>
                    <?php endif; ?>
                </div>
            
            <!-- Program Results List (Search by Program) -->
            <?php elseif (!empty($resultados_programa)): ?>
                <div class="content-box">
                    <h4 class="mb-4 text-center">Resultados: <?= e($programa_selected) ?></h4>
                    <div class="table-responsive">
                        <table class="table table-hover results-table">
                            <thead>
                                <tr>
                                    <th class="text-center" width="50">#</th>
                                    <th>Apellidos y Nombres</th>
                                    <th class="text-center">Puntaje</th>
                                    <th class="text-center">Condición</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($resultados_programa as $row): ?>
                                    <tr class="<?= $row['condicion'] == 'INGRESÓ' ? 'table-success-light' : '' ?>">
                                        <td class="text-center font-weight-bold"><?= $row['orden_merito'] ?></td>
                                        <td><?= e($row['nombres_apellidos']) ?></td>
                                        <td class="text-center"><?= $row['puntaje'] ?></td>
                                        <td class="text-center">
                                            <?php if ($row['condicion'] == 'INGRESÓ'): ?>
                                                <span class="badge badge-success px-3 py-2">INGRESÓ</span>
                                            <?php else: ?>
                                                <span class="badge badge-light border px-3 py-2">NO INGRESÓ</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            <?php elseif (isset($error)): ?>
                <div class="alert alert-danger text-center mx-auto" style="max-width: 600px;">
                    <i class="fas fa-exclamation-circle fa-2x mb-2"></i><br>
                    <?= e($error) ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>


<!-- PDF Preview Modal -->
<div id="publicPdfModal" class="public-modal-overlay" style="display: none;">
    <div class="public-modal-container">
        <div class="public-modal-header">
            <h5 class="public-modal-title" id="publicModalTitle">Vista Previa</h5>
            <button type="button" class="public-close-btn" onclick="closePublicModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="public-modal-body">
            <iframe id="publicModalFrame" src="" width="100%" height="100%" style="border: none;"></iframe>
        </div>
    </div>
</div>

<style>
.section-padding { padding: 60px 0; }
.content-box { background: white; padding: 40px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
.search-form .form-control { border-radius: 5px 0 0 5px; border: 2px solid #eee; }
.search-form .btn { border-radius: 0 5px 5px 0; }

.result-card { background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1); margin-top: 20px; text-align: left; }
.result-card.success .result-header { background: #10b981; color: white; }
.result-card.danger .result-header { background: #ef4444; color: white; }

.result-header { padding: 20px; display: flex; justify-content: space-between; align-items: center; }
.result-header h4 { margin: 0; font-size: 1.2rem; font-weight: 600; }
.result-header .badge { background: rgba(255,255,255,0.2); color: white; padding: 5px 10px; border-radius: 20px; font-size: 0.9rem; }

.result-body { padding: 25px; }
.result-body small { color: #888; display: block; margin-bottom: 2px; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.5px; }
.result-body p { font-size: 1.1rem; margin-bottom: 15px; color: #333; }

.result-footer { padding: 15px 25px; background: #f0fdf4; color: #166534; font-size: 0.95rem; border-top: 1px solid #dcfce7; }
.table-success-light { background-color: #f0fdf4; }
.badge-success { background-color: #10b981; color: white; }
.results-table th { background-color: #f8fafc; font-weight: 600; color: #64748b; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px; border-top: none; }
.results-table td { vertical-align: middle; }

/* Tabs & Preview Styles */
.public-tabs-header {
    display: flex;
    overflow-x: auto;
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    padding: 10px;
    gap: 8px;
}
.public-tab-btn {
    padding: 8px 16px;
    border: none;
    background: white;
    font-size: 0.9rem;
    font-weight: 600;
    color: #64748b;
    border-radius: 6px;
    cursor: pointer;
    white-space: nowrap;
    transition: all 0.2s;
    box-shadow: 0 1px 2px rgba(0,0,0,0.05);
}
.public-tab-btn:hover {
    background: #f1f5f9;
    color: #334155;
}
.public-tab-btn.active {
    background: #2563eb;
    color: white;
    box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.2);
}
.public-tab-pane {
    display: none;
    animation: fadeIn 0.3s ease;
}
.public-tab-pane.active {
    display: block;
}
.macos-file-item {
    cursor: pointer;
    transition: all 0.2s;
    background: white;
}
.macos-file-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    border-color: #2563eb !important;
}

/* Modal Styles */
.public-modal-overlay {
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(0,0,0,0.6);
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(3px);
}
.public-modal-container {
    background: white;
    width: 90%;
    max-width: 900px;
    height: 85vh;
    border-radius: 8px;
    display: flex;
    flex-direction: column;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}
.public-modal-header {
    padding: 1rem;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.public-modal-title { margin: 0; font-size: 1.1rem; }
.public-modal-body { flex: 1; overflow: hidden; background: #f1f5f9; }
.public-close-btn {
    background: none;
    border: none;
    font-size: 1.2rem;
    cursor: pointer;
    color: #64748b;
}
.public-close-btn:hover { color: #0f172a; }

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(5px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>

<script>
function switchPublicTab(btn, targetId) {
    // Remove active class from buttons buttons in this container
    let container = btn.closest('.content-box');
    container.querySelectorAll('.public-tab-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    
    // Hide panes
    container.querySelectorAll('.public-tab-pane').forEach(p => p.classList.remove('active'));
    document.getElementById(targetId).classList.add('active');
}

function openPublicPreview(url, title) {
    if(url === '#') return;
    document.getElementById('publicModalFrame').src = url;
    document.getElementById('publicModalTitle').textContent = title;
    document.getElementById('publicPdfModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
function closePublicModal() {
    document.getElementById('publicPdfModal').style.display = 'none';
    document.getElementById('publicModalFrame').src = '';
    document.body.style.overflow = 'auto';
}
document.getElementById('publicPdfModal').addEventListener('click', function(e) {
    if (e.target === this) closePublicModal();
});
</script>
