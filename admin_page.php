<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <style>
        body {
            font-family: sans-serif;
        }
        .container {
            width: 80%;
            margin: 0 auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .btn {
            padding: 5px 10px;
            text-decoration: none;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-right: 5px;
        }
        .btn-danger {
            background-color: #f44336;
            color: white;
        }
        .btn-warning {
            background-color: #ff9800;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>User List</h1>
        <table>
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Family Name</th>
                    <th>Given Name</th>
                    <th>Full Name</th>
                    <th>CPF</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'connection_db.php';
                $rs = $conn->query("SELECT * FROM usuarios");
                while($row = $rs->fetch(PDO::FETCH_OBJ)){
                    echo "<tr>";
                    echo "<td>{$row->email}</td>";
                    echo "<td>{$row->family_name}</td>";
                    echo "<td>{$row->given_name}</td>";
                    echo "<td>{$row->full_name}</td>";
                    echo "<td>{$row->cpf}</td>";
                    echo "<td>
                            <a href='#' class='btn btn-danger'>Delete</a>
                            <a href='#' class='btn btn-warning'>Edit</a>
                          </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>