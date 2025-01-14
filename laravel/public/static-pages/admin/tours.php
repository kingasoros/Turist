<?php include 'php/tours_process.php'; 

$stmt = $conn->prepare("SELECT * FROM attractions ORDER BY name");
$stmt->execute();
$attractions = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $conn->prepare("
    SELECT t.tour_id, t.tour_name, t.tour_description, t.price, t.start_date, t.end_date, t.status, 
           GROUP_CONCAT(a.name ORDER BY ta.attraction_order) AS attractions
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
    <table class="table table-bordered">
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
                    <div class="form-group">
                        <label>Látványosságok</label>
                        <select class="form-control" name="attractions[]" multiple required>
                            <?php foreach ($attractions as $attraction): ?>
                                <option value="<?= $attraction['attractions_id'] ?>"><?= htmlspecialchars($attraction['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Statusz</label>
                        <select class="form-control" name="status" required>
                            <option value="private">Private</option>
                            <option value="public">Public</option>
                        </select>
                    </div>
                    <label for="image">Kép feltöltése</label>
                    <input type="file" name="image" class="form-control-file" id="image">
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
                    <div class="form-group">
                        <label>Látványosságok</label>
                        <select class="form-control" name="attractions[]" multiple id="edit-tour-attractions" required>
                            <?php foreach ($attractions as $attraction): ?>
                                <option value="<?= $attraction['attractions_id'] ?>"><?= htmlspecialchars($attraction['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Statusz</label>
                        <select class="form-control" name="status" id="edit-tour-status" required>
                            <option value="private">Private</option>
                            <option value="public">Public</option>
                        </select>
                    </div>
                    <label for="image">Kép feltöltése</label>
                    <input type="file" name="image" class="form-control-file" id="image">
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
        const editButtons = document.querySelectorAll('.edit-btn');
        
        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const tourId = this.dataset.id;
                const tourName = this.dataset.name;
                const tourDescription = this.dataset.description;
                const price = this.dataset.price;
                const startDate = this.dataset.startDate;
                const endDate = this.dataset.endDate;
                const status = this.dataset.status;

                document.getElementById('edit-tour-id').value = tourId;
                document.getElementById('edit-tour-name').value = tourName;
                document.getElementById('edit-tour-description').value = tourDescription;
                document.getElementById('edit-tour-price').value = price;
                document.getElementById('edit-tour-start-date').value = startDate;
                document.getElementById('edit-tour-end-date').value = endDate;
                document.getElementById('edit-tour-status').value = status; 
            });
        });
    });
</script>

</body>
</html>