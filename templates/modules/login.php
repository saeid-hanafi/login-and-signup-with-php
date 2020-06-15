<?php
function get_title(){
    echo 'ورود';
}

function get_content(){
?>
<div class="row">
  <div class="col-xs-5 col-md-5">
    <div class="panel panel-primary">
        <div class="panel-heading">
        <h3 class="panel-title">ورود</h3>
        </div>
    <div class="panel-body">
        <form method="post">
            <div class="form-group">
              <label for="username">نام کاربری</label>
              <input type="text" name="username" class="form-control" id="username" placeholder="نام کاربری">
            </div>
            <div class="form-group">
              <label for="password">رمز عبور</label>
              <input type="password" name="password" class="form-control" id="password" placeholder="رمز عبور">
            </div>
            <button type="submit" name="login" id="login" class="btn btn-default">ورود</button>
        </form>
    </div>
    </div>
  </div>
  <div class="col-xs-2 col-md-2"></div>
  <div class="col-xs-5 col-md-5">
      <div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title">ثبت نام</h3>
  </div>
  <div class="panel-body">
      <form method="post">
        <div class="form-group">
          <label for="firstname">نام</label>
          <input type="text" name="firstname" class="form-control" id="firstname" placeholder="نام">
        </div>
        <div class="form-group">
          <label for="lastname">نام خانوادگی</label>
          <input type="text" name="lastname" class="form-control" id="lastname" placeholder="نام خانوادگی">
        </div>
        <div class="form-group">
          <label for="signup_username">نام کاربری</label>
          <input type="text" name="signup_username" class="form-control" id="signup_username" placeholder="نام کاربری">
        </div>
        <div class="form-group">
          <label for="signup_password">رمز عبور</label>
          <input type="password" name="signup_password" class="form-control" id="signup_password" placeholder="رمز عبور">
        </div>
        
          <button type="submit" id="sign" name="sign" class="btn btn-default">ثبت نام</button>
    </form>
  </div>
</div>
  </div>
</div>

<?php
}

function process_inputs() {
    
    if(get_inputs('login', $_POST) === NULL) {
        return;
    }
    
    if(get_inputs('username', $_POST) !== NULL) {
        $username = get_inputs('username', $_POST);
    }

    if(empty($username)) {
        add_message('نام کاربری نمی تواند خالی باشد.', 'error');
        return;
    }
    
    if(get_inputs('password', $_POST) !== NULL) {
        $password = get_inputs('password', $_POST);
    }
    
    if(empty($password)) {
        add_message('رمز عبور نمی تواند خالی باشد.', 'error');
        return;
    }
    
    user_login($username, $password);
    
    if(is_user_loggen_in() === FALSE) {
        add_message('نام کاربری یا رمز عبور، اشتباه است.', 'error');
    } else {
        redirect_to(home_url());
    }
    
}

function user_signup(){
    if (get_inputs('sign', $_POST) === NULL){
        return;
    }
    $first_name = get_inputs('firstname', $_POST);
    if(empty($first_name)){
        add_message('نام نمی تواند خالی باشد!', 'error');
        return;
    }
    $last_name = get_inputs('lastname', $_POST);
    if (empty($last_name)){
        add_message('نام خانوادگی نمی تواند خالی باشد!', 'error');
        return;
    }
    $signup_username = get_inputs('signup_username', $_POST);
    if (empty($signup_username)){
        add_message('نام کاربری نمی تواند خالی باشد!', 'error');
        return;
    }
    $signup_password = get_inputs('signup_password', $_POST);
    if (empty($signup_password)){
        add_message('رمز عبور نمی تواند خالی باشد!', 'error');
        return;
    }
    $users = get_all_users();
    foreach ($users as $user){
        if ($signup_username === $user['username']){
           add_message('نام کاربری مورد نظر توسط کاربر دیگری ثبت شده است!لطفا از نام کاربری دیگری استفاده کنید.' , 'error');
           return; 
        }
    }
    
    
    
    $userdata [] = array(
      'username' => $signup_username,
      'password' => $signup_password,
      'first_name' => $first_name,
      'last_name' => $last_name,
    );
    
    add_user($userdata);
    user_login($signup_username , $signup_password);
    redirect_to(home_url());
}