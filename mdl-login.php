  <div class="login-box">      
         <form action="" method="post" id="loginform"  class="login-form" >
           <h4 class="login-head">
          Production Support System <br>
          <i class="fa fa-lg fa-fw fa-user"></i>SIGN IN [QAS]</h4>
          <div class="form-group">
            <label class="control-label">USERNAME</label>
            <input class="form-control"  name="username" type="text" placeholder="Username" onkeypress="return /[A-Za-z0-9./()-_]/i.test(event.key)"  autofocus>
          </div>
          <div class="form-group">
            <label class="control-label">PASSWORD</label>
            <input class="form-control" name="pass" type="password" placeholder="Password" onkeypress="return /[A-Za-z0-9&./()-_[^@!$#]/i.test(event.key)">
          </div>
          <div class="form-group">
            <div class="utility">
              <div class="animated-checkbox">
               <!-- <label>
                  <input type="checkbox"><span class="label-text">Stay Signed in</span>
                </label>-->
              </div>
              <p class="semibold-text mb-2"><a href="#" data-toggle="flip">Forgot Password ?</a></p>
            </div>
          </div>
          <div class="form-group btn-container"><input name="submit" type="submit" value="LOGIN" class="btn btn-primary btn-block"/>
         <!--   <button class="btn btn-primary btn-block"><i class="fa fa-sign-in fa-lg fa-fw"></i>SIGN IN</button>-->
          </div>
        </form>
         <form id="recoverform" action="xfgt_psswd.php"  class="forget-form"  data-remote="true" method="post">
       <!-- <form class="forget-form" action="docs/index.html">-->
         <h4 class="login-head">
                    <i class="fa fa-lg fa-fw fa-lock"></i>Forgot Password ?</h4>
                  <div class="form-group">
            <label class="control-label">USERNAME</label>
             <input type="text" name="user_name" size="20"  id="user_name" value="<?php if(isset($_POST['user_name'])) echo htmlspecialchars($_POST['user_name'], ENT_QUOTES, 'UTF-8'); ?>" class="form-control" onkeypress="return /[A-Za-z0-9./()-_]/i.test(event.key)" >
         
          </div>
           <div class="form-group">
            <label class="control-label">EMAIL</label>
             <input type="text" name="email"  size="50" value="<?php if(isset($_POST['email'])) echo htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8'); ?>" class="form-control"  onkeypress="return /[A-Za-z0-9&. /()-_[^@!$#]/i.test(event.key)" >
         
          </div>
             
          
          <div class="form-group btn-container"><input name="submit2" type="submit" class="btn btn-primary btn-block" value="RESET" >
          <!--  <button class="btn btn-primary btn-block"><i class="fa fa-unlock fa-lg fa-fw"></i>RESET</button>-->
          </div>
         
           
          <div class="form-group mt-3">
           <p class="semibold-text mb-0"><a href="#" data-toggle="flip"><i class="fa fa-angle-left fa-fw"></i> Back to Login</a></p>
          </div>
        </form>
      </div>