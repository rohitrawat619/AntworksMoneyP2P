<!DOCTYPE html>
<html>
<head>
    <title>CodeIgniter Pagination</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.2/css/bulma.min.css">
</head>
<body>
<div class="container">
    <h3 class="title is-3">CodeIgniter Database Pagination</h3>
    <div class="column">
        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
            <thead>
            <tr>
                <th>ID</th>
                <th>Company Name</th>
                <th>Contact Number</th>
                <th>Email</th>
                <th>City</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($results as $result): ?>
                <tr>
                    <td><?= $result->id ?></td>
                    <td><?= $result->company_name ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <p><?php echo $links; ?></p>
    </div>
</div>
</body>
</html>