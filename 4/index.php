<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>4 задание</title>
        <style>
            ul{
                list-style-type: circle;
            }
            .menu{
                float: left;
                display: block;
                width: 50%;
            }
            .products{
                float: left;
                display: block;
                width: 50%;
            }
        </style>
    </head>
    <body>
        <div class="menu">
            <?php
            function set_child($current_id_parent, $groups){
                if ($current_id_parent != 0) {
                    $groups[$current_id_parent]->child = [];
                    foreach ($groups as $need_child) {
                        if ($need_child->id_parent == $current_id_parent){
                            $groups[$current_id_parent]->child[] = $need_child;
                        }
                    }
                    return set_child($groups[$current_id_parent]->id_parent, $groups);
                }
                else{
                    return $groups;
                }
            }

            function print_child($top_with_child, $current_id){
                if (isset($top_with_child->child)) {
                    echo "<ul>";
                    foreach ($top_with_child->child as $children){
                        if ($children->id == $current_id){
                            echo "<li><a>" . $children->name . " ".$children->count. "</a></li>";
                        }
                        else{
                            echo "<li><a href='?group=" . $children->id . "'>" . $children->name . " ".$children->count. "</a></li>";
                        }
                        print_child($children, $current_id);
                    }
                    echo "</ul>";
                }
            }

            function count_product($group, $products){
                $prods = [];
                foreach ($products as $product){
                    if($product->id_group == $group->id){
                        $prods[]=$product;
                    }
                }

                $count = count($prods);
                if ($group->child){
                    foreach ($group->child as $child){
                        $count += count_product($child, $products)[0];
                        foreach (count_product($child, $products)[1] as $product){
                            array_push($prods, $product);
                        };
                    }
                }

                return [$count, $prods];
            }

            $host = 'localhost';
            $user = 'root';
            $password = '';
            $db = 'test';

            $dbh = new PDO('mysql:host=localhost;dbname=test', $user, $password);

            $sth = $dbh->prepare("SELECT * FROM `groups`");
            $sth->execute();
            $groups_sql = $sth->fetchAll(PDO::FETCH_OBJ);
            $groups = [];
            foreach ($groups_sql as $group){
                $groups[$group->id] = $group;
            }
            foreach (array_reverse($groups) as $group){
                set_child($group->id, $groups);
            }

            $sth = $dbh->prepare("SELECT * FROM `products` ORDER BY name" );
            $sth->execute();
            $products_sql = $sth->fetchAll(PDO::FETCH_OBJ);
            $products = [];
            foreach ($products_sql as $product){
                $products[$product->id] = $product;
            }

            $groups_count_products = $groups;

            foreach (array_reverse($groups) as $group){
                $groups_count_products[$group->id]->count = count_product($group, $products)[0];
                $groups_count_products[$group->id]->products = count_product($group, $products)[1];
            }

//            foreach ($groups_count_products as $group){
//                echo $group->name." ".$group->count;
//                var_dump($group->products);
//                echo "<br><br><br>";
//            }

//            $sth = $dbh->prepare("SELECT * FROM `groups`");
//            $sth->execute();
//            $groups_sql = $sth->fetchAll(PDO::FETCH_OBJ);
            $groups = [];
            foreach ($groups_count_products as $group){
                $groups[$group->id] = new stdClass();
                $groups[$group->id]->id = $group->id;
                $groups[$group->id]->id_parent = $group->id_parent;
                $groups[$group->id]->name = $group->name;
                $groups[$group->id]->count = $group->count;
                $groups[$group->id]->products = $group->products;
            }


            echo "<a href='index.php'>Все категории</a>";
            echo "<ul>";

            if(isset($_GET['group'])){
                $current_id = intval($_GET['group']);
                $current_id_parent = $groups[$_GET['group']]->id_parent;
                set_child($current_id, $groups);
                foreach ($groups as $group) {
                    if ($group->id_parent == 0) {
                        if($group->id == $current_id){
                            echo "<li><a>" . $group->name . " ".$group->count."</a></li>";
                        }
                        else{
                            echo "<li><a href='?group=" . $group->id . "'>" . $group->name . " ".$group->count."</a></li>";
                        }
                        print_child($group, $current_id);
                    }
                }
            }
            else{
                foreach ($groups as $group){
                    if ($group->id_parent == 0){
                        echo "<li><a href='?group=".$group->id."'>".$group->name. " ".$group->count."</a></li>";
                    }
                }
            }

            echo "</ul>";
            ?>
        </div>
        <div class="products">
            <?php


            if(isset($_GET['group'])){
                foreach ($groups[$_GET['group']]->products as $product){
                    echo $product->name."<br>";
                }
            }
            else{
                foreach ($products as $product){
                    echo $product->name."<br>";
                }
            }

            $sth = null;
            $dbh = null;
            ?>
        </div>
    </body>
</html>

