<?php include 'php/users_process.php'; ?>
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

</head>
<body id="page-top">
<?php include 'nav.php'; ?>
<div class="container mt-4">
    <h2>Felhasználók</h2>
    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addUserModal">Új felhasználó hozzáadása</button>
        <table id="userTable" class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Név</th>
                <th>Email</th>
                <th>Létrehozva</th>
                <th>Szerepkör</th> <!-- New column for role -->
                <th>Műveletek</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($users)): ?>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['id']) ?></td>
                    <td><?= htmlspecialchars($user['name']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= htmlspecialchars($user['created_at']) ?></td>
                    <td>
                        <?php
                            switch ($user['role']) {
                                case 0: echo 'Tiltott'; break;
                                case 1: echo 'Felhasználó'; break;
                                case 2: echo 'Admin'; break;
                            }
                        ?>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-warning edit-btn" 
                            data-id="<?= htmlspecialchars($user['id']) ?>"
                            data-name="<?= htmlspecialchars($user['name']) ?>"
                            data-email="<?= htmlspecialchars($user['email']) ?>" 
                            data-role="<?= htmlspecialchars($user['role']) ?>"
                            data-toggle="modal" 
                            data-target="#editUserModal">Szerkesztés</button>
                        <button class="btn btn-sm btn-danger delete-btn" 
                            data-id="<?= htmlspecialchars($user['id']) ?>" 
                            data-toggle="modal" 
                            data-target="#deleteUserModal">Törlés</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">Nincsenek elérhető adatok.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- New User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="POST" action="php/users_process.php">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Új felhasználó hozzáadása</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="action" value="add">
                    <div class="form-group">
                        <label for="add-user-name">Név</label>
                        <input type="text" class="form-control" id="add-user-name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="add-user-email">Email</label>
                        <input type="email" class="form-control" id="add-user-email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="add-user-password">Jelszó</label>
                        <input type="password" class="form-control" id="add-user-password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="add-user-role">Szerepkör</label>
                        <select class="form-control" id="add-user-role" name="role" required>
                            <option value="0">Tiltott</option>
                            <option value="1">Felhasználó</option>
                            <option value="2">Admin</option>
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


<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="POST" action="php/users_process.php">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Felhasználó módosítása</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="action" value="edit">
                    <input type="hidden" id="edit-user-id" name="id">
                    <div class="form-group">
                        <label for="edit-user-name">Név</label>
                        <input type="text" class="form-control" id="edit-user-name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-user-email">Email</label>
                        <input type="email" class="form-control" id="edit-user-email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-user-password">Új Jelszó</label>
                        <input type="password" class="form-control" id="edit-user-password" name="password">
                    </div>
                    <div class="form-group">
                        <label for="edit-user-role">Szerepkör</label>
                        <select class="form-control" id="edit-user-role" name="role" required>
                            <option value="0">Tiltott</option>
                            <option value="1">Felhasználó</option>
                            <option value="2">Admin</option>
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

<!-- Delete User Modal -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="POST" action="php/users_process.php">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteUserModalLabel">Felhasználó törlése</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" id="delete-user-id" name="id">
                    Biztosan törölni szeretnéd ezt a felhasználót?
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

    $('#userTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/Hungarian.json"
            }
        });

    const editButtons = document.querySelectorAll('.edit-btn');
    const deleteButtons = document.querySelectorAll('.delete-btn');

    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const userId = this.dataset.id;
            const userName = this.dataset.name;
            const userEmail = this.dataset.email;
            const userRole = this.dataset.role;

            document.getElementById('edit-user-id').value = userId;
            document.getElementById('edit-user-name').value = userName;
            document.getElementById('edit-user-email').value = userEmail;
            document.getElementById('edit-user-role').value = userRole;
        });
    });

    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const userId = this.dataset.id;
            document.getElementById('delete-user-id').value = userId;
        });
    });
});
</script>
</body>
</html>
