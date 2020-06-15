<?php
function count_users(){
    global  $db;
    $result = $db->query("
        SELECT *
        FROM users
            ");
    $count = $result->num_rows;
    return $count;
}

function get_all_users(){
    global $db;
    $result = $db->query("
            SELECT *
            FROM users
            WHERE 1
            ");
    $users= array();
    while ($row = $result->fetch_assoc()){
        $users[] = $row;
    }
    return $users;
}

function get_user ($username){
    if (!$username){
        return;
    }
    global $db;
    $result = $db->query("
        SELECT *
        FROM users
        WHERE username = '$username'
        ");
    
    $row = $result->fetch_assoc();
    return $row;
}

function user_exists($username){
    if (!get_user($username)){
        return FALSE;
    }
    return TRUE;
}

function add_user($userdata){
    foreach ($userdata as $item){
        $username = $item['username'];
        $password = sha1($item['password']);
        $first_name = $item['first_name'];
        $last_name =$item['last_name'];
    }
    if(!$username){
        return;
    }
    global $db;
    if(!user_exists($username)){
        $db->query("
            INSERT INTO users (username , password , first_name , last_name) VALUES
            ('$username' , '$password' ,'$first_name' , '$last_name');
                ");
    } else {
        $db->query("
            UPDATE users
            SET password = '$password' , first_name = '$first_name' , last_name = '$last_name'
            WHERE username = '$username';  
                ");
    }
}

function update_user($userdata) {
    add_user($userdata);
}

function delete_user($username){
    if(!user_exists($username)){
        return;
    }
    global $db;
    $db->query("
        DELETE FROM users
        WHERE username = '$username';
            ");
}

