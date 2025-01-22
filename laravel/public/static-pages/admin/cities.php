<?php include 'php/cities_process.php'; ?>
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
    @media (max-width: 768px) {
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .table {
            min-width: 500px; 
        }
    }
    </style>
</head>

<body id="page-top">

<?php include 'nav.php'; ?>

<div class="container mt-4">
    <h2>Városok</h2>
    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addCityModal">Új város hozzáadása</button>
    <div class="table-responsive">
        <table id="cityTable" class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Ország</th>
                    <th>Város</th>
                    <th>Irányítószám</th>
                    <th>Műveletek</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($cities)): ?>
                    <?php foreach ($cities as $city): ?>
                    <tr>
                        <td><?= htmlspecialchars($city['city_id']) ?></td>
                        <td><?= htmlspecialchars($city['country_name']) ?></td>
                        <td><?= htmlspecialchars($city['city_name']) ?></td>
                        <td><?= htmlspecialchars($city['zip_code']) ?></td>
                        <td>
                            <button class="btn btn-sm btn-warning edit-btn" 
                                data-id="<?= htmlspecialchars($city['city_id']) ?>"
                                data-country="<?= htmlspecialchars($city['country_name']) ?>"
                                data-city="<?= htmlspecialchars($city['city_name']) ?>"
                                data-zip="<?= htmlspecialchars($city['zip_code']) ?>" 
                                data-toggle="modal" 
                                data-target="#editCityModal">Szerkesztés</button>
                            <button class="btn btn-sm btn-danger delete-btn" 
                                data-id="<?= htmlspecialchars($city['city_id']) ?>" 
                                data-toggle="modal" 
                                data-target="#deleteCityModal">Törlés</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">Nincsenek elérhető adatok.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Edit City Modal -->
<div class="modal fade" id="editCityModal" tabindex="-1" role="dialog" aria-labelledby="editCityModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="POST" action="php/cities_process.php">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCityModalLabel">Város módosítása</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="action" value="edit">
                    <input type="hidden" id="edit-city-id" name="city_id">
                    <div class="form-group">
                        <label>Ország</label>
                        <input type="text" class="form-control" id="edit-country-name" name="country_name" required>
                    </div>
                    <div class="form-group">
                        <label>Város</label>
                        <input type="text" class="form-control" id="edit-city-name" name="city_name" required>
                    </div>
                    <div class="form-group">
                        <label>Irányítószám</label>
                        <input type="text" class="form-control" id="edit-zip-code" name="zip_code" required>
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

<!-- Delete City Modal -->
<div class="modal fade" id="deleteCityModal" tabindex="-1" role="dialog" aria-labelledby="deleteCityModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="POST" action="php/cities_process.php">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteCityModalLabel">Város törlése</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" id="delete-city-id" name="city_id">
                    Biztosan törölni szeretnéd ezt a várost?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Mégse</button>
                    <button type="submit" class="btn btn-danger">Törlés</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Add City Modal -->
<div class="modal fade" id="addCityModal" tabindex="-1" role="dialog" aria-labelledby="addCityModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="POST" action="php/cities_process.php">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCityModalLabel">Új város hozzáadása</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="action" value="add">
                    <div class="form-group">
                        <label>Ország</label>
                        <input type="text" class="form-control" name="country_name" required>
                    </div>
                    <div class="form-group">
                        <label>Város</label>
                        <input type="text" class="form-control" name="city_name" required>
                    </div>
                    <div class="form-group">
                        <label>Irányítószám</label>
                        <input type="text" class="form-control" name="zip_code" required>
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


<script>
document.addEventListener('DOMContentLoaded', function() {
    $('#cityTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/Hungarian.json"
            }
        });

    const editButtons = document.querySelectorAll('.edit-btn');
    const deleteButtons = document.querySelectorAll('.delete-btn');

    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const cityId = this.dataset.id;
            const countryName = this.dataset.country;
            const cityName = this.dataset.city;
            const zipCode = this.dataset.zip;

            document.getElementById('edit-city-id').value = cityId;
            document.getElementById('edit-country-name').value = countryName;
            document.getElementById('edit-city-name').value = cityName;
            document.getElementById('edit-zip-code').value = zipCode;
        });
    });

    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const cityId = this.dataset.id;
            document.getElementById('delete-city-id').value = cityId;
        });
    });
});
</script>
</body>
</html>
