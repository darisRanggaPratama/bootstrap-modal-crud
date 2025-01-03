<!-- Pagination -->
<nav>
    <ul class="pagination justify-content-center">
        <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
            <a class="page-link"
               href="?page=<?= $page - 1 ?>&entries=<?= $entries ?>&search=<?= urlencode($search) ?>">Previous</a>
        </li>
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                <a class="page-link"
                   href="?page=<?= $i ?>&entries=<?= $entries ?>&search=<?= urlencode($search) ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>
        <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
            <a class="page-link"
               href="?page=<?= $page + 1 ?>&entries=<?= $entries ?>&search=<?= urlencode($search) ?>">Next</a>
        </li>
    </ul>
</nav>
