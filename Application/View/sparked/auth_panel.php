<div class="auth">
			<div class="auth-inner">
				<?php
					if($this->user){
						echo 'Вы вошли как <a href="/users/edit"><b>'.$this->user['uname'].'</b></a> | <a href="/auth/logout">Выйти</a>';
					}else{
						$this->get_login_form();
					}
				?>
			</div>
			
			<!--register block-->
			<div class="register-block">
				<form method="post" action="/auth/register">
					<table>
						<tr>
							<td><label for="rlogin">Логин</label></td>
							<td><input id="rlogin" type="text" name="login" ></td>
						</tr>
						<tr>
							<td><label for="rpass">Пароль</label></td>
							<td><input id="rpass" type="password" name="pass"></td>
						</tr>
						<tr>
							<td><label for="remail">Email</label></td></td>
							<td><input id="remail" type="text" name="email"></td>
						</tr>
						<tr>
							<td colspan="2"><button type="submit" id="reg-button">Зарегистрироваться</button></td>
						</tr>
					</table>
				</form>
			</div><!--register-block-->
		</div>