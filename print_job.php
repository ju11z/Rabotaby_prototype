<?php
require 'db_connect.php';
?>
<?php

$query = "SELECT id, title, parent_id FROM job_category";
$result = mysqli_query($link, $query) or die("database error:" . mysqli_error($conn));
// Create an array to conatin a list of items and parents
$menus = array(
    'items' => array(),
    'parents' => array()
);

while ($items = mysqli_fetch_assoc($result)) {
    // Create current menus item id into array
    $menus['items'][$items['id']] = $items;
    // Creates list of all items with children
    $menus['parents'][$items['parent_id']][] = $items['id'];

    //echo  $items;
}

function createMenu($parent, $menu)
{
    $html = "";
    if (isset($menu['parents'][$parent])) {
        // $html .= '<ul class="sina-menu sina-menu-right" data-in="fadeInLeft" data-out="fadeInOut">';
        foreach ($menu['parents'][$parent] as $itemId) {
            if (!isset($menu['parents'][$itemId])) {
                $html .= "<li >
                         <a  href='" . '' . "'>" . $menu['items'][$itemId]['title'] . "</a>
                     </li>";
            }
            if (isset($menu['parents'][$itemId])) {
                $html .= "<li class='dropdown'>
                  <a class='dropdown-toggle' data-toggle='dropdown' href='" . ''    . "'>" . $menu['items'][$itemId]['title'] .  "</a>";
                $html .= '<ul class="dropdown-menu">';
                $html .= createMenu($itemId, $menu);
                $html .= '</ul>';

                $html .= "</li>";
            }
        }
        // $html .= "</ul>";
    }
    return $html;
}
?>
<?php echo createMenu(0, $menus); ?>
