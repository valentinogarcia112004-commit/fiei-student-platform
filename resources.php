<?php
require_once 'backend/config.php';

// Mapeo de categorías (valor en BD -> código para el filtro)
$categoryMap = [
    'programacion'   => 'programming',
    'matematicas'    => 'math',
    'bases de datos' => 'database',
    'base de datos'  => 'database',
    'electronica'    => 'electronics',
    'redes'          => 'networks',
    'telecomunicaciones' => 'telecom',
    // Agrega también los códigos en inglés por si acaso ya están guardados así
    'programming'    => 'programming',
    'math'           => 'math',
    'database'       => 'database',
    'electronics'    => 'electronics',
    'networks'       => 'networks',
    'telecom'        => 'telecom'
];

// Consultar los recursos aprobados, uniendo con el nombre del profesor (usuario que subió)
$stmt = $pdo->prepare("
    SELECT r.*, u.full_name AS teacher_name 
    FROM resources r 
    JOIN users u ON r.uploaded_by = u.id_user 
    WHERE r.status = 'approved' 
    ORDER BY r.upload_date DESC
");
$stmt->execute();
$recursos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recursos Académicos - FIEI</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Barra de Navegación -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="logo">
                <h1>FIEI StudyHUB</h1>
                <span>Recursos Académicos</span>
            </div>

            <button class="menu-toggle" id="menuToggle" aria-label="Abrir menú">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </button>

            <ul class="nav-menu" id="navMenu">
                <li><a href="index.html">Inicio</a></li>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="resources.php" class="active">Recursos</a></li>
                <li><a href="upload.html">Subir Material</a></li>
                <li><a href="contact.html">Contacto</a></li>
            </ul>
        </div>
    </nav>

    <div class="resources-page">
        <!-- Encabezado y Búsqueda -->
        <section class="resources-header">
            <h2>📚 Biblioteca de Recursos Académicos</h2>
            <div class="search-filter-bar">
                <input type="text" id="searchInput" placeholder="🔍 Buscar recursos..." class="search-input">
                <select id="categoryFilter" class="filter-select">
                    <option value="all">Todas las Categorías</option>
                    <option value="programming">Programación</option>
                    <option value="math">Matemáticas</option>
                    <option value="database">Bases de Datos</option>
                    <option value="electronics">Electrónica</option>
                    <option value="networks">Redes</option>
                    <option value="telecom">Telecomunicaciones</option>
                </select>
            </div>
        </section>

        <!-- Categorías -->
        <section class="categories-section">
            <div class="category-tabs">
                <button class="category-tab active" data-category="all">Todos</button>
                <button class="category-tab" data-category="programming">💻 Programación</button>
                <button class="category-tab" data-category="math">📐 Matemáticas</button>
                <button class="category-tab" data-category="database">🗄️ Bases de Datos</button>
                <button class="category-tab" data-category="electronics">⚡ Electrónica</button>
                <button class="category-tab" data-category="networks">🌐 Redes</button>
                <button class="category-tab" data-category="telecom">📡 Telecomunicaciones</button>
            </div>
        </section>

        <!-- Grid de Recursos -->
        <section class="resources-grid-section">
            <div class="resources-grid">
                <?php if (count($recursos) > 0): ?>
                <?php foreach ($recursos as $r): 
                    
                     // Obtener el código de categoría para el filtro (en minúsculas, sin espacios extra)
                    $catCode = strtolower(trim($r['category']));
                    // Si existe en el mapeo, usar el código mapeado; si no, usar el original
                    $filterCategory = isset($categoryMap[$catCode]) ? $categoryMap[$catCode] : $catCode;
    
                    // Nombre legible de la categoría (para mostrar)
                    $displayCategory = htmlspecialchars($r['category']);
                    
                ?>
                    <div class="resource-card" data-category="<?php echo htmlspecialchars($r['category']); ?>">
                        <div class="resource-icon">
                            <?php
                                // Asignar un icono según la categoría
                                $categoria = strtolower($r['category']);
                                if ($categoria == 'programacion' || $categoria == 'programming') echo '📘';
                                elseif ($categoria == 'matematicas' || $categoria == 'math') echo '📊';
                                elseif ($categoria == 'bases de datos' || $categoria == 'database') echo '🗃️';
                                elseif ($categoria == 'electronica' || $categoria == 'electronics') echo '⚡';
                                elseif ($categoria == 'redes' || $categoria == 'networks') echo '🌐';
                                elseif ($categoria == 'telecomunicaciones' || $categoria == 'telecom') echo '📡';
                                else echo '📁';
                            ?>
                        </div>
                        <div class="resource-category"><?php echo htmlspecialchars($r['category']); ?></div>
                        <h3><?php echo htmlspecialchars($r['title']); ?></h3>
                        <p class="resource-description"><?php echo htmlspecialchars($r['description']); ?></p>
                        <div class="resource-meta">
                            <span>👨‍🏫 <?php echo htmlspecialchars($r['teacher_name']); ?></span>
                            <span>📅 <?php echo date('d/m/Y', strtotime($r['upload_date'])); ?></span>
                        </div>
                        <div class="resource-footer">
                            <span class="downloads">⬇ Descargas</span>
                            <a href="<?php echo htmlspecialchars($r['file_url']); ?>" class="btn-download" download>Descargar</a>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php else: ?>
                    <p style="text-align: center; grid-column: 1 / -1;">No hay recursos aprobados todavía.</p>
                <?php endif; ?>
            </div>
        </section>
    </div>

    <script src="js/app.js"></script>
</body>
</html>