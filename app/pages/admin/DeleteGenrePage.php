<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" sizes="180x180" href="<?= BASE_URL ?>/icon/favicon-110.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= BASE_URL ?>/icon/favicon-32.png">
    <!-- Global CSS -->
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/styles/template/globals.css">
    <!-- Navbar CSS -->
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/styles/template/popup.css">
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/styles/template/navbar.css">
    <!-- Page-specific CSS -->
    <link rel="stylesheet" type="text/css" href="<?= BASE_URL ?>/styles/admin/list.css">
    <title>Delete Genre : <? echo $this->data['genre_id'];?></title>
</head>

<body>
    <!-- Navigation bar -->
    <?php include(dirname(__DIR__) . '../../components/Navbar.php') ?>
    <section>
        <!-- Pop Up -->
        <span class="overlay"></span>

        <div class="modal-box">
            <h2>Delete Genre</h2>
            <h3>Are you sure want to delete this Genre?</h3>

            <div class="buttons">
                <button class="cancel-btn">Cancel</button>
                <button id="deleteGenre" class="confirm-btn-delete">Delete</button>
            </div>
        </div>
    <div class="wrapper-small">
        <div class="pad-40">
            <h1>Delete Genre Page</h1>
            <div class="centered">
                <form  
                    class="center-contents"
                    enctype="multipart/form-data"
                >
                    <p class="form-label">Genre ID : <?
                        echo $this->data['genre_id'];
                    ?></p>

                    <p class="form-label">Genre Name : <?
                        echo $this->data['name'];
                    ?></p>

                    <input type="button" class="show-modal button green-button" value="Delete">

                </form>
            </div>
        </div>
    </div>
    </section>
<script>
    const section = document.querySelector("section"),
        overlay = document.querySelector(".overlay"),
        showBtn = document.querySelector(".show-modal"),
        closeBtn = document.querySelector(".cancel-btn"),
        deleteGenre = document.getElementById("deleteGenre");

        deleteGenre.addEventListener("click", function (event) {
            event.preventDefault();
            const form = document.querySelector('form');
            form.action="/genre/delete/<? echo $this->data['genre_id']?>"
            form.method = "POST";
            form.enctype = "multipart/form-data";
            form.submit();
        });

    showBtn.addEventListener("click", ()=>section.classList.add("active"));

    overlay.addEventListener("click", () =>
        section.classList.remove("active")
    );

    closeBtn.addEventListener("click", () =>
        section.classList.remove("active")
    );
</script>
</body>

</html>