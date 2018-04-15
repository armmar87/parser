<?php
require_once 'core/init.php';


if(isset($_POST['url'])) {
    $url = $_POST['url'];
    $getPars = new GetPagePars();
    $getPars->getParsUrl($url);
}

$links = '';


$pages = DB::getInstance()->query('SELECT * FROM pages');

?>

<!DOCTYPE html>
<html>
<head>
    <title>Page Title</title>
</head>
<style>
    table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
    }
</style>
<body>
<div>
    <div>
        <form action="" method="post" style="margin-bottom: 30px">
            <div style="float: left">
                <label>Parse Url:</label>
                <input type="text" name="url"><br>
            </div>
            <input type="submit" value="Parse">
        </form>

        <?php if(count($pages->results()) > 0) {?>
            <table style="width:80%">
                <tr>
                    <th>#</th>
                    <th>Url</th>
                    <th>Title</th>
                    <th>Export</th>
                </tr>

                    <?php foreach($pages->results() as $page) {?>
                    <tr>
                        <td><?=$page->id?></td>
                        <td><a href="<?=$page->url?>" target="_blank"><?=$page->url?></a></td>
                        <td><?=$page->title?></td>
                        <td><a href="/xml/page_<?php echo $page->uniq_id ?>.xml" download>Export Xml</a></td>
                    </tr>
                <?php }?>
            </table>
        <?php }?>

    </div>
    <div>
        <form action="" method="post" style="margin-bottom: 20px;margin-top: 50px;">
            <div style="float: left">
                <label>Search Links:</label>
                <input type="text" name="search"><br>
            </div>
            <input type="submit" value="Search">
        </form>

        <?php
            if(isset($_POST['search'])) {
                $search = $_POST['search'];
                $links = DB::getInstance()->query('SELECT id, url
                FROM pages
                ORDER BY CASE
                    WHEN title LIKE \'%'.$search.'%\' THEN 1
                    WHEN content LIKE \'%'.$search.'%\' THEN 2
                    ELSE 3
                END;'); ?>

                <table style="width:80%">
                    <tr>
                        <th>#</th>
                        <th>Link</th>
                    </tr>
                    <?php foreach($links->results() as $link) {?>
                        <tr>
                            <td><?=$link->id?></td>
                            <td><a href="<?=$link->url?>" target="_blank"><?=$link->url?></a></td>
                        </tr>
                    <?php }?>
                </table>

        <?php } ?>
    </div>
</div>



</body>
</html>





