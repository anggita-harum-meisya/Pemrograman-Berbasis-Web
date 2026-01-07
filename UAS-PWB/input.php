<div class="input-group">
    <select id="taskType">
        <option value="Tugas">Tugas</option>
        <option value="Kegiatan">Kegiatan</option>
</select>
<input type="text" id="taskText" placehorder="Nama tugas/kegiatan..."/>
<input type="date" id="deadlineDate" />
    <button id="addBtn">Tambah</button>
</div>

<script>
const addBtn = document.getElementById("addBtn");
const taskText = document.getElementById("taskText");
const taskType = document.getElementById("taskType");
const deadlineDate = document.getElementById("deadlineDate");

addBtn.addEventListener("click", ()=>{
    const text = taskText.value.trim();
    const type = taskType.value;
    const deadline = deadlineDate.value;

    if(!text){ alert("Tulis nama tugas/kegiatan!"); return; }

    let tugas = JSON.parse(localStorage.getItem("tableTugas") || "[]");
    let kegiatan = JSON.parse(localStorage.getItem("tableKegiatan") || "[]");

    if(type==="Tugas") tugas.push({nama:text, deadline:deadline});
    else kegiatan.push({nama:text, deadline:deadline});

    localStorage.setItem("tableTugas", JSON.stringify(tugas));
    localStorage.setItem("tableKegiatan", JSON.stringify(kegiatan));

    taskText.value = "";
    deadlineDate.value = "";

    if(typeof updateTables==="function") updateTables();
});
</script>
