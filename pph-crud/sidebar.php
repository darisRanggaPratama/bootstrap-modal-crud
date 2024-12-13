<div class="sidebar" id="sidebar">
    <div class="d-flex flex-column flex-shrink-0 p-3 text-white">
        <span class="fs-4 mb-3">
            <span class="material-symbols-outlined">bolt
                    </span> Malea Energy</span>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <li>
                <!-- Refresh Button Added -->
                <a class="nav-link sidebar-link" id="refreshButton">
                    <i class="bi bi-arrow-clockwise"></i> Refresh
                </a>
            </li>
            <li class="nav-item">
                <a href="home.php" class="nav-link sidebar-link active">
                    <i class="bi bi-house me-2"></i>
                    Home
                </a>
            </li>
            <li class="nav-item">
                <div class="dropdown">
                    <button class="nav-link sidebar-link" type="button" id="dropdownMenuButton"
                            data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-filter-circle"></i>
                        Filter
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li>
                            <button class="btn btn-primary" onclick="location.href = 'class_a.php';">
                                <i class="bi bi-card-list"></i> Category A
                            </button>
                        </li>
                        <li>
                            <button class="btn btn-primary" onclick="location.href = 'class_b.php';">
                                <i class="bi bi-card-list"></i> Category B
                            </button>
                        </li>
                        <li>
                            <button class="btn btn-primary" onclick="location.href = 'class_c.php';">
                                <i class="bi bi-card-list"></i> Category C
                            </button>
                        </li>
                        <li>
                            <button class="btn btn-secondary" onclick="location.href = 'ptkp_tk0.php';">
                                <i class="bi bi-list"></i> PTKP TK/0
                            </button>
                        </li>
                        <li>
                            <button class="btn btn-secondary" onclick="location.href = 'ptkp_tk1.php';">
                                <i class="bi bi-list"></i> PTKP TK/1
                            </button>
                        </li>
                        <li>
                            <button class="btn btn-secondary" onclick="location.href = 'ptkp_tk2.php';">
                                <i class="bi bi-list"></i> PTKP TK/2
                            </button>
                        </li>
                        <li>
                            <button class="btn btn-secondary" onclick="location.href = 'ptkp_tk3.php';">
                                <i class="bi bi-list"></i> PTKP TK/3
                            </button>
                        </li>
                        <li>
                            <button class="btn btn-success" onclick="location.href = 'ptkp_k0.php';">
                                <i class="bi bi-list"></i> PTKP K/0
                            </button>
                        </li>
                        <li>
                            <button class="btn btn-success" onclick="location.href = 'ptkp_k1.php';">
                                <i class="bi bi-list"></i> PTKP K/1
                            </button>
                        </li>
                        <li>
                            <button class="btn btn-success" onclick="location.href = 'ptkp_k2.php';">
                                <i class="bi bi-list"></i> PTKP K/2
                            </button>
                        </li>
                        <li>
                            <button class="btn btn-success" onclick="location.href = 'ptkp_k3.php';">
                                <i class="bi bi-list"></i> PTKP K/3
                            </button>
                        </li>
                    </ul>
                </div>
            </li>
            <li>
                <a href="logout.php" class="nav-link sidebar-link">
                    <i class="bi bi-box-arrow-right me-2"></i>
                    Sign Out
                </a>
            </li>
        </ul>
    </div>
</div>
