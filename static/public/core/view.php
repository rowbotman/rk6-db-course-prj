<?php

/**
 * Class View
 */
class View
{
    /**
     * @param $content_view {} - виды отображающие контент страниц
     * @param $template {HTML} общий для всех страниц шаблон;
     * @param null $data - массив, содержащий элементы контента страниц
     */
    function render($content_view, $template, $data = null)
    {
        include 'static/public/views/' . $template;
    }
}
