<?php
include 'php/attr_process.php';

$stmtCities = $conn->prepare("SELECT city_id, city_name FROM cities");
$stmtCities->execute();
$cities = $stmtCities->fetchAll(PDO::FETCH_ASSOC);
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
            max-width:1400px;
        }
    }    
    </style>

</head>
<body id="page-top">

<?php include 'nav.php'; ?>

<div class="container mt-7">
    <h2>Látványosságok</h2>
    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addAttractionModal">Új látványosság hozzáadása</button>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Neve</th>
                <th>Leírás</th>
                <th>Helyszín</th>
                <th>Létrehozta</th>
                <th>Város neve</th>
                <th>Kép</th>
                <th>Műveletek</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($attractions)): ?>
                <?php foreach ($attractions as $attraction): ?>
                <tr>
                    <td><?= htmlspecialchars($attraction['attractions_id']) ?></td>
                    <td><?= htmlspecialchars($attraction['name']) ?></td>
                    <td><?= htmlspecialchars($attraction['description']) ?></td>
                    <td><?= htmlspecialchars($attraction['address']) ?></td>
                    <td><?= htmlspecialchars($attraction['created_by']) ?></td>
                    <td><?= htmlspecialchars($attraction['city_name']) ?></td>
                    <td>
                        <?php if (!empty($attraction['image'])): ?>
                            <img src="<?= htmlspecialchars($attraction['image']) ?>" alt="<?= htmlspecialchars($attraction['name']) ?>" style="width: 100px; height: auto;">
                        <?php else: ?>
                            Nincs kép
                        <?php endif; ?>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-warning edit-btn" 
                            data-id="<?= htmlspecialchars($attraction['attractions_id']) ?>"
                            data-name="<?= htmlspecialchars($attraction['name']) ?>"
                            data-description="<?= htmlspecialchars($attraction['description']) ?>"
                            data-address="<?= htmlspecialchars($attraction['address']) ?>" 
                            data-created-by="<?= htmlspecialchars($attraction['created_by']) ?>"
                            data-city-name="<?= htmlspecialchars($attraction['city_name']) ?>"
                            data-toggle="modal" 
                            data-target="#editAttractionModal">Szerkesztés</button>
                        <button class="btn btn-sm btn-danger delete-btn" 
                            data-id="<?= htmlspecialchars($attraction['attractions_id']) ?>" 
                            data-toggle="modal" 
                            data-target="#deleteAttractionModal">Törlés</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="text-center">Nincsenek elérhető adatok.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Add Attraction Modal -->
<div class="modal fade" id="addAttractionModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="POST" action="php/attr_process.php" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Új látványosság hozzáadása</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="action" value="add">
                    <div class="form-group">
                        <label>Neve</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="form-group">
                        <label>Leírás</label>
                        <input type="text" class="form-control" name="description" required>
                    </div>
                    <div class="form-group">
                        <label>Helyszín</label>
                        <input type="text" class="form-control" name="address" required>
                    </div>
                    <div class="form-group">
                        <label>Létrehozta</label>
                        <input type="text" class="form-control" name="created_by" required>
                    </div>
                    <div class="form-group">
                        <label>Város neve</label>
                        <select class="form-control" name="city_name" required>
                            <?php foreach ($cities as $city): ?>
                                <option value="<?= htmlspecialchars($city['city_name']) ?>"><?= htmlspecialchars($city['city_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Kép feltöltése</label>
                        <input type="file" class="form-control-file" name="image">
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

<!-- Edit Attraction Modal -->
<div class="modal fade" id="editAttractionModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="POST" action="php/attr_process.php" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Látványosság szerkesztése</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="action" value="edit">
                    <input type="hidden" name="attractions_id" id="editAttractionId">
                    <div class="form-group">
                        <label>Neve</label>
                        <input type="text" class="form-control" name="name" id="editAttractionName" required>
                    </div>
                    <div class="form-group">
                        <label>Leírás</label>
                        <input type="text" class="form-control" name="description" id="editAttractionDescription" required>
                    </div>
                    <div class="form-group">
                        <label>Helyszín</label>
                        <input type="text" class="form-control" name="address" id="editAttractionAddress" required>
                    </div>
                    <div class="form-group">
                        <label>Létrehozta</label>
                        <input type="text" class="form-control" name="created_by" id="editAttractionCreatedBy" required>
                    </div>
                    <div class="form-group">
                        <label>Város neve</label>
                        <select class="form-control" name="city_name" id="editAttractionCityName" required>
                            <?php foreach ($cities as $city): ?>
                                <option value="<?= htmlspecialchars($city['city_name']) ?>"><?= htmlspecialchars($city['city_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Kép frissítése (opcionális)</label>
                        <input type="file" class="form-control-file" name="image">
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

<!-- Delete Attraction Modal -->
<div class="modal fade" id="deleteAttractionModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="POST" action="php/attr_process.php">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Látványosság törlése</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="attractions_id" id="deleteAttractionId">
                    <p>Biztosan törölni szeretnéd ezt a látványosságot?</p>
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
    document.addEventListener('DOMContentLoaded', function () {
        const editButtons = document.querySelectorAll('.edit-btn');
        const deleteButtons = document.querySelectorAll('.delete-btn');

        editButtons.forEach(button => {
            button.addEventListener('click', function () {
                const id = this.dataset.id;
                const name = this.dataset.name;
                const description = this.dataset.description;
                const address = this.dataset.address;
                const createdBy = this.dataset.createdBy;
                const cityName = this.dataset.cityName;

                document.getElementById('editAttractionId').value = id;
                document.getElementById('editAttractionName').value = name;
                document.getElementById('editAttractionDescription').value = description;
                document.getElementById('editAttractionAddress').value = address;
                document.getElementById('editAttractionCreatedBy').value = createdBy;

                const citySelect = document.getElementById('editAttractionCityName');
                for (let option of citySelect.options) {
                    option.selected = option.value === cityName;
                }
            });
        });

        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const id = this.dataset.id;
                document.getElementById('deleteAttractionId').value = id;
            });
        });
    });
</script>
</body>
</html>
