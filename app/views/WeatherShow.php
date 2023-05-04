<html>
    <head>
        <title>Weather page</title>
    </head>
    <body>
        <h1>Weather webpage</h1>
        <p>This is a preview of the weather table from the database</p>
        <table>
            <thead>
                <tr>
                <th>ID</th>
                <th>Date</th>
                <th>Temperature</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($data as $entry) {?>
                <tr>
                <td><?=$entry->getId()?></td>
                <td><?=$entry->getDate()?></td>
                <td><?=$entry->getTemperature()?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </body>
</html>