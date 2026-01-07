<h2>Tugas</h2>
<button id="clearTugas" type="button" style="margin-bottom:10px;">Hapus Semua Tugas</button>
<table id="tableTugas">
    <thead>
        <tr><th>Nama</th><th>Deadline</th><th>Aksi</th></tr>
    </thead>
    <tbody></tbody>
</table>

<h2>Kegiatan</h2>
<button id="clearKegiatan" type="button" style="margin-bottom:10px;">Hapus Semua Kegiatan</button>
<table id="tableKegiatan">
    <thead>
        <tr><th>Nama</th><th>Deadline</th><th>Aksi</th></tr>
    </thead>
    <tbody></tbody>
</table>

<h2>Selesai</h2>
<button id="clearDone" type="button" style="margin-bottom:10px;">Hapus Semua Selesai</button>
<table id="tableSelesai">
    <thead>
        <tr><th>Nama</th><th>Jenis</th><th>Deadline</th></tr>
    </thead>
    <tbody></tbody>
</table>

<form method="POST" action="logout.php">
    <button type="submit" class="logout-btn">Logout</button>
</form>

<script>

function loadDone(){
    const tbodySelesai = document.querySelector("#tableSelesai tbody");
    tbodySelesai.innerHTML = "";
    const doneArr = JSON.parse(localStorage.getItem("tableSelesai") || "[]");
    doneArr.forEach(item => {
        const row = document.createElement("tr");
        row.innerHTML = `<td>${item.nama}</td><td>${item.jenis}</td><td>${item.deadline}</td>`;
        tbodySelesai.appendChild(row);
    });
}

function updateTables(){
    const tbodyTugas = document.querySelector("#tableTugas tbody");
    const tbodyKegiatan = document.querySelector("#tableKegiatan tbody");
    tbodyTugas.innerHTML = "";
    tbodyKegiatan.innerHTML = "";

    const tugas = JSON.parse(localStorage.getItem("tableTugas") || "[]");
    const kegiatan = JSON.parse(localStorage.getItem("tableKegiatan") || "[]");

    tugas.forEach((item)=>{
        const row = document.createElement("tr");
        row.innerHTML = `<td>${item.nama}</td><td>${item.deadline}</td>
            <td>
                <button class="edit-btn">Edit</button>
                <button class="delete-btn">Hapus</button>
                <button class="done-btn">Selesai</button>
            </td>`;
        tbodyTugas.appendChild(row);
    });

    kegiatan.forEach((item)=>{
        const row = document.createElement("tr");
        row.innerHTML = `<td>${item.nama}</td><td>${item.deadline}</td>
            <td>
                <button class="edit-btn">Edit</button>
                <button class="delete-btn">Hapus</button>
                <button class="done-btn">Selesai</button>
            </td>`;
        tbodyKegiatan.appendChild(row);
    });

    loadDone();
}

function addTableEvents(){
    ["#tableTugas tbody","#tableKegiatan tbody"].forEach(sel=>{
        document.querySelector(sel).addEventListener("click", e=>{
            const tr = e.target.closest("tr");
            if(!tr) return;
            const tbody = tr.parentElement;
            let key = tbody.id==="tableTugas"?"tableTugas":"tableKegiatan";
            let arr = JSON.parse(localStorage.getItem(key) || "[]");
            let index = Array.from(tbody.children).indexOf(tr);

            if(e.target.classList.contains("delete-btn")){
                arr.splice(index,1);
                localStorage.setItem(key,JSON.stringify(arr));
                updateTables();
            } else if(e.target.classList.contains("edit-btn")){
                const newText = prompt("Edit nama:", arr[index].nama);
                if(newText){ arr[index].nama=newText; localStorage.setItem(key,JSON.stringify(arr)); updateTables();}
            } else if(e.target.classList.contains("done-btn")){
                const done = arr.splice(index,1)[0];
                let doneArr = JSON.parse(localStorage.getItem("tableSelesai")||"[]");
                doneArr.push({...done, jenis:key==="tableTugas"?"Tugas":"Kegiatan"});
                localStorage.setItem("tableSelesai",JSON.stringify(doneArr));
                localStorage.setItem(key,JSON.stringify(arr));
                updateTables();
            }
        });
    });
}

document.getElementById("clearDone").addEventListener("click", ()=>{
    localStorage.setItem("tableSelesai",JSON.stringify([]));
    updateTables();
});
document.getElementById("clearTugas").addEventListener("click", ()=>{
    localStorage.setItem("tableTugas",JSON.stringify([]));
    updateTables();
});
document.getElementById("clearKegiatan").addEventListener("click", ()=>{
    localStorage.setItem("tableKegiatan",JSON.stringify([]));
    updateTables();
});

updateTables();
addTableEvents();

</script>
