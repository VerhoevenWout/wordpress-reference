<?php

// Array of objects, sort by name

usort($merken['merken'], function($a, $b){
    return strcmp(strtolower($a['term']->name), strtolower($b['term']->name));
});