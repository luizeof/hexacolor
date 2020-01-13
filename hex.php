<?php

// https://github.com/ozdemirburak/iris

require 'vendor/autoload.php';

use OzdemirBurak\Iris\Color\Hex;

$c = array();

$format = empty($_GET["format"]) ? 'json' : $_GET["format"];

$cols = 100;

try {
    $hex = new Hex('#' . $_GET["cor"]);

    if ($format == 'json') :
        $c["hex"]["color"]["hex"] = (string) $hex;
        $c["hex"]["color"]["is_dark"] = $hex->isDark() ? "1" : "0";
        $c["hex"]["color"]["is_light"] = $hex->isLight() ? "1" : "0";
    endif;

    $c["hex"]["color"]["hsl"] = (string) $hex->toHsl();
    $c["hex"]["color"]["hsla"] = (string) $hex->toHsla();
    $c["hex"]["color"]["hsv"] = (string) $hex->toHsv();
    $c["hex"]["color"]["rgb"] = (string) $hex->toRgb();
    $c["hex"]["color"]["rgba"] = (string) $hex->toRgba();

    function get_index($x)
    {
        return abs(round($x - 1) / 10);
        //return $x <= 10 ? "a" : "b";
    }

    function get_factor($j)
    {
        global $cols;
        return $f = round((($j / $cols) - 1.00) + 1.00, 2) * 100;
    }

    for ($i = 1; $i <= $cols; $i++) :
        $f = get_factor($i);
        $c["hex"]["transform"]["saturate"][get_index($i)]["$f"] = (string) $hex->saturate($f)->toHex();
    endfor;

    for ($i = 0; $i <= $cols; $i++) :
        $f = get_factor($i);
        $c["hex"]["transform"]["lighten"][get_index($i)]["$f"] = (string) $hex->lighten($f)->toHex();
    endfor;

    for ($i = 0; $i <= $cols; $i++) :
        $f = get_factor($i);
        $c["hex"]["transform"]["darken"][get_index($i)]["$f"] = (string) $hex->darken($f)->toHex();
    endfor;

    for ($i = 0; $i <= $cols; $i++) :
        $f = get_factor($i);
        $c["hex"]["transform"]["brighten"][get_index($i)]["$f"] = (string) $hex->brighten($f)->toHex();
    endfor;

    for ($i = 0; $i <= $cols; $i++) :
        $f = get_factor($i);
        $c["hex"]["transform"]["tint"][get_index($i)]["$f"] = (string) $hex->tint($f)->toHex();
    endfor;

    for ($i = 0; $i <= $cols; $i++) :
        $f = get_factor($i);
        $c["hex"]["transform"]["shade"][get_index($i)]["$f"] = (string) $hex->shade($f)->toHex();
    endfor;

    if ($format == 'json') :
        header('Content-Type: application/json');
        echo json_encode($c);
    else : ?>
        <!DOCTYPE html>
        <html>

        <head>
            <style>
                body {
                    font-family: "Courier" !important;
                    background-color: #fff;
                }

                table {
                    border-collapse: collapse;
                    width: 100%;
                }

                table,
                th,
                td {
                    border: 1px solid black;
                    text-align: center;
                }

                th,
                td {
                    padding: 5px;
                    height: 25px;

                }

                td {
                    font-size: 14px;
                }

                th {
                    font-size: 16px;
                }

                h1 {
                    padding-top: 25px;
                    padding-bottom: 25px;
                    font-size: 30px;
                }

                h1 span {
                    padding: 25px;
                }

                h3 {
                    font-size: 20px;
                }
            </style>
        </head>

        <body>

            <?php $textColor = $hex->isDark() ? "#FFF" : "#000"; ?>
            <?php $bgColor = $hex; ?>
            <h1 class="color"><span style="background-color: <?php echo $bgColor; ?>; color: <?php echo $textColor; ?>">HEX <?php echo $hex; ?></span></h1>
            <h3>Formats</h3>
            <table border="1">
                <tr>
                    <?php foreach ($c["hex"]["color"] as $key => $value) : ?>
                        <th>
                            <?php echo strtoupper($key); ?>
                        </th>
                    <?php endforeach; ?>
                </tr>
                <tr>
                    <?php foreach ($c["hex"]["color"] as $key => $value) : ?>
                        <?php $textColor = $hex->isDark() ? "#FFF" : "#000"; ?>
                        <?php $bgColor = $hex; ?>
                        <td style="background-color: <?php echo $bgColor; ?>; color: <?php echo $textColor; ?>">
                            <?php echo $value; ?>
                        </td>
                    <?php endforeach; ?>
                </tr>
            </table>

            <?php $linha = 0; ?>

            <?php foreach ($c["hex"]["transform"] as $name => $section) : ?>

                <h3><?php echo ucwords($name); ?></h3>

                <?php foreach ($section as $head) : ?>

                    <table border="1">
                        <tr>
                            <?php foreach ($head as $key => $value) : ?>
                                <th>
                                    <?php echo strtoupper($key); ?>%
                                </th>
                            <?php endforeach; ?>
                        </tr>
                        <tr>
                            <?php foreach ($head as $key => $value) : ?>
                                <?php $color = new Hex($value); ?>
                                <?php $textColor = $color->isDark() ? "#FFF" : "#000"; ?>
                                <?php $bgColor = $value; ?>
                                <td style="background-color: <?php echo $bgColor; ?>; color: <?php echo $textColor; ?>">
                                    <?php echo strtoupper($value); ?>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                    </table>

                <?php endforeach; ?>

            <?php endforeach; ?>

        </body>

        </html>
    <?php endif; ?>
<?php
} catch (Throwable $e) {
    http_response_code(500);
    $c = $e->getMessage();
    echo json_encode($c);
} catch (Exception $e) {
    http_response_code(500);
    $c = $e->getMessage();
    echo json_encode($c);
}
?>