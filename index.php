<?php
require_once 'core/init.php';


if(isset($_POST['url'])) {

    $url = $_POST['url'];
    $getPars = new GetPagePars();
    $getPars->getParsUrl($url);
//    echo '<pre>'; print_r($getPars->get_all_pars); die;

    DB::getInstance()->insert('pages', $getPars->get_all_pars);

}

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

<form action="" method="post" style="margin-bottom: 50px">
    <div style="float: left">
        parse url: <input type="text" name="url" placeholder="url"><br>
    </div>
    <input type="submit" value="parse">
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
                <td><?=$page->url?></td>
                <td><?=$page->title?></td>
                <td><?=$page->url?></td>
            </tr>
        <?php }?>
    </table>
<?php }?>

</body>
</html>





