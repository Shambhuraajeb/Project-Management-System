<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Meeting</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="stylemeeting.css">
</head>

<body>
    <div class="container">
        <div class="card p-4 mt-5">
            <div class="card-header bg-primary text-white">
                <h1 class="card-title mb-0">Create Meeting</h1>
            </div>
            <div class="card-body">
                <form action="include/create_meeting.php" method="POST">
                    <div class="mb-3">
                        <label for="title" class="form-label">Meeting Name</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Meeting Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Meeting Link(<i>If meeting held online</i>)</label>
                        <input type="text" class="form-control" id="link" name="link">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="start_time" class="form-label">Date</label>
                            <input type="date" class="form-control" id="start_time" name="date"
                                required>
                        </div>
                        <div class="col-md-6">
                            <label for="end_time" class="form-label">Start Time</label>
                            <input type="time" class="form-control" id="end_time" name="start_time" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="location" class="form-label">Location</label>
                        <input type="text" class="form-control" id="location" name="location" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="submit">Create Meeting</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Include JavaScript for dynamic addition/removal of agenda and topic items -->
    <script src="script.js"></script>
</body>

</html>