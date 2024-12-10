<?php include 'php/blogs_process.php'; ?>
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
        .blog-image {
            width: 100px;
            height: auto;
        }
    </style>
</head>

<body id="page-top">
    <?php include 'nav.php'; ?>

    <div class="container mt-4">
        <h2>Blogbejegyzések</h2>
        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addBlogModal">Új bejegyzés hozzáadása</button>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cím</th>
                    <th>Szerző</th>
                    <th>Szöveg</th>
                    <th>Kép</th>
                    <th>Műveletek</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($blogs)): ?>
                    <?php foreach ($blogs as $blog): ?>
                    <tr>
                        <td><?= htmlspecialchars($blog['id']) ?></td>
                        <td><?= htmlspecialchars($blog['title']) ?></td>
                        <td><?= htmlspecialchars($blog['author']) ?></td>
                        <td><?= htmlspecialchars(substr($blog['content'], 0, 10)) . (strlen($blog['content']) > 10 ? '...' : '') ?></td>
                        <td><img src="<?= htmlspecialchars($blog['image']) ?>" alt="Blog image" style="width: 100px; height: auto;"></td>
                        <td>
                            <button class="btn btn-sm btn-warning edit-btn" 
                                data-id="<?= htmlspecialchars($blog['id']) ?>"
                                data-title="<?= htmlspecialchars($blog['title']) ?>"
                                data-content="<?= htmlspecialchars($blog['content']) ?>"
                                data-author="<?= htmlspecialchars($blog['author']) ?>"
                                data-image="<?= htmlspecialchars($blog['image']) ?>"
                                data-toggle="modal" 
                                data-target="#editBlogModal">Szerkesztés</button>

                            <button class="btn btn-sm btn-danger delete-btn" 
                                data-id="<?= htmlspecialchars($blog['id']) ?>" 
                                data-toggle="modal" 
                                data-target="#deleteBlogModal">Törlés</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">Nincsenek elérhető bejegyzések.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Edit Blog Modal -->
    <div class="modal fade" id="editBlogModal" tabindex="-1" role="dialog" aria-labelledby="editBlogModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="POST" action="php/blogs_process.php">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editBlogModalLabel">Blog bejegyzés módosítása</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="action" value="edit">
                        <input type="hidden" id="edit-blog-id" name="id">

                        <div class="form-group">
                            <label>Cím</label>
                            <input type="text" class="form-control" id="edit-title" name="title" required>
                        </div>
                        <div class="form-group">
                            <label>Szöveg</label>
                            <textarea class="form-control" id="edit-content" name="content" rows="5" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Szerző</label>
                            <input type="text" class="form-control" id="edit-author" name="author" required>
                        </div>
                        <div class="form-group">
                            <label>Kép URL</label>
                            <input type="text" class="form-control" id="edit-image" name="image">
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

    <!-- Delete Blog Modal -->
    <div class="modal fade" id="deleteBlogModal" tabindex="-1" role="dialog" aria-labelledby="deleteBlogModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="POST" action="php/blogs_process.php">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteBlogModalLabel">Blog bejegyzés törlése</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" id="delete-blog-id" name="id">
                        Biztosan törölni szeretnéd ezt a blogbejegyzést?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Mégse</button>
                        <button type="submit" class="btn btn-danger">Törlés</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Add Blog Modal -->
    <div class="modal fade" id="addBlogModal" tabindex="-1" role="dialog" aria-labelledby="addBlogModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="POST" action="php/blogs_process.php">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addBlogModalLabel">Új blog bejegyzés hozzáadása</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="action" value="add">
                        <div class="form-group">
                            <label>Cím</label>
                            <input type="text" class="form-control" name="title" required>
                        </div>
                        <div class="form-group">
                            <label>Szöveg</label>
                            <textarea class="form-control" name="content" rows="5" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Szerző</label>
                            <input type="text" class="form-control" name="author" required>
                        </div>
                        <div class="form-group">
                            <label>Kép URL</label>
                            <input type="text" class="form-control" name="image">
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
            const editButtons = document.querySelectorAll('.edit-btn');
            const deleteButtons = document.querySelectorAll('.delete-btn');

            // Edit modal
            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const blogId = this.dataset.id;
                    const title = this.dataset.title;
                    const content = this.dataset.content;
                    const author = this.dataset.author;
                    const image = this.dataset.image;

                    document.getElementById('edit-blog-id').value = blogId;
                    document.getElementById('edit-title').value = title;
                    document.getElementById('edit-content').value = content;
                    document.getElementById('edit-author').value = author;
                    document.getElementById('edit-image').value = image;
                });
            });

            // Delete modal
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const blogId = this.dataset.id;
                    document.getElementById('delete-blog-id').value = blogId;
                });
            });
        });
    </script>
</body>
</html>