<?php
session_start();

// Si no ha iniciado sesión, redirigir al login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

// Datos del usuario desde la sesión
$full_name = $_SESSION['full_name'] ?? 'Estudiante FIEI';
$career = $_SESSION['career'] ?? 'Ingeniería Informática';
// Mapeo de carreras: código → nombre legible
$carreras = [
    'informatica' => 'Ing. Informática',
    'electronica' => 'Ing. Electrónica',
    'mecatronica' => 'Ing. Mecatrónica',
    'telecomunicaciones' => 'Ing. de Telecomunicaciones'
];

// Reemplazar el valor por el nombre bonito si existe en el mapeo
if (isset($carreras[$career])) {
    $career = $carreras[$career];
}
$user_id = $_SESSION['user_id'];
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - FIEI</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Barra de Navegación del Dashboard -->
    <nav class="navbar dashboard-nav">
        <div class="nav-container">
            <div class="logo">
                <h1>FIEI StudyHUB</h1>
                <span>Panel de Estudiante</span>
            </div>

            <button class="menu-toggle" id="menuToggle" aria-label="Abrir menú">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </button>

            <ul class="nav-menu" id="navMenu">
                <li><a href="dashboard.php" class="active">Dashboard</a></li>
                <li><a href="resources.php">Recursos</a></li>
                <li><a href="upload.html">Subir Material</a></li>
                <li><a href="contact.html">Contacto</a></li>
                <li><a href="backend/logout.php" class="btn-logout">Cerrar Sesión</a></li>
            </ul>
        </div>
    </nav>

    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="dashboard-sidebar">
            <div class="user-profile">
                <div class="user-avatar">👤</div>
                <h3 id="userName"><?php echo htmlspecialchars($full_name); ?></h3>
                <p id="userCareer"><?php echo htmlspecialchars($career); ?></p>
                <span class="user-status">En línea</span>
            </div>
            
            <nav class="sidebar-menu">
                <a href="#overview" class="sidebar-link active">
                    <span class="icon">📊</span> Resumen
                </a>
                <a href="#my-resources" class="sidebar-link">
                    <span class="icon">📚</span> Mis Recursos
                </a>
                <a href="#events" class="sidebar-link">
                    <span class="icon">📅</span> Eventos
                </a>
                <a href="#settings" class="sidebar-link">
                    <span class="icon">⚙️</span> Configuración
                </a>
            </nav>
        </aside>

        <!-- Contenido Principal -->
        <main class="dashboard-main">
            <!-- Sección de Bienvenida -->
            <section id="overview" class="dashboard-section">
                <h2>Bienvenido, <span id="welcomeName"><?php echo htmlspecialchars($full_name); ?></span></h2>
                <p class="last-login">Último acceso: Hoy, 10:30 AM</p>
                
                <!-- Tarjetas de Estadísticas -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">📥</div>
                        <div class="stat-info">
                            <h3>12</h3>
                            <p>Descargas</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">📤</div>
                        <div class="stat-info">
                            <h3>3</h3>
                            <p>Subidas</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">📅</div>
                        <div class="stat-info">
                            <h3>5</h3>
                            <p>Próximos Eventos</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon">⭐</div>
                        <div class="stat-info">
                            <h3>4.8</h3>
                            <p>Calificación</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Recursos Recientes -->
            <section id="my-resources" class="dashboard-section">
                <h2>📁 Archivos Subidos Recientemente</h2>
                <div class="resources-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Categoría</th>
                                <th>Fecha</th>
                                <th>Descargas</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Guía de Python.pdf</td>
                                <td><span class="badge badge-programming">Programación</span></td>
                                <td>24/05/2024</td>
                                <td>45</td>
                                <td><button class="btn-download">Descargar</button></td>
                            </tr>
                            <tr>
                                <td>Circuitos Digitales.pptx</td>
                                <td><span class="badge badge-electronics">Electrónica</span></td>
                                <td>23/05/2024</td>
                                <td>32</td>
                                <td><button class="btn-download">Descargar</button></td>
                            </tr>
                            <tr>
                                <td>SQL Avanzado.pdf</td>
                                <td><span class="badge badge-database">Bases de Datos</span></td>
                                <td>22/05/2024</td>
                                <td>28</td>
                                <td><button class="btn-download">Descargar</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Noticias y Eventos -->
            <section id="events" class="dashboard-section">
                <h2>📢 Noticias de la Facultad</h2>
                <div class="news-grid">
                    <article class="news-card">
                        <div class="news-date">25 Mayo</div>
                        <h3>Taller de Desarrollo Web</h3>
                        <p>Aprende las últimas tecnologías web con expertos de la industria</p>
                        <span class="news-tag">Taller</span>
                    </article>
                    <article class="news-card">
                        <div class="news-date">28 Mayo</div>
                        <h3>Conferencia de Robótica</h3>
                        <p>Descubre las innovaciones en robótica y automatización</p>
                        <span class="news-tag">Conferencia</span>
                    </article>
                    <article class="news-card">
                        <div class="news-date">01 Junio</div>
                        <h3>Hackathon FIEI 2024</h3>
                        <p>Participa en nuestra competencia anual de programación</p>
                        <span class="news-tag">Competencia</span>
                    </article>
                </div>

                <!-- Próximos Eventos -->
                <h3 style="margin-top: 2rem;">📅 Próximos Eventos</h3>
                <div class="events-list">
                    <div class="event-item">
                        <div class="event-date">
                            <span class="day">15</span>
                            <span class="month">Jun</span>
                        </div>
                        <div class="event-info">
                            <h4>Examen Parcial - Matemáticas</h4>
                            <p>10:00 AM - Aula 301</p>
                        </div>
                    </div>
                    <div class="event-item">
                        <div class="event-date">
                            <span class="day">20</span>
                            <span class="month">Jun</span>
                        </div>
                        <div class="event-info">
                            <h4>Entrega de Proyecto Final</h4>
                            <p>Fecha límite - Plataforma Virtual</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Configuración Rápida -->
            <section id="settings" class="dashboard-section">
                <h2>⚙️ Configuración Rápida</h2>
                <div class="settings-grid">
                    <div class="setting-card">
                        <h3>🔔 Notificaciones</h3>
                        <label class="toggle">
                            <input type="checkbox" checked>
                            <span class="slider"></span>
                        </label>
                    </div>
                    <div class="setting-card">
                        <h3>🌙 Modo Oscuro</h3>
                        <label class="toggle">
                            <input type="checkbox">
                            <span class="slider"></span>
                        </label>
                    </div>
                    <div class="setting-card">
                        <h3>📧 Correos Semanales</h3>
                        <label class="toggle">
                            <input type="checkbox" checked>
                            <span class="slider"></span>
                        </label>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <script src="js/app.js"></script>
</body>
</html>