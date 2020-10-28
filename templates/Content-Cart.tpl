<!-- Content Cart -->
<!-- One -->
<section id="one">
	<div class="inner">
		<h3>{success}</h3>
		<header>
			<h2>Cart</h2>
			{cart}
		</header>
	</div>
</section>

<!-- Two -->
<section id="footer">
	<div class="inner">
		<header>
			<h2>Reserve Cart</h2>
		</header>
		<form method="post" action="cart.php?reserve=yes&empty=all">
			<div class="field half first">
				<label for="firstname">First name</label>
				<input type="text" name="firstname" id="firstname" required/>
			</div>
			<div class="field half first">
				<label for="lastname">Last name</label>
				<input type="text" name="lastname" id="lastname" required/>
			</div>
			<div class="field half first">
				<label for="address">Address</label>
				<input type="text" name="address" id="address" required/>
			</div>
			<div class="field half first">
				<label for="phone">Telephone<small> (e.g.: 0933-123-456)</small></label>
				<input type="tel" id="phone" pattern="[0-9]{4}-[0-9]{3}-[0-9]{3}" name="phone" required>
			</div>
			<div style="clear:both;"></div>
			<div class="field half first">
				<label for="hall">Hall</label>
				<select name="hall" id="hall" required>
				  <option value="1">Baghdad Str. hall</option>
				  <option value="2">Almalki hall</option>
				</select>
			</div>
			<div class="field half first">
				<label for="appointment"><strong>Pick up time</strong></label>
				<input type="datetime-local" id="appointment"
			       name="appointment" required>
			</div>
			<div style="clear:both;"></div>
			<ul class="actions">
				<li><input type="submit" name="submitReserveCart" value="Reserve Cart" class="alt" /></li>
			</ul>
		</form>
	</div>
</section>
