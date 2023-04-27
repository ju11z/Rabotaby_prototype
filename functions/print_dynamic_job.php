
<?php

$query = "SELECT id, title, parent_id FROM job_category";
$result = mysqli_query($link, $query) or die("database error:" . mysqli_error($link));
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
        $html .= "<ul >";
        foreach ($menu['parents'][$parent] as $itemId) {
            if (!isset($menu['parents'][$itemId])) {
                $html .= "<li class='dynamic-li'>".
                    "<input type='radio' class='dynamic-radio' 
     name='job_category' value='".$menu['items'][$itemId]['id']."'><label>".$menu['items'][$itemId]['title']."</label>".
                    "</li>";

            }
            if (isset($menu['parents'][$itemId])) {
                $html .= "<li class='dynamic-li'>"."<input type='radio' 
     name='job_category' class='dynamic-radio' value='".$menu['items'][$itemId]['id']."'><label>".$menu['items'][$itemId]['title']."</label>";
                $html .= "<ul class='dynamic-ul'>";
                $html .= createMenu($itemId, $menu);
                $html .= '</ul>';

                $html .= "</li>";

            }
        }
        $html .= "</ul>";
    }

    return $html;
}
?>
<?php echo createMenu(0, $menus); ?>


