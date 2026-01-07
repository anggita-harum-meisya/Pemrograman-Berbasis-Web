<?php
session_start();
if(!isset($_SESSION['logged_in'])){
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>To-Do List</title>
<style>
body {
    font-family: "Poppins", sans-serif;
    background: linear-gradient(135deg, #a18cd1, #fbc2eb);
    margin: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}

.container {
    background: rgba(255,255,255,0.95);
    border-radius: 20px;
    padding: 25px;
    width: 800px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.1);
}

h1, h2 { text-align:center; color:#444; margin-bottom:15px; }

.input-group {
    display: flex;
    justify-content: center;
    gap: 10px;
    flex-wrap: wrap;
    margin-bottom: 30px;
}

input, select, button {
    padding: 8px;
    border-radius: 8px;
    border: 2px solid #b388ff;
    font-size: 14px;
}

button {
    background-color: #b388ff;
    color: white;
    font-weight: bold;
    cursor: pointer;
}

button:hover { background-color: #9575cd; }

table {
    width:100%;
    border-collapse: collapse;
    margin-bottom:30px;
}

th, td {
    border:1px solid #999;
    padding:8px;
    text-align:left;
}

th { background-color: #b388ff; color:white; }

td button {
    margin-right:5px;
    padding:5px 8px;
    border:none;
    border-radius:5px;
    cursor:pointer;
    color:white;
}

.edit-btn { background:#ffb74d; }
.edit-btn:hover { background:#f57c00; }
.delete-btn { background:#e91e63; }
.delete-btn:hover { background:#c2185b; }
.done-btn { background:#4caf50; }
.done-btn:hover { background:#388e3c; }

.logout-btn {
    background-color: #e91e63;
    color:white;
    border:none;
    border-radius:10px;
    padding:10px;
    cursor:pointer;
    font-weight:bold;
    width:100%;
    margin-top:20px;
}

.logout-btn:hover { background-color:#c2185b; }

.footer { text-align:center; margin-top:10px; font-size:12px; color:#666; }
</style>
</head>
<body>
<div class="container">
<h1>To-Do List</h1>

<!-- INPUT -->
<div class="input-group">
    <select id="taskType">
        <option value="Tugas">Tugas</option>
        <option value="Kegiatan">Kegiatan</option>
    </select>
    <input type="text" id="taskText" placeholder="Nama tugas/kegiatan..." />
    <input type="date" id="deadlineDate" />
    <button id="addBtn">Tambah</button>
</div>

<!-- TABEL -->
<h2>Tugas</h2>
<table id="tableTugas">
    <thead>
        <tr><th>Nama</th><th>Deadline</th><th>Aksi</th></tr>
    </thead>
    <tbody></tbody>
</table>

<h2>Kegiatan</h2>
<table id="tableKegiatan">
    <thead>
        <tr><th>Nama</th><th>Deadline</th><th>Aksi</th></tr>
    </thead>
    <tbody></tbody>
</table>

<h2>Selesai</h2>
<table id="tableSelesai">
    <thead>
        <tr><th>Nama</th><th>Jenis</th><th>Deadline</th></tr>
    </thead>
    <tbody></tbody>
</table>

<!-- LOGOUT -->
<form method="POST" action="logout.php">
    <button type="submit" class="logout-btn">Logout</button>
</form>

<div class="footer">Dibuat oleh Anggita Harum</div>
</div>

<script>
// References
const addBtn = document.getElementById("addBtn");
const taskText = document.getElementById("taskText");
const taskType = document.getElementById("taskType");
const deadlineDate = document.getElementById("deadlineDate");

const tbodyTugas = document.querySelector("#tableTugas tbody");
const tbodyKegiatan = document.querySelector("#tableKegiatan tbody");
const tbodySelesai = document.querySelector("#tableSelesai tbody");

// Load data
function loadData(){
    tbodyTugas.innerHTML = localStorage.getItem("tableTugas") || "";
    tbodyKegiatan.innerHTML = localStorage.getItem("tableKegiatan") || "";
    tbodySelesai.innerHTML = localStorage.getItem("tableSelesai") || "";
}
loadData();

// Save data
function saveData(){
    localStorage.setItem("tableTugas", tbodyTugas.innerHTML);
    localStorage.setItem("tableKegiatan", tbodyKegiatan.innerHTML);
    localStorage.setItem("tableSelesai", tbodySelesai.innerHTML);
}

// Add new row
addBtn.addEventListener("click", ()=>{
    const text = taskText.value.trim();
    const type = taskType.value;
    const deadline = deadlineDate.value;

    if(!text){ alert("Tulis nama tugas/kegiatan!"); return; }

    const row = document.createElement("tr");
    row.innerHTML = `
        <td>${text}</td>
        <td>${deadline}</td>
        <td>
            <button class="edit-btn">Edit</button>
            <button class="delete-btn">Hapus</button>
            <button class="done-btn">Selesai</button>
        </td>
    `;

    if(type === "Tugas") tbodyTugas.appendChild(row);
    else tbodyKegiatan.appendChild(row);

    taskText.value = "";
    deadlineDate.value = "";

    saveData();
});

// Event delegation
function addTableEvents(tbody, type){
    tbody.addEventListener("click", e=>{
        const tr = e.target.closest("tr");
        if(!tr) return;

        if(e.target.classList.contains("delete-btn")){
            tr.remove();
            saveData();
        } else if(e.target.classList.contains("edit-btn")){
            const newText = prompt("Edit nama:", tr.cells[0].textContent);
            if(newText) tr.cells[0].textContent = newText;
            saveData();
        } else if(e.target.classList.contains("done-btn")){
            const nama = tr.cells[0].textContent;
            const deadline = tr.cells[1].textContent;
            const doneRow = document.createElement("tr");
            doneRow.innerHTML = `<td>${nama}</td><td>${type}</td><td>${deadline}</td>`;
            tbodySelesai.appendChild(doneRow);
            tr.remove();
            saveData();
        }
    });
}

addTableEvents(tbodyTugas, "Tugas");
addTableEvents(tbodyKegiatan, "Kegiatan");
</script>
</body>
</html>