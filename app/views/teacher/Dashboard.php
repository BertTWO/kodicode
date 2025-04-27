<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Teacher Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <nav class="navbar navbar-dark bg-success mb-4">
    <div class="container">
      <a class="navbar-brand" href="#">Teacher Dashboard</a>
      <a href="/kodicode/logout" class="btn btn-sm btn-warning">Logout</a>
    </div>

  </nav>

  <div class="container">
    <div class="mb-4">
      <h2>Students List</h2>
      <table class="table table-striped table-hover shadow-sm">
        <thead class="table-success">
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Grade Level</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>1</td>
            <td>Jane Doe</td>
            <td>jane@example.com</td>
            <td>Grade 10</td>
            <td><button class="btn btn-sm btn-primary">View</button></td>
          </tr>
          <tr>
            <td>2</td>
            <td>John Smith</td>
            <td>john@example.com</td>
            <td>Grade 11</td>
            <td><button class="btn btn-sm btn-primary">View</button></td>
          </tr>
          <!-- More students -->
        </tbody>
      </table>
    </div>
  </div>

</body>
</html>
