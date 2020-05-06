<?php require_once("./Includes/database.php"); ?>
<?php require_once("./Includes/function.php"); ?>
<?php require_once("./Includes/session.php"); ?>

<?php
if (isset($_POST["submit"])) {
    $posttitle = $_POST["posttitle"];
    $chooseCat = $_POST["category"];
    $image =$_FILES["browseImg"]["name"];
    $target = "Images/".basename("$image");
    $postdescription =$_POST["postdescription"];

    $admin = "Anu";
    $currentTime = time();
    $today = strftime("%d/%B/%Y %H:%M:%S", $currentTime);

    error_log("cat11111111111");
    if (empty($posttitle)) {

        $_SESSION["ErrorMessage"] = "All fields must be filled";
        Redirect_to("addPosts.php");
    } else if (strlen($posttitle) < 5) {

        $_SESSION["ErrorMessage"] = "Title should be greater then 5 characters";
        Redirect_to("addPosts.php");
    } else if (strlen($postdescription) > 1199) {

        $_SESSION["ErrorMessage"] = "Post description should be less then 1199 characters";
        Redirect_to("addPosts.php");
    } else {
        $sql = "INSERT INTO post(posttitle,datepublished,categorytitle,author,image,post) VALUES
            
        (:posttitle,:datepublished,:categorytitle,:author,:image,:post)";
        $stmt = $ConnectDB->prepare($sql);
        $stmt->bindValue(':posttitle', $posttitle);
        $stmt->bindValue(':datepublished', $today);
        $stmt->bindValue(':categorytitle', $chooseCat);
        $stmt->bindValue(':author', $admin);
        $stmt->bindValue(':image', $target);
        $stmt->bindValue(':post', $postdescription);
        
        $execute = $stmt->execute();


        if ($execute) {
            $_SESSION["SuccessMessage"] = "Post Added";
            Redirect_to("index.php");
        } else {
            $_SESSION["ErrorMessage"] = "Post is not added,something went wrong ";
            Redirect_to("addPosts.php");
        }
    }
    error_log("cat222222222222");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Posts</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" />


    <script defer src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script defer src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script defer src="./js/javascript.js"></script>
</head>

<body>
    <video poster="./Images/pexels2.jpeg" id="bgvid" playsinline autoplay muted loop>
        <!-- 
- Video needs to be muted, since Chrome 66+ will not autoplay video with sound.
WCAG general accessibility recommendation is that media such as background video play through only once. Loop turned on for the purposes of illustration; if removed, the end of the video will fade in the same way created by pressing the "Pause" button  -->
        <source src="https://player.vimeo.com/external/224889154.sd.mp4?s=98d8a139b4ffb9a6627a37a8929c0fcf96e269c1&profile_id=164&oauth2_token_id=57447761" type="video/webm">
        <source src="https://player.vimeo.com/external/224889154.sd.mp4?s=98d8a139b4ffb9a6627a37a8929c0fcf96e269c1&profile_id=164&oauth2_token_id=57447761" type="video/mp4">

    </video>

    <?php include 'header.php'; ?>

    <section class="container py-2 mb-4">
        <div class="row">
            <div class="offset-lg-1 col-lg-10" style="min-height: 400px;">
                <?php
                echo ErrorMessage();
                echo SuccessMessage();
                ?>
                <form class="" action="addPosts.php" method="post" enctype="multipart/form-data">
                    <div class="card bg-secondary text-light mb-3">
                        <div class="card-header">
                            <h1>Add New Post</h1>
                        </div>
                        <div class="card-body bg-dark">
                            <div class="form-group">
                                <label for="title"><span class="fieldinfo ">Post Title:</span></label>
                                <input class="from-control" type="text" name="posttitle" id="title">
                            </div>
                            <div class="form-group">
                                <label for="posttitle"><span class="fieldinfo">Choose Category :</span></label>
                                <select class="form-control" id="categorytitle" name="category">
                           <?php
                           global $ConnectDB;
                           $sql = "SELECT * FROM category";
                           $stmt = $ConnectDB->query($sql);
                           while($rowData = $stmt->fetch()){
                               $id = $rowData["id"];
                               $categoryName = $rowData["cat_title"];
                           
                            ?>
                        <option><?php echo $categoryName; ?></option>
                           
                           <?php } ?>

                            </select>
                            </div>
                            <div class="form-group">
                                <label for="browseImg"><span class="fieldinfo">Browse Image :</span></label>
                                <div class="custom-file">
                                    <input class="custom-file-input" type="File" name="browseImg" id="browseImg" value="">
                                    <label class="custom-file-label" for="customFile"></label>
                                </div>
        

                            </div>
                            <div class="form-group">

                                <label for="post"><span class="fieldinfo">Post:</span></label>
                                <textarea name="postdescription" class="form-control" id="post" cols="80" rows="8"></textarea>


                            </div>
                            <div class="row">
                                <div class="col-lg-6 mb-2">
                                    <a href="dashbaord.php" class="btn btn-warning btn-block">Back To Dashboard</a>
                                </div>
                                <div class="col-lg-6">
                                    <button type="submit" name="submit" class="btn btn-warning btn-block">Publish</button>

                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>


        </div>

    </section>

    <?php include 'footer.php'; ?>

</body>

</html>