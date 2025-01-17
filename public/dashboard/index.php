<?php require_once("../header/header.php"); ?>
<?php


if (!isset($_SESSION['email'])) {
    header('Location:' . BASE_URL . "/login/index.php");
}

$filePath = "C:/laragon/www/PHP/File Operations/CRUD_OPERATION/database/db.txt";
if (file_exists($filePath) && is_readable($filePath)) {
    $allRegistrations = json_decode(file_get_contents($filePath), true);

    usort($allRegistrations, function ($a, $b) {
        return $a['id'] - $b['id'];
    });
}

?>

<section class="vh-100" style="background-color: #eee;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 mt-5">
                <?php if (isset($_GET['success'])) :  ?>
                    <div class="alert alert-success">
                        <?php
                        echo $_GET['success'];
                        ?>
                    </div>
                <?php endif; ?>
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#SL</th>
                            <th scope="col">ID</th>
                            <th scope="col">User Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php if (isset($allRegistrations)) :
                            $i = 0;
                            foreach ($allRegistrations as $data) :
                        ?>
                                <tr>
                                    <td><?php echo ++$i; ?></td>
                                    <td><?php echo $data['id']; ?></td>
                                    <td><?php echo $data['username'] ?? ""; ?></td>
                                    <td><?php echo $data['email'] ?? ""; ?></td>
                                    <td>
                                        <a href="#" class="btn btn-success btn-sm">View</a>
                                        <a href="<?php echo BASE_URL; ?>/user/edit.php?id=<?php echo $data['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                                        <a href="<?php echo BASE_URL; ?>/user/delete.php?id=<?php echo $data['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                                    </td>
                                </tr>
                        <?php
                            endforeach;
                        endif;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<?php require_once("../header/footer.php"); ?>