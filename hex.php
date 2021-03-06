<?php

// https://github.com/ozdemirburak/iris

require 'vendor/autoload.php';

use OzdemirBurak\Iris\Color\Hex;
use OzdemirBurak\Iris\Color\Hsl;

$c = array();

$format = empty($_GET["format"]) ? 'json' : $_GET["format"];

$cols = 100;

function get_index($x)
{
    global $format;
    if ($format == 'html') :
        return abs(round($x - 1) / 10);
    else :
        return '';
    endif;
}

function get_factor($j)
{
    global $cols;
    return round((($j / $cols) - 1.00) + 1.00, 2) * 100;
}

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

    $c['hex']['transform']['modes'][0]['saturate'] = (string) $hex->saturate($hex->isDark() ? 50 : 50)->toHex();
    $c['hex']['transform']['modes'][0]['desaturate'] = (string) $hex->desaturate($hex->isDark() ? 60 : 40)->toHex();
    $c['hex']['transform']['modes'][0]['lighten'] = (string) $hex->lighten($hex->isDark() ? 40 : 40)->toHex();
    $c['hex']['transform']['modes'][0]['darken'] = (string) $hex->darken($hex->isDark() ? 10 : 25)->toHex();
    $c['hex']['transform']['modes'][0]['brighten'] = (string) $hex->brighten($hex->isDark() ? 30 : 30)->toHex();
    $c['hex']['transform']['modes'][0]['tint'] = (string) $hex->tint($hex->isDark() ? 25 : 50)->toHex();
    $c['hex']['transform']['modes'][0]['shade'] = (string) $hex->shade($hex->isDark() ? 25 : 50)->toHex();

    for ($i = 1; $i <= $cols; $i++) :
        $f = get_factor($i);
        $cor = (string) $hex->saturate($f)->toHex();
        $c["hex"]["transform"]["saturate"][get_index($i)]["$f"] = $cor;
    endfor;

    for ($i = 1; $i <= $cols; $i++) :
        $f = get_factor($i);
        $cor = (string) $hex->desaturate($f)->toHex();
        $c["hex"]["transform"]["desaturate"][get_index($i)]["$f"] = (string) $cor;
    endfor;

    for ($i = 1; $i <= $cols; $i++) :
        $f = get_factor($i);
        $cor = (string) $hex->lighten($f)->toHex();
        $c["hex"]["transform"]["lighten"][get_index($i)]["$f"] = $cor;
    endfor;

    for ($i = 1; $i <= $cols; $i++) :
        $f = get_factor($i);
        $cor = (string) $hex->darken($f)->toHex();
        $c["hex"]["transform"]["darken"][get_index($i)]["$f"] = $cor;
    endfor;

    for ($i = 1; $i <= $cols; $i++) :
        $f = get_factor($i);
        $cor = (string) $hex->brighten($f)->toHex();
        $c["hex"]["transform"]["brighten"][get_index($i)]["$f"] = $cor;
    endfor;

    for ($i = 1; $i <= $cols; $i++) :
        $f = get_factor($i);
        $cor = (string) $hex->tint($f)->toHex();
        $c["hex"]["transform"]["tint"][get_index($i)]["$f"] = $cor;
    endfor;

    for ($i = 1; $i <= $cols; $i++) :
        $f = get_factor($i);
        $cor = (string) $hex->shade($f)->toHex();
        $c["hex"]["transform"]["shade"][get_index($i)]["$f"] = $cor;
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
                                    <?php echo str_pad(strtoupper($key), 2, '0', STR_PAD_LEFT); ?>%
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