<?php
function func_redirect(string $url, string $message = null, string $level = 'warning') {
    if ($message != null) {
        $url .= "?message=".rawurlencode($message)."&level=".rawurlencode($level);
    }
    header("Location: $url");
    exit();
}
function func_displayQueryMessage()  # https://getbootstrap.com/docs/4.0/components/alerts/
{   if (! isset($_GET['message'])) {  # check $_GET each page
    return; }
    $message = $_GET['message'];
    if (isset($_GET['level'])) {
        if (!in_array($_GET['level'] , ['dark', 'light', 'info', 'warning',
            'danger', 'success', 'secondary', 'primary'] )) {
            $_GET['level'] = 'secondary'; # force to a valid value
        }
    }
    $level = $_GET['level'];
    echo "<div class='container text-center'>
                <div class='alert alert-$level role='alert'>$message
                </div>
             </div>";
}

function nav_element(string $url,string $name, bool $is_current = false) : void {
    $active = "";
    if ($is_current) {$active= "-active";};
    echo "<a class='nav-item$active' href='$url'>$name</a>";
}

function nl_dump($var): void {
    var_dump($var); echo '<br>';
}

function generate_table(array $headers, array $data): void {
echo "<table class='table table-striped table-hover'>";

    foreach ($headers as $head) {
        echo "<th>".ucwords(str_replace('_', ' ', $head))."</th>";
    }
    foreach ($data as $values) {
        echo "<tr>";
        foreach ($headers as $head) {
            echo "<td>$values[$head]</td>";
        }
        echo "</tr>";
    }
echo "</table>";
}