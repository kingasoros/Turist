<?php include 'php/tours_process.php'; 

$stmt = $conn->prepare("SELECT * FROM attractions ORDER BY name");
$stmt->execute();
$attractions = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $conn->prepare("
    SELECT t.tour_id, t.tour_name, t.tour_description, t.price, t.start_date, t.end_date, t.status, 
           GROUP_CONCAT(a.name ORDER BY ta.attraction_order) AS attractions,
           GROUP_CONCAT(a.attractions_id ORDER BY ta.attraction_order) AS attraction_ids
    FROM tours t
    LEFT JOIN tour_attractions ta ON t.tour_id = ta.tour_id
    LEFT JOIN attractions a ON ta.attractions_id = a.attractions_id
    GROUP BY t.tour_id
    ORDER BY t.tour_name
");
$stmt->execute();
$tours = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>EcoTrips</title>
    <link rel="icon" type="image/x-icon" href="img/logo.png">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <style>
    @media(min-width:1200px){
        .container{
            max-width:1600px;
        }
    }    
    </style>

</head>

<body id="page-top">

<?php include 'nav.php'; ?>

<div class="container mt-10">
    <h2>Túrák</h2>
    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addTourModal">Új túra hozzáadása</button>
    <table id="tourTable" class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Túra neve</th>
                <th>Leírás</th>
                <th>Ár</th>
                <th>Kezdő dátum</th>
                <th>Befejező dátum</th>
                <th>Látványosságok</th>
                <th>Státusz</th> 
                <th>Műveletek</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($tours)): ?>
                <?php foreach ($tours as $tour): ?>
                <tr>
                    <td><?= htmlspecialchars($tour['tour_id']) ?></td>
                    <td><?= htmlspecialchars($tour['tour_name']) ?></td>
                    <td><?= htmlspecialchars($tour['tour_description']) ?></td>
                    <td><?= htmlspecialchars($tour['price']) ?> Ft</td>
                    <td><?= htmlspecialchars($tour['start_date']) ?></td>
                    <td><?= htmlspecialchars($tour['end_date']) ?></td>
                    <td><?= htmlspecialchars($tour['attractions']) ?></td>
                    <td><?= htmlspecialchars($tour['status']) ?></td> <!-- Display the status -->
                    <td>
                    <button class="btn btn-sm btn-warning edit-btn" 
                        data-id="<?= htmlspecialchars($tour['tour_id']) ?>"
                        data-name="<?= htmlspecialchars($tour['tour_name']) ?>"
                        data-description="<?= htmlspecialchars($tour['tour_description']) ?>"
                        data-price="<?= htmlspecialchars($tour['price']) ?>"
                        data-start-date="<?= htmlspecialchars($tour['start_date']) ?>"
                        data-end-date="<?= htmlspecialchars($tour['end_date']) ?>"
                        data-status="<?= htmlspecialchars($tour['status']) ?>" 
                        data-attractions="<?= htmlspecialchars($tour['attraction_ids']) ?>"
                        data-toggle="modal" 
                        data-target="#editTourModal">Szerkesztés</button>
                        <button class="btn btn-sm btn-danger delete-btn" 
                            data-id="<?= htmlspecialchars($tour['tour_id']) ?>" 
                            data-toggle="modal" 
                            data-target="#deleteTourModal">Törlés</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9" class="text-center">Nincsenek elérhető túrák.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Add Tour Modal -->
<div class="modal fade" id="addTourModal" tabindex="-1" role="dialog" aria-labelledby="addTourModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="POST" action="php/tours_process.php">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTourModalLabel">Új túra hozzáadása</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="action" value="add">
                    <div class="form-group">
                        <label>Túra neve</label>
                        <input type="text" class="form-control" name="tour_name" required>
                    </div>
                    <div class="form-group">
                        <label>Leírás</label>
                        <textarea class="form-control" name="tour_description" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Ár</label>
                        <input type="number" class="form-control" name="price" required>
                    </div>
                    <label for="add_start_date">Kezdő dátum:</label>
                    <input type="date" id="add_start_date" name="start_date" required><br>

                    <label for="add_end_date">Befejező dátum:</label>
                    <input type="date" id="add_end_date" name="end_date" required><br>
                    <div id="add_date_error" class="text-danger" style="display: none; color: red; font-size: 0.9em;">
                        A kezdő dátum nem lehet későbbi, mint a befejező dátum!
                    </div>

                    <div class="form-group">
                        <label class="form-label">Látványosságok</label>
                        <div class="row">
                            <?php foreach ($attractions as $attraction) { ?>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="<?= $attraction['attractions_id'] ?>" id="attraction_<?= $attraction['attractions_id'] ?>" name="attractions[]">
                                        <label class="form-check-label" for="attraction_<?= $attraction['attractions_id'] ?>">
                                            <?= htmlspecialchars($attraction['name']) ?> (<?= htmlspecialchars($attraction['city_name']) ?>)
                                        </label>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Statusz</label>
                        <select class="form-control" name="status" required>
                            <option value="private">Private</option>
                            <option value="public">Public</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Mégse</button>
                    <button type="submit" class="btn btn-primary">Hozzáadás</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Edit Tour Modal -->
<div class="modal fade" id="editTourModal" tabindex="-1" role="dialog" aria-labelledby="editTourModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="POST" action="php/tours_process.php">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTourModalLabel">Túra szerkesztése</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="action" value="edit">
                    <input type="hidden" name="tour_id" id="edit-tour-id">

                    <div class="form-group">
                        <label>Túra neve</label>
                        <input type="text" class="form-control" name="tour_name" id="edit-tour-name" required>
                    </div>
                    <div class="form-group">
                        <label>Leírás</label>
                        <textarea class="form-control" name="tour_description" id="edit-tour-description" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Ár</label>
                        <input type="number" class="form-control" name="price" id="edit-tour-price" required>
                    </div>
                    <label for="edit_start_date">Kezdő dátum:</label>
                    <input type="date" id="edit_start_date" name="start_date" required><br>

                    <label for="edit_end_date">Befejező dátum:</label>
                    <input type="date" id="edit_end_date" name="end_date" required><br>
                    <div id="edit_date_error" class="text-danger" style="display: none; color: red; font-size: 0.9em;">
                        A kezdő dátum nem lehet későbbi, mint a befejező dátum!
                    </div>

                    <div class="form-group">
                        <label class="form-label">Látványosságok</label>
                        <div class="row">
                            <?php foreach ($attractions as $attraction) { ?>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="<?= $attraction['attractions_id'] ?>" id="attraction_<?= $attraction['attractions_id'] ?>" name="attractions[]">
                                        <label class="form-check-label" for="attraction_<?= $attraction['attractions_id'] ?>">
                                            <?= htmlspecialchars($attraction['name']) ?> (<?= htmlspecialchars($attraction['city_name']) ?>)
                                        </label>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Statusz</label>
                        <select class="form-control" name="status" id="edit-tour-status" required>
                            <option value="private">Private</option>
                            <option value="public">Public</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Mégse</button>
                    <button type="submit" class="btn btn-primary">Mentés</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Delete Tour Modal -->
<div class="modal fade" id="deleteTourModal" tabindex="-1" role="dialog" aria-labelledby="deleteTourModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="POST" action="php/tours_process.php">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteTourModalLabel">Túra törlése</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="tour_id" id="delete-tour-id">
                    <p>Biztosan törölni szeretnéd ezt a túrát?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Mégse</button>
                    <button type="submit" class="btn btn-danger">Törlés</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        $('#tourTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/Hungarian.json"
            }
        });

        const editButtons = document.querySelectorAll('.edit-btn');
        const deleteButtons = document.querySelectorAll('.delete-btn');
        
        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const tourId = this.dataset.id;
                const tourName = this.dataset.name;
                const tourDescription = this.dataset.description;
                const price = this.dataset.price;
                const startDate = this.dataset.startDate;
                const endDate = this.dataset.endDate;
                const status = this.dataset.status;
                const attractions = this.dataset.attractions ? this.dataset.attractions.split(',') : [];

                document.getElementById('edit-tour-id').value = tourId;
                document.getElementById('edit-tour-name').value = tourName;
                document.getElementById('edit-tour-description').value = tourDescription;
                document.getElementById('edit-tour-price').value = price;
                document.getElementById('edit_start_date').value = startDate;
                document.getElementById('edit_end_date').value = endDate;
                document.getElementById('edit-tour-status').value = status;

                // Clear all checkboxes
                document.querySelectorAll('#editTourModal .form-check-input').forEach(checkbox => {
                    checkbox.checked = false;
                });

                // Set the selected attractions
                attractions.forEach(attractionId => {
                    const checkbox = document.querySelector(`#editTourModal .form-check-input[value="${attractionId}"]`);
                    if (checkbox) {
                        checkbox.checked = true;
                    }
                });
            });
        });

        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const id = this.dataset.id;
                document.getElementById('delete-tour-id').value = id;
            });
        });
        
        function validateDates(startDateInput, endDateInput, errorDiv) {
            const startDate = new Date(startDateInput.value);
            const endDate = new Date(endDateInput.value);

            if (startDate && endDate && startDate > endDate) {
                errorDiv.style.display = 'block';
                startDateInput.setCustomValidity('A kezdő dátum nem lehet későbbi, mint a befejező dátum!');
            } else {
                errorDiv.style.display = 'none';
                startDateInput.setCustomValidity('');
            }
        }

        // Add Tour Modal
        const addStartDateInput = document.getElementById('add_start_date');
        const addEndDateInput = document.getElementById('add_end_date');
        const addErrorDiv = document.getElementById('add_date_error');

        addStartDateInput.addEventListener('input', () => validateDates(addStartDateInput, addEndDateInput, addErrorDiv));
        addEndDateInput.addEventListener('input', () => validateDates(addStartDateInput, addEndDateInput, addErrorDiv));

        // Edit Tour Modal
        const editStartDateInput = document.getElementById('edit_start_date');
        const editEndDateInput = document.getElementById('edit_end_date');
        const editErrorDiv = document.getElementById('edit_date_error');

        editStartDateInput.addEventListener('input', () => validateDates(editStartDateInput, editEndDateInput, editErrorDiv));
        editEndDateInput.addEventListener('input', () => validateDates(editStartDateInput, editEndDateInput, editErrorDiv));
    });
</script>

</body>
</html>