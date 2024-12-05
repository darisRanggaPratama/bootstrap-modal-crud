// Sidebar Toggle
const sidebar = document.getElementById('sidebar');
const content = document.getElementById('content');
const sidebarToggle = document.getElementById('sidebarToggle');

sidebarToggle.addEventListener('click', () => {
    sidebar.classList.toggle('active');
    content.classList.toggle('shifted');
});

// Sidebar Link Effects
document.querySelectorAll('.sidebar-link').forEach(link => {
    link.addEventListener('click', function (e) {
        document.querySelectorAll('.sidebar-link').forEach(l => l.classList.remove('active'));
        this.classList.add('active');
    });
});

// Search and Entries Functions
function updateSearch() {
    const searchValue = document.getElementById('searchInput').value;
    const entriesValue = document.getElementById('entriesSelect').value;
    window.location.href = `?search=${encodeURIComponent(searchValue)}&entries=${entriesValue}&page=1`;
}

function updateEntries() {
    const searchValue = document.getElementById('searchInput').value;
    const entriesValue = document.getElementById('entriesSelect').value;
    window.location.href = `?search=${encodeURIComponent(searchValue)}&entries=${entriesValue}&page=1`;
}

// Search on Enter Key
document.getElementById('searchInput').addEventListener('keypress', function (e) {
    if (e.key === 'Enter') {
        updateSearch();
    }
});

// Edit Modal Population
document.querySelectorAll('.edit-btn').forEach(button => {
    button.addEventListener('click', function () {
        document.getElementById('editId').value = this.getAttribute('data-id');
        document.getElementById('editNik').value = this.getAttribute('data-nik');
        document.getElementById('editName').value = this.getAttribute('data-name');
        document.getElementById('editGaji').value = this.getAttribute('data-gaji');
        document.getElementById('editHadirPusat').value = this.getAttribute('data-hadirpusat');
        document.getElementById('editHadirProyek').value = this.getAttribute('data-hadirproyek');
        document.getElementById('editKonsumsi').value = this.getAttribute('data-konsumsi');
        document.getElementById('editLembur').value = this.getAttribute('data-lembur');
        document.getElementById('editTunjangLain').value = this.getAttribute('data-tunjanglain');
        document.getElementById('editJkk').value = this.getAttribute('data-jkk');
        document.getElementById('editJkm').value = this.getAttribute('data-jkm');
        document.getElementById('editSehat').value = this.getAttribute('data-sehat');
        document.getElementById('editPtkp').value = this.getAttribute('data-ptkp');
    });
});

// Tambahkan di file script.js
document.addEventListener('DOMContentLoaded', function() {
    const eraseAllForm = document.querySelector('#eraseAllModal form');
    if (eraseAllForm) {
        eraseAllForm.addEventListener('submit', function(e) {
            const confirmText = 'Please type DELETE to confirm';
            const userInput = prompt(confirmText);

            if (userInput !== 'DELETE') {
                e.preventDefault();
                alert('Operation cancelled. Data was not deleted.');
            }
        });
    }
});