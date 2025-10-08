<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "skytravel");

// Estatísticas
$total_destinations = $conn->query("SELECT COUNT(*) as total FROM destinations")->fetch_assoc()['total'];
$total_offers = $conn->query("SELECT COUNT(*) as total FROM special_offers")->fetch_assoc()['total'];
$total_testimonials = $conn->query("SELECT COUNT(*) as total FROM testimonials")->fetch_assoc()['total'];
$active_offers = $conn->query("SELECT COUNT(*) as total FROM special_offers WHERE is_active = 1")->fetch_assoc()['total'];

// Últimos destinos adicionados
$recent_destinations = $conn->query("SELECT * FROM destinations ORDER BY created_at DESC LIMIT 5");
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SkyTravel Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --sidebar-width: 250px;
            --header-height: 70px;
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --secondary: #ec4899;
            --dark: #1e293b;
            --light: #f8fafc;
            --gray: #64748b;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f1f5f9;
            display: flex;
        }

        .sidebar {
            width: var(--sidebar-width);
            background: var(--dark);
            color: white;
            height: 100vh;
            position: fixed;
            transition: all 0.3s ease;
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid #334155;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .sidebar-menu {
            padding: 1rem 0;
        }

        .menu-item {
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            color: #cbd5e1;
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .menu-item:hover, .menu-item.active {
            background: #334155;
            color: white;
            border-left-color: var(--primary);
        }

        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            padding: 2rem;
        }

        .header {
            background: white;
            padding: 1.5rem 2rem;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-avatar {
            width: 50px;
            height: 50px;
            background: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            background: var(--primary);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            margin: 0 auto 1rem;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: var(--gray);
            font-size: 1rem;
        }

        .content-section {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: var(--dark);
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        .table th {
            background: #f8fafc;
            font-weight: 600;
            color: var(--dark);
        }

        .btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-danger {
            background: #ef4444;
            color: white;
        }

        .btn-sm {
            padding: 0.3rem 0.8rem;
            font-size: 0.875rem;
        }

        .status-badge {
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .status-active {
            background: #dcfce7;
            color: #166534;
        }

        .status-inactive {
            background: #fecaca;
            color: #dc2626;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <div class="logo">
                <i class="fas fa-plane-departure"></i> SkyTravel
            </div>
        </div>
        <nav class="sidebar-menu">
            <a href="dashboard.php" class="menu-item active">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
            <a href="destinations.php" class="menu-item">
                <i class="fas fa-map-marked-alt"></i> Destinos
            </a>
            <a href="offers.php" class="menu-item">
                <i class="fas fa-tags"></i> Ofertas
            </a>
            <a href="testimonials.php" class="menu-item">
                <i class="fas fa-comments"></i> Depoimentos
            </a>
            <a href="content.php" class="menu-item">
                <i class="fas fa-language"></i> Conteúdo
            </a>
            <a href="settings.php" class="menu-item">
                <i class="fas fa-cog"></i> Configurações
            </a>
            <a href="logout.php" class="menu-item">
                <i class="fas fa-sign-out-alt"></i> Sair
            </a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="header">
            <h1>Dashboard</h1>
            <div class="user-info">
                <div class="user-avatar">
                    <?php echo strtoupper(substr($_SESSION['admin_name'], 0, 2)); ?>
                </div>
                <div>
                    <div class="user-name"><?php echo $_SESSION['admin_name']; ?></div>
                    <div class="user-role">Administrador</div>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-map-marked-alt"></i>
                </div>
                <div class="stat-number"><?php echo $total_destinations; ?></div>
                <div class="stat-label">Destinos Cadastrados</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-tags"></i>
                </div>
                <div class="stat-number"><?php echo $total_offers; ?></div>
                <div class="stat-label">Ofertas Especiais</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-comments"></i>
                </div>
                <div class="stat-number"><?php echo $total_testimonials; ?></div>
                <div class="stat-label">Depoimentos</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-bullhorn"></i>
                </div>
                <div class="stat-number"><?php echo $active_offers; ?></div>
                <div class="stat-label">Ofertas Ativas</div>
            </div>
        </div>

        <!-- Recent Destinations -->
        <div class="content-section">
            <h2 class="section-title">Destinos Recentes</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>País</th>
                        <th>Preço</th>
                        <th>Desconto</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($destination = $recent_destinations->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $destination['name_pt']; ?></td>
                        <td><?php echo $destination['country_pt']; ?></td>
                        <td>R$ <?php echo number_format($destination['price'], 2, ',', '.'); ?></td>
                        <td><?php echo $destination['discount']; ?>%</td>
                        <td>
                            <span class="status-badge <?php echo $destination['is_active'] ? 'status-active' : 'status-inactive'; ?>">
                                <?php echo $destination['is_active'] ? 'Ativo' : 'Inativo'; ?>
                            </span>
                        </td>
                        <td>
                            <a href="edit_destination.php?id=<?php echo $destination['id']; ?>" class="btn btn-primary btn-sm">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Quick Actions -->
        <div class="content-section">
            <h2 class="section-title">Ações Rápidas</h2>
            <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                <a href="add_destination.php" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Novo Destino
                </a>
                <a href="add_offer.php" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nova Oferta
                </a>
                <a href="add_testimonial.php" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Novo Depoimento
                </a>
            </div>
        </div>
    </div>
</body>
</html>
<?php $conn->close(); ?>