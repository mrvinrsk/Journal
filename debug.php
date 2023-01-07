<?php include_once "php/sql.php"; ?>

<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=yes, initial-scale=1.0, maximum-scale=2.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Journal</title>

    <link rel="stylesheet" href="style/css/global.css">
    <link rel="stylesheet" href="style/css/debug.css">
</head>
<body>

<main>
    <h1>Debug</h1>

    <?php echo (isset($pdo) ? "SQL verbunden" : "SQL nicht verbunden") . "."; ?>

    <div class="tables-wrapper">
        <h2>Tabellen</h2>
        <p>
            Aktuell gibt es die folgenden Tabellen:
        </p>

        <div class="tables">
            <?php
            // Select all tables
            $sql = "SHOW TABLES";
            $result = $pdo->query($sql);

            // Print a table for each table in the database
            while ($row = $result->fetch(PDO::FETCH_NUM)) {
                $table = $row[0];

                // Get the structure of the table
                $structure_sql = "DESCRIBE $table";
                $structure_result = $pdo->query($structure_sql);
                ?>

                <div class="sql-table">
                    <h3><?php echo $table; ?></h3>

                    <div class="table">
                        <table>
                            <thead>
                            <tr>
                                <th>Field</th>
                                <th>Type</th>
                                <th>Null</th>
                                <th>Key</th>
                                <th>Default</th>
                                <th>Extra</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php
                            // Print the rows of the table
                            while ($structure_row = $structure_result->fetch(PDO::FETCH_ASSOC)) {
                                echo "<tr>";
                                echo "<td>" . $structure_row['Field'] . "</td>";
                                echo "<td>" . $structure_row['Type'] . "</td>";
                                echo "<td>" . $structure_row['Null'] . "</td>";
                                echo "<td>" . $structure_row['Key'] . "</td>";
                                echo "<td>" . $structure_row['Default'] . "</td>";
                                echo "<td>" . $structure_row['Extra'] . "</td>";
                                echo "</tr>";
                            }
                            ?>
                            </tbody>

                        </table>
                    </div>
                </div>

            <?php } ?>

        </div>
    </div>


</main>

</body>
</html>