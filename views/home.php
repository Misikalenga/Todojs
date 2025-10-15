<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Todojs</title>
</head>
<body>
    <div class="flex items-center justify-center mt-10">
        <table>
        <thead>
            <tr>
                <th>Tache</th>
                <th>Détails</th>
            </tr>
        </thead>
        <tbody id="listTask">
            <tr >
                <td>tache</td>
                <td>info en plus</td>
            </tr>
    </table>
    </div>
    <script>
        function taskManage(todo){
            const listTask = document.getElementById('listTask');
            fetch('model/modelTask.php?task=' + encodeURIComponent(todo))
            .then(rep => rep.json())
            .then(data =>{
                for (let item of data){
                    listTask.innerHTML += `<tr><td>${item.title}</td><td>${item.comment}</td></tr>`;
                }
            })
        }

        taskManage("read");
    </script>
</body>
</html>