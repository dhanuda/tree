<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Milestones</title>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <h1>Project Milestones</h1>
    <table id="milestones" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>Project ID</th>
                <th>Posted Date</th>
                <th>Subject</th>
                <th>Due Date</th>
                <th>Start Date</th>
                <th>Description</th>
                <th>Hide to Cust</th>
                <th>Hide to All User</th>
                <th>Is Completed</th>
                <th>Added On</th>
                <th>User ID</th>
                <th>Is Revise</th>
                <th>Allotted To</th>
                <th>Parent ID</th>
                <th>Completed On</th>
                <th>Completed By</th>
                <th>Is Reopened</th>
                <th>Reopened On</th>
                <th>Reopened By</th>
                <th>Is Leaf</th>
                <th>Added By</th>
                <th>MST ID</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- Data will be loaded here via JavaScript -->
        </tbody>
    </table>

    <!-- Modal Structure -->
    <div class="modal fade" id="parentTreeModal" tabindex="-1" role="dialog" aria-labelledby="parentTreeModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="parentTreeModalLabel">Parent Tree View</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="accordion" id="accordionParentTree">
                        <!-- Accordion content will be injected here -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var table = $('#milestones').DataTable({
                "ajax": {
                    "url": "fetch_data.php",
                    "dataSrc": ""
                },
                "columns": [
                    { "data": "id" },
                    { "data": "proj_id" },
                    { "data": "posted_date" },
                    { "data": "subject" },
                    { "data": "due_date" },
                    { "data": "start_date" },
                    { "data": "description" },
                    { "data": "hidetocust" },
                    { "data": "hidetoalluser" },
                    { "data": "is_completed" },
                    { "data": "added_on" },
                    { "data": "user_id" },
                    { "data": "is_revise" },
                    { "data": "allotted_to" },
                    { "data": "parent_id" },
                    { "data": "completed_on" },
                    { "data": "completed_by" },
                    { "data": "is_reopened" },
                    { "data": "reopened_on" },
                    { "data": "reopened_by" },
                    { "data": "is_leaf" },
                    { "data": "added_by" },
                    { "data": "mst_id" },
                    {
                        "data": null,
                        "defaultContent": '<button class="btn btn-info btn-sm">View Parent Tree</button>',
                        "orderable": false
                    }
                ]
            });

            $('#milestones tbody').on('click', 'button', function () {
                var data = table.row($(this).parents('tr')).data();
                var projId = data.proj_id;

                $.ajax({
                    url: 'fetch_parent_tree.php',
                    type: 'GET',
                    data: { proj_id: projId },
                    success: function(response) {
                        $('#accordionParentTree').html(response);
                        $('#parentTreeModal').modal('show');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching parent tree:', status, error);
                    }
                });
            });
        });
    </script>
</body>
</html>
