<?php

defined('ROOTPATH') OR exit('Access Denied!');

check_extensions();

function check_extensions()
{
    $required_extensions = [
        'gd', 'mysqli', 'pdo_mysql', 'pdo_sqlite', 'curl', 'fileinfo', 'intl', 'mbstring', 'exif'
    ];

    $not_loaded = [];

    foreach ($required_extensions as $ext)
    {
        if (!extension_loaded($ext))
        {
            $not_loaded[] = $ext;
        }
    }

    if (!empty($not_loaded))
    {
        show_data("Please load the following extensions in your php.ini file: <br>" . implode("<br>", $not_loaded));
        die;
    }
}

function user(string $key = '')
{
    $session = new \Core\Session;
    $row_data = $session->user();

    if (!empty($row_data->$key))
    {
        return $row_data->$key;
    }

    return '';
}

function show_data($data)
{
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}

function esc($string)
{
    return htmlspecialchars($string);
}

function redirect($path)
{
    header("Location: " . ROOT . "/" . $path);
    die;
}

function formatMemory($bytes, $precision = 2) 
{
    $units = ['B', 'KB', 'MB', 'GB', 'TB'];
    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);
    $bytes /= (1 << (10 * $pow));
    
    return round($bytes, $precision) . ' ' . $units[$pow];
}

/** Check the image file to load. If it's not exist, load the placeholder **/
function get_image(mixed $file = '', string $type = 'post'): string
{
    $file = $file ?? '';

    if (file_exists($file))
    {
        return ROOT . "/" . $file;
    }

    if ($type == 'user')
    {
        return ROOT . "/assets/images/user.jpg";
    }
    else
    {
        return ROOT . "/assets/images/no_image.jpg";
    }
}

/** Get pagination links **/
function get_pagination_vars(): array
{
    $vars = [];
    $vars['page']       = $_GET['page'] ?? 1;
    $vars['page']       = (int)$vars['page'];
    $vars['prev_page']  = $vars['page'] <= 1 ? 1 : $vars['page'] - 1;
    $vars['next_page']  = $vars['page'] + 1;

    return $vars;
}

/** Saves or display a message to the user **/
function message(string $msg = null, bool $clear = false)
{
    $session = new Core\Session();

    if (!empty($msg))
    {
        $session->set('message', $msg);
    }
    else if (!empty($session->get('message')))
    {
        $msg = $session->get('message');
        
        if ($clear)
            $session->pop('message');

        return $msg;
    }

    return false;
}

/** Display/keep input value after page refresh **/
function old_value_input(string $key, mixed $default = "", string $mode = 'post'): mixed
{
    $POST = ($mode == 'post') ? $_POST : $_GET;

    if (isset($POST[$key]))
    {
        return $POST[$key];
    }

    return $default;
}

/** Display/keep checked input after page refresh **/
function old_checked_input(string $key, string $value, string $default = ""): string
{
    if (isset($_POST[$key]))
    {
        if ($_POST[$key] == $value)
        {
            return ' checked ';
        }
    }
    else
    {
        if ($_SERVER['REQUEST_METHOD'] == "GET" && $default == $value)
        {
            return ' checked ';
        }
    }

    return '';
}

/** Display/keep selected input after page refresh **/
function old_selected_input(string $key, mixed $value, mixed $default = "", string $mode = 'post'): string
{
    $POST = ($mode == 'post') ? $_POST : $_GET;

    if (isset($POST[$key]))
    {
        if ($POST[$key] == $value)
        {
            return " selected ";
        }
    }
    else if ($default == $value)
    {
        return " selected ";
    }
    
    return "";
}

/** Get a user readable date format **/
function get_date($date)
{
    return date("jS M, Y", strtotime($date));
}

/** Returns URL variables **/
function URL($key): mixed
{
    $URL = $_GET['url'] ?? 'home';
    $URL = explode("/", trim($URL, "/"));

    switch ($key)
    {
        case 'page':
        case 0:
            return $URL[0] ?? null;
            break;
        case 'section':
        case 'slug':
        case 1:
            return $URL[1] ?? null;
            break;
        case 'action':
        case 2:
            return $URL[2] ?? null;
            break;
        case 'id':
        case 3:
            return $URL[3] ?? null;
            break;
        default:
            return null;
            break;
    }
}

function add_root_to_images($contents)
{
    preg_match_all('/<img[^>]+>/', $contents, $matches);

    if (is_array($matches) && count($matches) > 0)
    {
        foreach ($matches[0] as $match)
        {
            preg_match('/src="[^"]+/', $match, $matches2);
            if (!strstr($matches2[0], 'http'))
            {
                $contents = str_replace($matches2[0], 'src="' . ROOT . '/' . str_replace('src="', "", $matches2[0]), $contents);
            }
        }
    }

    return $contents;
}

/** Convert base64 image from content editor to actual file **/
function remove_images_from_content($content, $folder = "uploads/")
{
    if (!file_exists($folder))
    {
        mkdir($folder, 0777, true);
        file_put_contents($folder . "index.php", "Access Denied!");
    }

    preg_match_all('/<img[^>]+>/', $content, $matches);
    $new_content = $content;

    if (is_array($matches) && count($matches) > 0)
    {
        $image_class = new \Model\Image();
        foreach ($matches[0] as $match)
        {
            if (strstr($match, "http"))
            {
                continue;
            }

            preg_match('/src="[^"]+/', $match, $matches2);

            preg_match('/data-filename="[^\"]+/', $match, $matches3);

            if (strstr($matches2[0], 'data: '))
            {
                $parts = explode(",", $matches2[0]);
                $basename = $matches3[0] ?? 'basename.jpg';
                $basename = str_replace('data-filename="', "", $basename);

                $filename = $folder . "img_" . sha1(rand(0,9999999999)) . $basename;

                $new_content = str_replace($parts[0] . "," . $parts[1], 'src="' . $filename, $new_content);
                file_put_contents($filename, base64_decode($parts[1]));

                $image_class->resize($filename, 1000);
            }
        }
    }

    return $new_content;
}

/** Delete images from the content editor **/
function delete_images_from_editor(string $content, string $content_new = ''): void
{
    if (empty($content_new))
    {
        preg_match_all('/<img[^>]+>/', $content, $matches);

        if (is_array($matches) && count($matches) > 0)
        {
            foreach ($matches[0] as $match)
            {
                preg_match('/src="[^"]+/', $match, $matches2);
                $matches2[0] = str_replace('src="', "", $matches2);

                if (file_exists($matches2[0]))
                {
                    unlink($matches2[0]);
                }
            }
        }
    }
    else
    {
        preg_match_all('/<img[^>]+>/', $content, $matches);
        preg_match_all('/<img[^>]+>/', $content_new, $matches_new);

        $old_images = [];
        $new_images = [];

        // Collect Old Images
        if (is_array($matches) && count($matches) > 0)
        {
            foreach ($matches[0] as $match)
            {
                preg_match('/src="[^"]/', $match, $matches2);
                $matches2[0] = str_replace('src="', "", $matches2[0]);

                if (file_exists($matches2[0]))
                {
                    $old_images[] = $matches2[0];
                }
            }
        }

        // Collect New Images
        if (is_array($matches_new) && count($matches_new) > 0)
        {
            foreach ($matches_new[0] as $match)
            {
                preg_match('/src="[^"]/', $match, $matches2);
                $matches2[0] = str_replace('src="', "", $matches2[0]);

                if (file_exists($matches2[0]))
                {
                    $new_images[] = $matches2[0];
                }
            }
        }

        foreach ($old_images as $img)
        {
            if (!in_array($img, $new_images))
            {
                if (file_exists($img))
                {
                    unlink($img);
                }
            }
        }
    }
}
