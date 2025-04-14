<?php

function findUser($json, $id)
{
    foreach ($json as $user) {
        if ($user['id'] == $id) return $user;
    }
    return  null;
};

function validateName($name)
{
    if (!is_string($name)) return false;
    return strlen((string)$name) <= 26 && strlen((string)$name) > 3;
};

function validateId($obj)
{
    return isset($obj['id']) && is_int($obj['id']);
}
function validateTime($time)
{
    return time() > $time;
};

function validateUser($user)
{
    return validateName($user['name']) &&
        validateId($user) &&
        is_int($user['postCount']);
}


function validatePost($post)
{
    return validateId($post) &&
        // validateTime($post['createdAt']) &&
        is_int($post['likesCount']);
        // isset($post['userId']) &&
        // is_int($post['userId']);
}
