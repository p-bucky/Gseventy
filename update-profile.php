<?php require_once("includes/classes/DateModifier.php"); ?>

<!-- HEADER  -->
<?php include "./includes/header.php" ?>

<!-- NAVIGATION -->
<?php include "./includes/navigation.php" ?>

<?php
// if user not logged in then page should redirect to index.php.
if (!isset($_SESSION['logged_in'])) {
    header("Location: ./index.php");
    exit();
}

$user_id = $_SESSION['user_id'];


// Using session to take username then updating user data in db by using username.
$user_name = $_SESSION['username'];
if (isset($_POST['update-bio'])) {
    $user_bio = $_POST['userbio'];

    // Updating Profile
    $sql = "UPDATE users SET biography = :ub WHERE user_id = :ui";
    $stmt = $connection->prepare($sql);
    $stmt->execute(['ub' => $user_bio, 'ui' => $user_id]);

    header("Location: profile.php");
    exit();
}

$sql = 'SELECT * FROM users WHERE user_id=:ui';
$stmt = $connection->prepare($sql);
$stmt->execute(['ui' => $user_id]);
$users = $stmt->fetchAll();

foreach ($users as $user) {
    $name = $user->user_firstname;
    $username = $user->username;
    $user_bio = $user->biography;
?>

    <div class="profile">
        <div class="profile-card">
            <div class="profile-card-content">
                <div class="profile-card-img">
                    <img src="./assets/images/dummy-profile.jpg" alt="profile-img">
                </div>
                <div class="update-profile-card-body">
                    <span class="profile-name"><?php echo $name ?></span>
                    <span class="profile-username">@<?php echo $username ?></span>
                    <span class="profile-bio-head">Achievements in Gaming</span>
                    <form action="" method="post" enctype="multipart/form-data">
                        <textarea name="userbio" class="post-content" id="body" cols="30" rows="10"><?php echo $user_bio ?></textarea>
                        <button name="update-bio">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<?php include "user_post.php" ?>


<?php include "./includes/footer.php" ?>