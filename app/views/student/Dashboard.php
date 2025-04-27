<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Student Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <nav class="navbar navbar-dark bg-primary mb-4">
    <div class="container">
      <a class="navbar-brand" href="#">Student Dashboard</a>
      <a href="/kodicode/logout" class="btn btn-sm btn-warning">Logout</a>
    </div>
  </nav>

  <div class="container">
    <div class="row g-4">
      <div class="col-md-4">
        <div class="card shadow-sm">
          <div class="card-body">
            <h5 class="card-title">My Courses</h5>
            <p class="card-text">View and manage your enrolled courses.</p>
            <a href="#" class="btn btn-primary">View Courses</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card shadow-sm">
          <div class="card-body">
            <h5 class="card-title">Assignments</h5>
            <p class="card-text">See your upcoming assignments and deadlines.</p>
            <a href="#" class="btn btn-primary">View Assignments</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card shadow-sm">
          <div class="card-body">
            <h5 class="card-title">Grades</h5>
            <p class="card-text">Track your grades and progress.</p>
            <a href="#" class="btn btn-primary">View Grades</a>
          </div>
        </div>
      </div>
    </div>
  </div>

</body>
</html>
