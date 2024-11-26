// Function to handle searching/filtering
document.addEventListener('DOMContentLoaded', function () {
    const searchInputs = {
        nim: document.getElementById('searchNim'),
        nama: document.getElementById('searchNama'),
        alamat: document.getElementById('searchAlamat'),
        prodi: document.getElementById('searchProdi')
    };

    // Add event listeners to all search inputs
    Object.values(searchInputs).forEach(input => {
        if (input) {
            input.addEventListener('keyup', filterTable);
        }
    });

    function filterTable() {
        const table = document.querySelector('.table');
        const rows = table.getElementsByTagName('tr');

        // Start from index 1 to skip header row
        for (let i = 1; i < rows.length; i++) {
            const row = rows[i];
            const cells = row.getElementsByTagName('td');

            if (cells.length > 0) {
                const nimMatch = !searchInputs.nim?.value ||
                    cells[2].textContent.toLowerCase().includes(searchInputs.nim.value.toLowerCase());
                const namaMatch = !searchInputs.nama?.value ||
                    cells[3].textContent.toLowerCase().includes(searchInputs.nama.value.toLowerCase());
                const alamatMatch = !searchInputs.alamat?.value ||
                    cells[4].textContent.toLowerCase().includes(searchInputs.alamat.value.toLowerCase());
                const prodiMatch = !searchInputs.prodi?.value ||
                    cells[5].textContent.toLowerCase().includes(searchInputs.prodi.value.toLowerCase());

                if (nimMatch && namaMatch && alamatMatch && prodiMatch) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        }
    }
});