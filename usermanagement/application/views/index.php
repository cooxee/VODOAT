
<div id="page">
    <fieldset>
        <legend>VODOAT Vehicle Management</legend>
        <?php
            $attributes = array('class' => 'login', 'name' => 'login_form', 'id' => 'login_form');
            echo form_open('login_controller/login', $attributes);
            echo form_error('username');
            echo form_error('password');
            if(isset($message)){
        ?>
                <div class="feedback_box error" style='margin-left:300px;'"><?php echo $message;?></div>
        <?php
            }
        ?>
        <div class="login_box">
            <ul>
                <li class="login">
                    <label for="username">User Name:</label>
                    <input type="text" name="username" class="text_field" tabindex="1" />
                </li>
                <li class="login">
                    <label for="password">Password:</label>
                    <input type="password" name="password" class="text_field"tabindex="2" />
                </li>
                <li class="right_align" style="margin-right:30px;">
                    <input type="submit" class='buttons' value="Submit" tabindex="3"/>
                </li>
            </ul>
        </div>
        <?php echo form_close();?>       
    </fieldset>
</div>
