<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fashion Bay</title>
    <link rel="icon" type="image/x-icon" href="/dRaczekProjekt/img/logo/logo_transparent_img_only.png">
    <?php echo $data['styles']; ?>
    <link rel="stylesheet" href="/dRaczekProjekt/css/categoriesList.css">
</head>
<body>
    <?php echo $data['header']; ?>
    <main>
        <div class="items">
            <?php foreach($data['categories'] as $category): ?>
                <a class="item" href="/dRaczekProjekt/products?page=1&size=20&categoryId=<?php echo $category['id']; ?>">
                    <div class="img-wrapper">
                        <img src="/dRaczekProjekt/<?php echo $category['image_path']; ?>">
                    </div>
                    <div class="name">
                        <?php echo $category['name']; ?>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </main>
    <?php echo $data['footer']; ?>
</body>
</html>