<!-- Content Revview -->
<!-- One -->
<section id="one">
	<div class="inner">
		<header>
			<h2>Review</h2>
			{reviews}
		</header>
	</div>
</section>

<!-- Two -->
<section id="footer">
	<div class="inner">
		<header>
			<h2>Write a review</h2>
		</header>
		<form method="post" action="review.php">
			<div class="field half first">
				<label for="name">Name</label>
				<input type="text" name="name" id="name" required/>
			</div>
			<div class="6u 12u$(small)">
				<input type="checkbox" id="copy" name="liked">
				<label for="copy"><strong>Like</strong></label>
			</div>

			<div style="clear:both;"></div>
			<div class="field half first">
				<label for="rate">Rate</label>
				<select name="rate" id="rate">
				  <option value="1">1</option>
				  <option value="2">2</option>
				  <option value="3">3</option>
				  <option value="4">4</option>
				  <option value="5">5</option>
				</select>
			</div>
			<div style="clear:both;"></div>
			<div class="field half first">
				<label for="message">Message</label>
				<textarea name="message" id="message" rows="6" required></textarea>
			</div>
			<div style="clear:both;"></div>
			<ul class="actions">
				<li><input type="submit" name="submit" value="Send Review" class="alt" /></li>
			</ul>
		</form>
	</div>
</section>
